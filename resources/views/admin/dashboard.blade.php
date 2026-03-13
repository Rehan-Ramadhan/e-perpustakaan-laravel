@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold mb-0">Dashboard</h2>
            <a href="{{ route('reports.index') }}" class="btn btn-primary">
                Lihat Laporan Lengkap <i class="bx bx-right-arrow-alt"></i>
            </a>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Panel Kendali Administrator</h5>
                                <p class="mb-4">
                                    Selamat datang kembali, <strong>{{ Auth::user()->nama }}</strong>. Hari ini adalah
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
                                <a href="{{ route('buku.index') }}" class="d-block">
                                    <span class="badge bg-label-primary p-2">
                                        <i class="bx bx-book fs-3"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Buku</span>
                        <h3 class="card-title mb-2">{{ number_format($totalBuku) }}</h3>
                        <small class="text-success fw-semibold">Data tersedia</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <a href="{{ route('pengguna.index') }}" class="d-block">
                                <div class="avatar flex-shrink-0">
                                    <span class="badge bg-label-success p-2"><i class="bx bx-user fs-3"></i></span>
                                </div>
                            </a>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Anggota</span>
                        <h3 class="card-title mb-2">{{ $totalAnggota }}</h3>
                        <small class="text-success fw-semibold">Anggota aktif</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('peminjaman.index') }}" class="d-block">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="badge bg-label-warning p-2"><i class="bx bx-book-reader fs-3"></i></span>
                                </div>
                            </div>
                        </a>
                        <span class="fw-semibold d-block mb-1">Peminjaman</span>
                        <h3 class="card-title mb-2">{{ $sedangDipinjam }}</h3>
                        <small class="text-success fw-semibold">Sedang dipinjam</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('pengembalian.index') }}" class="d-block">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <span class="badge bg-label-danger p-2"><i class="bx bx-error fs-3"></i></span>
                                </div>
                            </div>
                        </a>
                        <span class="fw-semibold d-block mb-1">Terlambat</span>
                        <h3 class="card-title mb-2">{{ $terlambat }}</h3>
                        <small class="text-danger fw-semibold">Perlu tindakan!</small>
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
                                @forelse($transaksiTerbaru as $trx)
                                    <tr>
                                        <td><strong>{{ $trx->kode_transaksi }}</strong></td>
                                        <td>{{ $trx->pengguna->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-label-{{ $trx->status == 'pinjam' ? 'primary' : 'success' }} me-1">
                                                {{ ucfirst($trx->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('peminjaman.show', $trx->id) }}"
                                                class="btn btn-sm btn-outline-info">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada transaksi terbaru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection