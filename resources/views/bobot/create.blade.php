@extends('layouts.app')
@section('title', isset($bobot) ? 'Edit Kriteria' : 'Tambah Kriteria')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <i class="fa fa-{{ isset($bobot) ? 'edit' : 'plus' }} me-2 text-success"></i>
        {{ isset($bobot) ? 'Edit Kriteria: '.$bobot->kriteria : 'Tambah Kriteria Baru' }}
    </div>
    <div class="card-body">
        <form action="{{ isset($bobot) ? route('bobot.update', $bobot) : route('bobot.store') }}" method="POST">
            @csrf
            @if(isset($bobot)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Kode Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode', $bobot->kode ?? '') }}" placeholder="C1" required>
                <div class="form-text">Harus sama dengan kode kolom di tabel supplier (C1–C5)</div>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="kriteria" class="form-control @error('kriteria') is-invalid @enderror"
                       value="{{ old('kriteria', $bobot->kriteria ?? '') }}" placeholder="Harga" required>
                @error('kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                    <option value="">-- Pilih Tipe --</option>
                    <option value="benefit" {{ old('tipe', $bobot->tipe ?? '') === 'benefit' ? 'selected' : '' }}>BENEFIT (lebih tinggi = lebih baik)</option>
                    <option value="cost"    {{ old('tipe', $bobot->tipe ?? '') === 'cost'    ? 'selected' : '' }}>COST (lebih rendah = lebih baik)</option>
                </select>
                @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nilai Bobot <span class="text-danger">*</span></label>
                <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                       value="{{ old('bobot', $bobot->bobot ?? '') }}" step="0.01" min="0" max="1" placeholder="0.30" required>
                <div class="form-text">Antara 0 dan 1. Total semua bobot harus = 1.0</div>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2"
                          placeholder="Deskripsi singkat kriteria...">{{ old('keterangan', $bobot->keterangan ?? '') }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-hijau">
                    <i class="fa fa-save me-1"></i>{{ isset($bobot) ? 'Update' : 'Simpan' }}
                </button>
                <a href="{{ route('bobot.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
