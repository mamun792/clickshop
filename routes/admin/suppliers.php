<?php

use App\Http\Controllers\Admin\Supplier\SuppliersController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', [SuppliersController::class, 'index'])->name('index');
        Route::get('/create', [SuppliersController::class, 'create'])->name('create');
        Route::post('/', [SuppliersController::class, 'store'])->name('store');
        Route::get('/{supplier}', [SuppliersController::class, 'show'])->name('show');
        Route::get('/{supplier}/edit', [SuppliersController::class, 'edit'])->name('edit');
        Route::patch('/{supplier}', [SuppliersController::class, 'update'])->name('update');
        Route::delete('/{supplier}', [SuppliersController::class, 'destroy'])->name('destroy');
    });
});