@extends($layout)

@section('title', 'Profil Saya')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-sm">
                    <div class="card-body">

                        <h4 class="mb-4 text-center">Profil Saya</h4>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- FOTO --}}
                            <div class="text-center mb-3">
                                @if ($user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $user->profile_photo_path) }}"
                                        class="rounded-circle mb-2" width="100" height="100">
                                @else
                                    <i class="fa fa-user-circle fa-5x text-muted"></i>
                                @endif
                                <div class="mb-3">
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="gambar" name="profile_photo_path"
                                            accept="image/*">
                                        <label class="input-group-text btn-upload" for="gambar">Upload Foto</label>
                                    </div>
                                    @error('profile_photo_path')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                @error('profile_photo_path')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NAMA --}}
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- EMAIL --}}
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- KELAS (HANYA SISWA) --}}
                            @if ($user->role?->name === 'siswa')
                                <div class="mb-3">
                                    <label class="form-label">Kelas</label>
                                    <input type="text" name="kelas" class="form-control"
                                        value="{{ old('kelas', $user->kelas) }}">
                                    @error('kelas')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <hr>

                            {{-- PASSWORD --}}
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control">
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            <button class="btn btn-primary w-100">
                                Simpan Perubahan
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
