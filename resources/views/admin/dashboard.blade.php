@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Panel Kendali Administrator</h5>
                                <p class="mb-4">
                                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>. Hari ini adalah
                                    @php
                                        \Carbon\Carbon::setLocale('id');
                                    @endphp
                                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}.
                                    Pantau statistik perpustakaan Anda melalui ringkasan di bawah ini.
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" height="140"
                                    alt="Admin Dashboard">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="badge bg-label-primary p-2"><i class="bx bx-book fs-3"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Buku</span>
                        <h3 class="card-title mb-2">1,240</h3> <small class="text-success fw-semibold">Data tersedia</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="badge bg-label-info p-2"><i class="bx bx-group fs-3"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Anggota</span>
                        <h3 class="card-title mb-2">450</h3>
                        <small class="text-success fw-semibold">Anggota aktif</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="badge bg-label-warning p-2"><i class="bx bx-transfer fs-3"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Peminjaman</span>
                        <h3 class="card-title mb-2">12</h3>
                        <small class="text-muted">Sedang dipinjam</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="badge bg-label-danger p-2"><i class="bx bx-error fs-3"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Terlambat</span>
                        <h3 class="card-title mb-2">5</h3>
                        <small class="text-danger fw-semibold">Perlu tindakan</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12 mb-4">
                <div class="card">
                    <h5 class="card-header">Transaksi Peminjaman Terbaru</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                <tr>
                                    <td><strong>TRP-001</strong></td>
                                    <td>Budi Anggota</td>
                                    <td>05 Maret 2026</td>
                                    <td><span class="badge bg-label-primary me-1">Dipinjam</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">Detail</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection