<?php

use App\Modules\AppUser\Http\Controllers\AppUserController;
use Illuminate\Support\Facades\Route;

Route::get('app-user', 'AppUserController@welcome');


Route::middleware('auth')->group(function () {

    Route::get('/app-user/index', [AppUserController::class, 'index'])->name('app_user.index');
    Route::get('/app-user/{user}/view', [AppUserController::class, 'view'])->name('app_user.view');
});
