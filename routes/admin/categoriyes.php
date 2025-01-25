<?php

use App\Http\Controllers\Admin\Categoryies\CategoriyesController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoriyesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriyesController::class, 'create'])->name('create');
        Route::post('/', [CategoriyesController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoriyesController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoriyesController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoriyesController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoriyesController::class, 'destroy'])->name('destroy');

        Route::post('/update-status', [CategoriyesController::class, 'updateStatus'])->name('updateStatus');
    });
});