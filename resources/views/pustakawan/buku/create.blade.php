{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Tambah Buku')

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
        <a href="{{ route('admin.pustakawan.buku.index') }}" class="breadcrumb-link">Perpustakaan</a> > Tambah Buku
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">

        <form action="{{ route('admin.pustakawan.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">

                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku"
                            placeholder="Masukan Judul Buku" value="{{ old('judul_buku') }}" required>
                        @error('judul_buku')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Masukan ISBN"
                            value="{{ old('isbn') }}">
                        @error('isbn')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        {{-- Desain tertulis "Judul Penerbit", saya ubah jadi "Penerbit" --}}
                        <label for="penerbit" class="form-label">Nama Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit"
                            placeholder="Masukan Penerbit" value="{{ old('penerbit') }}">
                        @error('penerbit')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit"
                            placeholder="Masukan Tahun Terbit (Contoh: 2024)" value="{{ old('tahun_terbit') }}">
                        @error('tahun_terbit')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukan Deskripsi Buku">{{ old('deskripsi') }}</textarea>
                    </div>

                </div>

                {{-- Kolom Kanan Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Buku</label>
                        <input type="number" class="form-control" id="stok" name="stok"
                            placeholder="Masukan Stok Buku" value="{{ old('stok') }}" required>
                        @error('stok')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis"
                            placeholder="Masukan Penulis" value="{{ old('penulis') }}">
                        @error('penulis')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="halaman" class="form-label">Halaman Buku</label>
                        <input type="number" class="form-control" id="halaman" name="halaman"
                            placeholder="Masukan Halaman Buku" value="{{ old('halaman') }}" required>
                        @error('halaman')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Buku</label>
                        <select name="kategori" id="kategori" class="form-control">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Buku Umum" {{ old('kategori') == 'Buku Umum' ? 'selected' : '' }}>Buku Umum
                            </option>
                            <option value="Buku Mata Pelajaran"
                                {{ old('kategori') == 'Buku Mata Pelajaran' ? 'selected' : '' }}>Buku Mata Pelajaran
                            </option>
                        </select>
                        @error('kategori')
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

                    <div class="action-buttons">
                        <a href="{{ route('admin.pustakawan.buku.index') }}" class="btn btn-kembali">Kembali</a>
                        <button type="submit" class="btn btn-simpan">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
