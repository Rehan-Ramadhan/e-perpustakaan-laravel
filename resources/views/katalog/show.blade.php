@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}">Katalog</a></li>
                <li class="breadcrumb-item active">{{ $buku->judul }}</li>
            </ol>
        </nav>

        <div class="row">
            {{-- Cover Buku --}}
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <img src="{{ $buku->image_url }}" class="img-fluid" alt="{{ $buku->judul }}">
                </div>
            </div>

            {{-- Info Buku --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <span class="badge bg-light text-primary mb-2">{{ $buku->kategori->nama }}</span>
                        <h2 class="fw-bold mb-1">{{ $buku->judul }}</h2>
                        <p class="fs-5 text-muted mb-4">Penulis: {{ $buku->penulis }}</p>

                        <div class="d-flex align-items-center gap-3 mb-4">
                            <div class="bg-light p-3 rounded-4 text-center" style="min-width: 100px;">
                                <small class="d-block text-muted">Stok</small>
                                <span class="fw-bold fs-5">{{ $buku->stok }}</span>
                            </div>
                            <div class="bg-light p-3 rounded-4 text-center" style="min-width: 100px;">
                                <small class="d-block text-muted">Tahun</small>
                                <span class="fw-bold fs-5">{{ $buku->tahun_terbit ?? '-' }}</span>
                            </div>
                        </div>

                        <h6 class="fw-bold">Sinopsis / Deskripsi</h6>
                        <p class="text-muted leading-relaxed">
                            {{ $buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.' }}
                        </p>

                        <hr class="my-4">

                        <form action="{{ route('keranjang.store') }}" method="POST" class="mb-4">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                            
                            <input type="hidden" name="jumlah" value="1">

                            <div class="row g-3">
                                <div class="col">
                                    <button type="submit" class="btn btn-dark btn-lg w-100 rounded-pill"
                                            @if($buku->stok <= 0) disabled @endif>
                                        <i class="bi bi-cart-plus me-2"></i>
                                        @if($buku->stok > 0)
                                            Tambah ke Daftar Pinjam
                                        @else
                                            Stok Sedang Kosong
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection