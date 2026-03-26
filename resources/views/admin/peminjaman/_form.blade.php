<div class="row g-4">

    <div class="col-md-6">
        <label class="form-label">Peminjam</label>
        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror">
            <option value="">Pilih anggota</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Buku</label>
        <select name="buku_id" class="form-select @error('buku_id') is-invalid @enderror">
            <option value="">Pilih buku</option>
            @foreach($bukus as $buku)
                <option value="{{ $buku->id }}" @selected(old('buku_id') == $buku->id)>
                    {{ $buku->nama }} (Stok: {{ $buku->stok }})
                </option>
            @endforeach
        </select>
        @error('buku_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
    <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
</div>