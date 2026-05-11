{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Laporan Transaksi Perpustakaan')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .content-card, .filter-card {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background-color: #fff;
        padding: 2rem;
    }
    
    /* Tombol Cetak & Filter */
    .btn-print {
        background-color: #0d6efd; /* Biru */
        color: white;
        font-weight: 600;
    }
    .btn-filter {
        background-color: #0d6efd; /* Biru */
        color: white;
        font-weight: 600;
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
    .nav-tabs .nav-link:not(.active) {
        background-color: #25256C;
        color: white;
    }
    .nav-tabs .nav-link.active {
        background-color: #E0E7FF;
        color: #25256C;
    }

    /* Styling Tabel */
    .table thead th {
        background-color: #25256C;
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
        background-color: #f8f9fa;
    }
</style>@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Tombol Cetak) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Total Transaksi Perpustakaan</h2>
        <a href="#" class="btn btn-print"> {{-- Nanti bisa diganti JS: onclick="window.print()" --}}
            <i class="fa fa-print me-2"></i> Cetak
        </a>
    </div>

    {{-- KARTU UNTUK FILTER TANGGAL --}}
    <div class="filter-card mb-4">
        <form action="{{ route('pustakawan.transaksi.laporan') }}" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="tanggal_mulai" class="form-label fw-bold">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-5">
                    <label for="tanggal_selesai" class="form-label fw-bold">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-filter w-100">Filter</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Kartu Konten Utama (Tab & Tabel) --}}
    <div class="content-card">
        
        @php
            $activeTab = request()->query('tab', 'peminjaman');
        @endphp

        {{-- Navigasi Tab --}}
        <ul class="nav nav-tabs" id="transaksiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'peminjaman' ? 'active' : '' }}" 
                   href="{{ route('pustakawan.transaksi.laporan', ['tab' => 'peminjaman'] + request()->except('tab')) }}">
                   Peminjaman
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'pengembalian' ? 'active' : '' }}" 
                   href="{{ route('pustakawan.transaksi.laporan', ['tab' => 'pengembalian'] + request()->except('tab')) }}">
                   Pengembalian
                </a>
            </li>
        </ul>

        {{-- Konten Tab --}}
        <div class="tab-content p-4">
            
            {{-- ======================= TAB PEMINJAMAN (Desain Kiri) ======================= --}}
            <div class="tab-pane fade {{ $activeTab == 'peminjaman' ? 'show active' : '' }}" id="peminjaman" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Kategori Buku</th>
                                <th scope="col">Jumlah Buku Dipinjam</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                {{-- Kolom Aksi dihilangkan di laporan --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse($laporanPeminjaman as $transaksi) --}}
                            @for ($i = 0; $i < 9; $i++)
                            <tr>
                                <td>Hans Bonatua</td>
                                <td>Amanah Oh Amanah</td>
                                <td>{{ $i % 2 == 0 ? 'Buku Umum' : 'Buku Mata Pelajaran' }}</td>
                                <td>1</td>
                                <td>21/09/2025</td>
                                <td>24/09/2025</td>
                            </tr>
                            @endfor
                            {{-- @empty --}}
                            {{-- <tr><td colspan="6" class="text-center">Tidak ada data peminjaman pada rentang tanggal ini.</td></tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <nav aria-label="Page navigation" class="d-flex justify-content-end mt-3"><ul class="pagination"><li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">3</a></li><li class="page-item"><a class="page-link" href="#">&raquo;</a></li></ul></nav>
            </div>

            {{-- ======================= TAB PENGEMBALIAN (Desain Kanan) ======================= --}}
            <div class="tab-pane fade {{ $activeTab == 'pengembalian' ? 'show active' : '' }}" id="pengembalian" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nama</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Kategori Buku</th>
                                <th scope="col">Denda</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                {{-- Kolom Aksi dihilangkan di laporan --}}
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse($laporanPengembalian as $transaksi) --}}
                             @for ($i = 0; $i < 9; $i++)
                            <tr>
                                <td>Hans Bonatua</td>
                                <td>Amanah Oh Amanah</td>
                                <td>{{ $i % 2 == 0 ? 'Buku Umum' : 'Buku Mata Pelajaran' }}</td>
                                <td>Rp 1000</td>
                                <td>21/09/2025</td>
                                <td>24/09/2025</td>
                            </tr>
                            @endfor
                            {{-- @empty --}}
                            {{-- <tr><td colspan="6" class="text-center">Tidak ada data pengembalian pada rentang tanggal ini.</td></tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
                 {{-- Pagination --}}
                <nav aria-label="Page navigation" class="d-flex justify-content-end mt-3"><ul class="pagination"><li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li><li class="page-item active"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="#">2</a></li><li class="page-item"><a class="page-link" href="#">3</a></li><li class="page-item"><a class="page-link" href="#">&raquo;</a></li></ul></nav>
            </div>
        </div>
    </div>
@endsection