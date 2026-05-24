@extends('layouts.app')
@section('title', 'Edit Supplier')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="fa fa-edit me-2 text-warning"></i>Edit Supplier: {{ $supplier->nama_supplier }}
    </div>
    <div class="card-body">
        <form action="{{ route('supplier.update', $supplier) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="kode_supplier" class="form-control @error('kode_supplier') is-invalid @enderror"
                           value="{{ old('kode_supplier', $supplier->kode_supplier) }}" required>
                    @error('kode_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror"
                           value="{{ old('nama_supplier', $supplier->nama_supplier) }}" required>
                    @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $supplier->alamat) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $supplier->telepon) }}">
                </div>

                <div class="col-12"><hr><p class="fw-semibold text-success mb-0"><i class="fa fa-chart-bar me-1"></i>Data Kriteria SAW</p></div>

                @if(isset($unsupportedBobyts) && $unsupportedBobyts->isNotEmpty())
                <div class="col-12">
                    <div class="alert alert-warning mb-3">
                        <i class="fa fa-exclamation-triangle me-2"></i>Beberapa kriteria tidak didukung oleh tabel supplier saat ini:
                        {{ $unsupportedBobyts->pluck('kode')->implode(', ') }}.
                        Silakan gunakan kode C1–C5 atau perbarui schema supplier.
                    </div>
                </div>
                @endif

                @foreach($kriteriaFields as $field)
                <div class="{{ in_array($field['column'], ['harga','kualitas','ketepatan_waktu']) ? 'col-md-4' : 'col-md-6' }}">
                    <label class="form-label">{{ $field['label'] }}
                        <span class="badge {{ $field['badge'] === 'BENEFIT' ? 'badge-benefit' : 'badge-cost' }} ms-1">{{ $field['badge'] }}</span></label>
                    <input type="number" name="{{ $field['column'] }}" class="form-control @error($field['column']) is-invalid @enderror"
                           value="{{ old($field['column'], $supplier->{$field['column']}) }}" step="{{ $field['step'] }}" min="{{ $field['min'] }}"
                           @if($field['max'] !== null) max="{{ $field['max'] }}" @endif required>
                    @error($field['column'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endforeach

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-warning"><i class="fa fa-save me-1"></i>Update</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
