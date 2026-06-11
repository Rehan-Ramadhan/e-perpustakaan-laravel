@extends('admin.app')

@section('title', 'Detail Pengembalian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Pengembalian</h2>
            <p class="text-muted mb-0">Informasi lengkap pengembalian buku.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary">Kembali</a>
            {{-- <a href="{{ route('admin.pengembalian.edit', $pengembalian) }}" class="btn btn-warning">
                Edit Pengembalian
            </a> --}}
        </div>
    </div>

    <div class="row g-4">

        <div class="col-lg-8">
            <div class="card h-100">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">
                        {{ $pengembalian->peminjaman->nomor_peminjaman }}
                    </h5>
                </div>
                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted">Nama Peminjam</label>
                            <div class="form-control bg-light">
                                {{ $pengembalian->peminjaman->user->name }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Buku</label>
                            <div class="form-control bg-light">
                                {{ $pengembalian->peminjaman->buku->nama }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Tanggal Kembali</label>
                            <div class="form-control bg-light">
                                {{ $pengembalian->tanggal_kembali->format('d F Y') }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">Keterlambatan</label>
                            <div class="form-control bg-light">
                                {{ $pengembalian->terlambat_hari }} hari
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label text-muted">Denda</label>
                            <div class="form-control bg-light">
                                Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-bottom">
                    <h5 class="mb-0">
                        Status Denda
                        <span class="badge bg-label-{{ $pengembalian->denda_dibayar ? 'success' : 'warning' }}">
                            {{ $pengembalian->denda_dibayar ? 'Lunas' : 'Belum Dibayar' }}
                        </span>
                    </h5>
                </div>

                <div class="card-body">
                    <p>
                        <strong>Nominal:</strong><br>
                        Rp {{ number_format($pengembalian->denda, 0, ',', '.') }}
                    </p>

                    <form action="{{ route('admin.pengembalian.destroy', $pengembalian) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus pengembalian ini?')">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-outline-danger w-100">
                            Hapus Pengembalian
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection