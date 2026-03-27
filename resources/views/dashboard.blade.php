<!DOCTYPE html>
<html lang="en">
@if (auth()->user()->force_password_change && auth()->user()->role !== 'admin')
    <div id="forceChangeModal"
        style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:2000;display:flex;align-items:center;justify-content:center;">
        <div
            style="background:white;padding:32px 32px 24px 32px;border-radius:18px;max-width:440px;width:100%;box-shadow:0 8px 32px rgba(67,96,38,0.18);display:flex;flex-direction:column;align-items:center;">
            <h2 style="margin-bottom:8px;font-size:1.35rem;font-weight:700;color:#222;text-align:center;">Change Your
                Password</h2>
            <hr style="width:100%;margin-bottom:16px;border:0;border-top:1px solid #e0e0e0;">
            <div style="margin-bottom:18px;text-align:center;color:#444;font-size:0.92rem;line-height:1.3;">
                Protect your account with a strong, secure password.<br>Make sure it's hard to guess and easy for you to
                remember.
            </div>
            <form method="POST" action="{{ route('force.password.change') }}"
                style="width:100%;display:flex;flex-direction:column;gap:18px;">
                @csrf
                @if ($errors->has('new_password'))
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        {{ $errors->first('new_password') }}
                    </div>
                @endif
                @if ($errors->has('new_password_confirmation'))
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        {{ $errors->first('new_password_confirmation') }}
                    </div>
                @endif
                @if ($errors->has('new_password') && $errors->first('new_password') === 'The new password confirmation does not match.')
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        Passwords do not match.
                    </div>
                @endif
                <div style="position:relative;width:100%;">
                    <input type="password" name="new_password" id="new_password" required
                        placeholder="Enter new password"
                        style="width:100%;padding:14px 16px;border:0;background:#e0e0e0;border-radius:12px;font-size:1.08rem;color:#222;outline:none;">
                    <!-- Eye icon removed -->
                </div>
                <div style="position:relative;width:100%;">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                        placeholder="Confirm Password"
                        style="width:100%;padding:14px 16px;border:0;background:#e0e0e0;border-radius:12px;font-size:1.08rem;color:#222;outline:none;">
                    <!-- Eye icon removed -->
                </div>
                @if ($errors->has('new_password') && $errors->first('new_password') === 'The new password confirmation does not match.')
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        Passwords do not match.
                    </div>
                @endif
                <button type="submit"
                    style="background:#436026;color:white;padding:14px 0;font-size:1.15rem;font-weight:700;border:none;border-radius:8px;width:100%;margin-top:8px;box-shadow:0 2px 8px rgba(67,96,38,0.08);transition:background 0.2s;cursor:pointer;">Confirm</button>
            </form>
        </div>
        <!-- Eye icon toggle script removed -->
    </div>
    <script>
        // Prevent interaction with dashboard until password is changed
        document.body.style.overflow = 'hidden';
    </script>
@endif
@if (session('force_password_change_success'))
    <div id="passwordSuccessModal"
        style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:2100;display:flex;align-items:center;justify-content:center;">
        <div
            style="background:white;padding:32px 32px 24px 32px;border-radius:18px;max-width:440px;width:100%;box-shadow:0 8px 32px rgba(67,96,38,0.18);display:flex;flex-direction:column;align-items:center;">
            <h2 style="margin-bottom:8px;font-size:1.35rem;font-weight:700;color:#436026;text-align:center;">Password
                Changed Successfully</h2>
            <hr style="width:100%;margin-bottom:16px;border:0;border-top:1px solid #e0e0e0;">
            <div style="margin-bottom:18px;text-align:center;color:#444;font-size:1rem;line-height:1.3;">
                Your password has been updated. You can now continue using your account securely.
            </div>
            <button
                onclick="document.getElementById('passwordSuccessModal').style.display='none';document.body.style.overflow='auto';"
                style="background:#436026;color:white;padding:14px 0;font-size:1.15rem;font-weight:700;border:none;border-radius:8px;width:100%;margin-top:8px;box-shadow:0 2px 8px rgba(67,96,38,0.08);transition:background 0.2s;cursor:pointer;">OK</button>
        </div>
    </div>
    <script>
        document.body.style.overflow = 'hidden';
    </script>
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Dashboard - When in Baguio Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brand-900: #1f3624;
            --brand-800: #2d4a30;
            --brand-700: #3f633c;
            --brand-500: #6f954d;
            --brand-300: #b5ce8a;
            --accent: #f5b700;
            --danger: #b84040;
            --surface: #f6f7f1;
            --surface-soft: #fcfcf8;
            --text: #172118;
            --muted: #5b6a56;
            --card-shadow: 0 10px 28px rgba(19, 40, 23, 0.12);
            --radius-lg: 18px;
            --radius-md: 12px;
        }

        body {
            font-family: 'Manrope', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--text);
            background: radial-gradient(circle at 10% -10%, #d9e8b6 0, rgba(217, 232, 182, 0) 30%),
                radial-gradient(circle at 100% 0, #e8f3cc 0, rgba(232, 243, 204, 0) 25%),
                linear-gradient(130deg, #eff2e4 0%, #e9efdc 45%, #edf3e8 100%);
        }

                @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')



        /* Main Content Styles */
        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 28px 30px;
            overflow-y: auto;
            background: transparent;
        }

        .content-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0;
            gap: 18px;
            flex-wrap: wrap;
        }

        .header-copy {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .content-header h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--brand-900);
            margin: 0;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.3px;
        }

        .dashboard-subtitle {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .action-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            text-decoration: none;
            padding: 8px 14px;
            color: var(--brand-900);
            background: rgba(63, 99, 60, 0.08);
            border: 1px solid rgba(63, 99, 60, 0.14);
            font-size: 12px;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .action-chip:hover {
            transform: translateY(-2px);
            background: rgba(245, 183, 0, 0.18);
            border-color: rgba(176, 129, 0, 0.3);
        }

        .user-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(67, 96, 38, 0.12);
            border-radius: 999px;
            padding: 6px 8px 6px 16px;
        }

        .user-indicator .user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--brand-700) 0%, var(--brand-500) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 12px rgba(48, 81, 35, 0.36);
        }

        .user-indicator .user-avatar:hover {
            background: linear-gradient(135deg, #f5d54f 0%, var(--accent) 100%);
            color: var(--brand-900);
            transform: scale(1.06);
            box-shadow: 0 8px 16px rgba(178, 138, 14, 0.34);
        }

        .user-indicator .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            gap: 2px;
        }

        .user-indicator .user-name {
            font-weight: 600;
            color: var(--text);
            font-size: 14px;
        }

        .user-indicator .user-role {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            text-transform: capitalize;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(140deg, #27442d 0%, #3f633c 100%);
            color: white;
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 12px 24px rgba(24, 46, 26, 0.24);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            cursor: pointer;
            min-height: 110px;
            animation: riseIn 0.45s ease both;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .stat-card:visited {
            color: white;
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(140deg, #31573a 0%, #4d7a4a 100%);
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(140deg, #365f55 0%, #447667 100%);
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(140deg, #61452f 0%, #8a6140 100%);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            right: -45px;
            top: -45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(21, 40, 20, 0.3);
        }

        .stat-card .stat-icon {
            font-size: 22px;
            opacity: 0.9;
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            filter: drop-shadow(1px 2px 4px rgba(0, 0, 0, 0.2));
            flex-shrink: 0;
        }

        .stat-card .stat-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.18);
            white-space: nowrap;
            overflow: hidden;
            width: 100%;
        }

        .stat-card p {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.9;
            margin: 0;
            letter-spacing: 0.35px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 14px;
        }

        .chart-box {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 18px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.12);
            animation: riseIn 0.5s ease both;
        }

        .chart-box:hover {
            box-shadow: 0 12px 24px rgba(35, 54, 22, 0.17);
            transform: translateY(-3px);
        }

        .chart-box h3 {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 12px;
            color: var(--brand-900);
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(67, 96, 38, 0.16);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-filter {
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            background: var(--surface-soft);
            border: 1px solid rgba(63, 99, 60, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--brand-800);
            font-weight: 600;
            outline: none;
        }

        .chart-filter:hover {
            border-color: #436026;
            box-shadow: 0 2px 6px rgba(67, 96, 38, 0.2);
        }

        .chart-filter:focus {
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .chart-placeholder {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #f6f8f0 0%, #fefefc 100%);
            border-radius: 8px;
            color: #666;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .transaction-history {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.12);
            animation: riseIn 0.55s ease both;
            animation-delay: 0.2s;
        }

        .transaction-history:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .transaction-history h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 16px;
            color: var(--brand-900);
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(67, 96, 38, 0.16);
        }

        .transaction-table {
            background: linear-gradient(135deg, #f6f8f0 0%, #edf2e4 100%);
            border-radius: 8px;
            padding: 40px;
            min-height: 200px;
            text-align: center;
            color: var(--muted);
            box-shadow: inset 0 2px 8px rgba(18, 44, 18, 0.06);
            border: 1px dashed rgba(67, 96, 38, 0.3);
        }

        /* Success Alert */
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
            animation: slideInDown 0.5s ease;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes riseIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-content {
                padding: 22px;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 230px;
                z-index: 1001;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 80px 16px 18px 16px;
            }

            .sidebar-logo {
                padding: 18px 16px;
            }

            .sidebar-logo img {
                width: 52px;
                height: 52px;
            }

            .menu-item {
                padding: 10px 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                padding: 0;
            }

            .content-header h1 {
                font-size: 26px;
            }

            .user-indicator {
                width: 100%;
                justify-content: space-between;
                margin-left: 0;
            }

            .quick-actions {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 70px 15px 15px 15px;
            }

            .stat-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                padding: 20px;
            }

            .stat-card h3 {
                font-size: 24px;
            }

            .chart-box {
                padding: 16px;
            }

            .transaction-history {
                padding: 16px;
            }

            .user-indicator .user-info {
                align-items: flex-start;
                text-align: left;
            }

            .user-indicator .user-name {
                font-size: 13px;
            }
        }

        @include('partials.user-indicator-styles')
    </style>
</head>

<body>
    @include('partials.app-sidebar', ['activePage' => 'dashboard'])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <div class="header-copy">
                <h1>Dashboard Overview</h1>
            </div>
            @include('partials.user-indicator')
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-wallet stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;{{ number_format($totalCollections, 2) }}</h3>
                    <p>Total Collections</p>
                </div>
            </a>
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;200,000</h3>
                    <p>Net Revenue</p>
                </div>
            </a>
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-piggy-bank stat-icon"></i>
                <div class="stat-content">
                    <h3>-</h3>
                    <p>GT. Funds Balance</p>
                </div>
            </a>
            <a href="{{ route('bank-deposit') }}" class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;{{ number_format($totalDiscrepancies, 2) }}</h3>
                    <p>Discrepancies</p>
                </div>
            </a>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <!-- Gross Sales Trend Chart -->
            <div class="chart-box">
                <h3>
                    <span>Gross Sales Trend</span>
                    <select class="chart-filter" id="salesTrendFilter" onchange="changeSalesTrendView(this.value)">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="annually">Annually</option>
                    </select>
                </h3>
                <div class="chart-placeholder">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Daily/Weekly/Monthly Chart -->
            <div class="chart-box">
                <h3>
                    <span>Funds and Outflows</span>
                    <select class="chart-filter" id="fundsFlowFilter" onchange="changeChartView(this.value)">
                        <option value="daily" selected>Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </h3>
                <div class="chart-placeholder">
                    <canvas id="expenseBalanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders by Month Trend -->
        <div class="chart-box" style="margin-bottom:30px;">
            <h3>
                <span>Orders by Month Trend</span>
                <select class="chart-filter" id="ordersByMonthYear" onchange="updateOrdersByMonth(this.value)">
                    @foreach ($chartYears as $yr)
                        <option value="{{ $yr }}" {{ $loop->first ? 'selected' : '' }}>{{ $yr }}
                        </option>
                    @endforeach
                </select>
            </h3>
            <div class="chart-placeholder">
                <canvas id="ordersByMonthChart"></canvas>
            </div>
        </div>

        <!-- Recent Transaction History -->
        <div class="transaction-history">
            <h3>Recent Transaction History</h3>
            <div class="transaction-table">
                <!-- Transaction data will be displayed here -->
                <p style="color: #999;">No recent transactions</p>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gross Sales Trend Chart
        const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Partners',
                    data: [300, 450, 350, 500, 400, 300, 350],
                    borderColor: '#3f633c',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'Non-Partners',
                    data: [250, 300, 400, 350, 450, 380, 420],
                    borderColor: '#b84040',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'Good Taste',
                    data: [400, 380, 420, 400, 350, 300, 250],
                    borderColor: '#447667',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 100
                        }
                    }
                }
            }
        });

        // Expense/Balance Chart
        const expenseCtx = document.getElementById('expenseBalanceChart').getContext('2d');
        const expenseBalanceChart = new Chart(expenseCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Beginning Balance',
                    data: [80, 150, 110, 90, 80, 100, 110],
                    backgroundColor: '#436026',
                    stack: 'Stack 0',
                    categoryPercentage: 0.7,
                    barPercentage: 0.9
                }, {
                    label: 'Expense',
                    data: [-120, -180, -130, -110, -100, -120, -130],
                    backgroundColor: '#ffd300',
                    stack: 'Stack 0',
                    categoryPercentage: 0.7,
                    barPercentage: 0.9
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 25,
                            padding: 10
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: '#e5e5e5'
                        },
                        ticks: {
                            stepSize: 100
                        }
                    }
                }
            }
        });

        function changeChartView(view) {
            // Update chart data based on view (daily/weekly/monthly)
            // This is a placeholder - implement actual data fetching logic
            console.log('Funds and Outflows view changed to:', view);

            // Example: Update chart labels based on period
            let labels;
            switch (view) {
                case 'daily':
                    labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    break;
                case 'weekly':
                    labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    break;
                case 'monthly':
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    break;
            }

            // Update chart with new labels
            expenseBalanceChart.data.labels = labels;
            expenseBalanceChart.update();
        }

        // Orders by Month Chart connected to merchant orders totals
        const ordersData = @json($monthlyOrders);
        const defaultYear = {{ $chartYears[0] }};

        function buildZeroOrderPoints(values) {
            return values.map(v => Number(v) === 0 ? 0 : null);
        }

        const ordersCtx = document.getElementById('ordersByMonthChart').getContext('2d');
        const ordersByMonthChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    type: 'line',
                    label: 'Zero Orders',
                    data: buildZeroOrderPoints(ordersData[defaultYear] || Array(12).fill(0)),
                    showLine: false,
                    pointRadius: 5,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#b84040',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    order: 0
                }, {
                    label: 'Overall Orders',
                    data: ordersData[defaultYear] || Array(12).fill(0),
                    backgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return value === 0 ? 'rgba(67,96,38,0.15)' : '#436026';
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                    hoverBackgroundColor: '#ffd300',
                    order: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                if (ctx.dataset.label === 'Zero Orders') {
                                    return ' Zero orders this month';
                                }
                                return ctx.parsed.y === 0 ?
                                    ' Orders: 0' :
                                    ' Orders: ' + ctx.parsed.y.toLocaleString('en-PH');
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e5e5e5'
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('en-PH');
                            }
                        }
                    }
                }
            }
        });

        function updateOrdersByMonth(year) {
            const yearData = ordersData[year] || Array(12).fill(0);
            ordersByMonthChart.data.datasets[0].data = buildZeroOrderPoints(yearData);
            ordersByMonthChart.data.datasets[1].data = yearData;
            ordersByMonthChart.update();
        }

        // Change Sales Trend View
        function changeSalesTrendView(period) {
            // This is a placeholder - implement actual data fetching logic
            // You can update the chart data based on the selected period
            console.log('Sales trend period changed to:', period);

            // Example: Update chart labels based on period
            let labels;
            switch (period) {
                case 'daily':
                    labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    break;
                case 'weekly':
                    labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    break;
                case 'monthly':
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    break;
                case 'annually':
                    labels = ['2020', '2021', '2022', '2023', '2024', '2025', '2026'];
                    break;
            }

            // Update chart with new labels
            salesTrendChart.data.labels = labels;
            salesTrendChart.update();
        }

        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.querySelector('.mobile-menu-toggle');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !toggleBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            }
        });

        // Auto-fit stat card numbers so they never overflow regardless of value length
        function fitStatCardNumbers() {
            document.querySelectorAll('.stat-card h3').forEach(function(h3) {
                h3.style.fontSize = '';
                var maxSize = 32;
                var minSize = 10;
                var size = maxSize;
                h3.style.fontSize = size + 'px';
                while (h3.scrollWidth > h3.offsetWidth && size > minSize) {
                    size -= 0.5;
                    h3.style.fontSize = size + 'px';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', fitStatCardNumbers);
        window.addEventListener('resize', fitStatCardNumbers);
    </script>

    @include('partials.floating-widgets')
</body>

</html>

