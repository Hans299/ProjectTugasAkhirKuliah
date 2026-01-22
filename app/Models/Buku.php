<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{

    protected $fillable = [
        'judul_buku',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'isbn',
        'halaman',
        'deskripsi',
        'gambar',
        'stok',
        'kategori',
    ];

    public function transaksis()
    {
        return $this->morphMany(Transaksi::class, 'itemable');
    }
}
