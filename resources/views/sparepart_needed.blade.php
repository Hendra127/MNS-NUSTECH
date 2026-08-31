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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sparepart Needed | Project Operational</title>
    <style>
        /* Custom Select2 Dropdown for SN */
        .select2-sn-dropdown .select2-results__options {
            max-height: 130px !important;
            overflow-y: auto !important;
        }
        /* Each result item smaller */
        .select2-sn-dropdown .select2-results__option {
            padding: 4px 8px !important;
            font-size: 0.8rem !important;
        }
        .select2-sn-dropdown .select2-search--dropdown {
            padding: 5px 8px !important;
        }
        .select2-sn-dropdown .select2-search__field {
            font-size: 0.82rem !important;
        }
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

        /* Tombol teks utama untuk aksi baru */
        .btn-buat-pengajuan {
            height: 42px;
            padding: 0 20px;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white !important;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.3px;
            white-space: nowrap;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);
            cursor: pointer;
        }

        .btn-buat-pengajuan:hover {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.5);
            transform: translateY(-1px);
        }

        .btn-buat-pengajuan:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);
        }

        .btn-buat-pengajuan i {
            font-size: 1rem;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

        [data-bs-theme="dark"] .search-box {
            background: #2b3035 !important;
            border-color: #495057 !important;
        }

        [data-bs-theme="dark"] .search-box input {
            color: #f8f9fa !important;
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

        /* ================================================
           Select2 Custom Styling — SN Perangkat Search
           ================================================ */

        /* Kotak pemilih utama (trigger) */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 10px !important;
            min-height: 44px !important;
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            border: 1.5px solid #c8d6e5 !important;
            font-size: 0.875rem !important;
            background: #fff !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .select2-container--bootstrap-5 .select2-selection:focus,
        .select2-container--bootstrap-5.select2-container--focus .select2-selection {
            border-color: #4a9eff !important;
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.18) !important;
            outline: none !important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding-left: 12px !important;
            padding-right: 36px !important;
            color: #333 !important;
            font-size: 0.875rem !important;
            line-height: 42px !important;
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }
        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__placeholder {
            color: #9aa5b4 !important;
        }
        .select2-container--bootstrap-5 .select2-selection__arrow {
            height: 44px !important;
            right: 10px !important;
        }
        /* Dropdown container */
        .select2-container--bootstrap-5 .select2-dropdown {
            border-radius: 12px !important;
            border: 1.5px solid #c8d6e5 !important;
            box-shadow: 0 8px 32px rgba(30, 60, 120, 0.13) !important;
            overflow: hidden !important;
            background: #fff !important;
            margin-top: 4px !important;
            min-width: 420px !important;
        }
        /* Kotak pencarian di dalam dropdown */
        .select2-container--bootstrap-5 .select2-search--dropdown {
            padding: 10px 12px 8px 12px !important;
            background: #f7f9fc !important;
            border-bottom: 1px solid #e8eef5 !important;
        }
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
            border-radius: 8px !important;
            border: 1.5px solid #4a9eff !important;
            padding: 8px 14px !important;
            font-size: 0.875rem !important;
            width: 100% !important;
            margin: 0 !important;
            background: #fff !important;
            color: #333 !important;
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.1) !important;
            outline: none !important;
            transition: border-color 0.2s, box-shadow 0.2s !important;
        }
        .select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field:focus {
            border-color: #1a7bff !important;
            box-shadow: 0 0 0 3px rgba(74, 158, 255, 0.22) !important;
        }
        /* Daftar opsi */
        .select2-container--bootstrap-5 .select2-results__options {
            max-height: 230px !important;
            overflow-y: auto !important;
            padding: 4px 0 !important;
        }
        .select2-container--bootstrap-5 .select2-results__options::-webkit-scrollbar {
            width: 6px;
        }
        .select2-container--bootstrap-5 .select2-results__options::-webkit-scrollbar-thumb {
            background: #c8d6e5;
            border-radius: 4px;
        }
        .select2-results__option {
            padding: 9px 16px !important;
            font-size: 0.825rem !important;
            border-bottom: 1px solid #f0f4f8 !important;
            color: #3a4a5a !important;
            cursor: pointer !important;
            transition: background 0.15s !important;
        }
        .select2-results__option:last-child {
            border-bottom: none !important;
        }
        .select2-results__option--highlighted {
            background-color: #e8f1fd !important;
            color: #1a5bbf !important;
            font-weight: 500 !important;
        }
        /* Optgroup label */
        .select2-results__group {
            padding: 6px 14px 4px 14px !important;
            font-size: 0.72rem !important;
            font-weight: 700 !important;
            color: #7a8fa6 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            background: #f7f9fc !important;
            border-bottom: 1px solid #e8eef5 !important;
        }
        /* Item yang sudah dipilih — sembunyikan dari dropdown */
        .select2-container--bootstrap-5 .select2-results__option[aria-selected="true"] {
            display: none !important;
        }
        /* Tag terpilih (multiple) */
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            font-size: 0.8rem;
            padding: 2px 10px;
            margin-top: 5px;
            border-radius: 6px;
            background: #e8f1fd;
            border: 1px solid #aac8f5;
            color: #1a5bbf;
        }
        /* Pastikan dropdown muncul di atas modal */
        .select2-container--open {
            z-index: 9999 !important;
        }
        /* Dropdown above fix */
        .select2-dropdown--above {
            border-top: 1.5px solid #c8d6e5 !important;
            border-bottom: none !important;
            border-radius: 12px !important;
            margin-bottom: 4px !important;
            margin-top: 0 !important;
        }
        /* Pesan tidak ada hasil */
        .select2-results__message {
            padding: 12px 16px !important;
            font-size: 0.825rem !important;
            color: #9aa5b4 !important;
            text-align: center !important;
        }

        /* ---- Dua-baris item SN di dropdown ---- */
        .s2-item-sn {
            display: flex;
            flex-direction: column;
            gap: 1px;
            padding: 1px 0;
            max-width: 100%;
            overflow: hidden;
        }
        .s2-item-sn__code {
            font-weight: 600;
            font-size: 0.82rem;
            color: #1a3a5c;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
        }
        .s2-item-sn__info {
            font-size: 0.72rem;
            color: #6b7e96;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }
        /* Saat di-hover: ubah warna teks info */
        .select2-results__option--highlighted .s2-item-sn__code {
            color: #1a5bbf;
        }
        .select2-results__option--highlighted .s2-item-sn__info {
            color: #5a8fd8;
        }
        /* Padding lebih besar untuk item dua baris */
        .select2-results__option:has(.s2-item-sn) {
            padding: 7px 14px !important;
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
            .content-container {
                padding: 15px !important;
                margin: 10px !important;
                border-radius: 12px;
                width: calc(100vw - 20px);
            }

            .main-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 15px;
            }

            .header-logo-container {
                margin-bottom: 10px;
            }

            .d-flex.justify-content-between.align-items-center.mb-4 {
                flex-direction: column;
                align-items: stretch !important;
                gap: 15px;
            }

            .d-flex.justify-content-between.align-items-center.mb-4>div {
                width: 100%;
            }

            .btn-premium,
            .btn-action-premium {
                width: 100%;
                border-radius: 8px;
                height: 45px;
            }

            .btn-premium::after,
            .btn-action-premium::after {
                display: none !important;
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
            @if(auth()->check() && auth()->user()->hasAdminAccess())
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
        <a href="{{ route('sparepart_needed') }}" class="tab active">Pengajuan Perangkat</a>
        <a href="{{ route('csr.index') }}" class="tab">Pengajuan CSR</a>
        <a href="{{ route('cm.index') }}" class="tab">Pengajuan CM</a>
        <div class="ms-auto d-flex align-items-center">
            <span class="summary-badge text-black" id="summaryBadge">Total Sparepart Needed :
                <b>{{ $sparepartsNeeded->total() }}</b></span>
        </div>
    </div>

    <style>
        .modal-print-preview {
            background: white;
            margin: 20px auto;
            padding: 30px;
            width: 100%;
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
            width: 140px;
            text-align: left;
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

        .step-dot.completed,
        .step-dot.active {
            background: #10b981;
            box-shadow: 0 0 4px rgba(16, 185, 129, 0.4);
        }

        .step-dot.rejected {
            background: #ef4444;
            box-shadow: 0 0 4px rgba(239, 68, 68, 0.4);
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

        [data-bs-theme="dark"] .text-dark {
            color: #f8f9fa !important;
        }
    </style>

    <!-- TABEL PENGAJUAN -->
    <div class="content-container mt-4">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin', 'user', 'noc_leader']))
                    <button type="button" class="btn btn-primary rounded-pill d-flex align-items-center gap-2 px-4 shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#modalPrintPengajuan" title="Buat Pengajuan Baru" style="height: 40px;">
                        <i class="bi bi-plus-lg"></i> Buat Pengajuan
                    </button>
                @endif
            </div>
            <div class="w-100 mt-2 mt-lg-0">
                <form method="GET" action="{{ route('sparepart_needed') }}"
                    class="search-form row g-2 align-items-center w-100 m-0 justify-content-lg-end"
                    id="filterPengajuanForm">

                    <div class="col-12 col-md-auto">
                        <select name="tipe_pengajuan" class="form-select form-select-sm w-100"
                            style="border-radius: 50px;">
                            <option value="">Semua Klasifikasi</option>
                            <option value="Pembelian Baru" {{ request('tipe_pengajuan') === 'Pembelian Baru' ? 'selected' : '' }}>Pembelian Baru</option>
                            <option value="Repair Perangkat" {{ request('tipe_pengajuan') === 'Repair Perangkat' ? 'selected' : '' }}>Repair Perangkat</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-auto">
                        <select name="status_pembayaran" class="form-select form-select-sm w-100"
                            style="border-radius: 50px;">
                            <option value="">Semua Status Bayar</option>
                            <option value="belum_dibayar" {{ request('status_pembayaran') === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                            <option value="dp_50" {{ request('status_pembayaran') === 'dp_50' ? 'selected' : '' }}>Sudah
                                di DP 50%</option>
                            <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Sudah
                                Lunas</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-auto">
                        <select name="approval_status" class="form-select form-select-sm w-100"
                            style="border-radius: 50px;">
                            <option value="">Semua Status</option>
                            <option value="pending_noc" {{ request('approval_status') == 'pending_noc' ? 'selected' : '' }}>Pending NOC Leader</option>
                            <option value="pending" {{ request('approval_status') == 'pending' ? 'selected' : '' }}>
                                Pending Manager</option>
                            <option value="approved_manager" {{ request('approval_status') == 'approved_manager' ? 'selected' : '' }}>Pending Accounting</option>
                            <option value="approved_accounting" {{ request('approval_status') == 'approved_accounting' ? 'selected' : '' }}>Pending Direktur</option>
                            <option value="approved_direktur" {{ request('approval_status') == 'approved_direktur' ? 'selected' : '' }}>Pending Penasihat</option>
                            <option value="approved_penasihat" {{ request('approval_status') == 'approved_penasihat' ? 'selected' : '' }}>Selesai (Approved)</option>
                            <option value="rejected" {{ request('approval_status') == 'rejected' ? 'selected' : '' }}>
                                Ditolak</option>
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
                            style="padding: 8px 12px;" title="Reset Filter"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100"
                            style="font-size: 13px; padding: 5px 15px; border-radius: 50px; background: #f8f9fa; border: 1px solid #dee2e6;">
                            <input type="text" name="search_pengajuan" id="searchPengajuanInput"
                                placeholder="Cari No / Divisi / Perangkat" value="{{ request('search_pengajuan') }}"
                                style="flex-grow: 1; border: none; outline: none; padding-left: 10px; background: transparent; font-size: 13px;">
                            <button type="submit" style="border: none; background: transparent;"><i
                                    class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive-custom" id="tablePengajuanContainer">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">NO</th>
                        <th style="min-width: 150px;">TANGGAL & NOMOR</th>
                        <th style="min-width: 300px;">DETAIL PERANGKAT</th>
                        <th style="min-width: 200px;">SN PERANGKAT</th>
                        <th class="text-end" style="min-width: 130px;">TOTAL DANA</th>
                        <th class="text-center" style="min-width: 150px;">STATUS PEMBAYARAN</th>
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
                                @if($p->tipe_pengajuan === 'Repair Perangkat')
                                    <span class="badge mt-1" style="background-color: #dc3545; font-size:0.68rem;"><i
                                            class="bi bi-tools me-1"></i>Repair</span>
                                @else
                                    <span class="badge mt-1" style="background-color: #10b981; font-size:0.68rem;"><i
                                            class="bi bi-cart-plus me-1"></i>Pembelian</span>
                                @endif
                            </td>
                            <td style="max-width: 300px;">
                                <div class="small text-dark text-truncate">
                                    @if(is_array($p->items))
                                        @php
                                            $perangkatList = array_map(function ($i) {
                                                return ($i['perangkat'] ?? '') . ' (' . ($i['qty'] ?? 1) . ')';
                                            }, $p->items);
                                        @endphp
                                        {{ implode(', ', $perangkatList) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td style="max-width: 200px;">
                                <div class="small text-dark text-truncate">
                                    @if(is_array($p->items))
                                        @php
                                            $snList = array_map(function ($i) {
                                                return !empty($i['sn_perangkat']) ? $i['sn_perangkat'] : '-';
                                            }, $p->items);
                                        @endphp
                                        {{ implode(', ', $snList) }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="fw-bold text-success">Rp {{ number_format($p->grand_total, 0, ',', '.') }}</div>
                            </td>
                            <td class="text-center">
                                @if($p->status_pembayaran === 'lunas')
                                    <span class="badge bg-success" style="min-width: 85px; padding: 5px;">Lunas</span>
                                @elseif($p->status_pembayaran === 'dp_50')
                                    <span class="badge bg-warning text-dark" style="min-width: 85px; padding: 5px;">DP
                                        50%</span>
                                @else
                                    <span class="badge bg-danger" style="min-width: 85px; padding: 5px;">Belum Dibayar</span>
                                @endif

                                @if(in_array($p->status_pembayaran, ['lunas', 'dp_50']) && ($p->bukti_transfer || $p->bukti_dp))
                                    <div class="mt-1">
                                        <button type="button"
                                            class="btn btn-sm btn-info text-white shadow-sm d-inline-flex align-items-center justify-content-center gap-1"
                                            style="font-size: 0.72rem; padding: 4px; border-radius: 6px; min-width: 85px;"
                                            title="Lihat Bukti Pembayaran" data-bs-toggle="modal"
                                            data-bs-target="#modalBuktiSP{{ $p->id }}">
                                            <i class="bi bi-info-circle-fill"></i> Info
                                        </button>
                                    </div>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-{{ $p->status_color }} mb-1 rounded-pill px-3 py-2"
                                    style="font-size: 0.75rem;">
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
                                            <div
                                                class="step-dot {{ $p->step > ($idx + 1) ? 'completed' : ($p->approval_status == 'rejected' && $p->rejected_by == $label ? 'rejected' : ($p->step == ($idx + 1) ? 'active' : '')) }}">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center align-items-center">
                                    @if($p->can_approve)
                                        @if($p->approval_status === 'approved_manager' && auth()->user()->role === 'accounting')
                                            {{-- Accounting: buka modal isi no_surat + catatan dulu --}}
                                            <button type="button" class="btn btn-sm btn-success shadow-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalApproveAccSP{{ $p->id }}" title="Setujui &amp; Isi Catatan">
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

                                    <button type="button" class="btn btn-sm btn-info text-white shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalInfoPengajuan{{ $p->id }}"
                                        title="View Pengajuan">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-dark dropdown-toggle"
                                            style="border-radius:8px;padding:6px 10px;" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false" title="Cetak">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sparepart.needed.pengajuan.print', ['id' => $p->id, 'with_ttd' => 1]) }}"
                                                    target="_blank"><i
                                                        class="bi bi-file-earmark-pdf text-danger me-2"></i>Cetak Full
                                                    TTD</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('sparepart.needed.pengajuan.print', ['id' => $p->id, 'with_ttd' => 0]) }}"
                                                    target="_blank"><i class="bi bi-file-earmark-pdf me-2"></i>Cetak Tanpa
                                                    TTD</a></li>
                                        </ul>
                                    </div>

                                    @if(auth()->check() && auth()->user()->role === 'noc_leader')
                                        <button
                                            class="btn btn-sm shadow-sm {{ $p->tipe_pengajuan === 'Repair Perangkat' ? 'btn-warning text-dark' : 'btn-light border text-primary' }}"
                                            data-bs-toggle="modal" data-bs-target="#modalEditPengajuan{{ $p->id }}"
                                            title="Edit ({{ $p->tipe_pengajuan ?? 'Pembelian Baru' }})">
                                            @if($p->tipe_pengajuan === 'Repair Perangkat')
                                                <i class="bi bi-tools"></i>
                                            @else
                                                <i class="bi bi-pencil"></i>
                                            @endif
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
                                        <button type="button" class="btn btn-sm btn-outline-dark"
                                            style="border-radius:8px;padding:6px 10px;" data-bs-toggle="modal"
                                            data-bs-target="#modalNotesSP{{ $p->id }}" title="Isi / Edit Catatan & No Surat">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                </div>

                                <!-- Modal Info Pengajuan -->
                                {{-- Modal Bukti Pembayaran SP (Dual Tab) --}}
                                @if(in_array($p->status_pembayaran, ['lunas', 'dp_50']) && ($p->bukti_transfer || $p->bukti_dp))
                                    <div class="modal fade" id="modalBuktiSP{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" style="max-width: 540px;">
                                            <div class="modal-content border-0 shadow-lg"
                                                style="border-radius: 16px; overflow: hidden;">
                                                <div class="modal-header text-white border-0 py-3"
                                                    style="background: linear-gradient(135deg, #0ea5e9, #0284c7);">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="bi bi-cash-coin fs-5"></i>
                                                        <div>
                                                            <h6 class="modal-title fw-bold mb-0">Bukti Pembayaran</h6>
                                                            <div style="font-size: 0.72rem; opacity: 0.85;">
                                                                No. {{ $p->nomor ?? '-' }} &bull;
                                                                <span class="badge bg-success">Sudah Lunas</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn-close btn-close-white ms-auto"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-0" style="background: #f1f5f9;">
                                                    @php
                                                        $spHasDp = !empty($p->bukti_dp);
                                                        $spHasLunas = !empty($p->bukti_transfer);
                                                        $spShowTabs = $spHasDp && $spHasLunas;
                                                    @endphp

                                                    @if($spShowTabs)
                                                        <ul class="nav nav-tabs nav-fill px-3 pt-3 border-0 gap-2" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <button
                                                                    class="nav-link active fw-semibold d-flex align-items-center justify-content-center gap-1"
                                                                    data-bs-toggle="tab" data-bs-target="#sp-tab-dp-{{ $p->id }}"
                                                                    type="button" role="tab"
                                                                    style="border-radius: 10px; border: 2px solid #f59e0b; color:#d97706; font-size:0.82rem;">
                                                                    <i class="bi bi-percent"></i> DP / Uang Muka
                                                                </button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button
                                                                    class="nav-link fw-semibold d-flex align-items-center justify-content-center gap-1"
                                                                    data-bs-toggle="tab" data-bs-target="#sp-tab-lunas-{{ $p->id }}"
                                                                    type="button" role="tab"
                                                                    style="border-radius: 10px; border: 2px solid #10b981; color:#059669; font-size:0.82rem;">
                                                                    <i class="bi bi-check-circle-fill"></i> Lunas
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    @endif

                                                    <div class="tab-content p-3">
                                                        @if($spHasDp)
                                                            <div class="tab-pane fade {{ !$spShowTabs || $spHasDp ? 'show active' : '' }}"
                                                                id="sp-tab-dp-{{ $p->id }}" role="tabpanel">
                                                                <div class="text-center mb-2">
                                                                    <span class="badge bg-warning text-dark px-3 py-1"
                                                                        style="font-size:0.78rem;">
                                                                        <i class="bi bi-percent me-1"></i>Bukti DP / Uang Muka
                                                                    </span>
                                                                </div>
                                                                <div class="rounded-3 overflow-hidden shadow-sm border"
                                                                    style="background: white;">
                                                                    <img src="{{ asset('storage_public/' . $p->bukti_dp) }}"
                                                                        alt="Bukti DP" class="w-100"
                                                                        style="max-height: 400px; object-fit: contain; display: block;"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                                    <div class="align-items-center justify-content-center p-4 text-muted"
                                                                        style="display:none;">
                                                                        <i class="bi bi-image-alt me-2 fs-4"></i> Gambar tidak
                                                                        ditemukan
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2 d-flex justify-content-end">
                                                                    <a href="{{ asset('storage_public/' . $p->bukti_dp) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1"
                                                                        style="font-size: 0.75rem; border-radius: 8px;">
                                                                        <i class="bi bi-box-arrow-up-right"></i> Buka
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        @if($spHasLunas)
                                                            <div class="tab-pane fade {{ $spShowTabs ? '' : 'show active' }}"
                                                                id="sp-tab-lunas-{{ $p->id }}" role="tabpanel">
                                                                <div class="text-center mb-2">
                                                                    <span class="badge bg-success px-3 py-1"
                                                                        style="font-size:0.78rem;">
                                                                        <i class="bi bi-check-circle-fill me-1"></i>Bukti Lunas
                                                                    </span>
                                                                </div>
                                                                <div class="rounded-3 overflow-hidden shadow-sm border"
                                                                    style="background: white;">
                                                                    <img src="{{ asset('storage_public/' . $p->bukti_transfer) }}"
                                                                        alt="Bukti Lunas" class="w-100"
                                                                        style="max-height: 400px; object-fit: contain; display: block;"
                                                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                                    <div class="align-items-center justify-content-center p-4 text-muted"
                                                                        style="display:none;">
                                                                        <i class="bi bi-image-alt me-2 fs-4"></i> Gambar tidak
                                                                        ditemukan
                                                                    </div>
                                                                </div>
                                                                <div class="mt-2 d-flex justify-content-end">
                                                                    <a href="{{ asset('storage_public/' . $p->bukti_transfer) }}"
                                                                        target="_blank"
                                                                        class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1"
                                                                        style="font-size: 0.75rem; border-radius: 8px;">
                                                                        <i class="bi bi-box-arrow-up-right"></i> Buka
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="px-3 pb-3 small text-muted">
                                                        <i class="bi bi-box-seam me-1"></i>
                                                        {{ Str::limit($p->divisi ?? '', 40) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="modal fade" id="modalInfoPengajuan{{ $p->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-xl modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg"
                                            style="border-radius:12px; overflow: hidden;">
                                            <div class="modal-header py-3"
                                                style="background:linear-gradient(135deg,#1e3a8a,#3b82f6); color:white;">
                                                <h6 class="modal-title fw-bold mb-0">Detail Pengajuan Sparepart</h6>
                                                <button type="button" class="btn-close btn-close-white"
                                                    data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-0"
                                                style="background:#f1f5f9; max-height: 85vh; overflow-y: auto;">
                                                <div class="modal-print-preview">
                                                    <div class="preview-header">
                                                        <img src="{{ asset('assets/img/logo2.jpg') }}" class="preview-logo"
                                                            onerror="this.src='{{ asset('assets/img/logonustech.png') }}'">
                                                        <div class="preview-header-text">
                                                            <h2>FORMULIR PENGAJUAN</h2>
                                                            @if($p->tipe_pengajuan === 'Repair Perangkat')
                                                                <div class="subtitle">REPAIR PERANGKAT</div>
                                                            @else
                                                                <div class="subtitle">PENGADAAN BARANG INVENTARIS</div>
                                                            @endif
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
                                                        @if($p->tipe_pengajuan === 'Repair Perangkat')
                                                            <div class="preview-info-row">
                                                                <div class="preview-info-label">Tipe Pengajuan</div>
                                                                <div class="preview-info-separator">:</div>
                                                                <div>Repair Perangkat</div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <p style="font-size: 10pt; text-align: justify; margin-bottom: 10px;">
                                                        Dengan ini saya mengajukan perangkat sparepart untuk pergantian
                                                        perangkat yang rusak dengan perincian sebagai berikut :
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
                                                                        <td style="text-align: left;">
                                                                            {{ $item['perangkat'] ?? '-' }}
                                                                        </td>
                                                                        <td style="text-align: center;">{{ $item['qty'] ?? 1 }}</td>
                                                                        <td style="text-align: left;">Rp
                                                                            {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                                                                        </td>
                                                                        <td class="bg-gray-label" style="text-align: left;">Rp
                                                                            {{ number_format(($item['qty'] ?? 1) * ($item['harga'] ?? 0), 0, ',', '.') }}
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            {{ $item['layanan'] ?? '-' }}
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            {{ $item['peruntukan'] ?? '-' }}
                                                                        </td>
                                                                        <td style="text-align: center;">
                                                                            {{ $item['keterangan'] ?? '-' }}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="8" style="text-align: center;">Belum ada
                                                                        perangkat.</td>
                                                                </tr>
                                                            @endif
                                                            <tr>
                                                                <td colspan="4" class="bg-gray-label"
                                                                    style="text-align: center;">TOTAL</td>
                                                                <td colspan="4" class="bg-gray-label"
                                                                    style="text-align: left;">Rp
                                                                    {{ number_format($p->grand_total ?? 0, 0, ',', '.') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="bg-gray-label"
                                                                    style="text-align: center;">Terbilang</td>
                                                                <td colspan="4"
                                                                    style="text-align: left; font-style: italic; color: #b71c1c !important;">
                                                                    @php
                                                                        $terbilang = '';
                                                                        if ($p->data_json) {
                                                                            $decoded = json_decode($p->data_json, true);
                                                                            $terbilang = $decoded['terbilang'] ?? '';
                                                                        }
                                                                     @endphp
                                                                    {{ $terbilang }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="4" class="bg-gray-label"
                                                                    style="text-align: center;">Catatan</td>
                                                                <td colspan="4" style="text-align: left;">
                                                                    {{ $p->catatan ?? '-' }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>

                                                    <p style="font-size: 10pt; margin-bottom: 15px;">Demikian surat
                                                        pengajuan ini dibuat, atas perhatiannya saya ucapkan terima kasih.
                                                    </p>

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
                                                            <p class="preview-sign-name">
                                                                {{ $dataJson['pemohon_nama'] ?? 'Rossie Maulana Septian, S.Kom' }}
                                                            </p>
                                                            <p class="preview-sign-jabatan">
                                                                {{ $dataJson['pemohon_jabatan'] ?? 'NOC Leader' }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-1">Diverifikasi,</p>
                                                            <div class="preview-sign-img">
                                                                @if($p->approved_manager_at)
                                                                    <img src="{{ asset('assets/img/ttd/manager.png') }}">
                                                                @endif
                                                            </div>
                                                            <p class="preview-sign-name">
                                                                {{ $dataJson['diverifikasi1_nama'] ?? 'Dimas Farid Awaludin, S.Kom' }}
                                                            </p>
                                                            <p class="preview-sign-jabatan">
                                                                {{ $dataJson['diverifikasi1_jabatan'] ?? 'Manager' }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-1">Diverifikasi,</p>
                                                            <div class="preview-sign-img" style="height: 70px;">
                                                                @if($p->approved_accounting_at)
                                                                    <img src="{{ asset('assets/img/ttd/accounting.png') }}"
                                                                        style="bottom: -20px; position: relative;">
                                                                @endif
                                                            </div>
                                                            <p class="preview-sign-name">
                                                                {{ $dataJson['diverifikasi2_nama'] ?? 'Baiq Nana Erlina, A.Md' }}
                                                            </p>
                                                            <p class="preview-sign-jabatan">
                                                                {{ $dataJson['diverifikasi2_jabatan'] ?? 'Accounting' }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="mb-1">Disetujui,</p>
                                                            <div class="preview-sign-img">
                                                                @if($p->approved_direktur_at)
                                                                    <img src="{{ asset('assets/img/ttd/direktur.png') }}">
                                                                @endif
                                                            </div>
                                                            <p class="preview-sign-name">
                                                                {{ $dataJson['disetujui_nama'] ?? 'Galuh Zakiyatun, S.Kom' }}
                                                            </p>
                                                            <p class="preview-sign-jabatan">
                                                                {{ $dataJson['disetujui_jabatan'] ?? 'Direktur' }}
                                                            </p>
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
                                                            <p class="preview-sign-name">
                                                                {{ $dataJson['mengetahui_nama'] ?? 'Raden Yuniarta Alba, S.Kom' }}
                                                            </p>
                                                            <p class="preview-sign-jabatan">
                                                                {{ $dataJson['mengetahui_jabatan'] ?? 'Penasihat' }}
                                                            </p>
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
                                    Nomor Surat dan Catatan <strong>tidak wajib diisi</strong>. Anda tetap bisa menyetujui tanpa
                                    mengisinya.
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Nomor Surat <span
                                            class="text-muted">(opsional)</span></label>
                                    <input type="text" name="no_surat" class="form-control" value="{{ $p->no_surat }}"
                                        placeholder="Contoh: 001/ACC/SP/V/2026">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Catatan <span
                                            class="text-muted">(opsional)</span></label>
                                    <textarea name="catatan" class="form-control" rows="3"
                                        placeholder="Catatan dari Accounting...">{{ $p->catatan }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light rounded-pill px-4"
                                    data-bs-dismiss="modal">Batal</button>
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
                                <i class="bi bi-journal-text me-2"></i>Isi / Edit Catatan &amp; Status
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('sparepart.needed.accounting.notes', $p->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body p-4">
                                <div class="alert alert-warning border-0 small mb-3" style="background:#fffbeb;">
                                    <i class="bi bi-lock me-1"></i>
                                    Hanya <strong>Accounting</strong> yang dapat mengisi/mengubah data ini. Semua field bersifat
                                    opsional.
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Status Pembayaran</label>
                                    <select name="status_pembayaran" class="form-select" id="status_pembayaran_sp_{{ $p->id }}"
                                        onchange="toggleBuktiTransferSp({{ $p->id }})">
                                        <option value="belum_dibayar" {{ $p->status_pembayaran === 'belum_dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                        <option value="dp_50" {{ $p->status_pembayaran === 'dp_50' ? 'selected' : '' }}>Sudah di
                                            DP 50%</option>
                                        <option value="lunas" {{ $p->status_pembayaran === 'lunas' ? 'selected' : '' }}>Sudah
                                            Lunas</option>
                                    </select>
                                </div>
                                <div class="mb-3" id="bukti_dp_container_sp_{{ $p->id }}"
                                    style="display: {{ in_array($p->status_pembayaran, ['dp_50', 'lunas']) ? 'block' : 'none' }};">
                                    <label class="form-label fw-bold small text-warning">
                                        <i class="bi bi-image me-1"></i>Foto Bukti DP / Uang Muka
                                        <span class="text-muted fw-normal">(Opsional)</span>
                                    </label>
                                    <input type="file" name="bukti_dp" class="form-control" accept="image/*">
                                    @if($p->bukti_dp)
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="{{ asset('storage_public/' . $p->bukti_dp) }}" class="rounded border"
                                                style="height:50px;object-fit:cover;">
                                            <a href="{{ asset('storage_public/' . $p->bukti_dp) }}" target="_blank"
                                                class="small text-primary">Lihat Bukti DP</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3" id="bukti_transfer_container_sp_{{ $p->id }}"
                                    style="display: {{ $p->status_pembayaran === 'lunas' ? 'block' : 'none' }};">
                                    <label class="form-label fw-bold small text-success">
                                        <i class="bi bi-image me-1"></i>Foto Bukti Lunas
                                        <span class="text-muted fw-normal">(Opsional)</span>
                                    </label>
                                    <input type="file" name="bukti_transfer" class="form-control" accept="image/*">
                                    @if($p->bukti_transfer)
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <img src="{{ asset('storage_public/' . $p->bukti_transfer) }}" class="rounded border"
                                                style="height:50px;object-fit:cover;">
                                            <a href="{{ asset('storage_public/' . $p->bukti_transfer) }}" target="_blank"
                                                class="small text-primary">Lihat Bukti Lunas</a>
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Nomor Surat</label>
                                    <input type="text" name="no_surat" class="form-control" value="{{ $p->no_surat }}"
                                        placeholder="Contoh: 001/ACC/SP/V/2026">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Catatan</label>
                                    <textarea name="catatan" class="form-control" rows="3"
                                        placeholder="Catatan dari Accounting...">{{ $p->catatan }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-light rounded-pill px-4"
                                    data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn rounded-pill px-5 fw-bold text-white"
                                    style="background:linear-gradient(135deg,#f59e0b,#d97706);border:none;">Simpan</button>
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
                    id="headerModalPengajuan" style="background-color: #198754; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title w-100 text-center fw-bold" id="titleModalPengajuan">
                        <i class="bi bi-box-seam me-2"></i>Buat Pengajuan Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-4">
                    <form action="{{ route('sparepart.needed.print') }}" method="POST" target="_blank"
                        id="formPengajuan" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4 p-3 border rounded shadow-sm" style="background-color: #f8f9fa;">
                            <label class="form-label fw-bold" style="font-size: 0.95rem; color: #0d6efd;">
                                <i class="bi bi-gear-fill me-1"></i> Tipe Pengajuan
                            </label>
                            <div class="d-flex gap-3 mt-2">
                                <div class="form-check flex-fill">
                                    <input class="form-check-input" type="radio" name="tipe_pengajuan"
                                        id="tipe_pembelian_baru" value="Pembelian Baru" checked>
                                    <label class="form-check-label fw-bold" for="tipe_pembelian_baru">
                                        <i class="bi bi-cart-plus-fill text-success me-1"></i> Pembelian Baru (Stok)
                                    </label>
                                </div>
                                <div class="form-check flex-fill">
                                    <input class="form-check-input" type="radio" name="tipe_pengajuan"
                                        id="tipe_repair_perangkat" value="Repair Perangkat">
                                    <label class="form-check-label fw-bold" for="tipe_repair_perangkat">
                                        <i class="bi bi-tools text-warning me-1"></i> Repair Perangkat
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="alertRepairMode" class="alert alert-warning d-none mb-3" role="alert">
                            <i class="bi bi-tools me-2"></i>
                            <strong>Mode Repair:</strong> Kolom Harga dinonaktifkan. Wajib isi <strong>SN
                                Perangkat</strong> dan <strong>Foto SN</strong> di setiap baris.
                        </div>

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
                                <input type="text" name="divisi" class="form-control" value="Manage Service AI BAKTI"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold" style="font-size: 0.85rem;">No. Pengajuan</label>
                            <input type="text" name="nomor" class="form-control" placeholder="Contoh: 001/SP/2026">
                        </div>

                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-muted mb-0">Detail Perangkat</h6>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-add-item-trigger"
                                id="btnAddItem"><i class="bi bi-plus"></i></button>
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
                                <div class="row mt-3 repair-fields"
                                    style="display: none; background: linear-gradient(135deg, #fff5f5 0%, #fff0f0 100%); padding: 16px; border-radius: 10px; border: 1.5px solid #f5c6c6; gap: 0;">
                                    <div class="col-12 mb-2">
                                        <div class="d-flex align-items-center gap-2 mb-2" style="border-bottom: 1px solid #f5c6c6; padding-bottom: 8px;">
                                            <span style="background:#dc3545;border-radius:6px;padding:4px 8px;display:inline-flex;align-items:center;">
                                                <i class="bi bi-cpu-fill text-white" style="font-size:0.85rem;"></i>
                                            </span>
                                            <span class="fw-bold text-danger" style="font-size:0.82rem;">Informasi Perangkat yang di-Repair</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;">
                                            <i class="bi bi-upc-scan me-1"></i>SN Perangkat yang akan direpair <span class="badge bg-danger" style="font-size:0.65rem;">Wajib</span>
                                        </label>
                                        <input type="hidden" class="hidden-sn">
                                        <div class="sn-custom-dropdown" style="position:relative;">
                                            {{-- Trigger button --}}
                                            <div class="sn-trigger form-control d-flex align-items-center justify-content-between"
                                                style="cursor:pointer; font-size:0.85rem; border:1.5px solid #dee2e6; border-radius:6px; background:#fff; user-select:none;">
                                                <span class="sn-trigger-text text-muted">-- Pilih SN --</span>
                                                <i class="bi bi-chevron-down text-muted" style="font-size:0.75rem;"></i>
                                            </div>
                                            {{-- Dropdown panel (hidden by default) --}}
                                            <div class="sn-dropdown-panel" style="display:none; position:absolute; top:100%; left:0; right:0; z-index:9999; background:#fff; border:1.5px solid #4f8ef7; border-radius:6px; box-shadow:0 4px 15px rgba(0,0,0,0.12); margin-top:2px;">
                                                <div style="padding:6px 8px; border-bottom:1px solid #e3ecfc; background:#f0f5ff;">
                                                    <input type="text" class="form-control form-control-sm sn-search-input"
                                                        placeholder="🔍 Ketik SN atau nama perangkat..."
                                                        autocomplete="off"
                                                        style="border:1.5px solid #4f8ef7; border-radius:5px; font-size:0.82rem;">
                                                </div>
                                                <select name="sn_perangkat[]" class="form-select input-sn sn-list-select"
                                                    size="6"
                                                    style="border:none; border-radius:0 0 6px 6px; font-size:0.8rem; height:140px; overflow-y:auto;">
                                                    <option value="">-- Pilih SN --</option>
                                                    @foreach($allSNs['sparetracker'] as $sn)
                                                        @if(!empty(trim($sn->sn)) && trim($sn->sn) !== '-' && strtolower(trim($sn->sn)) !== 'unreadable')
                                                        @php
                                                            $info = collect([$sn->nama_perangkat, $sn->jenis, $sn->kondisi, $sn->lokasi])
                                                                ->filter()->implode(' | ');
                                                        @endphp
                                                        <option value="{{ $sn->sn }}">{{ $sn->sn }}{{ $info ? ' — '.$info : '' }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-1" style="font-size:0.75rem; color:#888;">
                                            <i class="bi bi-info-circle me-1"></i>Ketik SN atau nama perangkat untuk mencari
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;"><i class="bi bi-image me-1"></i>Foto SN Perangkat <span class="badge bg-danger" style="font-size:0.65rem;">Wajib</span></label>
                                        <input type="file" name="foto_sn[]" class="form-control form-control-sm input-foto-sn" accept="image/*" style="border-radius:8px;">
                                    </div>
                                    {{-- Auto-fill foto perangkat dari Spare Tracker --}}
                                    <div class="col-md-6 mt-0 sn-foto-preview-create" style="display:none;">
                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;"><i class="bi bi-camera-fill me-1"></i>Foto Perangkat (Spare Tracker)</label>
                                        <div class="d-flex align-items-center gap-3 p-2 bg-white rounded border">
                                            <a class="sn-foto-link" href="#" target="_blank">
                                                <img class="sn-foto-img" src="" alt="foto perangkat" style="max-height:80px;max-width:120px;border-radius:6px;border:1px solid #ddd;object-fit:cover;cursor:pointer;">
                                            </a>
                                            <p class="mb-0 text-muted" style="font-size:0.75rem;">Klik gambar untuk melihat penuh</p>
                                        </div>
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
                        <div class="modal-header text-white d-flex justify-content-center position-relative edit-modal-header-{{ $p->id }}"
                            style="background-color: {{ $p->tipe_pengajuan === 'Repair Perangkat' ? '#dc3545' : '#0d6efd' }}; border-radius: 15px 15px 0 0;">
                            <h5 class="modal-title w-100 text-center fw-bold edit-modal-title-{{ $p->id }}">
                                @if($p->tipe_pengajuan === 'Repair Perangkat')
                                    <i class="bi bi-tools me-2"></i>Edit Pengajuan Repair
                                @else
                                    <i class="bi bi-pencil-square me-2"></i>Edit Formulir Pengajuan
                                @endif
                            </h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                                data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body pt-4">
                            <form action="{{ route('sparepart.needed.pengajuan.update', $p->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Toggle Tipe Pengajuan --}}
                                <div class="mb-3 p-3 rounded-3" style="background: #f8f9fa; border: 1px solid #dee2e6;">
                                    <label class="form-label fw-bold mb-2" style="font-size:0.85rem;"><i
                                            class="bi bi-arrow-left-right me-1"></i>Tipe Pengajuan</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check flex-fill border rounded-3 p-3 mb-0"
                                            style="cursor:pointer; background:#fff;">
                                            <input class="form-check-input edit-tipe-radio" type="radio" name="tipe_pengajuan"
                                                id="edit_tipe_pembelian_{{ $p->id }}" value="Pembelian Baru"
                                                data-modal-id="{{ $p->id }}" {{ ($p->tipe_pengajuan !== 'Repair Perangkat') ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold w-100" for="edit_tipe_pembelian_{{ $p->id }}"
                                                style="cursor:pointer;">
                                                <i class="bi bi-cart-plus-fill text-success me-1"></i> Pembelian Baru
                                            </label>
                                        </div>
                                        <div class="form-check flex-fill border rounded-3 p-3 mb-0"
                                            style="cursor:pointer; background:#fff;">
                                            <input class="form-check-input edit-tipe-radio" type="radio" name="tipe_pengajuan"
                                                id="edit_tipe_repair_{{ $p->id }}" value="Repair Perangkat"
                                                data-modal-id="{{ $p->id }}" {{ $p->tipe_pengajuan === 'Repair Perangkat' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold w-100" for="edit_tipe_repair_{{ $p->id }}"
                                                style="cursor:pointer;">
                                                <i class="bi bi-tools text-warning me-1"></i> Repair Perangkat
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-warning mb-3 edit-repair-alert-{{ $p->id }} {{ $p->tipe_pengajuan === 'Repair Perangkat' ? '' : 'd-none' }}"
                                    role="alert">
                                    <i class="bi bi-tools me-2"></i>
                                    <strong>Mode Repair:</strong> Kolom Harga dinonaktifkan. SN dan Foto SN wajib diisi.
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Tempat, Tanggal</label>
                                        <input type="text" name="tempat_tanggal" class="form-control"
                                            value="{{ $p->tempat_tanggal }}" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Divisi / Bagian</label>
                                        <input type="text" name="divisi" class="form-control" value="{{ $p->divisi }}" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="font-size: 0.85rem;">No. Pengajuan</label>
                                    <input type="text" name="nomor" class="form-control" value="{{ $p->nomor }}"
                                        placeholder="Contoh: 001/SP/2026">
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
                                                    style="top: 10px; right: 10px; z-index: 10; {{ count($p->items) <= 1 ? 'display: none;' : '' }}"
                                                    title="Hapus"><i class="bi bi-x"></i></button>
                                                <div class="row mb-2">
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Perangkat</label>
                                                        <input type="text" name="perangkat[]" class="form-control" required
                                                            value="{{ $item['perangkat'] ?? '' }}" placeholder="Contoh: ROUTER">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Qty</label>
                                                        <input type="number" name="qty[]" class="form-control input-qty" min="1"
                                                            value="{{ $item['qty'] ?? 1 }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Harga
                                                            Satuan</label>
                                                        <div
                                                            class="input-group edit-harga-group-{{ $p->id }} {{ $p->tipe_pengajuan === 'Repair Perangkat' ? 'opacity-50' : '' }}">
                                                            <span class="input-group-text">Rp</span>
                                                            <input type="number" name="harga[]" class="form-control input-harga"
                                                                value="{{ $item['harga'] ?? 0 }}" {{ $p->tipe_pengajuan === 'Repair Perangkat' ? 'readonly' : '' }} placeholder="50000">
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
                                                        <input type="text" name="layanan[]" class="form-control"
                                                            value="{{ $item['layanan'] ?? 'BMN' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Peruntukan</label>
                                                        <input type="text" name="peruntukan[]" class="form-control"
                                                            value="{{ $item['peruntukan'] ?? 'STOK' }}">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label fw-bold" style="font-size: 0.85rem;">Keterangan</label>
                                                        <input type="text" name="keterangan[]" class="form-control"
                                                            value="{{ $item['keterangan'] ?? '-' }}">
                                                    </div>
                                                </div>
                                                {{-- Repair Fields (shown/hidden dynamically) --}}
                                                <div class="row mt-3 edit-repair-fields-{{ $p->id }} {{ $p->tipe_pengajuan === 'Repair Perangkat' ? '' : 'd-none' }}"
                                                    style="background: linear-gradient(135deg, #fff5f5 0%, #fff0f0 100%); padding: 16px; border-radius: 10px; border: 1.5px solid #f5c6c6; gap: 0;">
                                                    <div class="col-12 mb-2">
                                                        <div class="d-flex align-items-center gap-2 mb-2" style="border-bottom: 1px solid #f5c6c6; padding-bottom: 8px;">
                                                            <span style="background:#dc3545;border-radius:6px;padding:4px 8px;display:inline-flex;align-items:center;">
                                                                <i class="bi bi-cpu-fill text-white" style="font-size:0.85rem;"></i>
                                                            </span>
                                                            <span class="fw-bold text-danger" style="font-size:0.82rem;">Informasi Perangkat yang di-Repair</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-2">
                                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;">
                                                            <i class="bi bi-upc-scan me-1"></i>SN Perangkat yang direpair <span class="badge bg-danger" style="font-size:0.65rem;">Wajib</span>
                                                        </label>
                                                        <input type="hidden" class="hidden-sn" value="{{ $item['sn_perangkat'] ?? '' }}">
                                                        <div class="sn-custom-dropdown" style="position:relative;">
                                                            {{-- Trigger button --}}
                                                            <div class="sn-trigger form-control d-flex align-items-center justify-content-between"
                                                                style="cursor:pointer; font-size:0.85rem; border:1.5px solid #dee2e6; border-radius:6px; background:#fff; user-select:none;">
                                                                <span class="sn-trigger-text {{ empty($item['sn_perangkat']) ? 'text-muted' : 'fw-semibold text-dark' }}">
                                                                    {{ !empty($item['sn_perangkat']) ? $item['sn_perangkat'] : '-- Pilih SN --' }}
                                                                </span>
                                                                <i class="bi bi-chevron-down text-muted" style="font-size:0.75rem;"></i>
                                                            </div>
                                                            {{-- Dropdown panel (hidden by default) --}}
                                                            <div class="sn-dropdown-panel" style="display:none; position:absolute; top:100%; left:0; right:0; z-index:9999; background:#fff; border:1.5px solid #4f8ef7; border-radius:6px; box-shadow:0 4px 15px rgba(0,0,0,0.12); margin-top:2px;">
                                                                <div style="padding:6px 8px; border-bottom:1px solid #e3ecfc; background:#f0f5ff;">
                                                                    <input type="text" class="form-control form-control-sm sn-search-input"
                                                                        placeholder="🔍 Ketik SN atau nama perangkat..."
                                                                        autocomplete="off"
                                                                        style="border:1.5px solid #4f8ef7; border-radius:5px; font-size:0.82rem;">
                                                                </div>
                                                                <select name="sn_perangkat[]" class="form-select sn-list-select"
                                                                    size="6"
                                                                    style="border:none; border-radius:0 0 6px 6px; font-size:0.8rem; height:140px; overflow-y:auto;">
                                                                    <option value="">-- Pilih SN --</option>
                                                                    @foreach($allSNs['sparetracker'] as $sn)
                                                                        @if(!empty(trim($sn->sn)) && trim($sn->sn) !== '-' && strtolower(trim($sn->sn)) !== 'unreadable')
                                                                        @php
                                                                            $info = collect([$sn->nama_perangkat, $sn->jenis, $sn->kondisi, $sn->lokasi])
                                                                                ->filter()->implode(' | ');
                                                                        @endphp
                                                                        <option value="{{ $sn->sn }}" {{ ($item['sn_perangkat'] ?? '') === $sn->sn ? 'selected' : '' }}>{{ $sn->sn }}{{ $info ? ' — '.$info : '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mt-1" style="font-size:0.75rem; color:#888;">
                                                            <i class="bi bi-info-circle me-1"></i>Ketik SN atau nama perangkat untuk mencari
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;"><i
                                                                class="bi bi-image me-1"></i>Foto SN <span class="badge bg-danger" style="font-size:0.65rem;">Wajib</span></label>
                                                        @if(!empty($item['foto_sn']))
                                                            <div class="mb-1"><small class="text-success"><i class="bi bi-check-circle"></i>
                                                                    Sudah ada foto</small></div>
                                                        @endif
                                                        <input type="file" name="foto_sn[]" class="form-control form-control-sm input-foto-sn" accept="image/*" style="border-radius:8px;">
                                                    </div>
                                                    {{-- Auto-fill foto perangkat dari Spare Tracker (Edit Modal) --}}
                                                    <div class="col-md-6 mt-2 sn-foto-preview-edit" style="display:none;">
                                                        <label class="form-label fw-semibold text-danger mb-1" style="font-size: 0.82rem;"><i class="bi bi-camera-fill me-1"></i>Foto Perangkat (Spare Tracker)</label>
                                                        <div class="d-flex align-items-center gap-3 p-2 bg-white rounded border">
                                                            <a class="sn-foto-link" href="#" target="_blank">
                                                                <img class="sn-foto-img" src="" alt="foto perangkat" style="max-height:80px;max-width:120px;border-radius:6px;border:1px solid #ddd;object-fit:cover;cursor:pointer;">
                                                            </a>
                                                            <p class="mb-0 text-muted" style="font-size:0.75rem;">Klik gambar untuk melihat penuh</p>
                                                        </div>
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
                        // Destroy Select2 temporarily on the first row to clean up cloning
                        const firstRowSource = itemsContainer.querySelector('.item-row');
                        const selectElement = firstRowSource.querySelector('.select2-sn-create');
                        if (selectElement && $(selectElement).hasClass('select2-hidden-accessible')) {
                            $(selectElement).select2('destroy');
                        }

                        const firstRow = firstRowSource.cloneNode(true);

                        // Re-init Select2 on the source row
                        if (selectElement && typeof initCreateSN === 'function') {
                            initCreateSN();
                        } else if (selectElement) {
                            $(selectElement).select2({ theme: 'bootstrap-5', tags: true, width: '100%', dropdownParent: $('#modalPrintPengajuan') });
                        }

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

                        // Clear selected options in cloned select
                        const clonedSelect = firstRow.querySelector('.select2-sn-create');
                        if (clonedSelect) {
                            clonedSelect.innerHTML = clonedSelect.innerHTML; // clear state if needed
                            Array.from(clonedSelect.options).forEach(opt => opt.selected = false);
                        }

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

                        // Re-init Select2 on the new row
                        if (typeof initCreateSN === 'function') {
                            initCreateSN();
                        } else if (clonedSelect) {
                            $(clonedSelect).select2({ theme: 'bootstrap-5', tags: true, width: '100%', dropdownParent: $('#modalPrintPengajuan') });
                        }
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

        // Simpan pengajuan ke DB saat form diproses
        const formPengajuan = document.getElementById('formPengajuan');
        if (formPengajuan) {
            formPengajuan.addEventListener('submit', function (e) {
                // Prevent default if it's Save (target _self) to allow dual fetch
                const isPrint = this.action.includes('print');

                if (!isPrint) {
                    e.preventDefault(); // Stop native submission for Save
                }

                const formData = new FormData(this);

                // 1. Fetch to Sparepart Needed Store
                const request1 = fetch("{{ route('sparepart.needed.pengajuan.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                // 2. Fetch to Inventory Store
                const request2 = fetch("{{ route('inventory.pengajuan.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: { "X-Requested-With": "XMLHttpRequest" }
                });

                Promise.all([request1, request2]).then(() => {
                    if (!isPrint) {
                        window.location.reload();
                    } else {
                        setTimeout(() => window.location.reload(), 1500);
                    }
                }).catch(err => {
                    console.error("Error saving data:", err);
                    alert("Terjadi kesalahan saat menyimpan data.");
                });
            });
        }

        function toggleBuktiTransferSp(id) {
            const status = document.getElementById('status_pembayaran_sp_' + id).value;
            const dpContainer = document.getElementById('bukti_dp_container_sp_' + id);
            const lunasContainer = document.getElementById('bukti_transfer_container_sp_' + id);
            const isDpOrLunas = status === 'dp_50' || status === 'lunas';
            const isLunas = status === 'lunas';

            if (dpContainer) dpContainer.style.display = isDpOrLunas ? 'block' : 'none';
            if (lunasContainer) lunasContainer.style.display = isLunas ? 'block' : 'none';
        }

        // ============================================================
        // TOGGLE TIPE PENGAJUAN DI MODAL EDIT
        // ============================================================
        function bindEditTipeRadio() {
            document.querySelectorAll('.edit-tipe-radio').forEach(function (radio) {
                // Hapus event listener lama jika ada (untuk mencegah multiple fire)
                radio.removeEventListener('change', handleEditTipeRadioChange);
                radio.addEventListener('change', handleEditTipeRadioChange);
            });
        }

        function handleEditTipeRadioChange() {
            const modalId = this.dataset.modalId;
            const isRepair = (this.value === 'Repair Perangkat');

            // 1. Ubah warna header modal
            const header = document.querySelector('.edit-modal-header-' + modalId);
            const title = document.querySelector('.edit-modal-title-' + modalId);
            if (header) header.style.backgroundColor = isRepair ? '#dc3545' : '#0d6efd';
            if (title) {
                title.innerHTML = isRepair
                    ? '<i class="bi bi-tools me-2"></i>Edit Pengajuan Repair'
                    : '<i class="bi bi-pencil-square me-2"></i>Edit Formulir Pengajuan';
            }

            // 2. Tampilkan/sembunyikan alert repair
            const alert = document.querySelector('.edit-repair-alert-' + modalId);
            if (alert) alert.classList.toggle('d-none', !isRepair);

            // 3. Tampilkan/sembunyikan semua baris field repair
            document.querySelectorAll('.edit-repair-fields-' + modalId).forEach(function (el) {
                el.classList.toggle('d-none', !isRepair);
            });

            // 4. Lock/unlock semua field harga dan tetap pertahankan nilainya
            document.querySelectorAll('.edit-harga-group-' + modalId).forEach(function (group) {
                group.classList.toggle('opacity-50', isRepair);
                const hargaInput = group.querySelector('.input-harga');
                if (hargaInput) {
                    if (isRepair) {
                        hargaInput.setAttribute('readonly', true);
                    } else {
                        hargaInput.removeAttribute('readonly');
                    }
                    // Trigger kalkulasi ulang jika diperlukan
                    hargaInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });
        }

        bindEditTipeRadio();


        // Toggle fields for Repair Perangkat (Lama)
        function toggleRepairFields() {
            const tipe = document.getElementById('tipePengajuan')?.value;
            const isRepair = tipe === 'repair_perangkat';

            const inputFotoSn = document.getElementById('inputFotoSn');
            const inputFotoTerpasang = document.getElementById('inputFotoTerpasang');

            // Toggle required
            if (inputFotoSn) inputFotoSn.required = isRepair;
            if (inputFotoTerpasang) inputFotoTerpasang.required = isRepair;

            // Toggle badge labels
            document.querySelectorAll('.repair-required-badge').forEach(el => {
                el.style.display = isRepair ? 'inline' : 'none';
            });
            document.querySelectorAll('.optional-label').forEach(el => {
                el.style.display = isRepair ? 'none' : 'inline';
            });

            // Highlight wrapper
            const wrappers = [document.getElementById('fotoSnWrapper'), document.getElementById('fotoTerpasangWrapper')];
            wrappers.forEach(w => {
                if (w) {
                    if (isRepair) {
                        w.style.border = '2px solid #0d6efd';
                        w.style.borderRadius = '8px';
                        w.style.padding = '10px';
                        w.style.background = '#f0f5ff';
                    } else {
                        w.style.border = 'none';
                        w.style.borderRadius = '';
                        w.style.padding = '';
                        w.style.background = '';
                    }
                }
            });
        }

        // JS UI Logic for Tipe Pengajuan Utama (Print & Save)
        document.addEventListener('DOMContentLoaded', function () {
            // Listen to radio button changes instead of select
            const radioButtons = document.querySelectorAll('input[name="tipe_pengajuan"]');
            const headerModal = document.getElementById('headerModalPengajuan');
            const titleModal = document.getElementById('titleModalPengajuan');
            const alertRepair = document.getElementById('alertRepairMode');

            function getTipeValue() {
                const checked = document.querySelector('input[name="tipe_pengajuan"]:checked');
                return checked ? checked.value : 'Pembelian Baru';
            }

            function applyTipePengajuanLogic() {
                const isRepair = getTipeValue() === 'Repair Perangkat';

                // Update modal header appearance
                if (headerModal && titleModal) {
                    if (isRepair) {
                        headerModal.style.backgroundColor = '#dc3545';
                        titleModal.innerHTML = '<i class="bi bi-tools me-2"></i>Pengajuan Repair Perangkat';
                    } else {
                        headerModal.style.backgroundColor = '#198754';
                        titleModal.innerHTML = '<i class="bi bi-cart-plus-fill me-2"></i>Pengajuan Pembelian Baru';
                    }
                }

                // Show/hide repair alert
                if (alertRepair) {
                    alertRepair.classList.toggle('d-none', !isRepair);
                }

                document.querySelectorAll('.item-row').forEach(row => {
                    const repairFields = row.querySelector('.repair-fields');
                    const inputHarga = row.querySelector('.input-harga');
                    const inputSn = row.querySelector('.input-sn');
                    const inputFotoSn = row.querySelector('.input-foto-sn');
                    const inputFotoPerangkat = row.querySelector('.input-foto-perangkat');

                    if (isRepair) {
                        if (repairFields) repairFields.style.display = 'flex';
                        if (inputHarga) {
                            inputHarga.value = '0';
                            inputHarga.setAttribute('readonly', 'readonly');
                            inputHarga.parentElement.parentElement.style.opacity = '0.5';
                        }
                        if (inputSn) inputSn.setAttribute('required', 'required');
                        if (inputFotoSn) inputFotoSn.setAttribute('required', 'required');
                        if (inputFotoPerangkat) inputFotoPerangkat.setAttribute('required', 'required');
                    } else {
                        if (repairFields) repairFields.style.display = 'none';
                        if (inputHarga) {
                            inputHarga.removeAttribute('readonly');
                            inputHarga.parentElement.parentElement.style.opacity = '1';
                        }
                        if (inputSn) inputSn.removeAttribute('required');
                        if (inputFotoSn) inputFotoSn.removeAttribute('required');
                        if (inputFotoPerangkat) inputFotoPerangkat.removeAttribute('required');
                    }
                });
            }

            radioButtons.forEach(radio => {
                radio.addEventListener('change', applyTipePengajuanLogic);
            });

            // Listen to dynamically added rows to apply logic
            const itemsContainer = document.getElementById('itemsContainer');
            if (itemsContainer) {
                const observer = new MutationObserver(applyTipePengajuanLogic);
                observer.observe(itemsContainer, { childList: true });
            }

            // Initial apply
            applyTipePengajuanLogic();

            // ============================================================
            // AJAX FILTER PENGAJUAN FORM
            // ============================================================
            const filterForm = document.getElementById('filterPengajuanForm');
            const tableContainer = document.getElementById('tablePengajuanContainer');
            if (filterForm && tableContainer) {
                filterForm.querySelectorAll('select').forEach(select => {
                    select.addEventListener('change', function () {
                        const url = new URL(filterForm.action);
                        const formData = new FormData(filterForm);
                        const searchParams = new URLSearchParams(formData);
                        url.search = searchParams.toString();

                        tableContainer.style.opacity = '0.5';

                        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContainer = doc.getElementById('tablePengajuanContainer');
                                if (newContainer) {
                                    tableContainer.innerHTML = newContainer.innerHTML;

                                    // Re-initialize modal interactions on the newly loaded rows
                                    bindEditTipeRadio();

                                    // Optionally update URL to allow page refreshes to remember filters
                                    window.history.replaceState({}, '', url);
                                }
                                tableContainer.style.opacity = '1';
                            })
                            .catch(err => {
                                console.error('Error filtering table:', err);
                                tableContainer.style.opacity = '1';
                            });
                    });
                });
            }
        });
    </script>

    {{-- SN Custom Dropdown Script (vanilla JS) --}}
    <script>
    document.addEventListener('click', function(e) {
        // Handle trigger click
        var trigger = e.target.closest('.sn-trigger');
        if (trigger) {
            var wrapper = trigger.closest('.sn-custom-dropdown');
            var panel = wrapper.querySelector('.sn-dropdown-panel');
            var input = wrapper.querySelector('.sn-search-input');
            
            // Toggle panel
            var isHidden = panel.style.display === 'none';
            // Close all other panels first
            document.querySelectorAll('.sn-dropdown-panel').forEach(p => p.style.display = 'none');
            
            if (isHidden) {
                panel.style.display = 'block';
                input.focus();
            }
            return;
        }

        // Close panel if clicked outside
        if (!e.target.closest('.sn-custom-dropdown')) {
            document.querySelectorAll('.sn-dropdown-panel').forEach(p => p.style.display = 'none');
        }
    });

    // Filter opsi di sn-list-select saat mengetik di sn-search-input
    document.addEventListener('input', function(e) {
        if (!e.target.classList.contains('sn-search-input')) return;
        var keyword = e.target.value.toLowerCase().trim();
        var select = e.target.closest('.sn-custom-dropdown').querySelector('.sn-list-select');
        if (!select) return;
        Array.from(select.options).forEach(function(opt) {
            if(opt.value === '') return; // Skip placeholder
            var text = (opt.text + ' ' + opt.value).toLowerCase();
            opt.hidden = keyword !== '' && text.indexOf(keyword) === -1;
        });
    });

    // Saat user klik option di sn-list-select
    document.addEventListener('change', function(e) {
        if (!e.target.classList.contains('sn-list-select')) return;
        var select = e.target;
        var selectedOpt = select.options[select.selectedIndex];
        var wrapper = select.closest('.sn-custom-dropdown');
        if (!wrapper) return;
        
        var triggerText = wrapper.querySelector('.sn-trigger-text');
        var panel = wrapper.querySelector('.sn-dropdown-panel');
        var hiddenInput = wrapper.closest('.repair-fields, [class*="edit-repair-fields-"]').querySelector('.hidden-sn');
        
        if (selectedOpt && selectedOpt.value !== '') {
            triggerText.textContent = selectedOpt.value;
            triggerText.classList.remove('text-muted');
            triggerText.classList.add('fw-semibold', 'text-dark');
            if(hiddenInput) hiddenInput.value = selectedOpt.value;
        } else {
            triggerText.textContent = '-- Pilih SN --';
            triggerText.classList.add('text-muted');
            triggerText.classList.remove('fw-semibold', 'text-dark');
            if(hiddenInput) hiddenInput.value = '';
        }
        
        // Trigger change event manual untuk sync foto (di script bawah)
        var event = new Event('change', { bubbles: true });
        hiddenInput.dispatchEvent(event);

        // Tutup panel
        panel.style.display = 'none';
    });
    </script>

    {{-- Select2 initialization for SN fields --}}
    <script>
    $(document).ready(function() {

        /**
         * Custom Select2 Matcher:
         * - Strips zero-width characters (from copy-paste) and normalizes whitespace
         * - Searches against both option text and option value (id)
         * - Correctly handles optgroup by filtering children
         */
        function customSelect2Matcher(params, data) {
            // Helper: clean and lowercase a string
            function cleanStr(str) {
                if (str === null || str === undefined) return '';
                return String(str)
                    .replace(/[\u200B-\u200D\uFEFF\u00A0]/g, '') // zero-width + non-breaking space
                    .replace(/\s+/g, ' ')
                    .trim()
                    .toLowerCase();
            }

            // If no search term, show everything
            if (!params.term || params.term.trim() === '') return data;

            var term = cleanStr(params.term);

            // Handle optgroup (has children)
            if (data.children && data.children.length > 0) {
                var filteredChildren = [];
                $.each(data.children, function(_, child) {
                    var childText = cleanStr(child.text);
                    var childId   = cleanStr(child.id);
                    if (childText.indexOf(term) !== -1 || childId.indexOf(term) !== -1) {
                        filteredChildren.push(child);
                    }
                });
                if (filteredChildren.length > 0) {
                    // Shallow clone to avoid mutating Select2 internals
                    var modifiedData = $.extend({}, data);
                    modifiedData.children = filteredChildren;
                    return modifiedData;
                }
                return null;
            }

            // Handle regular option
            var text = cleanStr(data.text);
            var id   = cleanStr(data.id);
            if (text.indexOf(term) !== -1 || id.indexOf(term) !== -1) {
                return data;
            }
            return null;
        }

        var select2BaseConfig = {
            theme: 'bootstrap-5',
            placeholder: '-- Cari SN atau nama perangkat --',
            allowClear: true,
            width: '100%',
            dropdownCssClass: 'select2-sn-dropdown',
            tags: true,
            createTag: function(params) {
                var term = $.trim(params.term);
                if (!term) return null;
                return { id: term, text: '✏️ Manual: ' + term, newTag: true };
            },
            matcher: customSelect2Matcher,
            templateResult: function(data) {
                if (!data.id || data.id === '') return data.text;
                // Parse: "SN — Nama Perangkat @ Lokasi (Site)" or "SN | Nama"
                var raw = data.text || '';
                var sep = raw.indexOf(' — ') !== -1 ? ' — ' : (raw.indexOf(' | ') !== -1 ? ' | ' : null);
                var sn = raw, info = '';
                if (sep) {
                    var parts = raw.split(sep);
                    sn   = (parts[0] || '').trim();
                    info = (parts.slice(1).join(sep) || '').trim();
                }
                var $el = $('<div class="s2-item-sn"></div>');
                $('<div class="s2-item-sn__code"></div>').text(sn).appendTo($el);
                if (info) $('<div class="s2-item-sn__info"></div>').text(info).appendTo($el);
                return $el;
            },
            templateSelection: function(data) {
                if (!data.id) { return data.text; }
                // Hanya tampilkan SN (teks sebelum karakter | atau —) agar tag lebih rapi
                return data.text.split(' | ')[0].split('—')[0].trim();
            }
        };

        // --- Init for CREATE modal (#modalPrintPengajuan) ---
        function initCreateSN() {
            $('.select2-sn-create').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
                $(this).select2($.extend({}, select2BaseConfig, {
                    dropdownParent: $('#modalPrintPengajuan'),
                    width: '100%'
                }));
            });
        }

        // Init EDIT modal SN selects (each has unique class)
        function initEditSN($modal) {
            $modal.find('[class*="select2-sn-edit-"]').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
                $(this).select2($.extend({}, select2BaseConfig, {
                    dropdownParent: $modal,
                    width: '100%'
                }));
            });
        }

        // When the create modal opens
        $('#modalPrintPengajuan').on('shown.bs.modal', function() {
            initCreateSN();
        });

        // When any edit modal opens
        $(document).on('shown.bs.modal', '[id^="modalEditPengajuan"]', function() {
            initEditSN($(this));
        });

        // -------------------------------------------------------
        // Build foto lookup map from Blade data (reliable, no DOM issues)
        // -------------------------------------------------------
        var snFotoMap = {};
        @foreach($allSNs['sparetracker'] as $sn)
            @if($sn->foto)
            snFotoMap[{{ json_encode($sn->sn) }}] = {{ json_encode(asset('storage/' . $sn->foto)) }};
            @endif
        @endforeach

        // Sync hidden input + auto-fill foto for EDIT modals
        $(document).on('change', '[class*="select2-sn-edit-"]', function() {
            var selected = $(this).val();
            var valStr = Array.isArray(selected) ? selected.join(', ') : (selected || '');
            var $repairRow  = $(this).closest('[class*="edit-repair-fields-"]');
            $repairRow.find('.hidden-sn').val(valStr);

            var $previewDiv = $repairRow.find('.sn-foto-preview-edit');
            var snVal = Array.isArray(selected) ? selected[0] : selected;

            if (!snVal) {
                $previewDiv.hide();
                return;
            }

            if (snFotoMap[snVal]) {
                $previewDiv.find('.sn-foto-img').attr('src', snFotoMap[snVal]);
                $previewDiv.find('.sn-foto-link').attr('href', snFotoMap[snVal]);
                $previewDiv.show();
            } else {
                $.ajax({
                    url: '/api/sparetracker/sn/' + encodeURIComponent(snVal),
                    type: 'GET',
                    success: function(data) {
                        if (data.found && data.foto_url) {
                            snFotoMap[snVal] = data.foto_url;
                            $previewDiv.find('.sn-foto-img').attr('src', data.foto_url);
                            $previewDiv.find('.sn-foto-link').attr('href', data.foto_url);
                            $previewDiv.show();
                        } else {
                            $previewDiv.hide();
                        }
                    },
                    error: function() { $previewDiv.hide(); }
                });
            }
        });

        // CREATE repair: sync hidden input + auto-fill foto preview
        $(document).on('change', '.select2-sn-create', function() {
            var snVal = $(this).val(); // single select, returns a string
            var $repairRow = $(this).closest('.repair-fields');
            var $hiddenSn = $repairRow.find('.hidden-sn');
            var $previewDiv = $repairRow.find('.sn-foto-preview-create');

            // Sync ke hidden input
            $hiddenSn.val(snVal || '');

            if (!snVal) {
                $previewDiv.hide();
                return;
            }

            // Cek di map dulu (sudah di-build dari server-side)
            if (snFotoMap[snVal]) {
                $previewDiv.find('.sn-foto-img').attr('src', snFotoMap[snVal]);
                $previewDiv.find('.sn-foto-link').attr('href', snFotoMap[snVal]);
                $previewDiv.show();
            } else {
                // Fallback: fetch via AJAX API
                $.ajax({
                    url: '/api/sparetracker/sn/' + encodeURIComponent(snVal),
                    type: 'GET',
                    success: function(data) {
                        if (data.found && data.foto_url) {
                            snFotoMap[snVal] = data.foto_url; // cache
                            $previewDiv.find('.sn-foto-img').attr('src', data.foto_url);
                            $previewDiv.find('.sn-foto-link').attr('href', data.foto_url);
                            $previewDiv.show();
                        } else {
                            $previewDiv.hide();
                        }
                    },
                    error: function() { $previewDiv.hide(); }
                });
            }
        });
    });
    </script>

    @include('components.nav-modal-structure')
</body>

</html>