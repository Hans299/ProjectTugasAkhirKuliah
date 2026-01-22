<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bukus = Buku::query()
            ->when($request->search, function ($q) use ($request) {
                $search = $request->search;

                $q->where(function ($sub) use ($search) {
                    $sub->where('judul_buku', 'like', "%{$search}%")
                        ->orWhere('penulis', 'like', "%{$search}%")
                        ->orWhere('penerbit', 'like', "%{$search}%")
                        ->orWhere('tahun_terbit', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%");
                });
            })
            ->orderBy('judul_buku', 'asc')   // 🔤 Abjad A–Z
            ->orderBy('stok', 'desc')        // 📦 Stok terbanyak
            ->orderBy('isbn', 'asc')         // Tambahan penentu urutan
            ->paginate(10)
            ->withQueryString();

        return view('Pustakawan.buku.index', compact('bukus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pustakawan.buku.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1000|max:' . (date('Y')),
            'isbn' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bukus', 'isbn'),
            ],
            'halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10048',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 digit.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh lebih dari tahun saat ini.',
            'isbn.unique' => 'ISBN sudah terdaftar.',
            'halaman.integer' => 'Halaman harus berupa angka.',
            'halaman.min' => 'Halaman harus minimal 1.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpg, jpeg, png, gif, atau svg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
            'stok.required' => 'Stok wajib diisi.',
            'kategori.required' => 'Kategori wajib diisi.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 1. Ambil data yang sudah divalidasi
        $validated = $validator->validated();

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('gambar_buku', 'public');
            $validated['gambar'] = $gambarPath;
        }

        // 2. Simpan ke database
        Buku::create($validated);

        // 3. Redirect
        return redirect()->route('admin.pustakawan.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function show(Buku $buku)
    {
        return view('pustakawan.buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        return view('pustakawan.buku.edit', compact('buku'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $validator = Validator::make($request->all(), [
            'judul_buku' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'nullable|string|max:255',
            'tahun_terbit' => 'nullable|digits:4|integer|min:1000|max:' . (date('Y')),
            'isbn' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bukus', 'isbn')->ignore($buku->id),
            ],
            'halaman' => 'nullable|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif,svg|max:10048',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
        ], [
            'judul_buku.required' => 'Judul buku wajib diisi.',
            'penulis.required' => 'Penulis wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus terdiri dari 4 digit.',
            'tahun_terbit.min' => 'Tahun terbit tidak valid.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh lebih dari tahun saat ini.',
            'isbn.unique' => 'ISBN sudah terdaftar.',
            'halaman.integer' => 'Halaman harus berupa angka.',
            'halaman.min' => 'Halaman harus minimal 1.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpg, jpeg, png, gif, atau svg.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
            'stok.required' => 'Stok wajib diisi.',
            'kategori.required' => 'Kategori wajib diisi.',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 1. Ambil data yang sudah divalidasi
        $validated = $validator->validated();


        // 🔄 Jika upload gambar baru
        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($buku->gambar && Storage::disk('public')->exists($buku->gambar)) {
                Storage::disk('public')->delete($buku->gambar);
            }

            // Simpan gambar baru
            $validated['gambar'] = $request->file('gambar')->store('gambar_buku', 'public');
        }

        // 🔐 Update data buku
        $buku->update($validated);

        return redirect()
            ->route('admin.pustakawan.buku.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('admin.pustakawan.buku.index')
            ->with('success', 'Buku berhasil dihapus.');
    }
}
