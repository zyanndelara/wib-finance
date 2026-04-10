<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Archived Merchants - When in Baguio Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Manrope', 'Segoe UI', sans-serif;
            display: flex;
            min-height: 100vh;
            background: radial-gradient(circle at 25% -20%, #eef9f1 0%, #e8edf4 42%, #e4e8ef 100%);
            color: #0f172a;
        }

        @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')
        @include('partials.user-indicator-styles')

        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 40px;
            overflow-y: auto;
            background: linear-gradient(180deg, rgba(248, 252, 250, .92) 0%, rgba(241, 245, 249, .96) 100%);
            position: relative;
        }

        .main-content::before {
            content: '';
            position: absolute;
            inset: 0 0 auto 0;
            height: 180px;
            background: linear-gradient(180deg, rgba(47, 111, 63, .08) 0%, rgba(47, 111, 63, 0) 100%);
            pointer-events: none;
        }

        .content-header {
            margin-bottom: 22px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .content-header h1 {
            font-size: 34px;
            font-weight: 800;
            color: #111827;
            letter-spacing: -.4px;
            margin: 0;
        }

        .subline {
            margin-top: 4px;
            color: #64748b;
            font-size: 13px;
        }

        .stats-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        .stat-card {
            border-radius: 14px;
            padding: 18px 18px;
            color: #fff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .2);
            border: 1px solid rgba(255, 255, 255, .18);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            width: 92px;
            height: 92px;
            right: -20px;
            top: -26px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .12);
        }

        .stat-card .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
            opacity: .9;
            font-weight: 700;
        }

        .stat-card .value {
            margin-top: 6px;
            font-size: 28px;
            font-weight: 800;
            position: relative;
            z-index: 1;
        }

        .stat-card.slate {
            background: linear-gradient(135deg, #334155, #475569);
        }

        .stat-card.blue {
            background: linear-gradient(135deg, #1e40af, #2563eb);
        }

        .stat-card.amber {
            background: linear-gradient(135deg, #92400e, #b45309);
        }

        .panel {
            background: #fff;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, .75);
            box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
            overflow: hidden;
            position: relative;
            z-index: 1;
        }

        .panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .panel-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .panel-title-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, #334155, #475569);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .2);
        }

        .panel-head h3 {
            font-size: 15px;
            font-weight: 800;
            color: #111827;
            margin: 0;
        }

        .panel-note {
            margin-top: 2px;
            font-size: 11px;
            color: #64748b;
        }

        .head-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            border: 1px solid #d1d5db;
            background: #fff;
            color: #1f2937;
            padding: 8px 12px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn:hover {
            border-color: #9ca3af;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .btn-primary {
            border: none;
            background: linear-gradient(135deg, #2f6f3f, #245732);
            color: #fff;
            box-shadow: 0 8px 18px rgba(36, 87, 50, .28);
        }

        .table-wrap {
            overflow-x: auto;
            padding-bottom: 2px;
        }

        table {
            width: 100%;
            min-width: 860px;
            border-collapse: collapse;
        }

        thead tr {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            padding: 12px 14px;
            text-align: left;
            font-size: 11px;
            color: #64748b;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .7px;
        }

        td {
            padding: 13px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            color: #334155;
            vertical-align: middle;
        }

        tbody tr {
            transition: background .15s ease;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        .merchant-name {
            font-weight: 700;
            color: #111827;
        }

        .address-col {
            max-width: 340px;
            color: #475569;
        }

        .restore-col {
            text-align: center;
            width: 90px;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge.partner {
            background: #dcfce7;
            color: #166534;
        }

        .badge.nonpartner {
            background: #fef9c3;
            color: #854d0e;
        }

        .badge.archived {
            background: #e2e8f0;
            color: #334155;
        }

        .action-btn {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: #dcfce7;
            box-shadow: 0 6px 14px rgba(22, 101, 52, .2);
            transform: translateY(-1px);
        }

        .empty {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            padding: 46px 16px;
        }

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
            min-width: 280px;
            max-width: 420px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .16);
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-left: 4px solid #28a745;
        }

        .toast-icon {
            font-size: 20px;
            flex-shrink: 0;
        }

        .toast-message {
            flex: 1;
            color: #333;
            font-size: 14px;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 18px;
            color: #999;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 80px 16px 18px;
            }

            .content-header h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>
    @include('partials.app-sidebar', ['activePage' => 'merchants-archived'])

    <div class="main-content">
        <div class="content-header">
            <div>
                <h1>Archived Merchants</h1>
                <div class="subline">Inactive merchant records and quick restore actions.</div>
            </div>
            @include('partials.user-indicator')
        </div>

        <div class="stats-strip">
            <div class="stat-card slate">
                <div class="label">Total Archived</div>
                <div class="value" id="stat_total_archived">{{ number_format($totalArchived) }}</div>
            </div>
            <div class="stat-card blue">
                <div class="label">Partner Archived</div>
                <div class="value" id="stat_partner_archived">{{ number_format($archivedPartners) }}</div>
            </div>
            <div class="stat-card amber">
                <div class="label">Non-Partner Archived</div>
                <div class="value" id="stat_nonpartner_archived">{{ number_format($archivedNonPartners) }}</div>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <div class="panel-title">
                    <span class="panel-title-icon"><i class="fas fa-box-archive"></i></span>
                    <div>
                        <h3>Archived Merchant Directory</h3>
                        <div class="panel-note">Review inactive merchants and restore them when needed.</div>
                    </div>
                </div>
                <div class="head-actions">
                    <a href="{{ route('merchants') }}" class="btn">
                        <i class="fas fa-arrow-left"></i> Active Merchants
                    </a>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Merchant</th>
                            <th>Partner Type</th>
                            <th>Status</th>
                            <th>Address</th>
                            <th style="text-align:center;">Restore</th>
                        </tr>
                    </thead>
                    <tbody id="archivedMerchantTbody">
                        @forelse ($archivedMerchants as $merchant)
                            @php
                                $normalizedType = strtolower(str_replace(['_', ' '], '-', trim((string) $merchant->type)));
                                if ($normalizedType === 'nonpartner') {
                                    $normalizedType = 'non-partner';
                                }
                                $isPartnerType = $normalizedType === 'partner';
                                $typeLabel =
                                    $isPartnerType
                                        ? 'Partner'
                                        : ($normalizedType === 'non-partner'
                                            ? 'Non-Partner'
                                            : ucwords(str_replace('-', ' ', $normalizedType)));
                            @endphp
                            <tr id="archived-merchant-row-{{ $merchant->id }}">
                                <td class="merchant-name">{{ $merchant->name }}</td>
                                <td>
                                    <span class="badge {{ $isPartnerType ? 'partner' : 'nonpartner' }}">{{ $typeLabel }}</span>
                                </td>
                                <td>
                                    <span class="badge archived">Inactive</span>
                                </td>
                                <td class="address-col">
                                    {{ $merchant->address ? \Illuminate\Support\Str::limit($merchant->address, 60) : 'No address' }}
                                </td>
                                <td class="restore-col">
                                    <button type="button" class="action-btn" title="Restore merchant"
                                        onclick="restoreMerchant({{ $merchant->id }}, '{{ addslashes($merchant->name) }}')">
                                        <i class="fas fa-rotate-left"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow">
                                <td colspan="5" class="empty">
                                    <i class="fas fa-box-open" style="font-size: 26px; margin-bottom: 8px; display: block;"></i>
                                    No archived merchants found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }

        function updateArchivedStats() {
            const rows = Array.from(document.querySelectorAll('#archivedMerchantTbody tr[id^="archived-merchant-row-"]'));
            const total = rows.length;

            let partner = 0;
            rows.forEach((row) => {
                const typeBadge = row.querySelector('td:nth-child(2) .badge');
                if (typeBadge && typeBadge.textContent.trim().toLowerCase() === 'partner') {
                    partner += 1;
                }
            });

            const nonPartner = Math.max(total - partner, 0);

            const totalEl = document.getElementById('stat_total_archived');
            const partnerEl = document.getElementById('stat_partner_archived');
            const nonPartnerEl = document.getElementById('stat_nonpartner_archived');

            if (totalEl) totalEl.textContent = total.toLocaleString();
            if (partnerEl) partnerEl.textContent = partner.toLocaleString();
            if (nonPartnerEl) nonPartnerEl.textContent = nonPartner.toLocaleString();
        }

        function ensureEmptyState() {
            const tbody = document.getElementById('archivedMerchantTbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr[id^="archived-merchant-row-"]');
            const existingEmpty = document.getElementById('emptyRow');
            if (rows.length === 0 && !existingEmpty) {
                const tr = document.createElement('tr');
                tr.id = 'emptyRow';
                tr.innerHTML = '<td colspan="5" class="empty"><i class="fas fa-box-open" style="font-size: 26px; margin-bottom: 8px; display: block;"></i>No archived merchants found.</td>';
                tbody.appendChild(tr);
            }
        }

        async function restoreMerchant(id, merchantName) {
            const confirmed = confirm(`Restore ${merchantName}?`);
            if (!confirmed) return;

            try {
                const resp = await fetch(`/merchants/${id}/restore`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: new URLSearchParams({
                        _method: 'PATCH'
                    }),
                });

                const data = await resp.json();
                if (data.success) {
                    const tr = document.getElementById('archived-merchant-row-' + id);
                    if (tr) tr.remove();
                    const existingEmpty = document.getElementById('emptyRow');
                    if (existingEmpty) existingEmpty.remove();
                    ensureEmptyState();
                    updateArchivedStats();
                    showToast(data.message || 'Merchant restored successfully.', 'success');
                } else {
                    showToast(data.message || 'Failed to restore merchant.', 'error');
                }
            } catch {
                showToast('Network error. Please try again.', 'error');
            }
        }

        function showToast(message, type = 'success') {
            let container = document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toastContainer';
                document.body.appendChild(container);
            }

            const colors = {
                success: '#28a745',
                error: '#dc3545',
                warning: '#f59e0b',
                info: '#0ea5e9'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };

            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            toast.style.borderLeftColor = colors[type] || colors.success;
            toast.innerHTML = `
                <i class="fas ${icons[type] || icons.success} toast-icon" style="color:${colors[type] || colors.success}"></i>
                <div class="toast-message">${message}</div>
                <button class="toast-close" onclick="this.closest('.custom-toast').remove()">&times;</button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3500);
        }

        @if (session('success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('success') }}', 'success');
            });
        @endif
    </script>
</body>

</html>
