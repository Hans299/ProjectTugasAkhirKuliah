{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Dashboard Pustakawan')

@push('styles')
    {{-- CSS khusus untuk kartu statistik --}}
    <style>
        .fc-day-sun {
            background-color: #fff5f5;
        }

        .fc-event {
            font-size: 12px;
            border-radius: 6px;
            padding: 2px 4px;
        }

        /* ===== EVENT DI KALENDER ===== */
        .fc-daygrid-event {
            white-space: normal !important;
            overflow: visible !important;
            text-overflow: unset !important;
            cursor: pointer;
        }

        /* Judul event di dalam tanggal */
        .fc-event-title {
            font-size: 11px;
            line-height: 1.25;
            white-space: normal !important;
        }

        /* Tinggi cell agar rapi */
        .fc-daygrid-day-frame {
            min-height: 120px;
        }

        /* ===== TOOLTIP CUSTOM ===== */
        .fc-tooltip {
            position: absolute;
            z-index: 9999;
            background: #212529;
            color: #fff;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 12px;
            max-width: 260px;
            line-height: 1.4;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .2);
        }

        /* ===== HARI INI (TODAY) ===== */
        .fc-day-today {
            background-color: #e7f1ff !important;
            /* biru muda */
        }

        .fc-day-today .fc-daygrid-day-number {
            background: #25256c;
            /* biru bootstrap */
            color: #fff;
            border-radius: 50%;
            padding: 4px 8px;
            font-weight: 600;
        }

        .stat-card {
            background-color: #25256C;
            /* Warna biru tua */
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
        }

        .stat-card-title {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-card-number {
            font-size: 2.25rem;
            font-weight: 700;
        }

        .stat-card .icon {
            font-size: 2rem;
            opacity: 0.8;
        }

        .calendar-placeholder {
            background-color: #D9D9D9;
            border-radius: 12px;
            min-height: 400px;
            /* Tinggi minimal kalender */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')

    <div class="row g-4">
        {{-- Kolom Kiri: Kartu Statistik --}}
        <div class="col-lg-8">
            <div class="row g-4">

                {{-- Kartu 1: Jumlah Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Buku</h5>
                                {{-- Ganti $jumlahBuku dengan variabel dari Controller --}}
                                <span class="stat-card-number">{{ $jumlahBuku ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 2: Jumlah Peminjaman Buku --}}
                <div class="col-md-6">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Peminjaman Buku</h5>
                                <span class="stat-card-number">{{ $jumlahPeminjaman ?? 100 }}</span>
                            </div>
                            <i class="fa fa-book-reader icon"></i>
                        </div>
                    </div>
                </div>

                {{-- Kartu 3: Jumlah Pengembalian Buku --}}
                <div class="col-md-6"> {{-- Sesuai desain, kartu ini di baris baru --}}
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="stat-card-title">Jumlah Pengembalian Buku</h5> {{-- Di desain tertulis "Pengembangan" --}}
                                <span class="stat-card-number">{{ $jumlahPengembalian ?? 100 }}</span>
                            </div>
                            <i class="fa fa-undo icon"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Kolom Kanan: Kalender --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    📅 Kalender Indonesia
                </div>
                <div class="card-body p-2">
                    <div id="calendarIndonesia"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendarIndonesia');

            const holidays = @json($holidays);

            // Mapping events
            const events = holidays.map(item => {
                const month = String(item.bulan).padStart(2, '0');
                const day = String(item.tanggal).padStart(2, '0');

                return {
                    title: item.keterangan.length > 18 ?
                        item.keterangan.substring(0, 18) + '…' : item.keterangan,
                    start: `${item.tahun}-${month}-${day}`,
                    allDay: true,
                    color: '#dc3545',
                    extendedProps: {
                        fullTitle: item.keterangan
                    }
                };
            });

            let tooltip;

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 'auto',
                eventDisplay: 'block',
                dayMaxEventRows: false,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: events,

                // TOOLTIP HANDLER
                eventDidMount: function(info) {
                    info.el.addEventListener('mouseenter', function(e) {
                        tooltip = document.createElement('div');
                        tooltip.className = 'fc-tooltip';
                        tooltip.innerText = info.event.extendedProps.fullTitle;
                        document.body.appendChild(tooltip);

                        const rect = info.el.getBoundingClientRect();
                        tooltip.style.top = rect.top + window.scrollY - tooltip.offsetHeight -
                            6 + 'px';
                        tooltip.style.left = rect.left + window.scrollX + 'px';
                    });

                    info.el.addEventListener('mouseleave', function() {
                        if (tooltip) {
                            tooltip.remove();
                            tooltip = null;
                        }
                    });
                }
            });

            calendar.render();
        });
    </script>
@endpush
