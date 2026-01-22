<?php

namespace App\Http\Controllers\Laboran;

use App\Exports\TransaksiExportLab;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\AlatLab; // <-- DIUBAH
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TransaksiController extends Controller
{
    /**
     * Menampilkan halaman daftar transaksi
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        // QUERY UTAMA
        $transaksis = Transaksi::where('itemable_type', AlatLab::class)
            ->with(['itemable', 'user'])
            ->when($search, function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', "%{$search}%");
                })
                    ->orWhereHas('itemable', function ($i) use ($search) {
                        $i->where('nama_alat', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // FILTER STATUS (DARI COLLECTION)
        $pending = $transaksis->getCollection()->where('status', 'pending');
        $dipinjam = $transaksis->getCollection()->where('status', 'dipinjam');
        $menunggu_konfirmasi = $transaksis->getCollection()->where('status', 'menunggu-konfirmasi');
        $selesai = $transaksis->getCollection()->whereIn('status', ['dikembalikan', 'ditolak']);

        return view('laboran.transaksi.index', compact(
            'transaksis',
            'pending',
            'dipinjam',
            'menunggu_konfirmasi',
            'selesai',
            'search'
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
            $alat->decrement('stok', $transaksi->jumlah); // <-- DIUBAH

            // 3. Update status transaksi
            $transaksi->status = 'dipinjam';
            $transaksi->tanggal_pengembalian = now()->addDays(7);
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
            $transaksi->itemable->increment('stok', $transaksi->jumlah);

            // 2. Update status
            $transaksi->status = 'dikembalikan';
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
    public function gagalKembali(Transaksi $transaksi, Request $request)
    {
        $request->validate([
            'catatan' => 'required|string',
        ], [
            'catatan.required' => 'Catatan penolakan wajib diisi.',
        ]);

        $transaksi->update([
            'status' => 'dipinjam',
            'catatan' => $request->catatan,
        ]);

        return back()->with('warning', 'Pengembalian berhasil ditolak dengan catatan');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable|string',
        ]);

        return Excel::download(
            new TransaksiExportLab($request->start_date, $request->end_date,   $request->status,),
            'riwayat-peminjaman-lab-' . $request->status . '_' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
