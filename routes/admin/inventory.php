<?php

use App\Http\Controllers\Admin\Inventory\InventoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');

        Route::get('/stock-out-products', [InventoryController::class, 'stockOutProducts'])->name('stock.out.products');

        Route::get('/upcomming-stock-out-products', [InventoryController::class, 'upcommingStockOutProducts'])->name('upcomming.stock.out.products');
    });
});
