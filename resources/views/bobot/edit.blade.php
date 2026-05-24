@extends('layouts.app')
@section('title', 'Edit Kriteria')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-6">
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit me-2 text-warning"></i>Edit Kriteria: {{ $bobot->kriteria }}
    </div>
    <div class="card-body">
        <form action="{{ route('bobot.update', $bobot) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror"
                       value="{{ old('nama_kriteria', $bobot->nama_kriteria) }}" required>
                @error('nama_kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Atribut <span class="text-danger">*</span></label>
                <select name="atribut" class="form-select @error('atribut') is-invalid @enderror" required>
                    <option value="benefit" {{ old('atribut', $bobot->atribut) === 'benefit' ? 'selected' : '' }}>BENEFIT</option>
                    <option value="cost" {{ old('atribut', $bobot->atribut) === 'cost' ? 'selected' : '' }}>COST</option>
                </select>
                @error('atribut')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nilai Bobot <span class="text-danger">*</span></label>
                <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                       value="{{ old('bobot', $bobot->bobot) }}" step="0.0001" min="0" max="1" required>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-warning"><i class="fa fa-save me-1"></i>Update</button>
                <a href="{{ route('bobot.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
