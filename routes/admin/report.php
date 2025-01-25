<?php

use App\Http\Controllers\Admin\Report\ReportController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');

        // offical sale report
        Route::get('/official-sale-report', [ReportController::class, 'officialSaleReport'])->name('official.sale.report');
        //  Purchase Report
        Route::get('/purchase-report', [ReportController::class, 'purchaseReport'])->name('purchase.report');
        //  Stock Report
        Route::get('/stock-report', [ReportController::class, 'stockReport'])->name('stock.report');
        //  Stock Report


    });
});