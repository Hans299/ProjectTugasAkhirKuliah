{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Kelola Akun Admin')

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

    /* Styling Tabel (Sama seperti Laboran & Pustakawan) */
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
    .btn-tambah:hover {
        background-color: #2563eb;
        color: white;
    }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Tombol Tambah) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Data Admin</h2>
        <div>
            {{-- Tombol Tambah mengarah ke route 'create' --}}
            <a href="{{ route('superadmin.admins.create') }}" class="btn btn-tambah">
                <i class="fa fa-plus me-2"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Kartu Konten Utama (Search & Tabel) --}}
    <div class="content-card bg-white">
        
        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="search-bar" style="max-width: 400px;">
                <input type="text" class="form-control" placeholder="Cari Admin">
                <span class="search-icon"><i class="fa fa-search"></i></span>
            </div>
        </div>

        {{-- Tabel Data Admin --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Role</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- 
                      Ganti bagian ini dengan loop data dari Controller
                      @forelse($admins as $admin) 
                    --}}
                    <tr>
                        <td>hans.bonatua@example.com</td> {{-- Sesuai header 'Email' --}}
                        <td>Hans Bonatua</td>
                        <td>********</td>
                        <td>Perpustakaan</td>
                        <td class="action-buttons">
                            <a href="#" class="btn btn-warning text-white"> {{-- route('superadmin.admins.edit', $admin->id) --}}
                                <i class="fa fa-pencil-alt"></i>
                            </a>
                            <form action="#" method="POST" class="d-inline"> {{-- route('superadmin.admins.destroy', $admin->id) --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                            <a href="#" class="btn btn-info text-white"> {{-- route('superadmin.admins.show', $admin->id) --}}
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>lab.admin@example.com</td>
                        <td>Hans Bonatua</td>
                        <td>********</td>
                        <td>Lab</td>
                        <td class="action-buttons">
                            <a href="#" class="btn btn-warning text-white"><i class="fa fa-pencil-alt"></i></a>
                            <form action="#" method="POST" class="d-inline"><button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button></form>
                            <a href="#" class="btn btn-info text-white"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>
                    {{-- @empty --}}
                    {{-- <tr><td colspan="5" class="text-center">Belum ada data admin.</td></tr> --}}
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
        {{-- Ganti pagination statis di atas dengan: $admins->links() --}}

    </div>
@endsection