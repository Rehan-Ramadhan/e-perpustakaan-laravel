@props(['buku', 'display' => 'grid'])

@if ($display === 'list')
    <div class="card mb-3 p-3 rounded-4 shadow-sm border-0 position-relative">
        <div class="row g-0 align-items-center">
            <div class="col-4 col-md-3">
                <img src="{{ $buku->cover_url }}" class="img-fluid rounded-3"
                    style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $buku->nama }}">
            </div>
            <div class="col-8 col-md-9">
                <div class="card-body py-0">
                    <small class="text-primary fw-bold">{{ $buku->kategori->nama ?? 'Umum' }}</small>
                    <h5 class="card-title my-1">
                        <a href="{{ route('katalog.show', $buku->slug) }}"
                            class="text-decoration-none text-dark stretched-link">
                            {{ Str::limit($buku->nama, 40) }}
                        </a>
                    </h5>
                    <p class="text-muted small mb-0">{{ $buku->pengarang }}</p>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="product-item swiper-slide card h-100 border-0 shadow-sm p-3 rounded-4 position-relative">
        <div class="position-absolute top-0 start-0 m-3" style="z-index: 2;">
            @if ($buku->stok <= 0)
                <span class="badge bg-danger">Habis</span>
            @elseif($buku->is_featured)
                <span class="badge bg-success">Unggulan</span>
            @endif
        </div>

        <figure class="mb-3">
            <img src="{{ $buku->cover_url }}" class="rounded-4 w-100" style="height: 280px; object-fit: cover;"
                alt="{{ $buku->nama }}">
        </figure>

        <div class="d-flex flex-column h-100">
            <small class="text-muted">{{ $buku->kategori->nama ?? 'Umum' }}</small>
            <h3 class="h6 fw-bold mt-1">
                <a href="{{ route('katalog.show', $buku->slug) }}" class="text-decoration-none text-dark stretched-link">
                    {{ Str::limit($buku->nama, 35) }}
                </a>
            </h3>

            <div class="mt-auto">
                <div class="d-flex align-items-center justify-content-between position-relative" style="z-index: 3;">
                    <span class="badge border text-dark fw-light">Stok: {{ $buku->stok }}</span>

                    <form action="{{ route('keranjang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                        <button type="submit" class="btn btn-link p-0 text-primary fw-bold text-decoration-none"
                            @if($buku->stok <= 0) disabled @endif>
                            Pinjam <iconify-icon icon="uil:shopping-cart"></iconify-icon>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif