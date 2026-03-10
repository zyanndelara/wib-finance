<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - When in Baguio Inc.</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
        }

        .brand-content {
            text-align: center;
            z-index: 1;
            animation: fadeIn 1s ease-out;
        }

        .brand-content img {
            max-width: 280px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .brand-content p {
            font-size: 18px;
            opacity: 0.9;
            line-height: 1.6;
            max-width: 400px;
            margin: 0 auto;
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

        .reset-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
        }

        .reset-card {
            background: white;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 5px 30px rgba(0, 0, 0, 0.08);
            animation: slideUp 0.5s ease-out;
            position: relative;
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
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, rgba(67, 96, 38, 0.1) 0%, rgba(90, 125, 53, 0.05) 100%);
            border-radius: 50%;
        }

        .logo-icon i {
            font-size: 36px;
            color: #436026;
        }

        .reset-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .reset-header h1 {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .reset-header p {
            color: #666;
            font-size: 15px;
            font-weight: 400;
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
            transition: color 0.3s ease;
        }

        .form-control {
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            padding: 14px 16px 14px 45px;
            font-size: 15px;
            transition: all 0.3s ease;
            width: 100%;
            background: #fafafa;
        }

        .form-control:focus {
            border-color: #436026;
            box-shadow: 0 0 0 4px rgba(67, 96, 38, 0.1);
            background: white;
            outline: none;
        }

        .form-control:focus + .input-icon {
            color: #436026;
        }

        .form-control::placeholder {
            color: #aaa;
        }

        .btn-submit {
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
            margin-bottom: 0;
            margin-top: 8px;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 96, 38, 0.4);
            background: linear-gradient(135deg, #5a7d35 0%, #436026 100%);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(67, 96, 38, 0.3);
        }

        .alert {
            margin-bottom: 20px;
            border-radius: 6px;
            border: none;
        }

        .alert-danger {
            background-color: #fee;
            color: #c33;
            border-left: 4px solid #dc3545;
            padding: 12px 16px;
        }

        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #436026;
            padding: 12px 16px;
        }

        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            background: #e8e8e8;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { 
            width: 33%; 
            background: #dc3545; 
        }

        .strength-medium { 
            width: 66%; 
            background: #ffc107; 
        }

        .strength-strong { 
            width: 100%; 
            background: #436026; 
        }

        /* Success Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
        }

        .success-modal {
            background: white;
            border-radius: 16px;
            padding: 40px;
            max-width: 450px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: slideUp 0.4s ease;
            position: relative;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: scaleIn 0.5s ease;
        }

        .success-icon i {
            font-size: 40px;
            color: white;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-modal h2 {
            color: #1a1a1a;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .success-modal p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .modal-btn {
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
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .modal-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 96, 38, 0.4);
            background: linear-gradient(135deg, #5a7d35 0%, #436026 100%);
        }

        .modal-btn:active {
            transform: translateY(0);
        }

        /* Stepper Indicator Styles */
        .stepper-container {
            margin-top: 40px;
            padding: 0 20px;
        }

        .stepper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 10px;
        }

        .stepper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 3px;
            background: #e8e8e8;
            z-index: 0;
        }

        .stepper-progress {
            position: absolute;
            top: 20px;
            left: 0;
            height: 3px;
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            transition: width 0.3s ease;
            z-index: 1;
        }

        .stepper-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .stepper-step:first-child {
            align-items: flex-start;
        }

        .stepper-step:last-child {
            align-items: flex-end;
        }

        .step-circle {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e8e8e8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #999;
            transition: all 0.3s ease;
            margin-bottom: 8px;
        }

        .step-circle i {
            font-size: 18px;
        }

        .stepper-step.active .step-circle {
            border-color: #436026;
            background: linear-gradient(135deg, #436026 0%, #5a7d35 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            transform: scale(1.1);
        }

        .stepper-step.completed .step-circle {
            border-color: #436026;
            background: #436026;
            color: white;
        }

        .step-label {
            font-size: 13px;
            color: #999;
            font-weight: 600;
            text-align: center;
            transition: color 0.3s ease;
            white-space: nowrap;
        }

        .stepper-step.active .step-label {
            color: #436026;
        }

        .stepper-step.completed .step-label {
            color: #666;
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

            .brand-content img {
                max-width: 200px;
            }

            .stepper-container {
                padding: 0 10px;
            }

            .step-label {
                font-size: 11px;
            }

            .step-circle {
                width: 36px;
                height: 36px;
            }

            .step-circle i {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="split-container">
        <!-- Right Section - Branding -->
        <div class="right-section">
            <div class="brand-content">
                <img src="{{ asset('images/wib.png') }}" alt="When in Baguio">
                <p>Create a strong password to secure your account.</p>
            </div>
        </div>

        <!-- Left Section - Reset Password Form -->
        <div class="left-section">
            <div class="reset-container">
                <div class="reset-card">
                    <!-- Back to Login Link -->
                   
                    
                    <!-- Logo Icon -->
                    <div class="logo-icon">
                        <i class="fas fa-key"></i>
                    </div>

                    <!-- Reset Password Header -->
                    <div class="reset-header">
                        <h1>Reset Password</h1>
                        <p>Enter your new password below</p>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Error!</strong>
                            <ul class="mb-0 mt-2" style="list-style: none; padding-left: 0;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <!-- Reset Password Form -->
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ old('email', $email ?? '') }}">

                        <!-- New Password Field -->
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <div class="input-wrapper">
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    placeholder="Enter your new password"
                                >
                                <i class="fas fa-lock input-icon"></i>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <small id="strengthText" style="color: #999;">Password strength</small>
                            </div>
                            @error('password')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <div class="input-wrapper">
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    placeholder="Confirm your new password"
                                >
                                <i class="fas fa-lock input-icon"></i>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit">Reset Password</button>
                    </form>
                    
                    <!-- Stepper Indicator -->
                    <div class="stepper-container">
                        <div class="stepper">
                            <div class="stepper-progress" style="width: 100%;"></div>
                            
                            <div class="stepper-step completed">
                                <div class="step-circle">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="step-label">Enter Email</span>
                            </div>
                            
                            <div class="stepper-step completed">
                                <div class="step-circle">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="step-label">Verify PIN</span>
                            </div>
                            
                            <div class="stepper-step active">
                                <div class="step-circle">
                                    <i class="fas fa-key"></i>
                                </div>
                                <span class="step-label">Reset Password</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            <h2>Successful!</h2>
            <p>Your password has been changed successfully. You can now login with your new password.</p>
            <button class="modal-btn" onclick="redirectToLogin()">Continue to Login</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check if password was reset successfully
        @if(session('password_reset_success'))
            // Show success modal
            document.getElementById('successModal').classList.add('show');
        @endif

        // Redirect to login
        function redirectToLogin() {
            window.location.href = "{{ route('login') }}";
        }

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]+/)) strength++;
            if (password.match(/[A-Z]+/)) strength++;
            if (password.match(/[0-9]+/)) strength++;
            if (password.match(/[$@#&!]+/)) strength++;

            strengthFill.className = 'strength-fill';
            
            if (password.length === 0) {
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Password strength';
                strengthText.style.color = '#999';
            } else if (strength <= 2) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Weak password';
                strengthText.style.color = '#dc3545';
            } else if (strength <= 4) {
                strengthFill.classList.add('strength-medium');
                strengthText.textContent = 'Medium password';
                strengthText.style.color = '#ffc107';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Strong password';
                strengthText.style.color = '#436026';
            }
        });
    </script>
</body>
</html>
