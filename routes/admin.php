<?php

use Illuminate\Support\Facades\Route;

// Controller dari Tahap 5 (Dashboard)
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDash;
use App\Http\Controllers\Pustakawan\DashboardController as PustakawanDash;
use App\Http\Controllers\Laboran\DashboardController as LaboranDash;

// Controller BARU dari Tahap 6 (Kelola User)
use App\Http\Controllers\Superadmin\UserController;
 
/*
|--------------------------------------------------------------------------
| Rute Admin
|--------------------------------------------------------------------------
|
| Semua rute di file ini secara otomatis mendapatkan prefix /admin 
| dan nama awalan admin. (dari file bootstrap/app.php)
|
*/

// == Grup SUPERADMIN ==
// Hanya bisa diakses oleh Superadmin yang sudah login
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    
    // Rute Dashboard (dari Tahap 5)
    // Nama: admin.superadmin.dashboard
    Route::get('/dashboard', [SuperadminDash::class, 'index'])->name('dashboard');
    
    // Rute CRUD User (dari Tahap 6)
    // Ini akan otomatis membuat 7 rute untuk kelola user
    // Contoh: admin.superadmin.users.index, admin.superadmin.users.create, dll.
    Route::resource('users', UserController::class);

});
 
// == Grup PUSTAKAWAN ==
// Hanya bisa diakses oleh Pustakawan yang sudah login
Route::middleware(['auth', 'pustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    
    // Rute Dashboard (dari Tahap 5)
    // Nama: admin.pustakawan.dashboard
    Route::get('/dashboard', [PustakawanDash::class, 'index'])->name('dashboard');

    // Nanti rute CRUD Buku akan ditambahkan di sini
});
 
// == Grup LABORAN ==
// Hanya bisa diakses oleh Laboran yang sudah login
Route::middleware(['auth', 'laboran'])->prefix('laboran')->name('laboran.')->group(function () {
    
    // Rute Dashboard (dari Tahap 5)
    // Nama: admin.laboran.dashboard
    Route::get('/dashboard', [LaboranDash::class, 'index'])->name('dashboard');

    // Nanti rute CRUD Alat Lab akan ditambahkan di sini
});