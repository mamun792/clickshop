<?php

use App\Http\Controllers\Admin\Coupon\CouponController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('coupons')->name('coupons.')->group(function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('/create', [CouponController::class, 'create'])->name('create');
        Route::post('/', [CouponController::class, 'store'])->name('store');
        Route::get('/{coupon}', [CouponController::class, 'show'])->name('show');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('edit');
        Route::patch('/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('destroy');
        // add product to coupon
        Route::get('/{coupon}/add-product', [CouponController::class, 'addProduct'])->name('add.product');
        Route::post('add-product', [CouponController::class, 'storeProduct'])->name('store.product');


        Route::delete('/{coupon}/delete-coupon-product', [CouponController::class, 'deleteCouponWithProduct'])->name('delete.coupon.product');

        // unique code check
        Route::post('/check-unique-code', [CouponController::class, 'checkUniqueCode'])->name('check.unique.code');
    });
});