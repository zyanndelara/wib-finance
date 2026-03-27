<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Reports - When in Baguio Inc.</title>
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

                @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')



        /* Main Content Styles */
        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: #f5f5f5;
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
        }

        .user-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-indicator .user-avatar {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 22px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .user-indicator .user-avatar:hover {
            background: #ffd300;
            color: #436026;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(255, 211, 0, 0.3);
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
            color: #1a1a1a;
            font-size: 15px;
        }

        .user-indicator .user-role {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            text-transform: capitalize;
        }

        .content-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .content-box {
            background: #d3d3d3;
            border-radius: 8px;
            padding: 40px;
            min-height: 200px;
        }

        .content-box-large {
            background: #d3d3d3;
            border-radius: 8px;
            padding: 40px;
            min-height: 300px;
            grid-column: 1 / -1;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #d3d3d3;
            border-radius: 8px;
            padding: 30px 20px;
            min-height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        /* Filters Section */
        .filters-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 200px;
        }

        .filter-label {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: white;
            cursor: pointer;
        }

        .filter-select:focus {
            outline: none;
            border-color: #436026;
        }

        /* Table Styles */
        .reports-table-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #dee2e6;
        }

        .reports-table thead th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border: 1px solid #dee2e6;
        }

        .reports-table tbody td {
            padding: 15px;
            border: 1px solid #dee2e6;
            color: #666;
            min-height: 50px;
        }

        .reports-table tbody tr:hover {
            background: #f8f9fa;
        }

        /* Summary Section */
        .summary-section {
            background: #d3d3d3;
            border-radius: 8px;
            padding: 30px;
            min-height: 200px;
        }

        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        /* Success Alert */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        /* Toast Notification */
        #toastContainer {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: min(420px, calc(100vw - 24px));
            pointer-events: none;
        }

        .custom-toast {
            position: relative;
            overflow: hidden;
            width: 100%;
            background: #ffffff;
            border-left: 4px solid #28a745;
            border-radius: 8px;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.16);
            padding: 12px 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: toastSlideIn 0.25s ease-out;
            transition: opacity 0.3s ease;
            pointer-events: auto;
        }

        .toast-icon {
            color: #28a745;
            font-size: 18px;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .toast-message {
            flex: 1;
            min-width: 0;
            color: #1f2937;
            font-size: 13px;
            line-height: 1.45;
            word-break: break-word;
        }

        .toast-close {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: -1px;
            padding: 0;
        }

        .toast-close:hover {
            color: #1f2937;
        }

        .toast-progress {
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 100%;
            animation: toastProgress 3s linear forwards;
        }

        @keyframes toastSlideIn {
            from {
                transform: translateX(24px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }

            to {
                width: 0;
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
                width: 230px;
                z-index: 1001;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 80px 20px 20px 20px;
            }

            #toastContainer {
                right: 12px;
                left: 12px;
                bottom: 12px;
                width: auto;
            }

            .custom-toast {
                padding: 11px 12px;
            }

            .toast-message {
                font-size: 12px;
            }

            .sidebar-logo {
                padding: 18px 16px;
            }

            .sidebar-logo img {
                width: 52px;
                height: 52px;
            }

            .menu-item {
                padding: 8px 10px;
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

            .user-indicator .user-name {
                font-size: 12px;
            }
        }

        @include('partials.user-indicator-styles')
    </style>
</head>
<body>
    @include('partials.app-sidebar', ['activePage' => ''])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Reports & Analytics</h1>
            @include('partials.user-indicator')
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <!-- Stat content -->
            </div>
            <div class="stat-card">
                <!-- Stat content -->
            </div>
            <div class="stat-card">
                <!-- Stat content -->
            </div>
            <div class="stat-card">
                <!-- Stat content -->
            </div>
        </div>

        <!-- Filters Section -->
        <div class="filters-section">
            <div class="filter-group">
                <select class="filter-select" id="merchantFilter">
                    <option value="all">All Merchants</option>
                    <option value="partners">Partners</option>
                    <option value="non partners">Non Partners</option>
                    <option value="good taste">Good Taste</option>
                </select>
            </div>
            <div class="filter-group">
                <select class="filter-select" id="statusFilter">
                    <option value="">Filter by status</option>
                    <option value="cleared">Cleared</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div class="filter-group">
                <select class="filter-select" id="dateFilter">
                    <option value="">Filter by date</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="year">This Year</option>
                </select>
            </div>
        </div>

        <!-- Reports Table -->
        <div class="reports-table-container">
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Source</th>
                        <th>Gross Sales</th>
                        <th>WIB Commission</th>
                        <th>ADJ/Penalty</th>
                        <th>Net Payout</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="summary-section">
            <h2 class="summary-title">Summary of selected period</h2>
            <!-- Summary content will go here -->
        </div>
    </div>

    <script>
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

        // Toast Notification Function
        function showToast(message, type = 'success', duration = 3000) {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            let iconHtml = '<i class="fas fa-check-circle toast-icon"></i>';
            let borderColor = '#28a745';
            let progressColor = '#28a745';
            if (type === 'error') {
                iconHtml = '<i class="fas fa-exclamation-circle toast-icon" style="color:#dc3545"></i>';
                borderColor = '#dc3545';
                progressColor = '#dc3545';
            } else if (type === 'warning') {
                iconHtml = '<i class="fas fa-exclamation-triangle toast-icon" style="color:#ffc107"></i>';
                borderColor = '#ffc107';
                progressColor = '#ffc107';
            } else if (type === 'info') {
                iconHtml = '<i class="fas fa-info-circle toast-icon" style="color:#17a2b8"></i>';
                borderColor = '#17a2b8';
                progressColor = '#17a2b8';
            }
            toast.style.borderLeftColor = borderColor;
            toast.innerHTML = `
                ${iconHtml}
                <div class="toast-message">${message}</div>
                <button class="toast-close" aria-label="Close">&times;</button>
                <div class="toast-progress" style="background:${progressColor}"></div>
            `;

            const progressBar = toast.querySelector('.toast-progress');
            if (progressBar) {
                progressBar.style.animationDuration = `${duration}ms`;
            }

            toast.querySelector('.toast-close').onclick = function() {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            };
            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, duration);
            container.appendChild(toast);
        }

        // Show toast for session success messages
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('success') }}', 'success');
            });
        @endif
    </script>

    <!-- Toast Notification Container -->
    <div id="toastContainer"></div>

    @include('partials.floating-widgets')
</body>
</html>

