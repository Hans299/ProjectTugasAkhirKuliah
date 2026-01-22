{{--
  Ini adalah layout "Kerangka Hijau" untuk semua halaman Siswa.
  File ini memuat struktur dasar dengan sidebar dan slot untuk konten.
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Judul halaman akan diambil dari @section('title') --}}
        <title>@yield('title', 'Dashboard Siswa') - {{ config('app.name', 'Sistem Informasi') }}</title>

        {{-- Bootstrap 5 CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- Font Awesome (untuk ikon) --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        {{-- CSS utama untuk layout sidebar --}}
        <style>
            html,
            body {
                height: 100%;
                margin: 0;
            }

            body {
                background-color: #f4f7f6;
                overflow-x: hidden;
            }

            /* =====================
       LAYOUT UTAMA
    ====================== */
            .sidebar-layout {
                display: flex;
                min-height: 100vh;
            }

            /* =====================
       SIDEBAR
    ====================== */
            .sidebar-wrapper {
                width: 260px;
                flex-shrink: 0;
                background-color: #1e4d2b;
                transition: transform .3s ease-in-out;
            }

            /* =====================
       KONTEN UTAMA
    ====================== */
            .main-content-wrapper {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .main-content {
                padding: 2rem;
                flex-grow: 1;
                background-color: #255f38;
                color: white;
                border: 2px solid #ffd632;
            }

            #closeSidebar {
                display: absolute;
                background-color: transparent !important;
                color: white !important;
                width: 36px;
                border: none;
                height: 36px;
                padding: 0;
            }


            /* =====================
       DESKTOP (≥ 992px)
    ====================== */
            @media (min-width: 992px) {
                .sidebar-sticky {
                    position: sticky;
                    top: 0;
                    height: 100vh;
                    overflow-y: auto;
                }
            }


            /* =====================
       TABLET (≤ 991px)
    ====================== */
            @media (max-width: 991.98px) {
                .sidebar-wrapper {
                    width: 220px;
                }

                .main-content {
                    padding: 1.5rem;
                }

            }

            /* =====================
       MOBILE (≤ 767px)
    ====================== */
            @media (max-width: 767.98px) {
                .sidebar-layout {
                    flex-direction: column;
                }

                .sidebar-wrapper {
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100%;
                    transform: translateX(-100%);
                    z-index: 1050;
                }

                .sidebar-wrapper.show {
                    transform: translateX(0);
                }

                .main-content-wrapper {
                    width: 100%;
                }

                .main-content {
                    padding: 1rem;
                }
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
                @include('partials.siswa.sidebar')
            </div>

            {{-- Bagian Konten Utama --}}
            <div class="main-content-wrapper">

                {{-- Memasukkan Navbar --}}
                @include('partials.siswa.navbar')
                <main class="main-content" style="background-color: #255f38; color: white; border: 2px solid #ffd632;">
                    {{-- Di sinilah konten dari dasbor.blade.php akan dimuat --}}
                    @yield('content')
                </main>
            </div>

        </div>

        {{-- Bootstrap 5 JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Chart.js (untuk grafik di dashboard) --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        {{-- Slot untuk JS tambahan dari halaman anak --}}
        @stack('scripts')

    </body>

</html>
