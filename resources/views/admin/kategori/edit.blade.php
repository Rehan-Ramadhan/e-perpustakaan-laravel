@extends('admin.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Data Kategori</h2>
            <p class="text-muted mb-0">Perbarui kategori {{ $kategori->nama }}</p>
        </div>
        <a href="{{ route('admin.kategori.show', $kategori) }}" class="btn btn-outline-secondary">Lihat Detail</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit {{ $kategori->nama }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.kategori._form', [
                    'kategori' => $kategori,
                    'submitLabel' => 'Update Kategori',
                ])
                </form>
            </div>
        </div>
@endsection