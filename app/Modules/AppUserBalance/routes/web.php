<?php

use App\Modules\AppUserBalance\Http\Controllers\DepositLogController;
use App\Modules\AppUserBalance\Http\Controllers\WithdrawLogController;
use Illuminate\Support\Facades\Route;

Route::get('app-user-balance', 'AppUserBalanceController@welcome');

Route::middleware('auth')->group(function () {

    Route::get('/app-user/deposit-request', [DepositLogController::class, 'depositRequest'])->name('app_user.deposit.request');
    Route::get('/app-user/update-deposit-status', [DepositLogController::class, 'updateDepositStatus'])->name('app_user.update.deposit.status');

    Route::get('/app-user/withdraw-request', [WithdrawLogController::class, 'withdrawRequest'])->name('app_user.withdraw.request');
    Route::get('/app-user/update-withdraw-status', [WithdrawLogController::class, 'updateWithdrawStatus'])->name('app_user.update.withdraw.status');
});
