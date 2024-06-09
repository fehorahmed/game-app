<?php

use App\Modules\CoinManagement\Http\Controllers\UserCoinController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('api/app-user/give-coin', [UserCoinController::class, 'apiGiveCoinToUse']);
