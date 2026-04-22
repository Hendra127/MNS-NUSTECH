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
    <title>Log Perangkat | Project Operational</title>
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

        .col-site-id {
            left: 50px;
            min-width: 135px;
        }

        .col-nama_site {
            left: 185px;
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ route('pergantianperangkat') }}"
            class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}"
            style="text-decoration: none; color: White;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}"
            style="text-decoration: none; color: Black;">Summary</a>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3"
            style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button class="btn-action bi bi-plus" title="Add" id="addDataModall"></button>
                    <button class="btn-action bi bi-upload" title="Upload"></button>
                @endif
                <button class="btn-action bi bi-download" title="Download"></button>
            </div>
            <div class="w-100 mt-2 mt-lg-0 d-flex justify-content-lg-end">
                <form method="GET" action="{{ route('datapas') }}" class="search-form m-0"
                    style="max-width: 320px; width: 100%;">
                    <div class="search-box d-flex align-items-center w-100">
                        <input type="text" name="search" placeholder="Search" value="{{ request('search') }}"
                            style="flex-grow: 1; border: none; outline: none; padding-left: 15px; background: transparent;">
                        <button type="submit" class="search-btn">🔍</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive-custom">
            <table>
                <thead>
                    <tr>
                        <th class="text-center sticky-col col-no">NO.</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-nama_site">SITE NAME</th>
                        <th>TIPE</th>
                        <th>BATCH</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="sticky-col-right">AKSI</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="10" class="empty text-center">
                            <!-- Empty State Content -->
                            Showing 0 of 0 results
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>