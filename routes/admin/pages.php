<?php

use App\Http\Controllers\Admin\Pages\PagesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('pages')->name('pages.')->group(function () {
        Route::get('/privacy-policy', [PagesController::class, 'privacyPolicy'])->name('privacy.policy');
        Route::get('/terms-conditions', [PagesController::class, 'termsConditions'])->name('terms.conditions');
        Route::get('/refund-policy', [PagesController::class, 'refundPolicy'])->name('refund.policy');
        Route::get('/sales-support', [PagesController::class, 'salesSupport'])->name('sales.support');
        Route::get('/shipping-delivery', [PagesController::class, 'shippingDelivery'])->name('shipping.delivery');

        // store pages
        Route::post('/{type}', [PagesController::class, 'store'])->name('store');
    });
});