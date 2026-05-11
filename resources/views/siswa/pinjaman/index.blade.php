@extends('layouts.tamu') 

{{-- Judul akan dinamis --}}
@php
    $isBuku = isset($bukus); // Cek apakah controller mengirim $bukus
    $items = $isBuku ? $bukus : $alats; // $items adalah $bukus atau $alats
@endphp

@section('title', $isBuku ? 'Daftar Buku' : 'Daftar Alat')

@push('styles')
<style>
    .item-card {
        background-color: white; border-radius: 10px; color: #333;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 1.5rem;
        margin-bottom: 1.5rem; text-decoration: none; display: block;
        transition: all 0.2s ease-in-out;
    }
    .item-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .item-card h3 { color: #1D3A1F; font-weight: 600; }
    .item-card .stok { font-weight: 500; color: #2A5A3A; }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-4 fw-bold" style="color: #1D3A1F;">
            @if($isBuku)
                <i class="fas fa-book me-3"></i> Perpustakaan
            @else
                <i class="fas fa-flask me-3"></i> Laboratorium
            @endif
        </h1>
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-success">Kembali ke Dashboard</a>
    </div>

    {{-- Tampilkan Pesan Sukses/Error --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        @forelse ($items as $item)
            <div class="col-md-6 col-lg-4">
                {{-- Tentukan link detail berdasarkan tipe item --}}
                @php
                    $route = $isBuku ? route('siswa.item.show.buku', $item) : route('siswa.item.show.alat', $item);
                @endphp
                
                <a href="{{ $route }}" class="item-card">
                    {{-- Tampilkan judul (buku) atau nama (alat) --}}
                    <h3>{{ $item->judul ?? $item->nama }}</h3>
                    
                    @if($isBuku)
                        <p class="mb-2">Oleh: {{ $item->pengarang }}</p>
                    @else
                        <p class="mb-2">{{ Str::limit($item->deskripsi, 50) }}</p>
                    @endif
                    
                    <span class="stok">Stok Tersisa: {{ $item->stok }}</span>
                </a>
            </div>
        @empty
            <p class="text-center fs-5">Belum ada item yang tersedia.</p>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $items->links() }}
    </div>
</div>
@endsection