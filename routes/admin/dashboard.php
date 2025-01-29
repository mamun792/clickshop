<?php

use App\Http\Controllers\Admin\Api\APIController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\BlogCategory\BlogCategoryController;
use App\Http\Controllers\Admin\Dashboard\DashboardController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Profile\ProfileController;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:Dashboard');

  //All available user
  Route::get('/user', [ProfileController::class, 'users'])->name('users');

  //Profile Setting
  Route::get('/profile-setting', [ProfileController::class, 'profileSetting'])->name('profileSetting');
  Route::post('/profile-update', [ProfileController::class, 'profileUpdate'])->name('profileUpdate');
  Route::post('/password-update', [ProfileController::class, 'passwordUpdate'])->name('passwordUpdate');



  //Product Manage
  // Route::resource('products', ProductController::class);

  Route::get('products', [ProductController::class, 'index'])
      ->name('products.index')
      ->middleware('permission:AllProduct');

  Route::get('products/create', [ProductController::class, 'create'])
      ->name('products.create')->middleware('permission:AddProduct');

  Route::post('products', [ProductController::class, 'store'])
      ->name('products.store')->middleware('permission:AddProduct');;

  Route::get('products/{product}', [ProductController::class, 'show'])
      ->name('products.show');


  Route::get('products/{product}/edit', [ProductController::class, 'edit'])
      ->name('products.edit');


  Route::put('products/{product}', [ProductController::class, 'update'])
      ->name('products.update');


  Route::delete('products/{product}', [ProductController::class, 'destroy'])
      ->name('products.destroy');




  //End

  Route::patch('/products/update-free-shipping/{productId}', [ProductController::class, 'updateFreeShipping'])->name('update.free.shipping');


  //ajax dynamic dependent subcategory
  Route::get('/get-subcategories/{category_id}', [ProductController::class, 'getSubcategories']);

  //ajax toggle status
  Route::patch('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');
  //Ajax Toggle Feature
  Route::patch('/products/{product}/toggle-feature', [ProductController::class, 'toggleFeature']);

  //Ajax request for grab purchase based data
  Route::get('/get-purchase-data/{product_code}', [ProductController::class, 'getPurchaseData']);

  //filter product
  Route::get('/filter-products', [ProductController::class, 'filter'])->name('filter.products');

  //Bulk delete ajax request

  Route::post('/products/bulk-delete', [ProductController::class, 'bulkDelete']);

  //Bulk publish ans Unpublish

  Route::post('/products/bulk-publish', [ProductController::class, 'bulkPublish'])->name('products.bulk.publish');
  Route::post('/products/bulk-unpublish', [ProductController::class, 'bulkUnpublish'])->name('products.bulk.unpublish');


  //Manage Blog
  Route::resource('blogs', BlogController::class);

  //Manage Blog Category

  Route::resource('blog-category', BlogCategoryController::class);

  //blog category toggle status

  Route::post('/blog-category/toggle-status', [BlogCategoryController::class, 'toggleStatus'])->name('blog-category.toggle-status');



  //Manage API
  Route::get('/couriar-api', [APIController::class, 'index'])->name('couriarApi');
  Route::post('/couriar-api', [APIController::class, 'storeOrUpdateCourier'])->name('couriarApi.store');
  Route::patch('/couriar-api/{couriar}', [APIController::class, 'update'])->name('couriarApi.update');

//    // Api Token Generate
//     Route::get('/api-token', [APIController::class, 'apiToken'])->name('apiToken');
    Route::post('/api-token', [APIController::class, 'generateApiToken'])->name('generateApiToken');

  Route::get('/payment-api', [APIController::class, 'paymentApi'])->name('paymentApi');

  // analytics dashboard
  Route::get('/analytics', [DashboardController::class, 'analytics'])
  ->name('admin.analytics')
  ->middleware('permission:AnalyticsDashboard');
});
