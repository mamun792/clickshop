<?php

use App\Http\Controllers\Admin\Promotion\PromotionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('promotions')->name('promotions.')->group(function () {
        Route::get('/', [PromotionController::class, 'index'])->name('index');
        Route::get('/create', [PromotionController::class, 'create'])->name('create');
        Route::post('/', [PromotionController::class, 'store'])->name('store');

        Route::get('/{promotion}/edit', [PromotionController::class, 'edit'])->name('edit');
        Route::patch('/{promotion}', [PromotionController::class, 'update'])->name('update');
        Route::delete('/{promotion}', [PromotionController::class, 'destroy'])->name('destroy');

        // product add 
        Route::get('/add-product-campain', [PromotionController::class, 'addProduct'])->name('add.product.campain');
        Route::post('/add-product-campain', [PromotionController::class, 'storeProduct'])->name('store.product.campain');
        Route::get('/{edit}/edit-product-campain', [PromotionController::class, 'editProduct'])->name('edit.product.campain');
        Route::patch('/{edit}/edit-product-campain', [PromotionController::class, 'updateProduct'])->name('update.product.campain');
        Route::delete('/{edit}/edit-product-campain', [PromotionController::class, 'destroyProduct'])->name('destroy.product.campain');
    });
});