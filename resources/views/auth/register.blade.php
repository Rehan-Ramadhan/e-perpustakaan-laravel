@extends('layouts.auth')

@section('title', 'Registrasi')

@section('content')
    <div class="authentication-wrapper authentication-basic">
        <div class="authentication-inner" style="max-width: 450px;">
            <div class="card">
                <div class="card-body px-4 py-4">
                    <div class="app-brand justify-content-center">
                        <a class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="{{ asset('assets/img/favicon/favicon.png') }}" alt="Logo" width="32">
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder text-uppercase">e-Perpus</span>
                        </a>
                    </div>
                    <div class="mt-4 text-center">
                        <h4 class="mb-2">Daftar Akun Baru</h4>
                    </div>
                    <p class="mb-4 text-center">Lengkapi formulir di bawah ini untuk mendaftarkan akun Anda.</p>

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
                                    name="password_confirmation" placeholder="Konfirmasi kata sandi" />
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
@endsection
