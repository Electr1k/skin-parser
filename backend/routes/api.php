<?php

use App\Http\Controllers\LotsController;
use App\Http\Controllers\SkinSettingsController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::prefix('skin-settings')->group(function () {
        Route::get('/', [SkinSettingsController::class, 'index']);
        Route::get('/all', [SkinSettingsController::class, 'list']);

        Route::get('/find-skins', [SkinSettingsController::class, 'findSkins']);
        Route::post('/', [SkinSettingsController::class, 'store']);
        Route::put('/{skin_settings}', [SkinSettingsController::class, 'update']);
    });
    Route::prefix('lots')->group(function () {
        Route::get('/', [LotsController::class, 'index']);
    });
});
