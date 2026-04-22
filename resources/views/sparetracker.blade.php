<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}?v=1.2">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Tracker | Project Operational</title>
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
        .col-sn { left: 50px; min-width: 150px; }
        .col-nama-perangkat { left: 200px; min-width: 250px; }
        
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .tabs-section {
            flex-wrap: wrap;
            gap: 10px;
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
        @media (max-width: 768px) {
            .tabs-section .ms-auto {
                width: 100%;
                margin-left: 0 !important;
                justify-content: flex-start;
                margin-top: 10px;
            }
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
        /* Sticky col shadow untuk kolom NAMA PERANGKAT */
        th.col-nama-perangkat, td.col-nama-perangkat {
            border-right: 2px solid #e8ecf0 !important;
            box-shadow: 2px 0 8px rgba(0,0,0,0.06) !important;
        }
        .col-sn {
            left: 50px;
            min-width: 130px;
        }
        .col-nama-perangkat {
            left: 180px;
            min-width: 160px;
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
            box-shadow: 0 2px 8px rgba(13,110,253,0.3);
        }
        .btn-filter-pill:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(13,110,253,0.4);
        }
        [data-bs-theme="dark"] .btn-filter-pill {
            background: linear-gradient(135deg, #1a6fc4, #0d5dbc);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Spare: <b>{{ $totalSpare }}</b></span>
            <span class="summary-badge text-success">Baik: <b>{{ $countBaik }}</b></span>
            <span class="summary-badge text-danger">Rusak: <b>{{ $countRusak }}</b></span>
            <span class="summary-badge text-primary">Baru: <b>{{ $countBaru }}</b></span>
        </div>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal" data-bs-target="#modalTambahSpare"></button>
                    <!-- Form Import -->
                    <form action="{{ route('sparetracker.import') }}" method="POST" enctype="multipart/form-data" id="importForm" class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" onchange="document.getElementById('importForm').submit();">
                        <button type="button" class="btn-action bi bi-upload" title="Upload" onclick="document.getElementById('fileInput').click();"></button>
                    </form>
                @endif
                <!-- Button Export -->
                <a href="{{ route('sparetracker.export') }}" class="btn-action bi bi-download" title="Download" style="text-decoration: none;"></a>
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('sparetracker') }}" class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">
                    <div class="col-12 col-md-auto">
                        <select name="kondisi" class="form-select form-select-sm w-100">
                            <option value="">Semua Kondisi</option>
                            <option value="BAIK" {{ request('kondisi') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
                            <option value="RUSAK" {{ request('kondisi') == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
                            <option value="BARU" {{ request('kondisi') == 'BARU' ? 'selected' : '' }}>BARU</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-auto">
                        <div class="d-flex align-items-center gap-1 w-100">
                            <input type="date" name="tgl_masuk_mulai" class="form-control form-control-sm w-100" value="{{ request('tgl_masuk_mulai') }}" title="Tgl Masuk Dari">
                            <input type="date" name="tgl_masuk_selesai" class="form-control form-control-sm w-100" value="{{ request('tgl_masuk_selesai') }}" title="Tgl Masuk Sampai">
                        </div>
                    </div>

                    <div class="col-12 col-md-auto">
                        <div class="d-flex align-items-center gap-1 w-100">
                            <input type="date" name="tgl_keluar_mulai" class="form-control form-control-sm w-100" value="{{ request('tgl_keluar_mulai') }}" title="Tgl Keluar Dari">
                            <input type="date" name="tgl_keluar_selesai" class="form-control form-control-sm w-100" value="{{ request('tgl_keluar_selesai') }}" title="Tgl Keluar Sampai">
                        </div>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('sparetracker') }}" class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100" title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" name="search" id="searchInput" placeholder="Search Data" value="{{ request('search') }}" style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal fade" id="modalTambahSpare" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152; border-radius: 15px 15px 0 0;">
                <h4 class="modal-title w-100 text-center fw-bold">Tambah Data Spare Tracker</h4>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form action="{{ route('sparetracker.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label label-blue">SN</label>
                            <input type="text" name="sn" class="form-control input-custom" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Nama Perangkat</label>
                            <input type="text" name="nama_perangkat" class="form-control input-custom">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label label-blue">Jenis</label>
                            <select name="jenis" class="form-select input-custom">
                                <option value="">-- Pilih --</option>
                                <option value="MODEM">MODEM</option>
                                <option value="ROUTER">ROUTER</option>
                                <option value="SWITCH">SWITCH</option>
                                <option value="AP1">AP1</option>
                                <option value="AP2">AP2</option>
                                <option value="STAVOL">STAVOL</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label label-blue">Type</label>
                            <input type="text" name="type" class="form-control input-custom">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label label-blue">Kondisi</label>
                            <select name="kondisi" class="form-select input-custom">
                                <option value="">-- Pilih --</option>
                                <option value="BAIK">BAIK</option>
                                <option value="RUSAK">RUSAK</option>
                                <option value="BARU">BARU</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Pengadaan By</label>
                            <input type="text" name="pengadaan_by" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi Asal</label>
                            <input type="text" name="lokasi_asal" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control input-custom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label label-blue">Bulan Masuk</label>
                            <input type="text" name="bulan_masuk" class="form-control input-custom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label label-blue">Tanggal Masuk</label>
                            <input type="date" name="tanggal_masuk" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Status Penggunaan</label>
                            <input type="text" name="status_penggunaan_sparepart" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Lokasi Realtime</label>
                            <input type="text" name="lokasi_realtime" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control input-custom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label label-blue">Bulan Keluar</label>
                            <input type="text" name="bulan_keluar" class="form-control input-custom">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label label-blue">Tanggal Keluar</label>
                            <input type="date" name="tanggal_keluar" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Layanan AI</label>
                            <input type="text" name="layanan_ai" class="form-control input-custom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label label-blue">Keterangan</label>
                            <textarea name="keterangan" rows="2" class="form-control input-custom"></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary px-4 rounded-3">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </div>
        <div class="table-responsive-custom">
        <table>
            <thead>
                <tr class="thead-dark">
                    <th class="text-center sticky-col col-no">NO</th>
                    <th class="sticky-col col-sn">SN</th>
                    <th class="sticky-col col-nama-perangkat">NAMA PERANGKAT</th>
                    <th>JENIS</th>
                    <th>TYPE</th>
                    <th>KONDISI</th>
                    <th>PENGADAAN BY</th>
                    <th>LOKASI ASAL</th>
                    <th>LOKASI</th>
                    <th>TANGGAL MASUK</th>
                    <th>TANGGAL KELUAR</th>
                    <th>STATUS PENGGUNAAN</th>
                    <th>LOKASI REALTIME</th>
                    <th>KABUPATEN</th>
                    <th>LAYANAN AI</th>
                    <th>KETERANGAN</th>
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <th class="sticky-col-right">AKSI</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($spare_data as $item)
                <tr>
                    <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                    <td class="sticky-col col-sn">{{ $item->sn }}</td>
                    <td class="sticky-col col-nama-perangkat">{{ $item->nama_perangkat }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->type }}</td>
                    <td class="text-center">
                        @if($item->kondisi == 'BAIK')
                            <span class="badge bg-success">BAIK</span>
                        @elseif($item->kondisi == 'RUSAK')
                            <span class="badge bg-danger">RUSAK</span>
                        @elseif($item->kondisi == 'BARU')
                            <span class="badge bg-primary">BARU</span>
                        @else
                            {{ $item->kondisi }}
                        @endif
                    </td>
                    <td>{{ $item->pengadaan_by }}</td>
                    <td>{{ $item->lokasi_asal }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->tanggal_masuk }}</td>
                    <td>{{ $item->tanggal_keluar }}</td>
                    <td>{{ $item->status_penggunaan_sparepart }}</td>
                    <td>{{ $item->lokasi_realtime }}</td>
                    <td>{{ $item->kabupaten }}</td>
                    <td>{{ $item->layanan_ai }}</td>
                    <td>{{ $item->keterangan }}</td>
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <td class="text-center sticky-col-right">
                        <div class="d-flex gap-2 justify-content-center align-items-center">
                            <button class="btn btn-sm bi bi-pencil text-dark p-0 border-0 shadow-none" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditSpare{{ $item->id }}"
                                    title="Edit"
                                    style="font-size: 1rem;">
                            </button>
                            <button class="btn btn-sm bi bi-trash text-dark p-0 border-0 shadow-none" 
                                    onclick="confirmDelete('{{ $item->id }}')"
                                    title="Hapus"
                                    style="font-size: 1rem;">
                            </button>
                        </div>
                    </td>
                    @endif
                </tr>
                        <!-- Modal Edit Spare -->
                        <div class="modal fade" id="modalEditSpare{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content rounded-4 border-0 shadow-lg text-start">
                                    <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152; border-radius: 15px 15px 0 0;">
                                        <h4 class="modal-title w-100 text-center fw-bold">Edit Data Spare Tracker</h4>
                                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body pt-3">
                                        <form action="{{ route('sparetracker.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">SN</label>
                                                    <input type="text" name="sn" class="form-control input-custom" value="{{ $item->sn }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Nama Perangkat</label>
                                                    <input type="text" name="nama_perangkat" class="form-control input-custom" value="{{ $item->nama_perangkat }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label label-blue">Jenis</label>
                                                    <select name="jenis" class="form-select input-custom">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach(['MODEM', 'ROUTER', 'SWITCH', 'AP1', 'AP2', 'STAVOL'] as $j)
                                                            <option value="{{ $j }}" {{ $item->jenis == $j ? 'selected' : '' }}>{{ $j }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label label-blue">Type</label>
                                                    <input type="text" name="type" class="form-control input-custom" value="{{ $item->type }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label label-blue">Kondisi</label>
                                                    <select name="kondisi" class="form-select input-custom">
                                                        <option value="">-- Pilih --</option>
                                                        @foreach(['BAIK', 'RUSAK', 'BARU'] as $k)
                                                            <option value="{{ $k }}" {{ $item->kondisi == $k ? 'selected' : '' }}>{{ $k }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Pengadaan By</label>
                                                    <input type="text" name="pengadaan_by" class="form-control input-custom" value="{{ $item->pengadaan_by }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Lokasi Asal</label>
                                                    <input type="text" name="lokasi_asal" class="form-control input-custom" value="{{ $item->lokasi_asal }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Lokasi</label>
                                                    <input type="text" name="lokasi" class="form-control input-custom" value="{{ $item->lokasi }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label label-blue">Bulan Masuk</label>
                                                    <input type="text" name="bulan_masuk" class="form-control input-custom" value="{{ $item->bulan_masuk }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label label-blue">Tanggal Masuk</label>
                                                    <input type="date" name="tanggal_masuk" class="form-control input-custom" value="{{ $item->tanggal_masuk }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Status Penggunaan</label>
                                                    <input type="text" name="status_penggunaan_sparepart" class="form-control input-custom" value="{{ $item->status_penggunaan_sparepart }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Lokasi Realtime</label>
                                                    <input type="text" name="lokasi_realtime" class="form-control input-custom" value="{{ $item->lokasi_realtime }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Kabupaten</label>
                                                    <input type="text" name="kabupaten" class="form-control input-custom" value="{{ $item->kabupaten }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label label-blue">Bulan Keluar</label>
                                                    <input type="text" name="bulan_keluar" class="form-control input-custom" value="{{ $item->bulan_keluar }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label label-blue">Tanggal Keluar</label>
                                                    <input type="date" name="tanggal_keluar" class="form-control input-custom" value="{{ $item->tanggal_keluar }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Layanan AI</label>
                                                    <input type="text" name="layanan_ai" class="form-control input-custom" value="{{ $item->layanan_ai }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label label-blue">Keterangan</label>
                                                    <textarea name="keterangan" rows="2" class="form-control input-custom">{{ $item->keterangan }}</textarea>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2 mt-4">
                                                <button type="button" class="btn btn-light px-4 rounded-3" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary px-4 rounded-3">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <form id="delete-form-{{ $item->id }}" action="{{ route('sparetracker.destroy', $item->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
                @endforeach
                <tr class="row-grand-total">
                    <td colspan="17" class="text-center">GRAND TOTAL: {{ $totalSpare }} Unit</td>
                </tr>
            </tbody>
        </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $spare_data->firstItem() ?? 0 }} to {{ $spare_data->lastItem() ?? 0 }} 
                of&nbsp;<strong>{{ $spare_data->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $spare_data->appends(request()->query())->links("pagination::bootstrap-5") }}
            </nav>
        </div>
    </div>
</div>
</body>
</html>

