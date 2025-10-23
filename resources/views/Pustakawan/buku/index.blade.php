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
            {{-- Tombol Tambah mengarah ke route 'create' --}}
            <a href="{{ route('pustakawan.buku.create') }}" class="btn btn-tambah">
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

        {{-- Tabel Data Buku --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" style="text-align: left;">Judul Buku</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Stok Buku</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                      Ganti bagian ini dengan loop data dari Controller
                      @forelse($daftarBuku as $buku) 
                    --}}
                    @for ($i = 0; $i < 5; $i++)
                    <tr>
                        <td style="text-align: left;">Loneliness is my best friend</td>
                        <td>978-3-16-148410-0</td>
                        <td>Media Nusantara</td>
                        <td>2018</td>
                        <td>10</td>
                        <td class="action-buttons">
                            {{-- Tombol Edit --}}
                            <a href="#" class="btn btn-warning text-white"> {{-- route('pustakawan.buku.edit', $buku->id) --}}
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            
                            {{-- Tombol Hapus (gunakan form) --}}
                            <form action="#" method="POST" class="d-inline"> {{-- route('pustakawan.buku.destroy', $buku->id) --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            
                            {{-- Tombol Lihat/Show --}}
                            <a href="#" class="btn btn-info text-white"> {{-- route('pustakawan.buku.show', $buku->id) --}}
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endfor
                    {{-- @empty --}}
                    {{-- <tr><td colspan="6" class="text-center">Belum ada data buku.</td></tr> --}}
                    {{-- @endforelse --}}
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <nav aria-label="Page navigation" class="d-flex justify-content-end mt-3">
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav>
        {{-- Ganti pagination statis di atas dengan: $daftarBuku->links() --}}

    </div>
@endsection