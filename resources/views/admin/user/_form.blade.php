<div class="row g-4">
    <div class="col-md-6">
        <label class="form-label">NIK</label>
        <input type="text" class="form-control bg-light" value="{{ $kodeUser }}" readonly>
    </div>

    <div class="col-md-6">
        <label class="form-label">Nama</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label">Telepon (optional)</label>
        <input type="number" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
            value="{{ old('telepon', $user->telepon ?? '') }}">
        @error('telepon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label class="form-label">Alamat (optional)</label>
        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3"
            >{{ old('alamat', $user->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.user.index') }}" class="btn btn-outline-secondary">Kembali</a>
    <button class="btn btn-primary">{{ $submitLabel }}</button>
</div>