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
    public function showBuku(Buku $buku)
    {
        // Memanggil view: resources/views/siswa/item/show.blade.php
        return view('siswa.item.show', compact('buku'));
    }
    
    /**
     * Menampilkan halaman DETAIL ALAT
     */
    public function showAlat(AlatLab $alat)
    {
        // Memanggil view: resources/views/siswa/item/show.blade.php
        return view('siswa.item.show', compact('alat'));
    }
}