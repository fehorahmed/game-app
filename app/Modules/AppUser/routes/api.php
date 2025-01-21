<?php

use App\Http\Controllers\AppBannerController;
use App\Http\Controllers\HelpVideoController;
use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use App\Modules\AppUser\Http\Controllers\UserGameController;
use App\Modules\AppUserBalance\Http\Controllers\AppUserBalanceController;
use App\Modules\AppUserBalance\Http\Controllers\LevelIncomeLogController;
use App\Modules\AppUserBalance\Http\Controllers\StarLogController;
use App\Modules\CoinManagement\Http\Controllers\UserCoinConvertLogController;
use App\Modules\Game\Http\Controllers\GameController;
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
        Route::post('my-referral-request/{id}/change-status', [AppUserController::class, 'apiMyReferralRequestChangeStatus'])->name('api.app_user.my-referral-request-change-status');

        //Deposit
        Route::post('deposit-store', [AppUserController::class, 'apiDepositStore'])->name('api.app_user.deposit');
        Route::get('deposit-history', [AppUserController::class, 'apiDepositHistory'])->name('api.app_user.deposit.history');
        //Withdraw
        Route::post('/withdraw-store', [AppUserController::class, 'apiWithdrawStore'])->name('api.app_user.withdraw');
        Route::get('/withdraw-history', [AppUserController::class, 'apiWithdrawHistory'])->name('api.app_user.withdraw.history');
        //Coin Transfer
        Route::post('/coin-transfer-store', [AppUserBalanceController::class, 'apiCoinTransferStore'])->name('api.app_user.coin-transfer.store');
        Route::get('/coin-transfer-history', [AppUserBalanceController::class, 'apiCoinTransferHistory'])->name('api.app_user.coin-transfer.history');
        //Coin Convert
        Route::post('/coin-convert-store', [UserCoinConvertLogController::class, 'apiCoinConvertStore'])->name('api.app_user.coin-convert.store');
        Route::get('/coin-convert-history', [UserCoinConvertLogController::class, 'apiCoinConvertHistory'])->name('api.app_user.coin-convert.history');

        //Balance History
        Route::get('all-balance', [AppUserController::class, 'apiUserAllStar'])->name('api.app_user.all_balance');
        Route::get('/balance-history', [AppUserBalanceController::class, 'apiUserBalanceHistory'])->name('api.app_user.balance.history');
        Route::get('/coin-history', [AppUserBalanceController::class, 'apiUserCoinHistory'])->name('api.app_user.coin.history');
        Route::get('/star-history', [AppUserBalanceController::class, 'apiUserStarHistory'])->name('api.app_user.star.history');
        //Income
        Route::get('your-income', [LevelIncomeLogController::class, 'apiUserIncome'])->name('api.app_user.income');
        Route::get('your-loss', [LevelIncomeLogController::class, 'apiUserLoss'])->name('api.app_user.loss');
        //Member count by Level
        Route::get('member-count-by-level', [AppUserController::class, 'apiUserMemberCountByLevel'])->name('api.app_user.member_count_by_level');
        //Routing Website List
        Route::get('routing-website-list', [AppUserController::class, 'apiRoutingWebsiteList'])->name('api.app_user.routing_website_list');
        Route::get('own-website-list', [AppUserController::class, 'apiOwnWebsiteList'])->name('api.app_user.own_website_list');


        // app-banners
        Route::get('app-banners', [AppBannerController::class, 'apiGetAppBanners'])->name('api.app_user.get_app_banner');
        // Help Video
        Route::get('get-help-videos', [HelpVideoController::class, 'apiGetHelpVideos'])->name('api.app_user.get_help_video');
        Route::get('get-active-game-list', [GameController::class, 'apiGetActiveGameList'])->name('api.app_user.get_active_game_list');
    });
});
