<?php

namespace App\Http\Controllers\Pustakawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Buku;
use Illuminate\Support\Facades\Storage; 

class TransaksiController extends Controller
{
    public function index()
    {
        // Ambil transaksi di mana 'itemable_type' adalah 'Buku'
        // Kita gunakan 'whereHasMorph' untuk memfilter berdasarkan relasi polimorfik
        $transaksis = Transaksi::where('itemable_type', Buku::class)
                                ->with(['itemable', 'user']) // Ambil data buku dan data siswa
                                ->orderBy('created_at', 'desc')
                                ->get();

        // Pisahkan berdasarkan status untuk ditampilkan di view
        $pending = $transaksis->where('status', 'pending');
        $dipinjam = $transaksis->where('status', 'dipinjam');
        $menunggu_konfirmasi = $transaksis->where('status', 'menunggu-konfirmasi');
        $selesai = $transaksis->whereIn('status', ['selesai', 'ditolak']);

        return view('pustakawan.transaksi.index', compact(
            'pending', 
            'dipinjam', 
            'menunggu_konfirmasi', 
            'selesai'
        ));
    }
    public function setujui(Transaksi $transaksi)
    {
        // Gunakan DB Transaction untuk memastikan data konsisten
        try {
            DB::beginTransaction();

            $buku = $transaksi->itemable; // Ambil buku terkait

            // 1. Cek stok
            if ($buku->stok < 1) {
                return back()->with('error', 'Stok buku habis. Transaksi tidak bisa disetujui.');
            }

            // 2. Kurangi stok
            $buku->decrement('stok');

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
    public function tolak(Transaksi $transaksi)
    {
        // Cek apakah statusnya 'pending'
        if ($transaksi->status != 'pending') {
            return back()->with('error', 'Transaksi ini tidak bisa ditolak.');
        }

        $transaksi->status = 'ditolak';
        $transaksi->save();

        // Stok tidak perlu dikembalikan karena belum berkurang
        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }
    public function selesaikan(Transaksi $transaksi)
    {
        // Cek status
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
    public function gagalKembali(Transaksi $transaksi)
    {
        // Cek status
        if ($transaksi->status != 'menunggu-konfirmasi') {
            return back()->with('error', 'Status transaksi salah.');
        }

        // 1. Hapus foto bukti
        if ($transaksi->foto_pengembalian) {
            Storage::delete($transaksi->foto_pengembalian);
        }

        // 2. Reset status
        $transaksi->status = 'dipinjam';
        $transaksi->foto_pengembalian = null;
        $transaksi->tanggal_kembali = null;
        $transaksi->save();

        return back()->with('warning', 'Pengembalian ditolak. Siswa diminta upload ulang bukti.');
    }
}
