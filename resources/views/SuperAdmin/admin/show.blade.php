{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Lihat Admin')

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
        <a href="{{ route('superadmin.admins.index') }}" class="breadcrumb-link">Data Admin</a> > Lihat Admin
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- Variabel $admin harus Anda kirim dari Controller --}}
        <div class="row g-4">
            
            {{-- Kolom Kiri Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="{{ $admin->email ?? 'Email Admin' }}" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" value="{{ $admin->name ?? 'Username Admin' }}" readonly>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Role Admin</label>
                    <input type="text" class="form-control" id="role" value="{{ ucfirst($admin->role ?? 'Role') }}" readonly>
                </div>
            </div>

            {{-- Kolom Kanan Form --}}
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" class="form-control" id="password" value="********" readonly>
                </div>
                
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="text" class="form-control" id="password_confirmation" value="********" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar/Foto Profil</label>
                    @if ($admin->profile_photo_path)
                        <img src="{{ asset('storage/' . $admin->profile_photo_path) }}" alt="Foto Profil" class="current-image d-block">
                    @else
                        <p class="form-control-plaintext">Tidak ada gambar.</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="action-buttons">
            <a href="{{ route('superadmin.admins.index') }}" class="btn btn-kembali">Kembali</a>
            {{-- Tombol "Simpan" dihapus --}}
        </div>
        
    </div>
@endsection