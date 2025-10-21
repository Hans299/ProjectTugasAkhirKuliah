{{-- 
  Kita TIDAK menggunakan @extends di sini karena welcome.blade.php 
  biasanya berdiri sendiri atau menggunakan layout yang lebih simpel.
  Kita akan memuat @vite langsung di sini.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- 
      ✅ MEMUAT BOOTSTRAP ANDA
      Pastikan 'npm run dev' berjalan
    --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="antialiased">
    
    {{-- Navbar Sederhana (Jika Anda ingin navbar di halaman welcome) --}}
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- Menu Kiri (jika perlu) --}}
                <ul class="navbar-nav me-auto"></ul>

                {{-- Menu Kanan (Login/Register atau Logout) --}}
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ url('/home') }}"> {{-- Ganti ke /home atau /dashboard --}}
                                    Dashboard
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Utama Halaman Welcome --}}
    <main class="container py-5">
        <div class="p-5 mb-4 bg-light rounded-3 text-center">
            <div class="container-fluid py-5">
                
                {{-- Logo Laravel --}}
                <svg width="150" class="mb-4 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.9 83.2"><path d="M63.8 41.6c0 18.2-11.3 31-27.9 31S7.9 59.8 7.9 41.6c0-18.2 11.3-31 27.9-31s27.9 12.8 27.9 31zm-45.7 0c0 11.3 7 19.4 17.8 19.4s17.8-8.2 17.8-19.4c0-11.3-7-19.4-17.8-19.4s-17.8 8.2-17.8 19.4zM71.9 41.6c0 18.2-11.3 31-27.9 31V61.3c11.1 0 16.5-6.9 16.5-19.7 0-12.8-5.4-19.7-16.5-19.7V10.6c16.5 0 27.9 12.8 27.9 31zM0 41.6c0 18.2 11.3 31 27.9 31V61.3c-11.1 0-16.5-6.9-16.5-19.7 0-12.8 5.4-19.7 16.5-19.7V10.6C11.3 10.6 0 23.4 0 41.6z" fill="#FF2D20"/></svg>

                <h1 class="display-5 fw-bold">Selamat Datang!</h1>
                <p class="fs-4 col-md-8 mx-auto">Project Laravel 12 Anda kini menggunakan Bootstrap 5.</p>
                
                <hr class="my-4">

                <p class="lead">Halaman ini (`welcome.blade.php`) sudah menggunakan kelas Bootstrap.</p>

                {{-- Tombol Aksi (jika belum login) --}}
                @guest
                    @if (Route::has('login'))
                       <a class="btn btn-primary btn-lg mt-3" href="{{ route('login') }}">Login Sekarang</a>
                    @endif
                @endguest

            </div>
        </div>
    </main>

</body>
</html>