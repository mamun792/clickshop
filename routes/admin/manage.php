<?php

use App\Http\Controllers\Admin\Manage\ManageController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('manage')->name('manage.')->group(function () {
        Route::get('/', [ManageController::class, 'index'])->name('index');
        Route::match(['post', 'put'], '/store-or-update', [ManageController::class, 'storeOrUpdateSite'])->name('storeOrUpdate');
        // smtp setting
        Route::get('/smtp-setting', [ManageController::class, 'smtpSetting'])->name('smtpSetting');
        Route::match(['post', 'put'], '/store-or-update-smtp', [ManageController::class, 'storeOrUpdateSmtp'])->name('storeOrUpdateSmtp');

        Route::get('/contact-page', [ManageController::class, 'contactPage'])->name('contact.page');
        Route::get('/social-media-links', [ManageController::class, 'socialMediaLinks'])->name('social.media.links');
    });
});
;