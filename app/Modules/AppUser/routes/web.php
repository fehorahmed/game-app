<?php

use App\Modules\AppUser\Http\Controllers\AppUserController;
use Illuminate\Support\Facades\Route;

Route::get('app-user', 'AppUserController@welcome');


Route::get('/app-user/password-reset/{token}', [AppUserController::class, 'apiPasswordResetForm'])->name('app_user.password-reset');
Route::post('/app-user/password/reset', [AppUserController::class, 'apiPasswordReset'])->name('app_user.password-reset-store');


Route::middleware('auth')->group(function () {

    Route::get('/app-user/index', [AppUserController::class, 'index'])->name('app_user.index');
    Route::get('/app-user/{user}/view', [AppUserController::class, 'view'])->name('app_user.view');
});


// App User On Frontend

Route::get('/user-login', [AppUserController::class, 'appUserLogin'])->name('user.login');
Route::get('/user-register', [AppUserController::class, 'register'])->name('user.register');
Route::post('/user-login', [AppUserController::class, 'appUserLoginStore']);
Route::post('/user-register', [AppUserController::class, 'registerStore']);

Route::post('/appuser/logout', [AppUserController::class, 'appUserLogout'])->name('appuser.logout');

Route::middleware(['auth:appuser'])->group(function () {
    Route::get('/user_profile', [AppUserController::class, 'appUserProfile'])->name('user.profile');
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

});
