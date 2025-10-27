<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan 'use Auth' ada

class AdminLoginController extends Controller
{
    /**
     * Menampilkan halaman/form login untuk admin.
     */
    public function showLoginForm()
    {
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