{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Kelola Akun Pengguna')

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

        /* Styling Tabel */
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
    </style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')

    {{-- Header Konten (Judul & Tombol Tambah) --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Data User</h2>
        <div>
            {{-- Tombol Tambah mengarah ke route 'create' --}}
            <a href="{{ route('admin.superadmin.user.create') }}" class="btn btn-tambah">
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
        {{-- Search --}}
        <div class="mb-4">
            <div class="search-bar" style="max-width: 400px;">
                <form method="GET" id="search-form">
                    <input type="text" name="search" id="search-input" value="{{ request('search') }}"
                        class="form-control" placeholder="Cari Data User" autocomplete="off">
                </form>

                <span class="search-icon"><i class="fa fa-search"></i></span>
            </div>
        </div>

        {{-- Tabel Siswa --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Password</th>
                        <th>Aksi</th>
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

                    @forelse ($users as $user)
                        {{-- Proteksi tambahan: hanya siswa --}}
                        @if ($user->role_id == 4)
                            <tr>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->kelas ?? '-' }}</td>
                                <td>********</td>
                                <td class="action-buttons">
                                    <a href="{{ route('admin.superadmin.user.edit', $user->id) }}"
                                        class="btn btn-warning text-white">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('admin.superadmin.user.destroy', $user->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin hapus siswa ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.superadmin.user.show', $user->id) }}"
                                        class="btn btn-info text-white">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data user belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>

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
