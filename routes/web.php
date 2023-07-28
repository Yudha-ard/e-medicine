<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\KategoriObatController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ExcelExportController;


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

    Route::get('apotek', [ApotekController::class, 'index'])->name('customer.apotek');
    Route::get('apotek/{apotek}', [ApotekController::class, 'show'])->name('customer.apotek.show');

    Route::get('order', [OrderController::class, 'index'])->name('customer.order');
    Route::get('order/{apotek}', [OrderController::class, 'apotek'])->name('customer.order.apotek');
    Route::post('order/{apotek}/add', [OrderController::class, 'add'])->name('customer.order.apotek.add');
    Route::get('order/{apotek}/create', [OrderController::class, 'create'])->name('customer.order.apotek.create');
    Route::post('order/{apotek}/checkout', [OrderController::class, 'store'])->name('customer.order.apotek.checkout');
    Route::get('order/{apotek}/destroy', [OrderController::class, 'destroy'])->name('customer.order.apotek.destroy');

    Route::get('transaksi', [TransaksiController::class, 'index'])->name('customer.transaksi');
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('customer.transaksi.show');

    Route::get('riwayat', [RiwayatController::class, 'index'])->name('customer.riwayat');
    Route::get('riwayat/{riwayat}', [RiwayatController::class, 'show'])->name('customer.riwayat.show');

    Route::get('/transaksiExport', [ExcelExportController::class, 'exportTransaksiCustomer'])->name('customer.transaksi.export');
    Route::get('/riwayatExport', [ExcelExportController::class, 'exportRiwayatCustomer'])->name('customer.riwayat.export');

});

