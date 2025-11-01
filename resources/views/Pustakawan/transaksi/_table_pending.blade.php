<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Tgl. Pengajuan</th>
                        <th>Stok Tersisa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                    <tr>
                        <td>{{ $trx->user->name }}</td>
                        <td>{{ $trx->itemable->judul }}</td>
                        <td>{{ $trx->tanggal_pinjam->format('d M Y') }}</td>
                        <td>
                            {{-- Beri tanda merah jika stok habis --}}
                            <span class="badge {{ $trx->itemable->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $trx->itemable->stok }}
                            </span>
                        </td>
                        <td class="action-buttons">
                            {{-- TOMBOL SETUJUI --}}
                            {{-- Tombol ini akan dinonaktifkan jika stok habis --}}
                            <form action="{{ route('admin.pustakawan.transaksi.setujui', $trx) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Setujui"
                                    {{ $trx->itemable->stok < 1 ? 'disabled' : '' }}>
                                    <i class="fa fa-check"></i>
                                </button>
                            </form>

                            {{-- TOMBOL TOLAK --}}
                            <form action="{{ route('admin.pustakawan.transaksi.tolak', $trx) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                    <i class="fa fa-times"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada permintaan pending.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>