<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Nama Alat</th>
                        <th>Tgl. Pinjam</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                    <tr>
                        <td>{{ $trx->user->name }}</td>
                        <td>{{ $trx->itemable->nama }}</td>
                        <td>{{ $trx->tanggal_pinjam->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada item yang sedang dipinjam.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>