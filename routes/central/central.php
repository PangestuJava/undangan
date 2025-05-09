<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Central\Admin\TenantController;

require __DIR__ . '/auth.php';

Route::middleware(['auth:sanctum', 'throttle:60,1'])->prefix('admin')->group(function () {
    Route::controller(TenantController::class)->group(function () {
        Route::get('tenant', 'index');
        Route::get('tenant/{id}', 'get');
        Route::post('tenant', 'store');
        Route::patch('tenant/{id}', 'update');
        Route::delete('tenant/{id}', 'destroy');
    });
});
