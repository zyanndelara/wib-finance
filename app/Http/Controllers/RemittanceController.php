<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Remittance;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class RemittanceController extends Controller
{
    private function resolveMerchantTypeColumn($legacySchema): ?string
    {
        if (!$legacySchema->hasTable('mt_merchant')) {
            return null;
        }

        $merchantColumns = $legacySchema->getColumnListing('mt_merchant');

        return collect(['partner_type', 'merchant_type', 'type'])->first(function ($column) use ($merchantColumns) {
            return in_array($column, $merchantColumns, true);
        });
    }

    private function resolveMerchantCommissionTypeColumn($legacySchema): ?string
    {
        if (!$legacySchema->hasTable('mt_merchant')) {
            return null;
        }

        $merchantColumns = $legacySchema->getColumnListing('mt_merchant');

        return collect(['commission_type', 'commision_type'])->first(function ($column) use ($merchantColumns) {
            return in_array($column, $merchantColumns, true);
        });
    }

    private function resolveMerchantCommissionRateColumn($legacySchema): ?string
    {
        if (!$legacySchema->hasTable('mt_merchant')) {
            return null;
        }

        $merchantColumns = $legacySchema->getColumnListing('mt_merchant');

        return collect(['commission_rate', 'percent_commision'])->first(function ($column) use ($merchantColumns) {
            return in_array($column, $merchantColumns, true);
        });
    }

    private function calculateMerchantRemitAmount(string $merchantName, string $merchantType, float $orderTotal, float $deliveryFee, float $tipAmount, string $paymentType = '', float $receiptNonPartners = 0): float
    {
        $normalizedMerchantName = strtolower(trim(preg_replace('/\s+/', ' ', $merchantName)));
        $normalizedPaymentType = strtoupper(trim($paymentType));
        $remitAmount = max(0, $orderTotal - $deliveryFee);

        if ($normalizedMerchantName === 'victoria bakery - magsaysay branch' && $normalizedPaymentType === 'COD') {
            return max(0, $orderTotal - $deliveryFee - $receiptNonPartners);
        }
        
        // If payment type is PYR (Payment on Remittance), return negative amount
        // This will be deducted from overall total remit
        if ($normalizedPaymentType === 'PYR') {
            return -$remitAmount;
        }
        
        return $remitAmount;
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'rider_id' => 'required|exists:wheninba_MercifulGod.mt_driver,driver_id',
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

        $targetRemittanceDate = $request->filled('remittance_date')
            ? \Carbon\Carbon::parse($request->remittance_date)->toDateString()
            : today()->toDateString();

        $targetDate = \Carbon\Carbon::parse($targetRemittanceDate);
        $previousDate = $targetDate->copy()->subDay()->toDateString();

        $hasRemittedPreviousDate = Remittance::query()
            ->where('rider_id', $request->rider_id)
            ->whereDate('remittance_date', $previousDate)
            ->exists();

        if (!$hasRemittedPreviousDate) {
            $legacyDb = DB::connection('wheninba_MercifulGod');
            $legacySchema = Schema::connection('wheninba_MercifulGod');
            $hadDeliveriesPreviousDate = false;

            if ($legacySchema->hasTable('mt_driver_task')) {
                $driverTaskColumns = $legacySchema->getColumnListing('mt_driver_task');
                $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($driverTaskColumns) {
                    return in_array($column, $driverTaskColumns, true);
                });
                $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                    ->first(function ($column) use ($driverTaskColumns) {
                        return in_array($column, $driverTaskColumns, true);
                    });
                $taskKeyColumn = in_array('task_id', $driverTaskColumns, true) ? 'task_id' : null;

                if ($riderKeyColumn && $taskDateColumn && $taskKeyColumn) {
                    $hadDeliveriesPreviousDate = $legacyDb->table('mt_driver_task')
                        ->where("{$riderKeyColumn}", $request->rider_id)
                        ->whereNotNull($taskKeyColumn)
                        ->whereDate($taskDateColumn, $previousDate)
                        ->exists();
                }
            }

            if ($hadDeliveriesPreviousDate) {
                return response()->json([
                    'success' => false,
                    'message' => 'This rider has unremitted deliveries from the previous day. Please remit that day first before proceeding.'
                ], 409);
            }
        }

        $alreadyRemittedAmount = (float) Remittance::query()
            ->where('rider_id', $request->rider_id)
            ->whereDate('remittance_date', $targetRemittanceDate)
            ->sum('total_remit');

        $legacyDb = DB::connection('wheninba_MercifulGod');
        $legacySchema = Schema::connection('wheninba_MercifulGod');
        $merchantTypeColumn = $this->resolveMerchantTypeColumn($legacySchema);
        $commissionTypeColumn = $this->resolveMerchantCommissionTypeColumn($legacySchema);
        $commissionRateColumn = $this->resolveMerchantCommissionRateColumn($legacySchema);

        $expectedTotalAmount = 0.0;
        if ($legacySchema->hasTable('mt_driver_task')) {
            $driverTaskColumns = $legacySchema->getColumnListing('mt_driver_task');
            $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($driverTaskColumns) {
                return in_array($column, $driverTaskColumns, true);
            });
            $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                ->first(function ($column) use ($driverTaskColumns) {
                    return in_array($column, $driverTaskColumns, true);
                });

            if ($riderKeyColumn && $taskDateColumn) {
                $expectedRows = $legacyDb->table('mt_driver_task')
                    ->leftJoin('wheninba_MercifulGod.mt_order', 'mt_driver_task.order_id', '=', 'wheninba_MercifulGod.mt_order.order_id')
                    ->leftJoin('mt_merchant', 'wheninba_MercifulGod.mt_order.merchant_id', '=', 'mt_merchant.merchant_id')
                    ->where("mt_driver_task.{$riderKeyColumn}", $request->rider_id)
                    ->whereDate("mt_driver_task.{$taskDateColumn}", $targetRemittanceDate)
                    ->whereNotNull('mt_driver_task.order_id')
                    ->selectRaw("COALESCE(mt_merchant.restaurant_name, 'Unknown Merchant') as merchant_name")
                    ->selectRaw($merchantTypeColumn ? "COALESCE(MAX(mt_merchant.{$merchantTypeColumn}), '') as merchant_type" : "'' as merchant_type")
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.delivery_charge), 0) as delivery_fee')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.cart_tip_value), 0) as tip_amount')
                    ->selectRaw("COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.payment_type AS CHAR)), '') as payment_type")
                    ->groupBy('merchant_name', 'mt_driver_task.order_id');

                if ($merchantTypeColumn) {
                    $expectedRows->groupBy('merchant_type');
                }

                $expectedRows = $expectedRows->get();

                $expectedTotalAmount = (float) $expectedRows->sum(function ($row) {
                    return $this->calculateMerchantRemitAmount(
                        (string) ($row->merchant_name ?? ''),
                        (string) ($row->merchant_type ?? ''),
                        (float) ($row->order_total ?? 0),
                        (float) ($row->delivery_fee ?? 0),
                        (float) ($row->tip_amount ?? 0),
                        (string) ($row->payment_type ?? ''),
                        0
                    );
                });
            }
        }

        $incomingRemitAmount = (float) $request->total_remit;
        $remainingAmount = max($expectedTotalAmount - $alreadyRemittedAmount, 0);

        if ($expectedTotalAmount > 0 && $remainingAmount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'This rider is already fully remitted for the selected date. No remaining amount to remit.'
            ], 409);
        }

        if ($expectedTotalAmount > 0 && $incomingRemitAmount - $remainingAmount > 0.0001) {
            return response()->json([
                'success' => false,
                'message' => 'Remit amount exceeds remaining balance. Remaining amount: ₱' . number_format($remainingAmount, 2)
            ], 422);
        }

        // Mangan deliveries add on top of main deliveries
        $manganDeliveries = (int) ($request->mangan_total_deliveries ?? 0);
        $combinedDeliveries = (int) $request->total_deliveries + $manganDeliveries;

        $existingRemittance = Remittance::query()
            ->where('rider_id', $request->rider_id)
            ->whereDate('remittance_date', $targetRemittanceDate)
            ->latest('id')
            ->first();

        // Handle payment mode - support both single and multiple modes
        $modeOfPayment = $request->mode_of_payment;
        if ($request->filled('payment_modes_json')) {
            try {
                $modes = json_decode($request->payment_modes_json, true);
                if (is_array($modes) && count($modes) > 0) {
                    $modeOfPayment = json_encode($modes);
                }
            } catch (\Exception $e) {
                // Fallback to original mode if JSON decode fails
            }
        }

        $extractModes = function ($rawMode) {
            if (!is_string($rawMode) || trim($rawMode) === '') {
                return [];
            }

            $decoded = json_decode($rawMode, true);
            if (is_array($decoded)) {
                return array_values(array_filter(array_map(function ($mode) {
                    return strtolower(trim((string) $mode));
                }, $decoded)));
            }

            return [strtolower(trim($rawMode))];
        };

        $incomingModes = $extractModes($modeOfPayment);
        $existingModes = $existingRemittance ? $extractModes($existingRemittance->mode_of_payment) : [];
        $mergedModes = array_values(array_unique(array_filter(array_merge($existingModes, $incomingModes))));
        $storedMode = count($mergedModes) > 1 ? json_encode($mergedModes) : ($mergedModes[0] ?? $modeOfPayment);

        $newTotalRemit = $alreadyRemittedAmount + $incomingRemitAmount;
        $isComplete = $expectedTotalAmount > 0
            ? ($newTotalRemit + 0.0001 >= $expectedTotalAmount)
            : true;
        $remainingAfterSave = $expectedTotalAmount > 0
            ? max($expectedTotalAmount - $newTotalRemit, 0)
            : 0;

        $incomingRemarks = trim((string) $request->remarks);
        $mergedRemarks = $incomingRemarks;
        if ($existingRemittance) {
            $existingRemarks = trim((string) $existingRemittance->remarks);
            if ($existingRemarks !== '' && $incomingRemarks !== '') {
                $mergedRemarks = $existingRemarks . ' | ' . $incomingRemarks;
            } elseif ($existingRemarks !== '' && $incomingRemarks === '') {
                $mergedRemarks = $existingRemarks;
            }
        }

        $incomingRemarksAmount = $request->filled('remarks_amount') ? (float) $request->remarks_amount : null;
        $existingRemarksAmount = $existingRemittance && $existingRemittance->remarks_amount !== null
            ? (float) $existingRemittance->remarks_amount
            : null;
        $storedRemarksAmount = $incomingRemarksAmount ?? $existingRemarksAmount;

        $remittanceData = [
            'rider_id' => $request->rider_id,
            'total_deliveries' => $combinedDeliveries,
            'total_delivery_fee' => $request->total_delivery_fee,
            'total_remit' => $newTotalRemit,
            'total_tips' => $request->total_tips ?? 0,
            'total_collection' => $request->total_collection,
            'mode_of_payment' => $storedMode,
            'remarks' => $mergedRemarks,
            'remarks_amount' => $storedRemarksAmount,
            'status' => $isComplete ? 'confirmed' : 'pending',
            'remittance_date' => $targetRemittanceDate,
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
            if ($existingRemittance && $existingRemittance->remit_photo) {
                Storage::disk('public')->delete($existingRemittance->remit_photo);
            }
            $file = $request->file('remit_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('remittances', $filename, 'public');
            $remittanceData['remit_photo'] = $path;
        } elseif ($existingRemittance && $existingRemittance->remit_photo) {
            $remittanceData['remit_photo'] = $existingRemittance->remit_photo;
        }

        if ($existingRemittance) {
            $existingRemittance->update($remittanceData);
            $remittance = $existingRemittance->fresh();
        } else {
            $remittance = Remittance::create($remittanceData);
        }

        // Do not overwrite rider master status on remittance submit.
        // Daily remit state is derived from remittance records/date, not mt_driver.status.

        // Load the rider relationship
        $remittance->load('rider');

        AuditLog::log(
            ($existingRemittance ? 'Remittance Updated' : 'Remittance Submitted') . ' – Rider: ' . ($remittance->rider->name ?? $remittance->rider_id),
            'Remittance',
            $isComplete ? 'completed' : 'pending',
            [
                'amount'        => $remittance->total_remit,
                'source_bank'   => $remittance->mode_of_payment,
                'notes'         => 'Mode: ' . $remittance->mode_of_payment . ($remittance->remarks ? ' | ' . $remittance->remarks : ''),
                'attached_file' => $remittance->remit_photo,
            ]
        );

        return response()->json([
            'success' => true,
            'message' => $existingRemittance
                ? 'Remittance updated successfully in the same record!'
                : 'Remittance submitted successfully!',
            'remittance' => $remittance,
            'expected_total_amount' => $expectedTotalAmount,
            'remaining_amount' => $remainingAfterSave,
            'is_complete' => $isComplete
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

    public function getRemittanceMerchantBreakdown(Remittance $remittance)
    {
        $summary = [
            'merchant_count' => 0,
            'total_deliveries' => 0,
            'total_collection' => 0,
        ];

        $targetDate = $remittance->remittance_date
            ? \Carbon\Carbon::parse($remittance->remittance_date)->toDateString()
            : \Carbon\Carbon::parse($remittance->created_at)->toDateString();

        $legacyDb = DB::connection('wheninba_MercifulGod');
        $legacySchema = Schema::connection('wheninba_MercifulGod');
        $merchantTypeColumn = $this->resolveMerchantTypeColumn($legacySchema);
        $commissionTypeColumn = $this->resolveMerchantCommissionTypeColumn($legacySchema);
        $commissionRateColumn = $this->resolveMerchantCommissionRateColumn($legacySchema);

        try {
            if (!$legacySchema->hasTable('mt_driver_task')) {
                return response()->json([
                    'success' => true,
                    'remittance_id' => $remittance->id,
                    'remittance_date' => $targetDate,
                    'breakdown' => [],
                    'summary' => $summary,
                    'message' => 'Delivery task table is unavailable.',
                ]);
            }

            $taskColumns = $legacySchema->getColumnListing('mt_driver_task');
            $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($taskColumns) {
                return in_array($column, $taskColumns, true);
            });
            $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                ->first(function ($column) use ($taskColumns) {
                    return in_array($column, $taskColumns, true);
                });

            if (!$riderKeyColumn || !$taskDateColumn || !in_array('order_id', $taskColumns, true)) {
                return response()->json([
                    'success' => true,
                    'remittance_id' => $remittance->id,
                    'remittance_date' => $targetDate,
                    'breakdown' => [],
                    'summary' => $summary,
                    'message' => 'Required delivery columns are unavailable for merchant breakdown.',
                ]);
            }

            $detailRows = $legacyDb->table('mt_driver_task')
                ->leftJoin('wheninba_MercifulGod.mt_order', 'mt_driver_task.order_id', '=', 'wheninba_MercifulGod.mt_order.order_id')
                ->leftJoin('mt_merchant', 'wheninba_MercifulGod.mt_order.merchant_id', '=', 'mt_merchant.merchant_id')
                ->where("mt_driver_task.{$riderKeyColumn}", $remittance->rider_id)
                ->whereDate("mt_driver_task.{$taskDateColumn}", $targetDate)
                ->whereNotNull('mt_driver_task.order_id')
                ->selectRaw("COALESCE(mt_merchant.restaurant_name, 'Unknown Merchant') as merchant_name")
                ->selectRaw($merchantTypeColumn ? "COALESCE(MAX(mt_merchant.{$merchantTypeColumn}), '') as merchant_type" : "'' as merchant_type")
                ->selectRaw($commissionTypeColumn ? "COALESCE(MAX(mt_merchant.{$commissionTypeColumn}), '') as commission_type" : "'' as commission_type")
                ->selectRaw($commissionRateColumn ? "COALESCE(MAX(mt_merchant.{$commissionRateColumn}), 0) as commission_rate" : "0 as commission_rate")
                ->selectRaw('mt_driver_task.order_id as order_id')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.delivery_charge), 0) as delivery_fee')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.cart_tip_value), 0) as tip_amount')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.packaging), 0) as cf_amount')
                ->selectRaw("COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.payment_type AS CHAR)), '') as payment_type")
                ->groupBy('merchant_name', 'mt_driver_task.order_id')
                ->orderBy('merchant_name')
                ->orderBy('mt_driver_task.order_id')
                ->get();

            $breakdown = $detailRows
                ->groupBy('merchant_name')
                ->map(function ($rows, $merchantName) {
                    $orders = collect($rows)
                        ->map(function ($row) {
                            $merchantName = (string) ($row->merchant_name ?? '');
                            $merchantType = (string) ($row->merchant_type ?? '');
                            $commissionType = (string) ($row->commission_type ?? '');
                            $commissionRate = (float) ($row->commission_rate ?? 0);
                            $orderTotal = (float) ($row->order_total ?? 0);
                            $deliveryFee = (float) ($row->delivery_fee ?? 0);
                            $tipAmount = (float) ($row->tip_amount ?? 0);
                            $cfAmount = (float) ($row->cf_amount ?? 0);
                            $paymentType = (string) ($row->payment_type ?? '');
                            $isGtOrGrumpy = str_contains(strtolower($merchantName), 'good taste') || str_contains(strtolower($merchantName), 'grumpy');
                            $isPartnerOrNonPartner = in_array(strtolower(trim($merchantType)), ['partner', 'non-partner'], true);

                            $receiptNonPartners = ($isGtOrGrumpy || $isPartnerOrNonPartner)
                                ? 0
                                : max(0, $orderTotal - $deliveryFee - $tipAmount);

                            $totalRemit = $this->calculateMerchantRemitAmount($merchantName, $merchantType, $orderTotal, $deliveryFee, $tipAmount, $paymentType, $receiptNonPartners);

                            $gtGrumpyReceipt = $isGtOrGrumpy
                                ? max(0, $totalRemit - $cfAmount)
                                : 0;

                            return [
                                'order_id' => (string) ($row->order_id ?? ''),
                                'payment_type' => (string) ($row->payment_type ?? ''),
                                'total_collection' => (float) ($row->order_total ?? 0),
                                'delivery_fee' => $deliveryFee,
                                'tip_amount' => $tipAmount,
                                'merchant_type' => $merchantType,
                                'commission_type' => $commissionType,
                                'commission_rate' => $commissionRate,
                                'gt_grumpy_receipt' => $gtGrumpyReceipt,
                                'receipt_non_partners' => $receiptNonPartners,
                                'total_remit' => $totalRemit,
                                'cf_amount' => $cfAmount,
                            ];
                        })
                        ->filter(function ($order) {
                            return $order['order_id'] !== '';
                        })
                        ->values();

                    return [
                        'merchant_name' => (string) ($merchantName ?: 'Unknown Merchant'),
                        'deliveries' => $orders->count(),
                        'total_collection' => (float) $orders->sum('total_collection'),
                        'order_ids' => $orders->pluck('order_id')->values()->all(),
                        'orders' => $orders->all(),
                    ];
                })
                ->sortByDesc('deliveries')
                ->values();

            $manganDeliveries = (int) ($remittance->mangan_total_deliveries ?? 0);
            if ($manganDeliveries > 0) {
                $manganMerchantName = trim((string) ($remittance->mangan_merchant_name ?? ''));
                $manganMerchantName = $manganMerchantName !== '' ? $manganMerchantName : 'Mangan App';
                $manganAmount = (float) ($remittance->mangan_total_amount ?? 0);

                $existingIndex = $breakdown->search(function ($item) use ($manganMerchantName) {
                    return strtolower((string) ($item['merchant_name'] ?? '')) === strtolower($manganMerchantName);
                });

                if ($existingIndex !== false) {
                    $current = $breakdown->get($existingIndex);
                    $current['deliveries'] = (int) ($current['deliveries'] ?? 0) + $manganDeliveries;
                    $current['total_collection'] = (float) ($current['total_collection'] ?? 0) + $manganAmount;
                    $currentOrderIds = collect($current['order_ids'] ?? []);
                    if (!$currentOrderIds->contains('MANGAN-AGGREGATED')) {
                        $currentOrderIds->push('MANGAN-AGGREGATED');
                    }
                    $current['order_ids'] = $currentOrderIds->values()->all();

                    $currentOrders = collect($current['orders'] ?? []);
                    $currentOrders->push([
                        'order_id' => 'MANGAN-AGGREGATED',
                        'payment_type' => (string) ($remittance->mode_of_payment ?? ''),
                        'total_collection' => $manganAmount,
                        'delivery_fee' => (float) ($remittance->mangan_df ?? 0),
                        'tip_amount' => (float) ($remittance->mangan_tips ?? 0),
                        'gt_grumpy_receipt' => (float) ($remittance->mangan_gt ?? 0),
                        'receipt_non_partners' => (float) ($remittance->mangan_receipt_non_partners ?? 0),
                        'total_remit' => (float) ($remittance->mangan_df ?? 0) + (float) ($remittance->mangan_tips ?? 0),
                        'cf_amount' => 0,
                    ]);
                    $current['orders'] = $currentOrders->values()->all();
                    $breakdown->put($existingIndex, $current);
                } else {
                    $breakdown->push([
                        'merchant_name' => $manganMerchantName,
                        'deliveries' => $manganDeliveries,
                        'total_collection' => $manganAmount,
                        'order_ids' => ['MANGAN-AGGREGATED'],
                        'orders' => [
                            [
                                'order_id' => 'MANGAN-AGGREGATED',
                                'payment_type' => (string) ($remittance->mode_of_payment ?? ''),
                                'total_collection' => $manganAmount,
                                'delivery_fee' => (float) ($remittance->mangan_df ?? 0),
                                'tip_amount' => (float) ($remittance->mangan_tips ?? 0),
                                'gt_grumpy_receipt' => (float) ($remittance->mangan_gt ?? 0),
                                'receipt_non_partners' => (float) ($remittance->mangan_receipt_non_partners ?? 0),
                                'total_remit' => (float) ($remittance->mangan_df ?? 0) + (float) ($remittance->mangan_tips ?? 0),
                                'cf_amount' => 0,
                            ],
                        ],
                    ]);
                }

                $breakdown = $breakdown
                    ->sortByDesc('deliveries')
                    ->values();
            }

            $summary = [
                'merchant_count' => $breakdown->count(),
                'total_deliveries' => (int) $breakdown->sum('deliveries'),
                'total_collection' => (float) $breakdown->sum('total_collection'),
            ];

            return response()->json([
                'success' => true,
                'remittance_id' => $remittance->id,
                'remittance_date' => $targetDate,
                'rider_id' => $remittance->rider_id,
                'mode_of_payment' => (string) ($remittance->mode_of_payment ?? ''),
                'remarks' => (string) ($remittance->remarks ?? ''),
                'breakdown' => $breakdown,
                'summary' => $summary,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => true,
                'remittance_id' => $remittance->id,
                'remittance_date' => $targetDate,
                'breakdown' => [],
                'summary' => $summary,
                'message' => 'Unable to load merchant breakdown right now.',
            ]);
        }
    }

    public function getRiderDeliveryBreakdown(Request $request, $riderId)
    {
        $summary = [
            'merchant_count' => 0,
            'total_deliveries' => 0,
            'total_collection' => 0,
        ];

        $targetDate = $request->filled('date')
            ? \Carbon\Carbon::parse($request->date)->toDateString()
            : today()->toDateString();

        $legacyDb = DB::connection('wheninba_MercifulGod');
        $legacySchema = Schema::connection('wheninba_MercifulGod');
        $merchantTypeColumn = $this->resolveMerchantTypeColumn($legacySchema);
        $commissionTypeColumn = $this->resolveMerchantCommissionTypeColumn($legacySchema);
        $commissionRateColumn = $this->resolveMerchantCommissionRateColumn($legacySchema);

        try {
            if (!$legacySchema->hasTable('mt_driver_task')) {
                return response()->json([
                    'success' => true,
                    'rider_id' => (int) $riderId,
                    'remittance_date' => $targetDate,
                    'breakdown' => [],
                    'summary' => $summary,
                    'message' => 'Delivery task table is unavailable.',
                ]);
            }

            $taskColumns = $legacySchema->getColumnListing('mt_driver_task');
            $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($taskColumns) {
                return in_array($column, $taskColumns, true);
            });
            $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                ->first(function ($column) use ($taskColumns) {
                    return in_array($column, $taskColumns, true);
                });

            if (!$riderKeyColumn || !$taskDateColumn || !in_array('order_id', $taskColumns, true)) {
                return response()->json([
                    'success' => true,
                    'rider_id' => (int) $riderId,
                    'remittance_date' => $targetDate,
                    'breakdown' => [],
                    'summary' => $summary,
                    'message' => 'Required delivery columns are unavailable for breakdown.',
                ]);
            }

            $detailRows = $legacyDb->table('mt_driver_task')
                ->leftJoin('wheninba_MercifulGod.mt_order', 'mt_driver_task.order_id', '=', 'wheninba_MercifulGod.mt_order.order_id')
                ->leftJoin('mt_merchant', 'wheninba_MercifulGod.mt_order.merchant_id', '=', 'mt_merchant.merchant_id')
                ->where("mt_driver_task.{$riderKeyColumn}", $riderId)
                ->whereDate("mt_driver_task.{$taskDateColumn}", $targetDate)
                ->whereNotNull('mt_driver_task.order_id')
                ->selectRaw("COALESCE(mt_merchant.restaurant_name, 'Unknown Merchant') as merchant_name")
                ->selectRaw($merchantTypeColumn ? "COALESCE(MAX(mt_merchant.{$merchantTypeColumn}), '') as merchant_type" : "'' as merchant_type")
                ->selectRaw($commissionTypeColumn ? "COALESCE(MAX(mt_merchant.{$commissionTypeColumn}), '') as commission_type" : "'' as commission_type")
                ->selectRaw($commissionRateColumn ? "COALESCE(MAX(mt_merchant.{$commissionRateColumn}), 0) as commission_rate" : "0 as commission_rate")
                ->selectRaw('mt_driver_task.order_id as order_id')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.delivery_charge), 0) as delivery_fee')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.cart_tip_value), 0) as tip_amount')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.packaging), 0) as cf_amount')
                ->selectRaw("COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.payment_type AS CHAR)), '') as payment_type")
                ->groupBy('merchant_name', 'mt_driver_task.order_id')
                ->orderBy('merchant_name')
                ->orderBy('mt_driver_task.order_id')
                ->get();

            $breakdown = $detailRows
                ->groupBy('merchant_name')
                ->map(function ($rows, $merchantName) {
                    $orders = collect($rows)
                        ->map(function ($row) {
                            $merchantName = (string) ($row->merchant_name ?? '');
                            $merchantType = (string) ($row->merchant_type ?? '');
                            $commissionType = (string) ($row->commission_type ?? '');
                            $commissionRate = (float) ($row->commission_rate ?? 0);
                            $orderTotal = (float) ($row->order_total ?? 0);
                            $deliveryFee = (float) ($row->delivery_fee ?? 0);
                            $tipAmount = (float) ($row->tip_amount ?? 0);
                            $cfAmount = (float) ($row->cf_amount ?? 0);
                            $paymentType = (string) ($row->payment_type ?? '');
                            $isGtOrGrumpy = str_contains(strtolower($merchantName), 'good taste') || str_contains(strtolower($merchantName), 'grumpy');
                            $isPartnerOrNonPartner = in_array(strtolower(trim($merchantType)), ['partner', 'non-partner'], true);

                            $receiptNonPartners = ($isGtOrGrumpy || $isPartnerOrNonPartner)
                                ? 0
                                : max(0, $orderTotal - $deliveryFee - $tipAmount);

                            $totalRemit = $this->calculateMerchantRemitAmount($merchantName, $merchantType, $orderTotal, $deliveryFee, $tipAmount, $paymentType, $receiptNonPartners);

                            $gtGrumpyReceipt = $isGtOrGrumpy
                                ? max(0, $totalRemit - $cfAmount)
                                : 0;

                            return [
                                'order_id' => (string) ($row->order_id ?? ''),
                                'payment_type' => (string) ($row->payment_type ?? ''),
                                'total_collection' => (float) ($row->order_total ?? 0),
                                'delivery_fee' => $deliveryFee,
                                'tip_amount' => $tipAmount,
                                'merchant_type' => $merchantType,
                                'commission_type' => $commissionType,
                                'commission_rate' => $commissionRate,
                                'gt_grumpy_receipt' => $gtGrumpyReceipt,
                                'receipt_non_partners' => $receiptNonPartners,
                                'total_remit' => $totalRemit,
                                'cf_amount' => $cfAmount,
                            ];
                        })
                        ->filter(function ($order) {
                            return $order['order_id'] !== '';
                        })
                        ->values();

                    return [
                        'merchant_name' => (string) ($merchantName ?: 'Unknown Merchant'),
                        'deliveries' => $orders->count(),
                        'total_collection' => (float) $orders->sum('total_collection'),
                        'order_ids' => $orders->pluck('order_id')->values()->all(),
                        'orders' => $orders->all(),
                    ];
                })
                ->sortByDesc('deliveries')
                ->values();

            $summary = [
                'merchant_count' => $breakdown->count(),
                'total_deliveries' => (int) $breakdown->sum('deliveries'),
                'total_collection' => (float) $breakdown->sum('total_collection'),
            ];

            return response()->json([
                'success' => true,
                'rider_id' => (int) $riderId,
                'remittance_date' => $targetDate,
                'breakdown' => $breakdown,
                'summary' => $summary,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => true,
                'rider_id' => (int) $riderId,
                'remittance_date' => $targetDate,
                'breakdown' => [],
                'summary' => $summary,
                'message' => 'Unable to load rider delivery breakdown right now.',
            ]);
        }
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
