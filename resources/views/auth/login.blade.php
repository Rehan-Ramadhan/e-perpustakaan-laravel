@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <img src="{{ asset('assets/img/favicon/favicon.png') }}" alt="Logo" width="32">
                                </span>
                                <span class="app-brand-text demo text-body fw-bolder text-uppercase">e-Perpus</span>
                            </a>
                        </div>
                        <div class="mt-4 text-center">
                            <h4 class="mb-2">Selamat Datang Kembali!</h4>
                        </div>
                        <p class="mb-4">Silakan masuk untuk mengakses sistem perpustakaan.</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Masukkan email Anda" value="{{ old('email') }}" autofocus />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Kata Sandi</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Minimal 8 karakter" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember-me"> Ingat Saya </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Masuk</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>Belum memiliki akun?</span>
                            <a href="{{ route('register') }}">
                                <span>Daftar sekarang</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .authentication-wrapper.authentication-basic {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .authentication-inner {
            max-width: 400px;
            width: 100%;
        }
    </style>
@endsection