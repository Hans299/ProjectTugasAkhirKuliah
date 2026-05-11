@extends('layouts.admin')

@section('title', 'Edit Admin')

@push('styles')
    <style>
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #333;
        }

        .page-title .breadcrumb-link {
            color: #6c757d;
            text-decoration: none;
        }

        .page-title .breadcrumb-link:hover {
            color: #333;
        }

        .form-card {
            border-radius: 12px;
            border: 2px solid #25256C;
            /* Border biru tua */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            padding: 2.5rem;
            background-color: #fff;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        /* Styling untuk field yang hanya-baca */
        .form-control[readonly],
        .form-select[disabled] {
            background-color: #e9ecef;
            /* Warna abu-abu muda */
            opacity: 1;
            border: 1px solid #ced4da;
        }

        .current-image {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-kembali {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border: 1px solid #ced4da;
        }

        .btn-upload {
            background-color: #3B82F6;
            /* Biru muda */
            color: white;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')

    <h2 class="page-title mb-4">
        <a href="{{ route('admin.superadmin.admin.index') }}" class="breadcrumb-link">Data Admin</a> > Edit Admin
    </h2>

    <div class="form-card">

        <div class="mb-3  d-flex flex-column align-items-center">
            @if ($admin->profile_photo_path)
                <img src="{{ asset('storage/' . $admin->profile_photo_path) }}" alt="Foto Profil"
                    class="current-image d-block">
            @else
                <p class="text-center p-4 border rounded bg-light text-muted">
                    Tidak ada gambar.
                </p>
            @endif
            <label class="form-label">Gambar/Foto Profil</label>
        </div>

        <form action="{{ route('admin.superadmin.admin.update', $admin->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-4">

                {{-- KIRI --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $admin->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $admin->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role Admin</label>
                        <select name="role_id" class="form-select @error('role_id') is-invalid @enderror">
                            <option value="">-- Pilih Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ old('role_id', $admin->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="active" {{ old('status', $admin->status) == 'active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="inactive" {{ old('status', $admin->status) == 'inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- KANAN --}}
                <div class="col-lg-6">

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <span class="text-muted">(kosongkan jika tidak diubah)</span>
                        <div class="input-group">
                            <input type="password" id="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
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
                                class="form-control">
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

            <div class="action-buttons">
                <a href="{{ route('admin.superadmin.admin.index') }}" class="btn btn-kembali">Kembali</a>

                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
@endsection
