<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;
use App\Models\AlatLab;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        /* ===============================
         | JUMLAH USER & ADMIN
         =============================== */
        $jumlahAdmin = User::whereIn('role_id', [1, 2, 3])->count();
        $jumlahUser  = User::where('role_id', 4)->count();

        /* ===============================
         | DATA MASTER
         =============================== */
        $jumlahBuku = Buku::count();
        $jumlahAlat = AlatLab::count();

        /* ===============================
         | TRANSAKSI PEMINJAMAN
         =============================== */
        $peminjamanBuku = Transaksi::where('itemable_type', Buku::class)
            ->where('status', 'dipinjam')
            ->count();

        $peminjamanAlat = Transaksi::where('itemable_type', AlatLab::class)
            ->where('status', 'dipinjam')
            ->count();

        /* ===============================
         | TRANSAKSI PENGEMBALIAN
         =============================== */
        $pengembalianBuku = Transaksi::where('itemable_type', Buku::class)
            ->where('status', 'dikembalikan')
            ->count();

        $pengembalianAlat = Transaksi::where('itemable_type', AlatLab::class)
            ->where('status', 'dikembalikan')
            ->count();


        $year = now()->year;
        $path = "holidays/holidays-{$year}.json";

        if (!Storage::exists($path)) {
            $holidays = [];
        } else {
            $holidays = json_decode(
                Storage::get($path),
                true
            );
        }

        return view('SuperAdmin.dashboard', compact(
            'jumlahAdmin',
            'jumlahUser',
            'jumlahBuku',
            'jumlahAlat',
            'peminjamanBuku',
            'peminjamanAlat',
            'pengembalianBuku',
            'pengembalianAlat',
            'holidays',
            'year'
        ));
    }
}
