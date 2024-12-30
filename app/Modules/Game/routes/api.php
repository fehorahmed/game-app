<?php

use App\Modules\AppUser\Http\Controllers\AppUserAuthController;
use App\Modules\Game\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('api/game/list', [GameController::class, 'apiGameList'])->name('api.game.list');
//For Game User
Route::group(['prefix' => 'api/game', 'middleware' => 'throttle:1000,10'], function () {
    Route::post('login', [AppUserAuthController::class, 'normalGameUserLogin'])->name('api.game.login');
    Route::post('registration', [AppUserAuthController::class, 'normalGameUserRegistration'])->name('api.game.register');
    // Route::group(['middleware' => ['auth:sanctum', 'apiemailverified']], function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('session-initiate', [GameController::class, 'apiGameInit'])->name('api.game.init');
        Route::post('session-update', [GameController::class, 'apiGameSessionUpdate'])->name('api.game.session_update');
        Route::post('wish-coin-store', [GameController::class, 'apiGameWishCoinStore'])->name('api.game.wish-coin-store');
        Route::get('game-history', [GameController::class, 'apiUserGameHistory'])->name('api.game.game_history');
        Route::get('game-profile', [GameController::class, 'apiGameProfile'])->name('api.game.game_profile');
    });
});
