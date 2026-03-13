@extends('layouts.app')

@section('title', 'Proses Pengembalian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Tambah Data Pengembalian</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Proses Kembali</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pengembalian.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="peminjaman_id">Kode Transaksi</label>
                                <div class="col-sm-10">
                                    <select name="peminjaman_id" id="peminjaman_id"
                                        class="form-select @error('peminjaman_id') is-invalid @enderror">
                                        <option value="">Pilih Kode Pinjam / Anggota</option>
                                        @foreach(\App\Models\Peminjaman::where('status', 'pinjam')->get() as $pinjam)
                                            @php
                                                $tgl1 = \Carbon\Carbon::now()->startOfDay();
                                                $tgl2 = \Carbon\Carbon::parse($pinjam->tgl_harus_kembali)->startOfDay();
                                                $terlambat = $tgl1->diffInDays($tgl2, false);
                                            @endphp
                                            <option value="{{ $pinjam->id }}">
                                                {{ $pinjam->kode_transaksi }} - {{ $pinjam->pengguna->nama }}
                                                @if($terlambat < 0)
                                                    (Terlambat {{ abs((int) $terlambat) }} Hari!)
                                                @else
                                                    (Belum jatuh tempo)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('peminjaman_id') <small class="text-danger">{{ $message }}</small> @enderror
                                    <small class="text-danger">*Denda dihitung otomatis Rp1.000/hari.</small>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-6 d-grid">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                                </div>
                                <div class="col-sm-6 d-grid">
                                    <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection