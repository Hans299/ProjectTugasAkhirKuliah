<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3">
    <div class="container-fluid">
        <div class="d-flex justify-content-start">
            <button class="btn btn-outline-primary d-lg-none" id="toggleSidebar">
                <i class="fa fa-bars"></i>
            </button>
        </div>

        {{-- User Dropdown --}}
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{-- Ganti dengan foto profil --}}
                @if (Auth::user()->profile_photo_path && file_exists(public_path('storage/' . Auth::user()->profile_photo_path)))
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="User Avatar"
                        class="rounded-circle me-2" width="40" height="40">
                @else
                    <i class="fa fa-user-circle fa-2x text-primary me-2"></i>
                @endif

                <div>
                    <span class="fw-bold d-block">{{ Auth::user()->name }}</span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="{{ route('profile.index') }}">Profiles</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
