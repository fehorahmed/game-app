<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use App\Modules\AppUser\Http\Controllers\UserGameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/app-user', 'middleware' => 'throttle:1000,10'], function () {

    Route::post('login', [AppUserAuthController::class, 'appLogin'])->name('api.app_user.login');
    Route::post('registration', [AppUserAuthController::class, 'appRegistration'])->name('api.app_user.register');
    Route::post('password/email', [AppUserAuthController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [AppUserAuthController::class, 'reset']);


    //Google
    Route::get('auth/google', [AppUserAuthController::class, 'redirectToGoogleByApi'])->name('api.app_user,google.login');
    Route::get('google/auth-receiver', [AppUserAuthController::class, 'redirectToGoogleByApi'])->name('api.app_user.google.auth-receive');

    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('user-details', [AppUserController::class, 'apiUserDetails'])->name('api.app_user.details');
        Route::post('profile-update', [AppUserController::class, 'apiUserProfileUpdate'])->name('api.app_user.profile_update');
        Route::post('profile-photo-update', [AppUserController::class, 'apiUserProfilePhotoUpdate'])->name('api.app_user.profile_photo_update');
        Route::get('total-coin', [AppUserController::class, 'apiUserTotalCoin'])->name('api.app_user.total_coin');


        //Referral
        Route::get('my-referral', [AppUserController::class, 'apiMyReferral'])->name('api.app_user.my-referral');
        Route::get('my-referral-request', [AppUserController::class, 'apiMyReferralRequest'])->name('api.app_user.my-referral-request');
        Route::get('get-referral-by-user', [AppUserController::class, 'apiGetReferralByUser'])->name('api.app_user.get-referral-by-user');
    });
});
