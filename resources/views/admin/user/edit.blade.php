@extends('admin.app')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Edit Data Pengguna</h2>
            <p class="text-muted mb-0">Perbarui data user {{ $user->nik }}.</p>
        </div>
        <a href="{{ route('admin.user.show', $user) }}" class="btn btn-outline-secondary">Lihat Detail</a>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Form Edit {{ $user->nik }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.user.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.user._form', [
                    'user' => $user,
                    'kodeUser' => $user->nik,
                    'submitLabel' => 'Update Pengguna',
                ])
            </form>
        </div>
    </div>
@endsection