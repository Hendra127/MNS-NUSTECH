<!DOCTYPE html>
<html>

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Log Remote Mikrotik - Audit Trail</title>
    <meta name="description" content="Riwayat lengkap akses remote Mikrotik via WinBox untuk security tracking.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f0f2f5;
        }

        .stat-cards {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .stat-card-item {
            flex: 1;
            min-width: 160px;
            background: #fff;
            border-radius: 14px;
            padding: 18px 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: #fff;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .stat-icon.green {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .stat-icon.purple {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1a1a2e;
            line-height: 1;
        }

        .stat-label {
            font-size: 11px;
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .log-table-card {
            background: #fff;
            border-radius: 16px;
            padding: 0;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .log-table-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .log-table-header h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .log-table {
            width: 100%;
            border-collapse: collapse;
        }

        .log-table thead th {
            background: #f8f9fa;
            padding: 12px 16px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #666;
            font-weight: 700;
            border-bottom: 2px solid #eee;
            white-space: nowrap;
        }

        .log-table tbody td {
            padding: 14px 16px;
            font-size: 13px;
            color: #333;
            border-bottom: 1px solid #f5f5f5;
            vertical-align: middle;
        }

        .log-table tbody tr {
            transition: background 0.15s;
        }

        .log-table tbody tr:hover {
            background: #f8faff;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e8e8e8;
        }

        .user-info .user-name-sm {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 13px;
        }

        .user-info .user-role-sm {
            font-size: 10px;
            color: #999;
        }

        .badge-page {
            font-size: 10px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-page.datasite {
            background: #e8f4fd;
            color: #0d6efd;
        }

        .badge-page.open-ticket {
            background: #fff3cd;
            color: #856404;
        }

        .badge-page.nav-modal {
            background: #d1e7dd;
            color: #0f5132;
        }

        .ip-mono {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #0d6efd;
            font-size: 13px;
        }

        .tunnel-badge {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            padding: 3px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            font-family: monospace;
        }

        .time-info {
            font-size: 12px;
            color: #555;
        }

        .time-sub {
            font-size: 10px;
            color: #aaa;
            display: block;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0.3;
        }

        .search-filter-bar {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-filter-bar input,
        .search-filter-bar select {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            outline: none;
            transition: border 0.2s;
        }

        .search-filter-bar input:focus {
            border-color: #4facfe;
        }

        /* ========== DARK MODE OVERRIDES ========== */
        [data-bs-theme="dark"] body {
            background: #121212 !important;
        }

        [data-bs-theme="dark"] .stat-card-item {
            background: #1e1e1e !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3) !important;
        }

        [data-bs-theme="dark"] .stat-card-item:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4) !important;
        }

        [data-bs-theme="dark"] .stat-number {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .stat-label {
            color: #888 !important;
        }

        [data-bs-theme="dark"] .log-table-card {
            background: #1e1e1e !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3) !important;
        }

        [data-bs-theme="dark"] .log-table-header {
            border-bottom-color: #333 !important;
        }

        [data-bs-theme="dark"] .log-table-header h2 {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .log-table thead th {
            background: #161b22 !important;
            color: #aaa !important;
            border-bottom-color: #333 !important;
        }

        [data-bs-theme="dark"] .log-table tbody td {
            color: #d0d0d0 !important;
            border-bottom-color: #2a2a2a !important;
        }

        [data-bs-theme="dark"] .log-table tbody tr:hover {
            background: #252525 !important;
        }

        [data-bs-theme="dark"] .user-avatar-sm {
            border-color: #444 !important;
        }

        [data-bs-theme="dark"] .user-name-sm {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .user-role-sm {
            color: #777 !important;
        }

        [data-bs-theme="dark"] .ip-mono {
            color: #64b5f6 !important;
        }

        [data-bs-theme="dark"] .tunnel-badge {
            background: linear-gradient(135deg, #5c6bc0, #6a3fb5) !important;
        }

        [data-bs-theme="dark"] .badge-page.datasite {
            background: rgba(13, 110, 253, 0.15) !important;
            color: #64b5f6 !important;
        }

        [data-bs-theme="dark"] .badge-page.open-ticket {
            background: rgba(255, 193, 7, 0.15) !important;
            color: #ffd54f !important;
        }

        [data-bs-theme="dark"] .badge-page.nav-modal {
            background: rgba(25, 135, 84, 0.15) !important;
            color: #81c784 !important;
        }

        [data-bs-theme="dark"] .time-info {
            color: #bbb !important;
        }

        [data-bs-theme="dark"] .time-sub {
            color: #777 !important;
        }

        [data-bs-theme="dark"] .search-filter-bar input,
        [data-bs-theme="dark"] .search-filter-bar select {
            background: #2a2a2a !important;
            border-color: #444 !important;
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] .search-filter-bar input::placeholder {
            color: #777 !important;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .badge-status.success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-status.failed {
            background: #f8d7da;
            color: #842029;
        }

        .badge-status.unknown {
            background: #e2e3e5;
            color: #41464b;
        }

        [data-bs-theme="dark"] .badge-status.success {
            background: rgba(25, 135, 84, 0.2) !important;
            color: #81c784 !important;
        }

        [data-bs-theme="dark"] .badge-status.failed {
            background: rgba(220, 53, 69, 0.2) !important;
            color: #ef9a9a !important;
        }

        [data-bs-theme="dark"] .badge-status.unknown {
            background: rgba(108, 117, 125, 0.2) !important;
            color: #adb5bd !important;
        }

        [data-bs-theme="dark"] .empty-state {
            color: #666 !important;
        }

        [data-bs-theme="dark"] h1 {
            color: #e0e0e0 !important;
        }

        [data-bs-theme="dark"] p {
            color: #999 !important;
        }
    </style>
</head>

<body>
    <header class="main-header">
        <div class="header-logo-container">
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()"
                style="text-decoration: none !important; color: white !important;">
                <div class="header-brand" style="display: flex; align-items: center; gap: 8px; font-weight: bold;">
                    Project <span style="opacity: 0.5;">|</span> Operational
                </div>
            </a>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if(auth()->check() && auth()->user()->role === 'superadmin')
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                <div id="profileDropdownMenu" class="hidden"
                    style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                    <div
                        style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        style="padding: 10px 15px; text-decoration: none; color: #333; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;"
                        onmouseover="this.style.backgroundColor='#f5f5f5'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit"
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ url('/todolist') }}" class="tab {{ request()->is('todolist*') ? 'active' : '' }}"
            style="text-decoration: none;">To Do List</a>
        @if(auth()->check() && auth()->user()->role === 'superadmin')
            <a href="{{ route('jadwalpiket') }}" class="tab {{ request()->is('jadwalpiket*') ? 'active' : '' }}"
                style="text-decoration: none;">Jadwal Piket</a>
            <a href="{{ route('remotelog') }}" class="tab {{ request()->is('remote-log*') ? 'active' : '' }}"
                style="text-decoration: none;">Log Remote</a>
        @endif
    </div>

    <div style="max-width: 1200px; margin: 0 auto; padding: 25px 20px;">

        {{-- Page Title --}}
        <div style="margin-bottom: 20px;">
            <h1
                style="font-size: 1.5rem; font-weight: 800; color: #1a1a2e; display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-shield-lock-fill" style="color: #4facfe;"></i>
                Remote Access Audit Trail
            </h1>
            <p style="font-size: 13px; color: #888; margin: 5px 0 0 0;">
                Riwayat lengkap siapa saja yang meremote router Mikrotik via WinBox
            </p>
        </div>

        {{-- Stat Cards --}}
        <div class="stat-cards">
            <div class="stat-card-item">
                <div class="stat-icon blue"><i class="bi bi-broadcast"></i></div>
                <div>
                    <div class="stat-number">{{ $totalToday }} <span
                            style="font-size: 14px; font-weight: 500; opacity: 0.7;">Sesi</span></div>
                    <div class="stat-label">Hari Ini</div>
                </div>
            </div>
            <div class="stat-card-item">
                <div class="stat-icon green"><i class="bi bi-calendar-week"></i></div>
                <div>
                    <div class="stat-number">{{ $totalWeek }} <span
                            style="font-size: 14px; font-weight: 500; opacity: 0.7;">Sesi</span></div>
                    <div class="stat-label">Minggu Ini</div>
                </div>
            </div>
            <div class="stat-card-item">
                <div class="stat-icon purple"><i class="bi bi-database"></i></div>
                <div>
                    <div class="stat-number">{{ $totalAll }} <span
                            style="font-size: 14px; font-weight: 500; opacity: 0.7;">Sesi</span></div>
                    <div class="stat-label">Total Semua</div>
                </div>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="log-table-card">
            <div class="log-table-header" style="padding-bottom: 20px;">
                <h2><i class="bi bi-list-columns-reverse" style="color: #4facfe;"></i> Log Riwayat Remote</h2>
                <form method="GET" action="{{ route('remotelog') }}" class="search-filter-bar">
                    <input type="text" name="search" placeholder="🔍 Cari user, site, IP..."
                        value="{{ request('search') }}" style="min-width: 200px;">
                    <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" title="Dari tanggal">
                    <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" title="Sampai tanggal">
                    <button type="submit" class="btn btn-sm btn-primary"
                        style="border-radius: 8px; padding: 8px 16px; font-size: 13px;">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('remotelog') }}" class="btn btn-sm btn-outline-secondary"
                        style="border-radius: 8px; padding: 8px 12px; font-size: 13px;">
                        Reset
                    </a>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table class="log-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Site Name</th>
                            <th>Site ID</th>
                            <th>IP Router</th>
                            <th>Tunnel VPN</th>
                            <th>Sumber</th>
                            <th>Status Koneksi</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                            <tr>
                                <td class="text-center" style="color: #aaa; font-weight: 600;">
                                    {{ $logs->firstItem() + $index }}</td>
                                <td>
                                    <div class="user-cell">
                                        @if($log->user && $log->user->photo)
                                            <img src="{{ asset('storage_public/' . $log->user->photo) }}" class="user-avatar-sm"
                                                alt="">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($log->user_name) }}&background=random&size=32"
                                                class="user-avatar-sm" alt="">
                                        @endif
                                        <div class="user-info">
                                            <div class="user-name-sm">{{ $log->user_name }}</div>
                                            <div class="user-role-sm">{{ $log->user->role ?? 'user' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-weight: 600;">{{ $log->site_name }}</td>
                                <td>{{ $log->site_code ?? '-' }}</td>
                                <td><span class="ip-mono">{{ $log->ip_router }}</span></td>
                                <td><span class="tunnel-badge">{{ $log->tunnel_name }}</span></td>
                                <td>
                                    @php
                                        $pageClass = match ($log->source_page) {
                                            'datasite' => 'datasite',
                                            'open_ticket' => 'open-ticket',
                                            'nav_modal' => 'nav-modal',
                                            default => 'datasite'
                                        };
                                        $pageLabel = match ($log->source_page) {
                                            'datasite' => 'All Sites',
                                            'open_ticket' => 'Open Ticket',
                                            'nav_modal' => 'Nav Modal',
                                            default => $log->source_page
                                        };
                                    @endphp
                                    <span class="badge-page {{ $pageClass }}">{{ $pageLabel }}</span>
                                </td>
                                <td>
                                    @php
                                        $status = $log->status ?? 'unknown';
                                        $statusLabel = match ($status) {
                                            'success' => '<i class="bi bi-check-circle-fill"></i> Berhasil',
                                            'failed' => '<i class="bi bi-x-circle-fill"></i> Gagal/Offline',
                                            default => '<i class="bi bi-question-circle"></i> Tidak diketahui',
                                        };
                                    @endphp
                                    <span class="badge-status {{ $status }}">{!! $statusLabel !!}</span>
                                </td>
                                <td>
                                    <div class="time-info">
                                        {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Makassar')->format('d M Y') }}
                                        <span
                                            class="time-sub">{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Makassar')->format('H:i') }}
                                            WITA</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <i class="bi bi-shield-slash"></i>
                                        <div style="font-size: 15px; font-weight: 600;">Belum ada riwayat remote</div>
                                        <div style="font-size: 12px; margin-top: 5px;">Log akan tercatat otomatis saat user
                                            menggunakan fitur Remote Mikrotik</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper">
                <span class="pagination-info">
                    Showing {{ $logs->firstItem() ?? 0 }} to {{ $logs->lastItem() ?? 0 }}
                    of&nbsp;<strong>{{ $logs->total() }}</strong>&nbsp;results
                </span>
                <nav>
                    {{ $logs->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>