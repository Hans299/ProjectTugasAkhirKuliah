<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AlatLab; // <-- DIUBAH
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{
    /**
     * Menampilkan halaman daftar transaksi
     */
    public function index()
    {
        // Ambil transaksi di mana 'itemable_type' adalah 'AlatLab'
        $transaksis = Transaksi::where('itemable_type', AlatLab::class) // <-- DIUBAH
                                ->with(['itemable', 'user'])
                                ->orderBy('created_at', 'desc')
                                ->get();

        $pending = $transaksis->where('status', 'pending');
        $dipinjam = $transaksis->where('status', 'dipinjam');
        $menunggu_konfirmasi = $transaksis->where('status', 'menunggu-konfirmasi');
        $selesai = $transaksis->whereIn('status', ['selesai', 'ditolak']);

        // Arahkan ke view laboran
        return view('laboran.transaksi.index', compact( // <-- DIUBAH
            'pending', 
            'dipinjam', 
            'menunggu_konfirmasi', 
            'selesai'
        ));
    }

    /**
     * Menyetujui peminjaman (status: pending -> dipinjam)
     */
    public function setujui(Transaksi $transaksi)
    {
        try {
            DB::beginTransaction();

            $alat = $transaksi->itemable; // <-- DIUBAH

            // 1. Cek stok
            if ($alat->stok < 1) { // <-- DIUBAH
                return back()->with('error', 'Stok alat habis. Transaksi tidak bisa disetujui.');
            }

            // 2. Kurangi stok
            $alat->decrement('stok'); // <-- DIUBAH

            // 3. Update status transaksi
            $transaksi->status = 'dipinjam';
            $transaksi->save();

            DB::commit();
            return back()->with('success', 'Peminjaman berhasil disetujui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak peminjaman (status: pending -> ditolak)
     */
    public function tolak(Transaksi $transaksi)
    {
        if ($transaksi->status != 'pending') {
            return back()->with('error', 'Transaksi ini tidak bisa ditolak.');
        }

        $transaksi->status = 'ditolak';
        $transaksi->save();

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Menyelesaikan pengembalian (status: menunggu-konfirmasi -> selesai)
     */
    public function selesaikan(Transaksi $transaksi)
    {
        if ($transaksi->status != 'menunggu-konfirmasi') {
            return back()->with('error', 'Status transaksi salah.');
        }

        try {
            DB::beginTransaction();

            // 1. Tambah stok (stok kembali)
            $transaksi->itemable->increment('stok');

            // 2. Update status
            $transaksi->status = 'selesai';
            $transaksi->save();

            DB::commit();
            return back()->with('success', 'Pengembalian berhasil dikonfirmasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menolak bukti pengembalian (status: menunggu-konfirmasi -> dipinjam)
     */
    public function gagalKembali(Transaksi $transaksi)
    {
        if ($transaksi->status != 'menunggu-konfirmasi') {
            return back()->with('error', 'Status transaksi salah.');
        }

        if ($transaksi->foto_pengembalian) {
            Storage::delete($transaksi->foto_pengembalian);
        }

        $transaksi->status = 'dipinjam';
        $transaksi->foto_pengembalian = null;
        $transaksi->tanggal_kembali = null;
        $transaksi->save();

        return back()->with('warning', 'Pengembalian ditolak. Siswa diminta upload ulang bukti.');
    }
}