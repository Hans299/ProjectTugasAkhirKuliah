<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\AlatLab;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    /**
     * 1. Menampilkan FORM Peminjaman.
     */
    public function showPinjamForm(Request $request, $item_type, $item_id)
    {
        if ($item_type == 'Buku') {
            $item = Buku::findOrFail($item_id);
        } elseif ($item_type == 'AlatLab') {
            $item = AlatLab::findOrFail($item_id);
        } else {
            abort(404);
        }

        // Memanggil view: resources/views/siswa/pinjaman/create.blade.php
        return view('siswa.pinjaman.create', compact('item', 'item_type'));
    }

    /**
     * 2. Memproses FORM Peminjaman.
     */
    public function storePeminjaman(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|integer',
            'item_type' => 'required|string|in:Buku,AlatLab',
        ]);

        $modelClass = $validated['item_type'] == 'Buku' ? Buku::class : AlatLab::class;
        $item = $modelClass::find($validated['item_id']);

        if (!$item || $item->stok < 1) {
            return back()->with('error', 'Item tidak ditemukan atau stok habis.');
        }

        // Cek jika sudah pernah pinjam (pending/dipinjam)
        $existingLoan = Transaksi::where('user_id', Auth::id())
                                ->where('itemable_id', $item->id)
                                ->where('itemable_type', $modelClass)
                                ->whereIn('status', ['pending', 'dipinjam'])
                                ->exists();
        
        if ($existingLoan) {
            return redirect()->route('siswa.pinjaman.riwayat')->with('error', 'Anda sudah meminjam item ini.');
        }

        // Buat transaksi
        Transaksi::create([
            'user_id' => Auth::id(),
            'itemable_id' => $item->id,
            'itemable_type' => $modelClass,
            'tanggal_pinjam' => now(),
            'status' => 'pending', // Status awal: Menunggu persetujuan
        ]);

        // Arahkan ke halaman riwayat dengan pesan sukses
        return redirect()->route('siswa.pinjaman.riwayat')->with('success', 'Permintaan peminjaman berhasil diajukan.');
    }

    /**
     * 3. Menampilkan RIWAYAT Peminjaman.
     */
    public function riwayat()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                                ->with('itemable') // Ambil data item (Buku/Alat)
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Memanggil view: resources/views/siswa/pinjaman/riwayat.blade.php
        return view('siswa.pinjaman.riwayat', compact('transaksis'));
    }

    /**
     * 4. Menampilkan FORM Pengembalian (dengan upload foto).
     */
    public function showKembaliForm(Transaksi $transaksi)
    {
        // Pastikan siswa ini yang punya transaksi
        if ($transaksi->user_id != Auth::id() || $transaksi->status != 'dipinjam') {
            abort(403, 'Aksi tidak diizinkan.');
        }

        // Memanggil view: resources/views/siswa/pinjaman/kembalikan.blade.php
        return view('siswa.pinjaman.kembalikan', compact('transaksi'));
    }

    /**
     * 5. Memproses FORM Pengembalian (dengan upload foto).
     */
    public function storePengembalian(Request $request, Transaksi $transaksi)
    {
        // Pastikan siswa ini yang punya transaksi
        if ($transaksi->user_id != Auth::id() || $transaksi->status != 'dipinjam') {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $validated = $request->validate([
            'foto_pengembalian' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib foto, maks 2MB
        ]);

        // Upload foto
        $path = $request->file('foto_pengembalian')->store('public/bukti_pengembalian');

        // Update transaksi
        $transaksi->update([
            'status' => 'menunggu-konfirmasi', // Status baru: admin harus cek foto
            'foto_pengembalian' => $path, // Simpan path foto
            'tanggal_kembali' => now(),
        ]);

        return redirect()->route('siswa.pinjaman.riwayat')->with('success', 'Pengajuan pengembalian berhasil, menunggu konfirmasi admin.');
    }
}