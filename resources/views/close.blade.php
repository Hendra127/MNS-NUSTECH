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
        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
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
            .search-form, .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
            }
        }
        /* Sync with Open Page Table Style */
        .table-container {
            overflow-x: auto;
            max-height: 600px;
            overflow-y: auto;
        }
        .table-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-container thead th {
            position: sticky;
            top: 0;
            background-color: #1B435D !important;
            color: white !important;
            z-index: 10;
            padding: 10px 12px;
            font-size: 12px;
            text-align: center;
            border: 1px solid #2c5a75;
        }
        .table-container tbody td {
            padding: 8px 12px !important; /* More compact spacing */
            font-size: 13px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .sticky-col {
            position: sticky !important;
            background-color: white;
            z-index: 5;
        }
        .col-no { left: 0; min-width: 50px; }
        .col-site-id { left: 50px; min-width: 100px; }
        .col-nama_site { left: 150px; min-width: 200px; border-right: 2px solid #dee2e6 !important; }
        thead th.sticky-col { z-index: 15 !important; background-color: #1B435D !important; }
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
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary Tiket</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Close: <b>{{ $closeAllCount }}</b></span>
            <span class="summary-badge text-black">Close Hari Ini: <b>{{ $todayCount }}</b></span>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="actions">
                <a href="{{ route('close.ticket.export') }}" class="btn-action bi bi-download" title="Download Excel" style="text-decoration: none; line-height: 1.8;"></a>
            </div>
            <form method="GET" action="{{ route('close.ticket') }}" class="search-form">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i> </button>
                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none;">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>
        {{-- TABLE --}}
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th class="sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_site">NAMA SITE</th>
                        <th>KATEGORI</th>
                        <th>TANGGAL OPEN</th>
                        <th>TANGGAL CLOSE</th>
                        <th>DURASI</th>
                        <th>STATUS</th>
                        <th>CE</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th>AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $i => $t)
                    <tr>
                        <td class="text-center sticky-col col-no">{{ $tickets->firstItem() + $i }}</td>
                        <td class="text-center sticky-col col-site-id">{{ $t->site_code }}</td>
                        <td class="sticky-col col-nama_site">{{ $t->nama_site }}</td>
                        <td class="text-center">{{ $t->kategori }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                        <td class="text-center">{{ $t->tanggal_close ? \Carbon\Carbon::parse($t->tanggal_close)->format('d M Y') : '-' }}</td>
                        <td class="text-center">{{ number_format($t->durasi, 0) }} Hari</td>
                        <td class="text-center"><span class="status-badge">CLOSED</span></td>
                        <td>{{ $t->ce }}</td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <td class="text-center">
                            <button class="btn btn-sm bi bi-pencil" data-bs-toggle="modal" data-bs-target="#modalEditTicket{{ $t->id }}">
                            </button>
                            <form action="{{ route('close.ticket.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm bi bi-trash btn-delete" data-name="{{ $t->nama_site }}">
                                </button>
                            </form>
                            <button type="button" class="btn btn-sm bi bi-info-circle" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalInfo{{ $t->id }}">
                            </button>
                            <!-- Modal Info -->
                            <div class="modal fade" id="modalInfo{{ $t->id }}" tabindex="-1" aria-labelledby="label{{ $t->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header border-0 p-4 d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #00d2ff 0%, #3a7bd5 100%);">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-white bg-opacity-25 p-2 rounded-circle">
                                                    <i class="bi bi-info-circle-fill text-white fs-4"></i>
                                                </div>
                                                <div>
                                                    <h5 class="modal-title text-white fw-bold mb-0" id="label{{ $t->id }}">Detail Tiket Site</h5>
                                                    <small class="text-white text-opacity-75">Informasi lengkap perbaikan perangkat</small>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4 bg-light text-start">
                                            <div class="row g-4">
                                                <div class="col-md-6">
                                                    <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                                                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center gap-2">
                                                            <i class="bi bi-geo-alt-fill"></i> Lokasi & Identitas
                                                        </h6>
                                                        <div class="d-flex flex-column gap-2">
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Site ID</span>
                                                                <span class="fw-bold">{{ $t->site_code }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Nama Site</span>
                                                                <span class="fw-bold text-end" style="max-width: 150px;">{{ $t->nama_site }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Provinsi</span>
                                                                <span class="fw-semibold">{{ $t->provinsi }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Kabupaten</span>
                                                                <span class="fw-semibold">{{ $t->kabupaten }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Kategori</span>
                                                                <span class="badge bg-info bg-opacity-10 text-info fw-bold">{{ $t->kategori }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="bg-white p-3 rounded-4 shadow-sm h-100">
                                                        <h6 class="fw-bold text-success mb-3 d-flex align-items-center gap-2">
                                                            <i class="bi bi-clock-history"></i> Progres & Waktu
                                                        </h6>
                                                        <div class="d-flex flex-column gap-2">
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Tgl Open</span>
                                                                <span class="fw-bold">{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Tgl Close</span>
                                                                <span class="fw-bold text-success">{{ $t->tanggal_close ? \Carbon\Carbon::parse($t->tanggal_close)->format('d M Y') : '-' }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Status</span>
                                                                <span class="badge bg-secondary text-white fw-bold px-3 rounded-pill">CLOSED</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Durasi</span>
                                                                <span class="text-danger fw-bold fs-5">{{ number_format($t->durasi, 0) }} Hari</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">CE</span>
                                                                <span class="fw-semibold">{{ $t->ce ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="bg-white p-3 rounded-4 shadow-sm">
                                                        <h6 class="fw-bold text-danger mb-3 d-flex align-items-center gap-2">
                                                            <i class="bi bi-exclamation-triangle-fill"></i> Detail Teknis
                                                        </h6>
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <div class="p-3 bg-light rounded-3 h-100">
                                                                    <div class="text-muted small fw-bold mb-1">KENDALA UTAMA</div>
                                                                    <p class="mb-0 fw-semibold text-dark">{{ $t->kendala }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="p-3 bg-light rounded-3 h-100">
                                                                    <div class="text-muted small fw-bold mb-1">EVIDENCE</div>
                                                                    <p class="mb-0 fw-semibold text-dark">{{ $t->evidence ?? 'TIDAK ADA' }}</p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="p-3 bg-light rounded-3 mb-3">
                                                                    <div class="text-muted small fw-bold mb-1">DETAIL PROBLEM</div>
                                                                    <p class="mb-0 text-dark small" style="line-height: 1.6;">{{ $t->detail_problem }}</p>
                                                                </div>
                                                                <div class="p-3 rounded-3" style="background-color: #f0f7ff; border-left: 4px solid #3a7bd5;">
                                                                    <div class="text-primary small fw-bold mb-1">PLAN ACTION / TINDAKAN</div>
                                                                    <p class="mb-0 text-dark small" style="line-height: 1.6;">{{ $t->plan_actions }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 bg-light">
                                            <button type="button" class="btn btn-primary px-4 rounded-pill shadow-sm" data-bs-dismiss="modal">
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
        <div class="mt-3">
            {{ $tickets->appends(['q' => $search])->links() }}
        </div>
    </div>
{{-- MODAL FILTER --}}
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center">Filter Data Tiket</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('close.ticket') }}">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                <option value="BMN" {{ request('kategori') == 'BMN' ? 'selected' : '' }}>BMN</option>
                                <option value="SL" {{ request('kategori') == 'SL' ? 'selected' : '' }}>SL</option>
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
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('close.ticket') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL EDIT TICKET --}}
@foreach($tickets as $t)
<div class="modal fade" id="modalEditTicket{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('close.ticket.update', $t->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center"><i class="bi bi-pencil-square"></i> Edit Tiket Terutup - {{ $t->nama_site }}</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
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
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ $t->tanggal_rekap }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Tanggal Close</label>
                        <input type="date" name="tanggal_close" class="form-control" value="{{ \Carbon\Carbon::parse($t->tanggal_close)->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">CE (Customer Engineer)</label>
                        <select name="ce" class="form-select" required>
                            <option value="Eka Mahatva Yudha" {{ $t->ce == 'Eka Mahatva Yudha' ? 'selected' : '' }}>Eka Mahatva Yudha</option>
                            <option value="Herman Seprianto" {{ $t->ce == 'Herman Seprianto' ? 'selected' : '' }}>Herman Seprianto</option>
                            <option value="Moh. Walangadi" {{ $t->ce == 'Moh. Walangadi' ? 'selected' : '' }}>Moh. Walangadi</option>
                            <option value="Ahmad Suhaini" {{ $t->ce == 'Ahmad Suhaini' ? 'selected' : '' }}>Ahmad Suhaini</option>
                            <option value="Hasrul Fandi Serang" {{ $t->ce == 'Hasrul Fandi Serang' ? 'selected' : '' }}>Hasrul Fandi Serang</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-bold text-primary">Kendala</label>
                        <input type="text" name="kendala" class="form-control" value="{{ $t->kendala }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Detail Problem</label>
                        <textarea name="detail_problem" class="form-control" rows="3" required>{{ $t->detail_problem }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-primary">Action Plan</label>
                        <textarea name="plan_actions" class="form-control" rows="3" required>{{ $t->plan_actions }}</textarea>
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
        // Search Otomatis
        let timeout = null;
        const searchInput = document.getElementById('searchInput');
        const form = searchInput.closest('form');
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.submit();
            }, 500); 
        });
        // Autofocus kursor
        searchInput.focus();
        const val = searchInput.value;
        searchInput.value = '';
        searchInput.value = val;
        // SweetAlert Notifications
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2000, showConfirmButton: false });
        @endif
        // Confirm Delete
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                const siteName = this.getAttribute('data-name');
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Tiket untuk " + siteName + " akan dihapus permanen!",
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
</body>
</html>

