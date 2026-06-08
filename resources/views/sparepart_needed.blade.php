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
    <title>Sparepart Needed | Project Operational</title>
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

        .col-perangkat {
            left: 50px;
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

        /* Approval Steps Dots */
        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #e0e0e0;
        }

        .step-dot.active {
            background: #198754;
            box-shadow: 0 0 5px rgba(25, 135, 84, 0.5);
        }

        .step-dot.rejected {
            background: #dc3545;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
        }

        .btn-action-premium {
            width: 46px;
            height: 46px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white !important;
            border: none;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            cursor: pointer;
        }

        .btn-action-premium:hover {
            transform: scale(1.1) rotate(90deg);
            background: linear-gradient(135deg, #8b5cf6, #6366f1);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.5);
        }

        .btn-action-premium i {
            font-size: 1.5rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Sticky col shadow untuk kolom NAMA PERANGKAT dihilangkan untuk menyamakan dengan pergantianperangkat */
        .col-perangkat {
            left: 50px;
            min-width: 250px;
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

        /* Sweet Alert Blur Backdrop */
        .swal2-backdrop-blur {
            backdrop-filter: blur(6px) !important;
            -webkit-backdrop-filter: blur(6px) !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
        }

        .swal2-custom-image {
            max-height: 80vh !important;
            object-fit: contain !important;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
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
            @if(auth()->check() && auth()->user()->hasAdminAccess())
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                    @if(auth()->check() && auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile"
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
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ route('sparepart_needed') }}" class="tab active">Pengajuan Perangkat</a>
        <a href="{{ route('csr.index') }}" class="tab">Pengajuan CSR</a>
        <a href="{{ route('cm.index') }}" class="tab">Pengajuan CM</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black" id="summaryBadge">Total Sparepart Needed :
                <b>{{ $sparepartsNeeded->total() }}</b></span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user', 'noc_leader']))
                    <button type="button" class="btn-action-premium" title="Tambah Data" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSparepart">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                @endif
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('sparepart_needed') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">

                    <div class="col-12 col-md-auto">
                        <select name="status" class="form-select form-select-sm w-100">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $st)
                                <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn-filter-pill w-100 justify-content-center">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('sparepart_needed') }}"
                            class="btn btn-light btn-sm rounded-pill border d-flex align-items-center justify-content-center h-100"
                            title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" name="search" id="searchInput" placeholder="Cari Sparepart / Site"
                                value="{{ request('search') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn" style="border: none; background: transparent;"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- MODAL TAMBAH -->
            <div class="modal fade" id="modalTambahSparepart" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg">
                        <div class="modal-header text-white d-flex justify-content-center position-relative"
                            style="background-color: #0d6efd; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title w-100 text-center fw-bold">Tambah Sparepart Needed</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body pt-4">
                            <form action="{{ route('sparepart.needed.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Site Tujuan
                                        <span class="text-danger">*</span></label>
                                    <select name="site_id" required class="form-select">
                                        <option value="">-- Pilih Site --</option>
                                        @foreach(\App\Models\Site::orderBy('sitename')->get() as $s)
                                            <option value="{{ $s->site_id }}">{{ $s->site_id }} - {{ $s->sitename }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Nama
                                            Sparepart <span class="text-danger">*</span></label>
                                        <input type="text" name="sparepart_name" required placeholder="Contoh: Kabel FO"
                                            class="form-control">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Qty
                                            <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" required min="1" value="1"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Status
                                            Kebutuhan</label>
                                        <input type="text" name="status" class="form-control" value="Pending" required
                                            placeholder="Contoh: Pending">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Tingkat
                                            Urgensi <span class="text-danger">*</span></label>
                                        <select name="urgency" required class="form-select">
                                            <option value="Low">Low</option>
                                            <option value="Medium" selected>Medium</option>
                                            <option value="High">High</option>
                                            <option value="Urgent">Urgent &#128293;</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Foto
                                            Resi <i>(Opsional)</i></label>
                                        <input type="file" name="foto_resi" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Foto
                                            Terpasang <i>(Opsional)</i></label>
                                        <input type="file" name="foto_terpasang" class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Foto SN
                                            Baru <i>(Opsional)</i></label>
                                        <input type="file" name="foto_sn" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Foto
                                            Lainnya <i>(Opsional)</i></label>
                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                    </div>
                                    <div class="col-12">
                                        <div class="form-text" style="font-size: 0.75rem;">Format: JPG, PNG, GIF. Maks:
                                            5MB per file.</div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Keterangan /
                                        Deskripsi</label>
                                    <textarea name="description" rows="3" placeholder="Alasan membutuhkan sparepart..."
                                        class="form-control"></textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-light px-4 rounded-3 border"
                                        data-bs-dismiss="modal">
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

        <!-- TABLE DATA -->
        <div id="tableContainer">
            <div class="table-responsive-custom">
                <table>
                    <thead>
                        <tr class="thead-dark">
                            <th class="text-center sticky-col col-no">NO</th>
                            <th class="sticky-col col-perangkat">NAMA SPAREPART</th>
                            <th class="text-center">QTY</th>
                            <th>NAMA SITE</th>
                            <th>SITE ID</th>
                            <th class="text-center">FOTO LAIN - LAIN</th>
                            <th class="text-center">URGENSI</th>
                            <th class="text-center">STATUS</th>
                            <th>KETERANGAN</th>
                            <th>TANGGAL REQUEST</th>
                            @if(auth()->check() && auth()->user()->role === 'noc_leader')
                                <th class="text-center">AKSI</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sparepartsNeeded as $item)
                            <tr>
                                <td class="text-center sticky-col col-no">
                                    {{ $loop->iteration + ($sparepartsNeeded->currentPage() - 1) * $sparepartsNeeded->perPage() }}
                                </td>
                                <td class="sticky-col col-perangkat fw-bold text-dark">{{ $item->sparepart_name }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary">{{ $item->quantity }}</span>
                                </td>
                                <td>{{ $item->site ? $item->site->sitename : '-' }}</td>
                                <td>{{ $item->site_id }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-column gap-2 align-items-center">
                                        @php
                                            $displayPhotos = [
                                                'Resi' => $item->foto_resi,
                                                'Terpasang' => $item->foto_terpasang,
                                                'SN' => $item->foto_sn,
                                                'Lain' => $item->photo
                                            ];
                                        @endphp

                                        @php $hasAnyPhoto = false; @endphp
                                        @foreach($displayPhotos as $label => $path)
                                            @if($path)
                                                @php $hasAnyPhoto = true; @endphp
                                                <div class="d-flex flex-column align-items-center">
                                                    <a href="javascript:void(0)" onclick="showImage(this.querySelector('img').src)">
                                                        <img src="{{ asset('storage/' . $path) }}"
                                                            onerror="this.onerror=null; this.src='{{ asset('storage/' . $path) }}';"
                                                            alt="{{ $label }}"
                                                            style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #ddd; transition: transform 0.2s;"
                                                            onmouseover="this.style.transform='scale(1.1)'"
                                                            onmouseout="this.style.transform='scale(1)'">
                                                    </a>
                                                    <small
                                                        style="font-size: 0.65rem; color: #666; margin-top: 2px;">{{ $label }}</small>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if(!$hasAnyPhoto)
                                            <span class="text-muted"><i class="bi bi-image"
                                                    style="font-size: 1.5rem; opacity: 0.3;"></i></span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if($item->urgency == 'Urgent')
                                        <span class="badge"
                                            style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid #e74c3c;"><i
                                                class="bi bi-fire"></i> Urgent</span>
                                    @elseif($item->urgency == 'High')
                                        <span class="badge"
                                            style="background: rgba(230, 126, 34, 0.1); color: #e67e22; border: 1px solid #e67e22;">High</span>
                                    @elseif($item->urgency == 'Low')
                                        <span class="badge"
                                            style="background: rgba(149, 165, 166, 0.1); color: #95a5a6; border: 1px solid #95a5a6;">Low</span>
                                    @else
                                        <span class="badge"
                                            style="background: rgba(52, 152, 219, 0.1); color: #3498db; border: 1px solid #3498db;">Medium</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->status == 'Pending')
                                        <span class="badge"
                                            style="background: rgba(243, 156, 18, 0.1); color: #f39c12; border: 1px solid #f39c12;">Pending</span>
                                    @elseif($item->status == 'Approved')
                                        <span class="badge"
                                            style="background: rgba(52, 152, 219, 0.1); color: #3498db; border: 1px solid #3498db;">Approved</span>
                                    @elseif($item->status == 'Completed')
                                        <span class="badge"
                                            style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid #2ecc71;">Completed</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>{{ $item->description ?: '-' }}</td>
                                <td>{{ $item->created_at->format('d M Y, H:i') }}</td>

                                @if(auth()->check() && auth()->user()->role === 'noc_leader')
                                    <td class="text-center">
                                        <div class="d-flex gap-2 justify-content-center align-items-center">
                                            <button class="btn btn-sm btn-light border shadow-sm text-primary"
                                                data-bs-toggle="modal" data-bs-target="#modalEditSparepart{{ $item->id }}"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('sparepart.needed.destroy', $item->id) }}" method="POST"
                                                class="m-0 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger"
                                                    title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>

                            <!-- Modal Edit -->
                            @if(auth()->check() && auth()->user()->role === 'noc_leader')
                                <div class="modal fade" id="modalEditSparepart{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow-lg text-start">
                                            <div class="modal-header text-white d-flex justify-content-center position-relative"
                                                style="background-color: #0d6efd; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title w-100 text-center fw-bold">Edit Sparepart Needed</h5>
                                                <button type="button"
                                                    class="btn-close btn-close-white position-absolute end-0 me-3"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body pt-4">
                                                <form action="{{ route('sparepart.needed.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            style="font-size: 0.85rem; font-weight: 600;">Site
                                                            Tujuan <span class="text-danger">*</span></label>
                                                        <select name="site_id" required class="form-select">
                                                            @foreach(\App\Models\Site::orderBy('sitename')->get() as $s)
                                                                <option value="{{ $s->site_id }}" {{ $item->site_id == $s->site_id ? 'selected' : '' }}>
                                                                    {{ $s->site_id }} - {{ $s->sitename }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-8">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Nama Sparepart
                                                                <span class="text-danger">*</span></label>
                                                            <input type="text" name="sparepart_name" required
                                                                value="{{ $item->sparepart_name }}" class="form-control">
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Qty <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="quantity" required min="1"
                                                                value="{{ $item->quantity }}" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Status
                                                                Kebutuhan</label>
                                                            <input type="text" name="status" class="form-control"
                                                                value="{{ $item->status }}" required
                                                                placeholder="Contoh: Pending / Menunggu Kirim">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Tingkat Urgensi
                                                                <span class="text-danger">*</span></label>
                                                            <select name="urgency" required class="form-select">
                                                                <option value="Low" {{ $item->urgency == 'Low' ? 'selected' : '' }}>Low</option>
                                                                <option value="Medium" {{ $item->urgency == 'Medium' ? 'selected' : '' }}>Medium</option>
                                                                <option value="High" {{ $item->urgency == 'High' ? 'selected' : '' }}>High</option>
                                                                <option value="Urgent" {{ $item->urgency == 'Urgent' ? 'selected' : '' }}>Urgent &#128293;</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Update Foto
                                                                Resi</label>
                                                            @if($item->foto_resi)
                                                                <div class="mb-2">
                                                                    <img src="{{ asset('storage/' . $item->foto_resi) }}"
                                                                        onerror="this.onerror=null; this.src='{{ asset('storage/' . $item->foto_resi) }}';"
                                                                        alt="Resi"
                                                                        style="height: 60px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover;">
                                                                </div>
                                                            @endif
                                                            <input type="file" name="foto_resi" class="form-control"
                                                                accept="image/*">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Update Foto
                                                                Terpasang</label>
                                                            @if($item->foto_terpasang)
                                                                <div class="mb-2">
                                                                    <img src="{{ asset('storage/' . $item->foto_terpasang) }}"
                                                                        onerror="this.onerror=null; this.src='{{ asset('storage/' . $item->foto_terpasang) }}';"
                                                                        alt="Terpasang"
                                                                        style="height: 60px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover;">
                                                                </div>
                                                            @endif
                                                            <input type="file" name="foto_terpasang" class="form-control"
                                                                accept="image/*">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Update Foto SN
                                                                Baru</label>
                                                            @if($item->foto_sn)
                                                                <div class="mb-2">
                                                                    <img src="{{ asset('storage/' . $item->foto_sn) }}"
                                                                        onerror="this.onerror=null; this.src='{{ asset('storage/' . $item->foto_sn) }}';"
                                                                        alt="SN"
                                                                        style="height: 60px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover;">
                                                                </div>
                                                            @endif
                                                            <input type="file" name="foto_sn" class="form-control"
                                                                accept="image/*">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label"
                                                                style="font-size: 0.85rem; font-weight: 600;">Update Foto
                                                                Lainnya</label>
                                                            @if($item->photo)
                                                                <div class="mb-2">
                                                                    <img src="{{ asset('storage/' . $item->photo) }}"
                                                                        onerror="this.onerror=null; this.src='{{ asset('storage/' . $item->photo) }}';"
                                                                        alt="Lainnya"
                                                                        style="height: 60px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover;">
                                                                </div>
                                                            @endif
                                                            <input type="file" name="photo" class="form-control"
                                                                accept="image/*">
                                                            <div class="form-text" style="font-size: 0.75rem;">Biarkan kosong
                                                                jika tidak ingin mengubah foto.</div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label"
                                                            style="font-size: 0.85rem; font-weight: 600;">Keterangan /
                                                            Deskripsi</label>
                                                        <textarea name="description" rows="3"
                                                            class="form-control">{{ $item->description }}</textarea>
                                                    </div>

                                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                                        <button type="button" class="btn btn-light px-4 rounded-3 border"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit"
                                                            class="btn btn-primary px-4 rounded-3">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">Belum ada request sparepart needed.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                <span class="pagination-info">
                    Showing {{ $sparepartsNeeded->firstItem() ?? 0 }} to {{ $sparepartsNeeded->lastItem() ?? 0 }}
                    of&nbsp;<strong>{{ $sparepartsNeeded->total() }}</strong>&nbsp;results
                </span>
                <nav>
                    {{ $sparepartsNeeded->appends(request()->query())->links("pagination::bootstrap-5") }}
                </nav>
            </div>
        </div>
    </div>

    <style>
        .modal-print-preview {
            background: white;
            margin: 20px auto;
            padding: 30px;
            max-width: 760px;
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
            width: 150px;
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
        .modal-body .modal-print-preview table.preview-table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 15px 0 !important;
            font-size: 10pt !important;
            background-color: #ffffff !important;
            border: 1px solid #000000 !important;
        }
        .modal-body .modal-print-preview table.preview-table th,
        .modal-body .modal-print-preview table.preview-table td {
            border: 1px solid #000000 !important;
            padding: 6px 10px !important;
            vertical-align: middle !important;
            color: #000000 !important;
            background-color: #ffffff !important;
        }
        .modal-body .modal-print-preview table.preview-table th,
        .modal-body .modal-print-preview table.preview-table td.bg-gray-label {
            background-color: #ffffff !important;
            font-weight: bold !important;
        }
        .modal-body .modal-print-preview table.preview-table th {
            text-align: center !important;
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
        .workflow-step {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-top: 6px;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #e2e8f0;
            transition: all 0.3s ease;
        }
        .step-dot.completed, .step-dot.active {
            background: #10b981;
            box-shadow: 0 0 4px rgba(16, 185, 129, 0.4);
        }
        .step-dot.rejected {
            background: #ef4444;
            box-shadow: 0 0 4px rgba(239, 68, 68, 0.4);
        }
    </style>

    <!-- TABEL PENGAJUAN -->
    <div class="content-container mt-4">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <h5 class="m-0 fw-bold"><i class="bi bi-file-earmark-text"></i> Data Formulir Pengajuan</h5>
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user', 'noc_leader']))
                <button type="button" class="btn-action-premium" data-bs-toggle="modal"
                    data-bs-target="#modalPrintPengajuan" title="Buat Pengajuan Baru">
                    <i class="bi bi-plus-lg"></i>
                </button>
            @endif
        </div>

        <div class="table-responsive-custom" id="tablePengajuanContainer">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">NO</th>
                        <th style="min-width: 150px;">TANGGAL & NOMOR</th>
                        <th style="min-width: 200px;">DIVISI</th>
                        <th style="min-width: 300px;">DETAIL PERANGKAT</th>
                        <th class="text-end" style="min-width: 130px;">TOTAL DANA</th>
                        <th class="text-center" style="min-width: 150px;">PROGRESS APPROVAL</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $index => $p)
                        <tr>
                            <td class="text-center">{{ $pengajuans->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $p->tempat_tanggal }}</div>
                                <div class="small text-muted">{{ $p->nomor }}</div>
                            </td>
                            <td>
                                <div class="small text-dark">{{ $p->divisi }}</div>
                            </td>
                            <td style="max-width: 300px;">
                                <div class="small text-dark text-truncate">
                                    @if(is_array($p->items))
                                        @php
                                            $perangkatList = array_map(function($i) { return ($i['perangkat'] ?? '') . ' (' . ($i['qty'] ?? 1) . ')'; }, $p->items);
                                        @endphp
                                        {{ implode(', ', $perangkatList) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($p->grand_total, 0, ',', '.') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $p->status_color }} mb-1 rounded-pill px-3 py-2" style="font-size: 0.75rem;">
                                    @if($p->approval_status == 'approved_penasihat')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($p->approval_status == 'rejected')
                                        <i class="bi bi-x-circle-fill"></i>
                                    @else
                                        <i class="bi bi-clock-history"></i>
                                    @endif
                                    {{ $p->status_label }}
                                </span>
                                <div class="workflow-step">
                                    @foreach(['NOC Leader', 'Manager', 'Accounting', 'Direktur', 'Penasihat'] as $idx => $label)
                                        <div class="step-item" title="{{ $label }}">
                                            <div class="step-dot {{ $p->step > ($idx + 1) ? 'completed' : ($p->approval_status == 'rejected' && $p->rejected_by == $label ? 'rejected' : ($p->step == ($idx + 1) ? 'active' : '')) }}"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    @if($p->can_approve)
                                        @if($p->approval_status === 'approved_manager' && auth()->user()->role === 'accounting')
                                            {{-- Accounting: buka modal isi no_surat + catatan dulu --}}
                                            <button type="button" class="btn btn-sm btn-success shadow-sm"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalApproveAccSP{{ $p->id }}"
                                                title="Setujui &amp; Isi Catatan">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-success shadow-sm"
                                                onclick="confirmApproval('{{ route('sparepart.needed.approve', $p->id) }}')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-sm btn-danger shadow-sm"
                                            onclick="showRejectModal('{{ route('sparepart.needed.reject', $p->id) }}')">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-info text-white shadow-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalInfoPengajuan{{ $p->id }}" title="View Pengajuan">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-success border shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item" href="{{ route('sparepart.needed.pengajuan.print', ['id' => $p->id, 'with_ttd' => 1]) }}" target="_blank"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Cetak Full TTD</a></li>
                                            <li><a class="dropdown-item" href="{{ route('sparepart.needed.pengajuan.print', ['id' => $p->id, 'with_ttd' => 0]) }}" target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Tanpa TTD</a></li>
                                        </ul>
                                    </div>

                                    @if(auth()->check() && auth()->user()->role === 'noc_leader')
                                        <button class="btn btn-sm btn-light border shadow-sm text-primary"
                                            data-bs-toggle="modal" data-bs-target="#modalEditPengajuan{{ $p->id }}"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('sparepart.needed.pengajuan.destroy', $p->id) }}" method="POST"
                                            class="m-0 delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border shadow-sm text-danger"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Edit Catatan/No Surat khusus Accounting --}}
                                    @if(auth()->check() && auth()->user()->role === 'accounting')
                                        <button type="button" class="btn btn-sm"
                                            style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:8px;padding:6px 10px;"
                                            data-bs-toggle="modal" data-bs-target="#modalNotesSP{{ $p->id }}"
                                            title="Isi / Edit Catatan & No Surat">
                                            <i class="bi bi-journal-text"></i>
                                        </button>
                                    @endif
                                </div>
                            
                        <!-- Modal Info Pengajuan -->
                        <div class="modal fade" id="modalInfoPengajuan{{ $p->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow: hidden;">
                                    <div class="modal-header py-3" style="background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:white;">
                                        <h6 class="modal-title fw-bold mb-0">Detail Pengajuan Sparepart</h6>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body p-0" style="background:#f1f5f9; max-height: 85vh; overflow-y: auto;">
                                        <div class="modal-print-preview">
                                            <div class="preview-header">
                                                <img src="{{ asset('assets/img/logo2.jpg') }}" class="preview-logo"
                                                    onerror="this.src='{{ asset('assets/img/logonustech.png') }}'">
                                                <div class="preview-header-text">
                                                    <h2>FORMULIR PENGAJUAN</h2>
                                                    <div class="subtitle">PENGADAAN BARANG INVENTARIS</div>
                                                </div>
                                            </div>

                                            <div class="preview-info-section mt-4">
                                                <div class="preview-info-row">
                                                    <div class="preview-info-label">Tempat, Tanggal</div>
                                                    <div class="preview-info-separator">:</div>
                                                    <div>{{ $p->tempat_tanggal }}</div>
                                                </div>
                                                <div class="preview-info-row">
                                                    <div class="preview-info-label">Divisi / Bagian</div>
                                                    <div class="preview-info-separator">:</div>
                                                    <div>{{ $p->divisi }}</div>
                                                </div>
                                                <div class="preview-info-row">
                                                    <div class="preview-info-label">No. Surat</div>
                                                    <div class="preview-info-separator">:</div>
                                                    <div>{{ $p->no_surat ?? '-' }}</div>
                                                </div>
                                            </div>

                                            <p style="font-size: 10pt; text-align: justify; margin-bottom: 10px;">
                                                Dengan ini saya mengajukan perangkat sparepart untuk pergantian perangkat yang rusak dengan perincian sebagai berikut :
                                            </p>

                                            <div class="table-responsive" style="width: 100%; overflow-x: auto;">
                                                <table class="preview-table">
                                                    <tr style="background-color: #f2f2f2;">
                                                        <th>No.</th>
                                                        <th>Perangkat</th>
                                                        <th>Qty</th>
                                                        <th>Harga</th>
                                                        <th>TOTAL</th>
                                                        <th>Layanan</th>
                                                        <th>Peruntukan</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                     @if(is_array($p->items) && count($p->items) > 0)
                                                         @foreach($p->items as $idx => $item)
                                                         <tr>
                                                             <td style="text-align: center;">{{ $idx + 1 }}.</td>
                                                             <td style="text-align: left;">{{ $item['perangkat'] ?? '-' }}</td>
                                                             <td style="text-align: center;">{{ $item['qty'] ?? 1 }}</td>
                                                             <td style="text-align: left;">Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}</td>
                                                             <td class="bg-gray-label" style="text-align: left;">Rp {{ number_format(($item['qty'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}</td>
                                                             <td style="text-align: center;">{{ $item['layanan'] ?? '-' }}</td>
                                                             <td style="text-align: center;">{{ $item['peruntukan'] ?? '-' }}</td>
                                                             <td style="text-align: center;">{{ $item['keterangan'] ?? '-' }}</td>
                                                         </tr>
                                                         @endforeach
                                                     @else
                                                         <tr>
                                                             <td colspan="8" style="text-align: center;">Belum ada perangkat.</td>
                                                         </tr>
                                                     @endif
                                                     <tr>
                                                         <td colspan="4" class="bg-gray-label" style="text-align: center;">TOTAL</td>
                                                         <td colspan="4" class="bg-gray-label" style="text-align: left;">Rp {{ number_format($p->grand_total ?? 0, 0, ',', '.') }}</td>
                                                     </tr>
                                                     <tr>
                                                         <td colspan="4" class="bg-gray-label" style="text-align: center;">Terbilang</td>
                                                         <td colspan="4" style="text-align: left; font-style: italic; color: #b71c1c !important;">
                                                             @php
                                                                 $terbilang = '';
                                                                 if($p->data_json) {
                                                                     $decoded = json_decode($p->data_json, true);
                                                                     $terbilang = $decoded['terbilang'] ?? '';
                                                                 }
                                                             @endphp
                                                             {{ $terbilang }}
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td colspan="4" class="bg-gray-label" style="text-align: center;">Catatan</td>
                                                         <td colspan="4" style="text-align: left;">{{ $p->catatan ?? '-' }}</td>
                                                     </tr>
                                                </table>
                                            </div>

                                            <p style="font-size: 10pt; margin-bottom: 15px;">Demikian surat pengajuan ini dibuat, atas perhatiannya saya ucapkan terima kasih.</p>

                                            @php
                                                $dataJson = json_decode($p->data_json, true) ?? [];
                                            @endphp

                                            @if(!empty($dataJson['mengetahui_nama']) && $dataJson['mengetahui_nama'] != '-')
                                                <div style="text-align: center; margin-bottom: 15px; font-size: 10pt;">
                                                    Mataram, {{ $p->updated_at->format('d F Y') }}
                                                </div>
                                            @endif

                                            <div class="preview-signature-grid">
                                                <div>
                                                    <p class="mb-1">Pemohon,</p>
                                                    <div class="preview-sign-img">
                                                        <img src="{{ asset('assets/img/ttd/pemohon.png') }}">
                                                    </div>
                                                    <p class="preview-sign-name">{{ $dataJson['pemohon_nama'] ?? 'Rossie Maulana Septian, S.Kom' }}</p>
                                                    <p class="preview-sign-jabatan">{{ $dataJson['pemohon_jabatan'] ?? 'NOC Leader' }}</p>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Diverifikasi,</p>
                                                    <div class="preview-sign-img">
                                                        @if($p->approved_manager_at)
                                                            <img src="{{ asset('assets/img/ttd/manager.png') }}">
                                                        @endif
                                                    </div>
                                                    <p class="preview-sign-name">{{ $dataJson['diverifikasi1_nama'] ?? 'Dimas Farid Awaludin, S.Kom' }}</p>
                                                    <p class="preview-sign-jabatan">{{ $dataJson['diverifikasi1_jabatan'] ?? 'Manager' }}</p>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Diverifikasi,</p>
                                                    <div class="preview-sign-img" style="height: 70px;">
                                                        @if($p->approved_accounting_at)
                                                            <img src="{{ asset('assets/img/ttd/accounting.png') }}" style="bottom: -20px; position: relative;">
                                                        @endif
                                                    </div>
                                                    <p class="preview-sign-name">{{ $dataJson['diverifikasi2_nama'] ?? 'Baiq Nana Erlina, A.Md' }}</p>
                                                    <p class="preview-sign-jabatan">{{ $dataJson['diverifikasi2_jabatan'] ?? 'Accounting' }}</p>
                                                </div>
                                                <div>
                                                    <p class="mb-1">Disetujui,</p>
                                                    <div class="preview-sign-img">
                                                        @if($p->approved_direktur_at)
                                                            <img src="{{ asset('assets/img/ttd/direktur.png') }}">
                                                        @endif
                                                    </div>
                                                    <p class="preview-sign-name">{{ $dataJson['disetujui_nama'] ?? 'Galuh Zakiyatun, S.Kom' }}</p>
                                                    <p class="preview-sign-jabatan">{{ $dataJson['disetujui_jabatan'] ?? 'Direktur' }}</p>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-center mt-3">
                                                <div style="text-align: center; font-size: 9pt; width: 50%;">
                                                    <p class="mb-1">Mengetahui,</p>
                                                    <div class="preview-sign-img">
                                                        @if($p->approved_penasihat_at)
                                                            <img src="{{ asset('assets/img/ttd/penasihat.png') }}">
                                                        @endif
                                                    </div>
                                                    <p class="preview-sign-name">{{ $dataJson['mengetahui_nama'] ?? 'Raden Yuniarta Alba, S.Kom' }}</p>
                                                    <p class="preview-sign-jabatan">{{ $dataJson['mengetahui_jabatan'] ?? 'Penasihat' }}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada data pengajuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $pengajuans->firstItem() ?? 0 }} to {{ $pengajuans->lastItem() ?? 0 }}
                of&nbsp;<strong>{{ $pengajuans->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $pengajuans->appends(request()->query())->links("pagination::bootstrap-5") }}
            </nav>
        </div>
    </div>

    {{-- ===== MODALS APPROVE ACCOUNTING + NOTES SPAREPART ===== --}}
    @if(auth()->check() && auth()->user()->role === 'accounting')
    @foreach($pengajuans as $p)
        {{-- MODAL APPROVE ACCOUNTING SPAREPART --}}
        <div class="modal fade" id="modalApproveAccSP{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#10b981,#059669);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-check-circle me-2"></i>Setujui &amp; Isi Data Accounting
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('sparepart.needed.approve', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 small mb-3" style="background:#eff6ff;">
                                <i class="bi bi-info-circle me-1"></i>
                                Nomor Surat dan Catatan <strong>tidak wajib diisi</strong>. Anda tetap bisa menyetujui tanpa mengisinya.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $p->no_surat }}"
                                    placeholder="Contoh: 001/ACC/SP/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan <span class="text-muted">(opsional)</span></label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $p->catatan }}</textarea>
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

        {{-- MODAL EDIT CATATAN / NO SURAT SPAREPART (Accounting saja) --}}
        <div class="modal fade" id="modalNotesSP{{ $p->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-journal-text me-2"></i>Isi / Edit Catatan &amp; No Surat
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('sparepart.needed.accounting.notes', $p->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-warning border-0 small mb-3" style="background:#fffbeb;">
                                <i class="bi bi-lock me-1"></i>
                                Hanya <strong>Accounting</strong> yang dapat mengisi/mengubah data ini. Semua field bersifat opsional.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat</label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $p->no_surat }}"
                                    placeholder="Contoh: 001/ACC/SP/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $p->catatan }}</textarea>
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
    @endforeach
    @endif
    {{-- ===== /MODALS APPROVE ACCOUNTING + NOTES SPAREPART ===== --}}

    <!-- Modal Print Pengajuan -->
    <div class="modal fade" id="modalPrintPengajuan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg text-start">
                <div class="modal-header text-white d-flex justify-content-center position-relative"
                    style="background-color: #198754; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title w-100 text-center fw-bold">Print Formulir Pengajuan</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form action="{{ route('sparepart.needed.print') }}" method="POST" target="_blank"
                        id="formPengajuan">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Tempat, Tanggal</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted fw-bold">Mataram,</span>
                                    <input type="date" id="picker_tanggal" class="form-control"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                                </div>
                                <input type="hidden" name="tempat_tanggal" id="hidden_tempat_tanggal"
                                    value="Mataram, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Divisi / Bagian</label>
                                <input type="text" name="divisi" class="form-control"
                                    value="Manage Service AI BAKTI" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">No. Pengajuan</label>
                            <input type="text" name="nomor" class="form-control" placeholder="Contoh: 001/SP/2026">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-muted mb-0">Detail Perangkat</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-add-item-trigger" id="btnAddItem"><i
                                    class="bi bi-plus"></i></button>
                        </div>

                        <div id="itemsContainer" class="items-container-dynamic">
                            <div class="item-row border p-3 mb-3 rounded position-relative bg-white">
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger position-absolute btn-remove-item"
                                    style="top: 10px; right: 10px; z-index: 10;" title="Hapus"><i
                                        class="bi bi-x"></i></button>
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Perangkat</label>
                                        <input type="text" name="perangkat[]" class="form-control" required
                                            placeholder="Contoh: ROUTER">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Qty</label>
                                        <input type="number" name="qty[]" class="form-control input-qty" min="1"
                                            value="1" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Harga
                                            Satuan</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="harga[]" class="form-control input-harga"
                                                required placeholder="50000">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Total</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control bg-light input-subtotal" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Layanan</label>
                                        <input type="text" name="layanan[]" class="form-control" value="BMN">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Peruntukan</label>
                                        <input type="text" name="peruntukan[]" class="form-control" value="STOK">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Keterangan</label>
                                        <input type="text" name="keterangan[]" class="form-control" value="-">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4 text-end fw-bold">Grand Total :</div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white">Rp</span>
                                    <input type="text" id="grand_total_display"
                                        class="form-control bg-light fw-bold text-success grand-total-display" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">Terbilang</label>
                            <input type="text" id="input_terbilang" name="terbilang"
                                class="form-control bg-light text-primary fw-bold input-terbilang" readonly>
                        </div>

                        <hr>
                        <h6 class="fw-bold text-muted mb-3">Tertanda</h6>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Pemohon</label>
                                <input type="text" name="pemohon_nama" class="form-control mb-1"
                                    placeholder="Nama Pemohon"
                                    value="{{ auth()->user() ? auth()->user()->name : 'Rossie Maulana Septian, s.Kom' }}"
                                    required>
                                <input type="text" name="pemohon_jabatan" class="form-control"
                                    placeholder="Jabatan Pemohon" value="NOC Leader" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Diverifikasi 1</label>
                                <input type="text" name="diverifikasi1_nama" class="form-control mb-1"
                                    value="Dimas Farid Awaludin, S.Kom">
                                <input type="text" name="diverifikasi1_jabatan" class="form-control" value="Manager">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-4">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Diverifikasi 2</label>
                                <input type="text" name="diverifikasi2_nama" class="form-control mb-1"
                                    value="Baiq Nana Erlina, A.Md">
                                <input type="text" name="diverifikasi2_jabatan" class="form-control" value="Accounting">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Disetujui</label>
                                <input type="text" name="disetujui_nama" class="form-control mb-1"
                                    value="Galuh Zakiyatun, S.Kom">
                                <input type="text" name="disetujui_jabatan" class="form-control" value="Direktur">
                            </div>
                            <div class="col-4">
                                <label class="form-label fw-bold" style="font-size: 0.85rem;">Mengetahui</label>
                                <input type="text" name="mengetahui_nama" class="form-control mb-1"
                                    value="Raden Yuniarta Alba, S.Kom">
                                <input type="text" name="mengetahui_jabatan" class="form-control" value="Penasihat">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light px-4 rounded-3 border"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit"
                                onclick="document.getElementById('formPengajuan').action='{{ route('sparepart.needed.pengajuan.store') }}'; document.getElementById('formPengajuan').target='_self';"
                                class="btn btn-primary px-4 rounded-3 d-flex align-items-center gap-2">
                                <i class="bi bi-save"></i> Save
                            </button>
                            <button type="submit"
                                onclick="document.getElementById('formPengajuan').action='{{ route('sparepart.needed.print') }}'; document.getElementById('formPengajuan').target='_blank';"
                                class="btn btn-success px-4 rounded-3 d-flex align-items-center gap-2">
                                <i class="bi bi-printer"></i> Print
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->role === 'noc_leader')
        @foreach($pengajuans as $p)
            <!-- Modal Edit Pengajuan {{ $p->id }} -->
            <div class="modal fade" id="modalEditPengajuan{{ $p->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow-lg text-start">
                        <div class="modal-header text-white d-flex justify-content-center position-relative"
                            style="background-color: #0d6efd; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title w-100 text-center fw-bold">Edit Formulir Pengajuan</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body pt-4">
                            <form action="{{ route('sparepart.needed.pengajuan.update', $p->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Tempat, Tanggal</label>
                                        <input type="text" name="tempat_tanggal" class="form-control"
                                            value="{{ $p->tempat_tanggal }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Divisi / Bagian</label>
                                        <input type="text" name="divisi" class="form-control"
                                            value="{{ $p->divisi }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size: 0.85rem;">No. Pengajuan</label>
                                    <input type="text" name="nomor" class="form-control" 
                                        value="{{ $p->nomor }}"
                                        placeholder="Contoh: 001/SP/2026" required>
                                </div>

                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-muted mb-0">Detail Perangkat</h6>
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-add-item-trigger">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>

                                <div id="itemsContainerEdit{{ $p->id }}" class="items-container-dynamic">
                                    @if(is_array($p->items))
                                        @foreach($p->items as $itemIdx => $item)
                                            <div class="item-row border p-3 mb-3 rounded position-relative bg-white">
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger position-absolute btn-remove-item"
                                                    style="top: 10px; right: 10px; z-index: 10; {{ count($p->items) <= 1 ? 'display: none;' : '' }}" title="Hapus"><i
                                                        class="bi bi-x"></i></button>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Perangkat</label>
                                                        <input type="text" name="perangkat[]" class="form-control" required
                                                            value="{{ $item['perangkat'] ?? '' }}"
                                                            placeholder="Contoh: ROUTER">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Qty</label>
                                                        <input type="number" name="qty[]" class="form-control input-qty" min="1"
                                                            value="{{ $item['qty'] ?? 1 }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Harga Satuan</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" name="harga[]" class="form-control input-harga"
                                                                value="{{ $item['harga'] ?? 0 }}"
                                                                required placeholder="50000">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Total</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="text" class="form-control bg-light input-subtotal" 
                                                                value="{{ number_format(($item['qty'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Layanan</label>
                                                        <input type="text" name="layanan[]" class="form-control" value="{{ $item['layanan'] ?? 'BMN' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Peruntukan</label>
                                                        <input type="text" name="peruntukan[]" class="form-control" value="{{ $item['peruntukan'] ?? 'STOK' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Keterangan</label>
                                                        <input type="text" name="keterangan[]" class="form-control" value="{{ $item['keterangan'] ?? '-' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-4 text-end fw-bold">Grand Total :</div>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-text bg-success text-white">Rp</span>
                                            <input type="text"
                                                class="form-control bg-light fw-bold text-success grand-total-display" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size: 0.85rem;">Terbilang</label>
                                    <input type="text" name="terbilang"
                                        class="form-control bg-light text-primary fw-bold input-terbilang" readonly>
                                </div>

                                <hr>
                                <h6 class="fw-bold text-muted mb-3">Tertanda</h6>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Pemohon</label>
                                        <input type="text" name="pemohon_nama" class="form-control mb-1"
                                            value="{{ $p->pemohon_nama }}" required>
                                        <input type="text" name="pemohon_jabatan" class="form-control"
                                            value="{{ $p->pemohon_jabatan }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Diverifikasi 1</label>
                                        <input type="text" name="diverifikasi1_nama" class="form-control mb-1"
                                            value="{{ $p->diverifikasi1_nama }}">
                                        <input type="text" name="diverifikasi1_jabatan" class="form-control" 
                                            value="{{ $p->diverifikasi1_jabatan }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Diverifikasi 2</label>
                                        <input type="text" name="diverifikasi2_nama" class="form-control mb-1"
                                            value="{{ $p->diverifikasi2_nama }}">
                                        <input type="text" name="diverifikasi2_jabatan" class="form-control" 
                                            value="{{ $p->diverifikasi2_jabatan }}">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Disetujui</label>
                                        <input type="text" name="disetujui_nama" class="form-control mb-1"
                                            value="{{ $p->disetujui_nama }}">
                                        <input type="text" name="disetujui_jabatan" class="form-control" 
                                            value="{{ $p->disetujui_jabatan }}">
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Mengetahui</label>
                                        <input type="text" name="mengetahui_nama" class="form-control mb-1"
                                            value="{{ $p->mengetahui_nama }}">
                                        <input type="text" name="mengetahui_jabatan" class="form-control" 
                                            value="{{ $p->mengetahui_jabatan }}">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-light px-4 rounded-3 border"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit"
                                        class="btn btn-primary px-4 rounded-3 d-flex align-items-center gap-2">
                                        <i class="bi bi-save"></i> Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // For both Add and Edit modals:
            function setupModalCalculations(modalElement) {
                const itemsContainer = modalElement.querySelector('.items-container-dynamic');
                if (!itemsContainer) return;

                function terbilangRupiah(angka) {
                    var bilangan = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
                    var bg = "";
                    if (angka < 12) { bg = " " + bilangan[angka]; }
                    else if (angka < 20) { bg = terbilangRupiah(angka - 10) + " Belas"; }
                    else if (angka < 100) { bg = terbilangRupiah(Math.floor(angka / 10)) + " Puluh" + terbilangRupiah(angka % 10); }
                    else if (angka < 200) { bg = " Seratus" + terbilangRupiah(angka - 100); }
                    else if (angka < 1000) { bg = terbilangRupiah(Math.floor(angka / 100)) + " Ratus" + terbilangRupiah(angka % 100); }
                    else if (angka < 2000) { bg = " Seribu" + terbilangRupiah(angka - 1000); }
                    else if (angka < 1000000) { bg = terbilangRupiah(Math.floor(angka / 1000)) + " Ribu" + terbilangRupiah(angka % 1000); }
                    else if (angka < 1000000000) { bg = terbilangRupiah(Math.floor(angka / 1000000)) + " Juta" + terbilangRupiah(angka % 1000000); }
                    else if (angka < 1000000000000) { bg = terbilangRupiah(Math.floor(angka / 1000000000)) + " Milyar" + terbilangRupiah(angka % 1000000000); }
                    return bg;
                }

                function calculateTotal() {
                    let grandTotal = 0;
                    itemsContainer.querySelectorAll('.item-row').forEach(row => {
                        let qty = parseInt(row.querySelector('.input-qty').value) || 0;
                        let harga = parseInt(row.querySelector('.input-harga').value) || 0;
                        let subTotal = qty * harga;
                        grandTotal += subTotal;
                        row.querySelector('.input-subtotal').value = new Intl.NumberFormat('id-ID').format(subTotal);
                    });

                    const gtDisplay = modalElement.querySelector('.grand-total-display');
                    if (gtDisplay) gtDisplay.value = new Intl.NumberFormat('id-ID').format(grandTotal);

                    const inputTerbilang = modalElement.querySelector('.input-terbilang');
                    if (inputTerbilang) {
                        if (grandTotal > 0) {
                            inputTerbilang.value = terbilangRupiah(grandTotal).trim() + " Rupiah";
                        } else {
                            inputTerbilang.value = "";
                        }
                    }
                }

                // Event delegation for input fields
                itemsContainer.addEventListener('input', function (e) {
                    if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga')) {
                        calculateTotal();
                    }
                });

                // Add Item button
                const btnAddItem = modalElement.querySelector('.btn-add-item-trigger');
                if (btnAddItem) {
                    btnAddItem.addEventListener('click', function () {
                        const firstRow = itemsContainer.querySelector('.item-row').cloneNode(true);

                        // Clear values in cloned row
                        firstRow.querySelectorAll('input').forEach(input => {
                            if (input.name == 'layanan[]' || input.getAttribute('name') == 'layanan[]') input.value = 'BMN';
                            else if (input.name == 'peruntukan[]' || input.getAttribute('name') == 'peruntukan[]') input.value = 'STOK';
                            else if (input.name == 'keterangan[]' || input.getAttribute('name') == 'keterangan[]') input.value = '-';
                            else if (input.name == 'qty[]' || input.getAttribute('name') == 'qty[]') input.value = '1';
                            else if (input.name == 'harga[]' || input.getAttribute('name') == 'harga[]') input.value = '';
                            else if (input.classList.contains('input-subtotal')) input.value = '0';
                            else input.value = '';
                        });

                        // Make sure there is a remove button
                        let btnRemove = firstRow.querySelector('.btn-remove-item');
                        if (!btnRemove) {
                            btnRemove = document.createElement('button');
                            btnRemove.type = 'button';
                            btnRemove.className = 'btn btn-sm btn-outline-danger position-absolute btn-remove-item';
                            btnRemove.style.cssText = 'top: 10px; right: 10px; z-index: 10;';
                            btnRemove.title = 'Hapus';
                            btnRemove.innerHTML = '<i class="bi bi-x"></i>';
                            firstRow.appendChild(btnRemove);
                        } else {
                            btnRemove.style.display = 'block';
                        }

                        itemsContainer.appendChild(firstRow);
                        calculateTotal();
                    });
                }

                // Remove Item button (delegation)
                itemsContainer.addEventListener('click', function (e) {
                    const btnRemove = e.target.closest('.btn-remove-item');
                    if (btnRemove) {
                        if (itemsContainer.querySelectorAll('.item-row').length > 1) {
                            btnRemove.closest('.item-row').remove();
                            calculateTotal();
                        } else {
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: 'Minimal harus ada 1 perangkat!',
                                });
                            } else {
                                alert('Minimal harus ada 1 perangkat!');
                            }
                        }
                    }
                });

                // Initial calculate
                calculateTotal();
            }

            // Bind to all modals that have itemsContainer
            document.querySelectorAll('.modal').forEach(modal => {
                setupModalCalculations(modal);
            });

            // Date Picker Logic (only for Add modal with id picker_tanggal)
            const pickerTanggal = document.getElementById('picker_tanggal');
            const hiddenTempatTanggal = document.getElementById('hidden_tempat_tanggal');

            if (pickerTanggal && hiddenTempatTanggal) {
                const bulanIndo = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                pickerTanggal.addEventListener('change', function () {
                    const dateVal = new Date(this.value);
                    if (!isNaN(dateVal.getTime())) {
                        const tgl = dateVal.getDate();
                        const bln = bulanIndo[dateVal.getMonth()];
                        const thn = dateVal.getFullYear();
                        hiddenTempatTanggal.value = `Mataram, ${tgl} ${bln} ${thn}`;
                    }
                });
            }
        });
        function showImage(srcUrl) {
            Swal.fire({
                imageUrl: srcUrl,
                imageAlt: 'Foto Resi / Barang',
                showConfirmButton: false,
                showCloseButton: true,
                width: 'auto',
                padding: '1em',
                background: 'transparent',
                customClass: {
                    backdrop: 'swal2-backdrop-blur',
                    image: 'swal2-custom-image'
                }
            });
        }

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif

        function bindDeleteEvents() {
            document.querySelectorAll('.delete-form').forEach(form => {
                // Hapus event listener lama jika ada (untuk mencegah double listener saat ajax)
                const newForm = form.cloneNode(true);
                form.parentNode.replaceChild(newForm, form);

                newForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus data ini?',
                        text: "Tindakan ini tidak dapat dibatalkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        }

        // Panggil pertama kali
        bindDeleteEvents();

        // AJAX Table Reload
        function fetchTableData(url = null) {
            const container = document.getElementById('tableContainer');
            // Sedikit efek opacity saat transisi
            container.style.opacity = '0.5';

            let fetchUrl = url;
            if (!fetchUrl) {
                const form = document.getElementById('filterForm');
                const params = new URLSearchParams(new FormData(form));
                fetchUrl = `${form.action}?${params.toString()}`;
            }

            fetch(fetchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    document.getElementById('tableContainer').innerHTML = doc.getElementById('tableContainer').innerHTML;
                    document.getElementById('summaryBadge').innerHTML = doc.getElementById('summaryBadge').innerHTML;

                    container.style.opacity = '1';
                    bindDeleteEvents();
                    bindPaginationEvents();

                    // Update URL bar without reloading
                    window.history.pushState({}, '', fetchUrl);
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    container.style.opacity = '1';
                });
        }

        function bindPaginationEvents() {
            document.querySelectorAll('#tableContainer .pagination a').forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    fetchTableData(this.href);
                });
            });
        }

        bindPaginationEvents();

        // Prevent form standar submit
        document.getElementById('filterForm').addEventListener('submit', function (e) {
            e.preventDefault();
            fetchTableData();
        });

        // Trigger on typing delay
        let typingTimer;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(() => fetchTableData(), 500);
            });
        }


        // Trigger on dropdown change
        const statusSelect = document.querySelector('select[name="status"]');
        if (statusSelect) {
            statusSelect.addEventListener('change', () => fetchTableData());
        }
    </script>

    <!-- Modal Reject -->
    <div class="modal fade" id="modalReject" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 shadow-lg border-0">
                <div class="modal-header bg-danger text-white rounded-top-4">
                    <h5 class="modal-title fw-bold">Alasan Penolakan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formReject" method="POST">
                    @csrf
                    <div class="modal-body">
                        <textarea name="reason" rows="4" class="form-control" placeholder="Masukkan alasan penolakan..."
                            required></textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light border px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4">Kirim Penolakan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmApproval(url) {
            Swal.fire({
                title: 'Konfirmasi Persetujuan',
                text: "Apakah Anda yakin ingin menyetujui pengajuan ini?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = `@csrf`;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function showRejectModal(url) {
            const form = document.getElementById('formReject');
            form.action = url;
            new bootstrap.Modal(document.getElementById('modalReject')).show();
        }

        // Simpan pengajuan ke DB saat form diproses (sebelum print)
        const formPengajuan = document.getElementById('formPengajuan');
        if (formPengajuan) {
            formPengajuan.addEventListener('submit', function (e) {
                // Gunakan Fetch untuk simpan ke database secara background agar print tetap jalan
                const formData = new FormData(this);
                fetch("{{ route('sparepart.needed.pengajuan.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                }).then(() => {
                    // Refresh table pengajuan setelah simpan sukses
                    setTimeout(() => window.location.reload(), 1000);
                });
            });
        }
    </script>
</body>

</html>
