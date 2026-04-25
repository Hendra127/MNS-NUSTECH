<!DOCTYPE html>
<html>

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Preventive Maintenance | Project Operational</title>
    <style>
        /* Modern Table Sticky Header */
        .table-responsive-custom table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f5f6fa !important;
            color: #555 !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 11px;
            padding: 12px 15px !important;
            border-bottom: 2px solid #e0e0e0 !important;
            box-shadow: 0 1px 0 #e0e0e0;
        }

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

        .col-no {
            left: 0;
            min-width: 50px;
        }

        .col-site-id {
            left: 50px;
            min-width: 135px;
        }

        .col-nama_lokasi {
            left: 185px;
            min-width: 250px;
        }

        /* Striped background for sticky columns */
        tbody tr:nth-child(even) .sticky-col {
            background-color: #fafbfc !important;
        }

        /* Hover effect */
        tbody tr:hover td {
            background-color: #f0f5fb !important;
        }

        /* Table Structure Refinement */
        .table-responsive-custom {
            max-height: 700px;
            overflow: auto;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .search-box {
            display: flex;
            align-items: center;
        }

        .search-box input {
            border: none;
            outline: none;
            padding: 20px;
            background: transparent;
        }

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
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.3);
        }

        .btn-filter-pill:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
        }

        [data-bs-theme="dark"] .btn-filter-pill {
            background: linear-gradient(135deg, #1a6fc4, #0d5dbc);
        }

        .summary-badge {
            font-size: 12px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
            display: inline-flex;
            align-items: center;
        }

        .tabs-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-form {
                width: 100%;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
        }

        /* Select2 Custom Styling */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 12px !important;
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            border: 1px solid #ced4da !important;
            font-size: 16px !important;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 15px !important;
            color: #495057 !important;
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-radius: 12px !important;
            border: 1px solid #ced4da !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
        }

        .select2-container--bootstrap-5 .select2-search__field {
            border-radius: 8px !important;
            margin: 10px !important;
            width: calc(100% - 20px) !important;
            border: 1px solid #7cb5f9 !important;
            padding: 8px 12px !important;
        }

        .select2-results__option {
            padding: 12px 15px !important;
            font-size: 15px !important;
            border-bottom: 1px solid #f8f9fa !important;
        }

        .select2-results__option--highlighted {
            background-color: #f0f4f8 !important;
            color: #000 !important;
        }

        /* Google Drive Smart Chip Style */
        .drive-chip {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            background: #fff;
            border: 1px solid #dadce0;
            border-radius: 20px;
            font-size: 12px;
            color: #3c4043;
            text-decoration: none !important;
            transition: all 0.2s ease;
            max-width: 180px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            box-shadow: 0 1px 2px rgba(60, 64, 67, 0.1);
        }

        .drive-chip:hover {
            background: #f8f9fa;
            color: #1a73e8;
            border-color: #d2e3fc;
            box-shadow: 0 2px 5px rgba(60, 64, 67, 0.15);
            transform: translateY(-1px);
        }

        .drive-chip i {
            color: #1e8e3e;
            margin-right: 8px;
            font-size: 14px;
        }

        [data-bs-theme="dark"] .drive-chip {
            background: #2d2e30;
            border-color: #5f6368;
            color: #e8eaed;
        }

        [data-bs-theme="dark"] .drive-chip:hover {
            background: #3c4043;
            color: #8ab4f8;
            border-color: #8ab4f8;
        }

        /* Google Drive Preview Card Styles - Premium & Tidy */
        .drive-preview-card {
            position: fixed;
            width: 300px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12), 0 0 0 1px rgba(0, 0, 0, 0.05);
            z-index: 2000;
            padding: 0;
            overflow: hidden;
            pointer-events: auto;
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateY(10px) scale(0.98);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .drive-preview-card.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .preview-header {
            display: flex;
            align-items: center;
            padding: 10px 14px;
            gap: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .preview-header i.bi-file-pdf {
            color: #ea4335;
            font-size: 18px;
            flex-shrink: 0;
        }

        .preview-title {
            flex-grow: 1;
            font-weight: 600;
            font-size: 13px;
            color: #1a73e8;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .preview-actions {
            display: flex;
            align-items: center;
            gap: 2px;
            flex-shrink: 0;
        }

        .preview-actions i {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            color: #5f6368;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .preview-actions i:hover {
            background-color: rgba(0, 0, 0, 0.05);
            color: #202124;
        }

        .preview-body {
            padding: 10px 14px;
        }

        .preview-thumbnail {
            width: 100%;
            height: 140px;
            background: #f1f3f4;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .preview-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-footer {
            padding: 0 14px 14px;
        }

        .preview-info-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 11px;
            color: #5f6368;
        }

        .preview-info-row i {
            font-size: 14px;
        }

        .preview-cta {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
        }

        .btn-ringkas {
            background: #0d6efd;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-grow: 1;
            justify-content: center;
        }

        .btn-circle-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f1f3f4;
            color: #5f6368;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            transition: all 0.2s;
        }

        .btn-circle-action:hover {
            background: #e8eaed;
            color: #202124;
        }

        [data-bs-theme="dark"] .drive-preview-card {
            background: #1e1e21;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid #444;
        }

        [data-bs-theme="dark"] .preview-header {
            border-bottom-color: #333;
        }

        [data-bs-theme="dark"] .preview-title {
            color: #8ab4f8;
        }

        [data-bs-theme="dark"] .preview-thumbnail {
            background: #2d2e31;
            border-color: #3c4043;
        }

        [data-bs-theme="dark"] .preview-info-row {
            color: #9aa0a6;
        }

        [data-bs-theme="dark"] .btn-ringkas {
            background: #3c4043;
            color: #8ab4f8;
        }

        [data-bs-theme="dark"] .btn-circle-action {
            background: #303134;
            color: #8ab4f8;
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*', 'sites*') ? 'active' : '' }}"
            style="text-decoration: none;">All Sites</a>
        <a href="{{ route('datapas') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}"
            style="text-decoration: none;">Management Password</a>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
            <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}"
                style="text-decoration: none;">Correctiv Maintenance</a>
        @endif
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}"
            style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}"
            style="text-decoration: none;">PM Summary</a>
        <div class="ms-auto d-flex align-items-center flex-wrap gap-2">
            <span class="summary-badge text-black">BMN Done: <b>&nbsp;{{ $totalBMNDone }}</b></span>
            <span class="summary-badge text-black">SL Done: <b>&nbsp;{{ $totalSLDone }}</b></span>
            <span class="summary-badge text-black">HOLD: <b>&nbsp;{{ $totalHold }}</b></span>
            <span class="summary-badge text-dark">Pending: <b>&nbsp;{{ $totalPending }}</b></span>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal"
                        data-bs-target="#modalTambah"></button>
                    <form action="{{ route('pmliberta.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm" class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" accept=".xlsx, .xls, .csv"
                            onchange="handleFileUpload()">
                        <button type="button" class="btn-action bi bi-upload" title="Upload"
                            onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
                <a href="{{ route('pmliberta.export', request()->all()) }}" class="btn-action bi bi-download"
                    title="Download"
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('pmliberta') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="searchForm">
                    <div class="col-auto">
                        <select name="kategori" class="form-select form-select-sm" style="max-width: 130px;">
                            <option value="">Semua Kategori</option>
                            <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="status" class="form-select form-select-sm" style="max-width: 120px;">
                            <option value="">Semua Status</option>
                            <option value="DONE" {{ request('status') == 'DONE' ? 'selected' : '' }}>DONE</option>
                            <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                            <option value="ON PROGRESS" {{ request('status') == 'ON PROGRESS' ? 'selected' : '' }}>ON PROGRESS</option>
                            <option value="HOLD" {{ request('status') == 'HOLD' ? 'selected' : '' }}>HOLD</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="provinsi" id="filter-provinsi" class="form-select form-select-sm" style="max-width: 115px;">
                            <option value="">Provinsi...</option>
                            @foreach($provinsiList as $p)
                                <option value="{{ $p }}" {{ request('provinsi') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <select name="kab" id="filter-kab" class="form-select form-select-sm" style="max-width: 120px;">
                            <option value="">Kabupaten...</option>
                            @if(request('provinsi') && isset($provinsiKabMap[request('provinsi')]))
                                @foreach($provinsiKabMap[request('provinsi')] as $k)
                                    <option value="{{ $k }}" {{ request('kab') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="date" name="tgl_mulai" class="form-control form-control-sm" style="max-width: 140px;"
                            value="{{ request('tgl_mulai') }}" title="Dari Tanggal">
                    </div>
                    <div class="col-auto">
                        <input type="date" name="tgl_selesai" class="form-control form-control-sm" style="max-width: 140px;"
                            value="{{ request('tgl_selesai') }}" title="Sampai Tanggal">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('pmliberta') }}"
                            class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                            title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-auto">
                        <div class="search-box d-flex align-items-center">
                            <input type="text" id="search-input" name="search" placeholder="Search..."
                                value="{{ request('search') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 15px; min-width: 120px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive-custom">
            <table>
                <thead>
                    <tr>
                        <th class="text-center sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_lokasi" style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="NAMA LOKASI">NAMA LOKASI</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN / KOTA</th>
                        <th>PIC CE</th>
                        <th>MONTH</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>KATEGORI</th>
                        <th>FILE PM</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="sticky-col-right">AKSI</th>
                        @elseif(auth()->check() && auth()->user()->role === 'user')
                            <th class="sticky-col-right">INFO</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pm_data as $key => $item)
                    <tr>
                        <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                        <td class="text-center sticky-col col-site-id">{{ $item->site_id }}</td>
                        <td class="sticky-col col-nama_lokasi text-truncate" style="max-width: 150px;" title="{{ $item->nama_lokasi }}">{{ $item->nama_lokasi }}</td>
                        <td>{{ $item->provinsi }}</td>
                        <td>{{ $item->kabupaten }}</td>
                        <td>{{ $item->pic_ce }}</td>
                        <td class="text-center">{{ $item->month }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @php
                                $displayStatus = $item->status ?: 'PENDING';
                                $badgeClass = 'bg-secondary';
                                if (strtoupper($displayStatus) == 'DONE')
                                    $badgeClass = 'bg-success';
                                elseif (strtoupper($displayStatus) == 'PENDING')
                                    $badgeClass = 'bg-warning';
                                elseif (strtoupper($displayStatus) == 'ON PROGRESS')
                                    $badgeClass = 'bg-info';
                                elseif (strtoupper($displayStatus) == 'HOLD')
                                    $badgeClass = 'bg-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} text-white">
                                {{ $displayStatus }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->kategori }}</td>
                        <td class="text-center">
                            @if($item->file_pm)
                                @php
                                    $fileName = "PM " . $item->site_id . " " . $item->nama_lokasi . " " . ($item->date ? \Carbon\Carbon::parse($item->date)->format('Y') : '') . " .pdf";
                                @endphp
                                <a href="{{ $item->file_pm }}" target="_blank" class="drive-chip" title="{{ $fileName }}"
                                    onmouseover="showDrivePreview(this, '{{ $item->file_pm }}', '{{ $fileName }}')"
                                    onmouseout="hideDrivePreview()">
                                    <i class="bi bi-file-earmark-pdf-fill"></i>
                                    <span>{{ $fileName }}</span>
                                </a>
                            @else
                                <span class="text-muted small">No File</span>
                            @endif
                        </td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <td class="text-center sticky-col-right">
                                <div class="btn-group btn-group-sm">
                                    @if(!(auth()->user()->role === 'admin' && strtoupper($item->status ?: 'PENDING') === 'DONE'))
                                        <button type="button" class="btn bi bi-pencil btn-edit" data-id="{{ $item->id }}"
                                            data-site_id="{{ $item->site_id }}" data-nama_lokasi="{{ $item->nama_lokasi }}"
                                            data-provinsi="{{ $item->provinsi }}" data-kabupaten="{{ $item->kabupaten }}"
                                            data-date="{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '' }}"
                                            data-month="{{ $item->month }}" data-status="{{ $item->status }}"
                                            data-week="{{ $item->week }}" data-kategori="{{ $item->kategori }}"
                                            data-file_pm="{{ $item->file_pm }}">
                                        </button>
                                        <form action="{{ route('pmliberta.destroy', $item->id) }}" method="POST"
                                            class="form-delete">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn bi bi-trash btn-delete-trigger"
                                                data-nama="{{ $item->nama_lokasi }}"> </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-muted border py-1 px-2"
                                            style="font-size: 10px; cursor: not-allowed;" title="Data DONE telah dikunci">
                                            <i class="bi bi-lock-fill"></i> LOCKED
                                        </span>
                                    @endif
                                </div>
                            </td>
                        @elseif(auth()->check() && auth()->user()->role === 'user')
                            <td class="text-center sticky-col-right">
                                <button type="button" class="btn btn-sm bi bi-info-circle btn-info-pm"
                                    data-id="{{ $item->id }}"
                                    data-site_id="{{ $item->site_id }}" data-nama_lokasi="{{ $item->nama_lokasi }}"
                                    data-provinsi="{{ $item->provinsi }}" data-kabupaten="{{ $item->kabupaten }}"
                                    data-date="{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('d M Y') : '-' }}"
                                    data-month="{{ $item->month }}" data-status="{{ $item->status }}"
                                    data-week="{{ $item->week }}" data-kategori="{{ $item->kategori }}"
                                    data-file_pm="{{ $item->file_pm }}" title="Info">
                                </button>
                            </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $pm_data->firstItem() }} to {{ $pm_data->lastItem() }}
                of&nbsp;<strong>{{ $pm_data->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $pm_data->onEachSide(1)->links() }}
            </nav>
        </div>
    </div>
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white d-flex justify-content-center position-relative"
                        style="background-color: #071152;">
                        <h5 class="modal-title w-100 text-center">Edit Data Preventive Maintenance</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Site ID</label>
                                <input type="text" name="site_id" id="edit_site_id" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Lokasi</label>
                                <input type="text" name="nama_lokasi" id="edit_nama_lokasi" class="form-control"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" id="edit_provinsi" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kabupaten</label>
                                <input type="text" name="kabupaten" id="edit_kabupaten" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date (Tanggal)</label>
                                <input type="date" name="date" id="edit_date" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Month</label>
                                <input type="text" name="month" id="edit_month" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Week</label>
                                <select name="week" id="edit_week" class="form-select">
                                    <option value="WEEK 1">WEEK 1</option>
                                    <option value="WEEK 2">WEEK 2</option>
                                    <option value="WEEK 3">WEEK 3</option>
                                    <option value="WEEK 4">WEEK 4</option>
                                </select>
                            </div>
                            <div class="col-md-4"> <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="BMN">BMN</option>
                                    <option value="SL">SL</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" id="edit_status" class="form-select">
                                    @if(auth()->user()->role !== 'admin')
                                        <option value="DONE">DONE</option>
                                        <option value="PENDING">PENDING</option>
                                        <option value="ON PROGRESS">ON PROGRESS</option>
                                    @endif
                                    <option value="HOLD">HOLD</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Link Google Drive (File PM)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="file_pm" id="edit_file_pm"
                                        class="form-control border-start-0" placeholder="https://drive.google.com/...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- MODAL TAMBAH DATA --}}
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg rounded-4 border-0">
                <form action="{{ route('pmliberta.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white d-flex justify-content-center position-relative"
                        style="background-color: #071152; border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title w-100 text-center fw-bold">Tambah Data Preventive Maintenance</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Cari Site ID</label>
                                <select id="siteSelectAdd" class="form-select select2-site" required>
                                    <option value="">-- Pilih Site --</option>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->site_id }}" data-name="{{ $site->sitename }}"
                                            data-provinsi="{{ $site->provinsi }}" data-kabupaten="{{ $site->kab }}">
                                            {{ $site->site_id }} - {{ $site->sitename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Hidden input for real site_id submit --}}
                            <input type="hidden" name="site_id" id="add_site_id">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lokasi</label>
                                <input type="text" name="nama_lokasi" id="add_nama_lokasi"
                                    class="form-control rounded-3" required readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kategori</label>
                                <select name="kategori" class="form-select rounded-3" required>
                                    <option value="" selected disabled>-- Pilih Kategori --</option>
                                    <option value="BMN">BMN</option>
                                    <option value="SL">SL</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Provinsi</label>
                                <input type="text" name="provinsi" id="add_provinsi" class="form-control rounded-3"
                                    readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kabupaten</label>
                                <input type="text" name="kabupaten" id="add_kabupaten" class="form-control rounded-3"
                                    readonly style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Date (Tanggal)</label>
                                <input type="date" name="date" id="add_date" class="form-control rounded-3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Month</label>
                                <input type="text" name="month" id="add_month" class="form-control rounded-3" readonly
                                    style="background-color: #f8f9fa;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Week</label>
                                <select name="week" class="form-select rounded-3">
                                    <option value="WEEK 1">WEEK 1</option>
                                    <option value="WEEK 2">WEEK 2</option>
                                    <option value="WEEK 3">WEEK 3</option>
                                    <option value="WEEK 4">WEEK 4</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Status</label>
                                <select name="status" class="form-select rounded-3">
                                    @if(auth()->user()->role !== 'admin')
                                        <option value="DONE">DONE</option>
                                        <option value="PENDING" selected>PENDING</option>
                                        <option value="ON PROGRESS">ON PROGRESS</option>
                                        <option value="HOLD">HOLD</option>
                                    @else
                                        <option value="HOLD" selected>HOLD</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">PIC CE</label>
                                <input type="text" name="pic_ce" class="form-control rounded-3">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Link Google Drive (File PM)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="file_pm" class="form-control border-start-0"
                                        placeholder="https://drive.google.com/...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4 rounded-3 border"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3"
                            style="background-color: #071152; border: none;">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Card Element -->
    <div id="drivePreview" class="drive-preview-card">
        <div class="preview-header">
            <i class="bi bi-file-pdf-fill bi-file-pdf"></i>
            <span id="previewTitle" class="preview-title">Loading...</span>
            <div class="preview-actions">
                <i class="bi bi-copy" id="previewActionCopy" title="Copy Link" style="cursor: pointer;"></i>
                <i class="bi bi-eye-slash" id="previewActionHide" title="Sembunyikan" style="cursor: pointer;"></i>
            </div>
        </div>
        <div class="preview-body">
            <div class="preview-thumbnail">
                <img id="previewImg" src="" alt="Thumbnail">
            </div>
        </div>
        <div class="preview-footer">
            <div class="preview-info-row">
                <i class="bi bi-person-circle"></i>
                <span>NUSTECH adalah pemilik</span>
            </div>
            <div class="preview-info-row">
                <i class="bi bi-clock-history"></i>
                <span id="previewHistory">Anda belum pernah melihat file ini</span>
            </div>
            <div class="preview-cta">
                <button class="btn-ringkas" id="previewActionSummary"><i class="bi bi-stars"></i> Ringkas file
                    ini</button>
                <div class="btn-circle-action" id="previewActionOpen" style="cursor: pointer;"><i
                        class="bi bi-arrow-right-short" style="font-size: 24px;"></i></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let hideTimeout;
        let currentUrl = '';
        let currentElement = null;

        function getDriveId(url) {
            if (!url) return null;
            let match = url.match(/\/d\/([a-zA-Z0-9_-]+)/);
            if (match) return match[1];
            try {
                let params = new URLSearchParams(new URL(url).search);
                return params.get('id');
            } catch (e) { return null; }
        }

        async function fetchDriveFileName(fileId, chipElement) {
            if (!fileId) return;

            try {
                // Gunakan route internal Laravel agar terhindar dari pemblokiran Cloudflare
                const url = `https://drive.google.com/file/d/${fileId}/view`;
                const response = await fetch(`/get-drive-title?url=${encodeURIComponent(url)}`);
                const data = await response.json();

                if (data && data.title) {
                    let driveTitle = data.title;

                    if (driveTitle && driveTitle !== 'Google Drive: Terjadi Masalah' && driveTitle !== 'Google Drive') {
                        // Update Judul di Card
                        const previewTitle = document.getElementById('previewTitle');
                        if (previewTitle) previewTitle.innerText = driveTitle;

                        // Update teks di Chip Asal
                        if (chipElement) {
                            const span = chipElement.querySelector('span');
                            if (span) span.innerText = driveTitle;
                            // Tandai chip ini sudah berhasil mengambil nama asli
                            chipElement.setAttribute('data-fetched', 'true');
                        }
                    }
                }
            } catch (e) {
                console.error("Gagal mengambil nama file drive via server:", e);
            }
        }

        function showDrivePreview(element, url, currentTitle) {
            clearTimeout(hideTimeout);
            const preview = document.getElementById('drivePreview');
            const fileId = getDriveId(url);

            if (fileId) {
                currentUrl = url;
                currentElement = element;

                // Gunakan teks yang sudah ada di chip sebagai judul awal
                const chipText = element.querySelector('span').innerText;
                document.getElementById('previewTitle').innerText = chipText;
                document.getElementById('previewImg').src = `https://drive.google.com/thumbnail?id=${fileId}&sz=w400`;

                // Hanya fetch jika belum pernah berhasil di-fetch sebelumnya
                if (element.getAttribute('data-fetched') !== 'true') {
                    fetchDriveFileName(fileId, element);
                }

                // Handle image error
                const previewImg = document.getElementById('previewImg');
                previewImg.onerror = function() {
                    this.parentElement.innerHTML = '<i class="bi bi-file-earmark-pdf" style="font-size: 60px; color: #dee2e6;"></i>';
                };

                // Reset display dan class first to get accurate measurements
                preview.style.display = 'block';
                const rect = element.getBoundingClientRect();
                const cardWidth = preview.offsetWidth || 360;
                const cardHeight = preview.offsetHeight || 420;

                let left = rect.left;
                let top = rect.top + 30;

                // Boundary checking - Right edge
                if (left + cardWidth > window.innerWidth) {
                    left = window.innerWidth - cardWidth - 20;
                }
                // Boundary checking - Left edge
                if (left < 10) left = 10;

                // Boundary checking - Bottom edge
                if (top + cardHeight > window.innerHeight) {
                    top = rect.top - cardHeight - 10;
                }

                preview.style.left = left + 'px';
                preview.style.top = top + 'px';

                setTimeout(() => preview.classList.add('show'), 10);
            }
        }
        function hideDrivePreview() {
            hideTimeout = setTimeout(() => {
                const preview = document.getElementById('drivePreview');
                preview.classList.remove('show');
                setTimeout(() => {
                    if (!preview.classList.contains('show')) {
                        preview.style.display = 'none';
                    }
                }, 200);
            }, 300); // 300ms buffer to allow moving mouse to the card
        }

        // Event listeners for the preview card itself
        document.getElementById('drivePreview').addEventListener('mouseenter', () => clearTimeout(hideTimeout));
        document.getElementById('drivePreview').addEventListener('mouseleave', hideDrivePreview);

        // Action: Copy Link
        document.getElementById('previewActionCopy').addEventListener('click', function (e) {
            e.stopPropagation();
            if (currentUrl) {
                navigator.clipboard.writeText(currentUrl).then(() => {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Link berhasil disalin!',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            }
        });



        // Action: Hide Preview
        document.getElementById('previewActionHide').addEventListener('click', function (e) {
            e.stopPropagation();
            const preview = document.getElementById('drivePreview');
            preview.classList.remove('show');
            setTimeout(() => preview.style.display = 'none', 200);
        });

        // Action: Open in New Tab
        document.getElementById('previewActionOpen').addEventListener('click', function (e) {
            e.stopPropagation();
            if (currentUrl) window.open(currentUrl, '_blank');
        });

        // Action: Summary (Ringkas)
        document.getElementById('previewActionSummary').addEventListener('click', function (e) {
            e.stopPropagation();
            Swal.fire({
                title: 'Summarizing...',
                text: 'Fitur AI sedang memproses dokumen PM ini.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        });

        $(document).ready(function () {
            // Inisialisasi Select2 untuk Tambah Data
            $('#siteSelectAdd').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#modalTambah'),
                placeholder: '-- Cari Site ID --',
                allowClear: true
            });
            // Auto-fill saat Site dipilih di modal Tambah
            $('#siteSelectAdd').on('select2:select', function (e) {
                var data = e.params.data;
                var element = $(data.element);
                $('#add_site_id').val(data.id);
                $('#add_nama_lokasi').val(element.data('name'));
                $('#add_provinsi').val(element.data('provinsi'));
                $('#add_kabupaten').val(element.data('kabupaten'));
            });
            // Auto-fill Bulan saat Tanggal dipilih di modal Tambah
            $('#add_date').on('change', function () {
                const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                const d = new Date($(this).val());
                if (!isNaN(d.getTime())) {
                    $('#add_month').val(months[d.getMonth()]);
                }
            });
            // Gunakan delegasi event agar tombol tetap berfungsi jika tabel di-refresh/filter
            $(document).on('click', '.btn-edit', function () {
                // 1. Ambil data dari atribut data-* tombol yang diklik
                let id = $(this).data('id');
                let site_id = $(this).data('site_id');
                let nama_lokasi = $(this).data('nama_lokasi');
                let provinsi = $(this).data('provinsi');
                let kabupaten = $(this).data('kabupaten');
                let status = $(this).data('status');
                let week = $(this).data('week');
                let kategori = $(this).data('kategori');
                let file_pm = $(this).data('file_pm');
                // 2. Penanganan khusus untuk Tanggal
                // Input type="date" HANYA menerima format YYYY-MM-DD
                let rawDate = $(this).data('date');
                let formattedDate = '';
                if (rawDate) {
                    // Memastikan jika ada jamnya (timestamp), kita ambil tanggalnya saja
                    formattedDate = rawDate.split(' ')[0];
                }
                // 3. Masukkan nilai ke dalam input modal berdasarkan ID
                $('#edit_site_id').val(site_id);
                $('#edit_nama_lokasi').val(nama_lokasi);
                $('#edit_provinsi').val(provinsi);
                $('#edit_kabupaten').val(kabupaten);
                $('#edit_date').val(formattedDate); // Set tanggal hasil format
                $('#edit_status').val(status);
                $('#edit_week').val(week);
                $('#edit_kategori').val(kategori);
                $('#edit_file_pm').val(file_pm);
                // 4. Set action URL form secara dinamis ke route update
                // Pastikan route di web.php adalah /PMLiberta/{id}
                $('#formEdit').attr('action', '/PMLiberta/' + id);
                // 5. Tampilkan modal
                // Menggunakan cara Bootstrap 5 yang lebih stabil
                var editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
                editModal.show();
            });

            // Handler INFO (read-only) untuk role user
            $(document).on('click', '.btn-info-pm', function () {
                let site_id     = $(this).data('site_id');
                let nama_lokasi = $(this).data('nama_lokasi');
                let provinsi    = $(this).data('provinsi');
                let kabupaten   = $(this).data('kabupaten');
                let tanggal     = $(this).data('date') || '-';
                let month       = $(this).data('month') || '-';
                let week        = $(this).data('week') || '-';
                let status      = $(this).data('status') || 'PENDING';
                let kategori    = $(this).data('kategori') || '-';
                let file_pm     = $(this).data('file_pm') || '';

                let statusColor = { DONE:'#198754', PENDING:'#ffc107', 'ON PROGRESS':'#0dcaf0', HOLD:'#dc3545' };
                let badgeColor  = statusColor[status.toUpperCase()] || '#6c757d';

                let fileHtml = file_pm
                    ? `<a href="${file_pm}" target="_blank" style="color:#0d6efd;"><i class="bi bi-file-earmark-pdf-fill me-1"></i>Lihat File PM</a>`
                    : '<span style="color:#aaa;">Tidak ada file</span>';

                Swal.fire({
                    title: '<i class="bi bi-info-circle-fill" style="color:#0d6efd;"></i> Detail PM',
                    html: `
                        <div style="text-align:left; font-size:14px; line-height:2;">
                            <table style="width:100%; border-collapse:collapse;">
                                <tr><td style="color:#888; width:120px;">Site ID</td><td><b>${site_id}</b></td></tr>
                                <tr><td style="color:#888;">Nama Lokasi</td><td>${nama_lokasi}</td></tr>
                                <tr><td style="color:#888;">Provinsi</td><td>${provinsi}</td></tr>
                                <tr><td style="color:#888;">Kabupaten</td><td>${kabupaten}</td></tr>
                                <tr><td style="color:#888;">Tanggal</td><td>${tanggal}</td></tr>
                                <tr><td style="color:#888;">Month</td><td>${month}</td></tr>
                                <tr><td style="color:#888;">Week</td><td>${week}</td></tr>
                                <tr><td style="color:#888;">Kategori</td><td>${kategori}</td></tr>
                                <tr><td style="color:#888;">Status</td><td><span style="background:${badgeColor}; color:white; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:700;">${status || 'PENDING'}</span></td></tr>
                                <tr><td style="color:#888;">File PM</td><td>${fileHtml}</td></tr>
                            </table>
                        </div>`,
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#0d6efd',
                    customClass: { popup: 'rounded-4' },
                    width: 500
                });
            });
        });
    </script>
    <!-- SCRIPT UNTUK KONFIRMASI DELETE DENGAN SWEETALERT -->
    <script>
        // Otomatis Submit saat file Excel dipilih
        function handleFileUpload() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                Swal.fire({
                    title: 'Memproses Excel...',
                    text: 'Harap tunggu, data sedang diunggah.',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById('importForm').submit();
            }
        }
        // SweetAlert Notifikasi Flash Message
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}" });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
        @endif
    </script>
    <!-- SCRIPT UNTUK KONFIRMASI DELETE DENGAN SWEETALERT -->
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn-delete-trigger', function (e) {
                e.preventDefault();
                let form = $(this).closest('.form-delete');
                let namaSite = $(this).data('nama'); // Ambil nama site dari data-nama
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    // Gunakan backtick ( ` ) agar bisa memasukkan variabel ke dalam string
                    html: "Data site <b>" + namaSite + "</b> akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        form.submit();
                    }
                });
            });
        });
    </script>
    {{-- SCRIPT UNTUK BULAN TERISI OTOMATIS SAAT UPDATE --}}
    <script>
        document.getElementById('edit_date').addEventListener('change', function () {
            const dateValue = this.value; // Format: YYYY-MM-DD
            if (dateValue) {
                const dateObj = new Date(dateValue);
                // Daftar nama bulan dalam Bahasa Indonesia
                const months = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                // Ambil nama bulan berdasarkan index (0-11)
                const monthName = months[dateObj.getMonth()];
                // Masukkan ke input month
                document.getElementById('edit_month').value = monthName;
            } else {
                document.getElementById('edit_month').value = '';
            }
        });
    </script>
    <script>
        // Mapping data dari controller untuk cascading filter
        const provinsiKabMap = @json($provinsiKabMap);

        function updateKabupatenDropdown(provinsi, targetId, selectedKab = '') {
            const kabDropdown = $(`#${targetId}`);
            kabDropdown.empty();
            kabDropdown.append('<option value="">Kabupaten...</option>');

            if (provinsi && provinsiKabMap[provinsi]) {
                provinsiKabMap[provinsi].forEach(kab => {
                    const isSelected = kab === selectedKab ? 'selected' : '';
                    kabDropdown.append(`<option value="${kab}" ${isSelected}>${kab}</option>`);
                });
            }
        }

        // Event listener untuk filter bar
        $('#filter-provinsi').on('change', function () {
            updateKabupatenDropdown($(this).val(), 'filter-kab');
        });

        // Agar Provinsi ter-update jika kategori berubah, form akan submit otomatis
        $('select[name="kategori"]').on('change', function () {
            $('#searchForm').submit();
        });
    </script>
</body>

</html>