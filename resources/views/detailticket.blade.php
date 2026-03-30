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
    <title>Detail Tiket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/detailtiket_premium.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Leaflet Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet MarkerCluster -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
    <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
    <style>
        .tabs-section {
            padding: 20px 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .summary-badge {
            font-size: 12px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .tabs-section .ms-auto {
                width: 100%;
                margin-left: 0 !important;
                justify-content: flex-start;
                margin-top: 10px;
            }
            .insight-grid {
                grid-template-columns: 1fr !important;
            }
            .card-header-actions {
                flex-direction: column;
                align-items: stretch !important;
                width: 100%;
            }
            .card-header-actions > div {
                margin-left: 0 !important;
                width: 100%;
                justify-content: space-between;
            }
        }
        /* Integrated Filter Styling inside Cards */
        .card-header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .filter-input-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 6px 14px;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            outline: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
            transition: all 0.2s;
        }
        /* KPI Insight Styling */
        .insight-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding-top: 10px;
        }
        .metric-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            transition: transform 0.2s;
        }
        .metric-box:hover {
            transform: translateY(-5px);
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }
        .metric-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-size: 1.25rem;
        }
        .metric-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 4px;
        }
        .metric-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.025em;
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
                        <button type="submit" style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #333; cursor: pointer; display: flex; align-items: center; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='transparent'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ url('/open-ticket') }}" class="tab {{ request()->is('open-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: {{ request()->is('open-ticket*') ? 'White' : 'Black' }};">Open Tiket</a>
        <a href="{{ url('/close-ticket') }}" class="tab {{ request()->is('close-ticket*') ? 'active' : '' }}" style="text-decoration: none; color: {{ request()->is('close-ticket*') ? 'White' : 'Black' }};">Close Tiket</a>
        <a href="{{ url('/detailticket') }}" class="tab {{ request()->is('detailticket*') ? 'active' : '' }}" style="text-decoration: none; color: {{ request()->is('detailticket*') ? 'White' : 'Black' }};">Detail Tiket</a>
        <a href="{{ url('/summaryticket') }}" class="tab {{ request()->is('summaryticket*') ? 'active' : '' }}" style="text-decoration: none; color: {{ request()->is('summaryticket*') ? 'White' : 'Black' }};">Summary Tiket</a>
    </div>
<main class="grid-container">
    {{-- CARD 1: LIST OPEN --}}
    <div class="premium-card">
        <h2 class="card-title">
            <i class="bi bi-activity"></i> 
            <span>Live Open Tickets Detail</span>
        </h2>
        <div class="ticket-list-scroll">
            @forelse($openTickets as $t)
                <div class="ticket-item">
                    <div class="ticket-status-dot">
                        <i class="bi bi-broadcast"></i>
                    </div>
                    <div class="ticket-info">
                        <div class="ticket-id">#TICK-{{ str_pad($t->id, 6, '0', STR_PAD_LEFT) }}</div>
                        <div class="ticket-site-name">{{ $t->nama_site }} <span style="opacity: 0.4; font-weight: 300;">({{ $t->site_code }})</span></div>
                        <div class="ticket-meta">
                            <span class="meta-pill"><i class="bi bi-tag-fill me-1"></i> {{ strtoupper($t->kategori) }}</span>
                            <span class="meta-pill"><i class="bi bi-exclamation-triangle-fill me-1"></i> {{ $t->kendala ?? 'No Detail' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align:center; color: var(--text-muted); padding: 40px;">
                    <i class="bi bi-check2-circle" style="font-size: 3rem; opacity: 0.2;"></i>
                    <p style="margin-top: 15px; font-weight: 600;">No active tickets found.</p>
                </div>
            @endforelse
        </div>
    </div>
    {{-- CARD 2: LINE CHART WITH INTEGRATED FILTER --}}
    <div class="premium-card">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
            <h2 class="card-title mb-0">
                <i class="bi bi-graph-up"></i>
                <span>Monthly Progress Trend</span>
            </h2>
            <div class="card-header-actions">
                <div class="d-flex align-items-center gap-2">
                    <label class="small fw-bold text-muted mb-0">Category:</label>
                    <select id="cardFilterKategori" class="filter-input-card" style="width: 140px;" onchange="applyCardFilter()">
                        <option value="">All Category</option>
                        <option value="BMN">BMN</option>
                        <option value="SL">SL</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2 ml-3">
                    <label class="small fw-bold text-muted mb-0">Month:</label>
                    <input type="month" id="cardFilterMonth" class="filter-input-card" onchange="applyCardFilter()">
                </div>
            </div>
        </div>
        <div class="chart-container-large">
            <canvas id="closeChart"></canvas>
        </div>
    </div>
    {{-- CARD 3 & 3B: CATEGORY & INSIGHTS --}}
    <div class="premium-card">
        <h2 class="card-title">
            <i class="bi bi-pie-chart-fill"></i>
            <span>Distribution by Category</span>
        </h2>
        <div class="chart-container-large">
            <canvas id="catChart"></canvas>
        </div>
    </div>
    <div class="premium-card">
        <h2 class="card-title">
            <i class="bi bi-lightning-charge-fill"></i>
            <span>System Performance & Analytics</span>
        </h2>
        <div class="insight-grid">
            <div class="metric-box">
                <div class="metric-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="metric-value" id="valResolvedRate">{{ $resolvedRate }}%</div>
                <div class="metric-label">Resolution Rate</div>
            </div>
            <div class="metric-box">
                <div class="metric-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div class="metric-value" id="valAvgResTime">{{ $avgResTime }}h</div>
                <div class="metric-label">Avg. Resolution</div>
            </div>
            <div class="metric-box">
                <div class="metric-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
                <div class="metric-value" id="valTopProblem" style="font-size: 1rem; line-height: 1.2; height: 1.2em; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $topProblem }}</div>
                <div class="metric-label">Top Incident</div>
            </div>
            <div class="metric-box">
                <div class="metric-icon" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                    <i class="bi bi-server"></i>
                </div>
                <div class="metric-value">{{ $totalSitesCount }}</div>
                <div class="metric-label">Monitored Sites</div>
            </div>
        </div>
        <div class="mt-4 p-3 rounded-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: white;">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small opacity-75">Monthly Load Intensity</span>
                <span class="badge bg-primary" id="valTotalFiltered">{{ $totalTickets }} Tickets</span>
            </div>
            <div class="progress" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px;">
                <div class="progress-bar bg-info" id="progTotalTickets" role="progressbar" style="width: {{ min(($totalTickets/100)*100, 100) }}%"></div>
            </div>
        </div>
    </div>
    {{-- CARD 4: BAR CHART --}}
    <div class="premium-card full-width">
        <h2 class="card-title">
            <i class="bi bi-geo-fill"></i>
            <span>Distribution by Region (Kabupaten)</span>
        </h2>
        <div style="height: 400px; position: relative;">
            <canvas id="kabChart"></canvas>
        </div>
    </div>
    {{-- CARD 4: DYNAMIC MAP --}}
    <div class="premium-card full-width" style="padding: 0; overflow: hidden;">
        <div id="sitesMap" style="height: 500px; width: 100%;"></div>
    </div>
</main>
<script>
    const trendLabels = @json($trendLabels);
    const openTotals = @json($openTotals);
    const closedTotals = @json($closedTotals);
    const kabLabels = @json($kabLabels);
    const kabTotals = @json($kabTotals);
    const catLabels = @json($catLabels);
    const catTotals = @json($catTotals);
    // Chart Defaults
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';
    let closeChart, kabChart, catChart;
    function initCharts() {
        // LINE CHART
        const ctxClose = document.getElementById('closeChart').getContext('2d');
        const gradientLine = ctxClose.createLinearGradient(0, 0, 0, 400);
        gradientLine.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradientLine.addColorStop(1, 'rgba(59, 130, 246, 0)');
        closeChart = new Chart(ctxClose, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: 'Open',
                        data: openTotals,
                        borderColor: '#3b82f6', // Blue for Open
                        borderWidth: 3,
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    },
                    {
                        label: 'Closed',
                        data: closedTotals,
                        borderColor: '#10b981', // Green for Closed
                        borderWidth: 3,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#10b981',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { 
                        display: true,
                        position: 'top',
                        labels: { usePointStyle: true, padding: 15 }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        borderRadius: 12,
                        titleFont: { size: 14, weight: 'bold' }
                    }
                },
                scales: {
                    y: { grid: { display: false }, beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });
        // BAR CHART
        const ctxKab = document.getElementById('kabChart').getContext('2d');
        kabChart = new Chart(ctxKab, {
            type: 'bar',
            data: {
                labels: kabLabels,
                datasets: [{
                    label: 'Total Tickets',
                    data: kabTotals,
                    backgroundColor: '#3b82f6',
                    borderRadius: 12,
                    barThickness: 30,
                    hoverBackgroundColor: '#0f172a',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                }
            }
        });
        // CATEGORY CHART (Doughnut)
        const ctxCat = document.getElementById('catChart').getContext('2d');
        catChart = new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catTotals,
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                    borderWidth: 0,
                    hoverOffset: 15
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20 }
                    }
                }
            }
        });
    }
    function applyCardFilter() {
        const monthValue = document.getElementById('cardFilterMonth').value;
        const kategoriValue = document.getElementById('cardFilterKategori').value;
        // Visual feedback
        document.querySelector('main').style.opacity = '0.5';
        fetch(`{{ url('/detailticket') }}?month=${monthValue}&kategori=${kategoriValue}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            updateDashboard(data);
            document.querySelector('main').style.opacity = '1';
        })
        .catch(err => {
            console.error(err);
            document.querySelector('main').style.opacity = '1';
        });
    }
    function updateDashboard(data) {
        // Update Ticket List
        const listContainer = document.querySelector('.ticket-list-scroll');
        if (data.openTickets.length > 0) {
            listContainer.innerHTML = data.openTickets.map(t => `
                <div class="ticket-item">
                    <div class="ticket-status-dot"><i class="bi bi-broadcast"></i></div>
                    <div class="ticket-info">
                        <div class="ticket-id">#TICK-${String(t.id).padStart(6, '0')}</div>
                        <div class="ticket-site-name">${t.nama_site} <span style="opacity: 0.4; font-weight: 300;">(${t.site_code})</span></div>
                        <div class="ticket-meta">
                            <span class="meta-pill"><i class="bi bi-tag-fill me-1"></i> ${t.kategori.toUpperCase()}</span>
                            <span class="meta-pill"><i class="bi bi-exclamation-triangle-fill me-1"></i> ${t.kendala || 'No Detail'}</span>
                        </div>
                    </div>
                </div>
            `).join('');
        } else {
            listContainer.innerHTML = `<div style="text-align:center; padding: 40px; color: #64748b;">No tickets found for this period.</div>`;
        }
        // Update Charts
        closeChart.data.labels = data.trendLabels;
        closeChart.data.datasets[0].data = data.openTotals;
        closeChart.data.datasets[1].data = data.closedTotals;
        closeChart.update();
        kabChart.data.labels = data.kabLabels;
        kabChart.data.datasets[0].data = data.kabTotals;
        kabChart.update();
        catChart.data.labels = data.catLabels;
        catChart.data.datasets[0].data = data.catTotals;
        catChart.update();
        // Update KPIs
        document.getElementById('valResolvedRate').innerText = data.resolvedRate + '%';
        document.getElementById('valAvgResTime').innerText = data.avgResTime + 'h';
        document.getElementById('valTopProblem').innerText = data.topProblem;
        document.getElementById('valTotalFiltered').innerText = data.totalTickets + ' Tickets';
        document.getElementById('progTotalTickets').style.width = Math.min((data.totalTickets/100)*100, 100) + '%';
    }
    const allSites = @json($allSites);
    // MAP INITIALIZATION
    function initMap() {
        // Center of Indonesia approx
        const map = L.map('sitesMap').setView([-2.5489, 118.0149], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        const markers = L.markerClusterGroup();
        allSites.forEach(site => {
            if (site.latitude && site.longitude) {
                const marker = L.marker([site.latitude, site.longitude])
                    .bindPopup(`
                        <div style="font-family: 'Inter', sans-serif;">
                            <strong style="color: #1e293b;">${site.sitename}</strong><br>
                            <span style="color: #64748b; font-size: 12px;">Code: ${site.site_code}</span><br>
                            <span style="color: #64748b; font-size: 12px;">ID: ${site.site_id}</span>
                        </div>
                    `);
                markers.addLayer(marker);
            }
        });
        map.addLayer(markers);
    }
    document.addEventListener('DOMContentLoaded', () => {
        initCharts();
        initMap();
    });
</script>
</body>
</html>

