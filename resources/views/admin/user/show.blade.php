@extends('admin.app')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Detail Pengguna</h2>
            <p class="text-muted mb-0">Informasi lengkap pengguna.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary">Kembali</a>
            <a href="{{ route('admin.pengguna.edit', $user) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label text-muted">NIK</label>
                <div class="form-control bg-light">{{ $user->nik }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Nama</label>
                <div class="form-control bg-light">{{ $user->name }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Telepon</label>
                <div class="form-control bg-light">{{ $user->telepon ?? '-' }}</div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted">Alamat</label>
                <div class="form-control bg-light">{{ $user->alamat ?? '-' }}</div>
            </div>

            <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST"
                onsubmit="return confirm('Yakin hapus buku ini?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-outline-danger w-100">Hapus Pengguna</button>
            </form>
        </div>
    </div>
@endsection