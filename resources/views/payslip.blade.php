<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rider Payslip - {{ $payroll->rider_name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #222;
            background: #fff;
        }

        .print-btn-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #436026;
            color: #fff;
            padding: 8px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .print-btn-bar span {
            font-size: 13px;
            font-weight: 600;
        }

        .print-btn-bar button {
            background: #ffd300;
            color: #2d4016;
            border: none;
            padding: 6px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .slip-wrapper {
            max-width: 820px;
            margin: 52px auto 30px auto;
            border: 1px solid #bbb;
            background: #fff;
        }

        /* ───── HEADER ───── */
        .slip-header {
            background: #2d5f0e;
            color: #fff;
            padding: 10px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .slip-header .company-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .slip-header .company-left img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            object-fit: contain;
            background: #fff;
        }

        .slip-header .company-info {
            line-height: 1.55;
        }

        .slip-header .company-name {
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.3px;
        }

        .slip-header .company-address {
            font-size: 10px;
            color: rgba(255,255,255,0.85);
        }

        .slip-header .company-contact {
            font-size: 10px;
            color: rgba(255,255,255,0.85);
        }

        .slip-header .company-right {
            text-align: right;
            font-size: 10.5px;
            line-height: 1.7;
            color: rgba(255,255,255,0.9);
        }

        .slip-header .company-right strong {
            color: #fff;
        }

        /* ───── TITLE BAR ───── */
        .slip-title-bar {
            background: #c8e04a;
            padding: 8px 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 2px solid #7aa325;
            border-bottom: 2px solid #7aa325;
        }

        .slip-title-bar .doc-title {
            font-size: 17px;
            font-weight: 800;
            color: #2d4016;
            letter-spacing: 0.2px;
        }

        .slip-title-bar .period-block {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .slip-title-bar .period-field {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #2d4016;
        }

        .slip-title-bar .period-value {
            border-bottom: 1.5px solid #2d4016;
            min-width: 80px;
            padding-bottom: 1px;
            font-weight: 600;
        }

        /* ───── RIDER INFO ───── */
        .slip-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            border-bottom: 1px solid #ccc;
        }

        .slip-info-left {
            padding: 10px 16px;
            border-right: 1px solid #ddd;
        }

        .slip-info-right {
            padding: 10px 16px;
        }

        .info-row {
            display: flex;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 11px;
        }

        .info-label {
            font-weight: 700;
            color: #444;
            white-space: nowrap;
        }

        .info-value {
            color: #222;
            border-bottom: 1px solid #bbb;
            flex: 1;
            min-width: 120px;
        }

        /* ───── TRANSACTION TABLE ───── */
        .slip-table-section {
            padding: 0 0 0 0;
        }

        .slip-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .slip-table thead tr {
            background: #436026;
            color: #fff;
        }

        .slip-table thead th {
            padding: 7px 10px;
            text-align: center;
            font-weight: 700;
            font-size: 10.5px;
            border: 1px solid #5a7d33;
            letter-spacing: 0.2px;
        }

        .slip-table thead th:first-child {
            text-align: left;
        }

        .slip-table tbody tr {
            border-bottom: 1px solid #e9e9e9;
        }

        .slip-table tbody tr:nth-child(even) {
            background: #f8f8f8;
        }

        .slip-table tbody td {
            padding: 6px 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .slip-table tbody td:first-child {
            text-align: left;
        }

        .slip-table tbody td:last-child {
            text-align: left;
        }

        .slip-table tfoot td {
            padding: 6px 10px;
            border: 1px solid #ddd;
        }

        /* ───── SUMMARY SECTION ───── */
        .slip-summary {
            display: flex;
            gap: 0;
            border-top: 1px solid #ccc;
        }

        .slip-summary-left {
            flex: 1;
            padding: 12px 16px;
            border-right: 1px solid #ddd;
        }

        .slip-summary-right {
            flex: 0 0 260px;
            padding: 10px 16px;
        }

        .slip-summary-left .notes-label {
            font-weight: 700;
            font-size: 11px;
            color: #444;
            margin-bottom: 8px;
        }

        .slip-summary-left .stat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 11px;
            line-height: 1.5;
        }

        .slip-summary-left .stat-label {
            color: #555;
        }

        .slip-summary-left .stat-value {
            font-weight: 600;
            color: #222;
            text-align: right;
            min-width: 80px;
        }

        .slip-summary-right .sum-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            font-size: 11px;
            line-height: 1.6;
            border-bottom: 1px dotted #ddd;
            padding-bottom: 2px;
        }

        .slip-summary-right .sum-row:last-child {
            border-bottom: none;
        }

        .slip-summary-right .sum-label {
            color: #555;
        }

        .slip-summary-right .sum-value {
            font-weight: 600;
            color: #222;
            text-align: right;
        }

        /* ───── NET PAY ───── */
        .net-pay-bar {
            background: #f0f8e8;
            border-top: 2px solid #436026;
            border-bottom: 2px solid #436026;
            text-align: right;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 800;
            color: #2d4016;
            letter-spacing: 0.5px;
        }

        /* ───── PAYMENT MODE ───── */
        .slip-payment {
            padding: 10px 16px;
            border-bottom: 1px solid #ddd;
        }

        .payment-title {
            font-weight: 700;
            font-size: 11px;
            color: #436026;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .payment-options {
            display: flex;
            gap: 24px;
            font-size: 11.5px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .checkbox {
            width: 13px;
            height: 13px;
            border: 1.5px solid #444;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        /* ───── BANK TABLE ───── */
        .bank-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 6px;
        }

        .bank-table th {
            background: #436026;
            color: #fff;
            padding: 5px 10px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #5a7d33;
        }

        .bank-table td {
            padding: 5px 10px;
            border: 1px solid #ddd;
        }

        /* ───── SIGNATURES ───── */
        .slip-signatures {
            padding: 14px 16px 10px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 12px;
        }

        .sig-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sig-label {
            font-size: 10px;
            font-weight: 700;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .sig-name {
            font-size: 11.5px;
            font-weight: 700;
            color: #222;
            padding-top: 2px;
            border-bottom: 1px solid #aaa;
            padding-bottom: 18px;
            min-width: 100px;
        }

        .sig-title {
            font-size: 9.5px;
            color: #666;
            margin-top: 3px;
        }

        @media print {
            .print-btn-bar {
                display: none;
            }

            .slip-wrapper {
                margin: 0;
                border: none;
                max-width: none;
            }

            body {
                font-size: 11px;
            }

            @page {
                margin: 0.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body>

<!-- Print button bar (hidden on print) -->
<div class="print-btn-bar">
    <span>&#128196; Rider Payslip — {{ $payroll->rider_name }}</span>
    <button onclick="window.print()">&#128438; Print Payslip</button>
</div>

<div class="slip-wrapper">

    <!-- ── COMPANY HEADER ── -->
    <div class="slip-header">
        <div class="company-left">
            <img src="{{ asset('images/logo.png') }}" alt="WIB Logo">
            <div class="company-info">
                <div class="company-name">When In Baguio Inc.</div>
                <div class="company-address">49 Upper P. Burgas, Baguio City</div>
                <div class="company-contact">financedepartment@whenInbaguio.com</div>
                <div class="company-contact">(074) 424 0807 | +639176366164</div>
            </div>
        </div>
        <div class="company-right">
            <div>TIN &nbsp;<strong>613-294-519-00000</strong></div>
            <div>SEC Reg No. &nbsp;<strong>2022080042402-00</strong></div>
        </div>
    </div>

    <!-- ── TITLE BAR ── -->
    <div class="slip-title-bar">
        <div class="doc-title">Freelance Delivery Rider Payslip</div>
        <div class="period-block">
            <div class="period-field">
                Month
                <span class="period-value">{{ \Carbon\Carbon::parse($payroll->created_at)->format('F') }}</span>
            </div>
            <div class="period-field">
                Year
                <span class="period-value">{{ \Carbon\Carbon::parse($payroll->created_at)->format('Y') }}</span>
            </div>
        </div>
    </div>

    <!-- ── RIDER INFO ── -->
    <div class="slip-info-grid">
        <div class="slip-info-left">
            <div class="info-row">
                <span class="info-label">Invoice for</span>
                <span class="info-value">{{ $payroll->rider_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">&nbsp;</span>
                <span class="info-value">&nbsp;</span>
            </div>
            <div class="info-row" style="margin-top:4px;">
                <span class="info-value" style="border:none; color:#888; font-size:10px;">&nbsp;</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $rider->email ?? '' }}</span>
            </div>
        </div>
        <div class="slip-info-right">
            <div class="info-row">
                <span class="info-label">Contact No.</span>
                <span class="info-value">{{ $rider->phone_number ?? '' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">ID Number</span>
                <span class="info-value">WIBFDR{{ str_pad($riderId, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Document Number</span>
                <span class="info-value">{{ 'WIBP' . \Carbon\Carbon::parse($payroll->created_at)->format('y') . \Carbon\Carbon::parse($payroll->created_at)->format('m') . str_pad($payroll->id, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tax Identification Number</span>
                <span class="info-value">&nbsp;</span>
            </div>
        </div>
    </div>

    <!-- ── TRANSACTION TABLE ── -->
    <div class="slip-table-section">
        <table class="slip-table">
            <thead>
                <tr>
                    <th style="min-width:95px;">Transaction Date</th>
                    <th>No. of Deliveries</th>
                    <th>Total WIB &amp; MANGAN DF</th>
                    <th>Tips Received</th>
                    <th>5% Deduction</th>
                    <th style="min-width:120px;">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($remittances as $remittance)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($remittance->remittance_date)->format('m/d/Y') }}</td>
                        <td>{{ number_format($remittance->total_deliveries) }}</td>
                        <td style="text-align:right;">{{ number_format($remittance->total_delivery_fee, 2) }}</td>
                        <td style="text-align:right;">{{ number_format($remittance->total_tips ?? 0, 2) }}</td>
                        <td style="text-align:right;">{{ number_format($remittance->total_delivery_fee * 0.05, 2) }}</td>
                        <td>{{ $remittance->remarks ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; color:#888; padding:14px; font-style:italic;">No remittances found for this pay period.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ── SUMMARY SECTION ── -->
    <div class="slip-summary">
        <div class="slip-summary-left">
            <div class="notes-label">Notes:</div>
            <div style="height:14px;"></div>
            <div class="stat-row">
                <span class="stat-label">Total Deliveries Made</span>
                <span class="stat-value">{{ number_format($totalDeliveries) }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Total Tips Received</span>
                <span class="stat-value">&#8369;{{ number_format($totalTips, 2) }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">Monthly Performance Incentive</span>
                <span class="stat-value">&#8369;{{ number_format($payroll->incentives ?? 0, 2) }}</span>
            </div>
            <div class="stat-row">
                <span class="stat-label">26 days renumeration</span>
                <span class="stat-value">&#8369;0.00</span>
            </div>
            <div class="stat-row" style="margin-top:4px; border-top:1px solid #ddd; padding-top:4px;">
                <span class="stat-label"><strong>ADDA DF</strong></span>
                <span class="stat-value" style="color:#436026;"><strong>&#8369;{{ number_format($payroll->base_salary, 2) }}</strong>
                    &nbsp;<span style="color:#888; font-weight:400; font-size:10px;">{{ \Carbon\Carbon::parse($payroll->created_at)->format('n/d/y') }}</span>
                </span>
            </div>
        </div>
        <div class="slip-summary-right">
            <div class="sum-row">
                <span class="sum-label">Subtotal</span>
                <span class="sum-value">&#8369;{{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-label">Platform Fee(5%)</span>
                <span class="sum-value" style="color:#dc3545;">&#8369;{{ number_format($platformFee, 2) }}</span>
            </div>
            <div class="sum-row">
                <span class="sum-label">Deductions</span>
                <span class="sum-value" style="color:#dc3545;">&#8369;{{ number_format($totalDeductions, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- ── NET PAY ── -->
    <div class="net-pay-bar">
        &#8369;{{ number_format($payroll->net_salary, 2) }}
    </div>

    <!-- ── MODE OF PAYMENT ── -->
    <div class="slip-payment">
        <div class="payment-title">Mode of Payment</div>
        <div class="payment-options">
            <div class="payment-option">
                <div class="checkbox">{!! $payroll->mode_of_payment === 'cash' ? '&#10003;' : '&nbsp;' !!}</div>
                CASH
            </div>
            <div class="payment-option">
                <div class="checkbox">{!! $payroll->mode_of_payment !== 'cash' ? '&#10003;' : '&nbsp;' !!}</div>
                Bank Transfer
            </div>
        </div>
    </div>

    <!-- ── BANK TRANSFER TABLE ── -->
    @if($payroll->mode_of_payment !== 'cash')
    <div style="padding: 0 0 0 0;">
        <table class="bank-table">
            <thead>
                <tr>
                    <th>Ref. No.</th>
                    <th>Bank/Digital Wallet</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Transfer Fee</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>{{ $payroll->rider_name }}</td>
                    <td>&nbsp;</td>
                    <td style="text-align:right;">&#8369;{{ number_format($payroll->net_salary, 2) }}</td>
                    <td style="text-align:center;">0</td>
                    <td>{{ \Carbon\Carbon::parse($payroll->created_at)->format('m/d/Y') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @else
    <div style="padding: 0;">
        <table class="bank-table">
            <thead>
                <tr>
                    <th>Ref. No.</th>
                    <th>Bank/Digital Wallet</th>
                    <th>Account Name</th>
                    <th>Account Number</th>
                    <th>Amount</th>
                    <th>Transfer Fee</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    <!-- ── SIGNATURES ── -->
    <div class="slip-signatures">
        <div class="sig-block">
            <div class="sig-label">Prepared By:</div>
            <div class="sig-name">&nbsp;</div>
            <div class="sig-title">WIB Finance Officer</div>
        </div>
        <div class="sig-block">
            <div class="sig-label">Released By:</div>
            <div class="sig-name">&nbsp;</div>
            <div class="sig-title">WIB Finance Officer</div>
        </div>
        <div class="sig-block">
            <div class="sig-label">Received By:</div>
            <div class="sig-name">{{ $payroll->rider_name }}</div>
            <div class="sig-title">Freelance Delivery Rider</div>
        </div>
        <div class="sig-block">
            <div class="sig-label">Approved By:</div>
            <div class="sig-name">&nbsp;</div>
            <div class="sig-title">WIB Finance Manager</div>
        </div>
    </div>

</div><!-- end .slip-wrapper -->

<script>
    // Auto-print when the page loads
    window.addEventListener('load', function () {
        // Small delay so styles fully render
        setTimeout(function () {
            window.print();
        }, 600);
    });
</script>

</body>
</html>
