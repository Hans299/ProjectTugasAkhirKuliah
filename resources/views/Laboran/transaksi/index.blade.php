{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Transaksi Alat Lab')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .content-card {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: #fff;
    }
    
    /* Styling Tab */
    .nav-tabs {
        border-bottom: none;
        padding: 1rem 1rem 0 1rem;
    }
    .nav-tabs .nav-link {
        border: none;
        border-radius: 8px 8px 0 0;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
    }
    /* Tab Tidak Aktif (sesuai desain) */
    .nav-tabs .nav-link:not(.active) {
        background-color: #25256C; /* Biru tua */
        color: white;
    }
    /* Tab Aktif (sesuai desain) */
    .nav-tabs .nav-link.active {
        background-color: #E0E7FF; /* Biru muda */
        color: #25256C; /* Biru tua */
    }

    /* Styling Tabel */
    .table thead th {
        background-color: #25256C; /* Header tabel biru tua */
        color: white;
        text-align: center;
        vertical-align: middle;
        padding: 1rem;
        border-bottom: none;
    }
    .table tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 1rem;
        color: #333;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: #f8f9fa; /* Warna belang abu-abu muda */
    }
    .table-hover > tbody > tr:hover > * {
        background-color: #e9ecef;
    }

    /* Tombol Aksi */
    .action-buttons .btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px;
    }
    .btn-lihat { background-color: #0d6efd; color: white; }
    .btn-setuju { background-color: #198754; color: white; }
    .btn-tolak { background-color: #dc3545; color: white; }

</style>@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul) --}}
    <h2 class="page-title mb-4">Transaksi Alat Lab</h2>

    {{-- Kartu Konten Utama (Tab & Tabel) --}}
    <div class="content-card">
        
        @php
            // Logika untuk menentukan tab aktif
            // Desain Anda menunjukkan 'pengembalian' sebagai default
            $activeTab = request()->query('tab', 'pengembalian');
        @endphp

        {{-- Navigasi Tab --}}
        <ul class="nav nav-tabs" id="transaksiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'peminjaman' ? 'active' : '' }}" 
                   href="{{ route('laboran.transaksi.index', ['tab' => 'peminjaman']) }}">
                   Peminjaman
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'pengembalian' ? 'active' : '' }}" 
                   href="{{ route('laboran.transaksi.index', ['tab' => 'pengembalian']) }}">
                   Pengembalian
                </a>
            </li>
        </ul>

        {{-- Konten Tab --}}
        <div class="tab-content p-4">
            
            {{-- ======================= TAB PEMINJAMAN ======================= --}}
            {{-- Ini adalah tab untuk menyetujui permintaan pinjaman BARU --}}
            <div class="tab-pane fade {{ $activeTab == 'peminjaman' ? 'show active' : '' }}" id="peminjaman" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Alat Lab</th>
                                <th scope="col">Kualitas Barang</th>
                                <th scope="col">Jumlah Alat Lab Dipinjam</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Batas Pengembalian</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- 
                              Ganti ini dengan loop data dari Controller
                              @forelse($daftarPeminjaman as $transaksi) 
                            --}}
                            <tr>
                                <td>Contoh Siswa</td>
                                <td>Gelas Ukur</td>
                                <td>Baik</td>
                                <td>5</td>
                                <td>21/09/2025</td>
                                <td>24/09/2025</td>
                                <td class="action-buttons">
                                    <a href="#" class="btn btn-lihat"><i class="fa fa-eye"></i></a>
                                    <a href="#" class="btn btn-setuju"><i class="fa fa-check"></i></a>
                                    <a href="#" class="btn btn-tolak"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>
                            {{-- @empty --}}
                            {{-- <tr><td colspan="7" class="text-center">Tidak ada permintaan peminjaman baru.</td></tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                {{-- $daftarPeminjaman->links() --}}
            </div>

            {{-- ======================= TAB PENGEMBALIAN ======================= --}}
            {{-- Ini adalah tab untuk mengonfirmasi pengembalian (sesuai desain) --}}
            <div class="tab-pane fade {{ $activeTab == 'pengembalian' ? 'show active'