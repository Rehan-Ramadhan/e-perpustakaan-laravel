@extends('admin.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Peminjaman</h2>
            <p class="text-muted mb-0">Informasi transaksi</p>
        </div>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <label class="form-label text-muted">Peminjam</label>
                <div class="form-control bg-light">{{ $peminjamans->user->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Buku</label>
                <div class="form-control bg-light">{{ $peminjamans->buku->nama }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Tanggal Pinjam</label>
                <div class="form-control bg-light">
                    {{ \Carbon\Carbon::parse($peminjamans->tanggal_pinjam)->format('d F Y') }}
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Jatuh Tempo</label>
                <div class="form-control bg-light">
                    {{ \Carbon\Carbon::parse($peminjamans->tanggal_jatuh_tempo)->format('d F Y') }}
                </div>
            </div>

        </div>
    </div>
@endsection