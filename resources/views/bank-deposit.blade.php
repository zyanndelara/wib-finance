<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bank & Deposit - When in Baguio Inc.</title>
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
            background: transparent;
            border-radius: 12px;
            padding: 0;
            min-height: 300px;
            grid-column: 1 / -1;
        }

        /* Bank Deposit Styles */
        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title::before {
            content: '';
            width: 4px;
            height: 28px;
            background: linear-gradient(180deg, #436026 0%, #5a7d33 100%);
            border-radius: 3px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .summary-card {
            border-radius: 18px;
            padding: 22px 20px 18px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.13);
            position: relative;
            overflow: hidden;
            transition: transform 0.28s cubic-bezier(.34,1.56,.64,1), box-shadow 0.28s ease;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border: none;
        }

        /* Decorative large background orb */
        .summary-card::before {
            content: '';
            position: absolute;
            top: -28px;
            right: -28px;
            width: 110px;
            height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.13);
            pointer-events: none;
        }
        .summary-card::after {
            content: '';
            position: absolute;
            bottom: -36px;
            left: -18px;
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.08);
            pointer-events: none;
        }

        .summary-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 18px 40px rgba(0,0,0,0.18);
        }

        /* Card 1 � Expected Remit (indigo-blue) */
        .summary-cards .summary-card:nth-child(1) {
            background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 60%, #60a5fa 100%);
        }
        .summary-cards .summary-card:nth-child(1):hover {
            box-shadow: 0 18px 40px rgba(59,130,246,0.45);
        }

        /* Card 2 � Cash Collected (emerald) */
        .summary-cards .summary-card:nth-child(2) {
            background: linear-gradient(135deg, #065f46 0%, #059669 55%, #34d399 100%);
        }
        .summary-cards .summary-card:nth-child(2):hover {
            box-shadow: 0 18px 40px rgba(5,150,105,0.45);
        }

        /* Card 3 � Discrepancy (rose-red) */
        .summary-cards .summary-card:nth-child(3) {
            background: linear-gradient(135deg, #9f1239 0%, #dc2626 55%, #f87171 100%);
        }
        .summary-cards .summary-card:nth-child(3):hover {
            box-shadow: 0 18px 40px rgba(220,38,38,0.45);
        }

        /* Card 4 � Change (amber-orange) */
        .summary-cards .summary-card:nth-child(4) {
            background: linear-gradient(135deg, #92400e 0%, #d97706 55%, #fbbf24 100%);
        }
        .summary-cards .summary-card:nth-child(4):hover {
            box-shadow: 0 18px 40px rgba(217,119,6,0.45);
        }

        .summary-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .summary-card-label {
            font-size: 11px;
            font-weight: 700;
            color: rgba(255,255,255,0.82);
            text-transform: uppercase;
            letter-spacing: 0.7px;
            line-height: 1.4;
            flex: 1;
        }

        .summary-card-icon {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.22);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 19px;
            flex-shrink: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.18), inset 0 1px 0 rgba(255,255,255,0.3);
            border: 1px solid rgba(255,255,255,0.25);
        }

        .summary-card-value {
            font-size: 26px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            line-height: 1;
            text-shadow: 0 1px 4px rgba(0,0,0,0.15);
        }

        .summary-card-sub {
            font-size: 10.5px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
            margin-top: -4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .controls-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 10px 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }

        .controls-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .controls-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .search-box {
            flex: 1;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 7px 12px 7px 34px;
            border: 1.5px solid #e9ecef;
            border-radius: 7px;
            font-size: 13px;
            background: #f8f9fa;
            transition: all 0.25s ease;
            color: #2d3436;
        }

        .search-box input:focus {
            outline: none;
            border-color: #436026;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .search-box i {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 12px;
        }

        .filter-dropdown {
            position: relative;
        }

        .filter-dropdown select {
            padding: 7px 36px 7px 12px;
            border: 1.5px solid #e9ecef;
            border-radius: 7px;
            font-size: 13px;
            background: #f8f9fa;
            cursor: pointer;
            appearance: none;
            font-weight: 500;
            color: #2d3436;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .filter-dropdown select:focus {
            outline: none;
            border-color: #436026;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .filter-dropdown::after {
            content: '\f0d7';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 11px;
            color: #666;
            pointer-events: none;
        }

        .content-layout {
            display: grid;
            grid-template-columns: 1fr 240px;
            gap: 16px;
        }

        .table-section {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .data-table thead {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
        }

        .data-table th {
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table th:first-child {
            border-top-left-radius: 10px;
        }

        .data-table th:last-child {
            border-top-right-radius: 10px;
        }

        .data-table td {
            padding: 7px 10px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 12px;
            color: #2d3436;
        }

        .data-table tbody tr {
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .sidebar-widgets {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .calendar-widget {
            background: #fff;
            border-radius: 10px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }

        .calendar-month {
            font-weight: 700;
            font-size: 13px;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .calendar-month::before {
            content: '\f133';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #436026;
            font-size: 12px;
        }

        .calendar-nav {
            display: flex;
            gap: 4px;
        }

        .calendar-nav button {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            cursor: pointer;
            color: #636e72;
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .calendar-nav button:hover {
            background: #436026;
            color: white;
            border-color: #436026;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .calendar-day-header {
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            color: #636e72;
            padding: 4px 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        #calendarDays {
            display: contents;
        }

        .calendar-day {
            text-align: center;
            padding: 5px 4px 3px;
            font-size: 11px;
            border-radius: 4px;
            cursor: pointer;
            color: #2d3436;
            font-weight: 500;
            transition: all 0.2s ease;
            position: relative;
            line-height: 1.3;
        }

        .calendar-day:hover {
            background: #e8f5e9;
            color: #436026;
            transform: scale(1.1);
        }

        .calendar-day.selected {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(67, 96, 38, 0.4);
            font-weight: 700;
        }

        .calendar-day.today {
            background: #e8f5e9;
            color: #436026;
            font-weight: 700;
            border: 2px solid #436026;
        }

        .calendar-day.today.selected {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: 2px solid #5a7d33;
        }

        .calendar-day.disabled {
            color: #dfe6e9;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .calendar-day.disabled:hover {
            background: transparent;
            transform: none;
            color: #dfe6e9;
        }

        .calendar-day.other-month {
            color: #b2bec3;
            cursor: pointer;
        }

        .calendar-day.other-month:hover {
            color: #636e72;
            background: rgba(67, 96, 38, 0.1);
        }

        /* Calendar day indicators */
        .calendar-day .cal-dots {
            display: flex;
            justify-content: center;
            gap: 2px;
            margin-top: 2px;
            height: 5px;
        }
        .cal-dot-disc {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #ef4444;
        }
        .cal-dot-valid {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #f97316;
        }
        .cal-dot-change {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #fbbf24;
        }
        .calendar-day.selected .cal-dot-disc   { background: #fca5a5; }
        .calendar-day.selected .cal-dot-valid  { background: #fed7aa; }
        .calendar-day.selected .cal-dot-change { background: #fde68a; }

        /* Tooltip on hover for indicator days */
        .calendar-day[data-has-indicator="1"]::after {
            content: attr(data-indicator-label);
            position: absolute;
            bottom: calc(100% + 5px);
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: #fff;
            font-size: 10px;
            white-space: nowrap;
            padding: 3px 7px;
            border-radius: 5px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.15s;
            z-index: 10;
        }
        .calendar-day[data-has-indicator="1"]:hover::after {
            opacity: 1;
        }

        /* Rider table row selection styles */
        .rider-row:hover {
            background-color: #f1f8e9 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(67, 96, 38, 0.15);
        }

        .rider-row.selected {
            background-color: #e8f5e8 !important;
            border-left: 4px solid #436026;
        }

        .rider-row.selected:hover {
            background-color: #dff0d8 !important;
        }

        /* Rider table row selection styles */
        .rider-row:hover {
            background-color: #f1f8e9 !important;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(67, 96, 38, 0.15);
        }

        .rider-row.selected {
            background-color: #e8f5e8 !important;
            border-left: 4px solid #436026;
        }

        .rider-row.selected:hover {
            background-color: #dff0d8 !important;
        }

        .denomination-widget {
            background: #fff;
            border-radius: 10px;
            padding: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            border: 1px solid #f0f0f0;
        }

        .denomination-header {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .denomination-header button:hover {
            background: #e0e0e0;
            border-color: #d0d0d0;
        }

        .denomination-header::before {
            content: '\f51e';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #436026;
        }

        .denomination-table {
            width: 100%;
            border-collapse: collapse;
        }

        .denomination-table th {
            padding: 8px 6px;
            text-align: left;
            font-weight: 700;
            color: #2d3436;
            border-bottom: 2px solid #e9ecef;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .denomination-table td {
            padding: 6px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 11px;
            color: #2d3436;
        }

        .denomination-table input {
            width: 100%;
            padding: 4px 6px;
            border: 2px solid #e9ecef;
            border-radius: 4px;
            font-size: 11px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        /* Auto-sizing input for bank field */
        .denomination-table .total-row:last-child input {
            min-width: 80px;
            width: auto;
            max-width: 100%;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            text-align: right;
        }

        /* Readonly bank input styling */
        .denomination-table .total-row:last-child input[readonly] {
            color: #495057;
            cursor: not-allowed;
            border-color: #ced4da;
        }

        .denomination-table input:focus {
            outline: none;
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .denomination-table .total-row {
            font-weight: 700;
            color: #1a1a1a;
        }

        .denomination-table .total-row td {
            border-bottom: none;
            padding: 8px 6px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: 18px;
            padding-top: 18px;
            border-top: 2px solid #f0f0f0;
        }

        .pagination button {
            padding: 8px 12px;
            border: 2px solid #e9ecef;
            background: #fff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #2d3436;
            transition: all 0.3s ease;
            min-width: 36px;
        }

        .pagination button:hover {
            background: #f8f9fa;
            border-color: #436026;
            color: #436026;
            transform: translateY(-2px);
        }

        .pagination button.active {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-color: #436026;
            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.3);
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

        /* Fade-in animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .summary-cards .summary-card {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        .summary-cards .summary-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .summary-cards .summary-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .summary-cards .summary-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .summary-cards .summary-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .content-layout {
            animation: fadeInUp 0.6s ease-out 0.5s forwards;
            opacity: 0;
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

            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .content-layout {
                grid-template-columns: 1fr;
            }

            .sidebar-widgets {
                grid-template-columns: repeat(2, 1fr);
                display: grid;
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

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .sidebar-widgets {
                grid-template-columns: 1fr;
            }

            .controls-section {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .controls-left {
                flex-direction: column;
            }
            .controls-right {
                justify-content: flex-end;
            }

            .data-table {
                font-size: 11px;
                display: block;
                overflow-x: auto;
                border-radius: 10px;
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;
                font-size: 11px;
            }

            .table-section,
            .calendar-widget,
            .denomination-widget {
                padding: 10px;
            }

            .denomination-header {
                font-size: 12px;
            }

            .calendar-month {
                font-size: 12px;
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

            .content-box-large {
                padding: 0;
            }

            .page-title {
                font-size: 20px;
            }

            .page-title::before {
                height: 24px;
                width: 3px;
            }

            .summary-card-value {
                font-size: 19px;
            }

            .summary-card-icon {
                width: 36px;
                height: 36px;
                font-size: 15px;
            }

            .summary-card-label {
                font-size: 9.5px;
            }

            .summary-card-sub {
                display: none;
            }

            .data-table {
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .data-table thead,
            .data-table tbody,
            .data-table tr {
                display: table;
                width: 100%;
                table-layout: fixed;
            }
        }

        /* Report Button */
        .btn-report {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            letter-spacing: 0.3px;
            box-shadow: 0 2px 8px rgba(67, 96, 38, 0.28);
        }
        .btn-report:hover {
            background: linear-gradient(135deg, #3a5420 0%, #4e6e2b 100%);
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(67, 96, 38, 0.38);
        }
        .btn-report:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(67, 96, 38, 0.25);
        }
        .btn-report i { font-size: 13px; }

        /* Report Modal */
        .report-modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9998;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        .report-modal-overlay.open { display: flex; }
        .report-modal {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 28px 70px rgba(0,0,0,0.22);
            width: 92%;
            max-width: 500px;
            overflow: hidden;
            animation: modalIn .22s ease;
        }
        /* Accent top bar */
        .report-modal-topbar {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            padding: 20px 24px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .report-modal-topbar-left { display: flex; align-items: center; gap: 12px; }
        .report-modal-topbar-icon {
            width: 40px; height: 40px;
            background: rgba(255,255,255,0.18);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .report-modal-topbar-icon i { color: #fff; font-size: 17px; }
        .report-modal-topbar-title { font-size: 16px; font-weight: 700; color: #fff; line-height: 1.2; }
        .report-modal-topbar-sub   { font-size: 11px; color: rgba(255,255,255,0.75); margin-top: 2px; }
        .report-modal-close {
            width: 30px; height: 30px;
            background: rgba(255,255,255,0.15);
            border: none; border-radius: 50%;
            color: #fff; font-size: 13px;
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: background 0.2s;
        }
        .report-modal-close:hover { background: rgba(255,255,255,0.3); }
        /* Body */
        .report-modal-body { padding: 22px 24px 0; }
        .report-section-label {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .report-section-label::before {
            content: '';
            width: 3px; height: 12px;
            background: #436026;
            border-radius: 2px;
            flex-shrink: 0;
        }
        .report-form-group { margin-bottom: 18px; }
        /* Date row */
        .report-date-row {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }
        .report-date-sep { font-size: 11px; font-weight: 600; color: #9ca3af; text-align: center; }
        .report-date-field {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .report-date-field span {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .report-input {
            width: 100%;
            padding: 8px 11px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            color: #111827;
            background: #f9fafb;
            transition: all 0.2s;
        }
        .report-input:focus {
            outline: none;
            border-color: #436026;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(67,96,38,0.1);
        }
        /* Report type cards */
        .report-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 18px;
        }
        .report-type-card {
            position: relative;
            cursor: pointer;
        }
        .report-type-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .report-type-card-inner {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 11px 8px;
            text-align: center;
            transition: all 0.2s;
            background: #f9fafb;
        }
        .report-type-card-inner i {
            display: block;
            font-size: 18px;
            margin-bottom: 6px;
            color: #9ca3af;
            transition: color 0.2s;
        }
        .report-type-card-inner span {
            font-size: 10px;
            font-weight: 600;
            color: #6b7280;
            line-height: 1.3;
            display: block;
            transition: color 0.2s;
        }
        .report-type-card input:checked + .report-type-card-inner {
            border-color: #436026;
            background: #f0fdf0;
            box-shadow: 0 0 0 3px rgba(67,96,38,0.1);
        }
        .report-type-card input:checked + .report-type-card-inner i { color: #436026; }
        .report-type-card input:checked + .report-type-card-inner span { color: #436026; font-weight: 700; }
        .report-type-card-inner:hover { border-color: #436026; background: #f9fff4; }
        /* Column chips */
        .report-col-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
            margin-bottom: 18px;
        }
        .report-col-chip {
            position: relative;
            cursor: pointer;
        }
        .report-col-chip input[type="checkbox"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .report-col-chip-inner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 6px;
            border: 1.5px solid #e5e7eb;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 600;
            color: #6b7280;
            background: #f9fafb;
            transition: all 0.18s;
            white-space: nowrap;
        }
        .report-col-chip-inner i { font-size: 10px; }
        .report-col-chip input:checked + .report-col-chip-inner {
            border-color: #436026;
            background: #f0fdf0;
            color: #436026;
            box-shadow: 0 0 0 2px rgba(67,96,38,0.12);
        }
        .report-col-chip-inner:hover { border-color: #436026; background: #f9fff4; color: #436026; }
        /* Format toggle */
        .report-format-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 20px;
        }
        .report-format-opt {
            position: relative;
            cursor: pointer;
        }
        .report-format-opt input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .report-format-opt-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 14px;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            background: #f9fafb;
            transition: all 0.2s;
        }
        .report-format-opt-inner .fmt-icon {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: #f0f0f0;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .report-format-opt-inner .fmt-icon i { font-size: 15px; color: #9ca3af; transition: color 0.2s; }
        .report-format-opt-inner .fmt-label { font-size: 12px; font-weight: 700; color: #374151; }
        .report-format-opt-inner .fmt-sub   { font-size: 10px; color: #9ca3af; margin-top: 1px; }
        .report-format-opt input:checked + .report-format-opt-inner {
            border-color: #436026;
            background: #f0fdf0;
            box-shadow: 0 0 0 3px rgba(67,96,38,0.1);
        }
        .report-format-opt input:checked + .report-format-opt-inner .fmt-icon {
            background: #436026;
        }
        .report-format-opt input:checked + .report-format-opt-inner .fmt-icon i { color: #fff; }
        .report-format-opt-inner:hover { border-color: #436026; background: #f9fff4; }
        /* Footer */
        .report-modal-footer {
            display: flex;
            gap: 10px;
            padding: 16px 24px 20px;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }
        .report-cancel-btn {
            flex: 1;
            padding: 10px;
            border: 1.5px solid #d1d5db;
            border-radius: 9px;
            background: #fff;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .report-cancel-btn:hover { background: #f3f4f6; border-color: #b0b7bf; }
        .report-generate-btn {
            flex: 1.6;
            padding: 10px;
            border: none;
            border-radius: 9px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 3px 10px rgba(67,96,38,0.28);
            letter-spacing: 0.3px;
        }
        .report-generate-btn:hover {
            background: linear-gradient(135deg, #3a5420 0%, #4e6e2b 100%);
            box-shadow: 0 6px 18px rgba(67,96,38,0.38);
            transform: translateY(-1px);
        }
        .report-generate-btn:active { transform: translateY(0); }

        @include('partials.user-indicator-styles')
    </style>
</head>
<body>
    @include('partials.app-sidebar', ['activePage' => 'bank-deposit'])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Bank & Deposit</h1>
            @include('partials.user-indicator')
        </div>

        <div class="content-box-large">
            <h2 class="page-title">
                @if(request('date'))
                    Daily Remittance Summary
                    <span style="font-size: 14px; font-weight: 500; color: #636e72; margin-left: 12px; background: #f8f9fa; padding: 4px 12px; border-radius: 20px;">
                        <i class="fas fa-calendar-day" style="margin-right: 6px;"></i>
                        {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}
                    </span>
                @else
                    Daily Remittance Summary
                    <span style="font-size: 14px; font-weight: 500; color: #636e72; margin-left: 12px; background: #f8f9fa; padding: 4px 12px; border-radius: 20px;">
                        <i class="fas fa-calendar-day" style="margin-right: 6px;"></i>
                        {{ now()->format('M d, Y') }} (Today)
                    </span>
                @endif
            </h2>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="summary-card">
                    <div class="summary-card-top">
                        <div class="summary-card-label">
                            @if(request('date') && \Carbon\Carbon::parse(request('date'))->isToday())
                                Today's Expected Remit
                            @elseif(request('date'))
                                Expected Remit ({{ \Carbon\Carbon::parse(request('date'))->format('M d') }})
                            @else
                                Today's Expected Remit
                            @endif
                        </div>
                        <div class="summary-card-icon"><i class="fas fa-wallet"></i></div>
                    </div>
                    <div class="summary-card-value">{{ number_format($totalExpectedRemit ?? 0, 2) }}</div>
                    <div class="summary-card-sub"><i class="fas fa-circle" style="font-size:6px;"></i> Total rider remittances due</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-top">
                        <div class="summary-card-label">
                            @if(request('date') && \Carbon\Carbon::parse(request('date'))->isToday())
                                Today's Cash Collected
                            @elseif(request('date'))
                                Cash Collected ({{ \Carbon\Carbon::parse(request('date'))->format('M d') }})
                            @else
                                Today's Cash Collected
                            @endif
                        </div>
                        <div class="summary-card-icon"><i class="fas fa-money-bill-wave"></i></div>
                    </div>
                    <div class="summary-card-value" id="cashCollectedDisplay">{{ number_format($confirmedCashCollected ?? 0, 2) }}</div>
                    <div class="summary-card-sub"><i class="fas fa-circle" style="font-size:6px;"></i> Confirmed bank deposits</div>
                </div>
                <div class="summary-card">
                    @php $discrepancy = $totalDiscrepancy; @endphp
                    <div class="summary-card-top">
                        <div class="summary-card-label">Discrepancy</div>
                        <div class="summary-card-icon"><i class="fas fa-balance-scale"></i></div>
                    </div>
                    <div class="summary-card-value" id="discrepancyDisplay"
                         data-original="-{{ number_format(abs($discrepancy), 2) }}"
                         data-original-color="#fff">
                        -{{ number_format(abs($discrepancy), 2) }}
                    </div>
                    <div class="summary-card-sub"><i class="fas fa-circle" style="font-size:6px;"></i> Expected vs. collected gap</div>
                </div>
                <div class="summary-card">
                    <div class="summary-card-top">
                        <div class="summary-card-label">Change</div>
                        <div class="summary-card-icon"><i class="fas fa-coins"></i></div>
                    </div>
                    <div class="summary-card-value" id="changeDisplay">+{{ number_format($totalChange, 2) }}</div>
                    <div class="summary-card-sub"><i class="fas fa-circle" style="font-size:6px;"></i> Excess cash returned</div>
                </div>
            </div>

            <!-- Search and Filter Controls -->
            <div class="controls-section">
                <div class="controls-left">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search today's riders..." value="{{ request('search') }}" oninput="liveSearchRiders()">
                    </div>
                    <div class="filter-dropdown">
                        <select id="sortFilter">
                            <option value="">Sort by</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Rider Name</option>
                            <option value="total_remit" {{ request('sort') == 'total_remit' ? 'selected' : '' }}>Total Remit</option>
                            <option value="transactions" {{ request('sort') == 'transactions' ? 'selected' : '' }}>Most Transactions</option>
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Activity</option>
                        </select>
                    </div>
                </div>
                <div class="controls-right">
                    <div style="width:1px; height:28px; background:#e9ecef; margin:0 4px;"></div>
                    <button class="btn-report" onclick="openReportModal()">
                        <i class="fas fa-file-alt"></i> Generate Report
                    </button>
                </div>
            </div>

            <!-- Main Content Layout -->
            <div class="content-layout">
                <!-- Table Section -->
                <div class="table-section">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>
                                    Rider's Name
                                    
                                </th>
                                <th>
                                    @if(request('date') && \Carbon\Carbon::parse(request('date'))->isToday())
                                        Today's Transactions
                                    @elseif(request('date'))
                                        Daily Transactions
                                    @else
                                        Today's Transactions
                                    @endif
                                </th>
                                <th>
                                    @if(request('date') && \Carbon\Carbon::parse(request('date'))->isToday())
                                        Daily Total Remit
                                    @elseif(request('date'))
                                        Total Remit
                                    @else
                                        Daily Total Remit
                                    @endif
                                </th>
                                <th>Discrepancy</th>
                                <th>Last Activity</th>
                                <th>Status</th>
                                <th>Confirmed Amount</th>
                                <th>Officer</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riderSummaries as $summary)
                            @php
                                // Compute all per-row values before the <tr> so they're available on the tag itself
                                $riderConfirmation = \App\Models\BankDepositConfirmation::where('rider_id', $summary->rider_id)
                                    ->whereDate('deposit_date', $filterDate)
                                    ->latest()
                                    ->first();
                                $riderDiscrepancy = $riderConfirmation ? $riderConfirmation->discrepancy : null;
                                if ($riderDiscrepancy !== null) {
                                    if ($riderDiscrepancy > 0) {
                                        $discColor = '#d97706';
                                        $discText  = '+' . number_format($riderDiscrepancy, 2);
                                    } elseif ($riderDiscrepancy < 0) {
                                        $discColor = '#dc2626';
                                        $discText  = '-' . number_format(abs($riderDiscrepancy), 2);
                                    } else {
                                        $discColor = '#059669';
                                        $discText  = '0.00';
                                    }
                                } else {
                                    $discColor = '#9ca3af';
                                    $discText  = '-';
                                }
                                $riderLatestRemittance = \App\Models\Remittance::where('rider_id', $summary->rider_id)
                                    ->latest()
                                    ->first();
                                $isValidated = \App\Models\BankDepositConfirmation::where('rider_id', $summary->rider_id)
                                    ->whereDate('deposit_date', $filterDate)
                                    ->exists();
                                if ($isValidated && $riderConfirmation && (float)$riderConfirmation->discrepancy === 0.0) {
                                    $validationStatus = 'validated';
                                } elseif ($isValidated || ($riderLatestRemittance && in_array($riderLatestRemittance->status, ['confirmed', 'pending']))) {
                                    $validationStatus = 'validating';
                                } else {
                                    $validationStatus = 'not validated';
                                }
                                $hasDenominationData = $riderConfirmation && (
                                    ((int)($riderConfirmation->denom_1000 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_500 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_200 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_100 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_50 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_20 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_20b ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_10 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_5 ?? 0) > 0) ||
                                    ((int)($riderConfirmation->denom_1 ?? 0) > 0)
                                );
                            @endphp
                            <tr class="rider-row" data-rider-id="{{ $summary->rider_id }}" data-rider-name="{{ $summary->rider->name }}" data-remit-amount="{{ $summary->total_remit_amount }}" data-validated="{{ $validationStatus === 'validated' ? 'true' : 'false' }}" data-has-denomination="{{ $hasDenominationData ? 'true' : 'false' }}" onclick="selectRiderFromTable(this)" style="cursor: pointer; transition: all 0.2s ease;{{ $validationStatus === 'validated' ? ' opacity: 0.65;' : '' }}">
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 2px;">
                                        <span style="font-weight: 600; color: #2d3436;">{{ $summary->rider->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 6px;">
                                        <span style="font-weight: 600; color: #1e3a8a;">{{ $summary->total_transactions }}</span>
                                        <span style="font-size: 10px; color: #64748b;">transactions</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                        <span style="font-weight: 700; color: #059669; font-size: 14px;">{{ number_format($summary->total_remit_amount, 2) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span id="discrepancy-cell-{{ $summary->rider_id }}"
                                          data-original="{{ $discText }}"
                                          data-raw="{{ $riderConfirmation ? $riderConfirmation->discrepancy : '' }}"
                                          data-confirmation-id="{{ $riderConfirmation?->id ?? '' }}"
                                          style="font-weight: 700; font-size: 13px; color: {{ $discColor }};">
                                        {{ $discText }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: 2px;">
                                        <span style="font-size: 11px; font-weight: 600; color: #374151;">{{ \Carbon\Carbon::parse($summary->latest_remittance)->format('M d, Y') }}</span>
                                        <span style="font-size: 10px; color: #6b7280;">
                                            {{ \Carbon\Carbon::parse($summary->latest_remittance)->diffForHumans() }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($validationStatus === 'validated')
                                        <span id="action-badge-{{ $summary->rider_id }}" style="display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; background: #059669; color: #fff; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i>Validated
                                        </span>
                                    @elseif($validationStatus === 'validating')
                                        <span id="action-badge-{{ $summary->rider_id }}" style="display: inline-block; padding: 5px 12px; background: #fff3cd; color: #856404; border-radius: 15px; font-size: 11px; font-weight: 600;">
                                            Validating
                                        </span>
                                    @else
                                        <span id="action-badge-{{ $summary->rider_id }}" style="display: inline-block; padding: 5px 12px; background: #f8d7da; color: #721c24; border-radius: 15px; font-size: 11px; font-weight: 600;">
                                            <i class="fas fa-exclamation-triangle" style="margin-right: 4px;"></i>Not Validated
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @php $riderConfirmed = $riderConfirmation ? $riderConfirmation->total_amount : 0; @endphp
                                    <span id="confirmed-amount-{{ $summary->rider_id }}" style="font-weight: 700; font-size: 13px; color: {{ $riderConfirmed > 0 ? '#059669' : '#9ca3af' }};">
                                        {{ number_format($riderConfirmed, 2) }}
                                    </span>
                                </td>
                                <td>{{ auth()->user()->name }}</td>
                                <td style="text-align:center;" onclick="event.stopPropagation()">
                                    <div style="display:inline-flex;flex-direction:row;gap:6px;align-items:center;justify-content:center;">
                                        <button id="edit-btn-{{ $summary->rider_id }}" onclick="editRiderRow(this.closest('tr'))"
                                            title="Edit"
                                            style="width:30px;height:30px;display:{{ $hasDenominationData ? 'inline-flex' : 'none' }};align-items:center;justify-content:center;background:rgba(5,150,105,0.08);color:#059669;border:1.5px solid #059669;border-radius:7px;cursor:pointer;transition:all 0.2s ease;flex-shrink:0;"
                                            onmouseover="this.style.background='#059669';this.style.color='#fff';this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.background='rgba(5,150,105,0.08)';this.style.color='#059669';this.style.transform='scale(1)'">
                                            <i class="fas fa-pen" style="font-size:11px;"></i>
                                        </button>
                                        <button onclick="showDenomHistory(this)"
                                            title="View History"
                                            data-rider-name="{{ $summary->rider->name }}"
                                            data-confirmed="{{ $riderConfirmation ? 'true' : 'false' }}"
                                            data-bank="{{ $riderConfirmation?->bank_amount ?? 0 }}"
                                            data-total="{{ $riderConfirmation?->total_amount ?? 0 }}"
                                            data-discrepancy="{{ $riderConfirmation?->discrepancy ?? 0 }}"
                                            data-denom1000="{{ $riderConfirmation?->denom_1000 ?? 0 }}"
                                            data-denom500="{{ $riderConfirmation?->denom_500 ?? 0 }}"
                                            data-denom200="{{ $riderConfirmation?->denom_200 ?? 0 }}"
                                            data-denom100="{{ $riderConfirmation?->denom_100 ?? 0 }}"
                                            data-denom50="{{ $riderConfirmation?->denom_50 ?? 0 }}"
                                            data-denom20="{{ $riderConfirmation?->denom_20 ?? 0 }}"
                                            data-denom20b="{{ $riderConfirmation?->denom_20b ?? 0 }}"
                                            data-denom10="{{ $riderConfirmation?->denom_10 ?? 0 }}"
                                            data-denom5="{{ $riderConfirmation?->denom_5 ?? 0 }}"
                                            data-denom1="{{ $riderConfirmation?->denom_1 ?? 0 }}"
                                            data-deposit-date="{{ $riderConfirmation?->deposit_date?->format('M d, Y') ?? '' }}"
                                            style="width:30px;height:30px;display:inline-flex;align-items:center;justify-content:center;background:rgba(99,102,241,0.08);color:#6366f1;border:1.5px solid #6366f1;border-radius:7px;cursor:pointer;transition:all 0.2s ease;flex-shrink:0;"
                                            onmouseover="this.style.background='#6366f1';this.style.color='#fff';this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.background='rgba(99,102,241,0.08)';this.style.color='#6366f1';this.style.transform='scale(1)'">
                                            <i class="fas fa-history" style="font-size:11px;"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px 30px; color: #b2bec3;">
                                    <i class="fas fa-calendar-times" style="font-size: 36px; margin-bottom: 12px; display: block; color: #dfe6e9;"></i>
                                    <div style="font-size: 14px; font-weight: 600; color: #636e72; margin-bottom: 4px;">No records found</div>
                                    @if(request('date'))
                                        <div style="font-size: 12px; color: #b2bec3;">No remittance data for {{ \Carbon\Carbon::parse(request('date'))->format('M d, Y') }}</div>
                                    @else
                                        <div style="font-size: 12px; color: #b2bec3;">No remittance data for {{ now()->format('M d, Y') }}</div>
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if($riderSummaries->count() > 10)
                    <div class="pagination">
                        <button disabled style="opacity: 0.5; cursor: not-allowed;">&laquo;</button>
                        <button class="active">1</button>
                        <button disabled style="opacity: 0.5; cursor: not-allowed;">&raquo;</button>
                    </div>
                    @endif
                </div>

                <!-- Sidebar Widgets -->
                <div class="sidebar-widgets">
                    <!-- Calendar Widget -->
                    <div class="calendar-widget">
                        <div class="calendar-header">
                            <div class="calendar-month" id="calendarMonth">February 2026</div>
                            <div class="calendar-nav">
                                <button id="prevMonth" onclick="changeBankMonth(-1)">&larr;</button>
                                <button id="nextMonth" onclick="changeBankMonth(1)">&rarr;</button>
                            </div>
                        </div>
                        <div class="calendar-grid">
                            <div class="calendar-day-header">S</div>
                            <div class="calendar-day-header">M</div>
                            <div class="calendar-day-header">T</div>
                            <div class="calendar-day-header">W</div>
                            <div class="calendar-day-header">T</div>
                            <div class="calendar-day-header">F</div>
                            <div class="calendar-day-header">S</div>
                            <div id="calendarDays"></div>
                        </div>

                        <!-- Calendar Legend -->
                        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:8px; padding: 6px 4px 2px; border-top:1px solid #f0f0f0;">
                            <span style="display:flex; align-items:center; gap:4px; font-size:10px; color:#636e72;">
                                <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span> Discrepancy
                            </span>
                            <span style="display:flex; align-items:center; gap:4px; font-size:10px; color:#636e72;">
                                <span style="width:7px;height:7px;border-radius:50%;background:#f97316;display:inline-block;"></span> Validating
                            </span>
                            <span style="display:flex; align-items:center; gap:4px; font-size:10px; color:#636e72;">
                                <span style="width:7px;height:7px;border-radius:50%;background:#fbbf24;display:inline-block;"></span> Change
                            </span>
                        </div>
                        
                        <!-- Clear Date Filter Button -->
                        @if(request('date'))
                        <div style="margin-top: 12px; text-align: center;">
                            <button onclick="clearDateFilter()" 
                                    style="padding: 6px 12px; background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 6px; font-size: 11px; cursor: pointer; color: #6c757d; transition: all 0.3s ease;">
                                <i class="fas fa-times" style="margin-right: 4px;"></i>Clear Date Filter
                            </button>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        // Date indicator sets (from server)
        const discrepancyDateSet = new Set({!! json_encode($discrepancyDates) !!});
        const validatingDateSet   = new Set({!! json_encode($validatingDates) !!});
        const changeDateSet       = new Set({!! json_encode($changeDates) !!});

        function padDate(y, m, d) {
            return y + '-' + String(m + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
        }

        function addDayDots(el, dateStr) {
            const hasDisc   = discrepancyDateSet.has(dateStr);
            const hasValid  = validatingDateSet.has(dateStr);
            const hasChange = changeDateSet.has(dateStr);
            if (!hasDisc && !hasValid && !hasChange) return;

            const dots = document.createElement('div');
            dots.className = 'cal-dots';

            if (hasDisc) {
                const d = document.createElement('span');
                d.className = 'cal-dot-disc';
                dots.appendChild(d);
            }
            if (hasValid) {
                const v = document.createElement('span');
                v.className = 'cal-dot-valid';
                dots.appendChild(v);
            }
            if (hasChange) {
                const c = document.createElement('span');
                c.className = 'cal-dot-change';
                dots.appendChild(c);
            }

            const labels = [];
            if (hasDisc)   labels.push('Discrepancy');
            if (hasValid)  labels.push('Validating');
            if (hasChange) labels.push('Change');
            el.setAttribute('data-has-indicator', '1');
            el.setAttribute('data-indicator-label', labels.join(' � '));
            el.appendChild(dots);
        }

        // Calendar functionality
        let currentDate = new Date();
        let displayDate = new Date(currentDate);
        let selectedDate = new Date(currentDate);

        function renderBankCalendar() {
            const year = displayDate.getFullYear();
            const month = displayDate.getMonth();
            
            // Update month display
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            document.getElementById('calendarMonth').textContent = `${monthNames[month]} ${year}`;
            
            // Get first day of month and number of days
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();
            
            const calendarDays = document.getElementById('calendarDays');
            calendarDays.innerHTML = '';
            
            // Add previous month's overflow days
            for (let i = firstDay - 1; i >= 0; i--) {
                const prevDate = daysInPrevMonth - i;
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day other-month';
                dayDiv.textContent = prevDate;
                
                const prevYear = month === 0 ? year - 1 : year;
                const prevMonth = month === 0 ? 11 : month - 1;
                
                // Add click event for previous month dates
                dayDiv.addEventListener('click', function() {
                    selectDate(prevYear, prevMonth, prevDate);
                });
                
                // Check if it's selected from URL
                const urlParams = new URLSearchParams(window.location.search);
                const selectedUrlDate = urlParams.get('date');
                if (selectedUrlDate) {
                    const dp = selectedUrlDate.split('-');
                    const urlDate = new Date(parseInt(dp[0]), parseInt(dp[1]) - 1, parseInt(dp[2]));
                    if (prevYear === urlDate.getFullYear() && 
                        prevMonth === urlDate.getMonth() && 
                        prevDate === urlDate.getDate()) {
                        dayDiv.classList.add('selected');
                    }
                }
                
                addDayDots(dayDiv, padDate(prevYear, prevMonth, prevDate));
                calendarDays.appendChild(dayDiv);
            }
            
            // Add current month's days
            for (let day = 1; day <= daysInMonth; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day';
                dayDiv.textContent = day;
                
                const dayDate = new Date(year, month, day);
                const isToday = year === currentDate.getFullYear() && 
                                month === currentDate.getMonth() && 
                                day === currentDate.getDate();
                
                // Check if it's today
                if (isToday) {
                    dayDiv.classList.add('today');
                }
                
                // Add click event for all dates (no restriction)
                dayDiv.addEventListener('click', function() {
                    selectDate(year, month, day);
                });
                
                // Check if it's selected (check for URL date parameter)
                const urlParams = new URLSearchParams(window.location.search);
                const selectedUrlDate = urlParams.get('date');
                
                if (selectedUrlDate) {
                    const dp = selectedUrlDate.split('-');
                    const urlDate = new Date(parseInt(dp[0]), parseInt(dp[1]) - 1, parseInt(dp[2]));
                    if (year === urlDate.getFullYear() && 
                        month === urlDate.getMonth() && 
                        day === urlDate.getDate()) {
                        dayDiv.classList.add('selected');
                    }
                } else if (selectedDate && 
                    year === selectedDate.getFullYear() && 
                    month === selectedDate.getMonth() && 
                    day === selectedDate.getDate()) {
                    dayDiv.classList.add('selected');
                }
                
                addDayDots(dayDiv, padDate(year, month, day));
                calendarDays.appendChild(dayDiv);
            }
            
            // Add next month's overflow days
            const totalCells = 42; // 6 rows � 7 days
            const usedCells = firstDay + daysInMonth;
            const nextMonthDays = totalCells - usedCells;
            
            for (let day = 1; day <= nextMonthDays; day++) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'calendar-day other-month';
                dayDiv.textContent = day;
                
                const nextYear = month === 11 ? year + 1 : year;
                const nextMonth = month === 11 ? 0 : month + 1;
                
                // Add click event for next month dates
                dayDiv.addEventListener('click', function() {
                    selectDate(nextYear, nextMonth, day);
                });
                
                // Check if it's selected from URL
                const urlParams = new URLSearchParams(window.location.search);
                const selectedUrlDate = urlParams.get('date');
                if (selectedUrlDate) {
                    const dp = selectedUrlDate.split('-');
                    const urlDate = new Date(parseInt(dp[0]), parseInt(dp[1]) - 1, parseInt(dp[2]));
                    if (nextYear === urlDate.getFullYear() && 
                        nextMonth === urlDate.getMonth() && 
                        day === urlDate.getDate()) {
                        dayDiv.classList.add('selected');
                    }
                }
                
                addDayDots(dayDiv, padDate(nextYear, nextMonth, day));
                calendarDays.appendChild(dayDiv);
            }
        }

        function changeBankMonth(delta) {
            displayDate.setMonth(displayDate.getMonth() + delta);
            renderBankCalendar();
        }

        function selectDate(year, month, day) {
            selectedDate = new Date(year, month, day);
            renderBankCalendar();
            
            // Format date for display and URL
            const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            console.log('Selected date:', formattedDate);
            
            // Format for user-friendly display
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'];
            const displayDate = `${monthNames[month]} ${day}, ${year}`;
            
            // Apply date filter to the current page
            filterByDate(formattedDate, displayDate);
        }

        // Date filtering function
        function filterByDate(dateString, displayDate) {
            const url = new URL(window.location.href);
            
            // Add date parameter to URL
            url.searchParams.set('date', dateString);
            url.searchParams.delete('page'); // Reset to page 1
            
            // Show loading toast
            showToast(`?? Filtering remittances for ${displayDate}...`, 'info', 2000);
            
            // Navigate to filtered results
            window.location.href = url.toString();
        }

        // Add clear date filter function
        function clearDateFilter() {
            const url = new URL(window.location.href);
            url.searchParams.delete('date');
            url.searchParams.delete('page');
            
            showToast('?? Date filter cleared - showing all records', 'info', 2000);
            window.location.href = url.toString();
        }

        // Live Search functionality
        function liveSearchRiders() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const riderRows = document.querySelectorAll('tbody .rider-row');

            riderRows.forEach(row => {
                const riderName = (row.getAttribute('data-rider-name') || '').toLowerCase();

                if (riderName.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filter functionality
        function handleFilterChange() {
            const filterSelect = document.getElementById('dateFilter');
            const filterValue = filterSelect.value;
            
            console.log('Filter changed to:', filterValue);
            
            if (filterValue) {
                const filterText = filterSelect.options[filterSelect.selectedIndex].text;
                showToast(`?? Filter applied: ${filterText}`, 'info', 2500);
                // Add your filter logic here
                // filterTableByDateRange(filterValue);
            } else {
                showToast('Filter cleared - showing all records', 'info', 2000);
            }
        }

        // Pagination functionality
        let currentPage = 1;
        const totalPages = 3;

        function changePage(page) {
            const paginationButtons = document.querySelectorAll('.pagination button');
            const previousPage = currentPage;
            
            if (page === 'prev') {
                if (currentPage > 1) {
                    currentPage--;
                } else {
                    showToast('Already on first page', 'warning', 1500);
                    return;
                }
            } else if (page === 'next') {
                if (currentPage < totalPages) {
                    currentPage++;
                } else {
                    showToast('Already on last page', 'warning', 1500);
                    return;
                }
            } else {
                currentPage = page;
            }
            
            // Update active button
            paginationButtons.forEach((btn, index) => {
                btn.classList.remove('active');
                if (index === currentPage) { // index 0 is prev, 1-3 are pages, 4 is next
                    btn.classList.add('active');
                }
            });
            
            console.log('Current page:', currentPage);
            if (previousPage !== currentPage) {
                showToast(`?? Loading page ${currentPage} of ${totalPages}`, 'info', 1500);
            }
            
            // Add your pagination logic here
            // loadPageData(currentPage);
        }

        // Reset denominations
        function resetDenominations() {
            const inputs = document.querySelectorAll('.denomination-table input[type=\"number\"]');
            let hasValues = false;
            
            inputs.forEach(input => {
                if (input.value && parseInt(input.value) > 0) {
                    hasValues = true;
                }
                input.value = '';
            });
            
            // Recalculate totals
            const denominationTable = document.querySelector('.denomination-table tbody');
            if (denominationTable) {
                const rows = denominationTable.querySelectorAll('tr:not(.total-row)');
                rows.forEach(row => {
                    const amountCell = row.querySelector('td:last-child');
                    if (amountCell && !amountCell.querySelector('input')) {
                        amountCell.textContent = '0';
                    }
                });
                
                const totalRows = denominationTable.querySelectorAll('.total-row');
                const totalCell = totalRows[0].querySelector('td:last-child');
                if (totalCell && !totalCell.querySelector('input')) {
                    totalCell.textContent = '0';
                }
            }

            // Reset Total and Remaining displays
            const denomTotalCell = document.getElementById('denominationTotal');
            if (denomTotalCell) denomTotalCell.textContent = '0';

            // Reset bank field to original remit amount
            const bankInput = document.getElementById('bankInput');
            if (bankInput) {
                const originalAmount = parseFloat(bankInput.dataset.originalAmount) || 0;
                bankInput.removeAttribute('readonly');
                if (originalAmount > 0) {
                    bankInput.value = '₱' + originalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                    bankInput.style.borderColor = '#436026';
                    bankInput.style.borderWidth = '2px';
                    bankInput.style.borderStyle = 'solid';
                } else {
                    bankInput.value = '';
                    bankInput.style.borderColor = '';
                }
                bankInput.setAttribute('readonly', true);
            }
            const bankLabelReset = document.getElementById('bankLabel');
            if (bankLabelReset) { bankLabelReset.textContent = 'Bank'; bankLabelReset.style.color = '#374151'; }
            
            if (hasValues) {
                showToast('? All denominations have been reset to zero', 'success', 2500);
            } else {
                showToast('Denominations are already empty', 'info', 2000);
            }
        }

        // Initialized from DB total for today � persists across refreshes
        let totalConfirmedCollection = {{ $confirmedCashCollected ?? 0 }};

        function refreshSummaryCards() {
            const params = new URLSearchParams(window.location.search);
            const date   = params.get('date') || new Date().toISOString().split('T')[0];
            fetch('/bank-deposit/totals?date=' + date)
                .then(r => r.json())
                .then(d => {
                    // Cash Collected
                    totalConfirmedCollection = d.confirmed_cash;
                    updateCashCollectedDisplay();

                    // Discrepancy card
                    const discCard = document.getElementById('discrepancyDisplay');
                    if (discCard) {
                        const absDisc = Math.abs(d.discrepancy || 0);
                        discCard.textContent = '-' + absDisc.toLocaleString('en-US', {minimumFractionDigits: 2});
                        discCard.style.color = '#fff';
                        discCard.dataset.original = discCard.textContent;
                    }

                    // Change card
                    const changeCard = document.getElementById('changeDisplay');
                    if (changeCard) {
                        const changeVal = d.change || 0;
                        changeCard.textContent = '+' + changeVal.toLocaleString('en-US', {minimumFractionDigits: 2});
                        changeCard.style.color = '#fff';
                    }
                })
                .catch(() => {});
        }

        function updateCashCollectedDisplay() {
            const display = document.getElementById('cashCollectedDisplay');
            if (display) {
                display.textContent = totalConfirmedCollection.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                display.style.color = '#fff';
            }
        }

        // Initialize display on load
        document.addEventListener('DOMContentLoaded', function() {
            updateCashCollectedDisplay();
        });

        // Holds pending confirm data for the modal
        let _pendingConfirm = null;
        // True only when the user has typed into a denomination field for the current rider
        let _denomsEntered = false;

        function confirmDenomination() {
            const denominationTable = document.querySelector('.denomination-table tbody');
            const bankInput = document.getElementById('bankInput');
            const selectedRow = document.querySelector('.rider-row.selected');

            // Check if a rider is selected
            if (!selectedRow) {
                showToast('?? Please select a rider first', 'error', 3000);
                return;
            }

            // Get original bank amount
            const originalAmount = parseFloat(bankInput.dataset.originalAmount) || 0;
            if (originalAmount <= 0) {
                showToast('?? No bank amount to confirm. Select a rider first.', 'error', 3000);
                return;
            }

            // Get total denomination amount
            const totalCell = document.getElementById('denominationTotal');
            const totalText = totalCell ? totalCell.textContent.replace(/,/g, '') : '0';
            const totalAmount = parseFloat(totalText) || 0;

            if (totalAmount <= 0) {
                showToast('?? Please enter denomination amounts first', 'error', 3000);
                return;
            }

            // Collect denomination piece counts from data-denom rows
            const denomData = {};
            denominationTable.querySelectorAll('tr[data-denom]').forEach(row => {
                const denom = row.getAttribute('data-denom');
                const pieces = parseInt(row.querySelector('input')?.value) || 0;
                denomData['denom_' + denom] = pieces;
            });

            const riderId   = selectedRow.getAttribute('data-rider-id');
            const riderName = selectedRow.getAttribute('data-rider-name');
            const balance   = originalAmount - totalAmount;

            // Store pending data and populate modal
            _pendingConfirm = { riderId, riderName, originalAmount, totalAmount, denomData, balance };

            document.getElementById('modal-rider-name').textContent  = riderName;
            document.getElementById('modal-bank-amount').textContent  = originalAmount.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('modal-denom-total').textContent  = totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2});

            const balanceEl = document.getElementById('modal-balance');
            const balanceLabelEl = document.getElementById('modal-balance-label');
            if (balance > 0) {
                // Bank > Total: denominations short ? Discrepancy
                balanceEl.textContent = '-' + balance.toLocaleString('en-US', {minimumFractionDigits: 2});
                balanceEl.style.color = '#dc2626';
                if (balanceLabelEl) { balanceLabelEl.textContent = 'Discrepancy'; balanceLabelEl.style.color = '#dc2626'; }
            } else if (balance === 0) {
                balanceEl.textContent = '0.00';
                balanceEl.style.color = '#059669';
                if (balanceLabelEl) { balanceLabelEl.textContent = 'Balance'; balanceLabelEl.style.color = '#6b7280'; }
            } else {
                // Total > Bank: denominations over ? Balance (excess)
                balanceEl.textContent = '+' + Math.abs(balance).toLocaleString('en-US', {minimumFractionDigits: 2});
                balanceEl.style.color = '#d97706';
                if (balanceLabelEl) { balanceLabelEl.textContent = 'Balance'; balanceLabelEl.style.color = '#6b7280'; }
            }

            const warningEl = document.getElementById('modal-warning');
            const warningText = document.getElementById('modal-warning-text');
            if (balance > 0) {
                // Denominations short
                warningText.textContent = 'Denomination total is ' + balance.toLocaleString('en-US', {minimumFractionDigits: 2}) + ' short of the bank amount. This will be recorded as a discrepancy.';
                warningEl.style.display = 'block';
                warningEl.style.background = '#fff1f2';
                warningEl.style.border = '1px solid #fecaca';
                warningEl.style.color = '#b91c1c';
            } else if (balance < 0) {
                // Denominations over
                warningText.textContent = 'Denomination total exceeds bank amount by ' + Math.abs(balance).toLocaleString('en-US', {minimumFractionDigits: 2}) + '. Verify the breakdown is correct.';
                warningEl.style.display = 'block';
                warningEl.style.background = '#fffbeb';
                warningEl.style.border = '1px solid #fcd34d';
                warningEl.style.color = '#92400e';
            } else {
                warningEl.style.display = 'none';
            }

            const modal = document.getElementById('confirmDenomModal');
            modal.style.display = 'flex';
        }

        function closeConfirmModal() {
            document.getElementById('confirmDenomModal').style.display = 'none';
            _pendingConfirm = null;
        }

        function showDenomHistory(btn) {
            const d = btn.dataset;
            const modal   = document.getElementById('denomHistoryModal');
            const noRec   = document.getElementById('dh-no-record');
            const body    = document.getElementById('dh-body');

            document.getElementById('dh-rider-name').textContent = d.riderName || '';

            if (d.confirmed !== 'true') {
                noRec.style.display = 'block';
                body.style.display  = 'none';
                modal.style.display = 'flex';
                return;
            }

            noRec.style.display = 'none';
            body.style.display  = 'block';

            document.getElementById('dh-date').textContent = d.depositDate ? 'Deposit Date: ' + d.depositDate : '';

            const denoms = [
                { label: '?1,000 Bill',  key: 'denom1000',  value: 1000 },
                { label: '?500 Bill',   key: 'denom500',   value: 500  },
                { label: '?200 Bill',   key: 'denom200',   value: 200  },
                { label: '?100 Bill',   key: 'denom100',   value: 100  },
                { label: '?50 Bill',    key: 'denom50',    value: 50   },
                { label: '?20 Bill',    key: 'denom20',    value: 20   },
                { label: '?20 Coin',    key: 'denom20b',   value: 20   },
                { label: '?10 Coin',    key: 'denom10',    value: 10   },
                { label: '?5 Coin',     key: 'denom5',     value: 5    },
                { label: '?1 Coin',     key: 'denom1',     value: 1    },
            ];

            const tbody = document.getElementById('dh-denom-rows');
            tbody.innerHTML = '';
            denoms.forEach(item => {
                const pieces = parseInt(d[item.key]) || 0;
                const amount = pieces * item.value;
                const tr = document.createElement('tr');
                tr.style.cssText = 'border-bottom:1px solid #f3f4f6;' + (pieces > 0 ? 'background:#fafafa;' : '');
                tr.innerHTML = `
                    <td style="padding:7px 12px; color:${pieces > 0 ? '#111827' : '#d1d5db'};">${item.label}</td>
                    <td style="padding:7px 12px; text-align:center; font-weight:${pieces > 0 ? '700' : '400'}; color:${pieces > 0 ? '#374151' : '#d1d5db'}; font-size:14px;">${pieces > 0 ? pieces : '�'}</td>
                    <td style="padding:7px 12px; text-align:right; font-weight:${pieces > 0 ? '700' : '400'}; color:${pieces > 0 ? '#059669' : '#d1d5db'};">${pieces > 0 ? amount.toLocaleString('en-US', {minimumFractionDigits: 2}) : '�'}</td>
                `;
                tbody.appendChild(tr);
            });

            const total = parseFloat(d.total) || 0;
            document.getElementById('dh-total').textContent = total.toLocaleString('en-US', {minimumFractionDigits: 2});

            const bank = parseFloat(d.bank) || 0;
            document.getElementById('dh-bank').textContent = bank.toLocaleString('en-US', {minimumFractionDigits: 2});

            const disc = parseFloat(d.discrepancy) || 0;
            const discEl = document.getElementById('dh-discrepancy');
            if (disc > 0)      { discEl.textContent = '+' + disc.toLocaleString('en-US', {minimumFractionDigits: 2}); discEl.style.color = '#d97706'; }
            else if (disc < 0) { discEl.textContent = '-' + Math.abs(disc).toLocaleString('en-US', {minimumFractionDigits: 2}); discEl.style.color = '#dc2626'; }
            else               { discEl.textContent = '0.00'; discEl.style.color = '#059669'; }

            modal.style.display = 'flex';
        }

        function closeDenomHistory() {
            document.getElementById('denomHistoryModal').style.display = 'none';
        }

        function _doConfirmPost() {
            if (!_pendingConfirm) return;
            const { riderId, riderName, originalAmount, totalAmount, denomData, balance } = _pendingConfirm;

            closeConfirmModal();

            const btn = document.getElementById('confirmDenomBtn');
            btn.disabled = true;
            btn.style.background = '#2d7a1f';
            btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right: 6px;"></i>Confirming...';

            // POST to database
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const depositDate = '{{ request('date') ?? now()->format('Y-m-d') }}';

            fetch('{{ route('bank-deposit.confirm') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({
                    rider_id:     riderId,
                    bank_amount:  originalAmount,
                    total_amount: totalAmount,
                    discrepancy:  totalAmount - originalAmount,
                    deposit_date: depositDate,
                    ...denomData,
                }),
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check-double" style="margin-right: 6px;"></i>Confirmed!';
                    btn.style.background = '#1a5c10';

                    // Add denomination total to accumulated cash collected and update card
                    totalConfirmedCollection += totalAmount;
                    updateCashCollectedDisplay();

                    // Update action badge based on discrepancy: Validated if 0, Validating otherwise
                    const badge = document.getElementById('action-badge-' + riderId);
                    const riderRowEl = document.querySelector('.rider-row[data-rider-id="' + riderId + '"]');
                    const editBtn = document.getElementById('edit-btn-' + riderId);
                    if (badge) {
                        if (balance === 0) {
                            badge.style.display = 'inline-flex';
                            badge.style.alignItems = 'center';
                            badge.style.gap = '5px';
                            badge.style.padding = '5px 12px';
                            badge.style.background = '#059669';
                            badge.style.color = '#fff';
                            badge.style.borderRadius = '20px';
                            badge.innerHTML = '<i class="fas fa-check-circle"></i>Validated';
                            if (riderRowEl) { riderRowEl.dataset.validated = 'true'; riderRowEl.style.opacity = '0.65'; riderRowEl.classList.remove('selected'); }
                        } else {
                            badge.style.display = 'inline-block';
                            badge.style.alignItems = '';
                            badge.style.gap = '';
                            badge.style.padding = '5px 12px';
                            badge.style.background = '#fff3cd';
                            badge.style.color = '#856404';
                            badge.style.borderRadius = '15px';
                            badge.innerHTML = 'Validating';
                            if (riderRowEl) { riderRowEl.dataset.validated = 'false'; riderRowEl.style.opacity = ''; }
                        }
                    }

                    if (riderRowEl) {
                        riderRowEl.dataset.hasDenomination = 'true';
                    }
                    if (editBtn) {
                        editBtn.style.display = 'inline-flex';
                    }

                    // Update discrepancy column cell with confirmed balance value
                    const discCell = document.getElementById('discrepancy-cell-' + riderId);
                    if (discCell) {
                        // discrepancy = totalAmount - originalAmount (which is -balance)
                        const discrepancyVal = totalAmount - originalAmount;
                        if (balance > 0) {
                            // Bank > Total: short ? Discrepancy (negative)
                            discCell.textContent = '-' + balance.toLocaleString('en-US', {minimumFractionDigits: 2});
                            discCell.style.color = '#dc2626';
                        } else if (balance < 0) {
                            // Total > Bank: over ? show excess as positive balance
                            discCell.textContent = '+' + Math.abs(balance).toLocaleString('en-US', {minimumFractionDigits: 2});
                            discCell.style.color = '#d97706';
                        } else {
                            discCell.textContent = '0.00';
                            discCell.style.color = '#059669';
                        }
                        // Keep dataset in sync so inline discrepancy edit works without page refresh
                        discCell.dataset.raw = discrepancyVal;
                        discCell.dataset.original = discCell.textContent;
                        if (data.confirmation_id) {
                            discCell.dataset.confirmationId = data.confirmation_id;
                        }
                    }

                    showToast(`? Confirmed! ${riderName} � ?${totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2})} saved to database`, 'success', 4000);

                    // Update Confirmed Amount cell live
                    const confirmedAmountSpan = document.getElementById('confirmed-amount-' + riderId);
                    if (confirmedAmountSpan) {
                        confirmedAmountSpan.textContent = totalAmount.toLocaleString('en-US', {minimumFractionDigits: 2});
                        confirmedAmountSpan.style.color = '#059669';
                    }

                    // Refresh Discrepancy, Change and Cash Collected cards from DB
                    refreshSummaryCards();

                    setTimeout(() => {
                        btn.disabled = false;
                        btn.style.background = '#436026';
                        btn.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i>Confirm';
                    }, 3000);
                } else {
                    throw new Error('Server error');
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                btn.style.background = '#436026';
                btn.innerHTML = '<i class="fas fa-check" style="margin-right: 6px;"></i>Confirm';
                showToast('? Failed to save. Please try again.', 'error', 3000);
            });
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

        // Denomination Calculator Functions
        function calculateDenomination(input, denomination) {
                const pieces = parseInt(input.value) || 0;
                const amount = pieces * denomination;
                const row = input.closest('tr');
                const amountCell = row.querySelector('td:last-child');
                amountCell.textContent = amount.toLocaleString();
                _denomsEntered = true;
                calculateTotal();
            }

            function calculateTotal() {
                const denominationTable = document.querySelector('.denomination-table tbody');
                const rows = denominationTable.querySelectorAll('tr:not(.total-row)');
                let total = 0;
                
                rows.forEach(row => {
                    const amountCell = row.querySelector('td:last-child');
                    if (amountCell && !amountCell.querySelector('input')) {
                        const amountText = amountCell.textContent.replace(/,/g, '');
                        const amount = parseInt(amountText) || 0;
                        total += amount;
                    }
                });
                
                // Update Total row
                const totalCell = document.getElementById('denominationTotal');
                if (totalCell) {
                    totalCell.textContent = total.toLocaleString();
                    totalCell.style.cursor = 'pointer';
                    totalCell.title = 'Click to copy total amount';
                    totalCell.onclick = function() {
                        navigator.clipboard.writeText(total.toString()).then(() => {
                            showToast(`? Copied ?${total.toLocaleString()} to clipboard`, 'success', 2000);
                        }).catch(() => {
                            showToast('Failed to copy to clipboard', 'error', 2000);
                        });
                    };
                }

                // Update Bank field to show remaining: Bank original - Total
                const bankInput = document.getElementById('bankInput');
                if (bankInput) {
                    const originalAmount = parseFloat(bankInput.dataset.originalAmount) || 0;
                    const remaining = originalAmount - total;

                    bankInput.removeAttribute('readonly');
                    const bankLabel = document.getElementById('bankLabel');
                    if (originalAmount === 0 || total === 0) {
                        // No rider selected or no denominations entered � show original amount, leave discrepancy alone
                        if (originalAmount > 0) {
                            bankInput.value = '₱' + originalAmount.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            bankInput.style.borderColor = '#436026';
                            bankInput.style.borderWidth = '2px';
                            bankInput.style.borderStyle = 'solid';
                        } else {
                            bankInput.value = '';
                            bankInput.style.borderColor = '';
                        }
                        if (bankLabel) { bankLabel.textContent = 'Bank'; bankLabel.style.color = '#374151'; }
                    } else if (remaining === 0) {
                        bankInput.value = '₱0.00';
                        bankInput.style.borderColor = '#059669';
                        bankInput.style.borderWidth = '2px';
                        bankInput.style.borderStyle = 'solid';
                        if (bankLabel) { bankLabel.textContent = 'Balanced'; bankLabel.style.color = '#059669'; }
                        // Reset discrepancy cell to original server-rendered value
                        if (_denomsEntered) {
                        const selectedRow0 = document.querySelector('.rider-row.selected');
                        if (selectedRow0) {
                            const riderId0 = selectedRow0.getAttribute('data-rider-id');
                            const discCell0 = document.getElementById('discrepancy-cell-' + riderId0);
                            if (discCell0) {
                                discCell0.textContent = discCell0.dataset.original || '';
                                discCell0.style.color = '#059669';
                            }
                        }
                        }
                    } else if (remaining > 0) {
                        bankInput.value = '-₱' + remaining.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        bankInput.style.borderColor = '#dc2626';
                        bankInput.style.borderWidth = '2px';
                        bankInput.style.borderStyle = 'solid';
                        if (bankLabel) { bankLabel.textContent = 'Discrepancy'; bankLabel.style.color = '#dc2626'; }

                        // Push discrepancy value to the rider's cell only (not the summary card)
                        if (_denomsEntered) {
                        const selectedRowP = document.querySelector('.rider-row.selected');
                        if (selectedRowP) {
                            const riderIdP = selectedRowP.getAttribute('data-rider-id');
                            const discCellP = document.getElementById('discrepancy-cell-' + riderIdP);
                            if (discCellP) {
                                discCellP.textContent = '-' + remaining.toLocaleString('en-US', {minimumFractionDigits: 2});
                                discCellP.style.color = '#dc2626';
                            }
                        }
                        }
                    } else {
                        bankInput.value = '+₱' + Math.abs(remaining).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                        bankInput.style.borderColor = '#d97706';
                        bankInput.style.borderWidth = '2px';
                        bankInput.style.borderStyle = 'solid';
                        if (bankLabel) { bankLabel.textContent = 'Balance'; bankLabel.style.color = '#d97706'; }

                        // Reset discrepancy cell to original server-rendered value (card unchanged)
                        if (_denomsEntered) {
                        const selectedRow = document.querySelector('.rider-row.selected');
                        if (selectedRow) {
                            const riderId = selectedRow.getAttribute('data-rider-id');
                            const discrepancyCell = document.getElementById('discrepancy-cell-' + riderId);
                            if (discrepancyCell) {
                                discrepancyCell.textContent = discrepancyCell.dataset.original || '';
                                discrepancyCell.style.color = '#d97706';
                            }
                        }
                        }
                    }
                    bankInput.setAttribute('readonly', true);
                }
            }

        // Initialize denomination calculator on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Check if there's a date parameter in URL and navigate the calendar to that month
            const urlParams = new URLSearchParams(window.location.search);
            const dateParam = urlParams.get('date');
            
            if (dateParam) {
                // Parse date parts directly to avoid UTC midnight offset issues
                const dateParts = dateParam.split('-');
                const urlYear  = parseInt(dateParts[0]);
                const urlMonth = parseInt(dateParts[1]) - 1; // 0-indexed
                const urlDay   = parseInt(dateParts[2]);
                // Navigate the calendar to the selected date's month
                displayDate  = new Date(urlYear, urlMonth, urlDay);
                selectedDate = new Date(urlYear, urlMonth, urlDay);
            }

            // Initialize calendar (now pointing to the correct month)
            renderBankCalendar();
            
            // Show keyboard shortcuts hint
            
            
            const denominations = [1000, 500, 200, 100, 50, 20, 20, 10, 5, 1];
            const denominationTable = document.querySelector('.denomination-table tbody');
            
            if (denominationTable) {
                const inputs = denominationTable.querySelectorAll('input[type="number"]');
                
                // Get only the denomination inputs (not the bank input)
                const denominationInputs = Array.from(inputs).slice(0, 10);
                
                denominationInputs.forEach((input, index) => {
                    if (index < denominations.length) {
                        // Add input event listener for real-time calculation
                        input.addEventListener('input', function() {
                            calculateDenomination(this, denominations[index]);
                        });
                        
                        // Add validation for negative numbers
                        input.addEventListener('change', function() {
                            const value = parseInt(this.value);
                            if (value < 0 || isNaN(value)) {
                                this.value = '';
                            }
                        });
                    }
                });
                

            }
            
            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + R to reset denominations
                if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
                    e.preventDefault();
                    resetDenominations();
                }
                
                // Ctrl/Cmd + F to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    const searchInput = document.getElementById('searchInput');
                    if (searchInput) {
                        searchInput.focus();
                        showToast('?? Search activated', 'info', 1500);
                    }
                }
            });
        });

        // Auto-resize input function
        function autoResizeInput(input) {
            const value = input.value;
            const minWidth = 80;
            const maxWidth = 200;
            
            // Create a temporary span to measure text width
            const span = document.createElement('span');
            span.style.visibility = 'hidden';
            span.style.position = 'absolute';
            span.style.fontSize = getComputedStyle(input).fontSize;
            span.style.fontFamily = getComputedStyle(input).fontFamily;
            span.style.fontWeight = getComputedStyle(input).fontWeight;
            span.style.letterSpacing = getComputedStyle(input).letterSpacing;
            span.style.padding = '0';
            span.textContent = value || input.placeholder;
            
            document.body.appendChild(span);
            const textWidth = span.offsetWidth;
            document.body.removeChild(span);
            
            // Set the input width to fit content, with min/max constraints
            const newWidth = Math.min(Math.max(textWidth + 20, minWidth), maxWidth);
            input.style.width = newWidth + 'px';
            
            // Add visual feedback for large numbers (only for active editing)
            if (!input.hasAttribute('readonly') && value && parseFloat(value) >= 100000) {
                input.style.borderColor = '#27ae60';
                input.style.fontWeight = '700';
            } else if (!input.hasAttribute('readonly') && value && parseFloat(value) >= 10000) {
                input.style.borderColor = '#f39c12';
                input.style.fontWeight = '600';
            } else if (input.hasAttribute('readonly')) {
                input.style.borderColor = '#ced4da';
                input.style.fontWeight = '600';
            } else {
                input.style.borderColor = '#e9ecef';
                input.style.fontWeight = '600';
            }
        }

        // Rider Selection Functions
        function editRiderRow(row) {
            const riderId   = row.getAttribute('data-rider-id');
            const riderName = row.getAttribute('data-rider-name');
            const cell      = document.getElementById('discrepancy-cell-' + riderId);
            if (!cell) return;

            if (row.dataset.hasDenomination !== 'true') {
                showToast('Edit is available only when denomination data exists for ' + riderName + '.', 'warning', 3000);
                return;
            }

            // Prevent double-opening
            if (cell.querySelector('.disc-edit-input')) return;

            const confirmationId = cell.dataset.confirmationId;
            if (!confirmationId) {
                showToast('No confirmed record found for ' + riderName + '. Please confirm first.', 'warning', 3000);
                return;
            }

            const rawValue     = cell.dataset.raw !== '' ? parseFloat(cell.dataset.raw) : 0;
            const originalText = cell.textContent.trim();
            const originalColor = cell.style.color;

            // Clear cell and inject inline editor
            cell.textContent = '';

            const wrapper = document.createElement('div');
            wrapper.style.cssText = 'display:flex;align-items:center;gap:3px;';

            const inp = document.createElement('input');
            inp.type = 'number';
            inp.className = 'disc-edit-input';
            inp.value = rawValue.toFixed(2);
            inp.step = '0.01';
            inp.style.cssText = 'width:90px;border:1.5px solid #3b82f6;border-radius:4px;padding:3px 6px;font-size:12px;font-weight:700;color:#1e3a8a;background:#eff6ff;text-align:right;outline:none;';

            const saveBtn   = document.createElement('button');
            saveBtn.innerHTML = '<i class="fas fa-check"></i>';
            saveBtn.title     = 'Save';
            saveBtn.style.cssText = 'padding:3px 7px;background:#059669;color:#fff;border:none;border-radius:4px;font-size:11px;cursor:pointer;';

            const cancelBtn = document.createElement('button');
            cancelBtn.innerHTML = '<i class="fas fa-times"></i>';
            cancelBtn.title     = 'Cancel';
            cancelBtn.style.cssText = 'padding:3px 7px;background:#dc2626;color:#fff;border:none;border-radius:4px;font-size:11px;cursor:pointer;';

            wrapper.appendChild(inp);
            wrapper.appendChild(saveBtn);
            wrapper.appendChild(cancelBtn);
            cell.appendChild(wrapper);
            setTimeout(() => { inp.focus(); inp.select(); }, 0);

            function restoreCell() {
                cell.textContent = originalText;
                cell.style.color = originalColor;
            }

            function commitSave() {
                const newVal = parseFloat(inp.value);
                if (isNaN(newVal)) { showToast('Please enter a valid number', 'error', 2000); return; }

                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                fetch('/bank-deposit/discrepancy/' + confirmationId, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfMeta ? csrfMeta.getAttribute('content') : ''
                    },
                    body: JSON.stringify({ discrepancy: newVal })
                })
                .then(r => r.json())
                .then(data => {
                    if (data.success) {
                        let newText, newColor;
                        if (newVal > 0)      { newText = '+' + newVal.toLocaleString('en-US', {minimumFractionDigits: 2}); newColor = '#d97706'; }
                        else if (newVal < 0) { newText = '-' + Math.abs(newVal).toLocaleString('en-US', {minimumFractionDigits: 2}); newColor = '#dc2626'; }
                        else                 { newText = '0.00'; newColor = '#059669'; }

                        cell.textContent           = newText;
                        cell.style.color           = newColor;
                        cell.dataset.original      = newText;
                        cell.dataset.raw           = newVal;

                        // Update Confirmed Amount cell with new total (bank_amount + discrepancy)
                        const newTotal = data.new_total;
                        const confirmedSpan = document.getElementById('confirmed-amount-' + riderId);
                        if (confirmedSpan && newTotal !== undefined) {
                            confirmedSpan.textContent = parseFloat(newTotal).toLocaleString('en-US', {minimumFractionDigits: 2});
                            confirmedSpan.style.color = parseFloat(newTotal) > 0 ? '#059669' : '#9ca3af';
                        }

                        // Update status badge based on new discrepancy value
                        const badge = document.getElementById('action-badge-' + riderId);
                        const riderRowEl = document.querySelector('.rider-row[data-rider-id="' + riderId + '"]');
                        if (badge) {
                            if (newVal === 0) {
                                badge.style.cssText = 'display:inline-flex;align-items:center;gap:5px;padding:5px 12px;background:#059669;color:#fff;border-radius:20px;font-size:11px;font-weight:600;';
                                badge.innerHTML = '<i class="fas fa-check-circle"></i>Validated';
                                if (riderRowEl) { riderRowEl.dataset.validated = 'true'; riderRowEl.style.opacity = '0.65'; riderRowEl.classList.remove('selected'); }
                            } else {
                                badge.style.cssText = 'display:inline-block;padding:5px 12px;background:#fff3cd;color:#856404;border-radius:15px;font-size:11px;font-weight:600;';
                                badge.innerHTML = 'Validating';
                                if (riderRowEl) { riderRowEl.dataset.validated = 'false'; riderRowEl.style.opacity = ''; }
                            }
                        }

                        refreshSummaryCards();
                        showToast('Discrepancy updated for ' + riderName, 'success', 2500);
                    } else {
                        restoreCell();
                        showToast('Failed to update discrepancy', 'error', 2500);
                    }
                })
                .catch(() => { restoreCell(); showToast('Error saving discrepancy', 'error', 2500); });
            }

            saveBtn.addEventListener('click',   e => { e.stopPropagation(); commitSave(); });
            cancelBtn.addEventListener('click', e => { e.stopPropagation(); restoreCell(); });
            inp.addEventListener('keydown', e => {
                if (e.key === 'Enter')  { e.preventDefault(); commitSave(); }
                if (e.key === 'Escape') restoreCell();
            });
        }

        function selectRiderFromTable(row) {
            // Block selection if already validated
            if (row.dataset.validated === 'true') {
                const riderName = row.getAttribute('data-rider-name');
                showToast(`?? ${riderName} is already validated and cannot be re-confirmed.`, 'warning', 3000);
                return;
            }

            // Remove previous selection
            document.querySelectorAll('.rider-row.selected').forEach(r => r.classList.remove('selected'));
            
            // Add selection to clicked row
            row.classList.add('selected');
            
            // Get rider data
            const riderId = row.getAttribute('data-rider-id');
            const riderName = row.getAttribute('data-rider-name');
            const remitAmount = row.getAttribute('data-remit-amount');
            
            // Auto-populate bank input
            loadRiderRemit(riderId, riderName, remitAmount);

            // Open denomination modal once a rider is selected
            openDenominationModal();
        }

        function loadRiderRemit(riderId, riderName, remitAmount) {
            const bankInput = document.getElementById('bankInput');
            const riderLabel = document.getElementById('denomSelectedRider');
            
            if (!riderId || !remitAmount) {
                // Clear bank input if no valid data
                bankInput.removeAttribute('readonly');
                bankInput.value = '';
                bankInput.setAttribute('readonly', true);
                showToast('Rider selection cleared', 'info', 2000);
                return;
            }
            
            // Temporarily remove readonly to set value
            bankInput.removeAttribute('readonly');
            
            // Store original amount for remaining calculation
            bankInput.dataset.originalAmount = parseFloat(remitAmount).toFixed(2);
            
            // Auto-populate bank input with rider's daily remit
            bankInput.value = '₱' + parseFloat(remitAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            bankInput.style.borderColor = '#436026';
            bankInput.style.borderWidth = '2px';
            bankInput.style.borderStyle = 'solid';
            const bankLabelLoad = document.getElementById('bankLabel');
            if (bankLabelLoad) { bankLabelLoad.textContent = 'Bank'; bankLabelLoad.style.color = '#374151'; }
            
            // Re-enable readonly
            bankInput.setAttribute('readonly', true);

            if (riderLabel) {
                riderLabel.textContent = riderName || '';
            }

            // Reset denomination flag � user hasn't typed anything for this rider yet
            _denomsEntered = false;

            // Recalculate if any denominations are already filled
            calculateTotal();
            
            // Show success toast
            
            
            // Trigger denomination recalculation 
            calculateTotal();
        }

        function openDenominationModal() {
            const modal = document.getElementById('denominationBreakdownModal');
            if (modal) {
                modal.style.display = 'flex';
            }
        }

        function closeDenominationModal() {
            const modal = document.getElementById('denominationBreakdownModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        // Search and Filter Functionality
        const sortFilter = document.getElementById('sortFilter');

        if (sortFilter) {
            sortFilter.addEventListener('change', function() {
                const url = new URL(window.location.href);
                const sortValue = sortFilter.value;
                if (sortValue) {
                    url.searchParams.set('sort', sortValue);
                } else {
                    url.searchParams.delete('sort');
                }
                url.searchParams.delete('page');
                window.location.href = url.toString();
            });
        }

        // Show toast for session success messages
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('success') }}', 'success');
            });
        @endif

        // --- Report Modal -------------------------------------------
        function openReportModal() {
            document.getElementById('reportModalOverlay').classList.add('open');
        }

        function closeReportModal() {
            document.getElementById('reportModalOverlay').classList.remove('open');
        }

        function generateReport() {
            const dateFrom   = document.getElementById('reportDateFrom').value;
            const dateTo     = document.getElementById('reportDateTo').value;
            const reportType = document.getElementById('reportType').value;
            const format     = document.getElementById('reportFormat').value;

            if (!dateFrom || !dateTo) {
                showToast('?? Please select both From and To dates.', 'error', 3000);
                return;
            }
            if (dateFrom > dateTo) {
                showToast('?? "Date From" cannot be after "Date To".', 'error', 3000);
                return;
            }

            // Gather selected columns
            const cols = [];
            if (document.getElementById('col-transactions').checked) cols.push('transactions');
            if (document.getElementById('col-remit').checked) cols.push('remit');
            if (document.getElementById('col-confirmed').checked) cols.push('confirmed');
            if (document.getElementById('col-discrepancy').checked) cols.push('discrepancy');
            if (document.getElementById('col-status').checked) cols.push('status');
            if (document.getElementById('col-officer').checked) cols.push('officer');

            if (format === 'csv') {
                // Redirect to CSV export route
                const url = new URL('/bank-deposit/report', window.location.origin);
                url.searchParams.set('date_from', dateFrom);
                url.searchParams.set('date_to', dateTo);
                url.searchParams.set('type', reportType);
                url.searchParams.set('cols', cols.join(','));
                url.searchParams.set('format', 'csv');
                window.location.href = url.toString();
            } else {
                // Open printable report in a new tab
                const url = new URL('/bank-deposit/report', window.location.origin);
                url.searchParams.set('date_from', dateFrom);
                url.searchParams.set('date_to', dateTo);
                url.searchParams.set('type', reportType);
                url.searchParams.set('cols', cols.join(','));
                url.searchParams.set('format', 'print');
                window.open(url.toString(), '_blank');
            }

            closeReportModal();
            showToast('?? Report is being generated...', 'success', 2500);
        }
    </script>

    <!-- Toast Notification Container -->
    <div id="toastContainer"></div>
<!-- Denomination Breakdown Modal -->
<div id="denominationBreakdownModal" onclick="if(event.target===this)closeDenominationModal()" style="display:none; position:fixed; inset:0; z-index:9998; align-items:center; justify-content:center; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px);">
    <div style="background:#fff; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,0.3); padding:22px 22px 18px; max-width:560px; width:94%; font-family:'Segoe UI',sans-serif; animation:modalIn .2s ease; max-height:92vh; overflow-y:auto;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
            <div>
                <div style="font-size:16px; font-weight:700; color:#111827;">Denomination Breakdown</div>
                <div style="font-size:12px; color:#6b7280; margin-top:2px;">Rider: <span id="denomSelectedRider" style="font-weight:700; color:#374151;"></span></div>
            </div>
            <button onclick="closeDenominationModal()" style="width:30px;height:30px;border-radius:50%;border:none;background:#f3f4f6;color:#6b7280;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="denomination-widget" style="padding:8px; box-shadow:none; border:1px solid #e5e7eb;">
            <div class="denomination-header">
                Denomination Breakdown
                <button onclick="resetDenominations()" style="margin-left: auto; padding: 3px 8px; background: #f0f0f0; border: 1px solid #e0e0e0; border-radius: 4px; font-size: 10px; cursor: pointer; transition: all 0.2s;">
                    <i class="fas fa-redo" style="margin-right: 3px;"></i>Reset
                </button>
            </div>
            <table class="denomination-table" id="denominationTable">
                <thead>
                    <tr>
                        <th>Denomination</th>
                        <th>No. of Pieces</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-denom="1000">
                        <td>1000</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="500">
                        <td>500</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="200">
                        <td>200</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="100">
                        <td>100</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="50">
                        <td>50</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="20">
                        <td>20</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="20b">
                        <td>20</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="10">
                        <td>10</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="5">
                        <td>5</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr data-denom="1">
                        <td>1</td>
                        <td><input type="number" min="0" placeholder="0"></td>
                        <td>0</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="2">Total</td>
                        <td id="denominationTotal">0</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px 14px; margin-top: 10px;">
            <span id="bankLabel" style="font-size: 13px; font-weight: 700; color: #374151;">Bank</span>
            <input type="text" id="bankInput" placeholder="₱0.00" readonly style="border: 2px solid #e5e7eb; border-radius: 6px; padding: 4px 8px; font-size: 13px; font-weight: 700; color: #374151; text-align: right; background: white; flex: 1; min-width: 0; margin-left: 12px; outline: none;">
        </div>

        <button onclick="confirmDenomination()" id="confirmDenomBtn" style="width: 100%; margin-top: 10px; padding: 8px 0; background: #436026; color: white; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.2s; letter-spacing: 0.5px;">
            <i class="fas fa-check" style="margin-right: 6px;"></i>Confirm
        </button>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmDenomModal" onclick="if(event.target===this)closeConfirmModal()" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px);">
    <div style="background:#fff; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,0.3); padding:32px 30px 26px; max-width:420px; width:90%; font-family:'Segoe UI',sans-serif; animation:modalIn .2s ease;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <div style="width:44px; height:44px; border-radius:50%; background:#f0fdf4; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fas fa-shield-alt" style="color:#16a34a; font-size:18px;"></i>
            </div>
            <div>
                <div style="font-weight:700; font-size:16px; color:#111827;">Confirm Denomination</div>
                <div style="font-size:12px; color:#6b7280; margin-top:2px;">Please review before submitting</div>
            </div>
        </div>
        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:14px 16px; margin-bottom:20px; font-size:13px;">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:5px 0; border-bottom:1px solid #e5e7eb;">
                <span style="color:#6b7280;">Rider</span>
                <span id="modal-rider-name" style="font-weight:700; color:#111827;"></span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:5px 0; border-bottom:1px solid #e5e7eb;">
                <span style="color:#6b7280;">Bank Amount</span>
                <span id="modal-bank-amount" style="font-weight:700; color:#111827;"></span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:5px 0; border-bottom:1px solid #e5e7eb;">
                <span style="color:#6b7280;">Denomination Total</span>
                <span id="modal-denom-total" style="font-weight:700; color:#111827;"></span>
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; padding:5px 0;">
                <span id="modal-balance-label" style="color:#6b7280;">Balance</span>
                <span id="modal-balance" style="font-weight:700;"></span>
            </div>
        </div>
        <div id="modal-warning" style="display:none; background:#fff7ed; border:1px solid #fed7aa; border-radius:8px; padding:10px 12px; margin-bottom:16px; font-size:12px; color:#c2410c; display:none;">
            <i class="fas fa-exclamation-triangle" style="margin-right:6px;"></i>
            <span id="modal-warning-text"></span>
        </div>
        <div style="display:flex; gap:10px;">
            <button onclick="closeConfirmModal()" style="flex:1; padding:10px; border:1.5px solid #d1d5db; border-radius:8px; background:#fff; color:#374151; font-size:14px; font-weight:600; cursor:pointer;">Cancel</button>
            <button id="modal-proceed-btn" onclick="_doConfirmPost()" style="flex:1.5; padding:10px; border:none; border-radius:8px; background:#16a34a; color:#fff; font-size:14px; font-weight:700; cursor:pointer;"><i class="fas fa-check" style="margin-right:6px;"></i>Proceed</button>
        </div>
    </div>
</div>
<!-- Denomination History Modal -->
<div id="denomHistoryModal" onclick="if(event.target===this)closeDenomHistory()" style="display:none; position:fixed; inset:0; z-index:9999; align-items:center; justify-content:center; background:rgba(0,0,0,0.55); backdrop-filter:blur(3px);">
    <div style="background:#fff; border-radius:14px; box-shadow:0 20px 60px rgba(0,0,0,0.3); padding:28px 28px 22px; max-width:460px; width:92%; font-family:'Segoe UI',sans-serif; animation:modalIn .2s ease; max-height:90vh; overflow-y:auto;">
        <!-- Header -->
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;">
            <div style="display:flex; align-items:center; gap:11px;">
                <div style="width:40px; height:40px; border-radius:50%; background:#eef2ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fas fa-history" style="color:#6366f1; font-size:16px;"></i>
                </div>
                <div>
                    <div style="font-weight:700; font-size:15px; color:#111827;">Denomination History</div>
                    <div id="dh-rider-name" style="font-size:12px; color:#6b7280; margin-top:1px;"></div>
                </div>
            </div>
            <button onclick="closeDenomHistory()" style="width:30px;height:30px;border-radius:50%;border:none;background:#f3f4f6;color:#6b7280;font-size:14px;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- No record state -->
        <div id="dh-no-record" style="display:none; text-align:center; padding:30px 0; color:#9ca3af;">
            <i class="fas fa-inbox" style="font-size:32px; margin-bottom:10px; display:block;"></i>
            <div style="font-size:13px; font-weight:600;">No denomination record found</div>
            <div style="font-size:11px; margin-top:4px;">This rider has not been confirmed yet.</div>
        </div>
        <!-- Record body -->
        <div id="dh-body">
            <div style="font-size:11px; color:#9ca3af; margin-bottom:10px;" id="dh-date"></div>
            <!-- Denomination table -->
            <table style="width:100%; border-collapse:collapse; font-size:13px; margin-bottom:14px;">
                <thead>
                    <tr style="background:#f9fafb;">
                        <th style="padding:8px 12px; text-align:left; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb;">Denomination</th>
                        <th style="padding:8px 12px; text-align:center; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb;">Pieces</th>
                        <th style="padding:8px 12px; text-align:right; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb;">Amount</th>
                    </tr>
                </thead>
                <tbody id="dh-denom-rows"></tbody>
                <tfoot>
                    <tr style="background:#f0fdf4;">
                        <td colspan="2" style="padding:9px 12px; font-weight:700; color:#065f46; border-top:2px solid #d1fae5;">Total</td>
                        <td id="dh-total" style="padding:9px 12px; text-align:right; font-weight:700; color:#059669; border-top:2px solid #d1fae5;"></td>
                    </tr>
                </tfoot>
            </table>
            <!-- Summary row -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px 14px;">
                    <div style="font-size:10px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Bank Amount</div>
                    <div id="dh-bank" style="font-size:15px; font-weight:700; color:#1e3a8a; margin-top:3px;"></div>
                </div>
                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px; padding:10px 14px;">
                    <div style="font-size:10px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.5px;">Discrepancy</div>
                    <div id="dh-discrepancy" style="font-size:15px; font-weight:700; margin-top:3px;"></div>
                </div>
            </div>
        </div>
        <div style="margin-top:18px; text-align:right;">
            <button onclick="closeDenomHistory()" style="padding:9px 22px; border:1.5px solid #d1d5db; border-radius:8px; background:#fff; color:#374151; font-size:13px; font-weight:600; cursor:pointer;">Close</button>
        </div>
    </div>
</div>
<style>
@keyframes modalIn { from { transform:scale(.93); opacity:0; } to { transform:scale(1); opacity:1; } }
</style>

<!-- Report Generation Modal -->
<div class="report-modal-overlay" id="reportModalOverlay" onclick="if(event.target===this)closeReportModal()">
    <div class="report-modal">

        <!-- Top accent bar -->
        <div class="report-modal-topbar">
            <div class="report-modal-topbar-left">
                <div class="report-modal-topbar-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <div>
                    <div class="report-modal-topbar-title">Generate Report</div>
                    <div class="report-modal-topbar-sub">Bank &amp; Deposit � configure &amp; export</div>
                </div>
            </div>
            <button class="report-modal-close" onclick="closeReportModal()"><i class="fas fa-times"></i></button>
        </div>

        <!-- Body -->
        <div class="report-modal-body">

            <!-- Date Range -->
            <div class="report-section-label">Date Range</div>
            <div class="report-date-row">
                <div class="report-date-field">
                    <span>From</span>
                    <input type="date" id="reportDateFrom" class="report-input" value="{{ request('date') ?? now()->format('Y-m-d') }}">
                </div>
                <div class="report-date-sep">?</div>
                <div class="report-date-field">
                    <span>To</span>
                    <input type="date" id="reportDateTo" class="report-input" value="{{ request('date') ?? now()->format('Y-m-d') }}">
                </div>
            </div>

            <!-- Report Type -->
            <div class="report-section-label">Report Type</div>
            <div class="report-type-grid">
                <label class="report-type-card">
                    <input type="radio" name="reportTypeRadio" value="summary" checked onchange="document.getElementById('reportType').value=this.value">
                    <div class="report-type-card-inner">
                        <i class="fas fa-table"></i>
                        <span>Daily Summary</span>
                    </div>
                </label>
                <label class="report-type-card">
                    <input type="radio" name="reportTypeRadio" value="detailed" onchange="document.getElementById('reportType').value=this.value">
                    <div class="report-type-card-inner">
                        <i class="fas fa-coins"></i>
                        <span>Denomination Breakdown</span>
                    </div>
                </label>
                <label class="report-type-card">
                    <input type="radio" name="reportTypeRadio" value="discrepancy" onchange="document.getElementById('reportType').value=this.value">
                    <div class="report-type-card-inner">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Discrepancy Only</span>
                    </div>
                </label>
            </div>
            <input type="hidden" id="reportType" value="summary">

            <!-- Columns -->
            <div class="report-section-label">Include Columns</div>
            <div class="report-col-grid">
                <label class="report-col-chip">
                    <input type="checkbox" id="col-transactions" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-receipt"></i> Transactions</div>
                </label>
                <label class="report-col-chip">
                    <input type="checkbox" id="col-remit" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-wallet"></i> Total Remit</div>
                </label>
                <label class="report-col-chip">
                    <input type="checkbox" id="col-confirmed" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-check"></i> Confirmed</div>
                </label>
                <label class="report-col-chip">
                    <input type="checkbox" id="col-discrepancy" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-balance-scale"></i> Discrepancy</div>
                </label>
                <label class="report-col-chip">
                    <input type="checkbox" id="col-status" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-tag"></i> Status</div>
                </label>
                <label class="report-col-chip">
                    <input type="checkbox" id="col-officer" checked>
                    <div class="report-col-chip-inner"><i class="fas fa-user"></i> Officer</div>
                </label>
            </div>

            <!-- Output Format -->
            <div class="report-section-label">Output Format</div>
            <div class="report-format-row">
                <label class="report-format-opt">
                    <input type="radio" name="reportFormatRadio" value="print" checked onchange="document.getElementById('reportFormat').value=this.value">
                    <div class="report-format-opt-inner">
                        <div class="fmt-icon"><i class="fas fa-print"></i></div>
                        <div>
                            <div class="fmt-label">Print / PDF</div>
                            <div class="fmt-sub">Opens in new tab</div>
                        </div>
                    </div>
                </label>
                <label class="report-format-opt">
                    <input type="radio" name="reportFormatRadio" value="csv" onchange="document.getElementById('reportFormat').value=this.value">
                    <div class="report-format-opt-inner">
                        <div class="fmt-icon"><i class="fas fa-file-csv"></i></div>
                        <div>
                            <div class="fmt-label">CSV Download</div>
                            <div class="fmt-sub">Spreadsheet file</div>
                        </div>
                    </div>
                </label>
            </div>
            <input type="hidden" id="reportFormat" value="print">

        </div><!-- /.report-modal-body -->

        <div class="report-modal-footer">
            <button class="report-cancel-btn" onclick="closeReportModal()">Cancel</button>
            <button class="report-generate-btn" onclick="generateReport()">
                <i class="fas fa-file-download"></i> Generate Report
            </button>
        </div>
    </div>
</div>

    @include('partials.floating-widgets')
</body>
</html>

