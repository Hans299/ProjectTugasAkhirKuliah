{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Kelola Buku')

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
        background-color: #fff;
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

    /* Styling Tabel (Sama seperti Laboran) */
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
    /* Kolom Judul Buku kita buat rata kiri */
    .table tbody td:first-child {
        text-align: left;
    }
    .table-striped > tbody > tr:nth-of-type(odd) > * {
        background-color: #f8f9fa; /* Warna belang abu-abu muda */
    }

    /* Tombol Aksi */
    .action-buttons .btn {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 2px;
    }
    /* Tombol Tambah (Biru muda) */
    .btn-tambah {
        background-color: #3B82F6;
        border: none;
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: white;
    }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Tombol Tambah) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Perpustakaan</h2>
        <div>
            {{-- Tombol Tambah mengarah ke route 'create' (DIPERBAIKI) --}}
            <a href="{{ route('admin.pustakawan.buku.create') }}" class="btn btn-tambah">
                <i class="fa fa-plus me-2"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Kartu Konten Utama (Search & Tabel) --}}
    <div class="content-card bg-white">
        
        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="search-bar" style="max-width: 400px;">
                <input type="text" class="form-control" placeholder="Cari Judul Buku">
                <span class="search-icon"><i class="fa fa-search"></i></span>
            </div>
        </div>

        {{-- Menampilkan pesan sukses (DITAMBAHKAN) --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tabel Data Buku --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        {{-- Kolom disesuaikan dengan Controller (DIPERBAIKI) --}}
                        <th scope="col" style="text-align: left;">Judul Buku</th>
                        <th scope="col">Pengarang</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop data dinamis (DIPERBAIKI) --}}
                    @forelse($bukus as $buku)
                    <tr>
                        <td style="text-align: left;">{{ $buku->judul }}</td>
                        <td>{{ $buku->pengarang }}</td>
                        <td>{{ $buku->penerbit ?? '-' }}</td>
                        <td>{{ $buku->stok }}</td>
                        <td class="action-buttons">
                            
                            {{-- Tombol Edit (Langkah 45) --}}
                            <a href="{{ route('admin.pustakawan.buku.edit', $buku->id) }}" class="btn btn-warning text-white">
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            
                            {{-- Tombol Hapus (Langkah 45) --}}
                            <form action="{{ route('admin.pustakawan.buku.destroy', $buku->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            
                            {{-- Tombol Lihat/Show (Opsional, arahkan ke edit) --}}
                            <a href="{{ route('admin.pustakawan.buku.edit', $buku->id) }}" class="btn btn-info text-white">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada data buku.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (DIPERBAIKI) --}}
        <div class="d-flex justify-content-end mt-3">
             {{-- Ini akan berfungsi jika Anda mengganti get() -> paginate() di controller --}}
             {{ $bukus->links() }}
        </div>

    </div>
@endsection