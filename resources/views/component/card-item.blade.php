{{-- 
  Ini adalah file "Komponen" untuk satu kartu item (Buku atau Alat).
  File ini akan di-@include berkali-kali di dalam loop.
  
  File ini menerima variabel seperti:
  - $imageUrl : URL gambar sampul
  - $title     : Judul buku/alat
  - $rating    : Rating bintang (angka 0-5)
--}}
<div class="card h-100" style="border: none; border-radius: 10px; overflow: hidden;">
    {{-- Gambar Item. '??' adalah operator default jika variabel tidak ada --}}
    <img src="{{ $imageUrl ?? 'https://via.placeholder.com/150x220' }}" class="card-img-top" alt="{{ $title ?? 'Item Cover' }}" style="height: 220px; object-fit: cover;">
    
    <div class="card-body text-center p-2">
        {{-- Judul Item --}}
        <h6 class="card-title" style="font-weight: 600; font-size: 0.9rem; margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $title ?? 'Judul Item' }}
        </h6>
        
        {{-- Rating Bintang --}}
        <div class="rating" style="color: #F8D442; font-size: 1.1rem;">
            @php $rate = $rating ?? 0; @endphp
            {{-- Loop untuk Bintang Terisi --}}
            @for ($i = 0; $i < $rate; $i++)
                <span>★</span>
            @endfor
            {{-- Loop untuk Bintang Kosong --}}
            @for ($i = 0; $i < (5 - $rate); $i++)
                <span style="color: #ccc;">★</span>
            @endfor
        </div>
    </div>
</div>