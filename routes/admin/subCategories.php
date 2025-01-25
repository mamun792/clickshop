<?php

use App\Http\Controllers\Admin\SubCategories\SubCategoriesController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('subcategories')->name('subcategories.')->group(function () {
        Route::get('/', [SubCategoriesController::class, 'index'])->name('index');
        Route::get('/create', [SubCategoriesController::class, 'create'])->name('create');
        Route::post('/', [SubCategoriesController::class, 'store'])->name('store');
        Route::get('/{subcategory}', [SubCategoriesController::class, 'show'])->name('show');
        Route::get('/{subcategory}/edit', [SubCategoriesController::class, 'edit'])->name('edit');
        Route::patch('/{subcategory}', [SubCategoriesController::class, 'update'])->name('update');
        Route::delete('/{subcategory}', [SubCategoriesController::class, 'destroy'])->name('destroy');

        Route::post('/update-status', [SubCategoriesController::class, 'updateStatus'])->name('updateStatus');
    });
});