<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Financial Requests - When in Baguio Inc.</title>
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
            --accent: #f5b700;
            --text: #172118;
            --muted: #5b6a56;
            --card-shadow: 0 10px 24px rgba(19, 40, 23, 0.12);
            --radius-lg: 18px;
            --radius-md: 12px;
        }

        body {
            font-family: 'Manrope', sans-serif;
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
            padding: 28px 30px;
            overflow-y: auto;
            background: transparent;
        }

        .content-header {
            margin-bottom: 22px;
            border-radius: var(--radius-lg);
            border: 1px solid rgba(44, 71, 44, 0.14);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.86) 0%, rgba(248, 252, 240, 0.86) 100%);
            box-shadow: var(--card-shadow);
            padding: 22px 24px;
        }

        .content-header h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--brand-900);
            margin-bottom: 6px;
        }

        .content-header p {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .layout-grid {
            display: grid;
            grid-template-columns: minmax(320px, 380px) 1fr;
            gap: 16px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(44, 71, 44, 0.14);
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow);
            padding: 18px;
        }

        .card h2 {
            font-size: 18px;
            color: var(--brand-900);
            margin-bottom: 14px;
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
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.45);
            z-index: 2000;
            padding: 16px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-card {
            width: min(560px, 100%);
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(184, 64, 64, 0.22);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.2);
            padding: 16px;
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
            margin-top: 12px;
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

        thead th {
            text-align: left;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            border-bottom: 1px solid rgba(63, 99, 60, 0.16);
            padding: 10px 8px;
        }

        tbody td {
            padding: 12px 8px;
            border-bottom: 1px solid rgba(63, 99, 60, 0.1);
            vertical-align: top;
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
        <div class="content-header">
            <h1>Financial Requests</h1>
            <p>
                @if ($authUser->isAdmin())
                    Review and approve requests submitted by members.
                @else
                    Submit a financial request for admin approval.
                @endif
            </p>
        </div>

        <div class="layout-grid">
            <section class="card">
                @if (str_starts_with((string) $authUser->role, 'finance_officer'))
                    <h2><i class="fas fa-hand-holding-dollar"></i> New Request</h2>
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
                @else
                    <h2><i class="fas fa-shield-check"></i> Admin Review</h2>
                    <p style="color:#5b6a56; font-size:13px; line-height:1.5;">
                        Admin can review pending requests and process them as approved or rejected.
                    </p>
                @endif
            </section>

            <section class="card">
                <h2><i class="fas fa-list-check"></i> Request List</h2>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $requestItem)
                            <tr>
                                <td>{{ $requestItem->id }}</td>
                                <td>{{ $requestItem->requester->name ?? 'N/A' }}</td>
                                <td>PHP {{ number_format((float) $requestItem->amount, 2) }}</td>
                                <td>
                                    <strong>{{ $requestItem->purpose }}</strong>
                                    @if ($requestItem->notes)
                                        <div style="color:#5b6a56; font-size:12px; margin-top:4px;">{{ $requestItem->notes }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-pill {{ $requestItem->status }}">{{ $requestItem->status }}</span>
                                    @if ($requestItem->status === 'rejected' && $requestItem->rejection_reason)
                                        <div style="color:#7b2424; font-size:12px; margin-top:6px; line-height:1.35;">
                                            Rejection reason: {{ $requestItem->rejection_reason }}
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $requestItem->created_at?->format('M d, Y h:i A') }}</td>
                                <td>
                                    @if ($requestItem->approver)
                                        {{ $requestItem->approver->name }}
                                        <div style="color:#5b6a56; font-size:12px;">{{ $requestItem->approved_at?->format('M d, Y h:i A') }}</div>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if ($authUser->isAdmin() && $requestItem->status === 'pending')
                                        <div style="display:flex; gap:6px;">
                                            <form method="POST" action="{{ route('financial-requests.approve', $requestItem) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn-approve">Approve</button>
                                            </form>
                                            <button type="button" class="btn-reject" onclick="openRejectModal('{{ route('financial-requests.reject', $requestItem) }}', '{{ $requestItem->id }}')">Reject</button>
                                        </div>
                                    @else
                                        <span style="color:#7a8774;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center; color:#7a8774; padding:24px 10px;">No financial requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="pagination-wrap">
                    {{ $requests->links() }}
                </div>
            </section>
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

        function openRejectModal(actionUrl, requestId) {
            const modal = document.getElementById('rejectReasonModal');
            const form = document.getElementById('rejectReasonForm');
            const field = document.getElementById('rejectReasonField');
            const subtitle = document.getElementById('rejectModalSubtitle');

            form.action = actionUrl;
            field.value = '';
            subtitle.textContent = 'Provide the reason for rejecting request #' + requestId + '.';
            modal.classList.add('open');
            setTimeout(() => field.focus(), 0);
        }

        function closeRejectModal() {
            const modal = document.getElementById('rejectReasonModal');
            modal.classList.remove('open');
        }

        document.getElementById('rejectReasonModal').addEventListener('click', closeRejectModal);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeRejectModal();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
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

