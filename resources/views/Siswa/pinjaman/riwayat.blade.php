@extends('layouts.siswa')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container py-4">

        <h4 class="fw-bold mb-4">
            <i class="fa fa-history me-2"></i> Riwayat Peminjaman
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
            <a href="{{ route('siswa.pinjaman.riwayat') }}" class="btn btn-sm {{ !$filter ? 'btn-primary' : 'btn-info' }}">
                Semua
            </a>

            <a href="{{ route('siswa.pinjaman.riwayat', ['filter' => 'buku']) }}"
                class="btn btn-sm {{ $filter === 'buku' ? 'btn-primary' : 'btn-info' }}">
                <i class="fa fa-book me-1"></i> Buku
            </a>

            <a href="{{ route('siswa.pinjaman.riwayat', ['filter' => 'alat']) }}"
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
                    @endphp

                    <div class="d-flex flex-column flex-md-row gap-3 border-5 border-bottom py-3">

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
                                Jumlah Dipinjam :
                                {{ $trx->jumlah }}
                            </div>
                            @if ($item->kategori != 'Buku Umum')
                                <div class="small text-muted">
                                    Guru Pengajar :
                                    {{ $trx->guru ?? '-' }}
                                </div>
                            @endif
                            @if ($trx->catatan)
                                <div class="mt-2 p-2 bg-warning bg-opacity-25 rounded">
                                    <strong>Catatan:</strong>
                                    <p class="mb-0">{{ $trx->catatan }}</p>
                                </div>
                            @endif
                            @if ($trx->status !== 'dikembalikan')
                                @if ($trx->tanggal_pengembalian)
                                    <div class="badge bg-danger mt-2 p-2">
                                        Harus dikembalikan Pada :
                                        {{ $trx->tanggal_pengembalian ? \Carbon\Carbon::parse($trx->tanggal_pengembalian)->format('d M Y') : '-' }}
                                    </div>
                                @endif
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
                                {{ ucfirst($trx->status === 'menunggu-konfirmasi' ? 'Menunggu Konfirmasi Pengembalian' : $trx->status) }}
                            </span>
                        </div>
                    </div>

                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa fa-box-open fa-3x mb-3"></i>
                        <p>Belum ada riwayat peminjaman.</p>
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
