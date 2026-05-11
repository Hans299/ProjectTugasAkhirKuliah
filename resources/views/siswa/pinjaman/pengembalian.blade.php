@extends('layouts.siswa')

@section('title', 'Aksi Pengembalian')
@push('styles')
    <style>
        .hover-card {
            transition: background 0.2s ease, transform 0.1s ease;
        }

        .hover-card:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="container py-4">

        <h4 class="fw-bold mb-4">
            <i class="fa fa-history me-2"></i> Aksi Pengembalian
        </h4>

        {{-- ALERT --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('siswa.pinjaman.pengembalian') }}"
                class="btn btn-sm {{ !$filter ? 'btn-primary' : 'btn-info' }}">
                Semua
            </a>

            <a href="{{ route('siswa.pinjaman.pengembalian', ['filter' => 'buku']) }}"
                class="btn btn-sm {{ $filter === 'buku' ? 'btn-primary' : 'btn-info' }}">
                <i class="fa fa-book me-1"></i> Buku
            </a>

            <a href="{{ route('siswa.pinjaman.pengembalian', ['filter' => 'alat']) }}"
                class="btn btn-sm {{ $filter === 'alat' ? 'btn-primary' : 'btn-info' }}">
                <i class="fa fa-flask me-1"></i> Alat Lab
            </a>
        </div>
        {{-- DATA --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">

                @forelse ($transaksis as $trx)
                    @php
                        $item = $trx->itemable;
                        $type = class_basename($trx->itemable_type); // Buku / AlatLab
                        $isClickable = $trx->status === 'dipinjam';
                    @endphp

                    {{-- WRAPPER LINK --}}
                    @if ($isClickable)
                        <a href="{{ route('siswa.pinjaman.kembalikan.store', $trx->id) }}"
                            class="text-decoration-none text-dark">
                    @endif

                    <div
                        class="d-flex flex-column flex-md-row gap-3 border-bottom py-3
                    {{ $isClickable ? 'hover-card cursor-pointer' : 'opacity-75' }}">

                        {{-- ICON / GAMBAR --}}
                        <div class="text-center" style="width:120px;">
                            @if ($item && $item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded"
                                    style="max-height:90px; object-fit:contain;">
                            @else
                                <i
                                    class="fa fa-{{ $type === 'Buku' ? 'book text-primary' : 'flask text-success' }} fa-3x"></i>
                            @endif
                        </div>

                        {{-- INFO --}}
                        <div class="flex-grow-1">

                            <h6 class="fw-bold mb-1">
                                {{ $type === 'Buku' ? $item->judul_buku : $item->nama_alat }}
                            </h6>

                            <div class="small text-muted mb-1">
                                {{ $type === 'Buku' ? 'ISBN' : 'ID Alat' }} :
                                {{ $type === 'Buku' ? $item->isbn : $item->id_alat }}
                            </div>

                            <div class="small text-muted mb-1">
                                Tanggal Pinjam :
                                {{ \Carbon\Carbon::parse($trx->tanggal_pinjam)->format('d M Y') }}
                            </div>

                            <div class="small text-muted">
                                Jumlah Dipinjam : {{ $trx->jumlah }}
                            </div>

                            @if ($trx->catatan)
                                <div class="mt-2 p-2 bg-warning bg-opacity-25 rounded">
                                    <strong>Catatan:</strong>
                                    <p class="mb-0">{{ $trx->catatan }}</p>
                                </div>
                            @endif
                            @if ($trx->tanggal_pengembalian)
                                <div class="badge bg-danger mt-2 p-2">
                                    Harus dikembalikan :
                                    {{ \Carbon\Carbon::parse($trx->tanggal_pengembalian)->format('d M Y') }}
                                </div>
                            @endif

                            {{-- PETUNJUK --}}
                            @if ($isClickable)
                                <div class="text-success small mt-2">
                                    <i class="fa fa-arrow-right me-1"></i>
                                    Klik untuk melakukan pengembalian
                                </div>
                            @endif
                        </div>

                        {{-- STATUS --}}
                        <div class="text-md-end">
                            @php
                                $statusClass = match ($trx->status) {
                                    'pending' => 'warning',
                                    'dipinjam' => 'primary',
                                    'dikembalikan' => 'success',
                                    'ditolak' => 'danger',
                                    default => 'secondary',
                                };
                            @endphp

                            <span class="badge bg-{{ $statusClass }} px-3 py-2">
                                {{ ucfirst($trx->status) }}
                            </span>
                        </div>

                    </div>

                    @if ($isClickable)
                        </a>
                    @endif

                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa fa-box-open fa-3x mb-3"></i>
                        <p>Belum ada peminjaman yang bisa dikembalikan.</p>
                    </div>
                @endforelse

            </div>

        </div>
        <div class="mt-4 d-flex justify-content-end" style="color: #fff !important;">
            {{ $transaksis->links('pagination::bootstrap-5') }}
        </div>

        {{-- BACK --}}
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-warning mt-4">
            <i class="fa fa-arrow-left me-1"></i> Kembali ke Dashboard
        </a>

    </div>
@endsection
