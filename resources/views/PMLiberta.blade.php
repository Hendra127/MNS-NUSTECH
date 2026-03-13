<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Preventive Maintenance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
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
        /* ===== PAGINATION STYLING ===== */
        .pagination-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px 16px;
            border-top: 1px solid #e9ecef;
            min-height: 44px;
        }
        .pagination-info {
            font-size: 13px;
            color: #6c757d;
            white-space: nowrap;
            line-height: 32px;
            margin: 0;
        }
        /* Sembunyikan teks 'Showing...' bawaan Laravel dari links() */
        .pagination-wrapper nav > div > div:first-child,
        .pagination-wrapper nav p.small {
            display: none !important;
        }
        /* Pastikan nav dan semua wrapper di dalamnya sejajar */
        .pagination-wrapper nav,
        .pagination-wrapper nav > div,
        .pagination-wrapper nav > div > div {
            display: flex !important;
            align-items: center !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        /* Override default Laravel pagination agar horizontal */
        .pagination-wrapper .pagination {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: wrap;
            gap: 4px;
            margin-bottom: 0;
            padding-left: 0;
            list-style: none;
        }
        .pagination-wrapper .pagination .page-item {
            display: inline-block !important;
        }
        .pagination-wrapper .pagination .page-item .page-link {
            padding: 5px 11px;
            font-size: 13px;
            border-radius: 6px !important;
            border: 1px solid #dee2e6;
            color: #3d5af1;
            background: #fff;
            line-height: 1.4;
            transition: background 0.15s, color 0.15s;
        }
        .pagination-wrapper .pagination .page-item.active .page-link {
            background-color: #3d5af1;
            border-color: #3d5af1;
            color: #fff;
            font-weight: 600;
        }
        .pagination-wrapper .pagination .page-item.disabled .page-link {
            color: #adb5bd;
            pointer-events: none;
        }
        .pagination-wrapper .pagination .page-item .page-link:hover:not(.active) {
            background-color: #e8ecff;
            color: #3d5af1;
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
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
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
            @if(auth()->check() && auth()->user()->role === 'superadmin')
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                @if(auth()->check() && auth()->user()->role === 'superadmin')
                    <a href="{{ route('setting.index') }}" class="user-profile-icon" title="Setting User" style="cursor: pointer; text-decoration: none; color: inherit;">
                        @if(auth()->user()->photo)
                            <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
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
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*', 'sites*') ? 'active' : '' }}" style="text-decoration: none;">All Sites</a>
        <a href="{{ route('datapas') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none;">Management Password</a>
        <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}" style="text-decoration: none;">Correctiv Maintenance</a>
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none;">PM Summary</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total BMN Done : <b>&nbsp;{{ $totalBMNDone }}</b></span>
            <span class="summary-badge text-black">Total SL Done : <b>&nbsp;{{ $totalSLDone }}</b></span>
            <span class="summary-badge text-dark">Pending Total : <b>&nbsp;{{ $totalPending }}</b></span>
        </div>
    </div>
    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal" data-bs-target="#modalTambah"></button>
                    <form action="{{ route('pmliberta.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" 
                            accept=".xlsx, .xls, .csv" 
                            onchange="handleFileUpload()"> 
                        <button type="button" class="btn-action bi bi-upload" title="Upload" 
                                onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
               <a href="{{ route('pmliberta.export', request()->all()) }}" 
               <a href="{{ route('pmliberta.export', request()->all()) }}" 
                    class="btn-action bi bi-download" 
                    title="Download" 
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>
            <form method="GET" action="{{ route('pmliberta') }}" class="search-form" id="searchForm">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i>
                    </button>
                    {{-- Hidden inputs untuk mempertahankan filter saat mencari --}}
                    @if(request('kategori')) <input type="hidden" name="kategori" value="{{ request('kategori') }}"> @endif
                    @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                    @if(request('tgl_mulai')) <input type="hidden" name="tgl_mulai" value="{{ request('tgl_mulai') }}"> @endif
                    @if(request('tgl_selesai')) <input type="hidden" name="tgl_selesai" value="{{ request('tgl_selesai') }}"> @endif
                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" autocomplete="off" style="flex-grow: 1; border: none; outline: none;">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>
        <div class="table-responsive-custom" style="overflow-x: auto; max-width: 100%;">
            <table class="table table-bordered">
            <thead>
                <tr class="thead-dark">
                        <th class="text-center sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_lokasi">NAMA LOKASI</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN / KOTA</th>
                        <th>PIC CE</th>
                        <th>MONTH</th>
                        <th>DATE</th>
                        <th>STATUS</th>
                        <th>KATEGORI</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th>AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $key => $item)
                    <tr>
                        <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                        <td class="text-center sticky-col col-site-id">{{ $item->site_id }}</td>
                        <td class="sticky-col col-nama_lokasi">{{ $item->nama_lokasi }}</td>
                        <td>{{ $item->provinsi }}</td>
                        <td>{{ $item->kabupaten }}</td>
                        <td>{{ $item->pic_ce }}</td>
                        <td class="text-center">{{ $item->month }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <span class="badge text-black{{ $item->status == 'Done' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-center">{{ $item->kategori }}</td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" 
                                        class="btn bi bi-pencil btn-edit" 
                                        data-id="{{ $item->id }}"
                                        data-site_id="{{ $item->site_id }}"
                                        data-nama_lokasi="{{ $item->nama_lokasi }}"
                                        data-provinsi="{{ $item->provinsi }}"
                                        data-kabupaten="{{ $item->kabupaten }}"
                                        data-date="{{ $item->date ? \Carbon\Carbon::parse($item->date)->format('Y-m-d') : '' }}"
                                        data-month="{{ $item->month }}"
                                        data-status="{{ $item->status }}"
                                        data-week="{{ $item->week }}"
                                        data-kategori="{{ $item->kategori }}">
                                    </button>
                                    <form action="{{ route('pmliberta.destroy', $item->id) }}" method="POST" class="form-delete">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="button" class="btn bi bi-trash btn-delete-trigger" data-nama="{{ $item->nama_lokasi }}"> </button>
                                    </form>
                                </div>
                            </td>
                        @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of&nbsp;<strong>{{ $data->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $data->onEachSide(1)->links() }}
            </nav>
        </div>
    </div>
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                    <h5 class="modal-title w-100 text-center">Edit Data Preventive Maintenance</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Site ID</label>
                            <input type="text" name="site_id" id="edit_site_id" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="edit_nama_lokasi" class="form-control" required>
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
                                <option value="DONE">DONE</option>
                                <option value="PENDING">PENDING</option>
                                <option value="ON PROGRESS">ON PROGRESS</option>
                            </select>
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
                <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title w-100 text-center fw-bold">Tambah Data Preventive Maintenance</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Cari Site ID</label>
                            <select id="siteSelectAdd" class="form-select select2-site" required>
                                <option value="">-- Pilih Site --</option>
                                @foreach($sites as $site)
                                    <option value="{{ $site->site_id }}" 
                                            data-name="{{ $site->sitename }}"
                                            data-provinsi="{{ $site->provinsi }}"
                                            data-kabupaten="{{ $site->kab }}">
                                        {{ $site->site_id }} - {{ $site->sitename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Hidden input for real site_id submit --}}
                        <input type="hidden" name="site_id" id="add_site_id">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Lokasi</label>
                            <input type="text" name="nama_lokasi" id="add_nama_lokasi" class="form-control rounded-3" required readonly style="background-color: #f8f9fa;">
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
                            <input type="text" name="provinsi" id="add_provinsi" class="form-control rounded-3" readonly style="background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kabupaten</label>
                            <input type="text" name="kabupaten" id="add_kabupaten" class="form-control rounded-3" readonly style="background-color: #f8f9fa;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Date (Tanggal)</label>
                            <input type="date" name="date" id="add_date" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Month</label>
                            <input type="text" name="month" id="add_month" class="form-control rounded-3" readonly style="background-color: #f8f9fa;">
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
                                <option value="DONE">DONE</option>
                                <option value="PENDING" selected>PENDING</option>
                                <option value="ON PROGRESS">ON PROGRESS</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">PIC CE</label>
                            <input type="text" name="pic_ce" class="form-control rounded-3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-3 border" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-3" style="background-color: #071152; border: none;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL FILTER --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center">Filter Data Preventive Maintenance</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('pmliberta') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                                <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="DONE" {{ request('status') == 'DONE' ? 'selected' : '' }}>DONE</option>
                                <option value="PENDING" {{ request('status') == 'PENDING' ? 'selected' : '' }}>PENDING</option>
                                <option value="ON PROGRESS" {{ request('status') == 'ON PROGRESS' ? 'selected' : '' }}>ON PROGRESS</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}">
                        </div>
                        {{-- Hidden input untuk mempertahankan pencarian saat filter --}}
                        @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('pmliberta') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END MODAL FILTER -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
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
    $('#add_date').on('change', function() {
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const d = new Date($(this).val());
        if (!isNaN(d.getTime())) {
            $('#add_month').val(months[d.getMonth()]);
        }
    });
    // Gunakan delegasi event agar tombol tetap berfungsi jika tabel di-refresh/filter
    $(document).on('click', '.btn-edit', function() {
        // 1. Ambil data dari atribut data-* tombol yang diklik
        let id          = $(this).data('id');
        let site_id     = $(this).data('site_id');
        let nama_lokasi = $(this).data('nama_lokasi');
        let provinsi    = $(this).data('provinsi');
        let kabupaten   = $(this).data('kabupaten');
        let status      = $(this).data('status');
        let week        = $(this).data('week');
        let kategori    = $(this).data('kategori');
        // 2. Penanganan khusus untuk Tanggal
        // Input type="date" HANYA menerima format YYYY-MM-DD
        let rawDate     = $(this).data('date'); 
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
        // 4. Set action URL form secara dinamis ke route update
        // Pastikan route di web.php adalah /PMLiberta/{id}
        $('#formEdit').attr('action', '/PMLiberta/' + id);
        // 5. Tampilkan modal
        // Menggunakan cara Bootstrap 5 yang lebih stabil
        var editModal = new bootstrap.Modal(document.getElementById('modalEdit'));
        editModal.show();
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
$(document).ready(function() {
    $(document).on('click', '.btn-delete-trigger', function(e) {
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
    document.getElementById('edit_date').addEventListener('change', function() {
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
<!-- SCRIPT UNTUK SUBMIT FORM PENCARIAN OTOMATIS SETELAH USER BERHENTI MENGETIK SELAMA 500MS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timer;
        searchInput.addEventListener('input', function() {
            // Hapus timer sebelumnya setiap kali user mengetik huruf baru
            clearTimeout(timer);
            // Set timer baru
            timer = setTimeout(() => {
                // Kirim form secara otomatis
                searchForm.submit();
            }, 100); // Jeda waktu dalam milidetik
        });
        // Trik agar kursor tetap di akhir teks setelah halaman refresh
        if (searchInput.value.length > 0) {
            searchInput.focus();
            const val = searchInput.value;
            searchInput.value = '';
            searchInput.value = val;
        }
    });
</script>
</body>
</html>

