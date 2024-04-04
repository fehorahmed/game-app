<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/app-user', 'middleware' => 'throttle:1000,10'], function () {
    Route::post('login', [AppUserAuthController::class, 'login'])->name('api.app_user.login');
    Route::post('registration', [AppUserAuthController::class, 'register'])->name('api.app_user.register');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('user-details', [AppUserController::class, 'userDetails'])->name('api.app_user.details');
    });
});
