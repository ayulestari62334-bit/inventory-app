<?php

use Illuminate\Support\Facades\Route;
use Modules\AssetInventory\app\Http\Controllers\KategoriBarangController;

Route::prefix('kategori-barang')
    ->name('kategori.')
    ->group(function () {

        Route::get('/', [KategoriBarangController::class, 'index'])->name('index');
        Route::post('/store', [KategoriBarangController::class, 'store'])->name('store');
        Route::put('/update/{id}', [KategoriBarangController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [KategoriBarangController::class, 'destroy'])->name('destroy');

    });
