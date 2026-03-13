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
    <title>Correctiv Maintenance</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
            .search-form, .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
            }
        }
        .filter-btn {
            background: none;
            border: none;
            padding-left: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
        }
        /* Select2 Custom Styling to match User Design */
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
            border: 1px solid #7cb5f9 !important; /* Blue border like image */
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
        /* STICKY COLUMNS CSS */
        .table-responsive-custom {
            overflow-x: auto;
            max-width: 100%;
            position: relative;
        }
        .sticky-col {
            position: sticky !important;
            background-color: white !important; /* Prevents overlap transparency */
            z-index: 5;
            border-right: 1px solid #dee2e6 !important;
        }
        thead th.sticky-col {
            z-index: 10 !important; /* Higher than body sticky columns */
            background-color: #f8f9fa !important; /* Standard header bg */
        }
        /* specific positions */
        .col-no {
            left: 0;
            min-width: 50px;
            max-width: 50px;
        }
        .col-site-id {
            left: 50px;
            min-width: 100px;
            max-width: 100px;
        }
        .col-nama_site {
            left: 150px;
            min-width: 200px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        /* Shadow effect on the last sticky column */
        th.col-nama_site, td.col-nama_site {
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
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
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none;">Summary PM</a>
    </div>
<!-- CARD -->
<div class="card">
    <div class="card-header">
        <div class="actions">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <!-- tombol plus (Add) -->
                <button type="button"
                        class="btn-action bi bi-plus"
                        data-bs-toggle="modal"
                        data-bs-target="#modalLaporanPM"
                        title="Tambah Data">
                </button>
                <!-- tombol upload (Import) -->
                <button type="button" 
                        class="btn-action bi bi-upload" 
                        title="Upload Data" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalImportLaporan">
                </button>
            @endif
            <!-- tombol download (Export) -->
            <a href="{{ route('laporancm.export') }}" 
               class="btn-action bi bi-download" 
               title="Download Excel"
               style="text-decoration: none;">
            </a>
        </div>
        <!-- search -->
        <form method="GET" action="{{ route('laporancm') }}" class="search-form" id="searchForm">
            <div class="search-box d-flex align-items-center">
                <!-- tombol filter -->
                <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter">
                    <i class="bi bi-sliders2"></i>
                </button>
                <input type="text" name="search" id="searchInput" placeholder="Search..." value="{{ request('search') }}" style="flex-grow: 1; border: none; outline: none; background: transparent; padding-left: 15px;">
                <button type="submit" class="search-btn">🔍</button>
            </div>
        </form>
    </div>
    <div class="table-responsive-custom" style="overflow-x: auto; max-width: 100%;">
        <table class="table table-bordered">
            <thead>
                <tr>
                <th class="sticky-col col-no">NO</th>
                <th class="sticky-col col-site-id">SITE ID</th>
                <th class="sticky-col col-nama_site">NAMA SITE</th>
                <th>TANGGAL ON SITE</th>
                <th>NAMA TEKNISI</th>
                <th>Correctiv Maintenance/PM</th>
                <th>NOTES</th>
                <th>BIAYA TEKNISI</th>
                <th>FOTO ON SITE</th>
                <th>BUKTI TRANSFER</th>
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <th>AKSI</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse($data as $item)
                <tr class="text-center">
                    <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                    <td class="sticky-col col-site-id">{{ $item->site_id }}</td>
                    <td class="sticky-col col-nama_site">{{ $item->nama_site ?? '-' }}</td>
                    <td class="text-center">{{ $item->tanggal_on_site ?? '-' }}</td>
                    <td>{{ $item->nama_teknisi ?? '-' }}</td>
                    <td>{{ $item->laporan_cm ?? '-' }}</td>
                    <td>{{ $item->notes ?? '-' }}</td>
                    <td>{{ $item->biaya_teknisi ? 'Rp ' . number_format($item->biaya_teknisi, 0, ',', '.') : '-' }}</td>
                    <td>
                        @if($item->foto_on_site)
                            <a href="{{ Storage::url($item->foto_on_site) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="bi bi-image"></i> Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($item->bukti_transfer)
                            <a href="{{ Storage::url($item->bukti_transfer) }}" target="_blank" class="btn btn-sm btn-info text-white"><i class="bi bi-file-earmark-text"></i> Lihat</a>
                        @else
                            -
                        @endif
                    </td>
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <td class="text-center">
                        <button class="btn btn-sm btn-edit" 
                                data-bs-toggle="modal" 
                                data-bs-target="#modalEditLaporanPM"
                                data-id="{{ $item->id }}"
                                data-tanggal_on_site="{{ $item->tanggal_on_site }}"
                                data-site_id="{{ $item->site_id }}"
                                data-nama_site="{{ $item->nama_site }}"
                                data-nama_teknisi="{{ $item->nama_teknisi }}"
                                data-laporan_cm="{{ $item->laporan_cm }}"
                                data-notes="{{ $item->notes }}"
                                data-biaya_teknisi="{{ $item->biaya_teknisi }}"
                                data-foto_on_site="{{ $item->foto_on_site }}"
                                data-bukti_transfer="{{ $item->bukti_transfer }}">
                            <i class="bi bi-pencil" style="color: #0c2484;"></i>
                        </button>
                        <button type="button" class="btn btn-sm" 
                            onclick="confirmDelete('{{ $item->id }}', '{{ $item->nama_site }}')">
                        <i class="bi bi-trash" style="color: #dc3545;"></i></button>
                        <form id="delete-form-{{ $item->id }}" action="{{ route('laporancm.destroy', $item->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="14" class="text-center p-3">
                        Showing 0 of 0 results
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<!-- ===================== MODAL TAMBAH LAPORAN PM ===================== -->
<div class="modal fade" id="modalLaporanPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header border-0 px-4 pt-4 " style="background-color: #071152; color: white;">
                <h4 class="modal-title fw-bold text-center w-100">Tambah Data Correctiv Maintenance</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Body -->
            <div class="modal-body px-4 pb-4">
                <form action="{{ route('laporancm.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- Tanggal On Site -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal On Site</label>
                            <input type="date" name="tanggal_on_site" id="tanggal_on_site"
                                class="form-control form-control-lg rounded-3" required>
                        </div>
                        <!-- Nama Site -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Site</label>
                            <select name="site_id" id="siteSelect" class="form-select form-select-lg rounded-3 select2-enable" required>
                                <option value="">Pilih atau cari Nama Site</option>
                                @foreach($sites as $s)
                                    <option value="{{ $s->site_id }}"
                                            data-siteid="{{ $s->site_id }}"
                                            data-lokasi="{{ $s->sitename }}"
                                            data-kab="{{ $s->kabupaten ?? $s->kab ?? '' }}"
                                            data-prov="{{ $s->provinsi ?? '' }}">
                                        {{ $s->site_id }} - {{ $s->sitename }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Site ID auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Site ID</label>
                            <input type="text" id="siteIdView"
                                   class="form-control form-control-lg rounded-3 bg-light"
                                   placeholder="Site ID" readonly>
                        </div>
                        <!-- Nama Site auto -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Site</label>
                            <input type="text" name="nama_site" id="namaSiteView" 
                                class="form-control form-control-lg rounded-3 bg-light" 
                                placeholder="Nama Site akan terisi otomatis" readonly>
                        </div>
                        <!-- Teknisi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Teknisi</label>
                            <input type="text" name="nama_teknisi"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Nama Teknisi" required>
                        </div>
                        <!-- Laporan CM/PM -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correctiv Maintenance/PM</label>
                            <input type="text" name="laporan_cm"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Nomor atau Deskripsi Laporan">
                        </div>
                        <!-- Notes -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Notes</label>
                            <input type="text" name="notes"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Notes atau Kendala">
                        </div>
                        <!-- Biaya Teknisi -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Biaya Teknisi</label>
                            <input type="number" name="biaya_teknisi"
                                   class="form-control form-control-lg rounded-3"
                                   placeholder="Contoh: 150000">
                        </div>
                        <!-- Foto On Site (file upload) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Foto On Site</label>
                            <input type="file" name="foto_on_site"
                                   accept="image/*,application/pdf"
                                   class="form-control form-control-lg rounded-3">
                        </div>
                        <!-- Bukti Transfer (file upload) -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bukti Transfer</label>
                            <input type="file" name="bukti_transfer"
                                   accept="image/*,application/pdf"
                                   class="form-control form-control-lg rounded-3">
                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm">
                            SIMPAN
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3"
                                data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ===================== MODAL EDIT LAPORAN CM ===================== --}}
<div class="modal fade" id="modalEditLaporanPM" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header border-0 px-4 pt-4" style="background-color: #071152; color: white;">
                <h4 class="modal-title fw-bold text-center w-100">Edit Data Correctiv Maintenance</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form id="formEditLaporan" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Site ID</label>
                            <input type="text" id="edit_site_id" name="site_id" class="form-control bg-light" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Site</label>
                            <input type="text" id="edit_nama_site" name="nama_site" class="form-control bg-light" readonly>
                        </div>
                        <hr class="my-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal On Site</label>
                            <input type="date" name="tanggal_on_site" id="edit_tanggal_on_site" class="form-control form-control-lg rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Teknisi</label>
                            <input type="text" name="nama_teknisi" id="edit_nama_teknisi" class="form-control form-control-lg rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Correctiv Maintenance/PM</label>
                            <input type="text" name="laporan_cm" id="edit_laporan_cm" class="form-control form-control-lg rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Notes</label>
                            <input type="text" name="notes" id="edit_notes" class="form-control form-control-lg rounded-3">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Biaya Teknisi</label>
                            <input type="number" name="biaya_teknisi" id="edit_biaya_teknisi" class="form-control form-control-lg rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Update Foto On Site (Opsional)</label>
                            <input type="file" name="foto_on_site_update" accept="image/*,application/pdf" class="form-control form-control-lg rounded-3">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Update Bukti Transfer (Opsional)</label>
                            <input type="file" name="bukti_transfer_update" accept="image/*,application/pdf" class="form-control form-control-lg rounded-3">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm" style="background-color: #0c2484 !important;">
                            UPDATE DATA
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3" data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ===================== MODAL IMPORT LAPORAN CM ===================== --}}
<div class="modal fade" id="modalImportLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header border-0 px-4 pt-4" style="background-color: #071152; color: white;">
                <h4 class="modal-title fw-bold text-center w-100">Import Data Correctiv Maintenance</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-4">
                <form action="{{ route('laporancm.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pilih File Excel (.xlsx, .xls)</label>
                        <input type="file" name="file" class="form-control form-control-lg rounded-3" accept=".xlsx, .xls" required>
                    </div>
                    <div class="d-flex justify-content-end gap-3">
                        <button type="submit" class="btn btn-success btn-lg px-5 rounded-3 shadow-sm">
                            IMPORT
                        </button>
                        <button type="button" class="btn btn-secondary btn-lg px-5 rounded-3" data-bs-dismiss="modal">
                            BATAL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- ===================== MODAL FILTER LAPORAN CM ===================== --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg rounded-4 border-0">
            <div class="modal-header border-0 px-4 pt-4" style="background-color: #071152; color: white;">
                <h5 class="modal-title fw-bold text-center w-100">Filter Data Correctiv Maintenance</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('laporancm') }}">
                <div class="modal-body px-4 pb-4">
                    <div class="row g-3">
                        <!-- Laporan CM Dropdown -->
                        <div class="col-12">
                            <label class="form-label small fw-bold">Correctiv Maintenance</label>
                            <select name="laporan_cm" class="form-select rounded-3">
                                <option value="">Semua Laporan</option>
                                @foreach($uniqueReports as $report)
                                    <option value="{{ $report }}" {{ request('laporan_cm') == $report ? 'selected' : '' }}>
                                        {{ $report }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Date Range -->
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Dari Tanggal</label>
                            <input type="date" name="tgl_mulai" class="form-control rounded-3" value="{{ request('tgl_mulai') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Sampai Tanggal</label>
                            <input type="date" name="tgl_selesai" class="form-control rounded-3" value="{{ request('tgl_selesai') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <a href="{{ route('laporancm') }}" class="btn btn-light border px-4 rounded-3">Reset</a>
                    <button type="submit" class="btn btn-primary px-4 rounded-3" style="background-color: #071152; border: none;">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Bootstrap JS (WAJIB biar modal jalan) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Script untuk inisialisasi Select2 pada modal --}}
