@extends('admin.app')

@section('title', 'Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Kategori</h2>
            <p class="text-muted mb-0">Daftar Kategori</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th class="text-center">Total Buku</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($kategoris as $kategori)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td class="text-center">{{ $kategori->bukus_count }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-{{ $kategori->is_active ? 'success' : 'secondary' }}">
                                    {{ $kategori->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="{{ route('admin.kategori.show', $kategori) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.kategori.edit', $kategori) }}"
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
                            <td colspan="5" class="text-center py-4">Belum ada data kategori.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $kategoris->links() }}
    </div>
@endsection