<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public function transaksis()
    {
        return $this->morphMany(Transaksi::class,'itemable');
    }
}
