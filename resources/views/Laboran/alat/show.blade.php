{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Detail Alat Lab')

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

@section('content')
    
    {{-- Header Konten (Judul & Breadcrumb) --}}
    <h2 class="page-title mb-4">
        <a href="{{ route('laboran.alat.index') }}" class="breadcrumb-link">Labotarium</a> > Lihat Alat Lab
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- Variabel $alat harus Anda kirim dari Controller --}}
        <div class="row g-4">
            
            {{-- Kolom Kiri Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="nama_alat" class="form-label">Nama Alat</label>
                    <input type="text" class="form-control" id="nama_alat" value="{{ $alat->nama_alat ?? 'Nama Alat' }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="id_alat" class="form-label">ID Alat</label>
                    <input type="text" class="form-control" id="id_alat" value="{{ $alat->id_alat ?? 'ID-001' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok Alat</label>
                    <input type="number" class="form-control" id="stok" value="{{ $alat->stok ?? 0 }}" readonly>
                </div>
            </div>

            {{-- Kolom Kanan Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="kualitas" class="form-label">Kualitas Alat</label>
                    <input type="text" class="form-control" id="kualitas" value="{{ $alat->kualitas ?? 'Baik' }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Gambar Alat</label>
                    @if ($alat->gambar)
                        <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="current-image d-block">
                    @else
                        <p class="form-control-plaintext">Tidak ada gambar.</p>
                    @endif
                </div>
            </div>

            {{-- Bagian Bawah Form (Deskripsi) --}}
            <div class="col-12">
                 <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Alat</label>
                    <textarea class="form-control" id="deskripsi" rows="4" readonly>{{ $alat->deskripsi ?? 'Deskripsi tidak tersedia.' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="action-buttons">
            <a href="{{ route('laboran.alat.index') }}" class="btn btn-kembali">Kembali</a>
            {{-- Tidak ada tombol "Simpan" --}}
        </div>
        
    </div>
@endsection