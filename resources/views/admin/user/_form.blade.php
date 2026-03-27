<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">NIK / Nomor User</label>
        <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
            value="{{ old('nik', $user->nik ?? $otomatisKode) }}" readonly style="background-color: #f8f9fa;">
        @error('nik')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}" placeholder="Masukkan nama lengkap">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
            value="{{ old('telepon', $user->telepon ?? '') }}" placeholder="Contoh: 08123456789">
        @error('telepon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror"
            placeholder="Masukkan alamat lengkap">{{ old('alamat', $user->alamat ?? '') }}</textarea>
        @error('alamat')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>