@extends('layouts.app')

@section('title', 'Laporan Analitik Perpustakaan')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">Laporan Perpustakaan</h2>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Filter Rentang Tanggal</h5>
                <small class="text-muted float-end">Gunakan untuk membatasi data</small>
            </div>
            <div class="card-body">
                <form method="GET" class="row align-items-end g-3">
                    <div class="col-md-4">
                        <label class="form-label">Dari Tanggal</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Sampai Tanggal</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                            <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bx bx-search me-1"></i> Filter
                        </button>
                        <a href="{{ route('reports.export', request()->all()) }}" class="btn btn-outline-success w-100">
                            <i class="bx bx-file me-1"></i> Export Excel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="bx bx-book-reader"></i></span>
                            </div>
                            <small class="text-muted d-block">Total Peminjaman</small>
                        </div>
                        <h3 class="card-title mb-1">{{ number_format($summary->total_pinjam) }}</h3>
                        <small class="text-success fw-semibold">Transaksi Terdata</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-danger"><i class="bx bx-money"></i></span>
                            </div>
                            <small class="text-muted d-block">Total Denda Terkumpul</small>
                        </div>
                        <h3 class="card-title mb-1">Rp {{ number_format($summary->total_denda ?? 0, 0, ',', '.') }}</h3>
                        <small class="text-muted">Berdasarkan periode terpilih</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0">Rincian Transaksi Peminjaman</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama Peminjam</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse($peminjamans as $p)
                                    <tr>
                                        <td><strong>{{ $p->kode_transaksi }}</strong></td>
                                        <td>{{ $p->pengguna->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge bg-label-{{ $p->status == 'pinjam' ? 'warning' : 'success' }}">
                                                {{ ucfirst($p->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Tidak ada data transaksi ditemukan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        {{ $peminjamans->appends(request()->all())->links() }}
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title m-0">Populer per Rak</h5>
                    </div>
                    <div class="card-body">
                        @forelse($byCategory as $cat)
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold">Rak {{ $cat->kategori ?? 'Umum' }}</span>
                                    <small class="text-muted">{{ $cat->total }}x</small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ ($cat->total / ($summary->total_pinjam ?: 1)) * 100 }}%"
                                        aria-valuenow="{{ $cat->total }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">Belum ada data kategori.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection