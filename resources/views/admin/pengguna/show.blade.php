@extends('layouts.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Lihat Data Pengguna</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">

                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $penggunas->nik }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $penggunas->nama }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span
                                        class="form-control bg-light">{{ $penggunas->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Telepon</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $penggunas->telepon }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="form-control bg-light">{{ $penggunas->alamat }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-6 d-grid">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                            </div>
                            <div class="col-sm-6 d-grid">
                                <a href="{{ route('pengguna.edit', $penggunas->id) }}"
                                    class="btn btn-warning text-white">Edit
                                    Data?</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection