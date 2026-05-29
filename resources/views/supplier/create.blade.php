@extends('layouts.app')
@section('title', isset($supplier) ? 'Ubah Data Supplier' : 'Tambah Supplier Baru')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header">
        <i class="fa fa-{{ isset($supplier) ? 'edit' : 'plus' }} me-2 text-success"></i>
        {{ isset($supplier) ? 'Ubah Data Supplier: '.$supplier->nama_supplier : 'Tambah Supplier Baru' }}
    </div>
    <div class="card-body">
        <form action="{{ isset($supplier) ? route('supplier.update', $supplier) : route('supplier.store') }}" method="POST">
            @csrf
            @if(isset($supplier)) @method('PUT') @endif
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                           value="{{ old('kode', $supplier->kode ?? '') }}" placeholder="S001" required {{ isset($supplier) ? 'readonly' : '' }}>
                    @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Supplier <span class="text-danger">*</span></label>
                    <input type="text" name="nama_supplier" class="form-control @error('nama_supplier') is-invalid @enderror"
                           value="{{ old('nama_supplier', $supplier->nama_supplier ?? '') }}" placeholder="Nama perusahaan supplier" required>
                    @error('nama_supplier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Lokasi/Kota</label>
                    <input type="text" name="alamat" class="form-control" value="{{ old('alamat', $supplier->alamat ?? '') }}" placeholder="Contoh: Surabaya">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor Telepon</label>
                    <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $supplier->no_telp ?? '') }}" placeholder="08xxxxxxxxxx">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}" placeholder="email@perusahaan.com">
                </div>

                <div class="col-12"><hr><p class="fw-semibold text-success mb-0"><i class="fa fa-star me-1"></i>Data Penilaian Supplier</p>
                <small class="text-muted">Isikan nilai untuk setiap kriteria penilaian</small></div>

                @forelse($kriteriaFields as $field)
                <div class="col-md-6">
                    <label class="form-label">{{ $field['label'] }} <span class="text-danger">*</span>
                        <span class="badge {{ $field['badgeClass'] }} ms-1" title="Cara penilaian kriteria ini">
                            {{ $field['badgeLabel'] }}
                        </span>
                    </label>
                    <input type="number" name="{{ $field['name'] }}" class="form-control @error('nilai.' . $field['id']) is-invalid @enderror"
                           value="{{ old('nilai.' . $field['id'], isset($supplier) && $supplier->penilaian ? $supplier->penilaian->where('kriteria_id', $field['id'])->first()?->nilai : '') }}"
                           step="{{ $field['step'] }}" min="{{ $field['min'] }}"
                           @if($field['max'] !== null) max="{{ $field['max'] }}" @endif required>
                    @error('nilai.' . $field['id'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-warning"><i class="fa fa-exclamation-triangle me-1"></i>Belum ada kriteria penilaian. <a href="{{ route('bobot.index') }}">Buat kriteria di sini terlebih dahulu</a></div>
                </div>
                @endforelse

                <div class="col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-hijau"><i class="fa fa-save me-1"></i>{{ isset($supplier) ? 'Update Data' : 'Simpan Supplier' }}</button>
                    <a href="{{ route('supplier.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
