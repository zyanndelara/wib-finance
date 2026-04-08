<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OTPHP\TOTP;

class AuthController extends Controller {

    /**
     * Handle forced password change
     */
    public function forcePasswordChange(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!$user instanceof User) {
            return redirect()->route('login')->withErrors([
                'email' => 'Unable to update password. Please log in again.',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->force_password_change = false;
        $user->save();

        return redirect('/dashboard')->with('force_password_change_success', true);
    }
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $emailInput = strtolower(trim((string) $request->input('email', '')));
        $throttleKey = ($emailInput !== '' ? $emailInput : 'guest') . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()->withErrors([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ])->onlyInput('email');
        }

        // Validate input with custom messages
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address must not exceed 255 characters.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($throttleKey, 60);

            return back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        // Sanitize email
        $credentials = [
            'email' => strtolower(trim($request->email)),
            'password' => $request->password,
        ];

        // Check if user exists
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            RateLimiter::hit($throttleKey, 60);

            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        // Attempt authentication
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();
            $authenticatedUser = Auth::user();

            if (!$authenticatedUser instanceof User) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'email' => 'Unable to start your session. Please try logging in again.',
                ]);
            }

            $landingRoute = $authenticatedUser->firstAccessibleRouteName();

            // If 2FA is enabled, hold the user in a pending session and redirect to challenge
            if (Auth::user()->two_factor_enabled) {
                // Check if this device is already trusted
                $cookie = $request->cookie('wib_2fa_device');
                if ($cookie) {
                    [$cookieUserId, $rawToken] = array_pad(explode('|', $cookie, 2), 2, '');
                    if ((int)$cookieUserId === Auth::user()->id && $rawToken) {
                        $hashed        = hash('sha256', $rawToken);
                        $trustedTokens = Auth::user()->two_factor_trusted_devices ?? [];
                        if (in_array($hashed, $trustedTokens)) {
                            // Trusted device â€” skip 2FA challenge
                            if (Auth::user()->force_password_change && Auth::user()->role !== 'admin') {
                                return redirect()->route($landingRoute)->with('force_password_change', true);
                            }
                            return redirect()->route($landingRoute)->with('success', 'Welcome back, ' . Auth::user()->name . '!');
                        }
                    }
                }

                // Not a trusted device â€” store user ID for the challenge page,
                // log out so the user is NOT authenticated yet, then regenerate
                // the session AFTER logout to preserve the pending session data.
                $userId = Auth::user()->id;
                Auth::logout();
                $request->session()->regenerate();
                session(['2fa_user_id' => $userId]);

                return redirect()->route('2fa.challenge');
            }

                // Check if user needs to change password, except for admin role
                if (Auth::user()->force_password_change && Auth::user()->role !== 'admin') {
                    return redirect()->route($landingRoute)->with('force_password_change', true);
                }
            return redirect()->route($landingRoute)->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'password' => 'Incorrect password. Please try again.',
        ])->onlyInput('email');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:fm_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
                'force_password_change' => true,
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Registration successful! Welcome to Wibsystem.');
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    /**
     * Handle forgot password request
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = strtolower(trim($request->email));

        // Always show the same response to prevent email enumeration
        $userExists = DB::table('fm_users')->where('email', $email)->exists();

        if ($userExists) {
            // Generate a cryptographically secure 6-digit PIN
            $pin = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Store hashed PIN in fm_password_reset_tokens table
            DB::table('fm_password_reset_tokens')->updateOrInsert(
                ['email' => $email],
                [
                    'email'      => $email,
                    'token'      => Hash::make($pin),
                    'created_at' => now(),
                ]
            );

            // Send PIN via Brevo API (uses MAIL_PASSWORD as API key)
            try {
                $htmlContent = view('emails.pin-reset', [
                    'pin'       => $pin,
                    'userEmail' => $email,
                ])->render();

                $response = Http::withHeaders([
                    'api-key'      => config('mail.mailers.smtp.password'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.brevo.com/v3/smtp/email', [
                    'sender' => [
                        'name'  => config('mail.from.name'),
                        'email' => config('mail.from.address'),
                    ],
                    'to' => [
                        ['email' => $email],
                    ],
                    'subject'     => 'Your Password Reset PIN Code',
                    'htmlContent' => $htmlContent,
                ]);

                if ($response->failed()) {
                    Log::error('Brevo API PIN email failed: ' . $response->body());
                    return back()->withErrors(['email' => 'Failed to send PIN email. Please try again later.'])->withInput();
                }
            } catch (\Exception $e) {
                Log::error('Password reset PIN email failed: ' . $e->getMessage());
                return back()->withErrors(['email' => 'Failed to send PIN email. Please try again later.'])->withInput();
            }
        }

        // Store email in session and redirect to the PIN verification page
        return redirect()->route('password.check')->with('email', $email);
    }

    /**
     * Show the check email page
     */
    public function showCheckEmailForm()
    {
        return view('check-email');
    }

    /**
     * Verify PIN code
     */
    public function verifyPin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'pin1'  => 'required|digits:1',
            'pin2'  => 'required|digits:1',
            'pin3'  => 'required|digits:1',
            'pin4'  => 'required|digits:1',
            'pin5'  => 'required|digits:1',
            'pin6'  => 'required|digits:1',
        ]);

        $email = strtolower(trim($request->email));
        $pin   = $request->pin1 . $request->pin2 . $request->pin3
               . $request->pin4 . $request->pin5 . $request->pin6;

        $record = DB::table('fm_password_reset_tokens')
            ->where('email', $email)
            ->first();

        // Check that a record exists, the PIN matches, and it is not older than 15 minutes
        if (! $record
            || ! Hash::check($pin, $record->token)
            || now()->diffInMinutes($record->created_at) > 15
        ) {
            return back()
                ->withErrors(['pin' => 'The PIN code is invalid or has expired. Please request a new one.'])
                ->with('email', $email);
        }

        // PIN is valid â€” replace the PIN record with a hashed reset token stored in the DB
        $resetToken = Str::random(64);

        DB::table('fm_password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token'      => Hash::make($resetToken),
                'created_at' => now(),
            ]
        );

        $url = route('password.reset', ['token' => $resetToken]) . '?' . http_build_query(['email' => $email]);

        return redirect()->to($url);
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm($token)
    {
        $email = request()->query('email');

        if (! $email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Invalid reset link. Please start again.']);
        }

        $record = DB::table('fm_password_reset_tokens')
            ->where('email', strtolower(trim($email)))
            ->first();

        if (! $record
            || ! Hash::check($token, $record->token)
            || now()->diffInMinutes($record->created_at) > 30
        ) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'This password reset link is invalid or has expired. Please start again.']);
        }

        return view('reset-password', ['token' => $token, 'email' => $email]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = strtolower(trim($request->email));

        $record = DB::table('fm_password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (! $record
            || ! Hash::check($request->token, $record->token)
            || now()->diffInMinutes($record->created_at) > 30
        ) {
            return back()->withErrors(['token' => 'This password reset link is invalid or has already been used.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No account found with this email address.']);
        }

        // Update the password
        $user->password              = Hash::make($request->password);
        $user->force_password_change = false;
        $user->save();

        // Delete the token so it cannot be reused
        DB::table('fm_password_reset_tokens')->where('email', $email)->delete();

        return redirect()->route('login')
            ->with('password_reset_success', true);
    }

    /**
     * Show the 2FA challenge page (after credentials are validated).
     */
    public function show2faChallenge()
    {
        if (!session('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa-challenge');
    }

    /**
     * Verify the submitted TOTP code and complete login.
     */
    public function verify2fa(Request $request)
    {
        $request->validate(['code' => 'required|string|digits:6']);

        $userId = session('2fa_user_id');
        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('login');
        }

        $secret = decrypt($user->two_factor_secret);
        $totp   = TOTP::createFromSecret($secret);

        if (!$totp->verify($request->code, null, 1)) {
            return back()->withErrors(['code' => 'Invalid authentication code. Please try again.']);
        }

        session()->forget('2fa_user_id');
        Auth::login($user);
        $request->session()->regenerate();

        // Trust this device: store a hashed token in the DB and set an encrypted cookie
        $rawToken      = Str::random(64);
        $hashed        = hash('sha256', $rawToken);
        $trustedTokens = $user->two_factor_trusted_devices ?? [];

        // Keep at most 20 trusted devices; remove the oldest if needed
        if (count($trustedTokens) >= 20) {
            array_shift($trustedTokens);
        }
        $trustedTokens[] = $hashed;
        $user->two_factor_trusted_devices = $trustedTokens;
        $user->save();

        $cookieValue  = $user->id . '|' . $rawToken;
        $cookieMinutes = 60 * 24 * 30; // 30 days

        if ($user->force_password_change && $user->role !== 'admin') {
            return redirect('/dashboard')
                ->with('force_password_change', true)
                ->cookie('wib_2fa_device', $cookieValue, $cookieMinutes);
        }

        return redirect('/dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!')
            ->cookie('wib_2fa_device', $cookieValue, $cookieMinutes);
    }
}
