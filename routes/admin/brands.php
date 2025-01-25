<?php


use App\Http\Controllers\Admin\Brands\BrandsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('brands')->name('brands.')->group(function () {
        Route::get('/', [BrandsController::class, 'index'])->name('index');
        Route::get('/create', [BrandsController::class, 'create'])->name('create');
        Route::post('/', [BrandsController::class, 'store'])->name('store');
        Route::get('/{brand}', [BrandsController::class, 'show'])->name('show');
        Route::get('/{brand}/edit', [BrandsController::class, 'edit'])->name('edit');
        Route::patch('/{brand}', [BrandsController::class, 'update'])->name('update');
        Route::delete('/{brand}', [BrandsController::class, 'destroy'])->name('destroy');
    });
});