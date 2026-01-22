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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            background-color: #fff;
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            border-radius: 8px;
            padding-left: 1rem;
            padding-right: 3rem;
            /* Ruang untuk ikon */
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
            background-color: #25256C;
            /* Header tabel biru tua */
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

        .table-striped>tbody>tr:nth-of-type(odd)>* {
            background-color: #f8f9fa;
            /* Warna belang abu-abu muda */
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
            <a href="{{ route('admin.superadmin.admin.create') }}" class="btn btn-tambah">
                <i class="fa fa-plus me-2"></i> Tambah
            </a>
        </div>
    </div>

    {{-- Kartu Konten Utama (Search & Tabel) --}}
    <div class="content-card bg-white">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fa fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="mb-4">
            <div class="search-bar" style="max-width: 400px;">
                <form method="GET" id="search-form">
                    <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                        class="form-control" placeholder="Cari Admin" autocomplete="off">
                </form>

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
                    <tr id="search-loading" style="display:none;">
                        <td colspan="5" class="text-center align-middle">
                            <div class="d-flex justify-content-center align-items-center py-2 text-muted">
                                <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                Mencari...
                            </div>
                        </td>
                    </tr>

                    @forelse ($admins as $admin)
                        <tr>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->name }}</td>
                            <td>********</td>
                            <td>{{ $admin->role->name ?? '-' }}</td>
                            <td class="action-buttons">

                                {{-- Edit --}}
                                <a href="{{ route('admin.superadmin.admin.edit', $admin->id) }}"
                                    class="btn btn-warning text-white">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.superadmin.admin.destroy', $admin->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                {{-- Show --}}
                                <a href="{{ route('admin.superadmin.admin.show', $admin->id) }}"
                                    class="btn btn-info text-white">
                                    <i class="fa fa-eye"></i>
                                </a>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data admin belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        {{-- <nav aria-label="Page navigation" class="d-flex justify-content-end mt-3">
            <ul class="pagination">
                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">5</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav> --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $admins->links('pagination::bootstrap-5') }}
        </div>


        {{-- Ganti pagination statis di atas dengan: $admins->links() --}}

    </div>
@endsection
@push('scripts')
    <script>
        let debounceTimer;

        document.getElementById('search-input').addEventListener('input', function() {
            const loadingRow = document.getElementById('search-loading');
            loadingRow.style.display = '';

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('search-form').submit();
            }, 500);
        });
    </script>
@endpush
