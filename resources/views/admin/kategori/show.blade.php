@extends('admin.app')

@section('title', 'Detail Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Kategori</h2>
            <p class="text-muted mb-0">Informasi lengkap kategori untuk kebutuhan administrasi perpustakaan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="btn btn-warning">Edit Kategori</a>
        </div>
    </div>

    <div class="row g-4">
        {{-- LEFT --}}
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">{{ $kategori->nama }}</h5>
                </div>

                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Kategori</label>
                            <div class="form-control bg-light">
                                {{ $kategori->nama }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Jumlah Buku</label>
                            <div class="form-control bg-light">
                                {{ $kategori->bukus_count ?? $kategori->bukus()->count() }} buku
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted">Gambar Kategori</label>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($kategori->gambar)
                                    <img src="{{ $kategori->gambar_url }}" alt="gambar kategori"
                                        style="width: 140px; height: 140px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <p class="text-muted">Belum ada gambar.</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted">Deskripsi</label>
                            <div class="form-control bg-light" style="min-height: 120px;">
                                {{ $kategori->deskripsi ?: 'Belum ada deskripsi.' }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">
                        Status Kategori &nbsp;
                        <span class="badge bg-label-{{ $kategori->is_active ? 'success' : 'secondary' }} fs-6">
                            {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <p class="mb-2">
                        <strong>Visibilitas:</strong>
                        {{ $kategori->is_active ? 'Ditampilkan di katalog' : 'Disembunyikan' }}
                    </p>

                    <p>
                        <strong>Slug:</strong> {{ $kategori->slug }}
                    </p>

                    <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection