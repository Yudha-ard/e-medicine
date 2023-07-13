<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;



Route::get('/', [FrontController::class, 'index'])->name('frontend.index');
Route::get('about', [FrontController::class, 'about'])->name('frontend.about');
Route::get('contact', [FrontController::class, 'contact'])->name('frontend.contact');

Route::get('logout', function() { return redirect('login'); });

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::prefix('user')->middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/', function() { return redirect('user/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'customer'])->name('customer.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('customer.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('customer.profile.update');

});

Route::prefix('admin')->middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/', function() { return redirect('admin/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');
    
});

Route::prefix('apotek')->middleware(['auth', 'role:apoteker'])->group(function () {
    Route::get('/', function() { return redirect('apotek/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'apoteker'])->name('apoteker.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('apoteker.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('apoteker.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('apoteker.profile.update');

});

Route::prefix('kurir')->middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/', function() { return redirect('kurir/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'kurir'])->name('kurir.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('kurir.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('kurir.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('kurir.profile.update');
});
