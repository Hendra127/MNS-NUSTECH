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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open Ticket | Project Operational</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
        }

        .summary-badge {
            font-size: 12px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
        }

        .search-box {
            display: flex;
            align-items: center;
        }

        .tabs-section {
            flex-wrap: wrap;
            gap: 10px;
        }

        .tabs-section .ms-auto {
            flex-wrap: wrap;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .tabs-section .ms-auto {
                width: 100%;
                margin-left: 0 !important;
                justify-content: flex-start;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-form,
            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
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

        /* Remote icon dark mode — sama dengan edit & hapus */
        .btn-remote-action {
            color: #000;
        }

        [data-bs-theme="dark"] .btn-remote-action {
            color: #7ec8e3 !important;
            /* cyan-teal sesuai ikon edit di dark mode */
        }

        /* Sorting Styles */
        thead th a {
            color: #555 !important;
            font-size: 11px;
            font-weight: 700;
            transition: all 0.2s;
        }

        thead th a:hover {
            color: #0b5ed7 !important;
        }

        thead th:has(a):hover {
            background-color: #f1f3f7 !important;
        }

        /* Active Sorting Style — Jauh lebih jelas */
        thead th.sorting-active {
            background-color: #e8f4ff !important;
            /* Biru muda sangat halus */
            border-bottom: 2px solid #007bff !important;
        }

        thead th.sorting-active a {
            color: #007bff !important;
        }

        thead th.sorting-active i {
            font-size: 1rem !important;
            font-weight: 800 !important;
            opacity: 1 !important;
        }

        .bi-chevron-expand {
            font-size: 0.75rem;
            opacity: 0.4;
        }

        /* Sorting Caret Stack — Sesuai permintaan gambar */
        .sort-icon-stack {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            vertical-align: middle;
            line-height: 1;
            margin-left: 4px;
        }

        .sort-icon-stack i {
            font-size: 0.65rem !important;
            margin: -2px 0;
            transition: color 0.2s;
        }

        .sort-icon-stack i.active {
            color: #007bff !important;
            opacity: 1 !important;
        }

        .sort-icon-stack i.inactive {
            color: #ccc !important;
            opacity: 0.5;
        }

        /* --- Hardware Chip & Unified Textarea --- */
        .hw-chip-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            padding: 12px;
            border: 1px solid #dee2e6;
            border-bottom: none;
            background: #fdfdfd;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            min-height: 50px;
            align-items: center;
        }

        .hw-chip {
            display: inline-flex;
            align-items: center;
            background-color: #0d6efd;
            color: white;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
            text-transform: uppercase;
        }

        .hw-chip i.bi-cpu {
            font-size: 14px;
            opacity: 0.9;
        }

        .hw-chip .btn-close-chip {
            cursor: pointer;
            font-size: 16px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .hw-chip .btn-close-chip:hover {
            opacity: 1;
        }

        .textarea-unified {
            border-top-left-radius: 0 !important;
            border-top-right-radius: 0 !important;
            border-color: #dee2e6 !important;
            box-shadow: none !important;
            resize: none;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Modal Uniform Styling */
        .modal-content {
            color: #000 !important;
        }
        .modal-content label {
            color: #000 !important;
            font-weight: 700 !important; /* Bold */
        }
        .modal-content .form-control, 
        .modal-content .form-select,
        .modal-content .text-muted,
        .modal-content .empty-chips-msg {
            color: #000 !important;
        }
        .modal-header .modal-title {
            font-weight: 800 !important;
        }
    </style>
</head>

<body>
    @include('components.nav-modal-structure')
    <header class="main-header">
        <div class="header-logo-container">
            <a href="javascript:void(0)" onclick="openNavModal()" class="header-brand-link"
                style="text-decoration: none !important; color: white !important;">
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
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <a href="{{ route('setting.index') }}" class="user-profile-icon" title="Setting User"
                        style="cursor: pointer; text-decoration: none; color: inherit;">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                @endif
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
                            style="width: 100%; text-align: left; padding: 10px 15px; border: none; background: transparent; color: red; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;"
                            onmouseover="this.style.backgroundColor='#fff0f0'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                style="margin-right: 8px;">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: White;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Summary Tiket</a>
        <div id="summary-badges" class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Open: <b>{{ $openAllCount }}</b></span>
            <span class="summary-badge text-black">Open Hari Ini: <b>{{ $openTodayCount }}</b></span>
            <span class="summary-badge text-dark">BMN: <b>{{ $countBMN }}</b></span>
            <span class="summary-badge text-dark">SL: <b>{{ $countSL }}</b></span>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button class="btn-action bi bi-plus" title="Add" data-bs-toggle="modal"
                        data-bs-target="#modalTambahTicket">
                    </button>
                    <form action="{{ route('open.ticket.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm" class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;"
                            onchange="document.getElementById('importForm').submit();">
                        <button type="button" class="btn-action bi bi-upload" title="Upload"
                            onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form id="filterForm" method="GET" action="{{ route('open.ticket') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end">
                    {{-- Hidden inputs to preserve sorting when filtering/searching --}}
                    <input type="hidden" name="sort" value="{{ request('sort', 'tanggal_rekap') }}">
                    <input type="hidden" name="order" value="{{ request('order', 'desc') }}">

                    <div class="col-auto">
                        <input type="number" name="per_page" class="form-control form-control-sm text-center" min="1"
                            placeholder="Data" value="{{ request('per_page', 50) }}" title="Jumlah data"
                            style="width: 70px;">
                    </div>

                    <div class="col-12 col-md-auto">
                        <select name="kategori" class="form-select form-select-sm w-100">
                            <option value="">Semua Kategori</option>
                            <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-auto">
                        <input type="date" name="tgl_mulai" class="form-control form-control-sm w-100"
                            value="{{ request('tgl_mulai') }}" title="Dari Tanggal">
                    </div>

                    <div class="col-12 col-md-auto">
                        <input type="date" name="tgl_selesai" class="form-control form-control-sm w-100"
                            value="{{ request('tgl_selesai') }}" title="Sampai Tanggal">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('open.ticket') }}"
                            class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                            title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" id="searchInput" name="q" placeholder="Search..."
                                value="{{ request('q') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        {{-- TABLE --}}
        {{-- TABLE CONTAINER UNTUK AJAX RELOAD --}}
        <div id="table-container">
            <div class="table-responsive-custom">
                <table>
                    <thead>
                        <tr>
                            <th class="sticky-col col-no">NO</th>
                            <th class="sticky-col col-site-id">SITE ID</th>
                            <th class="sticky-col col-nama_site">NAMA SITE</th>
                            <th class="text-center {{ request('sort') == 'durasi' ? 'sorting-active' : '' }}"
                                style="min-width: 120px; cursor: pointer;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'durasi', 'order' => (request('sort') == 'durasi' && request('order') == 'asc') ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none d-flex align-items-center justify-content-center gap-1">
                                    DURASI
                                    <div class="sort-icon-stack">
                                        <i
                                            class="bi bi-caret-up-fill {{ request('sort') == 'durasi' && request('order') == 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i
                                            class="bi bi-caret-down-fill {{ request('sort') == 'durasi' && request('order') == 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-center {{ request('sort') == 'tanggal_rekap' || !request('sort') ? 'sorting-active' : '' }}"
                                style="min-width: 150px; cursor: pointer;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_rekap', 'order' => (request('sort') == 'tanggal_rekap' && request('order') == 'asc') ? 'desc' : 'asc']) }}"
                                    class="text-decoration-none d-flex align-items-center justify-content-center gap-1">
                                    TANGGAL OPEN
                                    <div class="sort-icon-stack">
                                        <i
                                            class="bi bi-caret-up-fill {{ (request('sort') == 'tanggal_rekap' || !request('sort')) && request('order') == 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i
                                            class="bi bi-caret-down-fill {{ (request('sort') == 'tanggal_rekap' || !request('sort')) && request('order', 'desc') == 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th>PROVINSI</th>
                            <th>KABUPATEN</th>
                            <th>KATEGORI</th>
                            <th>STATUS</th>
                            <th>KENDALA</th>
                            <th>DETAIL PROBLEM</th>
                            <th>ACTION PLAN</th>
                            <th>CE</th>
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <th class="sticky-col-right">AKSI</th>
                            @elseif(auth()->check() && auth()->user()->role === 'user')
                                <th class="sticky-col-right">INFO</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $i => $t)
                            <tr>
                                <td class="text-center sticky-col col-no">{{ $tickets->firstItem() + $i }}</td>
                                <td class="text-center sticky-col col-site-id">{{ $t->site_code }}</td>
                                <td class="sticky-col col-nama_site">{{ $t->nama_site }}</td>
                                <td class="text-center">
                                    @php
                                        $tanggalRekap = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay();
                                        if (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close) {
                                            $hariAkhir = \Carbon\Carbon::parse($t->tanggal_close)->startOfDay();
                                        } else {
                                            $hariAkhir = now()->startOfDay();
                                        }
                                        $durasi = $tanggalRekap->diffInDays($hariAkhir);
                                    @endphp
                                    {{ floor($durasi) }} Hari
                                </td>
                                <td>{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                                <td>{{ $t->provinsi }}</td>
                                <td>{{ $t->kabupaten }}</td>
                                <td class="text-center">
                                    @if(in_array($t->kategori, ['BMN', 'BARANG MILIK NEGARA (BMN)']))
                                        BMN
                                    @elseif(in_array($t->kategori, ['SL', 'SEWA LAYANAN']))
                                        SL
                                    @else
                                        {{ $t->kategori }}
                                    @endif
                                </td>
                                <td class="text-center"><span>OPEN</span></td>
                                <td>{{ $t->kendala }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $t->detail_problem }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $t->plan_actions }}</td>
                                <td>{{ $t->ce }}</td>
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <td class="text-center sticky-col-right">
                                        <button type="button" class="btn btn-sm bi bi-x-lg" data-bs-toggle="modal"
                                            data-bs-target="#modalCloseTicket{{ $t->id }}" data-id="{{ $t->id }}"
                                            data-name="{{ $t->nama_site }}" title="Close Ticket" style="color: #198754;">
                                        </button>
                                        <button class="btn btn-sm bi bi-pencil" data-bs-toggle="modal"
                                            data-bs-target="#modalEditTicket{{ $t->id }}">
                                        </button>
                                        <form action="{{ route('open.ticket.destroy', $t->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm bi bi-trash btn-delete"
                                                data-name="{{ $t->nama_site }}">
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm bi bi-info-circle" data-bs-toggle="modal"
                                            data-bs-target="#modalInfo{{ $t->id }}">
                                        </button>
                                        @if($t->site && $t->site->ip_router && in_array(auth()->user()->role ?? '', ['admin', 'superadmin']))
                                            <button type="button" class="btn btn-sm btn-remote-action" title="Remote Mikrotik"
                                                onclick="remoteMikrotik('{{ $t->site->ip_router }}', '{{ $t->kategori }}', '{{ $t->nama_site }}', '{{ $t->site_code }}', '{{ $t->site->gateway_area }}', '{{ $t->site->hub }}')">
                                                <i class="bi bi-broadcast"></i>
                                            </button>
                                        @endif
                                    </td>
                                @elseif(auth()->check() && auth()->user()->role === 'user')
                                    <td class="text-center sticky-col-right">
                                        <button type="button" class="btn btn-sm bi bi-info-circle" data-bs-toggle="modal"
                                            data-bs-target="#modalInfo{{ $t->id }}">
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center py-4 text-muted">Belum ada tiket yang dibuka.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- ============================================================
                SEMUA MODAL DI LUAR TABLE - Mencegah stacking context rusak
                ============================================================ --}}
                @foreach($tickets as $t)

                    {{-- MODAL EDIT TICKET --}}
                    <div class="modal fade" id="modalEditTicket{{ $t->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <form method="POST" action="{{ route('open.ticket.update', $t->id) }}" class="modal-content"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header text-white d-flex justify-content-center position-relative"
                                    style="background-color: #071152;">
                                    <h5 class="modal-title w-100 text-center fw-bold"><i class="bi bi-pencil-square"></i>
                                        Edit Tiket - {{ $t->nama_site }}</h5>
                                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Site ID / Code</label>
                                            <input type="text" class="form-control bg-light" value="{{ $t->site_code }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Nama Site</label>
                                            <input type="text" class="form-control bg-light" value="{{ $t->nama_site }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Durasi Berjalan (Hari)</label>
                                            @php
                                                $dE = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay()->diffInDays(
                                                    (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close)
                                                    ? \Carbon\Carbon::parse($t->tanggal_close)->startOfDay() : now()->startOfDay()
                                                );
                                            @endphp
                                            <input type="text" class="form-control bg-light" value="{{ floor($dE) }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Provinsi</label>
                                            <input type="text" class="form-control bg-light" value="{{ $t->provinsi }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Kabupaten</label>
                                            <input type="text" class="form-control bg-light" value="{{ $t->kabupaten }}"
                                                readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-primary">Kategori</label>
                                            <select name="kategori" class="form-select" required>
                                                <option value="BMN" {{ in_array($t->kategori, ['BMN', 'BARANG MILIK NEGARA (BMN)']) ? 'selected' : '' }}>BMN</option>
                                                <option value="SL" {{ in_array($t->kategori, ['SL', 'SEWA LAYANAN']) ? 'selected' : '' }}>SL</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-primary">Tanggal Open/Rekap</label>
                                            <input type="date" name="tanggal_rekap" class="form-control"
                                                value="{{ $t->tanggal_rekap }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Problem</label>
                                            @php $kendalaOpts = ['PERANGKAT TIDAK ADA INTERNET', 'INTERNET TIDAK BISA DIGUNAKAN', 'PASSWORD SALAH', 'PERANGKAT INTERNET RUSAK']; @endphp
                                            <select name="kendala" class="form-select" required>
                                                <option value="">-- Pilih Kendala --</option>
                                                @foreach($kendalaOpts as $opt)
                                                    <option value="{{ $opt }}" {{ $t->kendala == $opt ? 'selected' : '' }}>
                                                        {{ $opt }}</option>
                                                @endforeach
                                                @if($t->kendala && !in_array($t->kendala, $kendalaOpts))
                                                    <option value="{{ $t->kendala }}" selected>{{ $t->kendala }} (Lainnya)
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark mb-2">Detail Problem</label>
                                                
                                                {{-- Selector Perangkat --}}
                                                <div class="mb-0">
                                                    <select class="form-select form-select-sm" onchange="addHardwareChip('{{ $t->id }}', this.value); this.value='';"
                                                        style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-color: #dee2e6 !important; background-color: #fff;">
                                                        <option value="">-- Pilih Perangkat Yang Bermasalah --</option>
                                                        @foreach(['MODEM', 'ROUTER', 'AP1', 'AP2', 'TRANSCEIVER', 'STAVOLT', 'RAK', 'ANTENA', 'LAIN LAIN'] as $opt)
                                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Container Chips --}}
                                                <div id="hw-chips-{{ $t->id }}" class="hw-chip-container">
                                                    @php 
                                                        $hwArr = array_filter(explode(',', $t->hardware_problem ?? ''));
                                                    @endphp
                                                    @foreach($hwArr as $item)
                                                        <div class="hw-chip" data-value="{{ $item }}">
                                                            <i class="bi bi-cpu"></i> {{ $item }}
                                                            <span class="btn-close-chip" onclick="removeHardwareChip('{{ $t->id }}', '{{ $item }}')">×</span>
                                                            <input type="hidden" name="hardware_problem[]" value="{{ $item }}">
                                                        </div>
                                                    @endforeach
                                                    <div class="empty-chips-msg text-muted small {{ count($hwArr) > 0 ? 'd-none' : '' }}">Belum ada perangkat terpilih</div>
                                                </div>

                                                {{-- Unified Textarea --}}
                                                <textarea name="detail_problem" class="form-control textarea-unified" rows="5" required 
                                                    placeholder="Tulis detail deskripsi masalah di sini...">{{ $t->detail_problem }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-bold text-dark mb-2">Action Plan</label>
                                                <textarea name="plan_actions" class="form-control" rows="8" required 
                                                    placeholder="Jelaskan detail action plan..."
                                                    style="border-color: #dee2e6 !important; box-shadow: none; border-radius: 8px;">{{ $t->plan_actions }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold text-primary">CE (Customer Engineer)</label>
                                            <select name="ce" class="form-select" required>
                                                <option value="">-- Pilih CE --</option>
                                                <option value="Eka Mahatva Yudha" {{ $t->ce == 'Eka Mahatva Yudha' ? 'selected' : '' }}>Eka Mahatva Yudha</option>
                                                <option value="Herman Seprianto" {{ $t->ce == 'Herman Seprianto' ? 'selected' : '' }}>Herman Seprianto</option>
                                                <option value="Moh. Walangadi" {{ $t->ce == 'Moh. Walangadi' ? 'selected' : '' }}>Moh. Walangadi</option>
                                                <option value="Ahmad Suhaini" {{ $t->ce == 'Ahmad Suhaini' ? 'selected' : '' }}>Ahmad Suhaini</option>
                                                <option value="Hasrul Fandi Serang" {{ $t->ce == 'Hasrul Fandi Serang' ? 'selected' : '' }}>Hasrul Fandi Serang</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label fw-bold text-primary">Evidence (Foto/Video)</label>
                                            <input type="file" name="evidence[]" class="form-control"
                                                accept="image/*,video/*" multiple>
                                            
                                            <div class="mt-2 d-flex flex-wrap gap-2">
                                                @if($t->evidences->count() > 0)
                                                    @foreach($t->evidences as $ev)
                                                        <div class="position-relative">
                                                            <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage_public/' . $ev->path) }}')" class="badge bg-info text-white text-decoration-none">
                                                                <i class="bi bi-paperclip"></i> Bukti #{{ $loop->iteration }}
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @elseif($t->evidence && str_contains($t->evidence, '.'))
                                                    <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage_public/' . $t->evidence) }}')" class="badge bg-secondary text-white text-decoration-none">
                                                        <i class="bi bi-paperclip"></i> Bukti Lama
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Belum ada bukti.</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary px-4">Update Data Tiket</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL CLOSE TICKET --}}
                    <div class="modal fade" id="modalCloseTicket{{ $t->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <form method="POST" action="{{ route('open.ticket.close', $t->id) }}" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header text-white position-relative"
                                    style="background-color: #198754; padding: 1rem 3rem;">
                                    <div class="w-100 text-center">
                                        <div class="fw-bold" style="font-size: 1.05rem;"><i class="bi bi-x-circle me-1"></i>
                                            Close Tiket</div>
                                        <div class="mt-1 text-white text-opacity-90"
                                            style="font-size: 0.8rem; word-break: break-word;">{{ $t->nama_site }}</div>
                                    </div>
                                    <button type="button"
                                        class="btn-close btn-close-white position-absolute top-50 end-0 translate-middle-y me-3"
                                        data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tanggal Close</label>
                                        <input type="date" name="tanggal_close" class="form-control"
                                            value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Detil Problem</label>
                                        <textarea name="detail_problem" class="form-control" rows="3"
                                            required>{{ $t->detail_problem }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Action</label>
                                        <textarea name="plan_actions" class="form-control" rows="3"
                                            required>{{ $t->plan_actions }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success px-4">Simpan &amp; Close Tiket</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL DETAIL / INFO --}}
                    <div class="modal fade" id="modalInfo{{ $t->id }}" tabindex="-1" aria-labelledby="label{{ $t->id }}"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header border-0 p-3 d-flex align-items-center justify-content-between"
                                    style="background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-white bg-opacity-25 p-2 rounded-circle">
                                            <i class="bi bi-info-circle-fill text-white fs-4"></i>
                                        </div>
                                        <div>
                                            <h5 class="modal-title text-white fw-bold mb-0" id="label{{ $t->id }}">Detail
                                                Tiket Site</h5>
                                            <small class="text-white text-opacity-75">Informasi lengkap perbaikan
                                                perangkat</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-3 bg-white">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="bg-light p-2 rounded-3 shadow-sm h-100">
                                                <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2"><i
                                                        class="bi bi-geo-alt-fill"></i> Lokasi &amp; Identitas</h6>
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Site ID</span><span
                                                            class="fw-bold">{{ $t->site_code }}</span></div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2 gap-2">
                                                        <span class="text-muted small flex-shrink-0">Nama Site</span><span
                                                            class="fw-bold text-end">{{ $t->nama_site }}</span></div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Provinsi</span><span
                                                            class="fw-semibold">{{ $t->provinsi }}</span></div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Kabupaten</span><span
                                                            class="fw-semibold">{{ $t->kabupaten }}</span></div>
                                                    <div class="d-flex justify-content-between pb-2"><span
                                                            class="text-muted small">Kategori</span><span
                                                            class="badge bg-info text-white fw-bold">{{ $t->kategori }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bg-light p-2 rounded-3 shadow-sm h-100">
                                                <h6 class="fw-bold text-success mb-3 d-flex align-items-center gap-2"><i
                                                        class="bi bi-clock-history"></i> Progres &amp; Waktu</h6>
                                                <div class="d-flex flex-column gap-2">
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Tgl Open</span><span
                                                            class="fw-bold">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Bulan</span><span
                                                            class="fw-semibold">{{ $t->bulan_open }}</span></div>
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Status</span><span
                                                            class="badge bg-warning text-dark fw-bold px-3 rounded-pill">{{ strtoupper($t->status) }}</span>
                                                    </div>
                                                    @php
                                                        $dI = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay()->diffInDays(
                                                            (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close)
                                                            ? \Carbon\Carbon::parse($t->tanggal_close)->startOfDay() : now()->startOfDay()
                                                        );
                                                    @endphp
                                                    <div class="d-flex justify-content-between border-bottom pb-2"><span
                                                            class="text-muted small">Durasi</span><span
                                                            class="text-danger fw-bold fs-5">{{ floor($dI) }} Hari</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between pb-2"><span
                                                            class="text-muted small">CE</span><span
                                                            class="fw-semibold">{{ $t->ce ?? '-' }}</span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="bg-light p-2 rounded-3 shadow-sm">
                                                <h6 class="fw-bold text-danger mb-3 d-flex align-items-center gap-2"><i
                                                        class="bi bi-exclamation-triangle-fill"></i> Detail Teknis</h6>
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-2 bg-white rounded-3 h-100 border text-center">
                                                            <div class="text-muted small fw-bold mb-1">KENDALA UTAMA</div>
                                                            <p class="mb-0 fw-semibold text-dark">{{ $t->kendala }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-2 bg-white rounded-3 h-100 border text-center">
                                                            <div class="text-muted small fw-bold mb-1">PERANGKAT BERMASALAH</div>
                                                            <div class="d-flex flex-wrap justify-content-center gap-1 mt-1">
                                                                @foreach(explode(',', $t->hardware_problem ?? '') as $hw)
                                                                    <span class="badge bg-primary">{{ strtoupper($hw) }}</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-2 bg-white rounded-3 h-100 border">
                                                            <div class="text-muted small fw-bold mb-1">EVIDENCE (BUKTI)</div>
                                                            <div class="d-flex flex-column gap-1">
                                                                @if($t->evidences->count() > 0)
                                                                    @foreach($t->evidences as $ev)
                                                                        <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage_public/' . $ev->path) }}')" class="text-primary text-decoration-none small">
                                                                            <i class="bi bi-eye"></i> Lihat Bukti #{{ $loop->iteration }}
                                                                        </a>
                                                                    @endforeach
                                                                @elseif($t->evidence && str_contains($t->evidence, '.'))
                                                                     <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage_public/' . $t->evidence) }}')" class="text-primary text-decoration-none small">
                                                                        <i class="bi bi-eye"></i> Lihat Bukti Utama
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted small">TIDAK ADA</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-2 bg-light rounded-3 mb-3 border-start border-4 border-primary">
                                                            <div class="text-muted small fw-bold px-2 mb-2">DETAIL PER PERANGKAT</div>
                                                            <div class="px-2">
                                                                @php 
                                                                    $details = json_decode($t->detail_problem ?? '{}', true);
                                                                    if (json_last_error() !== JSON_ERROR_NONE || !is_array($details)) {
                                                                        $details = ['MASALAH' => $t->detail_problem];
                                                                    }
                                                                @endphp
                                                                @foreach($details as $hw => $desc)
                                                                    <div class="d-flex gap-2 mb-1 border-bottom pb-1 border-light">
                                                                        <span class="fw-bold text-dark small" style="min-width: 100px;">{{ strtoupper($hw) }}:</span>
                                                                        <span class="text-muted small">{{ $desc }}</span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                        <div class="p-2 rounded-3"
                                                            style="background-color: #f0f7ff; border-left: 4px solid #3a7bd5;">
                                                            <div class="text-primary small fw-bold mb-1">PLAN ACTION /
                                                                TINDAKAN</div>
                                                            <p class="mb-0 text-dark small" style="line-height: 1.6;">
                                                                {{ $t->plan_actions }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 p-3 bg-white d-flex justify-content-between">
                                    @if($t->site && $t->site->ip_router && in_array(auth()->user()->role ?? '', ['admin', 'superadmin']))
                                        <button type="button" class="btn btn-outline-primary px-4 rounded-pill shadow-sm"
                                            onclick="remoteMikrotik('{{ $t->site->ip_router }}', '{{ $t->kategori }}', '{{ $t->nama_site }}', '{{ $t->site_code }}', '{{ $t->site->gateway_area }}', '{{ $t->site->hub }}')">
                                            <i class="bi bi-broadcast me-2"></i>Remote Mikrotik
                                        </button>
                                    @else
                                        <span></span>
                                    @endif
                                    <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm"
                                        data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
            <div class="pagination-wrapper">
                <span class="pagination-info">
                    Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }}
                    of&nbsp;<strong>{{ $tickets->total() }}</strong>&nbsp;results
                </span>
                <nav>
                    {{ $tickets->links() }}
                </nav>
            </div> {{-- End of #table-container --}}
        </div>
    </div>
    {{-- MODAL TAMBAH TICKET --}}
    <div class="modal fade" id="modalTambahTicket" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <form method="POST" action="{{ route('open.ticket.store') }}"
                class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" enctype="multipart/form-data"
                style="background-color: white !important; color: #333 !important;">
                @csrf
                <div class="modal-header text-white d-flex justify-content-center position-relative"
                    style="background-color: #071152;">
                    <h5 class="modal-title w-100 text-center">Tambah Tiket Baru</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4" style="background-color: white !important;">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Pilih Site ID</label>
                            <select name="site_id" id="site_select" class="form-select select2" required>
                                <option value="">-- Cari Site ID --</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->id }}" data-code="{{ $s->site_id }}"
                                        data-name="{{ $s->sitename }}" data-prov="{{ $s->provinsi }}"
                                        data-kab="{{ $s->kab }}" data-tipe="{{ $s->tipe }}">
                                        {{ $s->site_id }} - {{ $s->sitename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Site Code</label>
                            <input type="text" name="site_code" id="site_code" class="form-control bg-light" readonly
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Nama Site</label>
                            <input type="text" name="nama_site" id="nama_site" class="form-control bg-light" readonly
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" class="form-control bg-light" readonly
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" id="kabupaten" class="form-control bg-light" readonly
                                required>
                        </div>
                        {{-- Input untuk Kategori --}}
                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control bg-light" readonly
                                required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tanggal Rekap</label>
                            <input type="date" name="tanggal_rekap" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Durasi (Hari)</label>
                            <input type="text" name="durasi" id="durasi_input" class="form-control bg-light" value="0"
                                readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Problem</label>
                            <select name="kendala" class="form-select" required>
                                <option value="">-- Pilih Kendala --</option>
                                <option value="PERANGKAT TIDAK ADA INTERNET">PERANGKAT TIDAK ADA INTERNET</option>
                                <option value="INTERNET TIDAK BISA TERSAMBUNG">INTERNET TIDAK BISA TERSAMBUNG</option>
                                <option value="PASSWORD SALAH">PASSWORD SALAH</option>
                                <option value="PERANGKAT INTERNET RUSAK">PERANGKAT INTERNET RUSAK</option>
                            </select>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-2">Detail Problem</label>
                                
                                {{-- Selector Perangkat --}}
                                <div class="mb-0">
                                    <select class="form-select form-select-sm" onchange="addHardwareChip('tambah', this.value); this.value='';"
                                        style="border-bottom-left-radius: 0; border-bottom-right-radius: 0; border-color: #dee2e6 !important; background-color: #fff;">
                                        <option value="">-- Pilih Perangkat Yang Bermasalah --</option>
                                        @foreach(['MODEM', 'ROUTER', 'AP1', 'AP2', 'TRANSCEIVER', 'STAVOLT', 'RAK', 'ANTENA', 'LAIN LAIN'] as $opt)
                                            <option value="{{ $opt }}">{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Container Chips --}}
                                <div id="hw-chips-tambah" class="hw-chip-container">
                                    <div class="empty-chips-msg text-muted small">Belum ada perangkat terpilih</div>
                                </div>

                                {{-- Unified Textarea --}}
                                <textarea name="detail_problem" class="form-control textarea-unified" rows="5" required 
                                    placeholder="Tulis detail deskripsi masalah di sini..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark mb-2">Action Plan</label>
                                <textarea name="plan_actions" class="form-control" rows="8" required
                                    placeholder="Jelaskan detail action plan..."
                                    style="border-color: #dee2e6 !important; box-shadow: none; border-radius: 8px;"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="status" value="open">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Pilih CE</label>
                            <select name="ce" class="form-select" required>
                                <option value="">-- Pilih CE --</option>
                                <option value="Eka Mahatva Yudha">Eka Mahatva Yudha</option>
                                <option value="Herman Seprianto">Herman Seprianto</option>
                                <option value="Moh. Walangadi">Moh. Walangadi</option>
                                <option value="Ahmad Suhaini">Ahmad Suhaini</option>
                                <option value="Hasrul Fandi Serang">Hasrul Fandi Serang</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label fw-bold">Evidence (Foto/Video)</label>
                            <input type="file" name="evidence[]" class="form-control" accept="image/*,video/*" multiple>
                            <small class="text-muted">Pilih satu atau beberapa file. Format: jpg, png, mp4. Maks 20MB/file.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Tiket</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Script Remote Mikrotik --}}
    <script>
        // Daftar tunnel WireGuard dari config/wireguard.php
        const wgTunnels = @json($wgTunnels ?? []);

        function remoteMikrotik(ip, kategori, namaSite, siteCode, gateway, hub) {
            // Tentukan kredensial berdasarkan kategori/tipe
            let username = 'admin';
            let password = 'SLAPRO2024'; // Default SL
            let tipeLabel = 'SEWA LAYANAN';

            if (kategori && (kategori.toUpperCase().includes('BMN') || kategori.toUpperCase().includes('BARANG MILIK NEGARA'))) {
                password = 'KAPLBR2024';
                tipeLabel = 'BMN';
            } else {
                tipeLabel = 'SL';
            }

            // Cek tunnel terakhir dari localStorage
            const lastTunnel = localStorage.getItem('last_wg_tunnel');

            // Build select options dari daftar tunnel
            let tunnelOptions = '<option value="">-- Pilih Tunnel --</option>';
            wgTunnels.forEach(t => {
                const selected = (t === lastTunnel) ? 'selected' : '';
                tunnelOptions += `<option value="${t}" ${selected}>${t}</option>`;
            });

            // Tampilkan SweetAlert dengan info koneksi + input tunnel name
            Swal.fire({
                title: '<i class="bi bi-broadcast"></i> Remote Mikrotik',
                html: `
                <div style="text-align: left; font-size: 14px; line-height: 2;">
                    <div style="background: linear-gradient(135deg, #e8f4fd, #f0f7ff); padding: 15px; border-radius: 12px; margin-bottom: 15px; border-left: 4px solid #0d6efd;">
                        <div style="font-weight: 700; font-size: 16px; color: #071152; margin-bottom: 5px;">
                            ${namaSite}
                        </div>
                        <div style="font-size: 12px; color: #666;">Site ID: ${siteCode} | Tipe: ${tipeLabel}</div>
                    </div>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; color: #666; width: 120px;"><i class="bi bi-globe2 me-2"></i>IP Router</td>
                            <td style="padding: 8px 0; font-weight: 700; font-family: monospace; font-size: 15px; color: #0d6efd;">${ip}</td>
                            <td style="padding: 8px 0; width: 30px;"><button class="btn btn-sm btn-outline-primary" onclick="copyText('${ip}')" title="Copy IP"><i class="bi bi-clipboard"></i></button></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;"><i class="bi bi-hdd-network me-2"></i>HUB</td>
                            <td style="padding: 8px 0; font-weight: 600;">${hub || '-'}</td>
                            <td style="padding: 8px 0;"><button class="btn btn-sm btn-outline-primary" onclick="copyText('${hub || ''}')" title="Copy HUB"><i class="bi bi-clipboard"></i></button></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;"><i class="bi bi-door-open me-2"></i>Gateway</td>
                            <td style="padding: 8px 0; font-weight: 600;">${gateway || '-'}</td>
                            <td style="padding: 8px 0;"><button class="btn btn-sm btn-outline-primary" onclick="copyText('${gateway || ''}')" title="Copy Gateway"><i class="bi bi-clipboard"></i></button></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;"><i class="bi bi-person-fill me-2"></i>Username</td>
                            <td style="padding: 8px 0; font-weight: 600;">${username}</td>
                            <td style="padding: 8px 0;"><button class="btn btn-sm btn-outline-primary" onclick="copyText('${username}')" title="Copy"><i class="bi bi-clipboard"></i></button></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; color: #666;"><i class="bi bi-key-fill me-2"></i>Password</td>
                            <td style="padding: 8px 0; font-weight: 600; font-family: monospace;">${password}</td>
                            <td style="padding: 8px 0;"><button class="btn btn-sm btn-outline-primary" onclick="copyText('${password}')" title="Copy"><i class="bi bi-clipboard"></i></button></td>
                        </tr>
                    </table>
                    <hr style="margin: 12px 0;">
                    <div style="margin-top: 5px;">
                        <label style="font-size: 13px; font-weight: 600; color: #333; display: block; margin-bottom: 5px;">
                            <i class="bi bi-shield-lock-fill me-1" style="color: #0d6efd;"></i> Pilih Tunnel WireGuard
                        </label>
                        <select id="swal-tunnel-name" class="form-select" 
                               style="font-size: 14px; border: 2px solid #dee2e6; border-radius: 8px; padding: 8px 12px; cursor: pointer;">
                            ${tunnelOptions}
                        </select>
                        <small style="color: #888; font-size: 11px;">Pilih tunnel VPN yang sesuai untuk site ini</small>
                    </div>
                    <div style="margin-top: 12px; background: #f8f9fa; border-radius: 10px; padding: 12px; border: 1px dashed #dee2e6;">
                        <div style="font-size: 12px; color: #555; margin-bottom: 8px;">
                            <i class="bi bi-info-circle-fill me-1" style="color: #0d6efd;"></i>
                            <b>Pertama kali?</b> Download & jalankan installer sekali saja:
                        </div>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <a href="/tools/install-remote-v5.bat" download
                               style="display: inline-flex; align-items: center; gap: 5px; background: linear-gradient(135deg, #198754, #157347); color: white; text-decoration: none; padding: 6px 14px; border-radius: 8px; font-size: 12px; font-weight: 600;">
                                <i class="bi bi-download"></i> Download Installer v9
                            </a>
                            <span style="font-size: 11px; color: #888;">→ Klik kanan → Run as Administrator</span>
                        </div>
                    </div>
                </div>
            `,
                showCancelButton: true,
                showDenyButton: true,
                confirmButtonText: '<i class="bi bi-rocket-takeoff-fill me-1"></i> Remote Otomatis',
                denyButtonText: '<i class="bi bi-box-arrow-up-right me-1"></i> Buka WebFig',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#198754',
                denyButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                width: 540,
                customClass: {
                    popup: 'rounded-4'
                },
                preConfirm: () => {
                    const tunnelName = document.getElementById('swal-tunnel-name').value.trim();
                    if (!tunnelName) {
                        Swal.showValidationMessage('<i class="bi bi-exclamation-triangle me-1"></i> Pilih tunnel WireGuard terlebih dahulu!');
                        return false;
                    }
                    return tunnelName;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    localStorage.setItem('last_wg_tunnel', result.value);
                    launchRemote(ip, username, password, result.value, namaSite, siteCode);
                } else if (result.isDenied) {
                    window.open('http://' + ip, '_blank');
                }
            });
        }

        function launchRemote(ip, user, pass, tunnelName, siteName, siteCode) {
            const remoteUrl = `nusa-remote://${tunnelName}___${ip}___${user}___${pass}`;

            // Gunakan assign agar lebih reliabel
            window.location.assign(remoteUrl);

            // Log ke audit trail (status success karena ping sudah OK sebelumnya)
            fetch('/remote-log/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    site_name: siteName,
                    site_code: siteCode || '',
                    ip_router: ip,
                    tunnel_name: tunnelName,
                    source_page: 'open_ticket',
                    status: 'success'
                })
            }).catch(e => console.log('Log remote:', e));

            Swal.fire({
                icon: 'info',
                title: 'Remote Berjalan',
                html: `
                <div style="font-size: 14px;">
                    Sedang mengaktifkan VPN <b>${tunnelName}</b> dan membuka WinBox ke <b>${siteName}</b>...
                </div>
                <div style="margin-top: 15px; font-size: 11px; color: #888;">
                    Pastikan Anda sudah menginstall handler remote v5 di PC ini.
                </div>
            `,
                timer: 5000,
                showConfirmButton: false,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
                Toast.fire({ icon: 'success', title: 'Berhasil dicopy!' });
            });
        }

        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
                Toast.fire({ icon: 'success', title: 'Berhasil dicopy!' });
            });
        }

        function copyAllInfo(ip, username, password) {
            const allInfo = `IP Router: ${ip}\nUsername: ${username}\nPassword: ${password}`;
            navigator.clipboard.writeText(allInfo).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500
                });
                Toast.fire({ icon: 'success', title: 'Semua info dicopy!' });
            });
        }
    </script>
    {{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
    <script>
        // SCRIPT AUTO-FILL BERDASARKAN PILIHAN SITE
        document.getElementById('site_select').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
            document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
            document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
            document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
        });
        // SWEETALERT NOTIFIKASI
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
        @endif
    </script>
    {{-- Script untuk auto-fill berdasarkan pilihan site --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const siteSelect = document.getElementById('site_select');
            if (siteSelect) {
                siteSelect.addEventListener('change', function () {
                    const selected = this.options[this.selectedIndex];
                    // Mengisi input berdasarkan data-attribute yang ada di <option>
                    document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
                    document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
                    document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
                    document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
                });
            }
        });
    </script>
    {{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tanggalRekapInput = document.getElementsByName('tanggal_rekap')[0];
            const durasiInput = document.getElementById('durasi_input');
            function hitungDurasi() {
                const tanggalTerpilih = new Date(tanggalRekapInput.value);
                const hariIni = new Date();
                // Reset jam ke 00:00:00 agar perhitungan hari akurat
                tanggalTerpilih.setHours(0, 0, 0, 0);
                hariIni.setHours(0, 0, 0, 0);
                // Hitung selisih dalam milidetik
                const selisihMilidetik = hariIni.getTime() - tanggalTerpilih.getTime();
                // Konversi milidetik ke hari (1 hari = 24 * 60 * 60 * 1000 ms)
                const selisihHari = Math.floor(selisihMilidetik / (1000 * 60 * 60 * 24));
                // Jika tanggal rekap adalah hari ini, durasi 0. Jika kemarin, durasi 1.
                // Jika user memilih tanggal masa depan, kita set durasi ke 0
                durasiInput.value = selisihHari > 0 ? selisihHari : 0;
            }
            // Jalankan fungsi saat input tanggal berubah
            tanggalRekapInput.addEventListener('change', hitungDurasi);
            // Jalankan fungsi saat modal pertama kali dibuka (untuk default value)
            hitungDurasi();
        });
    </script>
    {{-- Script untuk konfirmasi delete dengan SweetAlert2 --}}
    <script>
        // SCRIPT KONFIRMASI DELETE DENGAN SWEETALERT2 (Menggunakan Delegasi agar tetap jalan setelah AJAX search)
        $(document).on('click', '.btn-delete', function (e) {
            const siteName = $(this).data('name');
            const $form = $(this).closest('form');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Tiket untuk " + siteName + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: { popup: 'rounded-4' }
            }).then((result) => {
                if (result.isConfirmed) {
                    $form.submit();
                }
            });
        });
    </script>
    {{-- Script untuk inisialisasi Select2 pada dropdown site --}}
    <script>
        $(document).ready(function () {
            $('#site_select').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Cari Site ID --',
                allowClear: true,
                width: '100%',
                // Mengambil parent modal secara otomatis
                dropdownParent: $('#site_select').closest('.modal')
            });
        });
    </script>
    {{-- Script untuk inisialisasi Select2 pada dropdown site dengan perbaikan fokus di modal --}}
    <script>
        $(document).ready(function () {
            // 1. Inisialisasi Select2 & Perbaikan Fokus di Modal
            const $siteSelect = $('#site_select');
            $siteSelect.select2({
                theme: 'bootstrap-5',
                placeholder: '-- Cari Site ID --',
                allowClear: true,
                width: '100%',
                // Mengambil parent modal secara otomatis agar bisa diketik
                dropdownParent: $siteSelect.closest('.modal').length ? $siteSelect.closest('.modal') : $(document.body)
            });
            // Fix bug Select2: agar kursor otomatis fokus ke kolom pencarian saat diklik
            $(document).on('select2:open', () => {
                setTimeout(() => {
                    const searchField = document.querySelector('.select2-search__field');
                    if (searchField) searchField.focus();
                }, 10);
            });
            // 2. Event saat Site ID dipilih (Auto-fill & Mapping Kategori)
            $siteSelect.on('change', function () {
                const selectedOption = $(this).find(':selected');
                // Ambil data dasar dari atribut data-
                const code = selectedOption.data('code');
                const name = selectedOption.data('name');
                const prov = selectedOption.data('prov');
                const kab = selectedOption.data('kab');
                const tipeFull = selectedOption.data('tipe');
                // Logika Mapping Kategori: Mengubah teks panjang menjadi singkatan
                let kategoriSingkat = "";
                if (tipeFull) {
                    const tipeUpper = tipeFull.toUpperCase(); // Ubah ke huruf besar semua agar pencarian akurat
                    if (tipeUpper.includes("BARANG MILIK NEGARA") || tipeUpper.includes("BMN")) {
                        kategoriSingkat = "BMN";
                    } else if (tipeUpper.includes("SEWA LAYANAN") || tipeUpper.includes("SL")) {
                        kategoriSingkat = "SL";
                    } else {
                        kategoriSingkat = tipeFull; // Pakai teks asli jika tidak ada kecocokan
                    }
                }
                // Distribusikan data ke input masing-masing ID
                $('#site_code').val(code || '');
                $('#nama_site').val(name || '');
                $('#provinsi').val(prov || '');
                $('#kabupaten').val(kab || '');
                $('#kategori').val(kategoriSingkat);
            });

            // --- NEW: Hardware Chips Logic ---
            window.addHardwareChip = function(modalId, device) {
                if (!device) return;
                const container = $(`#hw-chips-${modalId}`);
                
                // Prevent duplication
                if (container.find(`.hw-chip[data-value="${device}"]`).length > 0) return;

                const chipHtml = `
                    <div class="hw-chip animate__animated animate__zoomIn animate__faster" data-value="${device}">
                        <i class="bi bi-cpu"></i> ${device}
                        <span class="btn-close-chip" onclick="removeHardwareChip('${modalId}', '${device}')">×</span>
                        <input type="hidden" name="hardware_problem[]" value="${device}">
                    </div>
                `;

                container.find('.empty-chips-msg').addClass('d-none');
                container.append(chipHtml);
            };

            window.removeHardwareChip = function(modalId, device) {
                const container = $(`#hw-chips-${modalId}`);
                container.find(`.hw-chip[data-value="${device}"]`).remove();
                
                if (container.find('.hw-chip').length === 0) {
                    container.find('.empty-chips-msg').removeClass('d-none');
                }
            };

            // Remove legacy Hardware Row Management functions if no longer needed
            // (Keeping placeholders if needed for other parts, but logic is replaced above)


            // Initialize Master Select2 (Simple Theme)
            $(document).on('shown.bs.modal', '.modal', function () {
                $(this).find('.select2-master-simple').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $(this)
                });
            });
        });
    </script>

    <!-- Modal Viewer Evidence -->
    <div class="modal fade" id="modalViewerEvidence" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-transparent border-0 shadow-none">
                <div class="modal-body p-0 text-center position-relative">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal" aria-label="Close" style="z-index: 100001;"></button>
                    <div id="evidenceContainer" class="d-flex justify-content-center align-items-center">
                        <!-- Content will be injected here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewEvidence(url) {
            const container = document.getElementById('evidenceContainer');
            if (!container) return;

            const ext = url.split('.').pop().toLowerCase();
            const videoExts = ['mp4', 'mov', 'avi', 'webm'];

            container.innerHTML = '';

            if (videoExts.includes(ext)) {
                container.innerHTML = `<video src="${url}" controls autoplay class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto;"></video>`;
            } else {
                container.innerHTML = `<img src="${url}" class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto; object-fit: contain;">`;
            }

            var myModal = new bootstrap.Modal(document.getElementById('modalViewerEvidence'));
            myModal.show();
        }
    </script>
    <script>
        $(document).ready(function () {
            /**
             * Fungsi Utama AJAX Reload Tabel
             */
            function loadTable(url) {
                // Efek pemuatan (loading)
                $('#table-container').addClass('opacity-50');

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Perbarui Tabel
                        const newTable = doc.querySelector('#table-container')?.innerHTML;
                        if (newTable) {
                            $('#table-container').html(newTable);
                        }

                        // Perbarui Badge Summary (Total Open, BMN, SL)
                        const newBadges = doc.querySelector('#summary-badges')?.innerHTML;
                        if (newBadges) {
                            $('#summary-badges').html(newBadges);
                        }

                        // SINKRONISASI HIDDEN INPUTS (Agar sort tidak hilang saat ganti kategori)
                        const urlObj = new URL(url, window.location.origin);
                        const sort = urlObj.searchParams.get('sort');
                        const order = urlObj.searchParams.get('order');
                        if (sort) $('input[name="sort"]').val(sort);
                        if (order) $('input[name="order"]').val(order);

                        $('#table-container').removeClass('opacity-50');

                        // Perbarui URL di address bar tanpa reload halaman
                        window.history.pushState({ path: url }, '', url);
                    })
                    .catch(error => {
                        console.error('AJAX Error:', error);
                        $('#table-container').removeClass('opacity-50');
                        // Fallback: Reload normal jika AJAX gagal
                        // window.location.href = url;
                    });
            }

            /**
             * 1. Submit Form via AJAX (Pencarian & Filter Kategori/Provinsi)
             */
            $(document).on('submit', '#filterForm', function (e) {
                e.preventDefault();
                const action = $(this).attr('action') || window.location.pathname;
                const params = $(this).serialize();
                const url = action + (action.includes('?') ? '&' : '?') + params;
                loadTable(url);
            });

            /**
             * 2. Trigger Otomatis saat Select/Input diubah
             */
            $(document).on('change', '#filterForm select, #filterForm input[type="date"], #filterForm input[type="number"]', function () {
                $('#filterForm').trigger('submit');
            });

            /**
             * 3. Live Search (Opsional: Trigger saat mengetik - beri delay agar tidak lambat)
             */
            let searchTimer;
            $(document).on('keyup', '#searchInput', function () {
                clearTimeout(searchTimer);
                searchTimer = setTimeout(() => {
                    $('#filterForm').trigger('submit');
                }, 600); // Tunggu 0.6 detik setelah berhenti mengetik
            });

            /**
             * 4. Pagination & Sorting Links via AJAX
             */
            $(document).on('click', '#table-container .pagination a, #table-container thead th a', function (e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url && url !== '#') {
                    loadTable(url);
                }
            });

            /**
             * 5. Sinkronisasi dengan tombol BACK browser
             */
            window.onpopstate = function () {
                loadTable(window.location.href);
            };
        });
    </script>
</body>

</html>