<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Remittance;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RemittanceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'rider_id' => 'required|exists:mt_driver,driver_id',
                'total_deliveries' => 'required|integer|min:0',
                'total_delivery_fee' => 'required|numeric|min:0',
                'total_remit' => 'required|numeric|min:0',
                'total_tips' => 'nullable|numeric|min:0',
                'total_collection' => 'required|numeric|min:0',
                'mode_of_payment' => 'required|string',
                'remit_photo' => 'nullable|image|max:5120', // 5MB max
                'remarks_amount' => 'nullable|numeric|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        // Mangan deliveries add on top of main deliveries
        $manganDeliveries = (int) ($request->mangan_total_deliveries ?? 0);
        $combinedDeliveries = (int) $request->total_deliveries + $manganDeliveries;

        $remittanceData = [
            'rider_id' => $request->rider_id,
            'total_deliveries' => $combinedDeliveries,
            'total_delivery_fee' => $request->total_delivery_fee,
            'total_remit' => $request->total_remit,
            'total_tips' => $request->total_tips ?? 0,
            'total_collection' => $request->total_collection,
            'mode_of_payment' => $request->mode_of_payment,
            'remarks' => $request->remarks,
            'remarks_amount' => $request->remarks_amount ?? null,
            'status' => 'confirmed',
            'remittance_date' => $request->filled('remittance_date')
                ? \Carbon\Carbon::parse($request->remittance_date)->toDateString()
                : today()->toDateString(),
            // Mangan App fields
            'mangan_merchant_name'         => $request->mangan_merchant_name ?: null,
            'mangan_total_deliveries'      => $manganDeliveries ?: 0,
            'mangan_total_amount'          => $request->mangan_total_amount ?? 0,
            'mangan_df'                    => $request->mangan_df ?? 0,
            'mangan_gt'                    => $request->mangan_gt ?? 0,
            'mangan_tips'                  => $request->mangan_tips ?? 0,
            'mangan_receipt_non_partners'  => $request->mangan_receipt_non_partners ?? 0,
        ];

        // Handle file upload
        if ($request->hasFile('remit_photo')) {
            $file = $request->file('remit_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('remittances', $filename, 'public');
            $remittanceData['remit_photo'] = $path;
        }

        $remittance = Remittance::create($remittanceData);

        // Do not overwrite rider master status on remittance submit.
        // Daily remit state is derived from remittance records/date, not mt_driver.status.

        // Load the rider relationship
        $remittance->load('rider');

        AuditLog::log(
            'Remittance Submitted – Rider: ' . ($remittance->rider->name ?? $remittance->rider_id),
            'Remittance',
            'completed',
            [
                'amount'        => $remittance->total_remit,
                'source_bank'   => $remittance->mode_of_payment,
                'notes'         => 'Mode: ' . $remittance->mode_of_payment . ($remittance->remarks ? ' | ' . $remittance->remarks : ''),
                'attached_file' => $remittance->remit_photo,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Remittance submitted successfully!',
            'remittance' => $remittance
        ]);
    }

    public function index()
    {
        $remittances = Remittance::with('rider')->latest()->get();
        return response()->json([
            'success' => true,
            'remittances' => $remittances
        ]);
    }

    public function show(Remittance $remittance)
    {
        $remittance->load('rider');
        return response()->json([
            'success' => true,
            'remittance' => $remittance
        ]);
    }

    public function update(Request $request, Remittance $remittance)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed',
        ]);

        $remittance->update([
            'status' => $request->status,
        ]);

        AuditLog::log(
            'Remittance Status Updated – ' . ucfirst($request->status),
            'Remittance',
            $request->status === 'confirmed' ? 'completed' : 'dismissed',
            [
                'amount'      => $remittance->total_remit,
                'source_bank' => $remittance->mode_of_payment,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Remittance updated successfully!',
            'remittance' => $remittance
        ]);
    }

    public function destroy(Remittance $remittance)
    {
        // Delete photo if exists
        if ($remittance->remit_photo) {
            Storage::disk('public')->delete($remittance->remit_photo);
        }

        AuditLog::log(
            'Remittance Deleted – Rider: ' . ($remittance->rider->name ?? $remittance->rider_id),
            'Remittance',
            'reversed',
            [
                'amount'      => $remittance->total_remit,
                'source_bank' => $remittance->mode_of_payment,
            ]
        );

        $remittance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Remittance deleted successfully!'
        ]);
    }

    public function getRiderRemittances($riderId)
    {
        $rider = Rider::findOrFail($riderId);
        $remittances = Remittance::where('rider_id', $riderId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'rider' => $rider,
            'remittances' => $remittances
        ]);
    }

    public function report(Request $request)
    {
        $query = Remittance::with('rider');

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('rider_id') && $request->rider_id !== 'all') {
            $query->where('rider_id', $request->rider_id);
        }
        if ($request->filled('payment_mode') && $request->payment_mode !== 'all') {
            $query->where('mode_of_payment', $request->payment_mode);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $remittances = $query->latest()->get();

        $activeRiderIds = Rider::whereIn('status', ['active', 'cleared'])->pluck('driver_id');
        $ridersWithRemittance = $remittances->pluck('rider_id')->unique();
        $activeRidersWithRemittance = $ridersWithRemittance->intersect($activeRiderIds)->count();
        $nonRemittingRiderCount = $activeRiderIds->count() - $activeRidersWithRemittance;

        $summary = [
            'total_records'            => $remittances->count(),
            'total_deliveries'         => $remittances->sum('total_deliveries'),
            'total_delivery_fee'       => $remittances->sum('total_delivery_fee'),
            'total_remit'              => $remittances->sum('total_remit'),
            'total_tips'               => $remittances->sum('total_tips'),
            'total_collection'         => $remittances->sum('total_collection'),
            'cash_collection'          => $remittances->where('mode_of_payment', 'cash')->sum('total_collection'),
            'digital_collection'       => $remittances->whereIn('mode_of_payment', ['bank', 'gcash'])->sum('total_collection'),
            'confirmed_count'          => $remittances->where('status', 'confirmed')->count(),
            'pending_count'            => $remittances->where('status', 'pending')->count(),
            'non_remitting_rider_count' => max(0, $nonRemittingRiderCount),
        ];

        // Per-rider breakdown
        $riderBreakdown = $remittances->groupBy('rider_id')->map(function ($group) {
            $first = $group->first();
            return [
                'rider_name'         => $first->rider->name ?? 'N/A',
                'total_records'      => $group->count(),
                'total_deliveries'   => $group->sum('total_deliveries'),
                'total_delivery_fee' => $group->sum('total_delivery_fee'),
                'total_remit'        => $group->sum('total_remit'),
                'total_tips'         => $group->sum('total_tips'),
                'total_collection'   => $group->sum('total_collection'),
            ];
        })->values();

        return response()->json([
            'success'        => true,
            'remittances'    => $remittances,
            'summary'        => $summary,
            'riderBreakdown' => $riderBreakdown,
        ]);
    }
}
