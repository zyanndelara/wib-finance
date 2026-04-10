<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\AuditLog;
use App\Models\User;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;
use OTPHP\TOTP;

class ProfileController extends Controller
{
    /**
     * Handle email verification link.
     */
    public function verifyEmail($id, $hash)
    {
        $user = \App\Models\User::find($id);
        if (!$user) {
            return redirect()->route('profile')->with('error', 'Invalid verification link.');
        }
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('profile')->with('info', 'Email already verified.');
        }
        if ($hash !== sha1($user->email)) {
            return redirect()->route('profile')->with('error', 'Invalid verification link.');
        }
        $user->markEmailAsVerified();
        // Set a session flag to show popup on profile page
        session(['email_verified' => true]);
        return redirect()->route('profile');
    }
    /**
     * Display the user's profile.
     */
    public function show()
    {
        return view('profile');
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $this->authenticatedUser();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'suffix' => 'nullable|string|max:10',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Construct full name
        $fullName = trim($request->first_name . ' ' . ($request->middle_initial ?? '') . ' ' . $request->last_name . ' ' . ($request->suffix ?? ''));

        $emailChanged = $request->email !== $user->email;


        $user->name = $fullName;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_initial;
        $user->last_name = $request->last_name;
        $user->suffix = $request->suffix;
        $user->phone_number = $request->phone;
        if ($emailChanged) {
            $user->email = $request->email;
            $user->email_verified_at = null;
        } else {
            $user->email = $request->email;
        }
        $user->save();

        if ($emailChanged) {
            $this->sendBrevoVerification($user->fresh());
            AuditLog::log('Profile Updated (Email Changed)', 'Profile', 'completed', ['notes' => 'New email: ' . $user->email]);
            return redirect()->route('profile')->with('success', 'Profile updated! Please verify your new email address.');
        }

        AuditLog::log('Profile Updated', 'Profile', 'completed');
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authenticatedUser();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        AuditLog::log('Password Changed', 'Profile', 'completed');

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }

    /**
     * Resend email verification.
     */
    public function resendVerification(Request $request)
    {
        $user = $this->authenticatedUser();

        if ($user->hasVerifiedEmail()) {
            return redirect()->back()->with('info', 'Your email is already verified.');
        }

        $this->sendBrevoVerification($user);

        return redirect()->back()->with('success', 'Verification email sent successfully!')->with('verification_sent', true);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->authenticatedUser();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'The password is incorrect.'])
                ->withInput();
        }

        // Logout user
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Log before deletion
        AuditLog::create([
            'action'         => 'Account Deleted – ' . $user->email,
            'module'         => 'Profile',
            'user_id'        => $user->id,
            'status'         => 'cleared',
            'initiated_user' => $user->email,
        ]);

        // Delete user
        $user->delete();

        return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
    }

    private function sendBrevoVerification($user)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('BREVO_API_KEY'));
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $email = $user->email;
        $name = $user->name;
        $verificationUrl = url('/email/verify/' . $user->id . '/' . sha1($user->email));

        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [["email" => $email, "name" => $name]],
                'sender' => ["email" => env('MAIL_FROM_ADDRESS'), "name" => env('MAIL_FROM_NAME')],
            'subject' => 'Verify your email address',
            'htmlContent' => '<p>Hello ' . $name . ',</p><p>Please verify your email by clicking <a href="' . $verificationUrl . '">here</a>.</p>',
        ]);

        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            Log::error('Brevo verification email failed: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
        }
    }

    /**
     * Generate a 2FA secret and return QR code data for setup modal.
     */
    public function setup2fa()
    {
        $user = $this->authenticatedUser();

        if (!$user->two_factor_secret) {
            $totp = TOTP::generate();
            $totp->setLabel($user->email);
            $totp->setIssuer(config('app.name', 'WIBSystem'));
            $secret = $totp->getSecret();
            $user->two_factor_secret = encrypt($secret);
            $user->save();
        } else {
            $secret = decrypt($user->two_factor_secret);
            $totp = TOTP::createFromSecret($secret);
            $totp->setLabel($user->email);
            $totp->setIssuer(config('app.name', 'WIBSystem'));
        }

        $qrCodeUrl = $totp->getProvisioningUri();
        $qrCode    = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(200)->generate($qrCodeUrl);

        return response()->json([
            'qr_code' => base64_encode($qrCode),
            'secret'  => $secret,
        ]);
    }

    /**
     * Confirm and enable 2FA after user scans QR and enters a valid code.
     */
    public function confirm2fa(Request $request)
    {
        $request->validate(['code' => 'required|string|digits:6']);

        $user   = $this->authenticatedUser();
        $secret = decrypt($user->two_factor_secret);
        $totp   = TOTP::createFromSecret($secret);

        if (!$totp->verify($request->code, null, 1)) {
            return back()->withErrors(['2fa_code' => 'Invalid code. Please try again.']);
        }

        $user->two_factor_enabled      = true;
        $user->two_factor_confirmed_at = now();
        $user->save();

        AuditLog::log('Two-Factor Authentication Enabled', 'Profile', 'completed');

        return redirect()->route('profile')->with('success', 'Two-Factor Authentication has been enabled!');
    }

    /**
     * Disable 2FA for the authenticated user.
     */
    public function disable2fa(Request $request)
    {
        $request->validate(['password' => 'required']);

        $user = $this->authenticatedUser();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['disable_password' => 'The password is incorrect.']);
        }

        $user->two_factor_secret          = null;
        $user->two_factor_enabled         = false;
        $user->two_factor_confirmed_at    = null;
        $user->two_factor_trusted_devices = null;
        $user->save();

        AuditLog::log('Two-Factor Authentication Disabled', 'Profile', 'completed');

        return redirect()->route('profile')
            ->with('success', 'Two-Factor Authentication has been disabled.')
            ->withoutCookie('wib_2fa_device');
    }

    private function authenticatedUser(): User
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            abort(401, 'Unauthenticated.');
        }

        return $user;
    }
}
