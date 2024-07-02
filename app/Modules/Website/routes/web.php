<?php

use App\Modules\Website\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('website', 'WebsiteController@welcome');

Route::middleware('auth')->prefix('website')->group(function () {

    Route::get('/list', [WebsiteController::class, 'index'])->name('admin.website.list');
    Route::get('/create', [WebsiteController::class, 'create'])->name('admin.website.create');
    Route::post('/create', [WebsiteController::class, 'store']);
    Route::get('/{website}/edit', [WebsiteController::class, 'edit'])->name('admin.website.edit');
    Route::post('/{website}/edit', [WebsiteController::class, 'update']);
});
