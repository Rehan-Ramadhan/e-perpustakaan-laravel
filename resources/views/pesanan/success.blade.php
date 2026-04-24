@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card border-0 shadow-sm rounded-5 py-5 px-4">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
                            style="width: 100px; height: 100px;">
                            <i class="bi bi-check2-circle display-2"></i>
                        </div>
                        <h2 class="fw-bold mb-3 text-dark">Pembayaran Berhasil!</h2>
                        <p class="text-muted mb-5">Terima kasih, <strong>{{ auth()->user()->name }}</strong>. Pesanan Anda
                            <span class="text-primary fw-bold">#{{ $order->order_number }}</span> telah kami terima dan
                            segera diproses.</p>

                        <div class="bg-light p-4 rounded-4 mb-5">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small fw-bold text-uppercase">Total Terbayar</span>
                                <span class="fw-bold text-dark">Rp
                                    {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small fw-bold text-uppercase">Status Pembayaran</span>
                                <span class="badge bg-success px-3 py-2 rounded-pill">PAID</span>
                            </div>
                        </div>

                        <div class="d-flex gap-3 justify-content-center">
                            <a href="{{ route('orders.index') }}"
                                class="btn btn-primary rounded-pill px-4 py-2 shadow-sm fw-bold">Cek Status Pesanan</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold">Kembali
                                Belanja</a>
                        </div>
                    </div>
                </div>
                <p class="mt-4 text-muted small"><i class="bi bi-clock me-1"></i> Update otomatis oleh sistem Midtrans</p>
            </div>
        </div>
    </div>
@endsection