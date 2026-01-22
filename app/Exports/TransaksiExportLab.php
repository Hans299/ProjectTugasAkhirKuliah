<?php

namespace App\Exports;

use App\Models\AlatLab;
use App\Models\Transaksi;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExportLab implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $startDate;
    protected $endDate;
    protected $status;
    protected $no = 1;

    public function __construct($startDate, $endDate, $status)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->status = $status;
    }

    public function collection()
    {
        return Transaksi::with(['user', 'itemable'])
            ->where('itemable_type', AlatLab::class)
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
            'Nama Alat',
            'Jumlah',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Terlambat',
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
            $trx->itemable->nama_alat ?? '-',
            $trx->jumlah,
            optional($trx->tanggal_peminjaman)->format('d-m-Y'),
            optional($trx->tanggal_pengembalian)->format('d-m-Y'),
            $trx->keterlambatan ? $trx->keterlambatan . ' Hari' : '-',
            $trx->catatan,
            ucfirst($trx->status),
        ];
    }
}
