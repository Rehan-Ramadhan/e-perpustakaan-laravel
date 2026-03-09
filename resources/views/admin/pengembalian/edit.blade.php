@extends('layouts.app')

@section('title', 'Edit Pengembalian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Edit Data Pengembalian</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Transaksi: {{ $pengembalians->peminjaman->kode_transaksi }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengembalian.update', $pengembalians->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Nama Peminjam</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control bg-light"
                                        value="{{ $pengembalians->peminjaman->pengguna->nama }}" readonly />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Kembali</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control bg-light"
                                        value="{{ \Carbon\Carbon::parse($pengembalians->tgl_kembali_aktual)->translatedFormat('d F Y') }}"
                                        readonly />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="denda">Denda (Otomatis)</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control bg-light" id="denda" name="denda"
                                            value="{{ $pengembalians->denda }}" readonly />
                                    </div>
                                    <small class="text-danger">*Denda dihitung sistem, tidak dapat diubah manual.</small>
                                </div>
                            </div>

                            <div class="row justify-content-end mt-4">
                                <div class="col-sm-6 d-grid">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 d-grid">
                                    <button type="submit" class="btn btn-warning text-white">Update Data</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection