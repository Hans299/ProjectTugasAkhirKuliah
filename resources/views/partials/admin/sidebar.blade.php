{{--
  Sidebar Biru Tua Dinamis
  File ini akan menampilkan menu yang berbeda
  berdasarkan Auth::user()->role
--}}
<div class="d-flex flex-column flex-shrink-0 p-3" style=" height: 100vh; background-color: #25256C; color: white;">
    <button id="closeSidebar" class="btn btn-sm text-white d-lg-none align-self-end mb-3">
        <i class="fa fa-times fa-2x"></i>
    </button>

    {{-- Logo --}}
    <a href="#"
        class="d-flex flex-column  justify-content-center align-items-center mb-4 text-white text-decoration-none text-center">
        <div class="d-flex align-items-center justify-content-center mb-2"
            style="width: auto; height: auto; border-radius: 10px;">
            <img width="80" src="{{ asset('/logo.png') }}" alt="Logo">
        </div>

        <div class="fw-bold">
            SMP NEGERI 6 <br> Bandar Lampung
        </div>
    </a>

    <hr class="mt-4" style="border-color: rgba(255, 255, 255, 0.3);">

    {{-- Menu Navigasi --}}
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- ========================================================== --}}
        {{-- ================== MENU UNTUK SUPERADMIN ================= --}}
        {{-- ========================================================== --}}
        {{--
            CATATAN:
            Nama rute 'dasbor' Anda telah diubah menjadi 'dashboard'.
            Rute 'admins' dan 'pengguna' telah digabung menjadi 'users' (sesuai UserController kita).
        --}}
        @if (Auth::user()->role->name == 'superadmin')
            <li class="nav-item mb-2">
                <a href="/admin/superadmin/dashboard"
                    class="nav-link nav-admin {{ Request::is('admin/superadmin/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 6 (Kelola Akun) --}}
                <a href="{{ route('admin.superadmin.admin.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/superadmin/admin') ? 'active' : '' }}">
                    <i class="fa fa-users me-1"></i> Kelola Akun Admin
                </a>
            </li>

            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 6 (Kelola Akun) --}}
                <a href="{{ route('admin.superadmin.user.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/superadmin/user') ? 'active' : '' }}">
                    <i class="fa fa-user me-2"></i> Kelola Akun User
                </a>
            </li>

            {{-- Superadmin juga bisa melihat item (opsional) --}}
            <li class="nav-item mb-2">
                <a href="{{ route('admin.pustakawan.buku.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Perpustakaan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.laboran.alat.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Laboratorium
                </a>
            </li>

            {{-- Transaksi Dropdown untuk Superadmin (Rute 'transaksi' belum dibuat) --}}
            <li class="nav-item mb-2">
                <a href="#transaksiSubmenu" data-bs-toggle="collapse"
                    class="nav-link nav-admin d-flex justify-content-between align-items-center {{ Request::is('admin/pustakawan/transaksi*') || Request::is('admin/laboran/transaksi*') ? 'active' : '' }}">
                    <span><i class="fa fa-exchange-alt me-2"></i> Transaksi</span>
                    <i class="fa fa-chevron-down small"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 {{ Request::is('admin/pustakawan/transaksi*') || Request::is('admin/laboran/transaksi*') ? 'show' : '' }}"
                    id="transaksiSubmenu">
                    <li class="nav-item mb-1 mt-2">
                        <a href="{{ route('admin.pustakawan.transaksi.index') }}"
                            class="nav-link nav-admin-sub {{ Request::is('admin/pustakawan/transaksi*') ? 'active-sub' : '' }}">
                            Perpustakaan (TBD)
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('admin.laboran.transaksi.index') }}"
                            class="nav-link nav-admin-sub {{ Request::is('admin/laboran/transaksi*') ? 'active-sub' : '' }}">
                            Laboratorium (TBD)
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ========================================================== --}}
            {{-- ================== MENU UNTUK PUSTAKAWAN ================= --}}
            {{-- ========================================================== --}}
        @elseif(Auth::user()->role->name == 'pustakawan')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.pustakawan.dashboard') }}"
                    class="nav-link nav-admin {{ Request::is('admin/pustakawan/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 7 (Kelola Buku) --}}
                <a href="{{ route('admin.pustakawan.buku.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Perpustakaan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.pustakawan.transaksi.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/pustakawan/transaksi*') ? 'active' : '' }}">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi Perpustakaan
                </a>
            </li>

            {{-- ========================================================== --}}
            {{-- =================== MENU UNTUK LABORAN =================== --}}
            {{-- ========================================================== --}}
        @elseif(Auth::user()->role->name == 'laboran')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.laboran.dashboard') }}"
                    class="nav-link nav-admin {{ Request::is('admin/laboran/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 7 (Kelola Alat) --}}
                <a href="{{ route('admin.laboran.alat.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Kelola Alat
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.laboran.transaksi.index') }}"
                    class="nav-link nav-admin {{ Request::is('admin/laboran/transaksi*') ? 'active' : '' }}">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi
                </a>
            </li>
        @endif
    </ul>

    {{-- Tombol Logout di Bawah (Rute 'logout' SUDAH BENAR) --}}
    <hr style="border-color: rgba(255, 255, 255, 0.3);">
    <div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center py-2">
                <i class="fa fa-sign-out-alt me-2"></i>
                <span class="fw-bold">Logout</span>
            </button>
        </form>
    </div>
</div>

{{-- CSS untuk Nav Link (Biarkan apa adanya) --}}
<style>
    .nav-admin {
        color: #FFFFFF;
        font-weight: 500;
        font-size: 1rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
    }

    .nav-admin:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #FFFFFF;
    }

    .nav-pills .nav-link.active,
    .nav-pills .show>.nav-link {
        background-color: #ffffff;
        color: #25256C !important;
        /* Warna biru tua */
        font-weight: 600;
    }

    /* Submenu styling */
    .nav-admin-sub {
        color: #e0e0e0;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        text-decoration: none;
        display: block;
        border-radius: 6px;
    }

    .nav-admin-sub:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #FFFFFF;
    }

    .nav-admin-sub.active-sub {
        color: #ffffff;
        font-weight: 600;
    }
</style>
