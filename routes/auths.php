<?php


use App\Http\Controllers\user\AuthController;
use Illuminate\Support\Facades\Route;

//user auth routes

    Route::post('login', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('register', [AuthController::class, 'registerForm'])->name('register');
    Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('forgot-password', [AuthController::class, 'ForgotPasswordSendEmail'])->name('forgot.password.sent.email');
    Route::get('verify-reset-code', [AuthController::class, 'passwordVerify'])->name('password.verify');
    Route::post('reset-password', [AuthController::class, 'ResetPassword'])->name('reset.password');

