<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label" for="kode_buku">Kode Buku</label>
        <input type="text" class="form-control bg-light" id="kode_buku" value="{{ $kodeBuku }}" readonly />
    </div>

    <div class="col-md-6">
        <label class="form-label" for="kategori_id">Kategori</label>
        <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id"
            required>
            <option value="">Pilih kategori</option>
            @foreach ($kategoris as $kategori)
                <option value="{{ $kategori->id }}" @selected(old('kategori_id', $buku->kategori_id ?? '') == $kategori->id)>
                    {{ $kategori->nama }}
                </option>
            @endforeach
        </select>
        @error('kategori_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label" for="nama">Judul Buku</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
            value="{{ old('nama', $buku->nama ?? '') }}" placeholder="Contoh: Belajar Laravel 11 untuk Pemula"
            required />
        @error('nama')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="pengarang">Pengarang</label>
        <input type="text" class="form-control @error('pengarang') is-invalid @enderror" id="pengarang" name="pengarang"
            value="{{ old('pengarang', $buku->pengarang ?? '') }}" placeholder="Contoh: Budi Raharjo" required />
        @error('pengarang')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="penerbit">Penerbit</label>
        <input type="text" class="form-control @error('penerbit') is-invalid @enderror" id="penerbit" name="penerbit"
            value="{{ old('penerbit', $buku->penerbit ?? '') }}" placeholder="Contoh: Informatika" required />
        @error('penerbit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="tahun_terbit">Tahun Terbit</label>
        <input type="number" class="form-control @error('tahun_terbit') is-invalid @enderror" id="tahun_terbit"
            name="tahun_terbit" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? date('Y')) }}" min="1900"
            max="{{ date('Y') }}" required />
        @error('tahun_terbit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="stok">Stok</label>
        <input type="number" class="form-control @error('stok') is-invalid @enderror" id="stok" name="stok"
            value="{{ old('stok', $buku->stok ?? 0) }}" min="0" required />
        @error('stok')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="lokasi_rak">Lokasi Rak</label>
        <input type="text" class="form-control @error('lokasi_rak') is-invalid @enderror" id="lokasi_rak"
            name="lokasi_rak" value="{{ old('lokasi_rak', $buku->lokasi_rak ?? '') }}" placeholder="Contoh: T-01"
            required />
        @error('lokasi_rak')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label" for="deskripsi">Deskripsi (opsional)</label>
        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4"
            placeholder="Tambahkan ringkasan atau keterangan buku">{{ old('deskripsi', $buku->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-bold">Gambar Saat Ini</label>
        <div class="d-flex flex-wrap gap-2 p-2 border rounded bg-light mb-2">
            @forelse($buku?->gambarBukus ?? [] as $img)
                <img src="{{ asset('storage/' . $img->lokasi_gambar) }}" width="80" height="80"
                    class="rounded border shadow-sm object-fit-cover">
            @empty
                <small class="text-muted p-2">Belum ada gambar.</small>
            @endforelse
        </div>

        <label class="form-label fw-bold">
            Upload Gambar Baru <span class="text-danger">*</span>
        </label>

        <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple
            accept="image/*">

        @error('images.*')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <small class="text-danger">
            *Jika upload file baru, semua gambar lama otomatis terhapus.
        </small>
    </div>

    <div class="col-12">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                @checked(old('is_active', $buku->is_active ?? 1))>
            <label class="form-check-label" for="is_active">
                Tampilkan buku ini di katalog
            </label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.buku.index') }}" class="btn btn-outline-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>