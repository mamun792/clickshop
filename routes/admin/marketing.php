<?php

use App\Http\Controllers\Admin\MarketingTool\MarketingToolController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('marketing-tools')->name('marketing-tools.')->group(function () {
        Route::get('/', [MarketingToolController::class, 'index'])->name('index');
        Route::get('/create', [MarketingToolController::class, 'create'])->name('create');
        Route::post('/', [MarketingToolController::class, 'store'])->name('store');
        Route::get('/{marketingTool}', [MarketingToolController::class, 'show'])->name('show');
        Route::get('/{marketingTool}/edit', [MarketingToolController::class, 'edit'])->name('edit');
        Route::patch('/{marketingTool}', [MarketingToolController::class, 'update'])->name('update');
        Route::delete('/{marketingTool}', [MarketingToolController::class, 'destroy'])->name('destroy');
    });
});