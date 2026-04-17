@extends('admin.app')

@section('title', 'Pengembalian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengembalian</h2>
            <p class="text-muted mb-0">Daftar Pengembalian</p>
        </div>
        <a href="{{ route('admin.pengembalian.create') }}" class="btn btn-primary">
            Tambah Pengembalian
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>No. Pinjam</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Tanggal Kembali</th>
                        <th class="text-center">Denda</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalians as $data)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $data->peminjaman->nomor_peminjaman }}</td>
                            <td>{{ $data->peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $data->peminjaman->buku->nama ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($data->tanggal_kembali)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="{{ $data->denda > 0 ? 'text-danger' : 'text-success' }}">
                                    Rp {{ number_format($data->denda, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.pengembalian.destroy', $data) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus pengembalian ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pengembalian.show', $data) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.pengembalian.edit', $data) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection