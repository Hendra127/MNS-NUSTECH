<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Management PM</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .tabs-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        @media (max-width: 768px) {
            .grid-cols-2 {
                grid-template-columns: 1fr;
            }
            .flex.gap-4 {
                flex-wrap: wrap;
            }
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
    <div class="tabs-section" style="padding: 20px 30px 0 30px;">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*', 'sites*') ? 'active' : '' }}" style="text-decoration: none;">All Sites</a>
        <a href="{{ route('datapas') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none;">Management Password</a>
        <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}" style="text-decoration: none;">Correctiv Maintenance</a>
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none;">PM Summary</a>
    </div>
    <div style="padding: 20px 30px 30px 30px;">
        <style>
            /* Reset body to match datapas which probably has a gray background from external CSS */
            @media (max-width: 768px) {
                .tabs-section, div[style*="padding: 20px"] { padding-left: 20px !important; padding-right: 20px !important; }
            }
            .glass-panel { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
            .stat-card-gradient { background: linear-gradient(135deg, #071152 0%, #1a365d 100%); }
            .stat-card-gradient-2 { background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%); }
            .stat-card-gradient-3 { background: linear-gradient(135deg, #10b981 0%, #047857 100%); }
            /* Custom Scrollbar */
            .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        </style>
        <!-- Summary Cards Grid (with top margin/padding for breathing room) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-4">
            <!-- Total Done Card -->
            <div class="stat-card-gradient rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p class="text-blue-100 font-medium text-sm tracking-wide uppercase mb-1">Total Pencapaian (DONE)</p>
                        <h3 class="text-4xl font-bold">{{ $totalCount ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>
            <!-- BMN Card -->
            <div class="stat-card-gradient-2 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p class="text-sky-100 font-medium text-sm tracking-wide uppercase mb-1">Target BMN Selesai</p>
                        <h3 class="text-4xl font-bold">{{ $bmnCount ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-hdd-network text-2xl"></i>
                    </div>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5 mt-8 mb-2 relative z-10">
                    <div class="bg-white h-1.5 rounded-full" style="width: {{ min(round(($bmnCount / 240) * 100), 100) }}%"></div>
                </div>
                <div class="text-xs text-sky-100 font-medium text-right relative z-10">{{ $bmnCount }}/240 &mdash; {{ min(round(($bmnCount / 240) * 100), 100) }}% dari Target</div>
            </div>
            <!-- SL Card -->
            <div class="stat-card-gradient-3 rounded-3xl p-6 text-white shadow-xl relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-500"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p class="text-emerald-100 font-medium text-sm tracking-wide uppercase mb-1">Target SL Selesai</p>
                        <h3 class="text-4xl font-bold">{{ $slCount ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                        <i class="bi bi-router text-2xl"></i>
                    </div>
                </div>
                <div class="w-full bg-white/20 rounded-full h-1.5 mt-8 mb-2 relative z-10">
                    <div class="bg-white h-1.5 rounded-full" style="width: {{ min(round(($slCount / 121) * 100), 100) }}%"></div>
                </div>
                <div class="text-xs text-emerald-100 font-medium text-right relative z-10">{{ $slCount }}/121 &mdash; {{ min(round(($slCount / 121) * 100), 100) }}% dari Target</div>
            </div>
        </div>
        <!-- Main Chart & Table Section -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-8">
            <!-- Large Chart Section -->
            <div class="xl:col-span-2 glass-panel p-6 rounded-3xl">
                <div class="flex justify-between items-center mb-4 flex-wrap gap-3">
                    <h3 class="text-lg font-bold text-[#071152]">Trend Penyelesaian PM Harian</h3>
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Toggle Mode -->
                        <div class="flex rounded-lg overflow-hidden border border-slate-200 text-xs font-semibold">
                            <button id="btn-mode-bulan" onclick="setFilterMode('bulan')" class="px-3 py-1.5 bg-[#071152] text-white">Per Bulan</button>
                            <button id="btn-mode-range" onclick="setFilterMode('range')" class="px-3 py-1.5 bg-white text-slate-600 hover:bg-slate-50">Rentang Tanggal</button>
                        </div>
                        <!-- Filter: Per Bulan -->
                        <div id="filter-bulan" class="flex items-center gap-2">
                            <select id="sel-bulan" class="text-xs border border-slate-200 rounded-lg px-2 py-1.5 text-slate-600">
                                <option value="1"  {{ now()->month == 1  ? 'selected' : '' }}>Januari</option>
                                <option value="2"  {{ now()->month == 2  ? 'selected' : '' }}>Februari</option>
                                <option value="3"  {{ now()->month == 3  ? 'selected' : '' }}>Maret</option>
                                <option value="4"  {{ now()->month == 4  ? 'selected' : '' }}>April</option>
                                <option value="5"  {{ now()->month == 5  ? 'selected' : '' }}>Mei</option>
                                <option value="6"  {{ now()->month == 6  ? 'selected' : '' }}>Juni</option>
                                <option value="7"  {{ now()->month == 7  ? 'selected' : '' }}>Juli</option>
                                <option value="8"  {{ now()->month == 8  ? 'selected' : '' }}>Agustus</option>
                                <option value="9"  {{ now()->month == 9  ? 'selected' : '' }}>September</option>
                                <option value="10" {{ now()->month == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ now()->month == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ now()->month == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                            <select id="sel-tahun" class="text-xs border border-slate-200 rounded-lg px-2 py-1.5 text-slate-600">
                                @for($y = now()->year; $y >= now()->year - 3; $y--)
                                    <option value="{{ $y }}" {{ now()->year == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            <button onclick="applyChartFilter()" class="text-xs bg-[#071152] text-white px-3 py-1.5 rounded-lg hover:bg-blue-900">Tampilkan</button>
                        </div>
                        <!-- Filter: Rentang Tanggal -->
                        <div id="filter-range" class="hidden flex items-center gap-2">
                            <input type="date" id="range-start" class="text-xs border border-slate-200 rounded-lg px-2 py-1.5 text-slate-600">
                            <span class="text-slate-400 text-xs">s/d</span>
                            <input type="date" id="range-end" class="text-xs border border-slate-200 rounded-lg px-2 py-1.5 text-slate-600">
                            <button onclick="applyChartFilter()" class="text-xs bg-[#071152] text-white px-3 py-1.5 rounded-lg hover:bg-blue-900">Tampilkan</button>
                        </div>
                    </div>
                </div>
                <div class="relative w-full h-[350px]">
                    <canvas id="monthlyTrendChart"></canvas>
                </div>
            </div>
            <!-- Monthly Summary Table -->
            <div class="glass-panel p-6 rounded-3xl flex flex-col">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-[#071152]">Rekapitulasi Bulanan</h3>
                    <div class="relative group cursor-pointer">
                        <i class="bi bi-info-circle text-slate-400"></i>
                        <div class="absolute right-0 w-48 p-2 bg-slate-800 text-white text-xs rounded-lg mt-2 hidden group-hover:block z-50 shadow-lg top-full">Total komulatif per bulan yang statusnya sudah DONE.</div>
                    </div>
                </div>
                <div class="overflow-y-auto flex-1 custom-scrollbar pr-2 h-[350px]">
                    <div class="space-y-3">
                        @php
                            $monthsOrder = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        @endphp
                        @foreach($monthsOrder as $month)
                            @php
                                $summary = collect($monthlySummary ?? [])->first(function($item) use ($month) {
                                    $mDB = strtolower(trim($item->month));
                                    $m = strtolower($month);
                                    return $mDB == $m || 
                                           ($m == 'januari' && $mDB == 'january') || 
                                           ($m == 'februari' && $mDB == 'february') ||
                                           ($m == 'agustus' && $mDB == 'august') ||
                                           ($m == 'oktober' && $mDB == 'october') ||
                                           ($m == 'desember' && $mDB == 'december');
                                });
                                $b = $summary ? $summary->bmn_total : 0;
                                $s = $summary ? $summary->sl_total : 0;
                                $t = $b + $s;
                            @endphp
                            @if($t > 0 || $month == now()->locale('id')->monthName)
                            <div class="bg-white border border-slate-100 p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow relative overflow-hidden {{ $month == now()->locale('id')->monthName ? 'ring-2 ring-blue-100 bg-blue-50/20' : '' }}">
                                @if($month == now()->locale('id')->monthName)
                                    <div class="absolute right-0 top-0 bg-[#071152] text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg">BULAN INI</div>
                                @endif
                                <div class="flex justify-between items-center mb-2">
                                    <div class="font-bold text-slate-700 capitalize text-sm">{{ $month }}</div>
                                    <div class="font-black text-[#071152] text-lg">{{ $t }}</div>
                                </div>
                                <div class="flex gap-2">
                                    <div class="flex-1 bg-gradient-to-r from-sky-50 to-blue-50 rounded-lg py-1.5 px-2 text-center border border-sky-100/50">
                                        <div class="text-[10px] text-sky-600 font-bold uppercase mb-0.5">BMN</div>
                                        <div class="text-sm font-semibold text-slate-700">{{ $b }}</div>
                                    </div>
                                    <div class="flex-1 bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg py-1.5 px-2 text-center border border-emerald-100/50">
                                        <div class="text-[10px] text-emerald-600 font-bold uppercase mb-0.5">SL</div>
                                        <div class="text-sm font-semibold text-slate-700">{{ $s }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Latest Sites List (Card Grid) -->
        <div class="glass-panel p-6 rounded-3xl">
            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 shadow-inner">
                        <i class="bi bi-grid-1x2"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-[#071152]">Data Site PM Terakhir</h3>
                        <p class="text-xs text-slate-400 mt-0.5" id="sites-filter-label">20 pencapaian terbaru</p>
                    </div>
                </div>
                <a href="{{ url('/PMLiberta') }}" class="flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-all">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div id="sites-grid-container">
            @forelse($sites ?? [] as $index => $site)
                @php $kat = strtoupper($site->kategori ?? ''); @endphp
                @php $isBMN = str_contains($kat, 'BMN') || str_contains($kat, 'BARANG'); @endphp
                @php $status = strtoupper($site->status ?? ''); @endphp
                @if($index % 2 == 0)
                    @if($index > 0) </div> @endif
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                @endif
                <div class="group relative bg-white border border-slate-100 rounded-2xl p-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    {{-- Accent stripe --}}
                    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl {{ $isBMN ? 'bg-sky-400' : 'bg-emerald-400' }}"></div>
                    <div class="flex items-start justify-between pl-3">
                        {{-- Left: number + info --}}
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            {{-- Index badge --}}
                            <div class="w-8 h-8 rounded-xl {{ $isBMN ? 'bg-sky-50 text-sky-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center font-bold text-xs flex-shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="min-w-0 flex-1">
                                {{-- Site ID --}}
                                <span class="inline-block font-mono text-[10px] font-semibold {{ $isBMN ? 'text-sky-700 bg-sky-50' : 'text-emerald-700 bg-emerald-50' }} px-2 py-0.5 rounded mb-1">
                                    {{ $site->site_id }}
                                </span>
                                {{-- Nama Lokasi --}}
                                <p class="font-bold text-slate-800 text-sm leading-tight truncate group-hover:text-[#071152] transition-colors" title="{{ $site->nama_lokasi }}">
                                    {{ $site->nama_lokasi }}
                                </p>
                                {{-- Lokasi --}}
                                <div class="flex items-center gap-1 mt-1 text-slate-400 text-xs">
                                    <i class="bi bi-geo-alt-fill text-[10px]"></i>
                                    <span class="truncate" title="{{ strtoupper($site->kabupaten) }}">{{ strtoupper($site->kabupaten) }}</span>
                                </div>
                            </div>
                        </div>
                        {{-- Right: badges --}}
                        <div class="flex flex-col items-end gap-1.5 flex-shrink-0 ml-2">
                            {{-- Status badge --}}
                            @if($status == 'DONE')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">
                                    <i class="bi bi-check-circle-fill"></i> DONE
                                </span>
                            @elseif($status == 'PENDING')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    <i class="bi bi-clock-fill"></i> PENDING
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    {{ $status ?: 'N/A' }}
                                </span>
                            @endif
                            {{-- Kategori badge --}}
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $isBMN ? 'bg-sky-100 text-sky-700' : 'bg-emerald-100 text-emerald-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $isBMN ? 'bg-sky-500' : 'bg-emerald-500' }}"></span>
                                {{ $isBMN ? 'BMN' : 'SL' }}
                            </span>
                            {{-- Bulan --}}
                            <span class="text-[10px] text-slate-400 font-medium">{{ $site->month }}</span>
                        </div>
                    </div>
                </div>
                @if($index == ($sites->count() - 1))
                    </div>
                @endif
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                    <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                        <i class="bi bi-inbox text-3xl text-slate-300"></i>
                    </div>
                    <p class="font-semibold text-slate-500">Belum ada data</p>
                    <p class="text-xs mt-1">Belum ada penyelesaian Preventive Maintenance.</p>
                </div>
            @endforelse
            </div><!-- #sites-grid-container -->
        </div>
    </div> <!-- Close main content area padding div -->
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== CHART SETUP =====
        const ctx = document.getElementById('monthlyTrendChart').getContext('2d');
        let gradientLine = ctx.createLinearGradient(0, 0, 0, 400);
        gradientLine.addColorStop(0, 'rgba(7, 17, 82, 0.5)');
        gradientLine.addColorStop(1, 'rgba(7, 17, 82, 0.01)');
        const rawData = @json($chartData ?? []);
        function buildChartData(data) {
            if (data && data.length > 0) {
                return {
                    labels: data.map(item => {
                        let p = item.date.split('-');
                        return p[2] + ' ' + new Date(item.date).toLocaleString('id', { month: 'short' });
                    }),
                    values: data.map(item => item.total)
                };
            }
            return { labels: [], values: [] };
        }
        const initial = buildChartData(rawData);
        const trendChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: initial.labels,
                datasets: [{
                    label: 'Sites Selesai (DONE)',
                    data: initial.values,
                    borderColor: '#071152',
                    backgroundColor: gradientLine,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#071152',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointHoverBackgroundColor: '#173292',
                    pointHoverBorderColor: '#ffffff',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 900, easing: 'easeOutQuart' },
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(15,23,42,0.9)',
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 12, cornerRadius: 12, displayColors: false, yAlign: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(226,232,240,0.6)', borderDash: [5,5] },
                        ticks: { font: { size: 11 }, color: '#64748b', stepSize: 1 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11 }, color: '#64748b', maxRotation: 45, minRotation: 0 }
                    }
                }
            }
        });
        // ===== FILTER LOGIC =====
        let currentMode = 'bulan';
        function setFilterMode(mode) {
            currentMode = mode;
            const isBulan = (mode === 'bulan');
            document.getElementById('filter-bulan').classList.toggle('hidden', !isBulan);
            document.getElementById('filter-range').classList.toggle('hidden', isBulan);
            document.getElementById('btn-mode-bulan').className = 'px-3 py-1.5 ' + (isBulan  ? 'bg-[#071152] text-white' : 'bg-white text-slate-600 hover:bg-slate-50');
            document.getElementById('btn-mode-range').className = 'px-3 py-1.5 ' + (!isBulan ? 'bg-[#071152] text-white' : 'bg-white text-slate-600 hover:bg-slate-50');
        }
        // ===== RENDER SITES CARDS FROM JSON =====
        function renderSites(sites) {
            const container = document.getElementById('sites-grid-container');
            if (!sites || sites.length === 0) {
                container.innerHTML = `
                    <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mb-4">
                            <i class="bi bi-inbox text-3xl text-slate-300"></i>
                        </div>
                        <p class="font-semibold text-slate-500">Tidak ada data pada periode ini</p>
                        <p class="text-xs mt-1">Coba pilih periode lain.</p>
                    </div>`;
                return;
            }
            let html = '';
            sites.forEach((site, index) => {
                const kat    = (site.kategori || '').toUpperCase();
                const isBMN  = kat.includes('BMN') || kat.includes('BARANG');
                const status = (site.status || '').toUpperCase();
                const colorLeft   = isBMN ? 'bg-sky-400'     : 'bg-emerald-400';
                const colorBadge  = isBMN ? 'bg-sky-50 text-sky-600' : 'bg-emerald-50 text-emerald-600';
                const colorId     = isBMN ? 'text-sky-700 bg-sky-50'  : 'text-emerald-700 bg-emerald-50';
                const colorDot    = isBMN ? 'bg-sky-500'     : 'bg-emerald-500';
                const colorKat    = isBMN ? 'bg-sky-100 text-sky-700' : 'bg-emerald-100 text-emerald-700';
                const katLabel    = isBMN ? 'BMN' : 'SL';
                let statusBadge = '';
                if (status === 'DONE') {
                    statusBadge = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200"><i class="bi bi-check-circle-fill"></i> DONE</span>`;
                } else if (status === 'PENDING') {
                    statusBadge = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200"><i class="bi bi-clock-fill"></i> PENDING</span>`;
                } else {
                    statusBadge = `<span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">${status || 'N/A'}</span>`;
                }
                // Open row wrapper every 2 items
                if (index % 2 === 0) {
                    if (index > 0) html += '</div>';
                    html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">';
                }
                html += `
                <div class="group relative bg-white border border-slate-100 rounded-2xl p-4 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                    <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl ${colorLeft}"></div>
                    <div class="flex items-start justify-between pl-3">
                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div class="w-8 h-8 rounded-xl ${colorBadge} flex items-center justify-center font-bold text-xs flex-shrink-0">
                                ${index + 1}
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="inline-block font-mono text-[10px] font-semibold ${colorId} px-2 py-0.5 rounded mb-1">
                                    ${site.site_id || '-'}
                                </span>
                                <p class="font-bold text-slate-800 text-sm leading-tight truncate group-hover:text-[#071152] transition-colors" title="${site.nama_lokasi || ''}">
                                    ${site.nama_lokasi || '-'}
                                </p>
                                <div class="flex items-center gap-1 mt-1 text-slate-400 text-xs">
                                    <i class="bi bi-geo-alt-fill text-[10px]"></i>
                                    <span class="truncate">${(site.kabupaten || '').toUpperCase()}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end gap-1.5 flex-shrink-0 ml-2">
                            ${statusBadge}
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-semibold ${colorKat}">
                                <span class="w-1.5 h-1.5 rounded-full ${colorDot}"></span>
                                ${katLabel}
                            </span>
                            <span class="text-[10px] text-slate-400 font-medium">${site.month || ''}</span>
                        </div>
                    </div>
                </div>`;
                // Close last row
                if (index === sites.length - 1) html += '</div>';
            });
            container.innerHTML = html;
        }
        // ===== SET FILTER PERIOD LABEL =====
        function setFilterLabel(text) {
            const el = document.getElementById('sites-filter-label');
            if (el) el.textContent = text;
        }
        // ===== COMBINED FILTER: CHART + SITES =====
        function applyChartFilter() {
            const chartBase = '{{ route("summarypm.chartdata") }}';
            const sitesBase = '{{ route("summarypm.sites") }}';
            let params = new URLSearchParams();
            let label  = '';
            if (currentMode === 'bulan') {
                const bulan = document.getElementById('sel-bulan').value;
                const tahun = document.getElementById('sel-tahun').value;
                params.append('bulan', bulan);
                params.append('tahun', tahun);
                const monthNames = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                label = monthNames[parseInt(bulan)] + ' ' + tahun;
            } else {
                const s = document.getElementById('range-start').value;
                const e = document.getElementById('range-end').value;
                if (!s || !e) { alert('Pilih rentang tanggal terlebih dahulu.'); return; }
                params.append('start_date', s);
                params.append('end_date', e);
                label = s + ' s/d ' + e;
            }
            // Show loading state on sites section
            const container = document.getElementById('sites-grid-container');
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                    <div class="animate-spin w-8 h-8 border-4 border-slate-200 border-t-[#071152] rounded-full mb-4"></div>
                    <p class="text-sm">Memuat data...</p>
                </div>`;
            // Update label
            setFilterLabel('Periode: ' + label);
            const qs = params.toString();
            // Fetch chart data & sites in parallel
            Promise.all([
                fetch(chartBase + '?' + qs).then(r => r.json()),
                fetch(sitesBase + '?' + qs).then(r => r.json())
            ])
            .then(([chartData, sitesData]) => {
                // Update chart
                const parsed = buildChartData(chartData);
                trendChart.data.labels = parsed.labels;
                trendChart.data.datasets[0].data = parsed.values;
                trendChart.update();
                // Update sites cards
                renderSites(sitesData);
            })
            .catch(err => {
                console.error('Filter error:', err);
                container.innerHTML = `<div class="py-10 text-center text-red-400 text-sm">Gagal memuat data. Silakan coba lagi.</div>`;
            });
        }
    </script>
</body>
</html>

