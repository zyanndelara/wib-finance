<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;
use GuzzleHttp\Client;

class UserController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        $query = User::query();
        $availablePages = User::ACCESSIBLE_PAGES;
        
        // Check if showing archived members
        $showArchived = $request->has('archived') && $request->archived == '1';

        $roleOptionsQuery = User::query();
        if ($showArchived) {
            $roleOptionsQuery->where('status', 'inactive');
        } else {
            $roleOptionsQuery->where('status', 'active');
        }

        $roleOptions = $roleOptionsQuery
            ->whereNotNull('role')
            ->where('role', '!=', '')
            ->distinct()
            ->pluck('role')
            ->sort()
            ->values();

        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('employee_id', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%');
            });
        }

        // Role filter
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Status filter - if showing archived, show only inactive, otherwise show active by default
        if ($showArchived) {
            $query->where('status', 'inactive');
        } else {
            // Show only active members
            $query->where('status', 'active');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('member-management', compact('users', 'showArchived', 'roleOptions', 'availablePages'));
    }

    /**
     * Store a newly created member in database.
     */
    public function store(Request $request)
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'employee_id' => 'required|digits:4|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|regex:/^\+63[0-9]{10}$/|max:20',
            'role' => 'required|in:finance_officer',
            'rank' => 'required|in:I,II,III,IV,V',
            'status' => 'required|in:active,inactive',
            'accessible_pages' => 'required|array|min:1',
            'accessible_pages.*' => 'in:' . implode(',', array_keys(User::ACCESSIBLE_PAGES)),
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Auto-generate password
        $generatedPassword = Str::random(12);

        // Construct full name
        $fullName = trim(($request->first_name ?? '') . ' ' . ($request->middle_name ?? '') . ' ' . ($request->last_name ?? ''));
        if (empty($fullName)) {
            $fullName = $request->email; // Fallback to email if no name provided
        }

        // Combine role and rank
        $combinedRole = $request->role . '_' . $request->rank;

        $user = User::create([
            'name' => $fullName,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'employee_id' => $request->employee_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($generatedPassword),
            'role' => $combinedRole,
            'status' => $request->status,
            'accessible_pages' => array_values(array_unique($request->input('accessible_pages', User::DEFAULT_MEMBER_PAGES))),
        ]);

        // Send email with generated password to user
        try {
            $this->sendBrevoPassword($user, $generatedPassword);

            AuditLog::log(
                'New Member Added – ' . $user->email,
                'Member Management',
                'completed',
                ['notes' => 'Role: ' . $user->role]
            );
            
            return redirect()->route('members.index')
                ->with('success', value: 'Member added successfully! Password has been auto-generated and sent via email.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to send welcome email: ' . $e->getMessage());
            
            return redirect()->route('members.index')
                ->with('warning', 'Member added successfully, but failed to send email. Please contact the system administrator. Generated password: ' . $generatedPassword);
        }
    }

    private function sendBrevoPassword($user, $generatedPassword)
    {
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', env('MAIL_PASSWORD'));
        $apiInstance = new TransactionalEmailsApi(new Client(), $config);

        $email = $user->email;
        $name = $user->name;
        $employeeId = $user->employee_id;
        $password = $generatedPassword;

        // Render the Blade template to HTML
        $htmlContent = view('emails.welcome', [
            'userName' => $name,
            'employeeId' => $employeeId,
            'email' => $email,
            'password' => $password,
        ])->render();

        $sendSmtpEmail = new SendSmtpEmail([
            'to' => [["email" => $email, "name" => $name]],
            'sender' => ["email" => env('MAIL_FROM_ADDRESS'), "name" => env('MAIL_FROM_NAME')],
            'subject' => 'Welcome to When in Baguio Inc.',
            'htmlContent' => $htmlContent,
        ]);

        try {
            $apiInstance->sendTransacEmail($sendSmtpEmail);
        } catch (\Exception $e) {
            Log::error('Brevo verification email failed: ' . $e->getMessage() . '\n' . $e->getTraceAsString());
        }
    }

    /**
     * Update the specified member in database.
     */
    public function update(Request $request, User $user)
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:2',
            'last_name' => 'required|string|max:255',
            'employee_id' => 'required|digits:4|unique:fm_users,employee_id,' . $user->id,
            'email' => 'required|string|email|max:255|unique:fm_users,email,' . $user->id,
            'phone_number' => 'required|string|regex:/^\+63[0-9]{10}$/|max:20',
            'role' => 'required|in:finance_officer,admin',
            'rank' => 'nullable|in:I,II,III,IV,V',
            'status' => 'required|in:active,inactive',
            'accessible_pages' => 'nullable|array|min:1',
            'accessible_pages.*' => 'in:' . implode(',', array_keys(User::ACCESSIBLE_PAGES)),
        ]);

        // Add conditional validation for rank if role is finance_officer
        $validator->sometimes('rank', 'required|in:I,II,III,IV,V', function ($input) {
            return $input->role === 'finance_officer';
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Construct full name
        $fullName = trim(($request->first_name ?? '') . ' ' . ($request->middle_name ?? '') . ' ' . ($request->last_name ?? ''));
        if (empty($fullName)) {
            $fullName = $request->email; // Fallback to email if no name provided
        }

        // Combine role and rank for finance officers, leave admin as is
        $finalRole = $request->role;
        if ($request->role === 'finance_officer' && $request->filled('rank')) {
            $finalRole = $request->role . '_' . $request->rank;
        }

        $accessiblePages = $request->role === 'admin'
            ? User::DEFAULT_ADMIN_PAGES
            : array_values(array_unique($request->input('accessible_pages', $user->resolvedAccessiblePages())));

        $data = [
            'name' => $fullName,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'employee_id' => $request->employee_id,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'role' => $finalRole,
            'status' => $request->status,
            'accessible_pages' => $accessiblePages,
        ];

        $user->update($data);

        AuditLog::log(
            'Member Updated – ' . $user->email,
            'Member Management',
            'completed',
            ['notes' => 'Role: ' . $finalRole]
        );

        return redirect()->route('members.index')
            ->with('success', 'Member updated successfully!');
    }

    /**
     * Archive the specified member by setting status to inactive.
     */
    public function destroy(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        // Prevent archiving the currently authenticated user
        if ($user->id === Auth::id()) {
            return redirect()->route('members.index')
                ->with('error', 'You cannot archive your own account!');
        }

        // Set status to inactive instead of deleting
        $user->update(['status' => 'inactive']);

        AuditLog::log(
            'Member Archived – ' . $user->email,
            'Member Management',
            'cleared',
            ['notes' => 'Account set to inactive']
        );

        return redirect()->route('members.index')
            ->with('success', 'Member archived successfully!');
    }

    /**
     * Restore the specified member by setting status to active.
     */
    public function restore(User $user)
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        // Set status to active to restore the member
        $user->update(['status' => 'active']);

        AuditLog::log(
            'Member Restored – ' . $user->email,
            'Member Management',
            'completed',
            ['notes' => 'Account re-activated']
        );

        return redirect()->route('members.index', ['archived' => '1'])
            ->with('success', 'Member restored successfully!');
    }
}
