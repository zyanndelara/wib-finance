<!DOCTYPE html>
<html lang="en">
@if (auth()->user()->force_password_change && auth()->user()->role !== 'admin')
    <div id="forceChangeModal"
        style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:2000;display:flex;align-items:center;justify-content:center;">
        <div
            style="background:white;padding:32px 32px 24px 32px;border-radius:18px;max-width:440px;width:100%;box-shadow:0 8px 32px rgba(67,96,38,0.18);display:flex;flex-direction:column;align-items:center;">
            <h2 style="margin-bottom:8px;font-size:1.35rem;font-weight:700;color:#222;text-align:center;">Change Your
                Password</h2>
            <hr style="width:100%;margin-bottom:16px;border:0;border-top:1px solid #e0e0e0;">
            <div style="margin-bottom:18px;text-align:center;color:#444;font-size:0.92rem;line-height:1.3;">
                Protect your account with a strong, secure password.<br>Make sure it's hard to guess and easy for you to
                remember.
            </div>
            <form method="POST" action="{{ route('force.password.change') }}"
                style="width:100%;display:flex;flex-direction:column;gap:18px;">
                @csrf
                @if ($errors->has('new_password'))
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        {{ $errors->first('new_password') }}
                    </div>
                @endif
                @if ($errors->has('new_password_confirmation'))
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        {{ $errors->first('new_password_confirmation') }}
                    </div>
                @endif
                @if ($errors->has('new_password') && $errors->first('new_password') === 'The new password confirmation does not match.')
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        Passwords do not match.
                    </div>
                @endif
                <div style="position:relative;width:100%;">
                    <input type="password" name="new_password" id="new_password" required
                        placeholder="Enter new password"
                        style="width:100%;padding:14px 16px;border:0;background:#e0e0e0;border-radius:12px;font-size:1.08rem;color:#222;outline:none;">
                    <!-- Eye icon removed -->
                </div>
                <div style="position:relative;width:100%;">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                        placeholder="Confirm Password"
                        style="width:100%;padding:14px 16px;border:0;background:#e0e0e0;border-radius:12px;font-size:1.08rem;color:#222;outline:none;">
                    <!-- Eye icon removed -->
                </div>
                @if ($errors->has('new_password') && $errors->first('new_password') === 'The new password confirmation does not match.')
                    <div style="color:#d32f2f;font-size:0.95rem;margin-bottom:8px;text-align:center;">
                        Passwords do not match.
                    </div>
                @endif
                <button type="submit"
                    style="background:#436026;color:white;padding:14px 0;font-size:1.15rem;font-weight:700;border:none;border-radius:8px;width:100%;margin-top:8px;box-shadow:0 2px 8px rgba(67,96,38,0.08);transition:background 0.2s;cursor:pointer;">Confirm</button>
            </form>
        </div>
        <!-- Eye icon toggle script removed -->
    </div>
    <script>
        // Prevent interaction with dashboard until password is changed
        document.body.style.overflow = 'hidden';
    </script>
@endif
@if (session('force_password_change_success'))
    <div id="passwordSuccessModal"
        style="position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);z-index:2100;display:flex;align-items:center;justify-content:center;">
        <div
            style="background:white;padding:32px 32px 24px 32px;border-radius:18px;max-width:440px;width:100%;box-shadow:0 8px 32px rgba(67,96,38,0.18);display:flex;flex-direction:column;align-items:center;">
            <h2 style="margin-bottom:8px;font-size:1.35rem;font-weight:700;color:#436026;text-align:center;">Password
                Changed Successfully</h2>
            <hr style="width:100%;margin-bottom:16px;border:0;border-top:1px solid #e0e0e0;">
            <div style="margin-bottom:18px;text-align:center;color:#444;font-size:1rem;line-height:1.3;">
                Your password has been updated. You can now continue using your account securely.
            </div>
            <button
                onclick="document.getElementById('passwordSuccessModal').style.display='none';document.body.style.overflow='auto';"
                style="background:#436026;color:white;padding:14px 0;font-size:1.15rem;font-weight:700;border:none;border-radius:8px;width:100%;margin-top:8px;box-shadow:0 2px 8px rgba(67,96,38,0.08);transition:background 0.2s;cursor:pointer;">OK</button>
        </div>
    </div>
    <script>
        document.body.style.overflow = 'hidden';
    </script>
