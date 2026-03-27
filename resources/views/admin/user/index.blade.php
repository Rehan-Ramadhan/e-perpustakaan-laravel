@extends('admin.app')

@section('title', 'Pengguna')

@section('content')
    @if (session('success'))
        <div class="alert alert-{{ session('alert-type', 'light') }} alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal!</strong> {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Pengguna</h2>
            <p class="text-muted mb-0">Daftar Pengguna</p>
        </div>
        <a href="{{ route('admin.pengguna.create') }}" class="btn btn-primary">Tambah Pengguna</a>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th class="text-center">Telepon</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $user->name }}</td>
                            <td class="text-center">{{ $user->telepon ?? '-' }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pengguna.show', $user) }}" class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a href="{{ route('admin.pengguna.edit', $user) }}" class="btn btn-sm btn-outline-warning">
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
                            <td colspan="4" class="text-center py-4">Belum ada data pengguna.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection