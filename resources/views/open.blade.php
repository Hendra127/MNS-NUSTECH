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
    <title>Open Ticket | Project Operational</title>
     <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                justify-content: flex-start;
            }
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .search-form, .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
            }
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Logout
                        </button>
                    </form>
                </div>
                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                    @csrf
                </form>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary Tiket</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black">Total Open: <b>{{ $openAllCount }}</b></span>
            <span class="summary-badge text-black">Open Hari Ini: <b>{{ $openTodayCount }}</b></span>
            <span class="summary-badge text-dark">BMN: <b>{{ $countBMN }}</b></span>
            <span class="summary-badge text-dark">SL: <b>{{ $countSL }}</b></span>
        </div>
    </div>
    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button class="btn-action bi bi-plus" 
                            title="Add" 
                            data-bs-toggle="modal" 
                            data-bs-target="#modalTambahTicket">
                    </button>
                    <form action="{{ route('open.ticket.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" onchange="document.getElementById('importForm').submit();">
                        <button type="button" class="btn-action bi bi-upload" title="Upload" onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>
            <form method="GET" action="{{ route('open.ticket') }}" class="search-form">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i> </button>
                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none;">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>
        {{-- TABLE --}}
        <div class="table-container" style="overflow-x: auto; max-height: 600px; overflow-y: auto;">
            <table>
                <thead>
                    <tr>
                        <th class="sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_site">NAMA SITE</th>
                        <th>DURASI</th>
                        <th>TANGGAL OPEN</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KATEGORI</th>
                        <th>STATUS</th>
                        <th>KENDALA</th>
                        <th>DETAIL PROBLEM</th>
                        <th>ACTION PLAN</th>
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
                        <td class="text-center">
                            @php
                                $tanggalRekap = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay();
                                if (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close) {
                                    $hariAkhir = \Carbon\Carbon::parse($t->tanggal_close)->startOfDay();
                                } else {
                                    $hariAkhir = now()->startOfDay();
                                }
                                $durasi = $tanggalRekap->diffInDays($hariAkhir);
                            @endphp
                            {{ floor($durasi) }} Hari
                        </td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_rekap)->format('d M Y') }}</td>
                        <td>{{ $t->provinsi }}</td>
                        <td>{{ $t->kabupaten }}</td>
                        <td class="text-center">
                            @if($t->kategori == 'BARANG MILIK NEGARA (BMN)')
                                BMN
                            @elseif($t->kategori == 'SEWA LAYANAN')
                                SL
                            @else
                                {{ $t->kategori }}
                            @endif
                        </td>
                        <td class="text-center"><span>OPEN</span></td>
                        <td>{{ $t->kendala }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $t->detail_problem }}</td>
                        <td class="text-truncate" style="max-width: 200px;">{{ $t->plan_actions }}</td>
                        <td>{{ $t->ce }}</td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm bi bi-x-lg" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalCloseTicket{{ $t->id }}"
                                    data-id="{{ $t->id }}"
                                    data-name="{{ $t->nama_site }}" 
                                    title="Close Ticket"
                                    style="color: #198754;">
                            </button>
                            <button class="btn btn-sm bi bi-pencil" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEditTicket{{ $t->id }}">
                            </button>
                            <form action="{{ route('open.ticket.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm bi bi-trash btn-delete" 
                                        data-name="{{ $t->nama_site }}">
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
                                        <div class="modal-body p-4 bg-light">
                                            <div class="row g-4">
                                                <!-- Section 1: Site Information -->
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
                                                            <div class="d-flex justify-content-between border-bottom pb-2 gap-2">
                                                                <span class="text-muted small flex-shrink-0">Nama Site</span>
                                                                <span class="fw-bold text-end">{{ $t->nama_site }}</span>
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
                                                <!-- Section 2: Timeline & Status -->
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
                                                                <span class="text-muted small">Bulan</span>
                                                                <span class="fw-semibold">{{ $t->bulan_open }}</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Status</span>
                                                                <span class="badge bg-warning text-dark fw-bold px-3 rounded-pill">{{ strtoupper($t->status) }}</span>
                                                            </div>
                                                            @php
                                                                $tanggalRekapInfoComp = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay();
                                                                $hariAkhirInfoComp = (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close) 
                                                                    ? \Carbon\Carbon::parse($t->tanggal_close)->startOfDay() 
                                                                    : now()->startOfDay();
                                                                $durasiDinamicComp = $tanggalRekapInfoComp->diffInDays($hariAkhirInfoComp);
                                                            @endphp
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">Durasi</span>
                                                                <span class="text-danger fw-bold fs-5">{{ floor($durasiDinamicComp) }} Hari</span>
                                                            </div>
                                                            <div class="d-flex justify-content-between border-bottom pb-2">
                                                                <span class="text-muted small">CE</span>
                                                                <span class="fw-semibold">{{ $t->ce ?? '-' }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Section 3: Problem & Action -->
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
                                                                    <p class="mb-0 fw-semibold text-dark">
                                                                        @if($t->evidence && str_contains($t->evidence, '.') && !str_contains(strtolower($t->evidence), 'tidak ada'))
                                                                            <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage/' . $t->evidence) }}')" class="text-primary text-decoration-none">
                                                                                <i class="bi bi-eye"></i> ADA (Klik untuk lihat)
                                                                            </a>
                                                                        @else
                                                                            TIDAK ADA
                                                                        @endif
                                                                    </p>
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
                        <td colspan="12" class="text-center py-4 text-muted">Belum ada tiket yang dibuka.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $tickets->links() }}</div>
    </div>
</div>
{{-- MODAL TAMBAH TICKET --}}
<div class="modal fade" id="modalTambahTicket" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('open.ticket.store') }}" class="modal-content" enctype="multipart/form-data">
            @csrf
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center">Tambah Tiket Baru</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Pilih Site ID</label>
                        <select name="site_id" id="site_select" class="form-select select2" required>
                            <option value="">-- Cari Site ID --</option>
                            @foreach($sites as $s)
                            <option value="{{ $s->id }}" 
                                    data-code="{{ $s->site_id }}" 
                                    data-name="{{ $s->sitename }}"
                                    data-prov="{{ $s->provinsi }}"
                                    data-kab="{{ $s->kab }}"
                                    data-tipe="{{ $s->tipe }}">
                                {{ $s->site_id }} - {{ $s->sitename }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Site Code</label>
                        <input type="text" name="site_code" id="site_code" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Site</label>
                        <input type="text" name="nama_site" id="nama_site" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" name="kabupaten" id="kabupaten" class="form-control bg-light" readonly required>
                    </div>
                    {{-- Input untuk Kategori --}}
                    <div class="col-md-4">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" id="kategori" class="form-control bg-light" readonly required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Rekap</label>
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi (Hari)</label>
                        <input type="text" name="durasi" id="durasi_input" class="form-control bg-light" value="0" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kendala</label>
                        <input type="text" name="kendala" class="form-control" placeholder="Contoh: Kabel Rusak, Perangkat Mati, dll." required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Detail Problem</label>
                        <textarea name="detail_problem" class="form-control" rows="3" required placeholder="Jelaskan detail masalah..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Action Plan</label>
                        <textarea name="plan_actions" class="form-control" rows="3" required placeholder="Jelaskan detail action plan..."></textarea>
                    </div>
                    <input type="hidden" name="status" value="open">
                    <div class="col-md-4">
                        <select name="ce" class="form-select" required>
                            <option value="">-- Pilih CE --</option>
                            <option value="Eka Mahatva Yudha">Eka Mahatva Yudha</option>
                            <option value="Herman Seprianto">Herman Seprianto</option>
                            <option value="Moh. Walangadi">Moh. Walangadi</option>
                            <option value="Ahmad Suhaini">Ahmad Suhaini</option>
                            <option value="Hasrul Fandi Serang">Hasrul Fandi Serang</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Evidence (Foto/Video)</label>
                        <input type="file" name="evidence" class="form-control" accept="image/*,video/*">
                        <small class="text-muted">Format: jpg, png, mp4, etc. Maks 20MB.</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary px-4">Simpan Tiket</button>
            </div>
        </form>
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
            <form method="GET" action="{{ route('open.ticket') }}">
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
                    <a href="{{ route('open.ticket') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL EDIT TICKET (Dibuat untuk setiap tiket yang ada) --}}
@foreach($tickets as $t)
<div class="modal fade" id="modalEditTicket{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form method="POST" action="{{ route('open.ticket.update', $t->id) }}" class="modal-content" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center"><i class="bi bi-pencil-square"></i> Edit Tiket - {{ $t->nama_site }}</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    {{-- Info Site (Read Only saat Edit) --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Site ID / Code</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->site_code }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Site</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->nama_site }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Durasi Berjalan (Hari)</label>
                        @php
                            $tanggalRekapEdit = \Carbon\Carbon::parse($t->tanggal_rekap)->startOfDay();
                            if (in_array(strtolower($t->status), ['close', 'closed']) && $t->tanggal_close) {
                                $hariAkhirEdit = \Carbon\Carbon::parse($t->tanggal_close)->startOfDay();
                            } else {
                                $hariAkhirEdit = now()->startOfDay();
                            }
                            $durasiEdit = $tanggalRekapEdit->diffInDays($hariAkhirEdit);
                        @endphp
                        <input type="text" class="form-control bg-light" value="{{ floor($durasiEdit) }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Provinsi</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->provinsi }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kabupaten</label>
                        <input type="text" class="form-control bg-light" value="{{ $t->kabupaten }}" readonly>
                    </div>
                    {{-- Data yang Bisa Diedit --}}
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="BMN" {{ $t->kategori == 'BMN' ? 'selected' : '' }}>BMN</option>
                            <option value="SL" {{ $t->kategori == 'SL' ? 'selected' : '' }}>SL</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Tanggal Open/Rekap</label>
                        <input type="date" name="tanggal_rekap" class="form-control" value="{{ $t->tanggal_rekap }}" required>
                    </div>
                    <div class="col-md-8">
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
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">CE (Customer Engineer)</label>
                        <select name="ce" class="form-select" required>
                            <option value="">-- Pilih CE --</option>
                            <option value="Eka Mahatva Yudha" {{ $t->ce == 'Eka Mahatva Yudha' ? 'selected' : '' }}>Eka Mahatva Yudha</option>
                            <option value="Herman Seprianto" {{ $t->ce == 'Herman Seprianto' ? 'selected' : '' }}>Herman Seprianto</option>
                            <option value="Moh. Walangadi" {{ $t->ce == 'Moh. Walangadi' ? 'selected' : '' }}>Moh. Walangadi</option>
                            <option value="Ahmad Suhaini" {{ $t->ce == 'Ahmad Suhaini' ? 'selected' : '' }}>Ahmad Suhaini</option>
                            <option value="Hasrul Fandi Serang" {{ $t->ce == 'Hasrul Fandi Serang' ? 'selected' : '' }}>Hasrul Fandi Serang</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold text-primary">Evidence (Foto/Video)</label>
                        <input type="file" name="evidence" class="form-control" accept="image/*,video/*">
                        @if($t->evidence)
                            <div class="mt-1">
                                <a href="javascript:void(0)" onclick="viewEvidence('{{ asset('storage/' . $t->evidence) }}')" class="text-info small">
                                    <i class="bi bi-eye"></i> Lihat Evidence saat ini
                                </a>
                            </div>
                        @else
                            <small class="text-muted">Tidak ada evidence sebelumnya.</small>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-secondary px-4">Update Data Tiket</button>
            </div>
        </form>
    </div>
</div>
{{-- MODAL CLOSE TICKET --}}
<div class="modal fade" id="modalCloseTicket{{ $t->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('open.ticket.close', $t->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center"> Close Tiket - {{ $t->nama_site }}</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Tanggal Close</label>
                    <input type="date" name="tanggal_close" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Problem (Detail Masalah)</label>
                    <textarea name="detail_problem" class="form-control" rows="3" required>{{ $t->detail_problem }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Action Plan (Tindakan)</label>
                    <textarea name="plan_actions" class="form-control" rows="3" required>{{ $t->plan_actions }}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success px-4">Simpan & Close Tiket</button>
            </div>
        </form>
    </div>
</div>
@endforeach
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
<script>
    // SCRIPT AUTO-FILL BERDASARKAN PILIHAN SITE
    document.getElementById('site_select').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
        document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
        document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
        document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
    });
    // SWEETALERT NOTIFIKASI
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", confirmButtonColor: '#d33', confirmButtonText: 'Tutup' });
    @endif
