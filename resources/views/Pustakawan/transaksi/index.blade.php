@extends('layouts.admin') {{-- Ganti ini jika nama layout admin Anda berbeda --}}
@section('title', 'Manajemen Transaksi Buku')

@push('styles')
    <style>
        .nav-tabs .nav-link.active {
            background-color: #25256C;
            /* Sesuaikan dengan warna sidebar Anda */
            color: white;
            border-color: #25256C;
        }

        .nav-tabs .nav-link {
            color: #25256C;
        }

        .img-thumbnail-small {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .action-buttons form {
            display: inline-block;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-4">
        <h1 class="h3 mb-4 text-gray-800">Manajemen Transaksi Buku</h1>
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <form action="{{ route('admin.pustakawan.transaksi.export') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kategori Buku</label>
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Buku Umum">Buku Umum</option>
                            <option value="Buku Mata Pelajaran">Buku Mata Pelajaran</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status Transaksi</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="menunggu-konfirmasi">Menunggu Konfirmasi</option>
                            <option value="dikembalikan">Dikembalikan</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fa fa-file-excel"></i> Download Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        {{-- Tampilkan Pesan Sukses/Error dari Controller --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        {{-- Navigasi Tab --}}
        <ul class="nav nav-tabs" id="transaksiTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending"
                    type="button" role="tab" aria-controls="pending" aria-selected="true">
                    Permintaan Pending <span class="badge bg-danger">{{ $pending->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="dipinjam-tab" data-bs-toggle="tab" data-bs-target="#dipinjam" type="button"
                    role="tab" aria-controls="dipinjam" aria-selected="false">
                    Sedang Dipinjam <span class="badge bg-info">{{ $dipinjam->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="menunggu-tab" data-bs-toggle="tab" data-bs-target="#menunggu" type="button"
                    role="tab" aria-controls="menunggu" aria-selected="false">
                    Konfirmasi Pengembalian <span
                        class="badge bg-warning text-dark">{{ $menunggu_konfirmasi->count() }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button"
                    role="tab" aria-controls="selesai" aria-selected="false">
                    Riwayat Selesai
                </button>
            </li>
        </ul>

        {{-- Konten Tab (Memanggil Partial Views) --}}
        <div class="tab-content" id="transaksiTabContent">

            {{-- ================= TAB PENDING ================= --}}
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                {{-- Kita akan buat file ini di langkah berikutnya --}}
                @include('pustakawan.transaksi._table_pending', ['transaksis' => $pending])
            </div>

            {{-- ================= TAB DIPINJAM ================= --}}
            <div class="tab-pane fade" id="dipinjam" role="tabpanel" aria-labelledby="dipinjam-tab">
                {{-- Kita akan buat file ini di langkah berikutnya --}}
                @include('pustakawan.transaksi._table_dipinjam', ['transaksis' => $dipinjam])
            </div>

            {{-- ================= TAB MENUNGGU KONFIRMASI ================= --}}
            <div class="tab-pane fade" id="menunggu" role="tabpanel" aria-labelledby="menunggu-tab">
                {{-- Kita akan buat file ini di langkah berikutnya --}}
                @include('pustakawan.transaksi._table_menunggu', ['transaksis' => $menunggu_konfirmasi])
            </div>

            {{-- ================= TAB SELESAI ================= --}}
            <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                {{-- Kita akan buat file ini di langkah berikutnya --}}
                @include('pustakawan.transaksi._table_selesai', ['transaksis' => $selesai])
            </div>
        </div>

    </div>
@endsection
