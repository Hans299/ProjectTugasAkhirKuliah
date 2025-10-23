<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Superadmin\DashboardController as SuperadminDash;
use App\Http\Controllers\Pustakawan\DashboardController as PustakawanDash;
use App\Http\Controllers\Laboran\DashboardController as LaboranDash;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard',[SuperadminDash::class,'index'])->name('dashboard');
});
Route::middleware(['auth', 'laboran'])->prefix('laboran')->name('laboran.')->group(function () {
    Route::get('/dashboard',[LaboranDash::class,'index'])->name('dashboard');
});
Route::middleware(['auth', 'pustakawan'])->prefix('pustakawan')->name('pustakawan.')->group(function () {
    Route::get('/dashboard', [PustakawanDash::class, 'index'])->name('dashboard');
});
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
