<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        $merchantModel    = new Merchant();
        $createdAtColumn  = $merchantModel->getCreatedAtColumn();
        $typeColumn       = $merchantModel->getTypeColumn();
        $merchants       = Merchant::orderByDesc($createdAtColumn)->get();
        $totalMerchants  = Merchant::count();
        $partnerCount       = Merchant::where($typeColumn, 'partner')->count();
        $nonPartnerCount    = Merchant::where($typeColumn, 'non-partner')->count();

        $tableName = $merchantModel->getTable();
        $hasTotalSales = Schema::hasColumn($tableName, 'total_sales');
        $hasTotalCommission = Schema::hasColumn($tableName, 'total_commission');

        $partnerSales       = $hasTotalSales ? Merchant::where($typeColumn, 'partner')->sum('total_sales') : 0;
        $nonPartnerSales    = $hasTotalSales ? Merchant::where($typeColumn, 'non-partner')->sum('total_sales') : 0;
        $gtSales            = $hasTotalSales ? Merchant::sum('total_sales') : 0;
        $totalWibCommission = $hasTotalCommission ? Merchant::sum('total_commission') : 0;

        return view('merchants', compact(
            'merchants', 'totalMerchants', 'partnerCount', 'nonPartnerCount',
            'partnerSales', 'nonPartnerSales', 'gtSales', 'totalWibCommission'
        ));
    }

    public function store(Request $request)
    {
        $merchantModel = new Merchant();
        $merchantTable = $merchantModel->getTable();
        $merchantNameColumn = $merchantModel->getNameColumn();

        $validated = $request->validate([
            'name'            => "required|string|max:255|unique:{$merchantTable},{$merchantNameColumn}",
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
        }

        $merchant = Merchant::create([
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
        ]);

        AuditLog::log(
            'Merchant Added: ' . $merchant->name,
            'Merchants',
            'completed',

        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Merchant added successfully.',
                'merchant' => $merchant->fresh(),
            ]);
        }

        return redirect()->route('merchants')->with('success', 'Merchant added successfully.');
    }

    public function update(Request $request, Merchant $merchant)
    {
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
        }

        $merchant->update($validated);

        AuditLog::log(
            'Merchant Updated: ' . $merchant->name,
            'Merchants',
            'completed',
            ['type' => $merchant->type]
        );

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Merchant updated successfully.', 'merchant' => $merchant->fresh()]);
        }

        return redirect()->route('merchants')->with('success', 'Merchant updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $merchantModel = new Merchant();
        $merchantTable = $merchantModel->getTable();
        $merchantKeyColumn = $merchantModel->getKeyName();

        $validated = $request->validate([
            'merchant_ids'                => 'required|array',
            'merchant_ids.*'              => "exists:{$merchantTable},{$merchantKeyColumn}",
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
        foreach (['commission_type', 'commission_rate', 'commission_food_amount', 'commission_drinks_amount',
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

        if (empty($updateData)) {
            return response()->json([
                'success' => false,
                'message' => 'No valid fields to update.'
            ]);
        }

        // Update all selected merchants
        $updatedCount = Merchant::whereIn($merchantKeyColumn, $merchantIds)->update($updateData);

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
}
