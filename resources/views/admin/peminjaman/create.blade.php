@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Tambah Peminjaman</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Form Transaksi</h5>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="pengguna_id">Peminjam</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select name="pengguna_id"
                                            class="form-select @error('pengguna_id') is-invalid @enderror">
                                            <option value="">Pilih Anggota</option>
                                            @foreach($penggunas as $user)
                                                <option value="{{ $user->id }}">{{ $user->nik }} - {{ $user->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('pengguna_id') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="buku_ids">Pilih Buku</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <select name="buku_ids[]"
                                            class="form-select @error('buku_ids') is-invalid @enderror" multiple size="6">
                                            @foreach($bukus as $buku)
                                                <option value="{{ $buku->id }}">{{ $buku->judul }} (Stok: {{ $buku->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p>@error('buku_ids') <small class="text-danger">{{ $message }}</small> @enderror</p>
                                    <small class="text-muted">Shift + Klik untuk pilih lebih dari satu buku.</small>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-6 d-grid">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 d-grid">
                                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection