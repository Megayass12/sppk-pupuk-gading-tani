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
                    <th>Kriteria</th>
                    <th class="text-center">Tipe</th>
                    <th class="text-center">Bobot</th>
                    <th>Keterangan</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bobots as $b)
                <tr>
                    <td><strong>{{ $b->kode }}</strong></td>
                    <td>{{ $b->kriteria }}</td>
                    <td class="text-center">
                        @if($b->tipe === 'benefit')
                            <span class="badge badge-benefit px-2 py-1">BENEFIT</span>
                        @else
                            <span class="badge badge-cost px-2 py-1">COST</span>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ $b->bobot }}</td>
                    <td class="text-muted small">{{ $b->keterangan }}</td>
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
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data bobot.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="3" class="text-end fw-bold">Total Bobot:</td>
                    <td class="text-center fw-bold {{ $totalBobot == 1 ? 'text-success' : 'text-danger' }}">
                        {{ $totalBobot }}
                        @if($totalBobot != 1)
                            <i class="fa fa-exclamation-triangle ms-1" title="Total bobot harus = 1"></i>
                        @else
                            <i class="fa fa-check-circle ms-1"></i>
                        @endif
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header"><i class="fa fa-info-circle me-2 text-info"></i>Panduan Bobot</div>
        <div class="card-body small text-muted">
            <p><strong>Total bobot harus = 1.0</strong></p>
            @if($totalBobot != 1)
                <p class="text-danger mb-2"><strong>Rekomendasi SAW terkunci sampai total bobot menjadi 1.0.</strong></p>
            @endif
            <p><strong>BENEFIT</strong> – Nilai lebih tinggi lebih baik.<br>Contoh: Kualitas, Ketepatan Waktu, Kapasitas</p>
            <p><strong>COST</strong> – Nilai lebih rendah lebih baik.<br>Contoh: Harga, Jarak</p>
            <p>Kode kriteria harus sama dengan yang digunakan di sistem (C1–C5 untuk kolom default).</p>
        </div>
    </div>
</div>
</div>
@endsection
