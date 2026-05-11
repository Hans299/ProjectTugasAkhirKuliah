{{-- Menggunakan layout 'tamu' sebagai kerangka --}}
@extends('layouts.tamu')

{{-- Mengatur judul halaman --}}
@section('title', 'Login')

{{-- Menambahkan CSS kustom HANYA untuk halaman ini --}}
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body,
        html {
            height: 100%;
        }

        body {
            background-color: #1D3A1F;
        }

        .login-card {
            background-color: #2A5A3A;
            border: none;
            width: 450px;
            max-width: 100%;
        }

        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .login-logo img {
            max-width: 150px;
            max-height: auto;
            width: auto;
            height: auto;
            object-fit: contain;
        }


        @media (max-width: 576px) {
            .login-logo img {
                max-width: 120px;
            }
        }

        .form-control {
            background-color: #f0f0f0;
            border: none;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            color: #333;
        }

        .form-control::placeholder {
            color: #888;
        }

        .form-control:focus {
            background-color: #ffffff;
            box-shadow: none;
        }

        .btn-login {
            background-color: #333333;
            color: white;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            font-weight: 600;
            border: none;
        }

        .btn-login:hover {
            background-color: #000000;
            color: white;
        }

        .login-footer-link {
            color: #f0f0f0;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .login-footer-link:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .input-group-text {
            background-color: #f0f0f0;
            border: none;
            cursor: pointer;
            color: #555;
        }
    </style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    <div class="container-fluid vh-100">
        {{-- Utility Bootstrap untuk menengahkan kartu --}}
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                {{-- Kartu Login --}}
                <div class="card login-card text-light rounded-4 shadow-lg p-4 mx-auto">
                    <div class="card-body text-center">
                        {{-- Logo Placeholder --}}
                        <div class="login-logo d-flex align-items-center justify-content-center rounded-circle mx-auto mb-4">
                            <img src="{{ asset('\logo.png') }}" />
                        </div>
                        {{-- Judul --}}
                        <h2 class="fw-bold mb-2 fs-4">Selamat Datang di Website</h2>
                        <p class="mb-3">SMP Negeri 6 Bandar Lampung</p>
                        <p class="fw-bold mb-4">Silahkan Login</p>

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
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        {{-- Form Login --}}
                        <form action="{{ route('login') }}" method="POST" class="text-start">
                            {{-- Token CSRF WAJIB untuk keamanan form --}}
                            @csrf

                            {{-- Form Group Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label ms-1">Email:</label>
                                <input type="email" class="form-control rounded-3" id="email" name="email"
                                    placeholder="Masukan Email" value="{{ old('email') }}" required autofocus>
                            </div>

                            {{-- Form Group Password --}}
                            <div class="mb-4">
                                <label for="password" class="form-label ms-1">Password:</label>
                                <div class="input-group">
                                    <input type="password" class="form-control rounded-start-3" id="password"
                                        name="password" placeholder="Masukan Password" required>
                                    {{-- Tombol untuk toggle password --}}
                                    <span class="input-group-text rounded-end-3" id="togglePassword">
                                        <i class="fa fa-eye" id="iconPassword"></i>
                                    </span>
                                </div>
                            </div>

                            {{-- Tombol Submit --}}
                            <button class="btn btn-login w-100 mb-4 rounded-3" type="submit">Login</button>

                            {{-- Link ke Lupa Password dan Daftar --}}
                            <div class="d-flex justify-content-end px-1">
                                {{-- <a href="{{ route('password.request') }}" class="login-footer-link">Lupa Kata Sandi?</a> --}}
                                <a href="{{ route('register') }}" class="login-footer-link">Buat Akun</a>
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            {{-- Logika untuk show/hide password --}}
            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = document.getElementById('iconPassword');

                    if (type === 'password') {
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    } else {
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    }
                });
            }
        });
    </script>
@endpush
