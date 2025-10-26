<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LandingController;
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
});


Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [AuthenticatedSessionController::class, 'userDashboard'])
        ->name('user.dashboard');

// Route::get('/shop', [ProductController::class, 'katalog'])->name('shop');
Route::get('/shop/{category?}', [ProductController::class, 'katalog'])->name('shop');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
//     Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
// });

require __DIR__.'/auth.php';
