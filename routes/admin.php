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
    Route::resource('users', UserController::class);
});

// == Grup PUSTAKAWAN ==
Route::middleware(['auth', 'pustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    Route::get('/dashboard', [PustakawanDash::class, 'index'])->name('dashboard');

    // CRUD Kelola Buku
    Route::resource('buku', BukuController::class);

    // Transaksi
    Route::get('transaksi', [PustakawanTransaksi::class, 'index'])->name('transaksi.index');
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
    Route::post('transaksi/{transaksi}/setujui', [LaboranTransaksi::class, 'setujui'])->name('transaksi.setujui');
    Route::post('transaksi/{transaksi}/tolak', [LaboranTransaksi::class, 'tolak'])->name('transaksi.tolak');
    Route::post('transaksi/{transaksi}/selesaikan', [LaboranTransaksi::class, 'selesaikan'])->name('transaksi.selesaikan');
    Route::post('transaksi/{transaksi}/gagal-kembali', [LaboranTransaksi::class, 'gagalKembali'])->name('transaksi.gagalKembali');
});