<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppBannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GlobalConfigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeSlideController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StarConfigController;
use App\Modules\Website\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/{name}/detail', [HomeController::class, 'gameDetail'])->name('home.game.detail');

Route::get('/brawse', [WebsiteController::class, 'brawse'])->name('user.brawse');
Route::get('/visiting', [WebsiteController::class, 'visiting'])->name('user.visiting');


// Route::middleware(['auth:appuser'])->group(function () {
//     Route::get('/user_profile', [AppUserController::class, 'appUserProfile'])->name('user.profile');

// });


Route::middleware('auth', 'verified')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
        //Global Config
        Route::get('/global-config', [GlobalConfigController::class, 'index'])->name('global.config');
        Route::post('/global-config', [GlobalConfigController::class, 'store'])->name('global.config-store');
        //Star Config
        Route::get('/star-config', [StarConfigController::class, 'index'])->name('star.config');
        Route::post('/star-config', [StarConfigController::class, 'store'])->name('star.config-store');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('payment-method')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('config.payment-method.index');
            Route::get('/create', [PaymentMethodController::class, 'create'])->name('config.payment-method.create');
            Route::post('/create', [PaymentMethodController::class, 'store']);
            Route::get('/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('config.payment-method.edit');
            Route::post('/{paymentMethod}/edit', [PaymentMethodController::class, 'update']);
        });

        //HOME WEBSITE

        Route::prefix('home-slide')->group(function () {
            Route::get('/', [HomeSlideController::class, 'index'])->name('config.home-slide.index');
            Route::get('/create', [HomeSlideController::class, 'create'])->name('config.home-slide.create');
            Route::post('/create', [HomeSlideController::class, 'store'])->name('config.home-slide.store');
            Route::get('/edit/{id}', [HomeSlideController::class, 'edit'])->name('config.home-slide.edit');
            Route::post('/edit/{id}', [HomeSlideController::class, 'update'])->name('config.home-slide.update');
        });
        Route::prefix('app-banner')->group(function () {
            Route::get('/', [AppBannerController::class, 'index'])->name('config.app-banner.index');
            Route::get('/create', [AppBannerController::class, 'create'])->name('config.app-banner.create');
            Route::post('/create', [AppBannerController::class, 'store'])->name('config.app-banner.store');
        });
    });
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});
Route::get('/migrate', function () {
    Artisan::call('migrate');
});
Route::get('/optimize', function () {
    Artisan::call('optimize');
});

require __DIR__ . '/auth.php';
