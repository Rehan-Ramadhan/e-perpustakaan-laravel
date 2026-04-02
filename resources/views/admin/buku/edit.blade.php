@extends('admin.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Data Buku</h2>
            <p class="text-muted mb-0">Perbarui informasi buku {{ $buku->kode_buku }} tanpa keluar dari panel admin.</p>
        </div>
        <a href="{{ route('admin.buku.show', $buku) }}" class="btn btn-outline-secondary">Lihat Detail</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit {{ $buku->kode_buku }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.buku._form', [
                    'buku' => $buku,
                    'kodeBuku' => $buku->kode_buku,
                    'submitLabel' => 'Update Buku',
                ])
                </form>
            </div>
        </div>
@endsection