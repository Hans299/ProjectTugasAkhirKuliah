{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Edit Admin')

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
        background-color: #3B82F6;
        color: white;
        font-weight: 600;
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
    .btn-simpan {
        background-color: #3B82F6;
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
        <a href="{{ route('superadmin.admins.index') }}" class="breadcrumb-link">Data Admin</a> > Edit Admin
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class.form-card">
        
        {{-- 
          Form mengarah ke route 'update' dan menggunakan method PUT.
          Variabel $admin harus Anda kirim dari Controller.
        --}}
        <form action="{{ route('superadmin.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Method spoofing untuk update --}}

            <div class="row g-4">
                
                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        {{-- 'value' diisi dengan data lama dari $admin --}}