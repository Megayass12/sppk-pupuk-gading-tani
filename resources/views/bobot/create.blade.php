@extends('layouts.app')
@section('title', isset($bobot) ? 'Ubah Kriteria' : 'Tambah Kriteria Penilaian')

@section('content')
<!-- Simplified Sticky Weight Info -->
<div class="sticky-top mb-3" style="top: 0; z-index: 100; background: #f8f9fa; border-bottom: 2px solid #0dcaf0; padding: 12px 0;">
    <div class="container-fluid px-md-5">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-sm-4">
                <small class="text-muted d-block">Bobot Tersimpan</small>
                <div class="fw-bold text-primary" style="font-size: 1.25rem;">{{ number_format($totalKriteria * 100, 2) }}%</div>
            </div>
            <div class="col-12 col-sm-4">
                <small class="text-muted d-block">Sisa Bobot Tersedia</small>
                <div class="fw-bold text-success" style="font-size: 1.25rem;">{{ number_format($availableBobot * 100, 2) }}%</div>
            </div>
            <div class="col-12 col-sm-4">
                <small class="text-muted d-block">Total Target</small>
                <div class="fw-bold text-info" style="font-size: 1.25rem;">100%</div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <i class="fa fa-{{ isset($bobot) ? 'edit' : 'plus' }} me-2 text-success"></i>
        {{ isset($bobot) ? 'Ubah Kriteria: '.$bobot->nama_kriteria : 'Tambah Kriteria Penilaian Baru' }}
    </div>
    <div class="card-body">
        <form action="{{ isset($bobot) ? route('bobot.update', $bobot) : route('bobot.store') }}" method="POST">
            @csrf
            @if(isset($bobot)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                       value="{{ old('nama_kriteria', $bobot->nama_kriteria ?? '') }}" placeholder="Contoh: Kualitas Produk, Harga, dll" required>
                <small class="form-text text-muted">Nama kriteria yang akan digunakan untuk menilai supplier</small>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Nilai <span class="text-danger">*</span></label>
                <select name="atribut" class="form-select @error('atribut') is-invalid @enderror" required>
                    <option value="">-- Pilih Jenis Nilai --</option>
                    <option value="benefit" {{ old('atribut', $bobot->atribut ?? '') === 'benefit' ? 'selected' : '' }}>↑ Lebih Tinggi Lebih Baik (Contoh: Kualitas, Kecepatan)</option>
                    <option value="cost" {{ old('atribut', $bobot->atribut ?? '') === 'cost' ? 'selected' : '' }}>↓ Lebih Rendah Lebih Baik (Contoh: Harga, Waktu Tunggu)</option>
                </select>
                @error('atribut')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Bobot/Persentase Pentingnya <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                           value="{{ old('bobot', isset($bobot) ? number_format($bobot->bobot * 100, 2, '.', '') : '') }}" step="0.01" min="0" max="100" placeholder="30" required>
                    <span class="input-group-text">%</span>
                </div>
                <small class="form-text text-muted">Masukkan persentase dari 0 sampai 100. Contoh: 30 berarti kriteria ini 30% pentingnya</small>
                <div class="form-text text-warning mt-2"><i class="fa fa-info-circle me-1"></i><strong>Penting:</strong> Total semua bobot harus = 100%</div>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-hijau">
                    <i class="fa fa-save me-1"></i>{{ isset($bobot) ? 'Update Kriteria' : 'Simpan Kriteria' }}
                </button>
                <a href="{{ route('bobot.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
