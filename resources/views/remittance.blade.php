<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Remittance - When in Baguio Inc.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            background: #f0f2f5;
        }

                @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')



        /* Main Content Styles */
        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 24px 28px;
            overflow-y: auto;
            background: #f0f2f5;
        }

        .content-header {
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 22px;
            font-weight: 800;
            color: #1a1a1a;
            margin: 0;
            letter-spacing: -0.3px;
        }

        .user-indicator {
            display: flex;
            align-items: center;
            gap: 10px;
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
        }

        .user-indicator .user-role {
            font-size: 12px;
            color: #666;
            font-weight: 500;
            text-transform: capitalize;
        }

        .remittance-container {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 2fr);
            gap: 20px;
            align-items: start;

        }

        .rider-queue-panel {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07), 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            transition: box-shadow 0.2s ease;
            animation: fadeInUp 0.5s ease;
            min-width: 0;
            position: relative;
            z-index: 1;
        }

        .rider-queue-panel:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.09), 0 8px 24px rgba(0, 0, 0, 0.08);
        }

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

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .panel-header h2 {
            font-size: 16px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .panel-header h2::before {
            content: '';
            width: 3px;
            height: 18px;
            background: linear-gradient(180deg, #436026 0%, #5a7d33 100%);
            border-radius: 2px;
        }

        .add-remit-btn {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.3);
        }

        .add-remit-btn:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #6d9640 100%);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(67, 96, 38, 0.4);
        }

        .add-remit-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(67, 96, 38, 0.3);
        }

        .search-bar {
            margin-bottom: 15px;
            position: relative;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .search-bar input:focus {
            outline: none;
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
        }

        .rider-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
            max-height: 400px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .rider-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .rider-row.selected .rider-dropdown-header {
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            color: #fff;
            border-radius: 8px;
        }

        .rider-row.selected .rider-dropdown-header .rider-avatar {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
        }

        .rider-row.selected .rider-dropdown-header .rider-item-info strong {
            color: #fff;
        }

        .rider-row.selected .rider-dropdown-header .rider-chevron {
            color: rgba(255, 255, 255, 0.8);
        }

        .rider-list::-webkit-scrollbar {
            width: 5px;
        }

        .rider-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .rider-list::-webkit-scrollbar-thumb {
            background: #436026;
            border-radius: 10px;
        }

        .rider-list::-webkit-scrollbar-thumb:hover {
            background: #5a7d33;
        }

        .rider-item {
            background: white;
            padding: 12px 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex: 1;
        }

        .rider-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #436026 0%, #5a7d33 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .rider-item:hover {
            border-color: #e9ecef;
            background: #fafbfc;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .rider-item:hover::before {
            opacity: 0;
        }

        .rider-item.active {
            border-color: #e9ecef;
            background: linear-gradient(135deg, #f5f9f2 0%, #ebf3e7 100%);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .rider-item.active::before {
            opacity: 0;
        }

        /* Dropdown rider styles */
        .rider-dropdown {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #e9ecef;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .rider-dropdown.open {
            border-color: #436026;
            box-shadow: 0 4px 16px rgba(67, 96, 38, 0.13);
        }

        .rider-dropdown-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 12px 15px;
            cursor: pointer;
            background: white;
            transition: background 0.2s;
            user-select: none;
        }

        .rider-dropdown.open .rider-dropdown-header {
            background: linear-gradient(135deg, #f5f9f2 0%, #ebf3e7 100%);
        }

        .rider-row.selected .rider-dropdown.open .rider-dropdown-header {
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
        }

        .rider-dropdown-header:hover {
            background: #fafbfc;
        }

        .rider-chevron {
            font-size: 11px;
            color: #6c757d;
            transition: transform 0.25s ease;
            flex-shrink: 0;
        }

        .rider-dropdown.open .rider-chevron {
            transform: rotate(180deg);
            color: #436026;
        }

        .rider-dropdown-body {
            display: none;
            gap: 10px;
            padding: 12px 14px 14px 14px;
            background: linear-gradient(135deg, #f5f9f2 0%, #edf5e8 100%);
            border-top: 1px solid #d6eacc;
        }

        .rider-dropdown.open .rider-dropdown-body {
            display: flex;
        }

        .rider-item-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .rider-item strong {
            font-size: 14px;
            color: #1a1a1a;
        }

        .rider-status {
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border: 1.5px solid;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .rider-status.pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
            color: #856404;
            border-color: #ffc107;
        }

        .rider-status.cleared {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-color: #28a745;
        }

        .rider-status.blocked {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c2c7 100%);
            color: #842029;
            border-color: #dc3545;
        }

        .rider-status.short {
            background: linear-gradient(135deg, #ffe3e3 0%, #ffc9c9 100%);
            color: #9b1c1c;
            border-color: #fa5252;
        }

        .rider-action-btn.blocked-btn {
            background: linear-gradient(135deg, #adb5bd 0%, #868e96 100%);
            cursor: not-allowed;
            box-shadow: none;
            opacity: 0.65;
            pointer-events: none;
        }

        .rider-action-btn.blocked-btn:hover {
            transform: none;
            background: linear-gradient(135deg, #adb5bd 0%, #868e96 100%);
            box-shadow: none;
        }

        .rider-blocked-notice {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff3f3;
            border: 1px solid #f5c2c7;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 10px;
            color: #842029;
            font-weight: 600;
            margin-top: 4px;
        }

        .rider-blocked-notice i {
            font-size: 11px;
            flex-shrink: 0;
        }

        .rider-item-actions {
            display: flex;
            gap: 5px;
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .rider-item:hover .rider-item-actions {
            opacity: 1;
        }

        .rider-item.active .rider-item-actions {
            opacity: 1;
        }

        .rider-action-btn {
            flex: 1;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(67, 96, 38, 0.22);
            letter-spacing: 0.02em;
        }

        .rider-action-btn:hover {
            background: linear-gradient(135deg, #4e7030 0%, #6a9040 100%);
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(67, 96, 38, 0.35);
        }

        .rider-action-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(67, 96, 38, 0.3);
        }

        .rider-action-btn i {
            font-size: 10px;
        }

        .rider-action-btn.records-btn {
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            box-shadow: 0 2px 6px rgba(52, 58, 64, 0.25);
        }

        .rider-action-btn.records-btn:hover {
            background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
            box-shadow: 0 5px 14px rgba(52, 58, 64, 0.35);
        }

        .rider-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            letter-spacing: 0;
            box-shadow: 0 2px 6px rgba(67, 96, 38, 0.25);
            user-select: none;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: modalSlideIn 0.3s ease;
        }

        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            padding: 20px 25px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border-radius: 12px 12px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .modal-footer {
            padding: 20px 25px;
            background: #f8f9fa;
            border-radius: 0 0 12px 12px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn.cancel {
            background: #6c757d;
            color: white;
        }

        .modal-btn.cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
        }

        .modal-btn.submit {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
        }

        .modal-btn.submit:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #6d9640 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(67, 96, 38, 0.3);
        }

        .remittance-details-panel {
            background: #ffffff;
            border-radius: 0 0 12px 12px;
            padding: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07), 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            border-top: none;
            transition: box-shadow 0.2s ease;
            animation: fadeInUp 0.5s ease 0.1s both;
            min-width: 0;
            position: relative;
            z-index: 0;
        }

        .remittance-details-panel:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.09), 0 8px 24px rgba(0, 0, 0, 0.08);
        }

        .details-header {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 16px;
            padding: 10px 14px;
            background: #f9fafb;
            border-radius: 8px;
            border-left: 3px solid #436026;
            box-shadow: none;
        }

        .collection-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .collection-item {
            text-align: center;
            background: #f9fafb;
            padding: 14px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            box-shadow: none;
        }

        .collection-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.12);
            border-color: #86b562;
        }

        .collection-label {
            font-size: 11px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .collection-amount {
            font-size: 24px;
            font-weight: bold;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(67, 96, 38, 0.1);
        }

        .collection-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #e9ecef 20%, #e9ecef 80%, transparent 100%);
            margin: 20px 0;
            position: relative;
        }

        .collection-divider::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background: #436026;
            border-radius: 50%;
            box-shadow: 0 0 0 3px white, 0 0 0 5px #e9ecef;
        }

        .expenses-section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title::before {
            content: '\f15c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #436026;
            font-size: 16px;
        }

        .expenses-content {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: 10px;
            min-height: 100px;
            text-align: left;
            color: #6c757d;
            border: 2px dashed #dee2e6;
            position: relative;
            overflow: hidden;
            font-size: 13px;
        }

        .expenses-content::before {
            content: '\f02b';
            font-family: 'Font Awesome 6 Free';
            font-weight: 400;
            font-size: 36px;
            color: #dee2e6;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.3;
        }

        .net-turnover {
            background: linear-gradient(135deg, #f0f7ed 0%, #e6f3df 100%);
            padding: 14px 18px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            border: 1.5px solid #86b562;
            box-shadow: 0 2px 10px rgba(67, 96, 38, 0.1);
            position: relative;
            overflow: hidden;
        }

        .net-turnover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #436026 0%, #ffd300 50%, #436026 100%);
        }

        .net-turnover-label {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .net-turnover-label::before {
            content: '\f53d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: #436026;
            font-size: 18px;
        }

        .net-turnover-amount {
            font-size: 28px;
            font-weight: bold;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(67, 96, 38, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .action-btn {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #6d9640 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(67, 96, 38, 0.4);
        }

        .action-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
        }

        .action-btn:disabled {
            background: linear-gradient(135deg, #9e9e9e 0%, #757575 100%);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .action-btn:disabled:hover {
            transform: none;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.2);
        }

        .action-btn i {
            font-size: 14px;
            position: relative;
            z-index: 1;
        }

        .action-btn span {
            position: relative;
            z-index: 1;
        }

        /* Success Alert */
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 12px 18px;
            border-radius: 8px;
            margin-bottom: 15px;
            border-left: 3px solid #28a745;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideInDown 0.5s ease;
            font-weight: 500;
            font-size: 13px;
        }

        .alert-success i {
            font-size: 16px;
            color: #28a745;
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

        /* Cleared Riders Table */
        .cleared-riders-section {
            margin-top: 0;
            background: #ffffff;
            border-radius: 0 0 12px 12px;
            padding: 20px 24px 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06), 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            border-top: none;
            animation: fadeInUp 0.5s ease 0.2s both;
        }

        .cleared-riders-header {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 16px;
        }

        .cleared-riders-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .cleared-riders-table thead {
            background: linear-gradient(135deg, #2d4016 0%, #436026 60%, #5a7d33 100%);
        }

        .cleared-riders-table thead th {
            padding: 12px 14px;
            text-align: left;
            font-weight: 700;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: rgba(255, 255, 255, 0.95);
            border-bottom: none;
        }

        .cleared-riders-table tbody tr {
            background: #ffffff;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.15s ease;
        }

        .cleared-riders-table tbody tr:nth-child(even) {
            background: #fafafa;
        }

        .cleared-riders-table tbody tr:hover {
            background: #f0f7ed;
        }

        .cleared-riders-table tbody td {
            padding: 10px 14px;
            font-size: 13px;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
        }

        .cleared-riders-table tbody tr:last-child td {
            border-bottom: none;
        }

        .table-empty-state {
            text-align: center;
            padding: 40px;
            color: #6c757d;
        }

        .table-empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            opacity: 0.3;
        }

        .table-empty-state p {
            font-size: 14px;
            margin: 0;
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
                padding: 70px 15px 15px 15px;
            }

            .remittance-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .collection-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .panel-header {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }

            .add-remit-btn {
                width: 100%;
                justify-content: center;
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

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .content-header h1 {
                font-size: 20px;
            }

            .user-indicator {
                width: 100%;
                justify-content: flex-end;
            }

            .cleared-riders-section {
                overflow-x: auto;
            }

            .cleared-riders-table {
                min-width: 600px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 70px 15px 15px 15px;
            }

            .user-indicator .user-name {
                font-size: 12px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                justify-content: center;
            }

            .rider-queue-panel,
            .remittance-details-panel,
            .cleared-riders-section {
                padding: 15px;
            }

            .details-header {
                font-size: 16px;
                padding: 10px 12px;
            }

            .net-turnover {
                flex-direction: column;
                gap: 8px;
                text-align: center;
                padding: 12px 15px;
            }

            .collection-amount {
                font-size: 22px;
            }

            .net-turnover-amount {
                font-size: 26px;
            }

            .cleared-riders-header {
                font-size: 16px;
            }

            .cleared-riders-header {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
            }

            .cleared-riders-header .search-bar {
                max-width: 100% !important;
            }

            .cleared-riders-table thead th,
            .cleared-riders-table tbody td {
                padding: 10px;
                font-size: 12px;
            }
        }

        @include('partials.user-indicator-styles')
    </style>
</head>

<body>
    @include('partials.app-sidebar', ['activePage' => 'remittance'])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <h1>Remittance Management</h1>
            @include('partials.user-indicator')
        </div>

        <style>
            .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 14px;
                margin-bottom: 20px;
            }

            .stat-card {
                position: relative;
                border-radius: 12px;
                padding: 16px 16px;
                display: flex;
                flex-direction: column;
                gap: 6px;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                cursor: pointer;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .stat-card::before {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 90px;
                height: 90px;
                opacity: 0.1;
                border-radius: 50%;
                transform: translate(30%, -30%);
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.16);
            }

            .stat-card-icon {
                font-size: 20px;
                margin-bottom: 1px;
                display: flex;
                align-items: center;
                gap: 5px;
                opacity: 0.9;
            }

            .stat-card-label {
                font-size: 10px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                opacity: 0.85;
            }

            .stat-card-value {
                font-size: 24px;
                font-weight: 800;
                line-height: 1;
                margin-top: 1px;
                letter-spacing: -0.5px;
            }

            .stat-card-pending {
                background: linear-gradient(135deg, #2d4016 0%, #5a7d35 100%);
                color: #fff;
            }

            .stat-card-pending::before {
                background: #fff;
            }

            .stat-card-cleared {
                background: linear-gradient(135deg, #1e5631 0%, #4caf72 100%);
                color: #fff;
            }

            .stat-card-cleared::before {
                background: #fff;
            }

            .stat-card-cash {
                background: linear-gradient(135deg, #436026 0%, #8db547 100%);
                color: #fff;
            }

            .stat-card-cash::before {
                background: #fff;
            }

            .stat-card-digital {
                background: linear-gradient(135deg, #2d5a27 0%, #6aaa3a 100%);
                color: #fff;
            }

            .stat-card-digital::before {
                background: #fff;
            }

            @media (max-width: 1200px) {
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }

            @media (max-width: 768px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }
            }
        </style>

        <!-- Stats Date Filter -->
        <form method="GET" action="{{ route('remittance') }}" id="statsFilterForm"
            style="display:flex; align-items:center; gap:10px; margin-bottom:16px; flex-wrap:wrap;">
            <div
                style="display:flex; align-items:center; gap:0; background:#fff; border:1px solid #e5e7eb; border-radius:10px; padding:4px 6px 4px 12px; box-shadow:0 1px 4px rgba(0,0,0,0.06); gap:8px;">
                <i class="fas fa-calendar-day" style="color:#436026; font-size:13px;"></i>
                <label for="statsDateInput"
                    style="font-size:11px; font-weight:800; color:#436026; white-space:nowrap; text-transform:uppercase; letter-spacing:0.6px;">Stats
                    Date</label>
                <div style="width:1px; height:18px; background:#e5e7eb;"></div>
                <input type="date" id="statsDateInput" name="stats_date" value="{{ $statsDate }}"
                    onchange="this.form.submit()"
                    style="border:none; outline:none; font-size:13px; font-weight:600; color:#111827; background:transparent; cursor:pointer; padding:4px 4px;">
            </div>
            @if ($statsDate !== now()->toDateString())
                <a href="{{ route('remittance') }}"
                    style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; background:linear-gradient(135deg,#436026 0%,#5a7d33 100%); color:#fff; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; box-shadow:0 2px 6px rgba(67,96,38,0.25);"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(67,96,38,0.35)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(67,96,38,0.25)'">
                    <i class="fas fa-undo" style="font-size:11px;"></i>Back to Today
                </a>
            @endif
            <span style="font-size:11px; color:#9ca3af; font-style:italic; display:flex; align-items:center; gap:5px;">
                <i class="fas fa-circle"
                    style="font-size:5px; color:{{ $statsDate === now()->toDateString() ? '#22c55e' : '#f59e0b' }};"></i>
                @if ($statsDate === now()->toDateString())
                    Showing today's stats
                @else
                    Showing stats for {{ \Carbon\Carbon::parse($statsDate)->format('M d, Y') }}
                @endif
            </span>
        </form>

        <div class="stats-grid">
            <div class="stat-card stat-card-pending" onclick="openNonRemittingModal('{{ $statsDateParsed }}')"
                style="cursor:pointer;" title="Click to view non-remitting riders">
                <div class="stat-card-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-card-label">Non-remitting Rider</div>
                <div class="stat-card-value">{{ $nonRemittingRiderCount }}</div>
                <div style="font-size:10px;opacity:0.75;margin-top:4px;display:flex;align-items:center;gap:4px;"><i
                        class="fas fa-eye" style="font-size:9px;"></i> View riders</div>
            </div>
            <div class="stat-card stat-card-cleared">
                <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-card-label">Cleared Count</div>
                <div class="stat-card-value">{{ $clearedCount }}</div>
            </div>
            <div class="stat-card stat-card-cash">
                <div class="stat-card-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <div class="stat-card-label">Cash Collection</div>
                <div class="stat-card-value">₱{{ number_format($cashCollection, 2) }}</div>
            </div>
            <div class="stat-card stat-card-digital">
                <div class="stat-card-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <div class="stat-card-label">Digital Collection</div>
                <div class="stat-card-value">₱{{ number_format($digitalCollection, 2) }}</div>
            </div>
        </div>



        <div class="remittance-container">
            <!-- Rider Queue Panel -->
            <div class="rider-queue-panel">
                <div class="panel-header">
                    <h2>Rider Queue</h2>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="riderSearch" placeholder="Search rider..." oninput="searchRiders()">
                </div>
                <div class="rider-list">
                    @forelse($riders as $index => $rider)
                        @php $isBlocked = in_array($rider->id, $blockedRiderIds); @endphp
                        @php $isAlreadyRemitted = in_array($rider->id, $remittedRiderIds ?? []); @endphp
                        @php $isShortRemit = in_array($rider->id, $shortRiderIds ?? []); @endphp
                        <div class="rider-row" data-rider-id="{{ $rider->id }}"
                            data-blocked="{{ $isBlocked ? 'true' : 'false' }}"
                            data-remitted="{{ $isAlreadyRemitted ? 'true' : 'false' }}">
                            <div class="rider-dropdown">
                                <div class="rider-dropdown-header" onclick="toggleRiderDropdown(this)">
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div class="rider-avatar">{{ strtoupper(substr($rider->name, 0, 1)) }}</div>
                                        <div class="rider-item-info">
                                            <strong>{{ $rider->name }}</strong>
                                        </div>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:6px;">
                                        @if ($isBlocked)
                                            <span class="rider-status pending">Pending</span>
                                        @elseif($isAlreadyRemitted)
                                            <span class="rider-status cleared">
                                                <i class="fas fa-check" style="font-size:8px;"></i> Remitted
                                            </span>
                                        @elseif($isShortRemit)
                                            <span class="rider-status short">Short</span>
                                        @elseif(in_array($rider->id, $clearedRiderIds))
                                            <span class="rider-status cleared">
                                                <i class="fas fa-check" style="font-size:8px;"></i> Cleared
                                            </span>
                                        @else
                                            <span class="rider-status pending">Pending</span>
                                        @endif
                                        <i class="fas fa-chevron-down rider-chevron"></i>
                                    </div>
                                </div>
                                <div class="rider-dropdown-body" style="flex-direction:column;">
                                    <div style="display:flex;gap:10px;">
                                        @if ($isBlocked)
                                            <button class="rider-action-btn blocked-btn" disabled
                                                title="Rider did not remit yesterday">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span>Remit</span>
                                            </button>
                                        @elseif($isAlreadyRemitted)
                                            <button class="rider-action-btn blocked-btn" disabled
                                                title="Rider already fully remitted for the selected date">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span>Remit</span>
                                            </button>
                                        @else
                                            <button class="rider-action-btn"
                                                onclick="openRemitModal({{ $rider->id }}, '{{ $rider->name }}');event.stopPropagation()">
                                                <i class="fas fa-money-bill-wave"></i>
                                                <span>Remit</span>
                                            </button>
                                        @endif
                                        <button class="rider-action-btn records-btn"
                                            onclick="openRiderRecordsModal({{ $rider->id }}, '{{ $rider->name }}');event.stopPropagation()">
                                            <i class="fas fa-history"></i>
                                            <span>Records</span>
                                        </button>
                                    </div>
                                    @if ($isBlocked)
                                        <div class="rider-blocked-notice">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            This rider did not remit yesterday. Please settle before proceeding.
                                        </div>
                                    @elseif($isAlreadyRemitted)
                                        <div class="rider-blocked-notice" style="background: #e9f7ef; border-color: #b8e0c3; color: #1f6b3d;">
                                            <i class="fas fa-check-circle"></i>
                                            This rider is fully remitted for the selected date.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p style="font-size: 14px; margin: 0;">No riders available.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- Remittance Details Panel -->
            <div class="remittance-details-panel">
                <div class="remit-tabs" id="remitTabs">
                    <button class="remit-tab-btn active" data-tab="overview">Remittance Overview</button>
                    <button class="remit-tab-btn" data-tab="payroll">Rider's Payroll</button>
                </div>
                <style>
                    .remit-tabs {
                        display: flex;
                        justify-content: stretch;
                        align-items: stretch;
                        margin: -20px -20px 0 -20px;
                        width: calc(100% + 40px);
                        background: #f3f4f6;
                        border-top-left-radius: 12px;
                        border-top-right-radius: 12px;
                        border-bottom: 1px solid #e5e7eb;
                        padding: 6px 6px 0;
                        gap: 2px;
                    }

                    .remit-tab-btn {
                        flex: 1 1 0;
                        background: transparent;
                        color: #6b7280;
                        border: none;
                        border-radius: 8px 8px 0 0;
                        padding: 10px 0;
                        font-size: 13px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.2s;
                        outline: none;
                        box-shadow: none;
                        font-family: 'Inter', Arial, sans-serif;
                        position: relative;
                    }

                    .remit-tab-btn.active {
                        background: #ffffff;
                        color: #436026;
                        font-weight: 700;
                        z-index: 2;
                        box-shadow: 0 -1px 0 0 #e5e7eb inset, 1px 0 0 0 #e5e7eb inset, -1px 0 0 0 #e5e7eb inset;
                    }

                    .remit-tab-btn.active::after {
                        content: '';
                        position: absolute;
                        bottom: 0;
                        left: 10%;
                        right: 10%;
                        height: 2.5px;
                        background: #436026;
                        border-radius: 2px 2px 0 0;
                    }

                    .remit-tab-btn:hover:not(.active) {
                        background: rgba(255, 255, 255, 0.6);
                        color: #374151;
                    }

                    .remit-tab-content {
                        padding-top: 16px;
                    }

                    @media (max-width: 768px) {
                        .remit-tab-btn {
                            font-size: 12px;
                            padding: 8px 0;
                        }
                    }

                    @media (max-width: 480px) {
                        .remit-tabs {
                            flex-direction: column;
                            padding: 4px;
                            gap: 4px;
                            border-radius: 12px;
                            border-bottom: 1px solid #e5e7eb;
                        }

                        .remit-tab-btn {
                            border-radius: 8px;
                            padding: 10px 16px;
                            text-align: left;
                            display: flex;
                            align-items: center;
                        }

                        .remit-tab-btn.active {
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                        }

                        .remit-tab-btn.active::after {
                            display: none;
                        }
                    }
                </style>
                <div class="remit-tab-content" id="tabOverview">
                    <div class="details-header">
                        Remittance Details: <span id="detailsRiderName"
                            style="color: #436026; font-weight: 700;"></span>
                    </div>
                    <div class="collection-grid">
                        <div class="collection-item">
                            <div class="collection-label">Cash Collection</div>
                            <div class="collection-amount" id="cashCollectionDisplay">₱0.00</div>
                        </div>
                        <div class="collection-item">
                            <div class="collection-label">Digital/GCASH</div>
                            <div class="collection-amount" id="digitalCollectionDisplay">₱0.00</div>
                        </div>
                    </div>
                    <div class="collection-divider"></div>
                    <div class="expenses-section">
                        <div class="section-title">Remarks</div>
                        <div class="expenses-content">
                            <p style="position: relative; z-index: 1; font-weight: 500;">-</p>
                        </div>
                    </div>
                    <div class="collection-divider"></div>
                    <div class="net-turnover">
                        <div class="net-turnover-label">NET TO TURN OVER:</div>
                        <div class="net-turnover-amount" id="netTurnoverDisplay">₱0.00</div>
                    </div>
                    <div class="action-buttons">
                        <button class="action-btn" id="viewPhotoBtn" onclick="viewRemitPhoto()"
                            style="display: none;">
                            <i class="fas fa-image"></i>
                            <span>View Remit Photo</span>
                        </button>
                        <button class="action-btn" id="editRemitBtn" onclick="editRemittance()" disabled
                            style="opacity: 0.5; cursor: not-allowed; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </button>
                        <button class="action-btn" id="confirmReceiptBtn" onclick="confirmReceipt()" disabled
                            style="opacity: 0.5; cursor: not-allowed;">
                            <i class="fas fa-check"></i>
                            <span>Confirm Receipt</span>
                        </button>
                    </div>
                </div>
                <div class="remit-tab-content" id="tabPayroll" style="display:none;">
                    <style>
                        .payroll-panel {
                            padding: 0;
                        }

                        .payroll-sections-grid {
                            display: grid;
                            grid-template-columns: 1fr 1fr;
                            gap: 20px;
                            margin-bottom: 20px;
                        }

                        .payroll-section-full {
                            grid-column: 1 / -1;
                        }

                        .payroll-section {
                            background: #fff;
                            border-radius: 12px;
                            padding: 20px;
                            border: 1px solid #e5e7eb;
                            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                        }

                        .payroll-section-title {
                            font-size: 13px;
                            font-weight: 700;
                            color: #436026;
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            margin-bottom: 16px;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                        }

                        .payroll-section-title i {
                            font-size: 14px;
                        }

                        .form-row {
                            display: grid;
                            grid-template-columns: 140px 1fr;
                            gap: 12px;
                            align-items: start;
                            margin-bottom: 16px;
                        }

                        .form-row:last-child {
                            margin-bottom: 0;
                        }

                        .payroll-section-full .form-row {
                            grid-template-columns: 1fr;
                            gap: 8px;
                        }

                        .payroll-section-full .form-label {
                            padding-top: 0;
                            font-size: 12px;
                        }

                        .form-label {
                            font-size: 13px;
                            font-weight: 600;
                            color: #374151;
                            padding-top: 10px;
                            line-height: 1.4;
                        }

                        .form-input {
                            font-size: 14px;
                            padding: 10px 14px;
                            border-radius: 8px;
                            border: 1px solid #d1d5db;
                            background: #fff;
                            transition: all 0.2s;
                            font-family: 'Inter', Arial, sans-serif;
                        }

                        .form-input:focus {
                            outline: none;
                            border-color: #436026;
                            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
                        }

                        .form-input:read-only {
                            background: #f9fafb;
                            color: #6b7280;
                            cursor: not-allowed;
                        }

                        .form-input-readonly-highlight {
                            background: #f0f9f4 !important;
                            color: #436026 !important;
                            font-weight: 600 !important;
                            border-color: #9dc183 !important;
                        }

                        .adda-df-container {
                            display: flex;
                            flex-direction: column;
                            gap: 10px;
                        }

                        .adda-df-row {
                            display: flex;
                            gap: 10px;
                            align-items: center;
                        }

                        .adda-df-amount,
                        .adda-df-date {
                            flex: 1;
                            font-size: 14px;
                            padding: 10px 14px;
                            border-radius: 8px;
                            border: 1px solid #d1d5db;
                            background: #fff;
                            transition: all 0.2s;
                        }

                        .adda-df-amount:focus,
                        .adda-df-date:focus {
                            outline: none;
                            border-color: #436026;
                            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
                        }

                        .adda-df-remove {
                            background: #ef4444;
                            color: #fff;
                            border: none;
                            border-radius: 8px;
                            padding: 10px 16px;
                            font-size: 12px;
                            font-weight: 600;
                            cursor: pointer;
                            white-space: nowrap;
                            transition: all 0.2s;
                        }

                        .adda-df-remove:hover {
                            background: #dc2626;
                            transform: translateY(-1px);
                        }

                        .adda-df-footer {
                            display: flex;
                            align-items: center;
                            justify-content: space-between;
                            gap: 12px;
                            padding-top: 8px;
                            border-top: 1px solid #e5e7eb;
                        }

                        .adda-df-summary {
                            color: #6b7280;
                            font-size: 13px;
                            font-weight: 600;
                        }

                        .adda-add-btn {
                            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
                            color: #fff;
                            border: none;
                            border-radius: 8px;
                            padding: 9px 18px;
                            font-size: 13px;
                            font-weight: 600;
                            cursor: pointer;
                            white-space: nowrap;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                            transition: all 0.2s;
                            box-shadow: 0 2px 4px rgba(67, 96, 38, 0.2);
                        }

                        .adda-add-btn:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.3);
                        }

                        .net-salary-section {
                            background: linear-gradient(135deg, #f0f9f4 0%, #e8f5e9 100%);
                            border: 2px solid #9dc183;
                            border-radius: 10px;
                            padding: 16px 20px;
                            margin-top: 20px;
                        }

                        .net-salary-row {
                            display: flex;
                            align-items: center;
                            gap: 16px;
                            margin-bottom: 14px;
                        }

                        .net-salary-label {
                            font-size: 14px;
                            font-weight: 700;
                            color: #1f2937;
                            flex: 0 0 120px;
                            display: flex;
                            align-items: center;
                            gap: 6px;
                        }

                        .net-salary-label i {
                            font-size: 15px;
                        }

                        .net-salary-input {
                            flex: 1;
                            font-size: 15px;
                            padding: 10px 14px;
                            border-radius: 8px;
                            border: 2px solid #9dc183;
                            background: #fff;
                            font-weight: 700;
                            color: #436026;
                            transition: all 0.2s;
                        }

                        .net-salary-input:focus {
                            outline: none;
                            border-color: #436026;
                            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.15);
                        }

                        .confirm-payroll-btn {
                            background: linear-gradient(135deg, #2d5f0e 0%, #5a7d35 100%);
                            color: #fff;
                            font-size: 14px;
                            font-weight: 700;
                            padding: 10px 24px;
                            border: none;
                            border-radius: 8px;
                            display: flex;
                            align-items: center;
                            gap: 8px;
                            cursor: pointer;
                            transition: all 0.3s;
                            box-shadow: 0 2px 8px rgba(67, 96, 38, 0.25);
                            margin-left: auto;
                        }

                        .confirm-payroll-btn:hover {
                            transform: translateY(-1px);
                            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.35);
                        }

                        .confirm-payroll-btn i {
                            font-size: 14px;
                        }

                        @media (max-width: 768px) {
                            .payroll-sections-grid {
                                grid-template-columns: 1fr;
                            }

                            .payroll-section-full > div > div[style*="grid-template-columns"] {
                                grid-template-columns: 1fr !important;
                            }

                            .form-row {
                                grid-template-columns: 1fr;
                                gap: 8px;
                            }

                            .form-label {
                                padding-top: 0;
                            }

                            .net-salary-row {
                                flex-direction: column;
                                align-items: stretch;
                            }

                            .net-salary-label {
                                flex: none;
                            }

                            .adda-df-row {
                                flex-wrap: wrap;
                            }

                            .adda-df-amount,
                            .adda-df-date {
                                min-width: calc(50% - 5px);
                            }
                        }
                    </style>
                    <div class="payroll-panel">
                        <form id="payrollForm">
                            <!-- Rider Information Section (Full Width) -->
                            <div class="payroll-sections-grid">
                                <div class="payroll-section payroll-section-full">
                                    <div class="payroll-section-title">
                                        <i class="fas fa-user-circle"></i>
                                        Rider Information
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">Rider ID:</label>
                                            <input type="text" name="rider_id" readonly class="form-input form-input-readonly-highlight">
                                        </div>
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">Rider Name:</label>
                                            <input type="text" name="rider_name" readonly class="form-input form-input-readonly-highlight">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Details Section (Full Width) -->
                            <div class="payroll-sections-grid">
                                <div class="payroll-section payroll-section-full">
                                    <div class="payroll-section-title">
                                        <i class="fas fa-credit-card"></i>
                                        Payment Details
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">Salary Schedule:</label>
                                            <select name="salary_schedule" class="form-input" onchange="handleSalaryScheduleChange()">
                                                <option value="" disabled selected hidden>Choose schedule...</option>
                                                <option value="Mon-Thur/Friday payout">Mon-Thur/Friday payout</option>
                                                <option value="Fri-Sun/Monday payout">Fri-Sun/Monday payout</option>
                                                <option value="Mon-Sun/Monday payout">Mon-Sun/Monday payout</option>
                                                <option value="Cut off payout">Cut off payout</option>
                                                <option value="Select Date">Select Date</option>
                                            </select>
                                        </div>
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">Mode of Payment:</label>
                                            <div style="display: flex; gap: 16px; margin-top: 8px;">
                                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                                    <input type="checkbox" name="payroll_mode_of_payment_checkbox" value="cash" class="payroll-payment-mode-checkbox" style="cursor: pointer;">
                                                    <span>Cash</span>
                                                </label>
                                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                                    <input type="checkbox" name="payroll_mode_of_payment_checkbox" value="bank" class="payroll-payment-mode-checkbox" style="cursor: pointer;">
                                                    <span>Bank Digital Wallet</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="customDateRange" style="display: none; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 16px;">
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">From Date:</label>
                                            <input type="date" name="custom_from_date" class="form-input">
                                        </div>
                                        <div class="form-row" style="margin-bottom: 0;">
                                            <label class="form-label">To Date:</label>
                                            <input type="date" name="custom_to_date" class="form-input">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Two Column Grid for Salary Components and ADDA DF -->
                            <div class="payroll-sections-grid">
                                <!-- Salary Components Section -->
                                <div class="payroll-section">
                                    <div class="payroll-section-title">
                                        <i class="fas fa-money-bill-wave"></i>
                                        Salary Components
                                    </div>
                                    <div class="form-row">
                                        <label class="form-label">Base Salary:</label>
                                        <input type="number" name="base_salary" class="form-input form-input-readonly-highlight" step="0.01"  readonly>
                                    </div>
                                    <div class="form-row">
                                        <label class="form-label">Incentives:</label>
                                        <input type="number" name="incentives" class="form-input" step="0.01" placeholder="Enter incentives">
                                    </div>
                                    <div class="form-row">
                                        <label class="form-label">26 Days Renumeration:</label>
                                        <input type="number" name="renumeration_26_days" class="form-input" step="0.01" placeholder="Enter 26 days renumeration">
                                    </div>
                                </div>

                                <!-- ADDA DF Section -->
                                <div class="payroll-section">
                                    <div class="payroll-section-title">
                                        <i class="fas fa-calendar-plus"></i>
                                        ADDA DF
                                    </div>
                                    <div class="form-row">
                                        <label class="form-label">ADDA DF:</label>
                                        <div class="adda-df-container">
                                            <div id="addaDfAllowedDaysNotice" style="display:none; margin-bottom:8px; padding:6px 10px; background:#fff3cd; border-left:3px solid #ffc107; font-size:12px; color:#856404; border-radius:4px;">
                                                <i class="fas fa-info-circle"></i> <span id="addaDfAllowedDaysText"></span>
                                            </div>
                                            <div id="addaDfRows">
                                            </div>
                                            <div class="adda-df-footer">
                                                <span id="addaDfSummary" class="adda-df-summary">Total ADDA DF: ₱0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="adda_df" value="">
                                    <input type="hidden" name="adda_df_date" value="">
                                    <input type="hidden" name="adda_df_entries" value="[]">
                                </div>
                            </div>

                            <!-- Net Salary Section -->
                            <div class="net-salary-section">
                                <div class="net-salary-row">
                                    <label class="net-salary-label">
                                        <i class="fas fa-calculator"></i>
                                        Net Salary:
                                    </label>
                                    <input type="number" name="net_salary" class="net-salary-input" step="0.01"  readonly>
                                </div>
                                <button type="button" id="payrollSubmitBtn" onclick="openPayrollDeductionsModal()" class="confirm-payroll-btn">
                                    <i class="fas fa-briefcase"></i> Confirm Payroll
                                </button>
                            </div>
                        </form>

                        {{-- Payroll Deductions Modal --}}
                        <div id="payrollDeductionsModal"
                            style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; align-items:center; justify-content:center;">
                            <div
                                style="background:#fff; border-radius:16px; padding:0; max-width:600px; width:96%; box-shadow:0 16px 60px rgba(0,0,0,0.25); overflow:hidden; max-height:92vh; display:flex; flex-direction:column;">

                                {{-- Header --}}
                                <div
                                    style="background:linear-gradient(135deg,#2d5f0e 0%,#5a7d35 100%); color:#fff; padding:20px 26px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                                    <div style="display:flex; align-items:center; gap:14px;">
                                        <div
                                            style="width:44px; height:44px; border-radius:12px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                        <div>
                                            <div style="font-size:17px; font-weight:800; letter-spacing:0.2px;">
                                                Deductions</div>
                                            <div
                                                style="font-size:12px; opacity:0.8; margin-top:2px; display:flex; align-items:center; gap:5px;">
                                                <i class="fas fa-user" style="font-size:10px;"></i>
                                                <span id="payrollDeductionRiderName" style="font-weight:600;"></span>
                                                <span style="opacity:0.6; margin:0 4px;">·</span>
                                                <span style="opacity:0.75;">Optional — leave empty to skip</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="closePayrollDeductionsModal()"
                                        style="background:rgba(255,255,255,0.18); border:none; color:#fff; width:34px; height:34px; border-radius:50%; font-size:20px; cursor:pointer; display:flex; align-items:center; justify-content:center; line-height:1; transition:background 0.2s;"
                                        onmouseover="this.style.background='rgba(255,255,255,0.3)'"
                                        onmouseout="this.style.background='rgba(255,255,255,0.18)'">&times;</button>
                                </div>

                                {{-- Column Headers --}}
                                <div
                                    style="display:grid; grid-template-columns:1fr 140px 36px; gap:8px; padding:10px 22px 6px; background:#f5f9f2; border-bottom:1px solid #e2ead9; flex-shrink:0;">
                                    <div
                                        style="font-size:11px; font-weight:700; color:#436026; text-transform:uppercase; letter-spacing:0.5px;">
                                        Description / Remarks</div>
                                    <div
                                        style="font-size:11px; font-weight:700; color:#436026; text-transform:uppercase; letter-spacing:0.5px;">
                                        Amount (₱)</div>
                                    <div></div>
                                </div>

                                {{-- Rows --}}
                                <div style="padding:14px 22px; overflow-y:auto; flex:1;">
                                    <div id="payrollDeductionRows"
                                        style="display:flex; flex-direction:column; gap:8px;">
                                        <div class="payroll-deduction-row"
                                            style="display:grid; grid-template-columns:1fr 140px 36px; gap:8px; align-items:center;">
                                            <input type="text" class="pd-remarks"
                                                placeholder="e.g. Cash shortage, Equipment damage..."
                                                style="width:100%; font-size:13px; padding:9px 12px; border-radius:8px; border:1.5px solid #d1d5db; background:#fff; box-sizing:border-box; transition:border-color 0.2s;"
                                                onfocus="this.style.borderColor='#436026'"
                                                onblur="this.style.borderColor='#d1d5db'">
                                            <input type="number" class="pd-amount" step="0.01" min="0.01"
                                                placeholder="0.00"
                                                style="width:100%; font-size:13px; padding:9px 12px; border-radius:8px; border:1.5px solid #d1d5db; background:#fff; box-sizing:border-box; transition:border-color 0.2s;"
                                                onfocus="this.style.borderColor='#436026'"
                                                onblur="this.style.borderColor='#d1d5db'"
                                                oninput="updatePayrollDeductionTotal()">
                                            <button type="button" class="pd-remove-btn"
                                                onclick="removePayrollDeductionRow(this)"
                                                style="display:none; width:36px; height:36px; background:#fee2e2; color:#dc3545; border:1.5px solid #fca5a5; border-radius:8px; font-size:14px; cursor:pointer; display:flex !important; align-items:center; justify-content:center; visibility:hidden;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="button" onclick="addPayrollDeductionRow()"
                                        style="margin-top:12px; background:#f0f7eb; color:#436026; border:1.5px dashed #aacb87; border-radius:8px; padding:9px 18px; font-size:12px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:7px; width:100%; justify-content:center; transition:background 0.2s;"
                                        onmouseover="this.style.background='#e3f0d8'"
                                        onmouseout="this.style.background='#f0f7eb'">
                                        <i class="fas fa-plus-circle"></i> Add Another Row
                                    </button>
                                </div>

                                {{-- Footer --}}
                                <div
                                    style="padding:14px 22px; background:#f9fafb; border-top:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-size:12px; color:#6c757d; font-weight:500;">Total
                                            Deductions:</span>
                                        <span id="payrollDeductionTotal"
                                            style="font-size:15px; font-weight:800; color:#dc3545;">₱0.00</span>
                                    </div>
                                    <div style="display:flex; gap:10px;">
                                        <button type="button" onclick="closePayrollDeductionsModal()"
                                            style="padding:10px 22px; border:1.5px solid #d1d5db; border-radius:8px; background:#fff; color:#6c757d; font-size:13px; font-weight:600; cursor:pointer; transition:all 0.2s;"
                                            onmouseover="this.style.borderColor='#9ca3af';this.style.color='#374151'"
                                            onmouseout="this.style.borderColor='#d1d5db';this.style.color='#6c757d'">
                                            Cancel
                                        </button>
                                        <button type="button" id="payrollDeductionConfirmBtn"
                                            onclick="submitPayrollWithDeductions()"
                                            style="padding:10px 24px; border:none; border-radius:8px; background:linear-gradient(135deg,#436026,#5a7d35); color:#fff; font-size:13px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:8px; box-shadow:0 2px 8px rgba(67,96,38,0.3); transition:opacity 0.2s;"
                                            onmouseover="this.style.opacity='0.9'"
                                            onmouseout="this.style.opacity='1'">
                                            <i class="fas fa-check"></i> Submit
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    const riderRemittanceDateMap = @json($riderRemittanceDateMap ?? []);
                    const riderTaskDeliveriesMap = @json($riderTaskDeliveriesMap ?? []);
                    const riderDeliveryChargesMap = @json($riderDeliveryChargesMap ?? []);
                    const riderTipsMap = @json($riderTipsMap ?? []);
                    const riderTotalCollectionMap = @json($riderTotalCollectionMap ?? []);
                    const riderRemittedTotalsMap = @json($remittedTotalsByRider ?? []);
                    const payrollRiderRemittancesCache = {};

                    function normalizeDateOnly(rawDate) {
                        if (!rawDate) return null;
                        const dateObj = new Date(rawDate);
                        if (Number.isNaN(dateObj.getTime())) return null;
                        return dateObj.toISOString().slice(0, 10);
                    }

                    function isDateInRange(dateYmd, fromYmd, toYmd) {
                        if (!dateYmd || !fromYmd || !toYmd) return false;
                        return dateYmd >= fromYmd && dateYmd <= toYmd;
                    }

                    function sumDeliveryFeeBySchedule(remittances, schedule) {
                        if (!schedule || !Array.isArray(remittances) || remittances.length === 0) return 0;

                        const range = getPayrollDateRange(schedule);
                        if (!Array.isArray(range) || range.length !== 2) return 0;

                        const [fromDate, toDate] = range;

                        return remittances.reduce((sum, remittance) => {
                            const rawDate = remittance.remittance_date || remittance.created_at;
                            const remittanceDate = normalizeDateOnly(rawDate);
                            if (!isDateInRange(remittanceDate, fromDate, toDate)) {
                                return sum;
                            }

                            return sum + (parseFloat(remittance.total_delivery_fee) || 0);
                        }, 0);
                    }

                    async function getPayrollRemittancesByRider(riderId) {
                        const riderKey = String(riderId || '').trim();
                        if (!riderKey) return [];

                        if (Array.isArray(payrollRiderRemittancesCache[riderKey])) {
                            return payrollRiderRemittancesCache[riderKey];
                        }

                        const response = await fetch(`/riders/${riderKey}/remittances`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();
                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Failed to load rider remittances');
                        }

                        payrollRiderRemittancesCache[riderKey] = Array.isArray(data.remittances) ? data.remittances : [];
                        return payrollRiderRemittancesCache[riderKey];
                    }

                    // Automatic Base Salary Calculation Function
                    function calculateAndPopulateBaseSalary(riderId) {
                        const payrollForm = document.getElementById('payrollForm');
                        if (!payrollForm) return;

                        // Get selected salary schedule
                        const salaryScheduleSelect = payrollForm.querySelector('[name="salary_schedule"]');
                        const selectedSchedule = salaryScheduleSelect ? salaryScheduleSelect.value : '';

                        const baseSalaryInput = payrollForm.querySelector('[name="base_salary"]');
                        if (!baseSalaryInput) return 0;

                        if (!selectedSchedule) {
                            baseSalaryInput.value = '';
                            baseSalaryInput.placeholder = 'Select salary schedule first';
                            return 0;
                        }

                        const riderKey = String(riderId || '').trim();

                        const applyBaseSalary = (amount) => {
                            const baseSalary = Number.isFinite(amount) ? amount : 0;
                            baseSalaryInput.value = baseSalary.toFixed(2);
                            baseSalaryInput.placeholder = `₱${baseSalary.toFixed(2)} (${selectedSchedule})`;
                            return baseSalary;
                        };

                        // Fast fallback while async weekly/schedule remittances are loading
                        const fallbackAmount = parseFloat(riderDeliveryChargesMap[riderKey] || 0);
                        applyBaseSalary(fallbackAmount);

                        getPayrollRemittancesByRider(riderKey)
                            .then(remittances => {
                                const latestSelectedRider = payrollForm.querySelector('[name="rider_id"]').value.trim();
                                const latestSelectedSchedule = salaryScheduleSelect ? salaryScheduleSelect.value : '';
                                if (latestSelectedRider !== riderKey || latestSelectedSchedule !== selectedSchedule) {
                                    return;
                                }

                                const scheduleAmount = sumDeliveryFeeBySchedule(remittances, selectedSchedule);
                                applyBaseSalary(scheduleAmount);
                                calculateAndPopulateNetSalary();
                            })
                            .catch(() => {
                                // Keep fallback amount if fetch fails.
                            });

                        calculateAndPopulateNetSalary();
                        return fallbackAmount;
                    }

                    function calculateAndPopulateNetSalary() {
                        const payrollForm = document.getElementById('payrollForm');
                        if (!payrollForm) return 0;

                        const baseSalary = parseFloat(payrollForm.querySelector('[name="base_salary"]')?.value) || 0;
                        const incentives = parseFloat(payrollForm.querySelector('[name="incentives"]')?.value) || 0;
                        const renumeration = parseFloat(payrollForm.querySelector('[name="renumeration_26_days"]')?.value) || 0;

                        const addaDfHidden = payrollForm.querySelector('[name="adda_df"]');
                        const addaDfCurrent = addaDfHidden && addaDfHidden.value !== ''
                            ? parseFloat(addaDfHidden.value) || 0
                            : 0;

                        const netSalary = baseSalary + incentives + renumeration + addaDfCurrent;
                        const netSalaryInput = payrollForm.querySelector('[name="net_salary"]');
                        if (netSalaryInput) {
                            netSalaryInput.value = netSalary > 0 ? netSalary.toFixed(2) : '';
                            netSalaryInput.placeholder = netSalary > 0
                                ? `₱${netSalary.toFixed(2)}`
                                : 'Auto-calculated net salary';
                        }

                        return netSalary;
                    }

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

                        // Close button handler
                        toast.querySelector('.toast-close').onclick = function() {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 300);
                        };
                        // Auto-dismiss
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 300);
                        }, duration);
                        container.appendChild(toast);
                    }

                    function addAddaDfRow() {
                        const rows = document.getElementById('addaDfRows');
                        if (!rows) return;

                        const row = document.createElement('div');
                        row.className = 'adda-df-row';
                        row.style.display = 'flex';
                        row.style.gap = '8px';
                        row.innerHTML = `
                                <input type="number" class="adda-df-amount" step="0.01" placeholder="Amount"
                                    style="flex: 1; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                <input type="date" class="adda-df-date"
                                    style="flex: 1; min-width: 160px; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                <button type="button" class="adda-df-remove" onclick="removeAddaDfRow(this)"
                                    style="background:#dc3545; color:#fff; border:none; border-radius:8px; padding:7px 12px; font-size:12px; font-weight:600; cursor:pointer; white-space:nowrap;">
                                    Remove
                                </button>
                            `;
                        rows.appendChild(row);
                        enforceAddaDfDateInputRules();
                        updateAddaDfRemoveButtons();
                        attachAddaDfAmountListeners();
                    }

                    function removeAddaDfRow(buttonEl) {
                        const row = buttonEl ? buttonEl.closest('.adda-df-row') : null;
                        if (!row) return;

                        const rows = document.querySelectorAll('#addaDfRows .adda-df-row');
                        if (rows.length <= 1) {
                            row.querySelector('.adda-df-amount').value = '';
                            row.querySelector('.adda-df-date').value = '';
                        } else {
                            row.remove();
                        }

                        updateAddaDfRemoveButtons();
                        consolidateAddaDfEntries(false);
                        attachAddaDfAmountListeners();
                    }

                    function updateAddaDfRemoveButtons() {
                        const rows = document.querySelectorAll('#addaDfRows .adda-df-row');
                        rows.forEach((row, idx) => {
                            const removeBtn = row.querySelector('.adda-df-remove');
                            if (!removeBtn) return;
                            removeBtn.style.display = rows.length > 1 ? '' : 'none';
                        });
                    }

                    function handleSalaryScheduleChange() {
                        const scheduleSelect = document.querySelector('[name="salary_schedule"]');
                        const customDateRange = document.getElementById('customDateRange');
                        const fromDateInput = document.querySelector('[name="custom_from_date"]');
                        const toDateInput = document.querySelector('[name="custom_to_date"]');
                        const allowedDaysNotice = document.getElementById('addaDfAllowedDaysNotice');
                        const allowedDaysText = document.getElementById('addaDfAllowedDaysText');
                        const payrollForm = document.getElementById('payrollForm');
                        
                        // Clear all ADDA DF inputs when schedule changes
                        const addaDfRows = document.getElementById('addaDfRows');
                        if (addaDfRows) {
                            addaDfRows.innerHTML = '';
                        }
                        
                        if (scheduleSelect.value === 'Select Date') {
                            customDateRange.style.display = 'grid';
                            if (fromDateInput) fromDateInput.required = true;
                            if (toDateInput) toDateInput.required = true;
                            if (allowedDaysNotice) {
                                allowedDaysNotice.style.display = 'none';
                            }
                            hideAddaDfDateSelector();
                        } else {
                            customDateRange.style.display = 'none';
                            if (fromDateInput) {
                                fromDateInput.required = false;
                                fromDateInput.value = '';
                            }
                            if (toDateInput) {
                                toDateInput.required = false;
                                toDateInput.value = '';
                            }
                            
                            // Get rider's available dates and filter by schedule
                            const riderId = payrollForm ? payrollForm.querySelector('[name="rider_id"]').value.trim() : '';
                            if (riderId && scheduleSelect.value) {
                                const availableDates = getFilteredRiderDates(riderId, scheduleSelect.value);
                                updateAddaDfDateNotice(availableDates, scheduleSelect.value, allowedDaysNotice, allowedDaysText);
                                
                                // Show dropdown with available dates
                                showAddaDfDateSelector(availableDates);
                                
                                // Recalculate base salary with the new schedule
                                calculateAndPopulateBaseSalary(riderId);
                            } else if (scheduleSelect.value && allowedDaysNotice && allowedDaysText) {
                                const noticeText = getAllowedDaysNoticeText(scheduleSelect.value);
                                if (noticeText) {
                                    allowedDaysText.textContent = noticeText;
                                    allowedDaysNotice.style.display = 'block';
                                } else {
                                    allowedDaysNotice.style.display = 'none';
                                }
                                hideAddaDfDateSelector();
                            }
                        }
                    }
                    
                    let availableAddaDfDates = [];
                    
                    function showAddaDfDateSelector(availableDates) {
                        availableAddaDfDates = availableDates || [];
                        
                        const container = document.getElementById('addaDfAllowedDaysNotice');
                        if (!container) return;
                        
                        const existingSelector = document.getElementById('addaDfDateSelectorDropdown');
                        if (existingSelector) {
                            existingSelector.remove();
                        }
                        
                        if (availableAddaDfDates.length === 0) {
                            return;
                        }
                        
                        // Create dropdown selector
                        const selectorDiv = document.createElement('div');
                        selectorDiv.id = 'addaDfDateSelectorDropdown';
                        selectorDiv.style.cssText = 'margin-top:8px; padding:10px; background:#e8f5e9; border-left:3px solid #4caf50; border-radius:4px;';
                        
                        const sortedDates = [...availableAddaDfDates].sort();
                        
                        selectorDiv.innerHTML = `
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                                <i class="fas fa-calendar-check" style="color:#2e7d32;"></i>
                                <span style="font-size:12px; color:#2e7d32; font-weight:600;">Select dates to add ADDA DF:</span>
                            </div>
                            <div style="display:flex; gap:8px; align-items:center;">
                                <select id="addaDfDateSelect" style="flex:1; padding:8px 12px; border:1px solid #4caf50; border-radius:6px; font-size:13px; background:#fff;">
                                    <option value="">Choose a date...</option>
                                    ${sortedDates.map(date => `<option value="${date}">${formatDateDisplay(date)}</option>`).join('')}
                                </select>
                                <button type="button" onclick="addSelectedAddaDfDate()" style="background:#4caf50; color:#fff; border:none; border-radius:6px; padding:8px 16px; font-size:13px; font-weight:600; cursor:pointer; white-space:nowrap;">
                                    <i class="fas fa-plus-circle"></i> Add Date
                                </button>
                            </div>
                        `;
                        
                        container.parentElement.insertBefore(selectorDiv, container.nextSibling);
                    }
                    
                    function hideAddaDfDateSelector() {
                        const existingSelector = document.getElementById('addaDfDateSelectorDropdown');
                        if (existingSelector) {
                            existingSelector.remove();
                        }
                        availableAddaDfDates = [];
                    }
                    
                    function formatDateDisplay(dateStr) {
                        const date = new Date(dateStr + 'T00:00:00');
                        const options = { year: 'numeric', month: 'short', day: 'numeric', weekday: 'short' };
                        return date.toLocaleDateString('en-US', options);
                    }
                    
                    function addSelectedAddaDfDate() {
                        const select = document.getElementById('addaDfDateSelect');
                        if (!select || !select.value) {
                            showToast('Please select a date first', 'warning');
                            return;
                        }
                        
                        const selectedDate = select.value;
                        
                        // Check if date is already added
                        const existingDates = Array.from(document.querySelectorAll('.adda-df-date')).map(input => input.value);
                        if (existingDates.includes(selectedDate)) {
                            showToast('This date is already added', 'warning');
                            return;
                        }
                        
                        const addaDfRows = document.getElementById('addaDfRows');
                        if (!addaDfRows) return;
                        
                        // Remove empty rows first
                        const emptyRows = Array.from(addaDfRows.querySelectorAll('.adda-df-row')).filter(row => {
                            const amount = row.querySelector('.adda-df-amount').value.trim();
                            const date = row.querySelector('.adda-df-date').value.trim();
                            return !amount && !date;
                        });
                        emptyRows.forEach(row => row.remove());
                        
                        // Add new row with selected date
                        const row = document.createElement('div');
                        row.className = 'adda-df-row';
                        row.style.cssText = 'display: flex; gap: 8px; align-items: center; margin-bottom: 6px;';
                        row.innerHTML = `
                            <input type="number" class="adda-df-amount" step="0.01" placeholder="Amount"
                                style="flex: 1; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                            <input type="date" class="adda-df-date" value="${selectedDate}" readonly
                                style="flex: 1; min-width: 160px; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #f5f5f5; cursor: not-allowed;">
                            <button type="button" class="adda-df-remove" onclick="removeAddaDfRow(this)"
                                style="background:#dc3545; color:#fff; border:none; border-radius:8px; padding:7px 12px; font-size:12px; font-weight:600; cursor:pointer; white-space:nowrap;">
                                Remove
                            </button>
                        `;
                        addaDfRows.appendChild(row);
                        
                        updateAddaDfRemoveButtons();
                        
                        // Reset dropdown
                        select.value = '';
                        
                        // Attach event listeners for automatic calculation
                        attachAddaDfAmountListeners();
                        
                        // Focus on the amount input of the new row
                        const amountInput = row.querySelector('.adda-df-amount');
                        if (amountInput) {
                            setTimeout(() => amountInput.focus(), 50);
                        }
                        
                        showToast('Date added. Enter the amount.', 'success');
                    }
                    
                    function autoPopulateAddaDfDates(availableDates) {
                        // This function is now replaced by showAddaDfDateSelector
                        // Keeping for backward compatibility
                        showAddaDfDateSelector(availableDates);
                    }
                    
                    function getFilteredRiderDates(riderId, schedule) {
                        const riderDates = riderRemittanceDateMap[String(riderId)] || [];
                        
                        // Filter dates based on salary schedule rules
                        return riderDates.filter(dateStr => {
                            return isAddaDfDateAllowedBySchedule(dateStr, schedule);
                        });
                    }

                    function getScheduleRangeLabel(schedule) {
                        if (!schedule || schedule === 'Select Date') return '';

                        const range = getPayrollDateRange(schedule);
                        if (!Array.isArray(range) || range.length !== 2) return '';

                        return `${range[0]} to ${range[1]}`;
                    }
                    
                    function updateAddaDfDateNotice(availableDates, schedule, noticeElement, textElement) {
                        if (!noticeElement || !textElement) return;
                        const rangeLabel = getScheduleRangeLabel(schedule);
                        
                        if (availableDates.length === 0) {
                            textElement.innerHTML = `<i class="fas fa-exclamation-triangle"></i> No remittance data available for this rider matching the selected schedule${rangeLabel ? ` (${rangeLabel})` : ''}`;
                            noticeElement.style.background = '#fff3cd';
                            noticeElement.style.borderLeftColor = '#ffc107';
                            noticeElement.style.color = '#856404';
                            noticeElement.style.display = 'block';
                        } else {
                            const scheduleRule = getAllowedDaysNoticeText(schedule);
                            const dateCount = availableDates.length;
                            textElement.innerHTML = `<i class="fas fa-check-circle"></i> ${scheduleRule}${rangeLabel ? ` (${rangeLabel})` : ''} — <span style="font-weight:700;color:#155724;">${dateCount} date${dateCount !== 1 ? 's' : ''} available</span> for ADDA DF`;
                            noticeElement.style.background = '#d1f2eb';
                            noticeElement.style.borderLeftColor = '#28a745';
                            noticeElement.style.color = '#155724';
                            noticeElement.style.display = 'block';
                        }
                    }
                    
                    function getAllowedDaysNoticeText(schedule) {
                        if (schedule === 'Mon-Thur/Friday payout') {
                            return 'You can only select Monday through Thursday within the schedule period';
                        }
                        if (schedule === 'Fri-Sun/Monday payout') {
                            return 'You can only select Friday, Saturday, or Sunday within the schedule period';
                        }
                        if (schedule === 'Mon-Sun/Monday payout') {
                            return 'You can select any day except Monday within the schedule period';
                        }
                        if (schedule === 'Cut off payout') {
                            return 'You can select any day except the 15th and last day within the cutoff period';
                        }
                        return '';
                    }

                    function getScheduleDateRuleText(schedule) {
                        if (schedule === 'Mon-Thur/Friday payout') {
                            return 'Only Monday through Thursday within the selected payroll week are allowed';
                        }
                        if (schedule === 'Fri-Sun/Monday payout') {
                            return 'Only Friday, Saturday, and Sunday within the selected payroll week are allowed';
                        }
                        if (schedule === 'Mon-Sun/Monday payout') {
                            return 'Any day except Monday within the selected payroll week is allowed';
                        }
                        if (schedule === 'Cut off payout') {
                            return 'Date must be inside the current cutoff period and cannot be the 15th or last day';
                        }
                        if (schedule === 'Select Date') {
                            return 'Date must be within the selected date range';
                        }
                        return 'Please select a valid date for this schedule';
                    }

                    function isAddaDfDateAllowedBySchedule(dateRaw, schedule) {
                        if (!dateRaw || !schedule) {
                            return false;
                        }

                        const selectedDate = new Date(dateRaw + 'T00:00:00');
                        const dayOfWeek = selectedDate.getDay(); // 0=Sun, 1=Mon, ..., 6=Sat

                        // For custom date selection, check if date is within range
                        if (schedule === 'Select Date') {
                            const fromDateInput = document.querySelector('[name="custom_from_date"]');
                            const toDateInput = document.querySelector('[name="custom_to_date"]');
                            if (!fromDateInput || !toDateInput || !fromDateInput.value || !toDateInput.value) {
                                return true; // Allow if dates not set yet
                            }
                            const fromDate = new Date(fromDateInput.value + 'T00:00:00');
                            const toDate = new Date(toDateInput.value + 'T00:00:00');
                            return selectedDate >= fromDate && selectedDate <= toDate;
                        }

                        // Weekly/cutoff schedules must also be inside the computed payroll date range.
                        const normalizedDate = normalizeDateOnly(dateRaw);
                        const scheduleRange = getPayrollDateRange(schedule);
                        if (!normalizedDate || !Array.isArray(scheduleRange) || scheduleRange.length !== 2) {
                            return false;
                        }

                        const [fromDate, toDate] = scheduleRange;
                        if (!isDateInRange(normalizedDate, fromDate, toDate)) {
                            return false;
                        }

                        // Mon-Thur/Friday payout: Work period is Mon-Thu, payout is Fri
                        // Only allow Monday (1) through Thursday (4)
                        if (schedule === 'Mon-Thur/Friday payout') {
                            return dayOfWeek >= 1 && dayOfWeek <= 4; // Mon-Thu only
                        }
                        
                        // Fri-Sun/Monday payout: Work period is Fri-Sun, payout is Mon
                        // Only allow Friday (5), Saturday (6), Sunday (0)
                        if (schedule === 'Fri-Sun/Monday payout') {
                            return dayOfWeek === 5 || dayOfWeek === 6 || dayOfWeek === 0; // Fri, Sat, Sun only
                        }
                        
                        // Mon-Sun/Monday payout: Work period is Mon-Sun, payout is following Mon
                        // Allow any day except Monday (1)
                        if (schedule === 'Mon-Sun/Monday payout') {
                            return dayOfWeek !== 1; // Any day except Monday
                        }
                        
                        // Cut off payout: Allow any day except 15th and last day of month
                        if (schedule === 'Cut off payout') {
                            const day = selectedDate.getDate();
                            const lastDayOfMonth = new Date(selectedDate.getFullYear(), selectedDate.getMonth() + 1, 0)
                                .getDate();
                            return day !== 15 && day !== lastDayOfMonth;
                        }
                        
                        return true;
                    }

                    function consolidateAddaDfEntries(showErrors = true) {
                        const form = document.getElementById('payrollForm');
                        if (!form) return false;

                        const salarySchedule = form.querySelector('[name="salary_schedule"]').value;
                        if (!salarySchedule) {
                            if (showErrors) showToast('Please select Salary Schedule first', 'warning');
                            return false;
                        }

                        const amountInputs = form.querySelectorAll('.adda-df-amount');
                        const dateInputs = form.querySelectorAll('.adda-df-date');

                        let total = 0;
                        let latestDate = '';
                        const entries = [];

                        for (let i = 0; i < amountInputs.length; i++) {
                            const amountRaw = (amountInputs[i].value || '').trim();
                            const dateRaw = (dateInputs[i].value || '').trim();

                            // Skip completely empty trailing rows.
                            if (!amountRaw && !dateRaw) {
                                continue;
                            }

                            if (!amountRaw) {
                                if (showErrors) showToast('Please enter ADDA DF amount for each filled date row', 'warning');
                                return false;
                            }
                            if (!dateRaw) {
                                if (showErrors) showToast('Please select ADDA DF date for each filled amount row', 'warning');
                                return false;
                            }

                            if (!isAddaDfDateAllowedBySchedule(dateRaw, salarySchedule)) {
                                if (showErrors) {
                                    showToast('ADDA DF date must match salary schedule: ' + getScheduleDateRuleText(salarySchedule),
                                        'warning');
                                }
                                return false;
                            }

                            const riderId = form.querySelector('[name="rider_id"]').value.trim();
                            const riderDates = riderRemittanceDateMap[String(riderId)] || [];
                            if (!riderDates.includes(dateRaw)) {
                                if (showErrors) showToast('Cannot add ADDA DF: no remittance record found for selected date',
                                    'warning');
                                return false;
                            }

                            const amountNum = parseFloat(amountRaw);
                            if (!amountNum || amountNum <= 0) {
                                if (showErrors) showToast('ADDA DF amount must be greater than 0', 'warning');
                                return false;
                            }

                            total += amountNum;
                            if (!latestDate || dateRaw > latestDate) {
                                latestDate = dateRaw;
                            }
                            entries.push({
                                amount: Number(amountNum.toFixed(2)),
                                date: dateRaw
                            });
                        }

                        // If no ADDA DF entries, set hidden fields to empty and allow form submission
                        if (total <= 0 || !latestDate) {
                            form.querySelector('[name="adda_df"]').value = '';
                            form.querySelector('[name="adda_df_date"]').value = '';
                            form.querySelector('[name="adda_df_entries"]').value = '[]';
                            const summary = document.getElementById('addaDfSummary');
                            if (summary) {
                                summary.textContent = 'Total ADDA DF: ₱0.00';
                            }
                            return true;
                        }

                        form.querySelector('[name="adda_df"]').value = total.toFixed(2);
                        form.querySelector('[name="adda_df_date"]').value = latestDate;
                        form.querySelector('[name="adda_df_entries"]').value = JSON.stringify(entries);

                        const summary = document.getElementById('addaDfSummary');
                        if (summary) {
                            summary.textContent = 'Total ADDA DF: ₱' + total.toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }

                        calculateAndPopulateNetSalary();

                        return true;
                    }

                    function applyAddaDf() {
                        // Function kept for backward compatibility but calculation is now automatic
                        const ok = consolidateAddaDfEntries(true);
                        if (!ok) {
                            return;
                        }
                        showToast('ADDA DF total calculated successfully', 'success');
                        updateAddaDfRemoveButtons();
                    }
                    
                    function attachAddaDfAmountListeners() {
                        // Attach input event listeners to all amount fields for automatic calculation
                        const amountInputs = document.querySelectorAll('.adda-df-amount');
                        amountInputs.forEach(input => {
                            // Remove existing listeners to avoid duplicates
                            input.removeEventListener('input', autoCalculateAddaDf);
                            input.addEventListener('input', autoCalculateAddaDf);
                        });
                    }
                    
                    function autoCalculateAddaDf() {
                        consolidateAddaDfEntries(false);
                        calculateAndPopulateNetSalary();
                    }

                    const payrollFormEl = document.getElementById('payrollForm');
                    const salaryScheduleEl = payrollFormEl ? payrollFormEl.querySelector('[name="salary_schedule"]') : null;

                    function enforceAddaDfDateInputRules() {
                        if (!payrollFormEl || !salaryScheduleEl) return;

                        const dateInputs = payrollFormEl.querySelectorAll('.adda-df-date');
                        dateInputs.forEach(input => {
                            if (!input || input.dataset.scheduleBound === '1') return;
                            input.dataset.scheduleBound = '1';

                            // Validate on change
                            input.addEventListener('change', function() {
                                const selectedSchedule = salaryScheduleEl.value;
                                if (!selectedSchedule || !this.value) return;

                                if (!isAddaDfDateAllowedBySchedule(this.value, selectedSchedule)) {
                                    this.value = '';
                                    showToast(
                                        'Invalid date! ' + getScheduleDateRuleText(selectedSchedule),
                                        'warning'
                                    );
                                    this.focus();
                                }
                            });
                            
                            // Also validate on input (for better UX)
                            input.addEventListener('input', function() {
                                const selectedSchedule = salaryScheduleEl.value;
                                if (!selectedSchedule || !this.value) return;
                                
                                // Only validate if a complete date is entered
                                if (this.value.length === 10) {
                                    if (!isAddaDfDateAllowedBySchedule(this.value, selectedSchedule)) {
                                        // Add visual indicator
                                        this.style.borderColor = '#dc3545';
                                        this.style.backgroundColor = '#fff5f5';
                                    } else {
                                        this.style.borderColor = '';
                                        this.style.backgroundColor = '';
                                    }
                                }
                            });
                        });
                    }

                    if (salaryScheduleEl) {
                        salaryScheduleEl.addEventListener('change', function() {
                            const dateInputs = payrollFormEl.querySelectorAll('.adda-df-date');
                            let clearedCount = 0;
                            dateInputs.forEach(input => {
                                if (input.value && !isAddaDfDateAllowedBySchedule(input.value, salaryScheduleEl
                                        .value)) {
                                    input.value = '';
                                    clearedCount++;
                                }
                            });

                            if (clearedCount > 0) {
                                showToast(
                                    'Some ADDA DF dates were cleared because they do not match the selected salary schedule.',
                                    'info');
                            }

                            calculateAndPopulateNetSalary();
                        });
                    }

                    const netSalaryLiveInputs = payrollFormEl
                        ? payrollFormEl.querySelectorAll('[name="base_salary"], [name="incentives"], [name="renumeration_26_days"]')
                        : [];
                    netSalaryLiveInputs.forEach(input => {
                        input.addEventListener('input', calculateAndPopulateNetSalary);
                        input.addEventListener('change', calculateAndPopulateNetSalary);
                    });

                    enforceAddaDfDateInputRules();

                    // Add event listeners for custom date range changes
                    const customFromDateInput = document.querySelector('[name="custom_from_date"]');
                    const customToDateInput = document.querySelector('[name="custom_to_date"]');
                    
                    if (customFromDateInput && customToDateInput) {
                        const validateCustomDates = () => {
                            if (!salaryScheduleEl || salaryScheduleEl.value !== 'Select Date') return;
                            if (!customFromDateInput.value || !customToDateInput.value) return;
                            
                            const dateInputs = payrollFormEl.querySelectorAll('.adda-df-date');
                            let clearedCount = 0;
                            dateInputs.forEach(input => {
                                if (input.value && !isAddaDfDateAllowedBySchedule(input.value, 'Select Date')) {
                                    input.value = '';
                                    clearedCount++;
                                }
                            });

                            if (clearedCount > 0) {
                                showToast(
                                    'Some ADDA DF dates were cleared because they are outside the selected date range.',
                                    'info');
                            }

                            const riderIdEl = payrollFormEl ? payrollFormEl.querySelector('[name="rider_id"]') : null;
                            const riderId = riderIdEl ? riderIdEl.value.trim() : '';
                            if (riderId) {
                                calculateAndPopulateBaseSalary(riderId);
                            }
                        };
                        
                        customFromDateInput.addEventListener('change', validateCustomDates);
                        customToDateInput.addEventListener('change', validateCustomDates);
                    }

                    function openPayrollDeductionsModal() {
                        const form = document.getElementById('payrollForm');

                        if (!consolidateAddaDfEntries(true)) return;

                        calculateAndPopulateNetSalary();

                        const riderId = form.querySelector('[name="rider_id"]').value.trim();
                        const riderName = form.querySelector('[name="rider_name"]').value.trim();
                        const baseSalary = form.querySelector('[name="base_salary"]').value;
                        const renumeration26Days = form.querySelector('[name="renumeration_26_days"]').value;
                        const salarySchedule = form.querySelector('[name="salary_schedule"]').value;
                        
                        // Get selected payroll payment modes
                        const selectedPayrollModes = Array.from(document.querySelectorAll('.payroll-payment-mode-checkbox:checked'))
                            .map(cb => cb.value);
                        
                        const netSalary = form.querySelector('[name="net_salary"]').value;

                        if (!riderId || !riderName) {
                            showToast('Please select a rider from the Rider Queue first', 'warning');
                            return;
                        }
                        if (!baseSalary) {
                            showToast('Please enter Base Salary', 'warning');
                            return;
                        }
                        if (!salarySchedule) {
                            showToast('Please select Salary Schedule', 'warning');
                            return;
                        }
                        if (salarySchedule === 'Select Date') {
                            const customFromDate = form.querySelector('[name="custom_from_date"]').value;
                            const customToDate = form.querySelector('[name="custom_to_date"]').value;
                            if (!customFromDate || !customToDate) {
                                showToast('Please enter both From Date and To Date', 'warning');
                                return;
                            }
                            if (customFromDate > customToDate) {
                                showToast('From Date cannot be later than To Date', 'warning');
                                return;
                            }
                        }
                        if (selectedPayrollModes.length === 0) {
                            showToast('Please select at least one Mode of Payment', 'warning');
                            return;
                        }
                        if (!netSalary) {
                            showToast('Please enter Net Salary', 'warning');
                            return;
                        }

                        // Store the selected modes in hidden fields for form submission
                        let payrollModeInput = form.querySelector('[name="selected_payroll_modes"]');
                        if (!payrollModeInput) {
                            payrollModeInput = document.createElement('input');
                            payrollModeInput.type = 'hidden';
                            payrollModeInput.name = 'selected_payroll_modes';
                            form.appendChild(payrollModeInput);
                        }
                        payrollModeInput.value = JSON.stringify(selectedPayrollModes);

                        // Also set payment_modes_json for backend consistency
                        let paymentModesJson = form.querySelector('[name="payment_modes_json"]');
                        if (!paymentModesJson) {
                            paymentModesJson = document.createElement('input');
                            paymentModesJson.type = 'hidden';
                            paymentModesJson.name = 'payment_modes_json';
                            form.appendChild(paymentModesJson);
                        }
                        paymentModesJson.value = JSON.stringify(selectedPayrollModes);

                        // Set the mode_of_payment field
                        let modeOfPaymentInput = form.querySelector('[name="mode_of_payment"]');
                        if (!modeOfPaymentInput) {
                            modeOfPaymentInput = document.createElement('input');
                            modeOfPaymentInput.type = 'hidden';
                            modeOfPaymentInput.name = 'mode_of_payment';
                            form.appendChild(modeOfPaymentInput);
                        }
                        modeOfPaymentInput.value = selectedPayrollModes.length === 1 ? selectedPayrollModes[0] : 'multiple';

                        // Set rider name in modal header
                        document.getElementById('payrollDeductionRiderName').textContent = riderName;

                        // Reset deduction rows to a single empty row
                        const rowsContainer = document.getElementById('payrollDeductionRows');
                        rowsContainer.innerHTML = buildDeductionRowHtml(false);
                        updatePayrollDeductionTotal();

                        // Reset confirm button
                        const confirmBtn = document.getElementById('payrollDeductionConfirmBtn');
                        confirmBtn.disabled = false;
                        confirmBtn.innerHTML = '<i class="fas fa-check"></i> Submit';

                        document.getElementById('payrollDeductionsModal').style.display = 'flex';
                        setTimeout(() => rowsContainer.querySelector('.pd-remarks') && rowsContainer.querySelector('.pd-remarks')
                            .focus(), 80);
                    }

                    function closePayrollDeductionsModal() {
                        document.getElementById('payrollDeductionsModal').style.display = 'none';
                    }

                    function buildDeductionRowHtml(showRemove) {
                        return `<div class="payroll-deduction-row" style="display:grid; grid-template-columns:1fr 140px 36px; gap:8px; align-items:center;">
                                <input type="text" class="pd-remarks" placeholder="e.g. Cash shortage, Equipment damage..."
                                    style="width:100%; font-size:13px; padding:9px 12px; border-radius:8px; border:1.5px solid #d1d5db; background:#fff; box-sizing:border-box; transition:border-color 0.2s;"
                                    onfocus="this.style.borderColor='#436026'" onblur="this.style.borderColor='#d1d5db'">
                                <input type="number" class="pd-amount" step="0.01" min="0.01" placeholder="0.00"
                                    style="width:100%; font-size:13px; padding:9px 12px; border-radius:8px; border:1.5px solid #d1d5db; background:#fff; box-sizing:border-box; transition:border-color 0.2s;"
                                    onfocus="this.style.borderColor='#436026'" onblur="this.style.borderColor='#d1d5db'"
                                    oninput="updatePayrollDeductionTotal()">
                                <button type="button" class="pd-remove-btn" onclick="removePayrollDeductionRow(this)"
                                    style="width:36px; height:36px; background:#fee2e2; color:#dc3545; border:1.5px solid #fca5a5; border-radius:8px; font-size:13px; cursor:pointer; display:flex; align-items:center; justify-content:center; visibility:${showRemove ? 'visible' : 'hidden'}; transition:background 0.2s;"
                                    onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>`;
                    }

                    function addPayrollDeductionRow() {
                        const container = document.getElementById('payrollDeductionRows');
                        container.insertAdjacentHTML('beforeend', buildDeductionRowHtml(true));
                        updatePayrollDeductionRemoveButtons();
                        container.lastElementChild.querySelector('.pd-remarks').focus();
                    }

                    function removePayrollDeductionRow(btn) {
                        const rows = document.querySelectorAll('#payrollDeductionRows .payroll-deduction-row');
                        if (rows.length <= 1) {
                            const row = btn.closest('.payroll-deduction-row');
                            row.querySelector('.pd-remarks').value = '';
                            row.querySelector('.pd-amount').value = '';
                        } else {
                            btn.closest('.payroll-deduction-row').remove();
                        }
                        updatePayrollDeductionRemoveButtons();
                        updatePayrollDeductionTotal();
                    }

                    function updatePayrollDeductionRemoveButtons() {
                        const rows = document.querySelectorAll('#payrollDeductionRows .payroll-deduction-row');
                        rows.forEach(row => {
                            const b = row.querySelector('.pd-remove-btn');
                            if (b) b.style.visibility = rows.length > 1 ? 'visible' : 'hidden';
                        });
                    }

                    function updatePayrollDeductionTotal() {
                        const inputs = document.querySelectorAll('#payrollDeductionRows .pd-amount');
                        let total = 0;
                        inputs.forEach(inp => {
                            const v = parseFloat(inp.value);
                            if (v > 0) total += v;
                        });
                        const el = document.getElementById('payrollDeductionTotal');
                        if (el) el.textContent = '₱' + total.toLocaleString('en-PH', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }

                    async function submitPayrollWithDeductions() {
                        // Gather deduction rows, skip completely empty ones
                        const rows = document.querySelectorAll('#payrollDeductionRows .payroll-deduction-row');
                        const deductions = [];
                        for (const row of rows) {
                            const remarks = (row.querySelector('.pd-remarks').value || '').trim();
                            const amountRaw = (row.querySelector('.pd-amount').value || '').trim();
                            if (!remarks && !amountRaw) continue;
                            if (remarks && !amountRaw) {
                                showToast('Please enter an amount for: ' + remarks, 'warning');
                                return;
                            }
                            if (!remarks && amountRaw) {
                                showToast('Please enter a description for amount: ' + amountRaw, 'warning');
                                return;
                            }
                            const amount = parseFloat(amountRaw);
                            if (amount <= 0) {
                                showToast('Deduction amount must be greater than 0', 'warning');
                                return;
                            }
                            deductions.push({
                                remarks,
                                amount
                            });
                        }

                        const confirmBtn = document.getElementById('payrollDeductionConfirmBtn');
                        confirmBtn.disabled = true;
                        confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

                        const form = document.getElementById('payrollForm');
                        const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const data = new FormData(form);
                        const salarySchedule = form.querySelector('[name="salary_schedule"]').value;
                        const riderId = form.querySelector('[name="rider_id"]').value.trim();
                        const riderName = form.querySelector('[name="rider_name"]').value.trim();

                        try {
                            // 1. Save payroll
                            const res = await fetch('/rider-payroll', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrf
                                },
                                body: data
                            });

                            if (!res.ok) {
                                let errorMsg = 'Failed to save payroll.';
                                try {
                                    const errorData = await res.json();
                                    if (errorData && errorData.message) errorMsg = errorData.message;
                                    else if (errorData && errorData.errors) {
                                        errorMsg = Object.keys(errorData.errors).map(f => f + ': ' + errorData.errors[f].join(', '))
                                            .join(' | ');
                                    }
                                } catch {}
                                showToast(errorMsg, 'error');
                                confirmBtn.disabled = false;
                                confirmBtn.innerHTML = '<i class="fas fa-check"></i> Submit';
                                return;
                            }

                            const responseData = await res.json();
                            const payrollId = responseData.payroll && responseData.payroll.id ? responseData.payroll.id : '';

                            // 2. Save deductions if any
                            if (deductions.length > 0) {
                                const today = new Date().toISOString().split('T')[0];
                                let dSaved = 0,
                                    dFailed = 0;
                                for (const d of deductions) {
                                    try {
                                        const fd = new FormData();
                                        fd.append('rider_id', riderId);
                                        fd.append('rider_name', riderName);
                                        fd.append('remarks', d.remarks);
                                        fd.append('amount', d.amount);
                                        fd.append('date', today);
                                        const dr = await fetch('/rider-deductions', {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': csrf
                                            },
                                            body: fd
                                        });
                                        dr.ok ? dSaved++ : dFailed++;
                                    } catch {
                                        dFailed++;
                                    }
                                }
                                if (dFailed > 0) {
                                    showToast(dSaved + ' deduction(s) saved, ' + dFailed + ' failed.', dSaved > 0 ? 'warning' :
                                        'error');
                                }
                            }

                            // 3. Close modal, reset form, open payslip
                            closePayrollDeductionsModal();
                            form.reset();
                            showToast('Payroll saved! Opening payslip...', 'success');

                            const [fromDate, toDate] = getPayrollDateRange(salarySchedule);
                            if (payrollId) {
                                let payslipUrl = '/rider-payroll/' + payrollId + '/payslip';
                                if (fromDate && toDate) payslipUrl += '?from_date=' + fromDate + '&to_date=' + toDate;
                                setTimeout(() => {
                                    window.open(payslipUrl, '_blank');
                                    window.location.reload();
                                }, 500);
                            } else {
                                setTimeout(() => window.location.reload(), 1500);
                            }

                        } catch (err) {
                            showToast('Network error: ' + err.message, 'error');
                            confirmBtn.disabled = false;
                            confirmBtn.innerHTML = '<i class="fas fa-check"></i> Submit';
                        }
                    }

                    /**
                     * Returns [fromDate, toDate] (YYYY-MM-DD strings) for a given salary schedule,
                     * relative to today.  Used to filter the remittances shown on the payslip.
                     */
                    function getPayrollDateRange(schedule) {
                        const statsDateInput = document.getElementById('statsDateInput');
                        const now = statsDateInput && statsDateInput.value
                            ? new Date(statsDateInput.value + 'T00:00:00')
                            : new Date();
                        const pad = n => String(n).padStart(2, '0');
                        const fmt = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;

                        // Handle custom date selection
                        if (schedule === 'Select Date') {
                            const form = document.getElementById('payrollForm');
                            const customFromDate = form ? form.querySelector('[name="custom_from_date"]').value : '';
                            const customToDate = form ? form.querySelector('[name="custom_to_date"]').value : '';
                            if (customFromDate && customToDate) {
                                return [customFromDate, customToDate];
                            }
                            // Fallback if dates aren't set
                            return [fmt(now), fmt(now)];
                        }

                        // Day-of-week: 0=Sun,1=Mon,...,6=Sat
                        const dow = now.getDay();

                        if (schedule === 'Mon-Thur/Friday payout') {
                            // Monday → Thursday of the current week
                            const monday = new Date(now);
                            monday.setDate(now.getDate() - (dow === 0 ? 6 : dow - 1));
                            const thursday = new Date(monday);
                            thursday.setDate(monday.getDate() + 3);
                            return [fmt(monday), fmt(thursday)];
                        }

                        if (schedule === 'Fri-Sun/Monday payout') {
                            // Friday → Sunday (look back to the most recent Friday)
                            const friday = new Date(now);
                            const daysToFriday = (dow + 2) % 7; // days since last Friday
                            friday.setDate(now.getDate() - daysToFriday);
                            const sunday = new Date(friday);
                            sunday.setDate(friday.getDate() + 2);
                            return [fmt(friday), fmt(sunday)];
                        }

                        if (schedule === 'Mon-Sun/Monday payout') {
                            // Monday → Sunday of the previous (just finished) week
                            const thisMonday = new Date(now);
                            thisMonday.setDate(now.getDate() - (dow === 0 ? 6 : dow - 1));
                            const prevMonday = new Date(thisMonday);
                            prevMonday.setDate(thisMonday.getDate() - 7);
                            const prevSunday = new Date(thisMonday);
                            prevSunday.setDate(thisMonday.getDate() - 1);
                            return [fmt(prevMonday), fmt(prevSunday)];
                        }

                        // "Cut off payout" — 1st–15th or 16th–end of current month
                        const day = now.getDate();
                        if (day <= 15) {
                            const start = new Date(now.getFullYear(), now.getMonth(), 1);
                            const end = new Date(now.getFullYear(), now.getMonth(), 15);
                            return [fmt(start), fmt(end)];
                        } else {
                            const start = new Date(now.getFullYear(), now.getMonth(), 16);
                            const end = new Date(now.getFullYear(), now.getMonth() + 1, 0);
                            return [fmt(start), fmt(end)];
                        }
                    }
                </script>
                <script>
                    // Tab switching functionality
                    document.querySelectorAll('.remit-tab-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            // Remove active from all
                            document.querySelectorAll('.remit-tab-btn').forEach(b => b.classList.remove('active'));
                            this.classList.add('active');
                            // Hide all tab contents
                            document.querySelectorAll('.remit-tab-content').forEach(tab => tab.style.display = 'none');
                            // Show selected
                            if (this.dataset.tab === 'overview') {
                                document.getElementById('tabOverview').style.display = '';
                            } else if (this.dataset.tab === 'payroll') {
                                document.getElementById('tabPayroll').style.display = '';
                            }
                        });
                    });
                </script>
            </div>
        </div>

        <!-- Records Tabs -->
        <style>
            .records-tabs {
                display: flex;
                gap: 0;
                margin-bottom: 0;
                margin-top: 20px;
                background: #f3f4f6;
                border-radius: 12px 12px 0 0;
                overflow: hidden;
                border: 1px solid #e5e7eb;
                border-bottom: none;
                padding: 6px 6px 0;
                gap: 2px;
            }

            .records-tab-btn {
                flex: 1;
                background: transparent;
                color: #6b7280;
                border: none;
                border-radius: 8px 8px 0 0;
                padding: 11px 16px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 7px;
                font-family: 'Inter', Arial, sans-serif;
                position: relative;
            }

            .records-tab-btn.active {
                background: #ffffff;
                color: #436026;
                font-weight: 700;
                box-shadow: 0 -1px 0 0 #e5e7eb inset, 1px 0 0 0 #e5e7eb inset, -1px 0 0 0 #e5e7eb inset;
            }

            .records-tab-btn.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 10%;
                right: 10%;
                height: 2.5px;
                background: #436026;
                border-radius: 2px 2px 0 0;
            }

            .records-tab-btn:hover:not(.active) {
                background: rgba(255, 255, 255, 0.6);
                color: #374151;
            }

            .records-tab-content {
                display: none;
            }

            .records-tab-content.active {
                display: block;
            }

            .records-table-title {
                font-size: 14px;
                font-weight: 700;
                color: #111827;
                padding: 0 0 12px 0;
                margin-bottom: 14px;
                display: flex;
                align-items: center;
                gap: 9px;
                border-bottom: 1px solid #f3f4f6;
            }

            .records-table-title i {
                color: #436026;
                font-size: 15px;
            }

            /* Toolbar */
            .records-toolbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 16px;
                background: #ffffff;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                margin-bottom: 16px;
                flex-wrap: wrap;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            }

            .records-toolbar-left {
                display: flex;
                align-items: center;
                gap: 0;
                flex-wrap: nowrap;
                background: #f3f4f6;
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 4px 6px;
                gap: 4px;
            }

            .records-toolbar-right {
                display: flex;
                align-items: center;
                gap: 8px;
                flex-shrink: 0;
            }

            .toolbar-filter-label {
                display: flex;
                align-items: center;
                gap: 5px;
                font-size: 11px;
                font-weight: 800;
                color: #436026;
                text-transform: uppercase;
                letter-spacing: 0.7px;
                white-space: nowrap;
                padding: 0 4px;
            }

            .toolbar-filter-label i {
                color: #436026;
                font-size: 12px;
            }

            .toolbar-date-input {
                padding: 6px 10px;
                border-radius: 7px;
                border: 1px solid transparent;
                font-size: 12.5px;
                background: #ffffff;
                color: #111827;
                font-weight: 600;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
                font-family: 'Inter', Arial, sans-serif;
                cursor: pointer;
                box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            }

            .toolbar-date-input:hover {
                border-color: #86b562;
                background: #f9fafb;
            }

            .toolbar-date-input:focus {
                border-color: #436026;
                box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.12);
                background: #fff;
            }

            .toolbar-sep {
                font-size: 11px;
                font-weight: 700;
                color: #6b7280;
                padding: 0 2px;
            }

            .toolbar-clear-btn {
                padding: 6px 13px;
                background: #fff0f0;
                border: 1px solid #fca5a5;
                border-radius: 8px;
                cursor: pointer;
                font-size: 12px;
                font-weight: 700;
                color: #dc2626;
                transition: all 0.2s ease;
                display: flex;
                align-items: center;
                gap: 5px;
                font-family: 'Inter', Arial, sans-serif;
                letter-spacing: 0.2px;
            }

            .toolbar-clear-btn:hover {
                background: #fef2f2;
                border-color: #dc2626;
                box-shadow: 0 2px 6px rgba(220, 38, 38, 0.15);
                transform: translateY(-1px);
            }

            .toolbar-clear-btn:active {
                transform: translateY(0);
            }

            .toolbar-search-wrap {
                position: relative;
                display: flex;
                align-items: center;
            }

            .toolbar-search-wrap i {
                position: absolute;
                left: 10px;
                color: #9ca3af;
                font-size: 13px;
                pointer-events: none;
            }

            .toolbar-search-input {
                padding: 7px 12px 7px 32px;
                border: 1px solid #e5e7eb;
                border-radius: 8px;
                font-size: 13px;
                background: #f9fafb;
                color: #374151;
                width: 220px;
                outline: none;
                transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
                font-family: 'Inter', Arial, sans-serif;
            }

            .toolbar-search-input:focus {
                border-color: #436026;
                box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
                background: #ffffff;
            }

            .toolbar-report-btn {
                display: flex;
                align-items: center;
                gap: 6px;
                padding: 7px 18px;
                background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
                color: #fff;
                border: none;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                white-space: nowrap;
                transition: all 0.2s ease;
                font-family: 'Inter', Arial, sans-serif;
                box-shadow: 0 2px 6px rgba(67, 96, 38, 0.25);
                letter-spacing: 0.1px;
            }

            .toolbar-report-btn:hover {
                background: linear-gradient(135deg, #4e7030 0%, #6a9040 100%);
                box-shadow: 0 4px 12px rgba(67, 96, 38, 0.35);
                transform: translateY(-1px);
            }

            .toolbar-report-btn:active {
                transform: translateY(0);
            }
        </style>

        <div class="records-tabs">
            <button class="records-tab-btn active" data-records-tab="remittances">
                <i class="fas fa-clipboard-check"></i> Cleared Riders History
            </button>
            <button class="records-tab-btn" data-records-tab="payroll">
                <i class="fas fa-money-check-alt"></i> Rider Payroll Records
            </button>
            <button class="records-tab-btn" data-records-tab="deductions">
                <i class="fas fa-minus-circle"></i> Rider Deductions Records
            </button>
        </div>

        <!-- Records Section -->
        <div class="cleared-riders-section">
            <div class="records-table-title" id="recordsTableTitle">
                <i class="fas fa-clipboard-check"></i>
                <span>Cleared Riders History</span>
            </div>

            <!-- Remittances Tab Content -->
            <div class="records-tab-content active" id="recordsTabRemittances">
                <div class="records-toolbar">
                    @if ($remittances->count() > 0)
                        <div class="records-toolbar-left">
                            <span class="toolbar-filter-label"><i class="fas fa-calendar-alt"></i> Filter:</span>
                            <input type="date" id="remittancesFromDate" class="toolbar-date-input"
                                onchange="filterRemittancesByDate()">
                            <span class="toolbar-sep">to</span>
                            <input type="date" id="remittancesToDate" class="toolbar-date-input"
                                onchange="filterRemittancesByDate()">
                            <button onclick="clearRemittancesDateFilter()" class="toolbar-clear-btn">
                                <i class="fas fa-times"></i> Clear
                            </button>
                            <select id="remittancesNameFilter" class="toolbar-date-input"
                                onchange="filterRemittancesByDate()" style="min-width:140px; cursor:pointer;">
                                <option value="">All Riders</option>
                                @foreach ($riders->sortBy('name') as $rider)
                                    <option value="{{ $rider->name }}">{{ $rider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="records-toolbar-right">
                            <div class="toolbar-search-wrap">
                                <i class="fas fa-search"></i>
                                <input type="text" id="clearedRiderSearch" class="toolbar-search-input"
                                    placeholder="Search remittances..." oninput="searchClearedRiders()">
                            </div>
                            <button onclick="openReportModal()" class="toolbar-report-btn">
                                <i class="fas fa-file-alt"></i> Generate Report
                            </button>
                        </div>
                    @endif
                </div>
                @if ($remittances->count() > 0)
                    <div id="remittancesTableContainer">
                        <table class="cleared-riders-table">
                            <thead>
                                <tr>
                                    <th>Rider Name</th>
                                    <th>Total Deliveries</th>
                                    <th>Delivery Fee</th>
                                    <th>Total Remit</th>
                                    <th>Tips</th>
                                    <th>Collection</th>
                                    <th>Payment Mode</th>
                                    <th>Status</th>
                                    <th>Date Submitted</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="remittancesTableBody">
                                @foreach ($remittances as $remittance)
                                    <tr>
                                        <td><strong>{{ $remittance->rider->name ?? 'N/A' }}</strong></td>
                                        <td style="text-align: center; font-weight: 600; color: #436026;">
                                            {{ $remittance->total_deliveries }}</td>
                                        <td style="text-align: right;">
                                            ₱{{ number_format($remittance->total_delivery_fee, 2) }}</td>
                                        <td style="text-align: right; font-weight: 600; color: #28a745;">
                                            ₱{{ number_format($remittance->total_remit, 2) }}</td>
                                        <td style="text-align: right;">
                                            ₱{{ number_format($remittance->total_tips ?? 0, 2) }}</td>
                                        <td style="text-align: right; font-weight: 600; color: #007bff;">
                                            ₱{{ number_format($remittance->total_collection, 2) }}</td>
                                        <td style="text-align: center;">
                                            @php
                                                $rawMode = trim((string) ($remittance->mode_of_payment ?? ''));
                                                $normalizeMode = function ($value) {
                                                    $mode = trim((string) $value);
                                                    $mode = (string) preg_replace('/^[\'\"]+|[\'\"]+$/', '', $mode);
                                                    return strtolower(trim($mode));
                                                };

                                                $modes = [];
                                                $decoded = json_decode($rawMode, true);
                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                    if (is_array($decoded)) {
                                                        $modes = $decoded;
                                                    } elseif (is_string($decoded)) {
                                                        $modes = [$decoded];
                                                    }
                                                }

                                                if (empty($modes)) {
                                                    if (preg_match('/^\[(.*)\]$/', $rawMode, $matches)) {
                                                        $parts = array_map('trim', explode(',', $matches[1]));
                                                        $modes = $parts;
                                                    } else {
                                                        $modes = [$rawMode];
                                                    }
                                                }

                                                if ($rawMode === 'multiple' && isset($remittance->attributes['payment_modes_json'])) {
                                                    $jsonModes = json_decode($remittance->attributes['payment_modes_json'], true);
                                                    if (is_array($jsonModes) && !empty($jsonModes)) {
                                                        $modes = $jsonModes;
                                                    }
                                                }

                                                $modes = array_values(array_filter(array_map($normalizeMode, $modes), fn($mode) => $mode !== ''));
                                                if (empty($modes)) {
                                                    $modes = ['unknown'];
                                                }
                                            @endphp
                                            @if (count($modes) > 1)
                                                <div style="display: flex; gap: 4px; flex-wrap: wrap; justify-content: center;">
                                                    @foreach ($modes as $mode)
                                                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; 
                                                            {{ $mode === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                            {{ strtoupper($mode) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; 
                                                    {{ ($modes[0] ?? '') === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                    {{ strtoupper($modes[0] ?? 'UNKNOWN') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">
                                            <span
                                                class="rider-status {{ $remittance->status === 'confirmed' ? 'cleared' : $remittance->status }}">
                                                {{ $remittance->status === 'confirmed' ? 'Cleared' : ucfirst($remittance->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $remittance->created_at->format('M d, Y') }}</td>
                                        <td style="max-width: 250px;">
                                            @if ($remittance->remarks)
                                                @php
                                                    $remarkLines = preg_split('/\s*\|\s*|\r\n|\r|\n/', (string) $remittance->remarks);
                                                    $remarkLines = array_values(array_filter(array_map('trim', $remarkLines), fn($line) => $line !== ''));
                                                @endphp
                                                <div style="display: grid; gap: 4px;">
                                                    @foreach ($remarkLines as $line)
                                                        <div style="display: block; white-space: normal; word-break: break-word; line-height: 1.35;">{{ $line }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span style="color: #999; font-style: italic;">No remarks</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div id="remittancesPaginationContainer"
                        style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 15px 0;">
                        <div style="color: #666; font-size: 14px;">
                            Showing {{ $remittances->firstItem() }} to {{ $remittances->lastItem() }} of
                            {{ $remittances->total() }} entries
                        </div>
                        <div style="display: flex; gap: 5px;">
                            @if ($remittances->onFirstPage())
                                <button disabled
                                    style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                            @else
                                <a href="{{ $remittances->previousPageUrl() }}&type=remittances"
                                    class="pagination-link-remittances"
                                    data-page="{{ $remittances->currentPage() - 1 }}"
                                    style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(67, 96, 38, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif

                            @foreach ($remittances->getUrlRange(1, $remittances->lastPage()) as $page => $url)
                                @if ($page == $remittances->currentPage())
                                    <button disabled
                                        style="padding: 8px 14px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: default; font-size: 13px; font-weight: 700; min-width: 40px;">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}&type=remittances"
                                        class="pagination-link-remittances" data-page="{{ $page }}"
                                        style="padding: 8px 14px; background: #f8f9fa; color: #436026; border: 1px solid #dee2e6; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; min-width: 40px; text-align: center; transition: all 0.2s;"
                                        onmouseover="this.style.background='#e9ecef'; this.style.borderColor='#436026'"
                                        onmouseout="this.style.background='#f8f9fa'; this.style.borderColor='#dee2e6'">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($remittances->hasMorePages())
                                <a href="{{ $remittances->nextPageUrl() }}&type=remittances"
                                    class="pagination-link-remittances"
                                    data-page="{{ $remittances->currentPage() + 1 }}"
                                    style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(67, 96, 38, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button disabled
                                    style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <script>
                        // AJAX Pagination for Remittances
                        document.addEventListener('click', function(e) {
                            if (e.target.closest('.pagination-link-remittances')) {
                                e.preventDefault();
                                const link = e.target.closest('.pagination-link-remittances');
                                const url = link.getAttribute('href');

                                // Show loading state
                                const tableBody = document.getElementById('remittancesTableBody');
                                const paginationContainer = document.getElementById('remittancesPaginationContainer');
                                tableBody.style.opacity = '0.5';
                                tableBody.style.pointerEvents = 'none';

                                // Fetch paginated data
                                fetch(url, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Update table rows
                                            tableBody.innerHTML = data.tableRows;

                                            // Update pagination
                                            paginationContainer.innerHTML = data.pagination;

                                            // Scroll to table top smoothly
                                            document.getElementById('remittancesTableContainer').scrollIntoView({
                                                behavior: 'smooth',
                                                block: 'start'
                                            });
                                        }

                                        // Remove loading state
                                        tableBody.style.opacity = '1';
                                        tableBody.style.pointerEvents = 'auto';
                                    })
                                    .catch(error => {
                                        console.error('Error loading page:', error);
                                        // Remove loading state
                                        tableBody.style.opacity = '1';
                                        tableBody.style.pointerEvents = 'auto';
                                    });
                            }

                            // AJAX Pagination for Payroll
                            if (e.target.closest('.pagination-link-payroll')) {
                                e.preventDefault();
                                const link = e.target.closest('.pagination-link-payroll');
                                const url = link.getAttribute('href');

                                // Show loading state
                                const tableBody = document.getElementById('payrollTableBody');
                                const paginationContainer = document.getElementById('payrollPaginationContainer');
                                tableBody.style.opacity = '0.5';
                                tableBody.style.pointerEvents = 'none';

                                // Fetch paginated data
                                fetch(url, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'Accept': 'application/json'
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            // Update table rows
                                            tableBody.innerHTML = data.tableRows;

                                            // Update pagination
                                            paginationContainer.innerHTML = data.pagination;

                                            // Scroll to table top smoothly
                                            document.getElementById('payrollTableContainer').scrollIntoView({
                                                behavior: 'smooth',
                                                block: 'start'
                                            });
                                        }

                                        // Remove loading state
                                        tableBody.style.opacity = '1';
                                        tableBody.style.pointerEvents = 'auto';
                                    })
                                    .catch(error => {
                                        console.error('Error loading page:', error);
                                        // Remove loading state
                                        tableBody.style.opacity = '1';
                                        tableBody.style.pointerEvents = 'auto';
                                    });
                            }
                        });
                    </script>
                @else
                    <div class="table-empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <p>No remittances submitted yet.</p>
                    </div>
                @endif
            </div>

            <!-- Payroll Tab Content -->
            <div class="records-tab-content" id="recordsTabPayroll">
                <div class="records-toolbar">
                    @if ($payrolls->count() > 0)
                        <div class="records-toolbar-left">
                            <span class="toolbar-filter-label"><i class="fas fa-calendar-alt"></i> Filter:</span>
                            <input type="date" id="payrollFromDate" class="toolbar-date-input"
                                onchange="filterPayrollByDate()">
                            <span class="toolbar-sep">to</span>
                            <input type="date" id="payrollToDate" class="toolbar-date-input"
                                onchange="filterPayrollByDate()">
                            <button onclick="clearPayrollDateFilter()" class="toolbar-clear-btn">
                                <i class="fas fa-times"></i> Clear
                            </button>
                            <select id="payrollNameFilter" class="toolbar-date-input"
                                onchange="filterPayrollByDate()" style="min-width:140px; cursor:pointer;">
                                <option value="">All Riders</option>
                                @foreach ($riders->sortBy('name') as $rider)
                                    <option value="{{ $rider->name }}">{{ $rider->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="records-toolbar-right">
                            <div class="toolbar-search-wrap">
                                <i class="fas fa-search"></i>
                                <input type="text" id="payrollSearch" class="toolbar-search-input"
                                    placeholder="Search payroll..." oninput="searchPayroll()">
                            </div>
                            <button onclick="openPayrollReportModal()" class="toolbar-report-btn">
                                <i class="fas fa-file-alt"></i> Generate Report
                            </button>
                        </div>
                    @endif
                </div>
                @if ($payrolls->count() > 0)
                    <div id="payrollTableContainer">
                        <table class="cleared-riders-table">
                            <thead>
                                <tr>
                                    <th>Rider ID</th>
                                    <th>Rider Name</th>
                                    <th>Base Salary</th>
                                    <th>Incentives</th>
                                    <th>26 Days Renumeration</th>
                                    <th>ADDA DF</th>
                                    <th>ADDA DF Date</th>
                                    <th>Net Salary</th>
                                    <th>Salary Schedule</th>
                                    <th>Payment Mode</th>
                                    <th>Date Created</th>
                                </tr>
                            </thead>
                            <tbody id="payrollTableBody">
                                @foreach ($payrolls as $payroll)
                                    <tr class="payroll-row">
                                        <td><strong>{{ $payroll->rider_id }}</strong></td>
                                        <td>{{ $payroll->rider_name }}</td>
                                        <td>₱{{ number_format($payroll->base_salary, 2) }}</td>
                                        <td>₱{{ number_format($payroll->incentives ?? 0, 2) }}</td>
                                        <td>₱{{ number_format($payroll->renumeration_26_days ?? 0, 2) }}</td>
                                        <td>₱{{ number_format($payroll->adda_df ?? 0, 2) }}</td>
                                        <td>{{ $payroll->adda_df_date ? \Carbon\Carbon::parse($payroll->adda_df_date)->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td><strong
                                                style="color: #436026;">₱{{ number_format($payroll->net_salary, 2) }}</strong>
                                        </td>
                                        <td>{{ $payroll->salary_schedule }}</td>
                                        <td>
                                            @php
                                                $rawMode = trim((string) ($payroll->mode_of_payment ?? ''));
                                                $normalizeMode = function ($value) {
                                                    $mode = trim((string) $value);
                                                    $mode = (string) preg_replace('/^[\'\"]+|[\'\"]+$/', '', $mode);
                                                    return strtolower(trim($mode));
                                                };

                                                $modes = [];
                                                $decoded = json_decode($rawMode, true);
                                                if (json_last_error() === JSON_ERROR_NONE) {
                                                    if (is_array($decoded)) {
                                                        $modes = $decoded;
                                                    } elseif (is_string($decoded)) {
                                                        $modes = [$decoded];
                                                    }
                                                }

                                                if (empty($modes)) {
                                                    if (preg_match('/^\[(.*)\]$/', $rawMode, $matches)) {
                                                        $parts = array_map('trim', explode(',', $matches[1]));
                                                        $modes = $parts;
                                                    } else {
                                                        $modes = [$rawMode];
                                                    }
                                                }

                                                if ($rawMode === 'multiple' && isset($payroll->attributes['payment_modes_json'])) {
                                                    $jsonModes = json_decode($payroll->attributes['payment_modes_json'], true);
                                                    if (is_array($jsonModes) && !empty($jsonModes)) {
                                                        $modes = $jsonModes;
                                                    }
                                                }

                                                $modes = array_values(array_filter(array_map($normalizeMode, $modes), fn($mode) => $mode !== ''));
                                                if (empty($modes)) {
                                                    $modes = ['unknown'];
                                                }
                                            @endphp
                                            @if (count($modes) > 1)
                                                <div style="display: flex; gap: 4px; flex-wrap: wrap;">
                                                    @foreach ($modes as $mode)
                                                        <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; 
                                                            {{ $mode === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                            {{ ucfirst($mode) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; 
                                                    {{ ($modes[0] ?? '') === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                    {{ ucfirst($modes[0] ?? 'Unknown') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>{{ $payroll->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <div id="payrollPaginationContainer"
                        style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding: 15px 0;">
                        <div style="color: #666; font-size: 14px;">
                            Showing {{ $payrolls->firstItem() }} to {{ $payrolls->lastItem() }} of
                            {{ $payrolls->total() }} entries
                        </div>
                        <div style="display: flex; gap: 5px;">
                            @if ($payrolls->onFirstPage())
                                <button disabled
                                    style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </button>
                            @else
                                <a href="{{ $payrolls->previousPageUrl() }}&type=payroll"
                                    class="pagination-link-payroll" data-page="{{ $payrolls->currentPage() - 1 }}"
                                    style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(67, 96, 38, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif

                            @foreach ($payrolls->getUrlRange(1, $payrolls->lastPage()) as $page => $url)
                                @if ($page == $payrolls->currentPage())
                                    <button disabled
                                        style="padding: 8px 14px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: default; font-size: 13px; font-weight: 700; min-width: 40px;">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}&type=payroll" class="pagination-link-payroll"
                                        data-page="{{ $page }}"
                                        style="padding: 8px 14px; background: #f8f9fa; color: #436026; border: 1px solid #dee2e6; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; min-width: 40px; text-align: center; transition: all 0.2s;"
                                        onmouseover="this.style.background='#e9ecef'; this.style.borderColor='#436026'"
                                        onmouseout="this.style.background='#f8f9fa'; this.style.borderColor='#dee2e6'">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($payrolls->hasMorePages())
                                <a href="{{ $payrolls->nextPageUrl() }}&type=payroll" class="pagination-link-payroll"
                                    data-page="{{ $payrolls->currentPage() + 1 }}"
                                    style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 8px rgba(67, 96, 38, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <button disabled
                                    style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="table-empty-state">
                        <i class="fas fa-money-check-alt"></i>
                        <p>No payroll records yet.</p>
                    </div>
                @endif
            </div>

            <!-- Deductions Tab Content -->
            <div class="records-tab-content" id="recordsTabDeductions">
                <div class="records-toolbar">
                    @if ($deductionsByRider->count() > 0)
                        <div class="records-toolbar-left">
                            <span class="toolbar-filter-label"><i class="fas fa-calendar-alt"></i> Filter:</span>
                            <input type="date" id="deductionsFromDate" class="toolbar-date-input"
                                onchange="filterDeductionsByDate()">
                            <span class="toolbar-sep">to</span>
                            <input type="date" id="deductionsToDate" class="toolbar-date-input"
                                onchange="filterDeductionsByDate()">
                            <button onclick="clearDeductionsDateFilter()" class="toolbar-clear-btn">
                                <i class="fas fa-times"></i> Clear
                            </button>
                            <select id="deductionsNameFilter" class="toolbar-date-input"
                                onchange="filterDeductionsByName()" style="min-width:140px; cursor:pointer;">
                                <option value="">All Riders</option>
                                @foreach ($deductionsByRider->sortBy('rider_name') as $dRow)
                                    <option value="{{ $dRow->rider_name }}">{{ $dRow->rider_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="records-toolbar-right">
                            <div class="toolbar-search-wrap">
                                <i class="fas fa-search"></i>
                                <input type="text" id="deductionsSearch" class="toolbar-search-input"
                                    placeholder="Search deductions..." oninput="searchDeductions()">
                            </div>
                            <button onclick="openDeductionsReportModal()" class="toolbar-report-btn">
                                <i class="fas fa-file-alt"></i> Generate Report
                            </button>
                        </div>
                    @endif
                </div>
                {{-- Embed all deductions as JSON for the modal --}}
                <script>
                    const allDeductionsFlatData = @json($allDeductionsFlat);
                </script>

                @if ($deductionsByRider->count())
                    <div id="deductionsTableContainer">
                        <table class="cleared-riders-table">
                            <thead>
                                <tr>
                                    <th>Rider ID</th>
                                    <th>Rider Name</th>
                                    <th>Total Deductions</th>
                                    <th style="text-align:center;">Count</th>
                                    <th style="text-align:center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="deductionsTableBody">
                                @foreach ($deductionsByRider as $row)
                                    <tr class="deduction-row">
                                        <td><strong>{{ $row->rider_id }}</strong></td>
                                        <td>{{ $row->rider_name }}</td>
                                        <td><strong style="color: #dc3545;">-
                                                ₱{{ number_format($row->total_amount, 2) }}</strong></td>
                                        <td style="text-align:center;">
                                            <span
                                                style="display:inline-block; background:#f5f9f2; color:#436026; border:1px solid #d6eacc; border-radius:10px; padding:2px 10px; font-size:12px; font-weight:700;">{{ $row->deduction_count }}
                                                item{{ $row->deduction_count > 1 ? 's' : '' }}</span>
                                        </td>
                                        <td style="text-align:center;">
                                            <button type="button"
                                                onclick="openDeductionViewModal('{{ $row->rider_id }}', '{{ addslashes($row->rider_name) }}')"
                                                style="background: linear-gradient(135deg, #436026 0%, #5a7d35 100%); color:#fff; border:none; border-radius:5px; padding:5px 14px; font-size:12px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:5px;"
                                                onmouseover="this.style.opacity='0.85'"
                                                onmouseout="this.style.opacity='1'">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="table-empty-state">
                        <i class="fas fa-minus-circle"></i>
                        <p>No deduction records yet.</p>
                    </div>
                @endif

                {{-- Deduction View Modal --}}
                <div id="deductionViewModal"
                    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;"
                    onclick="if(event.target===this) closeDeductionViewModal()">
                    <div
                        style="background:#fff; border-radius:12px; width:90%; max-width:640px; max-height:85vh; display:flex; flex-direction:column; box-shadow:0 8px 32px rgba(0,0,0,0.18); overflow:hidden;">
                        {{-- Header --}}
                        <div
                            style="background:linear-gradient(135deg,#436026 0%,#5a7d35 100%); color:#fff; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
                            <div>
                                <div
                                    style="font-size:11px; opacity:0.8; text-transform:uppercase; letter-spacing:0.5px;">
                                    Deduction History</div>
                                <div style="font-size:15px; font-weight:700;" id="deductionViewModalRiderName"></div>
                            </div>
                            <button onclick="closeDeductionViewModal()"
                                style="background:rgba(255,255,255,0.2); border:none; color:#fff; width:30px; height:30px; border-radius:50%; cursor:pointer; font-size:15px; display:flex; align-items:center; justify-content:center;">&times;</button>
                        </div>
                        {{-- Date filter bar --}}
                        <div
                            style="padding:12px 20px; background:#f5f9f2; border-bottom:1px solid #d6eacc; flex-shrink:0; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                            <span style="font-size:12px; font-weight:600; color:#436026; white-space:nowrap;"><i
                                    class="fas fa-calendar-alt"></i> Filter by date:</span>
                            <input type="date" id="deductionModalFromDate"
                                style="font-size:12px; padding:5px 8px; border:1px solid #d6eacc; border-radius:5px; background:#fff; color:#1a1a1a; outline:none;"
                                oninput="applyDeductionModalFilter()" onfocus="this.style.borderColor='#436026'"
                                onblur="this.style.borderColor='#d6eacc'">
                            <button onclick="clearDeductionModalFilter()"
                                style="font-size:12px; padding:5px 12px; background:#fff; color:#6c757d; border:1px solid #d1d5db; border-radius:5px; cursor:pointer;"
                                onmouseover="this.style.borderColor='#adb5bd'"
                                onmouseout="this.style.borderColor='#d1d5db'"><i class="fas fa-times"></i>
                                Clear</button>
                        </div>
                        {{-- Summary bar --}}
                        <div
                            style="padding:10px 20px; border-bottom:1px solid #e9ecef; flex-shrink:0; display:flex; align-items:center; justify-content:space-between;">
                            <div style="font-size:12px; color:#6c757d;" id="deductionViewModalCount"></div>
                            <div style="font-size:14px; font-weight:700; color:#dc3545;" id="deductionViewModalTotal">
                            </div>
                        </div>
                        {{-- Table --}}
                        <div style="overflow-y:auto; flex:1;">
                            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                                <thead style="position:sticky; top:0; background:#f5f9f2; z-index:1;">
                                    <tr style="border-bottom:2px solid #d6eacc;">
                                        <th
                                            style="padding:10px 14px; text-align:left; font-weight:600; color:#436026;">
                                            #</th>
                                        <th
                                            style="padding:10px 14px; text-align:left; font-weight:600; color:#436026;">
                                            Deduction</th>
                                        <th
                                            style="padding:10px 14px; text-align:right; font-weight:600; color:#436026;">
                                            Amount</th>
                                        <th
                                            style="padding:10px 14px; text-align:left; font-weight:600; color:#436026;">
                                            Date</th>
                                    </tr>
                                </thead>
                                <tbody id="deductionViewModalBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <script>
                    let _deductionModalRiderId = null;

                    function openDeductionViewModal(riderId, riderName) {
                        _deductionModalRiderId = riderId;
                        document.getElementById('deductionViewModalRiderName').textContent = riderName;
                        document.getElementById('deductionModalFromDate').value = '';
                        renderDeductionModalTable();
                        document.getElementById('deductionViewModal').style.display = 'flex';
                    }

                    function applyDeductionModalFilter() {
                        renderDeductionModalTable();
                    }

                    function clearDeductionModalFilter() {
                        document.getElementById('deductionModalFromDate').value = '';
                        renderDeductionModalTable();
                    }

                    function renderDeductionModalTable() {
                        const selectedDate = document.getElementById('deductionModalFromDate').value;
                        let items = allDeductionsFlatData.filter(d => String(d.rider_id) === String(_deductionModalRiderId));

                        if (selectedDate) items = items.filter(d => d.date === selectedDate);

                        let total = 0;
                        const tbody = document.getElementById('deductionViewModalBody');

                        if (!items.length) {
                            tbody.innerHTML =
                                `<tr><td colspan="4" style="padding:24px; text-align:center; color:#adb5bd; font-size:13px;"><i class="fas fa-search" style="display:block; font-size:22px; margin-bottom:8px;"></i>No deductions found for the selected date range.</td></tr>`;
                            document.getElementById('deductionViewModalTotal').textContent = 'Total: - ₱0.00';
                            document.getElementById('deductionViewModalCount').textContent = '0 records';
                            return;
                        }

                        tbody.innerHTML = items.map((d, i) => {
                            total += parseFloat(d.amount);
                            const date = new Date(d.date + 'T00:00:00').toLocaleDateString('en-US', {
                                month: 'short',
                                day: '2-digit',
                                year: 'numeric'
                            });
                            return `<tr style="border-bottom:1px solid #f0f0f0;">
                                <td style="padding:10px 14px; color:#6c757d;">${i+1}</td>
                                <td style="padding:10px 14px;">${d.remarks ?? 'N/A'}</td>
                                <td style="padding:10px 14px; text-align:right; color:#dc3545; font-weight:600;">- ₱${parseFloat(d.amount).toFixed(2)}</td>
                                <td style="padding:10px 14px; color:#6c757d; white-space:nowrap;">${date}</td>
                            </tr>`;
                        }).join('');

                        document.getElementById('deductionViewModalTotal').textContent = 'Total: - ₱' + total.toFixed(2);
                        document.getElementById('deductionViewModalCount').textContent = items.length + ' record' + (items.length !==
                            1 ? 's' : '');
                    }

                    function closeDeductionViewModal() {
                        document.getElementById('deductionViewModal').style.display = 'none';
                        _deductionModalRiderId = null;
                    }
                </script>
            </div>

            <script>
                // Records tab switching functionality
                document.querySelectorAll('.records-tab-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Remove active from all tabs
                        document.querySelectorAll('.records-tab-btn').forEach(b => b.classList.remove('active'));
                        document.querySelectorAll('.records-tab-content').forEach(content => content.classList
                            .remove('active'));

                        // Add active to clicked tab
                        this.classList.add('active');

                        // Update table title
                        const titleElement = document.getElementById('recordsTableTitle');
                        const tab = this.getAttribute('data-records-tab');

                        // Show corresponding content and update title
                        if (tab === 'remittances') {
                            document.getElementById('recordsTabRemittances').classList.add('active');
                            titleElement.innerHTML =
                                '<i class="fas fa-clipboard-check"></i><span>Cleared Riders History</span>';
                        } else if (tab === 'payroll') {
                            document.getElementById('recordsTabPayroll').classList.add('active');
                            titleElement.innerHTML =
                                '<i class="fas fa-money-check-alt"></i><span>Rider Payroll Records</span>';
                        } else if (tab === 'deductions') {
                            document.getElementById('recordsTabDeductions').classList.add('active');
                            titleElement.innerHTML =
                                '<i class="fas fa-minus-circle"></i><span>Rider Deductions Records</span>';
                        }
                    });
                });
            </script>
        </div>
    </div>

    <!-- Remit Modal -->
    <div class="modal-overlay" id="remitModal">
        <div class="modal-content"
            style="max-width: 640px; max-height: 92vh; display: flex; flex-direction: column; overflow: hidden;">
            <div class="modal-header">
                <h3><i class="fas fa-money-bill-wave"></i> Remittance Form</h3>
            </div>
            <div class="modal-body" style="overflow-y: auto; flex: 1; padding: 20px 25px;">
                <form id="remitForm" enctype="multipart/form-data">
                    <input type="hidden" id="remitRiderId" name="rider_id">
                    <input type="hidden" id="remitRiderName" name="rider_name">

                    <div class="form-group">
                        <label><i class="fas fa-user"></i> Rider Name</label>
                        <input type="text" id="displayRiderName" readonly
                            style="background: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalDeliveries"><i class="fas fa-box"></i> Total Deliveries</label>
                            <input type="number" id="totalDeliveries" name="total_deliveries" placeholder="0"
                                min="0" readonly style="background: #f0f9f4; color: #2d4016; font-weight: 600; cursor: not-allowed; border-color: #9dc183;" required>
                            <small id="totalDeliveriesHint" style="color: #6c757d; font-size: 12px; display: block; margin-top: 5px;">
                                Based on tasks for selected date.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="totalDeliveryFee"><i class="fas fa-dollar-sign"></i> Total Delivery
                                Fee</label>
                            <input type="number" id="totalDeliveryFee" name="total_delivery_fee" placeholder="0.00"
                                step="0.01" min="0" readonly style="background: #f0f9f4; color: #2d4016; font-weight: 600; cursor: not-allowed; border-color: #9dc183;" required>
                            <small id="totalDeliveryFeeHint" style="color: #6c757d; font-size: 12px; display: block; margin-top: 5px;">
                                Based on delivery charges for selected date.
                            </small>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalCollection"><i class="fas fa-wallet"></i> Total Amount</label>
                            <input type="number" id="totalCollection" name="total_collection" placeholder="0.00"
                                step="0.01" min="0" readonly style="background: #f0f9f4; color: #2d4016; font-weight: 600; cursor: not-allowed; border-color: #9dc183;" required>
                            <small id="totalCollectionHint" style="color: #6c757d; font-size: 12px; display: block; margin-top: 5px;">
                                Based on total_w_tax for selected date.
                            </small>
                        </div>
                        <div class="form-group">
                            <label for="totalTips"><i class="fas fa-hand-holding-usd"></i> Total Tips</label>
                            <input type="number" id="totalTips" name="total_tips" placeholder="0.00"
                                step="0.01" min="0" readonly style="background: #f0f9f4; color: #2d4016; font-weight: 600; cursor: not-allowed; border-color: #9dc183;">
                            <small id="totalTipsHint" style="color: #6c757d; font-size: 12px; display: block; margin-top: 5px;">
                                Based on order tips for selected date.
                            </small>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalRemit"><i class="fas fa-money-check"></i> Total Remit</label>
                            <input type="number" id="totalRemit" name="total_remit" placeholder="0.00"
                                step="0.01" min="0" required>
                            <small id="remainingRemitHint" style="display:none; margin-top: 5px; font-size: 12px; font-weight: 600;"></small>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-credit-card"></i> Mode of Payment</label>
                            <div id="paymentModesContainer" style="display: flex; align-items: center; gap: 16px; margin-top: 0; min-height: 40px; padding: 0 12px; border: 1.5px solid #d6eacc; border-radius: 8px; background: #fff;">
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0;">
                                    <input type="checkbox" name="mode_of_payment_checkbox" value="cash" class="payment-mode-checkbox" style="cursor: pointer;">
                                    <span>Cash</span>
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; margin: 0;">
                                    <input type="checkbox" name="mode_of_payment_checkbox" value="gcash" class="payment-mode-checkbox" style="cursor: pointer;">
                                    <span>GCash</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Breakdown by Mode -->
                    <div id="paymentBreakdownSection" style="display: none; margin-bottom: 20px; padding: 16px; background: #f8faf7; border: 1.5px solid #d6eacc; border-radius: 10px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 12px; color: #2d4016;">
                            <i class="fas fa-list"></i> Payment Breakdown
                        </label>
                        <div id="paymentBreakdownFields" style="display: grid; gap: 12px;"></div>
                        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #d6eacc;">
                            <div style="display: grid; grid-template-columns: 1fr 150px; gap: 12px; align-items: center;">
                                <label style="font-weight: 600; color: #2d4016;">Total Remit:</label>
                                <input type="text" id="totalPaymentDisplay" readonly style="background: #e8f5e0; border: 1.5px solid #9dc183; color: #2d4016; font-weight: 600; padding: 8px 12px; border-radius: 6px;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-comment"></i> Remarks (optional)</label>
                        <div id="remitRemarksRows" style="display: grid; gap: 10px;">
                            <div class="remit-remark-row" style="display: grid; grid-template-columns: minmax(0, 1fr) 150px 40px; gap: 10px; align-items: start;">
                                <textarea class="remit-remarks-input" placeholder="Enter any remarks here" rows="3"
                                    style="width: 100%; background: #f8f9fa; border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px; resize: vertical;"></textarea>
                                <div style="display: flex; flex-direction: column; align-self: start;">
                                    <label style="display: block; margin-bottom: 6px; font-size: 12px; color: #666; font-weight: 600; line-height: 1.2;">Amount</label>
                                    <input type="number" class="remit-remarks-amount" placeholder="0.00"
                                        step="0.01" min="0"
                                        style="width: 100%; padding: 10px; background: #f8f9fa; border-radius: 8px; border: 1px solid #e0e0e0; font-size: 14px; box-sizing: border-box;">
                                </div>
                                <button type="button" class="remit-remark-remove" onclick="removeRemitRemarkRow(this)"
                                    style="height: 40px; width: 40px; margin-top: 24px; border: 1px solid #f5c2c7; background: #f8d7da; color: #842029; border-radius: 8px; cursor: pointer; visibility: hidden;"
                                    title="Remove row">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <button type="button" onclick="addRemitRemarkRow()"
                                style="padding: 8px 12px; border: 1px solid #9dc183; background: #f0f9f4; color: #2d4016; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-plus"></i> Add another remark
                            </button>
                        </div>
                        <input type="hidden" id="consolidatedRemarks" name="remarks" value="">
                        <input type="hidden" id="consolidatedRemarksAmount" name="remarks_amount" value="">
                    </div>

                    {{-- ── Mangan App Section ── --}}
                    <div
                        style="margin-bottom: 16px; border: 2px solid #e5e7eb; border-radius: 10px; overflow: hidden;">
                        {{-- Toggle Button --}}
                        <button type="button" onclick="toggleManganSection()" id="addManganBtn"
                            style="width: 100%; display: flex; align-items: center; justify-content: space-between; padding: 11px 16px; background: linear-gradient(135deg, #f0f7ed 0%, #e6f3df 100%); border: none; cursor: pointer; font-family: 'Inter', Arial, sans-serif; color: #2d4016; font-size: 14px; font-weight: 700; transition: background 0.2s;"
                            onmouseover="this.style.background='linear-gradient(135deg, #e6f3df 0%, #d9ecce 100%)'"
                            onmouseout="this.style.background='linear-gradient(135deg, #f0f7ed 0%, #e6f3df 100%)'">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <span
                                    style="width: 26px; height: 26px; border-radius: 7px; background: #436026; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">
                                    <i class="fas fa-utensils"></i>
                                </span>
                                Add Mangan
                                <span id="manganBadge"
                                    style="display: none; background: #436026; color: #fff; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 10px; letter-spacing: 0.3px;"></span>
                            </div>
                            <i id="manganChevron" class="fas fa-chevron-down"
                                style="color: #436026; font-size: 12px; transition: transform 0.25s;"></i>
                        </button>

                        {{-- Inline Mangan Form --}}
                        <div id="manganInlineForm"
                            style="display: none; padding: 16px; background: #fafdf8; border-top: 1px solid #d6eacc;">

                            {{-- Rider name --}}
                            <div class="form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px;"><i class="fas fa-user"></i> Rider Name</label>
                                <input type="text" id="manganRiderNameDisplay" readonly
                                    style="width: 100%; background: #f1f5f0; cursor: not-allowed; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; color: #436026; font-weight: 600; box-sizing: border-box;">
                            </div>

                            {{-- Merchant Name --}}
                            <div class="form-group" style="margin-bottom: 14px; position: relative;">
                                <label style="font-size: 13px;"><i class="fas fa-store"></i> Merchant Name</label>
                                <input type="text" id="manganMerchantInput" placeholder="Search merchant name..."
                                    autocomplete="off" oninput="filterManganMerchants(this.value)"
                                    onkeydown="manganMerchantKeydown(event)"
                                    style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                    onfocus="this.style.borderColor='#436026'; filterManganMerchants(this.value)"
                                    onblur="setTimeout(hideManganDropdown, 150)">
                                <div id="manganMerchantDropdown"
                                    style="display:none; position:absolute; top:100%; left:0; right:0; background:#fff; border:2px solid #86b562; border-radius:8px; max-height:180px; overflow-y:auto; z-index:9999; box-shadow:0 4px 12px rgba(0,0,0,0.12); margin-top:2px;">
                                </div>
                            </div>



                            {{-- Amount + DF --}}
                            <div
                                style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 13px;"><i class="fas fa-peso-sign"></i> Total
                                        Amount</label>
                                    <input type="number" id="manganTotalAmount" placeholder="0.00" min="0"
                                        step="0.01"
                                        style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#436026'"
                                        onblur="this.style.borderColor='#e9ecef'">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 13px;"><i class="fas fa-truck"></i> DF <span
                                            style="font-weight:400; color:#6c757d;">(Delivery Fee)</span></label>
                                    <input type="number" id="manganDf" placeholder="0.00" min="0"
                                        step="0.01"
                                        style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#436026'"
                                        onblur="this.style.borderColor='#e9ecef'">
                                </div>
                            </div>

                            {{-- GT + Tips --}}
                            <div
                                style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 14px;">
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 13px;"><i class="fas fa-calculator"></i> GT <span
                                            style="font-weight:400; color:#6c757d;">(Good Taste/Grumpy)</span></label>
                                    <input type="number" id="manganGt" placeholder="0.00" min="0"
                                        step="0.01"
                                        style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#436026'"
                                        onblur="this.style.borderColor='#e9ecef'">
                                </div>
                                <div class="form-group" style="margin-bottom: 0;">
                                    <label style="font-size: 13px;"><i class="fas fa-hand-holding-usd"></i> Tips <span
                                            style="font-weight:400; color:#6c757d;">(Mangan)</span></label>
                                    <input type="number" id="manganTips" placeholder="0.00" min="0"
                                        step="0.01"
                                        style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#436026'"
                                        onblur="this.style.borderColor='#e9ecef'">
                                </div>
                            </div>

                            {{-- Receipt Non-Partners --}}
                            <div class="form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px;"><i class="fas fa-receipt"></i> Receipt <span
                                        style="font-weight:400; color:#6c757d;">(Non-Partners)</span></label>
                                <input type="number" id="manganReceiptNonPartners" placeholder="0.00"
                                    min="0" step="0.01"
                                    style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                    onfocus="this.style.borderColor='#436026'"
                                    onblur="this.style.borderColor='#e9ecef'">
                            </div>

                            {{-- Total Remit --}}
                            <div class="form-group" style="margin-bottom: 14px;">
                                <label style="font-size: 13px;"><i class="fas fa-coins"></i> Total Remit</label>
                                <input type="number" id="manganTotalRemit" placeholder="0.00"
                                    min="0" step="0.01"
                                    style="width: 100%; padding: 9px 14px; border: 2px solid #e9ecef; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;"
                                    onfocus="this.style.borderColor='#436026'"
                                    onblur="this.style.borderColor='#e9ecef'">
                            </div>

                            {{-- Add Entry Button --}}
                            <div style="display: flex; justify-content: flex-end; padding-top: 4px;">
                                <button type="button" onclick="addManganEntry()"
                                    style="display: flex; align-items: center; gap: 8px; padding: 9px 22px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; box-shadow: 0 2px 8px rgba(67,96,38,0.25); transition: all 0.2s; font-family: 'Inter', Arial, sans-serif;"
                                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 14px rgba(67,96,38,0.35)'"
                                    onmouseout="this.style.transform=''; this.style.boxShadow='0 2px 8px rgba(67,96,38,0.25)'">
                                    <i class="fas fa-plus-circle"></i> Add Entry
                                </button>
                            </div>

                            {{-- Saved Entries List --}}
                            <div id="manganEntriesList"
                                style="display: none; margin-top: 14px; flex-direction: column; gap: 8px;"></div>
                        </div>
                        <input type="hidden" id="manganEntriesJson" name="mangan_entries">
                    </div>
                    {{-- End Mangan App Section --}}

                    <div class="form-group">
                        <label for="remitPhoto"><i class="fas fa-camera"></i> Attach Remit Photo</label>
                        <input type="file" id="remitPhoto" name="remit_photo" accept="image/*"
                            style="padding: 8px; border: 2px dashed #436026; background: #f8f9fa;">
                        <small style="color: #6c757d; font-size: 12px; display: block; margin-top: 5px;">
                            <i class="fas fa-info-circle"></i> Upload proof of remittance (optional)
                        </small>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel" onclick="closeRemitModal()">Cancel</button>
                <button class="modal-btn submit" onclick="submitRemit()"><i class="fas fa-paper-plane"></i>
                    Submit</button>
            </div>
        </div>
    </div>

    <script>
        // Merchant list for Mangan App search (from mt_merchant restaurant_name)
        const manganMerchants = @json($merchants->values());

        let manganDropdownIndex = -1;

        function filterManganMerchants(query) {
            const dropdown = document.getElementById('manganMerchantDropdown');
            const q = query.trim().toLowerCase();
            updateManganBadge();
            if (!q) {
                const defaultMatches = manganMerchants.slice(0, 20);
                manganDropdownIndex = -1;
                dropdown.innerHTML = defaultMatches.map((merchant, i) => {
                    const merchantName = String(merchant.name ?? merchant.restaurant_name ?? '');
                    const safeName = merchantName.replace(/'/g, "\\'");

                    return `<div data-index="${i}" onclick="selectManganMerchant('${safeName}')"
                        style="padding:9px 14px; font-size:14px; cursor:pointer; color:#2d4016; border-bottom:1px solid #f0f7ed;"
                        onmouseover="this.style.background='#f0f7ed'" onmouseout="this.style.background=''">` +
                        `<i class="fas fa-store" style="margin-right:8px; color:#86b562; font-size:12px;"></i>${merchantName}</div>`;
                }).join('');
                dropdown.style.display = defaultMatches.length ? 'block' : 'none';
                return;
            }

            const matches = manganMerchants.filter(merchant => {
                const merchantName = String(merchant.name ?? merchant.restaurant_name ?? '').toLowerCase();
                return merchantName.includes(q);
            }).slice(0, 20);

            if (matches.length === 0) {
                hideManganDropdown();
                return;
            }
            manganDropdownIndex = -1;
            dropdown.innerHTML = matches.map((merchant, i) => {
                const merchantName = String(merchant.name ?? merchant.restaurant_name ?? '');
                const safeName = merchantName.replace(/'/g, "\\'");

                return `<div data-index="${i}" onclick="selectManganMerchant('${safeName}')"
                    style="padding:9px 14px; font-size:14px; cursor:pointer; color:#2d4016; border-bottom:1px solid #f0f7ed;"
                    onmouseover="this.style.background='#f0f7ed'" onmouseout="this.style.background=''">` +
                `<i class="fas fa-store" style="margin-right:8px; color:#86b562; font-size:12px;"></i>${merchantName}</div>`;
            }).join('');
            dropdown.style.display = 'block';
        }

        function selectManganMerchant(merchantName) {
            document.getElementById('manganMerchantInput').value = merchantName;
            document.getElementById('manganMerchantInput').style.borderColor = '#436026';
            hideManganDropdown();
            updateManganBadge();
        }

        function hideManganDropdown() {
            const dropdown = document.getElementById('manganMerchantDropdown');
            if (dropdown) dropdown.style.display = 'none';
            manganDropdownIndex = -1;
        }

        function manganMerchantKeydown(e) {
            const dropdown = document.getElementById('manganMerchantDropdown');
            if (!dropdown || dropdown.style.display === 'none') return;
            const items = dropdown.querySelectorAll('div[data-index]');
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                manganDropdownIndex = Math.min(manganDropdownIndex + 1, items.length - 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                manganDropdownIndex = Math.max(manganDropdownIndex - 1, 0);
            } else if (e.key === 'Enter' && manganDropdownIndex >= 0) {
                e.preventDefault();
                items[manganDropdownIndex].click();
                return;
            } else if (e.key === 'Escape') {
                hideManganDropdown();
                return;
            } else {
                return;
            }
            items.forEach((el, i) => el.style.background = i === manganDropdownIndex ? '#e6f3df' : '');
        }

        function toggleManganSection() {
            const form = document.getElementById('manganInlineForm');
            const chevron = document.getElementById('manganChevron');
            const isOpen = form.style.display !== 'none';
            form.style.display = isOpen ? 'none' : 'block';
            chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
            if (!isOpen) {
                const riderName = document.getElementById('remitRiderName').value;
                const display = document.getElementById('manganRiderNameDisplay');
                if (display) display.value = riderName;
            }
        }

        function closeManganModal() {
            const form = document.getElementById('manganInlineForm');
            const chevron = document.getElementById('manganChevron');
            if (form) form.style.display = 'none';
            if (chevron) chevron.style.transform = '';
        }

        function updateCombinedDeliveries() {
            const main = parseInt(document.getElementById('totalDeliveries').value) || 0;
            const current = parseInt(document.getElementById('manganDeliveries') ? document.getElementById(
                'manganDeliveries').value : 0) || 0;
            const saved = manganEntries.reduce((sum, e) => sum + (parseInt(e.deliveries) || 0), 0);
            const el = document.getElementById('combinedDeliveriesCount');
            if (el) el.textContent = main + current + saved;
            updateManganBadge();
        }

        function updateManganBadge() {
            const badge = document.getElementById('manganBadge');
            if (!badge) return;
            if (manganEntries.length > 0) {
                badge.textContent = manganEntries.length + (manganEntries.length === 1 ? ' entry' : ' entries');
                badge.style.display = 'inline-block';
            } else {
                badge.style.display = 'none';
            }
        }

        // Mangan entries list
        let manganEntries = [];

        function addManganEntry() {
            const merchant = (document.getElementById('manganMerchantInput').value || '').trim();
            const amount = parseFloat(document.getElementById('manganTotalAmount').value) || 0;
            const df = parseFloat(document.getElementById('manganDf').value) || 0;
            const gt = parseFloat(document.getElementById('manganGt').value) || 0;
            const tips = parseFloat(document.getElementById('manganTips').value) || 0;
            const receipt = parseFloat(document.getElementById('manganReceiptNonPartners').value) || 0;
            const totalRemit = parseFloat(document.getElementById('manganTotalRemit').value) || 0;

            if (merchant) {
                const matchedMerchant = manganMerchants.find((item) => {
                    const itemName = String(item.name ?? item.restaurant_name ?? '').trim();
                    return itemName.toLowerCase() === merchant.toLowerCase();
                });

                if (!matchedMerchant) {
                    showToast('Please select a valid merchant from the mt_merchant list.', 'warning');
                    return;
                }
            }

            if (!merchant && amount === 0) {
                showToast('Please fill in at least the Merchant Name or Total Amount before adding.', 'warning');
                return;
            }

            manganEntries.push({
                merchant,
                deliveries: 1,
                amount,
                df,
                gt,
                tips,
                receipt,
                totalRemit
            });

            // Increment total deliveries by 1
            const totalDeliveriesEl = document.getElementById('totalDeliveries');
            totalDeliveriesEl.value = (parseInt(totalDeliveriesEl.value) || 0) + 1;

            // Add to main form fields
            const totalDeliveryFeeEl = document.getElementById('totalDeliveryFee');
            totalDeliveryFeeEl.value = ((parseFloat(totalDeliveryFeeEl.value) || 0) + df).toFixed(2);

            const totalCollectionEl = document.getElementById('totalCollection');
            totalCollectionEl.value = ((parseFloat(totalCollectionEl.value) || 0) + amount).toFixed(2);

            const totalTipsEl = document.getElementById('totalTips');
            totalTipsEl.value = ((parseFloat(totalTipsEl.value) || 0) + tips).toFixed(2);

            const totalRemitEl = document.getElementById('totalRemit');
            totalRemitEl.value = ((parseFloat(totalRemitEl.value) || 0) + totalRemit).toFixed(2);

            syncManganEntriesJson();
            renderManganEntries();

            // Reset input fields
            document.getElementById('manganMerchantInput').value = '';
            document.getElementById('manganTotalAmount').value = '';
            document.getElementById('manganDf').value = '';
            document.getElementById('manganGt').value = '';
            document.getElementById('manganTips').value = '';
            document.getElementById('manganReceiptNonPartners').value = '';
            document.getElementById('manganTotalRemit').value = '';
            updateManganBadge();
            showToast('Mangan entry added.', 'success');
            closeManganModal();
        }

        function removeManganEntry(index) {
            const entry = manganEntries[index];
            manganEntries.splice(index, 1);

            // Decrement total deliveries by 1
            const totalDeliveriesEl = document.getElementById('totalDeliveries');
            const current = parseInt(totalDeliveriesEl.value) || 0;
            if (current > 0) totalDeliveriesEl.value = current - 1;

            // Subtract from main form fields
            const totalDeliveryFeeEl = document.getElementById('totalDeliveryFee');
            totalDeliveryFeeEl.value = Math.max(0, (parseFloat(totalDeliveryFeeEl.value) || 0) - (entry.df || 0)).toFixed(2);

            const totalCollectionEl = document.getElementById('totalCollection');
            totalCollectionEl.value = Math.max(0, (parseFloat(totalCollectionEl.value) || 0) - (entry.amount || 0)).toFixed(2);

            const totalTipsEl = document.getElementById('totalTips');
            totalTipsEl.value = Math.max(0, (parseFloat(totalTipsEl.value) || 0) - (entry.tips || 0)).toFixed(2);

            const totalRemitEl = document.getElementById('totalRemit');
            totalRemitEl.value = Math.max(0, (parseFloat(totalRemitEl.value) || 0) - (entry.totalRemit || 0)).toFixed(2);

            syncManganEntriesJson();
            renderManganEntries();
            updateManganBadge();
        }

        function syncManganEntriesJson() {
            const el = document.getElementById('manganEntriesJson');
            if (el) el.value = JSON.stringify(manganEntries);
            // Also update legacy single-entry hidden fields from first entry (for backward compat)
            if (manganEntries.length > 0) {
                document.getElementById('manganMerchantInput').dataset.savedMerchant = manganEntries[0].merchant;
            }
        }

        function renderManganEntries() {
            const list = document.getElementById('manganEntriesList');
            if (!list) return;
            if (manganEntries.length === 0) {
                list.style.display = 'none';
                list.innerHTML = '';
                return;
            }
            list.style.display = 'flex';
            list.innerHTML = manganEntries.map((e, i) => `
                <div style="background: #f0f7ed; border: 1.5px solid #86b562; border-radius: 8px; padding: 10px 14px; display: flex; align-items: flex-start; justify-content: space-between; gap: 10px;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 12px; font-weight: 700; color: #2d4016; margin-bottom: 4px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-utensils" style="font-size: 10px;"></i>
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">${e.merchant || '—'}</span>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 6px; font-size: 11px; color: #436026;">
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;"><b>${e.deliveries}</b> deliveries</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">Amt: ₱${e.amount.toFixed(2)}</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">DF: ₱${e.df.toFixed(2)}</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">GT: ₱${e.gt.toFixed(2)}</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">Tips: ₱${e.tips.toFixed(2)}</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">Receipt: ₱${e.receipt.toFixed(2)}</span>
                            <span style="background:#fff; border:1px solid #d6eacc; border-radius:5px; padding:2px 8px;">Total Remit: ₱${(e.totalRemit || 0).toFixed(2)}</span>
                        </div>
                    </div>
                    <button type="button" onclick="removeManganEntry(${i})"
                        style="flex-shrink:0; background:#fee2e2; color:#dc3545; border:1.5px solid #fca5a5; border-radius:7px; width:30px; height:30px; font-size:13px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:background 0.2s;"
                        onmouseover="this.style.background='#fecaca'" onmouseout="this.style.background='#fee2e2'">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            `).join('');
        }
    </script>

    <!-- Message Modal -->
    <div class="modal-overlay" id="messageModal">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header" id="messageModalHeader">
                <h3 id="messageModalTitle"><i class="fas fa-info-circle"></i> Message</h3>
            </div>
            <div class="modal-body" style="padding: 30px 25px;">
                <p id="messageModalText" style="margin: 0; font-size: 14px; line-height: 1.6; color: #333;"></p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn submit" onclick="closeMessageModal()" style="width: 100%;"><i
                        class="fas fa-check"></i> OK</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal-overlay" id="confirmModal">
        <div class="modal-content" style="max-width: 450px;">
            <div class="modal-header" style="background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);">
                <h3><i class="fas fa-question-circle"></i> Confirmation</h3>

            </div>
            <div class="modal-body" style="padding: 30px 25px;">
                <p id="confirmModalText" style="margin: 0; font-size: 14px; line-height: 1.6; color: #333;"></p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn cancel" onclick="closeConfirmModal()">Cancel</button>
                <button class="modal-btn submit" id="confirmModalOkBtn"><i class="fas fa-check"></i> OK</button>
            </div>
        </div>
    </div>

    <!-- Rider Records Modal -->
    <div class="modal-overlay" id="riderRecordsModal">
        <div class="modal-content"
            style="max-width: 1000px; max-height: 85vh; overflow: hidden; display: flex; flex-direction: column;">
            <div class="modal-header" style="background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);">
                <h3><i class="fas fa-history"></i> <span id="riderRecordsTitle">Rider Remittance Records</span></h3>
                <button class="close-modal" onclick="closeRiderRecordsModal()"
                    style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; padding: 0; width: 30px; height: 30px;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 20px; overflow-y: auto; flex: 1;">
                <!-- Date Filter -->
                <div id="riderRecordsDateFilter"
                    style="display: none; margin-bottom: 20px; padding: 12px 16px; background: linear-gradient(135deg, #f0f7ed 0%, #fafdf8 100%); border-radius: 8px; border: 1px solid rgba(67, 96, 38, 0.15); box-shadow: 0 2px 6px rgba(67, 96, 38, 0.06);">
                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <i class="fas fa-calendar-alt" style="color: #436026; font-size: 16px;"></i>
                        <label
                            style="font-size: 13px; font-weight: 700; color: #436026; white-space: nowrap; letter-spacing: 0.3px;">Filter
                            by Date:</label>
                        <input type="date" id="riderRecordsFilterDate"
                            style="padding: 8px 12px; border-radius: 6px; border: 1px solid #c8dcc0; font-size: 13px; background: #fff; color: #333; transition: all 0.2s; font-weight: 500;"
                            onchange="filterRiderRecordsByDate()">
                        <button onclick="clearRiderRecordsDateFilter()"
                            style="padding: 8px 14px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; border-radius: 6px; cursor: pointer; font-size: 12px; font-weight: 700; color: #fff; transition: all 0.2s; box-shadow: 0 2px 4px rgba(220, 53, 69, 0.2); display: flex; align-items: center; gap: 5px;">
                            <i class="fas fa-times-circle"></i> Clear
                        </button>
                    </div>
                </div>

                <div id="riderRecordsContent">
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #436026;"></i>
                        <p style="margin-top: 10px; color: #666;">Loading records...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Message Modal Functions
        function showMessageModal(message, type = 'info') {
            const modal = document.getElementById('messageModal');
            const header = document.getElementById('messageModalHeader');
            const title = document.getElementById('messageModalTitle');
            const text = document.getElementById('messageModalText');

            // Set message text (convert \n to <br>)
            text.innerHTML = message.replace(/\n/g, '<br>');

            // Set type-specific styling
            if (type === 'success') {
                header.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                title.innerHTML = '<i class="fas fa-check-circle"></i> Success';
            } else if (type === 'error') {
                header.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                title.innerHTML = '<i class="fas fa-exclamation-circle"></i> Error';
            } else if (type === 'warning') {
                header.style.background = 'linear-gradient(135deg, #ffc107 0%, #ff9800 100%)';
                title.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Warning';
            } else {
                header.style.background = 'linear-gradient(135deg, #436026 0%, #5a7d33 100%)';
                title.innerHTML = '<i class="fas fa-info-circle"></i> Information';
            }

            modal.classList.add('active');
        }

        function closeMessageModal() {
            document.getElementById('messageModal').classList.remove('active');
        }

        // Confirmation Modal Functions
        function showConfirmModal(message, onConfirm) {
            const modal = document.getElementById('confirmModal');
            const text = document.getElementById('confirmModalText');
            const okBtn = document.getElementById('confirmModalOkBtn');

            text.textContent = message;

            // Remove any previous event listeners
            const newOkBtn = okBtn.cloneNode(true);
            okBtn.parentNode.replaceChild(newOkBtn, okBtn);

            // Add new event listener
            newOkBtn.addEventListener('click', function() {
                closeConfirmModal();
                onConfirm();
            });

            modal.classList.add('active');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.remove('active');
        }

        // Rider Records Modal Functions
        function openRiderRecordsModal(riderId, riderName) {
            const modal = document.getElementById('riderRecordsModal');
            const title = document.getElementById('riderRecordsTitle');
            const content = document.getElementById('riderRecordsContent');

            title.textContent = `${riderName}'s Remittance Records`;

            // Show loading state
            content.innerHTML = `
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #436026;"></i>
                    <p style="margin-top: 10px; color: #666;">Loading records...</p>
                </div>
            `;

            modal.classList.add('active');

            // Fetch rider remittances
            fetch(`/riders/${riderId}/remittances`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayRiderRemittances(data.remittances, riderName);
                    } else {
                        content.innerHTML = `
                            <div style="text-align: center; padding: 40px;">
                                <i class="fas fa-exclamation-circle" style="font-size: 48px; color: #dc3545; opacity: 0.3;"></i>
                                <p style="margin-top: 15px; color: #666;">Failed to load records.</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error fetching rider remittances:', error);
                    content.innerHTML = `
                        <div style="text-align: center; padding: 40px;">
                            <i class="fas fa-exclamation-circle" style="font-size: 48px; color: #dc3545; opacity: 0.3;"></i>
                            <p style="margin-top: 15px; color: #666;">Error loading records. Please try again.</p>
                        </div>
                    `;
                });
        }

        // Store remittances data for pagination
        let currentRiderRemittances = [];
        let filteredRiderRemittances = [];
        let currentRiderName = '';
        let currentPage = 1;
        const itemsPerPage = 10;
        let selectedRemittanceId = null;
        let remittanceBreakdownCache = {};
        let currentSelectedBreakdownPayload = null;
        let currentSelectedBreakdownRemittance = null;

        function displayRiderRemittances(remittances, riderName) {
            const content = document.getElementById('riderRecordsContent');
            const dateFilter = document.getElementById('riderRecordsDateFilter');
            const filterDateInput = document.getElementById('riderRecordsFilterDate');

            currentRiderRemittances = remittances;
            filteredRiderRemittances = remittances;
            currentRiderName = riderName;
            currentPage = 1;
            selectedRemittanceId = null;
            remittanceBreakdownCache = {};

            // Clear any previous filter
            filterDateInput.value = '';

            if (remittances.length === 0) {
                dateFilter.style.display = 'none';
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-inbox" style="font-size: 48px; color: #6c757d; opacity: 0.3;"></i>
                        <p style="margin-top: 15px; color: #666;">No remittance records found for ${riderName}.</p>
                    </div>
                `;
                return;
            }

            // Show date filter
            dateFilter.style.display = 'block';

            renderRiderRemittancesPage();
        }

        function renderRiderRemittancesPage() {
            const content = document.getElementById('riderRecordsContent');
            const remittances = filteredRiderRemittances;

            function formatRemarksHtmlLines(rawRemarks) {
                if (!rawRemarks) {
                    return '<span style="color: #999; font-style: italic;">No remarks</span>';
                }

                const lines = String(rawRemarks)
                    .split(/\s*\|\s*|\r?\n/)
                    .map(line => line.trim())
                    .filter(Boolean);

                if (!lines.length) {
                    return '<span style="color: #999; font-style: italic;">No remarks</span>';
                }

                return `<div style="display:grid; gap:4px;">${lines.map(line => `<div style="display:block; white-space:normal; word-break:break-word; line-height:1.35;">${escapeHtml(line)}</div>`).join('')}</div>`;
            }

            // Check if there are no filtered results
            if (remittances.length === 0) {
                content.innerHTML = `
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-filter" style="font-size: 48px; color: #6c757d; opacity: 0.3;"></i>
                        <p style="margin-top: 15px; color: #666;">No records found for the selected date.</p>
                        <p style="margin-top: 10px; color: #999; font-size: 14px;">Try selecting a different date or clear the filter.</p>
                    </div>
                `;
                return;
            }

            // Calculate totals
            let totalDeliveries = 0;
            let totalDeliveryFee = 0;
            let totalRemit = 0;
            let totalTips = 0;
            let totalCollection = 0;

            remittances.forEach(r => {
                totalDeliveries += parseInt(r.total_deliveries) || 0;
                totalDeliveryFee += parseFloat(r.total_delivery_fee) || 0;
                totalRemit += parseFloat(r.total_remit) || 0;
                totalTips += parseFloat(r.total_tips) || 0;
                totalCollection += parseFloat(r.total_collection) || 0;
            });

            // Calculate pagination
            const totalPages = Math.ceil(remittances.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, remittances.length);
            const paginatedRemittances = remittances.slice(startIndex, endIndex);

            // Build table HTML
            let tableHTML = `
                <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #436026;">
                    <h4 style="margin: 0 0 10px 0; color: #436026;"><i class="fas fa-chart-bar"></i> Summary</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 15px;">
                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">Total Records</div>
                            <div style="font-size: 20px; font-weight: bold; color: #436026;">${remittances.length}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">Total Deliveries</div>
                            <div style="font-size: 20px; font-weight: bold; color: #436026;">${totalDeliveries}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">Total Delivery Fee</div>
                            <div style="font-size: 20px; font-weight: bold; color: #436026;">₱${totalDeliveryFee.toFixed(2)}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">Total Remit</div>
                            <div style="font-size: 20px; font-weight: bold; color: #28a745;">₱${totalRemit.toFixed(2)}</div>
                        </div>
                        <div>
                            <div style="font-size: 12px; color: #666; margin-bottom: 4px;">Total Collection</div>
                            <div style="font-size: 20px; font-weight: bold; color: #007bff;">₱${totalCollection.toFixed(2)}</div>
                        </div>
                    </div>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden;">
                        <thead>
                            <tr style="background: #436026; color: white;">
                                <th style="padding: 12px; text-align: left; font-weight: 600; font-size: 13px;">Date</th>
                                <th style="padding: 12px; text-align: center; font-weight: 600; font-size: 13px;">Deliveries</th>
                                <th style="padding: 12px; text-align: right; font-weight: 600; font-size: 13px;">Delivery Fee</th>
                                <th style="padding: 12px; text-align: right; font-weight: 600; font-size: 13px;">Remit</th>
                                <th style="padding: 12px; text-align: right; font-weight: 600; font-size: 13px;">Tips</th>
                                <th style="padding: 12px; text-align: right; font-weight: 600; font-size: 13px;">Collection</th>
                                <th style="padding: 12px; text-align: center; font-weight: 600; font-size: 13px;">Payment</th>
                                <th style="padding: 12px; text-align: center; font-weight: 600; font-size: 13px;">Status</th>
                                <th style="padding: 12px; text-align: left; font-weight: 600; font-size: 13px;">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            paginatedRemittances.forEach((remittance, index) => {
                const recordDateRaw = remittance.remittance_date || remittance.created_at;
                const date = new Date(recordDateRaw);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });

                const remitDateStr = remittance.remittance_date ? remittance.remittance_date.substring(0, 10) : '';
                const submittedDateStr = remittance.created_at ? remittance.created_at.substring(0, 10) : '';
                let isLateSubmission = false;
                let lateDays = 0;
                if (remitDateStr && submittedDateStr) {
                    const remitDateOnly = new Date(remitDateStr + 'T00:00:00');
                    const submittedDateOnly = new Date(submittedDateStr + 'T00:00:00');
                    lateDays = Math.floor((submittedDateOnly - remitDateOnly) / (1000 * 60 * 60 * 24));
                    isLateSubmission = lateDays > 0;
                }

                const submittedDateLabel = submittedDateStr ? new Date(submittedDateStr + 'T00:00:00')
                    .toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }) : 'Unknown date';

                let statusColor = remittance.status === 'confirmed' ? '#28a745' : '#ffc107';
                let statusBg = remittance.status === 'confirmed' ? '#d4edda' : '#fff3cd';
                let statusText = remittance.status === 'confirmed' ? 'CLEARED' : remittance.status.toUpperCase();
                let statusSubText = '';

                if (isLateSubmission) {
                    statusColor = '#c92a2a';
                    statusBg = '#ffe3e3';
                    statusText = 'LATE REMITTED';
                    statusSubText = submittedDateLabel;
                }

                const paymentColor = remittance.mode_of_payment === 'cash' ? '#28a745' : '#007bff';
                const paymentBg = remittance.mode_of_payment === 'cash' ? '#d4edda' : '#cfe2ff';
                const isSelected = Number(selectedRemittanceId) === Number(remittance.id);

                tableHTML += `
                    <tr class="remittance-record-row ${isSelected ? 'remittance-record-row-selected' : ''}" data-remittance-id="${remittance.id}" style="border-bottom: 1px solid #e9ecef; cursor: pointer; ${index % 2 === 0 ? 'background: #f8f9fa;' : ''} ${isSelected ? 'background: #e6f3dd; box-shadow: inset 3px 0 0 #436026;' : ''}">
                        <td style="padding: 12px; font-size: 13px; color: #333;">${formattedDate}</td>
                        <td style="padding: 12px; text-align: center; font-size: 13px; font-weight: 600; color: #436026;">${remittance.total_deliveries}</td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #333;">₱${parseFloat(remittance.total_delivery_fee).toFixed(2)}</td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; font-weight: 600; color: #28a745;">₱${parseFloat(remittance.total_remit).toFixed(2)}</td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; color: #333;">₱${parseFloat(remittance.total_tips || 0).toFixed(2)}</td>
                        <td style="padding: 12px; text-align: right; font-size: 13px; font-weight: 600; color: #007bff;">₱${parseFloat(remittance.total_collection).toFixed(2)}</td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; background: ${paymentBg}; color: ${paymentColor};">
                                ${remittance.mode_of_payment.toUpperCase()}
                            </span>
                        </td>
                        <td style="padding: 12px; text-align: center;">
                            <span style="display: inline-block; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; background: ${statusBg}; color: ${statusColor};">
                                <span style="display:block; line-height:1.2;">${statusText}</span>
                                ${statusSubText ? `<span style="display:block; margin-top:2px; font-size:10px; font-style:italic; font-weight:500; line-height:1.2;">${statusSubText}</span>` : ''}
                            </span>
                        </td>
                        <td style="padding: 12px; font-size: 13px; color: #333; max-width: 250px;">${formatRemarksHtmlLines(remittance.remarks)}</td>
                    </tr>
                `;
            });

            tableHTML += `
                        </tbody>
                    </table>
                </div>

                <div id="remittanceMerchantBreakdown" style="margin-top: 16px; border: 1px solid #dce8d4; border-radius: 8px; background: #f9fcf7; padding: 14px 16px;">
                    <div style="font-size: 13px; color: #436026; font-weight: 700; margin-bottom: 6px;"><i class="fas fa-store"></i> Merchant Breakdown</div>
                    <div style="font-size: 13px; color: #6b7280;">Select a remittance row above to view delivery breakdown per merchant.</div>
                </div>
            `;

            // Add pagination if needed
            if (totalPages > 1) {
                tableHTML += `
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px; padding-top: 15px; border-top: 1px solid #e9ecef;">
                        <div style="color: #666; font-size: 14px;">
                            Showing ${startIndex + 1} to ${endIndex} of ${remittances.length} entries
                        </div>
                        <div style="display: flex; gap: 5px;">
                `;

                // Previous button
                if (currentPage > 1) {
                    tableHTML += `
                        <button onclick="goToRiderRecordsPage(${currentPage - 1})" style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s;">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    `;
                } else {
                    tableHTML += `
                        <button disabled style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                            <i class="fas fa-chevron-left"></i> Previous
                        </button>
                    `;
                }

                // Page numbers
                for (let i = 1; i <= totalPages; i++) {
                    if (i === currentPage) {
                        tableHTML += `
                            <button disabled style="padding: 8px 14px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; font-size: 13px; font-weight: 700; min-width: 40px;">
                                ${i}
                            </button>
                        `;
                    } else {
                        tableHTML += `
                            <button onclick="goToRiderRecordsPage(${i})" style="padding: 8px 14px; background: #f8f9fa; color: #436026; border: 1px solid #dee2e6; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; min-width: 40px; transition: all 0.2s;">
                                ${i}
                            </button>
                        `;
                    }
                }

                // Next button
                if (currentPage < totalPages) {
                    tableHTML += `
                        <button onclick="goToRiderRecordsPage(${currentPage + 1})" style="padding: 8px 12px; background: linear-gradient(135deg, #436026 0%, #5a7d33 100%); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-size: 13px; font-weight: 600; transition: all 0.2s;">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    `;
                } else {
                    tableHTML += `
                        <button disabled style="padding: 8px 12px; background: #e0e0e0; color: #999; border: none; border-radius: 6px; cursor: not-allowed; font-size: 13px; font-weight: 600;">
                            Next <i class="fas fa-chevron-right"></i>
                        </button>
                    `;
                }

                tableHTML += `
                        </div>
                    </div>
                `;
            }

            content.innerHTML = tableHTML;

            const recordRows = content.querySelectorAll('.remittance-record-row');
            recordRows.forEach(row => {
                row.addEventListener('click', () => {
                    setSelectedRemittanceRow(row);
                });
            });
        }

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function formatPaymentType(paymentType, fallback = '') {
            const raw = String(paymentType ?? fallback ?? '').trim();
            if (!raw) {
                return '';
            }

            const normalizeToken = (value) => String(value ?? '')
                .trim()
                .replace(/^['"]+|['"]+$/g, '')
                .trim();

            try {
                const parsed = JSON.parse(raw);
                if (Array.isArray(parsed)) {
                    return parsed
                        .map(item => normalizeToken(item))
                        .filter(Boolean)
                        .join(' / ')
                        .toUpperCase();
                }

                if (typeof parsed === 'string') {
                    const normalized = normalizeToken(parsed);
                    return normalized ? normalized.toUpperCase() : '';
                }
            } catch (_) {
                // Keep non-JSON values as-is.
            }

            // Handle non-JSON array-like values coming from DB, e.g. ['CASH'].
            const arrayLikeMatch = raw.match(/^\[(.*)\]$/);
            if (arrayLikeMatch) {
                const normalized = arrayLikeMatch[1]
                    .split(',')
                    .map(token => normalizeToken(token))
                    .filter(Boolean)
                    .join(' / ');

                return normalized ? normalized.toUpperCase() : '';
            }

            const normalized = normalizeToken(raw);
            return normalized ? normalized.toUpperCase() : '';
        }

        function normalizeDetailedRemarks(value) {
            const raw = String(value ?? '').trim();
            if (!raw) {
                return '';
            }

            return raw.replace(/(^|\|\s*|\n)\d+\.\s*/g, (match, prefix) => `${prefix}- `);
        }

        function setSelectedRemittanceRow(rowElement) {
            const remittanceId = Number(rowElement.getAttribute('data-remittance-id'));
            if (!remittanceId) {
                return;
            }

            const tableRows = document.querySelectorAll('.remittance-record-row');
            tableRows.forEach(row => {
                row.classList.remove('remittance-record-row-selected');
                const baseBg = row.rowIndex % 2 === 0 ? '#f8f9fa' : '#ffffff';
                row.style.background = baseBg;
                row.style.boxShadow = 'none';
            });

            selectedRemittanceId = remittanceId;
            rowElement.classList.add('remittance-record-row-selected');
            rowElement.style.background = '#e6f3dd';
            rowElement.style.boxShadow = 'inset 3px 0 0 #436026';

            const selectedRemittance = filteredRiderRemittances.find(item => Number(item.id) === remittanceId) || null;
            renderMerchantBreakdown(remittanceId, selectedRemittance);
        }

        function renderMerchantBreakdown(remittanceId, remittance) {
            const container = document.getElementById('remittanceMerchantBreakdown');
            if (!container) {
                return;
            }

            currentSelectedBreakdownRemittance = remittance || null;
            currentSelectedBreakdownPayload = null;

            container.innerHTML = `
                <div style="text-align: center; padding: 18px 12px; color: #436026;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 20px;"></i>
                    <p style="margin-top: 8px; font-size: 13px;">Loading merchant breakdown...</p>
                </div>
            `;

            if (remittanceBreakdownCache[remittanceId]) {
                paintMerchantBreakdown(container, remittanceBreakdownCache[remittanceId], remittance);
                return;
            }

            fetch(`/remittances/${remittanceId}/merchant-breakdown`)
                .then(response => response.json())
                .then(data => {
                    remittanceBreakdownCache[remittanceId] = data;
                    paintMerchantBreakdown(container, data, remittance);
                })
                .catch(() => {
                    container.innerHTML = `
                        <div style="text-align: center; padding: 16px 12px; color: #b91c1c; font-size: 13px;">
                            <i class="fas fa-exclamation-triangle" style="margin-right: 6px;"></i>
                            Unable to load merchant breakdown for this remittance.
                        </div>
                    `;
                });
        }

        function paintMerchantBreakdown(container, payload, remittance) {
            const items = Array.isArray(payload?.breakdown) ? payload.breakdown : [];
            const summary = payload?.summary || {
                merchant_count: 0,
                total_deliveries: 0,
                total_collection: 0
            };
            currentSelectedBreakdownPayload = payload || null;
            currentSelectedBreakdownRemittance = remittance || currentSelectedBreakdownRemittance;
            const recordDateRaw = remittance?.remittance_date || remittance?.created_at || payload?.remittance_date || '';
            const recordDate = recordDateRaw ? new Date(recordDateRaw).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : 'N/A';

            if (!items.length) {
                container.innerHTML = `
                    <div style="border:1px solid #dce8d4; border-radius:8px; overflow:hidden; background:#fff;">
                        <div style="padding:10px 12px; background:linear-gradient(135deg,#f0f7ed 0%,#f8fcf5 100%); border-bottom:1px solid #dce8d4; font-size:12px; font-weight:700; color:#2d4016;">
                            Detailed Breakdown (Sheet Format)
                        </div>
                        <div style="padding: 12px; border-radius: 6px; background: #fff; border: none; color: #6b7280; font-size: 13px;">
                            No merchant delivery breakdown found for this remittance date.
                        </div>
                    </div>
                `;
                return;
            }

            const rowsHtml = items.map((item, idx) => {
                const orders = Array.isArray(item.orders) ? item.orders : [];
                const orderBadges = orders.length ? orders.map(order =>
                    `<span style="display:inline-flex;align-items:center;padding:4px 8px;border:1px solid #d7e6ce;border-radius:999px;background:#fff;font-size:11px;color:#374151;font-weight:600;">#${escapeHtml(order.order_id || '')}</span>`
                ).join('') : '<span style="font-size:11px;color:#9ca3af;font-style:italic;">No order IDs</span>';

                const orderRows = orders.length ? orders.map(order => `
                    <tr>
                        <td style="padding:6px 8px;border-bottom:1px solid #edf2ea;font-size:11px;color:#374151;">${escapeHtml(order.order_id || '')}</td>
                        <td style="padding:6px 8px;border-bottom:1px solid #edf2ea;font-size:11px;color:#0d6efd;text-align:right;">₱${Number(order.total_collection || 0).toFixed(2)}</td>
                    </tr>
                `).join('') : `
                    <tr>
                        <td colspan="2" style="padding:6px 8px;font-size:11px;color:#9ca3af;font-style:italic;">No order rows available.</td>
                    </tr>
                `;

                return `
                <tr style="${idx % 2 === 0 ? 'background: #ffffff;' : 'background: #f7fbf4;'}">
                    <td style="padding: 10px 12px; border-bottom: 1px solid #e5eee0; font-size: 13px; color: #1f2937;">${escapeHtml(item.merchant_name || 'Unknown Merchant')}</td>
                    <td style="padding: 10px 12px; border-bottom: 1px solid #e5eee0; text-align: center; font-size: 13px; font-weight: 700; color: #436026;">${Number(item.deliveries || 0)}</td>
                    <td style="padding: 10px 12px; border-bottom: 1px solid #e5eee0; text-align: right; font-size: 13px; font-weight: 600; color: #0d6efd;">₱${Number(item.total_collection || 0).toFixed(2)}</td>
                </tr>
                <tr style="${idx % 2 === 0 ? 'background: #f9fcf7;' : 'background: #ffffff;'}">
                    <td colspan="3" style="padding: 8px 12px 12px; border-bottom: 1px solid #e5eee0;">
                        <details>
                            <summary style="cursor:pointer;color:#436026;font-size:12px;font-weight:700;">View Orders (${orders.length})</summary>
                            <div style="margin-top:8px;display:flex;flex-direction:column;gap:8px;">
                                <div style="display:flex;gap:6px;flex-wrap:wrap;">${orderBadges}</div>
                                <div style="max-width:360px;border:1px solid #e3eedb;border-radius:6px;overflow:hidden;background:#fff;">
                                    <table style="width:100%;border-collapse:collapse;">
                                        <thead>
                                            <tr style="background:#eef6e9;">
                                                <th style="padding:6px 8px;text-align:left;font-size:11px;color:#436026;">Order ID</th>
                                                <th style="padding:6px 8px;text-align:right;font-size:11px;color:#436026;">Collection</th>
                                            </tr>
                                        </thead>
                                        <tbody>${orderRows}</tbody>
                                    </table>
                                </div>
                            </div>
                        </details>
                    </td>
                </tr>
            `;
            }).join('');

            const detailRows = [];
            let taskCounter = 0;
            items.forEach(item => {
                const merchantName = item.merchant_name || 'Unknown Merchant';
                const orders = Array.isArray(item.orders) ? item.orders : [];
                if (!orders.length) {
                    return;
                }

                orders.forEach(order => {
                    taskCounter += 1;
                    detailRows.push({
                        task_no: taskCounter,
                        rider: currentRiderName || 'N/A',
                        mop: formatPaymentType(order?.payment_type, payload?.mode_of_payment || remittance?.mode_of_payment || ''),
                        ref_no: order.order_id || '',
                        merchant: merchantName,
                        total_amount: Number(order.total_collection || 0),
                        df: Number(order.delivery_fee || 0),
                        gt_grumpy_receipt: Number(order.gt_grumpy_receipt || 0),
                        tip: Number(order.tip_amount || 0),
                        receipt_non_partners: Number(order.receipt_non_partners || 0),
                        total_remit: Number(order.total_remit || 0),
                        cf: Number(order.cf_amount || 0),
                        estimate_sales_admin_fee: Number(order.total_collection || 0) + Number(order.cf_amount || 0),
                        remarks: normalizeDetailedRemarks(payload?.remarks || remittance?.remarks || '')
                    });
                });
            });

            const detailedRowsHtml = detailRows.length ? detailRows.map((row, idx) => `
                <tr style="${idx % 2 === 0 ? 'background:#fff;' : 'background:#f7fbf4;'} border-bottom:1px solid #e5eee0; transition: background 0.2s ease;">
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:center; font-size:12px; font-weight:600; color:#436026;">${row.task_no}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; font-size:12px; color:#374151;">${escapeHtml(row.rider)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:center; font-size:12px; color:#374151; white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(row.mop || '-')}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:center; font-size:12px; color:#0d6efd; font-weight:600;">${escapeHtml(row.ref_no || '-')}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; font-size:12px; color:#374151; white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(row.merchant)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#1f2937; font-weight:600;">₱${row.total_amount.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#374151;">₱${row.df.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#374151;">₱${row.gt_grumpy_receipt.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#374151;">₱${row.tip.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#374151;">₱${row.receipt_non_partners.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; font-weight:700; color:#436026;">₱${row.total_remit.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#374151;">₱${row.cf.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; text-align:right; font-size:12px; color:#1f2937; font-weight:600;">₱${row.estimate_sales_admin_fee.toFixed(2)}</td>
                    <td style="padding:10px; border-bottom:1px solid #e5eee0; font-size:12px; color:#666; white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(row.remarks || '-')}</td>
                </tr>
            `).join('') : `
                <tr>
                    <td colspan="14" style="padding:24px; text-align:center; color:#9ca3af; font-size:13px;">No detailed order rows available.</td>
                </tr>
            `;

            container.innerHTML = `
                <div style="margin-top:0; border:1px solid #dce8d4; border-radius:8px; overflow:hidden; background:#fff;">
                    <div style="padding:12px 14px; background:linear-gradient(135deg,#f0f7ed 0%,#f8fcf5 100%); border-bottom:1px solid #dce8d4; font-size:13px; font-weight:700; color:#2d4016;">
                        Detailed Breakdown (Sheet Format)
                    </div>
                    <div style="overflow:auto; max-height:500px; position:relative;">
                        <table style="width:100%; border-collapse:collapse; min-width: 1200px; table-layout: fixed;">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr style="background:#e8dbc4; color:#1f2937; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:center; border-bottom:2px solid #cdbd9f; width:60px; background:#e8dbc4;"># of Task</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:left; border-bottom:2px solid #cdbd9f; width:110px; background:#e8dbc4;">Rider</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:center; border-bottom:2px solid #cdbd9f; width:120px; background:#e8dbc4;">MOP</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:center; border-bottom:2px solid #cdbd9f; width:80px; background:#e8dbc4;">REF #</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:left; border-bottom:2px solid #cdbd9f; width:170px; background:#e8dbc4;">Merchant</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:90px; background:#e8dbc4;">Total Amount</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:70px; background:#e8dbc4;">DF</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:100px; background:#e8dbc4;">GT / Grumpy Receipt</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:70px; background:#e8dbc4;">Tip</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:110px; background:#e8dbc4;">Receipt (Non Partners)</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:90px; background:#e8dbc4;">Total Remit</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:70px; background:#e8dbc4;">CF</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:right; border-bottom:2px solid #cdbd9f; width:120px; background:#e8dbc4;">ESTIMATE SALES+ADMIN FEE</th>
                                    <th style="padding:10px 10px; font-size:11px; font-weight:700; text-align:left; border-bottom:2px solid #cdbd9f; width:140px; background:#e8dbc4;">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>${detailedRowsHtml}</tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        function escapeCsvCell(value) {
            const str = String(value ?? '');
            return `"${str.replace(/"/g, '""')}"`;
        }

        function exportCurrentBreakdownCsv() {
            const payload = currentSelectedBreakdownPayload;
            const items = Array.isArray(payload?.breakdown) ? payload.breakdown : [];

            if (!items.length) {
                showMessageModal('No breakdown data to export yet. Select a remittance row with available breakdown.', 'warning');
                return;
            }

            const rows = [];
            rows.push(['# of Task', 'Rider', 'MOP', 'REF #', 'Merchant', 'Total Amount', 'DF', 'GT/Grumpy Receipt', 'Tip', 'Receipt (Non Partners)', 'Total Remit', 'CF', 'ESTIMATE SALES+ADMIN FEE', 'Remarks'].map(escapeCsvCell).join(','));

            let taskCounter = 0;
            items.forEach(item => {
                const orders = Array.isArray(item.orders) ? item.orders : [];
                orders.forEach(order => {
                    taskCounter += 1;
                    rows.push([
                        taskCounter,
                        currentRiderName || '',
                        formatPaymentType(order?.payment_type, payload?.mode_of_payment || currentSelectedBreakdownRemittance?.mode_of_payment || ''),
                        order.order_id || '',
                        item.merchant_name || 'Unknown Merchant',
                        Number(order.total_collection || 0).toFixed(2),
                        Number(order.delivery_fee || 0).toFixed(2),
                        Number(order.gt_grumpy_receipt || 0).toFixed(2),
                        Number(order.tip_amount || 0).toFixed(2),
                        Number(order.receipt_non_partners || 0).toFixed(2),
                        Number(order.total_remit || 0).toFixed(2),
                        Number(order.cf_amount || 0).toFixed(2),
                        (Number(order.total_collection || 0) + Number(order.cf_amount || 0)).toFixed(2),
                        normalizeDetailedRemarks(payload?.remarks || currentSelectedBreakdownRemittance?.remarks || '')
                    ].map(escapeCsvCell).join(','));
                });
            });

            const csvContent = rows.join('\n');
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            const fileDate = payload?.remittance_date || (new Date().toISOString().substring(0, 10));
            a.href = url;
            a.download = `merchant-breakdown-${selectedRemittanceId || 'record'}-${fileDate}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        function exportCurrentBreakdownPdf() {
            const payload = currentSelectedBreakdownPayload;
            const items = Array.isArray(payload?.breakdown) ? payload.breakdown : [];

            if (!items.length) {
                showMessageModal('No breakdown data to export yet. Select a remittance row with available breakdown.', 'warning');
                return;
            }

            const summary = payload?.summary || {
                merchant_count: 0,
                total_deliveries: 0,
                total_collection: 0,
            };
            const recordDateRaw = currentSelectedBreakdownRemittance?.remittance_date || currentSelectedBreakdownRemittance?.created_at || payload?.remittance_date || '';
            const recordDate = recordDateRaw ? new Date(recordDateRaw).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : 'N/A';

            const detailRows = [];
            let taskCounter = 0;
            items.forEach(item => {
                const orders = Array.isArray(item.orders) ? item.orders : [];
                orders.forEach(order => {
                    taskCounter += 1;
                    detailRows.push(`
                        <tr>
                            <td style="text-align:center;">${taskCounter}</td>
                            <td>${escapeHtml(currentRiderName || 'N/A')}</td>
                            <td style="text-align:center; white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(formatPaymentType(order?.payment_type, payload?.mode_of_payment || currentSelectedBreakdownRemittance?.mode_of_payment || ''))}</td>
                            <td style="text-align:center;">${escapeHtml(order.order_id || '')}</td>
                            <td style="white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(item.merchant_name || 'Unknown Merchant')}</td>
                            <td style="text-align:right;">₱${Number(order.total_collection || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.delivery_fee || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.gt_grumpy_receipt || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.tip_amount || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.receipt_non_partners || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.total_remit || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${Number(order.cf_amount || 0).toFixed(2)}</td>
                            <td style="text-align:right;">₱${(Number(order.total_collection || 0) + Number(order.cf_amount || 0)).toFixed(2)}</td>
                            <td style="white-space:normal; overflow-wrap:anywhere; word-break:break-word; line-height:1.25;">${escapeHtml(normalizeDetailedRemarks(payload?.remarks || currentSelectedBreakdownRemittance?.remarks || ''))}</td>
                        </tr>
                    `);
                });
            });

            const printWindow = window.open('', '_blank', 'width=1100,height=800');
            if (!printWindow) {
                showMessageModal('Unable to open print window. Please allow pop-ups and try again.', 'warning');
                return;
            }

            const html = `
                <html>
                <head>
                    <title>Merchant Breakdown Export</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 24px; color: #1f2937; }
                        h2 { margin: 0 0 6px 0; color: #2d4016; }
                        .sub { margin: 0 0 14px 0; color: #4b5563; font-size: 12px; }
                        .summary { margin-bottom: 14px; display: flex; gap: 10px; flex-wrap: wrap; }
                        .card { border: 1px solid #d4e4ca; border-radius: 6px; padding: 8px 10px; font-size: 12px; }
                        table { width: 100%; border-collapse: collapse; }
                        thead th { background: #436026; color: #fff; padding: 9px; font-size: 11px; text-align: left; }
                        tbody td { border-bottom: 1px solid #e5eee0; padding: 8px; font-size: 12px; vertical-align: top; }
                    </style>
                </head>
                <body>
                    <h2>Merchant Breakdown</h2>
                    <p class="sub">Rider: ${escapeHtml(currentRiderName || 'N/A')} | Record Date: ${escapeHtml(recordDate)} | Remittance ID: ${escapeHtml(selectedRemittanceId || 'N/A')}</p>
                    <div class="summary">
                        <div class="card">Merchants: <strong>${Number(summary.merchant_count || 0)}</strong></div>
                        <div class="card">Deliveries: <strong>${Number(summary.total_deliveries || 0)}</strong></div>
                        <div class="card">Collection: <strong>₱${Number(summary.total_collection || 0).toFixed(2)}</strong></div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th style="text-align:center;">#</th>
                                <th>Rider</th>
                                <th style="text-align:center;">MOP</th>
                                <th style="text-align:center;">REF #</th>
                                <th>Merchant</th>
                                <th style="text-align:right;">Total Amount</th>
                                <th style="text-align:right;">DF</th>
                                <th style="text-align:right;">GT/Grumpy</th>
                                <th style="text-align:right;">Tip</th>
                                <th style="text-align:right;">Receipt (NP)</th>
                                <th style="text-align:right;">Total Remit</th>
                                <th style="text-align:right;">CF</th>
                                <th style="text-align:right;">Estimate Sales+Admin Fee</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>${detailRows.join('')}</tbody>
                    </table>
                </body>
                </html>
            `;

            printWindow.document.open();
            printWindow.document.write(html);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
            }, 400);
        }

        function goToRiderRecordsPage(page) {
            currentPage = page;
            selectedRemittanceId = null;
            currentSelectedBreakdownPayload = null;
            currentSelectedBreakdownRemittance = null;
            renderRiderRemittancesPage();
        }

        function filterRiderRecordsByDate() {
            const filterDateInput = document.getElementById('riderRecordsFilterDate');
            const selectedDate = filterDateInput.value;

            if (!selectedDate) {
                filteredRiderRemittances = currentRiderRemittances;
            } else {
                // Filter remittances by the selected date
                filteredRiderRemittances = currentRiderRemittances.filter(remittance => {
                    const remittanceDateRaw = remittance.remittance_date || remittance.created_at;
                    const remittanceDate = new Date(remittanceDateRaw);
                    const filterDate = new Date(selectedDate);

                    // Compare only the date part (ignore time)
                    return remittanceDate.getFullYear() === filterDate.getFullYear() &&
                        remittanceDate.getMonth() === filterDate.getMonth() &&
                        remittanceDate.getDate() === filterDate.getDate();
                });
            }

            // Reset to page 1 and render
            currentPage = 1;
            selectedRemittanceId = null;
            currentSelectedBreakdownPayload = null;
            currentSelectedBreakdownRemittance = null;
            renderRiderRemittancesPage();
        }

        function clearRiderRecordsDateFilter() {
            const filterDateInput = document.getElementById('riderRecordsFilterDate');
            filterDateInput.value = '';
            filteredRiderRemittances = currentRiderRemittances;
            currentPage = 1;
            selectedRemittanceId = null;
            currentSelectedBreakdownPayload = null;
            currentSelectedBreakdownRemittance = null;
            renderRiderRemittancesPage();
        }

        function closeRiderRecordsModal() {
            document.getElementById('riderRecordsModal').classList.remove('active');
            // Reset pagination state
            currentRiderRemittances = [];
            filteredRiderRemittances = [];
            currentRiderName = '';
            currentPage = 1;
            selectedRemittanceId = null;
            remittanceBreakdownCache = {};
            currentSelectedBreakdownPayload = null;
            currentSelectedBreakdownRemittance = null;
            // Hide and reset date filter
            const dateFilter = document.getElementById('riderRecordsDateFilter');
            const filterDateInput = document.getElementById('riderRecordsFilterDate');
            dateFilter.style.display = 'none';
            filterDateInput.value = '';
        }

        // Close rider records modal when clicking outside
        document.getElementById('riderRecordsModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeRiderRecordsModal();
            }
        });

        // Close message modal when clicking outside
        document.getElementById('messageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeMessageModal();
            }
        });

        // Close confirmation modal when clicking outside
        document.getElementById('confirmModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeConfirmModal();
            }
        });

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

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRemitModal();
                closeMessageModal();
                closeConfirmModal();
                closeRiderRecordsModal();
            }
        });

        // Search Riders Function
        function toggleRiderDropdown(headerEl) {
            const dropdown = headerEl.closest('.rider-dropdown');
            const wasOpen = dropdown.classList.contains('open');

            // Close all other open dropdowns
            document.querySelectorAll('.rider-dropdown.open').forEach(d => {
                if (d !== dropdown) d.classList.remove('open');
            });

            dropdown.classList.toggle('open');

            // When opening, select this rider across all tabs
            if (!wasOpen) {
                const row = dropdown.closest('.rider-row');
                const riderId = row.dataset.riderId;
                const riderName = headerEl.querySelector('.rider-item-info strong').textContent.trim();
                selectRiderGlobal(riderId, riderName, row);
            }
        }

        function toggleDeductionForm(forceClose = false) {
            const panel = document.getElementById('deductionFormPanel');
            if (!panel) return;
            if (forceClose || panel.style.display !== 'none') {
                panel.style.display = 'none';
            } else {
                // Check a rider is selected first
                const form = document.getElementById('deductionsForm');
                const riderId = form ? form.querySelector('[name="rider_id"]').value : '';
                if (!riderId) {
                    showToast('Please select a rider from the Rider Queue first', 'warning');
                    return;
                }
                panel.style.display = 'block';
                setTimeout(() => document.getElementById('deductionRemarks') && document.getElementById('deductionRemarks')
                    .focus(), 50);
            }
        }

        function selectRiderGlobal(riderId, riderName, rowEl) {
            // Highlight selected row
            document.querySelectorAll('.rider-row').forEach(r => r.classList.remove('selected'));
            if (rowEl) rowEl.classList.add('selected');

            // Fill Payroll tab
            const payrollForm = document.getElementById('payrollForm');
            if (payrollForm) {
                payrollForm.querySelector('[name="rider_id"]').value = riderId;
                payrollForm.querySelector('[name="rider_name"]').value = riderName;
                
                // Reset salary schedule dropdown
                const salaryScheduleSelect = payrollForm.querySelector('[name="salary_schedule"]');
                if (salaryScheduleSelect) {
                    salaryScheduleSelect.value = '';
                }
                
                // Clear all payroll form inputs except rider info
                const inputsToClear = ['base_salary', 'incentives', 'renumeration_26_days', 'net_salary', 'adda_df', 'adda_df_date', 'adda_df_entries'];
                inputsToClear.forEach(name => {
                    const input = payrollForm.querySelector(`[name="${name}"]`);
                    if (input) input.value = '';
                });

                // Automatically populate base salary from total delivery fee
                calculateAndPopulateBaseSalary(riderId);
                calculateAndPopulateNetSalary();
                
                // Clear mode of payment
                const modeOfPayment = payrollForm.querySelector('[name="mode_of_payment"]');
                if (modeOfPayment) modeOfPayment.value = '';
                
                // Reset ADDA DF rows
                const addaDfRows = document.getElementById('addaDfRows');
                if (addaDfRows) {
                    addaDfRows.innerHTML = '';
                }
                
                // Update ADDA DF summary
                const addaDfSummary = document.getElementById('addaDfSummary');
                if (addaDfSummary) {
                    addaDfSummary.textContent = 'Total ADDA DF: ₱0.00';
                }
                
                // Hide ADDA DF notice
                const allowedDaysNotice = document.getElementById('addaDfAllowedDaysNotice');
                if (allowedDaysNotice) {
                    allowedDaysNotice.style.display = 'none';
                }
                
                // Hide date selector dropdown
                hideAddaDfDateSelector();
                
                // Attach automatic calculation listeners
                if (typeof attachAddaDfAmountListeners === 'function') {
                    attachAddaDfAmountListeners();
                }
            }

            // Fill Deductions tab hidden inputs
            const deductionsForm = document.getElementById('deductionsForm');
            if (deductionsForm) {
                deductionsForm.querySelector('[name="rider_id"]').value = riderId;
                deductionsForm.querySelector('[name="rider_name"]').value = riderName;
            }

            // Update Deductions rider display card
            const nameDisplay = document.getElementById('deductionRiderNameDisplay');
            const avatarDisplay = document.getElementById('deductionRiderAvatar');
            if (nameDisplay) nameDisplay.textContent = riderName;
            if (avatarDisplay) avatarDisplay.textContent = riderName.charAt(0).toUpperCase();

            // Close any open deduction form when switching rider and clear staged list
            toggleDeductionForm(true);
            pendingDeductions = [];
            renderPendingDeductions();

            // Update Overview tab header
            const nameSpan = document.getElementById('detailsRiderName');
            if (nameSpan) nameSpan.textContent = riderName;
        }

        function searchRiders() {
            const searchValue = document.getElementById('riderSearch').value.toLowerCase();
            const riderRows = document.querySelectorAll('.rider-row');

            riderRows.forEach(row => {
                const riderName = row.querySelector('.rider-dropdown-header .rider-item-info strong').textContent
                    .toLowerCase();

                if (riderName.includes(searchValue)) {
                    row.style.display = 'block';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search Cleared Riders Function
        function searchClearedRiders() {
            const searchValue = document.getElementById('clearedRiderSearch').value.toLowerCase();
            const nameFilter = document.getElementById('remittancesNameFilter') ? document.getElementById(
                'remittancesNameFilter').value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.cleared-riders-table tbody tr');

            tableRows.forEach(row => {
                const riderName = row.querySelector('td:first-child strong') ? row.querySelector(
                    'td:first-child strong').textContent.toLowerCase() : '';
                const dateCleared = row.querySelector('td:last-child').textContent.toLowerCase();

                const matchesSearch = !searchValue || riderName.includes(searchValue) || dateCleared.includes(
                    searchValue);
                const matchesName = !nameFilter || riderName === nameFilter;

                row.style.display = (matchesSearch && matchesName) ? '' : 'none';
            });
        }

        // Search Payroll Records Function
        function searchPayroll() {
            const searchValue = document.getElementById('payrollSearch').value.toLowerCase();
            const nameFilter = document.getElementById('payrollNameFilter') ? document.getElementById('payrollNameFilter')
                .value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.payroll-row');

            tableRows.forEach(row => {
                const riderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const riderName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const salarySchedule = row.querySelector('td:nth-child(6)').textContent.toLowerCase();
                const dateCreated = row.querySelector('td:nth-child(8)').textContent.toLowerCase();

                const matchesSearch = !searchValue || riderId.includes(searchValue) || riderName.includes(
                    searchValue) || salarySchedule.includes(searchValue) || dateCreated.includes(searchValue);
                const matchesName = !nameFilter || riderName === nameFilter;

                row.style.display = (matchesSearch && matchesName) ? '' : 'none';
            });
        }

        // Search Deductions Records Function
        function searchDeductions() {
            const searchValue = document.getElementById('deductionsSearch').value.toLowerCase();
            const nameFilter = document.getElementById('deductionsNameFilter') ? document.getElementById(
                'deductionsNameFilter').value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.deduction-row');

            tableRows.forEach(row => {
                const riderId = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const riderName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const date = row.querySelector('td:nth-child(4)') ? row.querySelector('td:nth-child(4)').textContent
                    .toLowerCase() : '';
                const remarks = row.querySelector('td:nth-child(5)') ? row.querySelector('td:nth-child(5)')
                    .textContent.toLowerCase() : '';
                const dateCreated = row.querySelector('td:nth-child(6)') ? row.querySelector('td:nth-child(6)')
                    .textContent.toLowerCase() : '';

                const matchesSearch = !searchValue || riderId.includes(searchValue) || riderName.includes(
                        searchValue) || date.includes(searchValue) || remarks.includes(searchValue) || dateCreated
                    .includes(searchValue);
                const matchesName = !nameFilter || riderName === nameFilter;

                row.style.display = (matchesSearch && matchesName) ? '' : 'none';
            });
        }

        // Filter Remittances by Date Range + Name
        function filterRemittancesByDate() {
            const fromDate = document.getElementById('remittancesFromDate').value;
            const toDate = document.getElementById('remittancesToDate').value;
            const nameFilter = document.getElementById('remittancesNameFilter') ? document.getElementById(
                'remittancesNameFilter').value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.cleared-riders-table tbody tr');

            tableRows.forEach(row => {
                const dateCell = row.querySelector('td:nth-child(9)').textContent; // Date Submitted column
                const rowDate = new Date(dateCell);
                const riderName = row.querySelector('td:first-child strong') ? row.querySelector(
                    'td:first-child strong').textContent.toLowerCase() : '';

                let showRow = true;

                if (fromDate) {
                    const from = new Date(fromDate);
                    from.setHours(0, 0, 0, 0);
                    if (rowDate < from) showRow = false;
                }

                if (toDate) {
                    const to = new Date(toDate);
                    to.setHours(23, 59, 59, 999);
                    if (rowDate > to) showRow = false;
                }

                if (nameFilter && riderName !== nameFilter) showRow = false;

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Clear Remittances Date Filter
        function clearRemittancesDateFilter() {
            document.getElementById('remittancesFromDate').value = '';
            document.getElementById('remittancesToDate').value = '';
            if (document.getElementById('remittancesNameFilter')) document.getElementById('remittancesNameFilter').value =
                '';
            filterRemittancesByDate();
        }

        // Filter Payroll by Date Range + Name
        function filterPayrollByDate() {
            const fromDate = document.getElementById('payrollFromDate').value;
            const toDate = document.getElementById('payrollToDate').value;
            const nameFilter = document.getElementById('payrollNameFilter') ? document.getElementById('payrollNameFilter')
                .value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.payroll-row');

            tableRows.forEach(row => {
                const dateCell = row.querySelector('td:nth-child(8)').textContent; // Date Created column
                const rowDate = new Date(dateCell);
                const riderName = row.querySelector('td:nth-child(2)') ? row.querySelector('td:nth-child(2)')
                    .textContent.toLowerCase() : '';

                let showRow = true;

                if (fromDate) {
                    const from = new Date(fromDate);
                    from.setHours(0, 0, 0, 0);
                    if (rowDate < from) showRow = false;
                }

                if (toDate) {
                    const to = new Date(toDate);
                    to.setHours(23, 59, 59, 999);
                    if (rowDate > to) showRow = false;
                }

                if (nameFilter && riderName !== nameFilter) showRow = false;

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Clear Payroll Date Filter
        function clearPayrollDateFilter() {
            document.getElementById('payrollFromDate').value = '';
            document.getElementById('payrollToDate').value = '';
            if (document.getElementById('payrollNameFilter')) document.getElementById('payrollNameFilter').value = '';
            filterPayrollByDate();
        }

        // Filter Deductions by Date Range
        function filterDeductionsByDate() {
            const fromDate = document.getElementById('deductionsFromDate').value;
            const toDate = document.getElementById('deductionsToDate').value;
            const tableRows = document.querySelectorAll('.deduction-row');

            tableRows.forEach(row => {
                const dateCell = row.querySelector('td:nth-child(6)').textContent; // Date Created column
                const rowDate = new Date(dateCell);

                let showRow = true;

                if (fromDate) {
                    const from = new Date(fromDate);
                    from.setHours(0, 0, 0, 0);
                    if (rowDate < from) showRow = false;
                }

                if (toDate) {
                    const to = new Date(toDate);
                    to.setHours(23, 59, 59, 999);
                    if (rowDate > to) showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });
        }

        // Filter Deductions by Name
        function filterDeductionsByName() {
            const nameFilter = document.getElementById('deductionsNameFilter') ? document.getElementById(
                'deductionsNameFilter').value.toLowerCase() : '';
            const tableRows = document.querySelectorAll('.deduction-row');
            tableRows.forEach(row => {
                const riderName = row.querySelector('td:nth-child(2)') ? row.querySelector('td:nth-child(2)')
                    .textContent.toLowerCase() : '';
                row.style.display = (!nameFilter || riderName === nameFilter) ? '' : 'none';
            });
        }

        // Clear Deductions Date Filter
        function clearDeductionsDateFilter() {
            document.getElementById('deductionsFromDate').value = '';
            document.getElementById('deductionsToDate').value = '';
            if (document.getElementById('deductionsNameFilter')) document.getElementById('deductionsNameFilter').value = '';
            filterDeductionsByDate();
            filterDeductionsByName();
        }

        // Remit Modal Functions
        function getAutoTotalDeliveriesByRider(riderId) {
            const rawCount = riderTaskDeliveriesMap[String(riderId)] ?? riderTaskDeliveriesMap[riderId] ?? 0;
            const parsedCount = parseInt(rawCount, 10);
            return Number.isNaN(parsedCount) ? 0 : Math.max(0, parsedCount);
        }

        function getAutoTotalDeliveryChargeByRider(riderId) {
            const rawCharge = riderDeliveryChargesMap[String(riderId)] ?? riderDeliveryChargesMap[riderId] ?? 0;
            const parsedCharge = parseFloat(rawCharge);
            return Number.isNaN(parsedCharge) ? 0 : Math.max(0, parsedCharge);
        }

        function getAutoTotalTipsByRider(riderId) {
            const rawTips = riderTipsMap[String(riderId)] ?? riderTipsMap[riderId] ?? 0;
            const parsedTips = parseFloat(rawTips);
            return Number.isNaN(parsedTips) ? 0 : Math.max(0, parsedTips);
        }

        function getAutoTotalCollectionByRider(riderId) {
            const rawCollection = riderTotalCollectionMap[String(riderId)] ?? riderTotalCollectionMap[riderId] ?? 0;
            const parsedCollection = parseFloat(rawCollection);
            return Number.isNaN(parsedCollection) ? 0 : Math.max(0, parsedCollection);
        }

        function getAlreadyRemittedAmountByRider(riderId) {
            const rawRemitted = riderRemittedTotalsMap[String(riderId)] ?? riderRemittedTotalsMap[riderId] ?? 0;
            const parsedRemitted = parseFloat(rawRemitted);
            return Number.isNaN(parsedRemitted) ? 0 : Math.max(0, parsedRemitted);
        }

        function updateRemainingRemitHint() {
            const hintEl = document.getElementById('remainingRemitHint');
            const riderId = document.getElementById('remitRiderId')?.value;
            if (!hintEl || !riderId) return;

            const expectedTotal = getAutoTotalCollectionByRider(riderId);
            const alreadyRemitted = getAlreadyRemittedAmountByRider(riderId);
            const remainingBefore = Math.max(expectedTotal - alreadyRemitted, 0);
            const currentRemit = parseFloat(document.getElementById('totalRemit')?.value || '0') || 0;
            const remainingAfter = Math.max(remainingBefore - currentRemit, 0);

            if (alreadyRemitted > 0 && remainingBefore > 0) {
                hintEl.style.display = 'block';
                hintEl.style.color = '#b45309';
                hintEl.textContent = `Already remitted: ₱${alreadyRemitted.toFixed(2)} | Remaining: ₱${remainingBefore.toFixed(2)} | After this entry: ₱${remainingAfter.toFixed(2)}`;
                return;
            }

            if (remainingBefore <= 0 && expectedTotal > 0) {
                hintEl.style.display = 'block';
                hintEl.style.color = '#166534';
                hintEl.textContent = 'Fully remitted for selected date.';
                return;
            }

            hintEl.style.display = 'none';
            hintEl.textContent = '';
        }

        function updateTotalDeliveriesDateHint() {
            const hintEl = document.getElementById('totalDeliveriesHint');
            if (!hintEl) return;

            const statsDateInput = document.getElementById('statsDateInput');
            const rawDate = statsDateInput && statsDateInput.value ? statsDateInput.value : '';
            if (!rawDate) {
                hintEl.textContent = 'Based on tasks for selected date.';
                return;
            }

            const parsed = new Date(rawDate + 'T00:00:00');
            const isValidDate = !Number.isNaN(parsed.getTime());
            const displayDate = isValidDate ? parsed.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : rawDate;

            hintEl.textContent = `Based on tasks for ${displayDate}.`;
        }

        function updateTotalDeliveryFeeHint() {
            const hintEl = document.getElementById('totalDeliveryFeeHint');
            if (!hintEl) return;

            const statsDateInput = document.getElementById('statsDateInput');
            const rawDate = statsDateInput && statsDateInput.value ? statsDateInput.value : '';
            if (!rawDate) {
                hintEl.textContent = 'Based on delivery charges for selected date.';
                return;
            }

            const parsed = new Date(rawDate + 'T00:00:00');
            const isValidDate = !Number.isNaN(parsed.getTime());
            const displayDate = isValidDate ? parsed.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : rawDate;

            hintEl.textContent = `Based on delivery charges for ${displayDate}.`;
        }

        function updateTotalTipsHint() {
            const hintEl = document.getElementById('totalTipsHint');
            if (!hintEl) return;

            const statsDateInput = document.getElementById('statsDateInput');
            const rawDate = statsDateInput && statsDateInput.value ? statsDateInput.value : '';
            if (!rawDate) {
                hintEl.textContent = 'Based on order tips for selected date.';
                return;
            }

            const parsed = new Date(rawDate + 'T00:00:00');
            const isValidDate = !Number.isNaN(parsed.getTime());
            const displayDate = isValidDate ? parsed.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : rawDate;

            hintEl.textContent = `Based on order tips for ${displayDate}.`;
        }

        function updateTotalCollectionHint() {
            const hintEl = document.getElementById('totalCollectionHint');
            if (!hintEl) return;

            const statsDateInput = document.getElementById('statsDateInput');
            const rawDate = statsDateInput && statsDateInput.value ? statsDateInput.value : '';
            if (!rawDate) {
                hintEl.textContent = 'Based on total amount for selected date.';
                return;
            }

            const parsed = new Date(rawDate + 'T00:00:00');
            const isValidDate = !Number.isNaN(parsed.getTime());
            const displayDate = isValidDate ? parsed.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            }) : rawDate;

            hintEl.textContent = `Based on total amount for ${displayDate}.`;
        }

        function openRemitModal(riderId, riderName) {
            const selectedRow = document.querySelector(`[data-rider-id="${riderId}"]`);
            if (selectedRow && selectedRow.dataset.remitted === 'true') {
                showToast('This rider is already fully remitted for the selected date.', 'warning');
                return;
            }

            // Highlight the active dropdown
            document.querySelectorAll('.rider-dropdown').forEach(d => d.classList.remove('active-highlight'));
            if (selectedRow) {
                const dropdown = selectedRow.querySelector('.rider-dropdown');
                if (dropdown) dropdown.classList.add('active-highlight');
            }

            document.getElementById('remitModal').classList.add('active');
            document.getElementById('remitRiderId').value = riderId;
            document.getElementById('remitRiderName').value = riderName;
            document.getElementById('displayRiderName').value = riderName;
            document.getElementById('totalDeliveries').value = getAutoTotalDeliveriesByRider(riderId);
            document.getElementById('totalDeliveryFee').value = getAutoTotalDeliveryChargeByRider(riderId);
            document.getElementById('totalCollection').value = getAutoTotalCollectionByRider(riderId).toFixed(2);
            document.getElementById('totalTips').value = getAutoTotalTipsByRider(riderId).toFixed(2);
            updateTotalDeliveriesDateHint();
            updateTotalDeliveryFeeHint();
            updateTotalCollectionHint();
            updateTotalTipsHint();

            const expectedTotal = getAutoTotalCollectionByRider(riderId);
            const alreadyRemitted = getAlreadyRemittedAmountByRider(riderId);
            const remainingBefore = Math.max(expectedTotal - alreadyRemitted, 0);
            if (alreadyRemitted > 0 && remainingBefore > 0) {
                document.getElementById('totalRemit').value = remainingBefore.toFixed(2);
            }
            updateRemainingRemitHint();

            // Reset Mangan entries
            closeManganModal();
            manganEntries = [];
            syncManganEntriesJson();
            renderManganEntries();
            updateManganBadge();

            document.getElementById('totalDeliveries').focus();
        }

        function closeRemitModal() {
            document.getElementById('remitModal').classList.remove('active');
            document.getElementById('remitForm').reset();
            const hintEl = document.getElementById('remainingRemitHint');
            if (hintEl) {
                hintEl.style.display = 'none';
                hintEl.textContent = '';
            }
            resetRemitRemarksRows();
            closeManganModal();
            manganEntries = [];
            syncManganEntriesJson();
            renderManganEntries();
            updateManganBadge();
        }

        // Calculate Total Remit (Total Delivery Fee - 5%)
        // Removed computation logic for total remit and total delivery fee. Both are now simple input fields.

        // Close remit modal when clicking outside - DISABLED
        // document.getElementById('remitModal').addEventListener('click', function(event) {
        //     if (event.target === this) {
        //         closeRemitModal();
        //     }
        // });

        // Store pending remittance data
        let pendingRemittance = null;

        function submitRemit() {
            const form = document.getElementById('remitForm');
            if (form.checkValidity()) {
                const remarksData = consolidateRemitRemarks();
                if (!remarksData.valid) {
                    return;
                }

                // Get selected payment modes
                const selectedModes = Array.from(document.querySelectorAll('.payment-mode-checkbox:checked'))
                    .map(cb => cb.value);

                if (selectedModes.length === 0) {
                    showToast('Please select at least one Mode of Payment', 'warning');
                    return;
                }

                const formData = new FormData(form);
                const riderId = document.getElementById('remitRiderId').value;
                const riderName = document.getElementById('remitRiderName').value;
                const totalDeliveries = document.getElementById('totalDeliveries').value;
                const totalDeliveryFee = document.getElementById('totalDeliveryFee').value;
                const totalRemit = document.getElementById('totalRemit').value;
                const totalTips = document.getElementById('totalTips').value || 0;
                const totalCollection = document.getElementById('totalCollection').value;
                const remitPhoto = document.getElementById('remitPhoto').files[0];
                const remarks = remarksData.combinedRemarks;
                const remarksAmount = '';

                // Collect payment breakdown amounts
                const paymentBreakdown = {};
                selectedModes.forEach(mode => {
                    const amountInput = document.getElementById(`amount${mode.charAt(0).toUpperCase() + mode.slice(1)}`);
                    paymentBreakdown[mode] = amountInput ? parseFloat(amountInput.value) || 0 : 0;
                });

                // Convert selected modes to string format
                const modeOfPayment = selectedModes.length === 1 ? selectedModes[0] : 'multiple';
                
                // Remove the old mode_of_payment if exists and set the new one
                formData.delete('mode_of_payment');
                formData.set('mode_of_payment', modeOfPayment);
                formData.set('payment_modes_json', JSON.stringify(selectedModes));
                formData.set('payment_breakdown_json', JSON.stringify(paymentBreakdown));

                // Store form data for later submission
                pendingRemittance = {
                    formData: formData,
                    riderId: riderId,
                    riderName: riderName,
                    totalDeliveries: totalDeliveries,
                    totalDeliveryFee: totalDeliveryFee,
                    totalRemit: totalRemit,
                    totalTips: totalTips,
                    totalCollection: totalCollection,
                    modeOfPayment: modeOfPayment,
                    selectedModes: selectedModes,
                    paymentBreakdown: paymentBreakdown,
                    remitPhoto: remitPhoto,
                    remarks: remarks,
                    remarksAmount: remarksAmount,
                    remarkEntries: remarksData.entries
                };

                // Update the details panel
                const riderNameElement = document.getElementById('detailsRiderName');
                if (riderNameElement) {
                    riderNameElement.textContent = riderName;
                }

                const collectionAmount = parseFloat(totalCollection) || 0;

                // Base cash collection on Total Amount field value.
                let cashAmount = collectionAmount;
                let digitalAmount = 0;

                if (!selectedModes.includes('cash')) {
                    cashAmount = 0;
                }
                if (selectedModes.includes('gcash')) {
                    digitalAmount = paymentBreakdown['gcash'] || 0;
                }

                // If no specific breakdown amounts entered, split equally
                if (cashAmount === 0 && digitalAmount === 0) {
                    if (selectedModes.length === 2) {
                        cashAmount = collectionAmount / 2;
                        digitalAmount = collectionAmount / 2;
                    } else if (selectedModes.length === 1) {
                        if (selectedModes[0] === 'cash') {
                            cashAmount = collectionAmount;
                        } else if (selectedModes[0] === 'gcash') {
                            digitalAmount = collectionAmount;
                        }
                    }
                }

                document.getElementById('cashCollectionDisplay').textContent = '₱' + cashAmount.toFixed(2).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('digitalCollectionDisplay').textContent = '₱' + digitalAmount.toFixed(2).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('netTurnoverDisplay').textContent = '₱' + parseFloat(totalRemit || 0).toFixed(2)
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Update remarks in details panel
                const remarksSection = document.querySelector('.expenses-section .expenses-content');
                if (remarksSection) {
                    if (Array.isArray(remarksData.entries) && remarksData.entries.length > 0) {
                        const remarksHtml = remarksData.entries.map((entry) => {
                            const amountPart = entry.amount > 0
                                ? ` <span style="color: #436026; font-weight: 700;">₱${entry.amount.toFixed(2)}</span>`
                                : '';
                            return `<p style="position: relative; z-index: 1; font-weight: 500; margin: 0 0 4px 0;">- ${entry.remarks}${amountPart}</p>`;
                        }).join('');
                        remarksSection.innerHTML = remarksHtml;
                    } else if (remarks && remarks.trim() !== '') {
                        remarksSection.innerHTML =
                            `<p style="position: relative; z-index: 1; font-weight: 500;">${remarks}</p>`;
                    } else {
                        remarksSection.innerHTML = `<p style="position: relative; z-index: 1; font-weight: 500;">-</p>`;
                    }
                }

                // Enable confirm receipt and edit buttons
                const confirmBtn = document.getElementById('confirmReceiptBtn');
                confirmBtn.disabled = false;
                confirmBtn.style.opacity = '1';
                confirmBtn.style.cursor = 'pointer';

                const editBtn = document.getElementById('editRemitBtn');
                editBtn.disabled = false;
                editBtn.style.opacity = '1';
                editBtn.style.cursor = 'pointer';

                // Show/hide view photo button
                if (remitPhoto) {
                    document.getElementById('viewPhotoBtn').style.display = 'flex';
                } else {
                    document.getElementById('viewPhotoBtn').style.display = 'none';
                }

                // Close modal
                closeRemitModal();

                // Show success message
                showToast('Remittance form submitted! Please review the details and click "Confirm Receipt" to save.',
                    'success');
            } else {
                form.reportValidity();
            }
        }

        function confirmReceipt() {
            if (!pendingRemittance) {
                showToast('No pending remittance to confirm.', 'warning');
                return;
            }

            const confirmBtn = document.getElementById('confirmReceiptBtn');
            const originalText = confirmBtn.innerHTML;
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Append the currently-viewed stats date so the remittance is
            // recorded for the correct date even when submitting on a past date.
            const statsDateInput = document.getElementById('statsDateInput');
            if (statsDateInput && statsDateInput.value) {
                pendingRemittance.formData.set('remittance_date', statsDateInput.value);
            }

            // Send AJAX request to save remittance
            fetch('/remittances', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: pendingRemittance.formData
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => ({
                            response,
                            data
                        }));
                    } else {
                        return response.text().then(text => {
                            throw new Error(
                                `Server returned non-JSON response: ${response.status} ${response.statusText}`
                            );
                        });
                    }
                })
                .then(({
                    response,
                    data
                }) => {
                    if (!response.ok) {
                        // Handle validation errors (422)
                        if (response.status === 422 && data.errors) {
                            const errorMessages = Object.entries(data.errors)
                                .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                                .join('\n');
                            throw new Error(`Validation failed:\n${errorMessages}`);
                        }
                        throw new Error(data.message ||
                            `Failed to save remittance: ${response.status} ${response.statusText}`);
                    }
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to submit remittance');
                    }

                    if (pendingRemittance) {
                        pendingRemittance.saveResult = data;
                    }

                    console.log('Remittance saved, updating rider status...');

                    // Update rider status to cleared
                    return fetch(`/riders/${pendingRemittance.riderId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            name: pendingRemittance.riderName,
                            status: 'cleared'
                        })
                    });
                })
                .then(response => {
                    const contentType = response.headers.get('content-type');
                    if (contentType && contentType.includes('application/json')) {
                        return response.json().then(data => ({
                            response,
                            data
                        }));
                    } else {
                        return response.text().then(text => {
                            throw new Error(
                                `Server returned non-JSON response: ${response.status} ${response.statusText}`
                            );
                        });
                    }
                })
                .then(({
                    response,
                    data
                }) => {
                    if (!response.ok) {
                        // Handle validation errors (422)
                        if (response.status === 422 && data.errors) {
                            const errorMessages = Object.entries(data.errors)
                                .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                                .join('\n');
                            throw new Error(`Validation failed:\n${errorMessages}`);
                        }
                        throw new Error(data.message ||
                            `Failed to update rider status: ${response.status} ${response.statusText}`);
                    }
                    if (!data.success) {
                        throw new Error(data.message || 'Failed to update rider status');
                    }

                    console.log('Rider status updated to cleared successfully!');

                    const saveResult = pendingRemittance && pendingRemittance.saveResult ? pendingRemittance.saveResult : null;

                    // Keep badge as Pending — Cleared only shows the next day
                    // when viewing this date as a past date.

                    // Clear pending remittance
                    pendingRemittance = null;

                    // Clear the remittance details panel
                    document.getElementById('detailsRiderName').textContent = '';
                    document.getElementById('cashCollectionDisplay').textContent = '₱0.00';
                    document.getElementById('digitalCollectionDisplay').textContent = '₱0.00';
                    document.getElementById('netTurnoverDisplay').textContent = '₱0.00';
                    document.getElementById('viewPhotoBtn').style.display = 'none';

                    // Disable confirm and edit buttons again
                    confirmBtn.disabled = true;
                    confirmBtn.style.opacity = '0.5';
                    confirmBtn.style.cursor = 'not-allowed';
                    confirmBtn.innerHTML = originalText;

                    const editBtn = document.getElementById('editRemitBtn');
                    editBtn.disabled = true;
                    editBtn.style.opacity = '0.5';
                    editBtn.style.cursor = 'not-allowed';

                    // Show success message
                    if (saveResult && saveResult.is_complete === false) {
                        const remaining = Number(saveResult.remaining_amount || 0);
                        showToast(`Partial remittance saved in the same record. Remaining: ₱${remaining.toFixed(2)}.`, 'info');
                    } else {
                        showToast('Remittance is now complete and saved in the same record. Page will reload.', 'success');
                    }

                    // Reload page after 2 seconds to update the cleared riders table
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                })
                .catch(error => {
                    console.error('Error in confirmReceipt:', error);
                    showToast('Failed to confirm receipt: ' + error.message, 'error');
                    confirmBtn.disabled = false;
                    confirmBtn.style.opacity = '1';
                    confirmBtn.style.cursor = 'pointer';
                    confirmBtn.innerHTML = originalText;
                });
        }

        function editRemittance() {
            if (!pendingRemittance) {
                showToast('No pending remittance to edit.', 'warning');
                return;
            }

            // Open the remit modal
            document.getElementById('remitModal').classList.add('active');

            // Pre-fill all form fields with current values
            document.getElementById('remitRiderId').value = pendingRemittance.riderId;
            document.getElementById('remitRiderName').value = pendingRemittance.riderName;
            document.getElementById('displayRiderName').value = pendingRemittance.riderName;
            document.getElementById('totalDeliveries').value = pendingRemittance.totalDeliveries;
            document.getElementById('totalDeliveryFee').value = pendingRemittance.totalDeliveryFee;
            document.getElementById('totalRemit').value = pendingRemittance.totalRemit;
            document.getElementById('totalTips').value = pendingRemittance.totalTips;
            document.getElementById('totalCollection').value = pendingRemittance.totalCollection;

            const paymentModeCheckboxes = document.querySelectorAll('.payment-mode-checkbox');
            paymentModeCheckboxes.forEach(cb => {
                cb.checked = Array.isArray(pendingRemittance.selectedModes) && pendingRemittance.selectedModes.includes(cb.value);
            });
            if (typeof window.refreshPaymentBreakdown === 'function') {
                window.refreshPaymentBreakdown();
            }
            updateRemainingRemitHint();

            resetRemitRemarksRows();
            if (Array.isArray(pendingRemittance.remarkEntries) && pendingRemittance.remarkEntries.length > 0) {
                const firstRow = document.querySelector('#remitRemarksRows .remit-remark-row');
                if (firstRow) {
                    firstRow.querySelector('.remit-remarks-input').value = pendingRemittance.remarkEntries[0].remarks || '';
                    firstRow.querySelector('.remit-remarks-amount').value = pendingRemittance.remarkEntries[0].amount || '';
                }
                for (let i = 1; i < pendingRemittance.remarkEntries.length; i++) {
                    addRemitRemarkRow(pendingRemittance.remarkEntries[i].remarks || '', pendingRemittance.remarkEntries[i].amount || '');
                }
            } else {
                const firstRow = document.querySelector('#remitRemarksRows .remit-remark-row');
                if (firstRow) {
                    firstRow.querySelector('.remit-remarks-input').value = pendingRemittance.remarks || '';
                    firstRow.querySelector('.remit-remarks-amount').value = pendingRemittance.remarksAmount || '';
                }
            }

            // Note: File input cannot be pre-filled for security reasons
            // The user will need to re-upload if they want to change the photo

            document.getElementById('totalDeliveries').focus();
        }

        function viewRemitPhoto() {
            if (pendingRemittance && pendingRemittance.remitPhoto) {
                // Create a temporary URL for the file
                const photoUrl = URL.createObjectURL(pendingRemittance.remitPhoto);

                // Open in a modal or new window
                const photoWindow = window.open('', 'Remit Photo', 'width=800,height=600');
                photoWindow.document.write(`
                    <html>
                        <head>
                            <title>Remit Photo</title>
                            <style>
                                body { margin: 0; display: flex; justify-content: center; align-items: center; background: #000; }
                                img { max-width: 100%; max-height: 100vh; }
                            </style>
                        </head>
                        <body>
                            <img src="${photoUrl}" alt="Remit Photo">
                        </body>
                    </html>
                `);
            } else {
                showToast('No photo attached.', 'warning');
            }
        }

        // Add click handlers to existing remit buttons
        document.addEventListener('DOMContentLoaded', function() {
            const riderItems = document.querySelectorAll('.rider-row');
            riderItems.forEach((row) => {
                const riderId = row.getAttribute('data-rider-id');
                const riderName = row.querySelector('.rider-item-info strong').textContent;
                const remitBtn = row.querySelector('.rider-action-btn:not(.records-btn)');
                if (remitBtn && riderId) {
                    remitBtn.setAttribute('onclick', `openRemitModal(${riderId}, '${riderName}')`);
                }
            });
            
            // Initialize automatic ADDA DF calculation listeners
            if (typeof attachAddaDfAmountListeners === 'function') {
                attachAddaDfAmountListeners();
            }
        });

        // Show toast for session success messages
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('success') }}', 'success');
            });
        @endif

        /* =================== REPORT GENERATION =================== */
        function openReportModal() {
            // Default: today for both dates
            const today = new Date().toISOString().substring(0, 10);
            document.getElementById('reportDateFrom').value = today;
            document.getElementById('reportDateTo').value = today;
            document.getElementById('reportRider').value = 'all';
            document.getElementById('reportPaymentMode').value = 'all';
            document.getElementById('reportModalOverlay').classList.add('active');
        }

        function closeReportModal() {
            document.getElementById('reportModalOverlay').classList.remove('active');
        }

        document.getElementById('reportModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeReportModal();
        });

        function buildReportParams() {
            const params = new URLSearchParams();
            const dateFrom = document.getElementById('reportDateFrom').value;
            const dateTo = document.getElementById('reportDateTo').value;
            const rider = document.getElementById('reportRider').value;
            const mode = document.getElementById('reportPaymentMode').value;
            if (dateFrom) params.set('date_from', dateFrom);
            if (dateTo) params.set('date_to', dateTo);
            if (rider && rider !== 'all') params.set('rider_id', rider);
            if (mode && mode !== 'all') params.set('payment_mode', mode);
            params.set('status', 'confirmed'); // reports always show cleared only
            return params;
        }

        async function fetchReportData() {
            const params = buildReportParams();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('/remittances-report?' + params.toString(), {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            return res.json();
        }

        function fmtMoney(val) {
            return '₱' + Number(val || 0).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        async function generateReportPreview() {
            const btn = document.getElementById('reportPreviewBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            try {
                const data = await fetchReportData();
                if (!data.success) throw new Error('Failed to fetch report data');

                const groupBy = 'none';
                const dateFrom = document.getElementById('reportDateFrom').value || 'All';
                const dateTo = document.getElementById('reportDateTo').value || 'All';
                const riderSel = document.getElementById('reportRider');
                const riderLabel = riderSel.options[riderSel.selectedIndex].text;
                const modeSel = document.getElementById('reportPaymentMode');
                const modeLabel = modeSel.options[modeSel.selectedIndex].text;
                const generatedBy = '{{ addslashes(auth()->user()->name ?? 'N/A') }}';
                const generatedAt = new Date().toLocaleString('en-PH');

                const s = data.summary;

                let detailRows = '';
                if (groupBy === 'rider') {
                    data.riderBreakdown.forEach(r => {
                        detailRows += `<tr>
                            <td>${r.rider_name}</td>
                            <td style="text-align:center">${r.total_records}</td>
                            <td style="text-align:center">${r.total_deliveries}</td>
                            <td style="text-align:right">${fmtMoney(r.total_delivery_fee)}</td>
                            <td style="text-align:right">${fmtMoney(r.total_remit)}</td>
                            <td style="text-align:right">${fmtMoney(r.total_tips)}</td>
                            <td style="text-align:right">${fmtMoney(r.total_collection)}</td>
                        </tr>`;
                    });
                } else if (groupBy === 'date') {
                    const byDate = {};
                    data.remittances.forEach(r => {
                        const d = r.created_at ? r.created_at.substring(0, 10) : 'Unknown';
                        if (!byDate[d]) byDate[d] = {
                            records: 0,
                            deliveries: 0,
                            delivery_fee: 0,
                            remit: 0,
                            tips: 0,
                            collection: 0
                        };
                        byDate[d].records++;
                        byDate[d].deliveries += Number(r.total_deliveries);
                        byDate[d].delivery_fee += Number(r.total_delivery_fee);
                        byDate[d].remit += Number(r.total_remit);
                        byDate[d].tips += Number(r.total_tips);
                        byDate[d].collection += Number(r.total_collection);
                    });
                    Object.keys(byDate).sort().forEach(d => {
                        const g = byDate[d];
                        detailRows += `<tr>
                            <td>${d}</td>
                            <td style="text-align:center">${g.records}</td>
                            <td style="text-align:center">${g.deliveries}</td>
                            <td style="text-align:right">${fmtMoney(g.delivery_fee)}</td>
                            <td style="text-align:right">${fmtMoney(g.remit)}</td>
                            <td style="text-align:right">${fmtMoney(g.tips)}</td>
                            <td style="text-align:right">${fmtMoney(g.collection)}</td>
                        </tr>`;
                    });
                } else if (groupBy === 'payment_mode') {
                    const byMode = {};
                    data.remittances.forEach(r => {
                        const m = r.mode_of_payment || 'Unknown';
                        if (!byMode[m]) byMode[m] = {
                            records: 0,
                            deliveries: 0,
                            delivery_fee: 0,
                            remit: 0,
                            tips: 0,
                            collection: 0
                        };
                        byMode[m].records++;
                        byMode[m].deliveries += Number(r.total_deliveries);
                        byMode[m].delivery_fee += Number(r.total_delivery_fee);
                        byMode[m].remit += Number(r.total_remit);
                        byMode[m].tips += Number(r.total_tips);
                        byMode[m].collection += Number(r.total_collection);
                    });
                    Object.keys(byMode).forEach(m => {
                        const g = byMode[m];
                        detailRows += `<tr>
                            <td>${m.toUpperCase()}</td>
                            <td style="text-align:center">${g.records}</td>
                            <td style="text-align:center">${g.deliveries}</td>
                            <td style="text-align:right">${fmtMoney(g.delivery_fee)}</td>
                            <td style="text-align:right">${fmtMoney(g.remit)}</td>
                            <td style="text-align:right">${fmtMoney(g.tips)}</td>
                            <td style="text-align:right">${fmtMoney(g.collection)}</td>
                        </tr>`;
                    });
                } else {
                    // No grouping – show individual records
                    let rowNum = 0;
                    data.remittances.forEach(r => {
                        rowNum++;
                        const riderName = (r.rider && r.rider.name) ? r.rider.name : 'N/A';
                        const dateStr = r.created_at ? r.created_at.substring(0, 10) : '';
                        const modeRaw = r.mode_of_payment || '';
                        const modeBadge = modeRaw ?
                            `<span class="badge-mode badge-${modeRaw.toLowerCase()}">${modeRaw.toUpperCase()}</span>` :
                            '';
                        const remarksHtml = (() => {
                            const raw = r.remarks || '';
                            if (!raw.trim()) return `<span class="remarks-empty">&mdash;</span>`;
                            const lines = raw.split(/\s*\|\s*|\r?\n/).map(line => line.trim()).filter(Boolean);
                            return `<div class="remarks-lines">${lines.map(line => `<div class="remarks-line">${escapeHtml(line)}</div>`).join('')}</div>`;
                        })();
                        detailRows += `<tr>
                            <td style="text-align:center"><span class="task-num">${rowNum}</span></td>
                            <td><strong>${riderName}</strong></td>
                            <td style="white-space:nowrap">${dateStr}</td>
                            <td style="text-align:center;font-weight:600">${r.total_deliveries}</td>
                            <td style="text-align:right">${fmtMoney(r.total_delivery_fee)}</td>
                            <td style="text-align:right;font-weight:700;color:#436026">${fmtMoney(r.total_remit)}</td>
                            <td style="text-align:right">${fmtMoney(r.total_tips)}</td>
                            <td style="text-align:right;font-weight:700;color:#2b5c1a">${fmtMoney(r.total_collection)}</td>
                            <td style="text-align:center">${modeBadge}</td>
                            <td style="max-width:160px;word-break:break-word">${remarksHtml}</td>
                        </tr>`;
                    });
                }

                const groupedHeader = (groupBy === 'none') ?
                    `<tr>
                          <th style="padding:11px 14px;text-align:center;width:48px"># Task</th>
                          <th style="padding:11px 14px;text-align:left">Rider</th>
                          <th style="padding:11px 14px;text-align:left">Date</th>
                          <th style="padding:11px 14px;text-align:center">Deliveries</th>
                          <th style="padding:11px 14px;text-align:right">Del. Fee</th>
                          <th style="padding:11px 14px;text-align:right">Total Remit</th>
                          <th style="padding:11px 14px;text-align:right">Tips</th>
                          <th style="padding:11px 14px;text-align:right">Collection</th>
                          <th style="padding:11px 14px;text-align:center">Mode</th>
                          <th style="padding:11px 14px;text-align:left">Remarks</th>
                       </tr>` :
                    `<tr>
                          <th style="padding:11px 14px;text-align:left">${groupBy === 'rider' ? 'Rider' : groupBy === 'date' ? 'Date' : 'Payment Mode'}</th>
                          <th style="padding:11px 14px;text-align:center">Records</th>
                          <th style="padding:11px 14px;text-align:center">Deliveries</th>
                          <th style="padding:11px 14px;text-align:right">Del. Fee</th>
                          <th style="padding:11px 14px;text-align:right">Total Remit</th>
                          <th style="padding:11px 14px;text-align:right">Tips</th>
                          <th style="padding:11px 14px;text-align:right">Collection</th>
                       </tr>`;

                const html = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Remittance Report</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #e8e8e8; color: #1a1a1a; }

        /* ── Page wrapper ── */
        .page { max-width: 1100px; margin: 0 auto; padding: 32px 28px 48px; }

        /* ── Banner header ── */
        .banner {
            background: linear-gradient(135deg, #2b3d12 0%, #436026 55%, #5a7d33 100%);
            border-radius: 16px 16px 0 0;
            padding: 28px 32px 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            position: relative;
            overflow: hidden;
        }
        .banner::after {
            content: '';
            position: absolute;
            right: -40px; top: -40px;
            width: 220px; height: 220px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }
        .banner-left h1 {
            font-size: 26px; font-weight: 800; color: #fff;
            letter-spacing: -0.4px; line-height: 1.15;
        }
        .banner-left .sub {
            font-size: 12px; color: rgba(255,255,255,0.65);
            margin-top: 5px; display: flex; align-items: center; gap: 6px;
        }
        .banner-right {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 6px;
            align-items: flex-end;
        }
        .meta-row {
            display: flex;
            align-items: center;
            gap: 0;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(144,200,90,0.40);
            border-radius: 7px;
            overflow: hidden;
            min-width: 260px;
        }
        .meta-label {
            background: rgba(90,125,51,0.55);
            color: #d4f5a0;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            padding: 5px 10px;
            width: 108px;
            flex-shrink: 0;
            text-align: right;
            border-right: 1px solid rgba(144,200,90,0.35);
        }
        .meta-value {
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 12px;
            flex: 1;
            text-align: left;
            letter-spacing: 0.2px;
        }

        /* ── Accent bar ── */
        .accent-bar {
            height: 5px;
            background: linear-gradient(90deg, #ffd300 0%, #f0b800 50%, #e6a800 100%);
            border-radius: 0;
        }

        /* ── White card body ── */
        .card-body {
            background: #fff;
            border-radius: 0 0 16px 16px;
            padding: 28px 32px 32px;
            box-shadow: 0 8px 32px rgba(67,96,38,0.12);
        }

        /* ── Section label ── */
        .section-label {
            font-size: 10px; font-weight: 800; letter-spacing: 1.2px;
            text-transform: uppercase; color: #436026;
            margin-bottom: 12px; display: flex; align-items: center; gap: 7px;
        }
        .section-label::after {
            content: ''; flex: 1; height: 1px; background: #d6e8c8;
        }

        /* ── Summary grid ── */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 28px;
        }
        .s-card {
            border-radius: 12px;
            padding: 16px 18px;
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }
        .s-card.green1 { background: linear-gradient(135deg,#f0f7e8,#e4f1d4); border-color: #b8d98a; }
        .s-card.green2 { background: linear-gradient(135deg,#e8f5e0,#d9efc6); border-color: #a8d070; }
        .s-card.green3 { background: linear-gradient(135deg,#ebf5e2,#ddf0c8); border-color: #b0d880; }
        .s-card.gold1  { background: linear-gradient(135deg,#fffbea,#fff3c2); border-color: #ffd300; }
        .s-card.gold2  { background: linear-gradient(135deg,#fff8d6,#ffeeaa); border-color: #f5c200; }
        .s-card.gold3  { background: linear-gradient(135deg,#fffadf,#fff1b8); border-color: #efc000; }
        .s-card.olive1 { background: linear-gradient(135deg,#f5f7ee,#eaefd8); border-color: #c8d4a6; }
        .s-card.olive2 { background: linear-gradient(135deg,#f2f5e8,#e6ecce); border-color: #beca96; }
        .s-card.olive3 { background: linear-gradient(135deg,#f8f9f3,#eef0e2); border-color: #d0d8b8; }
        .s-card .s-icon {
            font-size: 22px; margin-bottom: 8px; opacity: 0.60;
        }
        .s-card .s-label {
            font-size: 10px; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.7px; color: #4a5a30; margin-bottom: 4px;
        }
        .s-card .s-value {
            font-size: 20px; font-weight: 800; color: #2b3d12; line-height: 1;
        }
        .s-card .s-value.lg { font-size: 22px; }

        /* ── Divider ── */
        .divider { height: 1px; background: #d6e8c8; margin: 6px 0 22px; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid #c8d8a8; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: linear-gradient(135deg, #2b3d12 0%, #436026 100%); }
        thead th {
            padding: 11px 14px; color: #fff; font-size: 11px;
            font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;
            white-space: nowrap;
        }
        thead th:first-child { border-radius: 11px 0 0 0; }
        thead th:last-child  { border-radius: 0 11px 0 0; }
        tbody tr { transition: background 0.15s; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr:nth-child(even) { background: #f5f9f2; }
        tbody td {
            padding: 9px 14px; border-bottom: 1px solid #e4eeda;
            vertical-align: middle; color: #1a1a1a;
        }
        tbody tr:last-child td { border-bottom: none; }
        .badge-cleared {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            background: linear-gradient(135deg,#d4edda,#c3e6cb); color: #155724;
            font-size: 11px; font-weight: 700; border: 1px solid #a8d4b4;
        }
        .badge-pending {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            background: linear-gradient(135deg,#fff3cd,#ffe69c); color: #856404;
            font-size: 11px; font-weight: 700; border: 1px solid #ffc107;
        }
        .badge-mode {
            display: inline-block; padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
        }
        .badge-cash  { background: linear-gradient(135deg,#e8f5e0,#d4edda); color: #2b5c1a; border: 1px solid #94c97a; }
        .badge-gcash { background: linear-gradient(135deg,#fffbea,#fff3c2); color: #7a6000; border: 1px solid #ffd300; }
        .badge-bank  { background: linear-gradient(135deg,#f0f7e8,#e4f1d4); color: #436026; border: 1px solid #9ac460; }
        .task-num {
            display: inline-flex; align-items: center; justify-content: center;
            width: 24px; height: 24px; border-radius: 50%;
            background: #e4f1d4; color: #436026; font-size: 11px; font-weight: 700;
            border: 1px solid #b8d98a;
        }
        tfoot tr { background: linear-gradient(135deg, #2b3d12 0%, #436026 100%); }
        tfoot td {
            padding: 11px 14px; color: #fff; font-weight: 700; font-size: 13px;
        }
        tfoot td:first-child { border-radius: 0 0 0 11px; }
        tfoot td:last-child  { border-radius: 0 0 11px 0; }
        .remarks-text { color: #555; font-size: 12px; font-style: italic; }
        .remarks-lines { display: grid; gap: 4px; }
        .remarks-line { color: #555; font-size: 12px; line-height: 1.35; white-space: normal; word-break: break-word; }
        .remarks-empty { color: #bbb; font-size: 12px; }

        /* ── Footer strip ── */
        .report-footer {
            margin-top: 20px; padding-top: 16px; border-top: 1px solid #d6e8c8;
            display: flex; justify-content: space-between; align-items: center;
            font-size: 11px; color: #888;
        }

        /* ── Print button ── */
        .print-btn-bar { text-align: center; margin-top: 28px; }
        .print-btn {
            display: inline-flex; align-items: center; gap: 10px;
            background: linear-gradient(135deg, #2b3d12 0%, #5a7d33 100%);
            color: #fff; border: none; padding: 13px 32px;
            border-radius: 10px; font-size: 14px; font-weight: 700;
            cursor: pointer; box-shadow: 0 4px 14px rgba(67,96,38,0.35);
            transition: transform 0.15s, box-shadow 0.15s;
            letter-spacing: 0.3px;
        }
        .print-btn:hover { transform: translateY(-2px); box-shadow: 0 7px 20px rgba(67,96,38,0.45); }
        .print-btn svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }

        @media print {
            @page { margin: 10mm 8mm; size: A4 landscape; }
            body { background: #fff; font-size: 10px; }
            .page { padding: 0; max-width: 100%; }
            .banner { border-radius: 0; padding: 10px 14px 9px; }
            .banner-left h1 { font-size: 15px; }
            .banner-left .sub { font-size: 9px; margin-top: 2px; }
            .banner-right { gap: 4px; }
            .meta-row { min-width: 200px; border-radius: 4px; border-color: rgba(144,200,90,0.35); }
            .meta-label { font-size: 8px; padding: 3px 7px; width: 80px; }
            .meta-value { font-size: 9px; padding: 3px 8px; }
            .banner::after { display: none; }
            .accent-bar { height: 3px; }
            .card-body { box-shadow: none; border-radius: 0; padding: 10px 14px 14px; }
            .section-label { font-size: 8px; margin-bottom: 6px; }
            .summary-grid { gap: 6px; margin-bottom: 12px; }
            .s-card { padding: 7px 9px; border-radius: 6px; }
            .s-card .s-icon { font-size: 13px; margin-bottom: 3px; }
            .s-card .s-label { font-size: 7px; letter-spacing: 0.3px; margin-bottom: 2px; }
            .s-card .s-value { font-size: 12px; }
            .s-card .s-value.lg { font-size: 13px; }
            .divider { margin: 4px 0 10px; }
            .table-wrap { border: none; border-radius: 0; }
            table { font-size: 9px; }
            thead th { padding: 5px 7px; font-size: 8px; letter-spacing: 0.2px; }
            thead th:first-child, thead th:last-child { border-radius: 0; }
            tbody td { padding: 4px 7px; }
            tfoot td { padding: 5px 7px; font-size: 9px; }
            tfoot td:first-child, tfoot td:last-child { border-radius: 0; }
            .badge-cleared, .badge-pending, .badge-mode {
                padding: 1px 5px; font-size: 8px; border-radius: 10px;
            }
            .task-num { width: 16px; height: 16px; font-size: 8px; }
            .remarks-text, .remarks-empty { font-size: 8px; }
            .report-footer { margin-top: 8px; padding-top: 6px; font-size: 8px; }
            .print-btn-bar { display: none; }
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Banner -->
    <div class="banner">
        <div class="banner-left">
            <h1>&#128196; Remittance Report</h1>
            <div class="sub">
                <span>&#128197; Generated: ${generatedAt}</span>
            </div>
        </div>
        <div class="banner-right">
            <div class="meta-row">
                <div class="meta-label">Date Range</div>
                <div class="meta-value">${dateFrom} &ndash; ${dateTo}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Rider</div>
                <div class="meta-value">${riderLabel}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Mode</div>
                <div class="meta-value">${modeLabel}</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Status</div>
                <div class="meta-value" style="color:#a8e06a;">Cleared Only</div>
            </div>
            <div class="meta-row">
                <div class="meta-label">Generated By</div>
                <div class="meta-value">${generatedBy}</div>
            </div>
        </div>
    </div>
    <div class="accent-bar"></div>

    <div class="card-body">

        <!-- Detail Table -->
        <div class="section-label">&#128203; Transaction Details</div>
        <div class="table-wrap">
        <table>
            <thead>${groupedHeader}</thead>
            <tbody>${detailRows || '<tr><td colspan="10" style="text-align:center;padding:32px;color:#aaa;font-size:14px;">No records found for the selected filters.</td></tr>'}</tbody>
            <tfoot>
                <tr>
                    <td colspan="${groupBy === 'none' ? 5 : 4}">TOTALS</td>
                    <td style="text-align:right">${fmtMoney(s.total_remit)}</td>
                    <td style="text-align:right">${fmtMoney(s.total_tips)}</td>
                    <td style="text-align:right">${fmtMoney(s.total_collection)}</td>
                    ${groupBy === 'none' ? '<td></td><td></td>' : ''}
                </tr>
            </tfoot>
        </table>
        </div>

        <!-- Footer -->
        <div class="report-footer">
            <span>WIB System &mdash; Remittance Report</span>
            <span>Total of <strong>${s.total_records}</strong> record(s) &nbsp;|&nbsp; ${dateFrom} to ${dateTo}</span>
        </div>
    </div>

    <!-- Print button -->
    <div class="print-btn-bar">
        <button class="print-btn" onclick="window.print()">
            <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7H6zm-1 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm13 8H6v-5h12v5zm2-12H4a2 2 0 0 0-2 2v6h4v4h12v-4h4v-6a2 2 0 0 0-2-2z"/></svg>
            Print &nbsp;/&nbsp; Save as PDF
        </button>
    </div>

</div>
</body>
</html>`;

                const win = window.open('', '_blank', 'width=1100,height=800');
                win.document.write(html);
                win.document.close();

            } catch (err) {
                showToast('Failed to generate report: ' + err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-print"></i> Preview & Print';
                closeReportModal();
            }
        }

        async function generateReportCsv() {
            const btn = document.getElementById('reportCsvBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';
            try {
                const data = await fetchReportData();
                if (!data.success) throw new Error('Failed to fetch report data');

                const dateFrom = document.getElementById('reportDateFrom').value || 'all';
                const dateTo = document.getElementById('reportDateTo').value || 'all';

                const headers = ['# of Task', 'Rider', 'Date', 'Deliveries', 'Delivery Fee', 'Total Remit', 'Tips',
                    'Collection', 'Payment Mode', 'Remarks', 'Remarks Amount'
                ];
                let csvRowNum = 0;
                const rows = data.remittances.map(r => {
                    csvRowNum++;
                    return [
                        csvRowNum,
                        (r.rider && r.rider.name) ? '"' + r.rider.name + '"' : 'N/A',
                        r.created_at ? r.created_at.substring(0, 10) : '',
                        r.total_deliveries,
                        Number(r.total_delivery_fee || 0).toFixed(2),
                        Number(r.total_remit || 0).toFixed(2),
                        Number(r.total_tips || 0).toFixed(2),
                        Number(r.total_collection || 0).toFixed(2),
                        r.mode_of_payment || '',
                        r.remarks ? '"' + r.remarks.replace(/"/g, '""') + '"' : '',
                        r.remarks_amount ? Number(r.remarks_amount).toFixed(2) : '0.00',
                    ];
                });

                const summaryRows = [
                    [],
                    ['SUMMARY'],
                    ['Total Records', data.summary.total_records],
                    ['Total Deliveries', data.summary.total_deliveries],
                    ['Total Delivery Fee', Number(data.summary.total_delivery_fee || 0).toFixed(2)],
                    ['Total Remit', Number(data.summary.total_remit || 0).toFixed(2)],
                    ['Total Tips', Number(data.summary.total_tips || 0).toFixed(2)],
                    ['Total Collection', Number(data.summary.total_collection || 0).toFixed(2)],
                    ['Cash Collection', Number(data.summary.cash_collection || 0).toFixed(2)],
                    ['Digital Collection', Number(data.summary.digital_collection || 0).toFixed(2)],
                    ['Confirmed Count', data.summary.confirmed_count],
                    ['Pending Count', data.summary.pending_count],
                    ['Non-remitting Rider', data.summary.non_remitting_rider_count],
                ];

                const csvContent = [headers, ...rows, ...summaryRows]
                    .map(row => Array.isArray(row) ? row.join(',') : row)
                    .join('\n');

                const blob = new Blob(['\uFEFF' + csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `remittance-report-${dateFrom}-to-${dateTo}.csv`;
                a.click();
                URL.revokeObjectURL(url);
                showToast('CSV exported successfully!', 'success');

            } catch (err) {
                showToast('Failed to export CSV: ' + err.message, 'error');
            } finally {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-file-csv"></i> Export CSV';
            }
        }
    </script>

    <!-- Toast Notification Container -->
    <div id="toastContainer"></div>

    <!-- ===================== REPORT MODAL ===================== -->
    <style>
        .report-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 10001;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(3px);
        }

        .report-modal-overlay.active {
            display: flex;
        }

        .report-modal {
            background: #fff;
            border-radius: 14px;
            width: 92%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18), 0 2px 8px rgba(0, 0, 0, 0.10);
            animation: modalSlideIn 0.25s ease;
            font-family: 'Inter', Arial, sans-serif;
        }

        .report-modal-header {
            padding: 18px 22px;
            background: #436026;
            color: #fff;
            border-radius: 14px 14px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-modal-header h3 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            letter-spacing: -0.1px;
        }

        .report-modal-header h3 i {
            font-size: 15px;
            opacity: 0.85;
        }

        .report-modal-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.8);
            font-size: 18px;
            cursor: pointer;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background 0.2s, color 0.2s;
        }

        .report-modal-close:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .report-modal-body {
            padding: 20px 22px 4px;
        }

        .report-modal-desc {
            font-size: 12px;
            color: #9ca3af;
            margin-bottom: 18px;
            line-height: 1.5;
        }

        .report-filter-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 6px;
        }

        @media (max-width: 500px) {
            .report-filter-grid {
                grid-template-columns: 1fr;
            }
        }

        .report-filter-group label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .report-filter-group label i {
            color: #436026;
            font-size: 11px;
        }

        .report-filter-group input,
        .report-filter-group select {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 13px;
            background: #ffffff;
            color: #374151;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            font-family: 'Inter', Arial, sans-serif;
        }

        .report-filter-group input:focus,
        .report-filter-group select:focus {
            outline: none;
            border-color: #436026;
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
        }

        .report-action-bar {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
            padding: 16px 22px 20px;
            border-top: 1px solid #f3f4f6;
            margin-top: 18px;
        }

        .report-action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            font-family: 'Inter', Arial, sans-serif;
        }

        .report-action-btn.preview {
            background: #436026;
            color: #fff;
            box-shadow: 0 1px 4px rgba(67, 96, 38, 0.2);
        }

        .report-action-btn.preview:hover {
            background: #4e7030;
            box-shadow: 0 3px 10px rgba(67, 96, 38, 0.3);
            transform: translateY(-1px);
        }

        .report-action-btn.cancel {
            background: #fff;
            color: #6b7280;
            border: 1px solid #d1d5db;
        }

        .report-action-btn.cancel:hover {
            background: #f9fafb;
            color: #374151;
            border-color: #9ca3af;
        }

        .report-action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Print styles */
        @media print {
            body>*:not(#reportPrintArea) {
                display: none !important;
            }

            #reportPrintArea {
                display: block !important;
            }

            .no-print {
                display: none !important;
            }
        }

        #reportPrintArea {
            display: none;
        }
    </style>

    <div class="report-modal-overlay" id="reportModalOverlay">
        <div class="report-modal">
            <div class="report-modal-header">
                <h3><i class="fas fa-file-alt"></i> Generate Remittance Report</h3>
                <button class="report-modal-close" onclick="closeReportModal()"><i class="fas fa-times"></i></button>
            </div>
            <div class="report-modal-body">
                <p class="report-modal-desc">
                    Select filters below to generate a remittance report. Leave blank to include all records.
                </p>
                <div class="report-filter-grid">
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date From</label>
                        <input type="date" id="reportDateFrom">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date To</label>
                        <input type="date" id="reportDateTo">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-motorcycle"></i> Rider</label>
                        <select id="reportRider">
                            <option value="all">All Riders</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->id }}">{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-credit-card"></i> Payment Mode</label>
                        <select id="reportPaymentMode">
                            <option value="all">All Modes</option>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="bank">Bank</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="report-action-bar">
                <button class="report-action-btn cancel" onclick="closeReportModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="report-action-btn preview" id="reportPreviewBtn" onclick="generateReportPreview()">
                    <i class="fas fa-print"></i> Preview & Print
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden print area -->
    <div id="reportPrintArea"></div>

    <!-- ===================== PAYROLL REPORT MODAL ===================== -->
    <div class="report-modal-overlay" id="payrollReportModalOverlay">
        <div class="report-modal">
            <div class="report-modal-header">
                <h3><i class="fas fa-file-alt"></i> Generate Payroll Report</h3>
                <button class="report-modal-close" onclick="closePayrollReportModal()"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="report-modal-body">
                <p class="report-modal-desc">
                    Select filters below to generate a payroll report. Leave blank to include all records.
                </p>
                <div class="report-filter-grid">
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date From</label>
                        <input type="date" id="payrollReportDateFrom">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date To</label>
                        <input type="date" id="payrollReportDateTo">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-motorcycle"></i> Rider</label>
                        <select id="payrollReportRider">
                            <option value="all">All Riders</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->name }}">{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-credit-card"></i> Payment Mode</label>
                        <select id="payrollReportMode">
                            <option value="all">All Modes</option>
                            <option value="cash">Cash</option>
                            <option value="gcash">GCash</option>
                            <option value="bank">Bank</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="report-action-bar">
                <button class="report-action-btn cancel" onclick="closePayrollReportModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="report-action-btn preview" id="payrollReportPreviewBtn"
                    onclick="generatePayrollReportPreview()">
                    <i class="fas fa-print"></i> Preview & Print
                </button>
            </div>
        </div>
    </div>

    <!-- ===================== DEDUCTIONS REPORT MODAL ===================== -->
    <div class="report-modal-overlay" id="deductionsReportModalOverlay">
        <div class="report-modal">
            <div class="report-modal-header">
                <h3><i class="fas fa-file-alt"></i> Generate Deductions Report</h3>
                <button class="report-modal-close" onclick="closeDeductionsReportModal()"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="report-modal-body">
                <p class="report-modal-desc">
                    Select filters below to generate a deductions report. Leave blank to include all records.
                </p>
                <div class="report-filter-grid">
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date From</label>
                        <input type="date" id="deductionsReportDateFrom">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-calendar-day"></i> Date To</label>
                        <input type="date" id="deductionsReportDateTo">
                    </div>
                    <div class="report-filter-group">
                        <label><i class="fas fa-motorcycle"></i> Rider</label>
                        <select id="deductionsReportRider">
                            <option value="all">All Riders</option>
                            @foreach ($riders as $rider)
                                <option value="{{ $rider->name }}">{{ $rider->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="report-action-bar">
                <button class="report-action-btn cancel" onclick="closeDeductionsReportModal()">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button class="report-action-btn preview" id="deductionsReportPreviewBtn"
                    onclick="generateDeductionsReportPreview()">
                    <i class="fas fa-print"></i> Preview & Print
                </button>
            </div>
        </div>
    </div>

    <script>
        // ── Payroll Report ──────────────────────────────────────────────
        function openPayrollReportModal() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('payrollReportDateFrom').value = today;
            document.getElementById('payrollReportDateTo').value = today;
            document.getElementById('payrollReportRider').value = 'all';
            document.getElementById('payrollReportMode').value = 'all';
            document.getElementById('payrollReportModalOverlay').classList.add('active');
        }

        function closePayrollReportModal() {
            document.getElementById('payrollReportModalOverlay').classList.remove('active');
        }
        document.getElementById('payrollReportModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closePayrollReportModal();
        });

        function generatePayrollReportPreview() {
            const btn = document.getElementById('payrollReportPreviewBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

            const dateFrom = document.getElementById('payrollReportDateFrom').value;
            const dateTo = document.getElementById('payrollReportDateTo').value;
            const riderSel = document.getElementById('payrollReportRider');
            const riderFilter = riderSel.value;
            const riderLabel = riderSel.options[riderSel.selectedIndex].text;
            const modeSel = document.getElementById('payrollReportMode');
            const modeFilter = modeSel.value;
            const modeLabel = modeSel.options[modeSel.selectedIndex].text;
            const generatedBy = '{{ addslashes(auth()->user()->name ?? 'N/A') }}';
            const generatedAt = new Date().toLocaleString('en-PH');

            // Collect rows from the visible payroll table
            const rows = document.querySelectorAll('#payrollTableBody tr.payroll-row');
            let detailRows = '';
            let totalBase = 0,
                totalIncentives = 0,
                totalRenumeration26Days = 0,
                totalAddaDf = 0,
                totalNet = 0,
                rowNum = 0;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (!cells.length) return;
                const riderId = cells[0] ? cells[0].innerText.trim() : '';
                const riderName = cells[1] ? cells[1].innerText.trim() : '';
                const base = cells[2] ? cells[2].innerText.trim() : '';
                const incentive = cells[3] ? cells[3].innerText.trim() : '';
                const renumeration26Days = cells[4] ? cells[4].innerText.trim() : '';
                const addaDf = cells[5] ? cells[5].innerText.trim() : '';
                const addaDfDate = cells[6] ? cells[6].innerText.trim() : '';
                const net = cells[7] ? cells[7].innerText.trim() : '';
                const schedule = cells[8] ? cells[8].innerText.trim() : '';
                const mode = cells[9] ? cells[9].innerText.trim() : '';
                const dateCreated = cells[10] ? cells[10].innerText.trim() : '';

                // Apply filters
                if (riderFilter !== 'all' && riderName !== riderFilter) return;
                if (modeFilter !== 'all' && mode.toLowerCase() !== modeFilter.toLowerCase()) return;
                if (dateFrom || dateTo) {
                    const rowDate = new Date(dateCreated);
                    if (dateFrom && rowDate < new Date(dateFrom)) return;
                    if (dateTo && rowDate > new Date(dateTo + 'T23:59:59')) return;
                }

                rowNum++;
                const baseNum = parseFloat(base.replace(/[₱,]/g, '')) || 0;
                const incentiveNum = parseFloat(incentive.replace(/[₱,]/g, '')) || 0;
                const renumerationNum = parseFloat(renumeration26Days.replace(/[₱,]/g, '')) || 0;
                const addaDfNum = parseFloat(addaDf.replace(/[₱,]/g, '')) || 0;
                const netNum = parseFloat(net.replace(/[₱,]/g, '')) || 0;
                totalBase += baseNum;
                totalIncentives += incentiveNum;
                totalRenumeration26Days += renumerationNum;
                totalAddaDf += addaDfNum;
                totalNet += netNum;

                const modeBadge = mode ?
                    `<span style="display:inline-block;padding:2px 10px;border-radius:10px;font-size:10px;font-weight:700;background:${mode.toLowerCase().includes('cash') ? '#d4edda' : '#d1ecf1'};color:${mode.toLowerCase().includes('cash') ? '#155724' : '#0c5460'}">${mode.toUpperCase()}</span>` :
                    '';

                detailRows += `<tr>
                    <td style="text-align:center;color:#999">${rowNum}</td>
                    <td style="text-align:center;color:#6b7280;font-size:12px">${riderId}</td>
                    <td><strong>${riderName}</strong></td>
                    <td style="text-align:right">${base}</td>
                    <td style="text-align:right">${incentive}</td>
                    <td style="text-align:right">${renumeration26Days}</td>
                    <td style="text-align:right">${addaDf}</td>
                    <td style="font-size:12px;color:#6b7280">${addaDfDate}</td>
                    <td style="text-align:right;font-weight:700;color:#436026">${net}</td>
                    <td>${schedule}</td>
                    <td style="text-align:center">${modeBadge}</td>
                    <td style="font-size:12px;color:#6b7280">${dateCreated}</td>
                </tr>`;
            });

            if (rowNum === 0) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-print"></i> Preview & Print';
                closePayrollReportModal();
                showToast('No records match the selected filters.', 'error');
                return;
            }

            const html = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payroll Report</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #e8ede0; color: #1a1a1a; }
        .page { max-width: 1100px; margin: 0 auto; padding: 32px 28px 48px; }

        /* Banner */
        .banner {
            background: linear-gradient(135deg, #2b3d12 0%, #436026 55%, #5a7d33 100%);
            border-radius: 16px 16px 0 0;
            padding: 28px 32px 24px;
            display: flex; justify-content: space-between; align-items: flex-end; gap: 20px;
            position: relative; overflow: hidden;
        }
        .banner::after { content: ''; position: absolute; right: -40px; top: -40px; width: 220px; height: 220px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .banner-left h1 { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: -0.4px; line-height: 1.15; }
        .banner-left .sub { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 5px; }
        .banner-right { flex-shrink: 0; display: flex; flex-direction: column; gap: 5px; align-items: flex-end; }
        .meta-row { display: flex; align-items: center; background: rgba(255,255,255,0.12); border: 1px solid rgba(144,200,90,0.40); border-radius: 7px; overflow: hidden; min-width: 260px; }
        .meta-label { background: rgba(90,125,51,0.55); color: #d4f5a0; font-size: 10px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; padding: 5px 10px; width: 108px; flex-shrink: 0; text-align: right; border-right: 1px solid rgba(144,200,90,0.35); }
        .meta-value { color: #fff; font-size: 11px; font-weight: 600; padding: 5px 12px; flex: 1; }

        /* Accent bar */
        .accent-bar { height: 5px; background: linear-gradient(90deg, #ffd300 0%, #f0b800 50%, #e6a800 100%); }

        /* Card body */
        .card-body { background: #fff; border-radius: 0 0 16px 16px; padding: 28px 32px 32px; box-shadow: 0 8px 32px rgba(67,96,38,0.12); }

        /* Section label */
        .section-label { font-size: 10px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: #436026; margin-bottom: 12px; display: flex; align-items: center; gap: 7px; }
        .section-label::after { content: ''; flex: 1; height: 1px; background: #d6e8c8; }

        /* Summary cards */
        .summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 26px; }
        .s-card { border-radius: 12px; padding: 16px 18px; border: 1px solid transparent; }
        .s-card.green1 { background: linear-gradient(135deg,#f0f7e8,#e4f1d4); border-color: #b8d98a; }
        .s-card.green2 { background: linear-gradient(135deg,#e8f5e0,#d9efc6); border-color: #a8d070; }
        .s-card.green3 { background: linear-gradient(135deg,#ebf5e2,#ddf0c8); border-color: #b0d880; }
        .s-card.gold1  { background: linear-gradient(135deg,#fffbea,#fff3c2); border-color: #ffd300; }
        .s-card .s-icon { font-size: 22px; margin-bottom: 8px; opacity: 0.65; }
        .s-card .s-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #4a5a30; margin-bottom: 4px; }
        .s-card .s-value { font-size: 20px; font-weight: 800; color: #2b3d12; line-height: 1; }
        .s-card .s-value.lg { font-size: 22px; }

        .divider { height: 1px; background: #d6e8c8; margin: 6px 0 22px; }

        /* Table */
        .table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid #c8d8a8; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: linear-gradient(135deg, #2b3d12 0%, #436026 100%); }
        thead th { padding: 11px 14px; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
        thead th:first-child { border-radius: 11px 0 0 0; }
        thead th:last-child  { border-radius: 0 11px 0 0; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr:nth-child(even) { background: #f5f9f2; }
        tbody td { padding: 9px 14px; border-bottom: 1px solid #e4eeda; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tfoot tr { background: linear-gradient(135deg, #2b3d12 0%, #436026 100%); }
        tfoot td { padding: 11px 14px; color: #fff; font-weight: 700; font-size: 13px; }
        tfoot td:first-child { border-radius: 0 0 0 11px; }
        tfoot td:last-child  { border-radius: 0 0 11px 0; }
        .badge-cash  { display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:linear-gradient(135deg,#e8f5e0,#d4edda);color:#2b5c1a;border:1px solid #94c97a; }
        .badge-gcash { display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:linear-gradient(135deg,#fffbea,#fff3c2);color:#7a6000;border:1px solid #ffd300; }
        .badge-bank  { display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;background:linear-gradient(135deg,#f0f7e8,#e4f1d4);color:#436026;border:1px solid #9ac460; }

        /* Signature row */
        .sig-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 36px; }
        .sig-box { text-align: center; }
        .sig-line { border-top: 1.5px solid #aac47a; margin: 0 20px 8px; }
        .sig-name { font-size: 12px; font-weight: 700; color: #2b3d12; }
        .sig-title { font-size: 10px; color: #888; margin-top: 2px; }

        .report-footer { margin-top: 20px; padding-top: 16px; border-top: 1px solid #d6e8c8; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #888; }

        /* Print button */
        .print-btn-bar { text-align: center; margin-top: 28px; }
        .print-btn { display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #2b3d12 0%, #5a7d33 100%); color: #fff; border: none; padding: 13px 32px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(67,96,38,0.35); letter-spacing: 0.3px; }
        .print-btn svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }

        @media print {
            @page { margin: 10mm 8mm; size: A4 landscape; }
            body { background: #fff; }
            .page { padding: 0; max-width: 100%; }
            .banner { border-radius: 0; padding: 10px 14px 9px; }
            .banner::after { display: none; }
            .banner-left h1 { font-size: 15px; }
            .banner-left .sub { font-size: 9px; }
            .meta-row { min-width: 200px; border-radius: 4px; }
            .meta-label { font-size: 8px; padding: 3px 7px; width: 80px; }
            .meta-value { font-size: 9px; padding: 3px 8px; }
            .accent-bar { height: 3px; }
            .card-body { box-shadow: none; border-radius: 0; padding: 10px 14px 14px; }
            .section-label { font-size: 8px; margin-bottom: 6px; }
            .summary-grid { gap: 6px; margin-bottom: 12px; }
            .s-card { padding: 7px 9px; border-radius: 6px; }
            .s-card .s-icon { font-size: 13px; margin-bottom: 3px; }
            .s-card .s-label { font-size: 7px; margin-bottom: 2px; }
            .s-card .s-value { font-size: 12px; }
            .s-card .s-value.lg { font-size: 13px; }
            .divider { margin: 4px 0 10px; }
            .table-wrap { border: none; border-radius: 0; }
            table { font-size: 9px; }
            thead th { padding: 5px 7px; font-size: 8px; }
            thead th:first-child, thead th:last-child { border-radius: 0; }
            tbody td { padding: 4px 7px; }
            tfoot td { padding: 5px 7px; font-size: 9px; }
            tfoot td:first-child, tfoot td:last-child { border-radius: 0; }
            .badge-cash, .badge-gcash, .badge-bank { padding: 1px 5px; font-size: 8px; border-radius: 10px; }
            .sig-row { margin-top: 18px; gap: 14px; }
            .sig-name { font-size: 10px; }
            .sig-title { font-size: 8px; }
            .report-footer { font-size: 8px; margin-top: 8px; }
            .print-btn-bar { display: none; }
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Banner -->
    <div class="banner">
        <div class="banner-left">
            <h1>&#128200; Payroll Report</h1>
            <div class="sub">WIB System &mdash; Rider Payroll Records &nbsp;&#183;&nbsp; Generated: ${generatedAt}</div>
        </div>
        <div class="banner-right">
            <div class="meta-row"><div class="meta-label">Date Range</div><div class="meta-value">${dateFrom || 'All'} &ndash; ${dateTo || 'All'}</div></div>
            <div class="meta-row"><div class="meta-label">Rider</div><div class="meta-value">${riderLabel}</div></div>
            <div class="meta-row"><div class="meta-label">Mode</div><div class="meta-value">${modeLabel}</div></div>
            <div class="meta-row"><div class="meta-label">Generated By</div><div class="meta-value">${generatedBy}</div></div>
        </div>
    </div>
    <div class="accent-bar"></div>

    <div class="card-body">

        <!-- Detail Table -->
        <div class="section-label">&#128203; Payroll Details</div>
        <div class="table-wrap">
        <table>
            <thead><tr>
                <th style="text-align:center;width:46px">#</th>
                <th style="text-align:center">Rider ID</th>
                <th>Rider Name</th>
                <th style="text-align:right">Base Salary</th>
                <th style="text-align:right">Incentives</th>
                <th style="text-align:right">26 Days Renumeration</th>
                <th style="text-align:right">ADDA DF</th>
                <th>ADDA DF Date</th>
                <th style="text-align:right">Net Salary</th>
                <th>Schedule</th>
                <th style="text-align:center">Mode</th>
                <th>Date Created</th>
            </tr></thead>
            <tbody>${detailRows}</tbody>
            <tfoot><tr>
                <td colspan="3" style="text-align:right;letter-spacing:0.5px">TOTALS</td>
                <td style="text-align:right">&#8369;${totalBase.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td style="text-align:right">&#8369;${totalIncentives.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td style="text-align:right">&#8369;${totalRenumeration26Days.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td style="text-align:right">&#8369;${totalAddaDf.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td></td>
                <td style="text-align:right">&#8369;${totalNet.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td colspan="3"></td>
            </tr></tfoot>
        </table>
        </div>

        <!-- Signature lines -->
        <div class="sig-row">
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Prepared By</div><div class="sig-title">Payroll Officer</div></div>
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Reviewed By</div><div class="sig-title">Supervisor</div></div>
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Approved By</div><div class="sig-title">Manager</div></div>
        </div>

        <div class="report-footer">
            <span>WIB System &mdash; Payroll Report</span>
            <span>Total of <strong>${rowNum}</strong> record(s) &nbsp;|&nbsp; ${dateFrom || 'All'} to ${dateTo || 'All'}</span>
        </div>
    </div>

    <!-- Print button -->
    <div class="print-btn-bar">
        <button class="print-btn" onclick="window.print()">
            <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7H6zm-1 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm13 8H6v-5h12v5zm2-12H4a2 2 0 0 0-2 2v6h4v4h12v-4h4v-6a2 2 0 0 0-2-2z"/></svg>
            Print &nbsp;/&nbsp; Save as PDF
        </button>
    </div>

</div>
</body>
</html>`;

            const win = window.open('', '_blank', 'width=1150,height=820');
            win.document.write(html);
            win.document.close();

            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-print"></i> Preview & Print';
            closePayrollReportModal();
        }

        // ── Deductions Report ───────────────────────────────────────────
        function openDeductionsReportModal() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('deductionsReportDateFrom').value = today;
            document.getElementById('deductionsReportDateTo').value = today;
            document.getElementById('deductionsReportRider').value = 'all';
            document.getElementById('deductionsReportModalOverlay').classList.add('active');
        }

        function closeDeductionsReportModal() {
            document.getElementById('deductionsReportModalOverlay').classList.remove('active');
        }
        document.getElementById('deductionsReportModalOverlay').addEventListener('click', function(e) {
            if (e.target === this) closeDeductionsReportModal();
        });

        function generateDeductionsReportPreview() {
            const btn = document.getElementById('deductionsReportPreviewBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';

            const dateFrom = document.getElementById('deductionsReportDateFrom').value;
            const dateTo = document.getElementById('deductionsReportDateTo').value;
            const riderSel = document.getElementById('deductionsReportRider');
            const riderFilter = riderSel.value;
            const riderLabel = riderSel.options[riderSel.selectedIndex].text;
            const generatedBy = '{{ addslashes(auth()->user()->name ?? 'N/A') }}';
            const generatedAt = new Date().toLocaleString('en-PH');

            const rows = document.querySelectorAll('#deductionsTableBody tr.deduction-row');
            let detailRows = '';
            let totalAmount = 0,
                rowNum = 0;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (!cells.length) return;
                const riderId = cells[0] ? cells[0].innerText.trim() : '';
                const riderName = cells[1] ? cells[1].innerText.trim() : '';
                const amount = cells[2] ? cells[2].innerText.trim() : '';
                const date = cells[3] ? cells[3].innerText.trim() : '';
                const remarks = cells[4] ? cells[4].innerText.trim() : '';
                const dateCreated = cells[5] ? cells[5].innerText.trim() : '';

                if (riderFilter !== 'all' && riderName !== riderFilter) return;
                if (dateFrom || dateTo) {
                    const rowDate = new Date(dateCreated);
                    if (dateFrom && rowDate < new Date(dateFrom)) return;
                    if (dateTo && rowDate > new Date(dateTo + 'T23:59:59')) return;
                }

                rowNum++;
                const amountNum = parseFloat(amount.replace(/[₱\-,\s]/g, '')) || 0;
                totalAmount += amountNum;

                detailRows += `<tr>
                    <td style="text-align:center;color:#999">${rowNum}</td>
                    <td style="text-align:center;color:#6b7280;font-size:12px">${riderId}</td>
                    <td><strong>${riderName}</strong></td>
                    <td style="text-align:right;font-weight:700;color:#dc2626">&minus; &#8369;${amountNum.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                    <td>${date}</td>
                    <td style="max-width:180px;word-break:break-word;color:#6b7280">${remarks || '&mdash;'}</td>
                    <td style="font-size:12px;color:#6b7280">${dateCreated}</td>
                </tr>`;
            });

            if (rowNum === 0) {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-print"></i> Preview & Print';
                closeDeductionsReportModal();
                showToast('No records match the selected filters.', 'error');
                return;
            }

            const html = `<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Deductions Report</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #e8ede0; color: #1a1a1a; }
        .page { max-width: 1000px; margin: 0 auto; padding: 32px 28px 48px; }

        /* Banner */
        .banner {
            background: linear-gradient(135deg, #2b3d12 0%, #436026 55%, #5a7d33 100%);
            border-radius: 16px 16px 0 0;
            padding: 28px 32px 24px;
            display: flex; justify-content: space-between; align-items: flex-end; gap: 20px;
            position: relative; overflow: hidden;
        }
        .banner::after { content: ''; position: absolute; right: -40px; top: -40px; width: 220px; height: 220px; background: rgba(255,255,255,0.06); border-radius: 50%; }
        .banner-left h1 { font-size: 26px; font-weight: 800; color: #fff; letter-spacing: -0.4px; line-height: 1.15; }
        .banner-left .sub { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 5px; }
        .banner-right { flex-shrink: 0; display: flex; flex-direction: column; gap: 5px; align-items: flex-end; }
        .meta-row { display: flex; align-items: center; background: rgba(255,255,255,0.12); border: 1px solid rgba(144,200,90,0.40); border-radius: 7px; overflow: hidden; min-width: 260px; }
        .meta-label { background: rgba(90,125,51,0.55); color: #d4f5a0; font-size: 10px; font-weight: 800; letter-spacing: 0.6px; text-transform: uppercase; padding: 5px 10px; width: 108px; flex-shrink: 0; text-align: right; border-right: 1px solid rgba(144,200,90,0.35); }
        .meta-value { color: #fff; font-size: 11px; font-weight: 600; padding: 5px 12px; flex: 1; }

        /* Accent bar */
        .accent-bar { height: 5px; background: linear-gradient(90deg, #ffd300 0%, #f0b800 50%, #e6a800 100%); }

        /* Card body */
        .card-body { background: #fff; border-radius: 0 0 16px 16px; padding: 28px 32px 32px; box-shadow: 0 8px 32px rgba(67,96,38,0.12); }

        /* Section label */
        .section-label { font-size: 10px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; color: #436026; margin-bottom: 12px; display: flex; align-items: center; gap: 7px; }
        .section-label::after { content: ''; flex: 1; height: 1px; background: #d6e8c8; }

        /* Summary cards */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 26px; }
        .s-card { border-radius: 12px; padding: 16px 18px; border: 1px solid transparent; }
        .s-card.green1 { background: linear-gradient(135deg,#f0f7e8,#e4f1d4); border-color: #b8d98a; }
        .s-card.olive1 { background: linear-gradient(135deg,#f5f7ee,#eaefd8); border-color: #c8d4a6; }
        .s-card.red1   { background: linear-gradient(135deg,#fff5f5,#ffe4e4); border-color: #f9aaaa; }
        .s-card .s-icon { font-size: 22px; margin-bottom: 8px; opacity: 0.65; }
        .s-card .s-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.7px; color: #4a5a30; margin-bottom: 4px; }
        .s-card.red1 .s-label { color: #8b2020; }
        .s-card .s-value { font-size: 20px; font-weight: 800; color: #2b3d12; line-height: 1; }
        .s-card.red1 .s-value { color: #c0392b; }
        .s-card .s-value.lg { font-size: 22px; }

        .divider { height: 1px; background: #d6e8c8; margin: 6px 0 22px; }

        /* Table */
        .table-wrap { overflow-x: auto; border-radius: 12px; border: 1px solid #c8d8a8; }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: linear-gradient(135deg, #2b3d12 0%, #436026 100%); }
        thead th { padding: 11px 14px; color: #fff; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; }
        thead th:first-child { border-radius: 11px 0 0 0; }
        thead th:last-child  { border-radius: 0 11px 0 0; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody tr:nth-child(even) { background: #f5f9f2; }
        tbody td { padding: 9px 14px; border-bottom: 1px solid #e4eeda; vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tfoot tr { background: linear-gradient(135deg, #6b1c1c 0%, #991f1f 100%); }
        tfoot td { padding: 11px 14px; color: #fff; font-weight: 700; font-size: 13px; }
        tfoot td:first-child { border-radius: 0 0 0 11px; }
        tfoot td:last-child  { border-radius: 0 0 11px 0; }

        /* Signature row */
        .sig-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-top: 36px; }
        .sig-box { text-align: center; }
        .sig-line { border-top: 1.5px solid #aac47a; margin: 0 20px 8px; }
        .sig-name { font-size: 12px; font-weight: 700; color: #2b3d12; }
        .sig-title { font-size: 10px; color: #888; margin-top: 2px; }

        .report-footer { margin-top: 20px; padding-top: 16px; border-top: 1px solid #d6e8c8; display: flex; justify-content: space-between; align-items: center; font-size: 11px; color: #888; }

        /* Print button */
        .print-btn-bar { text-align: center; margin-top: 28px; }
        .print-btn { display: inline-flex; align-items: center; gap: 10px; background: linear-gradient(135deg, #2b3d12 0%, #5a7d33 100%); color: #fff; border: none; padding: 13px 32px; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; box-shadow: 0 4px 14px rgba(67,96,38,0.35); letter-spacing: 0.3px; }
        .print-btn svg { width: 18px; height: 18px; fill: currentColor; flex-shrink: 0; }

        @media print {
            @page { margin: 10mm 8mm; size: A4 landscape; }
            body { background: #fff; }
            .page { padding: 0; max-width: 100%; }
            .banner { border-radius: 0; padding: 10px 14px 9px; }
            .banner::after { display: none; }
            .banner-left h1 { font-size: 15px; }
            .banner-left .sub { font-size: 9px; }
            .meta-row { min-width: 200px; border-radius: 4px; }
            .meta-label { font-size: 8px; padding: 3px 7px; width: 80px; }
            .meta-value { font-size: 9px; padding: 3px 8px; }
            .accent-bar { height: 3px; }
            .card-body { box-shadow: none; border-radius: 0; padding: 10px 14px 14px; }
            .section-label { font-size: 8px; margin-bottom: 6px; }
            .summary-grid { gap: 6px; margin-bottom: 12px; }
            .s-card { padding: 7px 9px; border-radius: 6px; }
            .s-card .s-icon { font-size: 13px; margin-bottom: 3px; }
            .s-card .s-label { font-size: 7px; margin-bottom: 2px; }
            .s-card .s-value { font-size: 12px; }
            .s-card .s-value.lg { font-size: 13px; }
            .divider { margin: 4px 0 10px; }
            .table-wrap { border: none; border-radius: 0; }
            table { font-size: 9px; }
            thead th { padding: 5px 7px; font-size: 8px; }
            thead th:first-child, thead th:last-child { border-radius: 0; }
            tbody td { padding: 4px 7px; }
            tfoot td { padding: 5px 7px; font-size: 9px; }
            tfoot td:first-child, tfoot td:last-child { border-radius: 0; }
            .sig-row { margin-top: 18px; gap: 14px; }
            .sig-name { font-size: 10px; }
            .sig-title { font-size: 8px; }
            .report-footer { font-size: 8px; margin-top: 8px; }
            .print-btn-bar { display: none; }
        }
    </style>
</head>
<body>
<div class="page">

    <!-- Banner -->
    <div class="banner">
        <div class="banner-left">
            <h1>&#128202; Deductions Report</h1>
            <div class="sub">WIB System &mdash; Rider Deductions Records &nbsp;&#183;&nbsp; Generated: ${generatedAt}</div>
        </div>
        <div class="banner-right">
            <div class="meta-row"><div class="meta-label">Date Range</div><div class="meta-value">${dateFrom || 'All'} &ndash; ${dateTo || 'All'}</div></div>
            <div class="meta-row"><div class="meta-label">Rider</div><div class="meta-value">${riderLabel}</div></div>
            <div class="meta-row"><div class="meta-label">Generated By</div><div class="meta-value">${generatedBy}</div></div>
        </div>
    </div>
    <div class="accent-bar"></div>

    <div class="card-body">

        <!-- Detail Table -->
        <div class="section-label">&#128203; Deduction Details</div>
        <div class="table-wrap">
        <table>
            <thead><tr>
                <th style="text-align:center;width:46px">#</th>
                <th style="text-align:center">Rider ID</th>
                <th>Rider Name</th>
                <th style="text-align:right">Amount</th>
                <th>Date</th>
                <th>Remarks</th>
                <th>Date Created</th>
            </tr></thead>
            <tbody>${detailRows}</tbody>
            <tfoot><tr>
                <td colspan="3" style="text-align:right;letter-spacing:0.5px">TOTAL DEDUCTIONS</td>
                <td style="text-align:right">&minus; &#8369;${totalAmount.toLocaleString('en-PH',{minimumFractionDigits:2})}</td>
                <td colspan="3"></td>
            </tr></tfoot>
        </table>
        </div>

        <!-- Signature lines -->
        <div class="sig-row">
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Prepared By</div><div class="sig-title">Payroll Officer</div></div>
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Reviewed By</div><div class="sig-title">Supervisor</div></div>
            <div class="sig-box"><div class="sig-line"></div><div class="sig-name">Approved By</div><div class="sig-title">Manager</div></div>
        </div>

        <div class="report-footer">
            <span>WIB System &mdash; Deductions Report</span>
            <span>Total of <strong>${rowNum}</strong> record(s) &nbsp;|&nbsp; ${dateFrom || 'All'} to ${dateTo || 'All'}</span>
        </div>
    </div>

    <!-- Print button -->
    <div class="print-btn-bar">
        <button class="print-btn" onclick="window.print()">
            <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7H6zm-1 4a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm13 8H6v-5h12v5zm2-12H4a2 2 0 0 0-2 2v6h4v4h12v-4h4v-6a2 2 0 0 0-2-2z"/></svg>
            Print &nbsp;/&nbsp; Save as PDF
        </button>
    </div>

</div>
</body>
</html>`;

            const win = window.open('', '_blank', 'width=1050,height=820');
            win.document.write(html);
            win.document.close();

            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-print"></i> Preview & Print';
            closeDeductionsReportModal();
        }
    </script>

    <!-- ============ NON-REMITTING RIDERS MODAL ============ -->
    <div class="report-modal-overlay" id="nonRemittingModalOverlay"
        onclick="if(event.target===this)closeNonRemittingModal()">
        <div class="report-modal" style="max-width:560px;width:min(560px,96vw);max-height:90vh;display:flex;flex-direction:column;">
            <div class="report-modal-header" style="background:linear-gradient(135deg,#2d4016 0%,#5a7d35 100%);">
                <h3 id="nrModalTitle"><i class="fas fa-clock"></i> Rider Remittance Status</h3>
                <button class="report-modal-close" onclick="closeNonRemittingModal()"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="report-modal-body" style="padding:10px 12px 8px;overflow:hidden;display:flex;flex-direction:column;">
                <p id="nrModalDesc" class="report-modal-desc"></p>
                <div id="nrModalBody">
                    <div style="text-align:center;padding:30px;color:#9ca3af;">
                        <i class="fas fa-spinner fa-spin" style="font-size:22px;"></i>
                        <p style="margin-top:8px;font-size:13px;">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="report-action-bar">
                <button class="report-action-btn cancel" onclick="closeNonRemittingModal()">
                    <i class="fas fa-times"></i> Close
                </button>
                <button class="report-action-btn preview" id="nrPrintBtn" onclick="printNonRemittingReport()"
                    style="display:none;">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <script>
        let _nrCurrentDate = null;
        let _nrCurrentRiders = [];

        const _nrBadge = {
            cleared: {
                bg: '#d4edda',
                color: '#155724',
                border: '#28a745',
                label: 'CLEARED'
            },
            late: {
                bg: '#ffe3e3',
                color: '#c92a2a',
                border: '#dc3545',
                label: 'LATE REMITTED'
            },
            pending: {
                bg: '#fff3cd',
                color: '#856404',
                border: '#ffc107',
                label: 'PENDING'
            },
            no_duty: {
                bg: '#f8d7da',
                color: '#842029',
                border: '#dc3545',
                label: 'NO REMIT'
            },
        };

        function _nrStatusBadge(status, isLate, lateDays, submittedDate) {
            let s = _nrBadge[status] || _nrBadge.no_duty;
            let label = s.label;
            let dateLabel = '';
            
            if (status === 'cleared' && isLate) {
                s = _nrBadge.late;
                label = s.label;
                
                if (submittedDate) {
                    const subDate = new Date(submittedDate);
                    dateLabel = `<div style="font-size:10px;font-weight:600;color:${s.color};margin-top:2px;">${subDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>`;
                }
            }
            
            return `<div style="display:flex;flex-direction:column;align-items:flex-start;"><span style="display:inline-block;padding:2px 8px;border-radius:999px;font-size:10px;line-height:1.2;font-weight:700;background:${s.bg};color:${s.color};border:1px solid ${s.border};white-space:nowrap;">${label}</span>${dateLabel}</div>`;
        }

        function openNonRemittingModal(date) {
            _nrCurrentDate = date;
            _nrCurrentRiders = [];
            document.getElementById('nrModalDesc').textContent = '';
            document.getElementById('nrModalTitle').innerHTML = '<i class="fas fa-clock"></i> Rider Remittance Status';
            document.getElementById('nrPrintBtn').style.display = 'none';
            document.getElementById('nrModalBody').innerHTML =
                '<div style="text-align:center;padding:30px;color:#9ca3af;"><i class="fas fa-spinner fa-spin" style="font-size:22px;"></i><p style="margin-top:8px;font-size:13px;">Loading...</p></div>';
            document.getElementById('nonRemittingModalOverlay').classList.add('active');

            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/non-remitting-riders?date=${date}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if (!data.success) throw new Error('Failed to load data');
                    _nrCurrentRiders = data.riders;

                    const isToday = data.is_today;
                    const dateLabel = new Date(data.date + 'T00:00:00').toLocaleDateString('en-PH', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    document.getElementById('nrModalTitle').innerHTML = isToday ?
                        `<i class="fas fa-clock"></i> Today's Rider Status` :
                        `<i class="fas fa-history"></i> Rider Status &mdash; ${dateLabel}`;

                    document.getElementById('nrModalDesc').textContent = isToday ?
                        `Live status for today (${dateLabel}). Resets to Pending at midnight each day.` :
                        `Finalized status for ${dateLabel}. Cleared = remitted, No Remit = did not remit.`;

                    const rows = data.riders.map((r, i) =>
                        `<tr>
                        <td style="padding:6px 8px;border-bottom:1px solid #f3f4f6;color:#6b7280;font-size:11px;width:34px;">${i+1}</td>
                        <td style="padding:6px 8px;border-bottom:1px solid #f3f4f6;font-weight:600;font-size:12px;">
                            <div style="display:flex;align-items:center;gap:7px;min-width:0;">
                                <div style="width:22px;height:22px;border-radius:50%;background:linear-gradient(135deg,#2d4016,#5a7d35);color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:700;flex-shrink:0;">${r.rider_name.charAt(0).toUpperCase()}</div>
                                ${r.rider_name}
                            </div>
                        </td>
                        <td style="padding:6px 8px;border-bottom:1px solid #f3f4f6;width:120px;">${_nrStatusBadge(r.status, r.is_late, r.late_days, r.submitted_date)}</td>
                    </tr>`
                    ).join('');

                    const cleared = data.riders.filter(r => r.status === 'cleared' && !r.is_late).length;
                    const late = data.riders.filter(r => r.status === 'cleared' && r.is_late).length;
                    const pending = data.riders.filter(r => r.status === 'pending').length;
                    const no_duty = data.riders.filter(r => r.status === 'no_duty').length;

                    const summaryParts = [];
                    if (cleared) summaryParts.push(
                        `<span style="color:#155724;font-weight:700;">${cleared} Cleared</span>`);
                    if (late) summaryParts.push(
                        `<span style="color:#c92a2a;font-weight:700;">${late} Late Remitted</span>`);
                    if (pending) summaryParts.push(
                        `<span style="color:#856404;font-weight:700;">${pending} Pending</span>`);
                    if (no_duty) summaryParts.push(
                        `<span style="color:#842029;font-weight:700;">${no_duty} No Remit</span>`);

                    document.getElementById('nrModalBody').innerHTML = data.riders.length === 0 ?
                        `<div style="text-align:center;padding:30px;color:#6b7280;">
                           <i class="fas fa-check-circle" style="font-size:32px;color:#28a745;margin-bottom:10px;"></i>
                           <p style="font-size:13px;font-weight:600;">No riders found for this date.</p>
                       </div>` :
                        `<div style="max-height:min(62vh,520px);overflow:auto;border:1px solid #e5e7eb;border-radius:10px;">
                           <table style="width:100%;border-collapse:collapse;font-family:inherit;table-layout:fixed;">
                               <thead>
                                   <tr style="background:#f9fafb;position:sticky;top:0;z-index:1;">
                                       <th style="padding:7px 8px;text-align:left;font-size:10px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.35px;border-bottom:1px solid #e5e7eb;width:34px;">#</th>
                                       <th style="padding:7px 8px;text-align:left;font-size:10px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.35px;border-bottom:1px solid #e5e7eb;">Rider</th>
                                       <th style="padding:7px 8px;text-align:left;font-size:10px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.35px;border-bottom:1px solid #e5e7eb;width:120px;">Status</th>
                                   </tr>
                               </thead>
                               <tbody>${rows}</tbody>
                           </table>
                       </div>
                       <div style="padding:8px 2px 0;font-size:11px;color:#6b7280;display:flex;gap:8px;flex-wrap:wrap;">${summaryParts.join(' ')}</div>`;

                    document.getElementById('nrPrintBtn').style.display = data.riders.length ? 'flex' : 'none';
                })
                .catch(err => {
                    document.getElementById('nrModalBody').innerHTML =
                        `<div style="text-align:center;padding:24px;color:#dc3545;"><i class="fas fa-exclamation-circle" style="font-size:22px;"></i><p style="margin-top:8px;font-size:13px;">${err.message}</p></div>`;
                });
        }

        function closeNonRemittingModal() {
            document.getElementById('nonRemittingModalOverlay').classList.remove('active');
        }

        function printNonRemittingReport() {
            if (!_nrCurrentRiders.length) return;
            const dateLabel = new Date(_nrCurrentDate + 'T00:00:00').toLocaleDateString('en-PH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            const statusLabel = {
                cleared: 'Cleared',
                late: 'Late Remitted',
                pending: 'Pending',
                no_duty: 'No Remit'
            };
            const statusStyle = {
                cleared: 'background:#d4edda;color:#155724;',
                late: 'background:#ffe3e3;color:#c92a2a;',
                pending: 'background:#fff3cd;color:#856404;',
                no_duty: 'background:#f8d7da;color:#842029;',
            };

            // Group riders by status
            const clearedRiders = _nrCurrentRiders.filter(r => r.status === 'cleared' && !r.is_late);
            const lateRiders = _nrCurrentRiders.filter(r => r.status === 'cleared' && r.is_late);
            const pendingRiders = _nrCurrentRiders.filter(r => r.status === 'pending');
            const noDutyRiders = _nrCurrentRiders.filter(r => r.status === 'no_duty');

            const cleared = clearedRiders.length;
            const late = lateRiders.length;
            const pending = pendingRiders.length;
            const no_duty = noDutyRiders.length;

            // Function to generate rows for a specific status group
            const generateRows = (riders) => {
                return riders.map((r, i) => {
                    let status = r.status;
                    let label = statusLabel[status] || 'No Remit';
                    let dateLabel = '';
                    
                    if (r.status === 'cleared' && r.is_late) {
                        status = 'late';
                        label = statusLabel.late;
                        
                        if (r.submitted_date) {
                            const subDate = new Date(r.submitted_date);
                            dateLabel = `<div style="font-size:10px;color:#c92a2a;margin-top:3px;">${subDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</div>`;
                        }
                    }
                    
                    return `<tr>
                        <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;">${i+1}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;font-weight:600;">${r.rider_name}</td>
                        <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;">
                            <span style="display:inline-block;padding:3px 10px;border-radius:8px;font-size:11px;font-weight:700;${statusStyle[status] || statusStyle.no_duty}">${label}</span>
                            ${dateLabel}
                        </td>
                    </tr>`;
                }).join('');
            };

            // Generate separate sections for each status
            let tableContent = '';
            
            if (cleared > 0) {
                tableContent += `
                    <h3 style="font-size:15px;color:#155724;margin:24px 0 10px;display:flex;align-items:center;gap:8px;">
                        <span style="background:#d4edda;color:#155724;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:700;">${cleared} Cleared</span>
                    </h3>
                    <table>
                        <thead><tr><th>#</th><th>Rider Name</th><th>Status</th></tr></thead>
                        <tbody>${generateRows(clearedRiders)}</tbody>
                    </table>
                `;
            }
            
            if (late > 0) {
                tableContent += `
                    <h3 style="font-size:15px;color:#c92a2a;margin:24px 0 10px;display:flex;align-items:center;gap:8px;">
                        <span style="background:#ffe3e3;color:#c92a2a;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:700;">${late} Late Remitted</span>
                    </h3>
                    <table>
                        <thead><tr><th>#</th><th>Rider Name</th><th>Status</th></tr></thead>
                        <tbody>${generateRows(lateRiders)}</tbody>
                    </table>
                `;
            }
            
            if (pending > 0) {
                tableContent += `
                    <h3 style="font-size:15px;color:#856404;margin:24px 0 10px;display:flex;align-items:center;gap:8px;">
                        <span style="background:#fff3cd;color:#856404;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:700;">${pending} Pending</span>
                    </h3>
                    <table>
                        <thead><tr><th>#</th><th>Rider Name</th><th>Status</th></tr></thead>
                        <tbody>${generateRows(pendingRiders)}</tbody>
                    </table>
                `;
            }
            
            if (no_duty > 0) {
                tableContent += `
                    <h3 style="font-size:15px;color:#842029;margin:24px 0 10px;display:flex;align-items:center;gap:8px;">
                        <span style="background:#f8d7da;color:#842029;padding:4px 12px;border-radius:8px;font-size:13px;font-weight:700;">${no_duty} No Remit</span>
                    </h3>
                    <table>
                        <thead><tr><th>#</th><th>Rider Name</th><th>Status</th></tr></thead>
                        <tbody>${generateRows(noDutyRiders)}</tbody>
                    </table>
                `;
            }

            const win = window.open('', '_blank', 'width=700,height=650');
            win.document.write(`<!DOCTYPE html><html><head><title>Rider Status – ${dateLabel}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 32px; color: #1f2937; }
                h2 { font-size: 18px; font-weight: 800; margin: 0 0 4px; }
                h3 { margin-top: 24px; }
                .sub { font-size: 12px; color: #6b7280; margin-bottom: 8px; }
                .legend { font-size: 12px; margin-bottom: 18px; display: flex; gap: 14px; }
                .legend span { padding: 2px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                thead tr { background: #2d4016; color: #fff; }
                th { padding: 9px 12px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 0.4px; }
                td { padding: 8px 12px; border-bottom: 1px solid #e5e7eb; font-size: 13px; }
                tr:nth-child(even) td { background: #f9fafb; }
                .footer { margin-top: 18px; font-size: 11px; color: #9ca3af; }
                @media print { button { display: none; } }
            </style></head><body>
            <h2>Rider Remittance Status</h2>
            <div class="sub">Date: ${dateLabel} &nbsp;|&nbsp; Generated: ${new Date().toLocaleString('en-PH')}</div>
            <div class="legend">
                <span style="background:#d4edda;color:#155724;">${cleared} Cleared</span>
                <span style="background:#ffe3e3;color:#c92a2a;">${late} Late Remitted</span>
                <span style="background:#fff3cd;color:#856404;">${pending} Pending</span>
                <span style="background:#f8d7da;color:#842029;">${no_duty} No Remit</span>
            </div>
            ${tableContent}
            <div class="footer">When in Baguio Inc. &mdash; Remittance System</div>
            <br><button onclick="window.print()" style="padding:8px 20px;background:#2d4016;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;">Print / Save as PDF</button>
            </body></html>`);
            win.document.close();
        }

        // ===== Payment Mode Multiple Selection Handler =====
        function initializePaymentModes() {
            const checkboxes = document.querySelectorAll('.payment-mode-checkbox');
            const breakdownSection = document.getElementById('paymentBreakdownSection');
            const breakdownFields = document.getElementById('paymentBreakdownFields');
            const totalCollection = document.getElementById('totalCollection');

            function updatePaymentBreakdown() {
                const selectedModes = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (selectedModes.length === 0) {
                    breakdownSection.style.display = 'none';
                    return;
                }

                breakdownSection.style.display = 'block';
                const collectionAmount = parseFloat(totalCollection.value) || 0;
                
                // Build breakdown fields HTML
                let fieldsHTML = '';
                let totalPayment = 0;

                selectedModes.forEach(mode => {
                    const modeLabel = mode === 'cash' ? 'Cash' : 'GCash';
                    const inputId = `amount${mode.charAt(0).toUpperCase() + mode.slice(1)}`;
                    
                    fieldsHTML += `
                        <div style="display: grid; grid-template-columns: 1fr 150px; gap: 12px; align-items: center;">
                            <label style="font-weight: 600; color: #2d4016;">${modeLabel}:</label>
                            <input 
                                type="number" 
                                id="${inputId}" 
                                class="payment-amount-input" 
                                step="0.01" 
                                min="0"
                                placeholder="0.00"
                                value="${collectionAmount / selectedModes.length}"
                                style="background: #fff; border: 1.5px solid #d6eacc; padding: 8px 12px; border-radius: 6px; font-weight: 600,"
                                onchange="updateTotalPaymentDisplay()">
                        </div>
                    `;
                });

                breakdownFields.innerHTML = fieldsHTML;
                updateTotalPaymentDisplay();

                // Add event listeners to new inputs
                document.querySelectorAll('.payment-amount-input').forEach(input => {
                    input.addEventListener('input', updateTotalPaymentDisplay);
                });
            }

            // Update total display
            window.updateTotalPaymentDisplay = function() {
                const amounts = Array.from(document.querySelectorAll('.payment-amount-input'))
                    .map(input => parseFloat(input.value) || 0);
                const total = amounts.reduce((sum, amount) => sum + amount, 0);
                const display = document.getElementById('totalPaymentDisplay');
                if (display) {
                    display.value = '₱' + total.toFixed(2);
                }

                const totalRemitInput = document.getElementById('totalRemit');
                if (totalRemitInput) {
                    totalRemitInput.value = total > 0 ? total.toFixed(2) : '';
                }

                updateRemainingRemitHint();
            };

            // Add event listeners to checkboxes
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updatePaymentBreakdown);
            });

            window.refreshPaymentBreakdown = updatePaymentBreakdown;

            // Initialize on load
            updatePaymentBreakdown();
        }

        function syncRemitRemarkRemoveButtons() {
            const rows = document.querySelectorAll('#remitRemarksRows .remit-remark-row');
            rows.forEach(row => {
                const removeBtn = row.querySelector('.remit-remark-remove');
                if (removeBtn) {
                    removeBtn.style.visibility = rows.length > 1 ? 'visible' : 'hidden';
                }
            });
        }

        function addRemitRemarkRow(remarkValue = '', amountValue = '') {
            const container = document.getElementById('remitRemarksRows');
            const sourceRow = container ? container.querySelector('.remit-remark-row') : null;
            if (!container || !sourceRow) return;

            const newRow = sourceRow.cloneNode(true);
            const remarkInput = newRow.querySelector('.remit-remarks-input');
            const amountInput = newRow.querySelector('.remit-remarks-amount');
            if (remarkInput) remarkInput.value = remarkValue;
            if (amountInput) amountInput.value = amountValue;
            container.appendChild(newRow);
            syncRemitRemarkRemoveButtons();
        }

        function removeRemitRemarkRow(button) {
            const container = document.getElementById('remitRemarksRows');
            if (!container) return;
            const rows = container.querySelectorAll('.remit-remark-row');
            const row = button.closest('.remit-remark-row');
            if (!row) return;

            if (rows.length <= 1) {
                const remarkInput = row.querySelector('.remit-remarks-input');
                const amountInput = row.querySelector('.remit-remarks-amount');
                if (remarkInput) remarkInput.value = '';
                if (amountInput) amountInput.value = '';
                return;
            }

            row.remove();
            syncRemitRemarkRemoveButtons();
        }

        function resetRemitRemarksRows() {
            const container = document.getElementById('remitRemarksRows');
            if (!container) return;

            const rows = Array.from(container.querySelectorAll('.remit-remark-row'));
            if (!rows.length) return;

            const firstRow = rows[0];
            rows.slice(1).forEach(row => row.remove());

            const remarkInput = firstRow.querySelector('.remit-remarks-input');
            const amountInput = firstRow.querySelector('.remit-remarks-amount');
            if (remarkInput) remarkInput.value = '';
            if (amountInput) amountInput.value = '';

            const remarksHidden = document.getElementById('consolidatedRemarks');
            const remarksAmountHidden = document.getElementById('consolidatedRemarksAmount');
            if (remarksHidden) remarksHidden.value = '';
            if (remarksAmountHidden) remarksAmountHidden.value = '';

            syncRemitRemarkRemoveButtons();
        }

        function consolidateRemitRemarks() {
            const rows = document.querySelectorAll('#remitRemarksRows .remit-remark-row');
            const entries = [];

            for (const row of rows) {
                const remarks = (row.querySelector('.remit-remarks-input')?.value || '').trim();
                const amountRaw = (row.querySelector('.remit-remarks-amount')?.value || '').trim();

                if (!remarks && !amountRaw) {
                    continue;
                }

                if (!remarks && amountRaw) {
                    showToast('Please add a remark text for the amount entered.', 'warning');
                    return {
                        valid: false
                    };
                }

                const amount = amountRaw ? parseFloat(amountRaw) : 0;
                if (Number.isNaN(amount) || amount < 0) {
                    showToast('Remarks amount must be a valid non-negative number.', 'warning');
                    return {
                        valid: false
                    };
                }

                entries.push({
                    remarks,
                    amount
                });
            }

            const combinedRemarks = entries.map((entry) => {
                const amountPart = entry.amount > 0 ? ` - ₱${entry.amount.toFixed(2)}` : '';
                return `- ${entry.remarks}${amountPart}`;
            }).join(' | ');

            const remarksHidden = document.getElementById('consolidatedRemarks');
            const remarksAmountHidden = document.getElementById('consolidatedRemarksAmount');
            if (remarksHidden) remarksHidden.value = combinedRemarks;
            if (remarksAmountHidden) remarksAmountHidden.value = '';

            return {
                valid: true,
                entries,
                combinedRemarks,
                totalAmount: 0
            };
        }

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('paymentModesContainer')) {
                initializePaymentModes();
            }
            syncRemitRemarkRemoveButtons();

            const totalRemitInput = document.getElementById('totalRemit');
            if (totalRemitInput) {
                totalRemitInput.addEventListener('input', updateRemainingRemitHint);
            }
        });
    </script>

    @include('partials.floating-widgets')
</body>

</html>

