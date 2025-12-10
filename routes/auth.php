<?php

use App\Http\Controllers\admin\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

    Route::get('signin', [AuthenticatedSessionController::class, 'index'])
        ->name('signin');

    Route::post('signin', [AuthenticatedSessionController::class, 'signin']);

});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
