@extends('layouts.app')

@section('title', 'Perpanjang Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tabel /</span> Edit Peminjaman</h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Transaksi: {{ $peminjaman->kode_transaksi }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">
                            @csrf @method('PUT')
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal harus kembali</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" name="tgl_harus_kembali" class="form-control"
                                            value="{{ $peminjaman->tgl_harus_kembali }}" />
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
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