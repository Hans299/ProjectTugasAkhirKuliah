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
        {{-- 
            CATATAN: 
            Nama rute 'dasbor' Anda telah diubah menjadi 'dashboard'.
            Rute 'admins' dan 'pengguna' telah digabung menjadi 'users' (sesuai UserController kita).
        --}}
        @if(Auth::user()->role->name == 'superadmin')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.superadmin.dashboard') }}" class="nav-link nav-admin {{ Request::is('admin/superadmin/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 6 (Kelola Akun) --}}
                <a href="{{ route('admin.superadmin.users.index') }}" class="nav-link nav-admin {{ Request::is('admin/superadmin/users*') ? 'active' : '' }}">
                    <i class="fa fa-users me-2"></i> Kelola Akun
                </a>
            </li>
            
            {{-- Superadmin juga bisa melihat item (opsional) --}}
            <li class="nav-item mb-2">
                <a href="{{ route('admin.pustakawan.buku.index') }}" class="nav-link nav-admin {{ Request::is('admin/pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Perpustakaan
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.laboran.alat.index') }}" class="nav-link nav-admin {{ Request::is('admin/laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Laboratorium
                </a>
            </li>
            
            {{-- Transaksi Dropdown untuk Superadmin (Rute 'transaksi' belum dibuat) --}}
            <li class="nav-item mb-2">
                <a href="#transaksiSubmenu" data-bs-toggle="collapse" class="nav-link nav-admin d-flex justify-content-between align-items-center {{ (Request::is('admin/pustakawan/transaksi*') || Request::is('admin/laboran/transaksi*')) ? 'active' : '' }}">
                    <span><i class="fa fa-exchange-alt me-2"></i> Transaksi</span>
                    <i class="fa fa-chevron-down small"></i>
                </a>
                <ul class="collapse list-unstyled ps-4 {{ (Request::is('admin/pustakawan/transaksi*') || Request::is('admin/laboran/transaksi*')) ? 'show' : '' }}" id="transaksiSubmenu">
                    <li class="nav-item mb-1 mt-2">
                        {{-- <a href="{{ route('admin.pustakawan.transaksi.index') }}" class="nav-link nav-admin-sub {{ Request::is('admin/pustakawan/transaksi*') ? 'active-sub' : '' }}"> --}}
                        <a href="#" class="nav-link nav-admin-sub">
                            Perpustakaan (TBD)
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        {{-- <a href="{{ route('admin.laboran.transaksi.index') }}" class="nav-link nav-admin-sub {{ Request::is('admin/laboran/transaksi*') ? 'active-sub' : '' }}"> --}}
                        <a href="#" class="nav-link nav-admin-sub">
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
                <a href="{{ route('admin.pustakawan.dashboard') }}" class="nav-link nav-admin {{ Request::is('admin/pustakawan/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 7 (Kelola Buku) --}}
                <a href="{{ route('admin.pustakawan.buku.index') }}" class="nav-link nav-admin {{ Request::is('admin/pustakawan/buku*') ? 'active' : '' }}">
                    <i class="fa fa-book me-2"></i> Kelola Buku
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- <a href="{{ route('admin.pustakawan.transaksi.index') }}" class="nav-link nav-admin {{ Request::is('admin/pustakawan/transaksi*') || Request::is('admin/pustakawan/laporan*') ? 'active' : '' }}"> --}}
                <a href="#" class="nav-link nav-admin">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi (TBD)
                </a>
            </li>

        {{-- ========================================================== --}}
        {{-- =================== MENU UNTUK LABORAN =================== --}}
        {{-- ========================================================== --}}
        @elseif(Auth::user()->role->name == 'laboran')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.laboran.dashboard') }}" class="nav-link nav-admin {{ Request::is('admin/laboran/dashboard*') ? 'active' : '' }}">
                    <i class="fa fa-th-large me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- Ini adalah link dari Tahap 7 (Kelola Alat) --}}
                <a href="{{ route('admin.laboran.alat.index') }}" class="nav-link nav-admin {{ Request::is('admin/laboran/alat*') ? 'active' : '' }}">
                    <i class="fa fa-flask me-2"></i> Kelola Alat
                </a>
            </li>
            <li class="nav-item mb-2">
                {{-- <a href="{{ route('admin.laboran.transaksi.index') }}" class="nav-link nav-admin {{ Request::is('admin/laboran/transaksi*') || Request::is('admin/laboran/laporan*') ? 'active' : '' }}"> --}}
                <a href="#" class="nav-link nav-admin">
                    <i class="fa fa-exchange-alt me-2"></i> Transaksi (TBD)
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