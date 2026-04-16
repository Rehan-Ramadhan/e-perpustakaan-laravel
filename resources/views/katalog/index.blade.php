@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white fw-bold border-0 pt-3">Filter Buku</div>
                    <div class="card-body">
                        <form action="{{ route('katalog.index') }}" method="GET">
                            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Kategori</h6>
                                @foreach($categories as $cat)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}"
                                            id="cat-{{ $cat->id }}" {{ request('category') == $cat->slug ? 'checked' : '' }}
                                            onchange="this.form.submit()">
                                        <label class="form-check-label" for="cat-{{ $cat->id }}">
                                            {{ $cat->nama }} <small class="text-muted">({{ $cat->bukus_count }})</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-dark w-100 rounded-pill btn-sm">Terapkan</button>
                            <a href="{{ route('katalog.index') }}"
                                class="btn btn-outline-secondary w-100 rounded-pill btn-sm mt-2">Reset</a>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold m-0">Koleksi Perpustakaan</h4>
                    <form method="GET" class="d-inline-block">
                        <select name="sort" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z (Judul)
                            </option>
                            <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A (Judul)
                            </option>
                        </select>
                    </form>
                </div>

                <div class="row g-4">
                    @forelse($bukus as $buku)
                        <div class="col-md-4 col-sm-6">
                            @include('bagian.buku-card', ['buku' => $buku])
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h5>Buku tidak ditemukan</h5>
                            <p class="text-muted">Coba gunakan kata kunci atau kategori lain.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $bukus->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection