<?php

use App\Http\Controllers\Admin\AccessManagement\RollPermissionController;
use App\Http\Controllers\Admin\AccessManagement\RollUserController;
use App\Http\Controllers\Admin\Api\APIController;
// use App\Http\Controllers\Admin\Api\APIController;
// use App\Http\Controllers\Admin\Attributes\AttributesController;
// use App\Http\Controllers\Admin\Blog\BlogController;
// use App\Http\Controllers\Admin\BlogCategory\BlogCategoryController;
// use App\Http\Controllers\Admin\Brand\BrandController;
// use App\Http\Controllers\Admin\Brands\BrandsController;
// use App\Http\Controllers\Admin\Cart\CartController;
// use App\Http\Controllers\Admin\Categoryies\CategoriyesController;
// use App\Http\Controllers\Admin\Comment\CommentController;
// use App\Http\Controllers\Admin\Coupon\CouponController;
 use App\Http\Controllers\Admin\CustomRegister\CustomRegisterController;
// use App\Http\Controllers\Admin\Dashboard\DashboardController;
 use App\Http\Controllers\Admin\Orders\ManageOrdersController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Models\ApiToken;


use App\Http\Controllers\NotificationController;



// use App\Http\Controllers\Admin\Sliders\SliderController;
// use App\Http\Controllers\Admin\SubCategories\SubCategoriesController;
// use App\Http\Controllers\Admin\Supplier\SuppliersController;


// use App\Http\Controllers\Admin\Inventory\InventoryController;
// use App\Http\Controllers\Admin\Manage\ManageController;
// use App\Http\Controllers\Admin\MarketingTool\MarketingToolController;
// use App\Http\Controllers\Admin\Media\MediaController;
// use App\Http\Controllers\Admin\Order\OrderController;
// use App\Http\Controllers\Admin\Pages\PagesController;
// use App\Http\Controllers\Admin\Pos\POSController;
// use App\Http\Controllers\Admin\Product\ProductController;
// use App\Http\Controllers\Admin\Profile\ProfileController;
// use App\Http\Controllers\Admin\Promotion\PromotionController;
// use App\Http\Controllers\Admin\Purchase\PurchaseController;
// use App\Http\Controllers\Admin\Report\ReportController;
// use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});



// dashboard

require __DIR__ . '/admin/dashboard.php';

Route::delete('products/gallery-image/{product}',[ProductController::class, 'deleteGalleryImage'] )->name('products.delete-gallery-image');

//access Management

Route::group(['middleware' => ['auth', 'verified'], 'prefix' => 'admin'], function () {

    Route::resource('role-user', RollUserController::class);
    // create role
    Route::post('role-user/create-role', [RollUserController::class, 'createRole'])->name('role-user.create-role');

    Route::resource('role-permission', RollPermissionController::class);
});


//Pos Manage

require __DIR__ . '/admin/pos.php';


// testing perpass
Route::middleware('auth')->get('/search-user', [CustomRegisterController::class, 'searchUser']);
// Route::get('/logged-in-user', [SearchController::class, 'getLoggedInUser']);




// Manage Incompelete Controller

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('incompelete')->name('incompelete.')->group(function () {
        Route::get('/', [ManageOrdersController::class, 'incompelete'])->name('index');
    });
    Route::prefix('duplicate')->name('duplicate.')->group(function () {
        Route::get('/', [ManageOrdersController::class, 'duplicate'])->name('index');
    });
});

// Manage Orders Controller

require __DIR__ . '/admin/orders.php';


/// Brands Controller

require __DIR__ . '/admin/brands.php';


// CouponController

require __DIR__ . '/admin/coupons.php';

//CategoriyesController

require __DIR__ . '/admin/categoriyes.php';

// SubCategoriesController

require __DIR__ . '/admin/subCategories.php';


// SuppliersController

require __DIR__ . '/admin/suppliers.php';

// SliderController

require __DIR__ . '/admin/sliders.php';


//  PromotionController

require __DIR__ . '/admin/promotions.php';


// InventoryController

require __DIR__ . '/admin/inventory.php';
// PurchaseController

require __DIR__ . '/admin/purchase.php';


//  AttributesController

require __DIR__ . '/admin/attributes.php';

// ReportController

require __DIR__ . '/admin/report.php';

// MediaController

require __DIR__ . '/admin/media.php';

//PagesController


require __DIR__ . '/admin/pages.php';


// ManageController

require __DIR__ . '/admin/manage.php';

// CommentController

require __DIR__ . '/admin/comment.php';

// MarketingToolController

require __DIR__ . '/admin/marketing.php';

require __DIR__ . '/auth.php';





Route::middleware(['auth'])->group(function () {
    Route::get('/notifications/unread', [NotificationController::class, 'fetchUnread']);
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::post('/notifications/destroylastten', [NotificationController::class, 'destroylastten'])->name('destroylastten');

});