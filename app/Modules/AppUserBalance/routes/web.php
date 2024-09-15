<?php

use App\Modules\AppUserBalance\Http\Controllers\DepositLogController;
use Illuminate\Support\Facades\Route;

Route::get('app-user-balance', 'AppUserBalanceController@welcome');

Route::middleware('auth')->group(function () {

    Route::get('/app-user/deposit-request', [DepositLogController::class, 'depositRequest'])->name('app_user.deposit.request');
    Route::get('/app-user/update-deposit-status', [DepositLogController::class, 'updateDepositStatus'])->name('app_user.update.deposit.status');
});
