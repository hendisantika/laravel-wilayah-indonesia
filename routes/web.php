<?php

use App\Http\Controllers\WilayahController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WilayahController::class, 'index'])->name('home');

Route::prefix('wilayah')->name('wilayah.')->group(function () {
    Route::get('/provinces/{code}', [WilayahController::class, 'province'])->name('province');
    Route::get('/regencies/{code}', [WilayahController::class, 'regency'])->name('regency');
    Route::get('/districts/{code}', [WilayahController::class, 'district'])->name('district');
    Route::get('/villages/{code}', [WilayahController::class, 'village'])->name('village');
    Route::get('/islands', [WilayahController::class, 'islands'])->name('islands');
});
