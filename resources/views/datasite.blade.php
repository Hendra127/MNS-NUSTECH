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
    <title>Database All Sites</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
        }

        /* Remote icon dark mode — sama dengan edit & hapus */
        .btn-remote-action {
            color: #000;
        }

        [data-bs-theme="dark"] .btn-remote-action {
            color: #7ec8e3 !important;
            /* cyan-teal sesuai ikon edit di dark mode */
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
        /* Sticky Right Columns */
        .col-sticky-right {
            position: sticky !important;
            z-index: 10 !important;
            background-color: #ffffff !important;
            box-shadow: -2px 0 5px rgba(0,0,0,0.08);
        }

        thead th.col-sticky-right {
            z-index: 30 !important;
            background-color: #f5f6fa !important;
        }

        tbody tr:nth-child(even) .col-sticky-right {
            background-color: #fafbfc !important;
        }

        tbody tr:hover .col-sticky-right {
            background-color: #f0f5fb !important;
        }

        .col-ip-modem { right: 480px; min-width: 120px; }
        .col-ip-router { right: 360px; min-width: 120px; }
        .col-ip-ap1 { right: 240px; min-width: 120px; }
        .col-ip-ap2 { right: 120px; min-width: 120px; }
        .col-aksi { right: 0; min-width: 120px; text-align: center !important; }

        @media (max-width: 768px) {
            .col-sticky-right {
                position: static !important;
                right: auto !important;
                box-shadow: none !important;
            }
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer;">
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
        <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}"
            style="text-decoration: none;">Correctiv Maintenance</a>
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}"
            style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}"
            style="text-decoration: none;">PM Summary</a>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Add" data-toggle="modal"
                        data-target="#modalSite" onclick="addSite()"></button>
                    <form action="{{ route('sites.import') }}" method="POST" enctype="multipart/form-data" id="importForm"
                        class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" accept=".xlsx, .xls, .csv"
                            onchange="this.form.submit()">
                        <button type="button" class="btn-action bi bi-upload" title="Upload"
                            onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
                <a href="{{ route('sites.export', request()->all()) }}" class="btn-action bi bi-download"
                    title="Download"
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('datasite') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="search-form">
                    <div class="col-12 col-md-auto">
                        <select name="tipe" class="form-select form-select-sm w-100">
                            <option value="">Semua Tipe</option>
                            <option value="BARANG MILIK NEGARA (BMN)" {{ request('tipe') == 'BARANG MILIK NEGARA (BMN)' ? 'selected' : '' }}>BMN</option>
                            <option value="SEWA LAYANAN" {{ request('tipe') == 'SEWA LAYANAN' ? 'selected' : '' }}>SL
                            </option>
                        </select>
                    </div>
                    <div class="col-12 col-md-auto">
                        <select name="provinsi" id="filter-provinsi" class="form-select form-select-sm w-100">
                            <option value="">Provinsi...</option>
                            @foreach($provinsiList as $p)
                                <option value="{{ $p }}" {{ request('provinsi') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-auto">
                        <select name="kab" id="filter-kab" class="form-select form-select-sm w-100">
                            <option value="">Kabupaten...</option>
                            @if(request('provinsi') && isset($provinsiKabMap[request('provinsi')]))
                                @foreach($provinsiKabMap[request('provinsi')] as $k)
                                    <option value="{{ $k }}" {{ request('kab') == $k ? 'selected' : '' }}>{{ $k }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('datasite') }}"
                            class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                            title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" id="search-input" name="search" placeholder="Search..."
                                value="{{ request('search') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
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
                        <th class="sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-sitename">SITENAME</th>
                        <th>TIPE</th>
                        <th>BATCH</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KECAMATAN</th>
                        <th>KELURAHAN</th>
                        <th>ALAMAT LOKASI</th>
                        <th>NAMA PIC</th>
                        <th>NOMOR PIC</th>
                        <th>SUMBER LISTRIK</th>
                        <th>GATEWAY AREA</th>
                        <th>BEAM</th>
                        <th>HUB</th>
                        <th>KODEFIKASI</th>
                        <th>SN ANTENA</th>
                        <th>SN MODEM</th>
                        <th>SN ROUTER</th>
                        <th>SN AP1</th>
                        <th>SN AP2</th>
                        <th>SN TRANSCIEVER</th>
                        <th>SN STABILIZER</th>
                        <th>SN RAK</th>
                        <th class="col-sticky-right col-ip-modem">IP MODEM</th>
                        <th class="col-sticky-right col-ip-router">IP ROUTER</th>
                        <th class="col-sticky-right col-ip-ap1">IP AP1</th>
                        <th class="col-sticky-right col-ip-ap2">IP AP2</th>
                        <th>EXPECTED SQF</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="col-sticky-right col-aksi">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($sites as $index => $site)
                        <tr>
                            <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                            <td class="sticky-col col-site-id">{{ $site->site_id }}</td>
                            <td class="sticky-col col-sitename">{{ $site->sitename }}</td>
                            <td>{{ $site->tipe }}</td>
                            <td>{{ $site->batch }}</td>
                            <td>{{ $site->latitude }}</td>
                            <td>{{ $site->longitude }}</td>
                            <td>{{ $site->provinsi }}</td>
                            <td>{{ $site->kab }}</td>
                            <td>{{ $site->kecamatan }}</td>
                            <td>{{ $site->kelurahan }}</td>
                            <td>{{ $site->alamat_lokasi }}</td>
                            <td>{{ $site->nama_pic }}</td>
                            <td>{{ $site->nomor_pic }}</td>
                            <td>{{ $site->sumber_listrik }}</td>
                            <td>{{ $site->gateway_area }}</td>
                            <td>{{ $site->beam }}</td>
                            <td>{{ $site->hub }}</td>
                            <td>{{ $site->kodefikasi }}</td>
                            <td>{{ $site->sn_antena }}</td>
                            <td>{{ $site->sn_modem }}</td>
                            <td>{{ $site->sn_router }}</td>
                            <td>{{ $site->sn_ap1 }}</td>
                            <td>{{ $site->sn_ap2 }}</td>
                            <td>{{ $site->sn_tranciever }}</td>
                            <td>{{ $site->sn_stabilizer }}</td>
                            <td>{{ $site->sn_rak }}</td>
                            <td class="col-sticky-right col-ip-modem">{{ $site->ip_modem }}</td>
                            <td class="col-sticky-right col-ip-router">{{ $site->ip_router }}</td>
                            <td class="col-sticky-right col-ip-ap1">{{ $site->ip_ap1 }}</td>
                            <td class="col-sticky-right col-ip-ap2">{{ $site->ip_ap2 }}</td>
                            <td>{{ $site->expected_sqf }}</td>
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <td class="col-sticky-right col-aksi">
                                    <div class="btn-group" role="group">
                                        {{-- JANGAN pakai <a> ke route edit, tapi pakai button onclick --}}
                                            <button type="button" class="btn btn-sm bi bi-pencil"
                                                onclick="editSite({{ $site->toJson() }})"></button>
                                            @if($site->ip_router && in_array(auth()->user()->role ?? '', ['admin', 'superadmin']))
                                                <button type="button" class="btn btn-sm btn-remote-action" title="Remote Mikrotik"
                                                    onclick="remoteMikrotik('{{ $site->ip_router }}', '{{ $site->tipe }}', '{{ $site->sitename }}', '{{ $site->site_id }}')">
                                                    <i class="bi bi-broadcast"></i>
                                                </button>
                                            @endif
                                            <form action="{{ route('sites.destroy', $site->site_id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm bi bi-trash btn-delete"
                                                    data-name="{{ $site->sitename }}">
                                                </button>
                                            </form>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="33" class="text-center">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $sites->firstItem() ?? 0 }} to {{ $sites->lastItem() ?? 0 }}
                of&nbsp;<strong>{{ $sites->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $sites->links() }}
            </nav>
        </div>
    </div>
    <script>
        @if(session('success'))
                    < div class="alert alert-success mt-2" >
                {{ session('success') }}
            </div >
        @endif
            @if($errors->any())
                        < div class="alert alert-danger mt-2" >
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                </div >
            @endif
    </script>
    <!-- MODAL ADD DATA -->
    <div class="modal fade" id="modalSite" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header text-white d-flex justify-content-center position-relative"
                    style="background-color: #071152;">
                    <h5 class="modal-title w-100 text-center" id="modalTitle">Form Data Site</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formSite" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs mb-3" id="siteTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1">General</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2">Lokasi & PIC</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab3">Hardware SN</a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab4">Network</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="tab1">
                                <div class="row">
                                    <div class="col-md-4"><label>SITE ID</label><input type="text" name="site_id"
                                            id="site_id" class="form-control mb-2" required></div>
                                    <div class="col-md-4"><label>SITE NAME</label><input type="text" name="sitename"
                                            id="sitename" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>TIPE</label><input type="text" name="tipe" id="tipe"
                                            class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>BATCH</label><input type="text" name="batch" id="batch"
                                            class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>KODEFIKASI</label><input type="text" name="kodefikasi"
                                            id="kodefikasi" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SUMBER LISTRIK</label><input type="text"
                                            name="sumber_listrik" id="sumber_listrik" class="form-control mb-2"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab2">
                                <div class="row">
                                    <div class="col-md-3"><label>LATITUDE</label><input type="text" name="latitude"
                                            id="latitude" class="form-control mb-2"></div>
                                    <div class="col-md-3"><label>LONGITUDE</label><input type="text" name="longitude"
                                            id="longitude" class="form-control mb-2"></div>
                                    <div class="col-md-3">
                                        <label>PROVINSI</label>
                                        <select name="provinsi" id="provinsi" class="form-select mb-2"
                                            onchange="updateKabupatenDropdown(this.value, 'kab')">
                                            <option value="">-- Pilih Provinsi --</option>
                                            @foreach($provinsiList as $p)
                                                <option value="{{ $p }}">{{ $p }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>KABUPATEN</label>
                                        <select name="kab" id="kab" class="form-select mb-2">
                                            <option value="">-- Pilih Kabupaten --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3"><label>KECAMATAN</label><input type="text" name="kecamatan"
                                            id="kecamatan" class="form-control mb-2"></div>
                                    <div class="col-md-3"><label>KELURAHAN</label><input type="text" name="kelurahan"
                                            id="kelurahan" class="form-control mb-2"></div>
                                    <div class="col-md-6"><label>ALAMAT LOKASI</label><input type="text"
                                            name="alamat_lokasi" id="alamat_lokasi" class="form-control mb-2"></div>
                                    <div class="col-md-6"><label>NAMA PIC</label><input type="text" name="nama_pic"
                                            id="nama_pic" class="form-control mb-2"></div>
                                    <div class="col-md-6"><label>NOMOR PIC</label><input type="text" name="nomor_pic"
                                            id="nomor_pic" class="form-control mb-2"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab3">
                                <div class="row">
                                    <div class="col-md-4"><label>SN ANTENA</label><input type="text" name="sn_antena"
                                            id="sn_antena" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN MODEM</label><input type="text" name="sn_modem"
                                            id="sn_modem" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN ROUTER</label><input type="text" name="sn_router"
                                            id="sn_router" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN AP1</label><input type="text" name="sn_ap1"
                                            id="sn_ap1" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN AP2</label><input type="text" name="sn_ap2"
                                            id="sn_ap2" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN TRANSCIEVER</label><input type="text"
                                            name="sn_tranciever" id="sn_tranciever" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN STABILIZER</label><input type="text"
                                            name="sn_stabilizer" id="sn_stabilizer" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>SN RAK</label><input type="text" name="sn_rak"
                                            id="sn_rak" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>HUB</label><input type="text" name="hub" id="hub"
                                            class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>BEAM</label><input type="text" name="beam" id="beam"
                                            class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>GATEWAY AREA</label><input type="text"
                                            name="gateway_area" id="gateway_area" class="form-control mb-2"></div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab4">
                                <div class="row">
                                    <div class="col-md-3"><label>IP MODEM</label><input type="text" name="ip_modem"
                                            id="ip_modem" class="form-control mb-2"></div>
                                    <div class="col-md-3"><label>IP ROUTER</label><input type="text" name="ip_router"
                                            id="ip_router" class="form-control mb-2"></div>
                                    <div class="col-md-3"><label>IP AP1</label><input type="text" name="ip_ap1"
                                            id="ip_ap1" class="form-control mb-2"></div>
                                    <div class="col-md-3"><label>IP AP2</label><input type="text" name="ip_ap2"
                                            id="ip_ap2" class="form-control mb-2"></div>
                                    <div class="col-md-4"><label>EXPECTED SQF</label><input type="text"
                                            name="expected_sqf" id="expected_sqf" class="form-control mb-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Script untuk handling modal dan SweetAlert --}}
    <script>
            $(document).ready(function () {
                // PERBAIKAN: SweetAlert Session (Tanpa HTML di dalam script)
                @if(session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                @endif
                @if($errors->any())
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Input',
                        text: "{{ $errors->first() }}"
                    });
                @endif
    });
        // Mapping data dari controller
        const provinsiKabMap = @json($provinsiKabMap);

        function updateKabupatenDropdown(provinsi, targetId, selectedKab = '') {
            const kabDropdown = $(`#${targetId}`);
            kabDropdown.empty();
            kabDropdown.append('<option value="">-- Pilih Kabupaten --</option>');

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

        // Fungsi Tambah Data
        function addSite() {
            $('#modalTitle').text('Tambah Data Site Baru');
            $('#formSite').attr('action', "{{ route('sites.store') }}");
            $('#methodField').empty();
            $('#formSite')[0].reset();
            $('#kab').empty().append('<option value="">-- Pilih Kabupaten --</option>');
            $('#modalSite').modal('show');
        }
        // Fungsi Edit Data
        function editSite(data) {
            $('#modalTitle').text('Edit Site: ' + data.site_id);
            $('#formSite').attr('action', "/sites/" + data.site_id);
            $('#methodField').html('@method("PUT")');
            Object.keys(data).forEach(key => {
                if (key !== 'kab') { // Handle kab separately after provinsi is set
                    $(`#${key}`).val(data[key]);
                }
            });

            // Update kabupaten dropdown based on provinces and select correct value
            if (data.provinsi) {
                updateKabupatenDropdown(data.provinsi, 'kab', data.kab);
            }

            $('#modalSite').modal('show');
        }
    </script>
    {{-- Script untuk konfirmasi hapus dengan SweetAlert --}}
    <script>
        $(document).ready(function () {
            $('.btn-delete').on('click', function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                // Ambil nama dari atribut data-name
                let siteName = $(this).data('name');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    // Masukkan variabel siteName ke dalam teks
                    html: `Data site <b>${siteName}</b> akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    {{-- Script Remote Mikrotik --}}
    <script>
        // Daftar tunnel WireGuard dari config/wireguard.php
        const wgTunnels = @json($wgTunnels ?? []);

        function remoteMikrotik(ip, tipe, namaSite, siteCode) {
            // Tentukan kredensial berdasarkan kategori/tipe
            let username = 'admin';
            let password = 'SLAPRO2024'; // Default SL
            let tipeLabel = 'SEWA LAYANAN';

            if (tipe && (tipe.toUpperCase().includes('BMN') || tipe.toUpperCase().includes('BARANG MILIK NEGARA'))) {
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

            // Gunakan assign agar lebih reliabel dalam memicu protokol
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
                    source_page: 'datasite',
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
    </script>
</body>

</html>