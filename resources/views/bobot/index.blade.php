@extends('layouts.app')
@section('title', 'Bobot Kriteria')

@section('content')
<div class="row">
<div class="col-lg-8">
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa fa-sliders me-2 text-success"></i>Daftar Bobot Kriteria</span>
        <a href="{{ route('bobot.create') }}" class="btn btn-sm btn-hijau">
            <i class="fa fa-plus me-1"></i>Tambah Kriteria
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Kriteria</th>
                    <th class="text-center">Atribut</th>
                    <th class="text-center">Bobot</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriteria as $b)
                <tr>
                    <td><strong>C{{ $loop->iteration }}</strong></td>
                    <td>{{ $b->nama_kriteria }}</td>
                    <td class="text-center">
                        @if($b->atribut === 'benefit')
                            <span class="badge badge-benefit px-2 py-1">BENEFIT</span>
                        @else
                            <span class="badge badge-cost px-2 py-1">COST</span>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ $b->bobot }}</td>
                    <td class="text-center">
                        <a href="{{ route('bobot.edit', $b) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('bobot.destroy', $b) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Hapus kriteria ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data kriteria.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="3" class="text-end fw-bold">Total Bobot:</td>
                    <td class="text-center fw-bold {{ abs($totalKriteria - 1) < 0.0001 ? 'text-success' : 'text-danger' }}">
                        {{ $totalKriteria }}
                        @if(abs($totalKriteria - 1) > 0.0001)
                            <i class="fa fa-exclamation-triangle ms-1" title="Total bobot harus = 1"></i>
                        @else
                            <i class="fa fa-check-circle ms-1"></i>
                        @endif
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header"><i class="fa fa-info-circle me-2 text-info"></i>Panduan Kriteria</div>
        <div class="card-body small text-muted">
            <p><strong>Total bobot harus = 1.0</strong></p>
            <p><strong>BENEFIT</strong> – Nilai lebih tinggi lebih baik.</p>
            <p><strong>COST</strong> – Nilai lebih rendah lebih baik.</p>
            <p>Nama kriteria akan digunakan sebagai label dinamis pada penilaian supplier.</p>
        </div>
    </div>
</div>
</div>
@endsection
