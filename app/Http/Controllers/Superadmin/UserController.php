<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')
                ->where('id', '!=', Auth::id())
                ->orderBy('name', 'asc')
                ->get();

    // Tampilkan view dan kirim data 'users'
    return view('superadmin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();

        return view('superadmin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role_id' => 'required|exists:roles,id',
        'kelas' => [
            // 'kelas' wajib diisi HANYA JIKA role_id adalah 'siswa'
            // Asumsikan role 'siswa' memiliki ID 4 (sesuai seeder kita)
            Rule::requiredIf($request->role_id == 4), 
            'nullable',
            'string',
            'max:50'
        ],
    ]);

    // 2. Buat user baru
    User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role_id' => $validated['role_id'],
        'kelas' => $request->role_id == 4 ? $validated['kelas'] : null,
    ]);

    // 3. Redirect kembali ke halaman index dengan pesan sukses
    return redirect()->route('admin.superadmin.users.index')
                     ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::where('name', '!=', 'superadmin')->get();

        // Kirim data user yang akan diedit dan data roles ke view
        return view('superadmin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            // Pastikan email unik, KECUALI untuk user ini sendiri
            Rule::unique('users')->ignore($user->id),
        ],
        'password' => 'nullable|string|min:8|confirmed', // Password Boleh Kosong
        'role_id' => 'required|exists:roles,id',
        'kelas' => [
            Rule::requiredIf($request->role_id == 4), // Asumsi ID 4 = siswa
            'nullable',
            'string',
            'max:50'
        ],
    ]);

    // 2. Siapkan data untuk diupdate
    $data = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'role_id' => $validated['role_id'],
        'kelas' => $request->role_id == 4 ? $validated['kelas'] : null,
    ];

    // 3. Cek jika password diisi, baru update password
    if (!empty($validated['password'])) {
        $data['password'] = Hash::make($validated['password']);
    }

    // 4. Update data user
    $user->update($data);

    // 5. Redirect kembali ke halaman index
    return redirect()->route('admin.superadmin.users.index')
                     ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

    // Redirect kembali ke halaman index
    return redirect()->route('admin.superadmin.users.index')
                     ->with('success', 'User berhasil dihapus.');
    }
}
