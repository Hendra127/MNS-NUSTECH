<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spare Tracker</title>
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
        /* Mengatur padding pada semua sel tabel agar lebih rapat - Sesuai open.blade */
        .table-responsive-custom table thead th,
        .table-responsive-custom table tbody td {
            padding-top: 4px !important;
            padding-bottom: 4px !important;
            padding-left: 8px !important;
            padding-right: 8px !important;
            line-height: 1.2 !important;
            vertical-align: middle !important;
        }
        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
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
    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
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
            <form method="GET" action="{{ route('sparetracker') }}" class="search-form" id="filterForm">
                <div class="search-box">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i>
                    </button>
                    <input type="text" name="search" id="searchInput" placeholder="Search..." value="{{ request('search') }}">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
                <!-- Fields to keep filters active during search -->
                @if(request('kondisi')) <input type="hidden" name="kondisi" value="{{ request('kondisi') }}"> @endif
                @if(request('tgl_masuk_mulai')) <input type="hidden" name="tgl_masuk_mulai" value="{{ request('tgl_masuk_mulai') }}"> @endif
                @if(request('tgl_masuk_selesai')) <input type="hidden" name="tgl_masuk_selesai" value="{{ request('tgl_masuk_selesai') }}"> @endif
                @if(request('tgl_keluar_mulai')) <input type="hidden" name="tgl_keluar_mulai" value="{{ request('tgl_keluar_mulai') }}"> @endif
                @if(request('tgl_keluar_selesai')) <input type="hidden" name="tgl_keluar_selesai" value="{{ request('tgl_keluar_selesai') }}"> @endif
            </form>
            <!-- Modal Filter -->
            <div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title w-100 text-center fw-bold">Filter Data Spare Tracker</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="GET" action="{{ route('sparetracker') }}">
                            @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                            <div class="modal-body pt-3">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold label-blue">Kondisi</label>
                                        <select name="kondisi" class="form-select input-custom">
                                            <option value="">Semua Kondisi</option>
                                            <option value="BAIK" {{ request('kondisi') == 'BAIK' ? 'selected' : '' }}>BAIK</option>
                                            <option value="RUSAK" {{ request('kondisi') == 'RUSAK' ? 'selected' : '' }}>RUSAK</option>
                                            <option value="BARU" {{ request('kondisi') == 'BARU' ? 'selected' : '' }}>BARU</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold label-blue">Tgl Masuk Dari</label>
                                        <input type="date" name="tgl_masuk_mulai" class="form-control input-custom" value="{{ request('tgl_masuk_mulai') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold label-blue">Sampai Tgl</label>
                                        <input type="date" name="tgl_masuk_selesai" class="form-control input-custom" value="{{ request('tgl_masuk_selesai') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold label-blue">Tgl Keluar Dari</label>
                                        <input type="date" name="tgl_keluar_mulai" class="form-control input-custom" value="{{ request('tgl_keluar_mulai') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold label-blue">Sampai Tgl</label>
                                        <input type="date" name="tgl_keluar_selesai" class="form-control input-custom" value="{{ request('tgl_keluar_selesai') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <a href="{{ route('sparetracker') }}" class="btn btn-light border px-4 rounded-3">Reset</a>
                                <button type="submit" class="btn btn-primary px-4 rounded-3">Terapkan Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
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
        <div class="table-responsive-custom" style="overflow-x: auto; max-width: 100%;">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>NO</th>
                    <th>SN</th>
                    <th>NAMA PERANGKAT</th>
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
                        <th>AKSI</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->sn }}</td>
                    <td>{{ $item->nama_perangkat }}</td>
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
                    <td class="text-center">
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
                    </td>
                </tr>
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
    </div>
</div>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data spare part akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
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
    // Script pencarian otomatis
    let timeout = null;
    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('filterForm');
    if(searchInput && filterForm) {
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                filterForm.submit();
            }, 500); 
        });
        // Fokus kursor ke akhir teks
        searchInput.focus();
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;
    }
</script>
</body>
</html>

