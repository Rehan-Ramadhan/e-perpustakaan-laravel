@extends('admin.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Peminjaman</h2>
            <p class="text-muted mb-0">Perpanjang masa pinjam</p>
        </div>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.peminjaman.update', $peminjamans) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam"
                        class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                        value="{{ old('tanggal_pinjam', \Carbon\Carbon::parse($peminjamans->tanggal_pinjam)->format('Y-m-d')) }}">

                    @error('tanggal_pinjam')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
@endsection