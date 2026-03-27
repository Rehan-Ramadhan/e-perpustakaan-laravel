@extends('admin.app')

@section('title', 'Edit Pengguna')

@section('content')
    @if (session('success'))
        <div class="alert alert-{{ session('alert-type', 'light') }} alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Data Pengguna</h2>
            <p class="text-muted mb-0">
                Perbarui informasi pengguna {{ $user->nik }} tanpa keluar dari panel admin.
            </p>
        </div>
        <a href="{{ route('admin.pengguna.show', $user) }}" class="btn btn-outline-secondary">
            Lihat Detail
        </a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit {{ $user->nik }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pengguna.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.user._form', [
                    'user' => $user,
                    'submitLabel' => 'Update Pengguna',
                ])
                </form>
            </div>
        </div>
@endsection