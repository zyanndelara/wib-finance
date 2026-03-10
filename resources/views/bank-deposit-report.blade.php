<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank & Deposit Report — {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}{{ $dateFrom !== $dateTo ? ' – '.\Carbon\Carbon::parse($dateTo)->format('M d, Y') : '' }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            color: #1a1a1a;
            background: #f5f5f5;
        }
        .page-wrap {
            max-width: 960px;
            margin: 0 auto;
            background: #fff;
            padding: 40px 48px;
            min-height: 100vh;
        }

        /* ── Header ── */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px solid #436026;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }
        .report-logo-block { display: flex; align-items: center; gap: 14px; }
        .report-logo-block .logo-circle {
            width: 54px; height: 54px;
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 22px;
        }
        .report-company { font-size: 20px; font-weight: 800; color: #436026; line-height: 1.2; }
        .report-company-sub { font-size: 11px; color: #6b7280; margin-top: 2px; }
        .report-meta { text-align: right; }
        .report-title { font-size: 17px; font-weight: 700; color: #1a1a1a; }
        .report-date-range {
            margin-top: 5px;
            font-size: 12px;
            color: #4b5563;
            display: flex;
            gap: 6px;
            align-items: center;
            justify-content: flex-end;
        }
        .report-date-range i { color: #436026; }
        .report-generated { font-size: 11px; color: #9ca3af; margin-top: 4px; }

        /* ── Table ── */
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title::before {
            content: '';
            width: 4px; height: 16px;
            background: #436026;
            border-radius: 3px;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 30px;
        }
        .report-table thead tr {
            background: linear-gradient(135deg, #436026 0%, #5a7d33 100%);
            color: #fff;
        }
        .report-table th {
            padding: 10px 12px;
            text-align: left;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .report-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .report-table tbody tr:nth-child(even) { background: #fafafa; }
        .report-table tbody tr:hover { background: #f0fdf4; }
        .report-table tfoot tr {
            background: #f9fafb;
            border-top: 2px solid #d1fae5;
            font-weight: 700;
        }
        .report-table tfoot td { padding: 10px 12px; }

        /* Status badges */
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 12px; font-size: 10px; font-weight: 700; }
        .badge-validated   { background: #d1fae5; color: #065f46; }
        .badge-validating  { background: #fef9c3; color: #854d0e; }
        .badge-notval      { background: #fee2e2; color: #991b1b; }

        /* ── Denomination breakdown (detailed) ── */
        .denom-section { margin-top: 30px; }
        .denom-group { margin-bottom: 22px; }
        .denom-group-title {
            font-size: 12px; font-weight: 700; color: #374151;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px solid #e5e7eb;
        }
        .denom-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .denom-table th { padding: 6px 10px; background: #f3f4f6; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; }
        .denom-table td { padding: 6px 10px; border-bottom: 1px solid #f0f0f0; }
        .denom-table tfoot td { font-weight: 700; background: #f0fdf4; color: #065f46; }

        .signature-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
            margin-bottom: 10px;
        }
        .signature-block { text-align: center; }
        .signature-line {
            border-top: 1px solid #374151;
            margin-bottom: 6px;
            padding-top: 6px;
            font-size: 11px;
            font-weight: 600;
            color: #374151;
        }
        .signature-role { font-size: 10px; color: #6b7280; }

        /* ── Disrepancy report highlight ── */
        .disc-positive { color: #d97706; font-weight: 700; }
        .disc-negative { color: #dc2626; font-weight: 700; }
        .disc-zero     { color: #059669; font-weight: 700; }

        /* ── Print styles ── */
        @page { margin: 0; }
        @media print {
            body { background: #fff; }
            .page-wrap { padding: 20px 24px; }
            .no-print { display: none !important; }
            .report-table, .denom-table { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
            thead { display: table-header-group; }
        }
    </style>
</head>
<body>
<div class="page-wrap">

    <!-- ── Report Header ── -->
    <div class="report-header">
        <div class="report-logo-block">
            <div class="logo-circle"><i class="fas fa-university"></i></div>
            <div>
                <div class="report-company">When in Baguio Inc.</div>
                <div class="report-company-sub">Bank & Deposit Management</div>
            </div>
        </div>
        <div class="report-meta">
            <div class="report-title">
                @if($reportType === 'summary')   Daily Remittance Summary Report
                @elseif($reportType === 'detailed') Detailed Denomination Report
                @else Discrepancy Report
                @endif
            </div>
            <div class="report-date-range">
                <i class="fas fa-calendar-alt"></i>
                {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
                @if($dateFrom !== $dateTo)
                    &nbsp;&mdash;&nbsp;{{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                @endif
            </div>
        </div>
    </div>

    <!-- ── Print / Close Buttons ── -->
    <div class="no-print" style="margin-bottom:20px; display:flex; gap:10px;">
        <button onclick="window.print()"
            style="display:inline-flex; align-items:center; gap:8px; padding:9px 20px; background:#436026; color:#fff; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
            <i class="fas fa-print"></i> Print / Save as PDF
        </button>
        <button onclick="window.close()"
            style="display:inline-flex; align-items:center; gap:8px; padding:9px 18px; background:#f3f4f6; color:#374151; border:1.5px solid #d1d5db; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer;">
            <i class="fas fa-times"></i> Close
        </button>
    </div>

    <!-- ── Summary Cards ── -->
    <!-- ── Main Summary Table ── -->
    <div class="section-title">Rider Summary</div>
    <table class="report-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Rider Name</th>
                @if(in_array('transactions', $cols))<th>Transactions</th>@endif
                @if(in_array('remit', $cols))<th>Total Remit</th>@endif
                @if(in_array('confirmed', $cols))<th>Confirmed Amount</th>@endif
                @if(in_array('discrepancy', $cols))<th>Discrepancy</th>@endif
                @if(in_array('status', $cols))<th>Status</th>@endif
                @if(in_array('officer', $cols))<th>Officer</th>@endif
            </tr>
        </thead>
        <tbody>
            @forelse($riderSummaries as $i => $summary)
                @php
                    $riderConfs = $confirmations[$summary->rider_id] ?? collect();
                    $latestConf = $riderConfs->first();
                    $disc       = $latestConf ? (float)$latestConf->discrepancy : null;
                    if ($disc !== null) {
                        if ($disc > 0)      { $discClass = 'disc-positive'; $discText = '+₱'.number_format($disc, 2); }
                        elseif ($disc < 0)  { $discClass = 'disc-negative'; $discText = '-₱'.number_format(abs($disc), 2); }
                        else                { $discClass = 'disc-zero';     $discText = '₱0.00'; }
                    } else {
                        $discClass = ''; $discText = '—';
                    }
                    $statusLabel  = $latestConf ? ($disc === 0.0 ? 'Validated' : 'Validating') : 'Not Validated';
                    $statusClass  = $latestConf ? ($disc === 0.0 ? 'badge-validated' : 'badge-validating') : 'badge-notval';
                @endphp
                <tr>
                    <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                    <td style="font-weight:600;">{{ $summary->rider->name ?? 'N/A' }}</td>
                    @if(in_array('transactions', $cols))<td>{{ $summary->total_transactions }}</td>@endif
                    @if(in_array('remit', $cols))<td style="font-weight:700; color:#059669;">₱{{ number_format($summary->total_remit_amount, 2) }}</td>@endif
                    @if(in_array('confirmed', $cols))<td style="font-weight:700; color:#1e3a8a;">₱{{ number_format($latestConf?->total_amount ?? 0, 2) }}</td>@endif
                    @if(in_array('discrepancy', $cols))<td class="{{ $discClass }}">{{ $discText }}</td>@endif
                    @if(in_array('status', $cols))<td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>@endif
                    @if(in_array('officer', $cols))<td>{{ $generatedBy }}</td>@endif
                </tr>
            @empty
                <tr>
                    <td colspan="10" style="text-align:center; padding:30px; color:#9ca3af;">
                        <i class="fas fa-inbox" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                        No records found for this date range.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="font-weight:700;">Totals</td>
                @if(in_array('transactions', $cols))<td>{{ $riderSummaries->sum('total_transactions') }}</td>@endif
                @if(in_array('remit', $cols))<td style="color:#059669;">₱{{ number_format($totalExpected, 2) }}</td>@endif
                @if(in_array('confirmed', $cols))<td style="color:#1e3a8a;">₱{{ number_format($totalConfirmed, 2) }}</td>@endif
                @if(in_array('discrepancy', $cols))<td style="color:#dc2626;">₱{{ number_format($totalDiscrepancy, 2) }}</td>@endif
                @if(in_array('status', $cols))<td></td>@endif
                @if(in_array('officer', $cols))<td></td>@endif
            </tr>
        </tfoot>
    </table>

    {{-- ── Denomination Breakdown (detailed / discrepancy types) ── --}}
    @if($reportType === 'detailed' || $reportType === 'discrepancy')
    <div class="denom-section">
        <div class="section-title">
            @if($reportType === 'detailed') Denomination Breakdown per Rider
            @else Discrepancy Details per Rider
            @endif
        </div>

        @forelse($riderSummaries as $summary)
            @php
                $riderConfs = $confirmations[$summary->rider_id] ?? collect();
                $latestConf = $riderConfs->first();
                if (!$latestConf) continue;
                $disc2 = (float)$latestConf->discrepancy;
                // For discrepancy report, skip riders with zero discrepancy
                if ($reportType === 'discrepancy' && $disc2 === 0.0) continue;
                $denoms = [
                    ['label' => '₱1,000', 'value' => 1000,  'qty' => $latestConf->denom_1000],
                    ['label' => '₱500',   'value' => 500,   'qty' => $latestConf->denom_500],
                    ['label' => '₱200',   'value' => 200,   'qty' => $latestConf->denom_200],
                    ['label' => '₱100',   'value' => 100,   'qty' => $latestConf->denom_100],
                    ['label' => '₱50',    'value' => 50,    'qty' => $latestConf->denom_50],
                    ['label' => '₱20',    'value' => 20,    'qty' => $latestConf->denom_20],
                    ['label' => '₱20 (b)','value' => 20,    'qty' => $latestConf->denom_20b],
                    ['label' => '₱10',    'value' => 10,    'qty' => $latestConf->denom_10],
                    ['label' => '₱5',     'value' => 5,     'qty' => $latestConf->denom_5],
                    ['label' => '₱1',     'value' => 1,     'qty' => $latestConf->denom_1],
                ];
            @endphp
            <div class="denom-group">
                <div class="denom-group-title" style="display:flex; justify-content:space-between;">
                    <span><i class="fas fa-user" style="margin-right:6px; color:#436026;"></i>{{ $summary->rider->name ?? 'N/A' }}</span>
                    @if($reportType === 'discrepancy')
                        <span class="{{ $disc2 > 0 ? 'disc-positive' : ($disc2 < 0 ? 'disc-negative' : 'disc-zero') }}">
                            Discrepancy: {{ $disc2 > 0 ? '+' : '' }}₱{{ number_format(abs($disc2), 2) }}
                        </span>
                    @else
                        <span style="font-size:11px; color:#6b7280;">Confirmed: ₱{{ number_format($latestConf->total_amount, 2) }}</span>
                    @endif
                </div>
                <table class="denom-table">
                    <thead>
                        <tr>
                            <th>Denomination</th>
                            <th style="text-align:center;">Pieces</th>
                            <th style="text-align:right;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denoms as $denom)
                            @php
                                $qty    = (int)$denom['qty'];
                                $amount = $qty * $denom['value'];
                            @endphp
                            @if($qty > 0)
                            <tr>
                                <td>{{ $denom['label'] }}</td>
                                <td style="text-align:center;">{{ $qty }}</td>
                                <td style="text-align:right;">₱{{ number_format($amount, 2) }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td></td>
                            <td style="text-align:right;">₱{{ number_format($latestConf->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
                @if($reportType === 'detailed')
                <div style="display:flex; gap:14px; margin-top:8px; font-size:11px;">
                    <span style="color:#6b7280;">Bank Amount: <strong>₱{{ number_format($latestConf->bank_amount, 2) }}</strong></span>
                    <span style="color:#6b7280;">Deposit Date: <strong>{{ \Carbon\Carbon::parse($latestConf->deposit_date)->format('M d, Y') }}</strong></span>
                </div>
                @endif
            </div>
        @empty
            <p style="color:#9ca3af; font-size:12px; padding:16px 0;">No denomination records found.</p>
        @endforelse
    </div>
    @endif

    {{-- ── Signature / Approval Section ── --}}
    <div class="signature-row">
        <div class="signature-block">
            <div style="height:40px;"></div>
            <div class="signature-line">{{ $generatedBy }}</div>
            @if($generatedByRole)
                <div class="signature-role" style="font-size:10px; color:#436026; font-weight:600;">{{ ucfirst($generatedByRole) }}</div>
            @endif
            <div class="signature-role">Prepared by</div>
        </div>
        <div class="signature-block">
            <div style="height:40px;"></div>
            <div class="signature-line">Joyce Ann R. Gonzales</div>
            <div class="signature-role" style="font-size:10px; color:#436026; font-weight:600;">Finance Manager</div>
            <div class="signature-role">Verified by</div>
        </div>
        <div class="signature-block">
            <div style="height:40px;"></div>
            <div class="signature-line">Joyce Ann R. Gonzales</div>
            <div class="signature-role" style="font-size:10px; color:#436026; font-weight:600;">Finance Manager</div>
            <div class="signature-role">Approved by</div>
        </div>
    </div>

</div>

<script>
    // Auto-trigger print for PDF mode when no "no-print" interaction needed
    // Users can click the Print button manually
</script>
</body>
</html>
