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
        $generatedBy = $request->user();

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

        // Filter by salary schedule day constraints
        $salarySchedule = $payroll->salary_schedule;
        if ($salarySchedule === 'Mon-Thur/Friday payout') {
            // Monday (1) through Friday (5)
            $remittancesQuery->whereRaw('DAYOFWEEK(remittance_date) BETWEEN 2 AND 6');
        } elseif ($salarySchedule === 'Fri-Sun/Monday payout') {
            // Friday (6), Saturday (7), Sunday (1), Monday (2) in MySQL DAYOFWEEK
            $remittancesQuery->whereRaw('DAYOFWEEK(remittance_date) IN (1, 2, 6, 7)');
        } elseif ($salarySchedule === 'Mon-Sun/Monday payout') {
            // All days - no filter needed
        } elseif ($salarySchedule === 'Cut off payout') {
            // 15th or last day of month
            $remittancesQuery->whereRaw('(DAY(remittance_date) = 15 OR DAY(remittance_date) = DAY(LAST_DAY(remittance_date)))');
        } elseif ($salarySchedule === 'Select Date') {
            // Custom date range - no day-of-week filter needed
            // The date range is already applied via $fromDate and $toDate above
        }

        $remittances     = $remittancesQuery->get();
        $subtotal        = (float) $remittances->sum('total_delivery_fee');
        $platformFee     = round($subtotal * 0.05, 2);
        $totalDeliveries = (int)   $remittances->sum('total_deliveries');
        $totalTips       = (float) $remittances->sum('total_tips');
        $monthlyPerformanceIncentive = (float) ($payroll->incentives ?? 0);
        $renumeration26Days = (float) ($payroll->renumeration_26_days ?? 0);
        // Keep fallback to base_salary for older payroll records created before adda_df existed.
        $addaDf = (float) ($payroll->adda_df ?? $payroll->base_salary ?? 0);
        $addaDfDate = $payroll->adda_df_date ?? $payroll->created_at?->toDateString();
        $addaDfEntries = json_decode($payroll->adda_df_entries ?? '[]', true);
        if (!is_array($addaDfEntries)) {
            $addaDfEntries = [];
        }

        // Prefer deductions linked to this payroll, but fall back to the pay-period
        // rider query so newly entered deductions still appear if the link is missing.
        $deductionsQuery = RiderDeduction::where('rider_id', $riderId)
            ->where('payroll_id', $payroll->id);
        $deductionRecords = $deductionsQuery->orderBy('date')->get();

        if ($deductionRecords->isEmpty()) {
            $deductionsQuery = RiderDeduction::where('rider_id', $riderId);
            if ($fromDate && $toDate) {
                $payrollDate  = $payroll->created_at->toDateString();
                $upperBound   = $payrollDate > $toDate ? $payrollDate : $toDate;
                $deductionsQuery->whereBetween('date', [$fromDate, $upperBound]);
            } else {
                $deductionsQuery
                    ->whereYear('date',  $payroll->created_at->year)
                    ->whereMonth('date', $payroll->created_at->month);
            }

            $deductionRecords = $deductionsQuery->orderBy('date')->get();
        }

        $totalDeductions  = (float) $deductionRecords->sum('amount');

        $computedTotal = round(
            ($subtotal + $totalTips + $monthlyPerformanceIncentive + $renumeration26Days + $addaDf)
            - $platformFee
            - $totalDeductions,
            2
        );

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
            'monthlyPerformanceIncentive',
            'renumeration26Days',
            'addaDf',
            'addaDfDate',
            'addaDfEntries',
            'deductionRecords',
            'totalDeductions',
            'computedTotal',
            'rider',
            'generatedBy',
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
                'renumeration_26_days' => 'nullable|numeric',
                'adda_df' => 'nullable|numeric',
                'adda_df_date' => 'nullable|date',
                'adda_df_entries' => 'nullable|string',
                'salary_schedule' => 'required|string',
                'mode_of_payment' => 'required|string',
                'net_salary' => 'required|numeric',
            ]);

            // Ensure optional monetary fields are set to 0 when left blank.
            if (!isset($validated['incentives']) || $validated['incentives'] === null || $validated['incentives'] === '') {
                $validated['incentives'] = 0;
            }

            if (!isset($validated['renumeration_26_days']) || $validated['renumeration_26_days'] === null || $validated['renumeration_26_days'] === '') {
                $validated['renumeration_26_days'] = 0;
            }

            // Ensure adda_df is set to 0 if missing or empty
            if (!isset($validated['adda_df']) || $validated['adda_df'] === null || $validated['adda_df'] === '' ) {
                $validated['adda_df'] = 0;
            }

            // Handle payment mode while keeping a single stored value.
            if ($request->filled('payment_modes_json')) {
                try {
                    $modes = json_decode($request->payment_modes_json, true);
                    if (is_array($modes) && count($modes) > 0) {
                        $validated['mode_of_payment'] = (string) $modes[0];
                    }
                } catch (\Exception $e) {
                    // Fallback to original mode if JSON decode fails
                }
            }

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
