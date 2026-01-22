<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check() && in_array(Auth::user()->role->name, ['superadmin', 'pustakawan', 'laboran'])) {
            // Jika sudah login sebagai admin, arahkan ke dashboard sesuai role
            switch (Auth::user()->role->name) {
                case 'superadmin':
                    return redirect()->route('admin.superadmin.dashboard');
                case 'pustakawan':
                    return redirect()->route('admin.pustakawan.dashboard');
                case 'laboran':
                    return redirect()->route('admin.laboran.dashboard');
            }
        } elseif (Auth::check() && Auth::user()->role->name === 'siswa') {
            // Jika sudah login sebagai siswa, arahkan ke dashboard siswa
            return redirect()->route('siswa.dashboard');
        }
        // Arahkan ke file blade login admin (desain biru)
        return view('auth.admin_login');
    }

    /**
     * Memproses percobaan login admin.
     */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Ambil data user yang berhasil login
            if ($user->status !== 'active') {
                Auth::logout(); // Logout paksa
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('email');
            }
            // 3. Cek apakah rolenya adalah admin (bukan siswa)
            if (in_array($user->role->name, ['superadmin', 'pustakawan', 'laboran'])) {

                $request->session()->regenerate(); // Regenerate session ID

                // ======================================================
                //      INI BAGIAN YANG DIUBAH (Langkah 5.4)
                //      Menggunakan nama rute '...dashboard'
                // ======================================================
                switch ($user->role->name) {
                    case 'superadmin':
                        return redirect()->intended(route('admin.superadmin.dashboard'));
                    case 'pustakawan':
                        return redirect()->intended(route('admin.pustakawan.dashboard'));
                    case 'laboran':
                        return redirect()->intended(route('admin.laboran.dashboard'));
                    default:
                        Auth::logout(); // Logout paksa jika role tidak dikenali
                        return back()->withErrors([
                            'email' => 'Akun ini bukan akun Admin.',
                        ])->onlyInput('email');
                }
                // ======================================================
                //            AKHIR BAGIAN YANG DIUBAH
                // ======================================================

            } else {
                // 4. Jika yang login Siswa di form admin, tolak
                Auth::logout(); // Logout paksa
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun Admin.',
                ])->onlyInput('email');
            }
        }

        // 5. Jika email/password salah
        return back()->withErrors([
            'email' => 'Email atau Password salah.',
        ])->onlyInput('email');
    }
}
