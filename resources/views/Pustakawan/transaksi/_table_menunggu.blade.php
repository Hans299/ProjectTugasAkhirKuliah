<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Judul Buku</th>
                        <th>Tgl. Kembali</th>
                        <th>Bukti Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $trx)
                    <tr>
                        <td>{{ $trx->user->name }}</td>
                        <td>{{ $trx->itemable->judul }}</td>
                        <td>{{ $trx->tanggal_kembali->format('d M Y') }}</td>
                        <td>
                            @if($trx->foto_pengembalian)
                                {{-- Link untuk membuka foto di tab baru --}}
                                <a href="{{ Storage::url($trx->foto_pengembalian) }}" target="_blank">
                                    <img src="{{ Storage::url($trx->foto_pengembalian) }}" alt="Bukti" class="img-thumbnail-small">
                                </a>
                            @else
                                <span class="text-muted">Foto tidak ada</span>
                            @endif
                        </td>
                        <td class="action-buttons">
                            {{-- TOMBOL SELESAIKAN (KONFIRMASI FOTO) --}}
                            <form action="{{ route('admin.pustakawan.transaksi.selesaikan', $trx) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm" title="Selesaikan">
                                    <i class="fa fa-check-double"></i> Selesaikan
                                </button>
                            </form>

                            {{-- TOMBOL GAGAL KEMBALI (TOLAK FOTO) --}}
                            <form action="{{ route('admin.pustakawan.transaksi.gagalKembali', $trx) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="