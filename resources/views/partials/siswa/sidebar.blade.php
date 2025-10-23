{{-- 
  Ini adalah file "Partial" yang berisi HANYA sidebar hijau.
  File ini akan di-@include oleh layouts/siswa.blade.php
--}}
<div class="d-flex flex-column p-4" style="width: 250px; height: 100vh; background-color: #2A5A3A; color: white;">
    
    {{-- Logo --}}
    <a href="{{ route('siswa.dasbor') }}" class="d-flex justify-content-center align-items-center mb-4 text-decoration-none">
        <div style="width: 100px; height: 100px; background-color: #f0f0f0; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #333; font-weight: 600; font-size: 1.2rem;">
            Logo
        </div>
    </a>

    {{-- Menu Navigasi --}}
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Tombol Home --}}
        <li class="nav-item mb-3">
            {{-- 
              Request::is('siswa/dasbor*') akan mengecek URL. 
              Jika cocok, class 'active' akan ditambahkan (membuat tombol jadi kuning).
            --}}
            <a href="{{ route('siswa.dasbor') }}" 
               class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('siswa/dasbor*') ? 'active' : '' }}" 
               style="border-radius: 10px; color: white; --bs-nav-pills-link-active-bg: #F8D442; --bs-nav-pills-link-active-color: #333;">
                
                <span style="font-size: 2rem;">🏠</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span style="font-weight: 500;">Home</span>
            </a>
        </li>
        
        {{-- Tombol Peminjaman --}}
        <li class="nav-item mb-3">
            <a href="{{ route('siswa.pinjaman.index') }}" 
               class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('siswa/pinjaman') ? 'active' : '' }}" 
               style="border-radius: 10px; color: white; --bs-nav-pills-link-active-bg: #F8D442; --bs-nav-pills-link-active-color: #333;">
                
                <span style="font-size: 2rem;">📚</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span style="font-weight: 500;">Peminjaman</span>
            </a>
        </li>
        
        {{-- Tombol Pengembalian (Riwayat) --}}
        <li class="nav-item mb-3">
            <a href="{{ route('siswa.pinjaman.riwayat') }}" 
               class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('siswa/pinjaman/riwayat') ? 'active' : '' }}" 
               style="border-radius: 10px; color: white; --bs-nav-pills-link-active-bg: #F8D442; --bs-nav-pills-link-active-color: #333;">
                
                <span style="font-size: 2rem;">🔄</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span style="font-weight: 500;">Pengembalian</span>
            </a>
        </li>
    </ul>

    {{-- Tombol Logout --}}
    <div class="logout-section mt-4">
         {{-- Logout HARUS menggunakan form dengan method POST untuk keamanan --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center p-2" style="border-radius: 10px; font-weight: 500; background-color: #E63946;">
                <span style="font-size: 1.5rem; margin-right: 10px;">🚪</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>