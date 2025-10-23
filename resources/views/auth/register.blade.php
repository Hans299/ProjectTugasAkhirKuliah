{{-- Menggunakan layout 'tamu' sebagai kerangka --}}
@extends('layouts.tamu')

{{-- Mengatur judul halaman --}}
@section('title', 'Daftar Akun')

{{-- Menambahkan CSS kustom (mirip dengan login) --}}
@push('styles')
<style>
    body, html { height: 100%; }
    body { background-color: #1D3A1F; }
    .register-card { background-color: #2A5A3A; border: none; width: 450px; max-width: 100%; }
    .register-logo { width: 80px; height: 80px; background-color: #f0f0f0; color: #333; font-weight: 600; font-size: 18px; }
    .form-control { background-color: #f0f0f0; border: none; padding-top: 0.75rem; padding-bottom: 0.75rem; color: #333; }
    .form-control::placeholder { color: #888; }
    .form-control:focus { background-color: #ffffff; box-shadow: none; }
    .input-group-text { background-color: #f0f0f0; border: none; cursor: pointer; color: #555; }
    .btn-register { background-color: #333333; color: white; padding-top: 0.75rem; padding-bottom: 0.75rem; font-weight: 600; border: none; }
    .btn-register:hover { background-color: #000000; color: white; }
    .back-link { color: #f0f0f0; text-decoration: none; font-size: 0.9rem; }
    .back-link:hover { color: #ffffff; }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
<div class="container-fluid vh-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12">
            {{-- Kartu Registrasi --}}
            <div class="card register-card text-light rounded-4 shadow-lg p-4 mx-auto">
                <div class="card-body">
                    {{-- Link kembali ke Halaman Login --}}
                    <div class="text-start mb-4">
                        <a href="{{ route('login') }}" class="back-link">&lsaquo; Kembali</a>
                    </div>
                    
                    {{-- Logo Placeholder --}}
                    <div class="register-logo d-flex align-items-center justify-content-center rounded-circle mx-auto mb-4">
                        Logo
                    </div>
                    <h2 class="fw-bold mb-4 fs-4 text-center">Daftar Akun</h2>

                    {{-- Menampilkan pesan error validasi jika ada --}}
                    @if ($errors->any())
                        <div class="alert alert-danger text-start" role="alert">
                            <ul class="mb-0" style="padding-left: 1.2rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Form Registrasi --}}
                    <form action="{{ route('register') }}" method="POST" class="text-start">
                        @csrf
                        
                        {{-- Form Group Username --}}
                        <div class="mb-3">
                            <label for="name" class="form-label ms-1">Username:</label>
                            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Masukan Username" value="{{ old('name') }}" required autofocus>
                        </div>
                        
                        {{-- Form Group Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label ms-1">Email:</label>
                            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="Masukan Email" value="{{ old('email') }}" required>
                        </div>
                        
                        {{-- Form Group Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label ms-1">Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-start-3" id="password" name="password" placeholder="Masukan Password" required>
                                <span class="input-group-text rounded-end-3" id="togglePassword">👁️</span>
                            </div>
                        </div>
                        
                        {{-- Form Group Konfirmasi Password --}}
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label ms-1">Ulang Password:</label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-start-3" id="password_confirmation" name="password_confirmation" placeholder="Masukan Ulang Password" required>
                                <span class="input-group-text rounded-end-3" id="togglePasswordConfirmation">👁️</span>
                            </div>
                        </div>
                        
                        {{-- Tombol Submit --}}
                        <button class="btn btn-register w-100 mb-3 rounded-3" type="submit">Buat Akun</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- Menambahkan JavaScript HANYA untuk halaman ini --}}
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        {{-- Fungsi ini dibuat agar bisa dipakai ulang untuk kedua field password --}}
        function createPasswordToggle(toggleId, inputId) {
            const toggle = document.getElementById(toggleId);
            const input = document.getElementById(inputId);
            if (toggle && input) {
                toggle.addEventListener('click', function () {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.textContent = type === 'password' ? '👁️' : '🙈';
                });
            }
        }
        {{-- Terapkan ke field password --}}
        createPasswordToggle('togglePassword', 'password');
        {{-- Terapkan ke field konfirmasi password --}}
        createPasswordToggle('togglePasswordConfirmation', 'password_confirmation');
    });
</script>
@endpush