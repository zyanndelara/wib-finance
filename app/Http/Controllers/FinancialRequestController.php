<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\FinancialRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialRequestController extends Controller
{
    private function isFinanceOfficer(User $user): bool
    {
        return str_starts_with((string) $user->role, 'finance_officer');
    }

    public function index()
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User) {
            abort(403);
        }

        if (!$authUser->isAdmin() && !$this->isFinanceOfficer($authUser)) {
            abort(403);
        }

        $requests = FinancialRequest::with(['requester', 'approver'])
            ->when(!$authUser->isAdmin(), fn ($q) => $q->where('requested_by', $authUser->id))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('financial-requests', compact('requests', 'authUser'));
    }

    public function store(Request $request): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User) {
            abort(403);
        }

        if (!$this->isFinanceOfficer($authUser)) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01|max:9999999999.99',
            'purpose' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $financialRequest = FinancialRequest::create([
            'requested_by' => $authUser->id,
            'amount' => $validated['amount'],
            'purpose' => $validated['purpose'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
        ]);

        AuditLog::log(
            'Financial Request Submitted – #' . $financialRequest->id,
            'Financial Requests',
            'pending',
            [
                'amount' => $financialRequest->amount,
                'notes' => 'Purpose: ' . $financialRequest->purpose,
            ]
        );

        return redirect()->route('financial-requests.index')
            ->with('success', 'Financial request submitted successfully.');
    }

    public function approve(FinancialRequest $financialRequest): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        if ($financialRequest->status !== 'pending') {
            return redirect()->route('financial-requests.index')
                ->with('error', 'This request has already been processed.');
        }

        $financialRequest->update([
            'status' => 'approved',
            'rejection_reason' => null,
            'approved_by' => $authUser->id,
            'approved_at' => now(),
        ]);

        AuditLog::log(
            'Financial Request Approved – #' . $financialRequest->id,
            'Financial Requests',
            'completed',
            [
                'amount' => $financialRequest->amount,
                'notes' => 'Approved request from user ID ' . $financialRequest->requested_by,
            ]
        );

        return redirect()->route('financial-requests.index')
            ->with('success', 'Financial request approved successfully.');
    }

    public function reject(Request $request, FinancialRequest $financialRequest): RedirectResponse
    {
        $authUser = Auth::user();
        if (!$authUser instanceof User || !$authUser->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        if ($financialRequest->status !== 'pending') {
            return redirect()->route('financial-requests.index')
                ->with('error', 'This request has already been processed.');
        }

        $financialRequest->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'],
            'approved_by' => $authUser->id,
            'approved_at' => now(),
        ]);

        AuditLog::log(
            'Financial Request Rejected – #' . $financialRequest->id,
            'Financial Requests',
            'reversed',
            [
                'amount' => $financialRequest->amount,
                'notes' => 'Rejected request from user ID ' . $financialRequest->requested_by . ' | Reason: ' . $validated['reason'],
            ]
        );

        return redirect()->route('financial-requests.index')
            ->with('success', 'Financial request rejected successfully.');
    }
}
