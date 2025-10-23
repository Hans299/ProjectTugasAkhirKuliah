{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Edit Buku')

@push('styles')
<style>
    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #333;
    }
    .page-title .breadcrumb-link {
        color: #6c757d;
        text-decoration: none;
    }
    .page-title .breadcrumb-link:hover {
        color: #333;
    }
    .form-card {
        border-radius: 12px;
        border: 2px solid #25256C; /* Border biru tua */
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 2.5rem;
        background-color: #fff;
    }
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        border: 1px solid #ced4da;
    }
    .form-control:focus, .form-select:focus {
        border-color: #25256C;
        box-shadow: 0 0 0 0.25rem rgba(37, 37, 108, 0.25);
    }
    textarea.form-control {
        min-height: 120px;
    }
    .btn-upload {
        background-color: #3B82F6;
        color: white;
        font-weight: 600;
    }
    .current-image {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-simpan {
        background-color: #3B82F6; /* Biru muda */
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border: none;
    }
    .btn-kembali {
        background-color: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border: 1px solid #ced4da;
    }
</style>
@endpush

{{-- Memulai bagian konten utama --}}
@section('content')
    
    {{-- Header Konten (Judul & Breadcrumb) --}}
    <h2 class="page-title mb-4">
        <a href="{{ route('pustakawan.buku.index') }}" class="breadcrumb-link">Perpustakaan</a> > Edit Buku
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- 
          Form mengarah ke route 'update' dan menggunakan method PUT.
          Variabel $buku harus Anda kirim dari Controller.
        --}}
        <form action="{{ route('pustakawan.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Method spoofing untuk update --}}

            <div class="row g-4">
                
                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="judul_buku" class="form-label">Judul Buku</label>
                        {{-- 'value' diisi dengan data lama dari $buku --}}
                        <input type="text" class="form-control" id="judul_buku" name="judul_buku" placeholder="Masukan Judul Buku" value="{{ old('judul_buku', $buku->judul_buku) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Masukan ISBN" value="{{ old('isbn', $buku->isbn) }}">
                    </div>

                    <div class="mb-3">
                        <label for="penerbit" class="form-label">Penerbit</label>
                        <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Masukan Penerbit" value="{{ old('penerbit', $buku->penerbit) }}">
                    </div>

                    <div class="mb-3">
                        <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                        <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" placeholder="Masukan Tahun Terbit (Contoh: 2024)" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                    </div>
                </div>

                {{-- Kolom Kanan Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Buku</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukan Stok Buku" value="{{ old('stok', $buku->stok) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis" placeholder="Masukan Penulis" value="{{ old('penulis', $buku->penulis) }}">
                    </div>

                    <div class="mb-3">
                        <label for="halaman" class="form-label">Halaman</label>
                        <input type="number" class="form-control" id="halaman" name="halaman" placeholder="Masukan Halaman" value="{{ old('halaman', $buku->halaman) }}">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="" disabled>Pilih Kategori</option>
                            {{-- old() akan prioritas, diikuti data dari database --}}
                            <option value="Buku Umum" {{ old('kategori', $buku->kategori) == 'Buku Umum' ? 'selected' : '' }}>Buku Umum</option>
                            <option value="Buku Mata Pelajaran" {{ old('kategori', $buku->kategori) == 'Buku Mata Pelajaran' ? 'selected' : '' }}>Buku Mata Pelajaran</option>
                        </select>
                    </div>
                </div>

                {{-- Bagian Bawah Form (Deskripsi & Upload) --}}
                <div class="col-12">
                     <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Buku</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukan Deskripsi Buku">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="col-12">
                    <label for="gambar" class="form-label">Upload File (Ganti)</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <label class="input-group-text btn-upload" for="gambar">Upload File</label>
                    </div>
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                    
                    {{-- Menampilkan gambar saat ini jika ada --}}
                    @if ($buku->gambar)
                        <img src="{{ asset('storage/' . $buku->gambar) }}" alt="{{ $buku->judul_buku }}" class="current-image">
                    @endif
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="action-buttons">
                <a href="{{ route('pustakawan.buku.index') }}" class="btn btn-kembali">Kembali</a>
                <button type="submit" class="btn btn-simpan">Simpan</button>
            </div>

        </form>
    </div>
@endsection