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

                <div class="col-md-4">
                    <label class="form-label">C1 – Harga (Rp/kg) <span class="badge badge-cost ms-1">COST</span></label>
                    <input type="number" name="harga" class="form-control" value="{{ old('harga', $supplier->harga) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">C2 – Kualitas (1–10) <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="kualitas" class="form-control" value="{{ old('kualitas', $supplier->kualitas) }}" step="0.1" min="1" max="10" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">C3 – Ketepatan Waktu (%) <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="ketepatan_waktu" class="form-control" value="{{ old('ketepatan_waktu', $supplier->ketepatan_waktu) }}" min="0" max="100" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">C4 – Kapasitas (ton/bulan) <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $supplier->kapasitas) }}" min="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">C5 – Jarak (km) <span class="badge badge-cost ms-1">COST</span></label>
                    <input type="number" name="jarak" class="form-control" value="{{ old('jarak', $supplier->jarak) }}" step="0.1" min="0" required>
                </div>

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
