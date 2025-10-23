{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Detail Transaksi Alat Lab')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .page-title .breadcrumb-link {
        color: #6c757d; /* Warna abu-abu untuk link "Transaksi Alat Lab" */
        text-decoration: none;
    }
    .page-title .breadcrumb-link:hover {
        color: #333;
    }

    /* Kartu form */
    .form-card {
        border-radius: 12px;
        border: 2px solid #25256C; /* Border biru tua sesuai desain */
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 2.5rem;
        background-color: #fff;
    }

    /* Styling form */
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-control[readonly] {
        background-color: #fff; /* Sesuai desain, field tidak di-grey */
        border: 1px solid #ced4da;
    }

    /* Tombol Aksi */
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

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Breadcrumb) --}}
    <h2 class="page-title mb-4">
        <a href="{{ route('laboran.transaksi.index') }}" class="breadcrumb-link">Transaksi Alat Lab</a> > Detail Peminjaman
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- 
          Variabel $transaksi harus Anda kirim dari Controller.
          Ini berisi data peminjaman termasuk relasi ke user dan item.
        --}}
        <div class="row g-4">
            
            {{-- Kolom Kiri --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $transaksi->user->email ?? 'Nama@gmail.com' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" value="{{ $transaksi->user->name ?? 'Hans Bonatua' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas</label>
                    <input type="text" class="form-control" id="kelas" value="{{ $transaksi->user->kelas ?? 'XI' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="alat_lab" class="form-label">Alat Lab</label>
                    <input type="text" class="form-control" id="alat_lab" value="{{ $transaksi->item->nama ?? 'Tabung Reaksi' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="kualitas" class="form-label">Kualitas Alat</label>
                    <input type="text" class="form-control" id="kualitas" value="{{ $transaksi->item->kualitas ?? 'Bagus' }}" readonly>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="jumlah_alat" class="form-label">Jumlah Alat Lab Dipinjam</label>
                    <input type="text" class="form-control" id="jumlah_alat" value="{{ $transaksi->jumlah ?? 10 }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tgl_pinjam" class="form-label">Tanggal Peminjaman</label>
                    <input type="text" class="form-control" id="tgl_pinjam" value="{{ $transaksi->tanggal_pinjam->format('d/m/Y') ?? '21/09/2025' }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tgl_kembali" class="form-label">Tanggal Pengembalian</label>
                    <input type="text" class="form-control" id="tgl_kembali" value="{{ $transaksi->tanggal_kembali->format('d/m/Y') ?? '24/09/2025' }}" readonly>
                </div>
            </div>

        </div>

        {{-- Tombol Aksi --}}
        <div class="action-buttons">
            <a href="{{ url()->previous() }}" class="btn btn-kembali">Kembali</a>
        </div>

    </div>
@endsection