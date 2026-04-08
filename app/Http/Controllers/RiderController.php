<?php

namespace App\Http\Controllers;

use App\Models\NonRemittingLog;
use App\Models\Rider;
use App\Models\RiderPayroll;
use App\Models\RiderDeduction;
use App\Models\Remittance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RiderController extends Controller
{
    public function index(Request $request)
    {
        $legacyDb = DB::connection('wibfinance');
        $legacySchema = Schema::connection('wibfinance');

        $riders = $legacyDb->table('mt_driver')
            ->select('driver_id', 'first_name', 'last_name', 'date_created')
            ->whereIn('status', ['active', 'cleared'])
            ->orderByDesc('date_created')
            ->get()
            ->map(function ($driver) {
                $fullName = trim((string) (($driver->first_name ?? '') . ' ' . ($driver->last_name ?? '')));

                return (object) [
                    'id' => $driver->driver_id,
                    'name' => $fullName !== '' ? $fullName : ('Driver #' . $driver->driver_id),
                    'created_at' => $driver->date_created,
                ];
            })
            ->values();
        $payrolls = RiderPayroll::latest()->paginate(10);
        $deductions = RiderDeduction::latest()->paginate(10);
        $deductionsByRider = RiderDeduction::selectRaw('rider_id, rider_name, SUM(amount) as total_amount, COUNT(*) as deduction_count')
            ->groupBy('rider_id', 'rider_name')
            ->orderBy('rider_name')
            ->get();
        $allDeductionsFlat = RiderDeduction::select('rider_id', 'rider_name', 'amount', 'date', 'remarks', 'created_at')
            ->orderBy('rider_name')->orderBy('date', 'desc')
            ->get();
        $remittances = Remittance::with('rider')->latest()->paginate(10);
        $riderRemittanceDateMap = Remittance::query()
            ->select('rider_id', 'remittance_date')
            ->whereNotNull('remittance_date')
            ->get()
            ->groupBy('rider_id')
            ->map(function ($items) {
                return $items->pluck('remittance_date')
                    ->map(function ($date) {
                        return \Carbon\Carbon::parse($date)->toDateString();
                    })
                    ->unique()
                    ->values()
                    ->all();
            })
            ->toArray();

        $riderTaskDeliveriesMap = [];
        if ($legacySchema->hasTable('mt_driver_task')) {
            $driverTaskColumns = $legacySchema->getColumnListing('mt_driver_task');
            $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($driverTaskColumns) {
                return in_array($column, $driverTaskColumns, true);
            });
            $taskKeyColumn = in_array('task_id', $driverTaskColumns, true) ? 'task_id' : null;
            $taskStatsDateParsed = \Carbon\Carbon::parse($request->get('stats_date', today()->toDateString()))->toDateString();

            if ($riderKeyColumn && $taskKeyColumn) {
                $taskQuery = $legacyDb->table('mt_driver_task')
                    ->selectRaw("{$riderKeyColumn} as rider_key, COUNT({$taskKeyColumn}) as total_deliveries")
                    ->whereNotNull($taskKeyColumn)
                    ->groupBy($riderKeyColumn);

                // Scope task counts by selected date using the best available task date column.
                $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                    ->first(function ($column) use ($driverTaskColumns) {
                        return in_array($column, $driverTaskColumns, true);
                    });

                if ($taskDateColumn) {
                    $taskQuery->whereDate($taskDateColumn, $taskStatsDateParsed);
                }

                $riderTaskDeliveriesMap = $taskQuery
                    ->pluck('total_deliveries', 'rider_key')
                    ->map(function ($count) {
                        return (int) $count;
                    })
                    ->toArray();
            }
        }

        // Build delivery charges map from mt_order.delivery_charge joined with mt_driver_task by order_id
        $riderDeliveryChargesMap = [];
        $riderTipsMap = [];
        $riderTotalCollectionMap = [];
        $taskStatsDateParsed = \Carbon\Carbon::parse($request->get('stats_date', today()->toDateString()))->toDateString();
        
        try {
            $driverTaskColumns = $legacySchema->getColumnListing('mt_driver_task');
            $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($driverTaskColumns) {
                return in_array($column, $driverTaskColumns, true);
            });
            
            if ($riderKeyColumn && $legacySchema->hasTable('mt_driver_task')) {
                // Get delivery charges from mt_order (in wibfinance) joined with mt_driver_task by order_id
                // Use raw join for cross-database queries
                $chargeQuery = $legacyDb->table('mt_driver_task')
                    ->selectRaw("mt_driver_task.{$riderKeyColumn} as rider_key, COALESCE(SUM(wibfinance.mt_order.delivery_charge), 0) as total_delivery_charge")
                    ->leftJoin('wibfinance.mt_order', 'mt_driver_task.order_id', '=', 'wibfinance.mt_order.order_id')
                    ->groupBy('mt_driver_task.' . $riderKeyColumn);
                
                // Scope by selected date using delivery_date from mt_driver_task
                $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                    ->first(function ($column) use ($driverTaskColumns) {
                        return in_array($column, $driverTaskColumns, true);
                    });
                
                if ($taskDateColumn) {
                    $chargeQuery->whereDate("mt_driver_task.{$taskDateColumn}", $taskStatsDateParsed);
                }
                
                $riderDeliveryChargesMap = $chargeQuery
                    ->pluck('total_delivery_charge', 'rider_key')
                    ->map(function ($charge) {
                        return (float) $charge;
                    })
                    ->toArray();

                // Get tips from mt_order.cart_tip_value using the same rider/date scope.
                $tipsQuery = $legacyDb->table('mt_driver_task')
                    ->selectRaw("mt_driver_task.{$riderKeyColumn} as rider_key, COALESCE(SUM(wibfinance.mt_order.cart_tip_value), 0) as total_tips")
                    ->leftJoin('wibfinance.mt_order', 'mt_driver_task.order_id', '=', 'wibfinance.mt_order.order_id')
                    ->groupBy('mt_driver_task.' . $riderKeyColumn);

                if ($taskDateColumn) {
                    $tipsQuery->whereDate("mt_driver_task.{$taskDateColumn}", $taskStatsDateParsed);
                }

                $riderTipsMap = $tipsQuery
                    ->pluck('total_tips', 'rider_key')
                    ->map(function ($tips) {
                        return (float) $tips;
                    })
                    ->toArray();

                // Get total order amount from mt_order.total_w_tax using the same rider/date scope.
                try {
                    $totalCollectionQuery = $legacyDb->table('mt_driver_task')
                        ->selectRaw("mt_driver_task.{$riderKeyColumn} as rider_key, COALESCE(SUM(wibfinance.mt_order.total_w_tax), 0) as total_collection")
                        ->leftJoin('wibfinance.mt_order', 'mt_driver_task.order_id', '=', 'wibfinance.mt_order.order_id')
                        ->groupBy('mt_driver_task.' . $riderKeyColumn);

                    if ($taskDateColumn) {
                        $totalCollectionQuery->whereDate("mt_driver_task.{$taskDateColumn}", $taskStatsDateParsed);
                    }

                    $riderTotalCollectionMap = $totalCollectionQuery
                        ->pluck('total_collection', 'rider_key')
                        ->map(function ($collection) {
                            return (float) $collection;
                        })
                        ->toArray();
                } catch (\Exception $e) {
                    // If total order amount cannot be calculated, keep empty map.
                    $riderTotalCollectionMap = [];
                }
            }
        } catch (\Exception $e) {
            // If delivery charges cannot be calculated, fall back to empty map
            $riderDeliveryChargesMap = [];
            $riderTipsMap = [];
            $riderTotalCollectionMap = [];
        }

        // Calculate counts and collections — scoped to selected date (default: today)
        $statsDate = $request->get('stats_date', today()->toDateString());
        $statsDateParsed = \Carbon\Carbon::parse($statsDate)->toDateString();

        // Non-Remitting count:
        // - Today (day not yet over) → 0
        // - Past dates → count riders who existed on that date and had no remittance record
        $isToday = $statsDateParsed === \Carbon\Carbon::today()->toDateString();
        if ($isToday) {
            $nonRemittingRiderCount = 0;
        } else {
            $remittedOnDate = Remittance::whereDate('remittance_date', $statsDateParsed)
                ->pluck('rider_id')->unique()->toArray();
            $nonRemittingRiderCount = $legacyDb->table('mt_driver')
                ->whereIn('status', ['active', 'cleared'])
                ->whereDate('date_created', '<=', $statsDateParsed)
                ->whereNotIn('driver_id', $remittedOnDate)
                ->count();
        }

        $yesterday  = \Carbon\Carbon::yesterday()->toDateString();
        $today      = \Carbon\Carbon::today()->toDateString();
        $isViewingToday = ($statsDateParsed === $today);

        // "No Remit Yesterday" block is only relevant when viewing today's queue.
        // On past dates there is no concept of a live warning — hide it entirely.
        if ($isViewingToday) {
            // A rider shows "No Remit Yesterday" if they existed before today,
            // had deliveries yesterday, did NOT submit a remittance yesterday,
            // and have NOT yet settled today.
            // This check is based purely on remittance records so it works
            // regardless of whether the nightly scheduler has run.
            $remittedYesterdayIds = Remittance::whereDate('remittance_date', $yesterday)
                ->pluck('rider_id')
                ->unique()
                ->toArray();
            $remittedTodayIds = Remittance::whereDate('remittance_date', $today)
                ->pluck('rider_id')
                ->unique()
                ->toArray();

            $ridersWithDeliveriesYesterday = [];
            if ($legacySchema->hasTable('mt_driver_task')) {
                $driverTaskColumns = $legacySchema->getColumnListing('mt_driver_task');
                $riderKeyColumn = collect(['driver_id', 'rider_id'])->first(function ($column) use ($driverTaskColumns) {
                    return in_array($column, $driverTaskColumns, true);
                });
                $taskKeyColumn = in_array('task_id', $driverTaskColumns, true) ? 'task_id' : null;
                $taskDateColumn = collect(['delivery_date', 'date_created', 'created_at', 'date_added'])
                    ->first(function ($column) use ($driverTaskColumns) {
                        return in_array($column, $driverTaskColumns, true);
                    });

                if ($riderKeyColumn && $taskKeyColumn && $taskDateColumn) {
                    $ridersWithDeliveriesYesterday = $legacyDb->table('mt_driver_task')
                        ->selectRaw("{$riderKeyColumn} as rider_key, COUNT({$taskKeyColumn}) as total_deliveries")
                        ->whereNotNull($taskKeyColumn)
                        ->whereDate($taskDateColumn, $yesterday)
                        ->groupBy($riderKeyColumn)
                        ->havingRaw("COUNT({$taskKeyColumn}) > 0")
                        ->pluck('rider_key')
                        ->map(function ($riderId) {
                            return (int) $riderId;
                        })
                        ->toArray();
                }
            }

            $blockedRiderIds = $legacyDb->table('mt_driver')
                ->whereIn('status', ['active', 'cleared'])
                ->whereDate('date_created', '<', \Carbon\Carbon::today())
                ->when(!empty($ridersWithDeliveriesYesterday), function ($query) use ($ridersWithDeliveriesYesterday) {
                    $query->whereIn('driver_id', $ridersWithDeliveriesYesterday);
                }, function ($query) {
                    // If there are no deliveries yesterday, nobody should be blocked.
                    $query->whereRaw('1 = 0');
                })
                ->whereNotIn('driver_id', $remittedYesterdayIds)
                ->whereNotIn('driver_id', $remittedTodayIds)
                ->pluck('driver_id')
                ->toArray();
        } else {
            $blockedRiderIds = [];
        }

        // Cleared badge only shows on past dates — today's queue always stays
        // Pending until the day ends and you view it the next day.
        if ($isViewingToday) {
            $clearedRiderIds = [];
        } else {
            $clearedRiderIds = Remittance::whereDate('remittance_date', $statsDateParsed)
                ->pluck('rider_id')
                ->unique()
                ->toArray();
        }

        $clearedCount = Remittance::whereDate('remittance_date', $statsDateParsed)
            ->where('status', 'confirmed')
            ->count();

        $remittedTotalsByRider = Remittance::query()
            ->whereDate('remittance_date', $statsDateParsed)
            ->selectRaw('rider_id, COALESCE(SUM(total_remit), 0) as total_remitted')
            ->groupBy('rider_id')
            ->pluck('total_remitted', 'rider_id')
            ->map(function ($amount) {
                return (float) $amount;
            })
            ->toArray();

        $remittedRiderIds = collect($riderTotalCollectionMap)
            ->filter(function ($expectedTotal, $riderId) use ($remittedTotalsByRider) {
                $expected = (float) $expectedTotal;
                $remitted = (float) ($remittedTotalsByRider[$riderId] ?? 0);
                return $expected > 0 && $remitted + 0.0001 >= $expected;
            })
            ->keys()
            ->map(function ($id) {
                return (int) $id;
            })
            ->values()
            ->all();

        $shortRiderIds = collect($riderTotalCollectionMap)
            ->filter(function ($expectedTotal, $riderId) use ($remittedTotalsByRider) {
                $expected = (float) $expectedTotal;
                $remitted = (float) ($remittedTotalsByRider[$riderId] ?? 0);
                return $expected > 0 && $remitted > 0 && $remitted + 0.0001 < $expected;
            })
            ->keys()
            ->map(function ($id) {
                return (int) $id;
            })
            ->values()
            ->all();
        $cashCollection = Remittance::whereDate('remittance_date', $statsDateParsed)
            ->where('mode_of_payment', 'cash')
            ->sum('total_collection');
        $digitalCollection = Remittance::whereDate('remittance_date', $statsDateParsed)
            ->whereIn('mode_of_payment', ['bank', 'gcash'])
            ->sum('total_collection');

        // Handle AJAX requests for pagination
        if ($request->ajax()) {
            $type = $request->get('type', 'remittances');

            // Handle Payroll Pagination
            if ($type === 'payroll') {
                $tableRows = '';
                foreach ($payrolls as $payroll) {
                    $paymentBadgeStyle = $payroll->mode_of_payment === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;';

                    $tableRows .= '<tr class="payroll-row">';
                    $tableRows .= '<td><strong>' . htmlspecialchars($payroll->rider_id) . '</strong></td>';
                    $tableRows .= '<td>' . htmlspecialchars($payroll->rider_name) . '</td>';
                    $tableRows .= '<td>₱' . number_format($payroll->base_salary, 2) . '</td>';
                    $tableRows .= '<td>₱' . number_format($payroll->incentives ?? 0, 2) . '</td>';
                    $tableRows .= '<td>₱' . number_format($payroll->renumeration_26_days ?? 0, 2) . '</td>';
                    $tableRows .= '<td>₱' . number_format($payroll->adda_df ?? 0, 2) . '</td>';
                    $tableRows .= '<td>' . ($payroll->adda_df_date ? \Carbon\Carbon::parse($payroll->adda_df_date)->format('M d, Y') : 'N/A') . '</td>';
                    $tableRows .= '<td><strong style="color: #436026;">₱' . number_format($payroll->net_salary, 2) . '</strong></td>';
                    $tableRows .= '<td>' . htmlspecialchars($payroll->salary_schedule) . '</td>';
                    $tableRows .= '<td><span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; ' . $paymentBadgeStyle . '">' . strtoupper($payroll->mode_of_payment) . '</span></td>';
                    $tableRows .= '<td>' . $payroll->created_at->format('M d, Y') . '</td>';
                    $tableRows .= '</tr>';
                }

                $paginationHtml = $this->generatePaginationHtml($payrolls, 'payroll');

                return response()->json([
                    'success' => true,
                    'tableRows' => $tableRows,
                    'pagination' => $paginationHtml
                ]);
            }

            // Handle Deductions Pagination
            if ($type === 'deductions') {
                $tableRows = '';
                foreach ($deductions as $deduction) {
                    $remarks = $deduction->remarks ?? 'N/A';

                    $tableRows .= '<tr class="deduction-row">';
                    $tableRows .= '<td><strong>' . htmlspecialchars($deduction->rider_id) . '</strong></td>';
                    $tableRows .= '<td>' . htmlspecialchars($deduction->rider_name) . '</td>';
                    $tableRows .= '<td><strong style="color: #dc3545;">- ₱' . number_format($deduction->amount, 2) . '</strong></td>';
                    $tableRows .= '<td>' . \Carbon\Carbon::parse($deduction->date)->format('M d, Y') . '</td>';
                    $tableRows .= '<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . htmlspecialchars($remarks) . '</td>';
                    $tableRows .= '<td>' . $deduction->created_at->format('M d, Y h:i A') . '</td>';
                    $tableRows .= '</tr>';
                }

                $paginationHtml = $this->generatePaginationHtml($deductions, 'deductions');

                return response()->json([
                    'success' => true,
                    'tableRows' => $tableRows,
                    'pagination' => $paginationHtml
                ]);
            }

            // Handle Remittances Pagination (default)
            $tableRows = '';
            foreach ($remittances as $remittance) {
                $riderName = $remittance->rider->name ?? 'N/A';
                $paymentBadgeStyle = $remittance->mode_of_payment === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;';
                $statusClass = $remittance->status === 'confirmed' ? 'cleared' : $remittance->status;
                $statusText = $remittance->status === 'confirmed' ? 'Cleared' : ucfirst($remittance->status);
                $remarks = $remittance->remarks ? '<span style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . htmlspecialchars($remittance->remarks) . '">' . htmlspecialchars($remittance->remarks) . '</span>' : '<span style="color: #999; font-style: italic;">No remarks</span>';

                $tableRows .= '<tr>';
                $tableRows .= '<td><strong>' . htmlspecialchars($riderName) . '</strong></td>';
                $tableRows .= '<td style="text-align: center; font-weight: 600; color: #436026;">' . $remittance->total_deliveries . '</td>';
                $tableRows .= '<td style="text-align: right;">₱' . number_format($remittance->total_delivery_fee, 2) . '</td>';
                $tableRows .= '<td style="text-align: right; font-weight: 600; color: #28a745;">₱' . number_format($remittance->total_remit, 2) . '</td>';
                $tableRows .= '<td style="text-align: right;">₱' . number_format($remittance->total_tips ?? 0, 2) . '</td>';
                $tableRows .= '<td style="text-align: right; font-weight: 600; color: #007bff;">₱' . number_format($remittance->total_collection, 2) . '</td>';
                $tableRows .= '<td style="text-align: center;"><span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; ' . $paymentBadgeStyle . '">' . strtoupper($remittance->mode_of_payment) . '</span></td>';
                $tableRows .= '<td style="text-align: center;"><span class="rider-status ' . $statusClass . '">' . $statusText . '</span></td>';
                $tableRows .= '<td>' . $remittance->created_at->format('M d, Y') . '</td>';
                $tableRows .= '<td style="max-width: 250px;">' . $remarks . '</td>';
                $tableRows .= '</tr>';
            }

            $paginationHtml = $this->generatePaginationHtml($remittances, 'remittances');

            return response()->json([
                'success' => true,
                'tableRows' => $tableRows,
                'pagination' => $paginationHtml
            ]);
        }

        $merchants = $legacyDb->table('mt_merchant')
            ->selectRaw('restaurant_name as name')
            ->whereNotNull('restaurant_name')
            ->whereRaw("TRIM(restaurant_name) <> ''")
            ->orderBy('restaurant_name')
            ->get();

        return view('remittance', compact('riders', 'payrolls', 'deductions', 'deductionsByRider', 'allDeductionsFlat', 'remittances', 'nonRemittingRiderCount', 'clearedCount', 'cashCollection', 'digitalCollection', 'statsDate', 'statsDateParsed', 'blockedRiderIds', 'clearedRiderIds', 'remittedRiderIds', 'shortRiderIds', 'remittedTotalsByRider', 'riderRemittanceDateMap', 'riderTaskDeliveriesMap', 'riderDeliveryChargesMap', 'riderTipsMap', 'riderTotalCollectionMap', 'merchants'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'nullable|in:pending,cleared',
            ]);

            $incomingName = trim((string) $request->name);
            $nameExists = Rider::query()
                ->whereRaw("TRIM(CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, ''))) = ?", [$incomingName])
                ->exists();

            if ($nameExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => ['name' => ['The name has already been taken.']]
                ], 422);
            }
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

        $name = trim((string) $request->name);
        [$firstName, $lastName] = array_pad(preg_split('/\s+/', $name, 2), 2, '');
        $nextDriverId = ((int) Rider::max('driver_id')) + 1;

        $rider = Rider::create([
            'driver_id' => $nextDriverId,
            'user_type' => 'rider',
            'user_id' => 0,
            'on_duty' => 1,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => '',
            'phone' => '',
            'username' => '',
            'password' => '',
            'team_id' => 0,
            'transport_type_id' => '',
            'transport_description' => '',
            'licence_plate' => '',
            'color' => '',
            'status' => $request->status ?? 'pending',
            'date_created' => now(),
            'date_modified' => now(),
            'last_login' => now(),
            'last_online' => 0,
            'location_lat' => '',
            'location_lng' => '',
            'ip_address' => '',
            'forgot_pass_code' => '0',
            'token' => '',
            'device_platform' => 'Android',
            'enabled_push' => 1,
            'profile_photo' => '',
            'is_signup' => 2,
            'app_version' => '',
            'last_onduty' => '',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rider added successfully!',
            'rider' => $rider
        ]);
    }

    public function update(Request $request, Rider $rider)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'status' => 'required|in:pending,cleared',
            ]);

            $incomingName = trim((string) $request->name);
            $nameExists = Rider::query()
                ->where('driver_id', '!=', $rider->driver_id)
                ->whereRaw("TRIM(CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, ''))) = ?", [$incomingName])
                ->exists();

            if ($nameExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => ['name' => ['The name has already been taken.']]
                ], 422);
            }
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

        $name = trim((string) $request->name);
        [$firstName, $lastName] = array_pad(preg_split('/\s+/', $name, 2), 2, '');

        $rider->update([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'status' => $request->status,
            'date_modified' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rider updated successfully!',
            'rider' => $rider
        ]);
    }

    public function destroy(Rider $rider)
    {
        $rider->delete();

        return response()->json([
            'success' => true,
            'message' => 'Rider deleted successfully!'
        ]);
    }

    private function generatePaginationHtml($paginator, $type)
    {
        $paginationHtml = '<div style="color: #666; font-size: 14px;">Showing ' . $paginator->firstItem() . ' to ' . $paginator->lastItem() . ' of ' . $paginator->total() . ' entries</div>';
        $paginationHtml .= '<div style="display: flex; gap: 5px;">';

        // Previous button
        if ($paginator->onFirstPage()) {
            $paginationHtml .= '<button disabled style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;"><i class="fas fa-chevron-left"></i> Previous</button>';
        } else {
            $url = $paginator->previousPageUrl() . '&type=' . $type;
            $paginationHtml .= '<a href="' . $url . '" class="pagination-link-' . $type . '" data-page="' . ($paginator->currentPage() - 1) . '" style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.transform=\'translateY(-1px)\'; this.style.boxShadow=\'0 4px 8px rgba(67, 96, 38, 0.3)\'" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'none\'"><i class="fas fa-chevron-left"></i> Previous</a>';
        }

        // Page numbers
        foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url) {
            $url = $url . '&type=' . $type;
            if ($page == $paginator->currentPage()) {
                $paginationHtml .= '<button disabled style="padding: 8px 14px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: default; font-size: 13px; font-weight: 700; min-width: 40px;">' . $page . '</button>';
            } else {
                $paginationHtml .= '<a href="' . $url . '" class="pagination-link-' . $type . '" data-page="' . $page . '" style="padding: 8px 14px; background: #f8f9fa; color: #436026; border: 1px solid #dee2e6; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; min-width: 40px; text-align: center; transition: all 0.2s;" onmouseover="this.style.background=\'#e9ecef\'; this.style.borderColor=\'#436026\'" onmouseout="this.style.background=\'#f8f9fa\'; this.style.borderColor=\'#dee2e6\'">' . $page . '</a>';
            }
        }

        // Next button
        if ($paginator->hasMorePages()) {
            $url = $paginator->nextPageUrl() . '&type=' . $type;
            $paginationHtml .= '<a href="' . $url . '" class="pagination-link-' . $type . '" data-page="' . ($paginator->currentPage() + 1) . '" style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;" onmouseover="this.style.transform=\'translateY(-1px)\'; this.style.boxShadow=\'0 4px 8px rgba(67, 96, 38, 0.3)\'" onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'none\'">Next <i class="fas fa-chevron-right"></i></a>';
        } else {
            $paginationHtml .= '<button disabled style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">Next <i class="fas fa-chevron-right"></i></button>';
        }

        $paginationHtml .= '</div>';

        return $paginationHtml;
    }
}
