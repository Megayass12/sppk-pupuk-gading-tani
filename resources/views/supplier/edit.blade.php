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
                    <label class="form-label fw-semibold">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                           value="{{ old('kode', $supplier->kode) }}" required>
                    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                    <label class="form-label fw-semibold">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $supplier->no_telp) }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                </div>

                <div class="col-12"><hr><p class="fw-semibold text-success mb-0"><i class="fa fa-chart-bar me-1"></i>Data Kriteria SAW</p></div>

                @forelse($kriteriaFields as $field)
                <div class="col-md-6">
                    <label class="form-label">{{ $field['label'] }}
                        <span class="badge {{ $field['badge'] === 'BENEFIT' ? 'badge-benefit' : 'badge-cost' }} ms-1">{{ $field['badge'] }}</span></label>
                    <input type="number" name="{{ $field['name'] }}" class="form-control @error('nilai.' . $field['id']) is-invalid @enderror"
                           value="{{ old('nilai.' . $field['id'], $nilai[$field['id']] ?? '') }}" step="{{ $field['step'] }}" min="{{ $field['min'] }}"
                           @if($field['max'] !== null) max="{{ $field['max'] }}" @endif required>
                    @error('nilai.' . $field['id'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning">Belum ada kriteria. Tambahkan kriteria terlebih dahulu sebelum mengedit supplier.</div>
                </div>
                @endforelse

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
