<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/filter-produk', [LandingController::class, 'filterProduk'])->name('filter.produk');
Route::view('/cara-pemesanan', 'cara-pemesanan');
Route::view('/login-page', 'auth.login')->name('login.page');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| USER (AUTH)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthenticatedSessionController::class, 'userDashboard'])
        ->name('dashboard');

    Route::get('/shop/{category?}', [ProductController::class, 'katalog'])
        ->name('shop');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/password', [ProfileController::class, 'updatePassword'])
        ->name('password.update');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{product}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{order}/check-status', [OrderController::class, 'checkStatus'])
        ->name('orders.check-status');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AuthenticatedSessionController::class, 'adminDashboard'])
        ->name('admin.dashboard');

    Route::resource('/produk', ProductController::class);
    Route::resource('/kategori', KategoriController::class);

    Route::get('/orders', [OrderAdminController::class, 'index'])
        ->name('admin.orders.index');

    Route::get('/orders/{order}', [OrderAdminController::class, 'show'])
        ->name('admin.orders.show');

    Route::get('/konfirmasi', [OrderAdminController::class, 'indexKonfirmasi'])
        ->name('admin.konfirmasi.index');

    Route::put('/orders/{order}/update-status', [OrderAdminController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');
});

/*
|--------------------------------------------------------------------------
| MIDTRANS
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/callback', [OrderController::class, 'callback'])
    ->name('midtrans.callback');

require __DIR__ . '/auth.php';
