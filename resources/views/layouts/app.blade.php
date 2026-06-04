<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Supplier Pupuk - UD. Gading Tani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        :root {
            --hijau: #2d6a4f;
            --hijau-muda: #52b788;
            --hijau-terang: #d8f3dc;
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 72px;
            --content-radius: 18px;
        }

        body {
            background: #eef4ef;
            font-family: 'Segoe UI', sans-serif;
            color: #2b2b2b;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, #2d6a4f 0%, #1b4332 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 200;
            padding-top: 20px;
            transition: width 0.25s ease, transform 0.25s ease, padding 0.25s ease;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar .brand {
            padding: 16px 22px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar .brand i {
            font-size: 22px;
            color: #d8f3dc;
            min-width: 30px;
            text-align: center;
        }
        .sidebar .brand-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }
        .sidebar .brand-title {
            color: #fff;
            font-weight: 700;
            font-size: 14px;
            line-height: 1.2;
        }
        .sidebar .brand-subtitle {
            color: rgba(255, 255, 255, 0.82);
            font-size: 11px;
            line-height: 1.4;
        }
        .sidebar.collapsed .brand {
            justify-content: center;
            padding: 18px 0;
        }
        .sidebar.collapsed .brand-info {
            display: none;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.82);
            padding: 12px 22px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            transition: all .25s ease;
            border-left: 3px solid transparent;
            margin: 4px 12px;
        }
        .sidebar .nav-link i {
            min-width: 22px;
            text-align: center;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(255, 255, 255, 0.12);
            border-left-color: var(--hijau-muda);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.08);
        }
        .sidebar .nav-link.disabled {
            color: rgba(255, 255, 255, 0.45);
            pointer-events: none;
        }
        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 14px 0;
            margin-left: 6px;
            margin-right: 6px;
        }
        .sidebar .nav-text {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar.collapsed .nav-text {
            display: none;
        }

        .sidebar .nav-label {
            font-size: 10px;
            color: rgba(255, 255, 255, 0.55);
            padding: 18px 22px 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .sidebar.collapsed .nav-label {
            display: none;
        }

        /* ── Overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            z-index: 199;
        }
        .sidebar-overlay.show { display: block; }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 24px;
            transition: margin-left 0.25s ease, padding 0.25s ease;
            min-height: 100vh;
        }
        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* ── Topbar ── */
        .topbar {
            background: #fff;
            padding: 16px 22px;
            border-bottom: 1px solid #e8ece8;
            margin: -24px -24px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-radius: 0 0 var(--content-radius) var(--content-radius);
        }
        .topbar h5 { margin: 0; font-weight: 700; color: #1a1a1a; }
        .topbar small { color: #6b7280; }

        .btn-sidebar-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: #f4f7f4;
            border: 1px solid #d1e7d6;
            border-radius: 12px;
            color: #2d6a4f;
            font-size: 16px;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }
        .topbar-left {
            gap: 18px;
        }
        .btn-sidebar-toggle:hover {
            background: #e7f1ea;
            transform: translateY(-1px);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* ── Cards / Tables ── */
        .card { border: none; border-radius: 18px; box-shadow: 0 12px 35px rgba(80, 106, 88, 0.08); }
        .card-header { background: #fff; border-bottom: 1px solid #f0f3f0; padding: 16px 22px; font-weight: 700; }

        .btn-hijau { background: var(--hijau); color: #fff; }
        .btn-hijau:hover { background: #1b4332; color: #fff; }
        .badge-benefit { background: #d8f3dc; color: #1b4332; }
        .badge-cost    { background: #ffe0e0; color: #7f1d1d; }

        .table thead th { background: rgba(216, 243, 220, 0.65); color: var(--hijau); font-weight: 700; font-size: 13px; border: none; }
        .table tbody td { font-size: 13px; vertical-align: middle; }

        .ranking-1 { background: #fffbeb; }
        .ranking-2 { background: #f0f9ff; }
        .ranking-3 { background: #f0fdf4; }

        .medal-1 { color: #d97706; }
        .medal-2 { color: #6b7280; }
        .medal-3 { color: #92400e; }

        /* ── Responsive breakpoint ── */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: var(--sidebar-width);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar.collapsed {
                width: var(--sidebar-width);
            }
            .sidebar.collapsed .nav-text {
                display: inline-block;
            }
            .sidebar.collapsed .brand h6,
            .sidebar.collapsed .brand small,
            .sidebar.collapsed .nav-label {
                display: block;
            }
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            .topbar {
                margin: -16px -16px 16px;
                padding: 12px 16px;
            }
            .topbar-username {
                display: none;
            }
            .btn-sidebar-toggle {
                width: 40px;
                height: 40px;
            }
        }

        @media (min-width: 769px) {
            .sidebar { transform: translateX(0) !important; }
            .sidebar-overlay { display: none !important; }
        }
    </style>
</head>
<body>

{{-- Overlay (mobile only) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

{{-- Sidebar --}}
<div class="sidebar" id="sidebar">
    <div class="brand">
        <i class="fa fa-leaf"></i>
        <div class="brand-info">
            <span class="brand-title">UD. Gading Tani</span>
            <small class="brand-subtitle">SPK Pemilihan Supplier Pupuk</small>
        </div>
    </div>
    <div class="nav-label">Menu Utama</div>
    <a href="{{ route('supplier.index') }}"
       class="nav-link {{ request()->routeIs('supplier.*') ? 'active' : '' }}">
        <i class="fa fa-building fa-fw"></i>
        <span class="nav-text">Daftar Supplier</span>
    </a>
    <a href="{{ route('bobot.index') }}"
       class="nav-link {{ request()->routeIs('bobot.*') ? 'active' : '' }}">
        <i class="fa fa-cog fa-fw"></i>
        <span class="nav-text">Pengaturan Penilaian</span>
    </a>
    <div class="nav-label">Hasil Analisis</div>
    @php
        $totalBobots = \App\Models\Kriteria::sum('bobot');
        $supplierCount = \App\Models\Supplier::count();
        $rekomendasiLocked = abs($totalBobots - 1.0) > 0.0001 || $supplierCount === 0;
    @endphp
    <a href="{{ $rekomendasiLocked ? '#' : route('rekomendasi.index') }}"
       class="nav-link {{ request()->routeIs('rekomendasi.*') ? 'active' : '' }} {{ $rekomendasiLocked ? 'disabled' : '' }}"
       @if($rekomendasiLocked) title="Pastikan total bobot = 100% dan ada data supplier." @endif>
        <i class="fa fa-award fa-fw"></i>
        <span class="nav-text">Rekomendasi Supplier</span>
    </a>
</div>

{{-- Main content --}}
<div class="main-content">
    <div class="topbar">
        <div class="topbar-left d-flex align-items-center">
            <button class="btn-sidebar-toggle" id="sidebarToggleButton" onclick="toggleSidebar()" aria-label="Buka menu">
                <i class="fa fa-bars" id="sidebarToggleIcon"></i>
            </button>
            <div>
                <h5>@yield('title', 'Dashboard')</h5>
                <small class="text-muted">Aplikasi Pemilihan Supplier Pupuk</small>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end topbar-username">
                <small class="text-muted d-block">Login sebagai</small>
                <strong style="color: var(--hijau)">{{ Auth::user()->name }}</strong>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalLogout">
                <i class="fa fa-sign-out-alt"></i>
                <span class="d-none d-sm-inline ms-1">Logout</span>
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

{{-- Modal Logout --}}
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
                <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">Batal</button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');

    function updateSidebarIcon() {
        if (window.innerWidth <= 768) {
            sidebarToggleIcon.className = 'fa fa-bars';
            sidebarToggleIcon.parentElement.setAttribute('aria-label', 'Buka menu');
            return;
        }

        const isCollapsed = sidebar.classList.contains('collapsed');
        sidebarToggleIcon.className = isCollapsed ? 'fa fa-chevron-right' : 'fa fa-chevron-left';
        sidebarToggleIcon.parentElement.setAttribute('aria-label', isCollapsed ? 'Buka sidebar' : 'Sembunyikan sidebar');
    }

    function toggleSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('show');
            return;
        }

        sidebar.classList.toggle('collapsed');
        localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        updateSidebarIcon();
    }

    function closeSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
        }
    }

    function restoreSidebarState() {
        if (window.innerWidth > 768) {
            const collapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            sidebar.classList.toggle('collapsed', collapsed);
        }
        updateSidebarIcon();
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            restoreSidebarState();
        }
    });

    document.querySelectorAll('.sidebar .nav-link').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) closeSidebar();
        });
    });

    restoreSidebarState();
</script>
@stack('scripts')
</body>
</html>
