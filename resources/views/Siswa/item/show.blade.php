{{-- Menggunakan layout 'tamu' (hijau) sebagai kerangka --}}
@extends('layouts.tamu')

@php
    // Logika ini sudah benar
    $isBuku = isset($buku); 
    $item = $isBuku ? $buku : $alat;
@endphp

@section('title', 'Detail ' . ($isBuku ? 'Buku' : 'Alat Lab'))

@push('styles')
{{-- (Ini adalah CSS dari file Anda) --}}
<style>
    .content-wrapper { padding: 2rem 3rem; color: white; width: 100%; }
    .detail-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .detail-header-title { font-weight: 600; font-size: 1.75rem; margin: 0; }
    .breadcrumb-link { color: #f0f0f0; text-decoration: none; }
    .breadcrumb-link:hover { color: #F8D442; }
    .detail-body { display: flex; gap: 2.5rem; }
    .item-cover img { width: 250px; border-radius: 10px; }
    .item-info .item-title { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; }
    .item-info .item-id { font-size: 1rem; color: #ccc; margin-bottom: 1.5rem; }
    .metadata-table { max-width: 500px; }
    .metadata-table td { padding: 0.5rem 0; border: none; color: white; }
    .metadata-table td:first-child { width: 150px; font-weight: 600; }
    .metadata-table td:nth-child(2) { width: 20px; }
    .item-description { margin-top: 3rem; }
    .item-description h4 { font-weight: 600; margin-bottom: 1rem; }
    .item-description p { color: #e0e0e0; line-height: 1.6; }
    .action-buttons { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; }
    .btn-custom-yellow { background-color: #F8D442; color: #333; font-weight: 600; border: none; }
    @media (max-width: 768px) {
        .detail-body { flex-direction: column; }
        .item-cover { text-align: center; }
        .item-cover img { width: 60%; max-width: 250px; }
    }
</style>
@endpush

@section('content')
<div class="content-wrapper">
    
    <div class="detail-header">
        <h2 class="detail-header-title">{{ $isBuku ? 'Detail Buku' : 'Detail Alat Lab' }}</h2>
        {{-- PERBAIKAN: Rute 'dashboard' --}}
        <a href="{{ route('siswa.dashboard') }}" class="breadcrumb-link">Home Beranda</a>
    </div>

    <div class="detail-body">
        <div class="item-cover flex-shrink-0">
            <img src="{{ $item->gambar_url ?? 'https://via.placeholder.com/250x380' }}" alt="Cover">
        </div>

        <div class="item-info flex-grow-1">
            {{-- PERBAIKAN: Sesuaikan judul/nama --}}
            <h1 class="item-title">{{ $isBuku ? $item->judul : $item->nama }}</h1>
            
            <p class="item-id">
                Stok Tersedia: {{ $item->stok }}
            </p>

            {{-- PERBAIKAN: Sesuaikan metadata dengan database KITA --}}
            <table class="table metadata-table">
                <tbody>
                    @if ($isBuku)
                        <tr>
                            <td>Penulis</td>
                            <td>:</td>
                            <td>{{ $buku->pengarang ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td>Penerbit</td>
                            <td>:</td>
                            <td>{{ $buku->penerbit ?? 'N/A' }}</td>
                        </tr>
                    @else
                         <tr>
                            <td>Deskripsi Singkat</td>
                            <td>:</td>
                            <td>{{ $alat->deskripsi ?? 'N/A' }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="item-description">
        <h4>Syarat dan Ketentuan</h4>
        <p>
            Batas waktu peminjaman materiil adalah 3 hari. Apabila buku belum juga dikembalikan, akan dikenakan sanksi... (dst)
        </p>
        <br>
        
        <h4>{{ $isBuku ? 'Info Buku' : 'Deskripsi Alat' }}</h4>
        <p>
            {{ $isBuku ? ($item->deskripsi_buku ?? 'Info buku tidak tersedia.') : ($item->deskripsi ?? 'Deskripsi alat tidak tersedia.') }}
        </p>
    </div>

    <div class="action-buttons">
        <a href="{{ url()->previous() }}" class="btn btn-outline-light px-4 py-2">Kembali</a>
        
        {{-- PERBAIKAN: Ini adalah link ke FORM KONFIRMASI (Langkah 4) --}}
        @php
            $item_type = $isBuku ? 'Buku' : 'AlatLab';
        @endphp
        <a href="{{ route('siswa.pinjaman.create', ['item_type' => $item_type, 'item_id' => $item->id]) }}" 
           class="btn btn-custom-yellow px-4 py-2">
           Pinjam {{ $isBuku ? 'Buku' : 'Alat' }}
        </a>
    </div>

</div>
@endsection