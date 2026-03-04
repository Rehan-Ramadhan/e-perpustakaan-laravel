@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if(session('success'))
            <div class="alert alert-{{ session('alert-type', 'light') }} alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Daftar Anggota</h2>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Anggota</th>
                            <th>Jenis Kelamin</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php $no = 1; @endphp
                        @forelse($anggotas as $anggota)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $anggota->nama }}</td>
                                <td>{{ $anggota->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $anggota->telepon }}</td>
                                <td>
                                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('anggota.show', $anggota->id) }}"
                                                class="btn btn-sm btn-info text-white"><i class="bi bi-eye me-1"></i></a>
                                            <a href="{{ route('anggota.edit', $anggota->id) }}"
                                                class="btn btn-sm btn-outline-warning"><i class="bi bi-pen me-1"></i></a>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i
                                                    class="bi bi-trash me-1"></i></button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data anggota.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection