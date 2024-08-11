<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GlobalConfigController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
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

Route::get('/brawse', [WebsiteController::class, 'brawse'])->name('user.brawse');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {

    Route::get('/admin/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/global-config', [GlobalConfigController::class, 'index'])->name('global.config');
    Route::post('/global-config', [GlobalConfigController::class, 'store'])->name('global.config-store');

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
});

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

require __DIR__ . '/auth.php';
