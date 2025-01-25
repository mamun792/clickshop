<?php

use App\Http\Controllers\Admin\Media\MediaController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('media')->name('media.')->group(function () {
        Route::get('/', [MediaController::class, 'index'])->name('index');

        Route::post('/', [MediaController::class, 'store'])->name('store');
    });
});