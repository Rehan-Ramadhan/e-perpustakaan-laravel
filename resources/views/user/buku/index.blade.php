@extends('layouts.app')

@section('title', 'Katalog')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-primary fw-bold">Koleksi Buku Perpustakaan</h2>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm mb-4">
                    <a href="{{ route('pengguna.buku.index') }}"
                        class="list-group-item list-group-item-action {{ !request('kategori') ? 'active' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach($kategoris as $kat)
                        <a href="{{ route('pengguna.buku.index', ['kategori' => $kat->slug]) }}"
                            class="list-group-item list-group-item-action {{ request('kategori') == $kat->slug ? 'active' : '' }}">
                            {{ $kat->nama }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-md-9">
                <div class="row">
                    @forelse($bukus as $buku)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <div class="card-body">
                                    <span class="badge bg-info text-dark mb-2">{{ $buku->kategori->nama }}</span>
                                    <h5 class="card-title fw-bold text-truncate">{{ $buku->nama }}</h5>
                                    <p class="card-text text-muted small">Penulis: {{ $buku->pengarang }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-{{ $buku->stok > 0 ? 'success' : 'danger' }} fw-bold">
                                            Stok: {{ $buku->stok }}
                                        </span>
                                        <a href="{{ route('pengguna.buku.show', $buku->slug) }}"
                                            class="btn btn-sm btn-outline-primary">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <p class="text-muted">Maaf, koleksi buku belum tersedia.</p>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $bukus->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection