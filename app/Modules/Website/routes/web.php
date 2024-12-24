<?php

use App\Modules\Website\Http\Controllers\OwnWebsiteController;
use App\Modules\Website\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

Route::get('website', 'WebsiteController@welcome');

Route::middleware('auth')->prefix('website')->group(function () {

    Route::get('/list', [WebsiteController::class, 'index'])->name('admin.website.list');
    Route::get('/create', [WebsiteController::class, 'create'])->name('admin.website.create');
    Route::post('/create', [WebsiteController::class, 'store']);
    Route::get('/{website}/edit', [WebsiteController::class, 'edit'])->name('admin.website.edit');
    Route::post('/{website}/edit', [WebsiteController::class, 'update']);


    Route::get('/own/list', [OwnWebsiteController::class, 'index'])->name('admin.own.website.list');
    Route::get('/own/create', [OwnWebsiteController::class, 'create'])->name('admin.own.website.create');
    Route::post('/own/create', [OwnWebsiteController::class, 'store']);
    Route::get('/own/{website}/edit', [OwnWebsiteController::class, 'edit'])->name('admin.own.website.edit');
    Route::post('/own/{website}/edit', [OwnWebsiteController::class, 'update']);


});
