<?php

use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\RegencyController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\VillageController;
use App\Http\Controllers\Api\IslandController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('provinces', ProvinceController::class)
        ->parameter('province', 'code');

    Route::apiResource('regencies', RegencyController::class)
        ->parameter('regency', 'code');

    Route::apiResource('districts', DistrictController::class)
        ->parameter('district', 'code');

    Route::apiResource('villages', VillageController::class)
        ->parameter('village', 'code');

    Route::apiResource('islands', IslandController::class)
        ->parameter('island', 'code');
});
