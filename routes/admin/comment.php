<?php

use App\Http\Controllers\Admin\Comment\CommentController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('comments')->name('comments.')->group(function () {
        Route::get('/', [CommentController::class, 'index'])->name('index');
        Route::get('/create', [CommentController::class, 'create'])->name('create');
        Route::post('/', [CommentController::class, 'store'])->name('store');
        Route::get('/{comment}', [CommentController::class, 'show'])->name('show');
        Route::get('/{comment}/edit', [CommentController::class, 'edit'])->name('edit');
        Route::patch('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');

        Route::post('/{comment}/status', [CommentController::class, 'toggleStatus'])->name('toggleStatus');
    });
});