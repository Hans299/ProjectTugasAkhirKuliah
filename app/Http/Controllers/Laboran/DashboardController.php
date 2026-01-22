<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\AlatLab;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /** ================= STATISTIK ALAT ================= */
        $jumlahAlat = AlatLab::count();

        $alatTersedia = AlatLab::whereIn('kualitas', ['Baik', 'Sangat Baik'])->count();

        $alatRusak = AlatLab::where('kualitas', 'Buruk')->count();

        $alatDipinjam = Transaksi::where('itemable_type', AlatLab::class)
            ->where('status', 'dipinjam')
            ->count();

        /** ================= GRAFIK 7 HARI TERAKHIR ================= */
        $peminjaman7Hari = Transaksi::select(
            DB::raw('DATE(created_at) as tanggal'),
            DB::raw('COUNT(*) as total')
        )
            ->where('itemable_type', AlatLab::class)
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Siapkan label & data grafik (biar rapi di chart.js)
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($tanggal)->translatedFormat('l');

            $data[] = $peminjaman7Hari
                ->firstWhere('tanggal', $tanggal)
                ->total ?? 0;
        }

        $total7Hari = array_sum($data);

        return view('laboran.dashboard', compact(
            'jumlahAlat',
            'alatTersedia',
            'alatDipinjam',
            'alatRusak',
            'labels',
            'data',
            'total7Hari'
        ));
    }
}
