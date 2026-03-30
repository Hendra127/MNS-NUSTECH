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
    <title>Jadwal Shift - {{ $bulanSekarang }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * { box-sizing: border-box; }
        :root {
            --navy-primary:  #1e293b;
            --color-pagi:    #4CAF50;
            --color-siang:   #2196F3;
            --color-malam:   #FFC107;
            --color-off:     #e05c35;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0; padding: 0; color: #333;
        }

        /* ── HEADER ── */
        .main-header {
            background-color: #1a202c;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── TABS ── */


        /* ── TOOLBAR ── */
        .toolbar-card {
            background: white; padding: 12px 20px; border-radius: 8px;
            margin-bottom: 16px; display: flex; justify-content: space-between;
            align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* ── CAPTURE AREA ── */
        #capture-area {
            background: #ffffff;
            padding: 20px;
            border-radius: 4px;
            overflow-x: auto;
            max-width: 100%;
        }
        .report-header {
            text-align: center; margin-bottom: 12px;
            border-bottom: 3px solid var(--navy-primary); padding-bottom: 10px;
        }
        .main-title {
            font-weight: 800; font-size: 18px; color: var(--navy-primary);
            margin: 0; text-transform: uppercase; letter-spacing: 2px;
        }

        /* ═══════════════════════════════════════
           TABEL JADWAL — COMPACT SPREADSHEET
        ═══════════════════════════════════════ */
        .table-piket {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        /* Baris header hari */
        .table-piket thead tr.row-hari th {
            background-color: #334155 !important;
            color: #fff !important;
            font-size: 7.5px;
            font-weight: 700;
            text-align: center;
            padding: 3px 1px;
            border: 1px solid #475569;
            white-space: nowrap;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .table-piket thead tr.row-hari th.weekend-hdr {
            background-color: #4b5563 !important;
        }

        /* Baris header tanggal */
        .table-piket thead tr.row-tanggal th {
            background-color: var(--navy-primary) !important;
            color: #fff !important;
            font-size: 9px;
            font-weight: 700;
            text-align: center;
            padding: 4px 1px;
            border: 1px solid #374151;
            min-width: 30px;
        }
        .table-piket thead tr.row-tanggal th.weekend-hdr {
            background-color: #374151 !important;
        }

        /* Kolom sticky header Nama (rowspan=2) */
        .name-cell-header {
            background: var(--navy-primary) !important;
            color: white !important;
            font-size: 9px;
            font-weight: 700;
            text-align: center;
            padding: 4px 6px !important;
            position: sticky; left: 0; z-index: 20;
            border: 1px solid #374151 !important;
            min-width: 120px;
        }

        /* Kolom summary header */
        .th-summary {
            background-color: var(--navy-primary) !important;
            color: white !important;
            font-size: 8px !important;
            text-align: center;
            padding: 3px 4px !important;
            border: 1px solid #374151 !important;
            min-width: 26px;
            white-space: nowrap;
        }

        /* Kolom nama di body */
        .name-cell {
            background: #f8fafc !important;
            font-weight: 700; font-size: 9px; color: #1e293b;
            border: 1px solid #cbd5e1 !important;
            padding: 4px 8px !important;
            white-space: nowrap;
            position: sticky; left: 0; z-index: 10;
            min-width: 120px;
        }

        /* ── DRAG & DROP ── */
        .drag-handle {
            cursor: grab;
            color: #94a3b8;
            font-size: 11px;
            padding: 0 4px;
            transition: color 0.2s;
            user-select: none;
        }
        .drag-handle:hover { color: #475569; }
        .drag-handle:active { cursor: grabbing; }
        tr.sortable-ghost {
            opacity: 0.4;
            background: #e0f2fe !important;
        }
        tr.sortable-chosen { background: #f0f9ff !important; }
        tr.sortable-drag   { box-shadow: 0 8px 24px rgba(0,0,0,0.18); }

        /* Sel isi tabel body */
        .table-piket tbody td {
            padding: 2px 1px !important;
            text-align: center;
            vertical-align: middle;
            border: 1px solid #e2e8f0;
        }
        .td-weekend { background-color: #fff7ed !important; }

        /* ── SHIFT BOX (div non-admin) ── */
        .shift-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 22px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 800;
            color: white;
            margin: 0 auto;
            padding: 0;
            line-height: 1;
            text-align: center;
            cursor: default;
        }

        /* ── SHIFT SELECT (select admin) ── */
        select.shift-box {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            cursor: pointer;
            border: none;
            /* Centering teks di dalam <select> */
            padding: 0 !important;
            margin: 0 auto;
            text-align: center;
            text-align-last: center;       /* chrome/edge */
            -moz-text-align-last: center;  /* firefox */
            line-height: 22px;             /* = height → teks vertikal tengah */
        }
        select.shift-box:focus { outline: none; }
        select.shift-box option { text-align: center; }
        select.shift-box.has-changed {
            border: 2px solid #ef4444 !important;
            animation: pulse-border 2s infinite;
        }
        @keyframes pulse-border {
            0%   { border-color: #ef4444; }
            50%  { border-color: transparent; }
            100% { border-color: #ef4444; }
        }

        /* Warna shift */
        .bg-p   { background-color: var(--color-pagi)  !important; }
        .bg-s   { background-color: var(--color-siang) !important; }
        .bg-m   { background-color: var(--color-malam) !important; color: #333 !important; }
        .bg-off { background-color: var(--color-off)   !important; }

        /* ── SUMMARY CELLS ── */
        .td-summary {
            font-size: 9px; font-weight: 700;
            text-align: center; vertical-align: middle;
            border: 1px solid #e2e8f0;
            padding: 2px 4px !important;
            white-space: nowrap;
        }
        .td-off-val   { color: var(--color-off); }
        .td-m-val     { color: #92400e; }
        .td-p-val     { color: #14532d; }
        .td-s-val     { color: #1e3a8a; }
        .td-total-val { color: var(--navy-primary); font-weight: 900; }

        /* ── LEGEND ── */
        .legend-area {
            margin-top: 14px; display: flex; justify-content: center;
            gap: 20px; font-size: 11px; font-weight: 600; color: #64748b;
        }
        .legend-item { display: flex; align-items: center; gap: 6px; }
        .dot { width: 12px; height: 12px; border-radius: 2px; }
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
                <a href="{{ route('setting.index') }}" class="text-white opacity-75" title="Settings">
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
                <div id="profileDropdownMenu" class="hidden" style="position: absolute; right: 0; top: 100%; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
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

    <div class="tabs-section">
        <a href="{{ url('/todolist') }}" class="tab {{ request()->is('todolist*') ? 'active' : '' }}" style="text-decoration: none;">To Do List</a>
        @if(auth()->check() && auth()->user()->role === 'superadmin')
            <a href="{{ route('jadwalpiket') }}" class="tab {{ request()->is('jadwalpiket*') ? 'active' : '' }}" style="text-decoration: none;">Jadwal Piket</a>
            <a href="{{ route('remotelog') }}" class="tab {{ request()->is('remote-log*') ? 'active' : '' }}" style="text-decoration: none;">Log Remote</a>
        @endif
    </div>

    <div class="container-fluid px-4">
        {{-- TOOLBAR --}}
        <div class="toolbar-card no-capture">
            <div class="d-flex gap-3 align-items-center">
                <h5 class="m-0 fw-bold" style="color:#1e293b;">Manajemen Shift</h5>
                <form action="{{ route('jadwalpiket') }}" method="GET" class="d-flex gap-2">
                    <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                        @for ($y = date('Y') - 1; $y <= date('Y') + 1; $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </form>
            </div>
            <div class="d-flex gap-2">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button class="btn btn-outline-success btn-sm px-4 fw-bold" onclick="saveChanges()">
                        <i class="bi bi-save me-2"></i> Simpan Jadwal
                    </button>
                @endif
                <button class="btn btn-outline-primary btn-sm px-4 fw-bold" onclick="downloadCapture()">
                    <i class="bi bi-camera me-2"></i> Capture
                </button>
            </div>
        </div>

        {{-- CAPTURE AREA --}}
        <div id="capture-area">
            <div class="report-header">
                <div class="main-title">Jadwal Piket</div>
                <div class="text-muted small mt-1">Bulan: {{ $bulanSekarang }} {{ $tahunSekarang }} | NUSTECH Indonesia</div>
            </div>

            <div class="table-responsive" style="overflow: visible !important;">
                <table class="table table-borderless table-piket">
                    <thead>
                        {{-- Baris 1: NAMA (rowspan) + Hari + Summary header --}}
                        <tr class="row-hari">
                            {{-- Kolom drag handle (hanya admin) --}}
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <th class="name-cell-header" rowspan="2" style="min-width:22px; width:22px;"></th>
                            @endif
                            <th class="name-cell-header" rowspan="2">NAMA</th>
                            @for ($i = 1; $i <= $jumlahHari; $i++)
                                @php
                                    $hdrDate = \Carbon\Carbon::createFromDate($year, $month, $i);
                                    $dayName = strtoupper(substr($hdrDate->translatedFormat('l'), 0, 3));
                                    $isWeekend = in_array($hdrDate->dayOfWeek, [0, 6]);
                                @endphp
                                <th class="{{ $isWeekend ? 'weekend-hdr' : '' }}">{{ $dayName }}</th>
                            @endfor
                            <th class="th-summary" rowspan="2">OFF</th>
                            <th class="th-summary" rowspan="2">M</th>
                            <th class="th-summary" rowspan="2">P</th>
                            <th class="th-summary" rowspan="2">S</th>
                            <th class="th-summary" rowspan="2">TOTAL</th>
                        </tr>
                        {{-- Baris 2: Tanggal --}}
                        <tr class="row-tanggal">
                            @for ($i = 1; $i <= $jumlahHari; $i++)
                                @php
                                    $tglDate2 = \Carbon\Carbon::createFromDate($year, $month, $i);
                                    $isWeekend2 = in_array($tglDate2->dayOfWeek, [0, 6]);
                                @endphp
                                <th class="{{ $isWeekend2 ? 'weekend-hdr' : '' }}">{{ $i }}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody id="piket-tbody">
                        @foreach($daftarNama as $nama)
                            @php
                                $cntOff = 0;
                                $cntM = 0;
                                $cntP = 0;
                                $cntS = 0;
                                $userRow = \App\Models\User::where('name', 'like', '%' . trim($nama) . '%')->first();
                            @endphp
                            <tr data-nama="{{ trim($nama) }}">
                                {{-- Drag handle --}}
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <td class="name-cell align-middle" style="min-width:22px; width:22px; padding:0 !important; cursor:grab;">
                                        <span class="drag-handle"><i class="bi bi-grip-vertical"></i></span>
                                    </td>
                                @endif
                                <td class="name-cell align-middle"><span class="name-text">{{ $nama }}</span></td>

                                @for ($d = 1; $d <= $jumlahHari; $d++)
                                    @php
                                        $tgl = \Carbon\Carbon::createFromDate($year, $month, $d)->format('Y-m-d');
                                        $existing = $userRow
                                            ? $dataPiket->where('user_id', $userRow->id)->where('tanggal', $tgl)->first()
                                            : null;
                                        $kodeAktif = $existing && $existing->shift ? $existing->shift->kode : 'OFF';
                                        $kodeUp = strtoupper($kodeAktif);
                                        $class = match ($kodeUp) {
                                            'M' => 'bg-m', 'S' => 'bg-s', 'P' => 'bg-p', default => 'bg-off',
                                        };
                                        if ($kodeUp === 'OFF')
                                            $cntOff++;
                                        elseif ($kodeUp === 'M')
                                            $cntM++;
                                        elseif ($kodeUp === 'P')
                                            $cntP++;
                                        elseif ($kodeUp === 'S')
                                            $cntS++;

                                        $cellDate = \Carbon\Carbon::createFromDate($year, $month, $d);
                                        $isWE = in_array($cellDate->dayOfWeek, [0, 6]);
                                    @endphp
                                    <td class="{{ $isWE ? 'td-weekend' : '' }}">
                                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                            <select class="shift-box {{ $class }}"
                                                    data-nama="{{ trim($nama) }}"
                                                    data-tanggal="{{ $tgl }}"
                                                    onchange="updateData(this)">
                                                <option value="OFF" {{ $kodeUp == 'OFF' ? 'selected' : '' }}>OFF</option>
                                                <option value="P"   {{ $kodeUp == 'P' ? 'selected' : '' }}>P</option>
                                                <option value="S"   {{ $kodeUp == 'S' ? 'selected' : '' }}>S</option>
                                                <option value="M"   {{ $kodeUp == 'M' ? 'selected' : '' }}>M</option>
                                            </select>
                                        @else
                                            <div class="shift-box {{ $class }}">{{ $kodeUp }}</div>
                                        @endif
                                    </td>
                                @endfor

                                {{-- Summary --}}
                                <td class="td-summary td-off-val">{{ $cntOff }}</td>
                                <td class="td-summary td-m-val">{{ $cntM }}</td>
                                <td class="td-summary td-p-val">{{ $cntP }}</td>
                                <td class="td-summary td-s-val">{{ $cntS }}</td>
                                <td class="td-summary td-total-val">{{ $jumlahHari }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="legend-area">
                <div class="legend-item"><div class="dot bg-p"></div> Pagi (P)</div>
                <div class="legend-item"><div class="dot bg-s"></div> Siang (S)</div>
                <div class="legend-item"><div class="dot bg-m"></div> Malam (M)</div>
                <div class="legend-item"><div class="dot bg-off"></div> Libur (OFF)</div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055;">
        <div id="saveToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle me-1"></i> <span id="toastMessage">Jadwal berhasil disimpan!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
    function updateData(el) {
        const $el = $(el);
        const kode = $el.val();
        $el.removeClass('bg-p bg-s bg-m bg-off');
        if      (kode === 'P') $el.addClass('bg-p');
        else if (kode === 'S') $el.addClass('bg-s');
        else if (kode === 'M') $el.addClass('bg-m');
        else                   $el.addClass('bg-off');
        $el.addClass('has-changed');
    }

    /* ══ DRAG & DROP — hanya nama yang berpindah, shift data tetap di slot ══ */
    const SORT_KEY = 'jadwal_order_{{ $year }}_{{ $month }}';

    document.addEventListener('DOMContentLoaded', () => {
        const tbody = document.getElementById('piket-tbody');
        if (!tbody) return;

        // Tandai setiap baris dengan nomor slot tetap (tak pernah berubah)
        Array.from(tbody.rows).forEach((tr, i) => {
            tr.dataset.slot = i;
        });

        // ── Simpan urutan SERVER (dari PHP/DB) ke localStorage
        // ── supaya mydashboard bisa membuat mapping nama DB → nama tampilan
        const SERVER_KEY = 'jadwal_server_order_{{ $year }}_{{ $month }}';
        const serverNames = Array.from(tbody.rows)
            .sort((a, b) => +a.dataset.slot - +b.dataset.slot)
            .map(tr => tr.querySelector('.name-text').textContent.trim());
        localStorage.setItem(SERVER_KEY, JSON.stringify(serverNames));

        /**
         * Terapkan urutan nama ke slot.
         * @param {string[]} names  - Array nama sesuai urutan slot
         * @param {boolean}  markChanged - true setelah drag agar Save tahu ada perubahan
         */
        function applyNamesToSlots(names, markChanged = false) {
            const rows = Array.from(tbody.rows)
                .sort((a, b) => +a.dataset.slot - +b.dataset.slot);

            // Kembalikan urutan baris ke slot asli di DOM
            rows.forEach(tr => tbody.appendChild(tr));

            rows.forEach((tr, i) => {
                if (names[i] === undefined) return;

                const oldName = tr.querySelector('.name-text').textContent.trim();
                const newName = names[i];

                // Update teks nama
                tr.querySelector('.name-text').textContent = newName;

                // Jika nama berubah, update data-nama di semua select shift row ini
                // dan tandai sebagai has-changed agar "Simpan Jadwal" memproses ke DB
                if (markChanged && oldName !== newName) {
                    tr.querySelectorAll('select.shift-box').forEach(sel => {
                        sel.dataset.nama = newName;
                        sel.classList.add('has-changed');
                    });
                } else {
                    // Load awal: update data-nama saja, tidak tandai has-changed
                    tr.querySelectorAll('select.shift-box').forEach(sel => {
                        sel.dataset.nama = newName;
                    });
                }
            });
        }

        // Muat urutan tersimpan dari localStorage
        const saved = localStorage.getItem(SORT_KEY);
        if (saved) {
            try { applyNamesToSlots(JSON.parse(saved), false); } catch(e) {}
        }

        Sortable.create(tbody, {
            handle:      '.drag-handle',
            animation:   150,
            ghostClass:  'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass:   'sortable-drag',
            onEnd: function() {
                // Ambil urutan nama baru SEBELUM revert baris
                const newNames = Array.from(tbody.rows).map(
                    tr => tr.querySelector('.name-text').textContent.trim()
                );
                // Kembalikan baris ke slot, update nama & tandai has-changed
                applyNamesToSlots(newNames, true);
                // Simpan urutan ke localStorage
                localStorage.setItem(SORT_KEY, JSON.stringify(newNames));
            }
        });
    });

    function saveChanges() {
        const updates = [];
        $('select.shift-box.has-changed').each(function() {
            const $el = $(this);
            updates.push({ nama: $el.data('nama'), tanggal: $el.data('tanggal'), shift_kode: $el.val() });
        });
        if (updates.length === 0) {
            Swal.fire({ icon: 'info', title: 'Tidak ada perubahan', text: 'Silakan ubah jadwal terlebih dahulu.', timer: 2000, showConfirmButton: false });
            return;
        }
        Swal.fire({ title: 'Menyimpan...', text: 'Mohon tunggu', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: "{{ route('piket.batchUpdate') }}",
            method: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { updates: updates },
            success: function(response) {
                $('select.shift-box.has-changed').removeClass('has-changed');
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.message, timer: 2000, showConfirmButton: false });
            },
            error: function(error) {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: error.responseJSON ? error.responseJSON.message : "Terjadi kesalahan sistem." });
            }
        });
    }

    function downloadCapture() {
        const element = document.getElementById('capture-area');
        const toolbar = document.querySelector('.no-capture');
        if (toolbar) toolbar.style.visibility = 'hidden';
        window.scrollTo(0, 0);
        html2canvas(element, {
            scale: 4,
            useCORS: true,
            backgroundColor: "#ffffff",
            logging: false,
            width: element.scrollWidth,
            height: element.scrollHeight,
            windowWidth: element.scrollWidth,
            onclone: (clonedDoc) => {
                const clonedArea = clonedDoc.getElementById('capture-area');
                if (clonedArea) {
                    clonedArea.style.width    = element.scrollWidth + 'px';
                    clonedArea.style.maxWidth = 'none';
                    clonedArea.style.overflow = 'visible';
                }
                // Ganti <select> → <div> agar teks tepat di tengah pada hasil capture
                clonedDoc.querySelectorAll('select.shift-box').forEach(s => {
                    const val         = s.value;
                    const parent      = s.parentNode;
                    const replacement = clonedDoc.createElement('div');
                    replacement.innerText = val;
                    replacement.className = s.className;
                    Object.assign(replacement.style, {
                        display: 'inline-flex', alignItems: 'center', justifyContent: 'center',
                        width: '28px', height: '22px', borderRadius: '3px',
                        fontWeight: '800', fontSize: '9px',
                        color: val === 'M' ? '#333' : 'white',
                        margin: '0 auto', padding: '0', lineHeight: '1', textAlign: 'center'
                    });
                    parent.replaceChild(replacement, s);
                });
                // Fix sticky kolom nama
                clonedDoc.querySelectorAll('.name-cell, .name-cell-header').forEach(c => c.style.position = 'static');
            }
        }).then(canvas => {
            const link = document.createElement('a');
            link.download = `Jadwal_Piket_{{ $bulanSekarang }}_{{ $tahunSekarang }}.png`;
            link.href = canvas.toDataURL("image/png", 1.0);
            link.click();
            if (toolbar) toolbar.style.visibility = 'visible';
        }).catch(err => {
            console.error('Error:', err);
            if (toolbar) toolbar.style.visibility = 'visible';
        });
    }
    </script>
</body>
</html>