<script>
    $(document).ready(function() {
    // Inisialisasi Select2
    $('#siteSelect').select2({
        theme: 'bootstrap-5', // Menggunakan tema Bootstrap 5
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        dropdownParent: $('#modalLaporanPM') // PENTING: Jika di dalam modal, harus ada ini agar search box bisa diklik
    });
    // 2. Logika Auto-Fill saat Site dipilih (Select2 Version)
    $('#siteSelect').on('select2:select', function (e) {
        const data = e.params.data.element; // Ambil elemen option yang dipilih
        const siteId = data.getAttribute("data-siteid") || "";
        const lokasi = data.getAttribute("data-lokasi") || "";
        // Isi field otomatis
        $('#siteIdView').val(siteId);
        $('#namaSiteView').val(lokasi);
    });
});
</script>
{{-- Script untuk membuka modal edit dan mengisi data ke form edit --}}
<script>
$(document).on('click', '.btn-edit', function() {
    // Ambil semua data dari atribut tombol yang diklik
    const id = $(this).data('id');
    const tanggal_on_site = $(this).data('tanggal_on_site');
    const site_id = $(this).data('site_id');
    const nama_site = $(this).data('nama_site');
    const nama_teknisi = $(this).data('nama_teknisi');
    const laporan_cm = $(this).data('laporan_cm');
    const notes = $(this).data('notes');
    const biaya_teknisi = $(this).data('biaya_teknisi');
    // Masukkan ke dalam field modal edit
    $('#edit_tanggal_on_site').val(tanggal_on_site);
    $('#edit_site_id').val(site_id);
    $('#edit_nama_site').val(nama_site);
    $('#edit_nama_teknisi').val(nama_teknisi);
    $('#edit_laporan_cm').val(laporan_cm);
    $('#edit_notes').val(notes);
    $('#edit_biaya_teknisi').val(biaya_teknisi);
    // Set Action URL Form
    $('#formEditLaporan').attr('action', '/laporancm/' + id);
});
</script>
{{-- Script untuk konfirmasi delete dengan SweetAlert2 --}}
<script>
function confirmDelete(id, lokasi) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        // Nama lokasi akan muncul di baris teks ini
        text: "Data Correctiv Maintenance untuk site " + lokasi + " akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0c2484',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 3000,
        showConfirmButton: false
    });
@endif
@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
    });
@endif
</script>
<!-- SCRIPT UNTUK SEARCH OTOMATIS -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchForm = document.getElementById('searchForm');
        let timer;
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    searchForm.submit();
                }, 500); // Jeda 500ms agar tidak terlalu berat
            });
            // Fokuskan kembali ke input setelah refresh dan taruh kursor di akhir
            if (searchInput.value.length > 0) {
                searchInput.focus();
                const val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }
        }
    });
</script>
</body>
</html>

