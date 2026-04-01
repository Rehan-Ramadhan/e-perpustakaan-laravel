@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="col-md-6">

        <div style="background: linear-gradient(135deg,#547c9a,#3f637d);" class="text-white text-center py-4">
            <h4 class="fw-bold mb-0" style="color:white;">Selamat Datang Kembali</h4>
            <small>Akses akunmu dan lanjutkan perjalanan literasimu!</small>
        </div>

        <div class="card-body p-4 p-md-5">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-envelope"></i>
                        </span>
                        <input type="email" class="form-control border-start-0 @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Masukkan email">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bx bx-lock"></i>
                        </span>
                        <input type="password" class="form-control border-start-0 @error('password') is-invalid @enderror"
                            name="password" placeholder="Masukkan password">
                    </div>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label">Ingat saya</label>
                </div>

                <div class="d-grid mb-3">
                    <button class="btn" style="background-color: #547c9a; color: white;"   py-2 fw-bold">Masuk</button>
                </div>

                <div class="position-relative mb-3">
                    <hr>
                    <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 small text-muted">
                        atau
                    </span>
                </div>

                <div class="d-grid mb-3">
                    <a href="#" class="btn btn-outline-dark d-flex align-items-center justify-content-center gap-2 py-2"
                        style="border-radius: 10px;">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18">
                        Login dengan Google
                    </a>
                </div>

                <div class="text-center">
                    <small>
                        Belum punya akun?
                        <a href="{{ route('register') }}" style="color:#547c9a;" class="fw-bold">
                            Daftar
                        </a>
                    </small>
                </div>

            </form>
        </div>

    </div>
@endsection