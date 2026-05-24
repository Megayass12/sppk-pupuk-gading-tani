@extends('layouts.app')
@section('title', isset($bobot) ? 'Edit Kriteria' : 'Tambah Kriteria')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <i class="fa fa-{{ isset($bobot) ? 'edit' : 'plus' }} me-2 text-success"></i>
        {{ isset($bobot) ? 'Edit Kriteria: '.$bobot->nama_kriteria : 'Tambah Kriteria Baru' }}
    </div>
    <div class="card-body">
        <form action="{{ isset($bobot) ? route('bobot.update', $bobot) : route('bobot.store') }}" method="POST">
            @csrf
            @if(isset($bobot)) @method('PUT') @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                       value="{{ old('nama_kriteria', $bobot->nama_kriteria ?? '') }}" placeholder="Harga" required>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Atribut <span class="text-danger">*</span></label>
                <select name="atribut" class="form-select @error('atribut') is-invalid @enderror" required>
                    <option value="">-- Pilih Atribut --</option>
                    <option value="benefit" {{ old('atribut', $bobot->atribut ?? '') === 'benefit' ? 'selected' : '' }}>BENEFIT (lebih tinggi = lebih baik)</option>
                    <option value="cost" {{ old('atribut', $bobot->atribut ?? '') === 'cost' ? 'selected' : '' }}>COST (lebih rendah = lebih baik)</option>
                </select>
                @error('atribut')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nilai Bobot <span class="text-danger">*</span></label>
                <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                       value="{{ old('bobot', $bobot->bobot ?? '') }}" step="0.0001" min="0" max="1" placeholder="0.30" required>
                <div class="form-text">Antara 0 dan 1. Total semua bobot harus = 1.0</div>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
