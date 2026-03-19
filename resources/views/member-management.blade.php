<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Management - When in Baguio Inc.</title>
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

        /* Success Alert */
        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 3px solid #28a745;
            font-size: 13px;
        }

        /* Error Alert */
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            border-left: 3px solid #dc3545;
            font-size: 13px;
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

        @media (max-width: 640px) {
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
        }

        /* Add Member Form */
        .add-member-section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .add-member-section h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #333;
            font-size: 13px;
        }

        .form-group input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .form-group select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
            transition: all 0.3s ease;
            background: white;
            cursor: pointer;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }

        .password-note {
            background: #d3d3d3;
            padding: 10px 15px;
            border-radius: 4px;
            color: #666;
            font-size: 12px;
            text-align: center;
            margin-bottom: 15px;
        }

        .btn {
            padding: 10px 22px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #436026 100%);
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(67, 96, 38, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #dc3545 100%);
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #ff9800 0%, #ffc107 100%);
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(255, 193, 7, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Members Table */
        .members-section {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-filter-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 8px 12px 8px 35px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 12px;
        }

        .filter-box {
            min-width: 130px;
        }

        .filter-box select {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 13px;
            background: white;
        }

        .status-badge {
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 11px;
            font-weight: 500;
            display: inline-block;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .members-section h2 {
            font-size: 18px;
            margin-bottom: 12px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
        }

        table th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            font-size: 13px;
        }

        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #dee2e6;
            color: #666;
            font-size: 13px;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .action-buttons {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 15px;
        }

        .pagination a,
        .pagination span {
            padding: 6px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #436026;
            font-size: 12px;
        }

        .pagination .active span {
            background: #436026;
            color: white;
            border-color: #436026;
        }

        .pagination a:hover {
            background: #f8f9fa;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 8px;
            padding: 20px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .modal-header h3 {
            margin: 0;
            color: #1a1a1a;
            font-size: 18px;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #666;
            line-height: 1;
        }

        .close-modal:hover {
            color: #000;
        }

        .error-text {
            color: #dc3545;
            font-size: 11px;
            margin-top: 4px;
            display: block;
        }

        /* Confirmation Modal */
        .confirm-modal-content {
            background: white;
            border-radius: 12px;
            padding: 0;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes modalFadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-30px);
            }
        }

        .modal-fade-out .confirm-modal-content {
            animation: modalFadeOut 0.3s ease forwards;
        }

        /* Success Check Animation */
        .success-check-icon {
            width: 80px;
            height: 80px;
            margin: 20px auto;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: checkBounce 0.5s ease;
        }

        .success-check-icon i {
            color: white;
            font-size: 40px;
            animation: checkScale 0.5s ease;
        }

        @keyframes checkBounce {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes checkScale {
            0% {
                transform: scale(0) rotate(-45deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.3) rotate(0deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        .confirm-modal-header {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            padding: 20px 25px;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .confirm-modal-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .confirm-modal-title {
            color: white;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .confirm-modal-body {
            padding: 30px 25px;
        }

        .confirm-modal-message {
            color: #555;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
            text-align: center;
        }

        .confirm-modal-separator {
            height: 1px;
            background: linear-gradient(to right, transparent, #e0e0e0 20%, #e0e0e0 80%, transparent);
            margin: 0;
        }

        .confirm-modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            padding: 20px 25px 25px;
        }

        .confirm-modal-buttons .btn {
            min-width: 100px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 6px;
        }

        .confirm-modal-buttons .btn-secondary {
            background: #e0e0e0;
            color: #333;
            border: none;
        }

        .confirm-modal-buttons .btn-secondary:hover {
            background: #d0d0d0;
        }

        .confirm-modal-buttons .btn-primary {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
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
    @include('partials.app-sidebar', ['activePage' => 'members'])

    <!-- Main Content -->
    <div class="main-content">
        <!-- Error Message -->
        @if (session('error'))
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <div class="content-header">
            <h1>Member Management</h1>
            @include('partials.user-indicator')
        </div>

        <!-- Members List -->
        <div class="members-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; flex-wrap: wrap; gap: 10px;">
                <h2 style="margin: 0;">
                    <i class="fas fa-users"></i> 
                    @if(isset($showArchived) && $showArchived)
                        Archived Members ({{ $users->total() }})
                    @else
                        Active Members ({{ $users->total() }})
                    @endif
                </h2>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    @if(isset($showArchived) && $showArchived)
                        <a href="{{ route('members.index') }}" class="btn btn-primary">
                            <i class="fas fa-users"></i> View Active Members
                        </a>
                    @else
                        <a href="{{ route('members.index', ['archived' => '1']) }}" class="btn btn-warning">
                            <i class="fas fa-archive"></i> View Archived
                        </a>
                        <button onclick="openAddModal()" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Add New Member
                        </button>
                    @endif
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <form method="GET" action="{{ route('members.index') }}" class="search-filter-bar">
                @if(isset($showArchived) && $showArchived)
                    <input type="hidden" name="archived" value="1">
                @endif
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="memberSearch" placeholder="Search by name, email, employee ID..." oninput="searchMembers()">
                </div>
                @if(!isset($showArchived) || !$showArchived)
                    <div class="filter-box">
                        <select name="role" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="finance_officer_i" {{ request('role') == 'finance_officer_i' ? 'selected' : '' }}>Finance Officer I</option>
                            <option value="finance_officer_ii" {{ request('role') == 'finance_officer_ii' ? 'selected' : '' }}>Finance Officer II</option>
                            <option value="finance_officer_iii" {{ request('role') == 'finance_officer_iii' ? 'selected' : '' }}>Finance Officer III</option>
                            <option value="finance_officer_iv" {{ request('role') == 'finance_officer_iv' ? 'selected' : '' }}>Finance Officer IV</option>
                            <option value="finance_officer_v" {{ request('role') == 'finance_officer_v' ? 'selected' : '' }}>Finance Officer V</option>
                        </select>
                    </div>
                @endif
                @if(request('role'))
                    <a href="{{ route('members.index', isset($showArchived) && $showArchived ? ['archived' => '1'] : []) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                @endif
            </form>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Employee ID</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="member-row">
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->employee_id ?? 'N/A' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number ?? 'N/A' }}</td>
                                <td><span style="text-transform: capitalize; padding: 3px 10px; background: #436026; color: white; border-radius: 10px; font-size: 11px;">{{ ucwords(str_replace('_', ' ', $user->role ?? 'finance officer')) }}</span></td>
                                <td>
                                    <span class="status-badge status-{{ $user->status ?? 'active' }}">
                                        {{ ucfirst($user->status ?? 'active') }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        @if(isset($showArchived) && $showArchived)
                                            <form id="restore-form-{{ $user->id }}" action="{{ route('members.restore', $user) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PATCH')
                                            </form>
                                            <button onclick="confirmRestore({{ $user->id }}, '{{ $user->name }}')" class="btn btn-primary btn-sm">
                                                <i class="fas fa-undo"></i> Restore
                                            </button>
                                        @else
                                            @if($user->role === 'admin')
                                                <button onclick="openViewModal({{ json_encode($user) }})" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            @else
                                                <button onclick="openEditModal({{ json_encode($user) }})" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            @endif
                                            @if($user->id !== auth()->id())
                                                <form id="archive-form-{{ $user->id }}" action="{{ route('members.destroy', $user) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button onclick="confirmArchive({{ $user->id }}, '{{ $user->name }}')" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-archive"></i> Archive
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 20px;">
                                    <i class="fas fa-users" style="font-size: 36px; color: #ddd;"></i>
                                    <p style="margin-top: 8px; color: #999; font-size: 13px;">No members found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Edit Member Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit"></i> Edit Member</h3>
            </div>
            <form id="editForm" method="POST" onsubmit="addDotToMiddleInitial('edit_middle_name')">
                @csrf
                @method('PUT')
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="edit_last_name">Last Name</label>
                        <input type="text" id="edit_last_name" name="last_name" placeholder="Last Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(l){ return l.toUpperCase() })" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_first_name">First Name</label>
                        <input type="text" id="edit_first_name" name="first_name" placeholder="First Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(l){ return l.toUpperCase() })" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_middle_name">Middle Initial</label>
                        <input type="text" id="edit_middle_name" name="middle_name" placeholder="M" maxlength="1" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '').toUpperCase()">
                    </div>
                </div>
                <div class="form-group">
                    <label for="edit_employee_id">Employee ID Number</label>
                    <input type="text" id="edit_employee_id" name="employee_id" placeholder="Employee ID Number" maxlength="4" pattern="[0-9]{4}" title="Must be exactly 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="edit_email">Email Address</label>
                        <input type="email" id="edit_email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" id="edit_phone_number" name="phone_number" placeholder="+63XXXXXXXXXX" maxlength="13" pattern="\+63[0-9]{10}" title="Must be +63 followed by 10 digits" oninput="if(!this.value.startsWith('+63')) this.value = '+63'; this.value = '+63' + this.value.slice(3).replace(/[^0-9]/g, '').slice(0, 10);" required>
                    </div>
                </div>
                <div class="form-row" id="edit_role_rank_row" style="gap: 45px ">
                    <div class="form-group">
                        <label for="edit_role">Role</label>
                        <input type="text" id="edit_role" value="Finance Officer" disabled style="background-color: #f0f0f0; cursor: not-allowed;">
                        <input type="hidden" name="role" id="edit_role_hidden" value="finance_officer">
                    </div>
                    <div class="form-group">
                        <label for="edit_rank">Rank </label>
                        <select id="edit_rank" name="rank">
                            <option value="">Select Rank</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="status" id="edit_status" value="active">
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Member Modal -->
    <div class="modal" id="addModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-plus"></i> Add New Member</h3>
            </div>
            <form action="{{ route('members.store') }}" method="POST" onsubmit="addDotToMiddleInitial('add_middle_name')">
                @csrf
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="add_last_name">Last Name <span style="color: red;">*</span></label>
                        <input type="text" id="add_last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(l){ return l.toUpperCase() })" required>
                        @error('last_name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add_first_name">First Name <span style="color: red;">*</span></label>
                        <input type="text" id="add_first_name" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').replace(/\b\w/g, function(l){ return l.toUpperCase() })" required>
                        @error('first_name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add_middle_name">Middle Initial</label>
                        <input type="text" id="add_middle_name" name="middle_name" value="{{ old('middle_name') }}" placeholder="M" maxlength="1" oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '').toUpperCase()">
                        @error('middle_name')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="add_employee_id">Employee ID Number <span style="color: red;">*</span></label>
                    <input type="text" id="add_employee_id" name="employee_id" value="{{ old('employee_id') }}" placeholder="Employee ID Number" maxlength="4" pattern="[0-9]{4}" title="Must be exactly 4 digits" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    @error('employee_id')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="add_email">Email Address <span style="color: red;">*</span></label>
                        <input type="email" id="add_email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                        @error('email')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add_phone_number">Phone Number <span style="color: red;">*</span></label>
                        <input type="text" id="add_phone_number" name="phone_number" value="{{ old('phone_number', '+63') }}" placeholder="+63XXXXXXXXXX" maxlength="13" pattern="\+63[0-9]{10}" title="Must be +63 followed by 10 digits" oninput="if(!this.value.startsWith('+63')) this.value = '+63'; this.value = '+63' + this.value.slice(3).replace(/[^0-9]/g, '').slice(0, 10);" required>
                        @error('phone_number')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="add_role">Role</label>
                        <select id="add_role" disabled style="background-color: #f0f0f0; cursor: not-allowed; appearance: none; -webkit-appearance: none; -moz-appearance: none;">
                            <option value="finance_officer" selected>Finance Officer</option>
                        </select>
                        <input type="hidden" name="role" value="finance_officer">
                        @error('role')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add_rank">Rank <span style="color: red;">*</span></label>
                        <select id="add_rank" name="rank" required>
                            <option value="" {{ old('rank') == '' ? 'selected' : '' }}>Select Rank</option>
                            <option value="I" {{ old('rank') == 'I' ? 'selected' : '' }}>I</option>
                            <option value="II" {{ old('rank') == 'II' ? 'selected' : '' }}>II</option>
                            <option value="III" {{ old('rank') == 'III' ? 'selected' : '' }}>III</option>
                            <option value="IV" {{ old('rank') == 'IV' ? 'selected' : '' }}>IV</option>
                            <option value="V" {{ old('rank') == 'V' ? 'selected' : '' }}>V</option>
                        </select>
                        @error('rank')
                            <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="status" value="{{ old('status', 'active') }}">
                <div class="form-group">
                    <label>Password</label>
                    <div class="password-note">
                        Password will be auto generated and sent via email provided.
                    </div>
                </div>
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal" id="confirmModal">
        <div class="confirm-modal-content">
            <div class="confirm-modal-header">
                <div class="confirm-modal-icon">
                    <i class="fas fa-question-circle" id="confirmIcon"></i>
                </div>
                <h3 class="confirm-modal-title" id="confirmTitle">Confirm Action</h3>
            </div>
            <div class="confirm-modal-body">
                <p class="confirm-modal-message" id="confirmMessage"></p>
            </div>
            <div class="confirm-modal-separator"></div>
            <div class="confirm-modal-buttons">
                <button class="btn btn-secondary" onclick="closeConfirmModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="btn btn-primary" id="confirmButton" onclick="confirmAction()">
                    <i class="fas fa-check"></i> Confirm
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal" id="successModal">
        <div class="confirm-modal-content">
            <div class="confirm-modal-header" style="background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);">
                <div class="confirm-modal-icon">
                    <i class="fas fa-check-circle" id="successIcon"></i>
                </div>
                <h3 class="confirm-modal-title" id="successTitle">Success</h3>
            </div>
            <div class="confirm-modal-body">
                <div class="success-check-icon" id="successCheckIcon">
                    <i class="fas fa-check"></i>
                </div>
                <p class="confirm-modal-message" id="successMessage"></p>
            </div>
        </div>
    </div>

    <script>
        // Add dot to middle initial before form submission
        function addDotToMiddleInitial(fieldId) {
            const field = document.getElementById(fieldId);
            if (field && field.value && !field.value.endsWith('.')) {
                field.value = field.value + '.';
            }
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

        // Open add modal
        function openAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.add('active');
        }

        // Close add modal
        function closeAddModal() {
            const modal = document.getElementById('addModal');
            modal.classList.remove('active');
        }

        // Open edit modal
        function openEditModal(user) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const roleRankRow = document.getElementById('edit_role_rank_row');
            
            // Ensure form is in edit mode (not view mode)
            enableEditForm();
            
            form.action = `/members/${user.id}`;
            document.getElementById('edit_first_name').value = user.first_name || '';
            document.getElementById('edit_middle_name').value = user.middle_name ? user.middle_name.replace('.', '') : '';
            document.getElementById('edit_last_name').value = user.last_name || '';
            document.getElementById('edit_employee_id').value = user.employee_id || '';
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_phone_number').value = user.phone_number || '';
            document.getElementById('edit_status').value = user.status || 'active';
            
            // Check if user is admin
            if (user.role === 'admin') {
                // Hide role and rank fields for admin
                roleRankRow.style.display = 'none';
                document.getElementById('edit_role_hidden').value = 'admin';
                document.getElementById('edit_rank').value = '';
                document.getElementById('edit_rank').removeAttribute('required');
            } else {
                // Show role and rank fields for non-admin users
                roleRankRow.style.display = 'flex';
                document.getElementById('edit_rank').setAttribute('required', 'required');
                
                // Extract rank from role (e.g., "finance_officer_IV" -> "IV")
                if (user.role) {
                    const roleParts = user.role.split('_');
                    const rank = roleParts[roleParts.length - 1]; // Get last part
                    if (['I', 'II', 'III', 'IV', 'V'].includes(rank)) {
                        document.getElementById('edit_rank').value = rank;
                        // Update hidden role field to base role
                        document.getElementById('edit_role_hidden').value = roleParts.slice(0, -1).join('_');
                    } else {
                        document.getElementById('edit_rank').value = '';
                        document.getElementById('edit_role_hidden').value = user.role;
                    }
                }
            }
            
            modal.classList.add('active');
        }

        // Close edit modal
        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.remove('active');
            // Re-enable all fields when closing
            enableEditForm();
        }

        // Open view modal (read-only for admin)
        function openViewModal(user) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const roleRankRow = document.getElementById('edit_role_rank_row');
            
            // Populate fields same as edit
            document.getElementById('edit_first_name').value = user.first_name || '';
            document.getElementById('edit_middle_name').value = user.middle_name ? user.middle_name.replace('.', '') : '';
            document.getElementById('edit_last_name').value = user.last_name || '';
            document.getElementById('edit_employee_id').value = user.employee_id || '';
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_phone_number').value = user.phone_number || '';
            document.getElementById('edit_status').value = user.status || 'active';
            
            // Hide role and rank for admin
            roleRankRow.style.display = 'none';
            
            // Disable all input fields for view-only mode
            document.querySelectorAll('#editForm input, #editForm select').forEach(field => {
                field.disabled = true;
                field.style.backgroundColor = '#f5f5f5';
                field.style.cursor = 'not-allowed';
            });
            
            // Hide submit button and change cancel button text
            const submitBtn = document.querySelector('#editForm button[type="submit"]');
            const cancelBtn = document.querySelector('#editForm button[type="button"]');
            if (submitBtn) submitBtn.style.display = 'none';
            if (cancelBtn) {
                cancelBtn.textContent = 'Close';
                cancelBtn.style.width = 'auto';
            }
            
            // Change modal title
            const modalTitle = document.querySelector('#editModal .modal-header h3');
            if (modalTitle) {
                modalTitle.innerHTML = '<i class="fas fa-eye"></i> View Member';
            }
            
            modal.classList.add('active');
        }

        // Helper function to re-enable edit form
        function enableEditForm() {
            document.querySelectorAll('#editForm input:not([type="hidden"]), #editForm select').forEach(field => {
                if (field.id !== 'edit_role') { // Keep role field disabled
                    field.disabled = false;
                    field.style.backgroundColor = '';
                    field.style.cursor = '';
                }
            });
            
            // Show submit button
            const submitBtn = document.querySelector('#editForm button[type="submit"]');
            const cancelBtn = document.querySelector('#editForm button[type="button"]');
            if (submitBtn) submitBtn.style.display = '';
            if (cancelBtn) {
                cancelBtn.textContent = 'Cancel';
                cancelBtn.style.width = '';
            }
            
            // Restore modal title
            const modalTitle = document.querySelector('#editModal .modal-header h3');
            if (modalTitle) {
                modalTitle.innerHTML = '<i class="fas fa-user-edit"></i> Edit Member';
            }
        }

        // Close modal when clicking outside
        document.getElementById('addModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddModal();
            }
        });

        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        // Auto-open add modal if there are validation errors
        @if($errors->any() && old('_token'))
            openAddModal();
        @endif

        // Real-time search functionality
        function searchMembers() {
            const searchValue = document.getElementById('memberSearch').value.toLowerCase();
            const memberRows = document.querySelectorAll('.member-row');
            
            memberRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const name = cells[1] ? cells[1].textContent.toLowerCase() : '';
                const employeeId = cells[2] ? cells[2].textContent.toLowerCase() : '';
                const email = cells[3] ? cells[3].textContent.toLowerCase() : '';
                const phoneNumber = cells[4] ? cells[4].textContent.toLowerCase() : '';
                
                if (name.includes(searchValue) || 
                    employeeId.includes(searchValue) || 
                    email.includes(searchValue) || 
                    phoneNumber.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Confirmation Modal Functions
        let confirmCallback = null;

        function confirmArchive(userId, userName) {
            const modal = document.getElementById('confirmModal');
            const title = document.getElementById('confirmTitle');
            const message = document.getElementById('confirmMessage');
            const icon = document.getElementById('confirmIcon');
            
            title.textContent = 'Archive Member';
            message.textContent = 'Are you sure you want to archive this member? The status will be set to inactive.';
            icon.className = 'fas fa-archive';
            
            confirmCallback = function() {
                document.getElementById('archive-form-' + userId).submit();
            };
            modal.classList.add('active');
        }

        function confirmRestore(userId, userName) {
            const modal = document.getElementById('confirmModal');
            const title = document.getElementById('confirmTitle');
            const message = document.getElementById('confirmMessage');
            const icon = document.getElementById('confirmIcon');
            
            title.textContent = 'Restore Member';
            message.textContent = 'Are you sure you want to restore this member? The status will be set to active.';
            icon.className = 'fas fa-undo';
            
            confirmCallback = function() {
                document.getElementById('restore-form-' + userId).submit();
            };
            modal.classList.add('active');
        }

        function confirmAction() {
            if (confirmCallback) {
                confirmCallback();
            }
            closeConfirmModal();
        }

        function closeConfirmModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.remove('active');
            confirmCallback = null;
        }

        // Close confirmation modal when clicking outside
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmModal();
            }
        });

        // Success Modal Functions
        function showSuccessModal(title, message, icon = 'fa-check-circle') {
            const modal = document.getElementById('successModal');
            const titleEl = document.getElementById('successTitle');
            const messageEl = document.getElementById('successMessage');
            const iconEl = document.getElementById('successIcon');
            const checkIcon = document.getElementById('successCheckIcon');
            
            titleEl.textContent = title;
            messageEl.textContent = message;
            iconEl.className = 'fas ' + icon;
            
            modal.classList.add('active');
            
            // Reset animation by cloning and replacing the element
            const newCheckIcon = checkIcon.cloneNode(true);
            checkIcon.parentNode.replaceChild(newCheckIcon, checkIcon);
            
            // Auto-close after animation completes (wait for bounce + display time)
            setTimeout(() => {
                modal.classList.add('modal-fade-out');
                setTimeout(() => {
                    modal.classList.remove('active');
                    modal.classList.remove('modal-fade-out');
                }, 300); // Wait for fade-out animation to complete
            }, 1000); // Wait 1 second (0.5s animation + 0.5s display)
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.add('modal-fade-out');
            setTimeout(() => {
                modal.classList.remove('active');
                modal.classList.remove('modal-fade-out');
            }, 300);
        }

        // Close success modal when clicking outside
        document.getElementById('successModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSuccessModal();
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

        // Check for success messages on page load
        @if (session('success'))
            @if (session('success') === 'Member archived successfully!')
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('Member archived successfully! Their status has been set to inactive.', 'success');
                });
            @elseif (session('success') === 'Member restored successfully!')
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('Member restored successfully! Their status has been set to active.', 'success');
                });
            @elseif (session('success') === 'Member updated successfully!')
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('Member information has been updated successfully.', 'success');
                });
            @elseif (str_starts_with(session('success'), 'Member added successfully'))
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('Member added successfully! Password has been sent via email.', 'success');
                });
            @else
                document.addEventListener('DOMContentLoaded', function() {
                    showToast('{{ session('success') }}', 'success');
                });
            @endif
        @endif
    </script>

    <!-- Toast Notification Container -->
    <div id="toastContainer"></div>

    @include('partials.floating-widgets')
</body>
</html>
