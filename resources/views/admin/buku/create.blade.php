@extends('admin.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Data Buku</h2>
            <p class="text-muted mb-0">Masukkan data buku baru ke sistem perpustakaan.</p>
        </div>
        <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Buku Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf
                @include('admin.buku._form', [
                    'buku' => null,
                    'kodeBuku' => $otomatisKode,
                    'submitLabel' => 'Simpan Buku',
                ])
            </form>
        </div>
    </div>
@endsection
