{{-- Menggunakan layout 'siswa' sebagai kerangka --}}
@extends('Layout.siswa')

{{-- 
  LOGIKA KUNCI 1:
  Mengecek apakah Controller mengirim variabel $buku.
  Jika YA, $isBuku = true (tampilkan desain Buku).
  Jika TIDAK, kita anggap ini Alat Lab.
--}}
@php
    $isBuku = isset($buku);
    $item = $isBuku ? $buku : $alat; // $item adalah data (buku atau alat)
@endphp

{{-- Judul halaman akan dinamis --}}
@section('title', 'Detail ' . ($isBuku ? 'Buku' : 'Alat Lab'))

{{-- Menambahkan CSS kustom HANYA untuk halaman ini --}}
@push('styles')
<style>
    .content-wrapper { padding: 2rem 3rem; color: white; width: 100%; }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .detail-header-title { font-weight: 600; font-size: 1.75rem; margin: 0; }
    .breadcrumb-link {
        color: #f0f0f0;
        text-decoration: none;
        font-size: 1rem;
        font-weight: 500;
    }
    .breadcrumb-link:hover { color: #F8D442; }

    .detail-body {
        display: flex;
        gap: 2.5rem;
    }
    .item-cover img {
        width: 250px;
        height: auto;
        border-radius: 10px;
        object-fit: cover;
    }
    .item-info .item-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .item-info .item-id {
        font-size: 1rem;
        color: #ccc;
        margin-bottom: 1.5rem;
    }
    .metadata-table {
        max-width: 500px;
        font-size: 1.1rem;
    }
    .metadata-table td {
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border: none;
        color: white;
    }
    .metadata-table td:first-child {
        width: 150px; /* Lebar untuk label (Penerbit, Penulis, dll) */
        font-weight: 600;
    }
    .metadata-table td:nth-child(2) {
        width: 20px; /* Lebar untuk titik dua (:) */
    }

    .item-description { margin-top: 3rem; }
    .item-description h4 { font-weight: 600; margin-bottom: 1rem; }
    .item-description p { color: #e0e0e0; line-height: 1.6; }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-custom-yellow {
        background-color: #F8D442;
        color: #333;
        font-weight: 600;
        border: none;
    }

    /* Responsif untuk layar kecil */
    @media (max-width: 768px) {
        .detail-body { flex-direction: column; }
        .item-cover { text-align: center; }
        .item-cover img { width: 60%; max-width: 250px; }
        .item-info .item-title { font-size: 2rem; }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    
    {{-- ======================= Header (Judul Halaman & Home) ======================= --}}
    <div class="detail-header">
        <h2 class="detail-header-title">{{ $isBuku ? 'Detail Buku' : 'Detail Alat Lab' }}</h2>
        <a href="{{ route('siswa.dasbor') }}" class="breadcrumb-link">Home Beranda</a>
    </div>

    {{-- ======================= Detail Body (Cover & Info) ======================= --}}
    <div class="detail-body">
        
        {{-- Bagian Kiri: Cover Gambar --}}
        <div class="item-cover flex-shrink-0">
            <img src="{{ $item->gambar_url ?? 'https://via.placeholder.com/250x380' }}" alt="Cover">
        </div>

        {{-- Bagian Kanan: Info Metadata --}}
        <div class="item-info flex-grow-1">
            <h1 class="item-title">{{ $item->nama ?? 'Judul Tidak Ditemukan' }}</h1>
            
            {{-- Menampilkan ISBN untuk Buku atau ID untuk Alat --}}
            <p class="item-id">
                {{ $isBuku ? ($item->isbn ?? 'ISBN-123-456-7') : ('ID: ' . ($item->id_alat ?? 'ALAT-001')) }}
            </p>

            {{-- 
              LOGIKA KUNCI 2:
              Menampilkan tabel metadata yang berbeda
            --}}
            <table class="table metadata-table">
                <tbody>
                    @if ($isBuku)
                        {{-- Tampilkan Metadata BUKU --}}
                        <tr>
                            <td>Penerbit</td>
                            <td>:</td>
                            <td>{{ $buku->penerbit ?? 'Data Penerbit' }}</td>
                        </tr>
                        <tr>
                            <td>Tahun Terbit</td>
                            <td>:</td>
                            <td>{{ $buku->tahun_terbit ?? '2024' }}</td>
                        </tr>
                        <tr>
                            <td>Edisi</td>
                            <td>:</td>
                            <td>{{ $buku->edisi ?? 'Data Edisi' }}</td>
                        </tr>
                        <tr>
                            <td>Penulis</td>
                            <td>:</td>
                            <td>{{ $buku->penulis ?? 'Data Penulis' }}</td>
                        </tr>
                        <tr>
                            <td>Halaman</td>
                            <td>:</td>
                            <td>{{ $buku->halaman ?? '100' }}</td>
                        </tr>
                        <tr>
                            <td>Kategori</td>
                            <td>:</td>
                            <td>{{ $buku->kategori ?? 'Umum' }}</td>
                        </tr>
                    @else
                        {{-- Tampilkan Metadata ALAT LAB --}}
                        <tr>
                            <td>ID Alat</td>
                            <td>:</td>
                            <td>{{ $alat->id_alat ?? 'ALAT-001' }}</td>
                        </tr>
                        <tr>
                            <td>Kualitas</td>
                            <td>:</td>
                            <td>{{ $alat->kualitas ?? 'Baik' }}</td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td>{{ $alat->stok ?? '10' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    {{-- ======================= Deskripsi & Syarat ======================= --}}
    <div class="item-description">
        <h4>Syarat dan Ketentuan</h4>
        <p>
            Batas waktu peminjaman materiil adalah 3 hari. Apabila buku belum juga dikembalikan, akan dikenakan sanksi berupa denda sebesar Rp 1.000 per hari. Apabila buku hilang atau rusak, peminjam akan dikenakan sanksi berupa denda 10x lipat dari harga buku.
        </p>
        <br>

        {{-- 
          LOGIKA KUNCI 3:
          Menampilkan judul "Sinopsis" atau "Deskripsi Alat"
        --}}
        <h4>{{ $isBuku ? 'Sinopsis' : 'Deskripsi Alat' }}</h4>
        <p>
            {{ $isBuku ? ($item->sinopsis ?? 'Sinopsis tidak tersedia.') : ($item->deskripsi ?? 'Deskripsi alat tidak tersedia.') }}
        </p>
    </div>

    {{-- ======================= Tombol Aksi ======================= --}}
    <div class="action-buttons">
        {{-- Tombol Kembali --}}
        <a href="{{ url()->previous() }}" class="btn btn-outline-light px-4 py-2">Kembali</a>
        
        {{-- Form untuk Pinjam --}}
        <form action="#" method="POST"> {{-- Ganti # dengan route pinjam --}}
            @csrf
            {{-- Kirim ID dan Tipe item yang ingin dipinjam --}}
            <input type="hidden" name="item_id" value="{{ $item->id ?? 0 }}">
            <input type="hidden" name="item_type" value="{{ $isBuku ? 'buku' : 'alat' }}">
            
            <button type="submit" class="btn btn-custom-yellow px-4 py-2">
                Pinjam {{ $isBuku ? 'Buku' : 'Alat' }}
            </button>
        </form>
    </div>

</div>
@endsection