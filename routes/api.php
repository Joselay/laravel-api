<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\OtpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/users', UserController::class);

Route::post('/otp', [OtpController::class, 'sendOtp']);
Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