@endif

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Dashboard - When in Baguio Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --brand-900: #1f3624;
            --brand-800: #2d4a30;
            --brand-700: #3f633c;
            --brand-500: #6f954d;
            --brand-300: #b5ce8a;
            --accent: #f5b700;
            --danger: #b84040;
            --surface: #f6f7f1;
            --surface-soft: #fcfcf8;
            --text: #172118;
            --muted: #5b6a56;
            --card-shadow: 0 10px 28px rgba(19, 40, 23, 0.12);
            --radius-lg: 18px;
            --radius-md: 12px;
        }

        body {
            font-family: 'Manrope', sans-serif;
            display: flex;
            height: 100vh;
            overflow: hidden;
            color: var(--text);
            background: radial-gradient(circle at 10% -10%, #d9e8b6 0, rgba(217, 232, 182, 0) 30%),
                radial-gradient(circle at 100% 0, #e8f3cc 0, rgba(232, 243, 204, 0) 25%),
                linear-gradient(130deg, #eff2e4 0%, #e9efdc 45%, #edf3e8 100%);
        }

                @include('partials.app-sidebar-styles')
        @include('partials.app-page-background-styles')



        /* Main Content Styles */
        .main-content {
            margin-left: 230px;
            flex: 1;
            padding: 28px 30px;
            overflow-y: auto;
            background: transparent;
        }

        .content-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0;
            gap: 18px;
            flex-wrap: wrap;
        }

        .header-copy {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .content-header h1 {
            font-size: 30px;
            font-weight: 800;
            color: var(--brand-900);
            margin: 0;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.3px;
        }

        .dashboard-subtitle {
            color: var(--muted);
            font-size: 14px;
            font-weight: 600;
        }

        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .action-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            text-decoration: none;
            padding: 8px 14px;
            color: var(--brand-900);
            background: rgba(63, 99, 60, 0.08);
            border: 1px solid rgba(63, 99, 60, 0.14);
            font-size: 12px;
            font-weight: 700;
            transition: all 0.25s ease;
        }

        .action-chip:hover {
            transform: translateY(-2px);
            background: rgba(245, 183, 0, 0.18);
            border-color: rgba(176, 129, 0, 0.3);
        }

        .user-indicator {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(67, 96, 38, 0.12);
            border-radius: 999px;
            padding: 6px 8px 6px 16px;
        }

        .user-indicator .user-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--brand-700) 0%, var(--brand-500) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 12px rgba(48, 81, 35, 0.36);
        }

        .user-indicator .user-avatar:hover {
            background: linear-gradient(135deg, #f5d54f 0%, var(--accent) 100%);
            color: var(--brand-900);
            transform: scale(1.06);
            box-shadow: 0 8px 16px rgba(178, 138, 14, 0.34);
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
            color: var(--text);
            font-size: 14px;
        }

        .user-indicator .user-role {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            text-transform: capitalize;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: linear-gradient(140deg, #27442d 0%, #3f633c 100%);
            color: white;
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            box-shadow: 0 12px 24px rgba(24, 46, 26, 0.24);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            cursor: pointer;
            min-height: 110px;
            animation: riseIn 0.45s ease both;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .stat-card:visited {
            color: white;
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(140deg, #31573a 0%, #4d7a4a 100%);
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(140deg, #365f55 0%, #447667 100%);
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(140deg, #61452f 0%, #8a6140 100%);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            right: -45px;
            top: -45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(21, 40, 20, 0.3);
        }

        .stat-card .stat-icon {
            font-size: 22px;
            opacity: 0.9;
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.15);
            filter: drop-shadow(1px 2px 4px rgba(0, 0, 0, 0.2));
            flex-shrink: 0;
        }

        .stat-card .stat-content {
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
            min-width: 0;
            overflow: hidden;
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.18);
            white-space: nowrap;
            overflow: hidden;
            width: 100%;
        }

        .stat-card p {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.9;
            margin: 0;
            letter-spacing: 0.35px;
        }

        .charts-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 14px;
            align-items: stretch;
        }

        .chart-box {
            position: relative;
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 14px;
            padding: 10px 10px 8px;
            box-shadow: 0 8px 22px rgba(25, 42, 20, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.1);
            animation: riseIn 0.5s ease both;
            overflow: hidden;
            min-height: 100%;
        }

        .chart-box::before {
            content: '';
            position: absolute;
            inset: 0 auto auto 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, rgba(63, 99, 60, 0.9) 0%, rgba(111, 149, 77, 0.7) 100%);
        }

        .chart-box:hover {
            box-shadow: 0 12px 24px rgba(35, 54, 22, 0.12);
            transform: translateY(-2px);
        }

        .chart-box h3 {
            font-size: 13px;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            margin-bottom: 8px;
            color: var(--brand-900);
            padding: 0 2px 8px;
            border-bottom: 1px solid rgba(67, 96, 38, 0.12);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .chart-box h3 span {
            display: inline-flex;
            align-items: center;
            letter-spacing: 0.05px;
        }

        .chart-filter {
            min-width: 84px;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 12px;
            background: linear-gradient(180deg, #ffffff 0%, #f5f8ef 100%);
            border: 1px solid rgba(63, 99, 60, 0.18);
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--brand-800);
            font-weight: 600;
            outline: none;
        }

        .chart-filter:hover {
            border-color: #436026;
            box-shadow: 0 3px 8px rgba(67, 96, 38, 0.12);
        }

        .chart-filter:focus {
            border-color: #436026;
            box-shadow: 0 0 0 2px rgba(67, 96, 38, 0.06);
        }

        .chart-placeholder {
            width: 100%;
            flex: 1;
            min-height: 180px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, rgba(250, 251, 245, 0.82) 0%, rgba(255, 255, 255, 0.95) 100%);
            border-radius: 9px;
            color: #666;
            border: 1px solid rgba(67, 96, 38, 0.05);
        }

        .chart-placeholder canvas {
            width: 100% !important;
            height: 100% !important;
        }

        #grossSalesTrendCard .chart-placeholder {
            min-height: 145px;
        }

        .chart-box--wide {
            grid-column: 1 / -1;
        }

        .chart-box--wide .chart-placeholder {
            min-height: 220px;
        }

        .orders-trend-body {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding-top: 10px;
            flex: 1;
            min-height: 0;
        }

        /* Orders Trend Chart Enhancement */
        .orders-trend-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafdf9 100%) !important;
            border: 1px solid rgba(67, 96, 38, 0.1) !important;
            box-shadow: 0 4px 20px rgba(25, 42, 20, 0.08) !important;
            padding: 8px 10px 10px !important;
            max-width: 100%;
            width: 100%;
            min-height: auto;
            display: flex;
            flex-direction: column;
        }

        .orders-trend-card .chart-placeholder {
            flex: 1;
            min-height: 0;
        }

        #ordersTrendCard {
            padding: 12px 6px 6px;
            border: 1px solid rgba(50, 82, 49, 0.14);
            background: linear-gradient(145deg, #ffffff 0%, #f8fbf4 100%);
            box-shadow: 0 9px 22px rgba(20, 38, 18, 0.08);
        }

        #ordersTrendCard .orders-trend-body {
            gap: 4px;
            padding-top: 4px;
        }

        #ordersTrendCard .chart-placeholder {
            min-height: 90px;
        }

        #ordersTrendCard .orders-trend-stats {
            gap: 6px;
        }

        #ordersTrendCard .stat-box {
            padding: 8px 9px 7px;
            border-color: rgba(68, 101, 54, 0.11);
            background: linear-gradient(145deg, rgba(68, 101, 54, 0.09) 0%, rgba(68, 101, 54, 0.03) 100%);
        }

        .orders-pro-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 0 0 8px;
            border-bottom: 1px solid rgba(58, 93, 52, 0.12);
        }

        .orders-pro-title-wrap {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            min-width: 0;
        }

        .orders-pro-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            display: grid;
            place-items: center;
            color: #ffffff;
            background: linear-gradient(145deg, #345633 0%, #6d944a 100%);
            box-shadow: 0 6px 12px rgba(52, 86, 51, 0.23);
            flex-shrink: 0;
        }

        .orders-pro-copy {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .orders-pro-title {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 14px;
            line-height: 1.2;
            font-weight: 800;
            color: #1f3624;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.2px;
            display: block;
        }

        .orders-pro-subtitle {
            margin: 0;
            font-size: 10px;
            font-weight: 600;
            color: #647460;
        }

        .orders-pro-badge {
            margin-top: 1px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: fit-content;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.35px;
            color: #2f5233;
            background: rgba(64, 103, 60, 0.11);
            border: 1px solid rgba(64, 103, 60, 0.2);
            border-radius: 999px;
            padding: 3px 8px;
            text-transform: uppercase;
        }

        .orders-pro-controls {
            display: inline-flex;
            align-items: center;
            padding: 3px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid rgba(61, 97, 55, 0.16);
            box-shadow: 0 3px 8px rgba(46, 72, 32, 0.08);
            flex-shrink: 0;
        }

        #fundsOutflowsCard {
            border: 1px solid rgba(74, 90, 42, 0.14);
            background: linear-gradient(145deg, #ffffff 0%, #fcfbf1 100%);
            box-shadow: 0 9px 22px rgba(35, 40, 14, 0.08);
            padding: 12px 9px 9px;
        }

        .funds-pro-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 11px;
            padding: 0 0 8px;
            border-bottom: 1px solid rgba(114, 124, 44, 0.15);
        }

        .funds-pro-title-wrap {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            min-width: 0;
        }

        .funds-pro-icon {
            width: 30px;
            height: 30px;
            border-radius: 9px;
            display: grid;
            place-items: center;
            color: #1f3624;
            background: linear-gradient(145deg, #ffe173 0%, #f5b700 100%);
            box-shadow: 0 6px 12px rgba(157, 116, 3, 0.26);
            flex-shrink: 0;
        }

        .funds-pro-copy {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .funds-pro-title {
            margin: 0;
            font-size: 14px;
            line-height: 1.2;
            font-weight: 800;
            color: #2c3f20;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.2px;
        }

        .funds-pro-subtitle {
            margin: 0;
            font-size: 10px;
            font-weight: 600;
            color: #74743f;
        }

        .funds-pro-badge {
            margin-top: 1px;
            display: inline-flex;
            align-items: center;
            width: fit-content;
            border-radius: 999px;
            padding: 3px 8px;
            border: 1px solid rgba(143, 132, 46, 0.28);
            background: rgba(245, 183, 0, 0.13);
            color: #665d17;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.35px;
            text-transform: uppercase;
        }

        .funds-pro-controls {
            display: inline-flex;
            align-items: center;
            padding: 3px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid rgba(143, 132, 46, 0.2);
            box-shadow: 0 3px 8px rgba(123, 100, 11, 0.09);
            flex-shrink: 0;
        }

        .funds-pro-body {
            display: flex;
            flex-direction: column;
            gap: 7px;
            padding-top: 6px;
            min-height: 0;
            flex: 1;
        }

        .funds-pro-metrics {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
        }

        .funds-pro-metric {
            border: 1px solid rgba(143, 132, 46, 0.16);
            border-radius: 9px;
            padding: 7px 8px;
            background: linear-gradient(145deg, rgba(245, 183, 0, 0.11) 0%, rgba(245, 183, 0, 0.04) 100%);
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }

        .funds-pro-metric-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.38px;
            color: #7a7030;
            text-transform: uppercase;
        }

        .funds-pro-metric-value {
            font-size: 12px;
            font-weight: 700;
            font-family: 'Sora', sans-serif;
            color: #2c3f20;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .funds-pro-metric.net {
            border-color: rgba(67, 96, 38, 0.22);
            background: linear-gradient(145deg, rgba(67, 96, 38, 0.14) 0%, rgba(67, 96, 38, 0.05) 100%);
        }

        .funds-pro-metric.net .funds-pro-metric-value {
            color: #1f3624;
        }

        #fundsOutflowsCard .chart-placeholder {
            min-height: 104px;
            border-color: rgba(130, 118, 40, 0.13);
            background: linear-gradient(165deg, rgba(255, 250, 230, 0.82) 0%, rgba(255, 255, 255, 0.96) 100%);
        }

        #grossSalesTrendCard {
            width: 100%;
            max-width: none;
            margin-left: 0;
            margin-right: 0;
            padding: 10px 12px 12px !important;
            border: 1px solid rgba(50, 82, 49, 0.15) !important;
            background: linear-gradient(140deg, #ffffff 0%, #f8fbf4 100%) !important;
            box-shadow: 0 10px 24px rgba(20, 38, 18, 0.09) !important;
        }

        #grossSalesTrendCard .orders-trend-body {
            gap: 8px;
            padding-top: 8px;
        }

        #grossSalesTrendCard .chart-placeholder {
            min-height: 130px;
            border-color: rgba(53, 84, 43, 0.1);
            background: linear-gradient(165deg, rgba(246, 250, 239, 0.85) 0%, rgba(255, 255, 255, 0.96) 100%);
        }

        .gross-sales-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
            padding: 0 0 10px;
            border-bottom: 1px solid rgba(57, 94, 53, 0.12);
        }

        .gross-sales-title-wrap {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            min-width: 0;
        }

        .gross-sales-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: #ffffff;
            background: linear-gradient(145deg, #2d4a30 0%, #5f8544 100%);
            box-shadow: 0 7px 14px rgba(45, 74, 48, 0.24);
            flex-shrink: 0;
        }

        .gross-sales-copy {
            display: flex;
            flex-direction: column;
            gap: 3px;
            min-width: 0;
        }

        .gross-sales-title {
            margin: 0;
            font-size: 15px;
            line-height: 1.2;
            font-weight: 800;
            color: #1f3624;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.2px;
        }

        .gross-sales-subtitle {
            margin: 0;
            font-size: 11px;
            color: #61715d;
            font-weight: 600;
        }

        .gross-sales-period {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: fit-content;
            margin-top: 1px;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            color: #305034;
            background: rgba(66, 106, 62, 0.1);
            border: 1px solid rgba(66, 106, 62, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .gross-sales-controls {
            display: inline-flex;
            align-items: center;
            padding: 3px;
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid rgba(61, 97, 55, 0.16);
            box-shadow: 0 3px 9px rgba(46, 72, 32, 0.08);
            flex-shrink: 0;
        }

        .gross-sales-metrics {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 8px;
        }

        .gross-sales-metric {
            background: linear-gradient(145deg, rgba(69, 105, 51, 0.08) 0%, rgba(69, 105, 51, 0.03) 100%);
            border: 1px solid rgba(69, 105, 51, 0.11);
            border-radius: 10px;
            padding: 8px 9px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            min-width: 0;
        }

        .gross-sales-metric-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.45px;
            color: #6d7c68;
            font-weight: 700;
        }

        .gross-sales-metric-value {
            font-size: 12px;
            color: #1f3624;
            font-family: 'Sora', sans-serif;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .gross-sales-metric.total {
            background: linear-gradient(145deg, rgba(31, 54, 36, 0.12) 0%, rgba(47, 80, 44, 0.06) 100%);
            border-color: rgba(31, 54, 36, 0.22);
        }

        .gross-sales-metric.total .gross-sales-metric-value {
            color: #18301f;
        }

        .orders-trend-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 12px;
            border-bottom: 1px solid rgba(67, 96, 38, 0.08);
            margin: -8px -10px 10px -10px;
            background: linear-gradient(90deg, rgba(67, 96, 38, 0.04) 0%, rgba(67, 96, 38, 0.015) 100%);
        }

        .orders-trend-title {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .orders-trend-header .orders-trend-heading {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #1f3624;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            letter-spacing: 0.1px;
            justify-content: flex-start;
            width: auto;
            border: 0;
            padding: 0;
            text-align: left;
            align-self: flex-start;
        }

        .orders-trend-heading i {
            color: #436026;
            font-size: 16px;
        }

        .orders-trend-subtitle {
            margin: 0;
            font-size: 11px;
            font-weight: 600;
            color: #6c7568;
            letter-spacing: 0.2px;
        }

        .orders-trend-actions {
            display: inline-flex;
            align-items: center;
            padding: 3px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(67, 96, 38, 0.14);
        }

        .orders-trend-year-filter {
            font-size: 12px;
            padding: 6px 10px;
            min-width: 78px;
        }

        .orders-trend-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            padding: 0;
            margin-bottom: 0;
            align-content: start;
        }

        .stat-box {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 11px 12px 10px;
            background: linear-gradient(135deg, rgba(67, 96, 38, 0.04) 0%, rgba(67, 96, 38, 0.02) 100%);
            border: 1px solid rgba(67, 96, 38, 0.08);
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.5);
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, rgba(67, 96, 38, 0.5), rgba(67, 96, 38, 0.08));
        }

        .stat-box:hover {
            background: linear-gradient(135deg, rgba(67, 96, 38, 0.08) 0%, rgba(67, 96, 38, 0.04) 100%);
            transform: translateY(-1px);
        }

        .stat-label {
            font-size: 10px;
            font-weight: 600;
            color: #6c7568;
            text-transform: uppercase;
            letter-spacing: 0.45px;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 15px;
            font-weight: 700;
            color: #436026;
            font-family: 'Sora', sans-serif;
            letter-spacing: 0.2px;
            line-height: 1.1;
        }

        @media (max-width: 768px) {
            #ordersTrendCard {
                padding: 10px 6px 5px;
            }

            .orders-pro-header {
                flex-direction: column;
                align-items: stretch;
                gap: 9px;
            }

            .orders-pro-controls {
                width: 100%;
                justify-content: flex-end;
            }

            .funds-pro-header {
                flex-direction: column;
                align-items: stretch;
                gap: 9px;
            }

            .funds-pro-controls {
                width: 100%;
                justify-content: flex-end;
            }

            .funds-pro-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            #fundsOutflowsCard .chart-placeholder {
                min-height: 95px;
            }

            #fundsOutflowsCard {
                padding: 10px 9px 9px;
            }

            #ordersTrendCard .chart-placeholder {
                min-height: 80px;
            }

            #grossSalesTrendCard {
                width: 100%;
                padding: 8px 9px 9px !important;
            }

            #grossSalesTrendCard .chart-placeholder {
                min-height: 115px;
            }

            .gross-sales-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .gross-sales-controls {
                width: 100%;
                justify-content: flex-end;
            }

            .gross-sales-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .orders-trend-body {
                gap: 8px;
            }

            .orders-trend-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .orders-trend-actions {
                width: 100%;
                justify-content: flex-end;
            }

            .orders-trend-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .orders-trend-card {
                max-width: 100%;
            }

            .orders-trend-card {
                height: auto !important;
            }
        }

        @media (max-width: 480px) {
            #fundsOutflowsCard {
                padding: 8px 8px 8px;
            }

            #ordersTrendCard {
                padding: 8px 5px 4px;
            }

            .orders-pro-title {
                font-size: 13px;
            }

            .funds-pro-title {
                font-size: 13px;
            }

            .funds-pro-metrics {
                grid-template-columns: 1fr;
            }

            #fundsOutflowsCard .chart-placeholder {
                min-height: 84px;
            }

            #ordersTrendCard .chart-placeholder {
                min-height: 70px;
            }

            #grossSalesTrendCard .chart-placeholder {
                min-height: 102px;
            }

            .gross-sales-title {
                font-size: 14px;
            }

            .gross-sales-metrics {
                grid-template-columns: 1fr;
            }

            .orders-trend-stats {
                grid-template-columns: 1fr;
            }

            .orders-trend-card {
                height: auto !important;
            }
        }

        .transaction-history {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(67, 96, 38, 0.12);
            animation: riseIn 0.55s ease both;
            animation-delay: 0.2s;
        }

        .transaction-history:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .transaction-history h3 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 16px;
            color: var(--brand-900);
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(67, 96, 38, 0.16);
        }

        .transaction-table {
            background: linear-gradient(135deg, #f6f8f0 0%, #edf2e4 100%);
            border-radius: 8px;
            padding: 40px;
            min-height: 200px;
            text-align: center;
            color: var(--muted);
            box-shadow: inset 0 2px 8px rgba(18, 44, 18, 0.06);
            border: 1px dashed rgba(67, 96, 38, 0.3);
        }

        /* Success Alert */
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
            animation: slideInDown 0.5s ease;
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

        @keyframes riseIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .main-content {
                padding: 22px;
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
                padding: 80px 16px 18px 16px;
            }

            .sidebar-logo {
                padding: 18px 16px;
            }

            .sidebar-logo img {
                width: 52px;
                height: 52px;
            }

            .menu-item {
                padding: 10px 10px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .chart-box--wide {
                grid-column: auto;
            }

            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
                padding: 0;
            }

            .content-header h1 {
                font-size: 26px;
            }

            .user-indicator {
                width: 100%;
                justify-content: space-between;
                margin-left: 0;
            }

            .quick-actions {
                width: 100%;
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
                font-size: 24px;
            }

            .chart-box {
                padding: 10px;
            }

            .chart-placeholder {
                min-height: 160px;
            }

            .chart-box--wide .chart-placeholder {
                min-height: 190px;
            }

            .orders-trend-body {
                padding-top: 8px;
            }

            .stat-box {
                padding: 9px 10px;
            }

            .transaction-history {
                padding: 16px;
            }

            .user-indicator .user-info {
                align-items: flex-start;
                text-align: left;
            }

            .user-indicator .user-name {
                font-size: 13px;
            }
        }

        @include('partials.user-indicator-styles')
    </style>
