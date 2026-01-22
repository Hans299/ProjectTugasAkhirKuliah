<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Kontroler untuk Login Admin (Tamu)
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Profile\ProfileController;
// Kontroler untuk SISWA (BARU)
use App\Http\Controllers\Siswa\DashboardController as SiswaDash;
use App\Http\Controllers\Siswa\ItemController as SiswaItem;
use App\Http\Controllers\Siswa\TransaksiController as SiswaTransaksi;

/*
|--------------------------------------------------------------------------
| Rute Web (Tamu & Siswa)
|--------------------------------------------------------------------------
|
| File ini HANYA mengurus rute publik (Tamu) dan rute
| yang diautentikasi sebagai Siswa.
|
*/

// == RUTE TAMU (Guest) ==

// 1. Rute Halaman Utama (Landing Page)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Rute Lupa Password dengan OTP
Route::get('/lupa-password', [ResetPasswordController::class, 'showEmailForm'])
    ->name('password.request');

Route::post('/lupa-password', [ResetPasswordController::class, 'sendOtp'])
    ->name('password.otp.send');

Route::get('/reset-password/{email}', [ResetPasswordController::class, 'showOtpForm'])
    ->name('password.otp.form');

Route::post('/reset-password', [ResetPasswordController::class, 'resetWithOtp'])
    ->name('password.otp.reset');



// 2. Rute Login Admin (Masih Rute Tamu)
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

// 3. Rute Profil (Harus Login)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| Rute SISWA (Harus Login sebagai Siswa)
|--------------------------------------------------------------------------
*/

// == Grup SISWA ==
// Semua rute di sini dilindungi middleware 'auth' dan 'siswa'
Route::middleware(['auth', 'siswa'])->prefix('/siswa')->name('siswa.')->group(function () {

    // 1. Dashboard (Hub Utama)
    // Nama: siswa.dashboard
    // Route::middleware(['auth', 'siswa'])->group(function () {
    Route::get('/dashboard', [SiswaDash::class, 'index'])->name('dashboard');

    // 2. Halaman Katalog (Daftar Item)
    // Nama: siswa.pinjaman.buku
    Route::get('/buku', [SiswaItem::class, 'buku'])->name('pinjaman.buku');
    // Nama: siswa.pinjaman.alat
    Route::get('/alat', [SiswaItem::class, 'alat'])->name('pinjaman.alat');

    // 3. Halaman Detail Item
    // Nama: siswa.item.show.buku
    Route::get('/buku/{buku}', [SiswaItem::class, 'showBuku'])->name('item.show.buku');
    // Nama: siswa.item.show.alat
    Route::get('/alat/{alat}', [SiswaItem::class, 'showAlat'])->name('item.show.alat');

    // 4. Halaman Riwayat Peminjaman
    // Nama: siswa.pinjaman.riwayat
    Route::get('/riwayat', [SiswaTransaksi::class, 'riwayat'])->name('pinjaman.riwayat');

    // 5. ALUR FORM PINJAM
    // (A) Tampilkan Form Konfirmasi Pinjam
    // Nama: siswa.pinjaman.create
    Route::get('/pinjam/{item_type}/{item_id}', [SiswaTransaksi::class, 'showPinjamForm'])->name('pinjaman.create');
    // (B) Proses Form Konfirmasi Pinjam
    // Nama: siswa.pinjaman.store
    Route::post('/pinjam/store', [SiswaTransaksi::class, 'storePeminjaman'])->name('pinjaman.store');

    // 6. ALUR FORM KEMBALIKAN (DENGAN FOTO)
    Route::get('/pengembalian', [SiswaTransaksi::class, 'showAksiPengembalian'])->name('pinjaman.pengembalian');
    // (A) Tampilkan Form Upload Foto
    // Nama: siswa.pinjaman.kembalikan.form
    Route::get('/kembalikan/{transaksi}', [SiswaTransaksi::class, 'showKembaliForm'])->name('pinjaman.kembalikan.form');
    // (B) Proses Form Upload Foto
    // Nama: siswa.pinjaman.kembalikan.store
    Route::post('/kembalikan/{transaksi}', [SiswaTransaksi::class, 'storePengembalian'])->name('pinjaman.kembalikan.store');
});
// });
