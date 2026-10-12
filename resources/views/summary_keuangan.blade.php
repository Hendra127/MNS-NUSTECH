<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summary Keuangan | Project Operational</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --blue-primary: #2563eb;
            --blue-light: #eff6ff;
            --blue-dark: #1d4ed8;
            --green-primary: #059669;
            --green-light: #ecfdf5;
            --purple-primary: #7c3aed;
            --purple-light: #f5f3ff;
            --orange-primary: #ea580c;
            --orange-light: #fff7ed;
            --cyan-primary: #0891b2;
            --cyan-light: #ecfeff;
            --red-primary: #dc2626;
            --card-shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.05);
            --card-shadow-hover: 0 8px 30px rgba(0,0,0,.12);
            --radius: 16px;
            --radius-sm: 10px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        /* ─── TOPBAR ─── */
        .summary-topbar {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #2563eb 100%);
            color: white;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 2px 16px rgba(37,99,235,.25);
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 1.05rem;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }

        .topbar-brand .brand-icon {
            width: 34px;
            height: 34px;
            background: rgba(255,255,255,.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        /* ─── PAGE HEADER ─── */
        .page-header {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 20px 28px;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
        }

        .page-header .subtitle {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 3px;
        }

        /* ─── FILTER BAR ─── */
        .filter-bar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-bar select {
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 7px 14px;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: #334155;
            background: white;
            cursor: pointer;
            outline: none;
            transition: border-color .2s;
        }

        .filter-bar select:focus {
            border-color: #2563eb;
        }

        .btn-apply {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 7px 18px;
            font-size: 0.875rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-apply:hover { background: #1d4ed8; }

        /* ─── MAIN CONTENT ─── */
        .main-content {
            padding: 24px 28px;
            max-width: 1600px;
            margin: 0 auto;
        }

        /* ─── GRAND TOTAL BANNER ─── */
        .grand-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: var(--radius);
            padding: 24px 28px;
            color: white;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .grand-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(37,99,235,.25) 0%, transparent 70%);
            pointer-events: none;
        }

        .grand-banner .label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            opacity: .65;
            font-weight: 600;
        }

        .grand-banner .value {
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .grand-banner .period {
            font-size: 0.85rem;
            opacity: .75;
            margin-top: 2px;
        }

        .grand-pill {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        /* ─── SECTION TITLE ─── */
        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title .icon-badge {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        /* ─── STAT CARDS ─── */
        .stat-card {
            background: white;
            border-radius: var(--radius);
            padding: 20px 22px;
            box-shadow: var(--card-shadow);
            transition: box-shadow .25s, transform .25s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .stat-card .card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 14px;
        }

        .stat-card .card-label {
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #64748b;
            margin-bottom: 6px;
        }

        .stat-card .card-value {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -.02em;
        }

        .stat-card .card-sub {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        .stat-card .card-stripe {
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            border-radius: 16px 0 0 16px;
        }

        /* ─── SECTION CARD ─── */
        .section-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 24px;
        }

        .section-card .card-header-custom {
            padding: 18px 22px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
        }

        .section-card .card-header-custom h3 {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-card .card-body-custom {
            padding: 20px 22px;
        }

        /* ─── DATA TABLE ─── */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.83rem;
        }

        .data-table thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: .06em;
            padding: 10px 14px;
            border-bottom: 1.5px solid #e2e8f0;
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .data-table tbody tr:last-child td { border-bottom: none; }

        .data-table tbody tr:hover td { background: #f8fafc; }

        .data-table .total-row td {
            background: #eff6ff !important;
            font-weight: 700;
            color: #1d4ed8;
            font-size: 0.85rem;
        }

        /* ─── BADGE ─── */
        .cat-badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: .04em;
        }

        /* ─── KABUPATEN CARD ─── */
        .kab-card {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: var(--radius-sm);
            padding: 14px 16px;
            transition: border-color .2s, box-shadow .2s;
        }

        .kab-card:hover {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(37,99,235,.08);
        }

        .kab-card .kab-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 4px;
        }

        .kab-card .kab-total {
            font-size: 1rem;
            font-weight: 800;
            color: #2563eb;
        }

        .kab-card .kab-count {
            font-size: 0.73rem;
            color: #64748b;
            margin-top: 2px;
        }

        .kab-card .site-pills {
            margin-top: 8px;
            display: flex;
            flex-wrap: wrap;
            gap: 4px;
        }

        .site-pill {
            background: #dbeafe;
            color: #1d4ed8;
            border-radius: 4px;
            font-size: 0.68rem;
            padding: 2px 7px;
            font-weight: 500;
        }

        /* ─── CHART CARD ─── */
        .chart-card {
            background: white;
            border-radius: var(--radius);
            box-shadow: var(--card-shadow);
            padding: 22px;
            height: 100%;
        }

        .chart-card .chart-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .chart-card .chart-subtitle {
            font-size: 0.77rem;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        /* ─── EMPTY STATE ─── */
        .empty-state {
            text-align: center;
            padding: 36px 20px;
            color: #94a3b8;
        }

        .empty-state i { font-size: 2.5rem; margin-bottom: 10px; }
        .empty-state p { font-size: 0.88rem; margin: 0; }

        /* ─── COLORS ─── */
        .c-blue  { color: #2563eb; }
        .c-green { color: #059669; }
        .c-purple{ color: #7c3aed; }
        .c-orange{ color: #ea580c; }
        .c-cyan  { color: #0891b2; }
        .c-red   { color: #dc2626; }

        .bg-blue-soft   { background: #eff6ff; }
        .bg-green-soft  { background: #ecfdf5; }
        .bg-purple-soft { background: #f5f3ff; }
        .bg-orange-soft { background: #fff7ed; }
        .bg-cyan-soft   { background: #ecfeff; }

        /* ─── ITEMS LIST ─── */
        .item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #e2e8f0;
            font-size: 0.83rem;
        }

        .item-row:last-child { border-bottom: none; }

        .item-name {
            color: #334155;
            flex: 1;
            padding-right: 12px;
        }

        .item-qty {
            background: #f1f5f9;
            color: #475569;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 0.72rem;
            font-weight: 600;
            margin-right: 10px;
            white-space: nowrap;
        }

        .item-price {
            color: #1d4ed8;
            font-weight: 700;
            white-space: nowrap;
        }

        /* ─── TOTAL SUMMARY ─── */
        .total-summary {
            background: linear-gradient(135deg, #eff6ff, #f0fdf4);
            border: 1.5px solid #bfdbfe;
            border-radius: var(--radius-sm);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
        }

        .total-summary .label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #1e40af;
        }

        .total-summary .value {
            font-size: 1.05rem;
            font-weight: 800;
            color: #1d4ed8;
        }

        /* ─── DIVIDER BADGE ─── */
        .sub-section-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .main-content { padding: 16px; }
            .grand-banner .value { font-size: 1.5rem; }
        }

        /* Dark mode */
        [data-bs-theme="dark"] body { background: #0f172a; color: #e2e8f0; }
        [data-bs-theme="dark"] .stat-card,
        [data-bs-theme="dark"] .section-card,
        [data-bs-theme="dark"] .chart-card { background: #1e293b; }
        [data-bs-theme="dark"] .page-header,
        [data-bs-theme="dark"] .filter-bar { background: #1e293b; border-color: #334155; }
        [data-bs-theme="dark"] .filter-bar select { background: #0f172a; color: #e2e8f0; border-color: #334155; }
        [data-bs-theme="dark"] .kab-card { background: #0f172a; border-color: #334155; }
        [data-bs-theme="dark"] .data-table thead th { background: #0f172a; }
        [data-bs-theme="dark"] .data-table tbody td { color: #cbd5e1; }
        [data-bs-theme="dark"] .data-table tbody tr:hover td { background: #1e293b; }
        [data-bs-theme="dark"] .item-row { border-color: #334155; }
        [data-bs-theme="dark"] .item-qty { background: #334155; color: #94a3b8; }
        [data-bs-theme="dark"] .total-summary { background: linear-gradient(135deg, #1e3a8a22, #14532d22); border-color: #3b82f6; }
        [data-bs-theme="dark"] .section-card .card-header-custom { border-color: #334155; }
        [data-bs-theme="dark"] .section-card .card-header-custom h3 { color: #e2e8f0; }
        [data-bs-theme="dark"] .grand-banner { background: linear-gradient(135deg, #020617, #0f172a); }
        [data-bs-theme="dark"] .data-table .total-row td { background: #1e3a8a33 !important; }
    </style>
</head>

<body>
    {{-- ─── TOP NAVIGATION ─── --}}
    <header class="summary-topbar">
        <a href="javascript:void(0)" onclick="openNavModal()" class="topbar-brand">
            <div class="brand-icon"><i class="bi bi-grid-3x3-gap-fill"></i></div>
            <span>Project <span style="opacity:.5">|</span> Operational</span>
        </a>
        <div class="d-flex align-items-center gap-3">
            @if(auth()->check() && auth()->user()->role === 'superadmin')
                <a href="{{ route('setting.index') }}" class="text-white opacity-75" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size:1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position:relative;">
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor:pointer;">
                    @if(auth()->check() && auth()->user()->photo)
                        <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                            style="width:35px;height:35px;border-radius:50%;object-fit:cover;">
                    @else
                        <i class="bi bi-person-circle" style="font-size:1.5rem;"></i>
                    @endif
                </div>
                <div id="profileDropdownMenu"
                    style="position:absolute;right:0;top:100%;margin-top:8px;width:150px;background:white;border:1px solid #ddd;border-radius:8px;box-shadow:0 4px 6px rgba(0,0,0,.1);z-index:1000;display:none;flex-direction:column;overflow:hidden;">
                    <div style="padding:10px 15px;border-bottom:1px solid #eee;font-size:14px;font-weight:bold;color:#333;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        style="padding:10px 15px;text-decoration:none;color:#333;font-size:14px;display:flex;align-items:center;"
                        onmouseover="this.style.backgroundColor='#f5f5f5'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            style="width:100%;padding:10px 15px;text-align:left;border:none;background:transparent;color:#dc3545;font-size:14px;cursor:pointer;display:flex;align-items:center;"
                            onmouseover="this.style.backgroundColor='#fff5f5'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- ─── PAGE HEADER ─── --}}
    <div class="page-header">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1><i class="bi bi-bar-chart-line-fill me-2" style="color:#2563eb;font-size:1.3rem;"></i>Summary Keuangan</h1>
                <div class="subtitle">Rekapitulasi pengeluaran operasional bulanan — Pengajuan Perangkat · CSR · CM</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('cm.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-tools me-1"></i>CM
                </a>
                <a href="{{ route('csr.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-heart me-1"></i>CSR
                </a>
                <a href="{{ route('sparepart_needed') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-cpu me-1"></i>Perangkat
                </a>
            </div>
        </div>
    </div>

    {{-- ─── FILTER BAR ─── --}}
    <div class="filter-bar">
        <form method="GET" action="{{ route('summary.keuangan') }}" class="d-flex align-items-center gap-2 flex-wrap" id="filterForm">
            <label style="font-size:.82rem;font-weight:600;color:#475569;margin:0;">Periode:</label>
            <select name="month" id="filterMonth" onchange="document.getElementById('filterForm').submit()">
                @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->locale('id')->isoFormat('MMMM') }}
                    </option>
                @endforeach
            </select>
            <select name="year" id="filterYear" onchange="document.getElementById('filterForm').submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <div style="font-size:.8rem;color:#64748b;padding:7px 0;">
                <i class="bi bi-info-circle me-1"></i>Auto-refresh saat ganti periode
            </div>
        </form>
    </div>

    {{-- ─── MAIN CONTENT ─── --}}
    <div class="main-content">

        {{-- ─── GRAND TOTAL BANNER ─── --}}
        <div class="grand-banner mb-4">
            <div>
                <div class="label"><i class="bi bi-wallet2 me-1"></i>Total Pengeluaran Bulan Ini</div>
                <div class="value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
                <div class="period">
                    {{ \Carbon\Carbon::create()->month($month)->locale('id')->isoFormat('MMMM') }} {{ $year }}
                    &nbsp;·&nbsp; {{ $cmAll->count() + $csrAll->count() + ($beliBaru->count() + $repair->count()) }} pengajuan
                </div>
            </div>
            <div class="d-flex gap-3 flex-wrap">
                <div class="grand-pill">
                    <div style="font-size:.7rem;opacity:.6;text-transform:uppercase;font-weight:600;">Perangkat</div>
                    <div style="font-size:1.05rem;font-weight:700;">Rp {{ number_format($perangkat_total, 0, ',', '.') }}</div>
                </div>
                <div class="grand-pill" style="border-left:1px solid rgba(255,255,255,.2);padding-left:16px;">
                    <div style="font-size:.7rem;opacity:.6;text-transform:uppercase;font-weight:600;">CSR</div>
                    <div style="font-size:1.05rem;font-weight:700;">Rp {{ number_format($csr_total, 0, ',', '.') }}</div>
                </div>
                <div class="grand-pill" style="border-left:1px solid rgba(255,255,255,.2);padding-left:16px;">
                    <div style="font-size:.7rem;opacity:.6;text-transform:uppercase;font-weight:600;">CM</div>
                    <div style="font-size:1.05rem;font-weight:700;">Rp {{ number_format($cm_total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- ─── TOP STAT CARDS ─── --}}
        <div class="row g-3 mb-4">
            {{-- Perangkat Beli Baru --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#2563eb;"></div>
                    <div class="card-icon bg-blue-soft c-blue"><i class="bi bi-bag-plus"></i></div>
                    <div class="card-label">Beli Baru</div>
                    <div class="card-value">{{ $beliBaru->count() }}</div>
                    <div class="card-sub">Rp {{ number_format($perangkat_total_belibaru, 0, ',', '.') }}</div>
                </div>
            </div>
            {{-- Perangkat Repair --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#0891b2;"></div>
                    <div class="card-icon bg-cyan-soft c-cyan"><i class="bi bi-tools"></i></div>
                    <div class="card-label">Repair</div>
                    <div class="card-value">{{ $repair->count() }}</div>
                    <div class="card-sub">Rp {{ number_format($perangkat_total_repair, 0, ',', '.') }}</div>
                </div>
            </div>
            {{-- CSR Total --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#059669;"></div>
                    <div class="card-icon bg-green-soft c-green"><i class="bi bi-heart-pulse"></i></div>
                    <div class="card-label">CSR</div>
                    <div class="card-value">{{ $csrAll->count() }}</div>
                    <div class="card-sub">Rp {{ number_format($csr_total, 0, ',', '.') }}</div>
                </div>
            </div>
            {{-- CM BMN --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#7c3aed;"></div>
                    <div class="card-icon bg-purple-soft c-purple"><i class="bi bi-building"></i></div>
                    <div class="card-label">CM BMN</div>
                    <div class="card-value">{{ $cmBmn->count() }}</div>
                    <div class="card-sub">Rp {{ number_format($cm_total_bmn, 0, ',', '.') }}</div>
                </div>
            </div>
            {{-- CM SL --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#ea580c;"></div>
                    <div class="card-icon bg-orange-soft c-orange"><i class="bi bi-wifi"></i></div>
                    <div class="card-label">CM SL</div>
                    <div class="card-value">{{ $cmSl->count() }}</div>
                    <div class="card-sub">Rp {{ number_format($cm_total_sl, 0, ',', '.') }}</div>
                </div>
            </div>
            {{-- Total Sites CM --}}
            <div class="col-6 col-md-4 col-lg-2">
                <div class="stat-card">
                    <div class="card-stripe" style="background:#0f172a;"></div>
                    <div class="card-icon" style="background:#f1f5f9;color:#475569;"><i class="bi bi-geo-alt"></i></div>
                    <div class="card-label">Total Site CM</div>
                    <div class="card-value">{{ $cmAllSites->count() }}</div>
                    <div class="card-sub">site/lokasi</div>
                </div>
            </div>
        </div>

        {{-- ─── CHARTS ROW ─── --}}
        <div class="row g-3 mb-4">
            {{-- Bar Chart: Tren Pengeluaran 12 Bulan --}}
            <div class="col-12 col-lg-7">
                <div class="chart-card">
                    <div class="chart-title"><i class="bi bi-bar-chart me-2" style="color:#2563eb;"></i>Tren Pengeluaran 12 Bulan</div>
                    <div class="chart-subtitle">Perbandingan total pengeluaran Perangkat, CSR, dan CM per bulan</div>
                    <canvas id="chartTrend" height="160"></canvas>
                </div>
            </div>
            {{-- Doughnut: Komposisi Bulan Ini --}}
            <div class="col-12 col-lg-5">
                <div class="row g-3 h-100">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="chart-title"><i class="bi bi-pie-chart me-2" style="color:#7c3aed;"></i>Komposisi Pengeluaran</div>
                            <div class="chart-subtitle">{{ \Carbon\Carbon::create()->month($month)->locale('id')->isoFormat('MMMM') }} {{ $year }}</div>
                            <div class="d-flex align-items-center gap-3">
                                <div style="flex:0 0 180px;max-width:180px;">
                                    <canvas id="chartDoughnut" height="180"></canvas>
                                </div>
                                <div style="flex:1;font-size:.82rem;">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width:12px;height:12px;border-radius:3px;background:#2563eb;display:inline-block;"></span>
                                        <span style="color:#475569;">Perangkat</span>
                                        <span class="ms-auto fw-700 c-blue">Rp {{ number_format($perangkat_total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width:12px;height:12px;border-radius:3px;background:#059669;display:inline-block;"></span>
                                        <span style="color:#475569;">CSR</span>
                                        <span class="ms-auto fw-700 c-green">Rp {{ number_format($csr_total, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width:12px;height:12px;border-radius:3px;background:#7c3aed;display:inline-block;"></span>
                                        <span style="color:#475569;">CM BMN</span>
                                        <span class="ms-auto fw-700 c-purple">Rp {{ number_format($cm_total_bmn, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="width:12px;height:12px;border-radius:3px;background:#ea580c;display:inline-block;"></span>
                                        <span style="color:#475569;">CM SL</span>
                                        <span class="ms-auto fw-700 c-orange">Rp {{ number_format($cm_total_sl, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="chart-title"><i class="bi bi-graph-up me-2" style="color:#059669;"></i>CM BMN vs SL</div>
                            <div class="chart-subtitle">Tren 12 bulan</div>
                            <canvas id="chartCmLine" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════
             SECTION 1: PENGAJUAN PERANGKAT
        ════════════════════════════════════════════════════════ --}}
        <div class="section-title">
            <div class="icon-badge" style="background:#eff6ff;color:#2563eb;"><i class="bi bi-cpu-fill"></i></div>
            1. Pengajuan Perangkat
        </div>

        <div class="row g-3 mb-4">
            {{-- Beli Baru --}}
            <div class="col-12 col-md-6">
                <div class="section-card h-100">
                    <div class="card-header-custom">
                        <h3>
                            <span style="background:#eff6ff;color:#2563eb;padding:4px 10px;border-radius:6px;font-size:.75rem;">BELI BARU</span>
                            {{ $beliBaru->count() }} pengajuan
                        </h3>
                        <span class="fw-700 c-blue" style="font-size:.9rem;">Rp {{ number_format($perangkat_total_belibaru, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body-custom">
                        @if($beliBaru_items->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada item beli baru bulan ini</p>
                            </div>
                        @else
                            @foreach($beliBaru_items as $item)
                                <div class="item-row">
                                    <div class="item-name">{{ $item['nama'] }}</div>
                                    <div class="item-qty">×{{ $item['qty'] }}</div>
                                    <div class="item-price">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                            <div class="total-summary">
                                <span class="label"><i class="bi bi-calculator me-1"></i>Total Beli Baru</span>
                                <span class="value">Rp {{ number_format($perangkat_total_belibaru, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Repair --}}
            <div class="col-12 col-md-6">
                <div class="section-card h-100">
                    <div class="card-header-custom">
                        <h3>
                            <span style="background:#ecfeff;color:#0891b2;padding:4px 10px;border-radius:6px;font-size:.75rem;">REPAIR</span>
                            {{ $repair->count() }} pengajuan
                        </h3>
                        <span class="fw-700 c-cyan" style="font-size:.9rem;">Rp {{ number_format($perangkat_total_repair, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body-custom">
                        @if($repair_items->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada item repair bulan ini</p>
                            </div>
                        @else
                            @foreach($repair_items as $item)
                                <div class="item-row">
                                    <div class="item-name">{{ $item['nama'] }}</div>
                                    <div class="item-qty">×{{ $item['qty'] }}</div>
                                    <div class="item-price">Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                            <div class="total-summary">
                                <span class="label"><i class="bi bi-calculator me-1"></i>Total Repair</span>
                                <span class="value">Rp {{ number_format($perangkat_total_repair, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════
             SECTION 2: CSR
        ════════════════════════════════════════════════════════ --}}
        <div class="section-title">
            <div class="icon-badge" style="background:#ecfdf5;color:#059669;"><i class="bi bi-heart-pulse-fill"></i></div>
            2. CSR (Corporate Social Responsibility)
        </div>

        <div class="section-card mb-4">
            <div class="card-header-custom">
                <h3><i class="bi bi-list-ul me-2"></i>Rekapitulasi CSR Bulan Ini</h3>
                <span class="fw-700 c-green" style="font-size:.9rem;">
                    Total: Rp {{ number_format($csr_total, 0, ',', '.') }}
                </span>
            </div>
            <div class="card-body-custom">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <div class="kab-card" style="border-color:#86efac;">
                            <div class="kab-name">BMN</div>
                            <div class="kab-total" style="color:#059669;">Rp {{ number_format($csr_total_bmn, 0, ',', '.') }}</div>
                            <div class="kab-count">{{ $csrBmn->count() }} pengajuan</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kab-card" style="border-color:#fdba74;">
                            <div class="kab-name">SL</div>
                            <div class="kab-total" style="color:#ea580c;">Rp {{ number_format($csr_total_sl, 0, ',', '.') }}</div>
                            <div class="kab-count">{{ $csrSl->count() }} pengajuan</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kab-card">
                            <div class="kab-name">Lainnya</div>
                            <div class="kab-total">Rp {{ number_format($csr_total_other, 0, ',', '.') }}</div>
                            <div class="kab-count">{{ $csrOther->count() }} pengajuan</div>
                        </div>
                    </div>
                </div>

                @if($csrAll->isEmpty())
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Tidak ada data CSR bulan ini</p>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Site</th>
                                <th>Rincian</th>
                                <th>Status</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($csrAll as $i => $csr)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $csr->nama_site ?? '-' }}</td>
                                    <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $csr->rincian_kebutuhan }}">
                                        {{ Str::limit($csr->rincian_kebutuhan ?? '-', 50) }}
                                    </td>
                                    <td>
                                        <span class="cat-badge" style="background:#dcfce7;color:#166534;font-size:.7rem;">
                                            {{ ucwords(str_replace('_', ' ', $csr->approval_status ?? '-')) }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-700" style="color:#059669;">Rp {{ number_format($csr->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="total-row">
                                <td colspan="4" class="text-end">TOTAL CSR</td>
                                <td class="text-end">Rp {{ number_format($csr_total, 0, ',', '.') }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════
             SECTION 3: CM (Corrective Maintenance)
        ════════════════════════════════════════════════════════ --}}
        <div class="section-title">
            <div class="icon-badge" style="background:#f5f3ff;color:#7c3aed;"><i class="bi bi-wrench-adjustable-circle-fill"></i></div>
            3. CM (Corrective Maintenance)
        </div>

        <div class="row g-3 mb-4">
            {{-- CM BMN --}}
            <div class="col-12 col-lg-6">
                <div class="section-card h-100">
                    <div class="card-header-custom">
                        <h3>
                            <span style="background:#f5f3ff;color:#7c3aed;padding:4px 10px;border-radius:6px;font-size:.75rem;">BMN</span>
                            {{ $cmBmn->count() }} pengajuan
                        </h3>
                        <span class="fw-700 c-purple" style="font-size:.9rem;">Rp {{ number_format($cm_total_bmn, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body-custom">
                        @if($cmBmn->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada data CM BMN bulan ini</p>
                            </div>
                        @else
                            <div class="sub-section-badge" style="background:#f5f3ff;color:#7c3aed;">
                                <i class="bi bi-geo-alt-fill"></i>Per Kabupaten
                            </div>
                            <div class="row g-2 mb-3">
                                @foreach($cmBmn_per_kabupaten as $kab)
                                    <div class="col-12 col-sm-6">
                                        <div class="kab-card">
                                            <div class="kab-name">{{ $kab['kabupaten'] }}</div>
                                            <div class="kab-total">Rp {{ number_format($kab['total'], 0, ',', '.') }}</div>
                                            <div class="kab-count">{{ $kab['count'] }} site · CM</div>
                                            <div class="site-pills">
                                                @foreach($kab['sites']->take(3) as $s)
                                                    <span class="site-pill">{{ Str::limit($s, 20) }}</span>
                                                @endforeach
                                                @if($kab['sites']->count() > 3)
                                                    <span class="site-pill">+{{ $kab['sites']->count() - 3 }} lagi</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Site</th>
                                        <th>Teknisi</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cmBmn as $i => $cm)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $cm->nama_site ?? '-' }}</td>
                                            <td>{{ $cm->nama_teknisi ?? '-' }}</td>
                                            <td class="text-end fw-700 c-purple">Rp {{ number_format($cm->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="total-row">
                                        <td colspan="3" class="text-end">TOTAL BMN</td>
                                        <td class="text-end">Rp {{ number_format($cm_total_bmn, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>

            {{-- CM SL --}}
            <div class="col-12 col-lg-6">
                <div class="section-card h-100">
                    <div class="card-header-custom">
                        <h3>
                            <span style="background:#fff7ed;color:#ea580c;padding:4px 10px;border-radius:6px;font-size:.75rem;">SL</span>
                            {{ $cmSl->count() }} pengajuan
                        </h3>
                        <span class="fw-700 c-orange" style="font-size:.9rem;">Rp {{ number_format($cm_total_sl, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-body-custom">
                        @if($cmSl->isEmpty())
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Tidak ada data CM SL bulan ini</p>
                            </div>
                        @else
                            <div class="sub-section-badge" style="background:#fff7ed;color:#ea580c;">
                                <i class="bi bi-geo-alt-fill"></i>Per Kabupaten
                            </div>
                            <div class="row g-2 mb-3">
                                @foreach($cmSl_per_kabupaten as $kab)
                                    <div class="col-12 col-sm-6">
                                        <div class="kab-card" style="border-color:#fed7aa;">
                                            <div class="kab-name">{{ $kab['kabupaten'] }}</div>
                                            <div class="kab-total" style="color:#ea580c;">Rp {{ number_format($kab['total'], 0, ',', '.') }}</div>
                                            <div class="kab-count">{{ $kab['count'] }} site · CM SL</div>
                                            <div class="site-pills">
                                                @foreach($kab['sites']->take(3) as $s)
                                                    <span class="site-pill" style="background:#ffedd5;color:#c2410c;">{{ Str::limit($s, 20) }}</span>
                                                @endforeach
                                                @if($kab['sites']->count() > 3)
                                                    <span class="site-pill" style="background:#ffedd5;color:#c2410c;">+{{ $kab['sites']->count() - 3 }} lagi</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Site</th>
                                        <th>Teknisi</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cmSl as $i => $cm)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $cm->nama_site ?? '-' }}</td>
                                            <td>{{ $cm->nama_teknisi ?? '-' }}</td>
                                            <td class="text-end fw-700 c-orange">Rp {{ number_format($cm->total, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="total-row">
                                        <td colspan="3" class="text-end">TOTAL SL</td>
                                        <td class="text-end">Rp {{ number_format($cm_total_sl, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- CM: Daftar Semua Site --}}
        @if($cmAllSites->isNotEmpty())
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <h3><i class="bi bi-map me-2"></i>Daftar Site CM Bulan Ini</h3>
                <span style="font-size:.82rem;color:#64748b;">{{ $cmAllSites->count() }} site</span>
            </div>
            <div class="card-body-custom">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($cmAllSites as $site)
                        <span style="background:#f1f5f9;border:1px solid #e2e8f0;color:#334155;border-radius:6px;padding:5px 12px;font-size:.8rem;font-weight:500;">
                            <i class="bi bi-geo-alt me-1" style="color:#7c3aed;"></i>{{ $site }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ─── CM TOTAL GRAND SUMMARY ─── --}}
        <div class="section-card mb-4">
            <div class="card-header-custom">
                <h3><i class="bi bi-table me-2"></i>Rekapitulasi Grand Total CM</h3>
            </div>
            <div class="card-body-custom">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th class="text-center">Jumlah Pengajuan</th>
                            <th class="text-center">Jumlah Site</th>
                            <th class="text-end">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="cat-badge" style="background:#f5f3ff;color:#7c3aed;">BMN</span></td>
                            <td class="text-center">{{ $cmBmn->count() }}</td>
                            <td class="text-center">{{ $cmBmn->pluck('nama_site')->filter()->unique()->count() }}</td>
                            <td class="text-end fw-700 c-purple">Rp {{ number_format($cm_total_bmn, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><span class="cat-badge" style="background:#fff7ed;color:#ea580c;">SL</span></td>
                            <td class="text-center">{{ $cmSl->count() }}</td>
                            <td class="text-center">{{ $cmSl->pluck('nama_site')->filter()->unique()->count() }}</td>
                            <td class="text-end fw-700 c-orange">Rp {{ number_format($cm_total_sl, 0, ',', '.') }}</td>
                        </tr>
                        @if($cmAll->whereNotIn('kategori', ['BMN','SL'])->count() > 0)
                        <tr>
                            <td><span class="cat-badge" style="background:#f1f5f9;color:#475569;">Lainnya</span></td>
                            <td class="text-center">{{ $cmAll->whereNotIn('kategori', ['BMN','SL'])->count() }}</td>
                            <td class="text-center">-</td>
                            <td class="text-end fw-700">Rp {{ number_format($cmAll->whereNotIn('kategori', ['BMN','SL'])->sum('total'), 0, ',', '.') }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td><strong>GRAND TOTAL CM</strong></td>
                            <td class="text-center">{{ $cmAll->count() }}</td>
                            <td class="text-center">{{ $cmAllSites->count() }}</td>
                            <td class="text-end">Rp {{ number_format($cm_total, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ─── FOOTER SPACE ─── --}}
        <div style="height:40px;"></div>
    </div>

    {{-- ─── CHART.JS SCRIPTS ─── --}}
    <script>
        const chartLabels   = @json($chartLabels);
        const chartPengajuan = @json($chartPengajuan);
        const chartCsr      = @json($chartCsr);
        const chartCm       = @json($chartCm);
        const chartCmBmn    = @json($chartCmBmn);
        const chartCmSl     = @json($chartCmSl);

        const fmtRp = (v) => {
            if (v >= 1_000_000_000) return 'Rp ' + (v / 1_000_000_000).toFixed(1) + ' M';
            if (v >= 1_000_000)     return 'Rp ' + (v / 1_000_000).toFixed(1) + ' Jt';
            return 'Rp ' + v.toLocaleString('id-ID');
        };

        // ── Bar Chart Trend ──
        const ctxTrend = document.getElementById('chartTrend').getContext('2d');
        new Chart(ctxTrend, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Perangkat',
                        data: chartPengajuan,
                        backgroundColor: 'rgba(37,99,235,.75)',
                        borderRadius: 5,
                        borderSkipped: false,
                    },
                    {
                        label: 'CSR',
                        data: chartCsr,
                        backgroundColor: 'rgba(5,150,105,.75)',
                        borderRadius: 5,
                        borderSkipped: false,
                    },
                    {
                        label: 'CM',
                        data: chartCm,
                        backgroundColor: 'rgba(124,58,237,.75)',
                        borderRadius: 5,
                        borderSkipped: false,
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { font: { size: 11, family: 'Inter' }, boxWidth: 12 } },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.dataset.label + ': ' + fmtRp(ctx.raw)
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10, family: 'Inter' } } },
                    y: {
                        grid: { color: 'rgba(0,0,0,.05)' },
                        ticks: {
                            font: { size: 10, family: 'Inter' },
                            callback: v => fmtRp(v)
                        }
                    }
                }
            }
        });

        // ── Doughnut Chart ──
        const perangkatTotal = {{ $perangkat_total }};
        const csrTotal       = {{ $csr_total }};
        const cmBmnTotal     = {{ $cm_total_bmn }};
        const cmSlTotal      = {{ $cm_total_sl }};

        const ctxDoughnut = document.getElementById('chartDoughnut').getContext('2d');
        new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Perangkat', 'CSR', 'CM BMN', 'CM SL'],
                datasets: [{
                    data: [perangkatTotal, csrTotal, cmBmnTotal, cmSlTotal],
                    backgroundColor: ['#2563eb', '#059669', '#7c3aed', '#ea580c'],
                    borderWidth: 2,
                    borderColor: '#fff',
                    hoverBorderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.label + ': ' + fmtRp(ctx.raw)
                        }
                    }
                }
            }
        });

        // ── Line Chart CM BMN vs SL ──
        const ctxLine = document.getElementById('chartCmLine').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'CM BMN',
                        data: chartCmBmn,
                        borderColor: '#7c3aed',
                        backgroundColor: 'rgba(124,58,237,.08)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#7c3aed',
                    },
                    {
                        label: 'CM SL',
                        data: chartCmSl,
                        borderColor: '#ea580c',
                        backgroundColor: 'rgba(234,88,12,.08)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 3,
                        pointBackgroundColor: '#ea580c',
                    },
                ]
            },
            options: {
                responsive: true,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { font: { size: 10, family: 'Inter' }, boxWidth: 10 } },
                    tooltip: {
                        callbacks: { label: ctx => ' ' + ctx.dataset.label + ': ' + fmtRp(ctx.raw) }
                    }
                },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 9, family: 'Inter' } } },
                    y: {
                        grid: { color: 'rgba(0,0,0,.04)' },
                        ticks: { font: { size: 9, family: 'Inter' }, callback: v => fmtRp(v) }
                    }
                }
            }
        });
    </script>
    @include('components.nav-modal-structure')
</body>
</html>
