@extends('admin.app')

@section('title', 'Tambah Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Peminjaman</h2>
            <p class="text-muted mb-0">Input transaksi baru</p>
        </div>
        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Transaksi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.peminjaman.store') }}" method="POST">
                @csrf
                @include('admin.peminjaman._form', ['submitLabel' => 'Simpan'])
            </form>
        </div>
    </div>
@endsection