<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\user\DepositController;



Route::post('deposit-check', [DepositController::class, 'webHook']);


