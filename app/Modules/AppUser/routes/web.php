<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use App\Modules\AppUserBalance\Http\Controllers\AppUserBalanceController;
use App\Modules\AppUserBalance\Http\Controllers\StarLogController;
use App\Modules\CoinManagement\Http\Controllers\UserCoinController;
use Illuminate\Support\Facades\Route;

Route::get('app-user', 'AppUserController@welcome');


Route::get('/app-user/password-reset/{token}', [AppUserController::class, 'apiPasswordResetForm'])->name('app_user.password-reset');
Route::post('/app-user/password/reset', [AppUserController::class, 'apiPasswordReset'])->name('app_user.password-reset-store');


Route::middleware('auth')->group(function () {

    Route::get('/app-user/index', [AppUserController::class, 'index'])->name('app_user.index');
    Route::get('/app-user/{user}/view', [AppUserController::class, 'view'])->name('app_user.view');

});

Route::get('/get_user_by_id', [AppUserController::class, 'getUserByUserId'])->name('user.get-user-by-user_id');
// App User On Frontend

Route::get('/user-login', [AppUserController::class, 'appUserLogin'])->name('user.login');
Route::get('/user-register', [AppUserController::class, 'register'])->name('user.register');
Route::post('/user-login', [AppUserController::class, 'appUserLoginStore']);
Route::post('/user-register', [AppUserController::class, 'registerStore']);

Route::get('/user-forget-password', [AppUserAuthController::class, 'appForgotPassword'])->name('user.forget-password');
Route::post('/user-forget-password', [AppUserAuthController::class, 'appForgotPasswordLinkSend']);

Route::post('/appuser/logout', [AppUserController::class, 'appUserLogout'])->name('appuser.logout');

Route::middleware(['auth:appuser'])->group(function () {
    Route::get('/user_profile', [AppUserController::class, 'appUserProfile'])->name('user.profile');
    Route::post('/user_profile_update', [AppUserController::class, 'appUserProfileUpdate'])->name('user.profile.update');
    Route::get('/user_dashboard', [AppUserController::class, 'appUserDashboard'])->name('user.dashboard');
    Route::get('/user_deposit_history', [AppUserController::class, 'appUserDepositHistory'])->name('user.deposit.history');

    Route::get('/user_deposit', [AppUserController::class, 'appUserDeposit'])->name('user.deposit');
    Route::get('/user_deposit_method', [AppUserController::class, 'appUserDepositMethodSubmit'])->name('user.deposit.method.submit');
    Route::post('/user_deposit_final_submit', [AppUserController::class, 'appUserDepositFinalSubmit'])->name('user.deposit.method.final_submit');
    Route::get('/user_withdraw', [AppUserController::class, 'appUserWithdraw'])->name('user.withdraw');
    Route::get('/user_withdraw_method', [AppUserController::class, 'appUserWithdrawMethodSubmit'])->name('user.withdraw.method.submit');
    Route::post('/user_withdraw_final_submit', [AppUserController::class, 'appUserWithdrawFinalSubmit'])->name('user.withdraw.method.final_submit');
    Route::get('/user_withdraw_history', [AppUserController::class, 'appUserWithdrawHistory'])->name('user.withdraw.history');


    Route::get('/user_change_password', [AppUserController::class, 'appUserChangePassword'])->name('user.change_password');
    Route::post('/user_change_password', [AppUserController::class, 'appUserChangePasswordAction']);

    Route::get('/referral_request', [AppUserController::class, 'appUserReferralRequest'])->name('user.referral_request');
    Route::get('/referral_request/{id}/accept', [AppUserController::class, 'appUserReferralRequestAccept'])->name('user.referral_request_accept');
    Route::get('/referral_request/{id}/cancel', [AppUserController::class, 'appUserReferralRequestCancel'])->name('user.referral_request_cancel');

    Route::get('/member_list', [AppUserController::class, 'appUserReferralMemberList'])->name('user.member_list');
    Route::get('/referral_member/{id}/detail', [AppUserController::class, 'appUserReferralMemberDetail'])->name('user.referral_member_detail');
    Route::get('/add_yourself', [AppUserController::class, 'appUserAddYouself'])->name('user.add_yourself');
    Route::post('/add_yourself', [AppUserController::class, 'appUserAddYouselfStore']);


    Route::get('/routing', [AppUserController::class, 'appUserRoutingList'])->name('user.routing_list');
    Route::get('/website_list', [AppUserController::class, 'appUserWebsiteList'])->name('user.website_list');
    Route::get('/website_visit_count/{website}', [AppUserController::class, 'appUserWebsiteVisitCount'])->name('user.website_visit_count');

    Route::get('/web_visiting_list', [AppUserController::class, 'appUserWebVisitingList'])->name('user.web_visiting_list');


    Route::get('/star_buy', [StarLogController::class, 'userStarBuy'])->name('user.star.buy');
    Route::get('/get_user_by_id_for_add_yourself', [AppUserController::class, 'getUserByUserIdForAddYourself'])->name('user.get-user-by-user_id-for-add-yourself');


    Route::get('/transfer_type', [AppUserController::class, 'appUserTransferType'])->name('user.transfer_type');
    Route::get('/balance_transfer', [AppUserBalanceController::class, 'appUserBalanceTransfer'])->name('user.balance_transfer');
    Route::post('/balance_transfer_store', [AppUserBalanceController::class, 'appUserBalanceTransferStore'])->name('user.balance_transfer_store');
    Route::get('/balance_transfer_history', [AppUserBalanceController::class, 'appUserBalanceTransferHistory'])->name('user.balance_transfer.history');

    Route::get('/coin_transfer', [AppUserBalanceController::class, 'appUserCoinTransfer'])->name('user.coin_transfer');
    Route::post('/coin_transfer_store', [AppUserBalanceController::class, 'appUserCoinTransferStore'])->name('user.coin_transfer_store');
    Route::get('/coin_transfer_history', [AppUserBalanceController::class, 'appUserCoinTransferHistory'])->name('user.coin_transfer.history');

    Route::get('/your_income', [AppUserController::class, 'appUserIncome'])->name('user.income');

    Route::get('/coin_convert', [UserCoinController::class, 'appUserCoinConvert'])->name('user.coin_convert');
    Route::post('/coin_convert_store', [UserCoinController::class, 'appUserCoinConvertStore'])->name('user.coin_convert_store');
    Route::get('/coin_convert_history', [UserCoinController::class, 'appUserCoinConvertHistory'])->name('user.coin_convert.history');

    Route::get('/taka_to_coin_convert', [UserCoinController::class, 'appUserTakaToCoinConvert'])->name('user.taka_to_coin_convert');
    Route::post('/taka_to_coin_convert_store', [UserCoinController::class, 'appUserTakaToCoinConvertStore'])->name('user.taka_to_coin_convert_store');
    Route::get('/taka_to_coin_convert_history', [UserCoinController::class, 'appUserTakaToCoinConvertHistory'])->name('user.taka_to_coin_convert.history');

    //Balance History
    Route::get('/balance_history', [AppUserBalanceController::class, 'appUserBalanceHistory'])->name('user.balance.history');
    Route::get('/coin_history', [AppUserBalanceController::class, 'appUserCoinHistory'])->name('user.coin.history');
    Route::get('/star_history', [AppUserBalanceController::class, 'appUserStarHistory'])->name('user.star.history');


     //Support
     Route::get('/user_support', [AppUserController::class, 'appUserSupport'])->name('user.support');
});

Route::get('/web_routing_visit_count/{website}', [AppUserController::class, 'appUserWebVisitCount'])->name('user.web_visit_count');
