@push('styles')
    <style>
        /* Cell wrapper */
        .catatan-cell {
            max-width: 250px;
            position: relative;
        }

        /* Default (collapse) */
        .catatan-preview {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: help;
        }

        /* Hover → tampil penuh */
        .catatan-preview:hover {
            white-space: normal;
            overflow: visible;
            background: #f8f9fa;
            padding: 8px;
            border-radius: 6px;
            position: absolute;
            z-index: 10;
            max-width: 350px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Guru Pengajar</th>
                        <th>Judul Buku</th>
                        <th>Jumlah Dipinjam</th>
                        <th>Tgl. Pinjam</th>
                        <th>Tgl. Kembali</th>
                        <th>Denda</th>
                        <th>Catatan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->user->name }}</td>
                            <td>{{ $trx->guru ?? '-' }}</td>
                            <td>{{ $trx->itemable->judul_buku }}</td>
                            <td>{{ $trx->jumlah }}</td>
                            <td>{{ $trx->tanggal_peminjaman->format('d M Y') }}</td>
                            <td>{{ $trx->tanggal_pengembalian ? $trx->tanggal_pengembalian->format('d M Y') : '-' }}
                            </td>
                            <td>
                                {{ 'Rp ' . number_format($trx->denda, 0, ',', '.') }}
                            </td>
                            <td class="catatan-cell">
                                @if ($trx->catatan)
                                    <div class="catatan-preview" title="Arahkan mouse untuk melihat penuh">
                                        {{ $trx->catatan }}
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if ($trx->status == 'dikembalikan')
                                    <span class="badge bg-success">Dikembalikan</span>
                                @else
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada riwayat transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
