{{-- Menggunakan layout 'admin' sebagai kerangka --}}
@extends('layouts.admin')

{{-- Mengatur judul halaman --}}
@section('title', 'Edit Alat Lab')

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
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
    }
    .btn-simpan {
        background-color: #25256C;
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
    .current-image {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
    
    {{-- Header Konten (Judul & Breadcrumb) --}}
    <h2 class="page-title mb-4">
        <a href="{{ route('laboran.alat.index') }}" class="breadcrumb-link">Labotarium</a> > Edit Alat Lab
    </h2>

    {{-- Kartu Konten Utama (Form) --}}
    <div class="form-card">
        
        {{-- 
          Form mengarah ke route 'update' dan menggunakan method PUT.
          Variabel $alat harus Anda kirim dari Controller.
        --}}
        <form action="{{ route('laboran.alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') {{-- Method spoofing untuk update --}}

            <div class="row g-4">
                
                {{-- Kolom Kiri Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="nama_alat" class="form-label">Nama Alat</label>
                        {{-- 'value' diisi dengan data lama dari $alat --}}
                        <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="Masukan Nama Alat" value="{{ old('nama_alat', $alat->nama_alat) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="id_alat" class="form-label">ID Alat</label>
                        <input type="text" class="form-control" id="id_alat" name="id_alat" placeholder="Masukan ID Alat" value="{{ old('id_alat', $alat->id_alat) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="stok" class="form-label">Stok Alat</label>
                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukan Stok Alat" value="{{ old('stok', $alat->stok) }}" required>
                    </div>
                </div>

                {{-- Kolom Kanan Form --}}
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label for="kualitas" class="form-label">Kualitas Alat</label>
                        <select class="form-select" id="kualitas" name="kualitas" required>
                            <option value="" disabled>Masukan Kualitas Alat</option>
                            {{-- old() akan prioritas, diikuti data dari database --}}
                            <option value="Sangat Baik" {{ old('kualitas', $alat->kualitas) == 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                            <option value="Baik" {{ old('kualitas', $alat->kualitas) == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Buruk" {{ old('kualitas', $alat->kualitas) == 'Buruk' ? 'selected' : '' }}>Buruk</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="gambar" class="form-label">Upload File (Ganti)</label>
                        <input type="file" class="form-control" id="gambar" name="gambar">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        
                        {{-- Menampilkan gambar saat ini jika ada --}}
                        @if ($alat->gambar)
                            <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="current-image">
                        @endif
                    </div>
                </div>

                {{-- Bagian Bawah Form (Deskripsi) --}}
                <div class="col-12">
                     <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Alat</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukan Deskripsi Alat">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="action-buttons">
                <a href="{{ route('laboran.alat.index') }}" class="btn btn-kembali">Kembali</a>
                <button type="submit" class="btn btn-simpan">Simpan Perubahan</button>
            </div>

        </form>
    </div>
@endsection