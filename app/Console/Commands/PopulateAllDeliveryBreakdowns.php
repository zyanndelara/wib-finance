<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Rider;
use App\Models\DeliveryBreakdown;

class PopulateAllDeliveryBreakdowns extends Command
{
    protected $signature = 'deliverybreakdowns:populate {--date=}';

    protected $description = 'Populate fm_delivery_breakdowns from legacy mt_driver_task for all dates or a specific date.';

    public function handle()
    {
        $legacy = DB::connection('wheninba_MercifulGod');
        $schema = Schema::connection('wheninba_MercifulGod');

        if (!$schema->hasTable('mt_driver_task')) {
            $this->error('Legacy table mt_driver_task not found.');
            return 1;
        }

        $dateOption = $this->option('date');
        if ($dateOption) {
            $dates = [$dateOption];
        } else {
            $dates = $legacy->table('mt_driver_task')
                ->whereNotNull('order_id')
                ->selectRaw('DATE(delivery_date) as d')
                ->groupBy('d')
                ->pluck('d')
                ->toArray();
        }

        foreach ($dates as $date) {
            $this->info("Processing date: $date");

            $driverIds = $legacy->table('mt_driver_task')
                ->whereDate('delivery_date', $date)
                ->whereNotNull('order_id')
                ->groupBy('driver_id')
                ->pluck('driver_id')
                ->toArray();

            foreach ($driverIds as $driverId) {
                $this->info(" - Rider: $driverId");
                $rider = Rider::query()->where('driver_id', $driverId)->first();
                $riderName = $rider?->name ?? ('Driver #' . $driverId);

                // Reuse the same query logic as in the controller to fetch detail rows
                $detailRows = $legacy->table('mt_driver_task')
                    ->leftJoin('wheninba_MercifulGod.mt_order', 'mt_driver_task.order_id', '=', 'wheninba_MercifulGod.mt_order.order_id')
                    ->leftJoin('mt_merchant', 'wheninba_MercifulGod.mt_order.merchant_id', '=', 'mt_merchant.merchant_id')
                    ->where('mt_driver_task.driver_id', $driverId)
                    ->whereDate('mt_driver_task.delivery_date', $date)
                    ->whereNotNull('mt_driver_task.order_id')
                    ->selectRaw("COALESCE(mt_merchant.restaurant_name, 'Unknown Merchant') as merchant_name")
                    ->selectRaw("COALESCE(MAX(CAST(wheninba_MercifulGod.mt_order.payment_type AS CHAR)), '') as payment_type")
                    ->selectRaw('mt_driver_task.order_id as order_id')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.total_w_tax), 0) as order_total')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.delivery_charge), 0) as delivery_fee')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.cart_tip_value), 0) as tip_amount')
                    ->selectRaw('COALESCE(MAX(wheninba_MercifulGod.mt_order.packaging), 0) as cf_amount')
                    ->groupBy('merchant_name', 'mt_driver_task.order_id')
                    ->orderBy('merchant_name')
                    ->orderBy('mt_driver_task.order_id')
                    ->get();

                $grouped = $detailRows->groupBy('merchant_name')->map(function ($rows, $merchantName) use ($date, $driverId) {
                    $orders = collect($rows)->map(function ($row) use ($merchantName) {
                        $orderTotal = (float) ($row->order_total ?? 0);
                        $deliveryFee = (float) ($row->delivery_fee ?? 0);
                        $tipAmount = (float) ($row->tip_amount ?? 0);
                        $cfAmount = (float) ($row->cf_amount ?? 0);

                        $totalRemit = max(0, $orderTotal - $deliveryFee);
                        $gtGrumpy = str_contains(strtolower((string)$merchantName), 'good taste') || str_contains(strtolower((string)$merchantName), 'grumpy') ? max(0, $totalRemit - $cfAmount) : 0;

                        return [
                            'order_id' => (string) ($row->order_id ?? ''),
                            'payment_type' => (string) ($row->payment_type ?? ''),
                            'total_collection' => $orderTotal,
                            'delivery_fee' => $deliveryFee,
                            'tip_amount' => $tipAmount,
                            'gt_grumpy_receipt' => $gtGrumpy,
                            'total_remit' => $totalRemit,
                            'cf_amount' => $cfAmount,
                        ];
                    })->filter(function ($o) { return $o['order_id'] !== ''; })->values()->all();

                    return [
                        'merchant_name' => (string) $merchantName,
                        'orders' => $orders,
                    ];
                })->values();

                $saved = 0;
                foreach ($grouped as $m) {
                    foreach ($m['orders'] as $order) {
                        $ref = $order['order_id'];
                        if ($ref === '') continue;

                        $data = [
                            'rider' => $riderName,
                            'mop' => $order['payment_type'] ?? null,
                            'ref_no' => $ref,
                            'merchant' => $m['merchant_name'],
                            'total_amount' => $order['total_collection'] ?? 0,
                            'df' => $order['delivery_fee'] ?? 0,
                            'gt_grumpy_receipt' => $order['gt_grumpy_receipt'] ?? 0,
                            'tip' => $order['tip_amount'] ?? 0,
                            'receipt_non_partners' => 0,
                            'total_remit' => $order['total_remit'] ?? 0,
                            'cf' => $order['cf_amount'] ?? 0,
                        ];

                        DeliveryBreakdown::updateOrCreate([
                            'ref_no' => $ref,
                        ], $data);

                        $saved++;
                    }
                }

                $this->info("   saved: $saved rows");
            }
        }

        $this->backfillMissingRiderNames($legacy);

        $this->info('Done.');
        return 0;
    }

    private function backfillMissingRiderNames($legacy): void
    {
        try {
            $legacy->statement(
                "UPDATE fm_delivery_breakdowns f
                 JOIN mt_driver_task t ON t.order_id = f.ref_no
                 LEFT JOIN mt_driver d ON d.driver_id = t.driver_id
                 SET f.rider = COALESCE(NULLIF(TRIM(CONCAT_WS(' ', d.first_name, d.last_name)), ''), CONCAT('Driver #', t.driver_id))
                 WHERE f.rider IS NULL OR f.rider = ''"
            );

            $this->info('Backfilled missing rider names in fm_delivery_breakdowns.');
        } catch (\Throwable $e) {
            $this->warn('Unable to backfill missing rider names: ' . $e->getMessage());
        }
    }
}
