<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\RemittanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiderPayrollController;
use App\Http\Controllers\RiderDeductionController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FinancialRequestController;
use App\Models\AuditLog;


// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/email/verify/{id}/{hash}', [ProfileController::class, 'verifyEmail'])->name('verification.verify');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 2FA Challenge Routes (unauthenticated, but session-gated)
Route::get('/2fa/challenge', [AuthController::class, 'show2faChallenge'])->name('2fa.challenge');
Route::post('/2fa/verify', [AuthController::class, 'verify2fa'])->name('2fa.verify');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/check-email', [AuthController::class, 'showCheckEmailForm'])->name('password.check');
Route::post('/verify-pin', [AuthController::class, 'verifyPin'])->name('password.verifyPin');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes (Require Authentication)
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::middleware('page.access:dashboard')->group(function () {
    Route::get('/dashboard', function () {
        $totalCollections = \App\Models\Remittance::sum('total_collection');
        $totalDiscrepancies = \App\Models\BankDepositConfirmation::sum('discrepancy');

        // Build monthly order counts per year from mt_order.order_id
        $currentYear = (int) date('Y');
        $chartYears  = [$currentYear, $currentYear - 1, $currentYear - 2];
        $orderColumns = collect(\Illuminate\Support\Facades\Schema::connection('wheninba_MercifulGod')->getColumnListing('mt_order'))
            ->map(fn ($column) => strtolower((string) $column));

        $orderDateColumn = collect(['order_date', 'date_created', 'created_at', 'date_added', 'delivery_date', 'date_modified'])
            ->first(fn ($column) => $orderColumns->contains(strtolower($column)));

        $rawMonthly = collect();
        if ($orderDateColumn && $orderColumns->contains('order_id')) {
            $rawMonthly = collect($chartYears)->flatMap(function ($year) use ($orderDateColumn) {
                return \Illuminate\Support\Facades\DB::connection('wheninba_MercifulGod')->table('mt_order')
                    ->selectRaw("YEAR({$orderDateColumn}) as yr, MONTH({$orderDateColumn}) as mo, COUNT(DISTINCT order_id) as total")
                    ->whereYear($orderDateColumn, $year)
                    ->whereNotNull('order_id')
                    ->groupByRaw("YEAR({$orderDateColumn}), MONTH({$orderDateColumn})")
                    ->get();
            });
        }

        $monthlyOrders = [];
        foreach ($chartYears as $yr) {
            $monthlyOrders[$yr] = array_fill(0, 12, 0);
        }
        foreach ($rawMonthly as $row) {
            $monthlyOrders[(int)$row->yr][(int)$row->mo - 1] = (int) $row->total;
        }

        $salesTrendSeries = [
            'daily' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'partners' => array_fill(0, 7, 0),
                'nonPartners' => array_fill(0, 7, 0),
                'goodTaste' => array_fill(0, 7, 0),
            ],
            'weekly' => [
                'labels' => [],
                'partners' => [],
                'nonPartners' => [],
                'goodTaste' => [],
            ],
            'monthly' => [
                'labels' => [],
                'partners' => [],
                'nonPartners' => [],
                'goodTaste' => [],
            ],
            'annually' => [
                'labels' => [],
                'partners' => [],
                'nonPartners' => [],
                'goodTaste' => [],
            ],
        ];

        try {
            $db = DB::connection('wheninba_MercifulGod');
            $orderTable = 'mt_order';
            $merchantTable = 'mt_merchant';

            $orderColumns = collect(Schema::connection('wheninba_MercifulGod')->getColumnListing($orderTable))
                ->map(fn ($column) => strtolower((string) $column));
            $merchantColumns = collect(Schema::connection('wheninba_MercifulGod')->getColumnListing($merchantTable))
                ->map(fn ($column) => strtolower((string) $column));

            $orderDateColumn = collect(['order_date', 'date_created', 'created_at', 'date_added', 'delivery_date', 'date_modified'])
                ->first(fn ($column) => $orderColumns->contains(strtolower($column)));
            $earningsColumn = collect(['merchant_earnings', 'merchant_earning'])
                ->first(fn ($column) => $orderColumns->contains(strtolower($column)));
            $merchantTypeColumn = collect(['partner_type', 'merchant_type', 'type'])
                ->first(fn ($column) => $merchantColumns->contains(strtolower($column)));
            $merchantNameColumn = collect(['restaurant_name', 'name'])
                ->first(fn ($column) => $merchantColumns->contains(strtolower($column)));
            $goodTasteMerchantName = 'the original good taste restaurant';

            if ($orderDateColumn && $earningsColumn && $merchantTypeColumn && $merchantNameColumn && $orderColumns->contains('merchant_id') && $merchantColumns->contains('merchant_id')) {
                $normalizeType = static function (?string $value): string {
                    $normalized = strtolower(trim((string) $value));
                    $normalized = str_replace(['_', ' '], '-', $normalized);

                    if ($normalized === 'nonpartner') {
                        return 'non-partner';
                    }

                    return $normalized === 'partner' ? 'partner' : 'non-partner';
                };

                $today = now()->startOfDay();

                $dailyBuckets = collect(range(6, 0))->map(fn ($offset) => $today->copy()->subDays($offset));
                $salesTrendSeries['daily']['labels'] = $dailyBuckets->map(fn ($d) => $d->format('D'))->values()->all();

                $dailyRaw = $db->table("{$orderTable} as o")
                    ->join("{$merchantTable} as m", 'm.merchant_id', '=', 'o.merchant_id')
                    ->selectRaw("DATE(o.{$orderDateColumn}) as bucket_date, m.{$merchantTypeColumn} as merchant_type, m.{$merchantNameColumn} as merchant_name, COALESCE(SUM(o.{$earningsColumn}), 0) as total_sales")
                    ->whereDate("o.{$orderDateColumn}", '>=', $dailyBuckets->first()->toDateString())
                    ->whereDate("o.{$orderDateColumn}", '<=', $today->toDateString())
                    ->whereNotNull('o.merchant_id')
                    ->groupByRaw("DATE(o.{$orderDateColumn}), m.{$merchantTypeColumn}, m.{$merchantNameColumn}")
                    ->get();

                $dailyPartner = array_fill(0, 7, 0);
                $dailyNonPartner = array_fill(0, 7, 0);
                $dailyGoodTaste = array_fill(0, 7, 0);
                $dailyIndex = $dailyBuckets->mapWithKeys(fn ($d, $i) => [$d->toDateString() => $i]);

                foreach ($dailyRaw as $row) {
                    $dateKey = (string) ($row->bucket_date ?? '');
                    if (!isset($dailyIndex[$dateKey])) {
                        continue;
                    }

                    $index = (int) $dailyIndex[$dateKey];
                    $bucketType = $normalizeType($row->merchant_type ?? null);
                    $amount = (float) ($row->total_sales ?? 0);
                    $merchantName = strtolower(trim((string) ($row->merchant_name ?? '')));

                    if ($bucketType === 'partner') {
                        $dailyPartner[$index] += $amount;
                    } else {
                        $dailyNonPartner[$index] += $amount;
                    }

                    if ($merchantName === $goodTasteMerchantName) {
                        $dailyGoodTaste[$index] += $amount;
                    }
                }

                $salesTrendSeries['daily']['partners'] = $dailyPartner;
                $salesTrendSeries['daily']['nonPartners'] = $dailyNonPartner;
                $salesTrendSeries['daily']['goodTaste'] = $dailyGoodTaste;

                $weeklyBuckets = collect(range(7, 0))->map(fn ($offset) => $today->copy()->startOfWeek()->subWeeks($offset));
                $weeklyStart = $weeklyBuckets->first()->toDateString();

                $salesTrendSeries['weekly']['labels'] = $weeklyBuckets
                    ->map(fn ($d) => 'Wk ' . $d->format('W'))
                    ->values()
                    ->all();

                $weeklyRaw = $db->table("{$orderTable} as o")
                    ->join("{$merchantTable} as m", 'm.merchant_id', '=', 'o.merchant_id')
                    ->selectRaw("YEARWEEK(o.{$orderDateColumn}, 1) as bucket_week, m.{$merchantTypeColumn} as merchant_type, m.{$merchantNameColumn} as merchant_name, COALESCE(SUM(o.{$earningsColumn}), 0) as total_sales")
                    ->whereDate("o.{$orderDateColumn}", '>=', $weeklyStart)
                    ->whereDate("o.{$orderDateColumn}", '<=', $today->toDateString())
                    ->whereNotNull('o.merchant_id')
                    ->groupByRaw("YEARWEEK(o.{$orderDateColumn}, 1), m.{$merchantTypeColumn}, m.{$merchantNameColumn}")
                    ->get();

                $weeklyPartner = array_fill(0, $weeklyBuckets->count(), 0);
                $weeklyNonPartner = array_fill(0, $weeklyBuckets->count(), 0);
                $weeklyGoodTaste = array_fill(0, $weeklyBuckets->count(), 0);
                $weeklyIndex = $weeklyBuckets->mapWithKeys(fn ($d, $i) => [(int) $d->format('oW') => $i]);

                foreach ($weeklyRaw as $row) {
                    $bucketWeek = (int) ($row->bucket_week ?? 0);
                    if (!isset($weeklyIndex[$bucketWeek])) {
                        continue;
                    }

                    $index = (int) $weeklyIndex[$bucketWeek];
                    $bucketType = $normalizeType($row->merchant_type ?? null);
                    $amount = (float) ($row->total_sales ?? 0);
                    $merchantName = strtolower(trim((string) ($row->merchant_name ?? '')));

                    if ($bucketType === 'partner') {
                        $weeklyPartner[$index] += $amount;
                    } else {
                        $weeklyNonPartner[$index] += $amount;
                    }

                    if ($merchantName === $goodTasteMerchantName) {
                        $weeklyGoodTaste[$index] += $amount;
                    }
                }

                $salesTrendSeries['weekly']['partners'] = $weeklyPartner;
                $salesTrendSeries['weekly']['nonPartners'] = $weeklyNonPartner;
                $salesTrendSeries['weekly']['goodTaste'] = $weeklyGoodTaste;

                $monthlyBuckets = collect(range(11, 0))->map(fn ($offset) => $today->copy()->startOfMonth()->subMonths($offset));
                $monthlyStart = $monthlyBuckets->first()->toDateString();

                $salesTrendSeries['monthly']['labels'] = $monthlyBuckets
                    ->map(fn ($d) => $d->format('M'))
                    ->values()
                    ->all();

                $monthlyRaw = $db->table("{$orderTable} as o")
                    ->join("{$merchantTable} as m", 'm.merchant_id', '=', 'o.merchant_id')
                    ->selectRaw("DATE_FORMAT(o.{$orderDateColumn}, '%Y-%m') as bucket_month, m.{$merchantTypeColumn} as merchant_type, m.{$merchantNameColumn} as merchant_name, COALESCE(SUM(o.{$earningsColumn}), 0) as total_sales")
                    ->whereDate("o.{$orderDateColumn}", '>=', $monthlyStart)
                    ->whereDate("o.{$orderDateColumn}", '<=', $today->toDateString())
                    ->whereNotNull('o.merchant_id')
                    ->groupByRaw("DATE_FORMAT(o.{$orderDateColumn}, '%Y-%m'), m.{$merchantTypeColumn}, m.{$merchantNameColumn}")
                    ->get();

                $monthlyPartner = array_fill(0, $monthlyBuckets->count(), 0);
                $monthlyNonPartner = array_fill(0, $monthlyBuckets->count(), 0);
                $monthlyGoodTaste = array_fill(0, $monthlyBuckets->count(), 0);
                $monthlyIndex = $monthlyBuckets->mapWithKeys(fn ($d, $i) => [$d->format('Y-m') => $i]);

                foreach ($monthlyRaw as $row) {
                    $bucketMonth = (string) ($row->bucket_month ?? '');
                    if (!isset($monthlyIndex[$bucketMonth])) {
                        continue;
                    }

                    $index = (int) $monthlyIndex[$bucketMonth];
                    $bucketType = $normalizeType($row->merchant_type ?? null);
                    $amount = (float) ($row->total_sales ?? 0);
                    $merchantName = strtolower(trim((string) ($row->merchant_name ?? '')));

                    if ($bucketType === 'partner') {
                        $monthlyPartner[$index] += $amount;
                    } else {
                        $monthlyNonPartner[$index] += $amount;
                    }

                    if ($merchantName === $goodTasteMerchantName) {
                        $monthlyGoodTaste[$index] += $amount;
                    }
                }

                $salesTrendSeries['monthly']['partners'] = $monthlyPartner;
                $salesTrendSeries['monthly']['nonPartners'] = $monthlyNonPartner;
                $salesTrendSeries['monthly']['goodTaste'] = $monthlyGoodTaste;

                $annualYears = range(((int) $today->format('Y')) - 5, (int) $today->format('Y'));
                $salesTrendSeries['annually']['labels'] = array_map(static fn ($year) => (string) $year, $annualYears);

                $annualRaw = $db->table("{$orderTable} as o")
                    ->join("{$merchantTable} as m", 'm.merchant_id', '=', 'o.merchant_id')
                    ->selectRaw("YEAR(o.{$orderDateColumn}) as bucket_year, m.{$merchantTypeColumn} as merchant_type, m.{$merchantNameColumn} as merchant_name, COALESCE(SUM(o.{$earningsColumn}), 0) as total_sales")
                    ->whereYear("o.{$orderDateColumn}", '>=', $annualYears[0])
                    ->whereYear("o.{$orderDateColumn}", '<=', $annualYears[count($annualYears) - 1])
                    ->whereNotNull('o.merchant_id')
                    ->groupByRaw("YEAR(o.{$orderDateColumn}), m.{$merchantTypeColumn}, m.{$merchantNameColumn}")
                    ->get();

                $annualPartner = array_fill(0, count($annualYears), 0);
                $annualNonPartner = array_fill(0, count($annualYears), 0);
                $annualGoodTaste = array_fill(0, count($annualYears), 0);
                $annualIndex = collect($annualYears)->values()->mapWithKeys(fn ($year, $i) => [(int) $year => $i]);

                foreach ($annualRaw as $row) {
                    $bucketYear = (int) ($row->bucket_year ?? 0);
                    if (!isset($annualIndex[$bucketYear])) {
                        continue;
                    }

                    $index = (int) $annualIndex[$bucketYear];
                    $bucketType = $normalizeType($row->merchant_type ?? null);
                    $amount = (float) ($row->total_sales ?? 0);
                    $merchantName = strtolower(trim((string) ($row->merchant_name ?? '')));

                    if ($bucketType === 'partner') {
                        $annualPartner[$index] += $amount;
                    } else {
                        $annualNonPartner[$index] += $amount;
                    }

                    if ($merchantName === $goodTasteMerchantName) {
                        $annualGoodTaste[$index] += $amount;
                    }
                }

                $salesTrendSeries['annually']['partners'] = $annualPartner;
                $salesTrendSeries['annually']['nonPartners'] = $annualNonPartner;
                $salesTrendSeries['annually']['goodTaste'] = $annualGoodTaste;
            }
        } catch (\Throwable $exception) {
            // Keep zeroed fallbacks so dashboard remains available even if source table changes.
        }

        return view('dashboard', compact('totalCollections', 'totalDiscrepancies', 'monthlyOrders', 'chartYears', 'salesTrendSeries'));
    })->name('dashboard');
    });

    Route::post('/force-password-change', [AuthController::class, 'forcePasswordChange'])->name('force.password.change');
    Route::get('/notifications/price-updates', [MerchantController::class, 'priceNotificationsFeed'])->name('notifications.price-updates');

    Route::middleware('page.access:remittance')->group(function () {
        Route::get('/remittance', [RiderController::class, 'index'])->name('remittance');
        Route::post('/riders', [RiderController::class, 'store'])->name('riders.store');
        Route::put('/riders/{rider}', [RiderController::class, 'update'])->name('riders.update');
        Route::delete('/riders/{rider}', [RiderController::class, 'destroy'])->name('riders.destroy');

        // Remittance Routes
        Route::post('/remittances', [RemittanceController::class, 'store'])->name('remittances.store');
        Route::post('/rider-payroll', [RiderPayrollController::class, 'store'])->name('rider-payroll.store');
        Route::get('/rider-payroll/{id}/payslip', [RiderPayrollController::class, 'payslip'])->name('rider-payroll.payslip');
        Route::post('/rider-deductions', [RiderDeductionController::class, 'store'])->name('rider-deductions.store');
        Route::get('/remittances', [RemittanceController::class, 'index'])->name('remittances.index');
        Route::get('/remittances/{remittance}', [RemittanceController::class, 'show'])->name('remittances.show');
        Route::put('/remittances/{remittance}', [RemittanceController::class, 'update'])->name('remittances.update');
        Route::delete('/remittances/{remittance}', [RemittanceController::class, 'destroy'])->name('remittances.destroy');
        Route::get('/riders/{rider}/delivery-breakdown', [RemittanceController::class, 'getRiderDeliveryBreakdown'])->name('riders.delivery-breakdown');
        Route::get('/riders/{rider}/remittances', [RemittanceController::class, 'getRiderRemittances'])->name('riders.remittances');
        Route::get('/remittances/{remittance}/merchant-breakdown', [RemittanceController::class, 'getRemittanceMerchantBreakdown'])->name('remittances.merchant-breakdown');
        Route::get('/remittances-report', [RemittanceController::class, 'report'])->name('remittances.report');

    // Non-remitting riders lookup (used by the stat card modal)
    Route::get('/non-remitting-riders', function (\Illuminate\Http\Request $request) {
        $date = $request->get('date', today()->toDateString());
        $isToday = $date === \Carbon\Carbon::today()->toDateString();

        if ($isToday) {
            $allRiders = \App\Models\Rider::whereIn('status', ['active', 'cleared'])
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();
            $remittances = \App\Models\Remittance::whereDate('remittance_date', $date)
                ->get(['rider_id', 'remittance_date', 'created_at']);

            $remittanceMap = $remittances->keyBy('rider_id');

            $rows = $allRiders->map(function ($r) use ($remittanceMap, $date) {
                $remittance = $remittanceMap->get($r->id);
                if ($remittance) {
                    $remitDate = \Carbon\Carbon::parse($remittance->remittance_date)->startOfDay();
                    $submittedDate = \Carbon\Carbon::parse($remittance->created_at)->startOfDay();
                    $lateDays = $submittedDate->diffInDays($remitDate, false);
                    $isLate = $lateDays < 0; // submitted after remittance date

                    return [
                        'rider_name' => $r->name,
                        'status'     => 'cleared',
                        'is_late'    => $isLate,
                        'late_days'  => $isLate ? abs($lateDays) : 0,
                        'submitted_date' => $remittance->created_at,
                    ];
                }
                return [
                    'rider_name' => $r->name,
                    'status'     => 'pending',
                    'is_late'    => false,
                    'late_days'  => 0,
                    'submitted_date' => null,
                ];
            })->values()->toArray();
        } else {
            // For past dates, check the remittances table directly so it works
            // for ALL dates — not just ones where the scheduler has run.
            $remittances = \App\Models\Remittance::whereDate('remittance_date', $date)
                ->get(['rider_id', 'remittance_date', 'created_at']);

            $remittanceMap = $remittances->keyBy('rider_id');

            $allRiders = \App\Models\Rider::whereIn('status', ['active', 'cleared'])
                ->whereDate('date_created', '<=', $date)
                ->orderBy('first_name')
                ->orderBy('last_name')
                ->get();

            $rows = $allRiders->map(function ($r) use ($remittanceMap, $date) {
                $remittance = $remittanceMap->get($r->id);
                if ($remittance) {
                    $remitDate = \Carbon\Carbon::parse($remittance->remittance_date)->startOfDay();
                    $submittedDate = \Carbon\Carbon::parse($remittance->created_at)->startOfDay();
                    $lateDays = $submittedDate->diffInDays($remitDate, false);
                    $isLate = $lateDays < 0; // submitted after remittance date

                    return [
                        'rider_name' => $r->name,
                        'status'     => 'cleared',
                        'is_late'    => $isLate,
                        'late_days'  => $isLate ? abs($lateDays) : 0,
                        'submitted_date' => $remittance->created_at,
                    ];
                }
                return [
                    'rider_name' => $r->name,
                    'status'     => 'no_duty',
                    'is_late'    => false,
                    'late_days'  => 0,
                    'submitted_date' => null,
                ];
            })->values()->toArray();
        }

        return response()->json([
            'success'  => true,
            'date'     => $date,
            'is_today' => $isToday,
            'riders'   => $rows,
        ]);
        })->name('non-remitting-riders');
    });

    Route::middleware('page.access:bank-deposit')->group(function () {
    Route::get('/bank-deposit', function (\Illuminate\Http\Request $request) {
        // Determine the date to filter by
        $filterDate = $request->filled('date') ? $request->date : now()->format('Y-m-d');

        // Get individual remittances for the specified date
        $query = \App\Models\Remittance::with('rider')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('created_at', $filterDate);

        // Apply search filter
        if ($request->filled('search')) {
            $query->whereHas('rider', function($q) use ($request) {
                $q->whereRaw("CONCAT_WS(' ', first_name, last_name) like ?", ['%' . $request->search . '%']);
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $remittances = $query->latest()->paginate(10)->withQueryString();

        // Get rider summary data - total remit per rider for the specified date
        $riderSummaryQuery = \App\Models\Remittance::with('rider')
            ->selectRaw('rider_id,
                         COUNT(*) as total_transactions,
                         SUM(total_remit) as total_remit_amount,
                         SUM(total_collection) as total_collection_amount,
                         MAX(created_at) as latest_remittance')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('created_at', $filterDate)
            ->groupBy('rider_id');

        // Apply search filter to summary
        if ($request->filled('search')) {
            $riderSummaryQuery->whereHas('rider', function($q) use ($request) {
                $q->whereRaw("CONCAT_WS(' ', first_name, last_name) like ?", ['%' . $request->search . '%']);
            });
        }

        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name':
                    $riderSummaryQuery->join(DB::raw('mt_driver as riders'), 'remittances.rider_id', '=', 'riders.driver_id')
                        ->orderByRaw("CONCAT_WS(' ', riders.first_name, riders.last_name) asc");
                    break;
                case 'total_remit':
                    $riderSummaryQuery->orderByRaw('SUM(total_remit) DESC');
                    break;
                case 'transactions':
                    $riderSummaryQuery->orderByRaw('COUNT(*) DESC');
                    break;
                case 'latest':
                    $riderSummaryQuery->orderByRaw('MAX(created_at) DESC');
                    break;
                default:
                    $riderSummaryQuery->orderByRaw('MAX(created_at) DESC');
            }
        } else {
            $riderSummaryQuery->orderByRaw('MAX(created_at) DESC');
        }

        $riderSummaries = $riderSummaryQuery->get();

        // Calculate overall statistics for the specified date
        $totalExpectedRemit = \App\Models\Remittance::whereIn('status', ['pending', 'confirmed'])
            ->whereDate('created_at', $filterDate)
            ->sum('total_remit');

        $totalCashCollected = \App\Models\Remittance::whereIn('status', ['pending', 'confirmed'])
            ->whereDate('created_at', $filterDate)
            ->sum('total_collection');

        $clearedCount = \App\Models\Remittance::where('status', 'confirmed')
            ->whereDate('created_at', $filterDate)
            ->count();

        $pendingCount = \App\Models\Remittance::where('status', 'pending')
            ->whereDate('created_at', $filterDate)
            ->count();

        // Get only the latest confirmation per rider for this date (matches table column logic)
        $latestConfirmationIds = \App\Models\BankDepositConfirmation::whereDate('deposit_date', $filterDate)
            ->selectRaw('MAX(id) as id')
            ->groupBy('rider_id')
            ->pluck('id');

        $confirmedCashCollected = \App\Models\BankDepositConfirmation::whereIn('id', $latestConfirmationIds)
            ->sum('total_amount');

        // Total discrepancy = sum of only negative discrepancy values from latest confirmation per rider
        $totalDiscrepancy = \App\Models\BankDepositConfirmation::whereIn('id', $latestConfirmationIds)
            ->where('discrepancy', '<', 0)
            ->sum('discrepancy');

        // Total change = sum of only positive discrepancy values (excess collected)
        $totalChange = \App\Models\BankDepositConfirmation::whereIn('id', $latestConfirmationIds)
            ->where('discrepancy', '>', 0)
            ->sum('discrepancy');

        // Dates that have a negative discrepancy (for calendar indicators)
        $discrepancyDates = \App\Models\BankDepositConfirmation::selectRaw('DATE(deposit_date) as d')
            ->where('discrepancy', '<', 0)
            ->groupBy('d')
            ->pluck('d')
            ->toArray();

        // Dates that have at least one positive discrepancy (change/excess cash)
        $changeDates = \App\Models\BankDepositConfirmation::selectRaw('DATE(deposit_date) as d')
            ->where('discrepancy', '>', 0)
            ->groupBy('d')
            ->pluck('d')
            ->toArray();

        // Dates with at least one "validating" rider (not fully validated).
        // A date is validating only when at least one rider on that date does NOT have
        // a latest bank deposit confirmation with discrepancy = 0.
        // ── Step 1: all date+rider combos that appear in the rider summary table
        $remitCombos = DB::table('remittances')
            ->selectRaw('DATE(created_at) as d, rider_id')
            ->whereIn('status', ['pending', 'confirmed'])
            ->groupByRaw('DATE(created_at), rider_id')
            ->get()
            ->map(fn($r) => $r->d . '|' . $r->rider_id)
            ->toArray();

        // ── Step 2: date+rider combos where the latest bank deposit confirmation is discrepancy=0
        $latestConfIds = DB::table('bank_deposit_confirmations')
            ->selectRaw('MAX(id) as id')
            ->groupByRaw('rider_id, DATE(deposit_date)')
            ->pluck('id');

        $validatedSet = collect();
        if ($latestConfIds->isNotEmpty()) {
            $validatedSet = DB::table('bank_deposit_confirmations')
                ->selectRaw('DATE(deposit_date) as d, rider_id')
                ->whereIn('id', $latestConfIds)
                ->where('discrepancy', 0)
                ->get()
                ->map(fn($r) => $r->d . '|' . $r->rider_id)
                ->flip();
        }

        // ── Step 3: collect dates where at least one rider is still unvalidated
        $validatingDates = [];
        foreach ($remitCombos as $key) {
            if (!$validatedSet->has($key)) {
                $validatingDates[] = explode('|', $key)[0];
            }
        }
        $validatingDates = array_values(array_unique($validatingDates));

        return view('bank-deposit', compact('remittances', 'riderSummaries', 'totalExpectedRemit', 'totalCashCollected', 'clearedCount', 'pendingCount', 'confirmedCashCollected', 'filterDate', 'totalDiscrepancy', 'totalChange', 'discrepancyDates', 'validatingDates', 'changeDates'));
    })->name('bank-deposit');

    Route::post('/bank-deposit/confirm', function (\Illuminate\Http\Request $request) {
        $request->validate([
            'rider_id'    => 'required|exists:wheninba_MercifulGod.mt_driver,driver_id',
            'bank_amount' => 'required|numeric|min:0',
            'total_amount'=> 'required|numeric|min:0.01',
            'deposit_date'=> 'required|date',
            'denom_1000'  => 'integer|min:0',
            'denom_500'   => 'integer|min:0',
            'denom_200'   => 'integer|min:0',            'denom_20b'  => 'integer|min:0',            'denom_100'   => 'integer|min:0',
            'denom_50'    => 'integer|min:0',
            'denom_20'    => 'integer|min:0',
            'denom_10'    => 'integer|min:0',
            'denom_5'     => 'integer|min:0',
            'denom_1'     => 'integer|min:0',
            'discrepancy' => 'nullable|numeric',
        ]);

        $confirmation = \App\Models\BankDepositConfirmation::create([
            'rider_id'     => $request->rider_id,
            'confirmed_by' => Auth::id(),
            'deposit_date' => $request->deposit_date,
            'bank_amount'  => $request->bank_amount,
            'denom_1000'   => $request->denom_1000 ?? 0,
            'denom_500'    => $request->denom_500  ?? 0,
            'denom_200'    => $request->denom_200  ?? 0,
            'denom_100'    => $request->denom_100  ?? 0,
            'denom_50'     => $request->denom_50   ?? 0,
            'denom_20'     => $request->denom_20   ?? 0,            'denom_20b'    => $request->denom_20b ?? 0,            'denom_10'     => $request->denom_10   ?? 0,
            'denom_5'      => $request->denom_5    ?? 0,
            'denom_1'      => $request->denom_1    ?? 0,
            'total_amount' => $request->total_amount,
            'discrepancy'  => $request->has('discrepancy') ? $request->discrepancy : ($request->total_amount - $request->bank_amount),
        ]);

        $rider = \App\Models\Rider::find($request->rider_id);
        AuditLog::log(
            'Bank Deposit Confirmed – Rider: ' . ($rider->name ?? $request->rider_id),
            'Bank & Deposit',
            'completed',
            [
                'amount'           => $request->total_amount,
                'source_bank' => 'Cash',
                'notes'            => 'Deposit Date: ' . $request->deposit_date . ' | Discrepancy: ' . ($request->discrepancy ?? 0),
            ]
        );

        return response()->json(['success' => true, 'confirmation_id' => $confirmation->id]);
    })->name('bank-deposit.confirm');

    Route::patch('/bank-deposit/discrepancy/{id}', function (\Illuminate\Http\Request $request, $id) {
        $request->validate(['discrepancy' => 'required|numeric']);
        $record = \App\Models\BankDepositConfirmation::findOrFail($id);
        $newTotal = $record->bank_amount + $request->discrepancy;
        $record->update([
            'discrepancy'  => $request->discrepancy,
            'total_amount' => $newTotal,
        ]);
        return response()->json(['success' => true, 'new_total' => $newTotal]);
    })->name('bank-deposit.discrepancy.update');

    Route::get('/bank-deposit/totals', function (\Illuminate\Http\Request $request) {
        $date = $request->get('date', today()->toDateString());
        $latestIds = \App\Models\BankDepositConfirmation::whereDate('deposit_date', $date)
            ->selectRaw('MAX(id) as id')
            ->groupBy('rider_id')
            ->pluck('id');
        $records = \App\Models\BankDepositConfirmation::whereIn('id', $latestIds)->get();
        return response()->json([
            'confirmed_cash' => $records->sum('total_amount'),
            'discrepancy'    => $records->where('discrepancy', '<', 0)->sum('discrepancy'),
            'change'         => $records->where('discrepancy', '>', 0)->sum('discrepancy'),
        ]);
    })->name('bank-deposit.totals');

    Route::get('/bank-deposit/report', function (\Illuminate\Http\Request $request) {
        $dateFrom   = $request->get('date_from', today()->toDateString());
        $dateTo     = $request->get('date_to',   today()->toDateString());
        $reportType = $request->get('type', 'summary');
        $format     = $request->get('format', 'print');
        $cols       = array_filter(explode(',', $request->get('cols', 'transactions,remit,confirmed,discrepancy,status,officer')));

        // Pull rider summaries for the date range
        $riderSummaries = \App\Models\Remittance::with('rider')
            ->selectRaw('rider_id,
                         COUNT(*) as total_transactions,
                         SUM(total_remit) as total_remit_amount,
                         MAX(created_at) as latest_remittance')
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->groupBy('rider_id')
            ->orderByRaw('MAX(created_at) DESC')
            ->get();

        // Pull confirmations in that range (latest per rider per day)
        $confirmations = \App\Models\BankDepositConfirmation::with('rider')
            ->whereDate('deposit_date', '>=', $dateFrom)
            ->whereDate('deposit_date', '<=', $dateTo)
            ->orderBy('deposit_date', 'desc')
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('rider_id');      // keyed by rider_id → collection of records

        // Overall totals
        $totalExpected  = $riderSummaries->sum('total_remit_amount');
        $totalConfirmed = \App\Models\BankDepositConfirmation::whereDate('deposit_date', '>=', $dateFrom)
                            ->whereDate('deposit_date', '<=', $dateTo)->sum('total_amount');
        $totalDiscrepancy = \App\Models\BankDepositConfirmation::whereDate('deposit_date', '>=', $dateFrom)
                            ->whereDate('deposit_date', '<=', $dateTo)
                            ->where('discrepancy', '<', 0)->sum('discrepancy');
        $totalChange    = \App\Models\BankDepositConfirmation::whereDate('deposit_date', '>=', $dateFrom)
                            ->whereDate('deposit_date', '<=', $dateTo)
                            ->where('discrepancy', '>', 0)->sum('discrepancy');
        $generatedBy    = Auth::user()->name;
        $generatedByRole = Auth::user()->role ?? '';

        if ($format === 'csv') {
            // Build CSV
            $headers = ['#', 'Rider Name'];
            if (in_array('transactions', $cols)) $headers[] = 'Transactions';
            if (in_array('remit', $cols))        $headers[] = 'Total Remit (PHP)';
            if (in_array('confirmed', $cols))    $headers[] = 'Confirmed Amount (PHP)';
            if (in_array('discrepancy', $cols))  $headers[] = 'Discrepancy (PHP)';
            if (in_array('status', $cols))       $headers[] = 'Status';
            if (in_array('officer', $cols))      $headers[] = 'Officer';

            $rows   = [];
            $rows[] = implode(',', $headers);
            foreach ($riderSummaries as $i => $s) {
                $latestConf = isset($confirmations[$s->rider_id]) ? $confirmations[$s->rider_id]->first() : null;
                $disc       = $latestConf ? $latestConf->discrepancy : null;
                $statusLabel = $latestConf ? (((float)$disc === 0.0) ? 'Validated' : 'Validating') : 'Not Validated';
                $row = [$i+1, '"' . ($s->rider->name ?? 'N/A') . '"'];
                if (in_array('transactions', $cols)) $row[] = $s->total_transactions;
                if (in_array('remit', $cols))        $row[] = number_format($s->total_remit_amount, 2, '.', '');
                if (in_array('confirmed', $cols))    $row[] = number_format($latestConf?->total_amount ?? 0, 2, '.', '');
                if (in_array('discrepancy', $cols))  $row[] = $disc !== null ? number_format($disc, 2, '.', '') : '0.00';
                if (in_array('status', $cols))       $row[] = $statusLabel;
                if (in_array('officer', $cols))      $row[] = '"' . $generatedBy . '"';
                $rows[] = implode(',', $row);
            }
            // totals row
            $rows[] = '';
            $rows[] = '"Total","","","' . number_format($totalExpected,2,'.','') . '","' . number_format($totalConfirmed,2,'.','') . '","' . number_format($totalDiscrepancy,2,'.','') . '"';

            $filename  = 'bank-deposit-report-' . $dateFrom . '-to-' . $dateTo . '.csv';
            $csvContent = implode("\r\n", $rows);
            return response($csvContent, 200, [
                'Content-Type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        return view('bank-deposit-report', compact(
            'riderSummaries', 'confirmations', 'dateFrom', 'dateTo',
            'reportType', 'cols', 'totalExpected', 'totalConfirmed',
            'totalDiscrepancy', 'totalChange', 'generatedBy', 'generatedByRole'
        ));
    })->name('bank-deposit.report');
    });

    Route::middleware('page.access:merchants')->group(function () {
        Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants');
        Route::get('/merchants/archived', [MerchantController::class, 'archivedIndex'])->name('merchants.archived');
        Route::get('/merchants/item-suggestions', [MerchantController::class, 'itemSuggestions'])->name('merchants.item-suggestions');
        Route::post('/merchants', [MerchantController::class, 'store'])->name('merchants.store');
        Route::put('/merchants/{merchant}', [MerchantController::class, 'update'])->name('merchants.update');
        Route::patch('/merchants/{merchant}/archive', [MerchantController::class, 'archive'])->name('merchants.archive');
        Route::patch('/merchants/{merchant}/restore', [MerchantController::class, 'restore'])->name('merchants.restore');
        Route::post('/merchants/bulk-update', [MerchantController::class, 'bulkUpdate'])->name('merchants.bulk-update');
        Route::delete('/merchants/{merchant}', [MerchantController::class, 'destroy'])->name('merchants.destroy');
    });

    Route::middleware('page.access:financial-requests')->group(function () {
        Route::get('/financial-requests', [FinancialRequestController::class, 'index'])->name('financial-requests.index');
        Route::post('/financial-requests', [FinancialRequestController::class, 'store'])->name('financial-requests.store');
        Route::patch('/financial-requests/{financialRequest}/approve', [FinancialRequestController::class, 'approve'])->name('financial-requests.approve');
        Route::patch('/financial-requests/{financialRequest}/reject', [FinancialRequestController::class, 'reject'])->name('financial-requests.reject');
    });

    // Member Management Routes
    Route::middleware('page.access:members')->group(function () {
        Route::get('/member-management', [UserController::class, 'index'])->name('members.index');
        Route::post('/members', [UserController::class, 'store'])->name('members.store');
        Route::put('/members/{user}', [UserController::class, 'update'])->name('members.update');
        Route::delete('/members/{user}', [UserController::class, 'destroy'])->name('members.destroy');
        Route::patch('/members/{user}/restore', [UserController::class, 'restore'])->name('members.restore');
    });

    Route::middleware('page.access:audit-logs')->group(function () {
    Route::get('/audit-logs', function (\Illuminate\Http\Request $request) {
        $query = AuditLog::with('user')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('email', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(10)->withQueryString();

        $modules = ['Remittance', 'Bank & Deposit', 'Member Management', 'Financial Requests', 'Profile', 'General'];

        return view('audit-logs', compact('logs', 'modules'));
    })->name('audit-logs');
    });

    // Profile Routes
    Route::middleware('page.access:profile')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::post('/profile/resend-verification', [ProfileController::class, 'resendVerification'])->name('profile.resend-verification');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // 2FA Setup Routes (require auth)
        Route::get('/profile/2fa/setup', [ProfileController::class, 'setup2fa'])->name('profile.2fa.setup');
        Route::post('/profile/2fa/confirm', [ProfileController::class, 'confirm2fa'])->name('profile.2fa.confirm');
        Route::post('/profile/2fa/disable', [ProfileController::class, 'disable2fa'])->name('profile.2fa.disable');
    });

    // Chat Routes
    Route::get('/chat/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/messages', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/unread', [ChatController::class, 'getUnreadCount'])->name('chat.unread');
    Route::get('/chat/inbox', [ChatController::class, 'inbox'])->name('chat.inbox');
});

Route::get('/info', function() {
    return view('info');
});
