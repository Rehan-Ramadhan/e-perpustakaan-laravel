@extends('layouts.app')

@section('title', 'Daftar Suka Saya')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0">Buku yang Saya Sukai</h3>
            <span class="badge bg-dark rounded-pill">{{ $bukus->total() }} Buku</span>
        </div>

        @if($bukus->count())
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($bukus as $buku)
                    <div class="col">
                        <x-buku-card :buku="$buku" />
                    </div>
                @endforeach
            </div>

            <div class="mt-5 d-flex justify-content-center">
                {{ $bukus->links() }}
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm border">
                <div class="mb-3">
                    <svg width="64" height="64" class="text-muted" style="fill: currentColor;">
                        <use xlink:href="#heart"></use>
                    </svg>
                </div>
                <h5 class="fw-bold">Belum Ada Buku Favorit</h5>
                <p class="text-muted">Jelajahi katalog dan klik ikon hati pada buku yang kamu suka.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-dark mt-2 px-4 rounded-pill">
                    Lihat Katalog
                </a>
            </div>
        @endif
    </div>
@endsection