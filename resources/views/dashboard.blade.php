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
    <title>Dashboard - When in Baguio Inc.</title>
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
            width: 200px;
            background: linear-gradient(180deg, #2d4016 0%, #3a5220 40%, #2d4016 100%);
            color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.35);
            z-index: 1000;
        }

        .sidebar-logo {
            padding: 18px 16px 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 7px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
        }

        .sidebar-logo img {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .sidebar-logo img:hover {
            transform: scale(1.07);
        }

        .sidebar-logo .app-name {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75);
        }

        .sidebar-menu {
            flex: 1;
            padding: 10px 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .menu-section-label {
            font-size: 9.5px;
            font-weight: 700;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.38);
            padding: 10px 8px 4px;
            user-select: none;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            color: rgba(255, 255, 255, 0.78);
            text-decoration: none;
            transition: all 0.22s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 12.5px;
            font-weight: 500;
            border-radius: 8px;
        }

        .menu-item .menu-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            transition: all 0.22s ease;
            color: rgba(255, 255, 255, 0.7);
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .menu-item:hover .menu-icon {
            background: rgba(255, 211, 0, 0.18);
            color: #ffd300;
        }

        .menu-item.active {
            background: rgba(255, 211, 0, 0.14);
            color: #ffd300;
            font-weight: 700;
        }

        .menu-item.active .menu-icon {
            background: #ffd300;
            color: #2d4016;
        }

        .menu-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.07);
            margin: 8px 4px;
        }

        .sidebar-footer {
            padding: 10px 10px 14px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.15);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            background: rgba(255, 80, 80, 0.1);
            color: rgba(255, 150, 150, 0.9);
            border: 1px solid rgba(255, 80, 80, 0.2);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.22s ease;
            width: 100%;
            font-size: 12.5px;
            font-weight: 600;
        }

        .logout-btn .menu-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: rgba(255, 80, 80, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
            transition: all 0.22s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 80, 80, 0.22);
            border-color: rgba(255, 80, 80, 0.5);
            color: #ff6b6b;
            transform: translateX(2px);
        }

        .logout-btn:hover .menu-icon {
            background: rgba(255, 80, 80, 0.3);
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
            margin-left: 200px;
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
            gap: 2px;
        }

        .user-indicator .user-name {
            font-weight: 600;
            color: #1a1a1a;
            font-size: 15px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
        }

        .user-indicator .user-role {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            text-transform: capitalize;
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
            text-decoration: none;
            cursor: pointer;
        }

        .stat-card:visited {
            color: white;
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
            min-width: 0;
            overflow: hidden;
        }

        .stat-card h3 {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.2);
            white-space: nowrap;
            overflow: hidden;
            width: 100%;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-filter {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            background: white;
            border: 1px solid #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #436026;
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
                width: 200px;
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
                font-size: 24px;
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
            <span class="app-name">When in Baguio Inc.</span>
        </div>

        <div class="sidebar-menu">
            <span class="menu-section-label">Main</span>
            <a href="{{ route('dashboard') }}" class="menu-item active">
                <span class="menu-icon"><i class="fas fa-home"></i></span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('remittance') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-file-invoice-dollar"></i></span>
                <span>Remittance</span>
            </a>
            <a href="{{ route('bank-deposit') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-university"></i></span>
                <span>Bank &amp; Deposit</span>
            </a>

            <div class="menu-divider"></div>
            <span class="menu-section-label">Management</span>
            <a href="{{ route('merchants') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-store"></i></span>
                <span>Merchants</span>
            </a>
            <a href="{{ route('members.index') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-users-cog"></i></span>
                <span>Member Management</span>
            </a>
            <a href="{{ route('audit-logs') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-clipboard-list"></i></span>
                <span>Audit Logs</span>
            </a>

            <div class="menu-divider"></div>
            <span class="menu-section-label">Account</span>
            <a href="{{ route('profile') }}" class="menu-item">
                <span class="menu-icon"><i class="fas fa-user"></i></span>
                <span>Profile</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    <span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Dashboard</h1>
            <div class="user-indicator">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</span>
                </div>
                <a href="{{ route('profile') }}" class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </a>
            </div>
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

        // Orders by Month Chart — connected to real merchant sales (remittances)
        const ordersData = @json($monthlySales);
        const defaultYear = {{ $chartYears[0] }};

        const ordersCtx = document.getElementById('ordersByMonthChart').getContext('2d');
        const ordersByMonthChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: ordersData[defaultYear] || Array(12).fill(0),
                    backgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return value === 0 ? 'rgba(67,96,38,0.15)' : '#436026';
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                    hoverBackgroundColor: '#ffd300'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(ctx) {
                                return ctx.parsed.y === 0 ?
                                    ' No data' :
                                    ' ₱' + ctx.parsed.y.toLocaleString('en-PH', {
                                        minimumFractionDigits: 2
                                    });
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
                                return '₱' + value.toLocaleString('en-PH');
                            }
                        }
                    }
                }
            }
        });

        function updateOrdersByMonth(year) {
            ordersByMonthChart.data.datasets[0].data = ordersData[year] || Array(12).fill(0);
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
