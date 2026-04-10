<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Financial Requests - When in Baguio Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brand-900: #1f3624;
            --brand-700: #3f633c;
            --brand-500: #6f954d;
            --surface-100: #f5f8f1;
            --accent: #f5b700;
            --text: #172118;
            --muted: #5b6a56;
            --card-shadow: 0 10px 24px rgba(19, 40, 23, 0.12);
            --card-shadow-soft: 0 18px 42px rgba(24, 40, 25, 0.08);
            --radius-lg: 18px;
            --radius-md: 12px;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--text);
        }

        @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')

        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 28px 34px;
            overflow-y: auto;
            background: transparent;
        }

        .content-shell {
            max-width: 1360px;
            margin: 0 auto;
        }

        .content-header {
            margin-bottom: 20px;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(44, 71, 44, 0.16);
            background: linear-gradient(120deg, rgba(255, 255, 255, 0.94) 0%, rgba(248, 252, 240, 0.9) 55%, rgba(236, 246, 223, 0.82) 100%);
            box-shadow: var(--card-shadow-soft);
            padding: 24px 26px;
            position: relative;
            overflow: hidden;
        }

        .content-header::after {
            content: '';
            position: absolute;
            right: -65px;
            top: -72px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: radial-gradient(circle at center, rgba(111, 149, 77, 0.24) 0%, rgba(111, 149, 77, 0) 68%);
            pointer-events: none;
        }

        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .header-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid rgba(63, 99, 60, 0.22);
            border-radius: 999px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            color: var(--brand-700);
            letter-spacing: 0.2px;
            background: rgba(255, 255, 255, 0.72);
        }

        .content-header h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--brand-900);
            margin-bottom: 8px;
            letter-spacing: -0.4px;
        }

        .content-header p {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
            max-width: 800px;
        }

        .header-metrics {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .metric-chip {
            display: inline-flex;
            align-items: baseline;
            gap: 8px;
            border-radius: 999px;
            border: 1px solid rgba(52, 88, 50, 0.16);
            background: rgba(255, 255, 255, 0.78);
            padding: 7px 12px;
            color: var(--brand-900);
        }

        .metric-value {
            font-size: 15px;
            font-weight: 800;
        }

        .metric-label {
            font-size: 12px;
            color: var(--muted);
            font-weight: 600;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: minmax(320px, 380px) 1fr;
            gap: 16px;
            align-items: start;
        }

        .layout-grid.single-column {
            grid-template-columns: 1fr;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(44, 71, 44, 0.14);
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow-soft);
            padding: 20px;
            backdrop-filter: blur(3px);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 9px;
            font-size: 18px;
            color: var(--brand-900);
            margin-bottom: 14px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .card-title i {
            font-size: 15px;
            color: var(--brand-700);
        }

        .panel-note {
            color: #4f6251;
            font-size: 13px;
            line-height: 1.55;
            background: rgba(111, 149, 77, 0.08);
            border: 1px solid rgba(63, 99, 60, 0.15);
            border-radius: 10px;
            padding: 10px 11px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        .form-group label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--brand-700);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            border: 1px solid rgba(63, 99, 60, 0.22);
            border-radius: 10px;
            padding: 10px 12px;
            font-size: 14px;
            color: var(--text);
            background: #fff;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .modal-textarea:focus {
            border-color: rgba(63, 99, 60, 0.5);
            box-shadow: 0 0 0 3px rgba(111, 149, 77, 0.16);
        }

        .form-group textarea {
            min-height: 90px;
            resize: vertical;
        }

        .btn-primary {
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-700) 0%, var(--brand-500) 100%);
            color: #fff;
            padding: 10px 14px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 10px 16px rgba(48, 81, 35, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(48, 81, 35, 0.28);
        }

        .btn-approve {
            border: 1px solid rgba(63, 99, 60, 0.25);
            border-radius: 8px;
            background: rgba(63, 99, 60, 0.1);
            color: var(--brand-900);
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .btn-approve:hover {
            background: rgba(63, 99, 60, 0.18);
        }

        .btn-reject {
            border: 1px solid rgba(184, 64, 64, 0.32);
            border-radius: 8px;
            background: rgba(184, 64, 64, 0.1);
            color: #7b2424;
            padding: 7px 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .btn-reject:hover {
            background: rgba(184, 64, 64, 0.18);
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(13, 22, 14, 0.5);
            backdrop-filter: blur(3px);
            z-index: 2000;
            padding: 16px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-card {
            width: min(560px, 100%);
            background: linear-gradient(160deg, #ffffff 0%, #f7faf4 100%);
            border-radius: 16px;
            border: 1px solid rgba(184, 64, 64, 0.22);
            box-shadow: 0 22px 50px rgba(0, 0, 0, 0.26);
            padding: 20px;
            animation: modalIn 0.2s ease-out;
        }

        .confirm-modal-card {
            width: min(500px, 100%);
            border: 1px solid rgba(44, 71, 44, 0.2);
            background: #fff;
        }

        .confirm-head {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 10px;
        }

        .confirm-icon {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
            background: rgba(63, 99, 60, 0.12);
            color: var(--brand-700);
        }

        .confirm-modal-card[data-variant="reject"] .confirm-icon {
            background: rgba(184, 64, 64, 0.12);
            color: #a42f2f;
        }

        .confirm-title {
            color: var(--brand-900);
            margin-bottom: 4px;
        }

        .confirm-message {
            color: var(--text);
            font-size: 14px;
            line-height: 1.45;
            margin-bottom: 0;
        }

        .confirm-note {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7a66;
        }

        .btn-confirm {
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--brand-700) 0%, var(--brand-500) 100%);
            color: #fff;
            padding: 8px 13px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 8px 16px rgba(48, 81, 35, 0.24);
            transition: all 0.2s ease;
        }

        .btn-confirm:hover {
            transform: translateY(-1px);
        }

        .confirm-modal-card[data-variant="reject"] .btn-confirm {
            background: linear-gradient(135deg, #a93434 0%, #c85353 100%);
            box-shadow: 0 8px 16px rgba(152, 46, 46, 0.24);
        }

        .confirm-modal-card[data-variant="reject"] .confirm-title {
            color: #7b2424;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 800;
            color: #7b2424;
            margin-bottom: 8px;
        }

        .modal-subtitle {
            font-size: 13px;
            color: #5b6a56;
            margin-bottom: 10px;
        }

        .modal-textarea {
            width: 100%;
            border: 1px solid rgba(184, 64, 64, 0.34);
            border-radius: 8px;
            padding: 10px;
            font-size: 13px;
            color: #172118;
            min-height: 120px;
            resize: vertical;
            outline: none;
            background: #fff;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }

        .btn-cancel {
            border: 1px solid rgba(45, 71, 44, 0.2);
            border-radius: 8px;
            background: #fff;
            color: #2d472c;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        @keyframes modalIn {
            from {
                transform: translateY(8px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .status-pill.pending {
            background: rgba(245, 183, 0, 0.16);
            color: #8c6200;
        }

        .status-pill.approved {
            background: rgba(57, 140, 86, 0.14);
            color: #1f5f36;
        }

        .status-pill.rejected {
            background: rgba(184, 64, 64, 0.14);
            color: #7b2424;
        }

        .alert {
            border-radius: 10px;
            padding: 11px 14px;
            margin-bottom: 14px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert-success {
            background: rgba(57, 140, 86, 0.12);
            border: 1px solid rgba(57, 140, 86, 0.26);
            color: #1f5f36;
        }

        .alert-error {
            background: rgba(184, 64, 64, 0.12);
            border: 1px solid rgba(184, 64, 64, 0.24);
            color: #7b2424;
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

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .table-shell {
            border: 1px solid rgba(63, 99, 60, 0.14);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        thead th {
            text-align: left;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            border-bottom: 1px solid rgba(63, 99, 60, 0.16);
            padding: 12px 10px;
            background: rgba(248, 251, 245, 0.82);
        }

        tbody td {
            padding: 13px 10px;
            border-bottom: 1px solid rgba(63, 99, 60, 0.1);
            vertical-align: top;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: rgba(243, 248, 239, 0.72);
        }

        .purpose-title {
            font-weight: 700;
            color: var(--brand-900);
        }

        .notes-text {
            color: #5b6a56;
            font-size: 12px;
            margin-top: 4px;
            line-height: 1.45;
        }

        .rejection-text {
            color: #7b2424;
            font-size: 12px;
            margin-top: 6px;
            line-height: 1.35;
        }

        .amount-cell {
            white-space: nowrap;
            font-weight: 700;
            color: var(--brand-900);
        }

        .approver-date {
            color: #5b6a56;
            font-size: 12px;
            margin-top: 2px;
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        .muted-dash {
            color: #7a8774;
        }

        .empty-state {
            text-align: center;
            color: #7a8774;
            padding: 28px 10px;
        }

        .pagination-wrap {
            margin-top: 14px;
        }

        .mobile-only {
            display: none;
        }

        @media (max-width: 960px) {
            .main-content {
                margin-left: 0;
                padding: 90px 14px 14px;
            }

            .content-shell {
                max-width: none;
            }

            .content-header {
                padding: 20px 16px;
            }

            .header-top {
                margin-bottom: 8px;
            }

            .content-header h1 {
                font-size: 25px;
            }

            .layout-grid {
                grid-template-columns: 1fr;
            }

            .mobile-only {
                display: inline;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            .table-shell {
                overflow: auto;
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
        }
    </style>
</head>

<body>
    @include('partials.app-sidebar', ['activePage' => 'financial-requests'])

    <div class="main-content">
        @php
            $requestsOnPage = $requests->count();
            $pendingOnPage = $requests->getCollection()->where('status', 'pending')->count();
            $isFinanceOfficer = str_starts_with((string) $authUser->role, 'finance_officer');
            $showActionColumn = $authUser->isAdmin();
        @endphp

        <div class="content-shell">
            <div class="content-header">
                <div class="header-top">
                    <div class="header-label">
                        <i class="fas fa-wallet"></i>
                        Financial Workflow
                    </div>
                    <div class="header-metrics">
                        <span class="metric-chip">
                            <span class="metric-value">{{ $requestsOnPage }}</span>
                            <span class="metric-label">On this page</span>
                        </span>
                        <span class="metric-chip">
                            <span class="metric-value">{{ $pendingOnPage }}</span>
                            <span class="metric-label">Pending</span>
                        </span>
                    </div>
                </div>

                <h1>Financial Requests</h1>
                <p>
                    @if ($authUser->isAdmin())
                        Review and approve requests submitted by members.
                    @else
                        Submit a financial request for admin approval.
                    @endif
                </p>
            </div>

            <div class="layout-grid {{ $isFinanceOfficer ? '' : 'single-column' }}">
                @if ($isFinanceOfficer)
                <section class="card">
                    <h2 class="card-title"><i class="fas fa-hand-holding-dollar"></i> New Request</h2>
                    <form method="POST" action="{{ route('financial-requests.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" min="0.01" step="0.01" required value="{{ old('amount') }}">
                        </div>
                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <input type="text" name="purpose" id="purpose" maxlength="255" required value="{{ old('purpose') }}">
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes (optional)</label>
                            <textarea name="notes" id="notes" maxlength="1000">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit" class="btn-primary">Submit Request</button>
                    </form>
                </section>
                @endif

                <section class="card">
                    <h2 class="card-title"><i class="fas fa-list-check"></i> Request List</h2>
                    <p class="panel-note" style="margin-bottom: 12px; background: var(--surface-100);">
                        Pending requests can be approved immediately or rejected with a reason for full audit visibility.
                    </p>
                    <div class="table-shell">
                        <table>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Requested By</th>
                                    <th>Amount</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th>Submitted</th>
                                    <th>Processed By</th>
                                    @if ($showActionColumn)
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($requests as $requestItem)
                                    <tr>
                                        <td>{{ $requestItem->id }}</td>
                                        <td>{{ $requestItem->requester->name ?? 'N/A' }}</td>
                                        <td class="amount-cell">PHP {{ number_format((float) $requestItem->amount, 2) }}</td>
                                        <td>
                                            <div class="purpose-title">{{ $requestItem->purpose }}</div>
                                            @if ($requestItem->notes)
                                                <div class="notes-text">{{ $requestItem->notes }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-pill {{ $requestItem->status }}">{{ $requestItem->status }}</span>
                                            @if ($requestItem->status === 'rejected' && $requestItem->rejection_reason)
                                                <div class="rejection-text">
                                                    Rejection reason: {{ $requestItem->rejection_reason }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $requestItem->created_at?->format('M d, Y h:i A') }}</td>
                                        <td>
                                            @if ($requestItem->approver)
                                                {{ $requestItem->approver->name }}
                                                <div class="approver-date">{{ $requestItem->approved_at?->format('M d, Y h:i A') }}</div>
                                            @else
                                                <span class="muted-dash">-</span>
                                            @endif
                                        </td>
                                        @if ($showActionColumn)
                                            <td>
                                                @if ($requestItem->status === 'pending')
                                                    <div class="action-group">
                                                        <form method="POST" action="{{ route('financial-requests.approve', $requestItem) }}" class="approve-request-form" data-request-id="{{ $requestItem->id }}" data-requester-name="{{ $requestItem->requester->name ?? 'N/A' }}">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn-approve">Approve</button>
                                                        </form>
                                                        <button type="button" class="btn-reject" data-requester-name="{{ $requestItem->requester->name ?? 'N/A' }}" onclick="openRejectModal('{{ route('financial-requests.reject', $requestItem) }}', '{{ $requestItem->id }}', this.dataset.requesterName)">Reject</button>
                                                    </div>
                                                @else
                                                    <span class="muted-dash">-</span>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $showActionColumn ? 8 : 7 }}" class="empty-state">No financial requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $requests->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div id="rejectReasonModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="rejectModalTitle">
        <div class="modal-card" onclick="event.stopPropagation()">
            <h3 id="rejectModalTitle" class="modal-title">Reject Financial Request</h3>
            <p id="rejectModalSubtitle" class="modal-subtitle">Provide the reason for rejection.</p>

            <form id="rejectReasonForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <textarea id="rejectReasonField" class="modal-textarea" name="reason" maxlength="1000" placeholder="Type the rejection reason here..." required></textarea>
                <div class="modal-actions">
                    <button type="button" class="btn-cancel" onclick="closeRejectModal()">Cancel</button>
                    <button type="submit" class="btn-reject">Confirm Reject</button>
                </div>
            </form>
        </div>
    </div>

    <div id="actionConfirmModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="actionConfirmTitle">
        <div id="actionConfirmCard" class="modal-card confirm-modal-card" data-variant="approve" onclick="event.stopPropagation()">
            <div class="confirm-head">
                <span class="confirm-icon" id="actionConfirmIcon"><i class="fas fa-check"></i></span>
                <div>
                    <h3 id="actionConfirmTitle" class="modal-title confirm-title">Confirm Action</h3>
                    <p id="actionConfirmMessage" class="modal-subtitle confirm-message">Please confirm this action.</p>
                    <p id="actionConfirmNote" class="confirm-note">This will be recorded in the request history.</p>
                </div>
            </div>

            <div class="modal-actions">
                <button type="button" id="actionConfirmCancel" class="btn-cancel">Cancel</button>
                <button type="button" id="actionConfirmProceed" class="btn-confirm">Confirm</button>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }

        function showToast(message, type = 'success', duration = 3000) {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = 'custom-toast';

            let iconClass = 'fa-check-circle';
            let borderColor = '#28a745';
            let iconColor = '#28a745';

            if (type === 'error') {
                iconClass = 'fa-times-circle';
                borderColor = '#dc3545';
                iconColor = '#dc3545';
            } else if (type === 'warning') {
                iconClass = 'fa-exclamation-triangle';
                borderColor = '#f59e0b';
                iconColor = '#f59e0b';
            } else if (type === 'info') {
                iconClass = 'fa-info-circle';
                borderColor = '#3b82f6';
                iconColor = '#3b82f6';
            }

            toast.style.borderLeftColor = borderColor;

            toast.innerHTML = `
                <i class="fas ${iconClass} toast-icon" style="color: ${iconColor}"></i>
                <span class="toast-message">${message}</span>
                <button class="toast-close" type="button" aria-label="Close">&times;</button>
                <div class="toast-progress" style="background:${borderColor}; animation-duration:${duration}ms;"></div>
            `;

            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                toast.remove();
            });

            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, duration);
        }

        function openRejectModal(actionUrl, requestId, requesterName) {
            const modal = document.getElementById('rejectReasonModal');
            const form = document.getElementById('rejectReasonForm');
            const field = document.getElementById('rejectReasonField');
            const subtitle = document.getElementById('rejectModalSubtitle');
            const safeRequesterName = requesterName || 'this requester';

            form.action = actionUrl;
            form.dataset.requestId = requestId;
            form.dataset.requesterName = safeRequesterName;
            field.value = '';
            subtitle.textContent = 'Provide the reason for rejecting ' + safeRequesterName + '.';
            modal.classList.add('open');
            setTimeout(() => field.focus(), 0);
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectReasonModal');
            modal.classList.remove('open');
        }

        function openActionConfirmModal(options) {
            const modal = document.getElementById('actionConfirmModal');
            const card = document.getElementById('actionConfirmCard');
            const titleNode = document.getElementById('actionConfirmTitle');
            const messageNode = document.getElementById('actionConfirmMessage');
            const noteNode = document.getElementById('actionConfirmNote');
            const confirmButton = document.getElementById('actionConfirmProceed');
            const iconNode = document.getElementById('actionConfirmIcon');

            const variant = options.variant || 'approve';
            card.setAttribute('data-variant', variant);
            titleNode.textContent = options.title || 'Confirm Action';
            messageNode.textContent = options.message || 'Please confirm this action.';
            noteNode.textContent = options.note || 'This will be recorded in the request history.';
            confirmButton.textContent = options.confirmLabel || 'Confirm';
            iconNode.innerHTML = variant === 'reject' ? '<i class="fas fa-triangle-exclamation"></i>' : '<i class="fas fa-check"></i>';

            window.pendingActionConfirm = options.onConfirm;
            modal.classList.add('open');
        }

        function closeActionConfirmModal() {
            const modal = document.getElementById('actionConfirmModal');
            modal.classList.remove('open');
            window.pendingActionConfirm = null;
        }

        function proceedActionConfirm() {
            const action = window.pendingActionConfirm;
            closeActionConfirmModal();
            if (typeof action === 'function') {
                action();
            }
        }

        document.getElementById('rejectReasonModal').addEventListener('click', closeRejectModal);
        document.getElementById('actionConfirmModal').addEventListener('click', closeActionConfirmModal);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRejectModal();
                closeActionConfirmModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('actionConfirmCancel').addEventListener('click', closeActionConfirmModal);
            document.getElementById('actionConfirmProceed').addEventListener('click', proceedActionConfirm);

            const approveForms = document.querySelectorAll('.approve-request-form');
            approveForms.forEach((form) => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    const requesterName = this.dataset.requesterName || 'this requester';
                    const currentForm = this;
                    openActionConfirmModal({
                        variant: 'approve',
                        title: 'Approve Request',
                        message: 'Approve financial request from ' + requesterName + '?',
                        note: requesterName + ' will see this as approved.',
                        confirmLabel: 'Yes, Approve',
                        onConfirm: function() {
                            currentForm.submit();
                        }
                    });
                });
            });

            const rejectForm = document.getElementById('rejectReasonForm');
            rejectForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const requesterName = this.dataset.requesterName || 'this requester';
                const currentForm = this;
                openActionConfirmModal({
                    variant: 'reject',
                    title: 'Reject Request',
                    message: 'Reject financial request from ' + requesterName + '?',
                    note: 'This cannot be undone and the reason will be shown to ' + requesterName + '.',
                    confirmLabel: 'Yes, Reject',
                    onConfirm: function() {
                        currentForm.submit();
                    }
                });
            });

            @if (session('success'))
                showToast(@json(session('success')), 'success', 3200);
            @endif

            @if (session('error'))
                showToast(@json(session('error')), 'error', 3600);
            @endif

            @if ($errors->any())
                showToast(@json($errors->first()), 'error', 3600);
            @endif
        });
    </script>
</body>

</html>

