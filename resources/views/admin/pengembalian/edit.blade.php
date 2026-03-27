@extends('admin.app')

@section('title', 'Edit Pengembalian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Pengembalian</h2>
            <p class="text-muted mb-0">
                Perbarui data pengembalian untuk nomor {{ $pengembalian->peminjaman->nomor_peminjaman }}.
            </p>
        </div>
        <a href="{{ route('admin.pengembalian.show', $pengembalian) }}" class="btn btn-outline-secondary">
            Lihat Detail
        </a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit Pengembalian</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengembalian.update', $pengembalian) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.pengembalian._form_edit', [
                    'pengembalian' => $pengembalian
                ])
            </form>
            </div>
        </div>
@endsection