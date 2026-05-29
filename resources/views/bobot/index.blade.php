@extends('layouts.app')
@section('title', 'Pengaturan Penilaian')

@section('content')
<div class="row">
<div class="col-lg-8">
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fa fa-cog me-2 text-success"></i>Kriteria Penilaian Supplier</span>
        <a href="{{ route('bobot.create') }}" class="btn btn-sm btn-hijau">
            <i class="fa fa-plus me-1"></i>Tambah Kriteria Baru
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kriteria</th>
                    <th class="text-center">Jenis Nilai</th>
                    <th class="text-center">Bobot (%)</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kriteria as $b)
                <tr>
                    <td><strong>{{ $loop->iteration }}</strong></td>
                    <td>{{ $b->nama_kriteria }}</td>
                    <td class="text-center">
                        @if($b->atribut === 'benefit')
                            <span class="badge badge-benefit px-2 py-1" title="Semakin tinggi nilainya, semakin baik">↑ Lebih Tinggi Lebih Baik</span>
                        @else
                            <span class="badge badge-cost px-2 py-1" title="Semakin rendah nilainya, semakin baik">↓ Lebih Rendah Lebih Baik</span>
                        @endif
                    </td>
                    <td class="text-center fw-bold">{{ number_format($b->bobot * 100, 2) }}%</td>
                    <td class="text-center">
                        <a href="{{ route('bobot.edit', $b) }}" class="btn btn-sm btn-outline-warning" title="Ubah">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form action="{{ route('bobot.destroy', $b) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kriteria penilaian. <a href="{{ route('bobot.create') }}">Buat kriteria baru</a></td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-light">
                    <td colspan="3" class="text-end fw-bold">Total Bobot:</td>
                    <td class="text-center fw-bold {{ abs($totalKriteria - 1) < 0.0001 ? 'text-success' : 'text-danger' }}">
                        {{ number_format($totalKriteria * 100, 2) }}%
                        @if(abs($totalKriteria - 1) > 0.0001)
                            <i class="fa fa-exclamation-triangle ms-1" title="Total bobot harus = 100%"></i>
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
        <div class="card-header"><i class="fa fa-question-circle me-2 text-info"></i>Cara Kerja</div>
        <div class="card-body small text-muted">
            <p><strong>Total bobot harus = 100%</strong> agar sistem dapat menghitung rekomendasi dengan baik.</p>
            <hr>
            <p><strong>↑ Lebih Tinggi Lebih Baik</strong></p>
            <p class="small">Misal: Kualitas Produk, Kecepatan Pengiriman. Nilai lebih besar = lebih baik.</p>
            <hr>
            <p><strong>↓ Lebih Rendah Lebih Baik</strong></p>
            <p class="small">Misal: Harga, Waktu Pengiriman. Nilai lebih kecil = lebih baik.</p>
        </div>
    </div>
</div>
</div>
@endsection
