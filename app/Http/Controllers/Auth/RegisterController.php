<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Redirect setelah registrasi
     */
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function registered()
    {
        Auth::logout(); // ⛔ logout otomatis



        return redirect($this->redirectTo)->with('success', 'Registrasi berhasil. Silakan minta aktivasi dari administrator.');
    }

    /**
     * Validasi input register
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'kelas' => ['required', 'string', 'max:100'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
            'email.unique' => 'Alamat email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.max' => 'Kelas maksimal 100 karakter.',
        ]);
    }

    /**
     * Simpan user baru (SESUAI MODEL)
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'], // otomatis di-hash karena cast
            'role_id'  => 4, // role siswa (sesuaikan dengan tabel role)
            'kelas'    => $data['kelas'] ?? null,
        ]);
    }
}
