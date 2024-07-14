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
