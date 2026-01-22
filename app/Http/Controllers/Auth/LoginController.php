<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::check() && Auth::user()->role->name === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        if (Auth::check() && Auth::user()->role->name !== 'siswa') {
            Auth::logout();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {
            $user = Auth::user(); // Ambil data user yang berhasil login
            if ($user->status !== 'active') {
                Auth::logout(); // Logout paksa
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ])->onlyInput('email');
            } elseif ($user->role->name !== 'siswa') {
                // Jika bukan siswa, logout dan tolak akses
                Auth::logout(); // Logout paksa
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun Siswa.',
                ])->onlyInput('email');
            } else {
                $request->session()->regenerate(); // Regenerate session ID
                // Redirect ke dashboard siswa
                return redirect()->intended(route('siswa.dashboard'));
            }
        }

        return redirect()->route('siswa.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
