@extends('layouts.app')
@section('title', 'Rekomendasi Supplier')

@push('styles')
    <style>
        .recommendation-card {
            border-radius: 24px;
            border: 1px solid rgba(15, 23, 42, 0.08);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.08);
            overflow: hidden;
            background: #fff;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .recommendation-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.12);
        }
        .recommendation-card .card-body {
            padding: 1.8rem 1.5rem;
        }
        .recommendation-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.45rem 0.85rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }
        .recommendation-score {
            font-size: 1.55rem;
            font-weight: 800;
            color: #0f766e;
        }
        .recommendation-meta {
            background: #f8fafc;
            border-radius: 18px;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
        }
        .recommendation-meta small {
            color: #475569;
        }
        .mini-divider {
            width: 60px;
            height: 4px;
            border-radius: 999px;
            margin: 1.25rem auto 1rem;
        }
        .rank-1 {
            background: linear-gradient(180deg, #fffbf0 0%, #fff6e8 100%);
        }
        .rank-1 .recommendation-tag,
        .rank-1 .mini-divider {
            background: rgba(245, 158, 11, 0.14);
            color: #b45309;
        }
        .rank-1 .recommendation-score {
            color: #b45309;
        }
        .rank-2 {
            background: linear-gradient(180deg, #f0f9ff 0%, #eff6ff 100%);
        }
        .rank-2 .recommendation-tag,
        .rank-2 .mini-divider {
            background: rgba(59, 130, 246, 0.14);
            color: #2563eb;
        }
        .rank-2 .recommendation-score {
            color: #2563eb;
        }
        .rank-3 {
            background: linear-gradient(180deg, #ecfdf5 0%, #f0fdf4 100%);
        }
        .rank-3 .recommendation-tag,
        .rank-3 .mini-divider {
            background: rgba(16, 185, 129, 0.14);
            color: #047857;
        }
        .rank-3 .recommendation-score {
            color: #047857;
        }
        .table thead th {
            border-bottom: 2px solid #e6f2ea;
            background: #f7fcf6;
            color: #1f2937;
            vertical-align: middle;
        }
        .table tbody tr:hover {
            background: #f4faf5;
        }
        .table tbody td small {
            color: #6b7280;
        }
        .criteria-badge {
            font-size: 0.72rem;
            padding: 0.32rem 0.55rem;
            border-radius: 999px;
        }
        .collapse-card .card-header {
            cursor: pointer;
        }
        .collapse-card .expand-icon {
            transition: transform .2s ease;
        }
        .collapse-card .collapse.show + .card-footer .expand-icon,
        .collapse-card .card-header[aria-expanded="true"] .expand-icon {
            transform: rotate(180deg);
        }
    </style>
@endpush

@section('content')

@if(isset($error))
    <div class="alert alert-warning d-flex align-items-center gap-2">
        <i class="fa fa-triangle-exclamation"></i>
        <span>{{ $error }}</span>
    </div>
@endif

@if(count($hasil) >= 1)
    <div class="row g-3 mb-4">
        @foreach(array_slice($hasil, 0, 3) as $h)
        @php
            $rankClass = $loop->first ? 'rank-1' : ($loop->index == 1 ? 'rank-2' : 'rank-3');
            $label = 'Top '.$h['ranking'];
        @endphp
        <div class="col-md-4">
            <div class="card recommendation-card {{ $rankClass }} h-100 border-0">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="recommendation-tag">{{ $label }}</span>
                        <span class="text-muted small">Rank {{ $h['ranking'] }}</span>
                    </div>
                    <h5 class="fw-bold mb-2" style="line-height: 1.15;">{{ $h['supplier']->nama_supplier }}</h5>
                    <p class="text-muted mb-3">{{ $h['supplier']->kode }}</p>
                    <div class="recommendation-meta mb-3 text-start">
                        <div class="small text-muted">Lokasi</div>
                        <div class="fw-semibold">{{ $h['supplier']->alamat }}</div>
                    </div>
                    <div class="mini-divider"></div>
                    <div class="d-flex justify-content-between align-items-end mt-auto gap-3">
                        <div>
                            <div class="small text-muted">Skor akhir</div>
                            <div class="recommendation-score">{{ number_format($h['vi'] * 100, 2) }}%</div>
                        </div>
                        <div class="text-end">
                            <div class="small text-muted">Nilai</div>
                            <div class="fw-semibold">{{ number_format($h['vi'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

<div class="card mb-4">
    <div class="card-header bg-white border-0">
        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-list-ol text-warning"></i>
            <span class="fw-bold">Ranking Supplier Terbaik</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="text-center">Ranking</th>
                        <th>Nama Supplier</th>
                        @foreach($kriteria as $krit)
                        <th class="text-center" style="min-width: 110px;">
                            {{ $krit->nama_kriteria }}
                            <div><small class="fw-normal text-muted">(Bobot {{ number_format($krit->bobot * 100, 2) }}%)</small></div>
                        </th>
                        @endforeach
                        <th class="text-center">Skor Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hasil as $h)
                    <tr>
                        <td class="text-center fw-bold">{{ $h['ranking'] }}</td>
                        <td>
                            <strong>{{ $h['supplier']->nama_supplier }}</strong>
                            <div><small class="text-muted">{{ $h['supplier']->kode }}</small></div>
                        </td>
                        @foreach($kriteria as $krit)
                        @php $kode = 'C'.$loop->iteration; @endphp
                        <td class="text-center">
                            <div><small class="text-muted">Nilai {{ number_format($h['matriks'][$kode] ?? 0, 2) }}</small></div>
                            <div class="fw-semibold">{{ number_format($h['normal'][$kode] ?? 0, 2) }}</div>
                        </td>
                        @endforeach
                        <td class="text-center">
                            <span class="badge bg-success">{{ number_format($h['vi'] * 100, 2) }}%</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-3 pb-3 pt-2">
            <small class="text-muted">Penjelasan: angka kecil = nilai awal; angka tebal = nilai normalisasi berdasarkan bobot kriteria.</small>
        </div>
    </div>
</div>

<div class="card collapse-card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#langkahSAW" aria-expanded="false">
        <div class="d-flex align-items-center gap-2">
            <i class="fa fa-info-circle text-info"></i>
            <span class="fw-bold">Penjelasan Cara Perhitungan</span>
        </div>
        <i class="fa fa-chevron-down expand-icon"></i>
    </div>
    <div class="collapse" id="langkahSAW">
        <div class="card-body bg-light">
            <h6 class="mb-3">Bagaimana Sistem Ini Bekerja?</h6>
            <p class="small text-muted">Sistem menggunakan metode <strong>Weighted Average</strong> untuk menghitung skor akhir setiap supplier.</p>

            <h6 class="mt-3 mb-2">Step 1: Normalisasi</h6>
            <ul class="small">
                <li><strong>Lebih Tinggi Lebih Baik</strong> (benefit): nilai supplier dibagi nilai tertinggi.</li>
                <li><strong>Lebih Rendah Lebih Baik</strong> (cost): nilai terendah dibagi nilai supplier.</li>
            </ul>

            <h6 class="mt-3 mb-2">Step 2: Hitung Skor Akhir</h6>
            <p class="small text-muted">Skor akhir = jumlah dari bobot × nilai normalisasi untuk semua kriteria.</p>

            <h6 class="mt-3 mb-2">Step 3: Ranking</h6>
            <p class="small text-muted">Supplier dengan skor akhir tertinggi menempati posisi teratas.</p>

            <h6 class="mt-3 mb-2">Kriteria yang Digunakan</h6>
            <ul class="small">
                @foreach($kriteria as $krit)
                <li>
                    <strong>{{ $krit->nama_kriteria }}</strong> (Bobot {{ number_format($krit->bobot * 100, 2) }}%)
                    @if($krit->atribut === 'benefit')
                        <span class="badge criteria-badge bg-success text-white ms-1"><i class="fa fa-arrow-up"></i> Benefit</span>
                    @else
                        <span class="badge criteria-badge bg-danger text-white ms-1"><i class="fa fa-arrow-down"></i> Cost</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
