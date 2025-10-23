{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Transaksi Perpustakaan')

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
    
    /* Styling Tab (Biru muda dan biru tua) */
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
        background-color: #25256C; /* Biru tua */
        color: white;
    }
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
        background-color: #f8f9fa;
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
    <h2 class="page-title mb-4">Transaksi Perpustakaan</h2>

    {{-- Kartu Konten Utama (Tab & Tabel) --}}
    <div class="content-card">
        
        @php
            // Desain Anda memiliki 2 tab: Peminjaman (kiri atas) & Pengembalian (kiri bawah)
            $activeTab = request()->query('tab', 'peminjaman'); 
        @endphp

        {{-- Navigasi Tab --}}
        <ul class="nav nav-tabs" id="transaksiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'peminjaman' ? 'active' : '' }}" 
                   href="{{ route('pustakawan.transaksi.index', ['tab' => 'peminjaman']) }}">
                   Peminjaman
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $activeTab == 'pengembalian' ? 'active' : '' }}" 
                   href="{{ route('pustakawan.transaksi.index', ['tab' => 'pengembalian']) }}">
                   Pengembalian
                </a>
            </li>
        </ul>

        {{-- Konten Tab --}}
        <div class="tab-content p-4">
            
            {{-- ======================= TAB PEMINJAMAN (Desain Kiri Atas) ======================= --}}
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
                                <th scope="col