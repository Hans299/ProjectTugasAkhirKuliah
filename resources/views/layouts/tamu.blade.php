{{-- 
  Ini adalah layout "Polos" untuk halaman Tamu (Login & Register).
  File ini hanya berisi struktur HTML dasar, Bootstrap, dan "slot" untuk konten.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Token CSRF untuk keamanan form di Laravel --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 
      Judul halaman akan diambil dari @section('title') di file anak.
      Jika tidak ada, akan memakai nama aplikasi dari .env
    --}}
    <title>@yield('title', config('app.name', 'Sistem Informasi'))</title>

    {{-- Memuat Bootstrap 5 CSS dari CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- 
      SLOT UNTUK CSS KUSTOM
      Di sinilah @push('styles') dari login.blade.php akan menempelkan CSS hijaunya.
    --}}
    @stack('styles')

</head>
<body class="antialiased">

    {{-- 
      SLOT UNTUK KONTEN UTAMA
      Di sinilah @section('content') dari login.blade.php akan disuntikkan.
    --}}
    @yield('content')

    {{-- Memuat Bootstrap 5 JS (Bundle) dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    {{-- 
      SLOT UNTUK JAVASCRIPT KUSTOM
      Di sinilah @push('scripts') dari login.blade.php akan menempelkan
      script untuk show/hide password.
    --}}
    @stack('scripts')
    
</body>
</html>