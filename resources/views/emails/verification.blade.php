<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f6f8;
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
        }
        .header {
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            color: #fff;
            padding: 36px;
            text-align: center;
        }
        .content {
            padding: 36px;
            line-height: 1.7;
            font-size: 15px;
        }
        .button {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 22px;
            background: #436026;
            color: #fff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        .footer {
            padding: 20px 36px 32px;
            color: #888;
            font-size: 13px;
            text-align: center;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>Verify Your Email</h1>
        </div>
        <div class="content">
            <p>Hello {{ $userName }},</p>
            <p>Please verify your email address to complete your account setup.</p>
            <p>
                <a class="button" href="{{ $verificationUrl }}">Verify Email Address</a>
            </p>
            <p>If the button does not work, copy and paste this link into your browser:</p>
            <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
        </div>
        <div class="footer">
            <p>This is an automated message, please do not reply.</p>
        </div>
    </div>
</body>
</html>
