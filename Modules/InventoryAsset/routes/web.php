<?php

use Illuminate\Support\Facades\Route;
use Modules\InventoryAsset\app\Http\Controllers\JenisBarangController;

Route::prefix('jenis-barang')->name('jenis-barang.')->group(function () {
    Route::get('/', [JenisBarangController::class, 'index'])->name('index');
    Route::post('/', [JenisBarangController::class, 'store'])->name('store');
    Route::put('/{id}', [JenisBarangController::class, 'update'])->name('update');
    Route::delete('/{id}', [JenisBarangController::class, 'destroy'])->name('destroy');
});