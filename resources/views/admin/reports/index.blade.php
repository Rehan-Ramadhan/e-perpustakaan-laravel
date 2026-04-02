@extends('admin.app')

@section('title', 'Laporan Peminjaman')

@section('content')
    @if (session('success'))
        <div class="alert alert-{{ session('alert-type', 'primary') }} alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Laporan Peminjaman</h2>
            <p class="text-muted mb-0">Analitik transaksi perpustakaan</p>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
    </div>

    {{-- FILTER --}}
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Filter Rentang Tanggal</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $dateTo }}" class="form-control">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-primary w-100">
                        Filter
                    </button>
                    <a href="{{ route('admin.reports.export', request()->all()) }}" class="btn btn-outline-success w-100">
                        Export Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- SUMMARY --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <small class="text-muted d-block">Total Peminjaman</small>
                    <h3 class="mb-1">{{ number_format($summary->total_pinjam ?? 0) }}</h3>
                    <small class="text-success">Transaksi Terdata</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm border-start border-danger border-4">
                <div class="card-body">
                    <small class="text-muted d-block">Total Denda</small>
                    <h3 class="mb-1">Rp {{ number_format($summary->total_denda ?? 0, 0, ',', '.') }}</h3>
                    <small class="text-muted">Periode terpilih</small>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card mb-4">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Rincian Transaksi</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $p)
                        <tr>
                            <td><strong>{{ $p->nomor_peminjaman }}</strong></td>
                            <td>{{ $p->pengguna->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-label-{{ $p->status == 'pinjam' ? 'warning' : 'success' }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-center">
            {{ $peminjamans->appends(request()->all())->links() }}
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom">
            <h5 class="mb-0">Populer per Rak</h5>
        </div>

        <div class="card-body">
            @forelse($byCategory as $cat)
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Rak {{ $cat->kategori ?? '-' }}</span>
                        <small>{{ $cat->total }}</small>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary"
                            style="width: {{ ($cat->total / ($summary->total_pinjam ?: 1)) * 100 }}%">
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada data.</p>
            @endforelse
        </div>
    </div>
@endsection