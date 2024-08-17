<?php

use App\Modules\Game\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;

Route::get('game', 'GameController@welcome');
Route::middleware('auth', 'verified')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::prefix('game')->group(function () {
            Route::get('/', [GameController::class, 'index'])->name('admin.game.index');
            Route::get('/create', [GameController::class, 'create'])->name('admin.game.create');
            Route::post('/create', [GameController::class, 'store'])->name('admin.game.store');
            Route::get('/edit/{id}', [GameController::class, 'edit'])->name('admin.game.edit');
            Route::post('/edit/{id}', [GameController::class, 'update'])->name('admin.game.update');
        });
    });
});
