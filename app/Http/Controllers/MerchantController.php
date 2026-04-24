<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MerchantController extends Controller
{
    private function merchantResponsePayload(Merchant $merchant): array
    {
        return [
            'id' => $merchant->id,
            'name' => $merchant->name,
            'type' => $merchant->type,
            'category' => $merchant->category ?? '',
            'address' => $merchant->address ?? '',
            'commission_rate' => $merchant->commission_rate,
            'commission_type' => $merchant->commission_type,
            'commission_food_amount' => $merchant->commission_food_amount,
            'commission_drinks_amount' => $merchant->commission_drinks_amount,
            'commission_small_amount' => $merchant->commission_small_amount,
            'commission_big_amount' => $merchant->commission_big_amount,
            'commission_mixed_percentage' => $merchant->commission_mixed_percentage,
            'commission_mixed_amount' => $merchant->commission_mixed_amount,
            'commission_items' => $merchant->commission_items ?? [],
            'status' => $merchant->status,
            'total_orders' => $merchant->total_orders ?? 0,
            'total_sales' => $merchant->total_sales ?? 0,
            'total_commission' => $merchant->total_commission ?? 0,
        ];
    }

    private function getMerchantColumnsLookup(Merchant $merchantModel): array
    {
        $table = $merchantModel->getTable();
        $connection = $merchantModel->getConnectionName();

        return collect(Schema::connection($connection)->getColumnListing($table))
            ->map(fn ($column) => strtolower((string) $column))
            ->flip()
            ->map(fn () => true)
            ->all();
    }

    private function filterMerchantPayloadForExistingColumns(array $payload, array $columnsLookup): array
    {
        $attributeToColumns = [
            'merchant_id' => ['merchant_id'],
            'name' => ['restaurant_name', 'name'],
            'type' => ['partner_type', 'merchant_type', 'type'],
            'address' => ['street', 'address'],
            'commission_type' => ['commision_type', 'commission_type'],
            'commission_rate' => ['percent_commision', 'commission_rate'],
            'commission_items' => ['commission_items'],
            'commission_food_amount' => ['commission_food_amount'],
            'commission_drinks_amount' => ['commission_drinks_amount'],
            'commission_small_amount' => ['commission_small_amount'],
            'commission_big_amount' => ['commission_big_amount'],
            'commission_mixed_percentage' => ['commission_mixed_percentage'],
            'commission_mixed_amount' => ['commission_mixed_amount'],
            'status' => ['status'],
        ];

        $filtered = [];
        foreach ($payload as $attribute => $value) {
            $candidateColumns = $attributeToColumns[$attribute] ?? [$attribute];
            $isSupported = collect($candidateColumns)->contains(function ($column) use ($columnsLookup) {
                return isset($columnsLookup[strtolower((string) $column)]);
            });

            if ($isSupported) {
                $filtered[$attribute] = $value;
            }
        }

        return $filtered;
    }

    private function nextMerchantId(string $connection, string $table, string $keyColumn): int
    {
        $maxId = DB::connection($connection)->table($table)->max($keyColumn);

        return ((int) $maxId) + 1;
    }

    public function index(Request $request)
    {
        $merchantModel    = new Merchant();
        $createdAtColumn  = $merchantModel->getCreatedAtColumn();
        $typeColumn       = $merchantModel->getTypeColumn();
        $merchantKeyColumn = $merchantModel->getKeyName();

        $selectedPeriod = strtolower((string) $request->query('period', 'daily'));
        $allowedPeriods = ['daily', 'weekly', 'monthly', 'bimonth', 'trimonth'];
        if (!in_array($selectedPeriod, $allowedPeriods, true)) {
            $selectedPeriod = 'daily';
        }

        $selectedDateRaw = (string) $request->query('stats_date', '');
        try {
            if (!filled($selectedDateRaw)) {
                $selectedDate = Carbon::today();
            } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $selectedDateRaw) === 1) {
                $selectedDate = Carbon::createFromFormat('m/d/Y', $selectedDateRaw)->startOfDay();
            } else {
                $selectedDate = Carbon::parse($selectedDateRaw)->startOfDay();
            }
        } catch (\Throwable $exception) {
            $selectedDate = Carbon::today();
        }

        $activeMerchantsQuery = Merchant::where('status', 'active');

        $merchants       = (clone $activeMerchantsQuery)->orderByDesc($createdAtColumn)->get();
        $totalMerchants  = (clone $activeMerchantsQuery)->count();
        $partnerCount       = (clone $activeMerchantsQuery)->where($typeColumn, 'partner')->count();
        $nonPartnerCount    = (clone $activeMerchantsQuery)->where($typeColumn, 'non-partner')->count();

        $periodStartDate = match ($selectedPeriod) {
            'daily' => $selectedDate->copy()->startOfDay(),
            'weekly' => $selectedDate->copy()->startOfWeek(),
            'monthly' => $selectedDate->copy()->startOfMonth(),
            'bimonth' => $selectedDate->copy()->subMonthsNoOverflow(2)->startOfMonth(),
            'trimonth' => $selectedDate->copy()->subMonthsNoOverflow(3)->startOfMonth(),
            default => null,
        };

        $merchantIds = $merchants
            ->pluck($merchantKeyColumn)
            ->filter(fn ($value) => filled($value))
            ->values();

        $merchantStatsByMerchant = collect();

        if ($merchantIds->isNotEmpty()) {
            try {
                $orderColumns = collect(Schema::connection('wheninba_MercifulGod')->getColumnListing('mt_order'))
                    ->map(fn ($column) => strtolower((string) $column));

                $dateCandidates = ['delivery_date', 'date_created', 'created_at', 'order_date', 'date_added', 'date_modified'];
                $orderDateColumn = collect($dateCandidates)->first(function ($column) use ($orderColumns) {
                    return $orderColumns->contains(strtolower($column));
                });

                $earningsColumn = collect(['merchant_earnings', 'merchant_earning'])->first(function ($column) use ($orderColumns) {
                    return $orderColumns->contains($column);
                });

                $commissionColumn = $orderColumns->contains('total_commission') ? 'total_commission' : null;

                if ($orderColumns->contains('merchant_id') && $earningsColumn) {
                    $selectRaw = "merchant_id, COALESCE(SUM({$earningsColumn}), 0) as merchant_earning_total, COUNT(DISTINCT order_id) as total_orders";
            
                    if ($commissionColumn) {
                        $selectRaw .= ", COALESCE(SUM({$commissionColumn}), 0) as total_commission";
                    }

                    $ordersQuery = DB::connection('wheninba_MercifulGod')->table('mt_order')
                        ->selectRaw($selectRaw)
                        ->whereIn('merchant_id', $merchantIds)
                        ->whereNotNull('merchant_id')
                        ->whereNotNull('order_id')
                        ->groupBy('merchant_id');

                    if ($orderDateColumn) {
            if ($selectedPeriod === 'daily') {
                $ordersQuery->whereDate($orderDateColumn, $selectedDate->toDateString());
            } elseif ($periodStartDate) {
                $ordersQuery
                    ->whereDate($orderDateColumn, '>=', $periodStartDate->toDateString())
                    ->whereDate($orderDateColumn, '<=', $selectedDate->toDateString());
            }
        }

        $merchantStatsByMerchant = $ordersQuery
            ->get()
            ->mapWithKeys(function ($row) use ($commissionColumn) {
                $merchantId = (int) ($row->merchant_id ?? 0);

                $data = [
                    'total_sales' => (float) ($row->merchant_earning_total ?? 0),
                    'total_orders' => (int) ($row->total_orders ?? 0),
                ];

                if ($commissionColumn) {
                    $data['total_commission'] = (float) ($row->total_commission ?? 0);
                }

                return [$merchantId => $data];
            });
                }
            } catch (\Throwable $exception) {
            $merchantStatsByMerchant = collect();
            }
        }

        $merchantTable = $merchantModel->getTable();
        $merchantSalesColumn = collect(['total_sales', 'sales'])
            ->first(fn (string $column) => Schema::hasColumn($merchantTable, $column));

        $merchants->each(function (Merchant $merchant) use ($merchantStatsByMerchant, $merchantKeyColumn, $merchantSalesColumn) {
            $merchantKey = (int) $merchant->getAttribute($merchantKeyColumn);
            $merchantStats = $merchantStatsByMerchant[$merchantKey] ?? null;

            $storedSales = 0;
            if ($merchantSalesColumn) {
                $storedSales = (float) ($merchant->getRawOriginal($merchantSalesColumn) ?? 0);
            }

            $merchant->total_sales = (float) ($merchantStats['total_sales'] ?? $storedSales);
            $merchant->total_orders = (int) ($merchantStats['total_orders'] ?? 0);

                    if (isset($merchantStats['total_commission'])) {
                        $merchant->total_commission = (float) $merchantStats['total_commission'];
                    }
        });

        $gtMerchantName = 'The Original Good Taste Restaurant';

        if ($merchantSalesColumn) {
            $partnerSales = (clone $activeMerchantsQuery)
                ->where($typeColumn, 'partner')
                ->sum($merchantSalesColumn);
            $nonPartnerSales = (clone $activeMerchantsQuery)
                ->where($typeColumn, 'non-partner')
                ->sum($merchantSalesColumn);

            $merchantNameColumn = $merchantModel->getNameColumn();
            $gtSales = (clone $activeMerchantsQuery)
                ->whereRaw('LOWER(' . $merchantNameColumn . ') = ?', [strtolower($gtMerchantName)])
                ->sum($merchantSalesColumn);
        } else {
            $partnerSales = $merchants
                ->filter(fn (Merchant $merchant) => strtolower((string) $merchant->type) === 'partner')
                ->sum('total_sales');
            $nonPartnerSales = $merchants
                ->filter(fn (Merchant $merchant) => strtolower((string) $merchant->type) === 'non-partner')
                ->sum('total_sales');
            $gtSales = $merchants
                ->first(fn (Merchant $merchant) => strtolower((string) $merchant->name) === strtolower($gtMerchantName))
                ?->total_sales ?? 0;
        }
        // Keep summary in sync with the per-merchant WIB commission values shown in the table.
        $totalWibCommission = (float) $merchants->sum(function (Merchant $merchant) {
            return (float) ($merchant->total_commission ?? 0);
        });

        return view('merchants', compact(
            'merchants', 'totalMerchants', 'partnerCount', 'nonPartnerCount',
            'partnerSales', 'nonPartnerSales', 'gtSales', 'totalWibCommission', 'selectedPeriod', 'selectedDate'
        ));
    }

    public function store(Request $request)
    {
        $merchantModel = new Merchant();
        $merchantConnection = $merchantModel->getConnectionName();
        $merchantTable = $merchantModel->getTable();
        $merchantKeyColumn = $merchantModel->getKeyName();
        $merchantNameColumn = $merchantModel->getNameColumn();
        $columnsLookup = $this->getMerchantColumnsLookup($merchantModel);

        $validated = $request->validate([
            'name'            => "required|string|max:255|unique:{$merchantConnection}.{$merchantTable},{$merchantNameColumn}",
            'type'            => 'required|in:partner,non-partner',

            'address'         => 'nullable|string|max:500',
            'commission_rate'          => 'nullable|numeric|min:0|max:100000',
            'commission_type'          => 'nullable|in:fixed_per_item,category_based_fixed,fixed_per_order,percentage_based,mixed',
            'commission_food_amount'      => 'nullable|numeric|min:0',
            'commission_drinks_amount'    => 'nullable|numeric|min:0',
            'commission_small_amount'     => 'nullable|numeric|min:0',
            'commission_big_amount'       => 'nullable|numeric|min:0',
            'commission_mixed_percentage' => 'nullable|numeric|min:0|max:100',
            'commission_mixed_amount'     => 'nullable|numeric|min:0',
            'commission_items'            => 'nullable|string',
            'status'                      => 'nullable|in:active,inactive',
        ], [
            'name.unique' => 'This merchant is already added.',
        ]);

        if (isset($validated['commission_items'])) {
            $decoded = json_decode($validated['commission_items'], true);
            $validated['commission_items'] = is_array($decoded) ? $decoded : null;
        } else {
            $validated['commission_items'] = null;
        }

        // Clear commission_items if commission type doesn't support items
        $commType = $validated['commission_type'] ?? 'percentage_based';
        if (!in_array($commType, ['fixed_per_item', 'category_based_fixed'])) {
            $validated['commission_items'] = null;
        }

        $createData = [
            'name'            => $validated['name'],
            'type'            => $validated['type'],

            'address'         => $validated['address'] ?? null,
            'commission_rate'          => $validated['commission_rate'] ?? 10.00,
            'commission_type'          => $validated['commission_type'] ?? 'percentage_based',
            'commission_food_amount'      => $validated['commission_food_amount'] ?? null,
            'commission_drinks_amount'    => $validated['commission_drinks_amount'] ?? null,
            'commission_small_amount'     => $validated['commission_small_amount'] ?? null,
            'commission_big_amount'       => $validated['commission_big_amount'] ?? null,
            'commission_mixed_percentage' => $validated['commission_mixed_percentage'] ?? null,
            'commission_mixed_amount'     => $validated['commission_mixed_amount'] ?? null,
            'commission_items'            => $validated['commission_items'] ?? null,
            'status'                      => $validated['status'] ?? 'active',
        ];

        $assignedMerchantId = null;
        if (isset($columnsLookup[strtolower($merchantKeyColumn)])) {
            $assignedMerchantId = $this->nextMerchantId($merchantConnection, $merchantTable, $merchantKeyColumn);
            $createData[$merchantKeyColumn] = $assignedMerchantId;
        }

        $merchant = Merchant::create(
            $this->filterMerchantPayloadForExistingColumns($createData, $columnsLookup)
        );

        $freshMerchant = null;
        if ($assignedMerchantId !== null) {
            $freshMerchant = Merchant::where($merchantKeyColumn, $assignedMerchantId)->first();
        }
        if (!$freshMerchant) {
            $freshMerchant = $merchant->fresh() ?: $merchant;
        }

        AuditLog::log(
            'Merchant Added: ' . $freshMerchant->name,
            'Merchants',
            'completed',

        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Merchant added successfully.',
                'merchant' => $freshMerchant ? $this->merchantResponsePayload($freshMerchant) : null,
            ]);
        }

        return redirect()->route('merchants')->with('success', 'Merchant added successfully.');
    }

    public function update(Request $request, Merchant $merchant)
    {
        $columnsLookup = $this->getMerchantColumnsLookup($merchant);

        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'type'            => 'required|in:partner,non-partner',

            'address'         => 'nullable|string|max:500',
            'commission_rate'          => 'nullable|numeric|min:0|max:100000',
            'commission_type'          => 'nullable|in:fixed_per_item,category_based_fixed,fixed_per_order,percentage_based,mixed',
            'commission_food_amount'      => 'nullable|numeric|min:0',
            'commission_drinks_amount'    => 'nullable|numeric|min:0',
            'commission_small_amount'     => 'nullable|numeric|min:0',
            'commission_big_amount'       => 'nullable|numeric|min:0',
            'commission_mixed_percentage' => 'nullable|numeric|min:0|max:100',
            'commission_mixed_amount'     => 'nullable|numeric|min:0',
            'commission_items'            => 'nullable|string',
            'status'                      => 'nullable|in:active,inactive',
        ]);

        if (isset($validated['commission_items'])) {
            $decoded = json_decode($validated['commission_items'], true);
            $validated['commission_items'] = is_array($decoded) ? $decoded : null;
        } else {
            $validated['commission_items'] = null;
        }

        // Clear commission_items if commission type doesn't support items
        $commType = $validated['commission_type'] ?? $merchant->commission_type;
        if (!in_array($commType, ['fixed_per_item', 'category_based_fixed'])) {
            $validated['commission_items'] = null;
        }

        $updateData = $this->filterMerchantPayloadForExistingColumns($validated, $columnsLookup);
        $merchant->update($updateData);

        AuditLog::log(
            'Merchant Updated: ' . $merchant->name,
            'Merchants',
            'completed',
            ['type' => $merchant->type]
        );

        if ($request->ajax()) {
            $freshMerchant = $merchant->fresh();
            return response()->json([
                'success' => true,
                'message' => 'Merchant updated successfully.',
                'merchant' => $freshMerchant ? $this->merchantResponsePayload($freshMerchant) : null,
            ]);
        }

        return redirect()->route('merchants')->with('success', 'Merchant updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $merchantModel = new Merchant();
        $merchantConnection = $merchantModel->getConnectionName();
        $merchantTable = $merchantModel->getTable();
        $merchantKeyColumn = $merchantModel->getKeyName();
        $columnsLookup = $this->getMerchantColumnsLookup($merchantModel);

        $validated = $request->validate([
            'merchant_ids'                => 'required|array',
            'merchant_ids.*'              => "exists:{$merchantConnection}.{$merchantTable},{$merchantKeyColumn}",
            'type'                        => 'nullable|in:partner,non-partner',
            'commission_type'             => 'nullable|in:fixed_per_item,category_based_fixed,fixed_per_order,percentage_based,mixed',
            'commission_rate'             => 'nullable|numeric|min:0|max:100000',
            'commission_food_amount'      => 'nullable|numeric|min:0',
            'commission_drinks_amount'    => 'nullable|numeric|min:0',
            'commission_small_amount'     => 'nullable|numeric|min:0',
            'commission_big_amount'       => 'nullable|numeric|min:0',
            'commission_mixed_percentage' => 'nullable|numeric|min:0|max:100',
            'commission_mixed_amount'     => 'nullable|numeric|min:0',
            'commission_items'            => 'nullable|string',
            'status'                      => 'nullable|in:active,inactive',
        ]);

        $merchantIds = $validated['merchant_ids'];
        $updateData = [];

        // Only include fields that have values
        foreach (['type', 'commission_type', 'commission_rate', 'commission_food_amount', 'commission_drinks_amount',
                  'commission_small_amount', 'commission_big_amount', 'commission_mixed_percentage',
                  'commission_mixed_amount', 'status'] as $field) {
            if (array_key_exists($field, $validated) && $validated[$field] !== null && $validated[$field] !== '') {
                $updateData[$field] = $validated[$field];
            }
        }

        // Handle commission items separately
        if (isset($validated['commission_items']) && $validated['commission_items'] !== '') {
            $decoded = json_decode($validated['commission_items'], true);
            $updateData['commission_items'] = is_array($decoded) ? $decoded : null;
        }

        $updateData = $this->filterMerchantPayloadForExistingColumns($updateData, $columnsLookup);

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid fields to update.'
            ]);
        }

        // Update selected merchants via model instances so mutators map
        // virtual attributes (e.g. type -> partner_type) to real columns.
        $updatedCount = 0;
        $merchantsToUpdate = Merchant::whereIn($merchantKeyColumn, $merchantIds)->get();
        foreach ($merchantsToUpdate as $merchant) {
            if ($merchant->update($updateData)) {
                $updatedCount++;
            }
        }

        // Log the bulk update
        AuditLog::log(
            'Bulk Updated ' . $updatedCount . ' merchants',
            'Merchants',
            'completed',
            ['updated_fields' => array_keys($updateData), 'merchant_count' => $updatedCount]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} merchants.",
                'updated_count' => $updatedCount
            ]);
        }

        return redirect()->route('merchants')->with('success', "Successfully updated {$updatedCount} merchants.");
    }

    public function archivedIndex(Request $request)
    {
        $merchantModel = new Merchant();
        $createdAtColumn = $merchantModel->getCreatedAtColumn();
        $typeColumn = $merchantModel->getTypeColumn();

        $archivedMerchants = Merchant::query()
            ->whereRaw('LOWER(COALESCE(status, "")) = ?', ['inactive'])
            ->orderByDesc($createdAtColumn)
            ->get();

        $totalArchived = $archivedMerchants->count();
        $archivedPartners = $archivedMerchants
            ->filter(fn (Merchant $merchant) => strtolower((string) $merchant->getAttribute($typeColumn)) === 'partner')
            ->count();
        $archivedNonPartners = $totalArchived - $archivedPartners;

        return view('merchants-archived', compact(
            'archivedMerchants',
            'totalArchived',
            'archivedPartners',
            'archivedNonPartners'
        ));
    }

    public function destroy(Request $request, Merchant $merchant)
    {
        $name = $merchant->name;
        $merchant->delete();

        AuditLog::log(
            'Merchant Deleted: ' . $name,
            'Merchants',
            'completed',
            []
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Merchant deleted successfully.']);
        }

        return redirect()->route('merchants')->with('success', 'Merchant deleted successfully.');
    }

    public function archive(Request $request, Merchant $merchant)
    {
        $alreadyInactive = strtolower((string) ($merchant->status ?? '')) === 'inactive';

        if (!$alreadyInactive) {
            $merchant->update(['status' => 'inactive']);

            AuditLog::log(
                'Merchant Archived: ' . $merchant->name,
                'Merchants',
                'completed',
                []
            );
        }

        $message = $alreadyInactive
            ? 'Merchant is already archived.'
            : 'Merchant archived successfully.';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'merchant' => $this->merchantResponsePayload($merchant->fresh() ?: $merchant),
            ]);
        }

        return redirect()->route('merchants')->with('success', $message);
    }

    public function restore(Request $request, Merchant $merchant)
    {
        $alreadyActive = strtolower((string) ($merchant->status ?? '')) === 'active';

        if (!$alreadyActive) {
            $merchant->update(['status' => 'active']);

            AuditLog::log(
                'Merchant Restored: ' . $merchant->name,
                'Merchants',
                'completed',
                []
            );
        }

        $message = $alreadyActive
            ? 'Merchant is already active.'
            : 'Merchant restored successfully.';

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'merchant' => $this->merchantResponsePayload($merchant->fresh() ?: $merchant),
            ]);
        }

        return redirect()->route('merchants.archived')->with('success', $message);
    }

    public function itemSuggestions(Request $request)
    {
        $validated = $request->validate([
            'q' => 'nullable|string|max:255',
            'merchant_id' => 'nullable|integer|min:1',
            'merchant_name' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1|max:300',
            'include_all' => 'nullable|boolean',
        ]);

        $query = trim((string) ($validated['q'] ?? ''));
        $includeAll = (bool) ($validated['include_all'] ?? false);

        if ($query === '' && !$includeAll) {
            return response()->json([
                'success' => true,
                'items' => [],
            ]);
        }

        $connection = 'wheninba_MercifulGod';
        $itemTable = 'mt_item';

        if (!Schema::connection($connection)->hasTable($itemTable)) {
            return response()->json([
                'success' => true,
                'items' => [],
            ]);
        }

        $itemColumns = collect(Schema::connection($connection)->getColumnListing($itemTable))
            ->map(fn ($column) => strtolower((string) $column));

        $itemNameColumn = collect(['item_name', 'name'])
            ->first(fn ($column) => $itemColumns->contains($column));
        $itemMerchantIdColumn = collect(['merchant_id'])
            ->first(fn ($column) => $itemColumns->contains($column));

        if (!$itemNameColumn) {
            return response()->json([
                'success' => true,
                'items' => [],
            ]);
        }

        $merchantId = (int) ($validated['merchant_id'] ?? 0);
        $merchantName = trim((string) ($validated['merchant_name'] ?? ''));

        if ($merchantId <= 0 && $merchantName !== '' && $itemMerchantIdColumn && Schema::connection($connection)->hasTable('mt_merchant')) {
            $merchantColumns = collect(Schema::connection($connection)->getColumnListing('mt_merchant'))
                ->map(fn ($column) => strtolower((string) $column));

            $merchantNameColumn = collect(['restaurant_name', 'name'])
                ->first(fn ($column) => $merchantColumns->contains($column));
            $merchantIdColumn = collect(['merchant_id'])
                ->first(fn ($column) => $merchantColumns->contains($column));

            if ($merchantNameColumn && $merchantIdColumn) {
                $matchedMerchantId = DB::connection($connection)
                    ->table('mt_merchant')
                    ->whereRaw('LOWER(' . $merchantNameColumn . ') = ?', [strtolower($merchantName)])
                    ->value($merchantIdColumn);

                if (!$matchedMerchantId) {
                    $matchedMerchantId = DB::connection($connection)
                        ->table('mt_merchant')
                        ->where($merchantNameColumn, 'like', '%' . $merchantName . '%')
                        ->value($merchantIdColumn);
                }

                $merchantId = (int) ($matchedMerchantId ?? 0);
            }
        }

        $limit = (int) ($validated['limit'] ?? ($includeAll ? 200 : 10));

        $itemsQuery = DB::connection($connection)
            ->table($itemTable)
            ->select($itemNameColumn)
            ->whereNotNull($itemNameColumn)
            ->where($itemNameColumn, '!=', '');

        if ($query !== '') {
            $itemsQuery->where($itemNameColumn, 'like', '%' . $query . '%');
        }

        if ($itemMerchantIdColumn && $merchantId > 0) {
            $itemsQuery->where($itemMerchantIdColumn, $merchantId);
        }

        $items = $itemsQuery
            ->groupBy($itemNameColumn)
            ->orderBy($itemNameColumn)
            ->limit($limit)
            ->pluck($itemNameColumn)
            ->filter(fn ($itemName) => filled($itemName))
            ->values();

        return response()->json([
            'success' => true,
            'items' => $items,
            'merchant_id' => $merchantId > 0 ? $merchantId : null,
        ]);
    }

    public function priceNotificationsFeed(Request $request)
    {
        $merchantModel = new Merchant();
        $updatedAtColumn = $merchantModel->getUpdatedAtColumn();
        $since = $request->query('since');
        $sinceDate = null;

        if (filled($since)) {
            try {
                $sinceDate = Carbon::parse($since);
            } catch (\Throwable $exception) {
                $sinceDate = null;
            }
        }

        $updatesQuery = Merchant::query()->orderByDesc($updatedAtColumn);

        if ($sinceDate) {
            $updatesQuery->where($updatedAtColumn, '>', $sinceDate->toDateTimeString());
        }

        $updates = $updatesQuery
            ->limit(12)
            ->get()
            ->map(function (Merchant $merchant) {
                $updatedAt = $merchant->updated_at;
                $rawCommissionType = $merchant->getRawOriginal('commission_type')
                    ?? $merchant->getRawOriginal('commision_type')
                    ?? 'percentage_based';
                $rawCommissionRate = $merchant->getRawOriginal('percent_commision')
                    ?? $merchant->getRawOriginal('commission_rate')
                    ?? 0;

                return [
                    'merchant_id' => $merchant->getKey(),
                    'merchant_name' => $merchant->name,
                    'commission_type' => $rawCommissionType,
                    'commission_rate' => (float) $rawCommissionRate,
                    'commission_food_amount' => $merchant->getAttribute('commission_food_amount'),
                    'commission_drinks_amount' => $merchant->getAttribute('commission_drinks_amount'),
                    'commission_small_amount' => $merchant->getAttribute('commission_small_amount'),
                    'commission_big_amount' => $merchant->getAttribute('commission_big_amount'),
                    'commission_mixed_percentage' => $merchant->getAttribute('commission_mixed_percentage'),
                    'commission_mixed_amount' => $merchant->getAttribute('commission_mixed_amount'),
                    'updated_at' => $updatedAt ? $updatedAt->toIso8601String() : null,
                    'updated_at_display' => $updatedAt ? $updatedAt->format('M d, Y h:i A') : null,
                ];
            })
            ->values();

        $latestRaw = Merchant::query()->max($updatedAtColumn);
        $latestTimestamp = null;

        if ($latestRaw) {
            try {
                $latestTimestamp = Carbon::parse($latestRaw)->toIso8601String();
            } catch (\Throwable $exception) {
                $latestTimestamp = null;
            }
        }

        return response()->json([
            'success' => true,
            'latest_timestamp' => $latestTimestamp,
            'updates' => $updates,
        ]);
    }
}
