{{-- 
  Ini adalah layout "Kerangka Hijau" untuk semua halaman Siswa.
  File ini memuat struktur dasar dengan sidebar dan slot untuk konten.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Judul halaman akan diambil dari @section('title') --}}
    <title>@yield('title', 'Dasbor Siswa') - {{ config('app.name', 'Sistem Informasi') }}</title>

    {{-- Memuat Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- CSS utama untuk layout sidebar --}}
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: #1D3A1F; /* Background hijau tua */
        }
        .sidebar-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar-wrapper {
            flex-shrink: 0; /* Mencegah sidebar menyusut */
        }
        .main-content {
            flex-grow: 1; /* Konten utama mengambil sisa ruang */
            overflow-y: auto; /* Memungkinkan konten di kanan untuk scroll */
        }
    </style>
    
    {{-- Slot untuk CSS tambahan dari halaman anak (dasbor.blade.php) --}}
    @stack('styles')
</head>
<body>
    <div class="sidebar-layout">
        
        {{-- Bagian Sidebar --}}
        <div class="sidebar-wrapper">
            {{-- Memanggil file sidebar --}}
            @include('partials.siswa._sidebar')
        </div>
        
        {{-- Bagian Konten Utama --}}
        <main class="main-content">
            {{-- Di sinilah konten dari dasbor.blade.php akan dimuat --}}
            @yield('content')
        </main>
        
    </div>

    {{-- Memuat Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Slot untuk JS tambahan dari halaman anak --}}
    @stack('scripts')
</body>
</html>