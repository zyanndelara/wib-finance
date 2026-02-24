<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

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
        $user = Auth::user();

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
            return redirect()->route('profile')->with('success', 'Profile updated! Please verify your new email address.');
        }

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

        $user = Auth::user();

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

        return redirect()->route('profile')->with('success', 'Password updated successfully!');
    }

    /**
     * Resend email verification.
     */
    public function resendVerification(Request $request)
    {
        $user = Auth::user();

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

        $user = Auth::user();

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

        // Delete user
        $user->delete();

        return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
    }

    private function sendBrevoVerification($user)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('MAIL_PASSWORD'));
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
}
