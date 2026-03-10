<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiderPayroll;
use App\Models\Remittance;
use App\Models\RiderDeduction;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RiderPayrollController extends Controller
{
    public function payslip($id, Request $request)
    {
        $payroll = RiderPayroll::findOrFail($id);

        $riderId  = (int) $payroll->rider_id;
        $fromDate = $request->get('from_date');
        $toDate   = $request->get('to_date');

        $remittancesQuery = Remittance::where('rider_id', $riderId)
            ->orderBy('remittance_date');

        if ($fromDate && $toDate) {
            $remittancesQuery->whereBetween('remittance_date', [$fromDate, $toDate]);
        } else {
            $remittancesQuery
                ->whereYear('remittance_date',  $payroll->created_at->year)
                ->whereMonth('remittance_date', $payroll->created_at->month);
        }

        $remittances     = $remittancesQuery->get();
        $subtotal        = (float) $remittances->sum('total_delivery_fee');
        $platformFee     = round($subtotal * 0.05, 2);
        $totalDeliveries = (int)   $remittances->sum('total_deliveries');
        $totalTips       = (float) $remittances->sum('total_tips');

        // Accumulated deductions for this rider within the pay period
        $deductionsQuery = RiderDeduction::where('rider_id', $riderId);
        if ($fromDate && $toDate) {
            $deductionsQuery->whereBetween('date', [$fromDate, $toDate]);
        } else {
            $deductionsQuery
                ->whereYear('date',  $payroll->created_at->year)
                ->whereMonth('date', $payroll->created_at->month);
        }
        $totalDeductions = (float) $deductionsQuery->sum('amount');

        // Try to find a matching user record for extra info (email / phone)
        $rider = User::where('role', 'rider')
            ->where(function ($q) use ($payroll) {
                $q->where('name', $payroll->rider_name)
                  ->orWhere(\Illuminate\Support\Facades\DB::raw("CONCAT(first_name, ' ', last_name)"), $payroll->rider_name);
            })->first();

        return view('payslip', compact(
            'payroll',
            'riderId',
            'remittances',
            'subtotal',
            'platformFee',
            'totalDeliveries',
            'totalTips',
            'totalDeductions',
            'rider',
            'fromDate',
            'toDate'
        ));
    }


    public function store(Request $request)
    {
        try {
            Log::info('Payroll submission attempt', $request->all());
            
            $validated = $request->validate([
                'rider_id' => 'required|string',
                'rider_name' => 'required|string',
                'base_salary' => 'required|numeric',
                'incentives' => 'nullable|numeric',
                'salary_schedule' => 'required|string',
                'mode_of_payment' => 'required|string',
                'net_salary' => 'required|numeric',
            ]);

            Log::info('Validation passed', $validated);

            $payroll = RiderPayroll::create($validated);
            
            Log::info('Payroll created successfully', ['id' => $payroll->id]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Payroll saved successfully!',
                'payroll' => $payroll
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Payroll save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save payroll: ' . $e->getMessage()
            ], 500);
        }
    }
}
