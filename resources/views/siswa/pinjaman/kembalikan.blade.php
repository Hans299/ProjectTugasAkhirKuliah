@extends('layouts.siswa')

@section('title', 'Form Pengembalian')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <form action="{{ route('siswa.pinjaman.kembalikan.store', $transaksi) }}" method="POST">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header text-white" style="background-color: #2A5A3A;">
                            <h4 class="mb-0">Konfirmasi Pengembalian</h4>
                        </div>

                        <div class="card-body p-4">

                            <h6 class="text-muted mb-2">Item yang akan dikembalikan:</h6>

                            <h5 class="fw-bold mb-3 text-dark">
                                {{ $transaksi->itemable->judul_buku ?? $transaksi->itemable->nama_alat }}
                            </h5>

                            <div class="alert alert-warning small">
                                <i class="fa fa-info-circle me-1"></i>
                                Dengan menekan tombol <b>Konfirmasi</b>, Anda menyatakan bahwa item ingin dikembalikan
                                dalam kondisi sesuai. Jika ada kerusakan, kehilangan atau keterlambatan Anda bersedia untuk
                                bertanggung
                                jawab sesuai dengan ketentuan.
                            </div>

                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="{{ route('siswa.pinjaman.pengembalian') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-1"></i> Batal
                            </a>

                            <button type="submit" class="btn btn-success" style="background-color: #2A5A3A;">
                                <i class="fa fa-check me-1"></i> Konfirmasi Pengembalian
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
