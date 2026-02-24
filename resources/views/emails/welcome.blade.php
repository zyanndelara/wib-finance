<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to When in Baguio Inc.</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(180deg, #436026 0%, #344d1e 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
            border-radius: 50%;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body h2 {
            color: #436026;
            margin-top: 0;
        }
        .credentials-box {
            background-color: #f8f8f8;
            border-left: 4px solid #436026;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .credentials-box p {
            margin: 10px 0;
            font-size: 14px;
        }
        .credentials-box strong {
            color: #436026;
            display: inline-block;
            width: 120px;
        }
        .password-display {
            background-color: #fff;
            padding: 10px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            color: #d9534f;
            margin-top: 5px;
            border: 1px dashed #ddd;
        }
        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }
        .warning-box p {
            margin: 5px 0;
            color: #856404;
            font-size: 14px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #436026;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
            font-weight: bold;
        }
        .button:hover {
            background-color: #344d1e;
        }
        .email-footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e0e0e0;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="data:image/png;base64,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 /Xc9dZUTmby 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" alt="When in Baguio Inc. Logo">
            <h1>Welcome to When in Baguio Inc.</h1>
        </div>
        
        <div class="email-body">
            <h2>Hello, {{ $userName }}!</h2>
            
            <p>Your account has been successfully created in the When in Baguio Inc. platform. You can now access the system using the credentials provided below.</p>
            
            <div class="credentials-box">
                <p><strong>Employee ID:</strong> {{ $employeeId }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                <p><strong>Password:</strong></p>
                <div class="password-display">{{ $password }}</div>
            </div>
            
            <div class="warning-box">
                <p><strong>⚠️ Important Security Notice:</strong></p>
                <p>• Please change your password after your first login</p>
                <p>• Do not share your password with anyone</p>
                <p>• Keep this email secure or delete it after changing your password</p>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="button">Login to Your Account</a>
            </div>
            
            <div class="divider"></div>
            
            <p style="font-size: 14px; color: #666;">
                If you have any questions or need assistance, please contact your system administrator.
            </p>
        </div>
        
        <div class="email-footer">
            <p>© {{ date('Y') }} When in Baguio Inc. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
