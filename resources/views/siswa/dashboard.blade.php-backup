{{-- Menggunakan layout 'tamu' (hijau) sebagai kerangka --}}
@extends('layouts.siswa')

{{-- Mengatur judul halaman --}}
@section('title', 'Dashboard Siswa')

@push('styles')
    {{-- CSS khusus untuk kartu statistik (Sama seperti dashboard Laboran/Pustakawan) --}}
    <style>
        .ribbon {
            position: absolute;
            top: 0;
            left: 0;
            width: 80px;
            height: 80px;
            overflow: hidden;
            z-index: 10;
        }

        .ribbon span {
            position: absolute;
            display: block;
            width: 120px;
            padding: 6px 0;
            background: #0d6efd;
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            transform: rotate(-45deg);
            top: 15px;
            left: -30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, .3);
        }

        .ribbon.buku span {
            background: #0d6efd;
            /* biru */
        }

        .ribbon.alat span {
            background: #198754;
            /* hijau */
        }

        .ribbon.terbaru span {
            background: #ff0000;
        }

        .slider-wrapper {
            width: 100%;
            overflow: hidden;
            position: relative;
            touch-action: pan-y;
        }

        .slider-track {
            display: flex;
            gap: 2rem;
            user-select: none;
            animation: slide-horizontal 20s ease-in-out infinite alternate;
            will-change: transform;
        }


        .slider-card {
            min-width: 220px;
            max-width: 220px;
            flex-shrink: 0;
        }

        .small.text-muted {
            display: none !important;
        }


        @media (max-width: 576px) {
            .slider-card {
                min-width: 160px;
            }
        }

        @keyframes slide-horizontal {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(calc(-1 * var(--overflow-width)));
            }
        }

        .book-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 380px;
            max-width: 80%;
            height: 100vh;
            background: #ffffff;
            box-shadow: -5px 0 15px rgba(0, 0, 0, .2);
            transform: translateX(100%);
            transition: transform .35s ease;
            z-index: 1055;
        }

        .book-sidebar.show {
            transform: translateX(0);
        }

        .book-sidebar-content {
            padding: 20px;
            height: 100%;
            overflow-y: auto;
        }

        .close-btn {
            position: relative;
            top: 12px;
            right: 15px;
            font-size: 28px;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        {{-- RIGHT SIDEBAR DETAIL BUKU --}}
        <div id="bookSidebar" class="book-sidebar">
            <div class="book-sidebar-content">
                <button class="close-btn" id="closeBookSidebar">&times;</button>

                <div id="bookSidebarBody">
                    {{-- DIISI VIA JS --}}
                </div>
            </div>
        </div>

        <h3 class="mb-3">Rekomendasi</h3>

        <div class="slider-wrapper">
            <div class="slider-track">
                @foreach ($items as $item)
                    <div class="slider-card isdata-items" data-id="{{ $item->id_alat ?? $item->isbn }}"
                        data-nama="{{ $item->nama }}" data-kategori="{{ $item->kategori }}"
                        data-stok="{{ $item->stok }}"
                        data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                        data-type="{{ $item->type }}" data-deskripsi="{{ $item->deskripsi }}">

                        <div class="card h-100 position-relative">
                            {{-- Ribbon Label --}}
                            <div class="ribbon {{ $item->type }}">
                                <span>{{ strtoupper($item->type) }}</span>
                            </div>

                            <div class="card-body text-center">
                                {{-- Gambar --}}
                                <div class="d-flex align-items-center justify-content-center mb-2 bg-light rounded"
                                    style="height: 150px;">
                                    @if (!empty($item->gambar))
                                        <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid"
                                            style="max-height:150px; object-fit:contain;">
                                    @else
                                        <i
                                            class="fa fa-{{ $item->type == 'buku' ? 'book' : 'flask' }} fa-4x text-{{ $item->type == 'buku' ? 'primary' : 'success' }}">
                                        </i>
                                    @endif
                                </div>


                                {{-- Nama --}}
                                <h6 class="mb-1">{{ $item->nama }}</h6>

                                {{-- Kategori --}}
                                @php
                                    if ($item->type === 'alat') {
                                        $badge = match ($item->kategori) {
                                            'Kualitas Sangat Baik' => 'success',
                                            'Kualitas Baik' => 'primary',
                                            default => 'danger',
                                        };
                                    } else {
                                        // buku
                                        $badge = $item->kategori === 'Buku Umum' ? 'primary' : 'success';
                                    }
                                @endphp

                                <span class="badge bg-{{ $badge }}">
                                    {{ $item->kategori }}
                                </span>


                                {{-- Stok --}}
                                <div class="mt-2">
                                    <span class="badge bg-{{ $item->stok < 5 ? 'danger' : 'success' }}">
                                        Stok: {{ $item->stok }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="my-4" style="border: 2px solid #ffd632;"> </div>
        <h3 class="mb-3">
            {{ request('search_buku') ? 'Hasil Pencarian Buku' : 'Perpustakaan' }}
            @if (!request('search_buku'))
                <a href="{{ route('siswa.dashboard', array_merge(request()->query(), ['filter_buku' => 'pelajaran'])) }}"
                    class="btn btn-md ms-2 mb-2 mt-2 {{ request('filter_buku') == 'pelajaran' ? 'btn-primary' : ' btn-warning' }}">
                    Buku Mata Pelajaran
                </a>

                <a href="{{ route('siswa.dashboard', array_merge(request()->query(), ['filter_buku' => 'umum'])) }}"
                    class="btn btn-md ms-2 {{ request('filter_buku') == 'umum' ? 'btn-primary' : ' btn-warning' }}">
                    Buku Umum
                </a>
            @endif
            @if (request('filter_buku'))
                <a href="{{ route('siswa.dashboard', request()->except('filter_buku')) }}"
                    class="btn btn-md btn-danger ms-2">
                    <i class="fa fa-eraser me-1"></i>
                    Reset
                </a>
            @endif

        </h3>
        <div class="d-flex flex-wrap justify-content-center gap-5">
            @forelse ($listbuku as $item)
                <div class="slider-card isdata-items" data-id="{{ $item->isbn }}" data-nama="{{ $item->nama }}"
                    data-kategori="{{ $item->kategori }}" data-stok="{{ $item->stok }}"
                    data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                    data-type="{{ $item->type }}" data-deskripsi="{{ $item->deskripsi }}">
                    <div class="card h-100 position-relative">
                        {{-- Ribbon Label --}}
                        @if ($item->isbn === $latestBukuId)
                            <div class="ribbon terbaru">
                                <span>Terbaru</span>
                            </div>
                        @endif


                        <div class="card-body text-center">
                            {{-- Gambar --}}
                            <div class="d-flex align-items-center justify-content-center mb-2 bg-light rounded"
                                style="height: 150px;">
                                @if (!empty($item->gambar))
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid"
                                        style="max-height:150px; object-fit:contain;">
                                @else
                                    <i
                                        class="fa fa-{{ $item->type == 'buku' ? 'book' : 'flask' }} fa-4x text-{{ $item->type == 'buku' ? 'primary' : 'success' }}">
                                    </i>
                                @endif
                            </div>


                            {{-- Nama --}}
                            <h6 class="mb-1">{{ $item->nama }}</h6>

                            {{-- Kategori --}}
                            @php
                                $badge = $item->kategori === 'Buku Umum' ? 'primary' : 'success';
                            @endphp

                            <span class="badge bg-{{ $badge }}">
                                {{ $item->kategori }}
                            </span>


                            {{-- Stok --}}
                            <div class="mt-2">
                                <span class="badge bg-{{ $item->stok < 5 ? 'danger' : 'success' }}">
                                    Stok: {{ $item->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada buku tersedia.</p>
            @endforelse
        </div>
        <div class="d-flex justify-content-end mt-3">
            {{ $listbuku->links('pagination::bootstrap-5') }}
        </div>

        <div class="my-4" style="border: 2px solid #ffd632;"> </div>

        <h3 class="mb-3">{{ request('search_alat') ? 'Hasil Pencarian Alat Lab' : 'Alat Lab' }}</h3>
        <div class="d-flex flex-wrap justify-content-center gap-5 ">
            @forelse ($listalat as $item)
                <div class="slider-card isdata-items" data-id="{{ $item->id_alat }}" data-nama="{{ $item->nama }}"
                    data-kategori="{{ $item->kategori }}" data-stok="{{ $item->stok }}"
                    data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                    data-type="{{ $item->type }}" data-deskripsi="{{ $item->deskripsi }}">
                    <div class="card h-100 position-relative">

                        {{-- Ribbon Label --}}
                        @if ($item->id_alat === $latestAlatId)
                            <div class="ribbon terbaru">
                                <span>Terbaru</span>
                            </div>
                        @endif


                        <div class="card-body text-center">
                            {{-- Gambar --}}
                            <div class="d-flex align-items-center justify-content-center mb-2 bg-light rounded"
                                style="height: 150px;">
                                @if (!empty($item->gambar))
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid"
                                        style="max-height:150px; object-fit:contain;">
                                @else
                                    <i
                                        class="fa fa-{{ $item->type == 'buku' ? 'book' : 'flask' }} fa-4x text-{{ $item->type == 'buku' ? 'primary' : 'success' }}">
                                    </i>
                                @endif
                            </div>

                            {{-- Nama --}}
                            <h6 class="mb-1">{{ $item->nama }}</h6>

                            {{-- Kategori --}}
                            @php
                                if ($item->type === 'alat') {
                                    $badge = match ($item->kategori) {
                                        'Kualitas Sangat Baik' => 'success',
                                        'Kualitas Baik' => 'primary',
                                        default => 'danger',
                                    };
                                } else {
                                    $badge = $item->kategori === 'Buku Umum' ? 'primary' : 'success';
                                }
                            @endphp

                            <span class="badge bg-{{ $badge }}">
                                {{ $item->kategori }}
                            </span>

                            {{-- Stok --}}
                            <div class="mt-2">
                                <span class="badge bg-{{ $item->stok < 5 ? 'danger' : 'success' }}">
                                    Stok: {{ $item->stok }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada alat lab tersedia.</p>
            @endforelse
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $listalat->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.querySelector('.slider-wrapper');
            const track = document.querySelector('.slider-track');

            if (!wrapper || !track) return;

            const wrapperWidth = wrapper.clientWidth;
            const trackWidth = track.scrollWidth;
            const overflow = trackWidth - wrapperWidth;

            if (overflow <= 0) return;

            track.style.setProperty('--overflow-width', overflow + 'px');

            let startX = 0;
            let currentX = 0;
            let isDragging = false;
            let resumeTimer = null;

            function getTranslateX() {
                const matrix = window.getComputedStyle(track).transform;
                if (matrix === 'none') return 0;
                return parseFloat(matrix.split(',')[4]);
            }

            function setTranslateX(x) {
                const min = -overflow;
                const max = 0;
                currentX = Math.max(Math.min(x, max), min);
                track.style.transform = `translateX(${currentX}px)`;
            }

            function stopAnimation() {
                clearTimeout(resumeTimer);
                currentX = getTranslateX();
                track.style.animation = 'none';
                setTranslateX(currentX);
            }

            function startAnimation() {
                track.style.transform = '';
                track.style.animation =
                    'slide-horizontal 20s ease-in-out infinite alternate';
            }

            function debounceStartAnimation(delay = 1200) {
                clearTimeout(resumeTimer);
                resumeTimer = setTimeout(() => {
                    startAnimation();
                }, delay);
            }

            /* =======================
               DESKTOP (MOUSE)
            ======================= */
            wrapper.addEventListener('mouseenter', stopAnimation);

            wrapper.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.clientX;
                stopAnimation();
            });

            wrapper.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                const diff = e.clientX - startX;
                setTranslateX(currentX + diff);
                startX = e.clientX;
            });

            window.addEventListener('mouseup', () => {
                if (!isDragging) return;
                isDragging = false;
                debounceStartAnimation(); // ⏳ TIDAK LANGSUNG RESET
            });

            wrapper.addEventListener('mouseleave', () => {
                if (!isDragging) debounceStartAnimation();
            });

            /* =======================
               MOBILE (TOUCH)
            ======================= */
            wrapper.addEventListener('touchstart', (e) => {
                isDragging = true;
                startX = e.touches[0].clientX;
                stopAnimation();
            }, {
                passive: true
            });

            wrapper.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault(); // ⬅️ wajib agar geser jalan
                const diff = e.touches[0].clientX - startX;
                setTranslateX(currentX + diff);
                startX = e.touches[0].clientX;
            }, {
                passive: false
            });

            wrapper.addEventListener('touchend', () => {
                isDragging = false;
                debounceStartAnimation(900); // ⏳ debounce lebih halus di HP
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('bookSidebar');
            const body = document.getElementById('bookSidebarBody');
            const closeBtn = document.getElementById('closeBookSidebar');

            document.querySelectorAll('.isdata-items').forEach(item => {
                item.addEventListener('click', () => {
                    const id = item.dataset.id;
                    const nama = item.dataset.nama;
                    const kategori = item.dataset.kategori;
                    const stok = item.dataset.stok;
                    const gambar = item.dataset.gambar;
                    const type = item.dataset.type;
                    const deskripsi = item.dataset.deskripsi;
                    const detailUrl =
                        type === 'buku' ?
                        `/siswa/buku/${id}` :
                        `/siswa/alat/${id}`;

                    const badgeClass = (() => {
                        switch (kategori) {
                            case 'Buku Mata Pelajaran':
                                return 'success';
                            case 'Kualitas Sangat Baik':
                                return 'success';
                            case 'Kualitas Buruk':
                                return 'danger';
                            default:
                                return 'primary';
                        }
                    })();

                    body.innerHTML = `
            <div class="text-center mb-3">
                ${
                    gambar
                        ? `<img src="${gambar}" class="img-fluid mb-3 mt-4" style="max-height:300px; max-width:80%; object-fit:contain; border:3px solid #ffd632; border-radius:5px;">`
                        : `<i class="fa fa-${type === 'buku' ? 'book text-primary' : 'flask text-success'} fa-5x mb-3"></i>`
                }
            </div>


                <h5 class="fw-bold text-dark text-center">${nama}</h5>
                <div class="text-center mb-3">
                    <span class="badge bg-${badgeClass}">${kategori}</span>
                    <span class="badge bg-${stok < 5 ? 'danger' : 'success'}">
                        Stok: ${stok}
                    </span>
                </div>

                <textarea class="form-control text-center mb-3" rows="6" readonly style="background:#f8f9fa; border:none; resize:none;">${deskripsi}</textarea>

                <hr>

                  <a href="${detailUrl}" class="btn btn-success w-100 mt-2">
        Detail Lengkap
    </a>
            `;

                    sidebar.classList.add('show');
                });
            });

            closeBtn.addEventListener('click', () => {
                sidebar.classList.remove('show');
            });

            // Klik area luar untuk menutup
            document.addEventListener('click', (e) => {
                if (
                    sidebar.classList.contains('show') &&
                    !sidebar.contains(e.target) &&
                    !e.target.closest('.isdata-items')
                ) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
@endpush
