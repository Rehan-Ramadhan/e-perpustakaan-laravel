@extends('layouts.app')

@section('title', 'Detail Permohonan Pinjam')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="mb-4">
                    <a href="{{ route('pesanan.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Pesanan
                    </a>
                </div>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-4 border-bottom">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div>
                                <h1 class="h3 fw-bold mb-1">Order #{{ $pesanan->nomor_order }}</h1>
                                <p class="text-muted mb-0">
                                    <i class="bi bi-calendar3"></i> {{ $pesanan->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div class="mt-3 mt-md-0">
                                @php
                                    $dbStatus = trim($pesanan->status);

                                    $statusMap = [
                                        'tertunda' => ['bg' => '#ffc107', 'text' => '#000', 'label' => 'Menunggu Konfirmasi'],
                                        'diproses' => ['bg' => '#0dcaf0', 'text' => '#fff', 'label' => 'Sedang Dipinjam'],
                                        'selesai' => ['bg' => '#198754', 'text' => '#fff', 'label' => 'Selesai'],
                                        'dibatalkan' => ['bg' => '#dc3545', 'text' => '#fff', 'label' => 'Dibatalkan Anda'],
                                        'ditolak' => ['bg' => '#dc3545', 'text' => '#fff', 'label' => 'Ditolak Admin'],
                                    ];

                                    $current = $statusMap[$dbStatus] ?? [
                                        'bg' => '#dc3545',
                                        'text' => '#fff',
                                        'label' => ucfirst($dbStatus)
                                    ];
                                @endphp
                                <span class="badge rounded-pill px-4 py-2 fs-6 shadow-sm"
                                    style="background-color: {{ $current['bg'] }} !important; color: {{ $current['text'] }} !important; opacity: 1 !important;">
                                    {{ $current['label'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="p-4 p-md-5">
                            <h5 class="fw-bold mb-4">Buku yang Dipinjam</h5>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" class="py-3 ps-4">Judul Buku</th>
                                            <th scope="col" class="text-center py-3">Jumlah</th>
                                            <th scope="col" class="text-center py-3">Status Buku</th>
                                            <th scope="col" class="text-end py-3 pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pesanan->itemPesanans as $item)
                                            <tr>
                                                <td class="py-3 ps-4">
                                                    <span class="fw-medium text-dark">{{ $item->nama_buku }}</span>
                                                </td>
                                                <td class="text-center py-3">1</td>
                                                <td class="text-center py-3">
                                                    @php 
                                                        $peminjaman = $item->buku->peminjamans->first(); 
                                                    @endphp

                                                    @if($peminjaman)
                                                        @if($peminjaman->status === 'dipinjam')
                                                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                                        @else
                                                            <span class="badge bg-success">Sudah Dikembalikan</span>
                                                        @endif
                                                    @else
                                                        <span class="text-success small"><i class="bi bi-check-circle"></i> Tersedia</span>
                                                    @endif
                                                </td>
                                                <td class="text-end py-3 pe-4">
                                                    @if($peminjaman && $peminjaman->status === 'dipinjam')
                                                        <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin mengembalikan buku \'{{ $item->nama_buku }}\' sekarang?')">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm rounded-pill px-3 shadow-sm">
                                                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                                                            </button>
                                                        </form>
                                                    @elseif($peminjaman && $peminjaman->status === 'dikembalikan')
                                                        <span class="text-muted small"><i class="bi bi-check-all text-success"></i> Selesai</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-top-0">
                                        <tr>
                                            <td colspan="3" class="text-end pt-4 border-0 fw-bold fs-5">TOTAL BUKU:</td>
                                            <td class="text-end pt-4 border-0 fw-bold fs-5 text-primary pe-4">
                                                {{ $pesanan->itemPesanans->count() }} Judul
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="p-4 p-md-5 bg-light border-top">
                            <h5 class="fw-bold mb-3">Catatan Anda</h5>
                            <div class="card border-0 shadow-none bg-white rounded-3">
                                <div class="card-body p-3">
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-chat-left-dots me-2"></i>
                                        {{ $pesanan->catatan ?? 'Tidak ada catatan untuk pesanan ini.' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white py-4 text-center border-top">
                        @if($pesanan->status === 'tertunda')
                            <p class="text-muted mb-0 small">
                                <i class="bi bi-info-circle me-1"></i>
                                Silakan tunggu konfirmasi Admin atau datang ke perpustakaan.
                            </p>
                        @else
                            <p class="text-muted mb-0 small">
                                Permohonan ini telah diproses. Cek menu <strong>Peminjaman Aktif</strong> untuk melihat tanggal
                                jatuh tempo.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection