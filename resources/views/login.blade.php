<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - When in Baguio Inc.</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .split-container {
            display: flex;
            width: 100%;
            height: 100vh;
        }

        .left-section {
            width: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow-y: auto;
            position: relative;
        }

        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(67, 96, 38, 0.03) 0%, rgba(67, 96, 38, 0.01) 100%);
            pointer-events: none;
        }

        .right-section {
            width: 50%;
            background: #436026;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .right-section::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -150px;
            right: -150px;
            animation: pulse 4s ease-in-out infinite;
        }

        .right-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
            animation: pulse 5s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        .circle-1 {
            width: 200px;
            height: 200px;
            top: 50%;
            right: 10%;
            animation: floatSlow 6s ease-in-out infinite;
        }

        .circle-2 {
            width: 150px;
            height: 150px;
            bottom: 20%;
            right: 40%;
            animation: floatSlow 5s ease-in-out infinite 1s;
        }

        .circle-3 {
            width: 100px;
            height: 100px;
            top: 20%;
            left: 20%;
            animation: floatSlow 7s ease-in-out infinite 2s;
        }

        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0px) translateX(0px);
            }

            33% {
                transform: translateY(-20px) translateX(10px);
            }

            66% {
                transform: translateY(10px) translateX(-10px);
            }
        }

        .brand-content {
            text-align: center;
            z-index: 1;
            animation: fadeIn 1s ease-out;
        }

        .brand-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .brand-content img {
            max-width: 550px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            animation: float 3s ease-in-out infinite;
            transition: all 0.3s ease;
        }

        .brand-content img:hover {
            transform: scale(1.05);
            filter: drop-shadow(0 15px 40px rgba(0, 0, 0, 0.4));
        }

        .brand-content p {
            font-size: 18px;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: white;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            animation: slideUp 0.5s ease-out;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
            transform: translateY(-2px);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-icon {
            width: 130px;
            height: 130px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            position: relative;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: relative;
            z-index: 1;
            border-radius: 50%;

        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-header p {
            color: #666;
            font-size: 15px;
            font-weight: 400;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            display: block;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #999;
            font-size: 16px;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            color: #aaa;
            font-size: 16px;
            cursor: pointer;
            transition: color 0.2s ease;
            z-index: 2;
            pointer-events: auto;
        }

        .toggle-password:hover {
            color: #436026;
        }

        .toggle-password:active {
            color: #2d4019;
        }

        .form-control:focus~.input-icon {
            color: #436026;
            transform: scale(1.1);
        }

        .form-control {
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            padding: 14px 16px 14px 45px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            background: #fafafa;
            position: relative;
            z-index: 1;
        }

        /* Hide browser's native password reveal button */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }

        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-contacts-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
            height: 0;
            width: 0;
            margin: 0;
        }

        .form-control:focus {
            border-color: #436026;
            box-shadow: 0 0 0 4px rgba(67, 96, 38, 0.1), 0 4px 15px rgba(67, 96, 38, 0.15);
            background: white;
            outline: none;
            transform: translateY(-1px);
        }

        .form-control:focus+.input-icon {
            color: #436026;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .form-check {
            margin-bottom: 20px;
        }

        .form-check-input {
            border: 1px solid #e0e0e0;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #436026;
            border-color: #436026;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(67, 96, 38, 0.1);
            border-color: #436026;
        }

        .form-check-label {
            color: #666;
            font-size: 14px;
            margin-left: 8px;
            cursor: pointer;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #436026;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: #5a7d35;
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 24px;
            margin-top: 8px;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-login:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 96, 38, 0.5);
            background: linear-gradient(135deg, #5a7d35 0%, #436026 100%);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(67, 96, 38, 0.3);
        }

        .btn-login:disabled {
            opacity: 0.8;
            cursor: not-allowed;
            transform: none;
        }

        .btn-login .loading-dots {
            display: inline-block;
            width: 20px;
            text-align: left;
        }

        .btn-login .loading-dots .dot {
            animation: blink 1.4s infinite;
            opacity: 0;
        }

        .btn-login .loading-dots .dot:nth-child(1) {
            animation-delay: 0s;
        }

        .btn-login .loading-dots .dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .btn-login .loading-dots .dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {

            0%,
            20% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .signup-link {
            text-align: center;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #436026;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #5a7d35;
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 6px;
            border: none;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border-left: 3px solid #dc3545;
            padding: 8px 12px;
            font-size: 13px;
        }

        .alert-danger.compact {
            margin-bottom: 16px;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #436026;
            padding: 12px 16px;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
        }

        .toast-success {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(67, 96, 38, 0.18), 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 18px 22px;
            min-width: 320px;
            max-width: 380px;
            border-left: 5px solid #436026;
            opacity: 0;
            transform: translateY(60px);
            transition: opacity 0.35s ease, transform 0.35s ease;
            pointer-events: none;
        }

        .toast-success.show {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .toast-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #436026, #5a7d35);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-icon i {
            color: #fff;
            font-size: 16px;
        }

        .toast-body {
            flex: 1;
        }

        .toast-title {
            font-weight: 700;
            font-size: 14px;
            color: #1a1a1a;
            margin-bottom: 3px;
        }

        .toast-message {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        .toast-close {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 16px;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: color 0.2s;
        }

        .toast-close:hover {
            color: #436026;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(135deg, #436026, #5a7d35);
            border-radius: 0 0 0 12px;
            width: 100%;
            transform-origin: left;
            animation: toastProgress 4s linear forwards;
        }

        @keyframes toastProgress {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        .form-control.is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1), 0 4px 15px rgba(220, 53, 69, 0.15);
        }

        .input-icon.error {
            color: #dc3545;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .split-container {
                flex-direction: column;
            }

            .left-section,
            .right-section {
                width: 100%;
                height: 50vh;
            }

            .right-section {
                order: -1;
            }

            .brand-content h1 {
                font-size: 32px;
            }

            .brand-content p {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="split-container">
        <!-- Right Section - Branding -->
        <div class="right-section">
            <div class="decorative-circle circle-1"></div>
            <div class="decorative-circle circle-2"></div>
            <div class="decorative-circle circle-3"></div>
            <div class="brand-content">
                <img src="{{ asset('images/wib.png') }}" alt="When in Baguio">
            </div>
        </div>

        <!-- Left Section - Login Form -->
        <div class="left-section">
            <div class="login-container">
                <div class="login-card">
                    <!-- Logo Icon -->
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo.png') }}" alt="When in Baguio Inc. Logo">
                    </div>

                    <!-- Login Header -->
                    <div class="login-header">
                        <h1><span style="color: #436026;">WEL</span><span style="color: #ffd300;">COME!</span></h1>
                        <p>Sign in to continue</p>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login') ?? '#' }}" method="POST">
                        @csrf

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Enter your email address" value="{{ old('email') }}" required>
                                <i class="fas fa-envelope input-icon"></i>
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="input-wrapper">
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Enter your password" required style="padding-right: 45px;">
                                <i class="fas fa-lock input-icon"></i>
                                <i class="fas fa-eye toggle-password" id="togglePassword" title="Show password"></i>
                            </div>
                        </div>

                        <!-- Error Message -->
                        @if ($errors->any())
                            <div class="alert alert-danger compact" style="margin-top: -12px;">
                                <i class="fas fa-exclamation-circle"></i> Incorrect email or password. Please try again.
                            </div>
                        @endif

                        <!-- Remember Me & Forgot Password -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <div class="forgot-password">
                                <a href="{{ route('password.request') ?? '#' }}">Forgot password?</a>
                            </div>
                        </div>

                        <!-- Login Button -->
                        <button type="submit" class="btn-login" id="loginBtn">
                            <span class="btn-text">Sign In</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    @if (session('password_reset_success'))
        <!-- Toast Notification -->
        <div class="toast-container">
            <div class="toast-success" id="resetToast" style="position:relative; overflow:hidden;">
                <div class="toast-icon">
                    <i class="fas fa-check"></i>
                </div>
                <div class="toast-body">
                    <div class="toast-title">Password Reset Successful</div>
                    <div class="toast-message">Your password has been changed. You can now sign in with your new
                        password.</div>
                </div>
                <button class="toast-close" onclick="dismissToast()">
                    <i class="fas fa-times"></i>
                </button>
                <div class="toast-progress" id="toastProgress"></div>
            </div>
        </div>
    @endif

    <script>
        // Show toast on page load if present
        const toast = document.getElementById('resetToast');
        if (toast) {
            setTimeout(() => toast.classList.add('show'), 100);
            // Auto-dismiss after 4s
            setTimeout(() => dismissToast(), 4100);
        }

        function dismissToast() {
            if (toast) {
                toast.classList.remove('show');
            }
        }

        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');

                // Update tooltip text
                this.setAttribute('title', type === 'password' ? 'Show password' : 'Hide password');
            });
        }

        // Login button loading animation
        const loginForm = document.querySelector('form');
        const loginBtn = document.getElementById('loginBtn');

        if (loginForm && loginBtn) {
            loginForm.addEventListener('submit', function(e) {
                // Add loading state
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;

                // Update button text with animated dots
                const btnText = loginBtn.querySelector('.btn-text');
                btnText.innerHTML =
                    'Signing In<span class="loading-dots"><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span></span>';
            });
        }
    </script>
</body>

</html>
