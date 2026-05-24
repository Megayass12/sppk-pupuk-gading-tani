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
                    <label class="form-label">{{ $field['label'] }} <span class="text-danger">*</span>
                        <span class="badge {{ $field['badge'] === 'BENEFIT' ? 'badge-benefit' : 'badge-cost' }} ms-1">{{ $field['badge'] }}</span></label>
                    <input type="number" name="{{ $field['column'] }}" class="form-control @error($field['column']) is-invalid @enderror"
                           value="{{ old($field['column']) }}" step="{{ $field['step'] }}" min="{{ $field['min'] }}"
                           @if($field['max'] !== null) max="{{ $field['max'] }}" @endif placeholder="" required>
                    @error($field['column'])<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @endforeach

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
