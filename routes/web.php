<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/filter-produk', [LandingController::class, 'filterProduk'])->name('filter.produk');

Route::get('/cara-pemesanan', function () {
    return view('cara-pemesanan');
});

Route::get('/login-page', function () {
    return view('auth.login');
})->name('login.page');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AuthenticatedSessionController::class, 'adminDashboard'])
        ->name('dashboard');
    Route::resource('produk', ProductController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('/admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderAdminController::class, 'show'])->name('admin.orders.show');

    Route::get('/admin/konfirmasi', [OrderAdminController::class, 'indexKonfirmasi'])
        ->name('admin.konfirmasi.index');
    Route::put(
        '/admin/orders/{order}/update-status',
        [OrderAdminController::class, 'updateStatus']
    )->name('admin.orders.updateStatus');
    Route::get('/admin/laporan', [ReportController::class, 'index'])->name('admin.laporan.index');
    Route::get('/admin/laporan/export-pdf', [ReportController::class, 'exportPdf'])->name('admin.laporan.pdf');
});

Route::middleware(['auth'])->group(function () {
      Route::get('/user/dashboard', [AuthenticatedSessionController::class, 'userDashboard'])
        ->name('user.dashboard');
    Route::get('/shop/{category?}', [ProductController::class, 'katalog'])->name('shop');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{product_id}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{order}/check-status', [OrderController::class, 'checkStatus'])
        ->name('orders.check-status')
        ->middleware('auth');
});

Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

   
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::put('/password', [ProfileController::class, 'updatePassword'])
        ->name('password.update');
});

require __DIR__ . '/auth.php';
