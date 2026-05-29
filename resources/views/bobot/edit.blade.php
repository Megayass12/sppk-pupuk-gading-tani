@extends('layouts.app')
@section('title', 'Ubah Kriteria')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit me-2 text-warning"></i>Ubah Kriteria: {{ $bobot->nama_kriteria }}
    </div>
    <div class="card-body">
        <form action="{{ route('bobot.update', $bobot) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                       value="{{ old('nama_kriteria', $bobot->nama_kriteria) }}" placeholder="Contoh: Kualitas Produk, Harga, dll" required>
                <small class="form-text text-muted">Nama kriteria yang akan digunakan untuk menilai supplier</small>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Nilai <span class="text-danger">*</span></label>
                <select name="atribut" class="form-select @error('atribut') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Nilai --</option>
                    <option value="benefit" {{ old('atribut', $bobot->atribut) === 'benefit' ? 'selected' : '' }}>↑ Lebih Tinggi Lebih Baik (Contoh: Kualitas, Kecepatan)</option>
                    <option value="cost" {{ old('atribut', $bobot->atribut) === 'cost' ? 'selected' : '' }}>↓ Lebih Rendah Lebih Baik (Contoh: Harga, Waktu Tunggu)</option>
                </select>
                @error('atribut')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Bobot/Persentase Pentingnya <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                           value="{{ old('bobot', $bobot->bobot * 100) }}" step="0.01" min="0" max="100" placeholder="30" required>
                    <span class="input-group-text">%</span>
                </div>
                <small class="form-text text-muted">Masukkan persentase dari 0 sampai 100. Contoh: 30 berarti kriteria ini 30% pentingnya</small>
                <div class="form-text text-warning mt-2"><i class="fa fa-info-circle me-1"></i><strong>Penting:</strong> Total semua bobot harus = 100%</div>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fa fa-save me-1"></i>Update Kriteria</button>
                <a href="{{ route('bobot.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
