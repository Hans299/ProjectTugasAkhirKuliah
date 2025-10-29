@extends('layouts.tamu') 
@section('title', 'Form Pengembalian')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- 
                PENTING: enctype="multipart/form-data" 
                diperlukan untuk upload file.
            --}}
            <form action="{{ route('siswa.pinjaman.kembalikan.store', $transaksi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm" style="border-radius: 10px;">
                    <div class="card-header text-white" style="background-color: #2A5A3A;">
                        <h4 class="mb-0">Konfirmasi Pengembalian</h4>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="mb-3">Item yang akan dikembalikan:</h5>
                        <p class="fs-4 fw-bold" style="color: #1D3A1F;">
                            {{ $transaksi->itemable->judul ?? $transaksi->itemable->nama }}
                        </p>
                        
                        <p class="text-muted">
                            Silakan lampirkan foto barang yang dikembalikan sebagai bukti.
                        </p>
                        
                        <div class="mb-3">
                            <label for="foto_pengembalian" class="form-label">Upload Bukti Foto</label>
                            <input class="form-control @error('foto_pengembalian') is-invalid @enderror" 
                                   type="file" 
                                   id="foto_pengembalian" 
                                   name="foto_pengembalian" 
                                   required>
                            @error('foto_pengembalian')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('siswa.pinjaman.riwayat') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success" style="background-color: #2A5A3A;">
                                <i class="fas fa-check"></i> Kirim Bukti Pengembalian
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection