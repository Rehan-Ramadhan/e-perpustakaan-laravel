@extends('layouts.app')

@section('title', 'Lihat Detail Buku')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Tabel /</span> Lihat Data Buku
        </h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Lihat Data</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Judul Buku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-book"></i></span>
                                    <span class="form-control bg-light">{{ $buku->judul }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kode Buku</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                    <span class="form-control bg-light">{{ $buku->kode_buku }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Pengarang</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <span class="form-control bg-light">{{ $buku->pengarang }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-archive"></i></span>
                                    <span class="form-control bg-light">{{ $buku->stok }} Eksemplar</span>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">Edit Data?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection