@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
    <div class="container py-5">
        <div class="mb-5">
            <h1 class="fw-bold text-dark h2">Pesanan Saya</h1>
            <p class="text-muted">Pantau perjalanan belanja Anda di sini.</p>
        </div>

        @forelse($orders as $order)
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <small class="text-muted d-block small fw-bold">ID PESANAN</small>
                            <span class="fw-bold h5 mb-0 text-dark">#{{ $order->order_number }}</span>
                        </div>
                        <div class="col-md-3">
                            <small class="text-muted d-block small fw-bold">TOTAL TAGIHAN</small>
                            <span class="fw-bold text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="col-md-2">
                            <small class="text-muted d-block small fw-bold mb-1">STATUS</small>
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="col-md-2 text-md-center border-start border-end">
                            <small class="text-muted d-block small fw-bold">TANGGAL</small>
                            <span class="text-dark">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="col-md-2 text-md-end">
                            <a href="{{ route('orders.show', $order) }}"
                                class="btn btn-dark rounded-pill px-4 shadow-sm w-100">Detail</a>
                        </div>
                    </div>
                </div>
                @if($order->items->count() > 0)
                    <div class="bg-light px-4 py-2 border-top">
                        <small class="text-muted italic"><i
                                class="bi bi-box-seam me-2"></i>{{ $order->items->first()->product_name }} ...</small>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-5">
                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" class="mb-4 opacity-25">
                <h5 class="fw-bold text-muted">Belum ada riwayat belanja</h5>
            </div>
        @endforelse

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    </div>
@endsection