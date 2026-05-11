@extends('layouts.tamu') 
@section('title', 'Konfirmasi Peminjaman')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm" style="border-radius: 10px;">
                <div class="card-header text-white" style="background-color: #2A5A3A;">
                    <h4 class="mb-0">Konfirmasi Peminjaman</h4>
                </div>
                <div class="card-body p-4">
                    <h5 class="mb-3">Anda akan meminjam item berikut:</h5>
                    
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th style="width: 30%;">Nama Item</th>
                                <td>{{ $item->judul ?? $item->nama }}</td>
                            </tr>
                            @if($item_type == 'Buku')
                            <tr>
                                <th>Pengarang</th>
                                <td>{{ $item->pengarang }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Stok Tersisa</th>
                                <td>{{ $item->stok }}</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <p class="text-muted mt-3">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Item ini akan masuk ke riwayat peminjaman Anda dengan status "Pending"
                        menunggu persetujuan dari admin.
                    </p>

                    {{-- Ini adalah FORM yang akan diproses oleh storePeminjaman --}}
                    <form action="{{ route('siswa.pinjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="hidden" name="item_type" value="{{ $item_type }}">
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success" style="background-color: #2A5A3A;">
                                <i class="fas fa-check"></i> Ya, Konfirmasi Pinjam
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection