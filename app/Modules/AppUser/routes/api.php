<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use App\Modules\AppUser\Http\Controllers\UserGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/app-user', 'middleware' => 'throttle:1000,10'], function () {
    Route::post('login', [AppUserAuthController::class, 'appLogin'])->name('api.app_user.login');
    Route::post('registration', [AppUserAuthController::class, 'appRegistration'])->name('api.app_user.register');
    //Google
    Route::get('auth/google', [AppUserAuthController::class, 'redirectToGoogleByApi'])->name('api.app_user,google.login');
    Route::get('google/auth-receiver', [AppUserAuthController::class, 'redirectToGoogleByApi'])->name('api.app_user.google.auth-receive');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('user-details', [AppUserController::class, 'apiUserDetails'])->name('api.app_user.details');
        Route::get('total-coin', [AppUserController::class, 'apiUserTotalCoin'])->name('api.app_user.total_coin');
    });
});


//For Game User
Route::group(['prefix' => 'api/game', 'middleware' => 'throttle:1000,10'], function () {
    Route::post('login', [AppUserAuthController::class, 'normalGameUserLogin'])->name('api.game.login');
    Route::post('registration', [AppUserAuthController::class, 'normalGameUserRegistration'])->name('api.game.register');

    Route::group(['middleware' => ['auth:sanctum', 'apiemailverified']], function () {
        Route::post('session-initiate', [UserGameController::class, 'apiGameInit'])->name('api.game.init');
        Route::post('session-update', [UserGameController::class, 'apiGameSessionUpdate'])->name('api.game.session_update');
    });
});
