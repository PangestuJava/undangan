<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\TenantController;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('admin')->group(function () {
    Route::controller(TenantController::class)->group(function () {
        Route::get('tenant', 'index');
        Route::get('tenant/{uuid}', 'get');
        Route::post('tenant', 'store');
        Route::patch('tenant/{uuid}', 'update');
        Route::delete('tenant/{uuid}', 'destroy');
    });
});
