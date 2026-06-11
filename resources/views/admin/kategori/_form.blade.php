<div class="row g-4">

    <div class="col-12">
        <label class="form-label" for="nama">Nama Kategori</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama"
            value="{{ old('nama', $kategori->nama ?? '') }}" required>
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label" for="deskripsi">Deskripsi</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi"
            rows="4">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">Gambar Saat Ini</label>
        <div class="p-2 border rounded bg-light mb-2">
            @if($kategori?->gambar)
                <img src="{{ $kategori->gambar_url }}" width="100" style="object-fit: cover; border-radius: 4px;">
            @else
                <small class="text-muted">Belum ada gambar.</small>
            @endif
        </div>

        <label class="form-label fw-bold">Upload Gambar Baru</label>
        <input type="file" name="gambar" class="form-control">
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input type="checkbox" class="form-check-input" name="is_active" value="1" @checked(old('is_active', $kategori->is_active ?? 1))>
            <label class="form-check-label">Tampilkan kategori</label>
        </div>
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>