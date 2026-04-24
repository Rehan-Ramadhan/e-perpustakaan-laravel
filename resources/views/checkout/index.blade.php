@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
    <div class="container py-5">
        <div class="d-flex align-items-center mb-4">
            <h1 class="fw-bold mb-0">Checkout</h1>
            <span class="ms-3 badge bg-light text-dark border shadow-sm px-3 rounded-pill">Langkah Terakhir</span>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h5 class="mb-4 fw-bold"><i class="bi bi-geo-alt me-2 text-primary"></i>Informasi Pengiriman
                            </h5>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">NAMA PENERIMA</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}"
                                    class="form-control form-control-lg bg-light border-0" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small fw-bold">NOMOR TELEPON</label>
                                <input type="text" name="phone" class="form-control form-control-lg bg-light border-0"
                                    placeholder="0812..." required>
                            </div>

                            <div class="mb-0">
                                <label class="form-label text-muted small fw-bold">ALAMAT LENGKAP</label>
                                <textarea name="address" rows="3" class="form-control bg-light border-0"
                                    placeholder="Nama jalan, nomor rumah, kec, kota..." required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 100px;">
                        <div class="card-body p-4">
                            <h5 class="mb-4 fw-bold">Ringkasan Pesanan</h5>

                            @foreach($cart->items as $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <p class="mb-0 fw-bold text-dark">{{ $item->product->name }}</p>
                                        <small class="text-muted">{{ $item->jumlah }}x @ Rp
                                            {{ number_format($item->product->price, 0, ',', '.') }}</small>
                                    </div>
                                    <span class="fw-bold text-primary">Rp
                                        {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </div>
                            @endforeach

                            <hr class="my-4 opacity-25">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="text-muted fw-bold">Total Pembayaran</span>
                                <span class="h4 mb-0 fw-bold text-dark">Rp
                                    {{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold">
                                Buat Pesanan <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection