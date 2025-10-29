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

    // (Nanti rute Transaksi Pustakawan akan ditambahkan di sini)
});

// == Grup LABORAN ==
Route::middleware(['auth', 'laboran'])->prefix('laboran')->name('laboran.')->group(function () {
    Route::get('/dashboard', [LaboranDash::class, 'index'])->name('dashboard');

    // CRUD Kelola Alat
    Route::resource('alat', AlatLabController::class);

    // (Nanti rute Transaksi Laboran akan ditambahkan di sini)
});