@extends('layouts.app')
@section('title', 'Riwayat Pesanan Buku')

@section('content')
    <div class="container py-5">
        <div class="mb-5 text-center">
            <h1 class="fw-bold text-dark h2">Riwayat Pesanan Buku</h1>
            <p class="text-muted">Pantau status permohonan pinjaman buku Anda di sini.</p>
        </div>

        @forelse($pesanans as $pesanan)
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center g-3 text-center">

                        <div class="col-md-3">
                            <small class="text-muted d-block small fw-bold">NOMOR ORDER</small>
                            <span class="fw-bold h5 mb-0 text-dark">#{{ $pesanan->nomor_order }}</span>
                        </div>

                        <div class="col-md-2">
                            <small class="text-muted d-block small fw-bold">JUMLAH BUKU</small>
                            <span class="fw-bold text-primary">{{ $pesanan->itemPesanans->count() }} Judul</span>
                        </div>

                        <div class="col-md-3">
                            <small class="text-muted d-block small fw-bold mb-2">STATUS</small>
                            @php
                                $statusMap = [
                                    'tertunda' => ['bg' => 'bg-warning', 'text' => 'text-dark', 'label' => 'Tertunda'],
                                    'diproses' => ['bg' => 'bg-info', 'text' => 'text-white', 'label' => 'Diproses'],
                                    'selesai' => ['bg' => 'bg-success', 'text' => 'text-white', 'label' => 'Selesai'],
                                    'dibatalkan' => ['bg' => 'bg-danger', 'text' => 'text-white', 'label' => 'Dibatalkan']
                                ];

                                $current = $statusMap[$pesanan->status] ?? ['bg' => 'bg-secondary', 'text' => 'text-white', 'label' => 'Tidak diketahui'];
                            @endphp

                            <span class="badge {{ $current['bg'] }} {{ $current['text'] }} px-3 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-info-circle me-1"></i> {{ $current['label'] }}
                            </span>
                        </div>

                        <div class="col-md-2 border-start border-end">
                            <small class="text-muted d-block small fw-bold">TANGGAL PESAN</small>
                            <span class="text-dark">{{ $pesanan->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('pesanan.show', $pesanan) }}"
                                class="btn btn-dark rounded-pill px-4 shadow-sm w-100">Detail</a>
                        </div>
                    </div>
                </div>

                @if($pesanan->itemPesanans->count() > 0)
                    <div class="bg-light px-4 py-2 border-top text-center">
                        <small class="text-muted">
                            <i class="bi bi-book me-2"></i>
                            <strong>{{ $pesanan->itemPesanans->first()->nama_buku }}</strong>
                            @if($pesanan->itemPesanans->count() > 1)
                                dan {{ $pesanan->itemPesanans->count() - 1 }} buku lainnya...
                            @endif
                        </small>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-journal-x display-1 text-muted opacity-25"></i>
                <h5 class="fw-bold text-muted mt-3">Belum ada riwayat pesanan pinjaman</h5>
                <a href="{{ url('/') }}" class="btn btn-primary btn-sm rounded-pill mt-2">Mulai Cari Buku</a>
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $pesanans->links() }}
        </div>
    </div>
@endsection