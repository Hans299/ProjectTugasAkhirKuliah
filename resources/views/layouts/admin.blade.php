<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Sistem Informasi') }}</title>

        {{-- Bootstrap 5 --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <style>
            html,
            body {
                height: 100%;
                margin: 0;
            }

            body {
                background-color: #f4f7f6;
            }

            /* =====================
           LAYOUT
        ===================== */
            .admin-layout {
                display: flex;
                min-height: 100vh;
                overflow: hidden;
            }

            /* =====================
           SIDEBAR
        ===================== */
            .sidebar-wrapper {
                width: 260px;
                background: #1e3a8a;
                flex-shrink: 0;
                transition: transform .3s ease;
            }

            /* Mobile & Tablet: hidden */
            @media (max-width: 991.98px) {
                .sidebar-wrapper {
                    position: fixed;
                    top: 0;
                    left: 0;
                    height: 100vh;
                    z-index: 1040;
                    transform: translateX(-100%);
                }

                .sidebar-wrapper.show {
                    transform: translateX(0);
                }
            }

            /* =====================
           BACKDROP (MOBILE)
        ===================== */
            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .4);
                z-index: 1030;
                display: none;
            }

            .sidebar-backdrop.show {
                display: block;
            }

            /* =====================
           MAIN CONTENT
        ===================== */
            .main-content-wrapper {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            .content-area {
                padding: 1.5rem;
                flex-grow: 1;
                overflow-y: auto;
            }

            @media (max-width: 576px) {
                .content-area {
                    padding: 1rem;
                }
            }
        </style>

        @stack('styles')
    </head>

    <body>

        {{-- Backdrop --}}
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <div class="admin-layout">

            {{-- SIDEBAR --}}
            <aside class="sidebar-wrapper" id="sidebar">
                @include('partials.admin.sidebar')
            </aside>

            {{-- MAIN --}}
            <div class="main-content-wrapper">

                {{-- NAVBAR --}}
                @include('partials.admin.navbar')

                {{-- CONTENT --}}
                <main class="content-area">
                    @yield('content')
                </main>
            </div>
        </div>

        {{-- Bootstrap --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Chart --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- Sidebar Script --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                const toggleBtn = document.getElementById('toggleSidebar');
                const closeBtn = document.getElementById('closeSidebar');

                function openSidebar() {
                    sidebar.classList.add('show');
                    backdrop.classList.add('show');
                }

                function closeSidebar() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                }

                if (toggleBtn) {
                    toggleBtn.addEventListener('click', openSidebar);
                }

                if (closeBtn) {
                    closeBtn.addEventListener('click', closeSidebar);
                }

                backdrop.addEventListener('click', closeSidebar);

                // Auto close when menu clicked (mobile)
                sidebar.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        if (window.innerWidth < 992) closeSidebar();
                    });
                });
            });
        </script>

        @stack('scripts')
    </body>

</html>
