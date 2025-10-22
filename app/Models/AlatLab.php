<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatLab extends Model
{
    public function transakasis()
    {
        return $this->morphMany(Transaksi::class,'itemable');
    }
}
