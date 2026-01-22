@extends('layouts.siswa')

@section('title', 'Detail Item')

@section('content')
    <div class="container py-4">

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row g-4 align-items-start">

                    {{-- GAMBAR / ICON --}}
                    <div class="col-12 col-md-3 text-center">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="img-fluid rounded"
                                style="max-height:300px; object-fit:contain; border:3px solid #ffd632;">
                        @else
                            <div class="d-flex justify-content-center align-items-center" style="height:200px;">
                                <i
                                    class="fa fa-{{ $type === 'buku' ? 'book text-primary' : 'flask text-success' }} fa-5x"></i>
                            </div>
                        @endif
                    </div>

                    {{-- DETAIL --}}
                    <div class="col-12 col-md-9">

                        <h4 class="fw-bold mb-3">
                            {{ $type === 'buku' ? $item->judul_buku : $item->nama_alat }}
                        </h4>

                        {{-- INFO LIST --}}
                        <div class="info-list">

                            <div class="info-row">
                                <span class="label">{{ $type === 'buku' ? 'ISBN' : 'ID Alat' }}</span>
                                <span class="colon">:</span>
                                <span class="value">{{ $type === 'buku' ? $item->isbn : $item->id_alat }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">{{ $type === 'buku' ? 'Penerbit' : 'Kualitas' }}</span>
                                <span class="colon">:</span>
                                <span class="value">{{ $type === 'buku' ? $item->penerbit : $item->kualitas }}</span>
                            </div>

                            <div class="info-row">
                                <span class="label">Stok</span>
                                <span class="colon">:</span>
                                <span class="value">
                                    <span class="badge bg-{{ $item->stok < 5 ? 'danger' : 'success' }}">
                                        {{ $item->stok }}
                                    </span>
                                </span>
                            </div>

                            @if ($type === 'buku')
                                <div class="info-row">
                                    <span class="label">Tahun Terbit</span>
                                    <span class="colon">:</span>
                                    <span class="value">{{ $item->tahun_terbit }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Penulis</span>
                                    <span class="colon">:</span>
                                    <span class="value">{{ $item->penulis }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Jumlah Halaman</span>
                                    <span class="colon">:</span>
                                    <span class="value">{{ $item->halaman }}</span>
                                </div>

                                <div class="info-row">
                                    <span class="label">Kategori</span>
                                    <span class="colon">:</span>
                                    <span class="value">
                                        <span class="badge bg-primary">{{ $item->kategori }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <hr class="my-4">

                <h6 class="fw-semibold">Syarat dan Ketentuan</h6>
                <p class="text-muted">
                    @if ($type === 'buku')
                        Batas waktu peminjaman maksimal adalah 3 hari sejak buku dipinjam. Jika buku dikembalikan terlambat,
                        akan dikenakan denda sebesar Rp 3.000 per hari. Apabila buku hilang atau rusak, peminjam akan
                        dikenakan sanksi.
                    @else
                        Peminjaman alat lab hanya dapat dilakukan oleh siswa yang mengikuti praktikum di laboratorium.
                        Setiap
                    @endif
                </p>

                {{-- DESKRIPSI --}}
                <hr class="my-4">

                <h6 class="fw-semibold">Deskripsi</h6>
                <p class="text-muted">
                    {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                </p>

                {{-- BACK --}}
                <div class="d-flex justify-content-end">
                    <a href="{{ route('siswa.dashboard') }}" class="btn btn-warning mt-3 me-3">
                        <i class="fa fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#modalPinjam"
                        {{ $item->stok < 1 ? 'disabled' : '' }}>
                        <i class="fa fa-book me-1"></i> Pinjam
                    </button>
                </div>

            </div>
        </div>
        <div class="modal fade" id="modalPinjam" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">

                    {{-- HEADER --}}
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">
                            <i class="fa fa-{{ $type === 'buku' ? 'book' : 'flask' }} me-2"></i>
                            Konfirmasi Peminjaman
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    {{-- FORM --}}
                    <form action="{{ route('siswa.pinjaman.store') }}" method="POST">
                        @csrf

                        {{-- ITEM ID --}}
                        <input type="hidden" name="item_id" value="{{ $type === 'buku' ? $item->isbn : $item->id_alat }}">

                        {{-- ITEM TYPE --}}
                        <input type="hidden" name="item_type" value="{{ $type === 'buku' ? 'Buku' : 'AlatLab' }}">

                        <div class="modal-body">

                            {{-- INFO ITEM --}}
                            <div class="mb-3 text-center">
                                <strong
                                    class="text-dark">{{ $type === 'buku' ? $item->judul_buku : $item->nama_alat }}</strong>
                                <div class="text-muted small">
                                    Stok tersedia: {{ $item->stok }}
                                </div>
                            </div>

                            {{-- JUMLAH PINJAM --}}
                            <div class="mb-3">
                                @if ($item->kategori != 'Buku Umum')
                                    <label class="form-label fw-semibold text-dark">
                                        Nama Guru Pengajar
                                    </label>
                                    <input type="text" name="guru" class="form-control" required>
                                @endif
                                <label class="form-label fw-semibold text-dark">
                                    Jumlah yang dipinjam
                                </label>
                                <input type="number" name="jumlah" class="form-control" min="1"
                                    max="{{ $item->stok }}" value="1" required>
                                <small class="text-muted">
                                    Maksimal {{ $item->stok }} item
                                </small>
                            </div>

                            {{-- KETENTUAN --}}
                            <div class="border rounded p-3 mb-3" style="background:#198754; color:#dddddd;">
                                <div class="fw-semibold mb-2">
                                    Persetujuan Ketentuan
                                </div>
                                <ul class="small mb-2">
                                    <li>Saya Telah membaca Syarat dan Ketentuan</li>
                                    <li>Barang wajib dikembalikan tepat waktu</li>
                                    <li>Kerusakan/hilang menjadi tanggung jawab peminjam</li>
                                    <li>Peminjaman dapat dibatalkan oleh petugas</li>
                                </ul>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="setuju" required>
                                    <label class="form-check-label" for="setuju">
                                        Saya telah membaca dan menyetujui ketentuan
                                    </label>
                                </div>
                            </div>

                        </div>

                        {{-- FOOTER --}}
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-check me-1"></i> Ajukan Peminjaman
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    {{-- STYLE --}}
    <style>
        .info-list {
            max-width: 600px;
        }

        .info-row {
            display: grid;
            grid-template-columns: 160px 15px auto;
            align-items: center;
            margin-bottom: 6px;
        }

        .info-row .label {
            font-weight: 600;
            color: #555;
        }

        .info-row .colon {
            text-align: center;
        }

        .info-row .value {
            color: #222;
        }

        @media (max-width: 576px) {
            .info-row {
                grid-template-columns: 130px 10px auto;
            }
        }
    </style>

@endsection
