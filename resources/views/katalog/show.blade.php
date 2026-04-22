@extends('layouts.app')

@section('title', $buku->judul)

@section('content')
    @php
        $cover = $buku->gambarBukus->first();
        $path = $cover ? asset('storage/' . $cover->lokasi_gambar) : asset('pengguna/images/no-cover.png');
        $isFavorit = auth()->check() && auth()->user()->hasInKeinginan($buku);
    @endphp

    <div class="container py-4">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('katalog.index') }}" class="text-decoration-none">Katalog</a>
                </li>
                <li class="breadcrumb-item active">{{ Str::limit($buku->judul, 30) }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-light">
                    <img src="{{ $path }}" id="main-image" class="w-100" alt="{{ $buku->judul }}"
                        style="height: 600px; object-fit: cover;">

                    @if($buku->gambarBukus->count() > 1)
                        <div class="p-3 bg-white d-flex gap-2 overflow-auto border-top">
                            @foreach($buku->gambarBukus as $gambar)
                                <img src="{{ asset('storage/' . $gambar->lokasi_gambar) }}" class="rounded border cursor-pointer"
                                    style="width: 70px; height: 70px; object-fit: cover;"
                                    onclick="document.getElementById('main-image').src = this.src">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4 p-xl-5">
                        <div class="mb-3">
                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-2">
                                {{ $buku->kategori->nama }}
                            </span>
                            <h1 class="fw-bold display-6 mb-1">{{ $buku->judul }}</h1>
                            <p class="fs-5 text-muted">Karya: <span class="text-dark fw-medium">{{ $buku->penulis }}</span>
                            </p>
                        </div>

                        <div class="mb-4">
                            @if($buku->stok > 5)
                                <div class="text-success d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill me-2"></i> Tersedia (Stok: {{ $buku->stok }})
                                </div>
                            @elseif($buku->stok > 0)
                                <div class="text-warning d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Stok Terbatas (Sisa {{ $buku->stok }})
                                </div>
                            @else
                                <div class="text-danger d-flex align-items-center">
                                    <i class="bi bi-x-circle-fill me-2"></i> Stok Habis
                                </div>
                            @endif
                        </div>

                        <hr class="my-4 opacity-50">

                        <div class="mb-4" style="display: flex; flex-direction: column; gap: 10px;">

                            <form action="{{ route('keranjang.store') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="buku_id" value="{{ $buku->id }}">
                                <input type="hidden" name="jumlah" value="1">

                                <button type="submit" @if($buku->stok <= 0) disabled @endif
                                    style="width: 100%; padding: 10px; border-radius: 50px; border: none; background-color: #000; color: #fff; font-weight: bold; cursor: pointer;">
                                    {{ $buku->stok > 0 ? 'Tambah ke Daftar Pinjam' : 'Stok Habis' }}
                                </button>
                            </form>

                            @auth
                                @php $isFavorit = auth()->user()->hasInKeinginan($buku); @endphp
                                <button type="button" onclick="toggleWishlist({{ $buku->id }})"
                                    class="wishlist-btn-{{ $buku->id }}"
                                    style="width: 100%; padding: 10px; border-radius: 50px; border: 2px solid #dc3545; background-color: {{ $isFavorit ? '#dc3545' : 'transparent' }}; color: {{ $isFavorit ? '#fff' : '#dc3545' }}; font-weight: bold; cursor: pointer; transition: all 0.3s ease;">
                                    <span class="wishlist-text">
                                        {{ $isFavorit ? 'Hapus dari Daftar Suka' : 'Tambah ke Daftar Suka' }}
                                    </span>
                                </button>
                            @endauth
                        </div>

                        <div class="mt-5">
                            <h5 class="fw-bold border-start border-4 border-primary ps-3 mb-3">Sinopsis</h5>
                            <div class="text-muted lh-lg" style="text-align: justify;">
                                {!! nl2br(e($buku->deskripsi ?? 'Tidak ada deskripsi untuk buku ini.')) !!}
                            </div>
                        </div>

                        <div class="mt-4 pt-4 border-top">
                            <div class="row text-muted">
                                <div class="col-6">
                                    <small class="d-block text-uppercase ls-1">Tahun Terbit</small>
                                    <span class="fw-bold text-dark">{{ $buku->tahun_terbit ?? '-' }}</span>
                                </div>
                                <div class="col-6 text-end">
                                    <small class="d-block text-uppercase ls-1">Kategori</small>
                                    <span class="fw-bold text-dark">{{ $buku->kategori->nama }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection