@extends('layouts.tamu') 
@section('title', 'Riwayat Peminjaman')

@push('styles')
<style>
    .table-custom { background-color: white; border-radius: 10px; }
    .table-custom thead th { background-color: #2A5A3A; color: white; vertical-align: middle; }
    .table-custom tbody td { vertical-align: middle; }
    .status-pending { background-color: #ffc107; color: #333; }
    .status-dipinjam { background-color: #0d6efd; color: white; }
    .status-selesai { background-color: #198754; color: white; }
    .status-ditolak { background-color: #dc3545; color: white; }
    .status-menunggu-konfirmasi { background-color: #0dcaf0; color: #333; }
    .badge-status { padding: 0.5em 0.75em; border-radius: 6px; font-weight: 600; font-size: 0.9em; }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="display-4 fw-bold" style="color: #1D3A1F;"><i class="fas fa-history me-3"></i> Riwayat Saya</h1>
        <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-success">Kembali ke Dashboard</a>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive table-custom shadow-sm">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Nama Item</th>
                    <th scope="col">Tgl. Pinjam</th>
                    <th scope="col">Tgl. Kembali</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $trx)
                    <tr>
                        <td>
                            {{ $trx->itemable->judul ?? $trx->itemable->nama }}
                            <small class="d-block text-muted">
                                Tipe: {{ $trx->itemable_type == 'App\Models\Buku' ? 'Buku' : 'Alat Lab' }}
                            </small>
                        </td>
                        <td>{{ $trx->tanggal_pinjam->format('d M Y') }}</td>
                        <td>
                            {{ $trx->tanggal_kembali ? $trx->tanggal_kembali->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <span class="badge-status 
                                @if($trx->status == 'pending') status-pending
                                @elseif($trx->status == 'dipinjam') status-dipinjam
                                @elseif($trx->status == 'menunggu-konfirmasi') status-menunggu-konfirmasi
                                @elseif($trx->status == 'selesai') status-selesai
                                @elseif($trx->status == 'ditolak') status-ditolak
                                @endif">
                                {{ ucfirst(str_replace('-', ' ', $trx->status)) }}
                            </span>
                        </td>
                        <td>
                            @if ($trx->status == 'dipinjam')
                                {{-- Status DIPINJAM, tampilkan tombol --}}
                                <a href="{{ route('siswa.pinjaman.kembalikan.form', $trx) }}" 
                                   class="btn btn-warning btn-sm">
                                   <i class="fas fa-undo"></i> Kembalikan
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center p-4">Anda belum memiliki riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection