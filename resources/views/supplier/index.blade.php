@extends('layouts.app')
@section('title', 'Data Supplier')

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa fa-truck me-2 text-success"></i>Daftar Supplier Pupuk</span>
        <div class="d-flex gap-2">
            <a href="{{ route('supplier.template') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-download me-1"></i>Template Excel
            </a>
            <a href="{{ route('supplier.export') }}" class="btn btn-sm btn-outline-success">
                <i class="fa fa-file-excel me-1"></i>Export Excel
            </a>
            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fa fa-upload me-1"></i>Import Excel
            </button>
            <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-hijau">
                <i class="fa fa-plus me-1"></i>Tambah Supplier
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Supplier</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Email</th>
                    @foreach($kriteria as $krit)
                    <th class="text-center">C{{ $loop->iteration }}<br><small>{{ $krit->nama_kriteria }}</small></th>
                    @endforeach
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($suppliers as $s)
                <tr>
                    <td><span class="badge bg-secondary">{{ $s->kode }}</span></td>
                    <td><strong>{{ $s->nama_supplier }}</strong></td>
                    <td class="text-muted">{{ $s->alamat }}</td>
                    <td>{{ $s->no_telp }}</td>
                    <td>{{ $s->email }}</td>
                    @foreach($kriteria as $krit)
                    @php $nilai = optional($s->penilaian->where('kriteria_id', $krit->id)->first())->nilai ?? 0; @endphp
                    <td class="text-center">{{ $nilai }}</td>
                    @endforeach
                    <td class="text-center">
                        <a href="{{ route('supplier.edit', $s) }}" class="btn btn-xs btn-outline-warning btn-sm">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('supplier.destroy', $s) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-xs btn-outline-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="{{ 5 + $kriteria->count() + 1 }}" class="text-center text-muted py-4">Belum ada data supplier.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($suppliers->hasPages())
    <div class="card-footer">{{ $suppliers->links() }}</div>
    @endif
</div>

{{-- Modal Import --}}
<div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><i class="fa fa-upload me-2"></i>Import Data Supplier dari Excel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('supplier.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info small mb-3">
                        <i class="fa fa-info-circle me-1"></i>
                        Download <a href="{{ route('supplier.template') }}">template Excel</a> terlebih dahulu.
                        Gunakan kolom: kode, nama_supplier, alamat, no_telp, email, dan setiap kriteria aktif sebagai "Kriteria: Nama Kriteria".
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-hijau btn-sm">
                        <i class="fa fa-upload me-1"></i>Import Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
