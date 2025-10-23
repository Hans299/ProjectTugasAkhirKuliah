{{-- Menggunakan layout 'siswa' sebagai kerangka --}}
@extends('layouts.siswa')

{{-- Mengatur judul halaman --}}
@section('title', 'Beranda Siswa')

{{-- Menambahkan CSS kustom HANYA untuk halaman dashboard --}}
@push('styles')
<style>
    .content-wrapper { padding: 2rem 3rem; color: white; width: 100%; }
    .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1rem; }
    .search-bar { background-color: #fff; border-radius: 20px; padding: 0.5rem 1rem; display: flex; align-items: center; min-width: 250px; }
    .search-bar input { border: none; background: transparent; outline: none; padding-left: 0.5rem; color: #333; width: 100%; }
    .search-bar input::placeholder { color: #888; }
    .search-bar-icon { color: #555; font-size: 1.1rem; }
    .user-info { font-weight: 500; font-size: 1.1rem; }
    .item-section { margin-bottom: 2.5rem; }
    .section-header { display: flex; align-items: center; margin-bottom: 1.5rem; gap: 1.5rem; flex-wrap: wrap; }
    .section-title { font-size: 1.75rem; font-weight: 600; margin: 0; }
    .tab-nav .btn { color: #333; border: none; border-radius: 20px; padding: 0.5rem 1.5rem; font-weight: 500; margin-right: 0.5rem; }
    .tab-nav .btn.active { background-color: #F8D442; } /* Warna Kuning */
    .tab-nav .btn.inactive { background-color: #fff; } /* Warna Putih */
    .item-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1.5rem; }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
<div class="content-wrapper">
    
    {{-- ======================= Top Bar (Search & User) ======================= --}}
    <div class="top-bar">
        {{-- Search Bars --}}
        <div class="d-flex flex-wrap gap-3">
            <div class="search-bar"> <span class="search-bar-icon">📚</span> <input type="text" placeholder="Cari Buku"> </div>
            <div class="search-bar"> <span class="search-bar-icon">🔬</span> <input type="text" placeholder="Cari Alat Lab"> </div>
        </div>
        {{-- User Info --}}
        <div class="user-info">
            {{ Auth::user()->name ?? 'Hans Bonatua' }}
        </div>
    </div>

    {{-- ======================= Section Rekomendasi ======================= --}}
    <div class="item-section">
        <div class="section-header">
            <h2 class="section-title">Rekomendasi</h2>
            <div class="tab-nav">
                {{-- 
                  LOGIKA KUNCI 1:
                  Mengecek apakah Controller mengirim variabel $bukuPelajaran.
                  Jika YA, $showBuku = true (tampilkan desain Buku).
                  Jika TIDAK, $showBuku = false (tampilkan desain Alat Lab).
                --}}
                @php $showBuku = isset($bukuPelajaran); @endphp

                {{-- Tombol tab akan 'active' (kuning) atau 'inactive' (putih) berdasarkan $showBuku --}}
                <a href="{{ route('siswa.dasbor.buku') }}" class="btn {{ $showBuku ? 'active' : 'inactive' }}">Buku</a>
                <a href="{{ route('siswa.dasbor.alat') }}" class="btn {{ !$showBuku ? 'active' : 'inactive' }}">Alat Lab</a>
            </div>
        </div>
        
        <div class="item-grid">
            {{-- 
              LOGIKA KUNCI 2:
              Menentukan data apa yang akan di-loop.
              Jika $showBuku true, gunakan $rekomendasiBuku.
              Jika false, gunakan $rekomendasiAlat.
            --}}
            @php $items = $showBuku ? ($rekomendasiBuku ?? []) : ($rekomendasiAlat ?? []); @endphp
            
            {{-- Loop data rekomendasi. @forelse adalah @foreach + @if empty --}}
            @forelse ($items as $item)
                {{-- Memanggil komponen kartu-item --}}
                @include('components.kartu-item', [
                    'imageUrl' => $item->gambar_url ?? 'https://via.placeholder.com/150x220',
                    'title' => $item->nama ?? ($showBuku ? 'Contoh Buku' : 'Contoh Alat'),
                    'rating' => $item->rating ?? rand(4, 5)
                ])
            @empty
                {{-- Tampilkan 8 item palsu jika datanya kosong --}}
                @for ($i = 0; $i < 8; $i++)
                    @include('components.kartu-item', [
                        'title' => $showBuku ? 'Contoh Buku' : 'Contoh Alat',
                        'rating' => rand(4, 5)
                    ])
                @endfor
            @endforelse
        </div>
    </div>

    {{-- ======================= Section Perpustakaan / Alat Lab ======================= --}}
    <div class="item-section">
        <div class="section-header">
            {{-- Judul bagian ini akan berubah otomatis --}}
            <h2 class="section-title">{{ $showBuku ? 'Perpustakaan' : 'Alat Lab' }}</h2>
            
            {{-- Tampilkan tab "Buku Mata Pelajaran" HANYA jika $showBuku true --}}
            @if ($showBuku)
            <div class="tab-nav">
                <button class="btn active">Buku Mata Pelajaran</button>
                <button class="btn inactive">Buku Umum</button>
            </div>
            @endif
            {{-- Jika $showBuku false, bagian tab ini akan kosong (sesuai desain Alat Lab) --}}
        </div>
        
        <div class="item-grid">
            {{-- 
              LOGIKA KUNCI 3:
              Menentukan data apa yang akan di-loop di bagian bawah.
            --}}
            @php $itemsBawah = $showBuku ? ($bukuPelajaran ?? []) : ($semuaAlat ?? []); @endphp
            
            {{-- Loop data --}}
            @forelse ($itemsBawah as $item)
                 @include('components.kartu-item', [
                    'imageUrl' => $item->gambar_url ?? 'https://via.placeholder.com/150x220',
                    'title' => $item->nama ?? ($showBuku ? 'Contoh Buku Pelajaran' : 'Contoh Alat Lab'),
                    'rating' => $item->rating ?? rand(4, 5)
                ])
            @empty
                {{-- Tampilkan 8 item palsu jika datanya kosong --}}
                @for ($i = 0; $i < 8; $i++)
                    @include('components.kartu-item', [
                        'title' => $showBuku ? 'Contoh Buku Pelajaran' : 'Contoh Alat Lab',
                        'rating' => rand(4, 5)
                    ])
                @endfor
            @endforelse
        </div>
    </div>
</div>
@endsection