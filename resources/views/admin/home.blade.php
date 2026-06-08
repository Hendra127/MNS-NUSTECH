<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – Kelola Landing Page | CV. NUSTECH</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
                :root {
            --bg: #F3F4F6;
            --panel: #FFFFFF;
            --border: #E5E7EB;
            --text-muted: #6B7280;
            --text-soft: #4B5563;
            --active: #EFF6FF;
            --active-text: #000000;
        }
        .dark {
            --bg: #171B24;
            --panel: #1E2330;
            --border: #252C3D;
            --text-muted: #6B7280;
            --text-soft: #9CA3AF;
            --active: #1D3461;
            --active-text: #FFFFFF;
        }
        body { background: var(--bg); color: #E5E7EB; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #2A303F; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #3B82F6; }

        .sidebar-link { transition: all 0.2s; }
        .sidebar-link:hover { background: rgba(156, 163, 175, 0.1); }
        .sidebar-link.active { background: var(--active); color: var(--active-text); }
        .sidebar-link.active .icon { color: #60A5FA; }

        /* Tab styles */
        .tab-btn { transition: all 0.25s; border-bottom: 2px solid transparent; }
        .tab-btn.active { border-color: #3B82F6; color: #60A5FA; }

        /* Card hover */
        .card-hover { transition: all 0.3s; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(0,0,0,0.25); }

        /* Modal */
        .modal-overlay { backdrop-filter: blur(8px); }
        @keyframes modalIn { from { opacity: 0; transform: scale(0.94) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
        .modal-box { animation: modalIn 0.3s cubic-bezier(0.16,1,0.3,1) forwards; }

        /* Toast */
        @keyframes toastIn { from { opacity:0; transform: translateX(100px); } to { opacity:1; transform: translateX(0); } }
        .toast-enter { animation: toastIn 0.4s cubic-bezier(0.16,1,0.3,1) forwards; }

        /* Gradient text */
        .gradient-text { background: linear-gradient(135deg, #60A5FA, #818CF8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

        /* Status badge */
        .badge-baik  { background: rgba(16,185,129,0.15); color: #34D399; border: 1px solid rgba(16,185,129,0.25); }
        .badge-warn  { background: rgba(251,191,36,0.15); color: #FCD34D; border: 1px solid rgba(251,191,36,0.25); }
        .badge-info  { background: rgba(59,130,246,0.15); color: #60A5FA; border: 1px solid rgba(59,130,246,0.25); }
        .badge-pink  { background: rgba(236,72,153,0.15); color: #F472B6; border: 1px solid rgba(236,72,153,0.25); }

        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(0.6); }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden font-sans">

    <!-- ===================== SIDEBAR ===================== -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden"></div>
    <aside id="admin-sidebar" class="w-[240px] flex flex-col shrink-0 border-r border-[var(--border)] fixed md:relative z-50 h-full transition-transform duration-300 -translate-x-full md:translate-x-0" style="background: var(--panel);">

        <!-- Logo -->
        <div class="h-16 flex items-center gap-3 px-5 border-b border-[var(--border)] shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 group">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-600/30">
                    <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo" class="w-6 h-6 rounded">
                </div>
                <div>
                    <h1 class="text-[13px] font-bold text-gray-900 dark:text-white font-heading leading-tight">CV. NUSTECH</h1>
                    <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-wider">Admin Panel</p>
                </div>
            </a>
        </div>

        <!-- Nav Links -->
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-widest font-bold px-3 mb-3">Menu Utama</p>

            <a href="#" onclick="switchTab('dashboard'); return false;" id="sidelink-dashboard" class="sidebar-link active flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-900 dark:text-white">
                <span class="icon w-4 text-center"><i class="fa-solid fa-house-chimney text-xs"></i></span>
                Dashboard
            </a>

            <div class="border-t border-[var(--border)] my-3 pt-3">
                <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-widest font-bold px-3 mb-3">Konten Landing Page</p>
                <button onclick="switchTab('portfolio')" id="sidelink-portfolio" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400 text-left">
                    <span class="icon w-4 text-center"><i class="fa-solid fa-images text-xs"></i></span>
                    Portofolio
                    <span class="ml-auto text-[10px] badge-info px-2 py-0.5 rounded-full font-bold">{{ count($portfolios) }}</span>
                </button>
                <button onclick="switchTab('general')" id="sidelink-general" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400 text-left">
                    <span class="icon w-4 text-center"><i class="fa-regular fa-newspaper text-xs"></i></span>
                    Berita Umum
                    <span class="ml-auto text-[10px] badge-info px-2 py-0.5 rounded-full font-bold">{{ count($generalNews) }}</span>
                </button>
                <button onclick="switchTab('news')" id="sidelink-news" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400 text-left">
                    <span class="icon w-4 text-center"><i class="fa-brands fa-instagram text-xs"></i></span>
                    Instagram News
                    <span class="ml-auto text-[10px] badge-pink px-2 py-0.5 rounded-full font-bold">{{ count($instagramNews) }}</span>
                </button>
                <button onclick="switchTab('content')" id="sidelink-content" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400 text-left">
                    <span class="icon w-4 text-center"><i class="fa-solid fa-pen-nib text-xs"></i></span>
                    Konten Teks
                    <span class="ml-auto text-[10px] badge-warn px-2 py-0.5 rounded-full font-bold">Edit</span>
                </button>
                <button onclick="switchTab('modal')" id="sidelink-modal" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-500 dark:text-gray-400 text-left">
                    <span class="icon w-4 text-center"><i class="fa-solid fa-layer-group text-xs"></i></span>
                    Item Layanan (Modal)
                    <span class="ml-auto text-[10px] badge-info px-2 py-0.5 rounded-full font-bold">Kelola</span>
                </button>
            </div>

            <div class="border-t border-[var(--border)] my-3 pt-3">
                <p class="text-[9px] text-[var(--text-muted)] uppercase tracking-widest font-bold px-3 mb-3">Pengaturan</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-gray-400 dark:text-gray-600 dark:text-gray-400">
                    <span class="icon w-4 text-center"><i class="fa-regular fa-circle-user text-xs"></i></span>
                    Profil
                </a>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-4 border-t border-[var(--border)] shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-gray-900 dark:text-white text-xs font-bold shadow">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-[10px] text-[var(--text-muted)]">Administrator</p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-gray-500 dark:text-gray-400 hover:text-red-400 transition text-xs" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>
    </aside>

    <!-- ===================== MAIN CONTENT ===================== -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden" style="background: var(--bg);">

        <!-- TOP HEADER -->
        <header class="h-16 flex items-center justify-between px-4 sm:px-6 border-b border-[var(--border)] shrink-0" style="background: var(--panel);">
            <div class="flex items-center gap-3 sm:gap-4 min-w-0 mr-2">
                <button onclick="toggleSidebar()" class="md:hidden flex items-center justify-center w-8 h-8 rounded-lg bg-black/5 dark:bg-white/5 border border-[var(--border)] text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition shrink-0">
                    <i class="fa-solid fa-bars text-[13px]"></i>
                </button>
                <div class="min-w-0">
                    <h2 class="text-[13px] sm:text-[15px] font-bold text-gray-900 dark:text-white font-heading truncate" id="page-title">Dashboard Konten</h2>
                    <p class="text-[10px] sm:text-[11px] text-[var(--text-muted)] truncate hidden sm:block">Kelola tampilan Landing Page CV. NUSTECH</p>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" id="theme-toggle" class="flex items-center justify-center w-8 h-8 rounded-lg bg-black/5 dark:bg-white/5 border border-[var(--border)] text-gray-400 hover:text-gray-900 dark:hover:text-white transition shrink-0">
                    <i class="fa-solid fa-moon dark:hidden text-[13px]"></i>
                    <i class="fa-solid fa-sun hidden dark:block text-[13px] text-amber-300"></i>
                </button>

                <!-- Live Clock -->
                <div class="hidden sm:flex items-center gap-2 bg-black/5 dark:bg-white/5 border border-[var(--border)] rounded-lg px-3 py-1.5 text-[11px] text-gray-400 dark:text-gray-600 font-mono shrink-0">
                    <i class="fa-regular fa-clock text-blue-400 text-[10px]"></i>
                    <span id="live-clock">--:--:--</span>
                </div>
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center justify-center gap-2 text-[12px] font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white bg-black/5 dark:bg-white/5 border border-[var(--border)] px-2.5 py-2 rounded-lg transition shrink-0">
                    <i class="fa-solid fa-earth-asia text-blue-400 text-xs"></i>
                    <span class="hidden sm:inline">Lihat Web</span>
                </a>
                <a href="{{ route('mydashboard') }}"
                   class="flex items-center justify-center gap-2 text-[12px] font-semibold text-white bg-blue-600 hover:bg-blue-700 px-2.5 py-2 rounded-lg transition shadow-lg shadow-blue-600/25 shrink-0">
                    <i class="fa-solid fa-chart-line text-xs"></i>
                    <span class="hidden sm:inline">Dashboard NOC</span>
                </a>
            </div>
        </header>

        <!-- =========== SCROLLABLE CONTENT =========== -->
        <div class="flex-1 overflow-y-auto p-6 md:p-8 space-y-6">

            <!-- Toast Notifications -->
            @if(session('success'))
            <div id="toast" class="toast-enter fixed top-5 right-5 z-[100] flex items-center gap-3 bg-[#1a2a1a] border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 px-5 py-4 rounded-2xl shadow-2xl max-w-sm">
                <div class="w-8 h-8 bg-emerald-500/20 rounded-full flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-emerald-800 dark:text-emerald-200">Berhasil!</p>
                    <p class="text-[11px] mt-0.5 text-emerald-400">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('toast').remove()" class="ml-2 text-emerald-500 hover:text-emerald-800 dark:text-emerald-200 transition text-lg leading-none">&times;</button>
            </div>
            @endif

            @if($errors->any())
            <div class="flex items-start gap-3 bg-red-50 dark:bg-red-950/30 border border-red-500/20 rounded-xl p-4">
                <i class="fa-solid fa-circle-exclamation text-red-400 mt-0.5"></i>
                <div>
                    <p class="text-xs font-bold text-red-700 dark:text-red-300 mb-1">Gagal menyimpan data</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)
                        <li class="text-[11px] text-red-400">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <!-- ====== STATS CARDS ====== -->
            <div id="dashboard-stats" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <!-- Portofolio -->
                <div class="card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden cursor-pointer" style="background: var(--panel);" onclick="switchTab('portfolio')">
                    <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-500/5 blur-xl"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/15 border border-blue-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-images text-blue-400"></i>
                        </div>
                        <span class="badge-info text-[10px] px-2 py-0.5 rounded-full font-bold">Aktif</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white font-heading">{{ count($portfolios) }}</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Total Portofolio</p>
                    <p class="text-[10px] text-blue-400 mt-3 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-arrow-right text-[9px]"></i> Kelola Dasboard
                    </p>
                </div>

                <!-- Berita Umum -->
                <div class="card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden cursor-pointer" style="background: var(--panel);" onclick="switchTab('general')">
                    <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-sky-500/5 blur-xl"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-sky-500/15 border border-sky-500/20 flex items-center justify-center">
                            <i class="fa-regular fa-newspaper text-sky-400"></i>
                        </div>
                        <span class="badge-info text-[10px] px-2 py-0.5 rounded-full font-bold">Live</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white font-heading">{{ count($generalNews) }}</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Berita Umum</p>
                    <p class="text-[10px] text-sky-400 mt-3 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-arrow-right text-[9px]"></i> Kelola Berita
                    </p>
                </div>

                <!-- Instagram News -->
                <div class="card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden cursor-pointer" style="background: var(--panel);" onclick="switchTab('news')">
                    <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-pink-500/5 blur-xl"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/15 border border-pink-500/20 flex items-center justify-center">
                            <i class="fa-brands fa-instagram text-pink-400"></i>
                        </div>
                        <span class="badge-pink text-[10px] px-2 py-0.5 rounded-full font-bold">Live</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white font-heading">{{ count($instagramNews) }}</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Instagram News</p>
                    <p class="text-[10px] text-pink-400 mt-3 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-arrow-right text-[9px]"></i> Kelola Berita
                    </p>
                </div>

                <!-- Terakhir Diperbarui -->
                <div class="card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden" style="background: var(--panel);">
                    <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-emerald-500/5 blur-xl"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/15 border border-emerald-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-clock-rotate-left text-emerald-400"></i>
                        </div>
                        <span class="badge-baik text-[10px] px-2 py-0.5 rounded-full font-bold">Terbaru</span>
                    </div>
                    @php
                        $latestPort = $portfolios->first();
                        $latestIGNews = $instagramNews->first();
                        $latestGenNews = $generalNews->first();
                        $portTime = $latestPort ? $latestPort->created_at : null;
                        $igNewsTime = $latestIGNews ? ($latestIGNews->published_at ?? $latestIGNews->created_at) : null;
                        $genNewsTime = $latestGenNews ? ($latestGenNews->published_at ?? $latestGenNews->created_at) : null;
                        
                        $latestTime = collect([$portTime, $igNewsTime, $genNewsTime])->filter()->max();
                    @endphp
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white leading-snug">{{ $latestTime ? $latestTime->diffForHumans() : '—' }}</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Terakhir Diperbarui</p>
                    <p class="text-[10px] text-emerald-400 mt-3 font-medium flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse inline-block"></span>
                        Sistem Berjalan
                    </p>
                </div>

                <!-- Quick Action -->
                <div class="rounded-xl border border-blue-500/20 p-5 relative overflow-hidden bg-gradient-to-br from-blue-600/20 via-indigo-600/10 to-transparent">
                    <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-500/10 blur-xl"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center">
                            <i class="fa-solid fa-plus text-blue-300"></i>
                        </div>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white font-heading">Tambah Konten</h3>
                    <p class="text-xs text-[var(--text-muted)] mt-0.5">Portofolio atau Berita</p>
                    <div class="flex gap-2 mt-3">
                        <button onclick="openModal('modal-add-portfolio')" class="text-[10px] bg-blue-500/20 hover:bg-blue-500/30 border border-blue-500/30 text-blue-300 px-3 py-1.5 rounded-lg font-bold transition flex items-center gap-1">
                            <i class="fa-solid fa-images"></i> Portfolio
                        </button>
                        <button onclick="openModal('modal-add-general-news')" class="text-[10px] bg-sky-500/20 hover:bg-sky-500/30 border border-sky-500/30 text-sky-300 px-3 py-1.5 rounded-lg font-bold transition flex items-center gap-1">
                            <i class="fa-regular fa-newspaper"></i> Berita
                        </button>
                        <button onclick="openModal('modal-add-news')" class="text-[10px] bg-pink-500/20 hover:bg-pink-500/30 border border-pink-500/30 text-pink-300 px-3 py-1.5 rounded-lg font-bold transition flex items-center gap-1">
                            <i class="fa-brands fa-instagram"></i> IG News
                        </button>
                    </div>
                </div>
                
                <!-- ====== GRAFIK & VIEWS ====== -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                    <!-- Total Views Card -->
                    <div class="card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden flex flex-col justify-center items-center" style="background: var(--panel);">
                        <div class="absolute -left-4 -bottom-4 w-24 h-24 rounded-full bg-purple-500/5 blur-2xl"></div>
                        <div class="w-14 h-14 rounded-full bg-purple-500/15 border border-purple-500/20 flex items-center justify-center mb-3">
                            <i class="fa-solid fa-eye text-purple-400 text-xl"></i>
                        </div>
                        <h3 class="text-4xl font-bold text-gray-900 dark:text-white font-heading">{{ number_format($totalViews) }}</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-1 font-medium tracking-wide uppercase">Total Kunjungan Halaman</p>
                    </div>

                    <!-- Chart Card -->
                    <div class="lg:col-span-2 card-hover rounded-xl border border-[var(--border)] p-5 relative overflow-hidden" style="background: var(--panel);">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fa-solid fa-chart-line text-blue-400"></i> Grafik Pengunjung
                            </h3>
                            <span class="badge-info text-[9px] px-2 py-0.5 rounded-full font-bold">7 Hari Terakhir</span>
                        </div>
                        <div class="h-48 w-full relative">
                            <canvas id="viewsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ====== TAB NAVIGATION ====== -->
            <div id="inner-tab-navigation" class="border-b border-[var(--border)] flex items-center gap-1 overflow-x-auto">
                <button onclick="switchTab('portfolio')" id="tab-btn-portfolio" class="tab-btn active px-5 py-3 text-sm font-semibold text-blue-400 flex items-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-images text-xs"></i> Portofolio Kerja
                    <span class="badge-info text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ count($portfolios) }}</span>
                </button>
                <button onclick="switchTab('general')" id="tab-btn-general" class="tab-btn px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300 flex items-center gap-2 transition whitespace-nowrap">
                    <i class="fa-regular fa-newspaper text-xs"></i> Berita Umum
                    <span class="badge-info text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ count($generalNews) }}</span>
                </button>
                <button onclick="switchTab('news')" id="tab-btn-news" class="tab-btn px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300 flex items-center gap-2 transition whitespace-nowrap">
                    <i class="fa-brands fa-instagram text-xs"></i> Instagram News
                    <span class="badge-pink text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">{{ count($instagramNews) }}</span>
                </button>
                <button onclick="switchTab('content')" id="tab-btn-content" class="tab-btn px-5 py-3 text-sm font-semibold text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:text-gray-300 flex items-center gap-2 transition whitespace-nowrap">
                    <i class="fa-solid fa-pen-nib text-xs"></i> Konten Teks
                    <span class="badge-warn text-[10px] px-2 py-0.5 rounded-full font-bold ml-1">Edit</span>
                </button>
            </div>

            <!-- ====== TAB: PORTOFOLIO ====== -->
            <div id="tab-portfolio" class="tab-pane space-y-5">
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-heading">Portofolio Kerja</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Dokumentasi proyek yang tampil di halaman <a href="{{ route('home') }}#gallery" target="_blank" class="text-blue-400 hover:underline">Gallery</a> landing page.</p>
                    </div>
                    <button onclick="openModal('modal-add-portfolio')"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-gray-900 dark:text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Portofolio
                    </button>
                </div>

                @if($portfolios->isEmpty())
                <div class="rounded-xl border border-[var(--border)] py-16 text-center" style="background: var(--panel);">
                    <div class="w-14 h-14 rounded-full bg-black/5 dark:bg-white/5 border border-[var(--border)] flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-image-portrait text-gray-500 dark:text-gray-400 text-xl"></i>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-semibold text-sm">Belum Ada Portofolio</h4>
                    <p class="text-[var(--text-muted)] text-xs mt-2 max-w-xs mx-auto">Tambahkan portofolio untuk ditampilkan di bagian Gallery pada landing page.</p>
                    <button onclick="openModal('modal-add-portfolio')"
                        class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-gray-900 dark:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-blue-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Sekarang
                    </button>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($portfolios as $p)
                    <div class="card-hover rounded-xl border border-[var(--border)] overflow-hidden group" style="background: var(--panel);">
                        <!-- Image -->
                        <div class="relative h-44 bg-gray-200 dark:bg-gray-900 overflow-hidden">
                            <img src="{{ asset($p->image_path) }}" alt="{{ $p->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            @if($p->category)
                            <span class="absolute top-3 left-3 bg-white/90 dark:bg-black/70 backdrop-blur-md text-blue-300 text-[9px] font-extrabold px-2.5 py-1 rounded-full uppercase tracking-wider border border-black/10 dark:border-white/10">
                                {{ $p->category }}
                            </span>
                            @endif
                            <span class="absolute bottom-3 right-3 bg-white/80 dark:bg-black/60 text-gray-700 dark:text-gray-300 text-[9px] px-2 py-0.5 rounded font-mono">
                                #{{ $p->id }}
                            </span>
                        </div>
                        <!-- Body -->
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-1 group-hover:text-blue-300 transition-colors">{{ $p->title }}</h4>
                            <p class="text-xs text-[var(--text-muted)] mt-1.5 line-clamp-2 leading-relaxed">{{ $p->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                        <!-- Actions -->
                        <div class="px-4 pb-4 flex items-center gap-2 border-t border-[var(--border)] pt-3 mt-1">
                            <button onclick='openEditPortfolioModal({{ $p->id }}, @json($p->title), @json($p->category), @json($p->description))'
                                    class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-black/5 dark:bg-white/5 hover:bg-blue-500/10 hover:text-blue-300 text-gray-400 dark:text-gray-600 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-blue-500/30 transition cursor-pointer">
                                <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                            </button>
                            <form action="{{ route('admin.home.portfolio.destroy', $p->id) }}" method="POST"
                                  onsubmit="return confirm('Hapus portofolio ini?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="flex items-center justify-center gap-1.5 px-3 py-2 bg-black/5 dark:bg-white/5 hover:bg-red-500/10 hover:text-red-400 text-gray-500 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-red-500/30 transition cursor-pointer">
                                    <i class="fa-solid fa-trash-can text-[10px]"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- ====== TAB: BERITA UMUM ====== -->
            <div id="tab-general" class="tab-pane hidden space-y-5">
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-heading">Berita Umum</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Berita umum perusahaan yang tampil di landing page.</p>
                    </div>
                    <button onclick="openModal('modal-add-general-news')"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-blue-500 hover:from-sky-700 hover:to-blue-600 text-gray-900 dark:text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-sky-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Berita
                    </button>
                </div>

                @if($generalNews->isEmpty())
                <div class="rounded-xl border border-[var(--border)] py-16 text-center" style="background: var(--panel);">
                    <div class="w-14 h-14 rounded-full bg-black/5 dark:bg-white/5 border border-[var(--border)] flex items-center justify-center mx-auto mb-4">
                        <i class="fa-regular fa-newspaper text-gray-500 dark:text-gray-400 text-xl"></i>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-semibold text-sm">Belum Ada Berita</h4>
                    <button onclick="openModal('modal-add-general-news')"
                        class="mt-5 inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-blue-500 text-gray-900 dark:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-sky-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Sekarang
                    </button>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($generalNews as $n)
                    <div class="card-hover rounded-xl border border-[var(--border)] overflow-hidden group" style="background: var(--panel);">
                        <div class="relative h-44 bg-gray-200 dark:bg-gray-900 overflow-hidden">
                            @if($n->image_path)
                                <img src="{{ asset($n->image_path) }}" alt="{{ $n->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-sky-950 via-blue-950 to-indigo-950 flex flex-col items-center justify-center text-gray-900 dark:text-white">
                                    <i class="fa-regular fa-newspaper text-4xl opacity-25 mb-2"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            @if($n->is_active)
                                <span class="absolute top-3 left-3 bg-emerald-500/80 backdrop-blur-md text-gray-900 dark:text-white text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="fa-solid fa-eye text-[8px]"></i> Ditampilkan
                                </span>
                            @else
                                <span class="absolute top-3 left-3 bg-gray-500/80 backdrop-blur-md text-gray-900 dark:text-white text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="fa-solid fa-eye-slash text-[8px]"></i> Disembunyikan
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-1 group-hover:text-sky-300 transition-colors">{{ $n->title }}</h4>
                            <p class="text-xs text-[var(--text-muted)] mt-1.5 line-clamp-2 leading-relaxed">{{ $n->caption ?? 'Tidak ada caption.' }}</p>
                        </div>
                        <div class="px-4 pb-4 flex flex-col gap-2 border-t border-[var(--border)] pt-3 mt-1">
                            <form action="{{ route('admin.home.news.toggle', $n->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 py-2 {{ $n->is_active ? 'bg-gray-200 dark:bg-gray-500/20 hover:bg-gray-300 dark:hover:bg-gray-500/30 text-gray-700 dark:text-gray-300' : 'bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400' }} rounded-lg text-xs font-semibold border border-[var(--border)] transition cursor-pointer">
                                    <i class="fa-solid {{ $n->is_active ? 'fa-eye-slash' : 'fa-eye' }} text-[10px]"></i> 
                                    {{ $n->is_active ? 'Sembunyikan dari Web' : 'Tampilkan di Web' }}
                                </button>
                            </form>
                            <div class="flex items-center gap-2">
                                <button onclick='openEditGeneralNewsModal({{ $n->id }}, @json($n->title), @json($n->caption), @json($n->published_at ? $n->published_at->format("Y-m-d") : ""))'
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-black/5 dark:bg-white/5 hover:bg-sky-500/10 hover:text-sky-300 text-gray-400 dark:text-gray-600 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-sky-500/30 transition cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                </button>
                                <form action="{{ route('admin.home.news.destroy', $n->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus berita ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-1.5 px-3 py-2 bg-black/5 dark:bg-white/5 hover:bg-red-500/10 hover:text-red-400 text-gray-500 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-red-500/30 transition cursor-pointer">
                                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- ====== TAB: INSTAGRAM NEWS ====== -->
            <div id="tab-news" class="tab-pane hidden space-y-5">
                <!-- Section Header -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-heading">Instagram News</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Postingan yang tampil di bagian <a href="{{ route('home') }}#news" target="_blank" class="text-pink-400 hover:underline">Berita</a> landing page.</p>
                    </div>
                    <button onclick="openModal('modal-add-news')"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-orange-500 hover:from-pink-700 hover:to-orange-600 text-gray-900 dark:text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-pink-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Kabar
                    </button>
                </div>

                @if($instagramNews->isEmpty())
                <div class="rounded-xl border border-[var(--border)] py-16 text-center" style="background: var(--panel);">
                    <div class="w-14 h-14 rounded-full bg-black/5 dark:bg-white/5 border border-[var(--border)] flex items-center justify-center mx-auto mb-4">
                        <i class="fa-brands fa-instagram text-gray-500 dark:text-gray-400 text-xl"></i>
                    </div>
                    <h4 class="text-gray-900 dark:text-white font-semibold text-sm">Belum Ada Kabar Berita</h4>
                    <p class="text-[var(--text-muted)] text-xs mt-2 max-w-xs mx-auto">Tambahkan link postingan Instagram agar landing page terhubung dinamis.</p>
                    <button onclick="openModal('modal-add-news')"
                        class="mt-5 inline-flex items-center gap-2 bg-gradient-to-r from-pink-600 to-orange-500 text-gray-900 dark:text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-pink-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Sekarang
                    </button>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($instagramNews as $n)
                    <div class="card-hover rounded-xl border border-[var(--border)] overflow-hidden group" style="background: var(--panel);">
                        <!-- Image / Cover -->
                        <div class="relative h-44 bg-gray-200 dark:bg-gray-900 overflow-hidden">
                            @if($n->image_path)
                                <img src="{{ asset($n->image_path) }}" alt="{{ $n->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-pink-950 via-purple-950 to-indigo-950 flex flex-col items-center justify-center text-gray-900 dark:text-white">
                                    <i class="fa-brands fa-instagram text-4xl opacity-25 mb-2"></i>
                                    <span class="text-[10px] text-pink-300 font-semibold tracking-wider">nustech.co.id</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            @if($n->is_active)
                                <span class="absolute top-3 left-3 bg-emerald-500/80 backdrop-blur-md text-gray-900 dark:text-white text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="fa-solid fa-eye text-[8px]"></i> Ditampilkan
                                </span>
                            @else
                                <span class="absolute top-3 left-3 bg-gray-500/80 backdrop-blur-md text-gray-900 dark:text-white text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <i class="fa-solid fa-eye-slash text-[8px]"></i> Disembunyikan
                                </span>
                            @endif

                            @if($n->published_at)
                            <span class="absolute top-3 right-3 bg-pink-600/80 backdrop-blur-md text-gray-900 dark:text-white text-[9px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                <i class="fa-solid fa-calendar-days text-[8px]"></i> {{ $n->published_at->format('d M Y') }}
                            </span>
                            @endif
                        </div>
                        <!-- Body -->
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-1 group-hover:text-pink-300 transition-colors">{{ $n->title }}</h4>
                            <p class="text-xs text-[var(--text-muted)] mt-1.5 line-clamp-2 leading-relaxed">{{ $n->caption ?? 'Tidak ada caption.' }}</p>
                            @if($n->instagram_url)
                            <a href="{{ $n->instagram_url }}" target="_blank"
                               class="inline-flex items-center gap-1.5 text-[10px] text-pink-400 hover:text-pink-300 mt-2.5 font-semibold transition">
                                <i class="fa-brands fa-instagram text-xs"></i>
                                Buka Postingan <i class="fa-solid fa-up-right-from-square text-[8px]"></i>
                            </a>
                            @endif
                        </div>
                        <!-- Actions -->
                        <div class="px-4 pb-4 flex flex-col gap-2 border-t border-[var(--border)] pt-3 mt-1">
                            <form action="{{ route('admin.home.news.toggle', $n->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center gap-1.5 py-2 {{ $n->is_active ? 'bg-gray-200 dark:bg-gray-500/20 hover:bg-gray-300 dark:hover:bg-gray-500/30 text-gray-700 dark:text-gray-300' : 'bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400' }} rounded-lg text-xs font-semibold border border-[var(--border)] transition cursor-pointer">
                                    <i class="fa-solid {{ $n->is_active ? 'fa-eye-slash' : 'fa-eye' }} text-[10px]"></i> 
                                    {{ $n->is_active ? 'Sembunyikan dari Web' : 'Tampilkan di Web' }}
                                </button>
                            </form>
                            <div class="flex items-center gap-2">
                                <button onclick='openEditNewsModal({{ $n->id }}, @json($n->title), @json($n->instagram_url), @json($n->caption), @json($n->published_at ? $n->published_at->format("Y-m-d") : ""))'
                                        class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-black/5 dark:bg-white/5 hover:bg-pink-500/10 hover:text-pink-300 text-gray-400 dark:text-gray-600 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-pink-500/30 transition cursor-pointer">
                                    <i class="fa-solid fa-pen-to-square text-[10px]"></i> Edit
                                </button>
                                <form action="{{ route('admin.home.news.destroy', $n->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus kabar berita ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="flex items-center justify-center gap-1.5 px-3 py-2 bg-black/5 dark:bg-white/5 hover:bg-red-500/10 hover:text-red-400 text-gray-500 dark:text-gray-400 rounded-lg text-xs font-semibold border border-[var(--border)] hover:border-red-500/30 transition cursor-pointer">
                                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ====== TAB: KONTEN TEKS ====== --}}
            <div id="tab-content" class="tab-pane hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-heading">Konten Teks Landing Page</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Edit semua teks, deskripsi, dan kontak yang tampil di <a href="{{ route('home') }}" target="_blank" class="text-amber-400 hover:underline">landing page</a>.</p>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-amber-400 border border-amber-500/30 rounded-xl px-3 py-2 bg-amber-500/5">
                        <i class="fa-solid fa-circle-info"></i>
                        Klik "Simpan Perubahan" di setiap bagian untuk menyimpan.
                    </div>
                </div>

                @php
                    $groups = [
                        'hero'         => ['label' => 'Hero Section',           'icon' => 'fa-star',           'color' => 'sky'],
                        'tentang'      => ['label' => 'Tentang Kami',           'icon' => 'fa-building',       'color' => 'blue'],
                        'modal_tentang'=> ['label' => 'Modal Profil Perusahaan','icon' => 'fa-rectangle-list', 'color' => 'indigo'],
                        'visimisi'     => ['label' => 'Visi & Misi',            'icon' => 'fa-bullseye',       'color' => 'purple'],
                        'layanan'      => ['label' => 'Layanan',                'icon' => 'fa-concierge-bell', 'color' => 'emerald'],
                        'kontak'       => ['label' => 'Kontak & Footer',        'icon' => 'fa-phone',          'color' => 'orange'],
                    ];
                @endphp

                @foreach($groups as $groupKey => $groupInfo)
                @php $groupItems = $contentItems->where('group', $groupKey); @endphp
                @if($groupItems->isNotEmpty())
                <div class="rounded-xl border border-[var(--border)] overflow-hidden" style="background: var(--panel);">
                    {{-- Group Header --}}
                    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-[var(--border)] bg-black/[0.02] dark:bg-white/[0.02]">
                        <div class="w-7 h-7 rounded-lg bg-{{ $groupInfo['color'] }}-500/15 border border-{{ $groupInfo['color'] }}-500/20 flex items-center justify-center">
                            <i class="fa-solid {{ $groupInfo['icon'] }} text-{{ $groupInfo['color'] }}-400 text-[11px]"></i>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white font-heading">{{ $groupInfo['label'] }}</h4>
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('admin.home.content.update') }}" method="POST" class="p-5 space-y-4">
                        @csrf
                        @method('PUT')

                        @foreach($groupItems->sortBy('order') as $item)
                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">
                                {{ $item->label }}
                            </label>
                            @if($item->type === 'textarea')
                                <textarea name="content[{{ $item->key }}]" rows="3"
                                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:border-{{ $groupInfo['color'] }}-500 focus:ring-1 focus:ring-{{ $groupInfo['color'] }}-500/20 focus:outline-none transition resize-none font-mono">{{ $item->value }}</textarea>
                            @elseif($item->type === 'number')
                                <input type="number" name="content[{{ $item->key }}]" value="{{ $item->value }}"
                                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-{{ $groupInfo['color'] }}-500 focus:ring-1 focus:ring-{{ $groupInfo['color'] }}-500/20 focus:outline-none transition">
                            @elseif($item->type === 'url')
                                <input type="text" name="content[{{ $item->key }}]" value="{{ $item->value }}"
                                    placeholder="https://..."
                                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white font-mono focus:border-{{ $groupInfo['color'] }}-500 focus:ring-1 focus:ring-{{ $groupInfo['color'] }}-500/20 focus:outline-none transition">
                            @else
                                <input type="text" name="content[{{ $item->key }}]" value="{{ $item->value }}"
                                    class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-{{ $groupInfo['color'] }}-500 focus:ring-1 focus:ring-{{ $groupInfo['color'] }}-500/20 focus:outline-none transition">
                            @endif
                        </div>
                        @endforeach

                        <div class="pt-2 flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-400 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-amber-500/20">
                                <i class="fa-solid fa-floppy-disk"></i> Simpan {{ $groupInfo['label'] }}
                            </button>
                        </div>
                    </form>
                </div>
                @endif
                @endforeach
            </div>

            {{-- ====== TAB: MODAL ITEMS ====== --}}
            <div id="tab-modal" class="tab-pane hidden space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-base font-bold text-gray-900 dark:text-white font-heading">Item Layanan (Modal)</h3>
                        <p class="text-xs text-[var(--text-muted)] mt-0.5">Kelola portofolio pada modal layanan Jaringan, VSAT, Baseband, dan CCTV.</p>
                    </div>
                    <button onclick="openModal('modal-add-modalitem')"
                        class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20">
                        <i class="fa-solid fa-plus"></i> Tambah Item
                    </button>
                </div>

                @php
                    $modalCategories = [
                        'jaringan' => ['label' => 'Jaringan', 'icon' => 'fa-wifi', 'color' => 'blue'],
                        'vsat' => ['label' => 'VSAT', 'icon' => 'fa-satellite-dish', 'color' => 'sky'],
                        'baseband' => ['label' => 'Baseband', 'icon' => 'fa-network-wired', 'color' => 'indigo'],
                        'cctv' => ['label' => 'CCTV', 'icon' => 'fa-camera', 'color' => 'purple'],
                        'aplikasi_software' => ['label' => 'Aplikasi: Pembuatan Software', 'icon' => 'fa-globe', 'color' => 'blue'],
                        'aplikasi_jasa' => ['label' => 'Aplikasi: Jasa Pemrograman', 'icon' => 'fa-database', 'color' => 'indigo'],
                        'reklame_desain' => ['label' => 'Reklame: Desain Media Promosi', 'icon' => 'fa-sign-hanging', 'color' => 'pink'],
                        'reklame_cetak' => ['label' => 'Reklame: Layanan Cetak', 'icon' => 'fa-print', 'color' => 'rose'],
                        'kelistrikan_sistem' => ['label' => 'Kelistrikan: Sistem Kelistrikan', 'icon' => 'fa-plug-circle-bolt', 'color' => 'yellow'],
                        'ac_pemasangan' => ['label' => 'AC: Pemasangan AC', 'icon' => 'fa-shower', 'color' => 'cyan'],
                        'ac_maintenance' => ['label' => 'AC: Maintenance & Perbaikan', 'icon' => 'fa-wind', 'color' => 'sky'],
                        'komputer_pengadaan' => ['label' => 'Komputer: Pengadaan Unit', 'icon' => 'fa-laptop', 'color' => 'slate'],
                        'komputer_perawatan' => ['label' => 'Komputer: Layanan Perawatan', 'icon' => 'fa-screwdriver-wrench', 'color' => 'gray'],
                        'elektronik_penyediaan' => ['label' => 'Elektronik: Penyediaan Perangkat', 'icon' => 'fa-tv', 'color' => 'teal'],
                        'kantor_penyediaan' => ['label' => 'Kantor: Penyediaan Perlengkapan', 'icon' => 'fa-chair', 'color' => 'orange'],
                        'kantor_perawatan' => ['label' => 'Kantor: Perawatan Alat', 'icon' => 'fa-box-archive', 'color' => 'amber']
                    ];
                @endphp

                @foreach($modalCategories as $modKey => $modInfo)
                <div class="rounded-xl border border-[var(--border)] overflow-hidden" style="background: var(--panel);">
                    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-[var(--border)] bg-black/[0.02] dark:bg-white/[0.02]">
                        <div class="w-7 h-7 rounded-lg bg-{{ $modInfo['color'] }}-500/15 border border-{{ $modInfo['color'] }}-500/20 flex items-center justify-center">
                            <i class="fa-solid {{ $modInfo['icon'] }} text-{{ $modInfo['color'] }}-400 text-[11px]"></i>
                        </div>
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white font-heading">{{ $modInfo['label'] }}</h4>
                    </div>
                    
                    <div class="p-5">
                        @php $items = collect($modalItems->get($modKey) ?? []); @endphp
                        @if($items->isEmpty())
                            <p class="text-[var(--text-muted)] text-xs italic">Belum ada item portofolio.</p>
                        @else
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                                @foreach($items as $item)
                                <div class="flex items-start justify-between gap-4 p-4 rounded-lg border border-[var(--border)] bg-[var(--bg)]">
                                    <div class="flex-1">
                                        <h5 class="text-sm font-bold text-gray-900 dark:text-white line-clamp-1">{{ $item->title }}</h5>
                                        <p class="text-[10px] text-[var(--text-muted)] mt-1.5 flex flex-wrap gap-x-3 gap-y-1">
                                            @if($item->year)<span class="text-{{ $modInfo['color'] }}-400"><i class="fa-regular fa-calendar"></i> {{ $item->year }}</span>@endif
                                            @if($item->client)<span><i class="fa-regular fa-building"></i> {{ $item->client }}</span>@endif
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-1.5 shrink-0">
                                        <button onclick='openEditModalItemModal({{ $item->id }}, @json($item->title), @json($item->year), @json($item->client), @json($item->description))'
                                            class="w-7 h-7 flex items-center justify-center rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-500/20 transition cursor-pointer">
                                            <i class="fa-solid fa-pen text-[10px]"></i>
                                        </button>
                                        <form action="{{ route('admin.home.modal.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-500/20 transition cursor-pointer">
                                                <i class="fa-solid fa-trash text-[10px]"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ====== PREVIEW SECTION ====== --}}

            <div class="rounded-xl border border-[var(--border)] p-5" style="background: var(--panel);">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 border border-[var(--border)] flex items-center justify-center">
                            <i class="fa-solid fa-eye text-gray-400 dark:text-gray-600 dark:text-gray-400 text-[11px]"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white font-heading">Pratinjau Landing Page</h3>
                    </div>
                    <a href="{{ route('home') }}" target="_blank"
                       class="text-[11px] text-blue-400 hover:text-blue-300 hover:underline flex items-center gap-1 transition">
                        Buka Full <i class="fa-solid fa-up-right-from-square text-[9px]"></i>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Portfolio Preview Summary -->
                    <div class="bg-black/[0.03] dark:bg-white/3 border border-[var(--border)] rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded bg-blue-500/15 flex items-center justify-center"><i class="fa-solid fa-images text-blue-400 text-[10px]"></i></div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Gallery Section</span>
                        </div>
                        @if($portfolios->isNotEmpty())
                        <div class="flex -space-x-2 mb-2">
                            @foreach($portfolios->take(5) as $p)
                            <div class="w-8 h-8 rounded-full border-2 border-[var(--panel)] overflow-hidden shrink-0">
                                <img src="{{ asset($p->image_path) }}" alt="" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                            @if($portfolios->count() > 5)
                            <div class="w-8 h-8 rounded-full border-2 border-[var(--panel)] bg-blue-600 flex items-center justify-center text-[9px] font-bold text-gray-900 dark:text-white shrink-0">
                                +{{ $portfolios->count() - 5 }}
                            </div>
                            @endif
                        </div>
                        <p class="text-[10px] text-[var(--text-muted)]">{{ $portfolios->count() }} proyek ditampilkan pada carousel galeri landing page.</p>
                        @else
                        <p class="text-[10px] text-[var(--text-muted)]">Belum ada portofolio. Tampilan galeri menggunakan placeholder.</p>
                        @endif
                    </div>
                    <!-- News Preview Summary -->
                    <div class="bg-black/[0.03] dark:bg-white/3 border border-[var(--border)] rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded bg-pink-500/15 flex items-center justify-center"><i class="fa-brands fa-instagram text-pink-400 text-[10px]"></i></div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">News Section</span>
                        </div>
                        @if($instagramNews->isNotEmpty())
                        <div class="space-y-1.5 mb-2">
                            @foreach($instagramNews->take(3) as $n)
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-pink-500/10 flex items-center justify-center shrink-0"><i class="fa-brands fa-instagram text-pink-400 text-[8px]"></i></div>
                                <span class="text-[10px] text-gray-400 dark:text-gray-600 dark:text-gray-400 line-clamp-1">{{ $n->title }}</span>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-[var(--text-muted)]">{{ $instagramNews->count() }} postingan ditampilkan pada section berita IG.</p>
                        @else
                        <p class="text-[10px] text-[var(--text-muted)]">Belum ada kabar IG. Tampilan news menggunakan konten statis.</p>
                        @endif
                    </div>
                    <!-- General News Preview Summary -->
                    <div class="bg-black/[0.03] dark:bg-white/3 border border-[var(--border)] rounded-xl p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-6 h-6 rounded bg-sky-500/15 flex items-center justify-center"><i class="fa-regular fa-newspaper text-sky-400 text-[10px]"></i></div>
                            <span class="text-xs font-bold text-gray-900 dark:text-white">Berita Umum</span>
                        </div>
                        @if($generalNews->isNotEmpty())
                        <div class="space-y-1.5 mb-2">
                            @foreach($generalNews->take(3) as $n)
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded bg-sky-500/10 flex items-center justify-center shrink-0"><i class="fa-regular fa-newspaper text-sky-400 text-[8px]"></i></div>
                                <span class="text-[10px] text-gray-400 dark:text-gray-600 dark:text-gray-400 line-clamp-1">{{ $n->title }}</span>
                            </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] text-[var(--text-muted)]">{{ $generalNews->count() }} berita ditampilkan pada section berita umum.</p>
                        @else
                        <p class="text-[10px] text-[var(--text-muted)]">Belum ada berita umum.</p>
                        @endif
                    </div>
                </div>
            </div>

        </div><!-- end scrollable -->
    </main><!-- end main -->

    <!-- ====================================================
         MODAL: ADD PORTFOLIO
    ==================================================== -->
    <div id="modal-add-portfolio" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-images text-blue-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Tambah Portofolio</h4>
                </div>
                <button onclick="closeModal('modal-add-portfolio')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form action="{{ route('admin.home.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Proyek / Pekerjaan <span class="text-red-400">*</span></label>
                    <input type="text" name="title" required placeholder="Cth: Instalasi Fiber Optik Kantor Gubernur NTB"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Kategori Bidang</label>
                    <input type="text" name="category" placeholder="Cth: Networking, VSAT, Tower, Kelistrikan"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan proyek atau pekerjaan ini secara singkat..."
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Foto Portofolio <span class="text-red-400">*</span></label>
                    <input type="file" name="image" required accept="image/*"
                           class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border file:border-[var(--border)] file:text-xs file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer">
                    <p class="text-[10px] text-gray-400 dark:text-gray-600 mt-1.5">Format: JPG, PNG, WEBP. Maks. 5MB</p>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-add-portfolio')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-blue-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: EDIT PORTFOLIO
    ==================================================== -->
    <div id="modal-edit-portfolio" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-indigo-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Edit Portofolio</h4>
                </div>
                <button onclick="closeModal('modal-edit-portfolio')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form id="form-edit-portfolio" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Proyek / Pekerjaan <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="edit-portfolio-title" required
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Kategori Bidang</label>
                    <input type="text" name="category" id="edit-portfolio-category"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" id="edit-portfolio-description" rows="3"
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Ganti Foto <span class="text-gray-400 dark:text-gray-600 font-normal">(kosongkan jika tidak diubah)</span></label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border file:border-[var(--border)] file:text-xs file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer">
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-edit-portfolio')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: ADD GENERAL NEWS
    ==================================================== -->
    <div id="modal-add-general-news" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-sky-500/15 border border-sky-500/20 flex items-center justify-center">
                        <i class="fa-regular fa-newspaper text-sky-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Tambah Berita Umum</h4>
                </div>
                <button onclick="closeModal('modal-add-general-news')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form action="{{ route('admin.home.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="type" value="general">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Kabar / Berita <span class="text-red-400">*</span></label>
                    <input type="text" name="title" required placeholder="Cth: Kegiatan CSR NUSTECH"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-sky-500 focus:ring-1 focus:ring-sky-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Isi Berita Singkat / Deskripsi</label>
                    <textarea name="caption" rows="3" placeholder="Deskripsi singkat berita..."
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-sky-500 focus:ring-1 focus:ring-sky-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" value="{{ date('Y-m-d') }}"
                               class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Cover Berita</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-[var(--border)] file:text-[10px] file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-add-general-news')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-sky-600 to-blue-500 hover:from-sky-700 hover:to-blue-600 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-sky-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: EDIT GENERAL NEWS
    ==================================================== -->
    <div id="modal-edit-general-news" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-sky-500/15 border border-sky-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-sky-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Edit Berita Umum</h4>
                </div>
                <button onclick="closeModal('modal-edit-general-news')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form id="form-edit-general-news" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf @method('PUT')
                <input type="hidden" name="type" value="general">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Kabar / Berita <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="edit-general-news-title" required
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-sky-500 focus:ring-1 focus:ring-sky-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Isi Berita Singkat / Deskripsi</label>
                    <textarea name="caption" id="edit-general-news-caption" rows="3"
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-sky-500 focus:ring-1 focus:ring-sky-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" id="edit-general-news-date"
                               class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-sky-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Ganti Cover <span class="text-gray-400 dark:text-gray-600 font-normal">(opsional)</span></label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-[var(--border)] file:text-[10px] file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-edit-general-news')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-sky-600 to-blue-500 hover:from-sky-700 hover:to-blue-600 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-sky-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: ADD NEWS
    ==================================================== -->
    <div id="modal-add-news" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-pink-500/15 border border-pink-500/20 flex items-center justify-center">
                        <i class="fa-brands fa-instagram text-pink-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Tambah Kabar Instagram</h4>
                </div>
                <button onclick="closeModal('modal-add-news')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form action="{{ route('admin.home.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <input type="hidden" name="type" value="instagram">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Kabar / Berita <span class="text-red-400">*</span></label>
                    <input type="text" name="title" required placeholder="Cth: Kegiatan CSR NUSTECH Peduli Lingkungan"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Link Postingan Instagram <span class="text-gray-400 dark:text-gray-600 font-normal">(Opsional)</span></label>
                    <input type="url" name="instagram_url" placeholder="https://www.instagram.com/p/..."
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Caption Postingan</label>
                    <textarea name="caption" rows="3" placeholder="Caption singkat postingan Instagram..."
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" value="{{ date('Y-m-d') }}"
                               class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-pink-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Cover Berita</label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-[var(--border)] file:text-[10px] file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-add-news')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-pink-600 to-orange-500 hover:from-pink-700 hover:to-orange-600 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-pink-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: EDIT NEWS
    ==================================================== -->
    <div id="modal-edit-news" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-orange-500/15 border border-orange-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-pen-to-square text-orange-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Edit Kabar Instagram</h4>
                </div>
                <button onclick="closeModal('modal-edit-news')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form id="form-edit-news" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf @method('PUT')
                <input type="hidden" name="type" value="instagram">
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Kabar / Berita <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="edit-news-title" required
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Link Instagram</label>
                    <input type="url" name="instagram_url" id="edit-news-url"
                           class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Caption Postingan</label>
                    <textarea name="caption" id="edit-news-caption" rows="3"
                              class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-600 focus:border-pink-500 focus:ring-1 focus:ring-pink-500/20 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" id="edit-news-date"
                               class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-pink-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Ganti Cover <span class="text-gray-400 dark:text-gray-600 font-normal">(opsional)</span></label>
                        <input type="file" name="image" accept="image/*"
                               class="w-full text-xs text-gray-400 dark:text-gray-600 dark:text-gray-400 file:py-1.5 file:px-3 file:rounded-lg file:border file:border-[var(--border)] file:text-[10px] file:font-bold file:bg-black/5 dark:bg-white/5 file:text-gray-700 dark:text-gray-300 hover:file:bg-black/10 dark:bg-white/10 cursor-pointer file:transition file:cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-edit-news')"
                            class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 dark:text-gray-400 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-pink-600 to-orange-500 hover:from-pink-700 hover:to-orange-600 text-gray-900 dark:text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-pink-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: ADD MODAL ITEM
    ==================================================== -->
    <div id="modal-add-modalitem" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-layer-group text-indigo-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Tambah Item Layanan</h4>
                </div>
                <button onclick="closeModal('modal-add-modalitem')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form action="{{ route('admin.home.modal.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Kategori Modal <span class="text-red-400">*</span></label>
                    <select name="modal_key" required class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                        <option value="jaringan">Jaringan</option>
                        <option value="vsat">VSAT</option>
                        <option value="baseband">Baseband</option>
                        <option value="cctv">CCTV</option>
                        <option value="aplikasi_software">Aplikasi: Pembuatan Software</option>
                        <option value="aplikasi_jasa">Aplikasi: Jasa Pemrograman</option>
                        <option value="reklame_desain">Reklame: Desain Media Promosi</option>
                        <option value="reklame_cetak">Reklame: Layanan Cetak</option>
                        <option value="kelistrikan_sistem">Kelistrikan: Sistem Kelistrikan</option>
                        <option value="ac_pemasangan">AC: Pemasangan AC</option>
                        <option value="ac_maintenance">AC: Maintenance & Perbaikan</option>
                        <option value="komputer_pengadaan">Komputer: Pengadaan Unit</option>
                        <option value="komputer_perawatan">Komputer: Layanan Perawatan</option>
                        <option value="elektronik_penyediaan">Elektronik: Penyediaan Perangkat</option>
                        <option value="kantor_penyediaan">Kantor: Penyediaan Perlengkapan</option>
                        <option value="kantor_perawatan">Kantor: Perawatan Alat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Proyek/Pekerjaan <span class="text-red-400">*</span></label>
                    <input type="text" name="title" required class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tahun</label>
                        <input type="text" name="year" placeholder="Cth: 2024" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Klien/Instansi</label>
                        <input type="text" name="client" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi / Cakupan (pisahkan dengan koma)</label>
                    <textarea name="description" rows="2" placeholder="Cth: Pemasangan PTP, Instalasi kabel..." class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-add-modalitem')" class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20 cursor-pointer">Simpan Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         MODAL: EDIT MODAL ITEM
    ==================================================== -->
    <div id="modal-edit-modalitem" class="fixed inset-0 z-50 hidden modal-overlay bg-white/90 dark:bg-black/70 flex items-center justify-center p-4">
        <div class="modal-box w-full max-w-lg rounded-2xl border border-[var(--border)] shadow-2xl overflow-hidden" style="background: var(--panel);">
            <div class="flex items-center justify-between px-6 py-4 border-b border-[var(--border)]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/15 border border-indigo-500/20 flex items-center justify-center">
                        <i class="fa-solid fa-pen text-indigo-400 text-sm"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 dark:text-white text-sm font-heading">Edit Item Layanan</h4>
                </div>
                <button onclick="closeModal('modal-edit-modalitem')" class="w-7 h-7 rounded-lg bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 hover:text-gray-900 dark:text-white flex items-center justify-center transition cursor-pointer">&times;</button>
            </div>
            <form id="form-edit-modalitem" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Judul Proyek/Pekerjaan <span class="text-red-400">*</span></label>
                    <input type="text" name="title" id="edit-mi-title" required class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Tahun</label>
                        <input type="text" name="year" id="edit-mi-year" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Klien/Instansi</label>
                        <input type="text" name="client" id="edit-mi-client" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1.5">Deskripsi / Cakupan (pisahkan dengan koma)</label>
                    <textarea name="description" id="edit-mi-description" rows="2" class="w-full bg-[var(--bg)] border border-[var(--border)] rounded-xl px-4 py-2.5 text-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="flex items-center gap-3 pt-3 border-t border-[var(--border)]">
                    <button type="button" onclick="closeModal('modal-edit-modalitem')" class="flex-1 bg-black/5 dark:bg-white/5 hover:bg-black/10 dark:bg-white/10 text-gray-400 dark:text-gray-600 py-2.5 rounded-xl text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-indigo-600/20 cursor-pointer">Update Item</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ====================================================
         SCRIPTS
    ==================================================== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // ---- VIEWS CHART INIT ----
        let viewsChartInstance = null;
        function initViewsChart() {
            const ctx = document.getElementById('viewsChart');
            if (!ctx) return;
            
            const isDark = document.documentElement.classList.contains('dark');
            const gridColor = isDark ? '#252C3D' : '#E5E7EB';
            const textColor = isDark ? '#9CA3AF' : '#6B7280';
            
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            if (viewsChartInstance) {
                viewsChartInstance.destroy();
            }

            viewsChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Pengunjung',
                        data: chartData,
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#1E40AF',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#3B82F6',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: isDark ? '#1E2330' : '#FFF',
                            titleColor: isDark ? '#FFF' : '#111827',
                            bodyColor: isDark ? '#D1D5DB' : '#4B5563',
                            borderColor: gridColor,
                            borderWidth: 1,
                            padding: 10,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Kunjungan';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { color: textColor, font: { size: 10 }, stepSize: 1 },
                            grid: { color: gridColor, drawBorder: false }
                        },
                        x: {
                            ticks: { color: textColor, font: { size: 10 } },
                            grid: { display: false, drawBorder: false }
                        }
                    },
                    interaction: { mode: 'index', intersect: false }
                }
            });
        }

        // ---- TAB SWITCHER ----
        function switchTab(tabId) {
            // Hide all panes
            document.querySelectorAll('.tab-pane').forEach(el => {
                el.classList.add('hidden');
            });
            // Show target pane
            const pane = document.getElementById('tab-' + tabId);
            if (pane) { pane.classList.remove('hidden'); }

            // Toggle dashboard stats and inner tab navigation
            const stats = document.getElementById('dashboard-stats');
            const innerTabNav = document.getElementById('inner-tab-navigation');
            
            if (tabId === 'dashboard') {
                if (stats) stats.classList.remove('hidden');
                if (innerTabNav) innerTabNav.classList.remove('hidden');
            } else if (tabId === 'portfolio' || tabId === 'general' || tabId === 'news' || tabId === 'content') {
                if (stats) stats.classList.add('hidden');
                if (innerTabNav) innerTabNav.classList.remove('hidden');
            } else {
                if (stats) stats.classList.add('hidden');
                if (innerTabNav) innerTabNav.classList.add('hidden');
            }

            // Update tab buttons (top tabs)
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.add('text-gray-500', 'dark:text-gray-400');
                btn.classList.remove('text-blue-400', 'text-pink-400');
            });
            const activeTabBtn = document.getElementById('tab-btn-' + tabId);
            if (activeTabBtn) {
                activeTabBtn.classList.add('active');
                activeTabBtn.classList.remove('text-gray-500', 'dark:text-gray-400');
                const colorMap = { portfolio: 'text-blue-400', general: 'text-sky-400', news: 'text-pink-400', content: 'text-amber-400' };
                activeTabBtn.classList.add(colorMap[tabId] || 'text-blue-400');
            }

            // Update sidebar links
            document.querySelectorAll('[id^="sidelink-"]').forEach(el => {
                el.classList.remove('active', 'text-gray-900', 'dark:text-white');
                el.classList.add('text-gray-500', 'dark:text-gray-400');
            });
            const activeSideLink = document.getElementById('sidelink-' + tabId);
            if (activeSideLink) { 
                activeSideLink.classList.remove('text-gray-500', 'dark:text-gray-400');
                activeSideLink.classList.add('active', 'text-gray-900', 'dark:text-white');
            }

            // Update page title
            const titles = { portfolio: 'Kelola Portofolio', general: 'Kelola Berita Umum', news: 'Kelola Instagram News', content: 'Edit Konten Teks Landing Page', modal: 'Kelola Item Layanan (Modal)' };
            const titleEl = document.getElementById('page-title');
            if (titleEl && titles[tabId]) titleEl.textContent = titles[tabId];
            else if (titleEl && tabId === 'dashboard') titleEl.textContent = 'Dashboard Konten';

            // Save to localStorage
            localStorage.setItem('admin_nustech_tab', tabId);
        }

        // Restore saved tab on load
        window.addEventListener('DOMContentLoaded', () => {
            const saved = localStorage.getItem('admin_nustech_tab');
            if (saved && (document.getElementById('tab-' + saved) || saved === 'dashboard')) {
                switchTab(saved);
            } else {
                switchTab('dashboard');
            }
            // Auto-dismiss toast after 5 seconds
            const toast = document.getElementById('toast');
            if (toast) { setTimeout(() => toast.remove(), 5000); }
        });

        // ---- MODAL OPEN/CLOSE ----
        function openModal(id) {
            const m = document.getElementById(id);
            if (!m) return;
            m.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            const m = document.getElementById(id);
            if (!m) return;
            m.classList.add('hidden');
            document.body.style.overflow = '';
        }
        // Close modal on backdrop click
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            });
        });

        // ---- EDIT PORTFOLIO MODAL ----
        function openEditPortfolioModal(id, title, category, description) {
            document.getElementById('edit-portfolio-title').value    = title;
            document.getElementById('edit-portfolio-category').value = category || '';
            document.getElementById('edit-portfolio-description').value = description || '';
            document.getElementById('form-edit-portfolio').action = `/admin/home/portfolio/${id}`;
            openModal('modal-edit-portfolio');
        }

        // ---- EDIT NEWS MODAL ----
        function openEditNewsModal(id, title, url, caption, date) {
            document.getElementById('edit-news-title').value   = title;
            document.getElementById('edit-news-url').value     = url || '';
            document.getElementById('edit-news-caption').value = caption || '';
            document.getElementById('edit-news-date').value    = date || '';
            document.getElementById('form-edit-news').action   = `/admin/home/news/${id}`;
            openModal('modal-edit-news');
        }

        // ---- EDIT GENERAL NEWS MODAL ----
        function openEditGeneralNewsModal(id, title, caption, date) {
            document.getElementById('edit-general-news-title').value   = title;
            document.getElementById('edit-general-news-caption').value = caption || '';
            document.getElementById('edit-general-news-date').value    = date || '';
            document.getElementById('form-edit-general-news').action   = `/admin/home/news/${id}`;
            openModal('modal-edit-general-news');
        }

        // ---- EDIT MODAL ITEM MODAL ----
        function openEditModalItemModal(id, title, year, client, description) {
            document.getElementById('edit-mi-title').value = title;
            document.getElementById('edit-mi-year').value = year || '';
            document.getElementById('edit-mi-client').value = client || '';
            document.getElementById('edit-mi-description').value = description || '';
            document.getElementById('form-edit-modalitem').action = `/admin/home/modal-items/${id}`;
            openModal('modal-edit-modalitem');
        }

        // ---- LIVE CLOCK ----
        function updateClock() {
            const el = document.getElementById('live-clock');
            if (!el) return;
            const now = new Date();
            const hh  = String(now.getHours()).padStart(2, '0');
            const mm  = String(now.getMinutes()).padStart(2, '0');
            const ss  = String(now.getSeconds()).padStart(2, '0');
            el.textContent = `${hh}:${mm}:${ss}`;
        }
        updateClock();
        setInterval(updateClock, 1000);

        // ---- THEME TOGGLE ----
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('admin_theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('admin_theme', 'dark');
            }
            // Re-render chart to match theme
            if (typeof initViewsChart === 'function') {
                initViewsChart();
            }
        }

        // Initialize theme based on localStorage
        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('admin_theme');
            const html = document.documentElement;
            if (savedTheme === 'light') {
                html.classList.remove('dark');
            } else if (savedTheme === 'dark') {
                html.classList.add('dark');
            }
            
            // Init Chart after theme is set
            setTimeout(() => {
                initViewsChart();
            }, 100);
        });

        // ---- SIDEBAR TOGGLE (MOBILE) ----
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
