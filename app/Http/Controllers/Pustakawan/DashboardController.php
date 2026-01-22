<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        /** ================= JUMLAH BUKU ================= */
        $jumlahBuku = Buku::count();

        /** ================= JUMLAH PEMINJAMAN ================= */
        $jumlahPeminjaman = Transaksi::where('itemable_type', Buku::class)
            ->where('status', 'dipinjam')
            ->count();

        /** ================= JUMLAH PENGEMBALIAN ================= */
        $jumlahPengembalian = Transaksi::where('itemable_type', Buku::class)
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

        return view('pustakawan.dashboard', compact(
            'jumlahBuku',
            'jumlahPeminjaman',
            'jumlahPengembalian',
            'holidays',
            'year'
        ));
    }
}
