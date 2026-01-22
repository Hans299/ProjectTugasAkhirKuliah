<nav class="navbar sticky-top navbar-expand-lg shadow-sm p-3"
    style="background-color: #255f38; border: 2px solid #ffd632;">
    <div class="container-fluid">
        {{-- KIRI: FORM PENCARIAN --}}
        <div class="d-flex gap-4 mb-3">

            {{-- Form Cari Buku --}}
            <form method="GET" id="search-buku-form" class="d-flex align-items-center">
                <input type="text" name="search_buku" id="search-buku-input" class="form-control form-control-sm me-1"
                    placeholder="Cari buku..." value="{{ request('search_buku') }}">

                <button type="button" class="btn btn-sm btn-primary" id="search-buku-btn"
                    {{ request('search_buku') ? '' : 'disabled' }}>
                    <i class="fa {{ request('search_buku') ? 'fa-times' : 'fa-search' }}" id="search-buku-icon"></i>
                </button>
            </form>


            {{-- Form Cari Alat Lab --}}
            <form method="GET" class="d-flex align-items-center" id="search-alat-form">
                <input type="text" name="search_alat" id="search-alat-input"
                    class="form-control form-control-sm me-1" placeholder="Cari alat lab..."
                    value="{{ request('search_alat') }}">

                <button type="button" class="btn btn-sm btn-success" id="search-alat-btn"
                    {{ request('search_alat') ? '' : 'disabled' }}>
                    <i class="fa {{ request('search_alat') ? 'fa-times' : 'fa-search' }}" id="search-alat-icon"></i>
                </button>
            </form>


        </div>
        <button class="btn btn-outline-light d-md-none ms-3" id="toggleSidebar">
            <i class="fa fa-bars"></i>
        </button>
        {{-- User Dropdown --}}
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdownMenuLink"
                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{-- Ganti dengan foto profil --}}
                @if (Auth::user()->profile_photo_path && file_exists(public_path('storage/' . Auth::user()->profile_photo_path)))
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="User Avatar"
                        class="rounded-circle me-2" width="40" height="40">
                @else
                    <i class="fa fa-user-circle fa-2x text-white me-2"></i>
                @endif

                <div>
                    <span class="fw-bold d-block text-light">{{ Auth::user()->name }}</span>
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
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formAlat = document.getElementById('search-alat-form');
            const inputAlat = document.getElementById('search-alat-input');
            const iconAlat = document.getElementById('search-alat-icon');
            const btnAlat = document.getElementById('search-alat-btn');

            const formBuku = document.getElementById('search-buku-form');
            const inputBuku = document.getElementById('search-buku-input');
            const iconBuku = document.getElementById('search-buku-icon');
            const btnBuku = document.getElementById('search-buku-btn');

            btnBuku.addEventListener('click', () => {
                if (inputBuku.value.trim() !== '') {
                    // 🔥 CLEAR SEARCH
                    inputBuku.value = '';
                    formBuku.submit();
                } else {
                    // 🔍 SUBMIT SEARCH
                    formBuku.submit();
                }
            });

            btnAlat.addEventListener('click', () => {
                if (inputAlat.value.trim() !== '') {
                    // 🔥 CLEAR SEARCH
                    inputAlat.value = '';
                    formAlat.submit();
                } else {
                    // 🔍 SUBMIT SEARCH
                    formAlat.submit();
                }
            });

            function debounceSearch(inputId, formId, iconId) {
                let debounceTimer;
                const input = document.getElementById(inputId);
                const form = document.getElementById(formId);
                const icon = document.getElementById(iconId);

                input.addEventListener('input', () => {
                    // Ganti icon jadi spinner
                    icon.className = 'fa fa-spinner fa-spin';

                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        form.submit();
                    }, 600); // debounce 600ms (nyaman)
                });
            }

            debounceSearch(
                'search-buku-input',
                'search-buku-form',
                'search-buku-icon'
            );

            debounceSearch(
                'search-alat-input',
                'search-alat-form',
                'search-alat-icon'
            );

            const params = new URLSearchParams(window.location.search);
            const searchAlat = params.get('search_alat');

            if (searchAlat && searchAlat.trim() !== '') {
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth'
                });
            }

        });
    </script>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar-wrapper');
            const toggleBtn = document.getElementById('toggleSidebar');
            const closeBtn = document.getElementById('closeSidebar');

            // =========================
            // OPEN SIDEBAR
            // =========================
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // cegah langsung ketutup
                    sidebar.classList.add('show');
                });
            }

            // =========================
            // CLOSE VIA BUTTON ❌
            // =========================
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    sidebar.classList.remove('show');
                });
            }

            // =========================
            // CLICK OUTSIDE → CLOSE
            // =========================
            document.addEventListener('click', function(e) {
                if (
                    sidebar.classList.contains('show') &&
                    !sidebar.contains(e.target) &&
                    !toggleBtn.contains(e.target)
                ) {
                    sidebar.classList.remove('show');
                }
            });

            // =========================
            // AUTO CLOSE SAAT KLIK MENU
            // =========================
            sidebar.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 992) {
                        sidebar.classList.remove('show');
                    }
                });
            });
        });
    </script>
@endpush
