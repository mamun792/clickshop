<?php

use App\Http\Controllers\Admin\Cart\CartController;
use App\Http\Controllers\Admin\CustomRegister\CustomRegisterController;
use App\Http\Controllers\Admin\Pos\POSController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('pos')->name('pos.')->group(function () {
        Route::get('/pos-manage', [POSController::class, 'index'])->name('manage');

        // custom user registration
        Route::post('/custom-register', [CustomRegisterController::class, 'Customregister'])->name('custom.register');
        // add to cart
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
        // get cart items
        Route::get('/get-cart-items', [CartController::class, 'getCartItems'])->name('get.cart.items');
        // remove cart item
        Route::post('/remove-cart-item', [CartController::class, 'removeCartItem'])->name('remove.cart.item');
        // update cart item
        Route::post('/update-cart-item', [CartController::class, 'updateCartItem'])->name('update.cart.item');

        // clear cart
        Route::post('/clear-cart', [CartController::class, 'clearCart'])->name('clear.cart');
    });
});
