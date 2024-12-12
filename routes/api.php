<?php

use App\Http\Controllers\Api\V1\GmailController;
use App\Http\Controllers\Api\V1\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/send-email', [GmailController::class, 'sendEmail']);
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/complete-registration', [RegisterController::class, 'completeRegistration']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');
});
