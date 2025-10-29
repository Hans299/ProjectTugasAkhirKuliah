<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus=Buku::orderBy('judul','asc')->paginate(10);
        return view('Pustakawan.buku.index',compact('bukus'));
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
        $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'pengarang' => 'required|string|max:255',
        'penerbit' => 'nullable|string|max:255',
        'stok' => 'required|integer|min:0',
    ]);

    // 2. Simpan ke database
    Buku::create($validated);

    // 3. Redirect
    return redirect()->route('admin.pustakawan.buku.index')
                     ->with('success', 'Buku berhasil ditambahkan.');
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
    public function edit(string $id)
    {
        return view('Pustakawan.buku.edit',compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        // 1. Validasi
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'pengarang' => 'required|string|max:255',
        'penerbit' => 'nullable|string|max:255',
        'stok' => 'required|integer|min:0',
    ]);

    // 2. Update data di database
    $buku->update($validated);

    // 3. Redirect
    return redirect()->route('admin.pustakawan.buku.index')
                     ->with('success', 'Buku berhasil diperbarui.');
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
