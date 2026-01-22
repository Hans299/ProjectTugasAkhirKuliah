<?php

namespace App\Exports;

use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExportBuku implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $no = 1;
    protected $kategori;

    public function __construct($startDate, $endDate, $status, $kategori)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->status = $status;
        $this->kategori = $kategori;
    }

    public function collection()
    {
        return Transaksi::with(['user', 'itemable'])
            ->where('itemable_type', Buku::class)
            ->when($this->kategori, function ($q) {
                $q->whereHasMorph(
                    'itemable',
                    [Buku::class],
                    function ($bukuQuery) {
                        $bukuQuery->where('kategori', $this->kategori);
                    }
                );
            })
            ->whereBetween('tanggal_peminjaman', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay(),
            ])
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->orderBy('tanggal_peminjaman', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Guru Pengajar',
            'Judul Buku',
            'Kategori Buku',
            'Jumlah Dipinjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Terlambat',
            'Denda',
            'Catatan',
            'Status',
        ];
    }

    public function map($trx): array
    {
        return [
            $this->no++,
            $trx->user->name ?? '-',
            $trx->guru ?? '-',
            $trx->itemable->judul_buku ?? '-',
            $trx->itemable->kategori ?? '-',
            $trx->jumlah,
            optional($trx->tanggal_peminjaman)->format('d-m-Y'),
            optional($trx->tanggal_pengembalian)->format('d-m-Y'),
            $trx->keterlambatan ? $trx->keterlambatan . ' Hari' : '-',
            'Rp ' . number_format($trx->denda, 0, ',', '.'),
            $trx->catatan ?? '-',
            ucfirst($trx->status),
        ];
    }
}
