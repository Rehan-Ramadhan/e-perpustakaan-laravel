@extends('admin.app')
@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0 fw-bold text-dark">Daftar Pesanan</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3">
            <ul class="nav nav-pills card-header-pills gap-2">
                @php 
                $statuses = [
                    'all'      => 'Semua', 
                    'tertunda' => 'Tertunda', 
                    'diproses' => 'Diproses', 
                    'selesai'  => 'Selesai',
                    'dibatalkan' => 'Dibatalkan'
                ]; 
                @endphp
                @foreach($statuses as $key => $label)
                    <li class="nav-item">
                        <a class="nav-link rounded-pill px-4 {{ (request('status') == $key || (!request('status') && $key == 'all')) ? 'active shadow-sm' : 'text-muted' }}"
                            href="{{ $key == 'all' ? route('admin.orders.index') : route('admin.orders.index', ['status' => $key]) }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-0">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">NOMOR ORDER</th>
                            <th class="py-3 text-muted small fw-bold">ANGGOTA</th>
                            <th class="py-3 text-muted small fw-bold">TANGGAL</th>
                            <th class="py-3 text-muted small fw-bold">STATUS</th>
                            <th class="text-end pe-4 py-3 text-muted small fw-bold">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td class="ps-4 fw-bold">#{{ $order->nomor_order }}</td>
                                <td>
                                    <div class="fw-bold">{{ $order->user->name }}</div>
                                    <small class="text-muted">{{ $order->user->email }}</small>
                                </td>
                                <td class="text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @php
                                        $badges = [
                                            'tertunda'   => 'bg-warning', 
                                            'diproses'   => 'bg-info', 
                                            'selesai'    => 'bg-success', 
                                            'dibatalkan' => 'bg-danger'
                                        ];
                                        $badge = $badges[$order->status] ?? 'bg-secondary';
                                    @endphp
                                    <span class="badge {{ $badge }} bg-opacity-10 {{ str_replace('bg-', 'text-', $badge) }} px-3 py-2 rounded-pill">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Tidak ada pesanan ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-top py-3">
            {{ $orders->links() }}
        </div>
    </div>
@endsection