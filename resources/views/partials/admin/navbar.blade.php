<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3">
    <div class="container-fluid">
        
        {{-- Tombol Toggle Sidebar (untuk mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Search Bar (Sesuai Desain) --}}
        <form class="d-flex ms-auto">
            <input class="form-control me-2" type="search" placeholder="Cari disini" aria-label="Search" style="width: 300px;">
        </form>

        {{-- User Dropdown --}}
        <ul class="navbar-nav ms-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{-- Ganti dengan foto profil --}}
                    <i class="fa fa-user-circle fa-2x text-primary me-2"></i>
                    <div>
                        <span class="fw-bold d-block">{{ Auth::user()->name ?? 'Hans Bonatua' }}</span>
                        <small class="text-muted">{{ Auth::user()->role ?? 'Laboran' }}</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>