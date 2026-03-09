@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Tambah Data Pengguna</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Tambah Data</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengguna.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nik">NIK Otomatis</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control bg-light" id="nik" name="nik"
                                            value="{{ $otomatisKode }}" readonly />
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="nama">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama') }}"
                                            placeholder="Contoh: Rehan Ramadhan" />
                                    </div>
                                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select name="jenis_kelamin"
                                            class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                            </option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                            </option>
                                        </select>
                                    </div>
                                    @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="telepon">No. Telepon</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control @error('telepon') is-invalid @enderror"
                                            id="telepon" name="telepon" value="{{ old('telepon') }}"
                                            placeholder="Contoh: 08123456789" />
                                    </div>
                                    @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <textarea name="alamat" id="alamat"
                                            class="form-control @error('alamat') is-invalid @enderror"
                                            placeholder="Alamat lengkap..." rows="2">{{ old('alamat') }}</textarea>
                                    </div>
                                    @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-6 d-grid">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 d-grid">
                                    <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection