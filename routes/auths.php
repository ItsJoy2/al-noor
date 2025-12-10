<?php


use App\Http\Controllers\user\AuthController;
use Illuminate\Support\Facades\Route;

//user auth routes

    Route::post('login', [AuthController::class, 'login']);
    Route::get('login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('register', [AuthController::class, 'registerForm'])->name('register');

