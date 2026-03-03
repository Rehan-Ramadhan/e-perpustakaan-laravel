@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Tabel /</span> Tambah Data Buku
        </h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Data</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buku.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kode_buku">Kode Buku</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                        <input type="text" class="form-control bg-light" id="kode_buku" name="kode_buku"
                                            value="{{ $otomatisKode }}" readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="judul">Judul Buku</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-book"></i></span>
                                        <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                            id="judul" name="judul" value="{{ old('judul') }}"
                                            placeholder="Contoh: Panduan Menulis Kode yang Rapi" />
                                    </div>
                                    @error('judul') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengarang">Pengarang</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control @error('pengarang') is-invalid @enderror"
                                            id="pengarang" name="pengarang" value="{{ old('pengarang') }}"
                                            placeholder="Contoh: Rehan Ramadhan" />
                                    </div>
                                    @error('pengarang') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="penerbit">Penerbit</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                        <input type="text" class="form-control @error('penerbit') is-invalid @enderror"
                                            id="penerbit" name="penerbit" value="{{ old('penerbit') }}"
                                            placeholder="Contoh: SMK Assalaam Bandung" />
                                    </div>
                                    @error('penerbit') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="tahun">Tahun Terbit</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                            id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}"
                                            placeholder="2024" />
                                    </div>
                                    @error('tahun') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="stok">Jumlah Stok</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-archive"></i></span>
                                        <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                            id="stok" name="stok" value="{{ old('stok', 1) }}"
                                            placeholder="Berapa banyak copy?" />
                                    </div>
                                    @error('stok') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="rak_lokasi">Rak Lokasi</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-map-pin"></i></span>
                                        <input type="text" class="form-control @error('rak_lokasi') is-invalid @enderror"
                                            id="rak_lokasi" name="rak_lokasi" value="{{ old('rak_lokasi') }}"
                                            placeholder="Contoh: A1" />
                                    </div>
                                    @error('rak_lokasi') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-6 d-grid">
                                    <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 d-grid">
                                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection