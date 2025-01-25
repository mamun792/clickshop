<?php

use App\Http\Controllers\Admin\Attributes\AttributesController;
use App\Http\Controllers\Admin\SubCategories\SubCategoriesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('attributes')->name('attributes.')->group(function () {
        Route::get('/', [AttributesController::class, 'index'])->name('index');
        Route::get('/create', [AttributesController::class, 'create'])->name('create');
        Route::post('/', [AttributesController::class, 'store'])->name('store');
        Route::patch('/{attribute}', [SubCategoriesController::class, 'update'])->name('update');


        Route::get('/{attribute}/add/option', [AttributesController::class, 'addOption'])->name('add.option');
        Route::post('/{attribute}/add/option', [AttributesController::class, 'storeOption'])->name('store.option');
        Route::get('/{attribute}/option/edit', [AttributesController::class, 'editOption'])->name('edit.option');
        Route::patch('/{attribute}/option', [AttributesController::class, 'updateOption'])->name('update.option');
        Route::delete('/{attribute}/option', [AttributesController::class, 'destroyOption'])->name('destroy.option');


        Route::get('/{attribute}/edit', [AttributesController::class, 'edit'])->name('edit');
        Route::patch('/{attribute}', [AttributesController::class, 'update'])->name('update');
        Route::delete('/{attribute}', [AttributesController::class, 'destroy'])->name('destroy');
    });
});