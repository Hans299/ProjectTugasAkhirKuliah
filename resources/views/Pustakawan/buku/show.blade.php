{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Lihat Buku')

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
    /* Styling untuk field yang hanya-baca */
    .form-control[readonly],
    .form-select[disabled] {
        background-color: #e9ecef; /* Warna abu-abu muda */
        opacity: 1;
        border: 1px solid #ced4da;
    }
    textarea.form-control[readonly] {
        min-height: 120px;
    }
    .current-image {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-top: 10px;
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

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Breadcrumb) --}}
    <h2 class="page-title mb-4">
        <a href="{{ route('pustakawan.buku.index') }}" class="breadcrumb-link">Perpustakaan</a> > Lihat Buku
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- Variabel $buku harus Anda kirim dari Controller --}}
        <div class="row g-4">
            
            {{-- Kolom Kiri Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="judul_buku" class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" id="judul_buku" value="{{ $buku->judul_buku ?? 'Judul Buku' }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" value="{{ $buku->isbn ?? 'ISBN' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="penerbit" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" value="{{ $buku->penerbit ?? 'Penerbit' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="tahun_terbit" value="{{ $buku->tahun_terbit ?? 2024 }}" readonly>
                </div>
            </div>

            {{-- Kolom Kanan Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="stok" class="form-label">Stok Buku</label>
                    <input type="number" class="form-control" id="stok" value="{{ $buku->stok ?? 0 }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" value="{{ $buku->penulis ?? 'Penulis' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="halaman" class="form-label">Halaman</label>
                    <input type="number" class="form-control" id="halaman" value="{{ $buku->halaman ?? 0 }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <input type="text" class="form-control" id="kategori" value="{{ $buku->kategori ?? 'Kategori' }}" readonly>
                </div>
            </div>

            {{-- Bagian Bawah Form (Deskripsi & Upload) --}}
            <div class="col-12">
                 <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                    <textarea class="form-control" id="deskripsi" rows="4" readonly>{{ $buku->deskripsi ?? 'Deskripsi tidak tersedia.' }}</textarea>
                </div>
            </div>

            <div class="col-12">
                <label class="form-label">Gambar Buku</label>
                @if ($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul_buku }}" class="current-image d-block">
                @else
                    <p class="form-control-plaintext">Tidak ada gambar.</p>
                @endif
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="action-buttons">
            <a href="{{ route('pustakawan.buku.index') }}" class="btn btn-kembali">Kembali</a>
            {{-- Tombol "Simpan" dihapus --}}
        </div>
        
    </div>
@endsection