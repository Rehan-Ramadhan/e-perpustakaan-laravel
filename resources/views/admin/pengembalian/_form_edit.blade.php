<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Nama Peminjam</label>
        <input type="text" class="form-control bg-light" value="{{ $pengembalian->peminjaman->user->name }}" readonly />
    </div>

    <div class="col-md-6">
        <label class="form-label">Buku</label>
        <input type="text" class="form-control bg-light" value="{{ $pengembalian->peminjaman->buku->nama }}" readonly />
    </div>

    <div class="col-md-6">
        <label class="form-label">Tanggal Kembali</label>
        <input type="text" class="form-control bg-light"
            value="{{ $pengembalian->tanggal_kembali->format('d F Y (H:i)') }}" readonly />
        <small class="text-muted">* Tercatat otomatis saat pengembalian.</small>
    </div>

    <div class="col-md-6">
        <label class="form-label">Denda Saat Ini</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="number" class="form-control bg-light" value="{{ $pengembalian->denda }}" readonly />
        </div>
        <div class="form-text text-info">
            Klik update untuk menghitung ulang denda.
        </div>
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-outline-secondary">Kembali</a>
    <button type="submit" class="btn btn-warning">Update Pengembalian</button>
</div>