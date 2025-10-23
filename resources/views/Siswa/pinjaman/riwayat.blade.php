{{-- Menggunakan layout 'siswa' sebagai kerangka --}}
@extends('Layout.siswa')

{{-- Mengatur judul halaman --}}
@section('title', 'Riwayat Pengembalian')

{{-- Menambahkan CSS kustom HANYA untuk halaman ini --}}
@push('styles')
<style>
    .content-wrapper { padding: 2rem 3rem; color: white; width: 100%; }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-title { font-weight: 600; font-size: 1.75rem; margin: 0; }
    .breadcrumb-link { color: #f0f0f0; text-decoration: none; font-size: 1rem; font-weight: 500; }
    .breadcrumb-link:hover { color: #F8D442; }

    /* Styling untuk Tab (Buku & Alat Lab) */
    .nav-tabs .nav-link {
        background-color: #fff;
        color: #333;
        border: none;
        border-radius: 20px 20px 0 0;
        margin-right: 0.5rem;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    .nav-tabs .nav-link.active {
        background-color: #F8D442; /* Kuning */
        color: #333;
    }
    .nav-tabs {
        border-bottom: none;
    }
    
    /* Konten tab transparan, karena tabel punya background sendiri */
    .tab-content {
        background-color: transparent;
        padding: 0;
    }

    /* Kontainer Tabel (background putih) */
    .table-container {
        background-color: #ffffff;
        color: #333; /* Teks di dalam tabel menjadi gelap */
        padding: 2rem;
        border-radius: 10px;
    }

    /* Filter Bar (Search & Dropdown) */
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .search-bar {
        position: relative;
    }
    .search-bar input {
        border-radius: 8px;
        padding-right: 3rem; /* Ruang untuk ikon */
    }
    .search-bar .search-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
    }
    .filter-dropdowns {
        display: flex;
        gap: 1rem;
    }
    
    /* Styling Tabel (versi gelap di atas putih) */
    .table {
        color: #333; /* Teks tabel gelap */
        border-color: #e0e0e0;
    }
    .table th {
        border-bottom: 2px solid #333;
        padding: 1rem;
        color: #000;
        font-weight: 600;
        text-align: center; /* Sesuai desain */
    }
    .table td {
        vertical-align: middle;
        padding: 1rem;
        text-align: center; /* Sesuai desain */
    }
    .table-hover > tbody > tr:hover > * {
        background-color: #f8f9fa; /* Hover abu-abu muda */
        color: #333;
    }

    /* Badge Status (sesuai desain baru) */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        color: white;
        display: inline-block;
    }
    .status-selesai { background-color: #0d6efd; } /* Biru (Selesai) */
    .status-denda { background-color: #dc3545; } /* Merah (Denda) */
    
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
<div class="content-wrapper">

    {{-- Header Halaman --}}
    <div class="page-header">
        <h2 class="page-title">Daftar Pengembalian</h2>
        <a href="{{ route('siswa.dasbor') }}" class="breadcrumb-link">Home Beranda</a>
    </div>

    @php
        $activeTab = request()->query('tab', 'buku');
    @endphp

    {{-- Navigasi Tab --}}
    <ul class="nav nav-tabs" id="riwayatTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab == 'buku' ? 'active' : '' }}" 
               href="{{ route('siswa.pinjaman.riwayat', ['tab' => 'buku']) }}">
               Buku
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab == 'alat' ? 'active' : '' }}" 
               href="{{ route('siswa.pinjaman.riwayat', ['tab' => 'alat']) }}">
               Alat Lab
            </a>
        </li>
    </ul>

    {{-- Konten Tab --}}
    <div class="tab-content" id="riwayatTabContent">
        
        {{-- ======================= TAB BUKU ======================= --}}
        <div class="tab-pane fade {{ $activeTab == 'buku' ? 'show active' : '' }}" id="buku" role="tabpanel">
            
            {{-- Kontainer Tabel Putih --}}
            <div class="table-container mt-3">
                
                {{-- Filter Bar (Search & Dropdowns) --}}
                <div class="filter-bar">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="Cari Buku">
                        <span class="search-icon">🔍</span>
                    </div>
                    <div class="filter-dropdowns">
                        {{-- Menggunakan nama "Jenis Buku" dan "Penyetelan" sesuai desain --}}
                        <select class="form-select" style="min-width: 180px;">
                            <option selected>Jenis Buku</option>
                            <option value="pelajaran">Buku Mata Pelajaran</option>
                            <option value="umum">Buku Umum</option>
                        </select>
                        <select class="form-select" style="min-width: 150px;">
                            <option selected>Penyetelan</option>
                        </select>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            {{-- Desain "Detail Buku" (kanan) memiliki kolom "Upload Struk" --}}
                            @if($activeTab == 'buku' && in_array('Upload Struk', $kolomBuku)) {{-- Logika kustom jika ada kolom beda --}}
                            <tr>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Tanggal Pinjam</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Keterlambatan</th>
                                <th scope="col">Denda</th>
                                <th scope="col">Upload Struk</th>
                                <th scope="col">Status</th>
                            </tr>
                            @else
                            {{-- Desain "Daftar Pengembalian" (kiri) --}}
                            <tr>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Tanggal Pinjam</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Keterlambatan</th>
                                <th scope="col">Denda</th>
                                <th scope="col">Status Peminjaman</th>
                            </tr>
                            @endif
                        </thead>
                        <tbody>
                            {{-- Ganti ini dengan loop data @forelse($riwayatBuku as $riwayat) --}}
                            <tr>
                                <td>Amanah oh Amanah</td>
                                <td>02/09/2025</td>
                                <td>05/09/2025</td>
                                <td>0 Hari</td>
                                <td>Rp 0</td>
                                <td><span class="status-badge status-selesai">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>Amanah oh Amanah</td>
                                <td>07/09/2025</td>
                                <td>10/09/2025</td>
                                <td>1 Hari</td>
                                <td>Rp 1.000</td>
                                <td><span class="status-badge status-denda">Denda</span></td>
                            </tr>
                            {{-- @empty --}}
                            {{-- <tr><td colspan="6" class="text-center">Tidak ada riwayat pengembalian buku.</td></tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
                {{-- Pagination (sesuai desain) --}}
                <nav aria-label="Page navigation" class="d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        {{-- ======================= TAB ALAT LAB ======================= --}}
        <div class="tab-pane fade {{ $activeTab == 'alat' ? 'show active' : '' }}" id="alat" role="tabpanel">
            
            {{-- Kontainer Tabel Putih --}}
            <div class="table-container mt-3">

                {{-- Filter Bar (Search Saja) --}}
                <div class="filter-bar">
                    <div class="search-bar">
                        <input type="text" class="form-control" placeholder="Cari Alat Lab">
                        <span class="search-icon">🔍</span>
                    </div>
                    <div class="filter-dropdowns">
                         <select class="form-select" style="min-width: 150px;">
                            <option selected>Penyetelan</option>
                        </select>
                    </div>
                </div>
                
                {{-- Tabel Data --}}
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            {{-- Kolom sesuai desain "Daftar Pengembalian" (tengah) --}}
                            <tr>
                                <th scope="col">Alat Lab</th>
                                <th scope="col">Tanggal Pinjam</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Keterlambatan</th>
                                <th scope="col">Denda</th>
                                <th scope="col">Status Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Ganti ini dengan loop data @forelse($riwayatAlat as $riwayat) --}}
                            <tr>
                                <td>Tabung Reaksi</td>
                                <td>07/09/2025</td>
                                <td>10/09/2025</td>
                                <td>0 Hari</td>
                                <td>Rp 0</td>
                                <td><span class="status-badge status-selesai">Selesai</span></td>
                            </tr>
                            <tr>
                                <td>Tabung Reaksi</td>
                                <td>07/09/2025</td>
                                <td>10/09/2025</td>
                                <td>1 Hari</td>
                                <td>Rp 1.000</td>
                                <td><span class="status-badge status-denda">Denda</span></td>
                            </tr>
                            {{-- @empty --}}
                            {{-- <tr><td colspan="6" class="text-center">Tidak ada riwayat pengembalian alat.</td></tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
                 {{-- Pagination (sesuai desain) --}}
                <nav aria-label="Page navigation" class="d-flex justify-content-end">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection