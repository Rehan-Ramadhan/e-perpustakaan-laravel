@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tabel /</span> Lihat Data Peminjaman</h4>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Kode / Peminjam</label>
                            <div class="col-sm-10">
                                <span class="form-control bg-light"><strong>{{ $peminjamans->kode_transaksi }}</strong> -
                                    {{ $peminjamans->pengguna->nama }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Buku yang Dipinjam</label>
                            <div class="col-sm-10">
                                <ul class="list-group">
                                    @foreach($peminjamans->peminjamanDetail as $detail)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $loop->iteration }}.{{ $detail->buku->judul }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tanggal Pinjam</label>
                            <div class="col-sm-10">
                                <span
                                    class="form-control bg-light">{{ \Carbon\Carbon::parse($peminjamans->tgl_pinjam)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tanggal Harus Kembali</label>
                            <div class="col-sm-10">
                                <span
                                    class="form-control bg-light">{{ \Carbon\Carbon::parse($peminjamans->tgl_harus_kembali)->format('d/m/Y') }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-10">
                                <span class="form-control bg-light">{{ ucfirst($peminjamans->status) }}</span>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 d-grid">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('peminjaman.edit', $peminjamans->id) }}" class="btn btn-warning">Edit
                                    Data?</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection