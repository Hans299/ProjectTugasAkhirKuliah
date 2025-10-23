{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Tambah User')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .page-title .breadcrumb-link {
        color: #6c757d; /* Warna abu-abu untuk link "Data User" */
        text-decoration: none;
    }
    .page-title .breadcrumb-link:hover {
        color: #333;
    }

    /* Kartu form */
    .form-card {
        border-radius: 12px;
        border: 2px solid #25256C; /* Border biru tua */
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
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
    }
    .form-control:focus, .form-select:focus {
        border-color: #25256C;
        box-shadow: 0 0 0 0.25rem rgba(37, 37, 108, 0.25);
    }
    .btn-upload {
        background-color: #3B82F6; /* Biru muda */
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
        background-color: #3B82F6; /* Biru muda (sesuai tombol tambah) */
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
        <a href="{{ route('superadmin.pengguna.index') }}" class="breadcrumb-link">Data User</a> > Tambah User
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        <form action="{{ route('superadmin.pengguna.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                
                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukan Email" value="{{ old('email') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="name" placeholder="Masukan Username" value="{{ old('name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Masukan Kelas" value="{{ old('kelas') }}">
                    </div>
                </div>

                {{-- Kolom Kanan Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan Password" required>
                        {{-- (Ikon mata bisa ditambahkan dengan JS) --}}
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Masukan Konfirmasi Password" required>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload File</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="gambar" name="gambar">
                            <label class="input-group-text btn-upload" for="gambar">Upload File</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="action-buttons">
                <a href="{{ route('superadmin.pengguna.index') }}" class="btn btn-kembali">Kembali</a>
                <button type="submit" class="btn btn-simpan">Simpan</button>
            </div>

        </form>
    </div>
@endsection