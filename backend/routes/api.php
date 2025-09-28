<?php

use App\Http\Controllers\SkinSettingsController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('skin-settings')->group(function () {
        Route::get('/', [SkinSettingsController::class, 'index']);
        Route::get('/all', [SkinSettingsController::class, 'list']);
    });
});
