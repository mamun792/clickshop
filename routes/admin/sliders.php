<?php

use App\Http\Controllers\Admin\Sliders\SliderController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('sliders')->name('sliders.')->group(function () {

        // banner slider
        Route::get('/banner', [SliderController::class, 'Banner'])->name('banner');
        Route::get('/banner/create', [SliderController::class, 'createBanner'])->name('banner.create');
        Route::post('/banner', [SliderController::class, 'storeBanner'])->name('banner.store');
        Route::get('/banner/{slider}/edit', [SliderController::class, 'editBanner'])->name('banner.edit');
        Route::patch('/banner/{slider}', [SliderController::class, 'updateBanner'])->name('banner.update');
        Route::delete('/banner/{slider}', [SliderController::class, 'destroyBanner'])->name('banner.destroy');
    });
});
