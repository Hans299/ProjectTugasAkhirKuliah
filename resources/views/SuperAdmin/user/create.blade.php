{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Tambah User')

@push('styles')
    <style>
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
        }

        .page-title .breadcrumb-link {
            color: #6c757d;
            /* Warna abu-abu untuk link "Data User" */
            text-decoration: none;
        }

        .page-title .breadcrumb-link:hover {
            color: #333;
        }

        /* Kartu form */
        .form-card {
            border-radius: 12px;
            border: 2px solid #25256C;
            /* Border biru tua */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            background-color: #fff;
        }

        /* Styling form */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #25256C;
            box-shadow: 0 0 0 0.25rem rgba(37, 37, 108, 0.25);
        }

        .btn-upload {
            background-color: #3B82F6;
            /* Biru muda */
            color: white;
            font-weight: 600;
        }

        /* Tombol Aksi */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-simpan {
            background-color: #3B82F6;
            /* Biru muda (sesuai tombol tambah) */
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border: none;
        }

        .btn-kembali {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border: 1px solid #ced4da;
        }
    </style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')

    <h2 class="page-title mb-4">
        <a href="{{ route('admin.superadmin.user.index') }}" class="breadcrumb-link">
            Data Siswa
        </a> > Tambah Siswa
    </h2>

    <div class="form-card">

        <form action="{{ route('admin.superadmin.user.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- role siswa (hidden) --}}
            <input type="hidden" name="role_id" value="4">

            <div class="row g-4">

                {{-- KIRI --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" required>

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" required>

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control @error('kelas') is-invalid @enderror"
                            value="{{ old('kelas') }}" placeholder="Contoh: VII A" required>

                        @error('kelas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- KANAN --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>

                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" required>
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="togglePassword('password_confirmation')">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload File</label>
                        <div class="input-group">
                            <input type="file" class="form-control" id="gambar" name="profile_photo_path"
                                accept="image/*">
                            <label class="input-group-text btn-upload" for="gambar">Upload File</label>
                        </div>
                        @error('profile_photo_path')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- AKSI --}}
            <div class="action-buttons">
                <a href="{{ route('admin.superadmin.user.index') }}" class="btn btn-kembali">
                    Kembali
                </a>
                <button type="submit" class="btn btn-simpan">
                    Simpan
                </button>
            </div>

        </form>
    </div>

    {{-- JS show/hide password --}}
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

@endsection