</script>
{{-- Script untuk auto-fill berdasarkan pilihan site --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const siteSelect = document.getElementById('site_select');
        if(siteSelect) {
            siteSelect.addEventListener('change', function() {
                const selected = this.options[this.selectedIndex];
                // Mengisi input berdasarkan data-attribute yang ada di <option>
                document.getElementById('site_code').value = selected.getAttribute('data-code') || '';
                document.getElementById('nama_site').value = selected.getAttribute('data-name') || '';
                document.getElementById('provinsi').value = selected.getAttribute('data-prov') || '';
                document.getElementById('kabupaten').value = selected.getAttribute('data-kab') || '';
            });
        }
    });
</script>
{{-- Script untuk menghitung durasi otomatis berdasarkan tanggal rekap --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const tanggalRekapInput = document.getElementsByName('tanggal_rekap')[0];
        const durasiInput = document.getElementById('durasi_input');
        function hitungDurasi() {
            const tanggalTerpilih = new Date(tanggalRekapInput.value);
            const hariIni = new Date();
            // Reset jam ke 00:00:00 agar perhitungan hari akurat
            tanggalTerpilih.setHours(0, 0, 0, 0);
            hariIni.setHours(0, 0, 0, 0);
            // Hitung selisih dalam milidetik
            const selisihMilidetik = hariIni.getTime() - tanggalTerpilih.getTime();
            // Konversi milidetik ke hari (1 hari = 24 * 60 * 60 * 1000 ms)
            const selisihHari = Math.floor(selisihMilidetik / (1000 * 60 * 60 * 24));
            // Jika tanggal rekap adalah hari ini, durasi 0. Jika kemarin, durasi 1.
            // Jika user memilih tanggal masa depan, kita set durasi ke 0
            durasiInput.value = selisihHari > 0 ? selisihHari : 0;
        }
        // Jalankan fungsi saat input tanggal berubah
        tanggalRekapInput.addEventListener('change', hitungDurasi);
        // Jalankan fungsi saat modal pertama kali dibuka (untuk default value)
        hitungDurasi();
    });
</script>
{{-- Script untuk submit form pencarian otomatis setelah user berhenti mengetik selama 500ms --}}
<script>
    let timeout = null;
    const searchInput = document.getElementById('searchInput');
    const form = searchInput.closest('form');
    searchInput.addEventListener('input', function() {
        // Hapus timeout sebelumnya jika user masih mengetik
        clearTimeout(timeout);
        // Setel waktu tunggu 500ms setelah ketikan terakhir
        timeout = setTimeout(() => {
            form.submit();
        }, 100); 
    });
    // Pindahkan kursor ke akhir teks setelah refresh halaman
    searchInput.focus();
    const val = searchInput.value;
    searchInput.value = '';
    searchInput.value = val;
</script>
{{-- Script untuk konfirmasi delete dengan SweetAlert2 --}}
<script>
    // SCRIPT KONFIRMASI DELETE DENGAN SWEETALERT2
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(e) {
            // Ambil data nama site dari attribute data-name yang sudah Abang buat
            const siteName = this.getAttribute('data-name');
            const form = this.closest('form'); // Cari form pembungkusnya
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
                    // Jika user klik Ya, jalankan submit form
                    form.submit();
                }
            });
        });
    });
</script>
{{-- Script untuk inisialisasi Select2 pada dropdown site --}}
<script>
    $(document).ready(function() {
    $('#site_select').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        width: '100%',
        // Mengambil parent modal secara otomatis
        dropdownParent: $('#site_select').closest('.modal') 
    });
});
</script>
{{-- Script untuk inisialisasi Select2 pada dropdown site dengan perbaikan fokus di modal --}}
<script>
$(document).ready(function() {
    // 1. Inisialisasi Select2 & Perbaikan Fokus di Modal
    const $siteSelect = $('#site_select');
    $siteSelect.select2({
        theme: 'bootstrap-5',
        placeholder: '-- Cari Site ID --',
        allowClear: true,
        width: '100%',
        // Mengambil parent modal secara otomatis agar bisa diketik
        dropdownParent: $siteSelect.closest('.modal').length ? $siteSelect.closest('.modal') : $(document.body)
    });
    // Fix bug Select2: agar kursor otomatis fokus ke kolom pencarian saat diklik
    $(document).on('select2:open', () => {
        setTimeout(() => {
            const searchField = document.querySelector('.select2-search__field');
            if (searchField) searchField.focus();
        }, 10);
    });
    // 2. Event saat Site ID dipilih (Auto-fill & Mapping Kategori)
    $siteSelect.on('change', function() {
        const selectedOption = $(this).find(':selected');
        // Ambil data dasar dari atribut data-
        const code = selectedOption.data('code');
        const name = selectedOption.data('name');
        const prov = selectedOption.data('prov');
        const kab = selectedOption.data('kab');
        const tipeFull = selectedOption.data('tipe'); 
        // Logika Mapping Kategori: Mengubah teks panjang menjadi singkatan
        let kategoriSingkat = "";
        if (tipeFull) {
            const tipeUpper = tipeFull.toUpperCase(); // Ubah ke huruf besar semua agar pencarian akurat
            if (tipeUpper.includes("BARANG MILIK NEGARA") || tipeUpper.includes("BMN")) {
                kategoriSingkat = "BMN";
            } else if (tipeUpper.includes("SEWA LAYANAN") || tipeUpper.includes("SL")) {
                kategoriSingkat = "SL";
            } else {
                kategoriSingkat = tipeFull; // Pakai teks asli jika tidak ada kecocokan
            }
        }
        // Distribusikan data ke input masing-masing ID
        $('#site_code').val(code || '');
        $('#nama_site').val(name || '');
        $('#provinsi').val(prov || '');
        $('#kabupaten').val(kab || '');
        $('#kategori').val(kategoriSingkat); 
    });
});
</script>

<!-- Modal Viewer Evidence -->
<div class="modal fade" id="modalViewerEvidence" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 text-center position-relative">
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index: 100001;"></button>
                <div id="evidenceContainer" class="d-flex justify-content-center align-items-center">
                    <!-- Content will be injected here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function viewEvidence(url) {
        const container = document.getElementById('evidenceContainer');
        if (!container) return;
        
        const ext = url.split('.').pop().toLowerCase();
        const videoExts = ['mp4', 'mov', 'avi', 'webm'];
        
        container.innerHTML = '';
        
        if (videoExts.includes(ext)) {
            container.innerHTML = `<video src="${url}" controls autoplay class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto;"></video>`;
        } else {
            container.innerHTML = `<img src="${url}" class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto; object-fit: contain;">`;
        }
        
        var myModal = new bootstrap.Modal(document.getElementById('modalViewerEvidence'));
        myModal.show();
    }
</script>
</body>
</html>

