@extends('layouts.app')

@section('title', 'Detail Pengembalian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Tabel /</span> Detail Pengembalian
        </h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kode Transaksi</label>
                            <div class="col-sm-10">
                                <span
                                    class="form-control bg-light"><strong>{{ $pengembalians->peminjaman->kode_transaksi }}</strong></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Peminjam</label>
                            <div class="col-sm-10">
                                <span class="form-control bg-light">{{ $pengembalians->peminjaman->pengguna->nama }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tanggal Kembali</label>
                            <div class="col-sm-10">
                                <span
                                    class="form-control bg-light">{{ \Carbon\Carbon::parse($pengembalians->tgl_kembali_aktual)->translatedFormat('l, d F Y') }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Denda Terbayar</label>
                            <div class="col-sm-10">
                                <span class="form-control bg-light">Rp
                                    {{ number_format($pengembalians->denda, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Buku yang Dikembalikan</label>
                            <div class="col-sm-10">
                                <ul class="list-group">
                                    @foreach($pengembalians->peminjaman->peminjamanDetail as $detail)
                                        <li class="list-group-item bg-light border-0 mb-1">
                                            <i class="bx bx-book-bookmark me-2"></i> {{ $detail->buku->judul }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="row justify-content-end mt-4">
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('pengembalian.edit', $pengembalians->id) }}" class="btn btn-warning">Edit
                                    Data?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsectione