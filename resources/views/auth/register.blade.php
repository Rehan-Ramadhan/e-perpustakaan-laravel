@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <div class="col-md-6">

        <div style="background: linear-gradient(135deg,#547c9a,#3f637d);" class="text-white text-center py-4">
            <h4 class="fw-bold mb-0" style="color:white;">Daftar Akun</h4>
            <small>Lengkapi data untuk bergabung</small>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name" placeholder="Nama lengkap">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>

                <div class="mb-3">
                    <label class="form-label">Konfirmasi</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi password">
                </div>

                <div class="d-grid mb-3">
                    <button class="btn btn-primary py-2 fw-bold">Daftar</button>
                </div>

                <div class="position-relative mb-3">
                    <hr>
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">
                        atau
                    </span>
                </div>

                <div class="d-grid mb-3">
                    <a href="{{ route('auth.google') }}" class="btn btn-outline-dark d-flex align-items-center justify-content-center gap-2 py-2"
                        style="border-radius: 10px;">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18">
                        Daftar dengan Google
                    </a>
                </div>

                <div class="text-center">
                    <small>
                        Sudah punya akun?
                        <a href="{{ route('login') }}" style="color:#547c9a;" class="fw-bold">
                            Masuk
                        </a>
                    </small>
                </div>

            </form>
        </div>

    </div>
@endsection