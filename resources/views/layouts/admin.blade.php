<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Sistem Informasi') }}</title>

    {{-- Bootstrap 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Font Awesome (untuk ikon) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    {{-- CSS Kustom untuk Admin Layout --}}
    <style>
        body {
            background-color: #f4f7f6; /* Background abu-abu muda untuk area konten */
        }
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        .sidebar-wrapper {
            flex-shrink: 0; /* Sidebar tidak akan menyusut */
        }
        .main-content-wrapper {
            flex-grow: 1; /* Konten utama mengambil sisa ruang */
            display: flex;
            flex-direction: column;
        }
        .content-area {
            padding: 2rem;
            flex-grow: 1;
        }
    </style>

    @stack('styles')
</head>
<body class="antialiased">

    <div class="admin-layout">
        
        {{-- Memasukkan Sidebar Biru --}}
        <div class="sidebar-wrapper">
            @include('partials.admin.sidebar')
        </div>
        
        {{-- Wrapper untuk Konten Utama (Navbar + Halaman) --}}
        <div class="main-content-wrapper">
            
            {{-- Memasukkan Navbar Atas --}}
            @include('partials.admin.navbar')

            {{-- Area Konten Utama --}}
            <main class="content-area">
                @yield('content')
            </main>

        </div>
    </div>

    {{-- Bootstrap 5 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Chart.js (untuk grafik di dashboard) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    @stack('scripts')
</body>
</html>