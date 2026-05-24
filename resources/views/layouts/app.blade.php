<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Supplier Pupuk - UD. Gading Tani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --hijau: #2d6a4f; --hijau-muda: #52b788; --hijau-terang: #d8f3dc; }
        body { background: #f4f7f4; font-family: 'Segoe UI', sans-serif; }

        .sidebar {
            width: 250px; min-height: 100vh;
            background: var(--hijau);
            position: fixed; top: 0; left: 0; z-index: 100;
            padding-top: 20px;
        }
        .sidebar .brand {
            padding: 16px 20px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }
        .sidebar .brand h6 { color: #fff; font-weight: 700; margin: 0; font-size: 14px; }
        .sidebar .brand small { color: var(--hijau-terang); font-size: 11px; }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.75); padding: 10px 20px;
            border-radius: 0; display: flex; align-items: center; gap: 10px;
            font-size: 14px; transition: all .2s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff; background: rgba(255,255,255,0.15);
            border-left: 3px solid var(--hijau-muda);
        }
        .sidebar .nav-link.disabled {
            color: rgba(255,255,255,0.45);
            opacity: 0.7;
            pointer-events: none;
        }
        .sidebar .nav-label {
            font-size: 10px; color: rgba(255,255,255,0.4);
            padding: 16px 20px 6px; text-transform: uppercase; letter-spacing: 1px;
        }

        .main-content { margin-left: 250px; padding: 24px; }
        .topbar {
            background: #fff; padding: 14px 24px;
            border-bottom: 1px solid #e2e8e2;
            margin: -24px -24px 24px; display: flex;
            align-items: center; justify-content: space-between;
        }
        .topbar h5 { margin: 0; font-weight: 600; color: #1a1a1a; }

        .card { border: none; border-radius: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.06); }
        .card-header { background: #fff; border-bottom: 1px solid #eee; padding: 14px 20px; font-weight: 600; }

        .btn-hijau { background: var(--hijau); color: #fff; }
        .btn-hijau:hover { background: #1b4332; color: #fff; }
        .badge-benefit { background: #d8f3dc; color: #1b4332; }
        .badge-cost    { background: #ffe0e0; color: #7f1d1d; }

        .table thead th { background: var(--hijau-terang); color: var(--hijau); font-weight: 600; font-size: 13px; border: none; }
        .table tbody td { font-size: 13px; vertical-align: middle; }

        .ranking-1 { background: #fffbeb; }
        .ranking-2 { background: #f0f9ff; }
        .ranking-3 { background: #f0fdf4; }

        .medal-1 { color: #d97706; }
        .medal-2 { color: #6b7280; }
        .medal-3 { color: #92400e; }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="brand">
        <h6><i class="fa fa-leaf me-2"></i>UD. Gading Tani</h6>
        <small>SPK Pemilihan Supplier Pupuk</small>
    </div>
    <div class="nav-label">Menu</div>
    <a href="{{ route('supplier.index') }}"
       class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
        <i class="fa fa-truck fa-fw"></i> Data Supplier
    </a>
    <a href="{{ route('bobot.index') }}"
       class="nav-link {{ request()->routeIs('bobot.*') ? 'active' : '' }}">
        <i class="fa fa-sliders fa-fw"></i> Bobot Kriteria
    </a>
    <div class="nav-label">Hasil</div>
    @php
        $totalBobots = \App\Models\Kriteria::sum('bobot');
        $supplierCount = \App\Models\Supplier::count();
        $rekomendasiLocked = abs($totalBobots - 1.0) > 0.0001 || $supplierCount === 0;
    @endphp
    <a href="{{ $rekomendasiLocked ? '#' : route('rekomendasi.index') }}"
       class="nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }} {{ $rekomendasiLocked ? 'disabled' : '' }}"
       @if($rekomendasiLocked) title="Menu rekomendasi terkunci. Pastikan total bobot = 1 dan ada supplier." @endif>
        <i class="fa fa-star fa-fw"></i> Rekomendasi SAW
    </a>
</div>

<!-- Main content -->
<div class="main-content">
    <div class="topbar">
        <h5>@yield('title', 'Dashboard')</h5>
        <small class="text-muted">Sistem Pendukung Keputusan &mdash; Metode SAW</small>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
