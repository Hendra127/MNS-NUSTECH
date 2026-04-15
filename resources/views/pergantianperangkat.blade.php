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
    <title>Pergantian Perangkat | Project Operational</title>
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

        .col-no { left: 0; min-width: 50px; }
        .col-site-id { left: 50px; min-width: 135px; }
        .col-nama_site { left: 185px; min-width: 250px; }
        
        /* Striped background for sticky columns */
        tbody tr:nth-child(even) .sticky-col {
            background-color: #fafbfc !important;
        }
        
        /* Hover effect */
        tbody tr:hover td {
            background-color: #f0f5fb !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}?v=1.2">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
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
        [data-bs-theme="dark"] .btn-filter-pill {
            background: linear-gradient(135deg, #1a6fc4, #0d5dbc);
        }
        .search-box {
            display: flex;
            align-items: center;
        }
        .search-box input {
            border: none;
            outline: none;
            padding: 10px;
            background: transparent;
            flex-grow: 1;
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
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary</a>
    </div>
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
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal" data-bs-target="#modalTambahPergantian"></button>
                    <form action="{{ route('pergantianperangkat.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" onchange="document.getElementById('importForm').submit();">
                        <button type="button" class="btn-action bi bi-upload" title="Upload Excel" onclick="document.getElementById('fileInput').click();"></button>
                    </form>
                @endif
                <a href="{{ route('pergantianperangkat.export') }}" class="btn-action bi bi-download" title="Download Excel" style="text-decoration: none;"></a>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('pergantianperangkat') }}" class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">
                    <div class="col-12 col-md-auto">
                        <select name="perangkat" class="form-select form-select-sm w-100">
                            <option value="">Semua Perangkat</option>
                            <option value="MODEM" {{ request('perangkat') == 'MODEM' ? 'selected' : '' }}>MODEM</option>
                            <option value="ROUTER" {{ request('perangkat') == 'ROUTER' ? 'selected' : '' }}>ROUTER</option>
                            <option value="SWITCH" {{ request('perangkat') == 'SWITCH' ? 'selected' : '' }}>SWITCH</option>
                            <option value="AP1" {{ request('perangkat') == 'AP1' ? 'selected' : '' }}>AP1</option>
                            <option value="AP2" {{ request('perangkat') == 'AP2' ? 'selected' : '' }}>AP2</option>
                            <option value="STAVOL" {{ request('perangkat') == 'STAVOL' ? 'selected' : '' }}>STAVOL</option>
                            <option value="LAINNYA" {{ request('perangkat') == 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
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
                        <a href="{{ route('pergantianperangkat') }}" class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100" title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" name="search" id="searchInput" placeholder="Search" value="{{ request('search') }}" style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive-custom">
            <table>
                <thead>
                    <tr class="thead-dark">
                        <th class="text-center sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_site">NAMA SITE</th>
                        <th>PERANGKAT</th>
                        <th>TANGGAL</th>
                        <th>SN LAMA</th>
                        <th>SN BARU</th>
                        <th>KETERANGAN</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="sticky-col-right">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($pergantian_data as $index => $item)
                    <tr>
                        <td class="text-center sticky-col col-no">{{ $index + 1 }}</td>
                        <td class="sticky-col col-site-id">{{ $item->site->site_id ?? '-' }}</td>
                        <td class="sticky-col col-nama_site">{{ $item->site->sitename ?? '-' }}</td>
                        <td>{{ $item->perangkat }}</td>
                        <td>{{ $item->tanggal_penggantian }}</td>
                        <td>{{ $item->sn_lama ?? '-' }}</td>
                        <td>{{ $item->sn_baru ?? '-' }}</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <td class="text-center sticky-col-right">
                            <div class="d-flex justify-content-center gap-1">
                                <button type="button" class="btn btn-sm bi bi-pencil" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalEditPergantian{{ $item->id }}"
                                        style="background: none; border: none; color: black; font-size: 1.1rem;"></button>
                                <form action="{{ route('pergantianperangkat.destroy', $item->id) }}" method="POST" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm bi bi-trash btn-delete" 
                                            data-perangkat="{{ $item->perangkat }}" 
                                            data-site="{{ $item->site->sitename ?? $item->site->site_id }}"
                                            style="background: none; border: none; color: black; font-size: 1.1rem;"></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="empty text-center">
                            Showing 0 of 0 results
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $pergantian_data->firstItem() ?? 0 }} to {{ $pergantian_data->lastItem() ?? 0 }} 
                of&nbsp;<strong>{{ $pergantian_data->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $pergantian_data->appends(request()->query())->links("pagination::bootstrap-5") }}
            </nav>
        </div>
    </div>

    <!-- Modal Tambah Pergantian -->
    <div class="modal fade" id="modalTambahPergantian" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pergantianperangkat.store') }}" method="POST">
                    @csrf
                    <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                        <h5 class="modal-title w-100 text-center">Tambah Log Pergantian</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold"><i class="bi bi-search me-1"></i>Cari Site (ID atau Nama)</label>
                            <input list="siteList" name="site_search" class="form-control" placeholder="Ketik untuk mencari site..." onchange="updateSiteId(this)">
                            <datalist id="siteList">
                                @foreach($sites as $site)
                                    <option value="{{ $site->site_id }} - {{ $site->sitename }}" data-id="{{ $site->id }}" data-siteid="{{ $site->site_id }}" data-sitename="{{ $site->sitename }}">
                                @endforeach
                            </datalist>
                            <input type="hidden" name="site_id" id="selected_site_id" required>
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Perangkat</label>
                                <select name="perangkat" class="form-select" required>
                                    <option value="" selected disabled>Pilih Perangkat</option>
                                    <option value="MODEM">MODEM</option>
                                    <option value="ROUTER">ROUTER</option>
                                    <option value="SWITCH">SWITCH</option>
                                    <option value="AP1">AP1</option>
                                    <option value="AP2">AP2</option>
                                    <option value="STAVOL">STAVOL</option>
                                    <option value="LAINNYA">LAINNYA</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" name="tanggal_penggantian" class="form-control" value="{{ date('Y-m-d') }}" required>
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
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Tambahkan keterangan jika ada..."></textarea>
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
    @foreach($pergantian_data as $item)
    <!-- Modal Edit Pergantian -->
    <div class="modal fade" id="modalEditPergantian{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pergantianperangkat.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                        <h5 class="modal-title w-100 text-center">Edit Log - {{ $item->site->sitename ?? $item->site->site_id }}</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Site (ID atau Nama)</label>
                            <input list="siteList" name="site_search" class="form-control" 
                                   value="{{ ($item->site->site_id ?? '') . ' - ' . ($item->site->sitename ?? '') }}"
                                   onchange="updateSiteIdEdit(this, {{ $item->id }})">
                            <input type="hidden" name="site_id" id="selected_site_id_edit_{{ $item->id }}" value="{{ $item->site_id }}" required>
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Perangkat</label>
                                <select name="perangkat" class="form-select" required>
                                    <option value="MODEM" {{ $item->perangkat == 'MODEM' ? 'selected' : '' }}>MODEM</option>
                                    <option value="ROUTER" {{ $item->perangkat == 'ROUTER' ? 'selected' : '' }}>ROUTER</option>
                                    <option value="SWITCH" {{ $item->perangkat == 'SWITCH' ? 'selected' : '' }}>SWITCH</option>
                                    <option value="AP1" {{ $item->perangkat == 'AP1' ? 'selected' : '' }}>AP1</option>
                                    <option value="AP2" {{ $item->perangkat == 'AP2' ? 'selected' : '' }}>AP2</option>
                                    <option value="STAVOL" {{ $item->perangkat == 'STAVOL' ? 'selected' : '' }}>STAVOL</option>
                                    <option value="LAINNYA" {{ $item->perangkat == 'LAINNYA' ? 'selected' : '' }}>LAINNYA</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal</label>
                                <input type="date" name="tanggal_penggantian" class="form-control" value="{{ $item->tanggal_penggantian }}" required>
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
                            <label class="form-label fw-bold">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="2">{{ $item->keterangan }}</textarea>
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
    @endforeach
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

