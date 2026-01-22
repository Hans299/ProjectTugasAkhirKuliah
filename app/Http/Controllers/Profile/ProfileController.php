<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $layout = $user->role?->name != 'siswa'
            ? 'layouts.admin'
            : 'layouts.siswa';

        return view('profile.index', compact('user', 'layout'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'kelas'    => 'nullable|string|max:50',
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'profile_photo_path' => 'nullable|image|max:2048',
        ], [
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal :min karakter.',
            'profile_photo_path.image' => 'File harus berupa gambar.',
            'profile_photo_path.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // =====================
        // UPDATE DATA
        // =====================
        $user->name  = $request->name;
        $user->email = $request->email;

        if ($user->role?->name === 'siswa') {
            $user->kelas = $request->kelas;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo_path')) {
            $path = $request->file('profile_photo_path')->store('profile', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }
}
