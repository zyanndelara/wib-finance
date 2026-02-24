<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\RemittanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/email/verify/{id}/{hash}', [ProfileController::class, 'verifyEmail'])->name('verification.verify');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // Max 5 attempts per minute

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/check-email', [AuthController::class, 'showCheckEmailForm'])->name('password.check');
Route::post('/verify-pin', [AuthController::class, 'verifyPin'])->name('password.verifyPin');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Protected Routes (Require Authentication)
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/force-password-change', [AuthController::class, 'forcePasswordChange'])->name('force.password.change');

    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');

    Route::get('/remittance', [RiderController::class, 'index'])->name('remittance');
    Route::post('/riders', [RiderController::class, 'store'])->name('riders.store');
    Route::put('/riders/{rider}', [RiderController::class, 'update'])->name('riders.update');
    Route::delete('/riders/{rider}', [RiderController::class, 'destroy'])->name('riders.destroy');
    
    // Remittance Routes
    Route::post('/remittances', [RemittanceController::class, 'store'])->name('remittances.store');
    Route::get('/remittances', [RemittanceController::class, 'index'])->name('remittances.index');
    Route::get('/remittances/{remittance}', [RemittanceController::class, 'show'])->name('remittances.show');
    Route::put('/remittances/{remittance}', [RemittanceController::class, 'update'])->name('remittances.update');
    Route::delete('/remittances/{remittance}', [RemittanceController::class, 'destroy'])->name('remittances.destroy');

    Route::get('/bank-deposit', function () {
        return view('bank-deposit');
    })->name('bank-deposit');

    Route::get('/merchants', function () {
        return view('merchants');
    })->name('merchants');

    // Member Management Routes
    Route::get('/member-management', [UserController::class, 'index'])->name('members.index');
    Route::post('/members', [UserController::class, 'store'])->name('members.store');
    Route::put('/members/{user}', [UserController::class, 'update'])->name('members.update');
    Route::delete('/members/{user}', [UserController::class, 'destroy'])->name('members.destroy');
    Route::patch('/members/{user}/restore', [UserController::class, 'restore'])->name('members.restore');

    Route::get('/audit-logs', function () {
        return view('audit-logs');
    })->name('audit-logs');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/resend-verification', [ProfileController::class, 'resendVerification'])->name('profile.resend-verification');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/info', function() {
    return view('info');
});
