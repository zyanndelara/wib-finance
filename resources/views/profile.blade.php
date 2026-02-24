<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Wibsystem</title>
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
            padding: 22px;
            overflow-y: auto;
            background: #f5f5f5;
        }

        .content-header {
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 26px;
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
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
            font-size: 14px;
        }

        /* Profile Styles */
        .profile-container {
            background: transparent;
            border-radius: 0;
            padding: 0;
            box-shadow: none;
        }

        .profile-main-layout {
              display: grid;
              grid-template-columns: 200px 1fr;
              gap: 8px;
              margin-bottom: 20px;
        }

        .profile-left {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding-bottom: 0;
            border-bottom: none;
            margin-bottom: 0;
            text-align: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #d3d3d3;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 600;
            color: #666;
            flex-shrink: 0;
        }

        .profile-name-section {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .profile-name-section h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .profile-name-section .role {
            font-size: 13px;
            color: #666;
            text-transform: capitalize;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .edit-icon {
            background: none;
            border: none;
            cursor: pointer;
            color: #436026;
            font-size: 13px;
            padding: 5px 10px;
            transition: color 0.3s ease;
        }

        .edit-icon:hover {
            color: #5a7d33;
        }

        .edit-icon i {
            margin-right: 5px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 12px;
        }

        .info-grid-second-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-field.full-width {
            grid-column: span 4;
        }

        .info-field.half-width {
            grid-column: span 2;
        }

        .info-field.span-2 {
            grid-column: span 2;
        }

        .small-fields-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .profile-right {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .info-field label {
            font-size: 12px;
            color: #666;
            font-weight: 500;
        }

        .info-field .field-value {
            background: #d3d3d3;
            padding: 8px 12px;
            border-radius: 4px;
            color: #999;
            font-size: 13px;
            min-height: 34px;
            display: flex;
            align-items: center;
        }

        .security-section {
            background: white;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            
        }

        .security-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            margin-bottom: 12px;
            border: 1px solid #e0e0e0;
        }

        .security-item.delete-item {
            background: #fff5f5;
            border-color: #ffcccc;
        }

        .security-item-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .security-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .security-icon.key {
            background: #f0f0f0;
            color: #1a1a1a;
        }

        .security-icon.verified {
            background: #d4edda;
            color: #28a745;
        }

        .security-icon.lock {
            background: #f0f0f0;
            color: #1a1a1a;
        }

        .security-icon.trash {
            background: #fff0f0;
            color: #dc3545;
        }

        .security-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .security-info h4 {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .security-info p {
            font-size: 13px;
            color: #666;
            margin: 0;
        }

        .security-button {
            padding: 10px 18px;
            border-radius: 4px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .security-button.primary {
            background: #f0f0f0;
            color: #1a1a1a;
            border: 1px solid #d0d0d0;
        }

        .security-button.primary:hover {
            background: #e5e5e5;
        }

        .security-button.danger {
            background: #dc3545;
            color: white;
        }

        .security-button.danger:hover {
            background: #c82333;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 26px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 26px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .toggle-switch input:checked + .toggle-slider {
            background-color: #436026;
        }

        .toggle-switch input:checked + .toggle-slider:before {
            transform: translateX(24px);
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge.status-disabled {
            background: #f0f0f0;
            color: #666;
        }

        .notification-bell {
            color: #ffd300;
            font-size: 22px;
        }

        /* Edit Mode Styles */
        .info-field input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            font-size: 13px;
            font-family: inherit;
            display: none;
        }

        .info-field.editing input {
            display: block;
        }

        .info-field.editing .field-value {
            display: none;
        }

        .edit-actions {
            display: none;
            gap: 10px;
            margin-top: 12px;
        }

        .edit-actions.active {
            display: flex;
        }

        .btn {
            padding: 8px 20px;
            border-radius: 4px;
            border: none;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #436026;
            color: white;
        }

        .btn-primary:hover {
            background: #5a7d33;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #1a1a1a;
        }

        .btn-secondary:hover {
            background: #d0d0d0;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 28px;
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.3s ease;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .modal-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            color: #666;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #1a1a1a;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
        }

        .form-group input:focus {
            outline: none;
            border-color: #436026;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 22px;
        }

        .error-text {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .delete-warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 14px;
            margin-bottom: 18px;
            border-radius: 4px;
        }

        .delete-warning p {
            color: #856404;
            margin: 0;
            font-size: 14px;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
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

            .profile-main-layout {
                flex-direction: column;
                gap: 20px;
            }

            .info-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .info-grid-second-row {
                grid-template-columns: repeat(2, 1fr);
            }

            .info-field.full-width {
                grid-column: span 2;
            }

            .info-field.span-2 {
                grid-column: span 2;
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

            .profile-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-main-layout {
                flex-direction: column;
                gap: 20px;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .info-grid-second-row {
                grid-template-columns: 1fr;
            }

            .info-field.full-width,
            .info-field.half-width,
            .info-field.span-2 {
                grid-column: span 1;
            }

            .small-fields-wrapper {
                grid-template-columns: 1fr 1fr;
            }

            .profile-main-layout {
                flex-direction: column;
            }

            .security-item {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .security-item-left {
                width: 100%;
            }

            .security-button {
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

            .profile-container {
                padding: 20px;
            }

            .profile-avatar {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .profile-name-section h2 {
                font-size: 17px;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .small-fields-wrapper {
                grid-template-columns: 1fr;
                gap: 6px;
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
            <a href="{{ route('dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
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
            <a href="{{ route('members.index') }}" class="menu-item">
                <i class="fas fa-users-cog"></i>
                <span>Member Management</span>
            </a>
            <a href="{{ route('audit-logs') }}" class="menu-item">
                <i class="fas fa-clipboard-list"></i>
                <span>Audit Logs</span>
            </a>
            <a href="{{ route('reports') }}" class="menu-item">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            <a href="{{ route('profile') }}" class="menu-item active">
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
                <!-- Email Verified Popup -->
                @if (session('email_verified'))
                    <div id="emailVerifiedPopup" style="position: fixed; top: 30px; left: 50%; transform: translateX(-50%); background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 20px 40px; border-radius: 8px; z-index: 9999; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                        <i class="fas fa-check-circle"></i> Your email has been verified!
                        <button onclick="document.getElementById('emailVerifiedPopup').style.display='none'" style="background:none;border:none;font-size:18px;float:right;cursor:pointer;">&times;</button>
                    </div>
                    <script>
                        setTimeout(function() {
                            var popup = document.getElementById('emailVerifiedPopup');
                            if (popup) popup.style.display = 'none';
                        }, 4000);
                    </script>
                @endif
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert-success" style="background: #f8d7da; color: #721c24; border-left-color: #dc3545;">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="content-header">
            <h1>Profile</h1>
            <div class="user-indicator">
                <i class="fas fa-bell notification-bell"></i>
            </div>
        </div>

        <div class="profile-container">
            <!-- Profile Main Layout -->
            <div class="profile-main-layout">
                <!-- Profile Left - Avatar and Name -->
                <div class="profile-left">
                    <div class="profile-header">
                        <div class="profile-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'NAME', 0, 1)) }}
                        </div>
                        <div class="profile-name-section">
                            <h2>{{ strtoupper(auth()->user()->name ?? 'NAME') }}</h2>
                            <span class="role">{{ auth()->user()->role ?? 'Role' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Profile Right - Personal Information -->
                <div class="profile-right">
                    <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="section-header">
                            <h3 class="section-title">Personal Information</h3>
                            <button type="button" class="edit-icon" id="editBtn" onclick="toggleEditMode()">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                        </div>

                        <!-- First Row - 4 fields -->
                        <div class="info-grid">
                            <div class="info-field">
                                <label>Last Name:</label>
                                <div class="field-value">{{ auth()->user()->last_name ?? '' }}</div>
                                <input type="text" name="last_name" value="{{ auth()->user()->last_name ?? '' }}" required>
                            </div>
                            <div class="info-field">
                                <label>First Name:</label>
                                <div class="field-value">{{ auth()->user()->first_name ?? '' }}</div>
                                <input type="text" name="first_name" value="{{ auth()->user()->first_name ?? '' }}" required>
                            </div>
                            <div class="info-field">
                                <label>Middle Initial:</label>
                                <div class="field-value">{{ auth()->user()->middle_name ?? '' }}</div>
                                <input type="text" name="middle_initial" value="{{ auth()->user()->middle_name ?? '' }}" maxlength="2">
                            </div>
                            <div class="info-field">
                                <label>Suffix:</label>
                                <div class="field-value">{{ auth()->user()->suffix ?? '' }}</div>
                                <input type="text" name="suffix" value="{{ auth()->user()->suffix ?? '' }}" maxlength="10">
                            </div>
                        </div>

                        <!-- Second Row - 3 fields with alignment -->
                        <div class="info-grid-second-row">
                            <div class="info-field">
                                <label>User Role:</label>
                                <div class="field-value">{{ auth()->user()->role ?? '' }}</div>
                            </div>
                            <div class="info-field span-2">
                                <label>Email Address:</label>
                                <div class="field-value">{{ auth()->user()->email ?? '' }}</div>
                                <input type="email" name="email" value="{{ auth()->user()->email ?? '' }}" required>
                            </div>
                            <div class="info-field">
                                <label>Phone Number:</label>
                                <div class="field-value">{{ auth()->user()->phone_number ?? '' }}</div>
                                <input type="text" name="phone" value="{{ auth()->user()->phone_number ?? '' }}" maxlength="13" placeholder="+63">
                            </div>
                        </div>

                        <div class="edit-actions" id="editActions">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                                <i class="fas fa-times"></i> Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security & Account Protection Section -->
            <div class="security-section">
                <h3 class="section-title" style="margin-bottom: 12px;">Security & Account Protection</h3>

                <!-- Password -->
                <div class="security-item">
                    <div class="security-item-left">
                        <div class="security-icon key">
                            <i class="fas fa-key"></i>
                        </div>
                        <div class="security-info">
                            <h4>Password</h4>
                            <p>Last changed: March 24, 2026</p>
                        </div>
                    </div>
                    <button type="button" class="security-button primary" onclick="openPasswordModal()">
                        <i class="fas fa-edit"></i> Update Password
                    </button>
                </div>

                <!-- Email Verification -->
                <div class="security-item">
                    <div class="security-item-left">
                        <div class="security-icon" style="background: {{ auth()->user()->email_verified_at ? '#d4edda' : '#f8d7da' }}; color: {{ auth()->user()->email_verified_at ? '#28a745' : '#dc3545' }}; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle" style="color: {{ auth()->user()->email_verified_at ? '#28a745' : '#dc3545' }};"></i>
                        </div>
                        <div class="security-info">
                            <h4>Email Verification</h4>
                            <p style="color: {{ auth()->user()->email_verified_at ? '#28a745' : '#dc3545' }}; font-weight: bold;">
                                @if (auth()->user()->email_verified_at)
                                    Verified
                                @else
                                    Not Verified
                                @endif
                            </p>
                        </div>
                    </div>
                    @if (!auth()->user()->email_verified_at)
                        <form action="{{ route('profile.resend-verification') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="security-button primary">
                                <i class="fas fa-envelope"></i>
                                @if(session('verification_sent'))
                                    Resend Verification Email
                                @else
                                    Send Verification Email
                                @endif
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Two-Factor Authentication -->
                <div class="security-item">
                    <div class="security-item-left">
                        <div class="security-icon lock">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="security-info">
                            <h4>Two-Factor Authentication</h4>
                            <p>Add an extra layer of security to your account.</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <span class="badge status-disabled">Disabled</span>
                        <label class="toggle-switch">
                            <input type="checkbox" disabled>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="security-item delete-item">
                    <div class="security-item-left">
                        <div class="security-icon trash">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="security-info">
                            <h4>Delete Account</h4>
                            <p>Permanently remove your account and all associated data.</p>
                        </div>
                    </div>
                    <button type="button" class="security-button danger" onclick="openDeleteModal()">
                        <i class="fas fa-trash"></i> Delete Account
                    </button>
                </div>
            </div>
        </div>

        <!-- Password Update Modal -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Update Password</h3>
                    <button type="button" class="modal-close" onclick="closePasswordModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="new_password" required minlength="8">
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" required minlength="8">
                    </div>
                    <div class="modal-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Password
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closePasswordModal()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Account Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3>Delete Account</h3>
                    <button type="button" class="modal-close" onclick="closeDeleteModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="delete-warning">
                    <p><strong>Warning:</strong> This action is irreversible. All your data will be permanently deleted.</p>
                </div>
                <form action="{{ route('profile.destroy') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label>Enter your password to confirm</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="modal-actions">
                        <button type="submit" class="btn btn-primary" style="background: #dc3545;">
                            <i class="fas fa-trash"></i> Delete Account
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
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

        // Edit Mode Functions
        function toggleEditMode() {
            const fields = document.querySelectorAll('.info-field');
            const editActions = document.getElementById('editActions');
            const editBtn = document.getElementById('editBtn');
            const phoneField = document.querySelector('input[name="phone"]');
            
            fields.forEach(field => {
                // Skip the User Role field
                if (!field.querySelector('input')) return;
                field.classList.add('editing');
            });
            
            // Ensure phone field has +63
            if (phoneField && (phoneField.value === '' || !phoneField.value.startsWith('+63'))) {
                phoneField.value = '+63';
            }
            
            editActions.classList.add('active');
            editBtn.style.display = 'none';
        }

        function cancelEdit() {
            const fields = document.querySelectorAll('.info-field');
            const editActions = document.getElementById('editActions');
            const editBtn = document.getElementById('editBtn');
            const form = document.getElementById('profileForm');
            
            fields.forEach(field => {
                field.classList.remove('editing');
            });
            
            editActions.classList.remove('active');
            editBtn.style.display = 'inline-block';
            
            // Reset form to original values
            form.reset();
        }

        // Password Modal Functions
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.add('active');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.remove('active');
            // Reset form
            document.querySelector('#passwordModal form').reset();
        }

        // Delete Account Modal Functions
        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            // Reset form
            document.querySelector('#deleteModal form').reset();
        }

        // Close modals on outside click
        window.addEventListener('click', function(event) {
            const passwordModal = document.getElementById('passwordModal');
            const deleteModal = document.getElementById('deleteModal');
            
            if (event.target === passwordModal) {
                closePasswordModal();
            }
            
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closePasswordModal();
                closeDeleteModal();
            }
        });

        // Auto-capitalize first letter of input fields
        function capitalizeFirstLetter(input) {
            const value = input.value;
            if (value.length > 0) {
                // Capitalize first letter of each word
                input.value = value.replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });
            }
        }

        // Add dot to middle initial
        function addDotToMiddleInitial(input) {
            let value = input.value.trim();
            if (value.length > 0 && !value.endsWith('.')) {
                input.value = value + '.';
            }
        }

        // Add event listeners to name fields for auto-capitalization
        document.addEventListener('DOMContentLoaded', function() {
            const nameFields = document.querySelectorAll('input[name="first_name"], input[name="last_name"], input[name="middle_initial"], input[name="suffix"]');
            const middleInitialField = document.querySelector('input[name="middle_initial"]');
            const phoneField = document.querySelector('input[name="phone"]');
            
            nameFields.forEach(function(input) {
                // Capitalize on input
                input.addEventListener('input', function() {
                    capitalizeFirstLetter(this);
                });
                
                // Also capitalize on blur (when leaving field)
                input.addEventListener('blur', function() {
                    capitalizeFirstLetter(this);
                });
            });

            // Add dot to middle initial on blur
            if (middleInitialField) {
                middleInitialField.addEventListener('blur', function() {
                    addDotToMiddleInitial(this);
                });
            }

            // Phone number formatting with +63
            if (phoneField) {
                // Initialize field with +63 if empty or convert existing number
                if (phoneField.value && !phoneField.value.startsWith('+63')) {
                    // If there's a value but no +63, add it
                    const cleanNumber = phoneField.value.replace(/^\+?63?/, '').replace(/\D/g, '');
                    if (cleanNumber) {
                        phoneField.value = '+63' + cleanNumber;
                    }
                }
                
                // Add +63 when field is focused
                phoneField.addEventListener('focus', function() {
                    if (this.value === '' || !this.value.startsWith('+63')) {
                        const cleanNumber = this.value.replace(/^\+?63?/, '').replace(/\D/g, '');
                        this.value = '+63' + cleanNumber;
                    }
                });

                // Ensure +63 stays and format the number
                phoneField.addEventListener('input', function(e) {
                    let value = this.value;
                    
                    // If user tries to delete +63, restore it
                    if (!value.startsWith('+63')) {
                        this.value = '+63' + value.replace(/^\+?63?/, '');
                        return;
                    }
                    
                    // Only allow numbers after +63
                    const numericPart = value.substring(3).replace(/\D/g, '');
                    this.value = '+63' + numericPart;
                });

                // Prevent backspace from deleting +63
                phoneField.addEventListener('keydown', function(e) {
                    if ((e.key === 'Backspace' || e.key === 'Delete') && this.selectionStart <= 3) {
                        e.preventDefault();
                        this.setSelectionRange(3, 3);
                    }
                });

                // Set cursor after +63
                phoneField.addEventListener('click', function() {
                    if (this.selectionStart < 3) {
                        this.setSelectionRange(3, 3);
                    }
                });
            }

            // Add dot to middle initial before form submission
            const profileForm = document.getElementById('profileForm');
            if (profileForm) {
                profileForm.addEventListener('submit', function(e) {
                    if (middleInitialField && middleInitialField.value.trim().length > 0) {
                        addDotToMiddleInitial(middleInitialField);
                    }
                });
            }
        });
    </script>
</body>
</html>
