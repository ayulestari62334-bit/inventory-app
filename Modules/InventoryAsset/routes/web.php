<?php

use Illuminate\Support\Facades\Route;
use Modules\InventoryAsset\app\Http\Controllers\InventoryAssetController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('inventoryassets', InventoryAssetController::class)->names('inventoryasset');
});
