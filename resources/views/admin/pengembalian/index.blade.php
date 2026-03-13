@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(session('success'))
            <div class="alert alert-{{ session('alert-type', 'success') }} alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-0">Daftar Pengembalian</h2>
            <a href="{{ route('pengembalian.create') }}" class="btn btn-primary">Tambah Pengembalian</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode Pinjam</th>
                            <th>Peminjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Denda</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($pengembalians as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->peminjaman->kode_transaksi }}</td>
                                <td>{{ $data->peminjaman->pengguna->nama }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->tgl_kembali_aktual)->translatedFormat('d/m/Y') }}</td>
                                <td>Rp {{ number_format($data->denda, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('pengembalian.destroy', $data->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus data pengembalian ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('pengembalian.show', $data->id) }}"
                                                class="btn btn-sm btn-info text-white"><i class="bx bx-show me-1"></i></a>
                                            <a href="{{ route('pengembalian.edit', $data->id) }}"
                                                class="btn btn-sm btn-outline-warning"><i class="bx bx-edit me-1"></i></a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                    class="bx bx-trash me-1"></i></button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data pengembalian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection