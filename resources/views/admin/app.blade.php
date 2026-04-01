<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'e-perpustakaan') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('admin/img/favicon/favicon.png') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="{{ asset('admin/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/vendor/css/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/css/demo.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <script src="{{ asset('admin/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('admin/js/config.js') }}"></script>
    
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @auth
                @include('bagian.sidebar')
                <div class="layout-page">
                    @include('bagian.navbar')
                    <div class="content-wrapper">
                        <div class="container-xxl flex-grow-1 container-p-y">
                            @yield('content')
                        </div>
                        @include('bagian.footer')
                    </div>
                </div>
            @endauth

            @guest
                <div class="container-xxl">
                    @yield('content')
                </div>
            @endguest

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