<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatLab extends Model
{

    protected $fillable = [
        'nama_alat',
        'id_alat',
        'deskripsi',
        'gambar',
        'stok',
        'kualitas',
    ];


    public function transakasis()
    {
        return $this->morphMany(Transaksi::class, 'itemable');
    }
}
