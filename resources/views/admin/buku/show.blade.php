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

                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kode / Judul</label>
                            <div class="col-sm-10">
                                <span class="form-control bg-light"><strong>{{ $bukus->kode_buku }}</strong> -
                                    {{ $bukus->judul }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Pengarang</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $bukus->pengarang }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Penerbit</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $bukus->penerbit }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tahun Terbit</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $bukus->tahun_terbit }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Stok</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $bukus->stok }} Eksemplar</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Rak Lokasi</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $bukus->rak_lokasi }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 d-grid">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('buku.edit', $bukus->id) }}" class="btn btn-warning">Edit Data?</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection