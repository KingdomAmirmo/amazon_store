<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;

use Modules\ContentCategory\Http\Controllers\ContentCategoryController;

Route::prefix('admin')->namespace('Admin')->group(function () {

    Route::prefix('content')->namespace('Content')->group(function () {

        Route::prefix('category')->namespace('Content')->group(function () {
            //category
            Route::get('/', [ContentCategoryController::class, 'index'])->name('admin.content.category.index');
            Route::get('/create', [ContentCategoryController::class, 'create'])->name('admin.content.category.create');
            Route::post('/store', [ContentCategoryController::class, 'store'])->name('admin.content.category.store');
            Route::get('/edit/{postCategory}', [ContentCategoryController::class, 'edit'])->name('admin.content.category.edit');
            Route::put('/update/{postCategory}', [ContentCategoryController::class, 'update'])->name('admin.content.category.update');
            Route::delete('/destroy/{postCategory}', [ContentCategoryController::class, 'destroy'])->name('admin.content.category.destroy');
            //for status
            Route::put('/status/{postCategory}', [ContentCategoryController::class, 'status'])->name('admin.content.category.status');

        });

    });

});
