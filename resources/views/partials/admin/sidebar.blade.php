{{-- 
  Sidebar Biru Tua Dinamis
  File ini akan menampilkan menu yang berbeda
  berdasarkan Auth::user()->role
--}}
<div class="d-flex flex-column flex-shrink-0 p-3" style="width: 280px; height: 100vh; background-color: #25256C; color: white;">
    
    {{-- Logo --}}
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <div class="d-flex align-items-center justify-content-center" style="width: 150px; height: 70px; background-color: #D9D9D9; border-radius: 10px; margin-left: 10px; margin-top: 10px;">
            <span style="color: #333; font-weight: 600;">Logo</span>
        </div>
    </a>
    <hr class="mt-4" style="border-color: rgba(255, 255, 255, 0.3);">
    
    {{-- Menu Navigasi --}}
    <ul class="nav nav-pills flex-column mb-auto">

        {{-- ========================================================== --}}
        {{-- ================== MENU UNTUK SUPERADMIN ================= --}}
        {{-- ========================================================== --}}
        @if(Auth::user()->role == 'superadmin')
            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.dasbor') }}" class="nav-link nav-admin {{ Request::is('superadmin/dasbor*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.admins.index') }}" class="nav-link nav-admin {{ Request::is('superadmin/admins*') ? 'active' : '' }}">
                    <i class="fa fa-user-shield me-2"></i> Kelola Akun Admin
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('superadmin.pengguna.index') }}" class="nav-link nav-admin {{ Request::is('superadmin/pengguna*') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i> Kelola Akun User
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('pustakawan.buku.index') }}" class="nav-link nav-admin {{ Request::is('pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Perpustakaan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laboran.alat.index') }}" class="nav-link nav-admin {{ Request::is('laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Labotarium
                </a>
            </li>
            {{-- Transaksi Dropdown untuk Superadmin --}}
            <li class="nav-item mb-2">
                <a href="#transaksiSubmenu" data-bs-toggle="collapse" class="nav-link nav-admin d-flex justify-content-between align-items-center {{ (Request::is('pustakawan/transaksi*') || Request::is('laboran/transaksi*')) ? 'active' : '' }}">
                    <span><i class="fa fa-exchange-alt me-2"></i> Transaksi</span>
                    <i class="fa fa-chevron-down small"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 {{ (Request::is('pustakawan/transaksi*') || Request::is('laboran/transaksi*')) ? 'show' : '' }}" id="transaksiSubmenu">
                    <li class="nav-item mb-1 mt-2">
                        <a href="{{ route('pustakawan.transaksi.index') }}" class="nav-link nav-admin-sub {{ Request::is('pustakawan/transaksi*') ? 'active-sub' : '' }}">
                            Perpustakaan
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="{{ route('laboran.transaksi.index') }}" class="nav-link nav-admin-sub {{ Request::is('laboran/transaksi*') ? 'active-sub' : '' }}">
                            Labotarium
                        </a>
                    </li>
                </ul>
            </li>

        {{-- ========================================================== --}}
        {{-- ================== MENU UNTUK PUSTAKAWAN ================= --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role == 'pustakawan')
            <li class="nav-item mb-2">
                <a href="{{ route('pustakawan.dasbor') }}" class="nav-link nav-admin {{ Request::is('pustakawan/dasbor*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('pustakawan.buku.index') }}" class="nav-link nav-admin {{ Request::is('pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Perpustakaan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('pustakawan.transaksi.index') }}" class="nav-link nav-admin {{ Request::is('pustakawan/transaksi*') || Request::is('pustakawan/laporan*') ? 'active' : '' }}">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi Perpustakaan
                </a>
            </li>

        {{-- ========================================================== --}}
        {{-- =================== MENU UNTUK LABORAN =================== --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role == 'laboran')
            <li class="nav-item mb-2">
                <a href="{{ route('laboran.dasbor') }}" class="nav-link nav-admin {{ Request::is('laboran/dasbor*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laboran.alat.index') }}" class="nav-link nav-admin {{ Request::is('laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Labotarium
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('laboran.transaksi.index') }}" class="nav-link nav-admin {{ Request::is('laboran/transaksi*') || Request::is('laboran/laporan*') ? 'active' : '' }}">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi Labotarium
                </a>
            </li>
        
        @endif
    </ul>
    
    {{-- Tombol Logout di Bawah --}}
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

{{-- CSS untuk Nav Link --}}
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
    .nav-pills .nav-link.active, .nav-pills .show > .nav-link {
        background-color: #ffffff;
        color: #25256C !important; /* Warna biru tua */
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