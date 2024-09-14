<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ForgotPasswordController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// When we use middleware of api we don't add prefix in api
Route::middleware(['api'])->group(function () {
    Route::post('api', function () {
        return 'welcome';
    });
    Route::post('user-register', [RegisterController::class, 'register']);
    Route::post('user-login', [LoginController::class, 'login']);
    Route::get('user-logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('user-details', [AuthController::class, 'details'])->middleware('auth:sanctum');
    Route::post('send-otp', [ForgotPasswordController::class, 'sendOtp']);
    Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
    Route::post('update-password', [ForgotPasswordController::class, 'updatePassword']);
});
