<?php

use App\Modules\CoinManagement\Http\Controllers\UserCoinController;
use Illuminate\Support\Facades\Route;

Route::get('coin-management', 'CoinManagementController@welcome');

Route::middleware('auth')->prefix('coin')->group(function () {

    Route::get('user-coin', [UserCoinController::class, 'userCoinList'])->name('coin.user_coin.list');
    Route::get('user-coin/{user_coin}/details', [UserCoinController::class, 'userCoinDetails'])->name('coin.user_coin.details');
});
