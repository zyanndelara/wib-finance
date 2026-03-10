<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Merchants - When in Baguio Inc.</title>
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

        /* Toast Notification Styles */
        #toastContainer {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .custom-toast {
            min-width: 300px;
            max-width: 500px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-left: 4px solid #28a745;
            animation: slideIn 0.3s ease-out;
            opacity: 1;
            transition: opacity 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-icon {
            font-size: 24px;
            color: #28a745;
            flex-shrink: 0;
        }

        .toast-message {
            flex: 1;
            color: #333;
            font-size: 14px;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #999;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #333;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: #28a745;
            animation: progress 3s linear;
        }

        @keyframes progress {
            from {
                width: 100%;
            }
            to {
                width: 0;
            }
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

        /* Success Alert */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
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

        .merchant-search-wrap {
            position: relative;
            display: flex;
            align-items: center;
            flex: 1;
            min-width: 220px;
        }
        .merchant-search-wrap i {
            position: absolute;
            left: 12px;
            color: #9ca3af;
            font-size: 13px;
            pointer-events: none;
        }
        .merchant-search-input {
            width: 100%;
            padding: 9px 14px 9px 36px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            background: #f9fafb;
            color: #374151;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .merchant-search-input:focus {
            border-color: #357a3a;
            box-shadow: 0 0 0 3px rgba(53, 122, 58, 0.1);
            background: #ffffff;
        }
        .merchant-row:hover { background: #f0fdf4; }
        .merchant-row:hover .merchant-action-btn { opacity: 1; }
        .merchant-row td {
            padding: 14px 16px;
            font-size: 13.5px;
            color: #374151;
            vertical-align: middle;
        }
        .merchant-row { border-bottom: 1px solid #f0f4f1; transition: background .15s; }
        .merchant-action-btn {
            opacity: .75;
            transition: opacity .15s, transform .15s, box-shadow .15s;
        }
        .merchant-action-btn:hover {
            opacity: 1 !important;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0,0,0,.12) !important;
        }
        .stat-card {
            border-radius: 12px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            position: relative;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
            color: #fff;
            cursor: default;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ffd300, transparent);
        }
        .stat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            transform: translate(35%, -35%);
            pointer-events: none;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,.22); }
        .stat-card.green  { background: linear-gradient(135deg,#2d5a1b 0%,#4a8c30 100%); box-shadow: 0 6px 18px rgba(45,90,27,.35); }
        .stat-card.blue   { background: linear-gradient(135deg,#1a4f8a 0%,#2e7ed1 100%); box-shadow: 0 6px 18px rgba(26,79,138,.35); }
        .stat-card.amber  { background: linear-gradient(135deg,#8a5a00 0%,#d48c00 100%); box-shadow: 0 6px 18px rgba(138,90,0,.35); }
        .stat-card.purple { background: linear-gradient(135deg,#4a2a96 0%,#7c4fd1 100%); box-shadow: 0 6px 18px rgba(74,42,150,.35); }
        .stat-card .sc-icon {
            font-size: 26px;
            opacity: .9;
            filter: drop-shadow(2px 2px 4px rgba(0,0,0,.2));
            flex-shrink: 0;
        }
        .stat-card .sc-body {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            min-width: 0;
        }
        .stat-card .sc-label {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .7px;
            opacity: .85;
        }
        .stat-card .sc-value {
            font-size: 30px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -.5px;
            text-shadow: 1px 2px 6px rgba(0,0,0,.18);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .stat-card .sc-sub {
            font-size: 11px;
            opacity: .8;
            font-weight: 600;
        }
        .stat-card .sc-badge {
            position: absolute;
            top: 12px;
            right: 14px;
            font-size: 10px;
            font-weight: 700;
            background: rgba(255,255,255,.2);
            color: #fff;
            border-radius: 20px;
            padding: 2px 9px;
            letter-spacing: .3px;
        }
        .filter-select {
            padding: 9px 12px;
            border-radius: 8px;
            border: 1.5px solid #e5e7eb;
            font-size: 13px;
            outline: none;
            background: #f9fafb;
            color: #374151;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s;
        }
        .filter-select:focus, .filter-select:hover { border-color: #357a3a; box-shadow: 0 0 0 3px rgba(53,122,58,.08); }
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
            <a href="{{ route('dashboard') }}" class="menu-item">
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
            <a href="{{ route('merchants') }}" class="menu-item active">
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
            <h1>Merchant &amp; Partner Hub</h1>
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

        <!-- ── Stat Cards ── -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px;margin-bottom:22px;">

            @php $activeCount = $merchants->where('status','active')->count(); @endphp

            <div class="stat-card green">
                <i class="fas fa-peso-sign sc-icon"></i>
                <div class="sc-body">
                    <div class="sc-label">WIB Commission</div>
                    <div class="sc-value" id="stat_total">&#8369;{{ number_format($totalWibCommission, 2) }}</div>
                </div>
            </div>

            <div class="stat-card blue">
                <i class="fas fa-handshake sc-icon"></i>
                <div class="sc-body">
                    <div class="sc-label">Partner Sales</div>
                    <div class="sc-value" id="stat_partner">₱{{ number_format($partnerSales, 2) }}</div>
                    <div class="sc-sub" id="stat_partner_sub">{{ $partnerCount }} partner merchant{{ $partnerCount !== 1 ? 's' : '' }}</div>
                </div>
            </div>

            <div class="stat-card amber">
                <i class="fas fa-store-alt sc-icon"></i>
                <div class="sc-body">
                    <div class="sc-label">Non-Partner Sales</div>
                    <div class="sc-value" id="stat_nonpartner">₱{{ number_format($nonPartnerSales, 2) }}</div>
                    <div class="sc-sub" id="stat_nonpartner_sub">{{ $nonPartnerCount }} non-partner merchant{{ $nonPartnerCount !== 1 ? 's' : '' }}</div>
                </div>
            </div>

            <div class="stat-card purple">
                <i class="fas fa-chart-line sc-icon"></i>
                <div class="sc-body">
                    <div class="sc-label">GT Sales</div>
                    <div class="sc-value">&#8369;{{ number_format($gtSales, 2) }}</div>
                    <div class="sc-sub">Grand total across all merchants</div>
                </div>
            </div>

        </div>
        <!-- ── Search & Filters ── -->
        <div style="background:#fff;border-radius:14px;padding:16px 20px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);margin-bottom:16px;">
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div class="merchant-search-wrap" style="flex:1;min-width:220px;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="merchantSearch"
                        placeholder="Search by name, category, address…"
                        class="merchant-search-input"
                        oninput="filterMerchants()" autocomplete="off">
                </div>
                <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                    <div style="display:flex;align-items:center;gap:5px;">
                        <span style="font-size:11px;font-weight:600;color:#9ca3af;white-space:nowrap;"><i class="fas fa-tag" style="font-size:10px;"></i> Type</span>
                        <select id="merchantTypeFilter" onchange="filterMerchants()" class="filter-select">
                            <option value="all">All Types</option>
                            <option value="partner">Partner</option>
                            <option value="non-partner">Non-Partner</option>
                        </select>
                    </div>
                    <div style="width:1px;height:24px;background:#e5e7eb;"></div>
                    <div style="display:flex;align-items:center;gap:5px;">
                        <span style="font-size:11px;font-weight:600;color:#9ca3af;white-space:nowrap;"><i class="fas fa-circle" style="font-size:7px;"></i> Status</span>
                        <select id="merchantStatusFilter" onchange="filterMerchants()" class="filter-select">
                            <option value="all">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div style="width:1px;height:24px;background:#e5e7eb;"></div>
                    <div style="display:flex;align-items:center;gap:5px;">
                        <span style="font-size:11px;font-weight:600;color:#9ca3af;white-space:nowrap;"><i class="fas fa-calendar" style="font-size:10px;"></i> Period</span>
                        <select id="merchantPeriodFilter" onchange="filterMerchants()" class="filter-select">
                            <option value="all">All Period</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="bimonth">Bi Month</option>
                            <option value="trimonth">Tri Month</option>
                        </select>
                    </div>
                    <div style="width:1px;height:24px;background:#e5e7eb;"></div>
                    <button type="button" onclick="openAddModal()"
                        style="padding:9px 20px;border-radius:9px;border:none;background:linear-gradient(135deg,#357a3a,#2a6030);color:#fff;font-size:13px;cursor:pointer;display:inline-flex;align-items:center;gap:7px;font-weight:700;white-space:nowrap;box-shadow:0 3px 10px rgba(53,122,58,.4);transition:transform .15s,box-shadow .15s;" onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 5px 15px rgba(53,122,58,.5)'" onmouseout="this.style.transform='';this.style.boxShadow='0 3px 10px rgba(53,122,58,.4)'">
                        <i class="fas fa-plus"></i> Add Merchant
                    </button>
                </div>
            </div>
        </div>

        <!-- ── Merchant Table ── -->
        <div style="background:#fff;border-radius:16px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 16px rgba(0,0,0,.04);overflow:hidden;">
            <div style="padding:18px 20px 14px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between;">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div style="width:34px;height:34px;border-radius:9px;background:linear-gradient(135deg,#357a3a,#56a35b);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-store" style="font-size:15px;color:#fff;"></i>
                    </div>
                    <div>
                        <h3 style="margin:0;font-size:15px;font-weight:700;color:#111827;">Merchant Directory</h3>
                        <p style="margin:0;font-size:11px;color:#9ca3af;">All registered merchants &amp; partners</p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    
                    <span id="partnerBadge" style="background:#dbeafe;color:#1e40af;border:1px solid #bfdbfe;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:700;">{{ $partnerCount }} partner</span>
                    <span id="nonPartnerBadge" style="background:#fef9c3;color:#854d0e;border:1px solid #fde68a;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:700;">{{ $nonPartnerCount }} non-partner</span>
                    <span id="merchantCount" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;border-radius:20px;padding:4px 12px;font-size:12px;font-weight:700;">{{ $merchants->count() }} merchants</span>
                </div>
            </div>
            <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;min-width:1100px;">
                <thead>
                    <tr style="background:#f8fafc;border-bottom:1.5px solid #e9ecef;">
                        <th style="padding:13px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Merchant</th>
                        <th style="padding:13px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Type</th>
                        <th style="padding:13px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Commission Type</th>
                        <th style="padding:13px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Commission Details</th>
                        <th style="padding:13px 16px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Status</th>
                        <th style="padding:13px 16px;text-align:right;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Orders</th>
                        <th style="padding:13px 16px;text-align:right;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Sales</th>
                        <th style="padding:13px 16px;text-align:right;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">WIB Commission</th>
                        <th style="padding:13px 16px;text-align:center;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:.7px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($merchants as $merchant)
                    <tr id="merchant-row-{{ $merchant->id }}" class="merchant-row"
                        data-name="{{ strtolower($merchant->name) }}"
                        data-category="{{ strtolower($merchant->category ?? '') }}"
                        data-address="{{ strtolower($merchant->address ?? '') }}"
                        data-type="{{ $merchant->type }}"
                        data-status="{{ $merchant->status }}"
                        data-created="{{ $merchant->created_at->toDateString() }}">
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:38px;height:38px;border-radius:10px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="fas fa-store" style="font-size:15px;color:#3b6e2f;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:14px;color:#111827;">{{ $merchant->name }}</div>
                                    @if($merchant->address)
                                    <div style="font-size:11px;color:#9ca3af;margin-top:1px;">{{ Str::limit($merchant->address, 40) }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;{{ $merchant->type==='partner'?'background:#dcfce7;color:#166534;':'background:#fef9c3;color:#854d0e;' }}">
                                {{ ucfirst($merchant->type) }}
                            </span>
                        </td>
                        @php
                            $commType = $merchant->commission_type ?? 'percentage_based';
                            $ctStyles = [
                                'percentage_based'     => 'background:#dcfce7;color:#166534;',
                                'fixed_per_item'       => 'background:#ede9fe;color:#5b21b6;',
                                'category_based_fixed' => 'background:#d1fae5;color:#065f46;',
                                'fixed_per_order'      => 'background:#dbeafe;color:#1e40af;',
                                'mixed'                => 'background:#fae8ff;color:#7e22ce;',
                            ];
                            $ctLabels2 = [
                                'percentage_based'     => 'Percentage',
                                'fixed_per_item'       => 'Fixed / Item',
                                'category_based_fixed' => 'Cat. Fixed',
                                'fixed_per_order'      => 'Fixed / Order',
                                'mixed'                => 'Mixed',
                            ];
                            $ctStyle = $ctStyles[$commType] ?? 'background:#f3f4f6;color:#374151;';
                            $ctLabel2 = $ctLabels2[$commType] ?? ucwords(str_replace('_',' ',$commType));
                        @endphp
                        <td>
                            <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;{{ $ctStyle }}">
                                {{ $ctLabel2 }}
                            </span>
                        </td>
                        <td>
                            @if($commType === 'percentage_based')
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#374151;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;font-size:10px;"></i>Rate:</span>
                                    <span style="color:#357a3a;font-weight:700;"> {{ $merchant->commission_rate ?? 0 }}%</span>
                                </div>
                            @elseif($commType === 'fixed_per_item')
                                @php $citems = is_array($merchant->commission_items) ? $merchant->commission_items : []; @endphp
                                @if(count($citems))
                                    @php
                                        $amounts   = array_unique(array_column($citems, 'amount'));
                                        $amountStr = count($amounts) === 1
                                            ? '₱' . number_format($amounts[0], 2) . '/item'
                                            : '₱' . number_format(min($amounts), 2) . '–₱' . number_format(max($amounts), 2);
                                    @endphp
                                    <span style="display:inline-flex;align-items:center;gap:5px;background:#faf5ff;border:1px solid #e9d5ff;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;color:#7c4fd1;white-space:nowrap;">
                                        <i class="fas fa-tags" style="font-size:10px;"></i>
                                        {{ count($citems) }} item{{ count($citems) > 1 ? 's' : '' }}
                                        <span style="color:#9ca3af;font-weight:500;">&bull;</span>
                                        {{ $amountStr }}
                                    </span>
                                @else
                                    <span style="color:#9ca3af;font-size:12px;"><i class="fas fa-tags" style="margin-right:4px;"></i>No items set</span>
                                @endif
                            @elseif($commType === 'category_based_fixed')
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#557a3a;font-weight:600;"><i class="fas fa-utensils" style="margin-right:4px;font-size:10px;"></i>Food:</span>
                                    <span style="color:#357a3a;font-weight:700;"> ₱{{ number_format($merchant->commission_food_amount ?? 0,2) }}</span>
                                </div>
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#557a3a;font-weight:600;"><i class="fas fa-glass-cheers" style="margin-right:4px;font-size:10px;"></i>Drinks:</span>
                                    <span style="color:#357a3a;font-weight:700;"> ₱{{ number_format($merchant->commission_drinks_amount ?? 0,2) }}</span>
                                </div>
                            @elseif($commType === 'fixed_per_order')
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#1a4f7a;font-weight:600;"><i class="fas fa-box-open" style="margin-right:4px;font-size:10px;"></i>Small Order:</span>
                                    <span style="color:#1a7ed1;font-weight:700;"> ₱{{ number_format($merchant->commission_small_amount ?? 0,2) }}</span>
                                </div>
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#1a4f7a;font-weight:600;"><i class="fas fa-box" style="margin-right:4px;font-size:10px;"></i>Big Order:</span>
                                    <span style="color:#1a7ed1;font-weight:700;"> ₱{{ number_format($merchant->commission_big_amount ?? 0,2) }}</span>
                                </div>
                            @elseif($commType === 'mixed')
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#5a3a7a;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;font-size:10px;"></i>Percentage:</span>
                                    <span style="color:#7c4fd1;font-weight:700;"> {{ $merchant->commission_mixed_percentage ?? 0 }}%</span>
                                </div>
                                <div style="font-size:12px;line-height:1.8;">
                                    <span style="color:#5a3a7a;font-weight:600;"><i class="fas fa-coins" style="margin-right:4px;font-size:10px;"></i>Fixed Amount:</span>
                                    <span style="color:#7c4fd1;font-weight:700;"> ₱{{ number_format($merchant->commission_mixed_amount ?? 0,2) }}</span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;{{ $merchant->status==='active'?'background:#dcfce7;color:#166534;':'background:#fee2e2;color:#991b1b;' }}">
                                {{ ucfirst($merchant->status) }}
                            </span>
                        </td>
                        <td style="text-align:right;font-size:13px;font-weight:700;color:#374151;">{{ number_format($merchant->total_orders ?? 0) }}</td>
                        <td style="text-align:right;font-size:13px;font-weight:700;color:#374151;">₱{{ number_format($merchant->total_sales ?? 0, 2) }}</td>
                        <td style="text-align:right;font-size:13px;font-weight:700;color:#357a3a;">₱{{ number_format($merchant->total_commission ?? 0, 2) }}</td>
                        <td style="text-align:center;">
                            <div style="display:flex;gap:6px;justify-content:center;">
                                <button onclick="openViewModal({{ $merchant->id }})"
                                    class="merchant-action-btn"
                                    style="background:#eff6ff;color:#1a7ed1;border:1px solid #bfdbfe;border-radius:8px;padding:7px 13px;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-weight:700;box-shadow:0 1px 3px rgba(26,126,209,.1);">
                                    <i class="fas fa-eye"></i> View
                                </button>
                                <button onclick="openEditModal({{ $merchant->id }})"
                                    class="merchant-action-btn"
                                    style="background:#fffbeb;color:#d97706;border:1px solid #fde68a;border-radius:8px;padding:7px 13px;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-weight:700;box-shadow:0 1px 3px rgba(217,119,6,.1);">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr id="merchantEmptyRow" style="display:none;">
                        <td colspan="10" style="text-align:center;padding:60px 20px;color:#888;">
                            <i class="fas fa-store" style="font-size:48px;margin-bottom:16px;display:block;opacity:.3;"></i>
                            <p style="font-size:15px;">No merchants found. Try adjusting your filters.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div><!-- /table scroll wrapper -->
            <!-- ── Pagination Bar ── -->
            <div id="paginationBar" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding:14px 20px;border-top:1px solid #f3f4f6;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:12px;color:#6b7280;">Rows per page:</span>
                    <select id="perPageSelect" onchange="changePerPage()" style="border:1px solid #e5e7eb;border-radius:6px;padding:4px 8px;font-size:12px;color:#374151;outline:none;cursor:pointer;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span id="paginationInfo" style="font-size:12px;color:#6b7280;"></span>
                </div>
                <div id="paginationButtons" style="display:flex;gap:4px;align-items:center;"></div>
            </div>
        </div>
    </div><!-- /main-content -->

    <!-- ====== VIEW MERCHANT MODAL ====== -->
    <div id="viewModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:2000;align-items:center;justify-content:center;padding:16px;">
        <div style="background:#f8fafc;border-radius:18px;width:660px;max-width:100%;max-height:92vh;box-shadow:0 20px 60px rgba(0,0,0,.25);overflow:hidden;position:relative;animation:modalIn .2s ease;display:flex;flex-direction:column;">

            <!-- Header -->
            <div style="background:linear-gradient(135deg,#1a3a6b 0%,#1a7ed1 100%);padding:24px 28px 20px;position:relative;flex-shrink:0;">
                <button onclick="closeModal('viewModal')" style="position:absolute;top:14px;right:16px;background:rgba(255,255,255,.15);border:none;width:32px;height:32px;border-radius:50%;font-size:18px;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .2s;" onmouseover="this.style.background='rgba(255,255,255,.28)'" onmouseout="this.style.background='rgba(255,255,255,.15)'">&times;</button>
                <div style="display:flex;align-items:center;gap:16px;">
                    <div style="width:62px;height:62px;border-radius:16px;background:rgba(255,255,255,.18);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid rgba(255,255,255,.25);">
                        <i class="fas fa-store" style="font-size:28px;color:#fff;"></i>
                    </div>
                    <div>
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                            <span style="font-size:10px;color:rgba(255,255,255,.65);letter-spacing:1.2px;text-transform:uppercase;font-weight:700;">Merchant Profile</span>
                            <span id="view_type_badge" style="font-size:10px;font-weight:700;text-transform:uppercase;padding:2px 8px;border-radius:20px;background:rgba(255,255,255,.2);color:#fff;letter-spacing:.5px;"></span>
                        </div>
                        <h3 id="viewModalTitle" style="color:#fff;font-size:20px;font-weight:800;margin:0;line-height:1.2;">—</h3>
                        <div id="view_address_sub" style="font-size:12px;color:rgba(255,255,255,.65);margin-top:4px;display:flex;align-items:center;gap:5px;"><i class="fas fa-map-marker-alt" style="font-size:10px;"></i><span id="view_address_short">—</span></div>
                    </div>
                </div>
                <!-- Stats strip -->
                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-top:18px;">
                    <div style="background:rgba(255,255,255,.12);border-radius:10px;padding:10px 14px;border:1px solid rgba(255,255,255,.15);">
                        <div style="font-size:10px;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.8px;font-weight:700;margin-bottom:3px;"><i class="fas fa-shopping-bag" style="margin-right:4px;"></i>Orders</div>
                        <div id="view_total_orders" style="font-size:18px;font-weight:800;color:#fff;">0</div>
                    </div>
                    <div style="background:rgba(255,255,255,.12);border-radius:10px;padding:10px 14px;border:1px solid rgba(255,255,255,.15);">
                        <div style="font-size:10px;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.8px;font-weight:700;margin-bottom:3px;"><i class="fas fa-peso-sign" style="margin-right:4px;"></i>Sales</div>
                        <div id="view_total_sales" style="font-size:18px;font-weight:800;color:#fff;">₱0.00</div>
                    </div>
                    <div style="background:rgba(255,255,255,.12);border-radius:10px;padding:10px 14px;border:1px solid rgba(255,255,255,.15);">
                        <div style="font-size:10px;color:rgba(255,255,255,.65);text-transform:uppercase;letter-spacing:.8px;font-weight:700;margin-bottom:3px;"><i class="fas fa-hand-holding-usd" style="margin-right:4px;"></i>WIB Commission</div>
                        <div id="view_total_commission" style="font-size:18px;font-weight:800;color:#7ee8a2;">₱0.00</div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div style="padding:22px 28px 8px;overflow-y:auto;flex:1;">

                <!-- Info Row: Status -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                    <div style="font-size:13px;color:#6b7280;font-weight:600;">Account Status</div>
                    <div id="view_status" style="font-size:13px;font-weight:700;padding:4px 14px;border-radius:20px;">—</div>
                </div>

                <!-- Commission Section -->
                <div style="background:#fff;border:1px solid #e9ecef;border-radius:12px;overflow:hidden;margin-bottom:16px;">
                    <div style="padding:12px 16px;background:#f0f6ff;border-bottom:1px solid #e0eaff;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-percentage" style="color:#1a7ed1;font-size:13px;"></i>
                        <span style="font-size:12px;font-weight:700;color:#1e3a5f;text-transform:uppercase;letter-spacing:.7px;">Commission Structure</span>
                        <span id="view_commission_type" style="margin-left:auto;font-size:11px;font-weight:700;padding:2px 10px;border-radius:20px;background:#dbeafe;color:#1e40af;">—</span>
                    </div>
                    <div style="padding:16px;">
                        <!-- percentage_based -->
                        <div id="view_rate_col" style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #bbf7d0;">
                            <span style="font-size:13px;color:#166534;font-weight:600;"><i class="fas fa-percent" style="margin-right:6px;font-size:11px;"></i>Commission Rate</span>
                            <span id="view_commission_rate" style="font-size:17px;font-weight:800;color:#166534;">—</span>
                        </div>
                        <!-- category_based_fixed -->
                        <div id="view_cat_fields" style="display:none;grid-template-columns:1fr 1fr;gap:10px;">
                            <div style="padding:10px 14px;background:#f0fdf4;border-radius:8px;border:1px solid #a7f3d0;text-align:center;">
                                <div style="font-size:10px;color:#065f46;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-utensils" style="margin-right:3px;"></i>Food</div>
                                <div id="view_commission_food_amount" style="font-size:20px;font-weight:800;color:#065f46;">—</div>
                            </div>
                            <div style="padding:10px 14px;background:#ecfdf5;border-radius:8px;border:1px solid #a7f3d0;text-align:center;">
                                <div style="font-size:10px;color:#065f46;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-glass-cheers" style="margin-right:3px;"></i>Drinks</div>
                                <div id="view_commission_drinks_amount" style="font-size:20px;font-weight:800;color:#065f46;">—</div>
                            </div>
                        </div>
                        <!-- fixed_per_order -->
                        <div id="view_order_fields" style="display:none;grid-template-columns:1fr 1fr;gap:10px;">
                            <div style="padding:10px 14px;background:#eff6ff;border-radius:8px;border:1px solid #bfdbfe;text-align:center;">
                                <div style="font-size:10px;color:#1e40af;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-box-open" style="margin-right:3px;"></i>Small Order</div>
                                <div id="view_commission_small_amount" style="font-size:20px;font-weight:800;color:#1e40af;">—</div>
                            </div>
                            <div style="padding:10px 14px;background:#dbeafe;border-radius:8px;border:1px solid #bfdbfe;text-align:center;">
                                <div style="font-size:10px;color:#1e40af;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-box" style="margin-right:3px;"></i>Big Order</div>
                                <div id="view_commission_big_amount" style="font-size:20px;font-weight:800;color:#1e40af;">—</div>
                            </div>
                        </div>
                        <!-- mixed -->
                        <div id="view_mixed_fields" style="display:none;grid-template-columns:1fr 1fr;gap:10px;">
                            <div style="padding:10px 14px;background:#faf5ff;border-radius:8px;border:1px solid #e9d5ff;text-align:center;">
                                <div style="font-size:10px;color:#6b21a8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-percent" style="margin-right:3px;"></i>Percentage</div>
                                <div id="view_commission_mixed_percentage" style="font-size:20px;font-weight:800;color:#6b21a8;">—</div>
                            </div>
                            <div style="padding:10px 14px;background:#f5f3ff;border-radius:8px;border:1px solid #e9d5ff;text-align:center;">
                                <div style="font-size:10px;color:#6b21a8;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;"><i class="fas fa-coins" style="margin-right:3px;"></i>Fixed Amount</div>
                                <div id="view_commission_mixed_amount" style="font-size:20px;font-weight:800;color:#6b21a8;">—</div>
                            </div>
                        </div>
                        <!-- fixed_per_item -->
                        <div id="view_item_fields" style="display:none;">
                            <div id="view_item_list"></div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div style="background:#fff;border:1px solid #e9ecef;border-radius:12px;padding:14px 16px;margin-bottom:16px;">
                    <div style="display:flex;align-items:flex-start;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:8px;background:#fff7ed;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid #fed7aa;">
                            <i class="fas fa-map-marker-alt" style="color:#ea580c;font-size:13px;"></i>
                        </div>
                        <div>
                            <div style="font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.7px;margin-bottom:4px;">Address</div>
                            <div id="view_address" style="font-size:14px;color:#374151;line-height:1.6;font-weight:500;">—</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div style="padding:14px 28px 20px;display:flex;justify-content:space-between;align-items:center;border-top:1px solid #f3f4f6;background:#fff;flex-shrink:0;">
                <span id="view_footer_meta" style="font-size:11px;color:#9ca3af;"></span>
                <div style="display:flex;gap:8px;">
                    <button type="button" id="view_edit_btn" style="background:#fffbeb;color:#d97706;border:1px solid #fde68a;border-radius:8px;padding:8px 18px;font-size:13px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:6px;"><i class="fas fa-edit"></i> Edit</button>
                    <button type="button" onclick="closeModal('viewModal')" style="background:linear-gradient(135deg,#1a3a6b,#1a7ed1);color:#fff;border:none;border-radius:8px;padding:8px 20px;font-size:13px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:6px;"><i class="fas fa-times"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ====== ADD MERCHANT MODAL ======-->
    <div id="addModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:2000;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:14px;width:520px;max-width:96vw;max-height:90vh;box-shadow:0 8px 32px rgba(0,0,0,.18);overflow:hidden;position:relative;animation:modalIn .2s ease;display:flex;flex-direction:column;">
            <button onclick="closeModal('addModal')" style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:22px;color:rgba(255,255,255,.85);cursor:pointer;z-index:1;">&times;</button>
            <div style="background:linear-gradient(135deg,#2d4016,#4a7a2e);padding:22px 28px 18px;display:flex;align-items:center;gap:14px;">
                <div style="width:56px;height:56px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 10px rgba(0,0,0,.2);">
                    <i class="fas fa-store-alt" style="font-size:26px;color:#3b6e2f;"></i>
                </div>
                <div>
                    <p style="font-size:11px;color:rgba(255,255,255,.7);letter-spacing:1px;text-transform:uppercase;margin-bottom:3px;">New Record</p>
                    <h3 style="color:#fff;font-size:18px;font-weight:700;">Add Merchant</h3>
                </div>
            </div>
            <form id="addMerchantForm" onsubmit="submitAddMerchant(event)" style="display:flex;flex-direction:column;flex:1;min-height:0;">
                @csrf
                <div style="padding:24px 28px 8px;overflow-y:auto;flex:1;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div style="margin-bottom:0;">
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Merchant Name <span style="color:#dc3545;">*</span></label>
                            <input type="text" name="name" class="modal-input" placeholder="e.g. Storely" required style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Type <span style="color:#dc3545;">*</span></label>
                            <select name="type" required style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="partner">Partner</option>
                                <option value="non-partner">Non-Partner</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Status</label>
                            <select name="status" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Commission Type <span style="color:#dc3545;">*</span></label>
                            <select name="commission_type" id="add_commission_type" onchange="updateCommissionLabel('add')" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="percentage_based">Percentage-Based</option>
                                <option value="fixed_per_item">Fixed Per Item</option>
                                <option value="category_based_fixed">Category-Based Fixed (Food/Drinks)</option>
                                <option value="fixed_per_order">Fixed Per Order (Small/Big)</option>
                                <option value="mixed">Mixed Commission</option>
                            </select>
                        </div>
                        <div id="add_rate_col">
                            <label id="add_commission_rate_label" style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Rate (%)</label>
                            <input type="number" id="add_commission_rate" name="commission_rate" min="0" step="0.01" value="10" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;">
                        </div>
                    </div>
                    <div id="add_cat_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#557a3a;margin-bottom:5px;font-weight:600;"><i class="fas fa-utensils" style="margin-right:4px;"></i>Food Amount (₱)</label>
                            <input type="number" id="add_commission_food_amount" name="commission_food_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #a7d7a9;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f6fff6;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#557a3a;margin-bottom:5px;font-weight:600;"><i class="fas fa-glass-cheers" style="margin-right:4px;"></i>Drinks Amount (₱)</label>
                            <input type="number" id="add_commission_drinks_amount" name="commission_drinks_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #a7d7a9;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f6fff6;">
                        </div>
                    </div>
                    <div id="add_order_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#1a4f7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-box-open" style="margin-right:4px;"></i>Small Order Amount (₱)</label>
                            <input type="number" id="add_commission_small_amount" name="commission_small_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #90c4e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f0f8ff;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#1a4f7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-box" style="margin-right:4px;"></i>Big Order Amount (₱)</label>
                            <input type="number" id="add_commission_big_amount" name="commission_big_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #90c4e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f0f8ff;">
                        </div>
                    </div>
                    <div id="add_mixed_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#5a3a7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;"></i>Percentage (%)</label>
                            <input type="number" id="add_commission_mixed_percentage" name="commission_mixed_percentage" min="0" max="100" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #c4a7e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#faf6ff;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#5a3a7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-coins" style="margin-right:4px;"></i>Fixed Amount (₱)</label>
                            <input type="number" id="add_commission_mixed_amount" name="commission_mixed_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #c4a7e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#faf6ff;">
                        </div>
                    </div>
                    <div id="add_item_fields" style="display:none;margin-top:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <label style="font-size:13px;color:#7c4fd1;font-weight:600;"><i class="fas fa-tags" style="margin-right:5px;"></i>Item Commissions</label>
                            <button type="button" onclick="addItemRow('add')" style="background:#ede9fe;color:#7c4fd1;border:1.5px solid #ddd6fe;border-radius:7px;padding:5px 12px;font-size:12px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:5px;"><i class="fas fa-plus"></i> Add Item</button>
                        </div>
                        <div id="add_item_rows"></div>
                    </div>
                    <div style="margin-top:14px;">
                        <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Address</label>
                        <textarea name="address" rows="2" placeholder="Street, City…" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;resize:vertical;"></textarea>
                    </div>
                </div>
                <div style="padding:12px 28px 24px;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;border-top:1px solid #f3f4f6;">
                    <button type="button" onclick="closeModal('addModal')" style="background:#f0f0f0;color:#555;border:none;border-radius:7px;padding:9px 20px;font-size:14px;cursor:pointer;font-weight:600;">Cancel</button>
                    <button type="submit" id="addSubmitBtn" style="background:#357a3a;color:#fff;border:none;border-radius:7px;padding:9px 20px;font-size:14px;cursor:pointer;font-weight:600;display:inline-flex;align-items:center;gap:7px;">
                        <i class="fas fa-save"></i> Save Merchant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== EDIT MERCHANT MODAL ====== -->
    <div id="editModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:2000;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:14px;width:520px;max-width:96vw;max-height:90vh;box-shadow:0 8px 32px rgba(0,0,0,.18);overflow:hidden;position:relative;animation:modalIn .2s ease;display:flex;flex-direction:column;">
            <button onclick="closeModal('editModal')" style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:22px;color:rgba(255,255,255,.85);cursor:pointer;z-index:1;">&times;</button>
            <div style="background:linear-gradient(135deg,#2d4016,#4a7a2e);padding:22px 28px 18px;display:flex;align-items:center;gap:14px;">
                <div style="width:56px;height:56px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 2px 10px rgba(0,0,0,.2);">
                    <i class="fas fa-edit" style="font-size:26px;color:#3b6e2f;"></i>
                </div>
                <div>
                    <p style="font-size:11px;color:rgba(255,255,255,.7);letter-spacing:1px;text-transform:uppercase;margin-bottom:3px;">Editing</p>
                    <h3 id="editModalTitle" style="color:#fff;font-size:18px;font-weight:700;">—</h3>
                </div>
            </div>
            <form id="editMerchantForm" onsubmit="submitEditMerchant(event)" style="display:flex;flex-direction:column;flex:1;min-height:0;">
                @csrf
                @method('PUT')
                <input type="hidden" id="editMerchantId">
                <div style="padding:24px 28px 8px;overflow-y:auto;flex:1;">
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Merchant Name <span style="color:#dc3545;">*</span></label>
                            <input type="text" id="edit_name" name="name" required style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Type <span style="color:#dc3545;">*</span></label>
                            <select id="edit_type" name="type" required style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="partner">Partner</option>
                                <option value="non-partner">Non-Partner</option>
                            </select>
                        </div>
                    </div>
                    <div style="margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Status</label>
                            <select id="edit_status" name="status" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Commission Type <span style="color:#dc3545;">*</span></label>
                            <select id="edit_commission_type" name="commission_type" onchange="updateCommissionLabel('edit')" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#fff;">
                                <option value="percentage_based">Percentage-Based</option>
                                <option value="fixed_per_item">Fixed Per Item</option>
                                <option value="category_based_fixed">Category-Based Fixed (Food/Drinks)</option>
                                <option value="fixed_per_order">Fixed Per Order (Small/Big)</option>
                                <option value="mixed">Mixed Commission</option>
                            </select>
                        </div>
                        <div id="edit_rate_col">
                            <label id="edit_commission_rate_label" style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Rate (%)</label>
                            <input type="number" id="edit_commission_rate" name="commission_rate" min="0" step="0.01" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;">
                        </div>
                    </div>
                    <div id="edit_cat_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#557a3a;margin-bottom:5px;font-weight:600;"><i class="fas fa-utensils" style="margin-right:4px;"></i>Food Amount (₱)</label>
                            <input type="number" id="edit_commission_food_amount" name="commission_food_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #a7d7a9;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f6fff6;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#557a3a;margin-bottom:5px;font-weight:600;"><i class="fas fa-glass-cheers" style="margin-right:4px;"></i>Drinks Amount (₱)</label>
                            <input type="number" id="edit_commission_drinks_amount" name="commission_drinks_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #a7d7a9;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f6fff6;">
                        </div>
                    </div>
                    <div id="edit_order_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#1a4f7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-box-open" style="margin-right:4px;"></i>Small Order Amount (₱)</label>
                            <input type="number" id="edit_commission_small_amount" name="commission_small_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #90c4e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f0f8ff;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#1a4f7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-box" style="margin-right:4px;"></i>Big Order Amount (₱)</label>
                            <input type="number" id="edit_commission_big_amount" name="commission_big_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #90c4e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#f0f8ff;">
                        </div>
                    </div>
                    <div id="edit_mixed_fields" style="display:none;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px;">
                        <div>
                            <label style="display:block;font-size:13px;color:#5a3a7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;"></i>Percentage (%)</label>
                            <input type="number" id="edit_commission_mixed_percentage" name="commission_mixed_percentage" min="0" max="100" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #c4a7e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#faf6ff;">
                        </div>
                        <div>
                            <label style="display:block;font-size:13px;color:#5a3a7a;margin-bottom:5px;font-weight:600;"><i class="fas fa-coins" style="margin-right:4px;"></i>Fixed Amount (₱)</label>
                            <input type="number" id="edit_commission_mixed_amount" name="commission_mixed_amount" min="0" step="0.01" placeholder="0.00" style="width:100%;border:1.5px solid #c4a7e8;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;background:#faf6ff;">
                        </div>
                    </div>
                    <div id="edit_item_fields" style="display:none;margin-top:14px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                            <label style="font-size:13px;color:#7c4fd1;font-weight:600;"><i class="fas fa-tags" style="margin-right:5px;"></i>Item Commissions</label>
                            <button type="button" onclick="addItemRow('edit')" style="background:#ede9fe;color:#7c4fd1;border:1.5px solid #ddd6fe;border-radius:7px;padding:5px 12px;font-size:12px;cursor:pointer;font-weight:700;display:inline-flex;align-items:center;gap:5px;"><i class="fas fa-plus"></i> Add Item</button>
                        </div>
                        <div id="edit_item_rows"></div>
                    </div>
                    <div style="margin-top:14px;">
                        <label style="display:block;font-size:13px;color:#555;margin-bottom:5px;font-weight:600;">Address</label>
                        <textarea id="edit_address" name="address" rows="2" style="width:100%;border:1px solid #ddd;border-radius:7px;padding:9px 12px;font-size:14px;outline:none;resize:vertical;"></textarea>
                    </div>
                </div>
                <div style="padding:12px 28px 24px;display:flex;justify-content:flex-end;gap:10px;flex-shrink:0;border-top:1px solid #f3f4f6;">
                    <button type="button" onclick="closeModal('editModal')" style="background:#f0f0f0;color:#555;border:none;border-radius:7px;padding:9px 20px;font-size:14px;cursor:pointer;font-weight:600;">Cancel</button>
                    <button type="submit" id="editSubmitBtn" style="background:#357a3a;color:#fff;border:none;border-radius:7px;padding:9px 20px;font-size:14px;cursor:pointer;font-weight:600;display:inline-flex;align-items:center;gap:7px;">
                        <i class="fas fa-save"></i> Update Merchant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====== DELETE CONFIRM MODAL ====== -->
    <div id="deleteModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:2000;align-items:center;justify-content:center;">
        <div style="background:#fff;border-radius:14px;width:360px;max-width:96vw;box-shadow:0 8px 32px rgba(0,0,0,.18);overflow:hidden;position:relative;animation:modalIn .2s ease;">
            <div style="padding:32px 28px 0;text-align:center;">
                <div style="width:70px;height:70px;border-radius:50%;background:#fde8ea;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:30px;color:#dc3545;">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h3 style="font-size:18px;margin-bottom:8px;">Delete Merchant?</h3>
                <p style="color:#666;font-size:14px;line-height:1.5;">You are about to delete <strong id="deleteMerchantName">—</strong>. This action cannot be undone.</p>
            </div>
            <input type="hidden" id="deleteMerchantId">
            <div style="padding:22px 28px 24px;display:flex;justify-content:center;gap:12px;">
                <button onclick="closeModal('deleteModal')" style="background:#f0f0f0;color:#555;border:none;border-radius:7px;padding:9px 22px;font-size:14px;cursor:pointer;font-weight:600;">Cancel</button>
                <button id="deleteConfirmBtn" onclick="confirmDelete()" style="background:#dc3545;color:#fff;border:none;border-radius:7px;padding:9px 22px;font-size:14px;cursor:pointer;font-weight:600;display:inline-flex;align-items:center;gap:7px;">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>

    <style>
        @keyframes modalIn { from{transform:scale(.95);opacity:0} to{transform:scale(1);opacity:1} }
        #toastContainer { position:fixed;bottom:20px;right:20px;z-index:10000;display:flex;flex-direction:column;gap:10px; }
        .custom-toast { min-width:300px;max-width:500px;background:#fff;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,.15);padding:16px;display:flex;align-items:center;gap:12px;border-left:4px solid #28a745;animation:slideInToast .3s ease-out;position:relative;overflow:hidden; }
        @keyframes slideInToast { from{transform:translateX(400px);opacity:0} to{transform:translateX(0);opacity:1} }
        .toast-icon{font-size:24px;color:#28a745;flex-shrink:0;}
        .toast-message{flex:1;color:#333;font-size:14px;line-height:1.4;}
        .toast-close{background:none;border:none;font-size:20px;color:#999;cursor:pointer;padding:0;width:24px;height:24px;display:flex;align-items:center;justify-content:center;}
        .toast-progress{position:absolute;bottom:0;left:0;height:3px;background:#28a745;animation:toastProgress 3.5s linear;}
        @keyframes toastProgress{from{width:100%}to{width:0}}
    </style>

    @php
        $merchantsJson = $merchants->keyBy('id')->map(function($m) {
            return [
                'id'              => $m->id,
                'name'            => $m->name,
                'type'            => $m->type,
                'category'        => $m->category ?? '',
                'address'         => $m->address ?? '',
                'commission_rate'          => $m->commission_rate,
                'commission_type'          => $m->commission_type ?? 'percentage_based',
                'commission_food_amount'      => $m->commission_food_amount,
                'commission_drinks_amount'    => $m->commission_drinks_amount,
                'commission_small_amount'     => $m->commission_small_amount,
                'commission_big_amount'       => $m->commission_big_amount,
                'commission_mixed_percentage' => $m->commission_mixed_percentage,
                'commission_mixed_amount'     => $m->commission_mixed_amount,
                'commission_items'            => $m->commission_items ?? [],
                'status'                      => $m->status,
                'total_orders'                => $m->total_orders ?? 0,
                'total_sales'                 => $m->total_sales ?? 0,
                'total_commission'            => $m->total_commission ?? 0,
            ];
        });
    @endphp

    <script>
        // Merchant data JSON for edit pre-fill
        const merchantsData = @json($merchantsJson);

        // ── Modal helpers ──
        function openModal(id) {
            const el = document.getElementById(id);
            el.style.display = 'flex';
        }
        function closeModal(id) {
            document.getElementById(id).style.display = 'none';
        }
        // Close on backdrop click
        ['addModal','editModal','deleteModal'].forEach(id => {
            document.getElementById(id).addEventListener('click', function(e) {
                if (e.target === this) closeModal(id);
            });
        });

        // ── Commission label helper ──
        const commissionTypeLabels = {
            'percentage_based':    'Percentage-Based',
            'fixed_per_item':      'Fixed Per Item',
            'category_based_fixed':'Category-Based Fixed (Food/Drinks)',
            'fixed_per_order':     'Fixed Per Order (Small/Big)',
            'mixed':               'Mixed Commission',
        };
        const commissionRateLabels = {
            'percentage_based':    'Rate (%)',
            'fixed_per_item':      'Amount (₱ per item)',
            'category_based_fixed':'Amount (₱ per category)',
            'fixed_per_order':     'Amount (₱ per order)',
            'mixed':               'Commission Value',
        };
        function updateCommissionLabel(prefix) {
            const type        = document.getElementById(prefix + '_commission_type').value;
            const label       = document.getElementById(prefix + '_commission_rate_label');
            const rateCol     = document.getElementById(prefix + '_rate_col');
            const catFields   = document.getElementById(prefix + '_cat_fields');
            const orderFields = document.getElementById(prefix + '_order_fields');
            const mixedFields = document.getElementById(prefix + '_mixed_fields');
            const itemFields  = document.getElementById(prefix + '_item_fields');
            const isCat       = type === 'category_based_fixed';
            const isOrder     = type === 'fixed_per_order';
            const isMixed     = type === 'mixed';
            const isItem      = type === 'fixed_per_item';
            const hideRate    = isCat || isOrder || isMixed || isItem;
            if (rateCol)     rateCol.style.display     = hideRate ? 'none' : '';
            if (catFields)   catFields.style.display   = isCat   ? 'grid' : 'none';
            if (orderFields) orderFields.style.display = isOrder  ? 'grid' : 'none';
            if (mixedFields) mixedFields.style.display = isMixed  ? 'grid' : 'none';
            if (itemFields)  itemFields.style.display  = isItem   ? ''     : 'none';
            if (label)       label.textContent         = commissionRateLabels[type] || 'Commission Value';
            if (isItem) { const c = document.getElementById(prefix + '_item_rows'); if (c && !c.children.length) addItemRow(prefix); }
        }

        // ── Fixed-per-item row helpers ──
        function addItemRow(prefix, label='', amount='') {
            const container = document.getElementById(prefix + '_item_rows');
            if (!container) return;
            const row = document.createElement('div');
            row.className = 'item-row';
            row.style.cssText = 'display:grid;grid-template-columns:1fr 1fr auto;gap:8px;margin-bottom:8px;align-items:center;';
            row.innerHTML = `
                <input type="text" placeholder="Item name (e.g. Burger)" class="item-label"
                    value="${label.replace(/"/g, '&quot;')}"
                    style="border:1.5px solid #ddd6fe;border-radius:7px;padding:8px 10px;font-size:13px;outline:none;background:#fdf6ff;width:100%;">
                <input type="number" placeholder="0.00" class="item-amount" min="0" step="0.01"
                    value="${amount}"
                    style="border:1.5px solid #ddd6fe;border-radius:7px;padding:8px 10px;font-size:13px;outline:none;background:#fdf6ff;width:100%;">
                <button type="button" onclick="removeItemRow(this)"
                    style="width:32px;height:32px;border-radius:7px;border:none;background:#fee2e2;color:#dc3545;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;flex-shrink:0;">
                    <i class="fas fa-times"></i>
                </button>`;
            container.appendChild(row);
        }
        function removeItemRow(btn) {
            const container = btn.closest('.item-row').parentElement;
            if (container.querySelectorAll('.item-row').length > 1) btn.closest('.item-row').remove();
        }
        function resetItemRows(prefix) {
            const c = document.getElementById(prefix + '_item_rows');
            if (c) { c.innerHTML = ''; }
        }

        // ── Add ──
        function openAddModal() {
            document.getElementById('addMerchantForm').reset();
            resetItemRows('add');
            updateCommissionLabel('add');
            openModal('addModal');
        }

        async function submitAddMerchant(e) {
            e.preventDefault();
            const btn = document.getElementById('addSubmitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving…';
            const fd = new FormData(e.target);
            if (document.getElementById('add_commission_type').value === 'fixed_per_item') {
                const items = [];
                document.querySelectorAll('#add_item_rows .item-row').forEach(row => {
                    const lbl = row.querySelector('.item-label').value.trim();
                    const amt = row.querySelector('.item-amount').value.trim();
                    if (lbl || amt) items.push({ label: lbl, amount: amt });
                });
                fd.set('commission_items', JSON.stringify(items));
            }
            try {
                const resp = await fetch('{{ route("merchants.store") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd,
                });
                const data = await resp.json();
                if (data.success) {
                    const added = data.merchant;
                    merchantsData[added.id] = added;
                    insertMerchantRow(added);
                    updateStatCards();
                    applyFilter();
                    closeModal('addModal');
                    e.target.reset();
                    showToast(data.message, 'success');
                } else {
                    const msg = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'An error occurred.');
                    showToast(msg, 'error');
                }
            } catch { showToast('Network error. Please try again.', 'error'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Save Merchant';
            }
        }

        // ── View ──
        function openViewModal(id) {
            const m = merchantsData[id];
            if (!m) return;

            // Header
            document.getElementById('viewModalTitle').textContent = m.name;
            document.getElementById('view_address_short').textContent = m.address || 'No address on file';

            // Type badge
            const typeBadge = document.getElementById('view_type_badge');
            typeBadge.textContent = m.type === 'partner' ? 'Partner' : 'Non-Partner';
            typeBadge.style.background = m.type === 'partner' ? 'rgba(134,239,172,.25)' : 'rgba(253,224,71,.2)';

            // Stats strip
            document.getElementById('view_total_orders').textContent     = Number(m.total_orders||0).toLocaleString();
            document.getElementById('view_total_sales').textContent      = '₱' + _numFmt(m.total_sales||0);
            document.getElementById('view_total_commission').textContent = '₱' + _numFmt(m.total_commission||0);

            // Status badge
            const stEl = document.getElementById('view_status');
            const isActive = m.status === 'active';
            stEl.textContent = isActive ? 'Active' : 'Inactive';
            stEl.style.cssText = isActive
                ? 'font-size:13px;font-weight:700;padding:4px 14px;border-radius:20px;background:#dcfce7;color:#166534;'
                : 'font-size:13px;font-weight:700;padding:4px 14px;border-radius:20px;background:#fee2e2;color:#991b1b;';

            // Commission type label
            document.getElementById('view_commission_type').textContent = commissionTypeLabels[m.commission_type] || m.commission_type || '—';

            const isCatView   = m.commission_type === 'category_based_fixed';
            const isOrderView = m.commission_type === 'fixed_per_order';
            const isMixedView = m.commission_type === 'mixed';
            const isItemView  = m.commission_type === 'fixed_per_item';
            const showRate    = !isCatView && !isOrderView && !isMixedView && !isItemView;

            document.getElementById('view_rate_col').style.display    = showRate   ? ''     : 'none';
            document.getElementById('view_cat_fields').style.display  = isCatView  ? 'grid' : 'none';
            document.getElementById('view_order_fields').style.display = isOrderView ? 'grid' : 'none';
            document.getElementById('view_mixed_fields').style.display = isMixedView ? 'grid' : 'none';
            document.getElementById('view_item_fields').style.display  = isItemView  ? ''     : 'none';

            document.getElementById('view_commission_rate').textContent =
                showRate && m.commission_rate !== null ? m.commission_rate + (m.commission_type === 'percentage_based' ? '%' : '/item') : '—';
            document.getElementById('view_commission_food_amount').textContent   = isCatView   && m.commission_food_amount   ? '₱' + parseFloat(m.commission_food_amount).toFixed(2)   : '—';
            document.getElementById('view_commission_drinks_amount').textContent = isCatView   && m.commission_drinks_amount ? '₱' + parseFloat(m.commission_drinks_amount).toFixed(2) : '—';
            document.getElementById('view_commission_small_amount').textContent  = isOrderView && m.commission_small_amount  ? '₱' + parseFloat(m.commission_small_amount).toFixed(2)  : '—';
            document.getElementById('view_commission_big_amount').textContent    = isOrderView && m.commission_big_amount    ? '₱' + parseFloat(m.commission_big_amount).toFixed(2)    : '—';
            document.getElementById('view_commission_mixed_percentage').textContent = isMixedView && m.commission_mixed_percentage ? parseFloat(m.commission_mixed_percentage).toFixed(2) + '%' : '—';
            document.getElementById('view_commission_mixed_amount').textContent     = isMixedView && m.commission_mixed_amount     ? '₱' + parseFloat(m.commission_mixed_amount).toFixed(2)     : '—';

            if (isItemView) {
                const list  = document.getElementById('view_item_list');
                const items = m.commission_items || [];
                list.innerHTML = items.length
                    ? `<div style="font-size:11px;color:#7c4fd1;font-weight:700;text-transform:uppercase;letter-spacing:.7px;margin-bottom:8px;"><i class="fas fa-tags" style="margin-right:4px;"></i>${items.length} item${items.length > 1 ? 's' : ''} configured</div>`
                      + items.map(item => `<div style="display:flex;justify-content:space-between;align-items:center;padding:9px 14px;border-radius:8px;background:#faf5ff;border:1px solid #e9d5ff;margin-bottom:6px;"><span style="font-size:13px;color:#374151;font-weight:600;">${item.label || '—'}</span><span style="font-weight:800;color:#7c4fd1;font-size:15px;">₱${parseFloat(item.amount||0).toFixed(2)}</span></div>`).join('')
                    : '<div style="color:#9ca3af;font-size:13px;padding:6px 0;"><i class="fas fa-tags" style="margin-right:4px;"></i>No items configured.</div>';
            }

            // Address
            document.getElementById('view_address').textContent = m.address || '—';

            // Footer meta + edit button
            document.getElementById('view_footer_meta').textContent = 'ID #' + m.id;
            document.getElementById('view_edit_btn').onclick = () => { closeModal('viewModal'); openEditModal(m.id); };

            openModal('viewModal');
        }

        // ── Edit ──
        function openEditModal(id) {
            const m = merchantsData[id];
            if (!m) return;
            document.getElementById('editModalTitle').textContent = m.name;
            document.getElementById('editMerchantId').value       = m.id;
            document.getElementById('edit_name').value            = m.name;
            document.getElementById('edit_type').value            = m.type;
            document.getElementById('edit_status').value          = m.status;
            document.getElementById('edit_commission_type').value = m.commission_type || 'percentage_based';
            document.getElementById('edit_commission_rate').value = m.commission_rate;
            document.getElementById('edit_commission_food_amount').value      = m.commission_food_amount      || '';
            document.getElementById('edit_commission_drinks_amount').value    = m.commission_drinks_amount    || '';
            document.getElementById('edit_commission_small_amount').value     = m.commission_small_amount     || '';
            document.getElementById('edit_commission_big_amount').value       = m.commission_big_amount       || '';
            document.getElementById('edit_commission_mixed_percentage').value = m.commission_mixed_percentage || '';
            document.getElementById('edit_commission_mixed_amount').value     = m.commission_mixed_amount     || '';
            resetItemRows('edit');
            if (m.commission_type === 'fixed_per_item' && m.commission_items && m.commission_items.length) {
                m.commission_items.forEach(item => addItemRow('edit', item.label || '', item.amount || ''));
            }
            updateCommissionLabel('edit');
            document.getElementById('edit_address').value         = m.address;
            openModal('editModal');
        }

        async function submitEditMerchant(e) {
            e.preventDefault();
            const id  = document.getElementById('editMerchantId').value;
            const btn = document.getElementById('editSubmitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving…';
            const fd = new FormData(e.target);
            fd.set('_method', 'PUT');
            if (document.getElementById('edit_commission_type').value === 'fixed_per_item') {
                const items = [];
                document.querySelectorAll('#edit_item_rows .item-row').forEach(row => {
                    const lbl = row.querySelector('.item-label').value.trim();
                    const amt = row.querySelector('.item-amount').value.trim();
                    if (lbl || amt) items.push({ label: lbl, amount: amt });
                });
                fd.set('commission_items', JSON.stringify(items));
            }
            try {
                const resp = await fetch(`/merchants/${id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd,
                });
                const data = await resp.json();
                if (data.success) {
                    const updated = data.merchant;
                    merchantsData[updated.id] = updated;
                    updateMerchantRow(updated);
                    updateStatCards();
                    closeModal('editModal');
                    showToast(data.message, 'success');
                } else {
                    const msg = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'An error occurred.');
                    showToast(msg, 'error');
                }
            } catch { showToast('Network error. Please try again.', 'error'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-save"></i> Update Merchant';
            }
        }

        // ── Delete ──
        function openDeleteModal(id, name) {
            document.getElementById('deleteMerchantId').value          = id;
            document.getElementById('deleteMerchantName').textContent  = name;
            openModal('deleteModal');
        }

        async function confirmDelete() {
            const id  = document.getElementById('deleteMerchantId').value;
            const btn = document.getElementById('deleteConfirmBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting…';
            try {
                const resp = await fetch(`/merchants/${id}`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: new URLSearchParams({ _method: 'DELETE' }),
                });
                const data = await resp.json();
                if (data.success) {
                    const tr = document.getElementById('merchant-row-' + id);
                    if (tr) tr.remove();
                    delete merchantsData[id];
                    updateStatCards();
                    applyFilter();
                    closeModal('deleteModal');
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message || 'Failed to delete.', 'error');
                }
            } catch { showToast('Network error. Please try again.', 'error'); }
            finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-trash"></i> Delete';
            }
        }

        // ── Sidebar ──
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        // ── DOM helpers for no-refresh row update ──
        function escHtml(str) {
            return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }
        function _ucfirst(str) { return str ? str.charAt(0).toUpperCase() + str.slice(1) : ''; }
        function _numFmt(n) { return parseFloat(n || 0).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

        function renderCommissionDetails(m) {
            const ct = m.commission_type || 'percentage_based';
            if (ct === 'percentage_based') {
                return `<div style="font-size:12px;line-height:1.8;"><span style="color:#374151;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;font-size:10px;"></i>Rate:</span> <span style="color:#357a3a;font-weight:700;">${m.commission_rate ?? 0}%</span></div>`;
            }
            if (ct === 'fixed_per_item') {
                const items = Array.isArray(m.commission_items) ? m.commission_items : [];
                if (items.length) {
                    const amounts = [...new Set(items.map(i => parseFloat(i.amount||0)))];
                    const amountStr = amounts.length === 1
                        ? '₱' + _numFmt(amounts[0]) + '/item'
                        : '₱' + _numFmt(Math.min(...amounts)) + '–₱' + _numFmt(Math.max(...amounts));
                    return `<span style="display:inline-flex;align-items:center;gap:5px;background:#faf5ff;border:1px solid #e9d5ff;border-radius:20px;padding:3px 10px;font-size:11px;font-weight:700;color:#7c4fd1;white-space:nowrap;"><i class="fas fa-tags" style="font-size:10px;"></i>${items.length} item${items.length>1?'s':''}<span style="color:#9ca3af;font-weight:500;">&bull;</span>${amountStr}</span>`;
                }
                return `<span style="color:#9ca3af;font-size:12px;"><i class="fas fa-tags" style="margin-right:4px;"></i>No items set</span>`;
            }
            if (ct === 'category_based_fixed') {
                return `<div style="font-size:12px;line-height:1.8;"><span style="color:#557a3a;font-weight:600;"><i class="fas fa-utensils" style="margin-right:4px;font-size:10px;"></i>Food:</span> <span style="color:#357a3a;font-weight:700;">₱${_numFmt(m.commission_food_amount??0)}</span></div><div style="font-size:12px;line-height:1.8;"><span style="color:#557a3a;font-weight:600;"><i class="fas fa-glass-cheers" style="margin-right:4px;font-size:10px;"></i>Drinks:</span> <span style="color:#357a3a;font-weight:700;">₱${_numFmt(m.commission_drinks_amount??0)}</span></div>`;
            }
            if (ct === 'fixed_per_order') {
                return `<div style="font-size:12px;line-height:1.8;"><span style="color:#1a4f7a;font-weight:600;"><i class="fas fa-box-open" style="margin-right:4px;font-size:10px;"></i>Small Order:</span> <span style="color:#1a7ed1;font-weight:700;">₱${_numFmt(m.commission_small_amount??0)}</span></div><div style="font-size:12px;line-height:1.8;"><span style="color:#1a4f7a;font-weight:600;"><i class="fas fa-box" style="margin-right:4px;font-size:10px;"></i>Big Order:</span> <span style="color:#1a7ed1;font-weight:700;">₱${_numFmt(m.commission_big_amount??0)}</span></div>`;
            }
            if (ct === 'mixed') {
                return `<div style="font-size:12px;line-height:1.8;"><span style="color:#5a3a7a;font-weight:600;"><i class="fas fa-percent" style="margin-right:4px;font-size:10px;"></i>Percentage:</span> <span style="color:#7c4fd1;font-weight:700;">${m.commission_mixed_percentage ?? 0}%</span></div><div style="font-size:12px;line-height:1.8;"><span style="color:#5a3a7a;font-weight:600;"><i class="fas fa-coins" style="margin-right:4px;font-size:10px;"></i>Fixed Amount:</span> <span style="color:#7c4fd1;font-weight:700;">₱${_numFmt(m.commission_mixed_amount??0)}</span></div>`;
            }
            return '';
        }

        function updateMerchantRow(m) {
            const tr = document.getElementById('merchant-row-' + m.id);
            if (!tr) return;
            // Update filter data attributes
            tr.dataset.name     = (m.name     || '').toLowerCase();
            tr.dataset.address  = (m.address  || '').toLowerCase();
            tr.dataset.type     = m.type;
            tr.dataset.status   = m.status;
            const cells  = tr.cells;
            // Cell 1 – Merchant name + address
            cells[1].innerHTML = `<div style="display:flex;align-items:center;gap:10px;"><div style="width:38px;height:38px;border-radius:10px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-store" style="font-size:15px;color:#3b6e2f;"></i></div><div><div style="font-weight:700;font-size:14px;color:#111827;">${escHtml(m.name)}</div>${m.address ? `<div style="font-size:11px;color:#9ca3af;margin-top:1px;">${escHtml(String(m.address).substring(0,40))}${m.address.length>40?'…':''}</div>` : ''}</div></div>`;
            // Cell 2 – Type badge
            const typeSt = m.type === 'partner' ? 'background:#dcfce7;color:#166534;' : 'background:#fef9c3;color:#854d0e;';
            cells[2].innerHTML = `<span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;${typeSt}">${_ucfirst(m.type)}</span>`;
            // Cell 3 – Commission type badge
            const ctStyles = { percentage_based:'background:#dcfce7;color:#166534;', fixed_per_item:'background:#ede9fe;color:#5b21b6;', category_based_fixed:'background:#d1fae5;color:#065f46;', fixed_per_order:'background:#dbeafe;color:#1e40af;', mixed:'background:#fae8ff;color:#7e22ce;' };
            const ctLabels = { percentage_based:'Percentage', fixed_per_item:'Fixed / Item', category_based_fixed:'Cat. Fixed', fixed_per_order:'Fixed / Order', mixed:'Mixed' };
            const ct = m.commission_type || 'percentage_based';
            cells[3].innerHTML = `<span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;${ctStyles[ct]||'background:#f3f4f6;color:#374151;'}">${ctLabels[ct]||ct}</span>`;
            // Cell 4 – Commission details
            cells[4].innerHTML = renderCommissionDetails(m);
            // Cell 5 – Status badge
            const stSt = m.status === 'active' ? 'background:#dcfce7;color:#166534;' : 'background:#fee2e2;color:#991b1b;';
            cells[5].innerHTML = `<span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;${stSt}">${_ucfirst(m.status)}</span>`;
            // Cell 6 – Orders
            cells[6].style.cssText = 'text-align:right;font-size:13px;font-weight:700;color:#374151;';
            cells[6].textContent = Number(m.total_orders||0).toLocaleString();
            // Cell 7 – Sales
            cells[7].style.cssText = 'text-align:right;font-size:13px;font-weight:700;color:#374151;';
            cells[7].textContent = '₱' + _numFmt(m.total_sales||0);
            // Cell 8 – WIB Commission
            cells[8].style.cssText = 'text-align:right;font-size:13px;font-weight:700;color:#357a3a;';
            cells[8].textContent = '₱' + _numFmt(m.total_commission||0);
        }

        // ── Stat card live update ──
        function updateStatCards() {
            const all = Object.values(merchantsData);
            const total      = all.length;
            const partners   = all.filter(m => m.type === 'partner').length;
            const nonPartners = all.filter(m => m.type === 'non-partner').length;
            const active     = all.filter(m => m.status === 'active').length;
            document.getElementById('stat_total').textContent        = total;
            document.getElementById('stat_active_sub').innerHTML     = '<i class="fas fa-circle" style="font-size:6px;margin-right:4px;"></i>' + active + ' active';
            document.getElementById('stat_partner').textContent      = partners;
            document.getElementById('stat_partner_sub').textContent  = (total > 0 ? Math.round(partners / total * 100) : 0) + '% of total';
            document.getElementById('stat_nonpartner').textContent   = nonPartners;
            document.getElementById('stat_nonpartner_sub').textContent = (total > 0 ? Math.round(nonPartners / total * 100) : 0) + '% of total';
        }

        // ── Insert new merchant row into table ──
        function insertMerchantRow(m) {
            const firstRow = document.querySelector('.merchant-row');
            const tbody = firstRow ? firstRow.closest('tbody') : document.querySelector('table tbody');
            if (!tbody) return;
            const rowNum = tbody.querySelectorAll('.merchant-row').length + 1;
            const typeSt = m.type === 'partner' ? 'background:#dcfce7;color:#166534;' : 'background:#fef9c3;color:#854d0e;';
            const ctStyles = { percentage_based:'background:#dcfce7;color:#166534;', fixed_per_item:'background:#ede9fe;color:#5b21b6;', category_based_fixed:'background:#d1fae5;color:#065f46;', fixed_per_order:'background:#dbeafe;color:#1e40af;', mixed:'background:#fae8ff;color:#7e22ce;' };
            const ctLabels = { percentage_based:'Percentage', fixed_per_item:'Fixed / Item', category_based_fixed:'Cat. Fixed', fixed_per_order:'Fixed / Order', mixed:'Mixed' };
            const ct  = m.commission_type || 'percentage_based';
            const stSt = m.status === 'active' ? 'background:#dcfce7;color:#166534;' : 'background:#fee2e2;color:#991b1b;';
            const today = new Date().toISOString().slice(0, 10);
            const tr = document.createElement('tr');
            tr.id        = 'merchant-row-' + m.id;
            tr.className = 'merchant-row';
            tr.dataset.name     = (m.name     || '').toLowerCase();
            tr.dataset.category = (m.category || '').toLowerCase();
            tr.dataset.address  = (m.address  || '').toLowerCase();
            tr.dataset.type     = m.type;
            tr.dataset.status   = m.status;
            tr.dataset.created  = today;
            tr.innerHTML = `
                <td>${rowNum}</td>
                <td><div style="display:flex;align-items:center;gap:10px;"><div style="width:38px;height:38px;border-radius:10px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;flex-shrink:0;"><i class="fas fa-store" style="font-size:15px;color:#3b6e2f;"></i></div><div><div style="font-weight:700;font-size:14px;color:#111827;">${escHtml(m.name)}</div>${m.address?`<div style="font-size:11px;color:#9ca3af;margin-top:1px;">${escHtml(String(m.address).substring(0,40))}${m.address.length>40?'…':''}</div>`:''}</div></div></td>
                <td><span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;${typeSt}">${_ucfirst(m.type)}</span></td>
                <td><span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;white-space:nowrap;${ctStyles[ct]||'background:#f3f4f6;color:#374151;'}">${ctLabels[ct]||ct}</span></td>
                <td>${renderCommissionDetails(m)}</td>
                <td><span style="display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;${stSt}">${_ucfirst(m.status)}</span></td>
                <td style="text-align:right;font-size:13px;font-weight:700;color:#374151;">${Number(m.total_orders||0).toLocaleString()}</td>
                <td style="text-align:right;font-size:13px;font-weight:700;color:#374151;">₱${_numFmt(m.total_sales||0)}</td>
                <td style="text-align:right;font-size:13px;font-weight:700;color:#357a3a;">₱${_numFmt(m.total_commission||0)}</td>
                <td style="text-align:center;"><div style="display:flex;gap:6px;justify-content:center;"><button onclick="openViewModal(${m.id})" class="merchant-action-btn" style="background:#eff6ff;color:#1a7ed1;border:1px solid #bfdbfe;border-radius:8px;padding:7px 13px;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-weight:700;box-shadow:0 1px 3px rgba(26,126,209,.1);"><i class="fas fa-eye"></i> View</button><button onclick="openEditModal(${m.id})" class="merchant-action-btn" style="background:#fffbeb;color:#d97706;border:1px solid #fde68a;border-radius:8px;padding:7px 13px;font-size:12px;cursor:pointer;display:inline-flex;align-items:center;gap:5px;font-weight:700;box-shadow:0 1px 3px rgba(217,119,6,.1);"><i class="fas fa-edit"></i> Edit</button></div></td>
            `;
            const emptyRow = document.getElementById('merchantEmptyRow');
            if (emptyRow) tbody.insertBefore(tr, emptyRow);
            else tbody.appendChild(tr);
        }

        // ── Toast ──
        function showToast(message, type = 'success', duration = 3500) {
            const container = document.getElementById('toastContainer');
            const colors = { success:'#28a745', error:'#dc3545', warning:'#ffc107', info:'#17a2b8' };
            const icons  = { success:'fa-check-circle', error:'fa-exclamation-circle', warning:'fa-exclamation-triangle', info:'fa-info-circle' };
            const color  = colors[type] || colors.success;
            const icon   = icons[type]  || icons.success;
            const toast  = document.createElement('div');
            toast.className = 'custom-toast';
            toast.style.borderLeftColor = color;
            toast.innerHTML = `
                <i class="fas ${icon} toast-icon" style="color:${color}"></i>
                <div class="toast-message">${message}</div>
                <button class="toast-close" onclick="this.closest('.custom-toast').remove()">&times;</button>
                <div class="toast-progress" style="background:${color}"></div>
            `;
            setTimeout(() => { toast.style.opacity='0'; setTimeout(()=>toast.remove(),300); }, duration);
            container.appendChild(toast);
        }

        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => showToast('{{ session('success') }}', 'success'));
        @endif

        // Client-side filter + pagination
        let _currentPage = 1;
        let _filteredRows = [];

        function changePerPage() { _currentPage = 1; applyFilter(); }

        function goToPage(page) { _currentPage = page; renderPage(); }

        function filterMerchants() { _currentPage = 1; applyFilter(); }

        function applyFilter() {
            const search = document.getElementById('merchantSearch').value.toLowerCase().trim();
            const type   = document.getElementById('merchantTypeFilter').value;
            const status = document.getElementById('merchantStatusFilter').value;
            const period = document.getElementById('merchantPeriodFilter').value;

            const now          = new Date();
            const today        = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const dayOfWeek    = today.getDay() === 0 ? 6 : today.getDay() - 1;
            const startOfWeek  = new Date(today); startOfWeek.setDate(today.getDate() - dayOfWeek);
            const startOfMonth = new Date(now.getFullYear(), now.getMonth(), 1);
            const startOfBiMonth  = new Date(now.getFullYear(), now.getMonth() - 2, 1);
            const startOfTriMonth = new Date(now.getFullYear(), now.getMonth() - 3, 1);

            _filteredRows = [];

            document.querySelectorAll('.merchant-row').forEach(row => {
                const name     = row.dataset.name     || '';
                const category = row.dataset.category || '';
                const address  = row.dataset.address  || '';
                const rowType   = row.dataset.type;
                const rowStatus = row.dataset.status;
                const created   = new Date(row.dataset.created + 'T00:00:00');

                const matchSearch = !search ||
                    name.includes(search) ||
                    category.includes(search) ||
                    address.includes(search);

                const matchType   = type   === 'all' || rowType   === type;
                const matchStatus = status === 'all' || rowStatus === status;

                let matchPeriod = true;
                if (period === 'daily')    matchPeriod = created >= today;
                if (period === 'weekly')   matchPeriod = created >= startOfWeek;
                if (period === 'monthly')  matchPeriod = created >= startOfMonth;
                if (period === 'bimonth')  matchPeriod = created >= startOfBiMonth;
                if (period === 'trimonth') matchPeriod = created >= startOfTriMonth;

                row.style.display = 'none';
                if (matchSearch && matchType && matchStatus && matchPeriod) {
                    _filteredRows.push(row);
                }
            });

            renderPage();
        }

        function renderPage() {
            const perPage = parseInt(document.getElementById('perPageSelect').value);
            const total   = _filteredRows.length;
            const totalPages = Math.max(1, Math.ceil(total / perPage));
            if (_currentPage > totalPages) _currentPage = totalPages;

            const start = (_currentPage - 1) * perPage;
            const end   = Math.min(start + perPage, total);

            // Hide all filtered rows first, then show current page slice
            _filteredRows.forEach((row, i) => {
                row.style.display = (i >= start && i < end) ? '' : 'none';
            });

            document.getElementById('merchantEmptyRow').style.display = total === 0 ? '' : 'none';

            // Info label
            const countEl = document.getElementById('merchantCount');
            if (countEl) countEl.textContent = total + ' merchant' + (total !== 1 ? 's' : '');
            const partnerCount = _filteredRows.filter(r => r.dataset.type === 'partner').length;
            const nonPartnerCount = _filteredRows.filter(r => r.dataset.type === 'non-partner').length;
            const partnerBadge = document.getElementById('partnerBadge');
            if (partnerBadge) partnerBadge.textContent = partnerCount + ' partner';
            const nonPartnerBadge = document.getElementById('nonPartnerBadge');
            if (nonPartnerBadge) nonPartnerBadge.textContent = nonPartnerCount + ' non-partner';
            const infoEl = document.getElementById('paginationInfo');
            if (infoEl) infoEl.textContent = total === 0 ? 'No results' : `${start + 1}–${end} of ${total}`;

            // Render buttons
            const btns = document.getElementById('paginationButtons');
            btns.innerHTML = '';
            const btnStyle = (active) => `border:1px solid ${active?'#357a3a':'#e5e7eb'};border-radius:6px;padding:5px 10px;font-size:12px;font-weight:${active?'700':'500'};background:${active?'#357a3a':'#fff'};color:${active?'#fff':'#374151'};cursor:${active?'default':'pointer'};min-width:32px;text-align:center;`;

            // Prev
            const prev = document.createElement('button');
            prev.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prev.style.cssText = btnStyle(false) + (_currentPage === 1 ? 'opacity:.4;cursor:default;' : '');
            prev.disabled = _currentPage === 1;
            prev.onclick = () => { if (_currentPage > 1) { _currentPage--; renderPage(); } };
            btns.appendChild(prev);

            // Page numbers (window of 5)
            const winSize = 5;
            let pStart = Math.max(1, _currentPage - Math.floor(winSize / 2));
            let pEnd   = pStart + winSize - 1;
            if (pEnd > totalPages) { pEnd = totalPages; pStart = Math.max(1, pEnd - winSize + 1); }

            if (pStart > 1) {
                const b = document.createElement('button'); b.textContent = '1';
                b.style.cssText = btnStyle(false); b.onclick = () => goToPage(1); btns.appendChild(b);
                if (pStart > 2) { const e=document.createElement('span'); e.textContent='…'; e.style.cssText='padding:5px 4px;font-size:12px;color:#9ca3af;'; btns.appendChild(e); }
            }
            for (let p = pStart; p <= pEnd; p++) {
                const b = document.createElement('button'); b.textContent = p;
                b.style.cssText = btnStyle(p === _currentPage); b.disabled = p === _currentPage;
                b.onclick = ((pg) => () => goToPage(pg))(p); btns.appendChild(b);
            }
            if (pEnd < totalPages) {
                if (pEnd < totalPages - 1) { const e=document.createElement('span'); e.textContent='…'; e.style.cssText='padding:5px 4px;font-size:12px;color:#9ca3af;'; btns.appendChild(e); }
                const b = document.createElement('button'); b.textContent = totalPages;
                b.style.cssText = btnStyle(false); b.onclick = () => goToPage(totalPages); btns.appendChild(b);
            }

            // Next
            const next = document.createElement('button');
            next.innerHTML = '<i class="fas fa-chevron-right"></i>';
            next.style.cssText = btnStyle(false) + (_currentPage === totalPages ? 'opacity:.4;cursor:default;' : '');
            next.disabled = _currentPage === totalPages;
            next.onclick = () => { if (_currentPage < totalPages) { _currentPage++; renderPage(); } };
            btns.appendChild(next);
        }

        // Init pagination on page load
        document.addEventListener('DOMContentLoaded', () => filterMerchants());
    </script>

    <!-- Toast Container -->
    <div id="toastContainer"></div>

    @include('partials.floating-widgets')
</body>
</html>





