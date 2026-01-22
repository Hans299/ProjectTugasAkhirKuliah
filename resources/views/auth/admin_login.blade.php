{{--
  Halaman Login Admin (Bootstrap Version)
--}}
@extends('layouts.tamu')

@section('title', 'Admin Login')

@push('styles')
    <style>
        body,
        html {
            height: 100%;
            background-color: #3B82F6;
        }

        .login-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .login-logo-img {
            max-width: 150px;
            max-height: auto;
            width: auto;
            height: auto;
            object-fit: contain;
        }


        @media (max-width: 576px) {
            .login-logo-img {
                max-width: 120px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container min-vh-100 d-flex justify-content-center align-items-center">
        <div class="card border-0 w-100" style="max-width: 900px; border-radius: 12px;">
            <div class="row g-0">

                {{-- BAGIAN KIRI --}}
                <div class="col-md-6 bg-light d-flex align-items-center justify-content-center login-illustration p-1"
                    style="border: 20px solid #3b82f6;">
                    <iframe src="https://lottie.host/embed/f5b81f91-4012-4db8-a1ba-582a5b8b88cd/4KrKZChLNZ.lottie"
                        class="w-75" style="min-height: 300px; border: none;"></iframe>
                </div>

                {{-- BAGIAN KANAN --}}
                <div class="col-md-6 p-5 d-flex align-items-center shadow-lg">
                    <div class="w-100">

                        <div class="login-logo">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="login-logo-img">
                        </div>


                        <h5 class="text-center fw-bold mb-1">SELAMAT DATANG DI WEBSITE</h5>
                        <p class="text-center mb-1">SMPN 6 Bandar Lampung</p>
                        <p class="text-center fw-medium mb-4">Silahkan Login Sebagai Admin</p>

                        {{-- Error --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Masukan Email"
                                    value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukan Password"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-semibold">
                                Login
                            </button>

                            {{-- <div class="d-flex justify-content-between mt-3">
                                <a href="#" class="text-decoration-none">Lupa Kata Sandi?</a>
                            </div> --}}
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
