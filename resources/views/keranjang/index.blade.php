@extends('layouts.app')

@section('title', 'Daftar Pinjaman Buku')

@section('content')
    <div class="container py-5">
        <div class="row">
            {{-- Bagian Kiri: Tabel Daftar Buku --}}
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-4">
                    <i class="bi bi-book-half fs-2 text-primary me-3"></i>
                    <h2 class="fw-bold mb-0">Daftar Pinjaman</h2>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3">Buku</th>
                                        <th class="text-center py-3">Jumlah</th>
                                        <th class="text-end pe-4 py-3">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->buku->gambarBukus->first() ? asset('storage/' . $item->buku->gambarBukus->first()->lokasi_gambar) : asset('pengguna/images/no-cover.png') }}"
                                                        class="rounded shadow-sm me-3" width="60" height="80"
                                                        style="object-fit: cover;">
                                                    <div>
                                                        <div class="fw-bold text-dark">{{ Str::limit($item->buku->nama, 40) }}
                                                        </div>
                                                        <div class="small text-muted">{{ $item->buku->pengarang }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST"
                                                    class="mx-auto" style="width: 80px;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1"
                                                        class="form-control form-control-sm text-center fw-bold"
                                                        onchange="this.form.submit()">
                                                </form>
                                            </td>
                                            <td class="text-end pe-4 py-3">
                                                <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0"
                                                        onclick="return confirm('Hapus buku ini dari daftar?')">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-5">
                                                <div class="text-muted">
                                                    <i class="bi bi-cart-x display-4"></i>
                                                    <p class="mt-3">Belum ada buku yang dipilih untuk dipinjam.</p>
                                                    <a href="{{ url('/') }}"
                                                        class="btn btn-primary btn-sm rounded-pill px-4">Cari Buku</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Ringkasan --}}
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 2rem;">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="fw-bold mb-0">Ringkasan Pinjaman</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Total Buku</span>
                            <span class="fw-bold fs-5 text-primary">{{ $totalBuku }} Eksemplar</span>
                        </div>
                        <hr class="text-muted opacity-25">
                        <div class="alert alert-warning border-0 small mb-4">
                            Batas waktu peminjaman adalah 7 hari sejak tanggal pengambilan.
                        </div>

                        <button class="btn btn-dark w-100 py-2 rounded-pill fw-bold mb-2 shadow-sm" {{ $items->isEmpty() ? 'disabled' : '' }}>
                            Konfirmasi Peminjaman
                        </button>

                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 py-2 rounded-pill border-0 small">
                            <i class="bi bi-arrow-left me-1"></i> Kembali Cari Buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection