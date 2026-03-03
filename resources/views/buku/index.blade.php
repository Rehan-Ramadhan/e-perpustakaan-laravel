@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Buku</h2>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Stok</th>
                        <th>Rak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $buku)
                        <tr>
                            <td>{{ $buku->kode_buku }}</td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->pengarang }}</td>
                            <td>{{ $buku->stok }}</td>
                            <td>{{ $buku->rak_lokasi }}</td>
                            <td>
                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('buku.show', $buku->id) }}"
                                            class="btn btn-sm btn-info text-white">Detail</a>
                                        <a href="{{ route('buku.edit', $buku->id) }}"
                                            class="btn btn-sm btn-outline-warning">Edit</a>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection