@extends('layouts.app')

@section('title', 'Edit Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold mb-4">Edit Peminjaman</h3>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Edit Transaksi: {{ $peminjamans->kode_transaksi }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('peminjaman.update', $peminjamans->id) }}" method="POST">
                            @csrf @method('PUT')

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Pinjam</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" name="tgl_pinjam" id="tgl_pinjam" class="form-control"
                                            value="{{ \Carbon\Carbon::parse($peminjamans->tgl_pinjam)->format('Y-m-d') }}" />
                                    </div>
                                    @error('tgl_pinjam') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tanggal Harus Kembali</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <input type="date" id="tgl_harus_kembali" class="form-control bg-light"
                                            value="{{ \Carbon\Carbon::parse($peminjamans->tgl_harus_kembali)->format('Y-m-d') }}"
                                            readonly />
                                    </div>
                                    <small class="text-muted">*Otomatis bertambah 7 hari dari tanggal
                                        pinjam.</small>
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

    <script>
        document.getElementById('tgl_pinjam').addEventListener('change', function () {
            let tglPinjam = new Date(this.value);
            if (!isNaN(tglPinjam.getTime())) {
                tglPinjam.setDate(tglPinjam.getDate() + 7);
                let yyyy = tglPinjam.getFullYear();
                let mm = String(tglPinjam.getMonth() + 1).padStart(2, '0');
                let dd = String(tglPinjam.getDate()).padStart(2, '0');
                document.getElementById('tgl_harus_kembali').value = yyyy + '-' + mm + '-' + dd;
            }
        });
    </script>
@endsection