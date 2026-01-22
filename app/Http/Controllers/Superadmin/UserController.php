<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of USER (SISWA ONLY)
     */
    public function index(Request $request)
    {
        $users = User::with('role')
            ->where('id', '!=', Auth::id())
            ->whereHas('role', function ($q) {
                $q->where('name', 'siswa'); // ⬅️ KHUSUS USER
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->orderBy('name', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new USER
     */
    public function create()
    {
        // Ambil ROLE SISWA SAJA
        $role = Role::where('name', 'siswa')->firstOrFail();

        return view('superadmin.user.create', compact('role'));
    }

    /**
     * Store a newly created USER
     */
    public function store(Request $request)
    {
        $roleSiswa = Role::where('name', 'siswa')->firstOrFail();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'kelas' => 'required|string|max:50',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'kelas.required' => 'Kelas wajib diisi.',
            'profile_photo_path.image' => 'File harus berupa gambar.',
            'profile_photo_path.mimes' => 'Format gambar harus berupa jpeg, png, jpg, gif, atau svg.',
            'profile_photo_path.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $gambarPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $gambarPath = $request->file('profile_photo_path')
                ->store('profile', 'public');
        }

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => $roleSiswa->id, // ⬅️ DIPAKSA SISWA
            'kelas'    => $validated['kelas'],
            'profile_photo_path' => $gambarPath,
            'status'   => 'active',
        ]);

        return redirect()
            ->route('admin.superadmin.user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('superadmin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the USER
     */
    public function edit(User $user)
    {
        // ❌ BLOK jika bukan siswa
        if ($user->role?->name !== 'siswa') {
            abort(403, 'Akses ditolak');
        }

        return view('superadmin.user.edit', compact('user'));
    }

    /**
     * Update the USER
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi input
        $validated = $request->validate(
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'password' => 'nullable|string|min:8|confirmed',
                'kelas' => [
                    'nullable',
                    'string',
                    'max:50'
                ],
                'profile_photo_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => [
                    'required',
                    Rule::in(['active', 'inactive']),
                ],
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'name.unique' => 'Username sudah digunakan.',
                'email.required' => 'Email wajib diisi.',
                'email.unique' => 'Email sudah digunakan.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'kelas.required' => 'Kelas wajib diisi untuk role siswa.',
                'profile_photo_path.image' => 'File harus berupa gambar.',
                'profile_photo_path.max' => 'Ukuran gambar maksimal 2MB.',
                'status.required' => 'Status wajib diisi.',
                'status.in' => 'Status tidak valid.',
            ]
        );

        // 2. Siapkan data update
        $data = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'kelas'   => $validated['kelas'],
            'status'  => $validated['status']
        ];

        // 3. Update password JIKA diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // 4. Handle upload foto JIKA ada
        if ($request->hasFile('profile_photo_path')) {

            // Hapus foto lama jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru
            $data['profile_photo_path'] = $request
                ->file('profile_photo_path')
                ->store('profile', 'public');
        }

        // 5. Update user
        $user->update($data);

        // 6. Redirect
        return redirect()
            ->route('admin.superadmin.user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the USER
     */
    public function destroy(User $user)
    {
        if ($user->role?->name !== 'siswa') {
            abort(403, 'Akses ditolak');
        }

        $user->delete();

        return redirect()
            ->route('admin.superadmin.user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
