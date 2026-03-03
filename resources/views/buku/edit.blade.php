@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Edit Data Buku: {{ $buku->kode_buku }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buku.update', $buku->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kode Buku</label>
                                    <input type="text" name="kode_buku" class="form-control bg-light"
                                        value="{{ $buku->kode_buku }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Judul Buku</label>
                                    <input type="text" name="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul', $buku->judul) }}">
                                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Pengarang</label>
                                    <input type="text" name="pengarang"
                                        class="form-control @error('pengarang') is-invalid @enderror"
                                        value="{{ old('pengarang', $buku->pengarang) }}">
                                    @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Penerbit</label>
                                    <input type="text" name="penerbit"
                                        class="form-control @error('penerbit') is-invalid @enderror"
                                        value="{{ old('penerbit', $buku->penerbit) }}">
                                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="number" name="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', $buku->tahun) }}">
                                    @error('tahun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stok"
                                        class="form-control @error('stok') is-invalid @enderror"
                                        value="{{ old('stok', $buku->stok) }}">
                                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Rak Lokasi</label>
                                    <input type="text" name="rak_lokasi"
                                        class="form-control @error('rak_lokasi') is-invalid @enderror"
                                        value="{{ old('rak_lokasi', $buku->rak_lokasi) }}">
                                    @error('rak_lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-warning px-4 text-white">Update Data</button>
                                <a href="{{ route('buku.index') }}" class="btn btn-light px-4">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection