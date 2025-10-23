{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Dashboard Superadmin')

@push('styles')
{{-- CSS khusus untuk kartu statistik (Sama seperti dashboard Laboran/Pustakawan) --}}
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
        min-height: 400px;
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
        {{-- Kolom Kiri: Kartu Statistik (8 Kartu) --}}
        <div class="col-lg-8">
            <div class="row g-4">
                
                {{-- Kartu 1: Jumlah Admin --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Admin</h5>
                                <span class="stat-card-number">{{ $jumlahAdmin ?? 100 }}</span>
                            </div>
                            <i class="fa fa-user-shield icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Jumlah Peminjaman Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Peminjaman Buku</h5>
                                <span class="stat-card-number">{{ $peminjamanBuku ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book-reader icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 3: Jumlah User --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah User</h5>
                                <span class="stat-card-number">{{ $jumlahUser ?? 100 }}</span>
                            </div>
                            <i class="fa fa-users icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 4: Jumlah Peminjaman Alat Lab --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Peminjaman Alat Lab</h5>
                                <span class="stat-card-number">{{ $peminjamanAlat ?? 100 }}</span>
                            </div>
                            <i class="fa fa-hand-holding icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 5: Jumlah Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Buku</h5>
                                <span class="stat-card-number">{{ $jumlahBuku ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 6: Jumlah Pengembalian Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Pengembalian Buku</h5>
                                <span class="stat-card-number">{{ $pengembalianBuku ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book-medical icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 7: Jumlah Alat Lab --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Alat Lab</h5>
                                <span class="stat-card-number">{{ $jumlahAlat ?? 100 }}</span>
                            </div>
                            <i class="fa fa-flask icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 8: Jumlah Pengembalian Alat Lab --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Pengembalian Alat Lab</h5>
                                <span class="stat-card-number">{{ $pengembalianAlat ?? 100 }}</span>
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