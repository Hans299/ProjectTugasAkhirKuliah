<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * (Atribut yang boleh diisi secara massal)
     */
    protected $guarded = ['id']; // 'guarded' adalah kebalikan dari 'fillable'. Ini bagus.

    /**
     * Get the attributes that should be cast.
     * (Ambil atribut yang harus di-cast / diubah tipenya)
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            // Ubah kolom-kolom ini menjadi objek Carbon (date)
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
            'tanggal_pengembalian_aktual' => 'date',
        ];
    }

    /**
     * Mendapatkan user (siswa) yang meminjam.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Mendapatkan admin (pustakawan/laboran) yang menyetujui.
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Mendapatkan item yang dipinjam (bisa Buku atau AlatLab).
     */
    public function itemable()
    {
        return $this->morphTo();
    }
}