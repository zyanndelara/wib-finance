<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiderDeduction;
use Illuminate\Support\Facades\Log;

class RiderDeductionController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Deduction submission attempt', $request->all());

            $remarks = trim((string) $request->input('remarks', ''));
            $amountRaw = trim((string) $request->input('amount', ''));

            // Allow the deductions section to be skipped entirely without failing validation.
            if ($remarks === '' && $amountRaw === '') {
                return response()->json([
                    'success' => true,
                    'message' => 'No deduction provided.'
                ]);
            }
            
            $validated = $request->validate([
                'rider_id' => 'required|string',
                'rider_name' => 'required|string',
                'payroll_id' => 'nullable|integer|exists:rider_payrolls,id',
                'replace_existing' => 'nullable|boolean',
                'amount' => 'required|numeric|min:0.01',
                'date' => 'required|date',
                'remarks' => 'nullable|string',
            ]);

            if (!empty($validated['replace_existing']) && !empty($validated['payroll_id'])) {
                RiderDeduction::where('rider_id', $validated['rider_id'])
                    ->where('payroll_id', $validated['payroll_id'])
                    ->delete();
            }

            unset($validated['replace_existing']);

            Log::info('Validation passed', $validated);

            $deduction = RiderDeduction::create($validated);
            
            Log::info('Deduction created successfully', ['id' => $deduction->id]);
            
            return response()->json([
                'success' => true, 
                'message' => 'Deduction saved successfully!',
                'deduction' => $deduction
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Deduction save failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to save deduction: ' . $e->getMessage()
            ], 500);
        }
    }
}
