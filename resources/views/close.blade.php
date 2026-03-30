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
    <title>Close Ticket | Project Operational</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                justify-content: flex-start !important;
            }

            .card-header {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 15px;
            }

            .search-form,
            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
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
        
        /* Active Sorting Style */
        thead th.sorting-active {
            background-color: #e8f4ff !important;
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

        /* Sorting Caret Stack */
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
                @if(auth()->check() && auth()->user()->role === 'superadmin')
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: White;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Summary Tiket</a>
        <div id="summary-badges" class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Close: <b>{{ $closeAllCount }}</b></span>
            <span class="summary-badge text-black">Close Hari Ini: <b>{{ $todayCount }}</b></span>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                <a href="{{ route('close.ticket.export') }}" class="btn-action bi bi-download" title="Download Excel"
                    style="text-decoration: none; line-height: 1.8;"></a>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form id="filterForm" method="GET" action="{{ route('close.ticket') }}" class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end">
                    {{-- Hidden inputs to preserve sorting when filtering/searching --}}
                    <input type="hidden" name="sort" value="{{ request('sort', 'tanggal_close') }}">
                    <input type="hidden" name="order" value="{{ request('order', 'desc') }}">

                    <div class="col-12 col-md-auto">
                        <input type="number" name="per_page" class="form-control form-control-sm text-center w-100" min="1" placeholder="Data" value="{{ request('per_page', 50) }}" title="Jumlah data">
                    </div>

                    <div class="col-12 col-md-auto">
                        <select name="kategori" class="form-select form-select-sm w-100">
                            <option value="">Semua Kategori</option>
                            <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-auto">
                        <input type="date" name="tgl_mulai" class="form-control form-control-sm w-100" value="{{ request('tgl_mulai') }}" title="Dari Tanggal">
                    </div>
                    
                    <div class="col-12 col-md-auto">
                        <input type="date" name="tgl_selesai" class="form-control form-control-sm w-100" value="{{ request('tgl_selesai') }}" title="Sampai Tanggal">
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('close.ticket') }}" class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100" title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- TABLE CONTAINER UNTUK AJAX RELOAD --}}
        <div id="table-container">
            <div class="table-responsive-custom">
                <table>
                    <thead>
                        <tr>
                            <th class="sticky-col col-no">NO</th>
                            <th class="sticky-col col-site-id">SITE ID</th>
                            <th class="sticky-col col-nama_site">NAMA SITE</th>
                            <th class="text-center">KATEGORI</th>
                            <th class="text-center {{ request('sort') == 'tanggal_rekap' ? 'sorting-active' : '' }}" style="min-width: 150px; cursor: pointer;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_rekap', 'order' => (request('sort') == 'tanggal_rekap' && request('order') == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none d-flex align-items-center justify-content-center gap-1">
                                    TANGGAL OPEN
                                    <div class="sort-icon-stack">
                                        <i class="bi bi-caret-up-fill {{ request('sort') == 'tanggal_rekap' && request('order') == 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bi bi-caret-down-fill {{ request('sort') == 'tanggal_rekap' && request('order') == 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-center {{ request('sort') == 'tanggal_close' || !request('sort') ? 'sorting-active' : '' }}" style="min-width: 150px; cursor: pointer;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_close', 'order' => (request('sort') == 'tanggal_close' && request('order') == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none d-flex align-items-center justify-content-center gap-1">
                                    TANGGAL CLOSE
                                    <div class="sort-icon-stack">
                                        <i class="bi bi-caret-up-fill {{ (request('sort') == 'tanggal_close' || !request('sort')) && request('order') == 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bi bi-caret-down-fill {{ (request('sort') == 'tanggal_close' || !request('sort')) && request('order', 'desc') == 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-center {{ request('sort') == 'durasi' ? 'sorting-active' : '' }}" style="min-width: 120px; cursor: pointer;">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'durasi', 'order' => (request('sort') == 'durasi' && request('order') == 'asc') ? 'desc' : 'asc']) }}" 
                                   class="text-decoration-none d-flex align-items-center justify-content-center gap-1">
                                    DURASI
                                    <div class="sort-icon-stack">
                                        <i class="bi bi-caret-up-fill {{ request('sort') == 'durasi' && request('order') == 'asc' ? 'active' : 'inactive' }}"></i>
                                        <i class="bi bi-caret-down-fill {{ request('sort') == 'durasi' && request('order') == 'desc' ? 'active' : 'inactive' }}"></i>
                                    </div>
                                </a>
                            </th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">CE</th>
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    </thead>
                <tbody>
                    @forelse($tickets as $i => $t)
                        <tr>
                            <td class="sticky-col col-no text-center">{{ $tickets->firstItem() + $i }}</td>
                            <td class="sticky-col col-site-id text-center">{{ $t->site_code }}</td>
                            <td class="sticky-col col-nama_site">{{ $t->nama_site }}</td>
                            <td class="text-center">{{ $t->kategori }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                            <td class="text-center">
                                {{ $t->tanggal_close ? \Carbon\Carbon::parse($t->tanggal_close)->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center">{{ number_format($t->durasi, 0) }} Hari</td>
                            <td class="text-center"><span class="status-badge">CLOSED</span></td>
                            <td class="text-center">{{ $t->ce }}</td>
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <td class="text-center">
                                        <button class="btn btn-sm bi bi-pencil" data-bs-toggle="modal"
                                            data-bs-target="#modalEditTicket{{ $t->id }}">
                                        </button>
                                        <form action="{{ route('close.ticket.destroy', $t->id) }}" method="POST"
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
                                        <!-- Modal Info -->
                                        <div class="modal fade" id="modalInfo{{ $t->id }}" tabindex="-1"
                                            aria-labelledby="label{{ $t->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered">
                                                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                                    <div class="modal-header border-0 p-4 d-flex align-items-center justify-content-between"
                                                        style="background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="bg-white bg-opacity-25 p-2 rounded-circle">
                                                                <i class="bi bi-info-circle-fill text-white fs-4"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="modal-title text-white fw-bold mb-0"
                                                                    id="label{{ $t->id }}">Detail Tiket Site</h5>
                                                                <small class="text-white text-opacity-75">Informasi lengkap
                                                                    perbaikan perangkat</small>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body p-4 bg-light text-start">
                                                        <div class="row g-4">
                                                            <div class="col-md-6">
                                                                <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                                                                    <h6
                                                                        class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                                                                        <i class="bi bi-geo-alt-fill"></i> Lokasi & Identitas
                                                                    </h6>
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Site ID</span>
                                                                            <span class="fw-bold">{{ $t->site_code }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Nama Site</span>
                                                                            <span class="fw-bold text-end text-wrap text-break"
                                                                                style="max-width: 65%;">{{ $t->nama_site }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Provinsi</span>
                                                                            <span class="fw-semibold">{{ $t->provinsi }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Kabupaten</span>
                                                                            <span class="fw-semibold">{{ $t->kabupaten }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Kategori</span>
                                                                            <span
                                                                                class="badge bg-info bg-opacity-10 text-info fw-bold">{{ $t->kategori }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                                                                    <h6
                                                                        class="fw-bold text-success mb-3 d-flex align-items-center gap-2">
                                                                        <i class="bi bi-clock-history"></i> Progres & Waktu
                                                                    </h6>
                                                                    <div class="d-flex flex-column gap-2">
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Tgl Open</span>
                                                                            <span
                                                                                class="fw-bold">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Tgl Close</span>
                                                                            <span
                                                                                class="fw-bold text-success">{{ $t->tanggal_close ? \Carbon\Carbon::parse($t->tanggal_close)->format('d M Y') : '-' }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Status</span>
                                                                            <span
                                                                                class="badge bg-secondary text-white fw-bold px-3 rounded-pill">CLOSED</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">Durasi</span>
                                                                            <span
                                                                                class="text-danger fw-bold fs-5">{{ number_format($t->durasi, 0) }}
                                                                                Hari</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex justify-content-between border-bottom pb-2">
                                                                            <span class="text-muted small">CE</span>
                                                                            <span class="fw-semibold">{{ $t->ce ?? '-' }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="bg-white p-3 rounded-4 shadow-sm">
                                                                    <h6
                                                                        class="fw-bold text-danger mb-3 d-flex align-items-center gap-2">
                                                                        <i class="bi bi-exclamation-triangle-fill"></i> Detail
                                                                        Teknis
                                                                    </h6>
                                                                    <div class="row g-3">
                                                                        <div class="col-md-6">
                                                                            <div class="p-3 bg-light rounded-3 h-100">
                                                                                <div class="text-muted small fw-bold mb-1">
                                                                                    KENDALA UTAMA</div>
                                                                                <p class="mb-0 fw-semibold text-dark">
                                                                                    {{ $t->kendala }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="p-3 bg-light rounded-3 h-100">
                                                                                <div class="text-muted small fw-bold mb-1">
                                                                                    EVIDENCE</div>
                                                                                <p class="mb-0 fw-semibold text-dark">
                                                                                    {{ $t->evidence ?? 'TIDAK ADA' }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="p-3 bg-light rounded-3 mb-3">
                                                                                <div class="text-muted small fw-bold mb-1">
                                                                                    DETAIL PROBLEM</div>
                                                                                <p class="mb-0 text-dark small"
                                                                                    style="line-height: 1.6;">
                                                                                    {{ $t->detail_problem }}
                                                                                </p>
                                                                            </div>
                                                                            <div class="p-3 rounded-3"
                                                                                style="background-color: #f0f7ff; border-left: 4px solid #3a7bd5;">
                                                                                <div class="text-primary small fw-bold mb-1">
                                                                                    PLAN ACTION / TINDAKAN</div>
                                                                                <p class="mb-0 text-dark small"
                                                                                    style="line-height: 1.6;">
                                                                                    {{ $t->plan_actions }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer border-0 p-4 bg-light">
                                                        <button type="button"
                                                            class="btn btn-primary px-4 rounded-pill shadow-sm"
                                                            data-bs-dismiss="modal">
                                                            Tutup
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-muted">Data close ticket tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- PAGINATION --}}
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $tickets->firstItem() ?? 0 }} to {{ $tickets->lastItem() ?? 0 }} 
                of&nbsp;<strong>{{ $tickets->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $tickets->appends(['q' => $search])->links() }}
            </nav>
        </div>
        </div> {{-- End of #table-container --}}
    </div>

    {{-- MODAL EDIT TICKET --}}
    @foreach($tickets as $t)
        <div class="modal fade" id="modalEditTicket{{ $t->id }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <form method="POST" action="{{ route('close.ticket.update', $t->id) }}" class="modal-content">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white d-flex justify-content-center position-relative"
                        style="background-color: #071152;">
                        <h5 class="modal-title w-100 text-center"><i class="bi bi-pencil-square"></i> Edit Tiket Terutup -
                            {{ $t->nama_site }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Site ID / Code</label>
                                <input type="text" class="form-control bg-light" value="{{ $t->site_code }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nama Site</label>
                                <input type="text" class="form-control bg-light" value="{{ $t->nama_site }}" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="BMN" {{ $t->kategori == 'BMN' ? 'selected' : '' }}>BMN</option>
                                    <option value="SL" {{ $t->kategori == 'SL' ? 'selected' : '' }}>SL</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Tanggal Open</label>
                                <input type="date" name="tanggal_rekap" class="form-control" value="{{ $t->tanggal_rekap }}"
                                    required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">Tanggal Close</label>
                                <input type="date" name="tanggal_close" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($t->tanggal_close)->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-primary">CE (Customer Engineer)</label>
                                <select name="ce" class="form-select" required>
                                    <option value="Eka Mahatva Yudha" {{ $t->ce == 'Eka Mahatva Yudha' ? 'selected' : '' }}>
                                        Eka Mahatva Yudha</option>
                                    <option value="Herman Seprianto" {{ $t->ce == 'Herman Seprianto' ? 'selected' : '' }}>
                                        Herman Seprianto</option>
                                    <option value="Moh. Walangadi" {{ $t->ce == 'Moh. Walangadi' ? 'selected' : '' }}>Moh.
                                        Walangadi</option>
                                    <option value="Ahmad Suhaini" {{ $t->ce == 'Ahmad Suhaini' ? 'selected' : '' }}>Ahmad
                                        Suhaini</option>
                                    <option value="Hasrul Fandi Serang" {{ $t->ce == 'Hasrul Fandi Serang' ? 'selected' : '' }}>Hasrul Fandi Serang</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold text-primary">Kendala</label>
                                <input type="text" name="kendala" class="form-control" value="{{ $t->kendala }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Detail Problem</label>
                                <textarea name="detail_problem" class="form-control" rows="3"
                                    required>{{ $t->detail_problem }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">Action Plan</label>
                                <textarea name="plan_actions" class="form-control" rows="3"
                                    required>{{ $t->plan_actions }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(document).ready(function() {
        /**
         * Fungsi Utama AJAX Reload Tabel
         */
        function loadTable(url) {
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
                
                // Perbarui Badge Summary
                const newBadges = doc.querySelector('#summary-badges')?.innerHTML;
                if (newBadges) {
                    $('#summary-badges').html(newBadges);
                }

                // SINKRONISASI HIDDEN INPUTS
                const urlObj = new URL(url, window.location.origin);
                const sort = urlObj.searchParams.get('sort');
                const order = urlObj.searchParams.get('order');
                if (sort) $('input[name="sort"]').val(sort);
                if (order) $('input[name="order"]').val(order);
                
                $('#table-container').removeClass('opacity-50');
                window.history.pushState({ path: url }, '', url);
            })
            .catch(error => {
                console.error('AJAX Error:', error);
                $('#table-container').removeClass('opacity-50');
            });
        }

        /**
         * 1. Submit Form via AJAX
         */
        $(document).on('submit', '#filterForm', function(e) {
            e.preventDefault();
            const action = $(this).attr('action') || window.location.pathname;
            const params = $(this).serialize();
            const url = action + (action.includes('?') ? '&' : '?') + params;
            loadTable(url);
        });

        /**
         * 2. Trigger Otomatis
         */
        $(document).on('change', '#filterForm select, #filterForm input[type="date"], #filterForm input[type="number"]', function() {
            $('#filterForm').trigger('submit');
        });

        /**
         * 3. Live Search
         */
        let searchTimer;
        $(document).on('keyup', '#searchInput', function() {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(() => {
                $('#filterForm').trigger('submit');
            }, 600);
        });

        /**
         * 4. Pagination & Sorting Links
         */
        $(document).on('click', '#table-container .pagination a, #table-container thead th a', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            if (url && url !== '#') {
                loadTable(url);
            }
        });

        /**
         * 5. Back Button Support
         */
        window.onpopstate = function() {
            loadTable(window.location.href);
        };
    });
    </script>
</body>

</html>
