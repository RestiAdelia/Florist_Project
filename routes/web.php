<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/filter-produk', [LandingController::class, 'filterProduk'])->name('filter.produk');

Route::get('/cara-pemesanan', function () {
    return view('cara-pemesanan');
});

Route::get('/login-page', function () {
    return view('auth.login');
})->name('login.page');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Admin dashboard

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AuthenticatedSessionController::class, 'adminDashboard'])
        ->name('dashboard');
    Route::resource('produk', ProductController::class);
    Route::resource('kategori', KategoriController::class);
    Route::get('/admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{id}', [OrderAdminController::class, 'show'])->name('admin.orders.show');

    Route::get('/admin/konfirmasi', [OrderAdminController::class, 'indexKonfirmasi'])
        ->name('admin.konfirmasi.index');
  Route::put('/admin/orders/{order}/update-status',
    [OrderAdminController::class, 'updateStatus']
)->name('admin.orders.updateStatus');

});

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [AuthenticatedSessionController::class, 'userDashboard'])
        ->name('user.dashboard');
    Route::get('/shop/{category?}', [ProductController::class, 'katalog'])->name('shop');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{product_id}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/pay', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/orders/{order}/check-status', [OrderController::class, 'checkStatus'])
        ->name('orders.check-status')
        ->middleware('auth');
});

// Route untuk Midtrans callback/webhook (tanpa auth)
Route::post('/midtrans/callback', [OrderController::class, 'callback'])->name('midtrans.callback');

// Route::middleware('auth')->group(function () {
//     Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/create/{product_id}', [OrderController::class, 'create'])->name('orders.create');
//     Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
//     Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
//     // routes/web.php


// Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');

//     // Success & Failed sebagai JSON
//     Route::get('/payment/success/{id}', [OrderController::class, 'success'])->name('payment.success');
//     Route::get('/payment/failed/{id}', [OrderController::class, 'failed'])->name('payment.failed');
// });




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
//     Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
// });

require __DIR__ . '/auth.php';
