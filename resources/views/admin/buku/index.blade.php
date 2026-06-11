@extends('admin.app')

@section('title', 'Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Buku</h2>
            <p class="text-muted mb-0">Daftar Buku</p>
        </div>
        <a href="{{ route('admin.buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center">Rak</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($bukus as $buku)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $buku->nama }}</td>
                            <td>{{ $buku->kategori->nama ?? '-' }}</td>
                            <td class="text-center">{{ $buku->stok }}</td>
                            <td class="text-center">{{ $buku->lokasi_rak }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-{{ $buku->status_color }}">{{ $buku->status_label }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.buku.destroy', $buku) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.buku.show', $buku) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.buku.edit', $buku) }}" class="btn btn-sm btn-outline-warning">
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
                            <td colspan="8" class="text-center py-4">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $bukus->links() }}
    </div>
@endsection