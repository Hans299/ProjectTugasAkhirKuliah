{{-- Menggunakan layout 'siswa' sebagai kerangka --}}
@extends('Layout.siswa')

{{-- 
  LOGIKA KUNCI 1:
  Mengecek apakah Controller mengirim variabel $buku.
  Jika YA, $isBuku = true (tampilkan form Buku).
  Jika TIDAK, kita anggap ini Alat Lab.
--}}
@php
    $isBuku = isset($buku);
    $item = $isBuku ? $buku : ($alat ?? null); // $item adalah data (buku atau alat)
@endphp

{{-- Judul halaman akan dinamis --}}
@section('title', 'Form Peminjaman ' . ($isBuku ? 'Buku' : 'Alat Lab'))

{{-- Menambahkan CSS kustom HANYA untuk halaman ini --}}
@push('styles')
<style>
    .content-wrapper { padding: 2rem 3rem; color: white; width: 100%; }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-title { font-weight: 600; font-size: 1.75rem; margin: 0; }
    .breadcrumb-link { color: #f0f0f0; text-decoration: none; font-size: 1rem; font-weight: 500; }
    .breadcrumb-link:hover { color: #F8D442; }

    /* Styling untuk Form Card */
    .form-card {
        background-color: #2A5A3A; /* Warna hijau form */
        padding: 2.5rem;
        border-radius: 10px;
        max-width: 800px; /* Batasi lebar form */
        margin: 0 auto; /* Tengahkan form */
    }
    .form-card-title {
        font-weight: 600;
        font-size: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #4a7c59;
    }

    /* Styling untuk input */
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        background-color: #fff;
        border: none;
        padding: 0.75rem 1rem;
        color: #333;
        border-radius: 8px;
    }
    .form-control:focus, .form-select:focus {
        background-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(248, 212, 66, 0.25); /* Shadow kuning */
        border-color: #F8D442;
    }
    /* Style untuk input yang disabled (data siswa) */
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef; /* Warna abu-abu */
        opacity: 1;
    }

    /* Tombol Aksi */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2.5rem;
    }
    .btn-custom-yellow {
        background-color: #F8D442;
        color: #333;
        font-weight: 600;
        border: none;
        padding: 0.75rem 1.5rem;
    }
    .btn-custom-secondary {
        background-color: #6c757d;
        color: white;
        font-weight: 600;
        border: none;
        padding: 0.75rem 1.5rem;
    }

</style>
@endpush

@section('content')
<div class="content-wrapper">

    {{-- Header Halaman --}}
    <div class="page-header">
        <h2 class="page-title">Formulir Peminjaman</h2>
        <a href="{{ route('siswa.dasbor') }}" class="breadcrumb-link">Home Beranda</a>
    </div>

    {{-- Kartu Form Utama --}}
    <div class="form-card">
        
        {{-- Judul Form (dinamis) --}}
        <h3 class="form-card-title text-center">
            FORM PEMINJAMAN {{ $isBuku ? 'BUKU' : 'ALAT LAB' }}
        </h3>

        {{-- Menampilkan error validasi jika ada --}}
        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Oops! Ada kesalahan:</h4>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form akan mengirim data ke controller --}}
        <form action="{{ route('siswa.pinjaman.store') }}" method="POST">
            @csrf
            
            {{-- 
              Input tersembunyi untuk mengirim ID dan Tipe Item.
              Ini penting agar Controller tahu apa yang sedang dipinjam.
            --}}
            <input type="hidden" name="item_id" value="{{ $item->id ?? 0 }}">
            <input type="hidden" name="item_type" value="{{ $isBuku ? 'buku' : 'alat' }}">


            {{-- Data Siswa (Otomatis terisi) --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="nama_peminjam"