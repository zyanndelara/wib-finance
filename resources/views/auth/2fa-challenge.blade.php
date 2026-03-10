<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - When in Baguio Inc.</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #2d4016 0%, #3a5220 50%, #2d4016 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: contain;
            margin-bottom: 16px;
        }

        .card h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .card p.subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 28px;
            line-height: 1.5;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, #436026, #5a7d33);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .icon-circle i {
            font-size: 28px;
            color: white;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #444;
            margin-bottom: 8px;
        }

        .code-input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 10px;
            text-align: center;
            transition: border-color 0.3s;
            font-family: monospace;
        }

        .code-input:focus {
            outline: none;
            border-color: #436026;
        }

        .code-input.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-verify {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #436026, #5a7d33);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-verify:hover {
            background: linear-gradient(135deg, #5a7d33, #6b9440);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(67, 96, 38, 0.35);
        }

        .back-link {
            display: block;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover { color: #436026; }
        .back-link i { margin-right: 5px; }

        .hint {
            background: #f0f7e6;
            border-left: 4px solid #436026;
            border-radius: 4px;
            padding: 12px 14px;
            margin-bottom: 22px;
            text-align: left;
            font-size: 13px;
            color: #3a5220;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('images/logowhite.png') }}" alt="Logo" class="logo" onerror="this.style.display='none'">

        <div class="icon-circle">
            <i class="fas fa-shield-alt"></i>
        </div>

        <h2>Two-Factor Authentication</h2>
        <p class="subtitle">Enter the 6-digit code from your authenticator app to continue.</p>

        <div class="hint">
            <i class="fas fa-info-circle"></i>
            Open your authenticator app (e.g. Google Authenticator or Authy) and enter the current code for <strong>When in Baguio Inc.</strong>
        </div>

        @if ($errors->has('code'))
            <div class="invalid-feedback" style="text-align:left; margin-bottom: 12px;">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first('code') }}
            </div>
        @endif

        <form action="{{ route('2fa.verify') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Authentication Code</label>
                <input
                    type="text"
                    id="code"
                    name="code"
                    class="code-input {{ $errors->has('code') ? 'is-invalid' : '' }}"
                    maxlength="6"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    autocomplete="one-time-code"
                    autofocus
                    placeholder="000000"
                >
            </div>

            <button type="submit" class="btn-verify">
                <i class="fas fa-check-circle"></i> Verify & Sign In
            </button>
        </form>

        <a href="{{ route('login') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Login
        </a>
    </div>

    <script>
        // Auto-submit when 6 digits are entered
        document.getElementById('code').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 6);
            if (this.value.length === 6) {
                this.closest('form').submit();
            }
        });
    </script>
</body>
</html>
