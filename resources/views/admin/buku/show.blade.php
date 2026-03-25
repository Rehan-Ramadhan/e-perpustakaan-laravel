@extends('admin.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Detail Buku</h4>
            <p class="text-muted mb-0">Informasi lengkap buku untuk kebutuhan administrasi perpustakaan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-primary">Edit Buku</a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">{{ $buku->nama }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Kode Buku</label>
                            <div class="form-control bg-light">{{ $buku->kode_buku }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Kategori</label>
                            <div class="form-control bg-light">{{ $buku->kategori->nama ?? '-' }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Pengarang</label>
                            <div class="form-control bg-light">{{ $buku->pengarang }}</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Penerbit</label>
                            <div class="form-control bg-light">{{ $buku->penerbit }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Tahun Terbit</label>
                            <div class="form-control bg-light">{{ $buku->tahun_terbit }}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Stok</label>
                            <div class="form-control bg-light">{{ $buku->stok }} eksemplar</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted">Lokasi Rak</label>
                            <div class="form-control bg-light">{{ $buku->lokasi_rak }}</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Deskripsi</label>
                            <div class="form-control bg-light" style="min-height: 120px;">{{ $buku->deskripsi ?: 'Belum ada deskripsi.' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">Status Buku &nbsp; <span class="badge bg-label-{{ $buku->status_color }} fs-6">{{ $buku->status_label }}</span></h5>
                </div>
                <div class="card-body">
                    <div class="mb-2"></div>
                    <p class="mb-2"><strong>Visibilitas:</strong> {{ $buku->is_active ? 'Aktif di katalog' : 'Disembunyikan' }}</p>
                    <p><strong>Slug:</strong> {{ $buku->slug }}</p>

                    <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">Hapus Buku</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
