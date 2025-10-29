{{-- Menggunakan layout 'tamu' (hijau) sebagai kerangka --}}
@extends('layouts.tamu')
@section('title', 'Dashboard Siswa')

@push('styles')
<style>
    /* (Ini adalah CSS dari langkah detail siswa sebelumnya) */
    body { background-color: #f4f7f6; }
    .welcome-card { background-color: #ffffff; border-radius: 12px; padding: 2.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .menu-card {
        display: block; text-decoration: none; background-color: #2A5A3A; color: white;
        padding: 2rem; border-radius: 10px; transition: all 0.2s ease-in-out;
    }
    .menu-card:hover { transform: translateY(-5px); background-color: #1D3A1F; color: white; box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .menu-card-icon { font-size: 3rem; margin-bottom: 1rem; }
    .menu-card-title { font-size: 1.5rem; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="welcome-card text-center mb-5">
                <h1 class="display-5 fw-bold" style="color: #1D3A1F;">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h1>
                <p class="fs-5 text-muted">Silakan pilih layanan yang Anda butuhkan.</p>
            </div>

            <div class="row">
                {{-- Link ke Daftar Buku (sesuai rute kita) --}}
                <div class="col-md-4 mb-4">
                    <a href="{{ route('siswa.pinjaman.buku') }}" class="menu-card text-center">
                        <div class="menu-card-icon"><i class="fas fa-book"></i></div>
                        <h2 class="menu-card-title">Perpustakaan</h2>
                    </a>
                </div>

                {{-- Link ke Daftar Alat (sesuai rute kita) --}}
                <div class="col-md-4 mb-4">
                    <a href="{{ route('siswa.pinjaman.alat') }}" class="menu-card text-center">
                        <div class="menu-card-icon"><i class="fas fa-flask"></i></div>
                        <h2 class="menu-card-title">Laboratorium</h2>
                    </a>
                </div>
                
                {{-- Link ke Riwayat (sesuai rute kita) --}}
                <div class="col-md-4 mb-4">
                    <a href="{{ route('siswa.pinjaman.riwayat') }}" class="menu-card text-center" style="background-color: #F8D442; color: #333;">
                        <div class="menu-card-icon"><i class="fas fa-history"></i></div>
                        <h2 class="menu-card-title">Riwayat Saya</h2>
                    </a>
                </div>
            </div>

            {{-- Tombol Logout --}}
            <div class="text-center mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection