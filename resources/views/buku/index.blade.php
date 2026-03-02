@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
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
                                <button class="btn btn-sm btn-warning">Edit</button>
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