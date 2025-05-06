<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\Auth\AuthenticatedSessionController;

Route::middleware('guest')->prefix('public')->group(function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(['throttle:5,1']);

    // Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware(['throttle:5,1']);

    // Route::post('/reset-password', [NewPasswordController::class, 'store'])->middleware(['throttle:5,1']);
});

Route::middleware(['auth:sanctum'])->prefix('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:5,1']);;

    // Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)->middleware(['signed']);

    Route::get('/check', [AuthenticatedSessionController::class, 'authCheck']);

    Route::post('/check/refresh', [AuthenticatedSessionController::class, 'refreshToken']);
});
