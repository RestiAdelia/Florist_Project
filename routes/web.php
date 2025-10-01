<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('landing');
});

// Cara pemesanan page
Route::get('/cara-pemesanan', function () {
    return view('cara-pemesanan');
});

// Login page (Breeze)
Route::get('/login-page', function () {
    return view('auth.login');
})->name('login.page');

// Dashboard (Breeze)
Route::get('/dashboard', function () {
    return view('dashboard'); // gunakan x-app-layout
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
