<div class="sidebar-sticky d-flex flex-column p-4"
    style="height: 100%; max-height: 100vh; background-color: #255f38; border: 2px solid #ffd632; color: white;">
    <button id="closeSidebar" class="btn btn-sm btn-light d-lg-none align-self-end mb-3">
        <i class="fa fa-times fa-2x"></i>
    </button>
    {{-- Logo --}}
    <a href="{{ route('siswa.dashboard') }}"
        class="d-flex justify-content-center align-items-center mb-4 text-decoration-none">
        <a href="#" class="d-flex justify-content-center align-items-center mb-4 text-white text-decoration-none">
            <div class="d-flex align-items-center justify-content-center"
                style="width: auto; height: auto; border-radius: 10px;">
                <img width="80px" src="{{ asset('/logo.png') }}" />
            </div>
        </a>
    </a>

    {{-- Menu Navigasi --}}
    <ul class="nav nav-pills flex-column mb-auto">
        {{-- Tombol Home --}}
        <li class="nav-item mb-3">
            {{--
              Request::is('siswa/dasbor*') akan mengecek URL.
              Jika cocok, class 'active' akan ditambahkan (membuat tombol jadi kuning).
            --}}
            <a href="{{ route('siswa.dashboard') }}"
                class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('dashboard*') ? 'active' : '' }}"
                style="border-radius: 10px; color: white; --bs-nav-pills-link-active-bg: #F8D442; --bs-nav-pills-link-active-color: #333;">

                <span style="font-size: 2rem;">🏠</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span style="font-weight: 500;">Dashboard</span>
            </a>
        </li>

        {{-- Tombol Peminjaman --}}
        <li class="nav-item mb-3">
            <a href="{{ route('siswa.pinjaman.riwayat') }}"
                class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('pinjaman') ? 'active' : '' }}"
                style="border-radius: 10px; color: white; --bs-nav-pills-link-active-bg: #F8D442; --bs-nav-pills-link-active-color: #333;">

                <span style="font-size: 2rem;">📚</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span style="font-weight: 500;">Peminjaman</span>
            </a>
        </li>

        {{-- Tombol Pengembalian (Riwayat) --}}
        <li class="nav-item mb-3">
            <a href="{{ route('siswa.pinjaman.pengembalian') }}"
                class="nav-link d-flex flex-column align-items-center justify-content-center p-3 {{ Request::is('pengembalian') ? 'active' : '' }}"
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
            <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center p-2"
                style="border-radius: 10px; font-weight: 500; background-color: #E63946;">
                <span style="font-size: 1.5rem; margin-right: 10px;">🚪</span> {{-- Ganti dengan <img> ikon Anda --}}
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>
