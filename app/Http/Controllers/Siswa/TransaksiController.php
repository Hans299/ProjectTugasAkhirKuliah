<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\AlatLab;
use App\Models\Transaksi;
use Carbon\Carbon;
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
        $request->validate([
            'item_id'   => 'required',
            'item_type' => 'required|in:Buku,AlatLab',
            'jumlah'    => 'required|integer|min:1',
            'guru'      => 'nullable|string|max:255',
        ]);

        $model = $request->item_type === 'Buku'
            ? \App\Models\Buku::where('isbn', $request->item_id)->firstOrFail()
            : \App\Models\AlatLab::where('id_alat', $request->item_id)->firstOrFail();

        if ($request->jumlah > $model->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        // cek apakah ada peminjaman pending yang sama
        $existingTransaction = Transaksi::where('user_id', Auth::user()->id)
            ->where('itemable_id', $model->getKey())
            ->where('itemable_type', get_class($model))
            ->whereIn('status', ['pending'])
            ->first();

        if ($existingTransaction) {
            return redirect()
                ->route('siswa.pinjaman.riwayat')
                ->with(
                    'error',
                    'Selesaikan pengajuan yang sama untuk peminjaman item ' .
                        $existingTransaction->itemable->judul_buku ?? $existingTransaction->itemable->nama_alat
                );
        }

        // Cek apakah sudah dipinjam
        Transaksi::create([
            'user_id'       => Auth::user()->id,
            'itemable_id'   => $model->getKey(),
            'itemable_type' => get_class($model),
            'jumlah'        => $request->jumlah,
            'status'        => 'pending',
            'guru'         => $request->guru,
            'tanggal_peminjaman' => now(),
        ]);


        return redirect()
            ->route('siswa.pinjaman.riwayat')
            ->with('success', 'Pengajuan peminjaman berhasil.');
    }

    public function showAksiPengembalian(Request $request)
    {
        $filter = $request->get('filter'); // buku | alat | null

        $transaksis = Transaksi::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->when($filter === 'buku', function ($q) {
                $q->where('itemable_type', \App\Models\Buku::class);
            })
            ->when($filter === 'alat', function ($q) {
                $q->where('itemable_type', \App\Models\AlatLab::class);
            })
            ->with('itemable')
            ->orderBy('tanggal_pengembalian', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();
        return view('siswa.pinjaman.pengembalian', compact('transaksis', 'filter'));
    }


    /**
     * 3. Menampilkan RIWAYAT Peminjaman.
     */
    public function riwayat(Request $request)
    {
        $filter = $request->get('filter'); // buku | alat | null

        $transaksis = Transaksi::where('user_id', Auth::id())
            ->when($filter === 'buku', function ($q) {
                $q->where('itemable_type', \App\Models\Buku::class);
            })
            ->when($filter === 'alat', function ($q) {
                $q->where('itemable_type', \App\Models\AlatLab::class);
            })
            ->with('itemable')
            ->orderByRaw("
            CASE
                WHEN status = 'pending' THEN 0
                ELSE 1
            END")
            ->orderByRaw("
            CASE
                WHEN status = 'menunggu-konfirmasi' THEN 0
                ELSE 1
            END")
            ->orderByRaw("
            CASE
                WHEN status = 'dipinjam' THEN 0
                ELSE 1
            END")
            ->orderBy('tanggal_pengembalian', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('siswa.pinjaman.riwayat', compact('transaksis', 'filter'));
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

    public function storePengembalian(Transaksi $transaksi)
    {
        if ($transaksi->user_id != Auth::id() || $transaksi->status != 'dipinjam') {
            abort(403, 'Aksi tidak diizinkan.');
        }

        $hariTerlambat = 0;

        if ($transaksi->tanggal_pengembalian) {
            $jatuhTempo = Carbon::parse($transaksi->tanggal_pengembalian)->startOfDay();
            $hariIni = now()->startOfDay();

            if ($hariIni->gt($jatuhTempo)) {
                $hariTerlambat = $jatuhTempo->diffInDays($hariIni);
            }
        }

        if ($transaksi->itemable_type == Buku::class) {
            $denda = $hariTerlambat * 3000;
        } else {
            $denda = null;
        }

        $transaksi->update([
            'status' => 'menunggu-konfirmasi',
            'tanggal_pengembalian_aktual' => now(),
            'keterlambatan' => $hariTerlambat,
            'denda' => $denda,
        ]);

        return redirect()
            ->route('siswa.pinjaman.pengembalian')
            ->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }
}
