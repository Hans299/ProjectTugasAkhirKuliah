<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard (hub utama) siswa.
     */
    public function index()
    {
        // Memanggil view: resources/views/siswa/dashboard.blade.php
        return view('siswa.dashboard');
    }
}