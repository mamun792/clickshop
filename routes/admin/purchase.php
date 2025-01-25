<?php

use App\Http\Controllers\Admin\Purchase\PurchaseController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('purchase')->name('purchase.')->group(function () {
        
        Route::get('/', [PurchaseController::class, 'index'])->name('index');
        Route::get('/create', [PurchaseController::class, 'create'])->name('create');
        Route::post('/', [PurchaseController::class, 'store'])->name('store');
        Route::get('/{purchase}', [PurchaseController::class, 'show'])->name('show');
        Route::get('/{purchase}/edit', [PurchaseController::class, 'edit'])->name('edit');
        Route::post('/{purchase}', [PurchaseController::class, 'update'])->name('update');
        Route::delete('/{purchase}', [PurchaseController::class, 'destroy'])->name('destroy');

        Route::post('/product/store', [PurchaseController::class, 'productStore'])->name('products.store');
        Route::post('/product/update', [PurchaseController::class, 'productUpdate'])->name('products.update');
        Route::delete('/product/delete', [PurchaseController::class, 'productDelete'])->name('products.delete');
    });
});
