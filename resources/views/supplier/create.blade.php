@extends('layouts.app')
@section('title', 'Tambah Supplier')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="fa fa-plus me-2 text-success"></i>Tambah Supplier Baru
    </div>
    <div class="card-body">
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="kode_supplier" class="form-control @error('kode_supplier') is-invalid @enderror"
                           value="{{ old('kode_supplier') }}" placeholder="SUP001" required>
                    @error('kode_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror"
                           value="{{ old('nama_supplier') }}" placeholder="CV. Contoh" required>
                    @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat') }}" placeholder="Kota/Kabupaten">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="{{ old('telepon') }}" placeholder="08xx">
                </div>

                <div class="col-12"><hr><p class="fw-semibold text-success mb-0"><i class="fa fa-chart-bar me-1"></i>Data Kriteria SAW</p>
                <small class="text-muted">Isi nilai sesuai kondisi aktual supplier</small></div>

                <div class="col-md-4">
                    <label class="form-label">C1 – Harga (Rp/kg) <span class="text-danger">*</span>
                        <span class="badge badge-cost ms-1">COST</span></label>
                    <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror"
                           value="{{ old('harga') }}" placeholder="8500" min="0" required>
                    @error('harga')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">C2 – Kualitas (1–10) <span class="text-danger">*</span>
                        <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="kualitas" class="form-control @error('kualitas') is-invalid @enderror"
                           value="{{ old('kualitas') }}" step="0.1" min="1" max="10" placeholder="8.5" required>
                    @error('kualitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">C3 – Ketepatan Waktu (%) <span class="text-danger">*</span>
                        <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="ketepatan_waktu" class="form-control @error('ketepatan_waktu') is-invalid @enderror"
                           value="{{ old('ketepatan_waktu') }}" min="0" max="100" placeholder="90" required>
                    @error('ketepatan_waktu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">C4 – Kapasitas (ton/bulan) <span class="text-danger">*</span>
                        <span class="badge badge-benefit ms-1">BENEFIT</span></label>
                    <input type="number" name="kapasitas" class="form-control @error('kapasitas') is-invalid @enderror"
                           value="{{ old('kapasitas') }}" min="0" placeholder="50" required>
                    @error('kapasitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">C5 – Jarak (km) <span class="text-danger">*</span>
                        <span class="badge badge-cost ms-1">COST</span></label>
                    <input type="number" name="jarak" class="form-control @error('jarak') is-invalid @enderror"
                           value="{{ old('jarak') }}" step="0.1" min="0" placeholder="20" required>
                    @error('jarak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-hijau"><i class="fa fa-save me-1"></i>Simpan</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
