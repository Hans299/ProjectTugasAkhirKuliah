{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Dashboard Pustakawan')

@push('styles')
{{-- CSS khusus untuk kartu statistik --}}
<style>
    .stat-card {
        background-color: #25256C; /* Warna biru tua */
        color: white;
        border-radius: 12px;
        padding: 1.5rem;
    }
    .stat-card-title {
        font-size: 1.1rem;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .stat-card-number {
        font-size: 2.25rem;
        font-weight: 700;
    }
    .stat-card .icon {
        font-size: 2rem;
        opacity: 0.8;
    }
    .calendar-placeholder {
        background-color: #D9D9D9;
        border-radius: 12px;
        min-height: 400px; /* Tinggi minimal kalender */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 600;
        color: #6c757d;
    }
</style>
@endpush

@section('content')
    
    <div class="row g-4">
        {{-- Kolom Kiri: Kartu Statistik --}}
        <div class="col-lg-8">
            <div class="row g-4">
                
                {{-- Kartu 1: Jumlah Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Buku</h5>
                                {{-- Ganti $jumlahBuku dengan variabel dari Controller --}}
                                <span class="stat-card-number">{{ $jumlahBuku ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Jumlah Peminjaman Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Peminjaman Buku</h5>
                                <span class="stat-card-number">{{ $jumlahPeminjaman ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book-reader icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 3: Jumlah Pengembalian Buku --}}
                <div class="col-md-6"> {{-- Sesuai desain, kartu ini di baris baru --}}
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Pengembalian Buku</h5> {{-- Di desain tertulis "Pengembangan" --}}
                                <span class="stat-card-number">{{ $jumlahPengembalian ?? 100 }}</span>
                            </div>
                            <i class="fa fa-undo icon"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Kolom Kanan: Kalender --}}
        <div class="col-lg-4">
            <div class="calendar-placeholder">
                Kalender
            </div>
        </div>
    </div>
@endsection