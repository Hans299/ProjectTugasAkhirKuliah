{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Tambah Alat Lab')

@push('styles')
    <style>
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
        }

        .page-title .breadcrumb-link {
            color: #6c757d;
            /* Warna abu-abu untuk link "Perpustakaan" */
            text-decoration: none;
        }

        .page-title .breadcrumb-link:hover {
            color: #333;
        }

        /* Kartu form */
        .form-card {
            border-radius: 12px;
            border: 2px solid #25256C;
            /* Border biru tua */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            background-color: #fff;
        }

        /* Styling form */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #25256C;
            box-shadow: 0 0 0 0.25rem rgba(37, 37, 108, 0.25);
        }

        textarea.form-control {
            min-height: 120px;
        }

        .btn-upload {
            background-color: #3B82F6;
            /* Biru muda (sesuai tombol tambah) */
            color: white;
            font-weight: 600;
        }

        /* Tombol Aksi */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-simpan {
            background-color: #3B82F6;
            /* Biru muda */
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border: none;
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
        <a href="{{ route('admin.laboran.alat.index') }}" class="breadcrumb-link">Labotarium</a> > Tambah Alat Lab
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">

        {{-- Form mengarah ke route 'store' --}}
        <form action="{{ route('admin.laboran.alat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="nama_alat" class="form-label">Nama Alat</label>
                        <input type="text" class="form-control" id="nama_alat" name="nama_alat"
                            placeholder="Masukan Nama Alat" value="{{ old('nama_alat') }}" required>
                        @error('nama_alat')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="id_alat" class="form-label">ID Alat</label>
                        <input type="text" class="form-control" id="id_alat" name="id_alat"
                            placeholder="Masukan ID Alat" value="{{ old('id_alat') }}" required>
                        @error('id_alat')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Alat</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Alat">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Kolom Kanan Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="kualitas" class="form-label">Kualitas Alat</label>
                        <select class="form-select" id="kualitas" name="kualitas" required>
                            <option value="" disabled selected>Pilih Kualitas</option>
                            <option value="Buruk" {{ old('kualitas') == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                            <option value="Baik" {{ old('kualitas') == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Sangat Baik" {{ old('kualitas') == 'Sangat Baik' ? 'selected' : '' }}>Sangat
                                Baik
                            </option>
                        </select>
                        @error('kualitas')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Alat</label>
                        <input type="number" class="form-control" id="stok" name="stok"
                            placeholder="Masukan Stok Alat" value="{{ old('stok') }}" required>
                        @error('stok')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload Gambar</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            <label class="input-group-text btn-upload" for="gambar">Upload Gambar</label>
                        </div>
                        @error('gambar')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
            {{-- Tombol Aksi --}}
            <div class="action-buttons">
                <a href="{{ route('admin.laboran.alat.index') }}" class="btn btn-kembali">Kembali</a>
                <button type="submit" class="btn btn-simpan">Simpan</button>
            </div>
        </form>
    </div>
@endsection
