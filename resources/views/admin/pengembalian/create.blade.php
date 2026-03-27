@extends('admin.app')

@section('title', 'Tambah Pengembalian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Pengembalian</h2>
            <p class="text-muted mb-0">Proses pengembalian buku oleh anggota.</p>
        </div>
        <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Pengembalian</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengembalian.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nomor Peminjaman</label>
                    <select name="peminjaman_id" class="form-select @error('peminjaman_id') is-invalid @enderror">
                        <option value="">Pilih peminjaman</option>
                        @foreach ($peminjamans as $pinjam)
                            <option value="{{ $pinjam->id }}">
                                {{ $pinjam->nomor_peminjaman }} - {{ $pinjam->user->name }} | {{ $pinjam->buku->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('peminjaman_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text text-danger">* Denda otomatis Rp 1.000/hari.</div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button class="btn btn-primary">Konfirmasi Pengembalian</button>
                </div>
            </form>
        </div>
    </div>
@endsection