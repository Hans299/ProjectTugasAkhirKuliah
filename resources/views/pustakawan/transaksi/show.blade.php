{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Judul akan dinamis --}}
@section('title', 'Detail Transaksi')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .page-title .breadcrumb-link {
        color: #6c757d;
        text-decoration: none;
    }
    .page-title .breadcrumb-link:hover {
        color: #333;
    }
    .form-card {
        border-radius: 12px;
        border: 2px solid #25256C; /* Border biru tua */
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 2.5rem;
        background-color: #fff;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-control[readonly] {
        background-color: #fff; /* Sesuai desain, field tidak di-grey */
        border: 1px solid #ced4da;
    }
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-kembali {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border: 1px solid #ced4da;
    }
</style>
@endpush

@section('content')
    
    {{-- 
      Variabel $transaksi harus Anda kirim dari Controller.
      Kita akan cek apakah $transaksi punya 'denda' untuk menentukan judul
    --}}
    @php
        $isPengembalian = isset($transaksi->denda);
    @endphp

    <h2 class="page-title mb-4">
        <a href="{{ route('pustakawan.transaksi.index') }}" class="breadcrumb-link">Transaksi Perpustakaan</a> > 
        {{ $isPengembalian ? 'Detail Pengembalian' : 'Detail Peminjaman' }}
    </h2>

    <div class="form-card">
        
        <div class="row g-4">
            
            {{-- Kolom Kiri --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $transaksi->user->email ?? 'Nama@gmail.com' }}" readonly>
                </div>
                <div class="mb-3">
                    {{-- Desain "Detail Pengembalian" (kanan bawah) tidak punya field "Nama Guru", jadi kita gabung --}}
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" value="{{ $transaksi->user->name ?? 'Hans Bonatua' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" value="{{ $transaksi->user->kelas ?? 'XI' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="judul_buku" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul_buku" value="{{ $transaksi->item->judul_buku ?? 'Amanah Oh Amanah' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori Buku</label>
                    <input type="text" class="form-control" id="kategori" value="{{ $transaksi->item->kategori ?? 'Buku Mata Pelajaran' }}" readonly>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-6">
                 <div class="mb-3">
                    <label for="jumlah_buku" class="form-label">Jumlah Peminjaman</label>
                    <input type="text" class="form-control" id="jumlah_buku" value="{{ $transaksi->jumlah ?? 1 }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tgl_pinjam" class="form-label">Tanggal Peminjaman</label>
                    <input type="text" class="form-control" id="tgl_pinjam" value="{{ $transaksi->tanggal_pinjam->format('d/m/Y') ?? '21/09/2025' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tgl_kembali" class="form-label">Tanggal Pengembalian</label>
                    <input type="text" class="form-control" id="tgl_kembali" value="{{ $transaksi->tanggal_kembali->format