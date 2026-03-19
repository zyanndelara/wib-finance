<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - When in Baguio Inc.</title>
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

        /* --- Audit Logs Specific ------------------- */

        /* Stats bar */
        .audit-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .audit-stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            border-left: 4px solid #e8e8e8;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .audit-stat-card:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            transform: translateY(-1px);
        }

        .audit-stat-card.green  { border-left-color: #28a745; }
        .audit-stat-card.blue   { border-left-color: #17a2b8; }
        .audit-stat-card.yellow { border-left-color: #ffc107; }
        .audit-stat-card.red    { border-left-color: #dc3545; }

        .audit-stat-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .audit-stat-card.green  .audit-stat-icon { background: #d4edda; color: #28a745; }
        .audit-stat-card.blue   .audit-stat-icon { background: #d1ecf1; color: #17a2b8; }
        .audit-stat-card.yellow .audit-stat-icon { background: #fff3cd; color: #e0a800; }
        .audit-stat-card.red    .audit-stat-icon { background: #f8d7da; color: #dc3545; }

        .audit-stat-info h4 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            line-height: 1;
            margin-bottom: 4px;
        }

        .audit-stat-info p {
            font-size: 12px;
            color: #888;
            font-weight: 500;
        }

        /* Toolbar card */
        .audit-toolbar-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            margin-bottom: 20px;
        }

        .audit-toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .audit-search-wrap {
            flex: 1;
            min-width: 200px;
            position: relative;
        }

        .audit-search-wrap i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
            pointer-events: none;
        }

        .audit-search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
            outline: none;
            color: #333;
        }

        .audit-search-input:focus {
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .audit-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
            border: 1.5px solid #e8e8e8;
            background: #f9f9f9;
            color: #555;
            text-decoration: none;
        }

        .audit-btn:hover {
            border-color: #436026;
            color: #436026;
            background: #f0f7e6;
        }

        .audit-btn.primary {
            background: #436026;
            color: #fff;
            border-color: #436026;
        }

        .audit-btn.primary:hover {
            background: #5a7d33;
            border-color: #5a7d33;
        }

        .audit-btn i { font-size: 12px; }

        .audit-module-select {
            padding: 10px 14px;
            border: 1.5px solid #e8e8e8;
            border-radius: 8px;
            font-size: 13px;
            background: #f9f9f9;
            outline: none;
            cursor: pointer;
            color: #555;
            transition: all 0.2s;
            font-weight: 500;
        }

        .audit-module-select:focus,
        .audit-module-select:hover {
            border-color: #436026;
            background: #fff;
        }

        /* Active filter chips */
        .filter-chips {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: #edf5e1;
            border: 1px solid #c2dda0;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: #436026;
        }

        .filter-chip-remove {
            background: none;
            border: none;
            cursor: pointer;
            color: #436026;
            font-size: 13px;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
        }

        /* Date filter dropdown */
        .date-filter-dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: #fff;
            border: 1.5px solid #e8e8e8;
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(0,0,0,0.12);
            padding: 18px;
            z-index: 500;
            min-width: 270px;
        }

        .date-filter-dropdown.open { display: block; }

        .date-filter-dropdown .df-title {
            font-size: 13px;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }

        .date-filter-dropdown label {
            font-size: 11px;
            font-weight: 600;
            color: #888;
            display: block;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .date-filter-dropdown input[type=date] {
            width: 100%;
            padding: 9px 10px;
            border: 1.5px solid #e8e8e8;
            border-radius: 7px;
            font-size: 13px;
            margin-bottom: 12px;
            outline: none;
            transition: border-color 0.2s;
            background: #f9f9f9;
        }

        .date-filter-dropdown input[type=date]:focus {
            border-color: #436026;
            background: #fff;
        }

        .date-filter-actions {
            display: flex;
            gap: 8px;
        }

        .btn-apply-date {
            flex: 1;
            padding: 9px;
            background: #436026;
            color: #fff;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-apply-date:hover { background: #5a7d33; }

        .btn-clear-date {
            flex: 1;
            padding: 9px;
            background: #f0f0f0;
            color: #555;
            border: none;
            border-radius: 7px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-clear-date:hover { background: #e0e0e0; }

        /* Layout: table + side panel */
        .audit-layout {
            display: flex;
            gap: 0;
            align-items: flex-start;
            position: relative;
        }

        /* Table card */
        .audit-table-card {
            flex: 1;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            overflow: hidden;
            min-width: 0;
        }

        .audit-table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .audit-table-header h2 {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .audit-table-header .record-count {
            font-size: 12px;
            color: #888;
            background: #f0f0f0;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-table thead tr {
            background: #fafafa;
            border-bottom: 1.5px solid #f0f0f0;
        }

        .audit-table th {
            padding: 12px 16px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #999;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .audit-table td {
            padding: 14px 16px;
            font-size: 13px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }

        .audit-table tbody tr {
            transition: background 0.12s;
            cursor: pointer;
        }

        .audit-table tbody tr:hover { background: #f9fdf5; }

        .audit-table tbody tr.selected-row { background: #edf5e1; }

        .audit-table tbody tr:last-child td { border-bottom: none; }

        /* Date cell */
        .date-cell {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .date-cell .date-main {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }

        .date-cell .date-time {
            font-size: 11px;
            color: #aaa;
        }

        /* Action cell */
        .action-cell {
            max-width: 240px;
        }

        .action-cell .action-text {
            font-size: 13px;
            color: #333;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
        }

        /* User cell */
        .user-cell {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .user-avatar-sm {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #436026, #5a7d33);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-cell .user-email {
            font-size: 12px;
            color: #555;
        }

        /* Action button */
        .btn-view-details {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: #f0f7e6;
            color: #436026;
            border: 1px solid #c2dda0;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .btn-view-details:hover {
            background: #436026;
            color: #fff;
            border-color: #436026;
        }

        /* Status Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .badge-completed  { background: #d4edda; color: #155724; }
        .badge-completed::before  { background: #28a745; }
        .badge-cleared    { background: #cce5ff; color: #004085; }
        .badge-cleared::before    { background: #007bff; }
        .badge-dismissed  { background: #e2e3e5; color: #383d41; }
        .badge-dismissed::before  { background: #6c757d; }
        .badge-reversed   { background: #fff3cd; color: #856404; }
        .badge-reversed::before   { background: #ffc107; }
        .badge-bounced    { background: #f8d7da; color: #721c24; }
        .badge-bounced::before    { background: #dc3545; }

        /* --- Detail Panel ------------------- */
        .audit-detail-panel {
            width: 0;
            flex-shrink: 0;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
            overflow: hidden;
            position: sticky;
            top: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
            transition: width 0.25s ease, margin-left 0.25s ease, opacity 0.2s ease;
            opacity: 0;
            margin-left: 0;
            pointer-events: none;
        }

        .audit-detail-panel.open {
            width: 320px;
            opacity: 1;
            margin-left: 20px;
            pointer-events: auto;
        }

        .detail-panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 20px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
        }

        .detail-panel-header h3 {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .detail-panel-header h3 i { font-size: 13px; opacity: 0.8; }

        .detail-close-btn {
            background: rgba(255,255,255,0.15);
            border: none;
            font-size: 16px;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s;
            line-height: 1;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .detail-close-btn:hover { background: rgba(255,255,255,0.3); }

        .detail-audit-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-bottom: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .detail-audit-id-tag {
            font-size: 12px;
            font-weight: 700;
            color: #436026;
            background: #edf5e1;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #c2dda0;
        }

        .detail-panel-body {
            padding: 16px 20px;
            overflow-y: auto;
            max-height: calc(100vh - 200px);
        }

        .detail-section {
            margin-bottom: 16px;
        }

        .detail-section-title {
            font-size: 10px;
            font-weight: 700;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .detail-kv {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 8px;
            margin-bottom: 9px;
        }

        .detail-kv:last-child { margin-bottom: 0; }

        .detail-key {
            font-size: 12px;
            color: #aaa;
            font-weight: 600;
            white-space: nowrap;
            min-width: 85px;
        }

        .detail-val {
            font-size: 12px;
            color: #222;
            font-weight: 500;
            text-align: right;
            word-break: break-word;
        }

        .detail-divider {
            border: none;
            border-top: 1px solid #f0f0f0;
            margin: 14px 0;
        }

        .detail-file-link {
            color: #436026;
            font-size: 12px;
            text-decoration: underline;
        }

        .detail-amount-highlight {
            font-size: 18px;
            font-weight: 700;
            color: #436026;
        }

        /* Mini history table */
        .audit-history-title {
            font-size: 10px;
            font-weight: 700;
            color: #bbb;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 10px;
        }

        .audit-history-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            border-radius: 8px;
            overflow: hidden;
        }

        .audit-history-table th {
            padding: 7px 8px;
            text-align: left;
            font-weight: 700;
            color: #777;
            border-bottom: 1px solid #e8e8e8;
            background: #f7f7f7;
        }

        .audit-history-table td {
            padding: 7px 8px;
            color: #555;
            border-bottom: 1px solid #f4f4f4;
        }

        /* Bottom row */
        .audit-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .audit-pagination {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .audit-pagination .page-label {
            font-size: 12px;
            color: #999;
            margin-right: 4px;
        }

        .audit-pagination a,
        .audit-pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 6px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            color: #555;
            background: #fff;
            border: 1.5px solid #e8e8e8;
            transition: all 0.2s;
            font-weight: 500;
        }

        .audit-pagination span.current {
            background: #436026;
            color: #fff;
            border-color: #436026;
            font-weight: 700;
        }

        .audit-pagination a:hover {
            background: #f0f7e6;
            border-color: #436026;
            color: #436026;
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px;
            color: #ccc;
        }

        .empty-state i {
            font-size: 52px;
            margin-bottom: 14px;
            display: block;
        }

        .empty-state p {
            font-size: 15px;
            font-weight: 500;
            color: #aaa;
        }

        .empty-state small {
            font-size: 12px;
            color: #ccc;
            display: block;
            margin-top: 4px;
        }

        @media (max-width: 1100px) {
            .audit-stats { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 900px) {
            .audit-stats { grid-template-columns: repeat(2, 1fr); }
            .audit-detail-panel {
                width: 100%;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                max-height: 70vh;
                overflow-y: auto;
                border-radius: 16px 16px 0 0;
                z-index: 800;
                box-shadow: 0 -4px 20px rgba(0,0,0,0.15);
            }
        }

        @media (max-width: 600px) {
            .audit-stats { grid-template-columns: 1fr 1fr; }
            .audit-stat-info h4 { font-size: 18px; }
        }

        @include('partials.user-indicator-styles')
    </style>
</head>
<body>
    @include('partials.app-sidebar', ['activePage' => 'audit-logs'])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Audit Logs</h1>
            @include('partials.user-indicator')
        </div>

        {{-- Search & Filter Toolbar --}}
        <form method="GET" action="{{ route('audit-logs') }}" id="auditFilterForm">
            <div class="audit-toolbar-card">
                <div class="audit-toolbar">
                    <div class="audit-search-wrap">
                        <i class="fas fa-search"></i>
                        <input
                            type="text"
                            name="search"
                            id="auditSearchInput"
                            class="audit-search-input"
                            placeholder="Search by action, module or user..."
                            value="{{ request('search') }}"
                            autocomplete="off"
                        >
                    </div>

                    {{-- Date filter --}}
                    <div style="position:relative;">
                        <button type="button" class="audit-btn" id="dateFilterToggle">
                            <i class="fas fa-calendar-alt"></i>
                            @if(request('date_from') || request('date_to'))
                                <span style="color:#436026;font-weight:600;">
                                    {{ request('date_from') ?? '...' }} ? {{ request('date_to') ?? '...' }}
                                </span>
                            @else
                                Date Range
                            @endif
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="date-filter-dropdown" id="dateFilterDropdown">
                            <div class="df-title"><i class="fas fa-calendar-alt" style="margin-right:6px;color:#436026;"></i>Filter by Date</div>
                            <label>From</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}">
                            <label>To</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}">
                            <div class="date-filter-actions">
                                <button type="submit" class="btn-apply-date">Apply</button>
                                <button type="button" class="btn-clear-date" id="clearDateBtn">Clear</button>
                            </div>
                        </div>
                    </div>

                    {{-- Module Filter --}}
                    <select name="module" class="audit-module-select" onchange="this.form.submit()">
                        <option value="">All Modules</option>
                        @foreach($modules ?? [] as $mod)
                            <option value="{{ $mod }}" {{ request('module') === $mod ? 'selected' : '' }}>{{ $mod }}</option>
                        @endforeach
                    </select>

                    @if(request('search') || request('module') || request('date_from') || request('date_to'))
                        <a href="{{ route('audit-logs') }}" class="audit-btn">
                            <i class="fas fa-times"></i> Clear All
                        </a>
                    @endif
                </div>

                {{-- Active filter chips --}}
                @if(request('search') || request('module') || request('date_from') || request('date_to'))
                <div class="filter-chips">
                    @if(request('search'))
                        <span class="filter-chip"><i class="fas fa-search" style="font-size:9px;"></i> "{{ request('search') }}"</span>
                    @endif
                    @if(request('module'))
                        <span class="filter-chip"><i class="fas fa-layer-group" style="font-size:9px;"></i> {{ request('module') }}</span>
                    @endif
                    @if(request('date_from') || request('date_to'))
                        <span class="filter-chip"><i class="fas fa-calendar" style="font-size:9px;"></i> {{ request('date_from','...') }} ? {{ request('date_to','...') }}</span>
                    @endif
                </div>
                @endif
            </div>
        </form>

        {{-- Audit Layout: table + detail panel --}}
        <div class="audit-layout">

            {{-- Table Card --}}
            <div class="audit-table-card" id="auditTableCard">
                <div class="audit-table-header">
                    <h2><i class="fas fa-clipboard-list" style="color:#436026;margin-right:8px;"></i>Audit Logs</h2>
                    @if(isset($logs))
                        <span class="record-count">{{ $logs->total() }} {{ Str::plural('record', $logs->total()) }}</span>
                    @endif
                </div>

                @if(isset($logs) && $logs->count() > 0)
                    <table class="audit-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>User</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr
                                class="audit-row"
                                data-id="{{ $log->id }}"
                                data-audit-id="Audit/{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}"
                                data-date="{{ $log->created_at->format('Y-m-d') }}"
                                data-module="{{ $log->module }}"
                                data-action="{{ $log->action }}"
                                data-user="{{ $log->user->email ?? '-' }}"
                                data-status="{{ $log->status }}"
                                data-amount="{{ $log->amount ? number_format($log->amount, 2) : '-' }}"
                                data-source-bank="{{ $log->source_bank ?? '-' }}"
                                data-initiated-user="{{ $log->initiated_user ?? $log->user->email ?? '-' }}"
                                data-attached-file="{{ $log->attached_file ?? '' }}"
                            >
                                <td>
                                    <div class="date-cell">
                                        <span class="date-main">{{ $log->created_at->format('Y-m-d') }}</span>
                                        <span class="date-time">{{ $log->created_at->format('h:i A') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $moduleColors = [
                                            'Remittance'        => ['bg'=>'#dbeafe','text'=>'#1e40af'],
                                            'Bank & Deposit'    => ['bg'=>'#d1fae5','text'=>'#065f46'],
                                            'Member Management' => ['bg'=>'#fef3c7','text'=>'#92400e'],
                                            'Profile'           => ['bg'=>'#ede9fe','text'=>'#4c1d95'],
                                            'General'           => ['bg'=>'#f3f4f6','text'=>'#374151'],
                                        ];
                                        $mc = $moduleColors[$log->module] ?? ['bg'=>'#f3f4f6','text'=>'#374151'];
                                    @endphp
                                    <span class="badge" style="background:{{ $mc['bg'] }};color:{{ $mc['text'] }};">{{ $log->module }}</span>
                                </td>
                                <td class="action-cell">
                                    <span class="action-text" title="{{ $log->action }}">{{ $log->action }}</span>
                                </td>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-sm">
                                            {{ strtoupper(substr($log->user->name ?? $log->user->email ?? '?', 0, 1)) }}
                                        </div>
                                        <span class="user-email">{{ $log->user->email ?? '-' }}</span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $badgeMap = [
                                            'completed' => 'badge-completed',
                                            'cleared'   => 'badge-cleared',
                                            'dismissed' => 'badge-dismissed',
                                            'reversed'  => 'badge-reversed',
                                            'bounced'   => 'badge-bounced',
                                        ];
                                        $badgeClass = $badgeMap[strtolower($log->status)] ?? 'badge-dismissed';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($log->status) }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn-view-details open-detail-btn">
                                        <i class="fas fa-eye"></i> Details
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-list"></i>
                        <p>No audit logs found.</p>
                        <small>Try adjusting your filters or search terms.</small>
                    </div>
                @endif
            </div>

            {{-- Detail Panel --}}
            <div class="audit-detail-panel" id="auditDetailPanel">
                <div class="detail-panel-header">
                    <h3><i class="fas fa-info-circle"></i> Transaction Details</h3>
                    <button type="button" class="detail-close-btn" id="closeDetailPanel"><i class="fas fa-times"></i></button>
                </div>
                <div class="detail-audit-badge">
                    <span class="detail-audit-id-tag" id="detailAuditId"></span>
                    <span id="detailStatusBadge"></span>
                </div>
                <div class="detail-panel-body">

                    <div class="detail-section">
                        <div class="detail-section-title">Overview</div>
                        <div class="detail-kv">
                            <span class="detail-key">Date</span>
                            <span class="detail-val" id="detailDate"></span>
                        </div>
                        <div class="detail-kv">
                            <span class="detail-key">Module</span>
                            <span class="detail-val" id="detailModule"></span>
                        </div>
                        <div class="detail-kv">
                            <span class="detail-key">Action</span>
                            <span class="detail-val" id="detailAction"></span>
                        </div>
                        <div class="detail-kv">
                            <span class="detail-key">User</span>
                            <span class="detail-val" id="detailUser"></span>
                        </div>
                    </div>

                    <hr class="detail-divider" id="financialDivider">

                    <div class="detail-section" id="financialSection">
                        <div class="detail-section-title">Financial</div>
                        <div class="detail-kv">
                            <span class="detail-key">Amount</span>
                            <span class="detail-val detail-amount-highlight" id="detailAmount"></span>
                        </div>
                        <div class="detail-kv">
                            <span class="detail-key">Source</span>
                            <span class="detail-val" id="detailSourceBank"></span>
                        </div>
                    </div>

                    <hr class="detail-divider">

                    <div class="detail-section">
                        <div class="detail-section-title">Audit Trail</div>
                        <div class="detail-kv">
                            <span class="detail-key">Initiated by</span>
                            <span class="detail-val" id="detailInitiatedUser"></span>
                        </div>
                        <div class="detail-kv" id="detailFileRow">
                            <span class="detail-key">Attachment</span>
                            <span class="detail-val" id="detailAttachedFile"></span>
                        </div>
                    </div>

                    <hr class="detail-divider">

                    <div class="audit-history-title">Full Audit History</div>
                    <table class="audit-history-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Action</th>
                                <th>By</th>
                            </tr>
                        </thead>
                        <tbody id="detailHistoryBody"></tbody>
                    </table>
                </div>
            </div>

        </div>{{-- /audit-layout --}}

        {{-- Bottom Row: Pagination + Full Report --}}
        <div class="audit-bottom" id="auditBottom">
            <div class="audit-pagination" id="auditPagination">
                @if(isset($logs))
                    <span class="page-label">Page {{ $logs->currentPage() }} of {{ $logs->lastPage() }}</span>
                    @if($logs->onFirstPage())
                        <span><i class="fas fa-chevron-left" style="font-size:10px;"></i></span>
                    @else
                        <a href="{{ $logs->previousPageUrl() }}"><i class="fas fa-chevron-left" style="font-size:10px;"></i></a>
                    @endif

                    @foreach($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                        @if($page == $logs->currentPage())
                            <span class="current">{{ $page }}</span>
                        @elseif(abs($page - $logs->currentPage()) <= 2 || $page == 1 || $page == $logs->lastPage())
                            <a href="{{ $url }}">{{ $page }}</a>
                        @elseif(abs($page - $logs->currentPage()) == 3)
                            <span style="border:none;background:none;color:#ccc;width:auto;">�</span>
                        @endif
                    @endforeach

                    @if($logs->hasMorePages())
                        <a href="{{ $logs->nextPageUrl() }}"><i class="fas fa-chevron-right" style="font-size:10px;"></i></a>
                    @else
                        <span><i class="fas fa-chevron-right" style="font-size:10px;"></i></span>
                    @endif
                @endif
            </div>


        </div>

    </div>{{-- /main-content --}}

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

        // --- Live Search ----------------------------------------
        (function () {
            const searchInput = document.getElementById('auditSearchInput');
            if (!searchInput) return;

            let debounceTimer = null;

            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value.trim();

                // Show a subtle loading hint
                const tableCard = document.getElementById('auditTableCard');
                if (tableCard) tableCard.style.opacity = '0.55';

                debounceTimer = setTimeout(function () {
                    const form   = document.getElementById('auditFilterForm');
                    const params = new URLSearchParams();

                    // Carry over module / date filters from the form
                    const moduleEl    = form.querySelector('[name=module]');
                    const dateFromEl  = form.querySelector('[name=date_from]');
                    const dateToEl    = form.querySelector('[name=date_to]');
                    if (moduleEl   && moduleEl.value)   params.set('module',    moduleEl.value);
                    if (dateFromEl && dateFromEl.value) params.set('date_from', dateFromEl.value);
                    if (dateToEl   && dateToEl.value)   params.set('date_to',   dateToEl.value);
                    if (query) params.set('search', query);

                    const url = '{{ route('audit-logs') }}?' + params.toString();

                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (res) { return res.text(); })
                        .then(function (html) {
                            const parser   = new DOMParser();
                            const doc      = parser.parseFromString(html, 'text/html');

                            // Replace table card
                            const newCard  = doc.getElementById('auditTableCard');
                            const oldCard  = document.getElementById('auditTableCard');
                            if (newCard && oldCard) {
                                oldCard.innerHTML = newCard.innerHTML;
                                oldCard.style.opacity = '1';
                            }

                            // Replace pagination
                            const newPag  = doc.getElementById('auditPagination');
                            const oldPag  = document.getElementById('auditPagination');
                            if (newPag && oldPag) oldPag.innerHTML = newPag.innerHTML;

                            // Re-bind row + detail panel events
                            bindRowEvents();

                            // Update browser URL without reload
                            window.history.replaceState(null, '', url);
                        })
                        .catch(function () {
                            if (tableCard) tableCard.style.opacity = '1';
                        });
                }, 350);
            });
        })();

        // --- Date Filter Toggle --------------------------------
        document.getElementById('dateFilterToggle').addEventListener('click', function (e) {
            e.stopPropagation();
            document.getElementById('dateFilterDropdown').classList.toggle('open');
        });

        document.addEventListener('click', function () {
            document.getElementById('dateFilterDropdown').classList.remove('open');
        });

        document.getElementById('dateFilterDropdown').addEventListener('click', function (e) {
            e.stopPropagation();
        });

        document.getElementById('clearDateBtn').addEventListener('click', function () {
            const form = document.getElementById('auditFilterForm');
            form.querySelector('[name=date_from]').value = '';
            form.querySelector('[name=date_to]').value   = '';
            form.submit();
        });

        // --- View Details Panel --------------------------------
        const detailPanel = document.getElementById('auditDetailPanel');

        function bindRowEvents() {
            document.querySelectorAll('.open-detail-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    openDetailPanel(btn.closest('.audit-row'));
                });
            });
            document.querySelectorAll('.audit-row').forEach(function (row) {
                row.addEventListener('click', function () { openDetailPanel(row); });
            });
        }

        function openDetailPanel(row) {
            // Highlight row
            document.querySelectorAll('.audit-row').forEach(r => r.classList.remove('selected-row'));
            row.classList.add('selected-row');

            const d = row.dataset;

            document.getElementById('detailAuditId').textContent = d.auditId;
            document.getElementById('detailDate').textContent     = d.date;
            document.getElementById('detailModule').textContent   = d.module;
            document.getElementById('detailAction').textContent   = d.action;
            document.getElementById('detailUser').textContent     = d.user;

            // Status badge
            const statusMap = {
                completed: 'badge-completed',
                cleared:   'badge-cleared',
                dismissed: 'badge-dismissed',
                reversed:  'badge-reversed',
                bounced:   'badge-bounced',
            };
            const cls = statusMap[(d.status || '').toLowerCase()] || 'badge-dismissed';
            document.getElementById('detailStatusBadge').innerHTML =
                `<span class="badge ${cls}">${d.status.charAt(0).toUpperCase() + d.status.slice(1)}</span>`;

            const isMemberMgmt = (d.module || '').toLowerCase().includes('member');
            document.getElementById('financialSection').style.display = isMemberMgmt ? 'none' : '';
            document.getElementById('financialDivider').style.display  = isMemberMgmt ? 'none' : '';

            document.getElementById('detailAmount').textContent       = d.amount !== '-' ? '$' + d.amount : '-';
            document.getElementById('detailSourceBank').textContent   = d.sourceBank;
            document.getElementById('detailInitiatedUser').textContent = d.initiatedUser;

            // Attached file
            const fileEl = document.getElementById('detailAttachedFile');
            if (d.attachedFile && d.attachedFile !== '') {
                fileEl.innerHTML = `<a href="/storage/${d.attachedFile}" target="_blank" class="detail-file-link">${d.attachedFile.split('/').pop()}</a>`;
                document.getElementById('detailFileRow').style.display = 'flex';
            } else {
                document.getElementById('detailFileRow').style.display = 'none';
            }

            // Build mini audit history (just this row for now)
            document.getElementById('detailHistoryBody').innerHTML = `
                <tr>
                    <td>${d.date}</td>
                    <td>${d.action}</td>
                    <td>${d.user}</td>
                </tr>
            `;

            detailPanel.classList.add('open');
        }

        bindRowEvents();

        document.getElementById('closeDetailPanel').addEventListener('click', function () {
            detailPanel.classList.remove('open');
            document.querySelectorAll('.audit-row').forEach(r => r.classList.remove('selected-row'));
        });
    </script>

    <!-- Toast Notification Container -->
    <div id="toastContainer"></div>

    @include('partials.floating-widgets')
</body>
</html>
