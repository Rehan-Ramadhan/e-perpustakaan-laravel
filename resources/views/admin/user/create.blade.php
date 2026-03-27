@extends('admin.app')

@section('title', 'Tambah Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Data Pengguna</h2>
            <p class="text-muted mb-0">Masukkan data pengguna baru ke sistem.</p>
        </div>
        <a href="{{ route('admin.pengguna.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Pengguna Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengguna.store') }}" method="POST">
                @csrf
                @include('admin.user._form', [
                    'user' => null,
                    'kodeUser' => $otomatisKode,
                    'submitLabel' => 'Simpan Pengguna',
                ])
                </form>
            </div>
        </div>
@endsection