@extends('layouts.app')
@section('title', 'Rekomendasi SAW')

@section('content')

@if(isset($error))
<div class="alert alert-warning"><i class="fa fa-exclamation-triangle me-2"></i>{{ $error }}</div>
@endif

{{-- Kartu Pemenang (Top 3) --}}
@if(count($hasil) >= 1)
<div class="row g-3 mb-4">
    @foreach(array_slice($hasil, 0, 3) as $h)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid {{ $loop->first ? '#d97706' : ($loop->index == 1 ? '#6b7280' : '#92400e') }} !important; border-top-style: solid !important;">
            <div class="card-body text-center py-4">
                <div class="display-6 mb-2">
                    @if($loop->first) 🥇
                    @elseif($loop->index == 1) 🥈
                    @else 🥉
                    @endif
                </div>
                <h6 class="fw-bold mb-1">{{ $h['supplier']->nama_supplier }}</h6>
                <small class="text-muted d-block mb-2">{{ $h['supplier']->kode_supplier }} &mdash; {{ $h['supplier']->alamat }}</small>
                <span class="badge bg-success fs-6 px-3 py-2">Vi = {{ $h['vi'] }}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Tabel Ranking Lengkap --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="fa fa-star me-2 text-warning"></i>Hasil Perankingan Supplier (Metode SAW)
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">Rank</th>
                    <th>Supplier</th>
                    @foreach($bobots as $b)
                    <th class="text-center" title="{{ $b->keterangan }}">
                        {{ $b->kode }}<br>
                        <small class="fw-normal text-muted">w={{ $b->bobot }}</small>
                    </th>
                    @endforeach
                    <th class="text-center">Nilai Vi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasil as $h)
                <tr class="{{ $h['ranking'] <= 3 ? 'ranking-'.$h['ranking'] : '' }}">
                    <td class="text-center fw-bold">
                        @if($h['ranking'] == 1) <span class="medal-1">🥇 1</span>
                        @elseif($h['ranking'] == 2) <span class="medal-2">🥈 2</span>
                        @elseif($h['ranking'] == 3) <span class="medal-3">🥉 3</span>
                        @else {{ $h['ranking'] }}
                        @endif
                    </td>
                    <td>
                        <strong>{{ $h['supplier']->nama_supplier }}</strong>
                        <small class="text-muted d-block">{{ $h['supplier']->kode_supplier }}</small>
                    </td>
                    @foreach($bobots as $b)
                    <td class="text-center">
                        <small class="text-muted d-block">{{ number_format($h['matriks'][$b->kode] ?? 0, 2) }}</small>
                        <strong>{{ number_format($h['normal'][$b->kode] ?? 0, 4) }}</strong>
                    </td>
                    @endforeach
                    <td class="text-center">
                        <span class="badge bg-success fs-6">{{ $h['vi'] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-3 pb-2 pt-1">
            <small class="text-muted"><em>Angka kecil abu-abu = nilai asli; angka tebal = nilai ternormalisasi (rij)</em></small>
        </div>
    </div>
</div>

{{-- Penjelasan Perhitungan --}}
<div class="card">
    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#langkahSAW" style="cursor:pointer">
        <i class="fa fa-calculator me-2 text-info"></i>Langkah Perhitungan SAW
        <i class="fa fa-chevron-down float-end"></i>
    </div>
    <div class="collapse" id="langkahSAW">
        <div class="card-body">
            <h6>Rumus Normalisasi:</h6>
            <ul class="small">
                <li><strong>BENEFIT:</strong> rij = Xij / max(Xij)</li>
                <li><strong>COST:</strong> rij = min(Xij) / Xij</li>
            </ul>
            <h6 class="mt-3">Rumus Nilai Preferensi:</h6>
            <p class="small">Vi = Σ (wj × rij) → jumlah dari (bobot × nilai normalisasi) semua kriteria</p>
            <h6 class="mt-3">Bobot yang Digunakan:</h6>
            <ul class="small">
                @foreach($bobots as $b)
                <li>{{ $b->kode }} – {{ $b->kriteria }}: <strong>{{ $b->bobot }}</strong>
                    <span class="badge {{ $b->tipe === 'benefit' ? 'badge-benefit' : 'badge-cost' }} ms-1">{{ strtoupper($b->tipe) }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
