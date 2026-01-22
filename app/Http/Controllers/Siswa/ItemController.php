<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\AlatLab;

class ItemController extends Controller
{
    /**
     * Menampilkan halaman KATALOG BUKU
     */
    public function buku()
    {
        $bukus = Buku::where('stok', '>', 0)->orderBy('judul')->paginate(12);

        // Memanggil view: resources/views/siswa/pinjaman/index.blade.php
        return view('siswa.pinjaman.index', compact('bukus'));
    }

    /**
     * Menampilkan halaman KATALOG ALAT
     */
    public function alat()
    {
        $alats = AlatLab::where('stok', '>', 0)->orderBy('nama')->paginate(12);

        // Memanggil view: resources/views/siswa/pinjaman/index.blade.php
        return view('siswa.pinjaman.index', compact('alats'));
    }

    /**
     * Menampilkan halaman DETAIL BUKU
     */
    public function showBuku($buku)
    {
        $item = Buku::where('isbn', $buku)->firstOrFail();

        return view('siswa.item.show', [
            'item' => $item,
            'type' => 'buku',
        ]);
    }

    /**
     * Menampilkan halaman DETAIL ALAT
     */
    public function showAlat($alat)
    {
        $item = AlatLab::where('id_alat', $alat)->firstOrFail();

        return view('siswa.item.show', [
            'item' => $item,
            'type' => 'alat',
        ]);
    }
}
