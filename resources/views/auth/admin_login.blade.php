{{-- 
  Menggunakan layout 'tamu' sebagai kerangka.
  Ini adalah Halaman Login KHUSUS untuk Admin (Pustakawan, Laboran, Superadmin).
--}}
@extends('layouts.tamu')

@section('title', 'Admin Login')

@push('styles')
<style>
    body, html { height: 100%; }
    body {
        /* Warna background biru dari desain */
        background-color: #3B82F6; 
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 2rem;
    }
    /* Kartu putih utama */
    .login-card {
        background-color: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        display: flex;
    }
    /* Bagian Kiri (Ilustrasi) */
    .login-illustration {
        flex: 1;
        background-color: #F9FAFB; 
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .login-illustration img { max-width: 100%; height: auto; }
    /* Bagian Kanan (Form) */
    .login-form-wrapper {
        flex: 1;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .login-logo {
        width: 70px;
        height: 70px;
        background-color: #E5E7EB;
        color: #6B7280;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        margin: 0 auto 1.5rem;
        font-weight: 600;
        font-size: 1rem;
    }
    /* Teks Judul */
    .login-form-wrapper h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1F2937;
        text-align: center;
        margin: 0;
    }
    .login-form-wrapper p {
        font-size: 1rem;
        color: #6B7280;
        text-align: center;
        margin-bottom: 2.5rem;
    }
    /* Styling Form */
    .form-group { margin-bottom: 1.5rem; }
    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    .form-group input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        background-color: #F9FAFB;
        color: #1F2937;
        font-size: 1rem;
    }
    .form-group input::placeholder { color: #9CA3AF; }
    /* Tombol Login */
    .btn-login {
        width: 100%;
        padding: 0.75rem;
        background-color: #3B82F6;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 1rem;
    }
    /* Link di Bawah */
    .login-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 1.5rem;
        font-size: 0.875rem;
    }
    .login-footer a { color: #3B82F6; text-decoration: none; }
    /* Responsif untuk layar kecil (HP) */
    @media (max-width: 768px) {
        .login-illustration { display: none; }
        .login-form-wrapper { padding: 2rem; }
    }
</style>
@endpush

@section('content')
<div class.login-container">
    <div class="login-card">

        {{-- BAGIAN KIRI: ILUSTRASI --}}
        <div class="login-illustration">
            {{-- Ganti 'src' dengan path ke gambar ilustrasi Anda --}}
            <img src="httpsstatic/images/your-illustration.svg" alt="Login Illustration">
        </div>

        {{-- BAGIAN KANAN: FORM --}}
        <div class="login-form-wrapper">
            
            <div class="login-logo">LOGO</div>

            <h2>SELAMAT DATANG DI WEBSITE</h2>
            <p>SMPN 6 Bandar Lampung</p>
            <p style="margin-top: -2.2rem; font-weight: 500;">Silahkan Login Sebagai Admin</p>

            {{-- Menampilkan error validasi jika ada --}}
            @if ($errors->any())
                <div class="alert alert-danger" role="alert" style="font-size: 0.9rem;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            {{-- 
              PENTING: 'action' dari form ini harus diarahkan ke route login admin,
              bukan route login siswa.
            --}}
            <form action="{{ route('admin.login.store') }}" method="POST"> {{-- (Contoh nama route) --}}
                @csrf
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Masukan Email" value="{{ old('email') }}" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" placeholder="Masukan Password" required>
                </div>
                
                <button type="submit" class="btn-login">Login</button>
                
                <div class="login-footer">
                    <a href="#">Lupa Kata Sandi?</a>
                    {{-- Admin tidak bisa "Buat Akun", jadi link-nya dihapus --}}
                </div>
            </form>
        </div>

    </div>
</div>
@endsection