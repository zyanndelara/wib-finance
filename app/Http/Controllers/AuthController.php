<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $user->password = Hash::make($request->new_password);
        $user->force_password_change = false;
        $user->save();

        return redirect('/dashboard')->with('success', 'Password changed successfully!');
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
            return back()->withErrors([
                'email' => 'No account found with this email address.',
            ])->onlyInput('email');
        }

        // Attempt authentication
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            // Check if user needs to change password
            if (Auth::user()->force_password_change) {
                return redirect()->intended('/dashboard')->with('force_password_change', true);
            }
            return redirect()->intended('/dashboard')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

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
            'email' => 'required|string|email|max:255|unique:users',
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

        // Generate 6-digit PIN
        $pin = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store PIN in database (only if user exists)
        $userExists = DB::table('users')->where('email', $request->email)->exists();
        
        if ($userExists) {
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'email' => $request->email,
                    'token' => Hash::make($pin),
                    'created_at' => now()
                ]
            );
        }

        // In a real application, you would send PIN via email here
        // For now, we'll pass it in session for development/testing
        
        // Note: To actually send emails, you need to configure your mail settings in .env
        // and uncomment the Mail::send() code below
        
        /*
        Mail::send('emails.pin-code', ['pin' => $pin], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset PIN Code');
        });
        */

        return redirect()->route('password.check')->with([
            'email' => $request->email,
            'pin' => $pin // For development/testing only - remove in production
        ]);
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
        // Generate a token for password reset
        $token = Str::random(64);

        // Redirect to reset password page
        return redirect()->route('password.reset', ['token' => $token])->with('email', $request->email);
    }

    /**
     * Show the reset password form
     */
    public function showResetPasswordForm($token)
    {
        return view('reset-password', ['token' => $token]);
    }

    /**
     * Handle password reset
     */
    public function resetPassword(Request $request)
    {
        return redirect()->route('password.reset', ['token' => $request->token])->with('password_reset_success', true);
    }
}