</head>

<body>
    @include('partials.app-sidebar', ['activePage' => 'dashboard'])

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-header">
            <div class="header-copy">
                <h1>Dashboard Overview</h1>
            </div>
            @include('partials.user-indicator')
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-wallet stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;{{ number_format($totalCollections, 2) }}</h3>
                    <p>Total Collections</p>
                </div>
            </a>
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-chart-line stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;200,000</h3>
                    <p>Net Revenue</p>
                </div>
            </a>
            <a href="{{ route('merchants') }}" class="stat-card">
                <i class="fas fa-piggy-bank stat-icon"></i>
                <div class="stat-content">
                    <h3>-</h3>
                    <p>GT. Funds Balance</p>
                </div>
            </a>
            <a href="{{ route('bank-deposit') }}" class="stat-card">
                <i class="fas fa-exclamation-triangle stat-icon"></i>
                <div class="stat-content">
                    <h3>&#8369;{{ number_format($totalDiscrepancies, 2) }}</h3>
                    <p>Discrepancies</p>
                </div>
            </a>
        </div>

        <!-- Charts -->
        <!-- Gross Sales Trend -->
        <div class="chart-box orders-trend-card" id="grossSalesTrendCard" style="margin-bottom:22px;">
            <div class="gross-sales-header">
                <div class="gross-sales-title-wrap">
                    <div class="gross-sales-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="gross-sales-copy">
                        <h3 class="gross-sales-title">Gross Sales Trend</h3>
                        <p class="gross-sales-subtitle">Live merchant sales performance by partner segment</p>
                        <span class="gross-sales-period" id="grossSalesPeriodLabel">Monthly View</span>
                    </div>
                </div>
                <div class="gross-sales-controls">
                    <select class="chart-filter orders-trend-year-filter" id="salesTrendFilter" onchange="changeSalesTrendView(this.value)">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly" selected>Monthly</option>
                        <option value="annually">Annually</option>
                    </select>
                </div>
            </div>

            <div class="orders-trend-body">
                <div class="gross-sales-metrics">
                    <div class="gross-sales-metric">
                        <span class="gross-sales-metric-label">Partners</span>
                        <span class="gross-sales-metric-value" id="grossSalesPartnersTotal">PHP 0.00</span>
                    </div>
                    <div class="gross-sales-metric">
                        <span class="gross-sales-metric-label">Non-Partners</span>
                        <span class="gross-sales-metric-value" id="grossSalesNonPartnersTotal">PHP 0.00</span>
                    </div>
                    <div class="gross-sales-metric">
                        <span class="gross-sales-metric-label">Good Taste</span>
                        <span class="gross-sales-metric-value" id="grossSalesGoodTasteTotal">PHP 0.00</span>
                    </div>
                    <div class="gross-sales-metric total">
                        <span class="gross-sales-metric-label">Total</span>
                        <span class="gross-sales-metric-value" id="grossSalesOverallTotal">PHP 0.00</span>
                    </div>
                </div>

                <div class="chart-placeholder">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="charts-grid">
            <!-- Orders by Month Trend Chart -->
            <div class="chart-box" id="ordersTrendCard">
                <div class="orders-pro-header">
                    <div class="orders-pro-title-wrap">
                        <div class="orders-pro-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div class="orders-pro-copy">
                            <h3 class="orders-pro-title">Orders by Month Trend</h3>
                            <p class="orders-pro-subtitle">Monthly order performance overview</p>
                            <span class="orders-pro-badge" id="ordersTrendYearBadge">Year {{ $chartYears[0] }}</span>
                        </div>
                    </div>
                    <div class="orders-pro-controls">
                        <select class="chart-filter orders-trend-year-filter" id="ordersByMonthYear" onchange="updateOrdersByMonth(this.value)">
                            @foreach ($chartYears as $yr)
                                <option value="{{ $yr }}" {{ $loop->first ? 'selected' : '' }}>{{ $yr }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="orders-trend-body">
                    <div class="orders-trend-stats">
                        <div class="stat-box">
                            <span class="stat-label">Total Orders</span>
                            <span class="stat-value" id="totalOrdersStat">0</span>
                        </div>
                        <div class="stat-box">
                            <span class="stat-label">Peak Month</span>
                            <span class="stat-value" id="peakMonthStat">-</span>
                        </div>
                    </div>

                    <div class="chart-placeholder">
                        <canvas id="ordersByMonthChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Daily/Weekly/Monthly Chart -->
            <div class="chart-box" id="fundsOutflowsCard">
                <div class="funds-pro-header">
                    <div class="funds-pro-title-wrap">
                        <div class="funds-pro-icon">
                            <i class="fas fa-arrows-left-right"></i>
                        </div>
                        <div class="funds-pro-copy">
                            <h3 class="funds-pro-title">Funds and Outflows</h3>
                            <p class="funds-pro-subtitle">Balance movement overview by reporting period</p>
                            <span class="funds-pro-badge" id="fundsFlowPeriodLabel">Daily Snapshot</span>
                        </div>
                    </div>
                    <div class="funds-pro-controls">
                        <select class="chart-filter" id="fundsFlowFilter" onchange="changeChartView(this.value)">
                            <option value="daily" selected>Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                </div>

                <div class="funds-pro-body">
                    <div class="funds-pro-metrics">
                        <div class="funds-pro-metric">
                            <span class="funds-pro-metric-label">Total Inflow</span>
                            <span class="funds-pro-metric-value" id="fundsTotalInflow">PHP 0.00</span>
                        </div>
                        <div class="funds-pro-metric">
                            <span class="funds-pro-metric-label">Total Outflow</span>
                            <span class="funds-pro-metric-value" id="fundsTotalOutflow">PHP 0.00</span>
                        </div>
                        <div class="funds-pro-metric net">
                            <span class="funds-pro-metric-label">Net Flow</span>
                            <span class="funds-pro-metric-value" id="fundsNetFlow">PHP 0.00</span>
                        </div>
                    </div>

                    <div class="chart-placeholder">
                        <canvas id="expenseBalanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transaction History -->
        <div class="transaction-history">
            <h3>Recent Transaction History</h3>
            <div class="transaction-table">
                <!-- Transaction data will be displayed here -->
                <p style="color: #999;">No recent transactions</p>
            </div>
        </div>
    </div>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gross Sales Trend Chart (live merchant sales from mt_order + mt_merchant)
        const salesTrendSeries = @json($salesTrendSeries ?? []);
        const merchantsBaseUrl = @json(route('merchants'));

        function getSalesSeries(period) {
            const fallback = {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                partners: Array(6).fill(0),
                nonPartners: Array(6).fill(0),
                goodTaste: Array(6).fill(0)
            };

            const candidate = salesTrendSeries[period] || salesTrendSeries.monthly || fallback;
            const labels = Array.isArray(candidate.labels) ? candidate.labels : fallback.labels;
            const partners = Array.isArray(candidate.partners) ? candidate.partners : Array(labels.length).fill(0);
            const nonPartners = Array.isArray(candidate.nonPartners) ? candidate.nonPartners : Array(labels.length).fill(0);
            const goodTaste = Array.isArray(candidate.goodTaste) ? candidate.goodTaste : Array(labels.length).fill(0);

            return {
                labels,
                partners,
                nonPartners,
                goodTaste
            };
        }

        function toCurrency(value) {
            return 'PHP ' + Number(value || 0).toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function sumNumericSeries(values) {
            if (!Array.isArray(values)) {
                return 0;
            }

            return values.reduce((sum, value) => sum + Number(value || 0), 0);
        }

        function updateGrossSalesSummary(period) {
            const activePeriod = period || document.getElementById('salesTrendFilter')?.value || 'monthly';
            const periodLabels = {
                daily: 'Daily View',
                weekly: 'Weekly View',
                monthly: 'Monthly View',
                annually: 'Annual View'
            };

            const series = getSalesSeries(activePeriod);
            const partnersTotal = sumNumericSeries(series.partners);
            const nonPartnersTotal = sumNumericSeries(series.nonPartners);
            const goodTasteTotal = sumNumericSeries(series.goodTaste);
            const overallTotal = partnersTotal + nonPartnersTotal + goodTasteTotal;

            const partnersEl = document.getElementById('grossSalesPartnersTotal');
            const nonPartnersEl = document.getElementById('grossSalesNonPartnersTotal');
            const goodTasteEl = document.getElementById('grossSalesGoodTasteTotal');
            const overallEl = document.getElementById('grossSalesOverallTotal');
            const periodEl = document.getElementById('grossSalesPeriodLabel');

            if (partnersEl) partnersEl.textContent = toCurrency(partnersTotal);
            if (nonPartnersEl) nonPartnersEl.textContent = toCurrency(nonPartnersTotal);
            if (goodTasteEl) goodTasteEl.textContent = toCurrency(goodTasteTotal);
            if (overallEl) overallEl.textContent = toCurrency(overallTotal);
            if (periodEl) periodEl.textContent = periodLabels[activePeriod] || 'Monthly View';
        }

        function mapSalesTrendToMerchantPeriod(period) {
            if (period === 'daily') return 'daily';
            if (period === 'weekly') return 'weekly';
            return 'monthly';
        }

        function openMerchantsFromSalesTrend(datasetLabel) {
            const merchantType = String(datasetLabel || '').toLowerCase().includes('non') ? 'non-partner' : 'partner';
            const selectedPeriod = document.getElementById('salesTrendFilter')?.value || 'monthly';
            const merchantPeriod = mapSalesTrendToMerchantPeriod(selectedPeriod);
            const nowDate = new Date().toISOString().slice(0, 10);

            const url = new URL(merchantsBaseUrl, window.location.origin);
            url.searchParams.set('merchant_type', merchantType);
            url.searchParams.set('period', merchantPeriod);
            url.searchParams.set('stats_date', nowDate);
            window.location.href = url.toString();
        }

        const initialSalesSeries = getSalesSeries('monthly');

        const salesCtx = document.getElementById('salesTrendChart').getContext('2d');
        const salesTrendChart = new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: initialSalesSeries.labels,
                datasets: [{
                    type: 'bar',
                    label: 'Partners',
                    data: initialSalesSeries.partners,
                    yAxisID: 'yUnits',
                    backgroundColor: '#2d4a30',
                    borderColor: '#2d4a30',
                    borderWidth: 0,
                    categoryPercentage: 0.58,
                    barPercentage: 0.7,
                    order: 2
                }, {
                    type: 'line',
                    label: 'Non-Partners',
                    data: initialSalesSeries.nonPartners,
                    yAxisID: 'yUnits',
                    borderColor: '#7fa34d',
                    backgroundColor: '#7fa34d',
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    tension: 0,
                    fill: false,
                    order: 1
                }, {
                    type: 'line',
                    label: 'Good Taste',
                    data: initialSalesSeries.goodTaste,
                    yAxisID: 'yUnits',
                    borderColor: '#3d746d',
                    backgroundColor: '#3d746d',
                    borderWidth: 3,
                    pointRadius: 3,
                    pointHoverRadius: 4,
                    tension: 0,
                    fill: false,
                    order: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                onClick: function(event, elements, chart) {
                    if (!elements || !elements.length) {
                        return;
                    }

                    const firstPoint = elements[0];
                    const dataset = chart?.data?.datasets?.[firstPoint.datasetIndex];
                    if (!dataset || !dataset.label) {
                        return;
                    }

                    openMerchantsFromSalesTrend(dataset.label);
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#4f5e4a',
                            padding: 14,
                            font: {
                                family: 'Manrope',
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(24, 34, 22, 0.94)',
                        titleColor: '#ffffff',
                        bodyColor: '#eef4ea',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.dataset.label + ': ' + toCurrency(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    yUnits: {
                        position: 'left',
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(67, 96, 38, 0.12)'
                        },
                        ticks: {
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 11
                            },
                            callback: function(value) {
                                const numeric = Number(value || 0);
                                if (Math.abs(numeric) >= 1000000) {
                                    return 'PHP ' + (numeric / 1000000).toFixed(1) + 'M';
                                }
                                if (Math.abs(numeric) >= 1000) {
                                    return 'PHP ' + (numeric / 1000).toFixed(0) + 'k';
                                }

                                return 'PHP ' + numeric.toLocaleString('en-PH');
                            }
                        }
                    }
                }
            }
        });

        // Expense/Balance Chart
        const expenseCtx = document.getElementById('expenseBalanceChart').getContext('2d');
        const expenseBalanceChart = new Chart(expenseCtx, {
            type: 'bar',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Beginning Balance',
                    data: [80, 150, 110, 90, 80, 100, 110],
                    backgroundColor: '#436026',
                    stack: 'Stack 0',
                    categoryPercentage: 0.7,
                    barPercentage: 0.9
                }, {
                    label: 'Expense',
                    data: [-120, -180, -130, -110, -100, -120, -130],
                    backgroundColor: '#ffd300',
                    stack: 'Stack 0',
                    categoryPercentage: 0.7,
                    barPercentage: 0.9
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#4f5e4a',
                            padding: 14,
                            font: {
                                family: 'Manrope',
                                size: 11,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(24, 34, 22, 0.94)',
                        titleColor: '#ffffff',
                        bodyColor: '#eef4ea',
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false,
                        titleFont: {
                            family: 'Sora',
                            size: 12,
                            weight: '600'
                        },
                        bodyFont: {
                            family: 'Manrope',
                            size: 11,
                            weight: '500'
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: true,
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 11
                            }
                        }
                    },
                    y: {
                        stacked: true,
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(67, 96, 38, 0.08)'
                        },
                        ticks: {
                            stepSize: 100,
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        function updateFundsSummary(view) {
            const activeView = view || document.getElementById('fundsFlowFilter')?.value || 'daily';
            const periodLabels = {
                daily: 'Daily Snapshot',
                weekly: 'Weekly Snapshot',
                monthly: 'Monthly Snapshot'
            };

            const inflowSeries = expenseBalanceChart?.data?.datasets?.[0]?.data || [];
            const outflowSeries = expenseBalanceChart?.data?.datasets?.[1]?.data || [];
            const totalInflow = sumNumericSeries(inflowSeries);
            const totalOutflow = Math.abs(sumNumericSeries(outflowSeries));
            const netFlow = totalInflow - totalOutflow;

            const inflowEl = document.getElementById('fundsTotalInflow');
            const outflowEl = document.getElementById('fundsTotalOutflow');
            const netEl = document.getElementById('fundsNetFlow');
            const periodEl = document.getElementById('fundsFlowPeriodLabel');

            if (inflowEl) inflowEl.textContent = toCurrency(totalInflow);
            if (outflowEl) outflowEl.textContent = toCurrency(totalOutflow);
            if (netEl) netEl.textContent = toCurrency(netFlow);
            if (periodEl) periodEl.textContent = periodLabels[activeView] || 'Daily Snapshot';
        }

        function changeChartView(view) {
            // Update chart data based on view (daily/weekly/monthly)
            // This is a placeholder - implement actual data fetching logic
            console.log('Funds and Outflows view changed to:', view);

            // Example: Update chart labels based on period
            let labels;
            switch (view) {
                case 'daily':
                    labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    break;
                case 'weekly':
                    labels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
                    break;
                case 'monthly':
                    labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    break;
            }

            // Update chart with new labels
            expenseBalanceChart.data.labels = labels;
            expenseBalanceChart.update();
            updateFundsSummary(view);
        }

        // Orders by Month Chart connected to mt_order order_id counts
        const ordersData = @json($monthlyOrders);
        const defaultYear = {{ $chartYears[0] }};

        const ordersCtx = document.getElementById('ordersByMonthChart').getContext('2d');
        const ordersByMonthChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Orders',
                    data: ordersData[defaultYear] || Array(12).fill(0),
                    backgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        if (value === 0) return 'rgba(67, 96, 38, 0.12)';
                        // Create gradient color based on value
                        const maxValue = Math.max(...(ordersData[defaultYear] || [0]));
                        const percentage = value / maxValue;
                        if (percentage < 0.3) return '#a8d5a8';
                        if (percentage < 0.6) return '#6fb84d';
                        if (percentage < 0.8) return '#436026';
                        return '#2a4118';
                    },
                    borderRadius: 6,
                    borderSkipped: false,
                    hoverBackgroundColor: '#436026',
                    borderColor: 'transparent',
                    categoryPercentage: 0.8,
                    barPercentage: 0.85,
                    order: 1,
                    transition: {
                        duration: 400
                    }
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        top: 10,
                        bottom: 6,
                        left: 8,
                        right: 8
                    }
                },
                plugins: {
                    filler: {
                        propagate: true
                    },
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            color: '#4f5e4a',
                            padding: 14,
                            font: {
                                family: 'Manrope',
                                size: 12,
                                weight: '600'
                            },
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.datasets.map((dataset, i) => ({
                                        text: dataset.label,
                                        fillStyle: dataset.backgroundColor || dataset.borderColor,
                                        hidden: !chart.isDatasetVisible(i),
                                        index: i,
                                        pointStyle: 'circle'
                                    }));
                                }
                                return [];
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(24, 34, 22, 0.96)',
                        titleColor: '#ffffff',
                        bodyColor: '#eef4ea',
                        borderColor: 'rgba(67, 96, 38, 0.3)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: true,
                        caretPadding: 15,
                        titleFont: {
                            family: 'Sora',
                            size: 13,
                            weight: '700'
                        },
                        bodyFont: {
                            family: 'Manrope',
                            size: 12,
                            weight: '500'
                        },
                        callbacks: {
                            title: function(ctx) {
                                return ctx[0].label + ' 2026';
                            },
                            label: function(ctx) {
                                if (ctx.dataset.label === 'Trend Line') {
                                    return '';
                                }
                                const value = ctx.parsed.y;
                                return ' ' + ctx.dataset.label + ': ' + value.toLocaleString('en-PH');
                            },
                            afterLabel: function(ctx) {
                                if (ctx.dataset.label === 'Orders') {
                                    const value = ctx.parsed.y;
                                    if (value === 0) {
                                        return '⚠ Zero orders this month';
                                    }
                                }
                                return '';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: true,
                            drawBorder: false,
                            color: 'rgba(67, 96, 38, 0.04)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 12,
                                weight: '600'
                            },
                            padding: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(67, 96, 38, 0.08)',
                            drawBorder: false,
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#6c7568',
                            font: {
                                family: 'Manrope',
                                size: 11,
                                weight: '500'
                            },
                            padding: 10,
                            callback: function(value) {
                                if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'k';
                                }
                                return value.toLocaleString('en-PH');
                            }
                        }
                    }
                }
            }
        });

        function updateOrdersStatistics(yearData) {
            const filteredData = yearData.filter(v => v > 0);
            const total = filteredData.reduce((a, b) => a + b, 0);
            
            let maxValue = 0;
            let peakMonth = '-';
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            
            yearData.forEach((value, index) => {
                if (value > maxValue) {
                    maxValue = value;
                    peakMonth = months[index];
                }
            });
            
            document.getElementById('totalOrdersStat').textContent = total.toLocaleString('en-PH');
            document.getElementById('peakMonthStat').textContent = peakMonth !== '-' ? peakMonth + ' (' + maxValue.toLocaleString('en-PH') + ')' : '-';
        }

        function updateOrdersTrendYearBadge(year) {
            const badge = document.getElementById('ordersTrendYearBadge');
            if (!badge) {
                return;
            }

            badge.textContent = 'Year ' + year;
        }

        function updateOrdersByMonth(year) {
            const yearData = ordersData[year] || Array(12).fill(0);
            ordersByMonthChart.data.datasets[0].data = yearData;
            updateOrdersStatistics(yearData);
            updateOrdersTrendYearBadge(year);
            ordersByMonthChart.update('active');
        }

        function syncOrdersTrendCardHeight() {
            const ordersCard = document.getElementById('ordersTrendCard');
            const grossCard = document.getElementById('grossSalesTrendCard');

            if (!ordersCard || !grossCard || typeof salesTrendChart === 'undefined' || typeof ordersByMonthChart === 'undefined') {
                return;
            }

            if (window.innerWidth <= 768) {
                grossCard.style.height = 'auto';
                salesTrendChart.resize();
                ordersByMonthChart.resize();
                return;
            }

            grossCard.style.height = ordersCard.offsetHeight + 'px';
            salesTrendChart.resize();
            ordersByMonthChart.resize();
        }
        
        // Initialize chart with data on page load
        const initialData = ordersData[defaultYear] || Array(12).fill(0);
        ordersByMonthChart.data.datasets[0].data = initialData;
        updateOrdersStatistics(initialData);
        updateOrdersTrendYearBadge(defaultYear);
        ordersByMonthChart.update();
        updateFundsSummary('daily');
        updateGrossSalesSummary('monthly');
        syncOrdersTrendCardHeight();

        // Change Sales Trend View
        function changeSalesTrendView(period) {
            const series = getSalesSeries(period);
            salesTrendChart.data.labels = series.labels;
            salesTrendChart.data.datasets[0].data = series.partners;
            salesTrendChart.data.datasets[1].data = series.nonPartners;
            salesTrendChart.data.datasets[2].data = series.goodTaste;
            salesTrendChart.update();
            updateGrossSalesSummary(period);
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

        // Auto-fit stat card numbers so they never overflow regardless of value length
        function fitStatCardNumbers() {
            document.querySelectorAll('.stat-card h3').forEach(function(h3) {
                h3.style.fontSize = '';
                var maxSize = 32;
                var minSize = 10;
                var size = maxSize;
                h3.style.fontSize = size + 'px';
                while (h3.scrollWidth > h3.offsetWidth && size > minSize) {
                    size -= 0.5;
                    h3.style.fontSize = size + 'px';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', fitStatCardNumbers);
        window.addEventListener('resize', fitStatCardNumbers);
        window.addEventListener('resize', syncOrdersTrendCardHeight);
        window.addEventListener('load', syncOrdersTrendCardHeight);
    </script>

    @include('partials.floating-widgets')
</body>

</html>

