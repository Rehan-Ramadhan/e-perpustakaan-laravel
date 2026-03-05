@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Selamat Datang, {{ Auth::user()->name }}! 🎉</h5>
                                <p class="mb-4">
                                    Anda telah masuk ke sistem <strong>e-perpus</strong>. Silakan jelajahi koleksi buku kami dan lakukan
                                    peminjaman secara mandiri melalui menu yang tersedia.
                                </p>

                                <a href="javascript:;" class="btn btn-sm btn-outline-primary">Lihat Koleksi Buku</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-book-content text-info fs-3"></i>
                                    </div>
                                </div>
                                <strong class="fw-semibold d-block mb-1">Dipinjam</strong>
                                <h3 class="card-title mb-2">0</h3>
                                <small class="text-muted">Buku sedang dipinjam</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <i class="bx bx-history text-success fs-3"></i>
                                    </div>
                                </div>
                                <strong class="fw-semibold d-block mb-1">Riwayat</strong>
                                <h3 class="card-title mb-2">0</h3>
                                <small class="text-muted">Total transaksi</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Informasi Perpustakaan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <strong class="avatar-initial rounded bg-label-primary"><i
                                            class="bx bx-info-circle"></i></strong>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Batas Peminjaman</h6>
                                        <small class="text-muted">Maksimal peminjaman adalah 3 buku dalam satu
                                            waktu.</small>
                                    </div>
                                </div>
                            </li>
                            <li class="d-flex">
                                <div class="avatar flex-shrink-0 me-3">
                                    <strong class="avatar-initial rounded bg-label-danger"><i class="bx bx-time"></i></strong>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">Durasi Peminjaman</h6>
                                        <small class="text-muted">Batas waktu pengembalian adalah 7 hari kalender.</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection