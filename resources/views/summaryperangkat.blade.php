<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operasional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}?v=1.2">
    <!-- Required for Dashboard Components -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* ===== PAGE PADDING ===== */
        .page-content {
            width: 100%;
            max-width: 1600px;
            margin: 0 auto;
            padding: 20px 24px 48px;
            box-sizing: border-box;
        }

        /* ===== STAT CARDS GRID — fluid 4 kolom ===== */
        .stat-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        /* ===== STAT CARD ===== */
        .stat-card {
            border-radius: 24px;
            padding: 20px;
            color: white;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            min-height: 110px;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            right: -20px;
            top: -20px;
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,0.12);
            border-radius: 50%;
            filter: blur(16px);
        }
        .stat-card-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            position: relative;
            z-index: 1;
        }
        .stat-card-label {
            font-size: clamp(9px, 1vw, 11px);
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            opacity: 0.85;
            margin: 0 0 6px;
        }
        .stat-card-value {
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 900;
            line-height: 1;
            margin: 0;
        }
        .stat-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-card-icon i { font-size: 18px; }

        .stat-card-gradient   { background: linear-gradient(135deg, #071152 0%, #1e293b 100%); }
        .stat-card-gradient-2 { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); }
        .stat-card-gradient-3 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-card-gradient-4 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }

        /* ===== PANEL GRID — 3 kolom section ===== */
        .panel-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        @media (max-width: 860px) {
            .panel-grid { grid-template-columns: 1fr; }
            .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 520px) {
            .stat-cards-grid { grid-template-columns: 1fr; }
            .page-content { padding: 12px 14px 24px; }
            .glass-panel { padding: 16px; }
        }

        /* ===== GLASS PANEL ===== */
        .glass-panel {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.45);
            box-shadow: 0 8px 32px rgba(0,0,0,0.05);
            border-radius: 24px;
            padding: 24px;
        }

        /* ===== PANEL HEADER ===== */
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }
        .panel-title {
            font-size: clamp(14px, 1.5vw, 17px);
            font-weight: 700;
            color: #071152;
            margin: 0 0 4px;
        }
        .panel-subtitle {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 500;
            margin: 0;
        }
        .panel-badge {
            background: #eef2ff;
            color: #4f46e5;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        /* ===== DONUT CHART SECTION ===== */
        .donut-section {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .donut-wrapper {
            position: relative;
            width: 100%;
            max-width: 220px;
            aspect-ratio: 1;
            margin: 0 auto 20px;
        }
        .donut-center {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        .donut-total-num {
            font-size: clamp(22px, 4vw, 32px);
            font-weight: 900;
            color: #071152;
            line-height: 1;
        }
        .donut-total-label {
            font-size: 10px;
            color: #94a3b8;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .donut-legend {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .legend-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 14px;
            border-radius: 16px;
            border: 1px solid;
        }
        .legend-row.green { background: #f0fdf4; border-color: #dcfce7; }
        .legend-row.red   { background: #fef2f2; border-color: #fee2e2; }
        .legend-row-label { font-size: 11px; font-weight: 700; }
        .legend-row.green .legend-row-label { color: #15803d; }
        .legend-row.red   .legend-row-label { color: #b91c1c; }
        .legend-row-value { font-size: 16px; font-weight: 900; color: #1e293b; }

        /* ===== REPLACEMENT STAT ROWS ===== */
        .replace-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 16px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            margin-bottom: 10px;
            transition: background 0.2s;
        }
        .replace-row:hover { background: #f1f5f9; }
        .replace-row:last-child { margin-bottom: 0; }
        .replace-row-left { display: flex; align-items: center; gap: 12px; }
        .replace-icon {
            width: 38px; height: 38px;
            border-radius: 12px;
            background: #e0e7ff;
            color: #4f46e5;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }
        .replace-name { font-size: 13px; font-weight: 700; color: #334155; }
        .replace-count { font-size: 20px; font-weight: 900; color: #071152; text-align: right; }
        .replace-unit  { font-size: 9px; font-weight: 700; color: #94a3b8; letter-spacing: 0.08em; text-transform: uppercase; text-align: right; }
        .replace-empty { text-align: center; padding: 24px; color: #94a3b8; font-size: 13px; }

        /* ===== TABLE OVERRIDES for Summary ===== */
        .glass-panel .table-responsive-custom {
            max-height: 320px;
            border-radius: 12px;
        }
        .glass-panel table th {
            background-color: #f5f7fb !important;
            color: #475569 !important;
            font-size: 11px !important;
            border-bottom: 2px solid #e2e8f0 !important;
            border-color: #e2e8f0 !important;
        }
        .glass-panel table td {
            font-size: 12px !important;
            border-color: #f1f5f9 !important;
            background-color: #fff !important;
        }
        .glass-panel table tr:nth-child(even) td {
            background-color: #fafbfc !important;
        }
        .glass-panel table tr:hover td {
            background-color: #f0f5fb !important;
        }
        .glass-panel table .grand-total-row td {
            background-color: #0f3b56 !important;
            color: #fff !important;
            font-weight: 700 !important;
        }

        /* ===== DATE/LOCATION BADGE ===== */
        .date-pill {
            background: #eef2ff;
            color: #4f46e5;
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }
        .location-main { font-weight: 800; color: #071152; font-size: 12px; }
        .location-sub  { font-size: 10px; color: #94a3b8; }
        .device-link   { font-weight: 700; color: #4f46e5; }

        /* ===== DARK MODE ===== */
        [data-bs-theme="dark"] .glass-panel {
            background: rgba(22, 27, 43, 0.85) !important;
            border-color: rgba(255,255,255,0.07) !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.3) !important;
        }
        [data-bs-theme="dark"] .panel-title  { color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .panel-badge  { background: #1e3a8a !important; color: #93c5fd !important; }
        [data-bs-theme="dark"] .legend-row.green { background: #052e16 !important; border-color: #14532d !important; }
        [data-bs-theme="dark"] .legend-row.red   { background: #450a0a !important; border-color: #7f1d1d !important; }
        [data-bs-theme="dark"] .legend-row.green .legend-row-label { color: #4ade80 !important; }
        [data-bs-theme="dark"] .legend-row.red   .legend-row-label { color: #f87171 !important; }
        [data-bs-theme="dark"] .legend-row-value { color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .donut-total-num  { color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .replace-row  { background: #1a1f2e !important; border-color: #2a3148 !important; }
        [data-bs-theme="dark"] .replace-row:hover { background: #222840 !important; }
        [data-bs-theme="dark"] .replace-icon { background: #1e3a8a !important; color: #93c5fd !important; }
        [data-bs-theme="dark"] .replace-name { color: #cbd5e1 !important; }
        [data-bs-theme="dark"] .replace-count { color: #93c5fd !important; }
        [data-bs-theme="dark"] .glass-panel table th {
            background-color: #1a202c !important; color: #94a3b8 !important; border-color: #2d3748 !important;
        }
        [data-bs-theme="dark"] .glass-panel table td {
            background-color: #1e1e2e !important; color: #cbd5e1 !important; border-color: #2a2a3a !important;
        }
        [data-bs-theme="dark"] .glass-panel table tr:nth-child(even) td { background-color: #252535 !important; }
        [data-bs-theme="dark"] .glass-panel table tr:hover td { background-color: #2a3040 !important; }
        [data-bs-theme="dark"] .glass-panel table .grand-total-row td {
            background-color: #0f1f38 !important; color: #93c5fd !important;
        }
        [data-bs-theme="dark"] .date-pill  { background: #1e3a8a !important; color: #93c5fd !important; }
        [data-bs-theme="dark"] .location-main { color: #93c5fd !important; }
        [data-bs-theme="dark"] .location-sub  { color: #64748b !important; }
        [data-bs-theme="dark"] .device-link   { color: #818cf8 !important; }
    </style>
</head>
<body>
<header class="main-header">
        <div class="header-logo-container">
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()" style="text-decoration: none !important; color: white !important;">
                <div class="header-brand" style="display: flex; align-items: center; gap: 8px; font-weight: bold;">
                    Project <span style="opacity: 0.5;">|</span> Operational
                </div>
            </a>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                @if(auth()->check() && auth()->user()->role === 'superadmin')
                    <a href="{{ route('setting.index') }}" class="user-profile-icon" title="Setting User" style="cursor: pointer; text-decoration: none; color: inherit;">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                @endif
                <div id="profileDropdownMenu" class="hidden" style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                    <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <a href="{{ route('profile.edit') }}" style="padding: 10px 15px; text-decoration: none; color: #333; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='transparent'">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab active" style="text-decoration: none; color: White;">Summary</a>
    </div>
    <div class="page-content">

        <!-- ===== STAT CARDS ===== -->
        <div class="stat-cards-grid">
            <!-- Total Perangkat -->
            <div class="stat-card stat-card-gradient">
                <div class="stat-card-inner">
                    <div>
                        <p class="stat-card-label">Total Perangkat</p>
                        <h3 class="stat-card-value">{{ $grandTotal }}</h3>
                    </div>
                    <div class="stat-card-icon"><i class="bi bi-cpu"></i></div>
                </div>
            </div>
            <!-- Kondisi Baik -->
            <div class="stat-card stat-card-gradient-3">
                <div class="stat-card-inner">
                    <div>
                        <p class="stat-card-label">Kondisi Baik</p>
                        <h3 class="stat-card-value">{{ $totalBaik }}</h3>
                    </div>
                    <div class="stat-card-icon"><i class="bi bi-check-circle"></i></div>
                </div>
            </div>
            <!-- Kondisi Rusak -->
            <div class="stat-card stat-card-gradient-4">
                <div class="stat-card-inner">
                    <div>
                        <p class="stat-card-label">Kondisi Rusak</p>
                        <h3 class="stat-card-value">{{ $totalRusak }}</h3>
                    </div>
                    <div class="stat-card-icon"><i class="bi bi-exclamation-triangle"></i></div>
                </div>
            </div>
            <!-- Stok Baru -->
            <div class="stat-card stat-card-gradient-2">
                <div class="stat-card-inner">
                    <div>
                        <p class="stat-card-label">Stok Baru</p>
                        <h3 class="stat-card-value">{{ $totalBaru }}</h3>
                    </div>
                    <div class="stat-card-icon"><i class="bi bi-box-seam"></i></div>
                </div>
            </div>
        </div>

        <!-- ===== CHART & STOCK TABLE ===== -->
        <div class="panel-grid">
            <!-- Donut Chart -->
            <div class="glass-panel donut-section">
                <div class="panel-header" style="justify-content:center; text-align:center;">
                    <div>
                        <p class="panel-title">Kondisi Hardware</p>
                        <p class="panel-subtitle">Data Kumulatif Seluruh Perangkat</p>
                    </div>
                </div>
                <div class="donut-wrapper">
                    <canvas id="conditionDonutChart"></canvas>
                    <div class="donut-center">
                        <span class="donut-total-num">{{ $grandTotal }}</span>
                        <span class="donut-total-label">Total</span>
                    </div>
                </div>
                <div class="donut-legend">
                    <div class="legend-row green">
                        <span class="legend-row-label">BAIK / BARU</span>
                        <span class="legend-row-value">{{ $totalBaik + $totalBaru }}</span>
                    </div>
                    <div class="legend-row red">
                        <span class="legend-row-label">RUSAK</span>
                        <span class="legend-row-value">{{ $totalRusak }}</span>
                    </div>
                </div>
            </div>

            <!-- Stock Table -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Stock Perangkat</p>
                        <p class="panel-subtitle">Berdasarkan Jenis &amp; Kondisi</p>
                    </div>
                    <span class="panel-badge">Live Stock</span>
                </div>
                <div class="table-responsive-custom">
                    <table>
                        <thead>
                            <tr>
                                <th>JENIS PERANGKAT</th>
                                <th class="text-center">BAIK</th>
                                <th class="text-center">RUSAK</th>
                                <th class="text-center">BARU</th>
                                <th class="text-center">GRAND TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats as $row)
                            <tr>
                                <td>{{ $row->jenis }}</td>
                                <td class="text-center" style="font-weight:700; color:#16a34a;">{{ $row->baik }}</td>
                                <td class="text-center" style="font-weight:700; color:#dc2626;">{{ $row->rusak }}</td>
                                <td class="text-center" style="font-weight:700; color:#4f46e5;">{{ $row->baru }}</td>
                                <td class="text-center" style="font-weight:900; color:#071152;">{{ $row->baik + $row->rusak + $row->baru }}</td>
                            </tr>
                            @endforeach
                            <tr class="grand-total-row">
                                <td>GRAND TOTAL</td>
                                <td class="text-center" style="font-weight:900;">{{ $totalBaik }}</td>
                                <td class="text-center" style="font-weight:900;">{{ $totalRusak }}</td>
                                <td class="text-center" style="font-weight:900;">{{ $totalBaru }}</td>
                                <td class="text-center" style="font-weight:900;">{{ $grandTotal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ===== REPLACEMENT HISTORY ===== -->
        <div class="panel-grid">
            <!-- Ringkasan Pergantian -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Ringkasan Pergantian</p>
                        <p class="panel-subtitle">Frekuensi Pergantian Perangkat</p>
                    </div>
                </div>
                @forelse($replacementStats as $replace)
                <div class="replace-row">
                    <div class="replace-row-left">
                        <div class="replace-icon"><i class="bi bi-arrow-repeat"></i></div>
                        <span class="replace-name">{{ $replace->perangkat }}</span>
                    </div>
                    <div>
                        <div class="replace-count">{{ $replace->total }}</div>
                        <div class="replace-unit">KALI</div>
                    </div>
                </div>
                @empty
                <div class="replace-empty">Belum ada data pergantian</div>
                @endforelse
            </div>

            <!-- Histori Lokasi & Tanggal -->
            <div class="glass-panel">
                <div class="panel-header">
                    <div>
                        <p class="panel-title">Histori Lokasi &amp; Tanggal</p>
                        <p class="panel-subtitle">10 Titik Pergantian Terakhir</p>
                    </div>
                    <a href="{{ route('pergantianperangkat') }}" style="font-size:10px; font-weight:800; color:#4f46e5; letter-spacing:0.06em; text-transform:uppercase; text-decoration:none;">Lihat Semua →</a>
                </div>
                <div class="table-responsive-custom">
                    <table>
                        <thead>
                            <tr>
                                <th>PERANGKAT</th>
                                <th>LOKASI SITE</th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($replacementLogs as $log)
                            <tr>
                                <td><span class="device-link">{{ $log->perangkat }}</span></td>
                                <td>
                                    <div class="location-main">{{ $log->site->sitename ?? '-' }}</div>
                                    <div class="location-sub">{{ $log->site->site_id ?? '-' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="date-pill">{{ \Carbon\Carbon::parse($log->tanggal_penggantian)->format('d M Y') }}</span>
                                </td>
                                <td class="text-center">
                                    <i class="bi bi-info-circle" style="color:#94a3b8; cursor:help;" title="{{ $log->keterangan ?? 'Tanpa keterangan' }}"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center" style="padding:24px; color:#94a3b8; font-size:13px;">Tidak ada histori pergantian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <script>
        // Init Donut Chart for Hardware Condition
        const donutCtx = document.getElementById('conditionDonutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Baik', 'Rusak', 'Baru'],
                datasets: [{
                    data: [{{ $totalBaik }}, {{ $totalRusak }}, {{ $totalBaru }}],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                    hoverBackgroundColor: ['#059669', '#dc2626', '#d97706'],
                    borderWidth: 0,
                    borderRadius: 10,
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                label += context.raw;
                                return label + ' Unit';
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

