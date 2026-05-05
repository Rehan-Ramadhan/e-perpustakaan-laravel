<div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="position-relative">
        <a href="{{ route('katalog.show', $buku->slug) }}">
            <img src="{{ $buku->cover_url }}" class="card-img-top" alt="{{ $buku->nama }}"
                style="height: 250px; object-fit: cover;">
        </a>

        <span class="badge bg-{{ $buku->status_color }} position-absolute top-0 end-0 m-2">
            {{ $buku->status_label }}
        </span>
    </div>

    <div class="card-body d-flex flex-column">
        <small class="text-primary fw-bold mb-1">{{ $buku->kategori->nama }}</small>
        <h6 class="card-title fw-bold mb-1">
            <a href="{{ route('katalog.show', $buku->slug) }}" class="text-decoration-none text-dark">
                {{ Str::limit($buku->nama, 40) }}
            </a>
        </h6>
        <p class="text-muted small mb-3">Oleh: {{ $buku->pengarang }}</p>

        <div class="mt-auto">
            <form action="{{ route('keranjang.store') }}" method="POST">
                @csrf
                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                <input type="hidden" name="jumlah" value="1">
                <button type="submit" class="btn btn-sm btn-dark w-100 rounded-pill" {{ $buku->stok <= 0 ? 'disabled' : '' }}>
                    <i class="bi bi-plus-circle me-1"></i>
                    {{ $buku->stok <= 0 ? 'Stok Habis' : 'Pinjam' }}
                </button>
            </form>
        </div>
    </div>
</div>