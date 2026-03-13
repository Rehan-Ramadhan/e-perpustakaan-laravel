@extends('layouts.app')

@section('title', 'Daftar Akun')

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
                            <h4 class="mb-2">Daftar Akun Baru</h4>
                        </div>
                        <p class="mb-4">Lengkapi formulir di bawah ini untuk mendaftarkan akun Anda.</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" placeholder="Masukkan alamat email" value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Kata Sandi</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Minimal 8 karakter" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password-confirm">Konfirmasi Kata Sandi</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation" placeholder="········" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>

                            <button class="btn btn-primary d-grid w-100" type="submit">Daftar Akun</button>
                        </form>

                        <p class="text-center">
                            <span>Sudah memiliki akun?</span>
                            <a href="{{ route('login') }}">
                                <span>Masuk kembali</span>
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
            max-width: 450px;
            width: 100%;
        }
    </style>
@endsection