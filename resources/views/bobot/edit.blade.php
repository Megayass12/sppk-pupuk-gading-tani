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
                <label class="form-label fw-semibold">Kode Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                       value="{{ old('kode', $bobot->kode) }}" required>
                @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Kriteria <span class="text-danger">*</span></label>
                <input type="text" name="kriteria" class="form-control @error('kriteria') is-invalid @enderror"
                       value="{{ old('kriteria', $bobot->kriteria) }}" required>
                @error('kriteria')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tipe <span class="text-danger">*</span></label>
                <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                    <option value="benefit" {{ $bobot->tipe === 'benefit' ? 'selected' : '' }}>BENEFIT</option>
                    <option value="cost"    {{ $bobot->tipe === 'cost'    ? 'selected' : '' }}>COST</option>
                </select>
                @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nilai Bobot <span class="text-danger">*</span></label>
                <input type="number" name="bobot" class="form-control @error('bobot') is-invalid @enderror"
                       value="{{ old('bobot', $bobot->bobot) }}" step="0.01" min="0" max="1" required>
                @error('bobot')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $bobot->keterangan) }}</textarea>
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
