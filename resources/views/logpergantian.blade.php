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
    <title>Log Perangkat | Project Operational</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}?v=1.2">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- jQuery (Required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        /* ── Sticky Header ── */
        .table-responsive-custom table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f5f6fa !important;
            color: #555 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px;
            padding: 10px 12px !important;
            border-bottom: 2px solid #e0e0e0 !important;
            white-space: nowrap;
        }

        /* ── Sticky Columns ── */
        .sticky-col {
            position: sticky !important;
            background-color: #fff !important;
            z-index: 5 !important;
            background-clip: padding-box;
        }
        thead th.sticky-col {
            z-index: 20 !important;
            background-color: #f5f6fa !important;
        }
        .col-no        { left: 0;     min-width: 48px;  }
        .col-site-id   { left: 48px;  min-width: 130px; }
        .col-nama_site { left: 178px; min-width: 230px; }

        tbody tr:nth-child(even) .sticky-col { background-color: #fafbfc !important; }
        tbody tr:hover td { background-color: #f0f5fb !important; }

        /* ── Perangkat Badge ── */
        .badge-perangkat {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
        }
        .bg-modem       { background-color: #2563eb; }
        .bg-router      { background-color: #7c3aed; }
        .bg-switch      { background-color: #0891b2; }
        .bg-ap1         { background-color: #059669; }
        .bg-ap2         { background-color: #16a34a; }
        .bg-stavol      { background-color: #dc2626; }
        .bg-transceiver { background-color: #d97706; }
        .bg-poe         { background-color: #b45309; }
        .bg-adaptor     { background-color: #1d4ed8; }
        .bg-kabel       { background-color: #1e293b; }
        .bg-access      { background-color: #4f46e5; }
        .bg-lainnya     { background-color: #6b7280; }

        /* ── Layanan Badge ── */
        .badge-layanan {
            display: inline-block;
            padding: 3px 9px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .layanan-sewa  { background-color: #fef3c7; color: #b45309; border: 1px solid #fcd34d; }
        .layanan-bmn   { background-color: #dbeafe; color: #1d4ed8; border: 1px solid #93c5fd; }
        .layanan-other { background-color: #f3f4f6; color: #6b7280; border: 1px solid #e5e7eb; }

        /* ── Status/Catatan badge ── */
        .badge-done {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            background: transparent;
            color: #555;
            border: 1px solid #ccc;
        }

        /* ── Foto list ── */
        .foto-list {
            display: flex;
            flex-direction: column;
            gap: 3px;
            min-width: 150px;
        }
        .foto-link {
            font-size: 11px;
            color: #2563eb;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
            display: block;
        }
        .foto-link:hover { text-decoration: underline; }

        /* ── Filter pill ── */
        .btn-filter-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #0d6efd, #0b5ed7);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(13,110,253,0.3);
        }
        .btn-filter-pill:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13,110,253,0.4);
        }

        /* ── Search box ── */
        .search-box {
            display: flex;
            align-items: center;
            background-color: #f1f3f4;
            border-radius: 50px;
            padding: 4px 16px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            width: 100%;
            max-width: 300px;
        }
        .search-box:focus-within {
            background-color: #fff;
            border-color: #4285f4;
            box-shadow: 0 1px 6px rgba(32,33,36,0.28);
        }
        .search-box input {
            border: none;
            outline: none;
            padding: 8px 0;
            background: transparent;
            flex-grow: 1;
            font-size: 14px;
            color: #3c4043;
        }
        .search-box input::placeholder {
            color: #70757a;
            opacity: 0.8;
        }
        .search-btn {
            background: none;
            border: none;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 16px;
            color: #4285f4;
            display: flex;
            align-items: center;
            justify-content: center;
            order: 2; /* Move icon to right */
        }

        /* ── SN / general cell ── */
        .sn-cell {
            font-size: 11.5px;
            white-space: nowrap;
            color: #374151;
        }

        /* ── Qty ── */
        .qty-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: #e5e7eb;
            font-size: 12px;
            font-weight: 700;
            color: #111;
            padding: 0 4px;
        }

        td, th { vertical-align: middle !important; }

        /* ── sticky right col ── */
        .sticky-col-right {
            position: sticky;
            right: 0;
            background-color: #fff;
            z-index: 5;
            background-clip: padding-box;
            border-left: 1px solid #e0e0e0;
        }
        thead th.sticky-col-right {
            z-index: 20;
            background-color: #f5f6fa !important;
        }

        /* ── Dark Mode Fixes ── */
        [data-bs-theme="dark"] .sticky-col,
        [data-bs-theme="dark"] .sticky-col-right {
            background-color: #212529 !important;
            color: #fff !important;
            border-color: #444 !important;
        }
        [data-bs-theme="dark"] tbody tr:nth-child(even) .sticky-col {
            background-color: #2c3034 !important;
        }
        [data-bs-theme="dark"] thead th {
            background-color: #2c3034 !important;
            color: #dee2e6 !important;
            border-color: #495057 !important;
        }
        [data-bs-theme="dark"] .search-box {
            background-color: #2c3034;
            border-color: #444;
        }
        [data-bs-theme="dark"] .search-box input {
            color: #fff;
        }
        [data-bs-theme="dark"] .search-box input::placeholder {
            color: #999;
        }
        [data-bs-theme="dark"] .qty-badge {
            background-color: #444;
            color: #fff;
        }
        [data-bs-theme="dark"] .bi-info-circle,
        [data-bs-theme="dark"] .bi-pencil,
        [data-bs-theme="dark"] .bi-trash,
        [data-bs-theme="dark"] .btn-action,
        [data-bs-theme="dark"] .search-btn {
            color: #fff !important;
        }
        [data-bs-theme="dark"] .sn-cell, 
        [data-bs-theme="dark"] .text-muted,
        [data-bs-theme="dark"] td {
            color: #dee2e6 !important;
        }
        [data-bs-theme="dark"] .badge-done {
            color: #dee2e6;
            border-color: #555;
        }
        [data-bs-theme="dark"] .table-responsive-custom {
            border-color: #444;
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
                style="position: absolute; right: 0; top: 100%; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
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
                        style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="tabs-section">
    <a href="{{ route('pergantianperangkat') }}"
        class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}"
        style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
    <a href="{{ url('/logpergantian') }}"
        class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}"
        style="text-decoration: none; color: White;">Log Perangkat</a>
    <a href="{{ url('/sparetracker') }}"
        class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}"
        style="text-decoration: none; color: Black;">Spare Tracker</a>
    <a href="{{ url('/pm-summary') }}"
        class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}"
        style="text-decoration: none; color: Black;">Summary</a>
</div>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: '<ul class="text-start">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
        });
    </script>
@endif

<!-- CONTENT -->
<div class="content-container">
    <!-- Toolbar -->
    <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
        style="margin-bottom: 20px;">
        <div class="actions flex-shrink-0">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <button class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal" data-bs-target="#modalTambahPergantian"></button>
                <button class="btn-action bi bi-upload" title="Import Data" data-bs-toggle="modal" data-bs-target="#modalImportLog"></button>
            @endif
            <a href="{{ route('pergantianperangkat.export') }}"
               class="btn-action bi bi-download" title="Download Excel" style="text-decoration: none;"></a>
        </div>
        <div class="w-100 mt-2 mt-lg-0">
            <form method="GET" action="{{ url('/logpergantian') }}"
                class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">

                {{-- Jenis Perangkat --}}
                <div class="col-12 col-md-auto">
                    <select name="perangkat" class="form-select form-select-sm w-100" onchange="this.form.submit()">
                        <option value="">Semua Perangkat</option>
                        @foreach(['MODEM','ROUTER','SWITCH','AP1','AP2','STAVOL','TRANSCEIVER','POE','ADAPTOR MIKROTIK','KABEL LAN','ACCESS POINT','LAINNYA'] as $p)
                            <option value="{{ $p }}" {{ request('perangkat') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Layanan --}}
                <div class="col-12 col-md-auto">
                    <select name="layanan" class="form-select form-select-sm w-100" onchange="this.form.submit()">
                        <option value="">Semua Layanan</option>
                        <option value="SEWA LAYANAN" {{ request('layanan') == 'SEWA LAYANAN' ? 'selected' : '' }}>SEWA LAYANAN</option>
                        <option value="BMN" {{ request('layanan') == 'BMN' ? 'selected' : '' }}>BMN</option>
                    </select>
                </div>

                {{-- Date range --}}
                <div class="col-12 col-md-auto">
                    <input type="date" name="tgl_mulai" class="form-control form-control-sm"
                        value="{{ request('tgl_mulai') }}" title="Dari Tanggal">
                </div>
                <div class="col-12 col-md-auto">
                    <input type="date" name="tgl_selesai" class="form-control form-control-sm"
                        value="{{ request('tgl_selesai') }}" title="Sampai Tanggal">
                </div>

                {{-- Filter --}}
                <div class="col-auto">
                    <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>

                {{-- Reset --}}
                <div class="col-auto">
                    <a href="{{ url('/logpergantian') }}"
                        class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                        title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                </div>

                {{-- Search --}}
                <div class="col-12 col-md-auto">
                    <div class="search-box">
                        <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}">
                        <button type="submit" class="search-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="10" cy="10" r="7" stroke="#5a3592" stroke-width="2.5" fill="#4dd0e1" />
                                <path d="M15 15L20 20" stroke="#5a3592" stroke-width="2.5" stroke-linecap="round"/>
                                <circle cx="8" cy="8" r="3" fill="white" fill-opacity="0.3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive-custom">
        <table>
            <thead>
                <tr class="thead-dark">
                    <th class="text-center sticky-col col-no">NO</th>
                    <th class="sticky-col col-site-id">SITE ID</th>
                    <th class="sticky-col col-nama_site">SITE NAME</th>
                    <th>JENIS PERANGKAT</th>
                    <th class="text-center">QTY</th>
                    <th>SN PERANGKAT LAMA</th>
                    <th>SN PERANGKAT BARU</th>
                    <th>TANGGAL PERGANTIAN</th>
                    <th>LAYANAN</th>
                    <th>CATATAN</th>
                    <th>FOTO PERANGKAT BARU</th>
                    <th>STATUS</th>
                    <th class="text-center sticky-col-right">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($log_data as $index => $item)
                    @php
                        /* ── perangkat colour ── */
                        $p = strtoupper($item->perangkat ?? '');
                        $bgClass = match(true) {
                            str_contains($p, 'MODEM')        => 'bg-modem',
                            str_contains($p, 'ROUTER')       => 'bg-router',
                            str_contains($p, 'SWITCH')       => 'bg-switch',
                            $p === 'AP1'                     => 'bg-ap1',
                            $p === 'AP2'                     => 'bg-ap2',
                            str_contains($p, 'STAVOL')       => 'bg-stavol',
                            str_contains($p, 'TRANSCEIVER')  => 'bg-transceiver',
                            str_contains($p, 'POE')          => 'bg-poe',
                            str_contains($p, 'ADAPTOR')      => 'bg-adaptor',
                            str_contains($p, 'KABEL')        => 'bg-kabel',
                            str_contains($p, 'ACCESS')       => 'bg-access',
                            default                          => 'bg-lainnya',
                        };

                        /* ── layanan colour ── */
                        $layanan = strtoupper($item->layanan ?? '');
                        $layananClass = match(true) {
                            str_contains($layanan, 'SEWA') => 'layanan-sewa',
                            str_contains($layanan, 'BMN')  => 'layanan-bmn',
                            default                        => 'layanan-other',
                        };
                    @endphp
                    <tr>
                        {{-- NO --}}
                        <td class="text-center sticky-col col-no">
                            {{ ($log_data->currentPage() - 1) * $log_data->perPage() + $index + 1 }}
                        </td>

                        {{-- SITE ID --}}
                        <td class="sticky-col col-site-id" style="font-size:12px; font-weight:600;">
                            {{ $item->site->site_id ?? '-' }}
                        </td>

                        {{-- SITE NAME --}}
                        <td class="sticky-col col-nama_site" style="font-size:12px;">
                            {{ $item->site->sitename ?? '-' }}
                        </td>

                        {{-- JENIS PERANGKAT --}}
                        <td>
                            <span class="badge-perangkat {{ $bgClass }}">{{ $item->perangkat ?? '-' }}</span>
                        </td>

                        {{-- QTY --}}
                        <td class="text-center">
                            <span class="qty-badge">{{ $item->qty ?? 1 }}</span>
                        </td>

                        {{-- SN LAMA --}}
                        <td class="sn-cell">{{ $item->sn_lama ?? '-' }}</td>

                        {{-- SN BARU --}}
                        <td class="sn-cell">{{ $item->sn_baru ?? '-' }}</td>

                        {{-- TANGGAL --}}
                        <td style="font-size:12px; white-space:nowrap;">
                            {{ $item->tanggal_penggantian
                                ? \Carbon\Carbon::parse($item->tanggal_penggantian)->format('d/m/Y')
                                : '-' }}
                        </td>

                        {{-- LAYANAN --}}
                        <td>
                            @if(!empty($item->layanan))
                                <span class="badge-layanan {{ $layananClass }}">{{ $item->layanan }}</span>
                            @else
                                <span style="color:#bbb; font-size:12px;">-</span>
                            @endif
                        </td>

                        {{-- CATATAN / KETERANGAN --}}
                        <td style="font-size:12px; max-width:180px;">
                            @if(!empty($item->keterangan))
                                {{ $item->keterangan }}
                            @else
                                <span style="color:#bbb;">-</span>
                            @endif
                        </td>

                        {{-- FOTO PERANGKAT BARU --}}
                        <td>
                            @if(!empty($item->foto_perangkat_baru))
                                <div class="foto-list">
                                    @php
                                        $fotos = is_array($item->foto_perangkat_baru)
                                            ? $item->foto_perangkat_baru
                                            : (json_decode($item->foto_perangkat_baru, true) ?? [$item->foto_perangkat_baru]);
                                    @endphp
                                    @foreach($fotos as $foto)
                                        <a href="{{ asset('storage/' . $foto) }}"
                                            target="_blank" class="foto-link" title="{{ basename($foto) }}">
                                            <i class="bi bi-file-image me-1" style="font-size:10px;"></i>{{ basename($foto) }}
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span style="color:#bbb; font-size:12px;">-</span>
                            @endif
                        </td>

                        {{-- STATUS --}}
                        <td style="font-size:12px;">
                            @if(!empty($item->status))
                                @php $st = strtoupper(trim($item->status)); @endphp
                                @if($st === 'DONE')
                                    <span class="badge-done">DONE</span>
                                @else
                                    <span style="color:#374151;">{{ $item->status }}</span>
                                @endif
                            @else
                                <span style="color:#bbb; font-size:12px;">-</span>
                            @endif
                        </td>
                        {{-- AKSI --}}
                        <td class="text-center sticky-col-right">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- INFO --}}
                                <button type="button" class="btn btn-sm bi bi-info-circle" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalInfoPergantian{{ $item->id }}"
                                        style="background: none; border: none; color: black; font-size: 1.1rem;" title="Detail Info"></button>
                                
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    {{-- EDIT --}}
                                    <button type="button" class="btn btn-sm bi bi-pencil" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEditPergantian{{ $item->id }}"
                                            style="background: none; border: none; color: black; font-size: 1.1rem;" title="Edit"></button>
                                    
                                    {{-- DELETE --}}
                                    <form action="{{ route('pergantianperangkat.destroy', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm bi bi-trash btn-delete" 
                                                data-perangkat="{{ $item->perangkat }}" 
                                                data-site="{{ $item->site->sitename ?? $item->site->site_id }}"
                                                style="background: none; border: none; color: black; font-size: 1.1rem;" title="Hapus"></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="empty text-center py-4">
                            <i class="bi bi-inbox" style="font-size:2rem; color:#ccc;"></i>
                            <div style="color:#aaa; margin-top:6px;">Showing 0 of 0 results</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        <span class="pagination-info">
            Showing {{ $log_data->firstItem() ?? 0 }} to {{ $log_data->lastItem() ?? 0 }}
            of&nbsp;<strong>{{ $log_data->total() }}</strong>&nbsp;results
        </span>
        <nav>
            {{ $log_data->appends(request()->query())->links("pagination::bootstrap-5") }}
        </nav>
    </div>
</div>

<!-- Modal Tambah Pergantian -->
<div class="modal fade" id="modalTambahPergantian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pergantianperangkat.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                    <h5 class="modal-title w-100 text-center">Tambah Log Pergantian</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="bi bi-search me-1"></i>Cari Site ID / Nama Site</label>
                        <select name="site_id" id="siteSelectAdd" class="form-select select2-site" required style="width: 100%;">
                            <option value="">-- Cari Site ID --</option>
                            @foreach($sites as $site)
                                <option value="{{ $site->id }}" 
                                        data-siteid="{{ $site->site_id }}" 
                                        data-sitename="{{ $site->sitename }}"
                                        data-tipe="{{ $site->tipe }}">
                                    {{ $site->site_id }} - {{ $site->sitename }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Site ID</label>
                            <input type="text" id="display_site_id" class="form-control bg-light" readonly placeholder="-">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nama Site</label>
                            <input type="text" id="display_site_name" class="form-control bg-light" readonly placeholder="-">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Perangkat</label>
                            <select name="perangkat" class="form-select" required>
                                <option value="" selected disabled>Pilih Perangkat</option>
                                <option value="MODEM">MODEM</option>
                                <option value="ROUTER">ROUTER</option>
                                <option value="SWITCH">SWITCH</option>
                                <option value="AP1">AP1</option>
                                <option value="AP2">AP2</option>
                                <option value="STAVOL">STAVOL</option>
                                <option value="TRANSCEIVER">TRANSCEIVER</option>
                                <option value="POE">POE</option>
                                <option value="ADAPTOR MIKROTIK">ADAPTOR MIKROTIK</option>
                                <option value="KABEL LAN">KABEL LAN</option>
                                <option value="ACCESS POINT">ACCESS POINT</option>
                                <option value="LAINNYA">LAINNYA</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Qty</label>
                            <input type="number" name="qty" class="form-control" min="1" value="1">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal</label>
                            <input type="date" name="tanggal_penggantian" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Layanan</label>
                            <input type="text" name="layanan" id="layananAdd" class="form-control bg-light" readonly placeholder="-">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">SN Lama</label>
                            <input type="text" name="sn_lama" class="form-control" placeholder="Masukkan SN Lama">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">SN Baru</label>
                            <input type="text" name="sn_baru" class="form-control" placeholder="Masukkan SN Baru">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Foto Perangkat Baru</label>
                        <input type="file" name="foto_perangkat_baru" class="form-control" accept="image/*">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">- Pilih Status -</option>
                                <option value="DONE">DONE</option>
                                <option value="PENDING">PENDING</option>
                                <option value="PROSES">PROSES</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Catatan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Import Log -->
<div class="modal fade" id="modalImportLog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('pergantianperangkat.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header text-white" style="background-color: #071152;">
                    <h5 class="modal-title">Import Log Pergantian</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                        <div class="mt-2 small text-muted">
                            <i class="bi bi-info-circle me-1"></i> Pastikan format file sesuai dengan template.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Unggah & Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($log_data as $item)
    @php
        $p = strtoupper($item->perangkat ?? '');
        $bgClass = match(true) {
            str_contains($p, 'MODEM')        => 'bg-modem',
            str_contains($p, 'ROUTER')       => 'bg-router',
            str_contains($p, 'SWITCH')       => 'bg-switch',
            $p === 'AP1'                     => 'bg-ap1',
            $p === 'AP2'                     => 'bg-ap2',
            str_contains($p, 'STAVOL')       => 'bg-stavol',
            str_contains($p, 'TRANSCEIVER')  => 'bg-transceiver',
            str_contains($p, 'POE')          => 'bg-poe',
            str_contains($p, 'ADAPTOR')      => 'bg-adaptor',
            str_contains($p, 'KABEL')        => 'bg-kabel',
            str_contains($p, 'ACCESS')       => 'bg-access',
            default                          => 'bg-lainnya',
        };
        $fotos = is_array($item->foto_perangkat_baru)
            ? $item->foto_perangkat_baru
            : (json_decode($item->foto_perangkat_baru, true) ?? [$item->foto_perangkat_baru]);
    @endphp
    <!-- Modal Edit Pergantian -->
    <div class="modal fade" id="modalEditPergantian{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pergantianperangkat.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                        <h5 class="modal-title w-100 text-center">Edit Log - {{ $item->site->sitename ?? $item->site->site_id }}</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Site (ID atau Nama)</label>
                            <select name="site_id" class="form-select select2-site-edit" id="siteSelectEdit{{ $item->id }}" required style="width: 100%;">
                                @foreach($sites as $site)
                                    <option value="{{ $site->id }}" 
                                            data-siteid="{{ $site->site_id }}" 
                                            data-sitename="{{ $site->sitename }}"
                                            data-tipe="{{ $site->tipe }}"
                                            {{ $item->site_id == $site->id ? 'selected' : '' }}>
                                        {{ $site->site_id }} - {{ $site->sitename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Site ID</label>
                                <input type="text" id="display_site_id_edit_{{ $item->id }}" class="form-control bg-light" readonly value="{{ $item->site->site_id ?? '-' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nama Site</label>
                                <input type="text" id="display_site_name_edit_{{ $item->id }}" class="form-control bg-light" readonly value="{{ $item->site->sitename ?? '-' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Perangkat</label>
                                <select name="perangkat" class="form-select" required>
                                    @foreach(['MODEM','ROUTER','SWITCH','AP1','AP2','STAVOL','TRANSCEIVER','POE','ADAPTOR MIKROTIK','KABEL LAN','ACCESS POINT','LAINNYA'] as $p_opt)
                                        <option value="{{ $p_opt }}" {{ $item->perangkat == $p_opt ? 'selected' : '' }}>{{ $p_opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Qty</label>
                                <input type="number" name="qty" class="form-control" min="1" value="{{ $item->qty ?? 1 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" name="tanggal_penggantian" class="form-control" value="{{ $item->tanggal_penggantian }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Layanan</label>
                                <input type="text" name="layanan" id="layananEdit{{ $item->id }}" class="form-control bg-light" readonly value="{{ $item->layanan ?? '-' }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">SN Lama</label>
                                <input type="text" name="sn_lama" class="form-control" value="{{ $item->sn_lama }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">SN Baru</label>
                                <input type="text" name="sn_baru" class="form-control" value="{{ $item->sn_baru }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Foto Perangkat Baru</label>
                            @if(!empty($item->foto_perangkat_baru))
                                <div class="mb-1"><small class="text-muted">Foto saat ini: <a href="{{ asset('storage/'.$item->foto_perangkat_baru) }}" target="_blank">{{ basename($item->foto_perangkat_baru) }}</a></small></div>
                            @endif
                            <input type="file" name="foto_perangkat_baru" class="form-control" accept="image/*">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">- Pilih Status -</option>
                                    <option value="DONE" {{ $item->status == 'DONE' ? 'selected' : '' }}>DONE</option>
                                    <option value="PENDING" {{ $item->status == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                    <option value="PROSES" {{ $item->status == 'PROSES' ? 'selected' : '' }}>PROSES</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Catatan</label>
                                <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Info Pergantian -->
    <div class="modal fade" id="modalInfoPergantian{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #071152;">
                    <h5 class="modal-title"><i class="bi bi-info-circle me-2"></i>Detail Pergantian Perangkat</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted text-uppercase small">Informasi Site</h6>
                            <table class="table table-sm table-borderless">
                                <tr><td width="120">Site ID</td><td>: <strong>{{ $item->site->site_id ?? '-' }}</strong></td></tr>
                                <tr><td>Nama Site</td><td>: {{ $item->site->sitename ?? '-' }}</td></tr>
                                <tr><td>Alamat</td><td>: {{ $item->site->alamat ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6 border-start">
                            <h6 class="fw-bold text-muted text-uppercase small">Informasi Perangkat</h6>
                            <table class="table table-sm table-borderless">
                                <tr><td width="120">Perangkat</td><td>: <span class="badge-perangkat {{ $bgClass }}">{{ $item->perangkat }}</span></td></tr>
                                <tr><td>Qty</td><td>: {{ $item->qty ?? 1 }} Unit</td></tr>
                                <tr><td>Layanan</td><td>: {{ $item->layanan ?? '-' }}</td></tr>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-muted text-uppercase small">Serial Number</h6>
                            <div class="p-3 bg-light rounded border mb-3">
                                <div class="mb-2">
                                    <small class="text-muted d-block">SN LAMA:</small>
                                    <code class="fs-6">{{ $item->sn_lama ?? 'TIDAK ADA' }}</code>
                                </div>
                                <div>
                                    <small class="text-muted d-block">SN BARU:</small>
                                    <code class="fs-6 text-success fw-bold">{{ $item->sn_baru ?? 'TIDAK ADA' }}</code>
                                </div>
                            </div>
                            <h6 class="fw-bold text-muted text-uppercase small">Waktu & Status</h6>
                            <table class="table table-sm table-borderless">
                                <tr><td width="120">Tanggal</td><td>: {{ $item->tanggal_penggantian }}</td></tr>
                                <tr><td>Status</td><td>: {{ $item->status ?? '-' }}</td></tr>
                            </table>
                        </div>
                        <div class="col-md-6 border-start">
                            <h6 class="fw-bold text-muted text-uppercase small">Catatan & Foto</h6>
                            <div class="mb-3">
                                <small class="text-muted d-block">Catatan:</small>
                                <p class="mb-0 small">{{ $item->keterangan ?? '-' }}</p>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-2">Foto Perangkat Baru:</small>
                                @if(!empty($item->foto_perangkat_baru))
                                    @foreach($fotos as $foto)
                                        @if(!empty($foto))
                                        <div class="mb-2">
                                            <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded border" style="max-height: 120px;" alt="Foto Perangkat">
                                            </a>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="p-3 text-center bg-light rounded border small text-muted">Tidak ada foto</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize Select2 for Add Modal
        $('#siteSelectAdd').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Cari Site ID --',
            dropdownParent: $('#modalTambahPergantian'),
            width: '100%'
        }).on('select2:select', function (e) {
            const data = e.params.data.element.dataset;
            $('#display_site_id').val(data.siteid);
            $('#display_site_name').val(data.sitename);
            
            // Auto-fill Layanan
            let tipeRaw = (data.tipe || '').toUpperCase().trim();
            let layananVal = '-';
            if (tipeRaw === 'SL' || tipeRaw === 'SEWA LAYANAN') {
                layananVal = 'SEWA LAYANAN';
            } else if (tipeRaw === 'BMN' || tipeRaw === 'BARANG MILIK NEGARA (BMN)') {
                layananVal = 'BARANG MILIK NEGARA (BMN)';
            } else {
                layananVal = tipeRaw || '-';
            }
            $('#layananAdd').val(layananVal);
        });

        // Initialize Select2 for Edit Modals
        $('.select2-site-edit').each(function() {
            const modalId = $(this).closest('.modal').attr('id');
            const itemId = modalId.replace('modalEditPergantian', '');
            
            $(this).select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#' + modalId),
                width: '100%'
            }).on('select2:select', function (e) {
                const data = e.params.data.element.dataset;
                $(`#display_site_id_edit_${itemId}`).val(data.siteid);
                $(`#display_site_name_edit_${itemId}`).val(data.sitename);

                // Auto-fill Layanan for Edit
                let tipeRaw = (data.tipe || '').toUpperCase().trim();
                let layananVal = '-';
                if (tipeRaw === 'SL' || tipeRaw === 'SEWA LAYANAN') {
                    layananVal = 'SEWA LAYANAN';
                } else if (tipeRaw === 'BMN' || tipeRaw === 'BARANG MILIK NEGARA (BMN)') {
                    layananVal = 'BARANG MILIK NEGARA (BMN)';
                } else {
                    layananVal = tipeRaw || '-';
                }
                $(`#layananEdit${itemId}`).val(layananVal);
            });
        });
    });

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('form');
            const perangkat = this.getAttribute('data-perangkat');
            const site = this.getAttribute('data-site');
            
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: `Data pergantian ${perangkat} di site ${site} akan dihapus!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
</body>
</html>