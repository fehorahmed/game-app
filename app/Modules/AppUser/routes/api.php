<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use App\Modules\AppUser\Http\Controllers\UserGameController;
use App\Modules\AppUserBalance\Http\Controllers\AppUserBalanceController;
use App\Modules\AppUserBalance\Http\Controllers\StarLogController;
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
        Route::get('total-balance', [AppUserController::class, 'apiUserTotalBalance'])->name('api.app_user.total_balance');
        Route::get('total-star', [AppUserController::class, 'apiUserTotalStar'])->name('api.app_user.total_star');

        //Star Price
        Route::get('get-star-price', [StarLogController::class, 'apiStarPrice'])->name('api.app_user.star_price');
        Route::post('buy-star', [StarLogController::class, 'apiUserBuyStar'])->name('api.app_user.buy_star');

        //Referral
        Route::get('my-referral', [AppUserController::class, 'apiMyReferral'])->name('api.app_user.my-referral');
        Route::get('my-referral-request', [AppUserController::class, 'apiMyReferralRequest'])->name('api.app_user.my-referral-request');
        Route::get('get-referral-by-user', [AppUserController::class, 'apiGetReferralByUser'])->name('api.app_user.get-referral-by-user');

        //Deposit
        Route::post('deposit-store', [AppUserController::class, 'apiDepositStore'])->name('api.app_user.deposit');
        Route::get('deposit-history', [AppUserController::class, 'apiDepositHistory'])->name('api.app_user.deposit.history');
        //Withdraw
        Route::post('/withdraw-store', [AppUserController::class, 'apiWithdrawStore'])->name('api.app_user.withdraw');
        Route::get('/withdraw-history', [AppUserController::class, 'apiWithdrawHistory'])->name('api.app_user.withdraw.history');
        //Coin Transfer
        Route::post('/coin-transfer-store', [AppUserBalanceController::class, 'apiCoinTransferStore'])->name('api.app_user.coin-transfer.store');
        Route::get('/coin-transfer-history', [AppUserBalanceController::class, 'apiCoinTransferHistory'])->name('api.app_user.coin-transfer.history');
    });
});
