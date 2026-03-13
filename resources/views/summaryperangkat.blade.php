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
    <title>Dashboard Operasional</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}">
    <!-- Required for Dashboard Components -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.03);
        }
        .stat-card-gradient { background: linear-gradient(135deg, #071152 0%, #1e293b 100%); }
        .stat-card-gradient-2 { background: linear-gradient(135deg, #0ea5e9 0%, #2563eb 100%); }
        .stat-card-gradient-3 { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stat-card-gradient-4 { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table-custom thead th {
            background: transparent;
            color: #94a3b8;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 10px;
            letter-spacing: 1px;
            padding: 12px 20px;
            border: none;
        }
        .table-custom tbody tr {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.02);
            border-radius: 16px;
        }
        .table-custom td {
            padding: 16px 20px;
            border: none;
            font-size: 13px;
            font-weight: 600;
        }
        .table-custom td:first-child { border-radius: 16px 0 0 16px; color: #071152; font-weight: 800; }
        .table-custom td:last-child { border-radius: 0 16px 16px 0; }
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
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pm-summary') }}" class="tab active" style="text-decoration: none; color: White;">Summary</a>
    </div>
    <div class="container pb-5">
        <!-- Summary Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-4">
            <!-- Total Devices -->
            <div class="stat-card-gradient rounded-3xl p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div>
                        <p class="text-blue-100 font-medium text-[10px] tracking-wider uppercase mb-1">TOTAL PERANGKAT</p>
                        <h3 class="text-3xl font-black">{{ $grandTotal }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-cpu text-xl"></i>
                    </div>
                </div>
            </div>
            <!-- Total Baik -->
            <div class="stat-card-gradient-3 rounded-3xl p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div>
                        <p class="text-emerald-100 font-medium text-[10px] tracking-wider uppercase mb-1">KONDISI BAIK</p>
                        <h3 class="text-3xl font-black">{{ $totalBaik }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
            <!-- Total Rusak -->
            <div class="stat-card-gradient-4 rounded-3xl p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div>
                        <p class="text-orange-100 font-medium text-[10px] tracking-wider uppercase mb-1">KONDISI RUSAK</p>
                        <h3 class="text-3xl font-black">{{ $totalRusak }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-exclamation-triangle text-xl"></i>
                    </div>
                </div>
            </div>
            <!-- Total Baru -->
            <div class="stat-card-gradient-2 rounded-3xl p-5 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-2 relative z-10">
                    <div>
                        <p class="text-sky-100 font-medium text-[10px] tracking-wider uppercase mb-1">STOK BARU</p>
                        <h3 class="text-3xl font-black">{{ $totalBaru }}</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-box-seam text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Charts & Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Donut Chart Section -->
            <div class="lg:col-span-1 glass-panel p-6 rounded-3xl flex flex-col items-center">
                <div class="w-full mb-6 text-center">
                    <h3 class="text-lg font-bold text-[#071152]">Kondisi Hardware</h3>
                    <p class="text-xs text-slate-400 font-medium">Data Kumulatif Seluruh Perangkat</p>
                </div>
                <div class="relative w-full aspect-square max-w-[220px] mb-6">
                    <canvas id="conditionDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-[#071152]">{{ $grandTotal }}</span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total</span>
                    </div>
                </div>
                <div class="w-full space-y-3">
                    <div class="flex justify-between items-center bg-green-50 p-3 rounded-2xl border border-green-100">
                        <span class="text-xs font-bold text-green-700">BAIK / BARU</span>
                        <span class="font-black text-slate-700">{{ $totalBaik + $totalBaru }}</span>
                    </div>
                    <div class="flex justify-between items-center bg-red-50 p-3 rounded-2xl border border-red-100">
                        <span class="text-xs font-bold text-red-700">RUSAK</span>
                        <span class="font-black text-slate-700">{{ $totalRusak }}</span>
                    </div>
                </div>
            </div>
            <!-- Tables Section -->
            <div class="lg:col-span-2 glass-panel p-6 rounded-3xl">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-[#071152]">Stock Perangkat</h3>
                        <p class="text-xs text-slate-400 font-medium">Berdasarkan Jenis & Kondisi</p>
                    </div>
                    <div class="bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider">LIVE STOCK</div>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>JENIS PERANGKAT</th>
                                <th class="text-center">BAIK</th>
                                <th class="text-center">RUSAK</th>
                                <th class="text-center">BARU</th>
                                <th class="text-center">GRAND TOTAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats as $row)
                            <tr>
                                <td>{{ $row->jenis }}</td>
                                <td class="text-center font-bold text-green-600">{{ $row->baik }}</td>
                                <td class="text-center font-bold text-red-500">{{ $row->rusak }}</td>
                                <td class="text-center font-bold text-indigo-500">{{ $row->baru }}</td>
                                <td class="text-center text-[#071152] font-black">{{ $row->baik + $row->rusak + $row->baru }}</td>
                            </tr>
                            @endforeach
                            <tr style="background: var(--primary-dark) !important; color: white !important;">
                                <td style="color: white !important;">GRAND TOTAL</td>
                                <td class="text-center font-black">{{ $totalBaik }}</td>
                                <td class="text-center font-black">{{ $totalRusak }}</td>
                                <td class="text-center font-black">{{ $totalBaru }}</td>
                                <td class="text-center font-black">{{ $grandTotal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Pergantian Perangkat Summary Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Replacement Stats (How many times replaced) -->
            <div class="lg:col-span-1 glass-panel p-6 rounded-3xl">
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-[#071152]">Ringkasan Pergantian</h3>
                    <p class="text-xs text-slate-400 font-medium">Frekuensi Pergantian Perangkat</p>
                </div>
                <div class="space-y-4">
                    @forelse($replacementStats as $replace)
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-700">{{ $replace->perangkat }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xl font-black text-[#071152]">{{ $replace->total }}</span>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase">KALI</span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-slate-400 text-sm">Belum ada data pergantian</div>
                    @endforelse
                </div>
            </div>
            <!-- Replacement Locations & Dates -->
            <div class="lg:col-span-2 glass-panel p-6 rounded-3xl">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-[#071152]">Histori Lokasi & Tanggal</h3>
                        <p class="text-xs text-slate-400 font-medium">10 Titik Pergantian Terakhir</p>
                    </div>
                    <a href="{{ route('pergantianperangkat') }}" class="text-indigo-600 font-bold text-[10px] uppercase tracking-wider hover:underline">Lihat Semua</a>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>PERANGKAT</th>
                                <th>LOKASI SITE</th>
                                <th class="text-center">TANGGAL</th>
                                <th class="text-center">DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($replacementLogs as $log)
                            <tr>
                                <td>
                                    <span class="text-indigo-600 font-bold">{{ $log->perangkat }}</span>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <span class="text-[#071152] font-black">{{ $log->site->sitename ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-400">{{ $log->site->site_id ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-[10px] font-bold">
                                        {{ \Carbon\Carbon::parse($log->tanggal_penggantian)->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <i class="bi bi-info-circle text-slate-400 cursor-help" title="{{ $log->keterangan ?? 'Tanpa keterangan' }}"></i>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-8 text-slate-400 text-sm">Tidak ada histori pergantian</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Init Donut Chart for Hardware Condition
        const donutCtx = document.getElementById('conditionDonutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Baik', 'Rusak', 'Baru'],
                datasets: [{
                    data: [{{ $totalBaik }}, {{ $totalRusak }}, {{ $totalBaru }}],
                    backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
                    hoverBackgroundColor: ['#059669', '#dc2626', '#d97706'],
                    borderWidth: 0,
                    borderRadius: 10,
                    spacing: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) label += ': ';
                                label += context.raw;
                                return label + ' Unit';
                            }
                        }
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

