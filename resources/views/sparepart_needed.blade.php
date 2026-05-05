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
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ route('mydashboard') }}" class="tab" style="text-decoration: none; color: Black;"><i
                class="bi bi-arrow-left"></i> Back to Dashboard</a>
        <a href="{{ route('sparepart_needed') }}" class="tab active"
            style="text-decoration: none; color: White;">Sparepart Needed</a>
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
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user']))
                    <button type="button" class="btn-action bi bi-plus" title="Tambah Data" data-bs-toggle="modal"
                        data-bs-target="#modalTambahSparepart"></button>
                @endif
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('sparepart_needed') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end" id="filterForm">
                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user']))
                        <div class="col-auto">
                            <button type="button"
                                class="btn btn-primary btn-sm rounded-pill d-flex align-items-center gap-2 px-3 fw-semibold shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#modalPrintPengajuan"
                                style="height: 38px; border: none; background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
                                <i class="bi bi-plus-lg"></i> Buat Pengajuan
                            </button>
                        </div>
                    @endif

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
                <div class="modal-dialog modal-dialog-centered">
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

                                <div class="mb-3">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Upload Foto
                                        (Resi) <i>(Opsional)</i></label>
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                    <div class="form-text" style="font-size: 0.75rem;">Format diperbolehkan: JPG, PNG,
                                        GIF. Maks: 5MB.</div>
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
                            <th class="text-center">FOTO RESI</th>
                            <th class="text-center">URGENSI</th>
                            <th class="text-center">STATUS</th>
                            <th>KETERANGAN</th>
                            <th>TANGGAL REQUEST</th>
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user']))
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
                                    @if($item->photo)
                                        <a href="javascript:void(0)" onclick="showImage(this.querySelector('img').src)">
                                            <img src="{{ asset('storage/' . $item->photo) }}"
                                                onerror="this.onerror=null; this.src='{{ asset('storage_public/' . $item->photo) }}';"
                                                alt="Foto"
                                                style="width: 45px; height: 45px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border: 1px solid #ddd; transition: transform 0.2s;"
                                                onmouseover="this.style.transform='scale(1.1)'"
                                                onmouseout="this.style.transform='scale(1)'">
                                        </a>
                                    @else
                                        <span class="text-muted"><i class="bi bi-image"
                                                style="font-size: 1.5rem; opacity: 0.3;"></i></span>
                                    @endif
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

                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user']))
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
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user']))
                                <div class="modal fade" id="modalEditSparepart{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
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

                                                    <div class="mb-3">
                                                        <label class="form-label"
                                                            style="font-size: 0.85rem; font-weight: 600;">Update Foto</label>
                                                        @if($item->photo)
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $item->photo) }}"
                                                                    onerror="this.onerror=null; this.src='{{ asset('storage_public/' . $item->photo) }}';"
                                                                    alt="Foto Lama"
                                                                    style="height: 60px; border-radius: 6px; border: 1px solid #ddd; object-fit: cover;">
                                                            </div>
                                                        @endif
                                                        <input type="file" name="photo" class="form-control" accept="image/*">
                                                        <div class="form-text" style="font-size: 0.75rem;">Biarkan kosong jika
                                                            tidak
                                                            ingin mengubah foto.</div>
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

    <!-- TABEL PENGAJUAN -->
    <div class="content-container mt-4">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <h5 class="m-0 fw-bold"><i class="bi bi-file-earmark-text"></i> Data Formulir Pengajuan</h5>
        </div>

        <div class="table-responsive-custom" id="tablePengajuanContainer">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="min-width: 60px;">No</th>
                        <th style="min-width: 150px;">Tanggal</th>
                        <th style="min-width: 200px;">Nomor</th>
                        <th style="min-width: 250px;">Divisi</th>
                        <th style="min-width: 150px;">Grand Total</th>
                        <th style="min-width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengajuans as $index => $p)
                        <tr>
                            <td>{{ $pengajuans->firstItem() + $index }}</td>
                            <td>{{ $p->tempat_tanggal }}</td>
                            <td>{{ $p->nomor }}</td>
                            <td>{{ $p->divisi }}</td>
                            <td>Rp {{ number_format($p->grand_total, 0, ',', '.') }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <form action="{{ route('sparepart.needed.print') }}" method="POST" target="_blank" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="tempat_tanggal" value="{{ $p->tempat_tanggal }}">
                                        <input type="hidden" name="divisi" value="{{ $p->divisi }}">
                                        <input type="hidden" name="nomor" value="{{ $p->nomor }}">
                                        <input type="hidden" name="terbilang" value="{{ $p->terbilang }}">
                                        <input type="hidden" name="pemohon_nama" value="{{ $p->pemohon_nama }}">
                                        <input type="hidden" name="pemohon_jabatan" value="{{ $p->pemohon_jabatan }}">
                                        <input type="hidden" name="diverifikasi1_nama" value="{{ $p->diverifikasi1_nama }}">
                                        <input type="hidden" name="diverifikasi1_jabatan" value="{{ $p->diverifikasi1_jabatan }}">
                                        <input type="hidden" name="diverifikasi2_nama" value="{{ $p->diverifikasi2_nama }}">
                                        <input type="hidden" name="diverifikasi2_jabatan" value="{{ $p->diverifikasi2_jabatan }}">
                                        <input type="hidden" name="disetujui_nama" value="{{ $p->disetujui_nama }}">
                                        <input type="hidden" name="disetujui_jabatan" value="{{ $p->disetujui_jabatan }}">
                                        <input type="hidden" name="mengetahui_nama" value="{{ $p->mengetahui_nama }}">
                                        <input type="hidden" name="mengetahui_jabatan" value="{{ $p->mengetahui_jabatan }}">
                                        
                                        @if(is_array($p->items))
                                            @foreach($p->items as $item)
                                                <input type="hidden" name="perangkat[]" value="{{ $item['perangkat'] ?? '' }}">
                                                <input type="hidden" name="qty[]" value="{{ $item['qty'] ?? 1 }}">
                                                <input type="hidden" name="harga[]" value="{{ $item['harga'] ?? 0 }}">
                                                <input type="hidden" name="layanan[]" value="{{ $item['layanan'] ?? '' }}">
                                                <input type="hidden" name="peruntukan[]" value="{{ $item['peruntukan'] ?? '' }}">
                                                <input type="hidden" name="keterangan[]" value="{{ $item['keterangan'] ?? '' }}">
                                            @endforeach
                                        @endif
                                        <button type="submit" class="btn btn-sm btn-success" title="Print"><i class="bi bi-printer"></i></button>
                                    </form>
                                    
                                    @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                        <form action="{{ route('sparepart.needed.pengajuan.destroy', $p->id) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data pengajuan.</td>
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
                    <form action="{{ route('sparepart.needed.print') }}" method="POST" target="_blank" id="formPengajuan">
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
                                    value="Manage Service AI BAKTI 2026 APROTECH" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">No. Pengajuan</label>
                            <input type="text" name="nomor" class="form-control" placeholder="Contoh: 001/SP/2026">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-muted mb-0">Detail Perangkat</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="btnAddItem"><i
                                    class="bi bi-plus"></i></button>
                        </div>

                        <div id="itemsContainer">
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
                                        class="form-control bg-light fw-bold text-success" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">Terbilang</label>
                            <input type="text" id="input_terbilang" name="terbilang"
                                class="form-control bg-light text-primary fw-bold" readonly>
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
                            <button type="submit" onclick="document.getElementById('formPengajuan').action='{{ route('sparepart.needed.pengajuan.store') }}'; document.getElementById('formPengajuan').target='_self';"
                                class="btn btn-primary px-4 rounded-3 d-flex align-items-center gap-2">
                                <i class="bi bi-save"></i> Save
                            </button>
                            <button type="submit" onclick="document.getElementById('formPengajuan').action='{{ route('sparepart.needed.print') }}'; document.getElementById('formPengajuan').target='_blank';"
                                class="btn btn-success px-4 rounded-3 d-flex align-items-center gap-2">
                                <i class="bi bi-printer"></i> Print
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                document.querySelectorAll('.item-row').forEach(row => {
                    let qty = parseInt(row.querySelector('.input-qty').value) || 0;
                    let harga = parseInt(row.querySelector('.input-harga').value) || 0;
                    let subTotal = qty * harga;
                    grandTotal += subTotal;
                    row.querySelector('.input-subtotal').value = new Intl.NumberFormat('id-ID').format(subTotal);
                });

                const gtDisplay = document.getElementById('grand_total_display');
                if (gtDisplay) gtDisplay.value = new Intl.NumberFormat('id-ID').format(grandTotal);

                const inputTerbilang = document.getElementById('input_terbilang');
                if (inputTerbilang) {
                    if (grandTotal > 0) {
                        inputTerbilang.value = terbilangRupiah(grandTotal).trim() + " Rupiah";
                    } else {
                        inputTerbilang.value = "";
                    }
                }
            }

            const itemsContainer = document.getElementById('itemsContainer');

            // Event delegation for input fields
            if (itemsContainer) {
                itemsContainer.addEventListener('input', function (e) {
                    if (e.target.classList.contains('input-qty') || e.target.classList.contains('input-harga')) {
                        calculateTotal();
                    }
                });
            }

            // Add Item button
            const btnAddItem = document.getElementById('btnAddItem');
            if (btnAddItem) {
                btnAddItem.addEventListener('click', function () {
                    if (!itemsContainer) return;
                    const firstRow = itemsContainer.querySelector('.item-row').cloneNode(true);

                    // Clear values in cloned row
                    firstRow.querySelectorAll('input').forEach(input => {
                        if (input.name == 'layanan[]') input.value = 'BMN';
                        else if (input.name == 'peruntukan[]') input.value = 'STOK';
                        else if (input.name == 'keterangan[]') input.value = '-';
                        else if (input.name == 'qty[]') input.value = '1';
                        else input.value = '';
                    });

                    itemsContainer.appendChild(firstRow);
                    calculateTotal();
                });
            }

            // Remove Item button (delegation)
            if (itemsContainer) {
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
            }

            // Initial calculate
            calculateTotal();

            // Date Picker Logic
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
</body>

</html>