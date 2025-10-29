<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\AlatLab;
use Illuminate\Http\Request;

class AlatLabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alats=AlatLab::orderBy('nama','asc')->paginate(10);
        return view('Laboran.alat.index',compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Laboran.alat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     // 1. Validasi
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'stok' => 'required|integer|min:0',
    ]);

    // 2. Simpan ke database
    AlatLab::create($validated);

    // 3. Redirect
    return redirect()->route('admin.laboran.alat.index')
                     ->with('success', 'Alat berhasil ditambahkan.');   
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
        return view('Laboran.alat.edit',compact('alat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlatLab $alat)
    {
        // 1. Validasi
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
        ]);

        // 2. Update
        $alat->update($validated);

        // 3. Redirect
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
