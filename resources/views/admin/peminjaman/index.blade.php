@extends('admin.app')

@section('title', 'Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Peminjaman</h2>
            <p class="text-muted mb-0">Daftar transaksi dan antrean pesanan</p>
        </div>
        <a href="{{ route('admin.peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
    </div>

    @if($antreanPesanan->count() > 0)
    <div class="card shadow-sm border-warning mb-4">
        <div class="card-header bg-label-warning py-3">
            <h5 class="mb-0 text-warning fw-bold">Antrean Pesanan (Menunggu Konfirmasi)</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Order ID</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($antreanPesanan as $pesanan)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td><span class="fw-bold">#{{ $pesanan->nomor_order }}</span></td>
                            <td>{{ $pesanan->user->name ?? '-' }}</td>
                            <td>
                                <ul class="mb-0 ps-3">
                                    @foreach($pesanan->itemPesanans as $item)
                                        <li>{{ $item->nama_buku }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.peminjaman.setujui', $pesanan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirm('Proses pesanan ini menjadi peminjaman?')">
                                        Setujui & Pinjamkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header py-3">
            <h5 class="mb-0 fw-bold">Data Peminjaman Aktif</h5>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Peminjam</th>
                        <th>Buku</th>
                        <th class="text-center">Jatuh Tempo</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($peminjamans as $peminjaman)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $peminjaman->user->name ?? '-' }}</td>
                            <td>{{ $peminjaman->buku->nama ?? '-' }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_jatuh_tempo)->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <span class="badge bg-label-{{ $peminjaman->status_color }}">
                                    {{ ucfirst($peminjaman->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.peminjaman.destroy', $peminjaman) }}" method="POST"
                                    onsubmit="return confirm('Yakin hapus buku ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <div class="btn-group">
                                        <a href="{{ route('admin.peminjaman.show', $peminjaman) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-show"></i>
                                        </a>

                                        <a href="{{ route('admin.peminjaman.edit', $peminjaman) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bx bx-edit"></i>
                                        </a>

                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada data peminjaman aktif.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection