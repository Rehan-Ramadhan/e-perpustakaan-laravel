@extends('layouts.app')

@section('title', 'Detail Buku - ' . $buku->judul)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary">Informasi Detail Buku</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Kode Buku</div>
                            <div class="col-sm-8 text-primary fw-bold">: {{ $buku->kode_buku }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Judul Buku</div>
                            <div class="col-sm-8">: {{ $buku->judul }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Pengarang</div>
                            <div class="col-sm-8">: {{ $buku->pengarang }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Penerbit</div>
                            <div class="col-sm-8">: {{ $buku->penerbit }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Tahun Terbit</div>
                            <div class="col-sm-8">: {{ $buku->tahun }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Stok Tersedia</div>
                            <div class="col-sm-8">
                                : <span class="badge {{ $buku->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $buku->stok }} Eksemplar
                                </span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-4 fw-boldx">Lokasi Rak</div>
                            <div class="col-sm-8">: {{ $buku->rak_lokasi ?? 'Belum ditentukan' }}</div>
                        </div>
                        <hr>
                        <div class="mt-4 d-flex gap-2">
                            <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning text-white px-4">
                                Edit Data
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection