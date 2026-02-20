<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Wibsystem</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #e8e8e8;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 180px;
            background: linear-gradient(180deg, #436026 0%, #344d1e 100%);
            color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }

        .sidebar-logo {
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            position: relative;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-logo img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .sidebar-logo img:hover {
            transform: scale(1.05);
        }

        .sidebar-menu {
            flex: 1;
            padding: 20px 0;
            overflow-y: auto;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 14px;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.15);
            padding-left: 25px;
            box-shadow: inset 4px 0 0 #ffd300;
        }

        .menu-item.active {
            background: rgba(0, 0, 0, 0.3);
            color: #ffd300;
            font-weight: 600;
            box-shadow: inset 4px 0 0 #ffd300;
            padding-left: 25px;
        }

        .menu-item.active i {
            color: #ffd300;
        }

        .menu-item i {
            margin-right: 12px;
            font-size: 16px;
            width: 20px;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.3);
            position: relative;
            background: rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            background: transparent;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #436026 100%);
            border-color: #5a7d33;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(90, 125, 51, 0.4);
        }

        .logout-btn i {
            margin-right: 10px;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
            background: #436026;
            color: white;
            border: none;
            padding: 12px 15px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: #5a7d33;
            transform: scale(1.05);
        }

        .mobile-menu-toggle i {
            font-size: 20px;
        }

        /* Mobile Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 180px;
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
        }

        .content-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 32px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .user-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-indicator .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 8px rgba(67, 96, 38, 0.4);
        }

        .user-indicator .user-avatar:hover {
            background: linear-gradient(135deg, #ffd300 0%, #ffed4e 100%);
            color: #436026;
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 211, 0, 0.5);
        }

        .user-indicator .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
            padding: 8px 12px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .user-indicator .user-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 14px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
        }

        .user-indicator .user-email {
            font-size: 12px;
            color: #666;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-radius: 12px;
            padding: 25px;
            text-align: left;
            box-shadow: 0 8px 20px rgba(67, 96, 38, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffd300, #436026);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(67, 96, 38, 0.4);
        }

        .stat-card .stat-icon {
            font-size: 28px;
            opacity: 0.9;
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.2));
            flex-shrink: 0;
        }

        .stat-card .stat-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
        }

        .stat-card p {
            font-size: 13px;
            font-weight: 600;
            opacity: 0.9;
            margin: 0;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-box {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.1);
        }

        .chart-box:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-3px);
        }

        .chart-box h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1a1a1a;
            padding-bottom: 10px;
            border-bottom: 2px solid #436026;
        }

        .chart-placeholder {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fafafa;
            border-radius: 8px;
            color: #666;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .transaction-history {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.1);
        }

        .transaction-history:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .transaction-history h3 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #1a1a1a;
            padding-bottom: 12px;
            border-bottom: 2px solid #436026;
        }

        .transaction-table {
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            border-radius: 8px;
            padding: 40px;
            min-height: 200px;
            text-align: center;
            color: #666;
            box-shadow: inset 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #ddd;
        }

        .chart-tabs {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .chart-tab {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
        }

        .chart-tab:hover {
            background: #f8f8f8;
            border-color: #436026;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(67, 96, 38, 0.2);
        }

        .chart-tab.active {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-color: #436026;
            box-shadow: 0 4px 10px rgba(67, 96, 38, 0.4);
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

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                width: 240px;
                z-index: 1001;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 80px 20px 20px 20px;
            }

            .sidebar-logo {
                padding: 20px;
            }

            .sidebar-logo img {
                width: 60px;
                height: 60px;
            }

            .menu-item {
                padding: 12px 20px;
            }

            .menu-item:hover,
            .menu-item.active {
                padding-left: 25px;
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
                gap: 15px;
            }

            .content-header h1 {
                font-size: 24px;
            }

            .user-indicator {
                width: 100%;
                justify-content: flex-end;
            }

            .chart-tabs {
                flex-wrap: wrap;
                gap: 10px;
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
                font-size: 28px;
            }

            .chart-box {
                padding: 20px;
            }

            .transaction-history {
                padding: 20px;
            }

            .user-indicator .user-info {
                padding: 6px 10px;
            }

            .user-indicator .user-name {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <img src="{{ asset('images/logowhite.png') }}" alt="Logo">
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('reports') }}" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="{{ route('remittance') }}" class="menu-item">
                <i class="fas fa-file-invoice-dollar"></i>
                <span>Remittance</span>
            </a>
            <a href="{{ route('bank-deposit') }}" class="menu-item">
                <i class="fas fa-university"></i>
                <span>Bank & Deposit</span>
            </a>
            <a href="{{ route('merchants') }}" class="menu-item">
                <i class="fas fa-store"></i>
                <span>Merchants</span>
            </a>
            <a href="{{ route('member-management') }}" class="menu-item">
                <i class="fas fa-users-cog"></i>
                <span>Member Management</span>
            </a>
            <a href="{{ route('audit-logs') }}" class="menu-item">
                <i class="fas fa-clipboard-list"></i>
                <span>Audit Logs</span>
            </a>
            <a href="{{ route('profile') }}" class="menu-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="content-header">
            <h1>Dashboard</h1>
            <div class="user-indicator">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                </div>
                <a href="{{ route('profile') }}" class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-wallet stat-icon"></i>
                <div class="stat-content">
                    <h3>₱170,000</h3>
                    <p>Total Collections</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-content">
                    <h3>₱200,000</h3>
                    <p>Net Revenue</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-piggy-bank stat-icon"></i>
                <div class="stat-content">
                    <h3>-</h3>
                    <p>GT. Funds Balance</p>
                </div>
            </div>
            <div class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon"></i>
                <div class="stat-content">
                    <h3>-</h3>
                    <p>Discrepancies</p>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <!-- Gross Sales Trend Chart -->
            <div class="chart-box">
                <h3>Gross Sales Trend</h3>
                <div class="chart-placeholder">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            <!-- Daily/Weekly/Monthly Chart -->
            <div class="chart-box">
                <div class="chart-tabs">
                    <button class="chart-tab" onclick="changeChartView('daily')">Daily</button>
                    <button class="chart-tab active" onclick="changeChartView('weekly')">Weekly</button>
                    <button class="chart-tab" onclick="changeChartView('monthly')">Monthly</button>
                </div>
                <div class="chart-placeholder">
                    <canvas id="expenseBalanceChart"></canvas>
                </div>
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
                    borderColor: '#a78bfa',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'Non-Partners',
                    data: [250, 300, 400, 350, 450, 380, 420],
                    borderColor: '#fb7185',
                    backgroundColor: 'transparent',
                    tension: 0.4
                }, {
                    label: 'Good Taste',
                    data: [400, 380, 420, 400, 350, 300, 250],
                    borderColor: '#60a5fa',
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
                        beginAtZero: true
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
                    label: 'Expense',
                    data: [-120, -180, -130, -110, -100, -120, -130],
                    backgroundColor: '#ffd300',
                    stack: 'Stack 0',
                    barThickness: 40
                }, {
                    label: 'Balance',
                    data: [80, 150, 110, 90, 80, 100, 110],
                    backgroundColor: '#436026',
                    stack: 'Stack 0',
                    barThickness: 40
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
                        }
                    }
                }
            }
        });

        function changeChartView(view) {
            // Remove active class from all tabs
            document.querySelectorAll('.chart-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            // Add active class to clicked tab
            event.target.classList.add('active');
            
            // Update chart data based on view (daily/weekly/monthly)
            // This is a placeholder - implement actual data fetching logic
            console.log('Chart view changed to:', view);
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
    </script>
</body>
</html>
