<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Shift - {{ $bulanSekarang }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root { 
            --navy-primary: #1e293b;
            --emerald-pagi: #44A194;  /* P */
            --amber-siang: #3A9AFF;   /* S */
            --indigo-malam: #FFD150;  /* M */
            --rose-off: #A03A13;      /* OFF */
        }
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f0f2f5; 
            margin: 0;
            padding: 0;
            color: #333;
        }
        .main-header { 
            background-color: #1a202c; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        /* Container Utama */
        #capture-area { 
            background: #ffffff; 
            padding: 40px; 
            border-radius: 4px; /* Sudut tajam lebih profesional untuk dokumen */
            overflow-x: auto;
            max-width: 100%;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid var(--navy-primary);
            padding-bottom: 20px;
        }
        .main-title {
            font-weight: 800;
            font-size: 24px;
            color: var(--navy-primary);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        /* Styling Tabel */
        .table-piket { 
            border-collapse: separate; 
            border-spacing: 4px; 
            width: 100%;
        }
        .table-piket thead th {
            background-color: var(--navy-primary) !important;
            color: white !important;
            font-size: 11px;
            font-weight: 600;
            padding: 12px 2px;
            text-align: center;
            border: none !important;
        }
        .name-cell { 
            min-width: 200px; 
            background: #ffffff !important; 
            font-weight: 700; 
            font-size: 13px;
            color: #334155;
            border: 1px solid #e2e8f0 !important;
            padding: 10px 15px !important;
            position: sticky; 
            left: 0; 
            z-index: 10;
        }
        /* Update CSS untuk Kartu Shift */
.shift-select {
    width: 65px; 
    height: 38px; 
    border: none; 
    border-radius: 6px; 
    font-weight: 800; 
    font-size: 13px; 
    text-align: center; 
    color: white !important; 
    cursor: pointer;
    /* Hilangkan panah dropdown agar tidak mendorong teks */
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    /* KUNCI TENGAH PRESISI */
    display: inline-flex;    /* Gunakan flex agar align-items bekerja */
    align-items: center;     /* Tengah Vertikal */
    justify-content: center;   /* Tengah Horizontal */
    padding: 0 !important;   /* Hapus padding agar teks tidak naik/terdorong */
    line-height: normal;     /* Reset line-height */
    margin: 0 auto;
}
        .shift-select:hover {
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }
        .shift-select:focus {
            outline: none;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }
        .shift-select.has-changed {
            border: 2px solid #ef4444 !important;
            animation: pulse-border 2s infinite;
        }
        @keyframes pulse-border {
            0% { border-color: #ef4444; }
            50% { border-color: transparent; }
            100% { border-color: #ef4444; }
        }
        /* Tambahan agar kolom tabel menyesuaikan ukuran select yang baru */
        .table-piket td {
    padding: 8px 4px !important;
    vertical-align: middle; /* Pastikan sel tabel di tengah secara vertikal */
    text-align: center;
}
        .shift-select::-ms-expand {
            display: none;
        }
        /* Card style dengan shadow */
        .bg-m, .bg-s, .bg-p, .bg-off {
            box-shadow: 0 4px 8px rgba(0,0,0,0.15) !important;
        }
        .bg-p { background-color: var(--emerald-pagi) !important; }
        .bg-s { background-color: var(--amber-siang) !important; }
        .bg-m { background-color: var(--indigo-malam) !important; }
        .bg-off { background-color: var(--rose-off) !important; }
        /* Keterangan di bawah */
        .legend-area {
            margin-top: 25px;
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
        }
        .legend-item { display: flex; align-items: center; gap: 8px; }
        .dot { width: 12px; height: 12px; border-radius: 2px; }
        /* Toolbar (Sembunyi saat download) */
        .toolbar-card {
            background: white;
            padding: 15px 25px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        /* TABS */
        .tabs-section {
            padding: 20px 30px;
            display: flex;
            gap: 15px;
        }
        .tab {
            background: white;
            padding: 10px 22px;
            border-radius: 20px;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            text-decoration: none;
            color: #000;
            transition: 0.3s;
            font-size: 14px;
        }
        .tab.active {
            background-color: #1a202c !important;
            color: white !important;
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
        @endif
    </div>
<div class="container-fluid mt-4 px-4">
    <div class="toolbar-card no-capture">
        <div class="d-flex gap-3 align-items-center">
            <h5 class="m-0 fw-bold text-navy">Manajemen Shift</h5>
            <form action="{{ route('jadwalpiket') }}" method="GET" class="d-flex gap-2">
                <select name="month" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for ($m=1; $m<=12; $m++)
                        <option value="{{ sprintf('%02d', $m) }}" {{ $month == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="form-select form-select-sm" onchange="this.form.submit()">
                    @for ($y = date('Y')-1; $y <= date('Y')+1; $y++)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div class="d-flex gap-2">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <button class="btn btn-success btn-sm px-4 fw-bold" onclick="saveChanges()">
                    <i class="bi bi-save me-2"></i> Simpan Jadwal
                </button>
            @endif
            <button class="btn btn-primary btn-sm px-4 fw-bold" onclick="downloadCapture()">
                <i class="bi bi-camera me-2"></i> Capture
            </button>
        </div>
    </div>
    <div id="capture-area">
        <div class="report-header">
            <div class="main-title">Jadwal Piket</div>
            <div class="text-muted small mt-1">Bulan: {{ $bulanSekarang }} {{ $tahunSekarang }} |  NUSTECH Indonesia</div>
        </div>
        <div class="table-responsive" style="overflow: visible !important;">
            <table class="table table-borderless table-piket">
                <thead>
                    <tr>
                        <th class="name-cell text-center align-middle" style="background:#1e293b !important; color:white !important;">Nama</th>
                        @for ($i = 1; $i <= $jumlahHari; $i++)
                            <th class="align-middle">{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarNama as $nama)
                    <tr>
                        <td class="name-cell align-middle">{{ $nama }}</td>
                        @for ($d = 1; $d <= $jumlahHari; $d++)
                            @php
                                $tgl = \Carbon\Carbon::createFromDate($year, $month, $d)->format('Y-m-d');
                                $userRow = \App\Models\User::where('name', 'like', '%' . trim($nama) . '%')->first();
                                $existing = $userRow ? $dataPiket->where('user_id', $userRow->id)->where('tanggal', $tgl)->first() : null;
                                $kodeAktif = $existing && $existing->shift ? $existing->shift->kode : 'OFF';
                                $class = match(strtoupper($kodeAktif)) {
                                    'M' => 'bg-m', 'S' => 'bg-s', 'P' => 'bg-p', default => 'bg-off',
                                };
                            @endphp
                            <td class="text-center align-middle">
                                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <select class="shift-select {{ $class }}" 
                                            data-nama="{{ trim($nama) }}" 
                                            data-tanggal="{{ $tgl }}"
                                            onchange="updateData(this)">
                                        <option value="OFF" {{ $kodeAktif == 'OFF' ? 'selected' : '' }}>OFF</option>
                                        <option value="P" {{ $kodeAktif == 'P' ? 'selected' : '' }}>P</option>
                                        <option value="S" {{ $kodeAktif == 'S' ? 'selected' : '' }}>S</option>
                                        <option value="M" {{ $kodeAktif == 'M' ? 'selected' : '' }}>M</option>
                                    </select>
                                @else
                                    <div class="shift-select {{ $class }}" 
                                         style="display: flex; align-items: center; justify-content: center; cursor: default;">
                                        {{ $kodeAktif }}
                                    </div>
                                @endif
                            </td>
                        @endfor
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
<!-- Toast Box for Auto-save Feedback -->
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
        if(kode == 'P') $el.addClass('bg-p');
        else if(kode == 'S') $el.addClass('bg-s');
        else if(kode == 'M') $el.addClass('bg-m');
        else $el.addClass('bg-off');
        // Tambahkan indikator visual bahwa ada perubahan belum tersimpan
        $el.addClass('has-changed');
    }
    function saveChanges() {
        const updates = [];
        $('.shift-select.has-changed').each(function() {
            const $el = $(this);
            updates.push({
                nama: $el.data('nama'),
                tanggal: $el.data('tanggal'),
                shift_kode: $el.val()
            });
        });
        if (updates.length === 0) {
            Swal.fire({
                icon: 'info',
                title: 'Tidak ada perubahan',
                text: 'Silakan ubah jadwal terlebih dahulu sebelum menyimpan.',
                timer: 2000,
                showConfirmButton: false
            });
            return;
        }
        // Tampilkan loading
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });
        $.ajax({
            url: "{{ route('piket.batchUpdate') }}",
            method: "POST",
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: { updates: updates },
            success: function(response) {
                $('.shift-select.has-changed').removeClass('has-changed');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.message,
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.responseJSON ? error.responseJSON.message : "Terjadi kesalahan sistem."
                });
            }
        });
    }
    function downloadCapture() {
    const element = document.getElementById('capture-area');
    const toolbar = document.querySelector('.no-capture');
    if(toolbar) toolbar.style.visibility = 'hidden';
    window.scrollTo(0,0);
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
            // 1. PAKSA LEBAR agar tidak terpotong
            if(clonedArea) {
                clonedArea.style.width = element.scrollWidth + 'px';
                clonedArea.style.maxWidth = 'none';
                clonedArea.style.overflow = 'visible';
            }
            // 2. TRIK FIX POSISI TEKS: Ubah Select menjadi Div di hasil clone
            const selects = clonedDoc.querySelectorAll('.shift-select');
            selects.forEach(s => {
                const val = s.value; // Ambil nilai M, S, P, atau OFF
                const parent = s.parentNode;
                // Buat elemen pengganti berupa DIV
                const replacement = clonedDoc.createElement('div');
                replacement.innerText = val;
                // Salin semua class (untuk warna background) dan style dasar
                replacement.className = s.className; 
                // Styling paksa agar div benar-benar presisi di tengah
                Object.assign(replacement.style, {
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    width: '65px',   // Sesuaikan dengan CSS select Anda
                    height: '38px',  // Sesuaikan dengan CSS select Anda
                    borderRadius: '6px',
                    fontWeight: '800',
                    fontSize: '13px',
                    color: 'white',
                    margin: '0 auto',
                    padding: '0',
                    lineHeight: '1', // Line height 1 sangat membantu presisi vertikal
                    textAlign: 'center'
                });
                // Ganti select dengan div baru ini (hanya di dokumen clone/download)
                parent.replaceChild(replacement, s);
            });
            // 3. FIX STICKY: Kolom nama diubah ke static agar tidak berantakan
            const stickyCells = clonedDoc.querySelectorAll('.name-cell');
            stickyCells.forEach(cell => {
                cell.style.position = 'static';
            });
        }
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Jadwal_Piket_{{ $bulanSekarang }}_{{ $tahunSekarang }}.png`;
        link.href = canvas.toDataURL("image/png", 1.0);
        link.click();
        if(toolbar) toolbar.style.visibility = 'visible';
    }).catch(err => {
        console.error('Error:', err);
        if(toolbar) toolbar.style.visibility = 'visible';
    });
}
</script>
</body>
</html>

