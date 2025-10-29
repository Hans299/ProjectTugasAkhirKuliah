{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Kelola Alat Lab')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .content-card {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 2rem;
    }
    .search-bar {
        position: relative;
    }
    .search-bar input {
        border-radius: 8px;
        padding-left: 1rem;
        padding-right: 3rem; /* Ruang untuk ikon */
        border: 1px solid #ced4da;
    }
    .search-bar .search-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #888;
        font-size: 1.1rem;
    }

    /* Styling Tabel */
    .table thead th {
        background-color: #25256C; /* Header tabel biru tua */
        color: white;
        text-align: center;
        vertical-align: middle;
        padding: 1rem;
        border-bottom: none;
    }
    .table tbody td {
        text-align: center;
        vertical-align: middle;
        padding: 1rem;
        color: #333;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: #f8f9fa; /* Warna belang abu-abu muda */
    }
    .table-hover > tbody > tr:hover > * {
        background-color: #e9ecef;
    }

    /* Tombol Aksi */
    .action-buttons .btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px; /* Memberi sedikit jarak antar tombol */
    }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Tombol Tambah) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Laboratorium</h2>
        <div>
            {{-- Tombol Tambah mengarah ke route 'create' (DIPERBAIKI) --}}
            <a href="{{ route('admin.laboran.alat.create') }}" class="btn btn-primary" style="background-color: #25256C; border: none; padding: 0.5rem 1rem; font-weight: 600;">
                <i class="fa fa-plus me-2"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Kartu Konten Utama (Search & Tabel) --}}
    <div class="content-card bg-white">
        
        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="search-bar" style="max-width: 400px;">
                <input type="text" class="form-control" placeholder="Cari Alat Lab">
                <span class="search-icon"><i class="fa fa-search"></i></span>
            </div>
        </div>

        {{-- Menampilkan pesan sukses --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Data Alat --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nama Alat</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                      Looping data dinamis dari Controller ($alats)
                    --}}
                    @forelse($alats as $alat)
                    <tr>
                        <td>{{ $alat->nama }}</td>
                        <td>{{ $alat->deskripsi ?? '-' }}</td>
                        <td>{{ $alat->stok }}</td>
                        <td class="action-buttons">
                            {{-- Tombol Edit (DIPERBAIKI) --}}
                            <a href="{{ route('admin.laboran.alat.edit', $alat->id) }}" class="btn btn-warning text-white">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            
                            {{-- Tombol Hapus (DIPERBAIKI) --}}
                            <form action="{{ route('admin.laboran.alat.destroy', $alat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            
                            {{-- Tombol Lihat/Show (DIPERBAIKI) --}}
                            {{-- Kita belum buat 'show', jadi arahkan ke 'edit' untuk sementara --}}
                            <a href="{{ route('admin.laboran.alat.edit', $alat->id) }}" class="btn btn-info text-white">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data alat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{-- 
                Ini akan menampilkan link pagination 
                TAPI kita perlu ubah controller agar pakai paginate() 
            --}}
            {{-- {{ $alats->links() }} --}}
        </div>

    </div>
@endsection