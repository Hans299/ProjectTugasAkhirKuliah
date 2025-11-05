<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Kontroler untuk Login Admin (Tamu)
use App\Http\Controllers\Auth\AdminLoginController;

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
    // Arahkan ke halaman login siswa secara default
    return redirect()->route('login');
});

// 2. Rute Login Admin (Masih Rute Tamu)
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);

// 3. Rute Bawaan Laravel untuk Autentikasi SISWA
// Ini akan otomatis membuat /login, /register, /logout untuk siswa
Auth::routes();


/*
|--------------------------------------------------------------------------
| Rute SISWA (Harus Login sebagai Siswa)
|--------------------------------------------------------------------------
*/

// == Grup SISWA ==
// Semua rute di sini dilindungi middleware 'auth' dan 'siswa'
// Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    
    // 1. Dashboard (Hub Utama)
    // Nama: siswa.dashboard
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
    // (A) Tampilkan Form Upload Foto
    // Nama: siswa.pinjaman.kembalikan.form
    Route::get('/kembalikan/{transaksi}', [SiswaTransaksi::class, 'showKembaliForm'])->name('pinjaman.kembalikan.form');
    // (B) Proses Form Upload Foto
    // Nama: siswa.pinjaman.kembalikan.store
    Route::post('/kembalikan/{transaksi}', [SiswaTransaksi::class, 'storePengembalian'])->name('pinjaman.kembalikan.store');

// });