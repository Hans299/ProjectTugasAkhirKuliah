{{-- Ini adalah halaman untuk PINJAMAN AKTIF (BELUM DIKEMBALIKAN) --}}

@extends('Layout.siswa')

@section('title', 'Daftar Peminjaman Aktif')

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
    .tab-content {
        background-color: #2A5A3A; /* Warna hijau tabel */
        color: white;
        padding: 2rem;
        border-radius: 0 10px 10px 10px;
    }
    
    /* Styling Tabel */
    .table {
        color: white;
        border-color: #4a7c59;
    }
    .table th {
        border-bottom: 2px solid white;
        padding: 1rem;
    }
    .table td {
        vertical-align: middle;
        padding: 1rem;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: #2A5A3A;
        color: white;
    }
    .table-hover > tbody > tr:hover > * {
        background-color: #3a6a4a;
        color: white;
    }

    /* Styling Status Badge (sesuai desain tabel hijau) */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.9rem;
        color: #333;
    }
    .status-proses { background-color: #F8D442; } /* Kuning */
    .status-telat { background-color: #E63946; color: white; } /* Merah */
    
</style>
@endpush

@section('content')
<div class="content-wrapper">

    {{-- Header Halaman --}}
    <div class="page-header">
        <h2 class="page-title">Daftar Peminjaman (Saat Ini)</h2>
        <a href="{{ route('siswa.dasbor') }}" class="breadcrumb-link">Home Beranda</a>
    </div>

    @php
        $activeTab = request()->query('tab', 'buku');
    @endphp

    {{-- Navigasi Tab --}}
    <ul class="nav nav-tabs" id="peminjamanTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab == 'buku' ? 'active' : '' }}" 
               href="{{ route('siswa.pinjaman.index', ['tab' => 'buku']) }}">
               Buku
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $activeTab == 'alat' ? 'active' : '' }}" 
               href="{{ route('siswa.pinjaman.index', ['tab' => 'alat']) }}">
               Alat Lab
            </a>
        </li>
    </ul>

    {{-- Konten Tab --}}
    <div class="tab-content" id="peminjamanTabContent">
        
        {{-- ======================= TAB BUKU ======================= --}}
        <div class="tab-pane fade {{ $activeTab == 'buku' ? 'show active' : '' }}" id="buku" role="tabpanel">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Batas Pengembalian</th> {{-- Diubah dari "Tanggal Pengembalian" --}}
                            <th scope="col">Kategori Buku</th>
                            <th scope="col">Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ganti ini dengan loop data @forelse($peminjamanBukuAktif as $pinjam) --}}
                        <tr>
                            <td>Amanah oh Amanah</td>
                            <td>07/09/2025</td>
                            <td>10/09/2025</td>
                            <td>Buku Mata Pelajaran</td>
                            <td><span class="status-badge status-proses">Proses</span></td>
                        </tr>
                        <tr>
                            <td>Contoh Buku Telat</td>
                            <td>01/09/2025</td>
                            <td>04/09/2025</td> {{-- Tanggal batasnya sudah lewat --}}
                            <td>Buku Umum</td>
                            <td><span class="status-badge status-telat">Telat</span></td>
                        </tr>
                        {{-- @empty --}}
                        {{-- <tr><td colspan="5" class="text-center">Tidak ada buku yang sedang dipinjam.</td></tr> --}}
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
            {{-- $peminjamanBukuAktif->links() --}}
        </div>

        {{-- ======================= TAB ALAT LAB ======================= --}}
        <div class="tab-pane fade {{ $activeTab == 'alat' ? 'show active' : '' }}" id="alat" role="tabpanel">
             <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Alat Lab</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Batas Pengembalian</th>
                            <th scope="col">Kualitas</th>
                            <th scope="col">Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Ganti ini dengan loop data @forelse($peminjamanAlatAktif as $pinjam) --}}
                        <tr>
                            <td>Tabung Reaksi</td>
                            <td>07/09/2025</td>
                            <td>10/09/2025</td>
                            <td>Bagus</td>
                            <td><span class="status-badge status-proses">Proses</span></td>
                        </tr>
                         <tr>
                            <td>Gelas Ukur</td>
                            <td>01/09/2025</td>
                            <td>04/09/2025</td>
                            <td>Cukup Bagus</td>
                            <td><span class="status-badge status-telat">Telat</span></td>
                        </tr>
                        {{-- @empty --}}
                        {{-- <tr><td colspan="5" class="text-center">Tidak ada alat yang sedang dipinjam.</td></tr> --}}
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
            {{-- $peminjamanAlatAktif->links() --}}
        </div>
    </div>
</div>
@endsection