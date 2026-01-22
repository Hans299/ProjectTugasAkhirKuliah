<?php

use Illuminate\Support\Facades\Route;

// Dashboard
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDash;
use App\Http\Controllers\Pustakawan\DashboardController as PustakawanDash;
use App\Http\Controllers\Laboran\DashboardController as LaboranDash;

// CRUD
use App\Http\Controllers\Superadmin\UserController;
use App\Http\Controllers\Pustakawan\BukuController;
use App\Http\Controllers\Laboran\AlatLabController;

//Transaksi
use App\Http\Controllers\Pustakawan\TransaksiController as PustakawanTransaksi;
use App\Http\Controllers\Laboran\TransaksiController as LaboranTransaksi;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Superadmin\AdminController;

/*
|--------------------------------------------------------------------------
| Rute Admin
|--------------------------------------------------------------------------
|
| File ini mengurus semua rute yang diawali dengan /admin
| (Superadmin, Pustakawan, Laboran).
|
*/

// == Grup SUPERADMIN ==
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperadminDash::class, 'index'])->name('dashboard');

    // CRUD Kelola Akun
    // Route::resource('users', UserController::class);
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user/store', [UserController::class, 'store'])->name('user.store');

    Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');

    Route::get('admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('admin/create', [AdminController::class, 'create'])->name('admin.create');
    Route::post('admin/store', [AdminController::class, 'store'])->name('admin.store');

    Route::get('admin/{user}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/{user}/update', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('admin/{user}/delete', [AdminController::class, 'destroy'])->name('admin.destroy');
});

// == Grup PUSTAKAWAN ==
Route::middleware(['auth', 'pustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    Route::get('/dashboard', [PustakawanDash::class, 'index'])->name('dashboard');

    // CRUD Kelola Buku
    Route::resource('buku', BukuController::class);

    // Transaksi
    Route::get('transaksi', [PustakawanTransaksi::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/export', [PustakawanTransaksi::class, 'exportExcel'])->name('transaksi.export');
    Route::post('transaksi/{transaksi}/setujui', [PustakawanTransaksi::class, 'setujui'])->name('transaksi.setujui');
    Route::post('transaksi/{transaksi}/tolak', [PustakawanTransaksi::class, 'tolak'])->name('transaksi.tolak');
    Route::post('transaksi/{transaksi}/selesaikan', [PustakawanTransaksi::class, 'selesaikan'])->name('transaksi.selesaikan');
    Route::post('transaksi/{transaksi}/gagal-kembali', [PustakawanTransaksi::class, 'gagalKembali'])->name('transaksi.gagalKembali');
});

// == Grup LABORAN ==
Route::middleware(['auth', 'laboran'])->prefix('laboran')->name('laboran.')->group(function () {
    Route::get('/dashboard', [LaboranDash::class, 'index'])->name('dashboard');

    // CRUD Kelola Alat
    Route::resource('alat', AlatLabController::class);

    // Transaksi
    Route::get('transaksi', [LaboranTransaksi::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/export', [LaboranTransaksi::class, 'exportExcel'])->name('transaksi.export');
    Route::post('transaksi/{transaksi}/setujui', [LaboranTransaksi::class, 'setujui'])->name('transaksi.setujui');
    Route::post('transaksi/{transaksi}/tolak', [LaboranTransaksi::class, 'tolak'])->name('transaksi.tolak');
    Route::post('transaksi/{transaksi}/selesaikan', [LaboranTransaksi::class, 'selesaikan'])->name('transaksi.selesaikan');
    Route::post('transaksi/{transaksi}/gagal-kembali', [LaboranTransaksi::class, 'gagalKembali'])->name('transaksi.gagalKembali');
});
