<?php

// add-account-type


use App\Http\Controllers\Admin\Account\AccountController;

use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('account')->name('account.')->group(function () {
      //add-account-type
        Route::get('/', [AccountController::class, 'index'])->name('add-account-type');

        Route::post('/', [AccountController::class, 'store'])->name('store');

        Route::get('/{accountType}/edit', [AccountController::class, 'edit'])->name('edit');

        Route::patch('/{accountType}', [AccountController::class, 'update'])->name('update');

        Route::delete('/{accountType}', [AccountController::class, 'destroy'])->name('destroy');

        // accountPurpose
        Route::get('/accountPurpose', [AccountController::class, 'accountPurpose'])->name('accountPurpose');

        Route::get('/add-purpose', [AccountController::class, 'addPurpose'])->name('addPurpose');

        // add-purpose
        Route::post('/accountPurpose', [AccountController::class, 'storePurpose'])->name('storePurpose');


        Route::get('/accountPurpose/{purpose}/edit', [AccountController::class, 'editPurpose'])->name('editPurpose');

        Route::patch('/accountPurpose/{purpose}', [AccountController::class, 'updatePurpose'])->name('updatePurpose');

        Route::delete('/accountPurpose/{purpose}', [AccountController::class, 'destroyPurpose'])->name('destroyPurpose');

    });
});
