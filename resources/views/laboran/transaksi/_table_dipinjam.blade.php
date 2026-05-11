<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Guru Pengajar</th>
                        <th>Nama Alat</th>
                        <th>Jumlah Dipinjam</th>
                        <th>Tgl. Pinjam</th>
                        <th>Estimasi Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->user->name }}</td>
                            <td>{{ $trx->guru ?? '-' }}</td>
                            <td>{{ $trx->itemable->nama_alat }}</td>
                            <td>{{ $trx->jumlah }}</td>
                            <td>{{ $trx->tanggal_peminjaman->format('d M Y') }}</td>
                            <td>{{ $trx->tanggal_pengembalian ? $trx->tanggal_pengembalian->format('d M Y') : 'Belum dikembalikan' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada item yang sedang dipinjam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
