<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Remittance - Wibsystem</title>
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
            padding: 25px;
            overflow-y: auto;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .content-header {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content-header h1 {
            font-size: 26px;
            font-weight: bold;
            color: #1a1a1a;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
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
            margin-top: 15px;
        }

        .rider-queue-panel {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(67, 96, 38, 0.1);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease;
        }

        .rider-queue-panel:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
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
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 1px 4px rgba(67, 96, 38, 0.3);
        }

        .rider-action-btn:hover {
            background: linear-gradient(135deg, #5a7d33 0%, #6d9640 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(67, 96, 38, 0.4);
        }

        .rider-action-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(67, 96, 38, 0.3);
        }

        .rider-action-btn i {
            font-size: 8px;
        }

        .rider-action-btn.records-btn {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            box-shadow: 0 2px 6px rgba(108, 117, 125, 0.3);
        }

        .rider-action-btn.records-btn:hover {
            background: linear-gradient(135deg, #5a6268 0%, #495057 100%);
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.4);
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
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(67, 96, 38, 0.1);
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease 0.2s both;
        }

        .remittance-details-panel:hover {
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
        }

        .details-header {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 20px;
            padding: 12px 15px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border-left: 3px solid #436026;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
        }

        .collection-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .collection-item {
            text-align: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .collection-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(67, 96, 38, 0.15);
            border-color: #436026;
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
            text-align: center;
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
            background: linear-gradient(135deg, #f5f9f2 0%, #ebf3e7 100%);
            padding: 15px 20px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border: 2px solid #436026;
            box-shadow: 0 6px 20px rgba(67, 96, 38, 0.2);
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
            margin-top: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(67, 96, 38, 0.1);
            animation: fadeInUp 0.6s ease 0.4s both;
        }

        .cleared-riders-header {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .cleared-riders-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 8px;
        }

        .cleared-riders-table thead {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: white;
        }

        .cleared-riders-table thead th {
            padding: 12px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cleared-riders-table tbody tr {
            background: white;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .cleared-riders-table tbody tr:hover {
            background: #f8f9fa;
            transform: translateX(3px);
        }

        .cleared-riders-table tbody td {
            padding: 12px 15px;
            font-size: 14px;
            color: #333;
        }

        .cleared-riders-table tbody tr:last-child {
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
                width: 240px;
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
        </div>

        <div class="sidebar-menu">
            <a href="{{ route('dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('remittance') }}" class="menu-item active">
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
            <h1>Remittance Management</h1>
            <div class="user-indicator">
                <div class="user-info">
                    <span class="user-name">{{ auth()->user()->name }}</span>
                    <span class="user-role">{{ auth()->user()->role }}</span>
                </div>
                <a href="{{ route('profile') }}" class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </a>
            </div>
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
                    @php
                        $pendingRiders = $riders->where('status', 'pending');
                    @endphp
                    @forelse($pendingRiders as $index => $rider)
                        <div class="rider-row" data-rider-id="{{ $rider->id }}">
                            <div class="rider-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="rider-item-info">
                                    <strong>{{ $rider->name }}</strong>
                                </div>
                                <div class="rider-item-actions">
                                    <button class="rider-action-btn records-btn">
                                        <i class="fas fa-history"></i>
                                        <span>Records</span>
                                    </button>
                                    <button class="rider-action-btn" onclick="openRemitModal({{ $rider->id }}, '{{ $rider->name }}')">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Remit</span>
                                    </button>
                                </div>
                            </div>
                            <span class="rider-status {{ $rider->status }}">{{ ucfirst($rider->status) }}</span>
                        </div>
                    @empty
                        <div class="empty-state" style="text-align: center; padding: 40px; color: #6c757d;">
                            <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <p style="font-size: 14px; margin: 0;">No pending riders. Click "Add Rider" to get started.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Remittance Details Panel -->
            <div class="remittance-details-panel">
                <div class="details-header">
                    Remittance Details: <span id="detailsRiderName" style="color: #436026; font-weight: 700;"></span>
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
                    <div class="section-title">Expenses & Payroll (Deductions)</div>
                    <div class="expenses-content">
                        <p style="position: relative; z-index: 1; font-weight: 500;">No expenses or deductions recorded</p>
                    </div>
                </div>

                <div class="collection-divider"></div>

                <div class="net-turnover">
                    <div class="net-turnover-label">NET TO TURN OVER:</div>
                    <div class="net-turnover-amount" id="netTurnoverDisplay">₱0.00</div>
                </div>

                <div class="action-buttons">
                    <button class="action-btn" id="viewPhotoBtn" onclick="viewRemitPhoto()" style="display: none;">
                        <i class="fas fa-image"></i>
                        <span>View Remit Photo</span>
                    </button>
                    <button class="action-btn" id="editRemitBtn" onclick="editRemittance()" disabled style="opacity: 0.5; cursor: not-allowed; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </button>
                    <button class="action-btn" id="confirmReceiptBtn" onclick="confirmReceipt()" disabled style="opacity: 0.5; cursor: not-allowed;">
                        <i class="fas fa-check"></i>
                        <span>Confirm Receipt</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Cleared Riders Table -->
        <div class="cleared-riders-section">
            <div class="cleared-riders-header" style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 15px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 3px; height: 20px; background: linear-gradient(180deg, #436026 0%, #5a7d33 100%); border-radius: 2px;"></div>
                    <span>Cleared Riders History</span>
                </div>
                @php
                    $clearedRiders = $riders->where('status', 'cleared');
                @endphp
                @if($clearedRiders->count() > 0)
                    <div class="search-bar" style="margin-bottom: 0; max-width: 300px;">
                        <i class="fas fa-search"></i>
                        <input type="text" id="clearedRiderSearch" placeholder="Search cleared riders..." oninput="searchClearedRiders()">
                    </div>
                @endif
            </div>
            @if($clearedRiders->count() > 0)
                <table class="cleared-riders-table">
                    <thead>
                        <tr>
                            <th>Rider Name</th>
                            <th>Status</th>
                            <th>Date Cleared</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clearedRiders as $rider)
                            <tr>
                                <td><strong>{{ $rider->name }}</strong></td>
                                <td>
                                    <span class="rider-status cleared">{{ ucfirst($rider->status) }}</span>
                                </td>
                                <td>{{ $rider->updated_at->format('M d, Y h:i A') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="table-empty-state">
                    <i class="fas fa-clipboard-check"></i>
                    <p>No cleared riders yet.</p>
                </div>
            @endif
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
                        <input type="text" id="riderName" name="riderName" placeholder="Enter rider name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="modal-btn submit" onclick="submitAddRider()"><i class="fas fa-check"></i> Add Rider</button>
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
                        <input type="text" id="displayRiderName" readonly style="background: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalDeliveries"><i class="fas fa-box"></i> Total Deliveries</label>
                            <input type="number" id="totalDeliveries" name="total_deliveries" placeholder="0" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="totalDeliveryFee"><i class="fas fa-dollar-sign"></i> Total Delivery Fee</label>
                            <input type="number" id="totalDeliveryFee" name="total_delivery_fee" placeholder="0.00" step="0.01" min="0" required oninput="calculateTotalRemit()">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalRemit"><i class="fas fa-money-check"></i> Total Remit</label>
                            <input type="number" id="totalRemit" name="total_remit" placeholder="0.00" step="0.01" min="0" required>
                        </div>
                        <div class="form-group">
                            <label for="totalTips"><i class="fas fa-hand-holding-usd"></i> Total Tips</label>
                            <input type="number" id="totalTips" name="total_tips" placeholder="0.00" step="0.01" min="0" value="0">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="totalCollection"><i class="fas fa-wallet"></i> Total Collection</label>
                            <input type="number" id="totalCollection" name="total_collection" placeholder="0.00" step="0.01" min="0" required>
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
                <button class="modal-btn submit" onclick="submitRemit()"><i class="fas fa-paper-plane"></i> Submit</button>
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
                <button class="modal-btn submit" onclick="closeMessageModal()" style="width: 100%;"><i class="fas fa-check"></i> OK</button>
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
            }
        });

        // Search Riders Function
        function searchRiders() {
            const searchValue = document.getElementById('riderSearch').value.toLowerCase();
            const riderRows = document.querySelectorAll('.rider-row');
            
            riderRows.forEach(row => {
                const riderName = row.querySelector('.rider-item-info strong').textContent.toLowerCase();
                
                if (riderName.includes(searchValue)) {
                    row.style.display = 'flex';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search Cleared Riders Function
        function searchClearedRiders() {
            const searchValue = document.getElementById('clearedRiderSearch').value.toLowerCase();
            const tableRows = document.querySelectorAll('.cleared-riders-table tbody tr');
            
            tableRows.forEach(row => {
                const riderName = row.querySelector('td:first-child strong').textContent.toLowerCase();
                const dateCleared = row.querySelector('td:last-child').textContent.toLowerCase();
                
                if (riderName.includes(searchValue) || dateCleared.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
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
                            <div class="rider-item">
                                <div class="rider-item-info">
                                    <strong>${rider.name}</strong>
                                </div>
                                <div class="rider-item-actions">
                                    <button class="rider-action-btn records-btn">
                                        <i class="fas fa-history"></i>
                                        <span>Records</span>
                                    </button>
                                    <button class="rider-action-btn" onclick="openRemitModal(${rider.id}, '${rider.name}')">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Remit</span>
                                    </button>
                                </div>
                            </div>
                            <span class="rider-status ${statusClass}">${statusText}</span>
                        `;
                        
                        riderList.appendChild(newRiderRow);
                        
                        // Close modal and reset form
                        closeAddRiderModal();
                        
                        // Show success message
                        showMessageModal(data.message, 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessageModal('Failed to add rider. Please try again.', 'error');
                });
                });
            } else {
                form.reportValidity();
            }
        }

        // Remit Modal Functions
        function openRemitModal(riderId, riderName) {
            // Remove active class from all rider items
            document.querySelectorAll('.rider-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Add active class to selected rider
            const selectedRow = document.querySelector(`[data-rider-id="${riderId}"]`);
            if (selectedRow) {
                const riderItem = selectedRow.querySelector('.rider-item');
                if (riderItem) {
                    riderItem.classList.add('active');
                }
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
        function calculateTotalRemit() {
            const totalDeliveryFee = parseFloat(document.getElementById('totalDeliveryFee').value) || 0;
            const totalRemit = totalDeliveryFee - (totalDeliveryFee * 0.05);
            document.getElementById('totalRemit').value = totalRemit.toFixed(2);
        }

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
                    remitPhoto: remitPhoto
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
                    // For mixed, split 50/50 or use actual amounts if you want
                    cashAmount = collectionAmount / 2;
                    digitalAmount = collectionAmount / 2;
                }
                
                document.getElementById('cashCollectionDisplay').textContent = '₱' + cashAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('digitalCollectionDisplay').textContent = '₱' + digitalAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                document.getElementById('netTurnoverDisplay').textContent = '₱' + parseFloat(totalRemit).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                
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
                showMessageModal('Remittance form submitted!\n\nPlease review the details and click "Confirm Receipt" to save.', 'success');
            } else {
                form.reportValidity();
            }
        }

        function confirmReceipt() {
            if (!pendingRemittance) {
                showMessageModal('No pending remittance to confirm.', 'warning');
                return;
            }
            
            const confirmBtn = document.getElementById('confirmReceiptBtn');
            const originalText = confirmBtn.innerHTML;
            confirmBtn.disabled = true;
            confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Confirming...';
            
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
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
                    return response.json().then(data => ({ response, data }));
                } else {
                    return response.text().then(text => {
                        throw new Error(`Server returned non-JSON response: ${response.status} ${response.statusText}`);
                    });
                }
            })
            .then(({ response, data }) => {
                if (!response.ok) {
                    // Handle validation errors (422)
                    if (response.status === 422 && data.errors) {
                        const errorMessages = Object.entries(data.errors)
                            .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                            .join('\n');
                        throw new Error(`Validation failed:\n${errorMessages}`);
                    }
                    throw new Error(data.message || `Failed to save remittance: ${response.status} ${response.statusText}`);
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
                    return response.json().then(data => ({ response, data }));
                } else {
                    return response.text().then(text => {
                        throw new Error(`Server returned non-JSON response: ${response.status} ${response.statusText}`);
                    });
                }
            })
            .then(({ response, data }) => {
                if (!response.ok) {
                    // Handle validation errors (422)
                    if (response.status === 422 && data.errors) {
                        const errorMessages = Object.entries(data.errors)
                            .map(([field, messages]) => `${field}: ${messages.join(', ')}`)
                            .join('\n');
                        throw new Error(`Validation failed:\n${errorMessages}`);
                    }
                    throw new Error(data.message || `Failed to update rider status: ${response.status} ${response.statusText}`);
                }
                if (!data.success) {
                    throw new Error(data.message || 'Failed to update rider status');
                }
                
                console.log('Rider status updated successfully:', data);
                
                // Remove the rider from the Rider Queue (pending section)
                const riderRow = document.querySelector(`[data-rider-id="${pendingRemittance.riderId}"]`);
                console.log('Found rider row:', riderRow);
                
                if (riderRow) {
                    // Remove the rider row with fade out animation
                    riderRow.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    riderRow.style.opacity = '0';
                    riderRow.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        riderRow.remove();
                        
                        // Check if rider list is empty, show empty state
                        const riderList = document.querySelector('.rider-list');
                        const remainingRiders = riderList.querySelectorAll('.rider-row');
                        
                        if (remainingRiders.length === 0) {
                            const emptyState = document.createElement('div');
                            emptyState.className = 'empty-state';
                            emptyState.style.cssText = 'text-align: center; padding: 40px; color: #6c757d;';
                            emptyState.innerHTML = `
                                <i class="fas fa-users" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                                <p style="font-size: 14px; margin: 0;">No pending riders. Click "Add Rider" to get started.</p>
                            `;
                            riderList.appendChild(emptyState);
                        }
                    }, 300);
                }
                
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
                showMessageModal('Receipt confirmed! Rider cleared and moved to history. Page will reload to show updated data.', 'success');
                
                // Reload page after 2 seconds to update the cleared riders table
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Error in confirmReceipt:', error);
                showMessageModal('Failed to confirm receipt: ' + error.message, 'error');
                confirmBtn.disabled = false;
                confirmBtn.style.opacity = '1';
                confirmBtn.style.cursor = 'pointer';
                confirmBtn.innerHTML = originalText;
            });
        }

        function editRemittance() {
            if (!pendingRemittance) {
                showMessageModal('No pending remittance to edit.', 'warning');
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
                showMessageModal('No photo attached.', 'warning');
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
    </script>
</body>
</html>
