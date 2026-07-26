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
    <title>CM Pengajuan | Project Operational</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tom Select (searchable dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom th {
            background-color: #f1f5f9;
            padding: 15px;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }

        .table-custom td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .table-custom tr:hover td {
            background-color: #f8fafc;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-premium {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            cursor: pointer;
            position: relative;
        }

        .btn-premium:hover {
            transform: scale(1.1) rotate(90deg);
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
            color: white;
        }

        .btn-premium i {
            font-size: 1.5rem;
        }

        .btn-premium::after {
            content: 'Buat Pengajuan';
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: #1f2937;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 10px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s;
            pointer-events: none;
        }

        .btn-premium:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) rotate(-90deg);
        }

        .btn-approve {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .btn-reject {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .workflow-step {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #cbd5e1;
        }

        .step-dot.active {
            background: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .step-dot.completed {
            background: #10b981;
        }

        .step-dot.rejected {
            background: #ef4444;
        }

        .site-list-compact {
            line-height: 1.1;
            font-size: 13px;
        }

        .site-item {
            margin-bottom: 1px;
        }

        .teknisi-info {
            line-height: 1.2;
        }

        .search-box {
            display: flex;
            align-items: center;
            font-size: 13px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
            height: 100%;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            padding: 5px;
            font-size: 13px;
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
        
        [data-bs-theme="dark"] .search-box {
            background: #2b3035;
            border-color: #495057;
        }
        [data-bs-theme="dark"] .search-box input {
            color: #f8f9fa;
        }
    </style>
    <style>
        /* Mobile & Desktop mode responsiveness */
        body {
            overflow-x: hidden;
        }
        
        .content-container {
            max-width: 100vw;
            box-sizing: border-box;
            overflow-x: hidden;
        }
        
        .table-responsive-custom {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            display: block;
        }
        
        .tabs-section {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            max-width: 100vw;
        }
        
        .tabs-section::-webkit-scrollbar {
            display: none;
        }
        
        .tabs-section .tab {
            white-space: nowrap;
            flex-shrink: 0;
        }
        
        @media (max-width: 768px) {
            .table-custom th,
            .table-custom td {
                padding: 10px;
            }
        }

        /* Dark Mode overrides for btn-outline-dark */
        [data-bs-theme="dark"] .btn-outline-dark {
            color: #f8f9fa;
            border-color: #f8f9fa;
        }
        [data-bs-theme="dark"] .btn-outline-dark:hover {
            color: #212529;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }
        
        @media (max-width: 768px) {
            .content-container {
                padding: 15px !important;
                margin: 10px !important;
                border-radius: 12px;
                width: calc(100vw - 20px);
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
                margin-right: 0;
            }
            .search-box input {
                width: 100%;
            }
            .btn-premium, .btn-action-premium {
                width: 100%;
                border-radius: 8px;
                height: 45px;
            }
            .btn-premium::after, .btn-action-premium::after {
                display: none !important;
            }
        }
    </style>
</head>

<body>
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
                            style="width: 100%; text-align: left; padding: 10px 15px; border: none; background: transparent; color: red; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;"
                            onmouseover="this.style.backgroundColor='#fff0f0'"
                            onmouseout="this.style.backgroundColor='transparent'">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ route('sparepart_needed') }}" class="tab">Pengajuan Perangkat</a>
        <a href="{{ route('csr.index') }}" class="tab">Pengajuan CSR</a>
        <a href="{{ route('cm.index') }}" class="tab active">Pengajuan CM</a>
    </div>

    <div class="content-container">
        {{-- ALERT MESSAGES --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Berhasil!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Gagal!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-circle-fill me-3 fs-4"></i>
                    <div>
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-1 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user', 'noc_leader']))
                    <button class="btn btn-primary text-white fw-bold d-flex align-items-center gap-2 rounded-pill px-4 py-2 mt-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahCm"
                        title="Buat Pengajuan Baru" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); border: none; transition: transform 0.2s; color: white !important;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="bi bi-plus-lg"></i> Buat Pengajuan
                    </button>
                @endif
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('cm.index') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">

                    <div class="col-12 col-md-auto">
                        <select name="status_pembayaran" class="form-select form-select-sm w-100" style="border-radius: 50px;">
                            <option value="">Semua Status Bayar</option>
                            <option value="belum_dibayar" {{ request('status_pembayaran') === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="dp_50" {{ request('status_pembayaran') === 'dp_50' ? 'selected' : '' }}>Sudah di DP 50%</option>
                            <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Sudah Lunas</option>
                        </select>
                    </div>
                    
                    <div class="col-12 col-md-auto">
                        <select name="status" class="form-select form-select-sm w-100" style="border-radius: 50px;">
                            <option value="">Semua Status</option>
                            <option value="pending_noc" {{ request('status') == 'pending_noc' ? 'selected' : '' }}>Pending NOC Leader</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Manager</option>
                            <option value="approved_manager" {{ request('status') == 'approved_manager' ? 'selected' : '' }}>Pending Accounting</option>
                            <option value="approved_accounting" {{ request('status') == 'approved_accounting' ? 'selected' : '' }}>Pending Direktur</option>
                            <option value="approved_direktur" {{ request('status') == 'approved_direktur' ? 'selected' : '' }}>Pending Penasihat</option>
                            <option value="approved_penasihat" {{ request('status') == 'approved_penasihat' ? 'selected' : '' }}>Selesai (Approved)</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('cm.index') }}"
                            class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                            style="padding: 8px 12px;"
                            title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" name="search" id="searchInput" placeholder="Cari No / Divisi / Site / Teknisi"
                                value="{{ request('search') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 10px;">
                            <button type="submit" class="search-btn" style="border: none; background: transparent;"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="tableCmContainer">
            <div class="table-responsive-custom">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th style="min-width: 150px;">Tanggal & Nomor</th>
                        <th style="min-width: 200px;">Site</th>
                        <th style="min-width: 180px;">Teknisi & Bank</th>
                        <th>Rincian Kebutuhan</th>
                        <th class="text-end" style="min-width: 130px;">Total Dana</th>
                        <th class="text-center" style="min-width: 150px;">Status Pembayaran</th>
                        <th class="text-center" style="min-width: 150px;">Progress Approval</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cmList as $cm)
                        @php
                            $statusColor = 'warning';
                            $statusLabel = 'Pending Manager';
                            $step = 0;

                            if ($cm->approval_status == 'approved_manager') {
                                $statusColor = 'info';
                                $statusLabel = 'Pending Accounting';
                                $step = 1;
                            } elseif ($cm->approval_status == 'approved_accounting') {
                                $statusColor = 'primary';
                                $statusLabel = 'Pending Direktur';
                                $step = 2;
                            } elseif ($cm->approval_status == 'approved_direktur') {
                                $statusColor = 'indigo';
                                $statusLabel = 'Pending Penasihat';
                                $step = 3;
                            } elseif ($cm->approval_status == 'approved_penasihat') {
                                $statusColor = 'success';
                                $statusLabel = 'Selesai (Approved)';
                                $step = 4;
                            } elseif ($cm->approval_status == 'rejected') {
                                $statusColor = 'danger';
                                $statusLabel = 'Ditolak';
                                $step = 0;
                            }
                        @endphp
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $cm->tempat_tanggal }}</div>
                                <div class="small text-muted">{{ $cm->nomor }}</div>
                            </td>
                            <td>
                                <div class="site-list-compact fw-bold text-dark">
                                    @php
                                        $rawSites = str_replace(["\r", "\n"], ',', $cm->nama_site);
                                        $siteArray = array_values(array_filter(array_map('trim', explode(',', $rawSites))));
                                    @endphp
                                    @if(count($siteArray) > 1)
                                        @foreach($siteArray as $index => $s)
                                            <div class="site-item">{{ $index + 1 }}. {{ preg_replace('/^[0-9]+\.\s*/', '', $s) }}
                                            </div>
                                        @endforeach
                                    @else
                                        {{ $cm->nama_site }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="teknisi-info">
                                    <div class="fw-bold text-dark" style="font-size: 13px;"><i class="bi bi-tools"></i>
                                        {{ $cm->nama_teknisi }}</div>
                                    @if($cm->bank)
                                        <div class="small text-primary mt-1" style="font-size: 11px;"><i class="bi bi-bank"></i>
                                            {{ $cm->bank }}</div>
                                        <div class="small text-muted" style="font-size: 11px;">{{ $cm->nomor_rekening }}</div>
                                    @endif
                                </div>
                            </td>
                            <td style="max-width: 300px;">
                                <div class="small text-dark text-truncate">{{ $cm->rincian_kebutuhan }}</div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($cm->total, 0, ',', '.') }}</div>
                            </td>
                            <td class="text-center">
                                @if($cm->status_pembayaran === 'lunas')
                                    <span class="badge bg-success" style="min-width: 85px; padding: 5px;">Lunas</span>
                                @elseif($cm->status_pembayaran === 'dp_50')
                                    <span class="badge bg-warning text-dark" style="min-width: 85px; padding: 5px;">DP 50%</span>
                                @else
                                    <span class="badge bg-danger" style="min-width: 85px; padding: 5px;">Belum Dibayar</span>
                                @endif

                                @if(in_array($cm->status_pembayaran, ['lunas', 'dp_50']) && ($cm->bukti_transfer || $cm->bukti_dp))
                                    <div class="mt-1">
                                        <button type="button"
                                            class="btn btn-sm btn-info text-white shadow-sm d-inline-flex align-items-center justify-content-center gap-1"
                                            style="font-size: 0.72rem; padding: 4px; border-radius: 6px; min-width: 85px;"
                                            title="Lihat Bukti Pembayaran"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalBuktiCm{{ $cm->id }}">
                                            <i class="bi bi-info-circle-fill"></i> Info
                                        </button>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge-status bg-{{ $statusColor }}-subtle text-{{ $statusColor }}">
                                    @if($cm->approval_status == 'approved_penasihat')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($cm->approval_status == 'rejected')
                                        <i class="bi bi-x-circle-fill"></i>
                                    @else
                                        <i class="bi bi-clock-history"></i>
                                    @endif
                                    {{ $statusLabel }}
                                </span>
                                <div class="workflow-step">
                                    @foreach(['NOC Leader', 'Manager', 'Accounting', 'Direktur', 'Penasihat'] as $idx => $label)
                                        <div class="step-item" title="{{ $label }}">
                                            <div
                                                class="step-dot 
                                                                {{ $cm->step > ($idx + 1) ? 'completed' : ($cm->approval_status == 'rejected' && $cm->rejected_by == $label ? 'rejected' : ($cm->step == ($idx + 1) ? 'active' : '')) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($cm->approval_status != 'approved_penasihat' && $cm->approval_status != 'rejected')
                                        @php
                                            $roleGate = [
                                                'pending_noc' => ['noc_leader'],
                                                'pending' => ['manager'],
                                                'approved_manager' => ['accounting'],
                                                'approved_accounting' => ['direktur'],
                                                'approved_direktur' => ['penasihat'],
                                            ];
                                            $allowedRoles = $roleGate[$cm->approval_status] ?? [];

                                            // Special check for Rossie Maulana Septian
                                            $isRossie = (auth()->user()->name === 'Rossie Maulana Septian, S.Kom');
                                            $canApprove = ($cm->user_id != auth()->id()) &&
                                                (in_array(auth()->user()->role, $allowedRoles) || ($cm->approval_status === 'pending_noc' && $isRossie));
                                        @endphp

                                        @if($canApprove)
                                            @if($cm->approval_status === 'approved_manager')
                                                {{-- Accounting: buka modal isi no_surat + catatan dulu --}}
                                                <button type="button" class="btn-approve"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalApproveAccCm{{ $cm->id }}"
                                                    title="Setujui &amp; Isi Catatan">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            @else
                                                <form action="{{ route('cm.approve', $cm->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-approve">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn-reject" data-bs-toggle="modal"
                                                data-bs-target="#modalReject{{ $cm->id }}">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    @endif

                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                        data-bs-target="#modalInfoCm{{ $cm->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    @php
                                        $isApprover = in_array(auth()->user()->role, ['manager', 'accounting', 'direktur', 'penasihat']);
                                        $canEdit = ($cm->approval_status == 'pending_noc' || $cm->approval_status == 'pending' || $cm->approval_status == 'rejected') && !$isApprover;
                                        $isAdmin = in_array(auth()->user()->role, ['noc_leader']);
                                    @endphp

                                    @if($canEdit || $isAdmin)
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#modalEditCm{{ $cm->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif

                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item" href="{{ route('cm.print', ['id' => $cm->id, 'with_ttd' => 1]) }}" target="_blank"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Cetak Full TTD</a></li>
                                            <li><a class="dropdown-item" href="{{ route('cm.print', ['id' => $cm->id, 'with_ttd' => 0]) }}" target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Tanpa TTD</a></li>
                                        </ul>
                                    </div>

                                    @if(auth()->user()->role === 'noc_leader')
                                        <form id="delete-form-cm-{{ $cm->id }}" action="{{ route('cm.destroy', $cm->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('delete-form-cm-{{ $cm->id }}')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Edit Catatan/Status khusus Accounting --}}
                                    @if(auth()->user()->role === 'accounting')
                                        <button type="button" class="btn btn-sm btn-outline-dark"
                                            data-bs-toggle="modal" data-bs-target="#modalNotesCm{{ $cm->id }}"
                                            title="Isi / Edit Catatan & Status">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                    {{-- Tombol Mark as Done (Direct Button) --}}
                                    @if((auth()->user()->role === 'noc_leader' || $cm->approval_status == 'approved_penasihat') && !$cm->is_clear)
                                        <form action="{{ url('/cm/mark-done/' . $cm->id) }}" method="POST" class="d-inline" id="formMarkDone{{ $cm->id }}">
                                            @csrf
                                            <button type="button" onclick="confirmMarkDone({{ $cm->id }})" class="btn btn-sm btn-outline-success d-inline-flex align-items-center" title="Tandai Selesai (DONE)">
                                                <i class="bi bi-check-circle-fill me-1"></i> DONE
                                            </button>
                                        </form>
                                    @elseif($cm->is_clear)
                                        <span class="badge border border-success text-success bg-transparent d-inline-flex align-items-center" style="font-size: 0.85rem; padding: 0.35rem 0.5rem;">
                                            <i class="bi bi-check-all me-1" style="font-size: 1rem;"></i> DONE
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Reject -->
                        <div class="modal fade" id="modalReject{{ $cm->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <form action="{{ route('cm.reject', $cm->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title fw-bold">Konfirmasi Penolakan</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label class="form-label fw-bold">Alasan Penolakan</label>
                                            <textarea name="rejection_reason" class="form-control" rows="3"
                                                required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Bukti Pembayaran CM (Dual Tab: DP & Lunas) --}}
                        @if(in_array($cm->status_pembayaran, ['lunas', 'dp_50']) && ($cm->bukti_transfer || $cm->bukti_dp))
                        <div class="modal fade" id="modalBuktiCm{{ $cm->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px; overflow: hidden;">
                                    <div class="modal-header text-white border-0 py-3"
                                        style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-cash-coin fs-5"></i>
                                            <div>
                                                <h6 class="modal-title fw-bold mb-0">Bukti Pembayaran</h6>
                                                <div style="font-size: 0.72rem; opacity: 0.85;">
                                                    CM #{{ $cm->nomor }} &bull;
                                                    @if($cm->status_pembayaran === 'lunas')
                                                        <span class="badge bg-success">Lunas</span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">DP 50%</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0" style="background: #f1f5f9;">
                                        {{-- Tab Navigation --}}
                                        @php
                                            $hasDp = !empty($cm->bukti_dp);
                                            $hasLunas = !empty($cm->bukti_transfer);
                                            $showTabs = $hasDp && $hasLunas;
                                        @endphp

                                        @if($showTabs)
                                        <ul class="nav nav-tabs nav-fill px-3 pt-3 border-0 gap-2" id="tabBuktiCm{{ $cm->id }}" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active fw-semibold d-flex align-items-center justify-content-center gap-1"
                                                    id="tab-dp-{{ $cm->id }}-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#tab-dp-{{ $cm->id }}"
                                                    type="button" role="tab"
                                                    style="border-radius: 10px; border: 2px solid #f59e0b; color:#d97706; font-size:0.82rem;">
                                                    <i class="bi bi-percent"></i> DP 50%
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fw-semibold d-flex align-items-center justify-content-center gap-1"
                                                    id="tab-lunas-{{ $cm->id }}-tab"
                                                    data-bs-toggle="tab"
                                                    data-bs-target="#tab-lunas-{{ $cm->id }}"
                                                    type="button" role="tab"
                                                    style="border-radius: 10px; border: 2px solid #10b981; color:#059669; font-size:0.82rem;">
                                                    <i class="bi bi-check-circle-fill"></i> Lunas
                                                </button>
                                            </li>
                                        </ul>
                                        @endif

                                        <div class="tab-content p-3" id="tabContentBuktiCm{{ $cm->id }}">
                                            {{-- Tab DP 50% --}}
                                            @if($hasDp)
                                            <div class="tab-pane fade {{ !$showTabs || $hasDp ? 'show active' : '' }}" id="tab-dp-{{ $cm->id }}" role="tabpanel">
                                                <div class="text-center mb-2">
                                                    <span class="badge bg-warning text-dark px-3 py-1" style="font-size:0.78rem;">
                                                        <i class="bi bi-percent me-1"></i>Bukti DP 50%
                                                    </span>
                                                </div>
                                                <div class="rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                                    <img src="{{ asset('storage_public/' . $cm->bukti_dp) }}"
                                                        alt="Bukti DP 50%"
                                                        class="w-100"
                                                        style="max-height: 400px; object-fit: contain; display: block;"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div class="align-items-center justify-content-center p-4 text-muted" style="display:none;">
                                                        <i class="bi bi-image-alt me-2 fs-4"></i> Gambar tidak ditemukan
                                                    </div>
                                                </div>
                                                <div class="mt-2 d-flex justify-content-end">
                                                    <a href="{{ asset('storage_public/' . $cm->bukti_dp) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1"
                                                        style="font-size: 0.75rem; border-radius: 8px;">
                                                        <i class="bi bi-box-arrow-up-right"></i> Buka
                                                    </a>
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Tab Lunas --}}
                                            @if($hasLunas)
                                            <div class="tab-pane fade {{ $showTabs ? '' : 'show active' }}" id="tab-lunas-{{ $cm->id }}" role="tabpanel">
                                                <div class="text-center mb-2">
                                                    <span class="badge bg-success px-3 py-1" style="font-size:0.78rem;">
                                                        <i class="bi bi-check-circle-fill me-1"></i>Bukti Lunas
                                                    </span>
                                                </div>
                                                <div class="rounded-3 overflow-hidden shadow-sm border" style="background: white;">
                                                    <img src="{{ asset('storage_public/' . $cm->bukti_transfer) }}"
                                                        alt="Bukti Lunas"
                                                        class="w-100"
                                                        style="max-height: 400px; object-fit: contain; display: block;"
                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div class="align-items-center justify-content-center p-4 text-muted" style="display:none;">
                                                        <i class="bi bi-image-alt me-2 fs-4"></i> Gambar tidak ditemukan
                                                    </div>
                                                </div>
                                                <div class="mt-2 d-flex justify-content-end">
                                                    <a href="{{ asset('storage_public/' . $cm->bukti_transfer) }}" target="_blank"
                                                        class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1"
                                                        style="font-size: 0.75rem; border-radius: 8px;">
                                                        <i class="bi bi-box-arrow-up-right"></i> Buka
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="px-3 pb-3">
                                            <div class="small text-muted">
                                                <i class="bi bi-building me-1"></i> {{ Str::limit($cm->nama_site, 40) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">Belum ada pengajuan CM.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>

    </div>

    {{-- MODAL TAMBAH CM --}}
    <div class="modal fade" id="modalTambahCm" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header text-white d-flex justify-content-center position-relative"
                    style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title w-100 text-center fw-bold">Buat Pengajuan CM</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('cm.store') }}" method="POST" id="formTambahCm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Tempat, Tanggal</label>
                                <input type="text" name="tempat_tanggal" class="form-control"
                                    value="Mataram, {{ date('d F Y') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Divisi / Bagian</label>
                                <input type="text" name="divisi" class="form-control"
                                    value="Manage Service AI BAKTI" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Nomor Pengajuan</label>
                                <input type="text" name="nomor" class="form-control"
                                    placeholder="Contoh: 001/CM/V/2026">
                            </div>

                            <div class="col-md-12">
                                <hr class="my-2">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Nama Site (Bisa pilih banyak)</label>
                                <select name="nama_site[]" class="form-select select_nama_site" multiple required>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->sitename }}">{{ $site->site_id }} - {{ $site->sitename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Tanggal Kunjungan</label>
                                <input type="text" name="tanggal_kunjungan" class="form-control date-range-picker"
                                    placeholder="Pilih rentang tanggal" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Teknisi</label>
                                <input type="text" name="nama_teknisi" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Bank</label>
                                <select name="bank" class="form-select select_bank">
                                    <option value="">-- Pilih Bank --</option>
                                    @php
                                        $banks = [
                                            'Bank BRI (Bank Rakyat Indonesia)',
                                            'Bank BNI (Bank Negara Indonesia)',
                                            'Bank BCA (Bank Central Asia)',
                                            'Bank Mandiri',
                                            'Bank BTN (Bank Tabungan Negara)',
                                            'Bank BSI (Bank Syariah Indonesia)',
                                            'Bank CIMB Niaga',
                                            'Bank Danamon',
                                            'Bank Permata',
                                            'Bank Maybank Indonesia',
                                        ];
                                    @endphp
                                    @foreach($banks as $b)
                                        <option value="{{ $b }}">{{ $b }}</option>
                                    @endforeach
                                    <option value="__custom__">-- Tulis Nama Bank Lainnya --</option>
                                </select>
                                <input type="text" name="bank_custom" class="form-control mt-2 custom_bank_input"
                                    placeholder="Tulis nama bank..." style="display: none;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nomor Rekening</label>
                                <input type="text" name="nomor_rekening" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Rincian Kebutuhan</label>
                                <textarea name="rincian_kebutuhan" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Total Dana (Rp)</label>
                                <input type="number" name="total" class="form-control" id="total_cm" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Terbilang</label>
                                <input type="text" name="terbilang" class="form-control" id="terbilang_cm" readonly>
                            </div>

                            <div class="col-md-12">
                                <hr class="my-2">
                                <h6 class="fw-bold small mb-3">Informasi Pejabat (Bisa dikosongkan jika ingin default)
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Nama Pemohon</label>
                                <input type="text" name="pemohon_nama" class="form-control form-control-sm"
                                    value="Rossie Maulana Septian, S.Kom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Jabatan Pemohon</label>
                                <input type="text" name="pemohon_jabatan" class="form-control form-control-sm"
                                    value="NOC Leader">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Diverifikasi 1 (Manager) - Nama</label>
                                <input type="text" name="diverifikasi1_nama" class="form-control form-control-sm"
                                    value="Dimas Farid Awaludin, S.Kom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Diverifikasi 1 (Manager) - Jabatan</label>
                                <input type="text" name="diverifikasi1_jabatan" class="form-control form-control-sm"
                                    value="Manager">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Diverifikasi 2 (Accounting) - Nama</label>
                                <input type="text" name="diverifikasi2_nama" class="form-control form-control-sm"
                                    value="Baiq Nana Erlina, A.Md">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Diverifikasi 2 (Accounting) - Jabatan</label>
                                <input type="text" name="diverifikasi2_jabatan" class="form-control form-control-sm"
                                    value="Accounting">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Disetujui (Direktur) - Nama</label>
                                <input type="text" name="disetujui_nama" class="form-control form-control-sm"
                                    value="Galuh Zakiyatun, S.Kom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Disetujui (Direktur) - Jabatan</label>
                                <input type="text" name="disetujui_jabatan" class="form-control form-control-sm"
                                    value="Direktur">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small">Mengetahui (Penasihat) - Nama</label>
                                <input type="text" name="mengetahui_nama" class="form-control form-control-sm"
                                    value="Raden Yuniarta Alba, S.Kom">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small">Mengetahui (Penasihat) - Jabatan</label>
                                <input type="text" name="mengetahui_jabatan" class="form-control form-control-sm"
                                    value="Penasihat">
                            </div>
                        </div>

                        <div class="modal-footer px-0 pb-0 pt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold"
                                style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border:none;">Simpan
                                Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach($cmList as $cm)
        {{-- MODAL INFO CM --}}
        <div class="modal fade" id="modalInfoCm{{ $cm->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow: hidden;">
                    <div class="modal-header py-3" style="background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:white;">
                        <h6 class="modal-title fw-bold mb-0">Detail Pengajuan CM</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0" style="background:#f1f5f9; max-height: 85vh; overflow-y: auto;">
                        <style>
                            .modal-print-preview {
                                background: white;
                                margin: 20px;
                                padding: 40px;
                                border-radius: 8px;
                                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                                font-family: Tahoma, Geneva, Verdana, sans-serif;
                                color: #000;
                                line-height: 1.45;
                            }

                            .preview-header {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                                border-bottom: 2px solid #3b82f6;
                                padding-bottom: 10px;
                                margin-bottom: 10px;
                            }

                            .preview-logo {
                                width: 180px;
                            }

                            .preview-header-text {
                                text-align: right;
                            }

                            .preview-header-text h2 {
                                margin: 0;
                                font-size: 14pt;
                                font-weight: 700;
                                color: #3f3f46;
                                text-transform: uppercase;
                            }

                            .preview-header-text .subtitle {
                                margin: 2px 0 0 0;
                                font-size: 14pt;
                                font-weight: 700;
                                color: #3f3f46;
                                text-transform: uppercase;
                            }

                            .preview-info-section {
                                margin-bottom: 15px;
                            }

                            .preview-info-row {
                                display: flex;
                                margin-bottom: 3px;
                                font-size: 10pt;
                            }

                            .preview-info-label {
                                width: 120px;
                                flex-shrink: 0;
                            }

                            .preview-info-separator {
                                width: 15px;
                                text-align: center;
                            }

                            .preview-table {
                                width: 100%;
                                border-collapse: collapse;
                                margin: 15px 0;
                                font-size: 10pt;
                            }

                            .preview-table td {
                                border: 1px solid #000;
                                padding: 6px 10px;
                                vertical-align: middle;
                            }

                            .preview-label-cell {
                                width: 150px;
                            }

                            .preview-total {
                                font-weight: bold;
                            }

                            .preview-terbilang {
                                font-style: italic;
                            }

                            .preview-signature-grid {
                                display: grid;
                                grid-template-columns: 1fr 1fr;
                                row-gap: 15px;
                                column-gap: 20px;
                                margin-top: 20px;
                                text-align: center;
                                font-size: 9pt;
                            }

                            .preview-sign-img {
                                height: 50px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                position: relative;
                            }

                            .preview-sign-img img {
                                height: 80px;
                                max-width: 150px;
                                object-fit: contain;
                                filter: contrast(3) brightness(0.5);
                            }

                            .preview-sign-name {
                                font-weight: bold;
                                text-decoration: underline;
                                margin-top: 5px;
                            }

                            .preview-sign-jabatan {
                                font-weight: bold;
                            }
                        </style>

                        <div class="modal-print-preview">
                            <div class="preview-header">
                                <img src="{{ asset('assets/img/logo2.jpg') }}" class="preview-logo"
                                    onerror="this.src='{{ asset('assets/img/logonustech.png') }}'">
                                <div class="preview-header-text">
                                    <h2>FORMULIR PENGAJUAN</h2>
                                    <div class="subtitle">CORRECTIVE / PREVENTIVE MAINTENANCE</div>
                                </div>
                            </div>

                            <div class="preview-info-section">
                                <div class="preview-info-row">
                                    <div class="preview-info-label">Tempat, Tanggal</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $cm->tempat_tanggal }}</div>
                                </div>
                                <div class="preview-info-row">
                                    <div class="preview-info-label">Divisi / Bagian</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $cm->divisi }}</div>
                                </div>
                                <div class="preview-info-row">
                                    <div class="preview-info-label">No. Surat</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $cm->no_surat ?? '-' }}</div>
                                </div>

                            </div>

                            <p style="font-size: 10pt; text-align: justify; margin-bottom: 10px;">
                                Dengan ini saya mengajukan kunjungan teknisi untuk maintenance site open tiket atau sudah
                                terpantau offline selama durasi lebih dari 3 hari dengan perincian sebagai berikut:
                            </p>

                            <table class="preview-table">
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nama Site</span><span>:</span>
                                        </div>
                                    </td>
                                    <td style="white-space: pre-line;">{!! nl2br(e($cm->nama_site)) !!}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Tanggal
                                                Kunjungan</span><span>:</span></div>
                                    </td>
                                    <td>{{ $cm->tanggal_kunjungan }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nama Teknisi</span><span>:</span>
                                        </div>
                                    </td>
                                    <td>{{ $cm->nama_teknisi }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Bank</span><span>:</span></div>
                                    </td>
                                    <td>{{ $cm->bank ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nomer
                                                Rekening</span><span>:</span></div>
                                    </td>
                                    <td>{{ $cm->nomor_rekening ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Rincian
                                                Kebutuhan</span><span>:</span></div>
                                    </td>
                                    <td>{!! nl2br(e($cm->rincian_kebutuhan)) !!}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Total</span><span>:</span></div>
                                    </td>
                                    <td class="preview-total">Rp {{ number_format($cm->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Terbilang</span><span>:</span>
                                        </div>
                                    </td>
                                    <td class="preview-terbilang">{{ $cm->terbilang }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Catatan</span><span>:</span></div>
                                    </td>
                                    <td>
                                        @if(auth()->user()->role === 'accounting')
                                            {{ $cm->catatan ?? '-' }}
                                        @else
                                            {{ $cm->catatan ?? '-' }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Keterangan</span><span>:</span></div>
                                    </td>
                                    <td>{{ $cm->keterangan ?? '-' }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 10pt; margin-bottom: 15px;">Demikian surat pengajuan ini dibuat, atas
                                perhatiannya saya ucapkan terima kasih.</p>

                            @if($cm->ttd_penasihat)
                                <div style="text-align: center; margin-bottom: 15px; font-size: 9pt;">
                                    Mataram, {{ $cm->updated_at->format('d F Y') }}
                                </div>
                            @endif

                            <div class="preview-signature-grid">
                                <div>
                                    <p class="mb-1">Pemohon,</p>
                                    <div class="preview-sign-img">
                                        @if($cm->ttd_pemohon)
                                            <img src="{{ asset('assets/img/ttd/pemohon.png') }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">Rossie Maulana Septian, S.Kom</p>
                                    <p class="preview-sign-jabatan">NOC Leader</p>
                                </div>
                                <div>
                                    <p class="mb-1">Diverifikasi,</p>
                                    <div class="preview-sign-img">
                                        @if($cm->ttd_manager)
                                            <img src="{{ asset('assets/img/ttd/manager.png') }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $cm->diverifikasi1_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $cm->diverifikasi1_jabatan ?: 'Manager' }}</p>
                                </div>
                                <div>
                                    <p class="mb-1">Diverifikasi,</p>
                                    <div class="preview-sign-img" style="height: 70px;">
                                        @if($cm->ttd_accounting)
                                            <img src="{{ asset('assets/img/ttd/accounting.png') }}" style="bottom: -20px; position: relative;">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $cm->diverifikasi2_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $cm->diverifikasi2_jabatan ?: 'Accounting' }}</p>
                                </div>
                                <div>
                                    <p class="mb-1">Disetujui,</p>
                                    <div class="preview-sign-img">
                                        @if($cm->ttd_direktur)
                                            <img src="{{ asset('assets/img/ttd/direktur.png') }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $cm->disetujui_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $cm->disetujui_jabatan ?: 'Direktur' }}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <div style="text-align: center; font-size: 9pt; width: 50%;">
                                    <p class="mb-1">Mengetahui,</p>
                                    <div class="preview-sign-img">
                                        @if($cm->ttd_penasihat)
                                            <img src="{{ asset('assets/img/ttd/penasihat.png') }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $cm->mengetahui_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $cm->mengetahui_jabatan ?: 'Penasihat' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL REJECT CM --}}
        <div class="modal fade" id="modalReject{{ $cm->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger text-white">
                        <h6 class="modal-title fw-bold">Tolak Pengajuan CM</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('cm.reject', $cm->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <label class="form-label fw-bold small">Alasan Penolakan</label>
                            <textarea name="rejection_reason" class="form-control" rows="4" required
                                placeholder="Tulis alasan mengapa pengajuan ini ditolak..."></textarea>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">Konfirmasi Tolak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL APPROVE ACCOUNTING CM (isi no_surat + catatan + keterangan) --}}
        @if(auth()->user()->role === 'accounting')
        <div class="modal fade" id="modalApproveAccCm{{ $cm->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#10b981,#059669);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-check-circle me-2"></i>Setujui & Isi Data Accounting
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('cm.approve', $cm->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 small mb-3" style="background:#eff6ff;">
                                <i class="bi bi-info-circle me-1"></i>
                                Isi data berikut sebelum menyetujui pengajuan CM ini.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $cm->no_surat }}"
                                    placeholder="Contoh: 001/ACC/CM/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan <span class="text-muted">(opsional)</span></label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $cm->catatan }}</textarea>
                            </div>

                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn rounded-pill px-5 fw-bold text-white"
                                style="background:linear-gradient(135deg,#10b981,#059669);border:none;">
                                <i class="bi bi-check-lg me-1"></i>Setujui Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT CATATAN / NO SURAT (Accounting saja) --}}
        <div class="modal fade" id="modalNotesCm{{ $cm->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-journal-text me-2"></i>Isi / Edit Catatan & Status
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('cm.accounting.notes', $cm->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-warning border-0 small mb-3" style="background:#fffbeb;">
                                <i class="bi bi-lock me-1"></i>
                                Hanya <strong>Accounting</strong> yang dapat mengisi/mengubah data ini.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Status Pembayaran</label>
                                <select name="status_pembayaran" class="form-select" id="status_pembayaran_{{ $cm->id }}" onchange="toggleBuktiTransfer({{ $cm->id }})">
                                    <option value="belum_dibayar" {{ $cm->status_pembayaran === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                    <option value="dp_50" {{ $cm->status_pembayaran === 'dp_50' ? 'selected' : '' }}>Sudah di DP 50%</option>
                                    <option value="lunas" {{ $cm->status_pembayaran === 'lunas' ? 'selected' : '' }}>Sudah Lunas</option>
                                </select>
                            </div>

                            {{-- Bukti DP 50% (muncul saat dp_50 atau lunas) --}}
                            <div class="mb-3" id="bukti_dp_container_{{ $cm->id }}"
                                style="display: {{ in_array($cm->status_pembayaran, ['dp_50', 'lunas']) ? 'block' : 'none' }};">
                                <label class="form-label fw-bold small text-warning">
                                    <i class="bi bi-image me-1"></i>Foto Bukti DP 50%
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <input type="file" name="bukti_dp" class="form-control" accept="image/*">
                                @if($cm->bukti_dp)
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage_public/' . $cm->bukti_dp) }}" class="rounded border" style="height:50px;object-fit:cover;">
                                        <a href="{{ asset('storage_public/' . $cm->bukti_dp) }}" target="_blank" class="small text-primary">Lihat Bukti DP</a>
                                    </div>
                                @endif
                            </div>

                            {{-- Bukti Lunas (muncul hanya saat lunas) --}}
                            <div class="mb-3" id="bukti_transfer_container_{{ $cm->id }}"
                                style="display: {{ $cm->status_pembayaran === 'lunas' ? 'block' : 'none' }};">
                                <label class="form-label fw-bold small text-success">
                                    <i class="bi bi-image me-1"></i>Foto Bukti Lunas
                                    <span class="text-muted fw-normal">(Opsional)</span>
                                </label>
                                <input type="file" name="bukti_transfer" class="form-control" accept="image/*">
                                @if($cm->bukti_transfer)
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="{{ asset('storage_public/' . $cm->bukti_transfer) }}" class="rounded border" style="height:50px;object-fit:cover;">
                                        <a href="{{ asset('storage_public/' . $cm->bukti_transfer) }}" target="_blank" class="small text-primary">Lihat Bukti Lunas</a>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat</label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $cm->no_surat }}"
                                    placeholder="Contoh: 001/ACC/CM/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $cm->catatan }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn rounded-pill px-5 fw-bold text-white"
                                style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">
                                <i class="bi bi-save me-1"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- MODAL EDIT CM --}}
        <div class="modal fade" id="modalEditCm{{ $cm->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header py-3"
                        style="background: linear-gradient(135deg, #0d6efd, #0b5ed7); color:white;">
                        <h5 class="modal-title fw-bold mb-0">Edit Pengajuan CM</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('cm.update', $cm->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tempat, Tanggal</label>
                                    <input type="text" name="tempat_tanggal" class="form-control"
                                        value="{{ $cm->tempat_tanggal }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Divisi / Bagian</label>
                                    <input type="text" name="divisi" class="form-control" value="{{ $cm->divisi }}"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nomor Pengajuan</label>
                                    <input type="text" name="nomor" class="form-control" value="{{ $cm->nomor }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Site (Bisa pilih banyak)</label>
                                    @php
                                        // Bersihkan string dari nomor urut (1. SiteA \n 2. SiteB)
                                        $rawSites = $cm->nama_site;
                                        $sites_selected = array_map(function ($s) {
                                            return trim(preg_replace('/^[0-9]+\.\s*/', '', $s));
                                        }, explode("\n", str_replace("\r", "", $rawSites)));
                                    @endphp
                                    <select name="nama_site[]" class="form-select select_nama_site" multiple required>
                                        @foreach($sites as $site)
                                            <option value="{{ $site->sitename }}" {{ in_array($site->sitename, $sites_selected) ? 'selected' : '' }}>
                                                {{ $site->site_id }} - {{ $site->sitename }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tanggal Kunjungan</label>
                                    <input type="text" name="tanggal_kunjungan" class="form-control date-range-picker"
                                        value="{{ $cm->tanggal_kunjungan }}" placeholder="Pilih rentang tanggal" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nama Teknisi</label>
                                    <input type="text" name="nama_teknisi" class="form-control"
                                        value="{{ $cm->nama_teknisi }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Bank</label>
                                    <select name="bank" class="form-select select_bank_edit">
                                        @php
                                            $banks = [
                                                'Bank BRI (Bank Rakyat Indonesia)',
                                                'Bank BNI (Bank Negara Indonesia)',
                                                'Bank BCA (Bank Central Asia)',
                                                'Bank Mandiri',
                                                'Bank BTN (Bank Tabungan Negara)',
                                                'Bank BSI (Bank Syariah Indonesia)',
                                                'Bank CIMB Niaga',
                                                'Bank Danamon',
                                                'Bank Permata',
                                                'Bank Maybank Indonesia',
                                            ];
                                            $isCustomBank = !empty($cm->bank) && !in_array($cm->bank, $banks);
                                        @endphp
                                        <option value="">-- Pilih Bank --</option>
                                        @foreach($banks as $b)
                                            <option value="{{ $b }}" {{ $cm->bank == $b ? 'selected' : '' }}>{{ $b }}</option>
                                        @endforeach
                                        <option value="__custom__" {{ $isCustomBank ? 'selected' : '' }}>-- Tulis Nama Bank
                                            Lainnya --</option>
                                    </select>
                                    <input type="text" name="bank_custom" class="form-control mt-2 custom_bank_input_edit"
                                        placeholder="Tulis nama bank..." value="{{ $isCustomBank ? $cm->bank : '' }}"
                                        style="display: {{ $isCustomBank ? 'block' : 'none' }};">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nomor Rekening</label>
                                    <input type="text" name="nomor_rekening" class="form-control"
                                        value="{{ $cm->nomor_rekening }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Rincian Kebutuhan</label>
                                    <textarea name="rincian_kebutuhan" class="form-control" rows="3"
                                        required>{{ $cm->rincian_kebutuhan }}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="2">{{ $cm->catatan }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Total Dana (Rp)</label>
                                    <input type="number" name="total" class="form-control total_cm_edit"
                                        value="{{ $cm->total }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Terbilang</label>
                                    <input type="text" name="terbilang" class="form-control terbilang_cm_edit"
                                        value="{{ $cm->terbilang }}" readonly>
                                </div>

                                <div class="col-md-12">
                                    <hr class="my-2">
                                    <h6 class="fw-bold small mb-3">Informasi Pejabat</h6>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Nama Pemohon</label>
                                    <input type="text" name="pemohon_nama" class="form-control form-control-sm"
                                        value="{{ $cm->pemohon_nama }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">Jabatan Pemohon</label>
                                    <input type="text" name="pemohon_jabatan" class="form-control form-control-sm"
                                        value="{{ $cm->pemohon_jabatan }}">
                                </div>
                                <div class="col-md-6">

                                    <label class="form-label small">Diverifikasi 1 (Manager) - Nama</label>

                                    <input type="text" name="diverifikasi1_nama" class="form-control form-control-sm"

                                        value="{{ $cm->diverifikasi1_nama }}">

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label small">Diverifikasi 1 (Manager) - Jabatan</label>

                                    <input type="text" name="diverifikasi1_jabatan" class="form-control form-control-sm"

                                        value="{{ $cm->diverifikasi1_jabatan ?: 'Manager' }}">

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label small">Diverifikasi 2 (Accounting) - Nama</label>

                                    <input type="text" name="diverifikasi2_nama" class="form-control form-control-sm"

                                        value="{{ $cm->diverifikasi2_nama }}">

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label small">Diverifikasi 2 (Accounting) - Jabatan</label>

                                    <input type="text" name="diverifikasi2_jabatan" class="form-control form-control-sm"

                                        value="{{ $cm->diverifikasi2_jabatan ?: 'Accounting' }}">

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label small">Disetujui (Direktur) - Nama</label>

                                    <input type="text" name="disetujui_nama" class="form-control form-control-sm"

                                        value="{{ $cm->disetujui_nama }}">

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label small">Disetujui (Direktur) - Jabatan</label>

                                    <input type="text" name="disetujui_jabatan" class="form-control form-control-sm"

                                        value="{{ $cm->disetujui_jabatan ?: 'Direktur' }}">

                                </div>


                                <div class="col-md-6">

                                    <label class="form-label small">Mengetahui (Penasihat) - Nama</label>

                                    <input type="text" name="mengetahui_nama" class="form-control form-control-sm"

                                        value="{{ $cm->mengetahui_nama }}">

                                </div>

                                <div class="col-md-6">

                                    <label class="form-label small">Mengetahui (Penasihat) - Jabatan</label>

                                    <input type="text" name="mengetahui_jabatan" class="form-control form-control-sm"

                                        value="{{ $cm->mengetahui_jabatan ?: 'Penasihat' }}">

                                </div>
                            </div>

                            <div class="modal-footer px-0 pb-0 pt-4 mt-3">
                                <button type="button" class="btn btn-light rounded-pill px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold">Simpan
                                    Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // TomSelect for Multiple Sites
            document.querySelectorAll('.select_nama_site').forEach(el => {
                new TomSelect(el, {
                    plugins: ['remove_button'],
                    placeholder: 'Pilih Site...',
                    maxItems: 50,
                });
            });

            // Bank Custom Logic (Main Form)
            const selectBank = document.querySelector('.select_bank');
            const customBankInput = document.querySelector('.custom_bank_input');
            if (selectBank) {
                selectBank.addEventListener('change', function () {
                    customBankInput.style.display = (this.value === '__custom__') ? 'block' : 'none';
                    if (this.value === '__custom__') customBankInput.focus();
                });
            }

            // Bank Custom Logic (Edit Modals - delegasi)
            document.addEventListener('change', function (e) {
                if (e.target.classList.contains('select_bank_edit')) {
                    const parent = e.target.closest('.row');
                    const customInput = parent.querySelector('.custom_bank_input_edit');
                    if (customInput) {
                        customInput.style.display = (e.target.value === '__custom__') ? 'block' : 'none';
                        if (e.target.value === '__custom__') customInput.focus();
                    }
                }
            });

            // Terbilang Logic (Main Form)
            const totalInput = document.getElementById('total_cm');
            const terbilangInput = document.getElementById('terbilang_cm');
            if (totalInput) {
                totalInput.addEventListener('input', function () {
                    const total = parseInt(this.value) || 0;
                    terbilangInput.value = total > 0 ? angkaKeTerbilang(total) + " Rupiah" : "";
                });
            }

            // Terbilang Logic (Edit Modals)
            document.addEventListener('input', function (e) {
                if (e.target.classList.contains('total_cm_edit')) {
                    const parent = e.target.closest('.row');
                    const terbilangEdit = parent.querySelector('.terbilang_cm_edit');
                    if (terbilangEdit) {
                        const total = parseInt(e.target.value) || 0;
                        terbilangEdit.value = total > 0 ? angkaKeTerbilang(total) + " Rupiah" : "";
                    }
                }
            });

            function angkaKeTerbilang(n) {
                const kata = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
                if (n < 12) return kata[n];
                if (n < 20) return angkaKeTerbilang(n - 10) + " Belas";
                if (n < 100) return angkaKeTerbilang(Math.floor(n / 10)) + " Puluh " + kata[n % 10];
                if (n < 200) return "Seratus " + angkaKeTerbilang(n - 100);
                if (n < 1000) return angkaKeTerbilang(Math.floor(n / 100)) + " Ratus " + angkaKeTerbilang(n % 100);
                if (n < 2000) return "Seribu " + angkaKeTerbilang(n - 1000);
                if (n < 1000000) return angkaKeTerbilang(Math.floor(n / 1000)) + " Ribu " + angkaKeTerbilang(n % 1000);
                if (n < 1000000000) return angkaKeTerbilang(Math.floor(n / 1000000)) + " Juta " + angkaKeTerbilang(n % 1000000);
                return "";
            }
        });

        function confirmDelete(formId) {
            Swal.fire({
                title: 'Hapus data ini?',
                text: "Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Notification handler
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif

        document.addEventListener("DOMContentLoaded", function() {
            flatpickr(".date-range-picker", {
                mode: "range",
                dateFormat: "d/m/Y",
                rangeSeparator: " s/d ",
                locale: {
                    rangeSeparator: " s/d "
                }
            });
        });

        function confirmMarkDone(id) {
            Swal.fire({
                title: 'Tandai sebagai DONE?',
                text: "Apakah Anda yakin ingin menandai pengajuan ini sebagai DONE? Notifikasi akan dikirimkan ke tim Accounting.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Selesai!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formMarkDone' + id).submit();
                }
            });
        }

        function toggleBuktiTransfer(id) {
            const select = document.getElementById('status_pembayaran_' + id);
            const dpContainer = document.getElementById('bukti_dp_container_' + id);
            const lunasContainer = document.getElementById('bukti_transfer_container_' + id);
            const val = select ? select.value : '';

            // Bukti DP: tampil saat dp_50 atau lunas
            if (dpContainer) {
                dpContainer.style.display = (val === 'dp_50' || val === 'lunas') ? 'block' : 'none';
            }
            // Bukti Lunas: tampil hanya saat lunas
            if (lunasContainer) {
                lunasContainer.style.display = val === 'lunas' ? 'block' : 'none';
            }
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.addEventListener('change', function(e) {
                    if (e.target.tagName === 'SELECT') {
                        e.preventDefault();
                        fetchTableData();
                    }
                });
                
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    fetchTableData();
                });
            }

            function fetchTableData() {
                if (filterForm) {
                    const formData = new FormData(filterForm);
                    const params = new URLSearchParams(formData);
                    const url = filterForm.action + '?' + params.toString();

                    const container = document.getElementById('tableCmContainer');
                    if (container) container.style.opacity = '0.5';

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('tableCmContainer');
                        if (newTable && container) {
                            container.innerHTML = newTable.innerHTML;
                            container.style.opacity = '1';
                            window.history.pushState({}, '', url);
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        if (container) container.style.opacity = '1';
                    });
                }
            }
        });
    </script>
    @include('components.nav-modal-structure')
</body>

</html>
