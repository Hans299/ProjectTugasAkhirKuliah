<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\AlatLab;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard (hub utama) siswa.
     */
    public function index()
    {
        $searchBuku = request('search_buku');
        $searchAlat = request('search_alat');
        $filterBuku = request('filter_buku');

        // Proteksi role siswa
        if (Auth::check() && Auth::user()->role->name !== 'siswa') {
            Auth::logout();
            return redirect()->route('login');
        }

        // Ambil 10 BUKU stok hampir habis (stok > 0)
        $bukuPrioritas = Buku::where('stok', '>', 0)
            ->where('stok', '<', 10)
            ->get()
            ->map(function ($item) {
                $item->id = $item->isbn;
                $item->type = 'buku';
                $item->nama = $item->judul_buku;
                return $item;
            });

        // Ambil 10 ALAT LAB stok hampir habis (stok > 0)
        $alatPrioritas = AlatLab::where('stok', '>', 0)
            ->where('stok', '<', 10)
            ->get()
            ->map(function ($item) {
                $item->id = $item->id_alat;
                $item->type = 'alat';
                $item->nama = $item->nama_alat;
                $item->kategori = 'Kualitas ' . $item->kualitas;
                return $item;
            });

        $items = $bukuPrioritas->concat($alatPrioritas)->shuffle();
        $kurang = 20 - $items->count();

        // Gabungkan jadi satu koleksi
        if ($kurang > 0) {
            $additionalBuku = Buku::where('stok', '>', 0)
                ->where('stok', '>=', 10)
                ->inRandomOrder()
                ->take($kurang)
                ->get()
                ->map(function ($item) {
                    $item->id = $item->isbn;
                    $item->type = 'buku';
                    $item->nama = $item->judul_buku;
                    return $item;
                });

            $additionalAlat = AlatLab::where('stok', '>', 0)
                ->where('stok', '>=', 10)
                ->inRandomOrder()
                ->take($kurang)
                ->get()
                ->map(function ($item) {
                    $item->id = $item->id_alat;
                    $item->type = 'alat';
                    $item->nama = $item->nama_alat;
                    $item->kategori = 'Kualitas ' . $item->kualitas;
                    return $item;
                });

            $items = $items->concat($additionalBuku)->concat($additionalAlat)->shuffle()->take(20);

            $listbuku = Buku::where('stok', '>', 0)
                ->when($searchBuku, function ($query) use ($searchBuku) {
                    $query->where('judul_buku', 'like', "%{$searchBuku}%")
                        ->orWhere('penulis', 'like', "%{$searchBuku}%")
                        ->orWhere('penerbit', 'like', "%{$searchBuku}%")
                        ->orWhere('tahun_terbit', 'like', "%{$searchBuku}%")
                        ->orWhere('kategori', 'like', "%{$searchBuku}%")
                        ->orWhere('isbn', 'like', "%{$searchBuku}%");
                })
                ->when($filterBuku, function ($query) use ($filterBuku) {
                    if ($filterBuku === 'pelajaran') {
                        $query->where('kategori', 'Buku Mata Pelajaran');
                    }

                    if ($filterBuku === 'umum') {
                        $query->where('kategori', 'Buku Umum');
                    }
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'page_buku')
                ->withQueryString()
                ->through(function ($item) {
                    $item->id = $item->isbn;
                    $item->type = 'buku';
                    $item->nama = $item->judul_buku;
                    return $item;
                });
            $latestBukuId = Buku::where('stok', '>', 0)
                ->latest('created_at')
                ->value('isbn');


            $listalat = AlatLab::where('stok', '>', 0)
                ->when($searchAlat, function ($query) use ($searchAlat) {
                    $query->where('nama_alat', 'like', "%{$searchAlat}%")
                        ->orWhere('id_alat', 'like', "%{$searchAlat}%")
                        ->orWhere('kualitas', 'like', "%{$searchAlat}%");
                })
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'page_alat')
                ->withQueryString()
                ->through(function ($item) {
                    $item->id = $item->id_alat;
                    $item->type = 'alat';
                    $item->nama = $item->nama_alat;
                    $item->kategori = 'Kualitas ' . $item->kualitas;
                    return $item;
                });


            $latestAlatId = AlatLab::where('stok', '>', 0)
                ->latest('created_at')
                ->value('id_alat');
        }
        return view('siswa.dashboard', compact('items', 'listbuku', 'listalat', 'latestAlatId', 'latestBukuId'));
    }
}
