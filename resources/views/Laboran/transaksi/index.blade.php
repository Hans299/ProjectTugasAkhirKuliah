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
    }@extends('layouts.admin') {{-- Ganti ini jika nama layout admin Anda berbeda --}}
@section('title', 'Manajemen Transaksi Alat Lab')

@push('styles')
<style>
    .nav-tabs .nav-link.active {
        background-color: #25256C; /* Sesuaikan dengan warna sidebar Anda */
        color: white;
        border-color: #25256C;
    }
    .nav-tabs .nav-link {
        color: #25256C;
    }
    .img-thumbnail-small {
        width: 100px;
        height: 100px;
        object-fit: cover;
    }
    .action-buttons form {
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="container-fluid my-4">
    <h1 class="h3 mb-4 text-gray-800">Manajemen Transaksi Alat Lab</h1>

    {{-- Tampilkan Pesan Sukses/Error dari Controller --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    {{-- Navigasi Tab --}}
    <ul class="nav nav-tabs" id="transaksiTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                Permintaan Pending <span class="badge bg-danger">{{ $pending->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="menunggu-tab" data-bs-toggle="tab" data-bs-target="#menunggu" type="button" role="tab" aria-controls="menunggu" aria-selected="false">
                Menunggu Konfirmasi <span class="badge bg-warning text-dark">{{ $menunggu_konfirmasi->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="dipinjam-tab" data-bs-toggle="tab" data-bs-target="#dipinjam" type="button" role="tab" aria-controls="dipinjam" aria-selected="false">
                Sedang Dipinjam <span class="badge bg-info">{{ $dipinjam->count() }}</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">
                Riwayat Selesai
            </button>
        </li>
    </ul>

    {{-- Konten Tab (Memanggil Partial Views Laboran) --}}
    <div class="tab-content" id="transaksiTabContent">
        
        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            @include('laboran.transaksi._table_pending', ['transaksis' => $pending])
        </div>
        
        <div class="tab-pane fade" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
            @include('laboran.transaksi._table_menunggu', ['transaksis' => $menunggu_konfirmasi])
        </div>

        <div class="tab-pane fade" id="dipinjam" role="tabpanel" aria-labelledby="dipinjam-tab">
            @include('laboran.transaksi._table_dipinjam', ['transaksis' => $dipinjam])
        </div>

        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
            @include('laboran.transaksi._table_selesai', ['transaksis' => $selesai])
        </div>
    </div>

</div>
@endsection
    
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