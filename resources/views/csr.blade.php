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
    <title>CSR Pengajuan | Project Operational</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tom Select (searchable dropdown) -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }


        .table-responsive-custom {
            background: white;
            border-radius: 12px;
            overflow: hidden;
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
            bottom: -30px;
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
            bottom: -35px;
            transform: translateX(-50%) rotate(-90deg);
            /* Counter-rotate to stay upright */
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

        .penerima-info {
            line-height: 1.2;
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
        <a href="{{ route('csr.index') }}" class="tab active">Pengajuan CSR</a>
        <a href="{{ route('cm.index') }}" class="tab">Pengajuan CM</a>
    </div>

    <div class="content-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Corporate Social Responsibility</h4>
            </div>
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user', 'noc_leader']))
                <button class="btn-premium" data-bs-toggle="modal" data-bs-target="#modalTambahCsr"
                    title="Buat Pengajuan Baru">
                    <i class="bi bi-plus-lg"></i>
                </button>
            @endif
        </div>

        <div class="table-responsive-custom">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th style="min-width: 150px;">Tanggal & Nomor</th>
                        <th style="min-width: 200px;">Site</th>
                        <th style="min-width: 180px;">Penerima & Bank</th>
                        <th>Rincian Kebutuhan</th>
                        <th class="text-end" style="min-width: 130px;">Total Dana</th>
                        <th class="text-center" style="min-width: 150px;">Progress Approval</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($csrList as $csr)
                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration + ($csrList->currentPage() - 1) * $csrList->perPage() }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $csr->tempat_tanggal }}</div>
                                <div class="small text-muted">{{ $csr->nomor }}</div>
                            </td>
                            <td>
                                <div class="site-list-compact fw-bold text-dark">
                                    @php
                                        $rawSites = str_replace(["\r", "\n"], ',', $csr->nama_site);
                                        $siteArray = array_values(array_filter(array_map('trim', explode(',', $rawSites))));
                                    @endphp
                                    @if(count($siteArray) > 1)
                                        @foreach($siteArray as $index => $s)
                                            <div class="site-item">{{ $index + 1 }}. {{ preg_replace('/^[0-9]+\.\s*/', '', $s) }}
                                            </div>
                                        @endforeach
                                    @else
                                        {{ $csr->nama_site }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="penerima-info">
                                    <div class="fw-bold text-dark" style="font-size: 13px;"><i class="bi bi-person"></i>
                                        {{ $csr->nama_penerima }}</div>
                                    @if($csr->bank)
                                        <div class="small text-primary mt-1" style="font-size: 11px;"><i class="bi bi-bank"></i>
                                            {{ $csr->bank }}</div>
                                        <div class="small text-muted" style="font-size: 11px;">{{ $csr->nomor_rekening }}</div>
                                    @endif
                                </div>
                            </td>
                            <td style="max-width: 300px;">
                                <div class="small text-dark text-truncate">{{ $csr->rincian_kebutuhan }}</div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($csr->total, 0, ',', '.') }}</div>
                            </td>
                            <td class="text-center">
                                <span class="badge-status bg-{{ $csr->status_color }}-subtle text-{{ $csr->status_color }}">
                                    @if($csr->approval_status == 'approved_penasihat')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @elseif($csr->approval_status == 'rejected')
                                        <i class="bi bi-x-circle-fill"></i>
                                    @else
                                        <i class="bi bi-clock-history"></i>
                                    @endif
                                    {{ $csr->status_label }}
                                </span>
                                <div class="workflow-step">
                                    @foreach(['NOC Leader', 'Manager', 'Accounting', 'Direktur', 'Penasihat'] as $idx => $label)
                                        <div class="step-item" title="{{ $label }}">
                                            <div
                                                class="step-dot 
                                                                {{ $csr->step > ($idx + 1) ? 'completed' : ($csr->approval_status == 'rejected' && $csr->rejected_by == $label ? 'rejected' : ($csr->step == ($idx + 1) ? 'active' : '')) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($csr->approval_status != 'approved_penasihat' && $csr->approval_status != 'rejected')
                                        @php
                                            $roleGate = [
                                                'pending_noc' => ['noc_leader'],
                                                'pending' => ['manager'],
                                                'approved_manager' => ['accounting'],
                                                'approved_accounting' => ['direktur'],
                                                'approved_direktur' => ['penasihat'],
                                            ];
                                            $nextRoleLabel = [
                                                'pending_noc' => 'NOC Leader',
                                                'pending' => 'Manager',
                                                'approved_manager' => 'Accounting',
                                                'approved_accounting' => 'Direktur',
                                                'approved_direktur' => 'Penasihat',
                                            ];

                                            $allowedRoles = $roleGate[$csr->approval_status] ?? [];

                                            // Special check for Rossie Maulana Septian
                                            $isRossie = (auth()->user()->name === 'Rossie Maulana Septian, S.Kom');
                                            $canApprove = ($csr->user_id != auth()->id()) &&
                                                (in_array(auth()->user()->role, $allowedRoles) || ($csr->approval_status === 'pending_noc' && $isRossie));

                                            $waitingFor = $nextRoleLabel[$csr->approval_status] ?? '';
                                        @endphp

                                        @if($canApprove)
                                            @if($csr->approval_status === 'approved_manager')
                                                {{-- Accounting: buka modal isi no_surat + catatan dulu --}}
                                                <button type="button" class="btn-approve"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modalApproveAccCsr{{ $csr->id }}"
                                                    title="Setujui &amp; Isi Catatan">
                                                    <i class="bi bi-check-lg"></i> Setujui
                                                </button>
                                            @else
                                                <form action="{{ route('csr.approve', $csr->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn-approve" title="Setujui sebagai {{ $waitingFor }}">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn-reject" title="Tolak" data-bs-toggle="modal"
                                                data-bs-target="#modalReject{{ $csr->id }}">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        @endif
                                    @endif

                                    <button type="button" class="btn btn-sm fw-semibold"
                                        style="background:linear-gradient(135deg,#6366f1,#8b5cf6); color:white; border:none; border-radius:8px; padding:6px 12px; font-size:12px; white-space:nowrap;"
                                        data-bs-toggle="modal" data-bs-target="#modalInfoCsr{{ $csr->id }}">
                                        <i class="bi bi-eye me-1"></i> View Pengajuan CSR
                                    </button>

                                    @php
                                        $isApprover = in_array(auth()->user()->role, ['manager', 'accounting', 'direktur', 'penasihat']);
                                        $canEdit = ($csr->approval_status == 'pending_noc' || $csr->approval_status == 'pending' || $csr->approval_status == 'rejected') && !$isApprover;
                                        $isAdmin = in_array(auth()->user()->role, ['noc_leader']);
                                    @endphp

                                    @if($canEdit || $isAdmin)
                                        <button type="button" class="btn btn-sm btn-outline-primary" title="Edit / Update"
                                            data-bs-toggle="modal" data-bs-target="#modalEditCsr{{ $csr->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif

                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item" href="{{ route('csr.print', ['id' => $csr->id, 'with_ttd' => 1]) }}" target="_blank"><i class="bi bi-file-earmark-pdf text-danger me-2"></i>Cetak Full TTD</a></li>
                                            <li><a class="dropdown-item" href="{{ route('csr.print', ['id' => $csr->id, 'with_ttd' => 0]) }}" target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Tanpa TTD</a></li>
                                        </ul>
                                    </div>

                                    @if(auth()->user()->role === 'noc_leader')
                                        <form id="delete-form-csr-{{ $csr->id }}" action="{{ route('csr.destroy', $csr->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('delete-form-csr-{{ $csr->id }}')" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Tombol Edit Catatan/No Surat khusus Accounting --}}
                                    @if(auth()->user()->role === 'accounting')
                                        <button type="button" class="btn btn-sm"
                                            style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:8px;padding:6px 10px;"
                                            data-bs-toggle="modal" data-bs-target="#modalNotesCsr{{ $csr->id }}"
                                            title="Isi / Edit Catatan & No Surat">
                                            <i class="bi bi-journal-text"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Reject -->

                        <div class="modal fade" id="modalReject{{ $csr->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <form action="{{ route('csr.reject', $csr->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header bg-danger text-white rounded-top-4">
                                            <h5 class="modal-title fw-bold">Konfirmasi Penolakan</h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label class="form-label fw-600">Alasan Penolakan</label>
                                            <textarea name="rejection_reason" class="form-control" rows="3" required
                                                placeholder="Tuliskan alasan penolakan..."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light rounded-pill"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger rounded-pill px-4">Tolak
                                                Pengajuan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.2;"></i>
                                <p class="mt-2">Belum ada pengajuan CSR.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($csrList->hasPages())
            <div class="mt-4">
                {{ $csrList->links() }}
            </div>
        @endif
    </div>

    {{-- ===== MODALS INFO CSR (outside table) ===== --}}
    @foreach($csrList as $csr)
        <div class="modal fade" id="modalInfoCsr{{ $csr->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:12px; overflow: hidden;">
                    <div class="modal-header py-3" style="background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:white;">
                        <h6 class="modal-title fw-bold mb-0">Detail Pengajuan CSR</h6>
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
                                    <div class="subtitle">CORPORATE SOCIAL RESPONSIBILITY</div>
                                </div>
                            </div>

                            <div class="preview-info-section">
                                <div class="preview-info-row">
                                    <div class="preview-info-label">Tempat, Tanggal</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $csr->tempat_tanggal }}</div>
                                </div>
                                <div class="preview-info-row">
                                    <div class="preview-info-label">Divisi / Bagian</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $csr->divisi }}</div>
                                </div>
                                <div class="preview-info-row">
                                    <div class="preview-info-label">No. Surat</div>
                                    <div class="preview-info-separator">:</div>
                                    <div>{{ $csr->no_surat ?? '-' }}</div>
                                </div>

                            </div>

                            <p style="font-size: 10pt; text-align: justify; margin-bottom: 10px; color: #2563eb;">
                                Dengan ini saya mengajukan CSR untuk site yang membutuhkan bantuan tambahan dalam
                                operasional AI BAKTI dengan rincian sebagai berikut:
                            </p>

                            <table class="preview-table">
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nama Site</span><span>:</span>
                                        </div>
                                    </td>
                                    <td style="white-space: pre-line;">{!! nl2br(e($csr->nama_site)) !!}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nama Penerima</span><span>:</span>
                                        </div>
                                    </td>
                                    <td>{{ $csr->nama_penerima }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Bank</span><span>:</span></div>
                                    </td>
                                    <td>{{ $csr->bank ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Nomer
                                                Rekening</span><span>:</span></div>
                                    </td>
                                    <td>{{ $csr->nomor_rekening ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Rincian
                                                Kebutuhan</span><span>:</span></div>
                                    </td>
                                    <td>{!! nl2br(e($csr->rincian_kebutuhan)) !!}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Total</span><span>:</span></div>
                                    </td>
                                    <td class="preview-total">Rp {{ number_format($csr->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Terbilang</span><span>:</span>
                                        </div>
                                    </td>
                                    <td class="preview-terbilang">{{ $csr->terbilang }}</td>
                                </tr>
                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Catatan</span><span>:</span></div>
                                    </td>
                                    <td>{{ $csr->catatan ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <td class="preview-label-cell">
                                        <div class="d-flex justify-content-between"><span>Keterangan</span><span>:</span></div>
                                    </td>
                                    <td>{{ $csr->keterangan ?? '-' }}</td>
                                </tr>
                            </table>

                            <p style="font-size: 10pt; margin-bottom: 15px; color: #2563eb;">Demikian surat pengajuan ini
                                dibuat, atas perhatiannya saya ucapkan terima kasih.</p>

                            @if($csr->ttd_penasihat)
                                <div style="text-align: center; margin-bottom: 15px; font-size: 9pt;">
                                    Mataram, {{ $csr->updated_at->format('d F Y') }}
                                </div>
                            @endif

                            <div class="preview-signature-grid">
                                <div>
                                    <p class="mb-1">Pemohon,</p>
                                    <div class="preview-sign-img">
                                        @if($csr->ttd_pemohon)
                                            <img
                                                src="{{ asset(str_replace('storage/', 'storage/', $csr->ttd_pemohon)) }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">Rossie Maulana Septian, S.Kom</p>
                                    <p class="preview-sign-jabatan">NOC Leader</p>
                                </div>
                                <div>
                                    <p class="mb-1">Diverifikasi,</p>
                                    <div class="preview-sign-img">
                                        @if($csr->ttd_manager)
                                            <img
                                                src="{{ asset(str_replace('storage/', 'storage/', $csr->ttd_manager)) }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $csr->diverifikasi2_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $csr->diverifikasi2_jabatan }}</p>
                                </div>
                                <div>
                                    <p class="mb-1">Diverifikasi,</p>
                                    <div class="preview-sign-img">
                                        @if($csr->ttd_accounting)
                                            <img
                                                src="{{ asset(str_replace('storage/', 'storage/', $csr->ttd_accounting)) }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $csr->diverifikasi3_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $csr->diverifikasi3_jabatan }}</p>
                                </div>
                                <div>
                                    <p class="mb-1">Disetujui,</p>
                                    <div class="preview-sign-img">
                                        @if($csr->ttd_direktur)
                                            <img
                                                src="{{ asset(str_replace('storage/', 'storage/', $csr->ttd_direktur)) }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $csr->disetujui_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $csr->disetujui_jabatan }}</p>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <div style="text-align: center; font-size: 9pt; width: 50%;">
                                    <p class="mb-1">Mengetahui,</p>
                                    <div class="preview-sign-img">
                                        @if($csr->ttd_penasihat)
                                            <img
                                                src="{{ asset(str_replace('storage/', 'storage/', $csr->ttd_penasihat)) }}">
                                        @endif
                                    </div>
                                    <p class="preview-sign-name">{{ $csr->mengetahui_nama }}</p>
                                    <p class="preview-sign-jabatan">{{ $csr->mengetahui_jabatan }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endforeach
    {{-- ===== /MODALS INFO CSR ===== --}}

    {{-- ===== MODALS APPROVE ACCOUNTING + NOTES CSR ===== --}}
    @if(auth()->user()->role === 'accounting')
    @foreach($csrList as $csr)
        {{-- MODAL APPROVE ACCOUNTING CSR --}}
        <div class="modal fade" id="modalApproveAccCsr{{ $csr->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#10b981,#059669);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-check-circle me-2"></i>Setujui &amp; Isi Data Accounting
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('csr.approve', $csr->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-info border-0 small mb-3" style="background:#eff6ff;">
                                <i class="bi bi-info-circle me-1"></i>
                                Isi data berikut sebelum menyetujui pengajuan CSR ini.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat <span class="text-muted">(opsional)</span></label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $csr->no_surat }}"
                                    placeholder="Contoh: 001/ACC/CSR/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan <span class="text-muted">(opsional)</span></label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $csr->catatan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Keterangan <span class="text-muted">(opsional)</span></label>
                                <textarea name="keterangan" class="form-control" rows="2"
                                    placeholder="Keterangan tambahan...">{{ $csr->keterangan }}</textarea>
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

        {{-- MODAL EDIT CATATAN / NO SURAT CSR (Accounting saja) --}}
        <div class="modal fade" id="modalNotesCsr{{ $csr->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius:15px;">
                    <div class="modal-header text-white"
                        style="background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:15px 15px 0 0;">
                        <h5 class="modal-title fw-bold mb-0">
                            <i class="bi bi-journal-text me-2"></i>Isi / Edit Catatan &amp; No Surat
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('csr.accounting.notes', $csr->id) }}" method="POST">
                        @csrf
                        <div class="modal-body p-4">
                            <div class="alert alert-warning border-0 small mb-3" style="background:#fffbeb;">
                                <i class="bi bi-lock me-1"></i>
                                Hanya <strong>Accounting</strong> yang dapat mengisi/mengubah data ini.
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nomor Surat</label>
                                <input type="text" name="no_surat" class="form-control"
                                    value="{{ $csr->no_surat }}"
                                    placeholder="Contoh: 001/ACC/CSR/V/2026">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Catatan</label>
                                <textarea name="catatan" class="form-control" rows="3"
                                    placeholder="Catatan dari Accounting...">{{ $csr->catatan }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"
                                    placeholder="Keterangan tambahan...">{{ $csr->keterangan }}</textarea>
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
    {{-- ===== /MODALS APPROVE ACCOUNTING + NOTES CSR ===== --}}

    {{-- ===== MODALS EDIT CSR ===== --}}
    @foreach($csrList as $csr)
        <div class="modal fade" id="modalEditCsr{{ $csr->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow-lg">
                    <div class="modal-header text-white d-flex justify-content-center position-relative"
                        style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title w-100 text-center fw-bold">Edit Pengajuan CSR</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ route('csr.update', $csr->id) }}" method="POST" class="formEditCsr">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tempat, Tanggal</label>
                                    <input type="text" name="tempat_tanggal" class="form-control"
                                        value="{{ $csr->tempat_tanggal }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Divisi / Bagian</label>
                                    <input type="text" name="divisi" class="form-control" value="{{ $csr->divisi }}"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nomor Pengajuan</label>
                                    <input type="text" name="nomor" class="form-control" value="{{ $csr->nomor }}">
                                </div>

                                <div class="col-md-12">
                                    <hr class="my-2">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Site (Bisa pilih banyak)</label>
                                    @php
                                        // Parse nama_site string back to array
                                        $currentSites = array_filter(array_map('trim', explode("\n", $csr->nama_site)));
                                        $currentSites = array_map(function ($s) {
                                            return preg_replace('/^[0-9]+\.\s*/', '', $s);
                                        }, $currentSites);
                                    @endphp
                                    <select name="nama_site[]" class="form-select select_nama_site_edit" multiple required>
                                        @foreach($sites as $site)
                                            <option value="{{ $site->sitename }}" @if(in_array($site->sitename, $currentSites))
                                            selected @endif>{{ $site->site_id }} - {{ $site->sitename }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Penerima</label>
                                    <input type="text" name="nama_penerima" class="form-control"
                                        value="{{ $csr->nama_penerima }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Bank</label>
                                    <select name="bank" class="form-select select_bank_edit">
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
                                                'Bank OCBC NISP',
                                                'Bank Panin',
                                                'Bank Mega',
                                                'Bank Sinarmas',
                                                'Bank Commonwealth',
                                                'Bank HSBC Indonesia',
                                                'Bank Citibank Indonesia',
                                                'Bank Standard Chartered Indonesia',
                                                'Bank DBS Indonesia',
                                                'Bank ANZ Indonesia',
                                                'Bank BTPN',
                                                'Bank Muamalat',
                                                'Bank Bukopin',
                                                'Bank Mestika',
                                                'Bank Jatim',
                                                'Bank Jateng',
                                                'Bank DKI',
                                                'Bank Kaltimtara',
                                                'Bank NTB Syariah',
                                                'Bank NTT',
                                                'Bank Papua',
                                                'Bank Kalsel',
                                                'Bank Kalbar',
                                                'Bank Kalteng',
                                                'Bank Sumut',
                                                'Bank Sumsel Babel',
                                                'Bank Riau Kepri',
                                                'Bank Nagari (Sumbar)',
                                                'Bank Banten',
                                                'Bank BJB (Jabar Banten)',
                                                'Bank Bali',
                                                'Bank Sulsel Sulbar',
                                                'Bank Sulut Go',
                                                'Bank Maluku Malut',
                                                'Bank Bengkulu',
                                                'Bank Lampung',
                                                'Bank Jambi',
                                                'Bank Aceh',
                                            ];
                                            $isCustomBank = !in_array($csr->bank, $banks) && $csr->bank;
                                        @endphp
                                        @foreach($banks as $b)
                                            <option value="{{ $b }}" @if($csr->bank == $b) selected @endif>{{ $b }}</option>
                                        @endforeach
                                        <option value="__custom__" @if($isCustomBank) selected @endif>-- Tulis Nama Bank
                                            Lainnya
                                            --</option>
                                    </select>
                                    <input type="text" name="bank_custom" class="form-control mt-2 custom_bank_input_edit"
                                        placeholder="Tulis nama bank..."
                                        style="display: {{ $isCustomBank ? 'block' : 'none' }};"
                                        value="{{ $isCustomBank ? $csr->bank : '' }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Nomor Rekening</label>
                                    <input type="text" name="nomor_rekening" class="form-control"
                                        value="{{ $csr->nomor_rekening }}">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Rincian Kebutuhan</label>
                                    <textarea name="rincian_kebutuhan" class="form-control" rows="3"
                                        required>{{ $csr->rincian_kebutuhan }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Total (Angka)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light fw-bold">Rp</span>
                                        <input type="number" name="total"
                                            class="form-control fw-bold text-success input_total_edit"
                                            value="{{ $csr->total }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Terbilang</label>
                                    <input type="text" name="terbilang" class="form-control bg-light input_terbilang_edit"
                                        value="{{ $csr->terbilang }}" readonly>
                                </div>

                                <div class="col-md-12">
                                    <hr class="my-2">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Pemohon (NOC Leader)</label>
                                    <input type="text" name="pemohon_nama" class="form-control mb-1"
                                        value="Rossie Maulana Septian, S.Kom" required>
                                    <input type="text" name="pemohon_jabatan" class="form-control small" value="NOC Leader"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Verifikasi (Manager)</label>
                                    <input type="text" name="diverifikasi2_nama" class="form-control mb-1"
                                        value="{{ $csr->diverifikasi2_nama }}">
                                    <input type="text" name="diverifikasi2_jabatan" class="form-control small"
                                        value="{{ $csr->diverifikasi2_jabatan }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Accounting</label>
                                    <input type="text" name="diverifikasi3_nama" class="form-control mb-1"
                                        value="{{ $csr->diverifikasi3_nama }}">
                                    <input type="text" name="diverifikasi3_jabatan" class="form-control small"
                                        value="{{ $csr->diverifikasi3_jabatan }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Direktur</label>
                                    <input type="text" name="disetujui_nama" class="form-control mb-1"
                                        value="{{ $csr->disetujui_nama }}">
                                    <input type="text" name="disetujui_jabatan" class="form-control small"
                                        value="{{ $csr->disetujui_jabatan }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold small">Penasihat</label>
                                    <input type="text" name="mengetahui_nama" class="form-control mb-1"
                                        value="{{ $csr->mengetahui_nama }}">
                                    <input type="text" name="mengetahui_jabatan" class="form-control small"
                                        value="{{ $csr->mengetahui_jabatan }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-light rounded-pill px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="bi bi-save"></i> Perbarui Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- ===== /MODALS EDIT CSR ===== --}}

    <!-- Modal Tambah CSR -->
    <div class="modal fade" id="modalTambahCsr" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header text-white d-flex justify-content-center position-relative"
                    style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title w-100 text-center fw-bold">Formulir Pengajuan CSR</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('csr.store') }}" method="POST" id="formCsr">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Tempat, Tanggal</label>
                                <input type="text" name="tempat_tanggal" class="form-control"
                                    value="Mataram, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Divisi / Bagian</label>
                                <input type="text" name="divisi" class="form-control"
                                    value="Manage Service AI BAKTI" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Nomor Pengajuan</label>
                                <input type="text" name="nomor" class="form-control"
                                    placeholder="Contoh: 001/CSR/V/2026">
                            </div>

                            <div class="col-md-12">
                                <hr class="my-2">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Nama Site (Bisa pilih banyak)</label>
                                <select name="nama_site[]" id="select_nama_site" class="form-select" multiple required>
                                    @foreach($sites as $site)
                                        <option value="{{ $site->sitename }}">{{ $site->site_id }} - {{ $site->sitename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Nama Penerima</label>
                                <input type="text" name="nama_penerima" class="form-control"
                                    placeholder="Nama Penerima Bantuan" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Bank</label>
                                <select id="select_bank" name="bank" class="form-select">
                                    <option value="">-- Pilih Bank --</option>
                                    <option>Bank BRI (Bank Rakyat Indonesia)</option>
                                    <option>Bank BNI (Bank Negara Indonesia)</option>
                                    <option>Bank BCA (Bank Central Asia)</option>
                                    <option>Bank Mandiri</option>
                                    <option>Bank BTN (Bank Tabungan Negara)</option>
                                    <option>Bank BSI (Bank Syariah Indonesia)</option>
                                    <option>Bank CIMB Niaga</option>
                                    <option>Bank Danamon</option>
                                    <option>Bank Permata</option>
                                    <option>Bank Maybank Indonesia</option>
                                    <option>Bank OCBC NISP</option>
                                    <option>Bank Panin</option>
                                    <option>Bank Mega</option>
                                    <option>Bank Sinarmas</option>
                                    <option>Bank Commonwealth</option>
                                    <option>Bank HSBC Indonesia</option>
                                    <option>Bank Citibank Indonesia</option>
                                    <option>Bank Standard Chartered Indonesia</option>
                                    <option>Bank DBS Indonesia</option>
                                    <option>Bank ANZ Indonesia</option>
                                    <option>Bank BTPN</option>
                                    <option>Bank Muamalat</option>
                                    <option>Bank Bukopin</option>
                                    <option>Bank Mestika</option>
                                    <option>Bank Jatim</option>
                                    <option>Bank Jateng</option>
                                    <option>Bank DKI</option>
                                    <option>Bank Kaltimtara</option>
                                    <option>Bank NTB Syariah</option>
                                    <option>Bank NTT</option>
                                    <option>Bank Papua</option>
                                    <option>Bank Kalsel</option>
                                    <option>Bank Kalbar</option>
                                    <option>Bank Kalteng</option>
                                    <option>Bank Sumut</option>
                                    <option>Bank Sumsel Babel</option>
                                    <option>Bank Riau Kepri</option>
                                    <option>Bank Nagari (Sumbar)</option>
                                    <option>Bank Banten</option>
                                    <option>Bank BJB (Jabar Banten)</option>
                                    <option>Bank Bali</option>
                                    <option>Bank Sulsel Sulbar</option>
                                    <option>Bank Sulut Go</option>
                                    <option>Bank Maluku Malut</option>
                                    <option>Bank Bengkulu</option>
                                    <option>Bank Lampung</option>
                                    <option>Bank Jambi</option>
                                    <option>Bank Aceh</option>
                                    <option value="__custom__">-- Tulis Nama Bank Lainnya --</option>
                                </select>
                                <input type="text" id="custom_bank_input" name="bank_custom" class="form-control mt-2"
                                    placeholder="Tulis nama bank..." style="display:none;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nomor Rekening</label>
                                <input type="text" name="nomor_rekening" class="form-control"
                                    placeholder="Nomor Rekening Penerima">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Rincian Kebutuhan</label>
                                <textarea name="rincian_kebutuhan" class="form-control" rows="3"
                                    placeholder="Contoh: 1. Subsidi BBM bulan MEI Rp 200.000" required
                                    id="rincian_kebutuhan"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Total (Angka)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light fw-bold">Rp</span>
                                    <input type="number" name="total" class="form-control fw-bold text-success"
                                        id="input_total" required placeholder="200000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Terbilang</label>
                                <input type="text" name="terbilang" class="form-control bg-light" id="input_terbilang"
                                    readonly placeholder="Dua Ratus Ribu Rupiah">
                            </div>

                            <div class="col-md-12">
                                <hr class="my-2">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Pemohon (NOC Leader)</label>
                                <input type="text" name="pemohon_nama" class="form-control mb-1"
                                    value="Rossie Maulana Septian, S.Kom" required>
                                <input type="text" name="pemohon_jabatan" class="form-control small" value="NOC Leader"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Verifikasi (Manager)</label>
                                <input type="text" name="diverifikasi2_nama" class="form-control mb-1"
                                    value="Dimas Farid Awaludin, S.Kom">
                                <input type="text" name="diverifikasi2_jabatan" class="form-control small"
                                    value="Manager">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Accounting</label>
                                <input type="text" name="diverifikasi3_nama" class="form-control mb-1"
                                    value="Baiq Nana Erlina, A.Md">
                                <input type="text" name="diverifikasi3_jabatan" class="form-control small"
                                    value="Accounting">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Direktur</label>
                                <input type="text" name="disetujui_nama" class="form-control mb-1"
                                    value="Galuh Zakiyatun, S.Kom">
                                <input type="text" name="disetujui_jabatan" class="form-control small" value="Direktur">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Penasihat</label>
                                <input type="text" name="mengetahui_nama" class="form-control mb-1"
                                    value="Raden Yuniarta Alba, S.Kom">
                                <input type="text" name="mengetahui_jabatan" class="form-control small"
                                    value="Penasihat">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleCsrDetail(rowId, btn) {
            const row = document.getElementById(rowId);
            if (!row) return;

            const isHidden = row.style.display === 'none' || row.style.display === '';

            // Close all other expanded rows first
            document.querySelectorAll('tr[id^="detail-"]').forEach(function (r) {
                if (r.id !== rowId) {
                    r.style.display = 'none';
                }
            });
            // Reset all other buttons
            document.querySelectorAll('.csr-view-btn').forEach(function (b) {
                if (b !== btn) {
                    b.innerHTML = '<i class="bi bi-eye me-1"></i> View Pengajuan CSR';
                    b.style.background = 'linear-gradient(135deg,#6366f1,#8b5cf6)';
                }
            });

            if (isHidden) {
                row.style.display = 'table-row';
                btn.innerHTML = '<i class="bi bi-eye-slash me-1"></i> Tutup';
                btn.style.background = 'linear-gradient(135deg,#374151,#1f2937)';
            } else {
                row.style.display = 'none';
                btn.innerHTML = '<i class="bi bi-eye me-1"></i> View Pengajuan CSR';
                btn.style.background = 'linear-gradient(135deg,#6366f1,#8b5cf6)';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Tom Select – Nama Site (Tambah & Edit)
            document.querySelectorAll('#select_nama_site, .select_nama_site_edit').forEach(function (el) {
                new TomSelect(el, {
                    plugins: ['remove_button'],
                    create: true,
                    sortField: { field: 'text', direction: 'asc' },
                    placeholder: 'Pilih satu atau lebih site...',
                    maxItems: null,
                });
            });

            // Tom Select – Bank (Tambah & Edit)
            document.querySelectorAll('#select_bank, .select_bank_edit').forEach(function (selectEl) {
                const modal = selectEl.closest('.modal-body');
                const customBankInput = modal.querySelector('#custom_bank_input, .custom_bank_input_edit');

                const tomBank = new TomSelect(selectEl, {
                    create: false,
                    sortField: { field: 'text', direction: 'asc' },
                    placeholder: 'Cari atau pilih bank...',
                });

                tomBank.on('change', function (value) {
                    if (value === '__custom__') {
                        customBankInput.style.display = 'block';
                        customBankInput.required = true;
                    } else {
                        customBankInput.style.display = 'none';
                        customBankInput.required = false;
                        customBankInput.value = '';
                    }
                });
            });

            // Before submit – merge custom bank into the bank field (Tambah & Edit)
            document.querySelectorAll('#formCsr, .formEditCsr').forEach(function (form) {
                form.addEventListener('submit', function (e) {
                    const customBankInput = form.querySelector('#custom_bank_input, .custom_bank_input_edit');
                    const bankField = form.querySelector('[name="bank"]');

                    if (customBankInput && customBankInput.style.display !== 'none' && customBankInput.value.trim()) {
                        // Set the hidden input value dynamically
                        const hidden = document.createElement('input');
                        hidden.type = 'hidden';
                        hidden.name = 'bank';
                        hidden.value = customBankInput.value.trim();
                        form.appendChild(hidden);
                        if (bankField) bankField.removeAttribute('name');
                    }
                });
            });

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

            // Total & Terbilang Logic (Tambah & Edit)
            document.querySelectorAll('#input_total, .input_total_edit').forEach(function (input) {
                const modal = input.closest('.modal-body');
                const terbilangField = modal.querySelector('#input_terbilang, .input_terbilang_edit');

                input.addEventListener('input', function () {
                    const total = parseInt(this.value) || 0;
                    if (total > 0) {
                        terbilangField.value = terbilangRupiah(total).trim() + " Rupiah";
                    } else {
                        terbilangField.value = "";
                    }
                });
            });
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

        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}"
            });
        @endif
    </script>
</body>

</html>
