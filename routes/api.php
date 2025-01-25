<?php

use App\Http\Controllers\Admin\Cart\CartController;
use App\Http\Controllers\Admin\Orders\ManageOrdersController;
use App\Http\Controllers\Admin\Pos\POSController;
use App\Http\Controllers\Api\ApiProductController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Profile\ProfileController;

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('home', [HomeController::class, 'index']);
    Route::get('/product/{slug}', [ApiProductController::class, 'product'])->name('singleproduct');

    // Auth routes without JWT middleware
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    
    
    
    // cart route
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
    Route::get('/get-cart-items', [CartController::class, 'getCartItems'])->name('get.cart.items');
    Route::post('/cart/sync', [CartController::class, 'syncOrMergeCart'])->name('cart.sync');
    Route::delete('/cart/remove', [CartController::class, 'removeCartItem'])->name('cart.remove');


    //order route
    Route::get('/order-get/{user_id?}', [ManageOrdersController::class, 'yourorder'])->name('yourorder');
    // store order
    Route::post('/create-order', [ManageOrdersController::class, 'apicheckout'])->name('checkout'); 
    Route::post('/check-coupon', [ManageOrdersController::class, 'validateCoupon'])->name('coupon'); 
    // informations 
    Route::get('/informations', [POSController::class, 'apiinformations'])->name('information'); 
        // incompelete 
    Route::post('orders/incomplete', [ManageOrdersController::class, 'apiincomplete'])->name('incomplete'); 
    Route::post('orders/filter', [ManageOrdersController::class, 'apiorderfilter'])->name('apiorderfilter'); 
    
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::post('refresh', [AuthController::class, 'refresh']);

        //profile information 
        Route::post('account-setting', [AuthController::class, 'accountSetting']);
        Route::post('password-setting', [AuthController::class, 'passwordSetting']);
        Route::post('delete-account', [AuthController::class, 'deleteAccount']);

        //Address info
        Route::post('create-address', [ProfileController::class, 'createAddress'] );
        Route::get('get-addresses', [ProfileController::class, 'getAddress'] );
        Route::post('update-address', [ProfileController::class, 'updateAddress'] );
        Route::get('get-address', [ProfileController::class, 'getAddress']);
        Route::post('delete-address', [ProfileController::class, 'deleteAddress']);
    });
});
