@extends('admin.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Tambah Data Kategori</h2>
            <p class="text-muted mb-0">Masukkan kategori baru ke sistem.</p>
        </div>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Kategori Baru</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.kategori._form', [
                    'kategori' => null,
                    'submitLabel' => 'Simpan Kategori',
                ])
                </form>
            </div>
        </div>
@endsection