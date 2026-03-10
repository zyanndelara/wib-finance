<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify PIN - When in Baguio Inc.</title>
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

        .verify-container {
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 1;
        }

        .verify-card {
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

        .pin-icon {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, rgba(67, 96, 38, 0.1) 0%, rgba(90, 125, 53, 0.05) 100%);
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.1);
        }

        .pin-icon i {
            font-size: 48px;
            color: #436026;
        }

        .verify-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .verify-header h1 {
            color: #1a1a1a;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .verify-header p {
            color: #666;
            font-size: 15px;
            font-weight: 400;
            line-height: 1.6;
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
            text-align: center;
        }

        .pin-input-wrapper {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .pin-box {
            width: 55px;
            height: 55px;
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .pin-box:focus {
            border-color: #436026;
            box-shadow: 0 0 0 4px rgba(67, 96, 38, 0.1);
            background: white;
            outline: none;
        }

        .btn-verify {
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
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(67, 96, 38, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-verify:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(67, 96, 38, 0.4);
            background: linear-gradient(135deg, #5a7d35 0%, #436026 100%);
        }

        .btn-verify:active {
            transform: translateY(0);
        }

        .btn-verify i {
            margin-right: 8px;
        }

        .resend-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .resend-section p {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .btn-resend {
            background: none;
            border: none;
            color: #436026;
            font-weight: 700;
            cursor: pointer;
            text-decoration: underline;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .btn-resend:hover {
            color: #5a7d35;
        }

        .btn-resend:disabled {
            color: #999;
            cursor: not-allowed;
            text-decoration: none;
        }

        .countdown-timer {
            color: #436026;
            font-weight: 700;
            font-size: 14px;
        }

        .back-link {
            position: absolute;
            top: 20px;
            left: 20px;
            color: #666;
            font-size: 14px;
            z-index: 10;
        }

        .back-link a {
            color: #436026;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .back-link a:hover {
            color: #5a7d35;
            background: #e9ecef;
            transform: translateX(-2px);
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
            text-align: center;
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

            .pin-box {
                width: 45px;
                height: 45px;
                font-size: 20px;
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
                <p>Secure password recovery to keep your account safe and accessible.</p>
            </div>
        </div>

        <!-- Left Section - PIN Verification -->
        <div class="left-section">
            <div class="verify-container">
                <div class="verify-card">
                    <!-- Back Link -->
                    <div class="back-link">
                        <a href="{{ route('password.request') }}">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                    
                    <!-- PIN Icon -->
                    <div class="pin-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>

                    <!-- Verify PIN Header -->
                    <div class="verify-header">
                        <h1>Verify PIN Code</h1>
                        <p>Enter the 6-digit PIN code sent to <strong>{{ session('email') ?? 'your email' }}</strong></p>
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

                    <!-- PIN Verification Form -->
                    <form action="{{ route('password.verifyPin') }}" method="POST" id="pinForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">

                        <!-- PIN Input -->
                        <div class="form-group">
                            <label for="pin">Enter PIN Code</label>
                            <div class="pin-input-wrapper">
                                <input type="text" class="pin-box" maxlength="1" name="pin1" id="pin1">
                                <input type="text" class="pin-box" maxlength="1" name="pin2" id="pin2">
                                <input type="text" class="pin-box" maxlength="1" name="pin3" id="pin3">
                                <input type="text" class="pin-box" maxlength="1" name="pin4" id="pin4">
                                <input type="text" class="pin-box" maxlength="1" name="pin5" id="pin5">
                                <input type="text" class="pin-box" maxlength="1" name="pin6" id="pin6">
                            </div>
                            @error('pin')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Verify Button -->
                        <button type="submit" class="btn-verify">
                            <i class="fas fa-check-circle"></i> Verify PIN
                        </button>
                    </form>

                    <!-- Resend Section -->
                    <div class="resend-section">
                        <p>Didn't receive the code?</p>
                        <form action="{{ route('password.email') }}" method="POST" style="display: inline;" id="resendForm">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <button type="submit" class="btn-resend" id="resendBtn" disabled>
                                <i class="fas fa-redo"></i> Resend PIN <span class="countdown-timer" id="countdown">(59s)</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Stepper Indicator -->
                    <div class="stepper-container">
                        <div class="stepper">
                            <div class="stepper-progress" style="width: 50%;"></div>
                            
                            <div class="stepper-step completed">
                                <div class="step-circle">
                                    <i class="fas fa-check"></i>
                                </div>
                                <span class="step-label">Enter Email</span>
                            </div>
                            
                            <div class="stepper-step active">
                                <div class="step-circle">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <span class="step-label">Verify PIN</span>
                            </div>
                            
                            <div class="stepper-step">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus and auto-advance PIN inputs
        document.addEventListener('DOMContentLoaded', function() {
            const pinInputs = document.querySelectorAll('.pin-box');
            
            pinInputs.forEach((input, index) => {
                // Only allow numbers
                input.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    
                    // Auto-advance to next input
                    if (this.value.length === 1 && index < pinInputs.length - 1) {
                        pinInputs[index + 1].focus();
                    }
                });
                
                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && this.value === '' && index > 0) {
                        pinInputs[index - 1].focus();
                    }
                });
                
                // Handle paste
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                    
                    for (let i = 0; i < pastedData.length && index + i < pinInputs.length; i++) {
                        pinInputs[index + i].value = pastedData[i];
                    }
                    
                    // Focus on the next empty input or the last input
                    const nextEmptyIndex = index + pastedData.length;
                    if (nextEmptyIndex < pinInputs.length) {
                        pinInputs[nextEmptyIndex].focus();
                    } else {
                        pinInputs[pinInputs.length - 1].focus();
                    }
                });
            });
            
            // Focus first input on load
            pinInputs[0].focus();
        });

        // Countdown timer for resend button
        let countdown = 59;
        const resendBtn = document.getElementById('resendBtn');
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(function() {
            countdown--;
            countdownElement.textContent = '(' + countdown + 's)';
            
            if (countdown <= 0) {
                clearInterval(timer);
                resendBtn.disabled = false;
                countdownElement.textContent = '';
            }
        }, 1000);

        // Reset countdown when resend button is clicked
        document.getElementById('resendForm').addEventListener('submit', function() {
            countdown = 59;
            resendBtn.disabled = true;
            countdownElement.textContent = '(59s)';
        });
    </script>
</body>
</html>