Route::prefix('admin')->middleware(['auth', 'role:administrator'])->group(function () {
    Route::get('/', function() { return redirect('admin/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('admin.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('user', [UserController::class, 'index'])->name('admin.user');
    Route::get('user/create', [UserController::class, 'create'])->name('admin.user.create');
    Route::get('user/{user}', [UserController::class, 'show'])->name('admin.user.show');
    Route::post('user', [UserController::class, 'store'])->name('admin.user.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('admin.user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('apotek', [ApotekController::class, 'index'])->name('admin.apotek');
    Route::get('apotek/create', [ApotekController::class, 'create'])->name('admin.apotek.create');
    Route::get('apotek/{apotek}', [ApotekController::class, 'show'])->name('admin.apotek.show');
    Route::post('apotek', [ApotekController::class, 'store'])->name('admin.apotek.store');
    Route::get('apotek/{apotek}/edit', [ApotekController::class, 'edit'])->name('admin.apotek.edit');
    Route::put('apotek/{apotek}', [ApotekController::class, 'update'])->name('admin.apotek.update');
    Route::delete('apotek/{apotek}', [ApotekController::class, 'destroy'])->name('admin.apotek.destroy');

    Route::get('transaksi', [TransaksiController::class, 'indexAdmin'])->name('admin.transaksi');
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'showAdmin'])->name('admin.transaksi.show');

    Route::get('riwayat', [RiwayatController::class, 'indexAdmin'])->name('admin.riwayat');
    Route::get('riwayat/{riwayat}', [RiwayatController::class, 'showAdmin'])->name('admin.riwayat.show');

    Route::get('/riwayatExport', [ExcelExportController::class, 'exportRiwayatAdmin'])->name('admin.riwayat.export');
    Route::get('/transaksiExport', [ExcelExportController::class, 'exportTransaksiAdmin'])->name('admin.transaksi.export');
    
});

Route::prefix('apotek')->middleware(['auth', 'role:apoteker'])->group(function () {
    Route::get('/', function() { return redirect('apotek/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'apoteker'])->name('apoteker.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('apoteker.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('apoteker.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('apoteker.profile.update');

    Route::get('kategori', [KategoriObatController::class, 'index'])->name('apoteker.kategori');
    Route::get('kategori/create', [KategoriObatController::class, 'create'])->name('apoteker.kategori.create');
    Route::get('kategori/{kategori}', [KategoriObatController::class, 'show'])->name('apoteker.kategori.show');
    Route::post('kategori', [KategoriObatController::class, 'store'])->name('apoteker.kategori.store');
    Route::get('kategori/{kategori}/edit', [KategoriObatController::class, 'edit'])->name('apoteker.kategori.edit');
    Route::put('kategori/{kategori}', [KategoriObatController::class, 'update'])->name('apoteker.kategori.update');
    Route::delete('kategori/{kategori}', [KategoriObatController::class, 'destroy'])->name('apoteker.kategori.destroy');

    Route::get('obat', [ObatController::class, 'index'])->name('apoteker.obat');
    Route::get('obat/create', [ObatController::class, 'create'])->name('apoteker.obat.create');
    Route::get('obat/{obat}', [ObatController::class, 'show'])->name('apoteker.obat.show');
    Route::post('obat', [ObatController::class, 'store'])->name('apoteker.obat.store');
    Route::get('obat/{obat}/edit', [ObatController::class, 'edit'])->name('apoteker.obat.edit');
    Route::put('obat/{obat}', [ObatController::class, 'update'])->name('apoteker.obat.update');
    Route::delete('obat/{obat}', [ObatController::class, 'destroy'])->name('apoteker.obat.destroy');

    Route::get('order', [OrderController::class, 'indexApotek'])->name('apoteker.order');
    Route::get('order/{order}', [OrderController::class, 'showApotek'])->name('apoteker.order.show');
    Route::put('order/{order}/accept', [OrderController::class, 'accept'])->name('apoteker.order.accept');
    Route::put('order/{order}/cancel', [OrderController::class, 'cancel'])->name('apoteker.order.cancel');
    Route::delete('order/{order}/delete', [OrderController::class, 'delete'])->name('apoteker.order.delete');

    Route::get('transaksi', [TransaksiController::class, 'indexApotek'])->name('apoteker.transaksi');
    Route::get('transaksi/{transaksi}', [TransaksiController::class, 'showApotek'])->name('apoteker.transaksi.show');

    Route::get('riwayat', [RiwayatController::class, 'indexApotek'])->name('apoteker.riwayat');
    Route::get('riwayat/{riwayat}', [RiwayatController::class, 'showApotek'])->name('apoteker.riwayat.show');

    Route::get('/orderExport', [ExcelExportController::class, 'exportOrderApotek'])->name('apoteker.order.export');
    Route::get('/riwayatExport', [ExcelExportController::class, 'exportRiwayatApotek'])->name('apoteker.riwayat.export');
    Route::get('/transaksiExport', [ExcelExportController::class, 'exportTransaksiApotek'])->name('apoteker.transaksi.export');
});

Route::prefix('kurir')->middleware(['auth', 'role:kurir'])->group(function () {
    Route::get('/', function() { return redirect('kurir/dashboard'); });
    Route::get('/dashboard', [DashboardController::class, 'kurir'])->name('kurir.dashboard');

    Route::get('profile', [ProfileController::class, 'index'])->name('kurir.profile');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('kurir.profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('kurir.profile.update');

    Route::get('order', [OrderController::class, 'indexKurir'])->name('kurir.order');
    Route::get('order/{order}', [OrderController::class, 'showKurir'])->name('kurir.order.show');
    Route::put('order/{order}/accept', [OrderController::class, 'acceptKurir'])->name('kurir.order.accept');

    Route::get('riwayat', [RiwayatController::class, 'indexKurir'])->name('kurir.riwayat');
    Route::get('riwayat/{riwayat}', [RiwayatController::class, 'showKurir'])->name('kurir.riwayat.show');

    Route::get('/orderExport', [ExcelExportController::class, 'exportOrderKurir'])->name('kurir.order.export');
    Route::get('/riwayatExport', [ExcelExportController::class, 'exportRiwayatKurir'])->name('kurir.riwayat.export');
});

