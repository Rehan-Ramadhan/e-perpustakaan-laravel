<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'e-perpustakaan') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/pages/page-auth.css') }}" />

    <script src="{{ asset('admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin/js/config.js') }}"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-10 col-lg-9">

                <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                    <div class="row g-0">

                        <div
                            class="col-md-6 d-none d-md-flex align-items-center justify-content-center bg-light border-end">
                            <div class="p-5 text-center">
                                <img src="{{ asset('admin/img/favicon/favicon.png') }}" class="img-fluid mb-4"
                                    style="max-height: 120px;">
                                <h3 class="fw-bold mb-2" style="color:#547c9a;">e-perpustakaan</h3>
                                <div class="mb-3">
                                    <span class="badge rounded-pill" style="background:#547C9A;">Sistem Informasi
                                        Perpustakaan</span>
                                </div>
                                <p class="text-muted small">
                                    Temukan Dunia Baru di Setiap Halaman
                                    Nikmati akses ke berbagai koleksi buku, kelola peminjaman dengan mudah,
                                    dan buat pengalaman membaca jadi lebih menyenangkan setiap harinya.
                                </p>
                            </div>
                        </div>

                        @yield('content')

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('admin/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('admin/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('admin/js/main.js') }}"></script>
</body>

</html>