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
                        <th>Tgl. Estimasi Kembali</th>
                        <th>Telat (Hari)</th>
                        <th>Denda</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->user->name }}</td>
                            <td>{{ $trx->guru ?? '-' }}</td>
                            <td>{{ $trx->itemable->judul_buku }}</td>
                            <td>{{ $trx->jumlah }}</td>
                            <td>{{ $trx->tanggal_pengembalian->format('d M Y') }}</td>
                            <td>
                                {{ $trx->keterlambatan }}
                            </td>
                            <td>
                                {{ 'Rp ' . number_format($trx->denda, 0, ',', '.') }}
                            </td>
                            <td class="action-buttons">
                                {{-- TOMBOL SELESAIKAN (KONFIRMASI) --}}
                                <form action="{{ route('admin.pustakawan.transaksi.selesaikan', $trx) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm" title="Selesaikan">
                                        <i class="fa fa-check-double"></i> Selesaikan
                                    </button>
                                </form>

                                {{-- TOMBOL GAGAL KEMBALI (TOLAK) --}}
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tolakModal{{ $trx->id }}">
                                    <i class="fa fa-times"></i> Tolak
                                </button>

                            </td>
                        </tr>

                        <div class="modal fade" id="tolakModal{{ $trx->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">

                                    <form action="{{ route('admin.pustakawan.transaksi.gagalKembali', $trx) }}"
                                        method="POST">
                                        @csrf

                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                Tolak Pengembalian
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <p>
                                                Berikan <strong>alasan penolakan</strong> untuk:
                                            </p>

                                            <ul class="small text-muted">
                                                <li>Siswa: <strong>{{ $trx->user->name }}</strong></li>
                                                <li>Buku: <strong>{{ $trx->itemable->judul_buku }}</strong></li>
                                            </ul>

                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">
                                                    Catatan Penolakan <span class="text-danger">*</span>
                                                </label>
                                                <textarea name="catatan" class="form-control" rows="4"
                                                    placeholder="Contoh: Buku rusak, halaman hilang, atau tidak sesuai kondisi..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fa fa-times"></i> Tolak Pengembalian
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada transaksi menunggu pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
