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

    private function resolveMerchantCommissionItemsColumn($legacySchema): ?string
    {
        if (!$legacySchema->hasTable('mt_merchant')) {
            return null;
        }

        $merchantColumns = $legacySchema->getColumnListing('mt_merchant');

        return collect(['commission_items'])->first(function ($column) use ($merchantColumns) {
            return in_array($column, $merchantColumns, true);
        });
    }

    private function calculateReceiptNonPartnersAmount(float $subTotal, float $commissionRate): float
    {
        $normalizedCommissionRate = abs($commissionRate);

        if ($normalizedCommissionRate > 1) {
            $normalizedCommissionRate /= 100;
        }

        return $this->calculateReceiptNonPartnersAmountByDivisor($subTotal, 1 + $normalizedCommissionRate);
    }

    private function calculateReceiptNonPartnersAmountByDivisor(float $subTotal, float $commissionStructureDivisor): float
    {
        if ($commissionStructureDivisor <= 0) {
            return max(0, $subTotal);
        }

        return max(0, $subTotal / $commissionStructureDivisor);
    }

    private function isNonPartnerMerchantType(string $merchantType): bool
    {
        $normalizedMerchantType = str_replace(['_', ' '], '-', strtolower(trim($merchantType)));
        return in_array($normalizedMerchantType, ['non-partner', 'nonpartner'], true);
    }

    private function isFixedPerItemCommissionType(string $commissionType): bool
    {
        $normalizedCommissionType = str_replace(['-', ' '], '_', strtolower(trim($commissionType)));
        return $normalizedCommissionType === 'fixed_per_item';
    }

    private function isPercentageCommissionType(string $commissionType): bool
    {
        $normalizedCommissionType = str_replace(['-', ' '], '_', strtolower(trim($commissionType)));
        return in_array($normalizedCommissionType, [
            'percentage_based',
            'percentage',
            'percent',
            'percentagebased',
        ], true);
    }

    private function normalizeCommissionItemKey($value): string
    {
        return strtolower(trim((string) $value));
    }

    private function extractCommissionItemRateMap($commissionItems): array
    {
        if (is_array($commissionItems)) {
            $decoded = $commissionItems;
        } else {
            $raw = trim((string) ($commissionItems ?? ''));
            if ($raw === '') {
                return [];
            }

            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) {
                return [];
            }
        }

        $rateMap = [];
        foreach ($decoded as $entry) {
            if (!is_array($entry)) {
                continue;
            }

            $label = $this->normalizeCommissionItemKey($entry['label'] ?? '');
            $amount = (float) ($entry['amount'] ?? 0);
            if ($label === '' || $amount < 0) {
                continue;
            }

            $rateMap[$label] = $amount;
        }

        return $rateMap;
    }

    private function resolveOrderItemNameById(int $itemId, string $legacyConnection = 'wheninba_MercifulGod'): ?string
    {
        static $itemLookupMeta = [];
        static $itemNameCache = [];

        if ($itemId <= 0) {
            return null;
        }

        if (isset($itemNameCache[$legacyConnection][$itemId])) {
            return $itemNameCache[$legacyConnection][$itemId];
        }

        if (!isset($itemLookupMeta[$legacyConnection])) {
            $schema = Schema::connection($legacyConnection);
            if (!$schema->hasTable('mt_item')) {
                $itemLookupMeta[$legacyConnection] = ['ready' => false];
            } else {
                $columns = $schema->getColumnListing('mt_item');
                $idColumn = collect(['item_id'])->first(function ($column) use ($columns) {
                    return in_array($column, $columns, true);
                });
                $nameColumn = collect(['item_name', 'name'])->first(function ($column) use ($columns) {
                    return in_array($column, $columns, true);
                });

                $itemLookupMeta[$legacyConnection] = [
                    'ready' => (bool) ($idColumn && $nameColumn),
                    'id_column' => $idColumn,
                    'name_column' => $nameColumn,
                ];
            }
        }

        $meta = $itemLookupMeta[$legacyConnection];
        if (empty($meta['ready'])) {
            return null;
        }

        try {
            $itemName = DB::connection($legacyConnection)
                ->table('mt_item')
                ->where($meta['id_column'], $itemId)
                ->value($meta['name_column']);

            $normalized = $itemName !== null ? trim((string) $itemName) : '';
            $itemNameCache[$legacyConnection][$itemId] = $normalized !== '' ? $normalized : null;
        } catch (\Throwable $e) {
            $itemNameCache[$legacyConnection][$itemId] = null;
        }

        return $itemNameCache[$legacyConnection][$itemId];
    }

    private function calculateFixedPerItemReceiptFromCommissionStructure(
        $jsonDetails,
        $commissionItems,
        string $legacyConnection = 'wheninba_MercifulGod'
    ): float {
        $rateMap = $this->extractCommissionItemRateMap($commissionItems);
        if (empty($rateMap)) {
            return 0.0;
        }

        if (is_array($jsonDetails)) {
            $decodedItems = $jsonDetails;
        } else {
            $raw = trim((string) ($jsonDetails ?? ''));
            if ($raw === '') {
                return 0.0;
            }

            $decodedItems = json_decode($raw, true);
            if (!is_array($decodedItems)) {
                return 0.0;
            }
        }

        $total = 0.0;
        foreach ($decodedItems as $item) {
            if (!is_array($item)) {
                continue;
            }

            $qty = (float) ($item['qty'] ?? 0);
            if ($qty <= 0) {
                continue;
            }

            $candidateKeys = [];

            $itemIdRaw = $item['item_id'] ?? null;
            $itemId = (int) $itemIdRaw;
            if ($itemId > 0) {
                $candidateKeys[] = $this->normalizeCommissionItemKey((string) $itemId);
            }

            if (isset($item['item_name'])) {
                $candidateKeys[] = $this->normalizeCommissionItemKey($item['item_name']);
            }

            if ($itemId > 0) {
                $resolvedItemName = $this->resolveOrderItemNameById($itemId, $legacyConnection);
                if ($resolvedItemName !== null) {
                    $candidateKeys[] = $this->normalizeCommissionItemKey($resolvedItemName);
                }
            }

            $rate = null;
            foreach ($candidateKeys as $key) {
                if ($key !== '' && array_key_exists($key, $rateMap)) {
                    $rate = (float) $rateMap[$key];
                    break;
                }
            }

            if ($rate === null) {
                continue;
            }

            $total += max(0, $qty * $rate);
        }

        return max(0, $total);
    }

    private function calculateFixedPerItemPyrReceiptFromJsonDetails($jsonDetails, float $commissionRate, $commissionItems): float
    {
        if (is_array($jsonDetails)) {
            $decodedItems = $jsonDetails;
        } else {
            $raw = trim((string) ($jsonDetails ?? ''));
            if ($raw === '') {
                return 0.0;
            }

            $decodedItems = json_decode($raw, true);
            if (!is_array($decodedItems)) {
                return 0.0;
            }
        }

        $normalizedCommissionRate = max(0, abs($commissionRate));
        $totalPrice = 0.0;
        $totalQty = 0.0;

        foreach ($decodedItems as $item) {
            if (!is_array($item)) {
                continue;
            }

            $qty = (float) ($item['qty'] ?? 0);
            $price = (float) ($item['price'] ?? 0);
            if ($qty <= 0 || $price < 0) {
                continue;
            }

            $totalQty += $qty;
            $totalPrice += ($qty * $price);
        }

        $commissionFromRate = $totalQty * $normalizedCommissionRate;
        $commissionFromStructure = $this->calculateFixedPerItemReceiptFromCommissionStructure($decodedItems, $commissionItems);
        $effectiveCommission = max(0, $commissionFromRate, $commissionFromStructure);

        return max(0, $totalPrice - $effectiveCommission);
    }

    private function extractTotalQtyFromJsonDetails($jsonDetails): float
    {
        if (is_array($jsonDetails)) {
            $decoded = $jsonDetails;
        } else {
            $raw = trim((string) ($jsonDetails ?? ''));
            if ($raw === '') {
                return 0.0;
            }

            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) {
                return 0.0;
            }
        }

        return (float) collect($decoded)
            ->sum(function ($item) {
                if (!is_array($item)) {
                    return 0;
                }

                return (float) ($item['qty'] ?? 0);
            });
    }

    private function calculateReceiptNonPartnersFromOrder(
        string $merchantType,
        string $commissionType,
        float $commissionRate,
        string $paymentType,
        float $orderSubTotal,
        float $orderTotal,
        float $deliveryFee,
        float $tipAmount,
        bool $isGtOrGrumpy,
        $jsonDetails,
        $commissionItems
    ): float {
        $paymentTypeNormalized = strtoupper(trim($paymentType));

        if ($this->isNonPartnerMerchantType($merchantType) && $this->isFixedPerItemCommissionType($commissionType)) {
            if ($paymentTypeNormalized === 'PYR') {
                return $this->calculateFixedPerItemPyrReceiptFromJsonDetails($jsonDetails, $commissionRate, $commissionItems);
            }

            return $this->calculateFixedPerItemReceiptFromCommissionStructure($jsonDetails, $commissionItems);
        }

        if ($this->isNonPartnerMerchantType($merchantType) && $this->isPercentageCommissionType($commissionType)) {
            return $this->calculateReceiptNonPartnersAmount($orderSubTotal, $commissionRate);
        }

        if (in_array($paymentTypeNormalized, ['PYR', 'PAYMONGO_GCASH'], true)) {
            return $this->calculateReceiptNonPartnersAmount($orderSubTotal, $commissionRate);
        }

        if ($isGtOrGrumpy || $this->isNonPartnerMerchantType($merchantType) || strtolower(trim($merchantType)) === 'partner') {
            return 0;
        }

        return max(0, $orderTotal - $deliveryFee - $tipAmount);
    }

    private function calculateMerchantRemitAmount(string $merchantName, float $orderTotal, float $deliveryFee, string $paymentType = '', float $receiptNonPartners = 0): float
    {
        $normalizedMerchantName = strtolower(trim(preg_replace('/\s+/', ' ', $merchantName)));
        $normalizedPaymentType = strtoupper(trim($paymentType));
        $remitAmount = max(0, $orderTotal - $deliveryFee);

        if ($normalizedMerchantName === 'victoria bakery - magsaysay branch' && $normalizedPaymentType === 'COD') {
            return max(0, $orderTotal - $deliveryFee - $receiptNonPartners);
        }
        
        // If payment type is PYR or PAYMONGO_GCASH, return negative delivery fee remit.
        // This will be deducted from overall total remit.
        if (in_array($normalizedPaymentType, ['PYR', 'PAYMONGO_GCASH'], true)) {
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
                'total_remit' => 'required|numeric|min:0.01',
                'total_tips' => 'nullable|numeric|min:0',
                'total_collection' => 'required|numeric|min:0',
                'mode_of_payment' => 'required|string|in:cash,gcash,multiple',
                'payment_modes_json' => 'nullable|string|max:255',
                'payment_breakdown_json' => 'nullable|string|max:1000',
                'remittance_date' => 'nullable|date_format:Y-m-d|before_or_equal:today',
                'remit_photo' => 'nullable|image|max:5120', // 5MB max
                'remarks' => 'nullable|string|max:1000',
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

        $allowedModes = ['cash', 'gcash'];
        $modeOfPayment = strtolower(trim((string) $request->mode_of_payment));

        $selectedModes = [];
        if ($request->filled('payment_modes_json')) {
            $decodedModes = json_decode((string) $request->payment_modes_json, true);
            if (!is_array($decodedModes)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment mode payload format.'
                ], 422);
            }

            $selectedModes = array_values(array_unique(array_filter(array_map(function ($mode) use ($allowedModes) {
                $normalized = strtolower(trim((string) $mode));
                return in_array($normalized, $allowedModes, true) ? $normalized : null;
            }, $decodedModes))));
        }

        if (empty($selectedModes)) {
            $selectedModes = in_array($modeOfPayment, $allowedModes, true) ? [$modeOfPayment] : [];
        }

        if (empty($selectedModes)) {
            return response()->json([
                'success' => false,
                'message' => 'At least one valid payment mode is required.'
            ], 422);
        }

        if ($modeOfPayment === 'multiple' && count($selectedModes) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Multiple mode requires at least two payment modes.'
            ], 422);
        }

        if ($modeOfPayment !== 'multiple' && (count($selectedModes) !== 1 || $selectedModes[0] !== $modeOfPayment)) {
            return response()->json([
                'success' => false,
                'message' => 'Mode of payment does not match selected payment mode(s).'
            ], 422);
        }

        $incomingRemitAmount = (float) $request->total_remit;
        $totalCollection = (float) $request->total_collection;
        if ($incomingRemitAmount - $totalCollection > 0.0001) {
            return response()->json([
                'success' => false,
                'message' => 'Total remit cannot be greater than total collection.'
            ], 422);
        }

        if ($request->filled('payment_breakdown_json')) {
            $decodedBreakdown = json_decode((string) $request->payment_breakdown_json, true);
            if (!is_array($decodedBreakdown)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment breakdown payload format.'
                ], 422);
            }

            $breakdownTotal = 0.0;
            foreach ($selectedModes as $mode) {
                $modeAmount = array_key_exists($mode, $decodedBreakdown) ? (float) $decodedBreakdown[$mode] : 0.0;
                if ($modeAmount < 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment breakdown values cannot be negative.'
                    ], 422);
                }
                $breakdownTotal += $modeAmount;
            }

            if ($breakdownTotal > 0 && ($breakdownTotal - $totalCollection > 0.0001)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment breakdown cannot exceed total collection.'
                ], 422);
            }
        }

        $targetRemittanceDate = $request->filled('remittance_date')
            ? \Carbon\Carbon::parse($request->remittance_date)->toDateString()
            : today()->toDateString();

        $targetDate = \Carbon\Carbon::parse($targetRemittanceDate);
        $previousDate = $targetDate->copy()->subDay()->toDateString();

        $requestedBlockedOverride = filter_var($request->input('optional_blocked_override', false), FILTER_VALIDATE_BOOLEAN);
        $authUser = $request->user();
        $canBypassPreviousDayBlock = $requestedBlockedOverride
            && $authUser
            && method_exists($authUser, 'isAdmin')
            && $authUser->isAdmin();

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

            if ($hadDeliveriesPreviousDate && !$canBypassPreviousDayBlock) {
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
        $commissionItemsColumn = $this->resolveMerchantCommissionItemsColumn($legacySchema);
        $orderColumns = $legacySchema->hasTable('mt_order')
            ? $legacySchema->getColumnListing('mt_order')
            : [];
        $hasOrderSubTotal = in_array('sub_total', $orderColumns, true);
        $hasOrderJsonDetails = in_array('json_details', $orderColumns, true);
        $orderColumns = $legacySchema->hasTable('mt_order')
            ? $legacySchema->getColumnListing('mt_order')
            : [];
        $hasOrderSubTotal = in_array('sub_total', $orderColumns, true);

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
                        (float) ($row->order_total ?? 0),
                        (float) ($row->delivery_fee ?? 0),
                        (string) ($row->payment_type ?? ''),
                        0
                    );
                });
            }
        }

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

        // Store as JSON only when multiple modes were selected.
        $modeOfPayment = count($selectedModes) > 1
            ? json_encode($selectedModes)
            : $selectedModes[0];

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
        $commissionItemsColumn = $this->resolveMerchantCommissionItemsColumn($legacySchema);
        $orderColumns = $legacySchema->hasTable('mt_order')
            ? $legacySchema->getColumnListing('mt_order')
            : [];
        $hasOrderSubTotal = in_array('sub_total', $orderColumns, true);
        $hasOrderJsonDetails = in_array('json_details', $orderColumns, true);

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
                ->selectRaw($commissionItemsColumn ? "COALESCE(MAX(CAST(mt_merchant.{$commissionItemsColumn} AS CHAR)), '') as merchant_commission_items" : "'' as merchant_commission_items")
                ->selectRaw('mt_driver_task.order_id as order_id')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                ->selectRaw($hasOrderSubTotal ? 'COALESCE(MAX(wheninba_MercifulGod.mt_order.sub_total), 0) as order_sub_total' : '0 as order_sub_total')
                ->selectRaw($hasOrderJsonDetails ? "COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.json_details AS CHAR)), '') as order_json_details" : "'' as order_json_details")
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
                            $orderSubTotal = (float) ($row->order_sub_total ?? 0);
                            $orderJsonDetails = (string) ($row->order_json_details ?? '');
                            $merchantCommissionItems = (string) ($row->merchant_commission_items ?? '');
                            $isGtOrGrumpy = str_contains(strtolower($merchantName), 'good taste') || str_contains(strtolower($merchantName), 'grumpy');
                            $receiptNonPartners = $this->calculateReceiptNonPartnersFromOrder(
                                $merchantType,
                                $commissionType,
                                $commissionRate,
                                $paymentType,
                                $orderSubTotal,
                                $orderTotal,
                                $deliveryFee,
                                $tipAmount,
                                $isGtOrGrumpy,
                                $orderJsonDetails,
                                $merchantCommissionItems
                            );

                            $totalRemit = $this->calculateMerchantRemitAmount($merchantName, $orderTotal, $deliveryFee, $paymentType, $receiptNonPartners);

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
        $commissionItemsColumn = $this->resolveMerchantCommissionItemsColumn($legacySchema);
        $orderColumns = $legacySchema->hasTable('mt_order')
            ? $legacySchema->getColumnListing('mt_order')
            : [];
        $hasOrderSubTotal = in_array('sub_total', $orderColumns, true);
        $hasOrderJsonDetails = in_array('json_details', $orderColumns, true);

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
                ->selectRaw($commissionItemsColumn ? "COALESCE(MAX(CAST(mt_merchant.{$commissionItemsColumn} AS CHAR)), '') as merchant_commission_items" : "'' as merchant_commission_items")
                ->selectRaw('mt_driver_task.order_id as order_id')
                ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                ->selectRaw($hasOrderSubTotal ? 'COALESCE(MAX(wheninba_MercifulGod.mt_order.sub_total), 0) as order_sub_total' : '0 as order_sub_total')
                ->selectRaw($hasOrderJsonDetails ? "COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.json_details AS CHAR)), '') as order_json_details" : "'' as order_json_details")
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
                            $orderSubTotal = (float) ($row->order_sub_total ?? 0);
                            $orderJsonDetails = (string) ($row->order_json_details ?? '');
                            $merchantCommissionItems = (string) ($row->merchant_commission_items ?? '');
                            $isGtOrGrumpy = str_contains(strtolower($merchantName), 'good taste') || str_contains(strtolower($merchantName), 'grumpy');
                            $receiptNonPartners = $this->calculateReceiptNonPartnersFromOrder(
                                $merchantType,
                                $commissionType,
                                $commissionRate,
                                $paymentType,
                                $orderSubTotal,
                                $orderTotal,
                                $deliveryFee,
                                $tipAmount,
                                $isGtOrGrumpy,
                                $orderJsonDetails,
                                $merchantCommissionItems
                            );

                            $totalRemit = $this->calculateMerchantRemitAmount($merchantName, $orderTotal, $deliveryFee, $paymentType, $receiptNonPartners);

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
