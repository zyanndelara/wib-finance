<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/logowhite.png') }}">
    <title>Password Reset PIN Code</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .email-header {
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            padding: 40px 40px 30px;
            text-align: center;
        }
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }
        .email-header p {
            color: rgba(255,255,255,0.85);
            margin: 8px 0 0;
            font-size: 14px;
        }
        .email-body {
            padding: 40px;
        }
        .email-body p {
            margin: 0 0 16px;
            line-height: 1.7;
            font-size: 15px;
            color: #444;
        }
        .pin-container {
            background: #f8f9fa;
            border: 2px dashed #436026;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 30px 0;
        }
        .pin-label {
            font-size: 13px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
            display: block;
        }
        .pin-code {
            font-size: 42px;
            font-weight: 800;
            color: #436026;
            letter-spacing: 12px;
            font-family: 'Courier New', Courier, monospace;
        }
        .pin-expiry {
            font-size: 13px;
            color: #888;
            margin-top: 12px;
            display: block;
        }
        .warning-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            border-radius: 4px;
            padding: 14px 16px;
            margin: 20px 0;
            font-size: 14px;
            color: #795548;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 24px 40px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        .email-footer p {
            margin: 0;
            font-size: 13px;
            color: #999;
            line-height: 1.6;
        }
        .brand-name {
            color: #436026;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <!-- Header -->
        <div class="email-header">
            <h1>Password Reset Request</h1>
            <p>When in Baguio - Account Security</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Hello,</p>
            <p>We received a request to reset the password for the account associated with <strong>{{ $userEmail }}</strong>. Use the PIN code below to proceed with your password reset.</p>

            <!-- PIN Code -->
            <div class="pin-container">
                <span class="pin-label">Your Verification PIN</span>
                <div class="pin-code">{{ $pin }}</div>
                <span class="pin-expiry">This PIN expires in <strong>15 minutes</strong></span>
            </div>

            <p>Enter this PIN on the verification page to reset your password. The PIN is valid for <strong>15 minutes</strong> from the time this email was sent.</p>

            <!-- Security Warning -->
            <div class="warning-box">
                <strong>Security Notice:</strong> If you did not request a password reset, please ignore this email. Your account remains secure and no changes have been made.
            </div>

            <p>For your security, never share this PIN with anyone. <span class="brand-name">When in Baguio Inc.</span> staff will never ask you for your PIN or password.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} <span class="brand-name">When in Baguio Inc. - When in Baguio</span>. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>

