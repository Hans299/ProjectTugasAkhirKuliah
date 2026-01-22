<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::with('role')
            ->where('id', '!=', Auth::id())
            ->whereHas('role', function ($q) {
                $q->whereNotIn('name', ['superadmin', 'siswa', 'user']);
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            ->paginate(10)
            ->withQueryString();

        return view('superadmin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'superadmin')
            ->where('name', '!=', 'siswa')
            ->get();

        return view('superadmin.admin.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Buat validator manual
        $validator = Validator::make(
            $request->all(),
            [
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('users', 'name'),
                ],
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email'),
                ],
                'password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
                'kelas' => [
                    Rule::requiredIf($request->role_id == 4),
                    'nullable',
                    'string',
                    'max:50'
                ],
                'profile_photo_path' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:2048',
            ],
            [
                'name.required' => 'Nama wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password minimal :min karakter.',
                'password.confirmed' => 'Konfirmasi password tidak sesuai.',
                'role_id.required' => 'Role admin wajib dipilih.',
                'role_id.exists' => 'Role admin tidak valid.',
                'kelas.required' => 'Kelas wajib diisi untuk role siswa.',
                'profile_photo_path.image' => 'File harus berupa gambar.',
                'profile_photo_path.mimes' => 'Format gambar harus jpg, jpeg, atau png.',
                'profile_photo_path.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );

        // 2. RETURN JIKA VALIDASI ERROR
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // 3. Upload gambar (jika ada)
        $gambarPath = null;
        if ($request->hasFile('profile_photo_path')) {
            $gambarPath = $request->file('profile_photo_path')
                ->store('profile', 'public');
        }

        // 4. Simpan user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'kelas' => $validated['role_id'] == 4 ? $validated['kelas'] : null,
            'profile_photo_path' => $gambarPath,
            'status' => 'active',
        ]);

        // 5. Redirect sukses
        return redirect()
            ->route('admin.superadmin.admin.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::findOrFail($id);
        return view('superadmin.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $admin)
    {
        $admin = User::findOrFail($admin);
        $roles = Role::where('name', '!=', 'superadmin')->get();

        // Kirim data user yang akan diedit dan data roles ke view
        return view('superadmin.admin.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi input
        $validator = Validator::make(
            $request->all(),
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
                'role_id' => 'required|exists:roles,id',
                'kelas' => [
                    Rule::requiredIf($request->role_id == 4),
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
                'role_id.required' => 'Role wajib dipilih.',
                'kelas.required' => 'Kelas wajib diisi untuk role siswa.',
                'profile_photo_path.image' => 'File harus berupa gambar.',
                'profile_photo_path.max' => 'Ukuran gambar maksimal 2MB.',
                'status.required' => 'Status wajib diisi.',
                'status.in' => 'Status tidak valid.',
            ]
        );

        // 2. RETURN JIKA VALIDASI ERROR
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // 2. Siapkan data update
        $data = [
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'role_id' => $validated['role_id'],
            'kelas'   => $request->role_id == 4 ? $validated['kelas'] : null,
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
            ->route('admin.superadmin.admin.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        // Redirect kembali ke halaman index
        return redirect()->route('admin.superadmin.admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
