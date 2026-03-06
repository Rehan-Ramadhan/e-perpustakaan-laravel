@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(session('success'))
            <div class="alert alert-{{ session('alert-type', 'light') }} alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Peminjaman</h2>
            <a href="{{ route('peminjaman.create') }}" class="btn btn-primary">Tambah Transaksi</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Peminjam</th>
                                <th>Buku Dipinjam</th>
                                <th>Tanggal Harus Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($peminjamans as $peminjaman)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $peminjaman->pengguna->nama }}</td>
                                    <td>
                                        @foreach($peminjaman->peminjamanDetail as $detail)
                                            <li class="list-group-item bg-light border-0 mb-1">
                                                {{ $detail->buku->judul }}
                                            </li>
                                        @endforeach
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_harus_kembali)->format('d/m/Y') }}</td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $peminjaman->status == 'pinjam' ? 'primary' : 'success' }}">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('peminjaman.show', $peminjaman->id) }}"
                                                    class="btn btn-sm btn-info text-white"><i class="bx bx-show me-1"></i></a>
                                                <a href="{{ route('peminjaman.edit', $peminjaman->id) }}"
                                                    class="btn btn-sm btn-outline-warning"><i class="bx bx-edit me-1"></i></a>
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                        class="bx bx-trash me-1"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection