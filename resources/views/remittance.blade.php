<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            padding: 24px 28px;
            overflow-y: auto;
            background: #f0f2f5;
        }

        .content-header {
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffff;
            padding: 14px 18px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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
            grid-template-columns: 1fr 2fr;
            gap: 20px;

        }

        .rider-queue-panel {
            background: #ffffff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.07), 0 4px 16px rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            transition: box-shadow 0.2s ease;
            animation: fadeInUp 0.5s ease;
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
                width: 200px;
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
            <a href="{{ route('remittance') }}" class="menu-item active">
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
        <h1 style="font-size: 22px; font-weight: 800; margin-bottom: 0; color: #111827; letter-spacing: -0.3px;">
            Remittance Management</h1>
        <div class="user-indicator" style="justify-content: flex-end; margin-bottom: 16px;">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</span>
            </div>
            <a href="{{ route('profile') }}" class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </a>
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
        <div class="remit-tabs" id="remitTabs">
            <button class="remit-tab-btn active" data-tab="overview">Remittance Overview</button>
            <button class="remit-tab-btn" data-tab="payroll">Rider's Payroll</button>
            <button class="remit-tab-btn" data-tab="deductions">Deductions</button>
        </div>



        <div class="remittance-container">
            <!-- Rider Queue Panel -->
            <div class="rider-queue-panel">
                <div class="panel-header">
                    <h2>Rider Queue</h2>
                    <button class="add-remit-btn" onclick="openAddRiderModal()">
                        <i class="fas fa-plus"></i>
                        <span>Add Rider</span>
                    </button>
                </div>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="riderSearch" placeholder="Search rider..." oninput="searchRiders()">
                </div>
                <div class="rider-list">
                    @forelse($riders as $index => $rider)
                        @php $isBlocked = in_array($rider->id, $blockedRiderIds); @endphp
                        <div class="rider-row" data-rider-id="{{ $rider->id }}"
                            data-blocked="{{ $isBlocked ? 'true' : 'false' }}">
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p style="font-size: 14px; margin: 0;">No riders yet. Click "Add Rider" to get started.</p>
                        </div>
                    @endforelse
                </div>
            </div>


            <!-- Remittance Details Panel -->
            <div class="remittance-details-panel">
                <style>
                    .remit-tabs {
                        display: flex;
                        justify-content: stretch;
                        align-items: stretch;
                        margin-bottom: 0;
                        width: 100%;
                        background: #f3f4f6;
                        border-top-left-radius: 12px;
                        border-top-right-radius: 12px;
                        border: 1px solid #e5e7eb;
                        border-bottom: none;
                        padding: 6px 6px 0;
                        gap: 2px;
                        max-width: 762px;
                        margin-left: auto;
                        margin-right: 0;
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
                    <div class="payroll-panel">
                        <form id="payrollForm">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Rider
                                        ID:</label>
                                    <input type="text" name="rider_id" readonly
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #f5f9f2; color: #436026; font-weight: 600; cursor: default;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Rider
                                        Name:</label>
                                    <input type="text" name="rider_name" readonly
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #f5f9f2; color: #436026; font-weight: 600; cursor: default;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Base
                                        Salary:</label>
                                    <input type="number" name="base_salary"
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label
                                        style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Incentives:</label>
                                    <input type="number" name="incentives"
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Salary
                                        Schedule:</label>
                                    <select name="salary_schedule"
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                        <option value="" disabled selected hidden>Choose schedule...</option>
                                        <option value="Mon-Thur/Friday payout">Mon-Thur/Friday payout</option>
                                        <option value="Fri-Sun/Monday payout">Fri-Sun/Monday payout</option>
                                        <option value="Mon-Sun/Monday payout">Mon-Sun/Monday payout</option>
                                        <option value="Cut off payout">Cut off payout</option>
                                    </select>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 12px;">
                                    <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Mode of
                                        Payment:</label>
                                    <select name="mode_of_payment"
                                        style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                                        <option value="" disabled selected hidden>Choose payment mode...</option>
                                        <option value="cash">Cash</option>
                                        <option value="bank">Bank Digital Wallet</option>
                                    </select>
                                </div>
                            </div>
                            <hr style="margin: 16px 0; border-color: #cfcfcf;">
                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 16px;">
                                <label style="flex: 1; font-size: 15px; font-weight: 600; color: #222;">Net
                                    Salary:</label>
                                <input type="number" name="net_salary"
                                    style="flex: 2; font-size: 15px; padding: 7px 12px; border-radius: 8px; border: 1px solid #bdbdbd; background: #fff;">
                            </div>
                            <div style="display: flex; justify-content: flex-end;">
                                <button type="submit" id="payrollSubmitBtn"
                                    style="background: #436026; color: #fff; font-size: 15px; font-weight: 600; padding: 8px 22px; border: none; border-radius: 8px; display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                    <i class="fas fa-briefcase"></i> Confirm Payroll
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="remit-tab-content" id="tabDeductions" style="display:none;">
                    <script>
                        // Toast Notification Function
                        function showToast(message, type = 'success', duration = 3000) {
                            const container = document.getElementById('toastContainer');
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
                        document.getElementById('payrollForm').addEventListener('submit', async function(e) {
                            e.preventDefault();
                            const btn = document.getElementById('payrollSubmitBtn');
                            const form = e.target;

                            // Validate form fields before submitting
                            const riderId = form.querySelector('[name="rider_id"]').value.trim();
                            const riderName = form.querySelector('[name="rider_name"]').value.trim();
                            const baseSalary = form.querySelector('[name="base_salary"]').value;
                            const salarySchedule = form.querySelector('[name="salary_schedule"]').value;
                            const modeOfPayment = form.querySelector('[name="mode_of_payment"]').value;
                            const netSalary = form.querySelector('[name="net_salary"]').value;

                            // Check for empty required fields
                            if (!riderId) {
                                showToast('Please select a rider from the Rider Queue first', 'warning');
                                return;
                            }
                            if (!riderName) {
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
                            if (!modeOfPayment) {
                                showToast('Please select Mode of Payment', 'warning');
                                return;
                            }
                            if (!netSalary) {
                                showToast('Please enter Net Salary', 'warning');
                                return;
                            }

                            btn.disabled = true;
                            btn.style.opacity = 0.7;
                            const data = new FormData(form);
                            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                            try {
                                const res = await fetch('/rider-payroll', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrf
                                    },
                                    body: data
                                });

                                console.log('Response status:', res.status);
                                console.log('Response ok:', res.ok);

                                if (res.ok) {
                                    const responseData = await res.json();
                                    form.reset();
                                    showToast('Payroll saved! Opening payslip...', 'success');

                                    // Compute the date range for this payroll schedule
                                    const [fromDate, toDate] = getPayrollDateRange(salarySchedule);
                                    const payrollId = responseData.payroll && responseData.payroll.id ? responseData.payroll
                                        .id : '';

                                    // Open the payslip in a new tab
                                    if (payrollId) {
                                        let payslipUrl = '/rider-payroll/' + payrollId + '/payslip';
                                        if (fromDate && toDate) {
                                            payslipUrl += '?from_date=' + fromDate + '&to_date=' + toDate;
                                        }
                                        setTimeout(() => {
                                            window.open(payslipUrl, '_blank');
                                            window.location.reload();
                                        }, 500);
                                    } else {
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1500);
                                    }
                                } else {
                                    let errorMsg = 'Failed to save payroll.';
                                    const responseText = await res.text();
                                    console.log('Error response:', responseText);

                                    try {
                                        const errorData = JSON.parse(responseText);
                                        console.log('Parsed error data:', errorData);

                                        if (errorData && errorData.message) {
                                            errorMsg = errorData.message;
                                        } else if (errorData && errorData.errors) {
                                            // Format validation errors nicely
                                            const errors = errorData.errors;
                                            errorMsg = Object.keys(errors).map(field => {
                                                return field + ': ' + errors[field].join(', ');
                                            }).join(' | ');
                                        }
                                    } catch (jsonErr) {
                                        console.error('Error parsing response:', jsonErr);
                                        errorMsg = 'Server error: ' + responseText.substring(0, 100);
                                    }
                                    showToast(errorMsg, 'error');
                                }
                            } catch (err) {
                                console.error('Network error:', err);
                                showToast('Network error: ' + err.message, 'error');
                            }

                            btn.disabled = false;
                            btn.style.opacity = 1;
                        });

                        /**
                         * Returns [fromDate, toDate] (YYYY-MM-DD strings) for a given salary schedule,
                         * relative to today.  Used to filter the remittances shown on the payslip.
                         */
                        function getPayrollDateRange(schedule) {
                            const now = new Date();
                            const pad = n => String(n).padStart(2, '0');
                            const fmt = d => `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;

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
                    <div class="details-header">Deductions</div>

                    {{-- Rider info card --}}
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; background: linear-gradient(135deg, #f5f9f2 0%, #edf5e8 100%); border: 1px solid #d6eacc; border-radius: 8px; padding: 12px 16px; margin-bottom: 14px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; border-radius: 50%; background: #436026; color: #fff; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center;"
                                id="deductionRiderAvatar">?</div>
                            <div>
                                <div
                                    style="font-size: 11px; color: #6c757d; font-weight: 500; text-transform: uppercase; letter-spacing: 0.4px;">
                                    Selected Rider</div>
                                <div style="font-size: 14px; font-weight: 700; color: #1a1a1a;"
                                    id="deductionRiderNameDisplay">No rider selected</div>
                            </div>
                        </div>
                        <button type="button" id="addDeductionBtn" onclick="toggleDeductionForm()"
                            style="background: #436026; color: #fff; font-size: 12px; font-weight: 600; padding: 8px 16px; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: background 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.12);"
                            onmouseover="this.style.background='#5a7d35'"
                            onmouseout="this.style.background='#436026'">
                            <i class="fas fa-plus"></i> Add Deduction
                        </button>
                    </div>

                    {{-- Two-column layout: form + staged list --}}
                    <div style="display: flex; gap: 14px; align-items: flex-start;">

                        {{-- Add deduction input form (collapsible) --}}
                        <div id="deductionFormPanel"
                            style="display: none; flex: 1; min-width: 0; background: #fff; border: 1px solid #d6eacc; border-radius: 8px; padding: 18px; box-shadow: 0 2px 8px rgba(67,96,38,0.07);">
                            <div
                                style="font-size: 13px; font-weight: 700; color: #436026; margin-bottom: 14px; display: flex; align-items: center; gap: 7px;">
                                <i class="fas fa-minus-circle"></i> New Deduction Entry
                            </div>
                            <form id="deductionsForm" onsubmit="addDeductionToList(event)">
                                <input type="hidden" name="rider_id">
                                <input type="hidden" name="rider_name">
                                <div style="display: flex; flex-direction: column; gap: 12px;">
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <label style="font-size: 13px; font-weight: 600; color: #1a1a1a;">Deduction
                                            <span style="color:#dc3545;">*</span></label>
                                        <input type="text" id="deductionRemarks" name="remarks"
                                            placeholder="e.g. Cash shortage, Equipment damage..."
                                            style="width: 100%; font-size: 13px; padding: 8px 10px; border-radius: 5px; border: 1px solid #d1d5db; background: #fff; transition: border-color 0.2s; box-sizing: border-box;"
                                            onfocus="this.style.borderColor='#436026'"
                                            onblur="this.style.borderColor='#d1d5db'">
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 4px;">
                                        <label style="font-size: 13px; font-weight: 600; color: #1a1a1a;">Amount <span
                                                style="color:#dc3545;">*</span></label>
                                        <input type="number" id="deductionAmount" name="amount" step="0.01"
                                            min="0.01" placeholder="0.00"
                                            style="width: 100%; font-size: 13px; padding: 8px 10px; border-radius: 5px; border: 1px solid #d1d5db; background: #fff; transition: border-color 0.2s; box-sizing: border-box;"
                                            onfocus="this.style.borderColor='#436026'"
                                            onblur="this.style.borderColor='#d1d5db'">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: flex-end; gap: 8px; margin-top: 16px;">
                                    <button type="button" onclick="toggleDeductionForm()"
                                        style="background: #fff; color: #6c757d; font-size: 13px; font-weight: 600; padding: 8px 18px; border: 1px solid #d1d5db; border-radius: 5px; cursor: pointer;"
                                        onmouseover="this.style.borderColor='#adb5bd'"
                                        onmouseout="this.style.borderColor='#d1d5db'">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        style="background: #436026; color: #fff; font-size: 13px; font-weight: 600; padding: 8px 22px; border: none; border-radius: 5px; display: flex; align-items: center; gap: 7px; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
                                        onmouseover="this.style.background='#5a7d35'"
                                        onmouseout="this.style.background='#436026'">
                                        <i class="fas fa-plus"></i> Add to List
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Staged deductions list --}}
                        <div id="pendingDeductionsList"
                            style="display: none; flex: 1; min-width: 0; background: #fff; border: 1px solid #d6eacc; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(67,96,38,0.07);">
                            <div
                                style="background: linear-gradient(135deg, #436026 0%, #5a7d35 100%); color: #fff; padding: 10px 16px; font-size: 13px; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
                                <span><i class="fas fa-list"></i> Deductions to Submit</span>
                                <span id="pendingDeductionCount"
                                    style="background: rgba(255,255,255,0.25); border-radius: 10px; padding: 2px 10px; font-size: 12px;">0
                                    items</span>
                            </div>
                            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                                <thead>
                                    <tr style="background: #f5f9f2; border-bottom: 1px solid #d6eacc;">
                                        <th
                                            style="padding: 8px 14px; text-align: left; font-weight: 600; color: #436026;">
                                            #</th>
                                        <th
                                            style="padding: 8px 14px; text-align: left; font-weight: 600; color: #436026;">
                                            Deduction</th>
                                        <th
                                            style="padding: 8px 14px; text-align: right; font-weight: 600; color: #436026;">
                                            Amount</th>
                                        <th
                                            style="padding: 8px 14px; text-align: center; font-weight: 600; color: #436026;">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="pendingDeductionsTbody"></tbody>
                                <tfoot>
                                    <tr style="background: #f5f9f2; border-top: 2px solid #d6eacc;">
                                        <td colspan="2"
                                            style="padding: 10px 14px; font-weight: 700; color: #436026;">Total</td>
                                        <td style="padding: 10px 14px; text-align: right; font-weight: 700; color: #dc3545;"
                                            id="pendingDeductionsTotal">₱0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div style="padding: 12px 14px; display: flex; justify-content: flex-end;">
                                <button type="button" onclick="showDeductionConfirmModal()"
                                    style="background: #dc3545; color: #fff; font-size: 13px; font-weight: 600; padding: 9px 22px; border: none; border-radius: 6px; display: flex; align-items: center; gap: 7px; cursor: pointer; box-shadow: 0 2px 6px rgba(220,53,69,0.3);"
                                    onmouseover="this.style.background='#c82333'"
                                    onmouseout="this.style.background='#dc3545'">
                                    <i class="fas fa-save"></i> Submit All Deductions
                                </button>
                            </div>
                        </div>

                    </div>{{-- end two-column --}}

                    {{-- Confirmation modal --}}
                    <div id="deductionConfirmModal"
                        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:9999; align-items:center; justify-content:center;">
                        <div
                            style="background:#fff; border-radius:12px; padding:28px 28px 22px; max-width:400px; width:90%; box-shadow:0 8px 32px rgba(0,0,0,0.18); text-align:center;">
                            <div
                                style="width:56px;height:56px;border-radius:50%;background:#fff3cd;color:#e0a800;font-size:26px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                                <i class="fas fa-exclamation-triangle"></i></div>
                            <div style="font-size:16px;font-weight:700;color:#1a1a1a;margin-bottom:8px;">Confirm Submit
                            </div>
                            <div style="font-size:13px;color:#6c757d;margin-bottom:6px;">You are about to save <strong
                                    id="confirmDeductionCount">0</strong> deduction(s) for:</div>
                            <div style="font-size:14px;font-weight:700;color:#436026;margin-bottom:6px;"
                                id="confirmDeductionRider"></div>
                            <div style="font-size:15px;font-weight:700;color:#dc3545;margin-bottom:20px;">Total: <span
                                    id="confirmDeductionTotal"></span></div>
                            <div style="display:flex;gap:10px;justify-content:center;">
                                <button type="button" onclick="closeDeductionConfirmModal()"
                                    style="padding:9px 22px;border:1px solid #d1d5db;border-radius:6px;background:#fff;color:#6c757d;font-size:13px;font-weight:600;cursor:pointer;">Cancel</button>
                                <button type="button" id="confirmDeductionBtn" onclick="submitAllDeductions()"
                                    style="padding:9px 22px;border:none;border-radius:6px;background:#dc3545;color:#fff;font-size:13px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:7px;"><i
                                        class="fas fa-check"></i> Yes, Submit</button>
                            </div>
                        </div>
                    </div>

                    <script>
                        // ── Staged deductions list ────────────────────────────────────────
                        let pendingDeductions = [];

                        function addDeductionToList(e) {
                            e.preventDefault();
                            const form = document.getElementById('deductionsForm');
                            const riderId = form.querySelector('[name="rider_id"]').value.trim();
                            const riderName = form.querySelector('[name="rider_name"]').value.trim();
                            const remarks = document.getElementById('deductionRemarks').value.trim();
                            const amount = parseFloat(document.getElementById('deductionAmount').value);

                            if (!riderId || !riderName) {
                                showToast('Please select a rider from the Rider Queue first', 'warning');
                                return;
                            }
                            if (!remarks) {
                                showToast('Please enter a deduction description', 'warning');
                                return;
                            }
                            if (!amount || amount <= 0) {
                                showToast('Please enter a valid Amount', 'warning');
                                return;
                            }

                            pendingDeductions.push({
                                rider_id: riderId,
                                rider_name: riderName,
                                remarks: remarks,
                                amount: amount,
                                date: new Date().toISOString().split('T')[0]
                            });

                            renderPendingDeductions();
                            document.getElementById('deductionRemarks').value = '';
                            document.getElementById('deductionAmount').value = '';
                            document.getElementById('deductionRemarks').focus();
                            showToast('Added to list. You can add more or submit all.', 'info');
                        }

                        function renderPendingDeductions() {
                            const tbody = document.getElementById('pendingDeductionsTbody');
                            const panel = document.getElementById('pendingDeductionsList');
                            const countEl = document.getElementById('pendingDeductionCount');
                            const totalEl = document.getElementById('pendingDeductionsTotal');

                            if (!pendingDeductions.length) {
                                panel.style.display = 'none';
                                return;
                            }

                            panel.style.display = 'block';
                            countEl.textContent = pendingDeductions.length + ' item' + (pendingDeductions.length > 1 ? 's' : '');

                            let total = 0;
                            tbody.innerHTML = pendingDeductions.map((d, i) => {
                                total += d.amount;
                                return `<tr style="border-bottom:1px solid #f0f0f0;">
                        <td style="padding:9px 14px;color:#6c757d;">${i + 1}</td>
                        <td style="padding:9px 14px;">${d.remarks}</td>
                        <td style="padding:9px 14px;text-align:right;color:#dc3545;font-weight:600;">- ₱${d.amount.toFixed(2)}</td>
                        <td style="padding:9px 14px;text-align:center;">
                            <button type="button" onclick="removeDeductionItem(${i})" style="background:none;border:none;color:#dc3545;cursor:pointer;font-size:14px;padding:2px 6px;" title="Remove"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>`;
                            }).join('');

                            totalEl.textContent = '₱' + total.toFixed(2);
                        }

                        function removeDeductionItem(index) {
                            pendingDeductions.splice(index, 1);
                            renderPendingDeductions();
                        }

                        function showDeductionConfirmModal() {
                            if (!pendingDeductions.length) return;
                            let total = pendingDeductions.reduce((s, d) => s + d.amount, 0);
                            document.getElementById('confirmDeductionCount').textContent = pendingDeductions.length;
                            document.getElementById('confirmDeductionRider').textContent = pendingDeductions[0].rider_name;
                            document.getElementById('confirmDeductionTotal').textContent = '₱' + total.toFixed(2);
                            const modal = document.getElementById('deductionConfirmModal');
                            modal.style.display = 'flex';
                        }

                        function closeDeductionConfirmModal() {
                            document.getElementById('deductionConfirmModal').style.display = 'none';
                        }

                        async function submitAllDeductions() {
                            const btn = document.getElementById('confirmDeductionBtn');
                            btn.disabled = true;
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                            let saved = 0,
                                failed = 0;

                            for (const d of pendingDeductions) {
                                try {
                                    const fd = new FormData();
                                    fd.append('rider_id', d.rider_id);
                                    fd.append('rider_name', d.rider_name);
                                    fd.append('remarks', d.remarks);
                                    fd.append('amount', d.amount);
                                    fd.append('date', d.date);
                                    const res = await fetch('/rider-deductions', {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrf
                                        },
                                        body: fd
                                    });
                                    res.ok ? saved++ : failed++;
                                } catch {
                                    failed++;
                                }
                            }

                            closeDeductionConfirmModal();
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-check"></i> Yes, Submit';

                            if (failed === 0) {
                                pendingDeductions = [];
                                renderPendingDeductions();
                                toggleDeductionForm(true);
                                showToast(saved + ' deduction(s) saved! Refreshing...', 'success');
                                setTimeout(() => window.location.reload(), 1500);
                            } else {
                                showToast(saved + ' saved, ' + failed + ' failed. Check and try again.', 'error');
                            }
                        }
                    </script>
                </div>
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
                            } else if (this.dataset.tab === 'deductions') {
                                document.getElementById('tabDeductions').style.display = '';
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
                                            <span
                                                style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 600; {{ $remittance->mode_of_payment === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                {{ strtoupper($remittance->mode_of_payment) }}
                                            </span>
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
                                                <span
                                                    style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                    title="{{ $remittance->remarks }}">
                                                    {{ $remittance->remarks }}
                                                </span>
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
                                        <td><strong
                                                style="color: #436026;">₱{{ number_format($payroll->net_salary, 2) }}</strong>
                                        </td>
                                        <td>{{ $payroll->salary_schedule }}</td>
                                        <td>
                                            <span
                                                style="display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600; {{ $payroll->mode_of_payment === 'cash' ? 'background: #d4edda; color: #155724;' : 'background: #d1ecf1; color: #0c5460;' }}">
                                                {{ ucfirst($payroll->mode_of_payment) }}
                                            </span>
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

    <!-- Add Rider Modal -->
    <div class="modal-overlay" id="addRiderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-plus"></i> Add New Rider</h3>
                <button class="modal-close" onclick="closeAddRiderModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addRiderForm">
                    <div class="form-group">
                        <label for="riderName"><i class="fas fa-user"></i> Rider Name</label>
                        <input type="text" id="riderName" name="riderName" placeholder="Enter rider name"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn submit" onclick="submitAddRider()"><i class="fas fa-check"></i> Add
                    Rider</button>
            </div>
        </div>
    </div>

    <!-- Remit Modal -->
    <div class="modal-overlay" id="remitModal">
        <div class="modal-content" style="max-width: 600px;">
            <div class="modal-header">
                <h3><i class="fas fa-money-bill-wave"></i> Remittance Form</h3>

            </div>
            <div class="modal-body">
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
                                min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="totalDeliveryFee"><i class="fas fa-dollar-sign"></i> Total Delivery
                                Fee</label>
                            <input type="number" id="totalDeliveryFee" name="total_delivery_fee" placeholder="0.00"
                                step="0.01" min="0" required>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalRemit"><i class="fas fa-money-check"></i> Total Remit</label>
                            <input type="number" id="totalRemit" name="total_remit" placeholder="0.00"
                                step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="totalTips"><i class="fas fa-hand-holding-usd"></i> Total Tips</label>
                            <input type="number" id="totalTips" name="total_tips" placeholder="0.00"
                                step="0.01" min="0">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalCollection"><i class="fas fa-wallet"></i> Total Collection</label>
                            <input type="number" id="totalCollection" name="total_collection" placeholder="0.00"
                                step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="modeOfPayment"><i class="fas fa-credit-card"></i> Mode of Payment</label>
                            <select id="modeOfPayment" name="mode_of_payment" required>
                                <option value="">Select Payment Mode</option>
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="remarks"><i class="fas fa-comment"></i> Remarks (optional)</label>
                        <textarea id="remarks" name="remarks" placeholder="Enter any remarks here" rows="3"
                            style="width: 100%; background: #f8f9fa; border-radius: 8px; border: 1px solid #e0e0e0; padding: 10px; resize: vertical;"></textarea>
                    </div>
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

        function displayRiderRemittances(remittances, riderName) {
            const content = document.getElementById('riderRecordsContent');
            const dateFilter = document.getElementById('riderRecordsDateFilter');
            const filterDateInput = document.getElementById('riderRecordsFilterDate');

            currentRiderRemittances = remittances;
            filteredRiderRemittances = remittances;
            currentRiderName = riderName;
            currentPage = 1;

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
                const date = new Date(remittance.created_at);
                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const statusColor = remittance.status === 'confirmed' ? '#28a745' : '#ffc107';
                const statusBg = remittance.status === 'confirmed' ? '#d4edda' : '#fff3cd';
                const statusText = remittance.status === 'confirmed' ? 'CLEARED' : remittance.status.toUpperCase();

                const paymentColor = remittance.mode_of_payment === 'cash' ? '#28a745' : '#007bff';
                const paymentBg = remittance.mode_of_payment === 'cash' ? '#d4edda' : '#cfe2ff';

                tableHTML += `
                    <tr style="border-bottom: 1px solid #e9ecef; ${index % 2 === 0 ? 'background: #f8f9fa;' : ''}">
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
                                ${statusText}
                            </span>
                        </td>
                        <td style="padding: 12px; font-size: 13px; color: #333; max-width: 250px;">
                            ${remittance.remarks ? `<span style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="${remittance.remarks}">${remittance.remarks}</span>` : '<span style="color: #999; font-style: italic;">No remarks</span>'}
                        </td>
                    </tr>
                `;
            });

            tableHTML += `
                        </tbody>
                    </table>
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
        }

        function goToRiderRecordsPage(page) {
            currentPage = page;
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
                    const remittanceDate = new Date(remittance.created_at);
                    const filterDate = new Date(selectedDate);

                    // Compare only the date part (ignore time)
                    return remittanceDate.getFullYear() === filterDate.getFullYear() &&
                        remittanceDate.getMonth() === filterDate.getMonth() &&
                        remittanceDate.getDate() === filterDate.getDate();
                });
            }

            // Reset to page 1 and render
            currentPage = 1;
            renderRiderRemittancesPage();
        }

        function clearRiderRecordsDateFilter() {
            const filterDateInput = document.getElementById('riderRecordsFilterDate');
            filterDateInput.value = '';
            filteredRiderRemittances = currentRiderRemittances;
            currentPage = 1;
            renderRiderRemittancesPage();
        }

        function closeRiderRecordsModal() {
            document.getElementById('riderRecordsModal').classList.remove('active');
            // Reset pagination state
            currentRiderRemittances = [];
            filteredRiderRemittances = [];
            currentRiderName = '';
            currentPage = 1;
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

        // Add Rider Modal Functions
        function openAddRiderModal() {
            document.getElementById('addRiderModal').classList.add('active');
            document.getElementById('riderName').focus();
        }

        function closeAddRiderModal() {
            document.getElementById('addRiderModal').classList.remove('active');
            document.getElementById('addRiderForm').reset();
        }

        // Close modal when clicking outside
        document.getElementById('addRiderModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeAddRiderModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAddRiderModal();
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

        function submitAddRider() {
            const form = document.getElementById('addRiderForm');

            if (form.checkValidity()) {
                const riderName = document.getElementById('riderName').value;

                // Show custom confirmation modal
                showConfirmModal(`Are you sure you want to add rider "${riderName}"?`, function() {
                    // Get CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Send AJAX request to save rider (status automatically set to 'pending')
                    fetch('/riders', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                name: riderName
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const rider = data.rider;

                                // Remove empty state if exists
                                const emptyState = document.querySelector('.empty-state');
                                if (emptyState) {
                                    emptyState.remove();
                                }

                                // Create new rider row
                                const riderList = document.querySelector('.rider-list');
                                const newRiderRow = document.createElement('div');
                                newRiderRow.className = 'rider-row';
                                newRiderRow.setAttribute('data-rider-id', rider.id);

                                const statusClass = rider.status === 'pending' ? 'pending' : 'cleared';
                                const statusText = rider.status === 'pending' ? 'Pending' : 'Cleared';

                                newRiderRow.innerHTML = `
                            <div class="rider-dropdown">
                                <div class="rider-dropdown-header" onclick="toggleRiderDropdown(this)">
                                    <div style="display:flex;align-items:center;gap:9px;">
                                        <div class="rider-avatar">${rider.name.charAt(0).toUpperCase()}</div>
                                        <div class="rider-item-info">
                                            <strong>${rider.name}</strong>
                                        </div>
                                    </div>
                                    <div style="display:flex;align-items:center;gap:6px;">
                                        <span class="rider-status ${statusClass}">${statusText}</span>
                                        <i class="fas fa-chevron-down rider-chevron"></i>
                                    </div>
                                </div>
                                <div class="rider-dropdown-body">
                                    <button class="rider-action-btn" onclick="openRemitModal(${rider.id}, '${rider.name}');event.stopPropagation()">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Remit</span>
                                    </button>
                                    <button class="rider-action-btn records-btn" onclick="openRiderRecordsModal(${rider.id}, '${rider.name}');event.stopPropagation()">
                                        <i class="fas fa-history"></i>
                                        <span>Records</span>
                                    </button>
                                </div>
                            </div>
                        `;

                                riderList.appendChild(newRiderRow);

                                // Close modal and reset form
                                closeAddRiderModal();

                                // Show success message
                                showToast(data.message, 'success');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('The rider name is already exist', 'error');
                        });
                });
            } else {
                form.reportValidity();
            }
        }

        // Remit Modal Functions
        function openRemitModal(riderId, riderName) {
            // Highlight the active dropdown
            document.querySelectorAll('.rider-dropdown').forEach(d => d.classList.remove('active-highlight'));
            const selectedRow = document.querySelector(`[data-rider-id="${riderId}"]`);
            if (selectedRow) {
                const dropdown = selectedRow.querySelector('.rider-dropdown');
                if (dropdown) dropdown.classList.add('active-highlight');
            }

            document.getElementById('remitModal').classList.add('active');
            document.getElementById('remitRiderId').value = riderId;
            document.getElementById('remitRiderName').value = riderName;
            document.getElementById('displayRiderName').value = riderName;
            document.getElementById('totalDeliveries').focus();
        }

        function closeRemitModal() {
            document.getElementById('remitModal').classList.remove('active');
            document.getElementById('remitForm').reset();
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
                const formData = new FormData(form);
                const riderId = document.getElementById('remitRiderId').value;
                const riderName = document.getElementById('remitRiderName').value;
                const totalDeliveries = document.getElementById('totalDeliveries').value;
                const totalDeliveryFee = document.getElementById('totalDeliveryFee').value;
                const totalRemit = document.getElementById('totalRemit').value;
                const totalTips = document.getElementById('totalTips').value || 0;
                const totalCollection = document.getElementById('totalCollection').value;
                const modeOfPayment = document.getElementById('modeOfPayment').value;
                const remitPhoto = document.getElementById('remitPhoto').files[0];
                const remarks = document.getElementById('remarks').value;

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
                    remitPhoto: remitPhoto,
                    remarks: remarks
                };

                // Update the details panel
                const riderNameElement = document.getElementById('detailsRiderName');
                if (riderNameElement) {
                    riderNameElement.textContent = riderName;
                }

                // Calculate cash and digital based on mode of payment
                let cashAmount = 0;
                let digitalAmount = 0;
                const collectionAmount = parseFloat(totalCollection);

                if (modeOfPayment === 'cash') {
                    cashAmount = collectionAmount;
                    digitalAmount = 0;
                } else if (modeOfPayment === 'gcash' || modeOfPayment === 'bank_transfer') {
                    cashAmount = 0;
                    digitalAmount = collectionAmount;
                } else if (modeOfPayment === 'mixed') {
                    cashAmount = collectionAmount / 2;
                    digitalAmount = collectionAmount / 2;
                }

                document.getElementById('cashCollectionDisplay').textContent = '₱' + cashAmount.toFixed(2).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('digitalCollectionDisplay').textContent = '₱' + digitalAmount.toFixed(2).replace(
                    /\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('netTurnoverDisplay').textContent = '₱' + parseFloat(totalCollection).toFixed(2)
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Update remarks in details panel
                const remarksSection = document.querySelector('.expenses-section .expenses-content');
                if (remarksSection) {
                    if (remarks && remarks.trim() !== '') {
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
                    showToast('Receipt confirmed! Rider moved to Cleared Riders History. Page will reload.', 'success');

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
            document.getElementById('modeOfPayment').value = pendingRemittance.modeOfPayment;

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
                        const remarksHtml = r.remarks ?
                            `<span class="remarks-text">${r.remarks}</span>` :
                            `<span class="remarks-empty">&mdash;</span>`;
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
                    'Collection', 'Payment Mode', 'Remarks'
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
                totalNet = 0,
                rowNum = 0;

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (!cells.length) return;
                const riderId = cells[0] ? cells[0].innerText.trim() : '';
                const riderName = cells[1] ? cells[1].innerText.trim() : '';
                const base = cells[2] ? cells[2].innerText.trim() : '';
                const incentive = cells[3] ? cells[3].innerText.trim() : '';
                const net = cells[4] ? cells[4].innerText.trim() : '';
                const schedule = cells[5] ? cells[5].innerText.trim() : '';
                const mode = cells[6] ? cells[6].innerText.trim() : '';
                const dateCreated = cells[7] ? cells[7].innerText.trim() : '';

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
                const netNum = parseFloat(net.replace(/[₱,]/g, '')) || 0;
                totalBase += baseNum;
                totalIncentives += incentiveNum;
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
        <div class="report-modal" style="max-width:480px;">
            <div class="report-modal-header" style="background:linear-gradient(135deg,#2d4016 0%,#5a7d35 100%);">
                <h3 id="nrModalTitle"><i class="fas fa-clock"></i> Rider Remittance Status</h3>
                <button class="report-modal-close" onclick="closeNonRemittingModal()"><i
                        class="fas fa-times"></i></button>
            </div>
            <div class="report-modal-body" style="padding-bottom:14px;">
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

        function _nrStatusBadge(status) {
            const s = _nrBadge[status] || _nrBadge.no_duty;
            return `<span style="display:inline-block;padding:3px 10px;border-radius:10px;font-size:10px;font-weight:700;background:${s.bg};color:${s.color};border:1.5px solid ${s.border};">${s.label}</span>`;
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
                        <td style="padding:9px 14px;border-bottom:1px solid #f3f4f6;color:#6b7280;font-size:12px;">${i+1}</td>
                        <td style="padding:9px 14px;border-bottom:1px solid #f3f4f6;font-weight:600;font-size:13px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#2d4016,#5a7d35);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;">${r.rider_name.charAt(0).toUpperCase()}</div>
                                ${r.rider_name}
                            </div>
                        </td>
                        <td style="padding:9px 14px;border-bottom:1px solid #f3f4f6;">${_nrStatusBadge(r.status)}</td>
                    </tr>`
                    ).join('');

                    const cleared = data.riders.filter(r => r.status === 'cleared').length;
                    const pending = data.riders.filter(r => r.status === 'pending').length;
                    const no_duty = data.riders.filter(r => r.status === 'no_duty').length;

                    const summaryParts = [];
                    if (cleared) summaryParts.push(
                        `<span style="color:#155724;font-weight:700;">${cleared} Cleared</span>`);
                    if (pending) summaryParts.push(
                        `<span style="color:#856404;font-weight:700;">${pending} Pending</span>`);
                    if (no_duty) summaryParts.push(
                        `<span style="color:#842029;font-weight:700;">${no_duty} No Remit</span>`);

                    document.getElementById('nrModalBody').innerHTML = data.riders.length === 0 ?
                        `<div style="text-align:center;padding:30px;color:#6b7280;">
                           <i class="fas fa-check-circle" style="font-size:32px;color:#28a745;margin-bottom:10px;"></i>
                           <p style="font-size:13px;font-weight:600;">No riders found for this date.</p>
                       </div>` :
                        `<table style="width:100%;border-collapse:collapse;font-family:'Inter',Arial,sans-serif;">
                           <thead>
                               <tr style="background:#f9fafb;">
                                   <th style="padding:8px 14px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;border-bottom:2px solid #e5e7eb;">#</th>
                                   <th style="padding:8px 14px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;border-bottom:2px solid #e5e7eb;">Rider</th>
                                   <th style="padding:8px 14px;text-align:left;font-size:11px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.4px;border-bottom:2px solid #e5e7eb;">Status</th>
                               </tr>
                           </thead>
                           <tbody>${rows}</tbody>
                       </table>
                       <div style="padding:10px 14px 0;font-size:12px;color:#6b7280;display:flex;gap:14px;flex-wrap:wrap;">${summaryParts.join(' &nbsp;|&nbsp; ')}</div>`;

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
                pending: 'Pending',
                no_duty: 'No Remit'
            };
            const statusStyle = {
                cleared: 'background:#d4edda;color:#155724;',
                pending: 'background:#fff3cd;color:#856404;',
                no_duty: 'background:#f8d7da;color:#842029;',
            };

            const rows = _nrCurrentRiders.map((r, i) =>
                `<tr>
                    <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;">${i+1}</td>
                    <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;font-weight:600;">${r.rider_name}</td>
                    <td style="padding:8px 12px;border-bottom:1px solid #e5e7eb;">
                        <span style="display:inline-block;padding:3px 10px;border-radius:8px;font-size:11px;font-weight:700;${statusStyle[r.status] || statusStyle.no_duty}">${statusLabel[r.status] || 'No Remit'}</span>
                    </td>
                </tr>`
            ).join('');

            const cleared = _nrCurrentRiders.filter(r => r.status === 'cleared').length;
            const pending = _nrCurrentRiders.filter(r => r.status === 'pending').length;
            const no_duty = _nrCurrentRiders.filter(r => r.status === 'no_duty').length;

            const win = window.open('', '_blank', 'width=700,height=650');
            win.document.write(`<!DOCTYPE html><html><head><title>Rider Status – ${dateLabel}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 32px; color: #1f2937; }
                h2 { font-size: 18px; font-weight: 800; margin: 0 0 4px; }
                .sub { font-size: 12px; color: #6b7280; margin-bottom: 8px; }
                .legend { font-size: 12px; margin-bottom: 18px; display: flex; gap: 14px; }
                .legend span { padding: 2px 10px; border-radius: 8px; font-weight: 700; font-size: 11px; }
                table { width: 100%; border-collapse: collapse; }
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
                <span style="background:#fff3cd;color:#856404;">${pending} Pending</span>
                <span style="background:#f8d7da;color:#842029;">${no_duty} No Remit</span>
            </div>
            <table>
                <thead><tr><th>#</th><th>Rider Name</th><th>Status</th></tr></thead>
                <tbody>${rows}</tbody>
            </table>
            <div class="footer">When in Baguio Inc. &mdash; Remittance System</div>
            <br><button onclick="window.print()" style="padding:8px 20px;background:#2d4016;color:#fff;border:none;border-radius:6px;cursor:pointer;font-size:13px;">Print / Save as PDF</button>
            </body></html>`);
            win.document.close();
        }
    </script>

    @include('partials.floating-widgets')
</body>

</html>
