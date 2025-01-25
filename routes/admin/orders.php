<?php

use App\Http\Controllers\Admin\Api\APIController;
use App\Http\Controllers\Admin\Orders\ManageOrdersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('orders')->name('orders.')->group(function () {

        Route::get('/', [ManageOrdersController::class, 'index'])->name('index');


        // Route::get('/checkout', [ManageOrdersController::class, 'checkout'])->name('checkout');

        Route::post('/checkout', [ManageOrdersController::class, 'checkout'])->name('checkout');

        Route::get('/order-reports', [ManageOrdersController::class, 'orderReports'])->name('reports');
        // view invoice
        Route::get('/{order}/invoice', [ManageOrdersController::class, 'invoice'])->name('invoice');

        Route::get('/{order}/invoice', [ManageOrdersController::class, 'show'])->name('show');

        Route::post('/comment', [ManageOrdersController::class, 'orderComment'])->name('orderComment');
        Route::post('/ordernote', [ManageOrdersController::class, 'ordernote'])->name('ordernote');
        Route::post('/order/comment/add', [ManageOrdersController::class, 'ordercommentadd'])->name('ordercommentadd');

// Add this route for the AJAX request
Route::post('updatestatus', [ManageOrdersController::class, 'updateStatus'])->name('updateStatus');

        Route::get('/order-status/{order_id}/{status}', [ManageOrdersController::class, 'orderStatus'])->name('orderStatus');

        Route::get('/delete/{id}', [ManageOrdersController::class, 'delete'])->name('delete');

        Route::get('/filter', [ManageOrdersController::class, 'orderFilter'])->name('filter');

        Route::post('/bulk-order', [ManageOrdersController::class, 'bulkProcess'])->name('bulkOrder');
        Route::get('/bulk-order-view', [ManageOrdersController::class, 'bulkOrderView'])->name('bulkOrderView');

        //bulk invoice
        Route::post('/generate-pdf', [ManageOrdersController::class, 'generatePDF'])->name('generate.pdf');

        //bulk csv steadfast

        Route::post('/bulk-csv-steadfast', [ManageOrdersController::class, 'bulkCSVProcessSteadfast']);
        Route::get('/bulk-csv-view-steadfast', [ManageOrdersController::class, 'bulkCSVViewSteadfast'])->name('bulkCSVViewSteadfast');

        //bulk csv pathao
        Route::post('/bulk-csv-pathao', [ManageOrdersController::class, 'bulkCSVProcessPathao']);
        Route::get('/bulk-csv-view-pathao', [ManageOrdersController::class, 'bulkCSVViewPathao'])->name('bulkCSVViewPathao');


        //bulk status update
        Route::post('/bulk-status-update', [ManageOrdersController::class, 'bulkStatusUpdate']);

        //bulk delete

        Route::post('/bulk-delete', [ManageOrdersController::class, 'bulkDelete']);

        //order edit

        Route::get('/edit/{id}', [ManageOrdersController::class, 'edit'])->name('edit');
        Route::get('/get-zones/{city_id}', [ManageOrdersController::class, 'getZones']);
        Route::get('/get-areas', [ManageOrdersController::class, 'getAreas']);
        Route::post('/order-info-update', [ManageOrdersController::class, 'orderInfoUpdate'])->name('orderInfoUpdate');

        //update

        Route::post('/update', [ManageOrdersController::class,  'update'])->name('update');
        //item Delete

        Route::delete('/delete-item', [ManageOrdersController::class,  'deleteitem'])->name('deleteitem');

        //Manage Steadfast Couriar
        Route::get('/send-steadfast/{id}', [APIController::class, 'sendSteadfast'])->name('steadfast');
        Route::post('/bulkSteadfast', [ApiController::class, 'bulkSendSteadfast'])->name('bulkSteadfast');

        //Manage REDX Couriar
        Route::get('/send-redx/{id}', [APIController::class, 'sendRedx'])->name('redx');
        // get area
        Route::get('/get-area', [APIController::class, 'getArea'])->name('getArea');
        // get city
        Route::get('/get-city', [APIController::class, 'getCity'])->name('getCity');
        // create order
        Route::post('/create-parcel', [APIController::class, 'createParcel'])->name('createParcel');
      

        //Bulk send redx
        Route::post('/bulkredx', [APIController::class, 'sendBulkRedx'])->name('sendBulkRedx');

        //Send Pathao
        Route::get('/send-pathao/{id}', [APIController::class, 'sendPathao'])->name('pathao');

        //Bulk send pathao
        Route::post('/send-to-pathao', [APIController::class, 'sendBulkPathao'])->name('sendBulkPathao');

        // order now button
        Route::Post('/order-now', [ManageOrdersController::class, 'orderNow'])->name('orderNow');


    });
});
