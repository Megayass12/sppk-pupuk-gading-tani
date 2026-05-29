@extends('layouts.app')
@section('title', 'Rekomendasi Supplier')

@section('content')

@if(isset($error))
<div class="alert alert-warning"><i class="fa fa-exclamation-triangle me-2"></i>{{ $error }}</div>
@endif

@if(count($hasil) >= 1)
<div class="row g-3 mb-4">
    @foreach(array_slice($hasil, 0, 3) as $h)
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-top: 4px solid {{ $loop->first ? '#d97706' : ($loop->index == 1 ? '#6b7280' : '#92400e') }} !important; border-top-style: solid !important;">
            <div class="card-body text-center py-4">
                <div class="display-6 mb-2">
                    @if($loop->first) 🥇 Rekomendasi 1
                    @elseif($loop->index == 1) 🥈 Rekomendasi 2
                    @else 🥉 Rekomendasi 3
                    @endif
                </div>
                <h6 class="fw-bold mb-1">{{ $h['supplier']->nama_supplier }}</h6>
                <small class="text-muted d-block mb-3">{{ $h['supplier']->kode }} — {{ $h['supplier']->alamat }}</small>
                <div class="progress mb-2" style="height: 6px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ min($h['vi'] * 100, 100) }}%"></div>
                </div>
                <span class="badge bg-success fs-6 px-3 py-2">Skor: {{ number_format($h['vi'] * 100, 2) }}%</span>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <i class="fa fa-list-ol me-2 text-warning"></i>Ranking Supplier Terbaik
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-center">Ranking</th>
                    <th>Nama Supplier</th>
                    @foreach($kriteria as $krit)
                    <th class="text-center" title="{{ $krit->nama_kriteria }}">
                        {{ $krit->nama_kriteria }}<br>
                        <small class="fw-normal text-muted">(Bobot: {{ number_format($krit->bobot * 100, 2) }}%)</small>
                    </th>
                    @endforeach
                    <th class="text-center">Skor Akhir</th>
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
                        <small class="text-muted d-block">{{ $h['supplier']->kode }}</small>
                    </td>
                    @foreach($kriteria as $krit)
                    @php $kode = 'C'.$loop->iteration; @endphp
                    <td class="text-center">
                        <div>
                            <small class="text-muted d-block">Nilai: {{ number_format($h['matriks'][$kode] ?? 0, 2) }}</small>
                            <strong>{{ number_format($h['normal'][$kode] ?? 0, 2) }}</strong>
                        </div>
                    </td>
                    @endforeach
                    <td class="text-center">
                        <span class="badge bg-success fs-6">{{ number_format($h['vi'] * 100, 2) }}%</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-3 pb-2 pt-1">
            <small class="text-muted"><em>Penjelasan: Angka kecil = nilai awal; angka tebal = persentase bobot yang sudah dihitung sesuai kriteria</em></small>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header" data-bs-toggle="collapse" data-bs-target="#langkahSAW" style="cursor:pointer">
        <i class="fa fa-graduation-cap me-2 text-info"></i>Penjelasan Cara Perhitungan
        <i class="fa fa-chevron-down float-end"></i>
    </div>
    <div class="collapse" id="langkahSAW">
        <div class="card-body bg-light">
            <h6 class="mb-3">📊 Bagaimana Sistem Ini Bekerja?</h6>
            <p class="small text-muted">Sistem menggunakan metode <strong>Weighted Average (Rata-rata Berbobot)</strong> untuk menghitung skor akhir setiap supplier.</p>

            <h6 class="mt-3 mb-2">Step 1: Normalisasi Nilai</h6>
            <ul class="small">
                <li><strong>Untuk kriteria "Lebih Tinggi Lebih Baik"</strong> (seperti Kualitas):<br>
                    <code>Nilai Normalisasi = Nilai Supplier ÷ Nilai Tertinggi</code></li>
                <li><strong>Untuk kriteria "Lebih Rendah Lebih Baik"</strong> (seperti Harga):<br>
                    <code>Nilai Normalisasi = Nilai Terendah ÷ Nilai Supplier</code></li>
            </ul>

            <h6 class="mt-3 mb-2">Step 2: Perhitungan Skor Akhir</h6>
            <p class="small">Skor akhir = Jumlah dari (Bobot × Nilai Normalisasi) untuk semua kriteria</p>

            <h6 class="mt-3 mb-2">Step 3: Ranking</h6>
            <p class="small">Supplier dengan Skor Akhir terbesar mendapat ranking teratas</p>

            <h6 class="mt-3 mb-2">📋 Kriteria yang Digunakan:</h6>
            <ul class="small">
                @foreach($kriteria as $krit)
                <li><strong>{{ $krit->nama_kriteria }}</strong> (Bobot: {{ number_format($krit->bobot * 100, 2) }}%)
                    @if($krit->atribut === 'benefit')
                        <span class="badge badge-benefit ms-1">↑ Lebih Tinggi Lebih Baik</span>
                    @else
                        <span class="badge badge-cost ms-1">↓ Lebih Rendah Lebih Baik</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection
