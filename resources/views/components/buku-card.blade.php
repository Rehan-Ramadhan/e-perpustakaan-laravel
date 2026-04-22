@props(['buku', 'display' => 'grid'])

@php
    $cover = $buku->gambarBukus->first();
    $path = $cover ? asset('storage/' . $cover->lokasi_gambar) : asset('pengguna/images/no-cover.png');
@endphp

@if ($display === 'list')

    <div class="card mb-3 p-3 rounded-4 shadow border-0">
        <a href="{{ route('katalog.show', $buku->slug) }}" class="nav-link">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ $path }}" class="img-fluid rounded" style="height: 100px; width: 100%; object-fit: cover;"
                        alt="{{ $buku->nama }}">
                </div>
                <div class="col-md-8">
                    <div class="card-body py-0">
                        <p class="text-muted mb-0">{{ $buku->pengarang }}</p>
                        <h5 class="card-title">{{ Str::limit($buku->nama, 25) }}</h5>
                    </div>
                </div>
            </div>
        </a>
    </div>
@else

    <div class="product-item swiper-slide">
        @if ($buku->stok <= 0)
            <span class="badge bg-danger position-absolute m-3">Habis</span>
        @elseif($buku->is_featured)
            <span class="badge bg-success position-absolute m-3">Unggulan</span>
        @endif

        <figure>
            <a href="{{ route('katalog.show', $buku->slug) }}" title="{{ $buku->nama }}">
                <img src="{{ $path }}" class="tab-image" style="height: 250px; object-fit: cover;">
            </a>
        </figure>

        <h3>{{ Str::limit($buku->nama, 35) }}</h3>
        <span class="qty">{{ $buku->penerbit }}</span>
        <span class="rating">
            <svg width="24" height="24" class="text-primary">
                <use xlink:href="#star-solid"></use>
            </svg> 5.0
        </span>
        <span class="price">{{ $buku->kategori->nama ?? 'Umum' }}</span>

        <div class="d-flex align-items-center justify-content-between">
            <div class="product-qty-info">
                <span class="badge border text-dark fw-light">Tersedia: {{ $buku->stok }}</span>
            </div>
            <form action="{{ route('keranjang.store') }}" method="POST">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                <button type="submit" class="nav-link fw-bold border-0 bg-transparent" @if($buku->stok <= 0) disabled @endif>
                    Pinjam <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                </button>
            </form>
        </div>
    </div>
@endif