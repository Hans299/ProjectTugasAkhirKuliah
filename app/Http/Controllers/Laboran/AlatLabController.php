<?php

namespace App\Http\Controllers\laboran;

use App\Http\Controllers\Controller;
use App\Models\AlatLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlatLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $alats = AlatLab::query()
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($sub) use ($search) {
                    $sub->where('nama_alat', 'like', "%{$search}%")
                        ->orWhere('id_alat', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%")
                        ->orWhere('kualitas', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_alat', 'asc')
            ->orderBy('stok', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('laboran.alat.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('laboran.alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validator = Validator::make($request->all(), [
            'nama_alat' => 'required|string|max:255',
            'id_alat' => [
                'required',
                'string',
                'max:100',
                Rule::unique('alat_labs', 'id_alat'),
            ],
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
            'kualitas' => 'required|string|max:255',
        ], [
            'id_alat.unique' => 'ID Alat sudah digunakan.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'nama_alat.required' => 'Nama Alat wajib diisi.',
            'kualitas.required' => 'Kualitas Alat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_alat', 'public');
            $validated['gambar'] = $gambarPath;
        }


        // 2. Simpan ke database
        AlatLab::create($validated);

        // 3. Redirect
        return redirect()->route('admin.laboran.alat.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AlatLab $alat)
    {
        return view('laboran.alat.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlatLab $alat)
    {
        return view('laboran.alat.edit', compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlatLab $alat)
    {
        // 1. Validasi (sama pola dengan store)
        $validator = Validator::make($request->all(), [
            'nama_alat' => 'required|string|max:255',
            'id_alat' => [
                'required',
                'string',
                'max:100',
                Rule::unique('alat_labs', 'id_alat')->ignore($alat->id),
            ],
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'kualitas' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'id_alat.unique' => 'ID Alat sudah digunakan.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'nama_alat.required' => 'Nama Alat wajib diisi.',
            'kualitas.required' => 'Kualitas Alat wajib diisi.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        // 2. Upload gambar (jika ada)
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($alat->gambar && Storage::disk('public')->exists($alat->gambar)) {
                Storage::disk('public')->delete($alat->gambar);
            }

            // Simpan gambar baru
            $validated['gambar'] = $request->file('gambar')
                ->store('gambar_alat', 'public');
        }

        // 3. Update database
        $alat->update($validated);

        // 4. Redirect
        return redirect()->route('admin.laboran.alat.index')
            ->with('success', 'Alat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlatLab $alat)
    {
        $alat->delete();
        return redirect()->route('admin.laboran.alat.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
