<?php

use Illuminate\Support\Facades\Route;
use Modules\InventoryAsset\Http\Controllers\InventoryAssetController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('inventoryassets', InventoryAssetController::class)->names('inventoryasset');
});
