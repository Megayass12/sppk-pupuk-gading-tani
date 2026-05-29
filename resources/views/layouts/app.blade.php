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
    <div class="nav-label">Menu Utama</div>
    <a href="{{ route('supplier.index') }}"
       class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
        <i class="fa fa-building fa-fw"></i> Daftar Supplier
    </a>
    <a href="{{ route('bobot.index') }}"
       class="nav-link {{ request()->routeIs('bobot.*') ? 'active' : '' }}">
        <i class="fa fa-cog fa-fw"></i> Pengaturan Penilaian
    </a>
    <div class="nav-label">Hasil Analisis</div>
    @php
        $totalBobots = \App\Models\Kriteria::sum('bobot');
        $supplierCount = \App\Models\Supplier::count();
        $rekomendasiLocked = abs($totalBobots - 1.0) > 0.0001 || $supplierCount === 0;
    @endphp
    <a href="{{ $rekomendasiLocked ? '#' : route('rekomendasi.index') }}"
       class="nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }} {{ $rekomendasiLocked ? 'disabled' : '' }}"
       @if($rekomendasiLocked) title="Untuk melihat rekomendasi, pastikan total bobot pengaturan = 100% dan ada data supplier." @endif>
        <i class="fa fa-award fa-fw"></i> Rekomendasi Supplier
    </a>
</div>

<!-- Main content -->
<div class="main-content">
    <div class="topbar">
        <div>
            <h5>@yield('title', 'Dashboard')</h5>
            <small class="text-muted">Aplikasi Pemilihan Supplier Pupuk</small>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end">
                <small class="text-muted d-block">Login sebagai</small>
                <strong class="text-hijau">{{ Auth::user()->name }}</strong>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalLogout">
                <i class="fa fa-sign-out-alt"></i> Logout
            </button>
        </div>
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
    <!-- Modal Konfirmasi Logout -->
    <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 380px;">
        <div class="modal-content border-0 shadow" style="border-radius: 12px;">

        <div class="modal-body text-center px-4 pt-4 pb-3">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: #ffe0e0;
                        display: flex; align-items: center; justify-content: center;
                        margin: 0 auto 16px;">
            <i class="fa fa-sign-out-alt fa-lg" style="color: #c0392b;"></i>
            </div>
            <h6 class="fw-bold mb-1" style="color: #1a1a1a;">Keluar dari website?</h6>
            <p class="text-muted mb-0" style="font-size: 13px;">
            Anda akan keluar dari sesi ini. Pastikan semua data sudah tersimpan sebelum melanjutkan.
            </p>
        </div>

        <div class="modal-footer border-0 px-4 pb-4 pt-2 d-flex gap-2">
            <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">
            Batal
            </button>
            <form action="{{ route('logout') }}" method="POST" class="flex-fill">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="fa fa-sign-out-alt me-1"></i> Ya, Keluar
            </button>
            </form>
        </div>

        </div>
    </div>
    </div>
</body>
</html>
