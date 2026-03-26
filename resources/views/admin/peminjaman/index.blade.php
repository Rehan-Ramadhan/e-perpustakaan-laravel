@extends('admin.app')

@section('title', 'Peminjaman')

@section('content')
    @if (session('success'))
        <div class="alert alert-{{ session('alert-type', 'light') }} alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Peminjaman</h2>
            <p class="text-muted mb-0">Daftar transaksi peminjaman</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Jatuh Tempo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->nama ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-{{ $peminjaman->status_color }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.peminjaman.show', $peminjaman) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection