<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  @include('partials.pwa-head')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CV. Nustech – Solusi IT, Pengadaan & Engineering NTB</title>
  <meta name="description" content="CV. Nustech – Penyedia solusi teknologi informasi, pengadaan barang, kelistrikan, dan engineering terpercaya di Nusa Tenggara Barat.">

  <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Swiper.js CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Tailwind CSS Play CDN (v3) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
            heading: ['Outfit', 'sans-serif'],
          },
          colors: {
            dark: {
              950: '#020817',
              900: '#0a1628',
              850: '#0d1b3e',
              800: '#1a2744',
              750: '#243352',
            },
            brand: {
              50:  '#f0f9ff',
              100: '#e0f2fe',
              400: '#38bdf8',
              500: '#0ea5e9',
              600: '#0284c7',
              700: '#0369a1',
              900: '#0c4a6e',
              950: '#082f49',
            }
          },
          animation: {
            'pulse-slow':   'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
            'float':        'float 6s ease-in-out infinite',
            'float-slow':   'float 8s ease-in-out infinite',
            'float-fast':   'float 4s ease-in-out infinite',
            'spin-slow':    'spin 20s linear infinite',
            'marquee':      'marquee 35s linear infinite',
            'marquee2':     'marquee2 35s linear infinite',
            'fade-up':      'fadeUp 0.8s ease forwards',
            'glow':         'glow 3s ease-in-out infinite',
          }
        }
      }
    }
  </script>

  <style type="text/tailwindcss">
    @layer utilities {
      .glass {
        background: rgba(255, 255, 255, 0.06);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.10);
      }
      .glass-card {
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.08);
      }
      .glass-white {
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.5);
      }
      .text-glow {
        text-shadow: 0 0 40px rgba(14, 165, 233, 0.6), 0 0 80px rgba(14,165,233,0.2);
      }
      .text-glow-soft {
        text-shadow: 0 0 30px rgba(14, 165, 233, 0.3);
      }
      .tab-btn-active {
        background: linear-gradient(135deg, #0ea5e9, #06b6d4) !important;
        color: #fff !important;
        box-shadow: 0 4px 20px rgba(14,165,233,0.40);
        border-color: transparent !important;
      }
      .tab-btn-active i { color: #fff !important; }
      .layanan-tab-btn { color: #475569; }
      .layanan-tab-btn.tab-btn-active {
        background: linear-gradient(135deg, #0ea5e9, #06b6d4) !important;
        color: #fff !important;
        border-color: transparent !important;
      }
      .hero-gradient {
        background: linear-gradient(135deg, rgba(2,8,23,0.88) 0%, rgba(8,47,73,0.70) 45%, rgba(2,8,23,0.85) 100%);
      }
      .section-gradient-1 {
        background: linear-gradient(180deg, #f8faff 0%, #f0f6ff 100%);
      }
      .card-hover {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }
      .card-hover:hover {
        transform: translateY(-6px);
      }
      .shimmer {
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.08) 50%, transparent 100%);
        background-size: 200% 100%;
        animation: shimmer 2.5s infinite;
      }
      .neon-border {
        box-shadow: 0 0 0 1px rgba(14,165,233,0.3), 0 0 20px rgba(14,165,233,0.1);
      }
      .neon-border:hover {
        box-shadow: 0 0 0 1px rgba(14,165,233,0.6), 0 0 30px rgba(14,165,233,0.2);
      }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-16px) rotate(2deg); }
    }
    @keyframes marquee {
      0%   { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    @keyframes marquee2 {
      0%   { transform: translateX(50%); }
      100% { transform: translateX(0); }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(30px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes glow {
      0%, 100% { opacity: 0.5; }
      50% { opacity: 1; }
    }
    @keyframes shimmer {
      0% { background-position: -200% 0; }
      100% { background-position: 200% 0; }
    }
    @keyframes orbit {
      from { transform: rotate(0deg) translateX(90px) rotate(0deg); }
      to   { transform: rotate(360deg) translateX(90px) rotate(-360deg); }
    }
    @keyframes orbit2 {
      from { transform: rotate(120deg) translateX(110px) rotate(-120deg); }
      to   { transform: rotate(480deg) translateX(110px) rotate(-480deg); }
    }
    @keyframes orbit3 {
      from { transform: rotate(240deg) translateX(130px) rotate(-240deg); }
      to   { transform: rotate(600deg) translateX(130px) rotate(-600deg); }
    }

    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .modal-backdrop {
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
    }

    .layanan-tab-btn {
      transition: all 0.25s ease;
      border: 1px solid #e2e8f0;
      background: #fff;
    }
    .layanan-tab-btn:hover:not(.tab-btn-active) {
      border-color: #bae6fd;
      background: #f0f9ff;
      color: #0369a1;
      transform: translateY(-1px);
    }

    .marquee-wrap {
      -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
      mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
    }

    /* Reveal */
    .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity: 0; transform: translateX(-40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right { opacity: 0; transform: translateX(40px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }

    /* Accordion */
    details[open] > summary .acc-arrow { transform: rotate(180deg); }
    .acc-arrow { transition: transform 0.3s ease; }

    /* Number gradient */
    .gradient-number {
      background: linear-gradient(135deg, #0ea5e9, #06b6d4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Feature icon ring */
    .icon-ring {
      position: relative;
    }
    .icon-ring::before {
      content: '';
      position: absolute;
      inset: -4px;
      border-radius: inherit;
      background: linear-gradient(135deg, rgba(14,165,233,0.3), rgba(6,182,212,0.15));
      z-index: -1;
    }

    /* Swiper Coverflow Custom Styles */
    .portfolioSwiper {
      width: 100%;
      padding-top: 40px !important;
      padding-bottom: 50px !important;
    }
    .portfolioSwiper .swiper-wrapper {
      transition-timing-function: cubic-bezier(0.19, 1, 0.22, 1) !important;
    }
    .portfolioSwiper .swiper-slide {
      width: 320px;
      transition: opacity 1.2s cubic-bezier(0.19, 1, 0.22, 1), filter 1.2s cubic-bezier(0.19, 1, 0.22, 1) !important;
      opacity: 0.3;
      filter: blur(2px) saturate(0.5);
    }
    .portfolioSwiper .swiper-slide-prev,
    .portfolioSwiper .swiper-slide-next {
      opacity: 0.7;
      filter: blur(0.5px) saturate(0.8);
    }
    .portfolioSwiper .swiper-slide-active {
      opacity: 1 !important;
      filter: blur(0px) saturate(1);
      box-shadow: 0 25px 50px rgba(14, 165, 233, 0.3), 0 0 0 1px rgba(14, 165, 233, 0.15);
      z-index: 10;
    }

    .portfolioSwiper .swiper-pagination-bullet {
      background: rgba(255, 255, 255, 0.3) !important;
      width: 8px;
      height: 8px;
      transition: all 0.3s ease;
    }
    .portfolioSwiper .swiper-pagination-bullet-active {
      background: #0ea5e9 !important;
      width: 24px;
      border-radius: 4px;
    }

    /* Lightbox Zoom Animation */
    @keyframes lightboxZoomIn {
      from { transform: scale(0.7) translateY(30px); opacity: 0; }
      to   { transform: scale(1) translateY(0); opacity: 1; }
    }
    @keyframes lightboxZoomOut {
      from { transform: scale(1) translateY(0); opacity: 1; }
      to   { transform: scale(0.7) translateY(30px); opacity: 0; }
    }
    .lightbox-zoom-in {
      animation: lightboxZoomIn 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .lightbox-zoom-out {
      animation: lightboxZoomOut 0.35s cubic-bezier(0.55, 0, 1, 0.45) forwards;
    }
  </style>
</head>

<body class="font-sans text-slate-800 bg-slate-50 overflow-x-hidden">

  <!-- ======================================================
       NAVBAR
  ====================================================== -->
  <nav id="navbar" class="fixed top-0 left-0 right-0 w-full z-50 transition-all duration-500 py-4">
    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8">
      <div id="navCapsule" class="mx-auto max-w-5xl rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-lg px-6 py-2.5 transition-all duration-500 flex items-center justify-between">

        <!-- Logo & Brand Toggle -->
        <div class="relative" id="logoDropdownWrapper">
          <button id="logoToggle" class="flex items-center gap-2.5 focus:outline-none cursor-pointer group py-1">
            <div class="relative">
              <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo CV. Nustech" class="h-9 w-9 rounded-full shadow-lg transition-transform duration-700 group-hover:rotate-[360deg] border-2 border-white/30">
              <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <span class="text-white font-heading font-extrabold text-lg tracking-tight transition-colors duration-300" id="navBrandText">NUSTECH</span>
            <svg class="w-3.5 h-3.5 text-white/70 transition-transform duration-300 ml-0.5" id="logoArrow" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- DROPDOWN LOGIN -->
          <div id="loginDropdownMenu" class="absolute left-0 mt-4 hidden opacity-0 translate-y-[-10px] transition-all duration-300 w-[340px] bg-white backdrop-blur-2xl rounded-3xl border border-slate-200/80 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.2)] overflow-hidden" style="z-index: 100;">
            <!-- Top gradient accent -->
            <div class="h-1 bg-gradient-to-r from-sky-500 via-cyan-400 to-sky-600"></div>

            <!-- Header -->
            <div class="px-5 pt-5 pb-3">
              <div class="flex items-center gap-2.5 mb-1">
                <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 flex items-center justify-center shadow-md shadow-sky-500/20">
                  <i class="fa-solid fa-right-to-bracket text-white text-[10px]"></i>
                </div>
                <div>
                  <h4 class="text-xs font-extrabold text-slate-800 tracking-tight">Portal Login</h4>
                  <p class="text-[9px] text-slate-400 font-medium">Pilih sistem yang ingin diakses</p>
                </div>
              </div>
            </div>

            <!-- Divider -->
            <div class="mx-5 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>

            <!-- Portal Items -->
            <div class="p-3 flex flex-col gap-2">
              <!-- MNS Nustech -->
              <a href="http://mns.nustech.co.id/login" target="_blank" class="relative flex items-center gap-4 p-4 rounded-2xl border border-slate-100 hover:border-sky-200 bg-gradient-to-r from-white to-slate-50/50 hover:from-sky-50/80 hover:to-cyan-50/40 transition-all duration-400 group hover:shadow-lg hover:shadow-sky-100/50 hover:-translate-y-0.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center text-xl group-hover:from-sky-500 group-hover:to-cyan-500 group-hover:text-white transition-all duration-500 group-hover:scale-105 shadow-sm group-hover:shadow-lg group-hover:shadow-sky-500/25 shrink-0">
                  <i class="fa-solid fa-chart-line"></i>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-bold text-slate-800 group-hover:text-sky-700 transition-colors flex items-center gap-2">
                    MNS Nustech
                    <span class="text-[8px] font-extrabold uppercase tracking-widest bg-sky-500/10 text-sky-600 px-2 py-0.5 rounded-full border border-sky-500/15">Portal</span>
                  </div>
                  <div class="text-[11px] text-slate-400 mt-0.5 font-medium">Monitoring & Network System</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-sky-500 flex items-center justify-center transition-all duration-300 shrink-0 group-hover:shadow-md group-hover:shadow-sky-500/20">
                  <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-white transition-colors group-hover:translate-x-0.5 transform duration-300"></i>
                </div>
              </a>

              <!-- Engineering -->
              <a href="http://enginering.nustech.co.id/login" target="_blank" class="relative flex items-center gap-4 p-4 rounded-2xl border border-slate-100 hover:border-orange-200 bg-gradient-to-r from-white to-slate-50/50 hover:from-orange-50/80 hover:to-amber-50/40 transition-all duration-400 group hover:shadow-lg hover:shadow-orange-100/50 hover:-translate-y-0.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 flex items-center justify-center text-xl group-hover:from-orange-500 group-hover:to-amber-500 group-hover:text-white transition-all duration-500 group-hover:scale-105 shadow-sm group-hover:shadow-lg group-hover:shadow-orange-500/25 shrink-0">
                  <i class="fa-solid fa-gears"></i>
                </div>
                <div class="flex-1 min-w-0">
                  <div class="text-sm font-bold text-slate-800 group-hover:text-orange-700 transition-colors flex items-center gap-2">
                    Engineering
                    <span class="text-[8px] font-extrabold uppercase tracking-widest bg-orange-500/10 text-orange-600 px-2 py-0.5 rounded-full border border-orange-500/15">Inventory</span>
                  </div>
                  <div class="text-[11px] text-slate-400 mt-0.5 font-medium">Engineering Inventory System</div>
                </div>
                <div class="w-8 h-8 rounded-xl bg-slate-100 group-hover:bg-orange-500 flex items-center justify-center transition-all duration-300 shrink-0 group-hover:shadow-md group-hover:shadow-orange-500/20">
                  <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-white transition-colors group-hover:translate-x-0.5 transform duration-300"></i>
                </div>
              </a>
            </div>

            <!-- Footer -->
            <div class="mx-5 h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent"></div>
            <div class="px-5 py-3 flex items-center justify-center gap-1.5">
              <i class="fa-solid fa-lock text-[8px] text-slate-300"></i>
              <span class="text-[9px] text-slate-400 font-semibold">Koneksi aman & terenkripsi</span>
            </div>
          </div>
        </div>

        <!-- MENU DESKTOP -->
        <div class="hidden md:flex items-center space-x-1">
          <a href="#beranda" class="nav-link text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200">Beranda</a>
          <a href="#tentang" class="nav-link text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200">Tentang</a>
          <a href="#visimisi" class="nav-link text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200">Visi Misi</a>

          <div id="layananDropdown" class="relative">
            <button id="layananToggle" class="text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200 flex items-center gap-1 cursor-pointer focus:outline-none">
              Layanan
              <svg class="w-3 h-3 transition-transform duration-300" id="layananArrow" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- MEGA MENU -->
            <div id="layananMenu" class="fixed left-1/2 -translate-x-1/2 w-[90vw] max-w-4xl bg-white shadow-2xl rounded-3xl border border-slate-200/60 hidden opacity-0 translate-y-[-10px] transition-all duration-300 overflow-hidden mt-4" style="z-index: 100;">
              <div class="h-1 bg-gradient-to-r from-sky-500 via-cyan-400 to-sky-600"></div>
              <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                  <!-- Col 1 -->
                  <div>
                    <h4 class="text-xs font-extrabold text-sky-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                      <span class="w-1.5 h-4 rounded-full bg-gradient-to-b from-sky-400 to-cyan-500"></span> Layanan Utama
                    </h4>
                    <div class="flex flex-col gap-1">
                      <button onclick="showLayanan('networking')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-network-wired"></i></div>
                        <div><div class="text-xs font-bold text-slate-800">Networking</div><div class="text-[10px] text-slate-400">Jaringan & Mikrotik</div></div>
                      </button>
                      <button onclick="showLayanan('aplikasi')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-code"></i></div>
                        <div><div class="text-xs font-bold text-slate-800">Aplikasi</div><div class="text-[10px] text-slate-400">Web & Software</div></div>
                      </button>
                      <button onclick="showLayanan('reklame')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-palette"></i></div>
                        <div><div class="text-xs font-bold text-slate-800">Reklame</div><div class="text-[10px] text-slate-400">Promo & Percetakan</div></div>
                      </button>
                      <button onclick="showLayanan('kelistrikan')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-bolt"></i></div>
                        <div><div class="text-xs font-bold text-slate-800">Kelistrikan</div><div class="text-[10px] text-slate-400">Instalasi & Panel Listrik</div></div>
                      </button>
                    </div>
                  </div>

                  <!-- Col 2 -->
                  <div>
                    <h4 class="text-xs font-extrabold text-sky-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                      <span class="w-1.5 h-4 rounded-full bg-gradient-to-b from-sky-400 to-cyan-500"></span> Pendukung
                    </h4>
                    <div class="flex flex-col gap-1">
                      <button onclick="showLayanan('ac')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-snowflake"></i></div>
                        <div class="text-xs font-bold text-slate-800">Pendingin Ruangan (AC)</div>
                      </button>
                      <button onclick="showLayanan('komputer')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-print"></i></div>
                        <div class="text-xs font-bold text-slate-800">Komputer & Printer</div>
                      </button>
                      <button onclick="showLayanan('elektronik')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-tv"></i></div>
                        <div class="text-xs font-bold text-slate-800">Alat Elektronik</div>
                      </button>
                      <button onclick="showLayanan('kantor')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-sky-50 text-left transition duration-300 group">
                        <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-sm group-hover:bg-sky-500 group-hover:text-white transition duration-300 group-hover:scale-110"><i class="fa-solid fa-briefcase"></i></div>
                        <div class="text-xs font-bold text-slate-800">Peralatan Kantor</div>
                      </button>
                    </div>
                  </div>

                  <!-- Col 3 -->
                  <div class="bg-gradient-to-br from-sky-950 to-brand-900 p-5 rounded-2xl flex flex-col justify-between text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-400/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div>
                      <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-cyan-300 mb-3 text-lg">
                        <i class="fa-solid fa-headset"></i>
                      </div>
                      <h4 class="text-sm font-extrabold text-white mb-2">Butuh Konsultasi?</h4>
                      <p class="text-[11px] text-slate-300 leading-relaxed mb-4">Tim kami siap melayani kebutuhan konsultasi teknis terkait proyek IT dan pengadaan barang secara gratis.</p>
                    </div>
                    <div class="flex flex-col gap-2 relative z-10">
                      <a href="https://wa.me/6281332809923" target="_blank" class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-400 text-white py-2.5 px-4 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg shadow-emerald-900/30">
                        <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Kami
                      </a>
                      <a href="#kontak" class="text-center text-xs text-sky-300 hover:text-white font-bold transition">Lihat Kontak Lainnya →</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <a href="#gallery" class="nav-link text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200">Galeri</a>
          <a href="#news" class="nav-link text-white hover:text-sky-300 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-200">Berita</a>
          <a href="#kontak" class="ml-2 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-white text-xs font-bold px-5 py-2.5 rounded-full transition-all duration-300 shadow-lg shadow-sky-500/20 hover:shadow-sky-400/30 hover:scale-105">Kontak</a>
        </div>

        <!-- Hamburger (Mobile) -->
        <div class="md:hidden flex items-center">
          <button id="menu-toggle" type="button" class="focus:outline-none p-2 -mr-2 cursor-pointer">
            <svg id="hamburgerIcon" class="w-6 h-6 text-white pointer-events-none transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

      </div>
    </div>

    <!-- MOBILE MENU -->
    <div id="mobile-menu" class="md:hidden hidden mx-4 mt-3 bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transition-all duration-300 p-5">
      <div class="flex flex-col gap-1.5">
        <a href="#beranda" class="mobile-nav-link p-3 rounded-xl hover:bg-sky-50 hover:text-sky-600 font-semibold transition-colors flex items-center gap-2.5"><i class="fa-solid fa-house text-sky-400 text-sm w-4"></i>Beranda</a>
        <a href="#tentang" class="mobile-nav-link p-3 rounded-xl hover:bg-sky-50 hover:text-sky-600 font-semibold transition-colors flex items-center gap-2.5"><i class="fa-solid fa-building text-sky-400 text-sm w-4"></i>Tentang Kami</a>
        <a href="#visimisi" class="mobile-nav-link p-3 rounded-xl hover:bg-sky-50 hover:text-sky-600 font-semibold transition-colors flex items-center gap-2.5"><i class="fa-solid fa-bullseye text-sky-400 text-sm w-4"></i>Visi & Misi</a>

        <!-- Mobile Layanan -->
        <div class="rounded-xl overflow-hidden bg-slate-50/80 border border-slate-100">
          <button onclick="document.getElementById('mobileLayananMenu').classList.toggle('hidden'); document.getElementById('mobileLayananArrow').classList.toggle('rotate-180')" class="w-full flex items-center justify-between p-3 text-left font-semibold text-slate-700 focus:outline-none">
            <span class="flex items-center gap-2.5"><i class="fa-solid fa-concierge-bell text-sky-400 text-sm w-4"></i>Layanan</span>
            <svg id="mobileLayananArrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="mobileLayananMenu" class="hidden flex flex-col bg-white border-t border-slate-100 py-1.5 px-3">
            <button onclick="showLayanan('networking')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Networking</button>
            <button onclick="showLayanan('aplikasi')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Aplikasi</button>
            <button onclick="showLayanan('reklame')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Reklame</button>
            <button onclick="showLayanan('kelistrikan')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Kelistrikan</button>
            <button onclick="showLayanan('ac')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Pendingin Ruangan (AC)</button>
            <button onclick="showLayanan('komputer')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Komputer & Printer</button>
            <button onclick="showLayanan('elektronik')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Alat Elektronik</button>
            <button onclick="showLayanan('kantor')" class="w-full text-left p-2.5 text-sm font-medium text-slate-600 hover:text-sky-600 transition-colors">Peralatan Kantor</button>
          </div>
        </div>

        <!-- Mobile Login -->
        <div class="rounded-2xl overflow-hidden bg-slate-50/80 border border-slate-100">
          <button onclick="document.getElementById('mobileLoginMenu').classList.toggle('hidden'); document.getElementById('mobileLoginArrow').classList.toggle('rotate-180')" class="w-full flex items-center justify-between p-3.5 text-left font-semibold text-slate-700 focus:outline-none">
            <span class="flex items-center gap-2.5">
              <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-right-to-bracket text-white text-[9px]"></i>
              </div>
              <div>
                <span class="text-sm font-bold text-slate-800">Login Portal</span>
                <span class="block text-[9px] text-slate-400 font-medium -mt-0.5">Pilih sistem yang ingin diakses</span>
              </div>
            </span>
            <svg id="mobileLoginArrow" class="w-4 h-4 transition-transform duration-300 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="mobileLoginMenu" class="hidden flex flex-col bg-white border-t border-slate-100 p-2.5 gap-2">
            <a href="http://mns.nustech.co.id/login" target="_blank" class="flex items-center gap-3.5 p-3.5 rounded-xl border border-slate-100 hover:border-sky-200 hover:bg-sky-50/60 transition-all duration-300 group">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center text-lg shrink-0 group-active:from-sky-500 group-active:to-cyan-500 group-active:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-slate-800 flex items-center gap-2">
                  MNS Nustech
                  <span class="text-[7px] font-extrabold uppercase tracking-widest bg-sky-500/10 text-sky-600 px-1.5 py-0.5 rounded-full border border-sky-500/15">Portal</span>
                </div>
                <div class="text-[10px] text-slate-400 mt-0.5 font-medium">Monitoring & Network System</div>
              </div>
              <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-arrow-right text-[9px] text-slate-400"></i>
              </div>
            </a>
            <a href="http://enginering.nustech.co.id/login" target="_blank" class="flex items-center gap-3.5 p-3.5 rounded-xl border border-slate-100 hover:border-orange-200 hover:bg-orange-50/60 transition-all duration-300 group">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 flex items-center justify-center text-lg shrink-0 group-active:from-orange-500 group-active:to-amber-500 group-active:text-white transition-all duration-300 shadow-sm">
                <i class="fa-solid fa-gears"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-slate-800 flex items-center gap-2">
                  Engineering
                  <span class="text-[7px] font-extrabold uppercase tracking-widest bg-orange-500/10 text-orange-600 px-1.5 py-0.5 rounded-full border border-orange-500/15">Inventory</span>
                </div>
                <div class="text-[10px] text-slate-400 mt-0.5 font-medium">Engineering Inventory System</div>
              </div>
              <div class="w-7 h-7 rounded-lg bg-slate-100 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-arrow-right text-[9px] text-slate-400"></i>
              </div>
            </a>
            <div class="flex items-center justify-center gap-1.5 pt-1 pb-0.5">
              <i class="fa-solid fa-lock text-[7px] text-slate-300"></i>
              <span class="text-[8px] text-slate-400 font-semibold">Koneksi aman & terenkripsi</span>
            </div>
          </div>
        </div>

        <a href="#gallery" class="mobile-nav-link p-3 rounded-xl hover:bg-sky-50 hover:text-sky-600 font-semibold transition-colors flex items-center gap-2.5"><i class="fa-solid fa-images text-sky-400 text-sm w-4"></i>Galeri</a>
        <a href="#news" class="mobile-nav-link p-3 rounded-xl hover:bg-sky-50 hover:text-sky-600 font-semibold transition-colors flex items-center gap-2.5"><i class="fa-brands fa-instagram text-sky-400 text-sm w-4"></i>Berita</a>
        <a href="#kontak" class="mt-1 bg-gradient-to-r from-sky-500 to-cyan-500 text-white font-bold text-sm py-3 px-5 rounded-xl text-center transition shadow-lg">Kontak Kami</a>
      </div>
    </div>
  </nav>

  <!-- ======================================================
       HERO SECTION
  ====================================================== -->
  <section id="beranda" class="w-full min-h-screen flex items-center justify-center relative overflow-hidden bg-dark-950">

    <!-- Background Video -->
    <video class="absolute inset-0 w-full h-full object-cover z-0" autoplay muted loop playsinline poster="{{ asset('assets/img/hero-satellite.jpg') }}">
      <source src="{{ asset('assets/video/videobackgroundweb.mp4') }}" type="video/mp4">
    </video>

    <!-- Multi-layer overlays -->
    <div class="hero-gradient absolute inset-0 z-1"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-dark-950/80 via-transparent to-dark-950/90 z-2"></div>

    <!-- Animated grid -->
    <div class="absolute inset-0 opacity-[0.04] z-3" style="background-image: linear-gradient(rgba(14,165,233,0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(14,165,233,0.15) 1px, transparent 1px); background-size: 60px 60px;"></div>

    <!-- Glowing orbs -->
    <div class="absolute top-1/4 left-1/6 w-72 h-72 bg-sky-600/10 rounded-full blur-3xl z-3 animate-pulse-slow"></div>
    <div class="absolute bottom-1/3 right-1/5 w-96 h-96 bg-cyan-500/8 rounded-full blur-3xl z-3 animate-pulse-slow" style="animation-delay:2s;"></div>
    <div class="absolute top-2/3 left-1/2 w-64 h-64 bg-brand-600/10 rounded-full blur-3xl z-3 animate-pulse-slow" style="animation-delay:4s;"></div>

    <!-- Floating particles -->
    <div class="absolute inset-0 z-4 overflow-hidden pointer-events-none">
      <div class="absolute w-1.5 h-1.5 bg-sky-400/50 rounded-full animate-float" style="left:8%;top:28%;"></div>
      <div class="absolute w-2 h-2 bg-cyan-300/30 rounded-full animate-float-slow" style="left:18%;top:62%;animation-delay:1s;"></div>
      <div class="absolute w-1 h-1 bg-white/40 rounded-full animate-float-fast" style="left:35%;top:20%;animation-delay:0.5s;"></div>
      <div class="absolute w-2.5 h-2.5 bg-sky-300/20 rounded-full animate-float" style="left:60%;top:72%;animation-delay:2s;"></div>
      <div class="absolute w-1.5 h-1.5 bg-white/25 rounded-full animate-float-slow" style="left:72%;top:18%;animation-delay:1.5s;"></div>
      <div class="absolute w-1 h-1 bg-cyan-400/40 rounded-full animate-float" style="left:88%;top:55%;animation-delay:3s;"></div>
      <div class="absolute w-2 h-2 bg-sky-200/20 rounded-full animate-float-fast" style="left:45%;top:82%;animation-delay:0.8s;"></div>
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 text-center px-6 w-full max-w-[95%] 2xl:max-w-[85%] mx-auto flex flex-col items-center">

      <!-- Live Badge -->
      <div class="inline-flex items-center gap-2.5 glass px-5 py-2 rounded-full text-xs font-bold text-sky-200 mb-10 shadow-lg tracking-widest uppercase">
        <span class="relative flex h-2.5 w-2.5">
          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
        </span>
        {{ $content['hero_badge'] ?? 'Professional Technology Solutions · Since 2014' }}
      </div>

      <!-- Main Heading -->
      <h1 class="text-5xl sm:text-7xl md:text-8xl lg:text-[7rem] font-heading font-black tracking-tight text-white leading-[0.95] text-glow mb-5">
      <span class="bg-gradient-to-r from-sky-300 via-cyan-200 to-sky-400 bg-clip-text text-transparent">{{ $content['hero_title'] ?? 'NUSTECH' }}</span>
      </h1>

      <p class="text-sm sm:text-base text-sky-200/80 font-bold tracking-[0.3em] mb-5 uppercase">
        {{ $content['hero_subtitle'] ?? 'Nusa Tenggara Barat' }}
      </p>

      <!-- Divider -->
      <div class="flex items-center gap-4 mb-7">
        <div class="h-px w-16 bg-gradient-to-r from-transparent to-sky-400/50"></div>
        <div class="w-1.5 h-1.5 rounded-full bg-sky-400/60"></div>
        <div class="h-px w-16 bg-gradient-to-l from-transparent to-sky-400/50"></div>
      </div>

      <p class="text-sm sm:text-lg text-slate-300/80 max-w-2xl mb-12 leading-relaxed font-light">
        {{ $content['hero_description'] ?? 'Solusi Teknologi Informasi, Komunikasi, dan Pengadaan Barang Terpercaya & Handal.' }}<br>
        <span class="text-sky-300/70 text-xs font-semibold tracking-widest mt-2 block">{{ $content['hero_keywords'] ?? 'Jaringan · VSAT · Kelistrikan · Reklame · Aplikasi' }}</span>
      </p>

      <!-- CTA Buttons -->
      <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-center justify-center w-full px-4 sm:px-0">
        <a href="#tentang" class="group flex items-center justify-center gap-2.5 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-white font-bold px-6 sm:px-8 py-3.5 sm:py-4 rounded-full shadow-2xl shadow-sky-500/30 hover:shadow-sky-400/40 hover:-translate-y-0.5 transition-all duration-300 text-sm w-full sm:w-auto">
          Tentang Kami
          <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform duration-300"></i>
        </a>
        <a href="#layanan" class="group flex items-center justify-center gap-2.5 glass hover:bg-white/10 text-white font-bold px-6 sm:px-8 py-3.5 sm:py-4 rounded-full hover:border-sky-400/40 transition-all duration-300 text-sm hover:-translate-y-0.5 w-full sm:w-auto">
          <i class="fa-solid fa-concierge-bell text-xs text-sky-300 group-hover:scale-110 transition-transform"></i>
          Layanan Kami
        </a>
        <a href="https://wa.me/{{ $content['hero_whatsapp'] ?? '6281332809923' }}" target="_blank" class="group flex items-center justify-center gap-2.5 bg-emerald-500/20 hover:bg-emerald-500 text-emerald-300 hover:text-white font-bold px-6 sm:px-8 py-3.5 sm:py-4 rounded-full border border-emerald-500/30 hover:border-emerald-400 transition-all duration-300 text-sm hover:-translate-y-0.5 w-full sm:w-auto">
          <i class="fa-brands fa-whatsapp text-sm group-hover:scale-110 transition-transform"></i>
          WhatsApp
        </a>
      </div>

      <!-- Stats -->
      <div class="mt-10 sm:mt-16 grid grid-cols-3 gap-2 sm:gap-16 w-full max-w-lg">
        <div class="text-center group">
          <div class="text-3xl sm:text-5xl font-heading font-black text-white text-glow-soft stat-number" data-count="{{ $content['hero_stat1_count'] ?? 50 }}">0+</div>
          <div class="text-[8px] sm:text-[10px] text-sky-300/60 font-bold uppercase tracking-widest mt-1 sm:mt-2">{{ $content['hero_stat1_label'] ?? 'Proyek Selesai' }}</div>
        </div>
        <div class="text-center border-x border-white/10 px-2 sm:px-4 group">
          <div class="text-3xl sm:text-5xl font-heading font-black text-white text-glow-soft stat-number" data-count="{{ $content['hero_stat2_count'] ?? 30 }}">0+</div>
          <div class="text-[8px] sm:text-[10px] text-sky-300/60 font-bold uppercase tracking-widest mt-1 sm:mt-2">{{ $content['hero_stat2_label'] ?? 'Klien Puas' }}</div>
        </div>
        <div class="text-center group">
          <div class="text-3xl sm:text-5xl font-heading font-black text-white text-glow-soft stat-number" data-count="{{ $content['hero_stat3_count'] ?? 8 }}">0+</div>
          <div class="text-[8px] sm:text-[10px] text-sky-300/60 font-bold uppercase tracking-widest mt-1 sm:mt-2">{{ $content['hero_stat3_label'] ?? 'Bidang Layanan' }}</div>
        </div>
      </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10 flex flex-col items-center gap-2">
      <span class="text-[9px] text-white/30 tracking-widest uppercase font-bold">Scroll</span>
      <div class="w-5 h-9 border border-white/20 rounded-full flex justify-center pt-1.5">
        <div class="w-1 h-2 bg-gradient-to-b from-sky-400 to-transparent rounded-full animate-bounce"></div>
      </div>
    </div>

    <!-- Bottom wave -->
    <div class="absolute bottom-0 left-0 w-full z-10">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16 fill-slate-50">
        <path d="M0,40 C240,75 480,10 720,50 C960,90 1200,20 1440,45 L1440,80 L0,80 Z"/>
      </svg>
    </div>
  </section>

  <!-- ======================================================
       TENTANG KAMI SECTION
  ====================================================== -->
  <section id="tentang" class="relative py-24 sm:py-32 overflow-hidden" style="background: linear-gradient(180deg,#f8faff 0%, #f0f6ff 60%, #ffffff 100%);">

    <!-- Decorative blobs -->
    <div class="absolute top-0 left-0 w-[600px] h-[600px] bg-sky-100/50 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-cyan-100/40 rounded-full blur-3xl translate-x-1/3 translate-y-1/3 pointer-events-none"></div>
    <div class="absolute top-1/2 right-1/4 w-48 h-48 bg-orange-100/30 rounded-full blur-2xl pointer-events-none"></div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 lg:gap-20 items-center">

        <!-- Left: Image -->
        <div class="relative flex justify-center reveal-left">
          <!-- Background decoration -->
          <div class="absolute -inset-8 bg-gradient-to-tr from-sky-400/10 via-cyan-300/5 to-orange-300/10 rounded-[3rem] blur-3xl pointer-events-none"></div>

          <div class="relative w-full max-w-md">
            <!-- Decorative frame top-left -->
            <div class="absolute -top-4 -left-4 w-24 h-24 border-t-4 border-l-4 border-sky-400/50 rounded-tl-3xl"></div>
            <!-- Decorative frame bottom-right -->
            <div class="absolute -bottom-4 -right-4 w-24 h-24 border-b-4 border-r-4 border-cyan-400/50 rounded-br-3xl"></div>

            <!-- Glow shadow -->
            <div class="absolute inset-3 bg-gradient-to-br from-sky-500/20 to-cyan-500/10 rounded-[2.5rem] blur-xl"></div>
            <img src="{{ asset('assets/img/tentangkami.png') }}" alt="Tentang CV. Nustech" class="relative w-full rounded-[2.5rem] shadow-2xl border border-white/60 object-cover hover:scale-[1.02] transition-transform duration-700">

            <!-- Floating badge 1 -->
            <div class="absolute -bottom-5 -right-5 bg-white rounded-2xl shadow-2xl p-4 border border-slate-100/80 flex items-center gap-3">
              <div class="w-11 h-11 bg-gradient-to-br from-sky-500 to-cyan-500 rounded-xl flex items-center justify-center text-white">
                <i class="fa-solid fa-shield-check text-lg"></i>
              </div>
              <div>
                <div class="text-xs font-black text-slate-800">Terpercaya</div>
                <div class="text-[10px] text-slate-400">ISO & SNI Compliant</div>
              </div>
            </div>

            <!-- Floating badge 2 -->
            <div class="absolute -top-5 -right-5 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl shadow-xl p-3.5 text-white flex items-center gap-2">
              <i class="fa-solid fa-star text-sm text-yellow-300"></i>
              <div>
                <div class="text-xs font-black">Sejak 2014</div>
                <div class="text-[9px] opacity-80">Berpengalaman</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Text -->
        <div class="space-y-7 reveal-right">

          <div class="inline-flex items-center gap-2 bg-sky-50 border border-sky-200/60 text-sky-600 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase">
            <i class="fa-solid fa-building text-[10px]"></i> Profil Perusahaan
          </div>

          <h2 class="text-4xl sm:text-5xl font-heading font-black text-slate-900 leading-tight">
            {{ $content['about_heading'] ?? 'Menghadirkan Solusi Teknologi Terintegrasi' }}
          </h2>

          <p class="text-slate-600 leading-relaxed text-base">
            {{ $content['about_desc1'] ?? 'CV. NUSTECH adalah perusahaan yang bergerak di bidang pengadaan barang dan jasa.' }}
          </p>

          <p class="text-slate-500 leading-relaxed text-sm">
            {{ $content['about_desc2'] ?? 'Komitmen kami adalah memberikan hasil yang presisi dan pelayanan prima.' }}
          </p>

          <!-- Feature Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div class="group flex items-center gap-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:border-sky-200 hover:shadow-md transition-all duration-300 card-hover">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-sky-50 to-sky-100 text-sky-600 flex items-center justify-center shrink-0 group-hover:from-sky-500 group-hover:to-cyan-500 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-certificate"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-800">Berpengalaman</div>
                <div class="text-[10px] text-slate-400">Sejak 2014 di NTB</div>
              </div>
            </div>
            <div class="group flex items-center gap-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:border-emerald-200 hover:shadow-md transition-all duration-300 card-hover">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 group-hover:from-emerald-500 group-hover:to-teal-500 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-handshake"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-800">Mitra Pemerintah</div>
                <div class="text-[10px] text-slate-400">Dinas & Instansi NTB</div>
              </div>
            </div>
            <div class="group flex items-center gap-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:border-orange-200 hover:shadow-md transition-all duration-300 card-hover">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-orange-50 to-amber-100 text-orange-500 flex items-center justify-center shrink-0 group-hover:from-orange-500 group-hover:to-amber-500 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-satellite-dish"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-800">VSAT & Fiber</div>
                <div class="text-[10px] text-slate-400">Jaringan 3T Indonesia</div>
              </div>
            </div>
            <div class="group flex items-center gap-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 hover:border-purple-200 hover:shadow-md transition-all duration-300 card-hover">
              <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-purple-50 to-violet-100 text-purple-600 flex items-center justify-center shrink-0 group-hover:from-purple-500 group-hover:to-violet-500 group-hover:text-white transition-all duration-500">
                <i class="fa-solid fa-headset"></i>
              </div>
              <div>
                <div class="text-xs font-bold text-slate-800">Support 24/7</div>
                <div class="text-[10px] text-slate-400">NOC & Teknisi Lapangan</div>
              </div>
            </div>
          </div>

          <div class="flex items-center gap-4 flex-wrap pt-1">
            <button onclick="openModal()" class="group inline-flex items-center gap-2.5 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-7 py-3.5 rounded-full shadow-lg hover:shadow-sky-500/25 transition-all duration-300">
              Pelajari Selengkapnya
              <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </button>
            <a href="https://wa.me/6281332809923" target="_blank" class="group inline-flex items-center gap-2 text-slate-600 hover:text-emerald-600 font-bold text-sm transition-colors">
              <div class="w-9 h-9 rounded-full bg-emerald-100 group-hover:bg-emerald-500 text-emerald-500 group-hover:text-white flex items-center justify-center transition-all duration-300">
                <i class="fa-brands fa-whatsapp text-base"></i>
              </div>
              Hubungi Kami
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- COMPANY MODAL -->
  <div id="modalTentang" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="modalTentangBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-building"></i></div>
          <h3 class="font-heading font-bold text-xl tracking-tight">Detail Profil CV. NUSTECH</h3>
        </div>
        <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="bg-gradient-to-br from-sky-50 to-cyan-50 p-5 rounded-2xl border border-sky-100">
          <h4 class="font-heading font-bold text-slate-800 text-lg mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-info text-sky-500"></i> Profil Perusahaan</h4>
          <div class="space-y-3 text-justify">
            <p>{{ $content['modal_about_p1'] ?? 'CV. NUSTECH didirikan sebagai respon atas cepatnya kemajuan teknologi informasi dan kelistrikan di Indonesia, khususnya kawasan Nusa Tenggara Barat.' }}</p>
            <p>{{ $content['modal_about_p2'] ?? 'Berpengalaman memelihara jaringan nirkabel serta pengadaan server kantor, kami selalu memprioritaskan kepuasan klien.' }}</p>
          </div>
        </div>
        <div class="bg-gradient-to-br from-slate-50 to-slate-100/50 p-5 rounded-2xl border border-slate-100">
          <h4 class="font-heading font-bold text-slate-800 text-lg mb-3 flex items-center gap-2"><i class="fa-solid fa-chess-rook text-sky-500"></i> Strategi Utama</h4>
          <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <li class="flex items-start gap-2.5">
              <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">1</span>
              <span>{{ $content['modal_strategy_1'] ?? 'Kualitas Terjamin: Pengerjaan infrastruktur sesuai standard industri.' }}</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">2</span>
              <span>{{ $content['modal_strategy_2'] ?? 'Inovasi Kontinu: Memakai modul hardware & software versi terkini.' }}</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">3</span>
              <span>{{ $content['modal_strategy_3'] ?? 'Sinergi Kemitraan: Menjalin kerja sama transparan jangka panjang.' }}</span>
            </li>
            <li class="flex items-start gap-2.5">
              <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-sky-500 to-cyan-500 text-white font-bold flex items-center justify-center text-[10px] shrink-0 mt-0.5">4</span>
              <span>{{ $content['modal_strategy_4'] ?? 'Kompetensi SDM: Teknisi lapangan dibekali sertifikasi keahlian.' }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- ======================================================
       PARTNER MARQUEE
  ====================================================== -->
  <section class="py-14 relative overflow-hidden" style="background: linear-gradient(135deg, #020817 0%, #0a1628 50%, #020817 100%);">
    <div class="absolute inset-0 opacity-5" style="background-image: linear-gradient(rgba(14,165,233,0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(14,165,233,0.2) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-sky-500/30 to-transparent"></div>
    <div class="absolute bottom-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-sky-500/20 to-transparent"></div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 mb-8 text-center reveal">
      <p class="text-[10px] text-sky-400/70 font-extrabold uppercase tracking-[0.3em]">
        <span class="inline-block w-8 h-px bg-sky-500/40 mr-3 align-middle"></span>
        Dipercaya oleh Instansi & Mitra di NTB
        <span class="inline-block w-8 h-px bg-sky-500/40 ml-3 align-middle"></span>
      </p>
    </div>

    <div class="flex flex-wrap justify-center gap-5 w-full max-w-4xl mx-auto px-4">
        @php
          $partners = [
            ['icon'=>'fa-solid fa-shield-halved','name'=>'POLDA NTB (RESKRIMSUS)','color'=>'blue'],
            ['icon'=>'fa-solid fa-building-shield','name'=>'BNNP NTB','color'=>'sky'],
          ];
        @endphp

        @foreach($partners as $p)
          <div class="inline-flex items-center gap-3 glass border border-white/8 rounded-2xl px-6 py-3.5 flex-shrink-0 hover:border-sky-500/30 transition-all duration-300 group">
            <div class="w-9 h-9 rounded-lg bg-white/5 text-white/70 flex items-center justify-center text-sm flex-shrink-0 group-hover:text-sky-300 transition-colors">
              <i class="{{ $p['icon'] }}"></i>
            </div>
            <span class="text-white/70 font-bold text-sm group-hover:text-white transition-colors">{{ $p['name'] }}</span>
          </div>
        @endforeach
      </div>
  </section>

  <!-- ======================================================
       VISI MISI SECTION
  ====================================================== -->
  <section id="visimisi" class="w-full relative py-24 sm:py-32 overflow-hidden" style="background: linear-gradient(135deg,#020817 0%, #0a1628 40%, #0d1b3e 70%, #020817 100%);">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-sky-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(255,255,255,0.1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 60px 60px;"></div>

    <!-- Top wave -->
    <div class="absolute top-0 left-0 w-full">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16" style="fill: #f0f6ff;">
        <path d="M0,40 C360,10 720,70 1080,30 C1260,10 1380,50 1440,40 L1440,0 L0,0 Z"/>
      </svg>
    </div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <!-- Section Title -->
      <div class="text-center mb-16 reveal">
        <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 text-sky-300 px-5 py-2 rounded-full text-xs font-bold tracking-widest uppercase mb-6">
          <i class="fa-solid fa-bullseye text-[10px] text-sky-400"></i> Visi & Misi
        </div>
        <h2 class="text-4xl sm:text-5xl font-heading font-black text-white text-glow-soft">{{ $content['visimisi_title'] ?? 'Komitmen & Arah Masa Depan' }}</h2>
        <p class="mt-4 text-slate-400/80 text-sm max-w-xl mx-auto leading-relaxed">{{ $content['visimisi_subtitle'] ?? 'Landasan nilai yang membimbing setiap langkah CV. NUSTECH menuju profesionalisme dan kepercayaan nasional.' }}</p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">

        <!-- VISI Card -->
        <div class="relative group reveal-left">
          <div class="absolute inset-0 bg-gradient-to-br from-sky-500/10 to-cyan-500/5 rounded-3xl blur-xl group-hover:from-sky-500/20 group-hover:to-cyan-500/10 transition-all duration-500"></div>
          <div class="relative bg-white/[0.04] backdrop-blur-md rounded-3xl p-8 border border-white/8 flex flex-col h-full hover:border-sky-500/30 transition-all duration-500 hover:bg-white/[0.07]">
            <!-- Header -->
            <div class="flex items-start gap-5 mb-8">
              <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-500/20 to-cyan-500/10 text-sky-300 flex items-center justify-center text-2xl border border-sky-500/20 shrink-0 group-hover:from-sky-500/30 group-hover:to-cyan-500/20 transition-all duration-500">
                <i class="fa-solid fa-eye"></i>
              </div>
              <div>
                <div class="inline-flex items-center gap-1.5 bg-sky-500/10 border border-sky-500/20 text-sky-400 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-2">Visi Perusahaan</div>
                <h3 class="text-3xl font-heading font-black text-white text-glow-soft">VISI</h3>
              </div>
            </div>

            <!-- Content -->
            <blockquote class="text-slate-300 leading-relaxed text-base italic text-justify flex-1 border-l-2 border-sky-500/30 pl-5">
              "{{ $content['visi_text'] ?? 'Menjadi perusahaan penyedia barang dan jasa di bidang teknologi informasi yang profesional dan terpercaya.' }}"
            </blockquote>

            <div class="mt-8 pt-6 border-t border-white/8 flex items-center gap-3 text-sky-400 text-xs font-bold uppercase tracking-wider">
              <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
              Integritas & Kredibilitas Utama
            </div>
          </div>
        </div>

        <!-- MISI Card -->
        <div class="relative group reveal-right">
          <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-sky-500/5 rounded-3xl blur-xl group-hover:from-cyan-500/20 group-hover:to-sky-500/10 transition-all duration-500"></div>
          <div class="relative bg-white/[0.04] backdrop-blur-md rounded-3xl p-8 border border-white/8 flex flex-col h-full hover:border-cyan-500/30 transition-all duration-500 hover:bg-white/[0.07]">
            <!-- Header -->
            <div class="flex items-start gap-5 mb-8">
              <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-sky-500/10 text-cyan-300 flex items-center justify-center text-2xl border border-cyan-500/20 shrink-0 group-hover:from-cyan-500/30 transition-all duration-500">
                <i class="fa-solid fa-rocket"></i>
              </div>
              <div>
                <div class="inline-flex items-center gap-1.5 bg-cyan-500/10 border border-cyan-500/20 text-cyan-400 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-2">Misi Perusahaan</div>
                <h3 class="text-3xl font-heading font-black text-white text-glow-soft">MISI</h3>
              </div>
            </div>

            <!-- Misi List -->
            <ul class="space-y-4 flex-1">
              @php $missions = [
                $content['misi_1'] ?? 'Memberikan pelayanan prima dan solusi inovatif tepat guna bagi instansi.',
                $content['misi_2'] ?? 'Menjamin mutu produk dan pengadaan barang berkualitas tinggi.',
                $content['misi_3'] ?? 'Membangun hubungan kemitraan profesional berlandaskan keterbukaan bisnis.',
                $content['misi_4'] ?? 'Meningkatkan kompetensi tim kerja secara terstruktur demi menjamin kualitas.',
              ]; @endphp
              @foreach($missions as $i => $m)
              <li class="flex items-start gap-4 group/item">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-sky-500 to-cyan-500 text-white flex items-center justify-center font-black text-xs shrink-0 mt-0.5 shadow-lg shadow-sky-500/20">{{ $i+1 }}</div>
                <p class="text-slate-300 text-sm leading-relaxed group-hover/item:text-slate-200 transition-colors">{{ $m }}</p>
              </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom wave -->
    <div class="absolute bottom-0 left-0 w-full">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16 fill-white">
        <path d="M0,30 C360,70 720,5 1080,50 C1260,70 1380,30 1440,40 L1440,80 L0,80 Z"/>
      </svg>
    </div>
  </section>

  <!-- ======================================================
       KEUNGGULAN SECTION
  ====================================================== -->
  <section class="py-20 bg-white relative overflow-hidden">
    <div class="absolute top-0 right-0 w-72 h-72 bg-sky-50 rounded-full blur-3xl opacity-60 translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-50 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-14 reveal">
        <div class="inline-flex items-center gap-2 bg-sky-50 border border-sky-100 text-sky-600 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
          <i class="fa-solid fa-star text-[10px]"></i> Keunggulan Kami
        </div>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-heading font-black text-slate-900">Mengapa Pilih <span class="bg-gradient-to-r from-sky-500 to-cyan-500 bg-clip-text text-transparent">NUSTECH?</span></h2>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
          $keunggulan = [
            ['icon'=>'fa-solid fa-wand-magic-sparkles','color'=>'sky','title'=>'Solusi Terintegrasi','desc'=>'Kelola seluruh kebutuhan IT, kelistrikan, dan pengadaan di bawah satu koordinasi teknis.'],
            ['icon'=>'fa-solid fa-wifi','color'=>'indigo','title'=>'Konektivitas Handal','desc'=>'Kestabilan koneksi via satelit VSAT maupun fiber optik, dikerjakan teknisi bersertifikasi.'],
            ['icon'=>'fa-solid fa-shield-halved','color'=>'emerald','title'=>'Layanan Purna Jual','desc'=>'Garansi pekerjaan & tim NOC tanggap darurat untuk meminimalkan kendala sistem.'],
            ['icon'=>'fa-solid fa-clock-rotate-left','color'=>'orange','title'=>'Tepat Waktu','desc'=>'Setiap proyek dikerjakan sesuai timeline kontrak dengan manajemen proyek terstruktur.'],
          ];
        @endphp
        @foreach($keunggulan as $k)
        <div class="group relative reveal" style="transition-delay: {{ $loop->index * 0.1 }}s;">
          <div class="absolute inset-0 bg-gradient-to-br from-{{ $k['color'] }}-50 to-transparent rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
          <div class="relative bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-lg hover:border-{{ $k['color'] }}-200 transition-all duration-400 card-hover h-full">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-{{ $k['color'] }}-100 to-{{ $k['color'] }}-50 text-{{ $k['color'] }}-600 flex items-center justify-center text-2xl mb-5 group-hover:from-{{ $k['color'] }}-500 group-hover:to-{{ $k['color'] }}-600 group-hover:text-white transition-all duration-500 group-hover:scale-110">
              <i class="{{ $k['icon'] }}"></i>
            </div>
            <h4 class="font-heading font-bold text-slate-800 text-base mb-2">{{ $k['title'] }}</h4>
            <p class="text-slate-500 text-xs leading-relaxed">{{ $k['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- ======================================================
       LAYANAN SECTION
  ====================================================== -->
  <section id="layanan" class="py-24 sm:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #f8faff 0%, #f1f5fb 100%);">
    <div class="absolute top-1/4 right-0 w-[450px] h-[450px] bg-sky-100/40 rounded-full blur-3xl translate-x-1/2 pointer-events-none"></div>
    <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-cyan-100/30 rounded-full blur-3xl -translate-x-1/3 pointer-events-none"></div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative">

      <!-- Title -->
      <div class="text-center mb-12 reveal">
        <div class="inline-flex items-center gap-2 bg-sky-50 text-sky-700 border border-sky-100 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
          <i class="fa-solid fa-concierge-bell text-[10px]"></i> Layanan Kami
        </div>
        <h2 class="text-3xl sm:text-4xl md:text-5xl font-heading font-black text-slate-900">{{ $content['layanan_title'] ?? 'Solusi Layanan' }} <span class="bg-gradient-to-r from-sky-500 to-cyan-500 bg-clip-text text-transparent">Komprehensif</span></h2>
        <p class="mt-4 text-slate-500 text-sm max-w-xl mx-auto">{{ $content['layanan_subtitle'] ?? 'Klik kategori di bawah untuk melihat detail layanan yang kami sediakan.' }}</p>
      </div>

      <!-- TAB SELECTOR -->
      <!-- Tab bar: scrollable on mobile, wrapped center on desktop -->
      <div class="flex sm:flex-wrap sm:justify-center gap-2.5 mb-12 reveal overflow-x-auto hide-scrollbar pb-2 sm:pb-0 -mx-4 px-4 sm:mx-0 sm:px-0" id="layananTabBar">
        <button id="tab-networking"  onclick="showLayanan('networking')"  class="layanan-tab-btn tab-btn-active flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-network-wired"></i> Networking
        </button>
        <button id="tab-aplikasi"   onclick="showLayanan('aplikasi')"    class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-code text-sky-500"></i> Aplikasi
        </button>
        <button id="tab-reklame"    onclick="showLayanan('reklame')"     class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-palette text-sky-500"></i> Reklame
        </button>
        <button id="tab-kelistrikan" onclick="showLayanan('kelistrikan')" class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-bolt text-sky-500"></i> Kelistrikan
        </button>
        <button id="tab-ac"         onclick="showLayanan('ac')"          class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-snowflake text-sky-500"></i> AC
        </button>
        <button id="tab-komputer"   onclick="showLayanan('komputer')"    class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-print text-sky-500"></i> Komputer & Printer
        </button>
        <button id="tab-elektronik" onclick="showLayanan('elektronik')"  class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-tv text-sky-500"></i> Elektronik
        </button>
        <button id="tab-kantor"     onclick="showLayanan('kantor')"      class="layanan-tab-btn flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold whitespace-nowrap shrink-0">
          <i class="fa-solid fa-briefcase text-sky-500"></i> Peralatan Kantor
        </button>
      </div>

      <!-- Tab Content -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">

        <!-- Left: Detail Box -->
        <div class="lg:col-span-6">
          <div class="relative bg-white rounded-3xl border border-slate-100 shadow-sm p-7 sm:p-9 h-full overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full pointer-events-none"></div>
            <div class="relative z-10">
              <!-- Networking -->
              <div id="networking" class="layanan-item space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center text-2xl shadow-sm">
                    <i class="fa-solid fa-network-wired"></i>
                  </div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">{{ $content['layanan_networking_title'] ?? 'Networking' }}</h3>
                    <p class="text-xs text-sky-500 font-semibold">{{ $content['layanan_networking_sub'] ?? 'Infrastruktur & Konektivitas' }}</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $content['layanan_networking_desc'] ?? 'Solusi infrastruktur jaringan internet lokal, inter-koneksi antar kantor, hingga maintenance periodik perangkat jaringan.' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-sky-200 hover:shadow-md cursor-pointer transition group" onclick="openJaringanModal()">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-all"><i class="fa-solid fa-network-wired"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-sky-600 leading-tight">Jaringan LAN & WiFi</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-sky-100 group-hover:text-sky-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-sky-200 hover:shadow-md cursor-pointer transition group" onclick="openVsatModal()">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-all"><i class="fa-solid fa-satellite-dish"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-sky-600 leading-tight">Instalasi VSAT</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-sky-100 group-hover:text-sky-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-sky-200 hover:shadow-md cursor-pointer transition group" onclick="openBasebandModal()">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-all"><i class="fa-solid fa-server"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-sky-600 leading-tight">Instalasi Baseband</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-sky-100 group-hover:text-sky-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-sky-200 hover:shadow-md cursor-pointer transition group" onclick="openCctvModal()">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-500 flex items-center justify-center shrink-0 group-hover:bg-sky-500 group-hover:text-white transition-all"><i class="fa-solid fa-camera"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-sky-600 leading-tight">Keamanan CCTV</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-sky-100 group-hover:text-sky-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Networking" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-500 to-cyan-500 hover:from-sky-400 hover:to-cyan-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg shadow-sky-500/20 hover:shadow-sky-400/30 hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Aplikasi -->
              <div id="aplikasi" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-code"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">{{ $content['layanan_aplikasi_title'] ?? 'Jasa Pengembangan Aplikasi & Program Komputer' }}</h3>
                    <p class="text-xs text-indigo-500 font-semibold">{{ $content['layanan_aplikasi_sub'] ?? 'Aplikasi & Program Komputer' }}</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $content['layanan_aplikasi_desc'] ?? 'Merancang software kustom sesuai alur bisnis instansi, mulai dari program kasir, inventory, hingga sistem manajemen.' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-indigo-200 hover:shadow-md cursor-pointer transition group" onclick="openAplikasiSoftwareModal()">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 group-hover:bg-indigo-500 group-hover:text-white transition-all"><i class="fa-solid fa-globe"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-indigo-600 leading-tight">Pembuatan Software</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-100 group-hover:text-indigo-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-indigo-200 hover:shadow-md cursor-pointer transition group" onclick="openAplikasiJasaModal()">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-500 flex items-center justify-center shrink-0 group-hover:bg-indigo-500 group-hover:text-white transition-all"><i class="fa-solid fa-database"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-indigo-600 leading-tight">Jasa Pemrograman</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-indigo-100 group-hover:text-indigo-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Aplikasi" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-blue-500 hover:from-indigo-400 hover:to-blue-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Reklame -->
              <div id="reklame" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-palette"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">{{ $content['layanan_reklame_title'] ?? 'Jasa Reklame dan Percetakan' }}</h3>
                    <p class="text-xs text-pink-500 font-semibold">{{ $content['layanan_reklame_sub'] ?? 'Branding & Promosi' }}</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $content['layanan_reklame_desc'] ?? 'Produksi material branding promosi fisik berkualitas untuk keperluan reklame luar ruangan maupun cetak massal.' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-pink-200 hover:shadow-md cursor-pointer transition group" onclick="openReklameDesainModal()">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center shrink-0 group-hover:bg-pink-500 group-hover:text-white transition-all"><i class="fa-solid fa-sign-hanging"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-pink-600 leading-tight">Desain Media Promosi</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-pink-100 group-hover:text-pink-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-pink-200 hover:shadow-md cursor-pointer transition group" onclick="openReklameCetakModal()">
                    <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-500 flex items-center justify-center shrink-0 group-hover:bg-pink-500 group-hover:text-white transition-all"><i class="fa-solid fa-print"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-pink-600 leading-tight">Layanan Cetak</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-pink-100 group-hover:text-pink-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Reklame" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-400 hover:to-rose-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Kelistrikan -->
              <div id="kelistrikan" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-yellow-100 to-amber-100 text-yellow-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-bolt"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">{{ $content['layanan_kelistrikan_title'] ?? 'Jasa Kelistrikan' }}</h3>
                    <p class="text-xs text-yellow-600 font-semibold">{{ $content['layanan_kelistrikan_sub'] ?? 'Kelistrikan Bangunan' }}</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $content['layanan_kelistrikan_desc'] ?? 'Perancangan kelistrikan terpusat untuk keamanan operasional server data center, perkantoran, dan gedung.' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-yellow-200 hover:shadow-md cursor-pointer transition group" onclick="openKelistrikanSistemModal()">
                    <div class="w-10 h-10 rounded-xl bg-yellow-50 text-yellow-500 flex items-center justify-center shrink-0 group-hover:bg-yellow-500 group-hover:text-white transition-all"><i class="fa-solid fa-plug-circle-bolt"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-yellow-600 leading-tight">Sistem Kelistrikan</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-yellow-100 group-hover:text-yellow-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Kelistrikan" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-400 hover:to-amber-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- AC -->
              <div id="ac" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-100 to-sky-100 text-cyan-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-snowflake"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">{{ $content['layanan_ac_title'] ?? 'Instalasi & Pemeliharaan Sistem Pendingin (AC)' }}</h3>
                    <p class="text-xs text-cyan-500 font-semibold">{{ $content['layanan_ac_sub'] ?? 'Sistem Pendingin (AC)' }}</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">{{ $content['layanan_ac_desc'] ?? 'Maintenance pendingin ruangan secara rutin demi menjaga kestabilan suhu ruangan kerja maupun mesin server.' }}</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-cyan-200 hover:shadow-md cursor-pointer transition group" onclick="openAcPemasanganModal()">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-500 flex items-center justify-center shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-all"><i class="fa-solid fa-shower"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-cyan-600 leading-tight">Pemasangan AC</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-cyan-100 group-hover:text-cyan-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-cyan-200 hover:shadow-md cursor-pointer transition group" onclick="openAcMaintenanceModal()">
                    <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-500 flex items-center justify-center shrink-0 group-hover:bg-cyan-500 group-hover:text-white transition-all"><i class="fa-solid fa-wind"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-cyan-600 leading-tight">Maintenance AC</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-cyan-100 group-hover:text-cyan-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Sistem%20Pendingin" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-sky-500 hover:from-cyan-400 hover:to-sky-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Komputer -->
              <div id="komputer" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-slate-100 to-slate-200 text-slate-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-print"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">Pengadaan & Maintenance Perangkat Komputer dan Printer</h3>
                    <p class="text-xs text-slate-500 font-semibold">Komputer & Printer</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">Penyediaan unit komputer client, laptop, server lokal, serta perbaikan berkala pada unit pencetak printer.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-slate-300 hover:shadow-md cursor-pointer transition group" onclick="openKomputerPengadaanModal()">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:bg-slate-600 group-hover:text-white transition-all"><i class="fa-solid fa-laptop"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-slate-700 leading-tight">Pengadaan Unit</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-200 group-hover:text-slate-700 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-slate-300 hover:shadow-md cursor-pointer transition group" onclick="openKomputerPerawatanModal()">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center shrink-0 group-hover:bg-slate-600 group-hover:text-white transition-all"><i class="fa-solid fa-print"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-slate-700 leading-tight">Layanan Perawatan</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-slate-200 group-hover:text-slate-700 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Komputer%20dan%20Printer" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-slate-700 to-slate-600 hover:from-slate-600 hover:to-slate-500 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Elektronik -->
              <div id="elektronik" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-100 to-emerald-100 text-teal-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-tv"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">Pengadaan Peralatan Elektronik</h3>
                    <p class="text-xs text-teal-500 font-semibold">Peralatan Elektronik</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">Pengadaan berbagai peralatan elektronik operasional seperti TV display informasi, speaker pro, hingga proyektor.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-teal-200 hover:shadow-md cursor-pointer transition group" onclick="openElektronikPenyediaanModal()">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center shrink-0 group-hover:bg-teal-500 group-hover:text-white transition-all"><i class="fa-solid fa-tv"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-teal-600 leading-tight">Penyediaan Elektronik</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-teal-100 group-hover:text-teal-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Alat%20Elektronik" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-500 to-emerald-500 hover:from-teal-400 hover:to-emerald-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <!-- Kantor -->
              <div id="kantor" class="layanan-item hidden space-y-5">
                <div class="flex items-center gap-4 mb-3">
                  <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 flex items-center justify-center text-2xl shadow-sm"><i class="fa-solid fa-briefcase"></i></div>
                  <div>
                    <h3 class="text-xl sm:text-2xl font-heading font-extrabold text-slate-950">Pengadaan & Perawatan Alat-Alat Kantor</h3>
                    <p class="text-xs text-orange-500 font-semibold">Alat-Alat Kantor</p>
                  </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed">Penyediaan meja kerja, kursi ergonomis, lemari berkas baja, serta furniture custom pendukung kenyamanan kantor.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-orange-200 hover:shadow-md cursor-pointer transition group" onclick="openKantorPenyediaanModal()">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-all"><i class="fa-solid fa-chair"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-orange-600 leading-tight">Perlengkapan Kantor</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-orange-100 group-hover:text-orange-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                  <div class="flex items-center gap-3 p-3 rounded-2xl border border-slate-100 bg-white hover:border-orange-200 hover:shadow-md cursor-pointer transition group" onclick="openKantorPerawatanModal()">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-all"><i class="fa-solid fa-box-archive"></i></div>
                    <div class="flex-1">
                      <span class="block text-[13px] font-bold text-slate-800 group-hover:text-orange-600 leading-tight">Perawatan Peralatan</span>
                      <span class="block text-[10px] text-slate-500 mt-0.5">Lihat Portofolio</span>
                    </div>
                    <div class="w-6 h-6 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center group-hover:bg-orange-100 group-hover:text-orange-600 transition shrink-0"><i class="fa-solid fa-arrow-right text-[10px]"></i></div>
                  </div>
                </div>
                <div class="pt-2">
                  <a href="https://wa.me/6281332809923?text=Halo,%20saya%20tertarik%20dengan%20layanan%20Peralatan%20Kantor" target="_blank" class="inline-flex items-center gap-2 bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-400 hover:to-amber-400 text-white py-2.5 px-6 rounded-xl text-xs font-bold transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                    Hubungi Kami <i class="fa-solid fa-arrow-right text-[9px]"></i>
                  </a>
                </div>
              </div>

              <div class="mt-8 pt-5 border-t border-slate-100 text-slate-400 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-lock text-[10px] text-sky-400"></i> CV. NUSTECH terdaftar dan berasuransi
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Accordion -->
        <div class="lg:col-span-6 flex flex-col gap-3 justify-center">
          @php
            $accordions = [
              ['icon'=>'fa-wand-magic-sparkles','title'=>'Solusi Terintegrasi','content'=>'Kelola seluruh CCTV, kelistrikan, pendingin, dan jaringan perkantoran Anda di bawah satu koordinasi teknis yang andal dan tepercaya.','open'=>true],
              ['icon'=>'fa-wifi','title'=>'Konektivitas Handal','content'=>'Kami menjamin kestabilan koneksi internet via satelit VSAT maupun fiber optik, dikerjakan oleh teknisi bersertifikasi.','open'=>false],
              ['icon'=>'fa-shield-halved','title'=>'Layanan Purna Jual','content'=>'Garansi pekerjaan dan ketersediaan tim tanggap darurat (NOC Team) untuk meminimalkan durasi kendala sistem.','open'=>false],
              ['icon'=>'fa-clock-rotate-left','title'=>'Pengerjaan Tepat Waktu','content'=>'Setiap proyek dikerjakan sesuai timeline kontrak yang disepakati, dengan manajemen proyek yang terstruktur dan transparan.','open'=>false],
            ];
          @endphp
          @foreach($accordions as $acc)
          <details class="group text-left cursor-pointer bg-white hover:bg-sky-50/30 border border-slate-100 hover:border-sky-200 rounded-2xl p-5 transition-all shadow-sm hover:shadow-md" {{ $acc['open'] ? 'open' : '' }}>
            <summary class="flex justify-between items-center font-heading font-bold text-slate-800 text-base list-none">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-50 text-sky-600 flex items-center justify-center shrink-0 group-open:from-sky-500 group-open:to-cyan-500 group-open:text-white transition-all duration-300">
                  <i class="fa-solid {{ $acc['icon'] }}"></i>
                </div>
                <span class="group-open:text-sky-700 transition-colors">{{ $acc['title'] }}</span>
              </div>
              <i class="fa-solid fa-chevron-down text-sky-400 text-xs acc-arrow shrink-0"></i>
            </summary>
            <div class="mt-3 text-xs text-slate-500 leading-relaxed pl-13">
              {{ $acc['content'] }}
            </div>
          </details>
          @endforeach
        </div>

      </div>
    </div>
  </section>

  <!-- ======================================================
       GALERI / PORTFOLIO SECTION
  ====================================================== -->
  <section id="gallery" class="py-20 sm:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #020817 0%, #0a1628 60%, #020817 100%);">
    <div class="absolute inset-0 opacity-[0.04]" style="background-image: radial-gradient(circle, rgba(14,165,233,0.3) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-sky-500/40 to-transparent"></div>
    <div class="absolute top-0 left-0 w-full">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16" style="fill:#f1f5fb;">
        <path d="M0,30 C360,60 720,5 1080,45 C1260,65 1380,25 1440,35 L1440,0 L0,0 Z"/>
      </svg>
    </div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <!-- Header -->
      <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-12 reveal">
        <div>
          <div class="inline-flex items-center gap-2 bg-sky-500/10 border border-sky-500/20 text-sky-400 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-4">
            <i class="fa-solid fa-images text-[10px]"></i> Portofolio
          </div>
          <h2 class="text-4xl sm:text-5xl font-heading font-black text-white text-glow-soft">Dokumentasi Proyek</h2>
          <p class="mt-2 text-slate-400 text-sm">Rekam jejak pengerjaan nyata di lapangan.</p>
        </div>

        <div class="flex gap-3 mt-6 md:mt-0 select-none">
          <button id="portfolio-prev" class="w-12 h-12 rounded-full bg-white/5 hover:bg-sky-500/20 border border-white/10 hover:border-sky-500/40 text-white hover:text-sky-300 flex items-center justify-center shadow transition-all duration-300 hover:-translate-x-0.5 neon-border cursor-pointer">
            <i class="fa-solid fa-chevron-left text-sm"></i>
          </button>
          <button id="portfolio-next" class="w-12 h-12 rounded-full bg-white/5 hover:bg-sky-500/20 border border-white/10 hover:border-sky-500/40 text-white hover:text-sky-300 flex items-center justify-center shadow transition-all duration-300 hover:translate-x-0.5 neon-border cursor-pointer">
            <i class="fa-solid fa-chevron-right text-sm"></i>
          </button>
        </div>
      </div>

      <!-- Gallery Swiper -->
      <div class="swiper portfolioSwiper !overflow-visible py-8">
        <div class="swiper-wrapper">
          @forelse($portfolios as $p)
            <div data-image="{{ asset($p->image_path) }}"
                 data-category="{{ $p->category ?? 'Umum' }}"
                 data-title="{{ $p->title }}"
                 data-desc="{{ $p->description ?? 'Deskripsi pengerjaan proyek.' }}"
                 class="swiper-slide cursor-pointer group relative rounded-3xl overflow-hidden border border-white/8 hover:border-sky-500/40 transition-all duration-500 hover:shadow-2xl hover:shadow-sky-500/10 select-none">
              <div class="h-56 relative overflow-hidden bg-slate-900">
                <img src="{{ asset($p->image_path) }}" alt="{{ $p->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                <span class="absolute top-4 left-4 bg-sky-500/80 backdrop-blur-md text-white text-[9px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">{{ $p->category ?? 'Umum' }}</span>
              </div>
              <div class="bg-dark-900/95 backdrop-blur-md p-5 border-t border-white/5">
                <h4 class="font-heading font-bold text-white text-sm line-clamp-1 mb-1.5">{{ $p->title }}</h4>
                <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">{{ $p->description ?? 'Deskripsi pengerjaan proyek.' }}</p>
              </div>
            </div>
          @empty
            @php
              $staticPortfolios = [
                ['img'=>'assets/img/exp-fiber.jpg','cat'=>'Networking','title'=>'Instalasi Fiber Optik','desc'=>'Penyambungan dan instalasi jalur kabel optik utama perkantoran.'],
                ['img'=>'assets/img/exp-tower.jpg','cat'=>'Engineering','title'=>'Pemeliharaan Tower BTS','desc'=>'Inspeksi struktur dan pemeliharaan baseband tower nirkabel.'],
                ['img'=>'assets/img/exp-vsat.jpg','cat'=>'VSAT','title'=>'Pemasangan Satelit VSAT','desc'=>'Pemasangan antena parabola penerima satelit internet untuk desa terpencil.'],
                ['img'=>'assets/img/exp-fiber.jpg','cat'=>'Kelistrikan','title'=>'Instalasi Panel Listrik','desc'=>'Pemasangan panel distribusi daya utama pada gedung perkantoran.'],
              ];
            @endphp
            @foreach($staticPortfolios as $sp)
            <div data-image="{{ asset($sp['img']) }}"
                 data-category="{{ $sp['cat'] }}"
                 data-title="{{ $sp['title'] }}"
                 data-desc="{{ $sp['desc'] }}"
                 class="swiper-slide cursor-pointer group relative rounded-3xl overflow-hidden border border-white/8 hover:border-sky-500/40 transition-all duration-500 hover:shadow-2xl hover:shadow-sky-500/10 select-none">
              <div class="h-56 relative overflow-hidden bg-slate-900">
                <img src="{{ asset($sp['img']) }}" alt="{{ $sp['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent"></div>
                <span class="absolute top-4 left-4 bg-sky-500/80 backdrop-blur-md text-white text-[9px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider">{{ $sp['cat'] }}</span>
              </div>
              <div class="bg-dark-900/95 backdrop-blur-md p-5 border-t border-white/5">
                <h4 class="font-heading font-bold text-white text-sm line-clamp-1 mb-1.5">{{ $sp['title'] }}</h4>
                <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">{{ $sp['desc'] }}</p>
              </div>
            </div>
            @endforeach
          @endforelse
        </div>
        <!-- Swiper Pagination -->
        <div class="swiper-pagination !relative !bottom-0 mt-8"></div>
      </div>
    </div>

    <!-- Bottom wave -->
    <div class="absolute bottom-0 left-0 w-full">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16 fill-white">
        <path d="M0,50 C360,20 720,65 1080,30 C1260,15 1380,55 1440,40 L1440,80 L0,80 Z"/>
      </svg>
    </div>
  </section>

  <!-- ======================================================
       INSTAGRAM NEWS SECTION
  ====================================================== -->
  <section id="news" class="py-20 sm:py-28 relative overflow-hidden" style="background: linear-gradient(180deg, #020817 0%, #0a1628 60%, #020817 100%);">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, rgba(236,72,153,0.3) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-pink-500/10 rounded-full blur-3xl translate-x-1/3 -translate-y-1/3 pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-500/10 rounded-full blur-3xl -translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <div class="text-center mb-16 reveal">
        <div class="inline-flex items-center gap-2 bg-pink-500/10 border border-pink-500/20 text-pink-400 px-5 py-2 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
          <i class="fa-brands fa-instagram text-sm"></i> Media Informasi
        </div>
        <h2 class="text-4xl sm:text-5xl font-heading font-black text-white text-glow-soft">Kabar Terbaru <span class="bg-gradient-to-r from-pink-400 to-orange-400 bg-clip-text text-transparent">Perusahaan</span></h2>
        <p class="mt-4 text-slate-400 text-sm max-w-lg mx-auto">Update aktivitas, proyek, dan perkembangan terkini CV. NUSTECH.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
        
        <!-- Kolom Kiri: Berita Umum -->
        <div>
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-heading font-black text-white flex items-center gap-2">
              <span class="w-8 h-8 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center"><i class="fa-regular fa-newspaper"></i></span> Berita Umum
            </h3>
            <div class="flex gap-2">
              <button id="general-prev" class="w-8 h-8 rounded-full bg-white/5 hover:bg-sky-500/20 border border-white/10 hover:border-sky-500/40 text-white hover:text-sky-300 flex items-center justify-center shadow transition-all duration-300">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <button id="general-next" class="w-8 h-8 rounded-full bg-white/5 hover:bg-sky-500/20 border border-white/10 hover:border-sky-500/40 text-white hover:text-sky-300 flex items-center justify-center shadow transition-all duration-300">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>
          </div>
          <div class="swiper generalNewsSwiper !overflow-visible py-4">
            <div class="swiper-wrapper">
              @forelse($generalNews as $item)
                <div class="swiper-slide w-[90%] sm:w-[400px] h-auto cursor-pointer"
                     data-image="{{ $item->image_path ? asset($item->image_path) : '' }}"
                     data-category="Berita Umum"
                     data-title="{{ $item->title }}"
                     data-desc="{{ strip_tags($item->caption) }}">
                  <div class="bg-dark-850/50 backdrop-blur-md rounded-3xl border border-white/10 shadow-lg overflow-hidden flex flex-col h-full hover:border-sky-500/40 hover:shadow-sky-500/10 hover:-translate-y-1 transition-all duration-400 group">
                    <div class="relative overflow-hidden aspect-video bg-dark-950 flex items-center justify-center shrink-0">
                      @if($item->image_path)
                        <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                      @else
                        <div class="w-full h-full bg-gradient-to-tr from-sky-950 via-brand-900 to-sky-700 flex flex-col items-center justify-center text-white p-6 text-center opacity-80 group-hover:opacity-100">
                          <i class="fa-regular fa-newspaper text-5xl opacity-20 mb-2"></i>
                        </div>
                      @endif
                      <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent"></div>
                    </div>
                    <div class="px-6 py-5 flex-1 flex flex-col justify-between relative z-10 -mt-8 pointer-events-none">
                      <div class="bg-dark-900/90 backdrop-blur-xl p-5 rounded-2xl border border-white/5 shadow-xl h-full flex flex-col justify-between pointer-events-auto">
                        <div>
                          <h4 class="font-heading font-bold text-white text-sm leading-snug line-clamp-2 mb-2 group-hover:text-sky-300 transition-colors">{{ $item->title }}</h4>
                          <p class="text-xs text-slate-400 leading-relaxed line-clamp-3">{!! nl2br(e($item->caption)) !!}</p>
                        </div>
                        <div class="mt-4 pt-4 border-t border-white/5 flex items-center justify-between">
                          <span class="text-[10px] text-sky-400 font-bold"><i class="fa-regular fa-calendar mr-1"></i> {{ $item->published_at ? $item->published_at->format('d M Y') : '' }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              @empty
                <div class="swiper-slide w-full">
                  <div class="bg-dark-850/30 rounded-2xl border border-white/10 p-8 text-center backdrop-blur-sm">
                    <i class="fa-regular fa-folder-open text-3xl text-slate-600 mb-3"></i>
                    <h4 class="text-slate-400 font-bold text-sm">Belum ada berita umum.</h4>
                  </div>
                </div>
              @endforelse
            </div>
            <div class="general-news-pagination flex justify-center mt-6"></div>
          </div>
        </div>

        <!-- Kolom Kanan: Instagram News -->
        <div>
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-heading font-black text-white flex items-center gap-2">
              <span class="w-8 h-8 rounded-lg bg-pink-500/20 text-pink-400 flex items-center justify-center"><i class="fa-brands fa-instagram"></i></span> Instagram News
            </h3>
            <div class="flex gap-2">
              <button id="ig-prev" class="w-8 h-8 rounded-full bg-white/5 hover:bg-pink-500/20 border border-white/10 hover:border-pink-500/40 text-white hover:text-pink-300 flex items-center justify-center shadow transition-all duration-300">
                <i class="fa-solid fa-chevron-left text-xs"></i>
              </button>
              <button id="ig-next" class="w-8 h-8 rounded-full bg-white/5 hover:bg-pink-500/20 border border-white/10 hover:border-pink-500/40 text-white hover:text-pink-300 flex items-center justify-center shadow transition-all duration-300">
                <i class="fa-solid fa-chevron-right text-xs"></i>
              </button>
            </div>
          </div>
          <div class="swiper instagramNewsSwiper !overflow-visible py-4">
            <div class="swiper-wrapper">
              @forelse($instagramNews as $item)
                <div class="swiper-slide w-[80%] sm:w-[320px] h-auto cursor-pointer"
                     data-image="{{ $item->image_path ? asset($item->image_path) : '' }}"
                     data-category="Instagram"
                     data-title="{{ $item->title }}"
                     data-desc="{{ strip_tags($item->caption) }}">
                  <div class="bg-dark-850/50 backdrop-blur-md rounded-3xl border border-white/10 shadow-lg overflow-hidden flex flex-col h-full hover:border-pink-500/40 hover:shadow-pink-500/10 hover:-translate-y-1 transition-all duration-400 group">
                    @if($item->instagram_url)
                      <div class="bg-white rounded-3xl overflow-hidden p-1 pointer-events-auto">
                        <blockquote class="instagram-media w-full m-0 p-0" data-instgrm-permalink="{{ rtrim($item->instagram_url, '/') }}/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" style="background:#FFF; border:0; margin:0; padding:0; width:100%;">
                        </blockquote>
                      </div>
                    @else
                      <div class="relative overflow-hidden aspect-square bg-dark-950 flex items-center justify-center shrink-0">
                        @if($item->image_path)
                          <img src="{{ asset($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-105 transition-all duration-500">
                        @else
                          <div class="w-full h-full bg-gradient-to-tr from-pink-950 via-purple-950 to-indigo-950 flex flex-col items-center justify-center text-white p-6 text-center opacity-80 group-hover:opacity-100">
                            <i class="fa-brands fa-instagram text-5xl opacity-20 mb-2"></i>
                          </div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent"></div>
                      </div>
                      <div class="px-5 py-4 flex-1 flex flex-col justify-between relative z-10 -mt-6 pointer-events-none">
                        <div class="bg-dark-900/90 backdrop-blur-xl p-4 rounded-2xl border border-white/5 shadow-xl h-full flex flex-col justify-between pointer-events-auto">
                          <div>
                            <h4 class="font-heading font-bold text-white text-xs leading-snug line-clamp-1 mb-1.5 group-hover:text-pink-300 transition-colors">{{ $item->title }}</h4>
                            <p class="text-[10px] text-slate-400 leading-relaxed line-clamp-2">{!! nl2br(e($item->caption)) !!}</p>
                          </div>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
              @empty
                <!-- Fallback cards -->
                @php
                  $instaPosts = [
                    ['img'=>'assets/img/exp-fiber.jpg','title'=>'Optimasi Jaringan Fiber Optic','caption'=>'Proses instalasi jalur utama koneksi kabel fiber optik berjalan lancar di area NTB.'],
                    ['img'=>'assets/img/exp-vsat.jpg','title'=>'Pemasangan VSAT di Lokasi 3T','caption'=>'Kami berhasil memasang antena parabola VSAT di kawasan terpencil untuk mendukung program internet desa.'],
                  ];
                @endphp
                @foreach($instaPosts as $post)
                <div class="swiper-slide w-[80%] sm:w-[320px] h-auto cursor-pointer"
                     data-image="{{ asset($post['img']) }}"
                     data-category="Instagram"
                     data-title="{{ $post['title'] }}"
                     data-desc="{{ $post['caption'] }}">
                  <div class="bg-dark-850/50 backdrop-blur-md rounded-3xl border border-white/10 shadow-lg hover:border-pink-500/40 hover:shadow-pink-500/10 hover:-translate-y-1.5 transition-all duration-500 flex flex-col overflow-hidden group h-full">
                    <!-- Header -->
                    <div class="px-4 py-3 flex items-center justify-between border-b border-white/5 shrink-0">
                      <div class="flex items-center gap-2.5">
                        <img src="{{ asset('assets/img/logonustech.png') }}" alt="Avatar" class="w-7 h-7 rounded-full border border-white/10 shadow-sm">
                        <div>
                          <div class="text-[10px] font-bold text-white flex items-center gap-1">nustech.co.id <i class="fa-solid fa-circle-check text-sky-400 text-[8px]"></i></div>
                          <div class="text-[8px] text-slate-400 font-semibold">Mataram, NTB</div>
                        </div>
                      </div>
                      <a href="https://www.instagram.com/nustech.co.id/" target="_blank" class="text-slate-500 hover:text-pink-400 transition-colors duration-300 pointer-events-auto">
                        <i class="fa-brands fa-instagram text-lg"></i>
                      </a>
                    </div>
                    <!-- Image -->
                    <div class="relative overflow-hidden aspect-square shrink-0">
                      <img src="{{ asset($post['img']) }}" alt="{{ $post['title'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-80 group-hover:opacity-100">
                      <div class="absolute inset-0 bg-gradient-to-t from-dark-950/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center scale-75 group-hover:scale-100 transition-transform duration-500">
                          <i class="fa-brands fa-instagram text-white text-xl"></i>
                        </div>
                      </div>
                    </div>
                    <!-- Content -->
                    <div class="px-4 py-3 flex-1 flex flex-col justify-between relative z-10 -mt-6 pointer-events-none">
                      <div class="bg-dark-900/90 backdrop-blur-xl p-3.5 rounded-2xl border border-white/5 shadow-xl h-full flex flex-col justify-between pointer-events-auto">
                        <div>
                          <h4 class="font-heading font-bold text-white text-[11px] leading-snug mb-1">{{ $post['title'] }}</h4>
                          <p class="text-[9px] text-slate-400 leading-relaxed line-clamp-2 mb-2">
                            <span class="font-bold text-slate-300 mr-1">nustech.co.id</span>{{ $post['caption'] }}
                          </p>
                        </div>
                        <div class="border-t border-white/5 pt-2 flex items-center justify-between">
                          <span class="text-[8px] text-pink-400 font-bold uppercase tracking-widest">Terbaru</span>
                          <a href="https://www.instagram.com/nustech.co.id/" target="_blank" class="bg-white/5 hover:bg-pink-500/20 text-slate-300 hover:text-pink-300 px-3 py-1 rounded-lg border border-white/10 text-[9px] font-bold transition-all duration-300 flex items-center gap-1 pointer-events-auto">
                            Buka <i class="fa-solid fa-arrow-up-right-from-square text-[7px]"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              @endforelse
            </div>
            <div class="instagram-news-pagination flex justify-center mt-6"></div>
          </div>
        </div>

      </div>

      <script async src="//www.instagram.com/embed.js"></script>
    </div>
  </section>

  <!-- ======================================================
       MODALS LAYANAN
  ====================================================== -->
  <!-- Jaringan Modal -->
  <div id="jaringanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="jaringanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-network-wired"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Instalasi dan maintenance jaringan komputer</h3>
        </div>
        <button onclick="closeJaringanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-500 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-medal text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Portofolio & Pengalaman Kerja</h4>
          <p class="text-slate-500 text-sm">Bukti komitmen dan kualitas layanan kami dalam instalasi serta maintenance jaringan komputer di berbagai instansi.</p>
        </div>

        <div class="grid grid-cols-1 gap-4">
          @forelse($modalItems->get('jaringan', collect()) as $item)
          <div class="group p-4 sm:p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100/50 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 flex flex-col sm:flex-row gap-4 sm:items-start">
              <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                <i class="fa-solid fa-wifi text-lg"></i>
              </div>
              <div class="flex-1 space-y-2.5">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                  <h5 class="font-bold text-slate-800 text-base leading-snug">{{ $item->title }}</h5>
                  @if($item->year)
                  <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 text-[11px] font-extrabold whitespace-nowrap shrink-0 border border-sky-100 shadow-sm"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                  @endif
                </div>
                @if($item->client)
                <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl w-fit border border-slate-100">
                  <i class="fa-regular fa-building text-sky-400"></i>
                  <span>{{ $item->client }}</span>
                </div>
                @endif
              </div>
            </div>
          </div>
          @empty
          <p class="text-slate-400 text-sm text-center py-4">Belum ada data portofolio.</p>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeJaringanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- VSAT Modal -->
  <div id="vsatModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="vsatModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-satellite-dish"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Pemasangan dan perawatan jaringan VSAT</h3>
        </div>
        <button onclick="closeVsatModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-500 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-satellite-dish text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pengalaman VSAT (Satelit)</h4>
          <p class="text-slate-500 text-sm">Mendukung program pemerataan akses digital pemerintah, kami berpengalaman menginstalasi antena parabola VSAT (Satelit) di berbagai daerah terpencil (3T).</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('vsat', collect()) as $item)
          <div class="group p-4 bg-white border border-slate-200/60 rounded-2xl hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-3">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-map-location-dot text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-sky-50 text-sky-600 text-[10px] font-extrabold whitespace-nowrap border border-sky-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-4 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-2.5 py-1.5 rounded-lg border border-slate-100">
              <i class="fa-regular fa-handshake text-sky-400"></i>
              <span class="truncate">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeVsatModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Baseband Modal -->
  <div id="basebandModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="basebandModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-tower-cell"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Pemasangan Baseband (BB) Tower</h3>
        </div>
        <button onclick="closeBasebandModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-500 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-tower-broadcast text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pengalaman Infrastruktur Tower</h4>
          <p class="text-slate-500 text-sm">Pengalaman kami dalam perancangan dan instalasi infrastruktur tower Baseband untuk telekomunikasi.</p>
        </div>

        @forelse($modalItems->get('baseband', collect()) as $item)
        <div class="group p-5 sm:p-6 bg-white border border-slate-200/60 rounded-3xl hover:border-sky-300 hover:shadow-2xl hover:shadow-sky-100/50 transition-all duration-300 relative overflow-hidden">
          <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-700"></div>
          <div class="relative z-10 flex flex-col sm:flex-row gap-5 items-start">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
              <i class="fa-solid fa-network-wired text-xl"></i>
            </div>
            <div class="flex-1 space-y-3">
              <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                <h5 class="font-bold text-slate-800 text-lg leading-snug">{{ $item->title }}</h5>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-lg bg-sky-50 text-sky-600 text-[11px] font-extrabold whitespace-nowrap shrink-0 border border-sky-100 shadow-sm"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              @if($item->client)
              <div class="flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3.5 py-2 rounded-xl w-fit border border-slate-100">
                <i class="fa-regular fa-building text-sky-400"></i>
                <span>{{ $item->client }}</span>
              </div>
              @endif
              @if($item->description)
              <div class="pt-3">
                <p class="font-bold text-slate-700 text-xs mb-2 uppercase tracking-wider">Cakupan Pekerjaan:</p>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-slate-500">
                  @foreach(explode(',', $item->description) as $scope)
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-sky-500"></i> {{ trim($scope) }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
            </div>
          </div>
        </div>
        @empty
        <p class="text-slate-400 text-sm text-center py-4">Belum ada data portofolio.</p>
        @endforelse
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeBasebandModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- CCTV Modal -->
  <div id="cctvModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="cctvModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-camera"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Instalasi dan pemeliharaan sistem CCTV</h3>
        </div>
        <button onclick="closeCctvModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-500 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-shield-halved text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pengalaman Sistem Keamanan CCTV</h4>
          <p class="text-slate-500 text-sm">Berikut adalah portofolio kami dalam merancang dan menginstalasi sistem keamanan CCTV yang terintegrasi di berbagai instansi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          @forelse($modalItems->get('cctv', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-sky-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100 text-sky-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-camera-rotate text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-sky-50 text-sky-600 text-[10px] font-extrabold whitespace-nowrap border border-sky-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-sky-400 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-3 text-center py-4 text-slate-400 text-sm">Belum ada data.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeCctvModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>
  <!-- Aplikasi Software Modal -->
  <div id="aplikasiSoftwareModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="aplikasiSoftwareModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-globe"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Pembuatan Software Aplikasi</h3>
        </div>
        <button onclick="closeAplikasiSoftwareModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-globe text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pembuatan Software Aplikasi</h4>
          <p class="text-slate-500 text-sm">Pembuatan software/aplikasi sesuai kebutuhan klien.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('aplikasi_software', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-code text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-extrabold whitespace-nowrap border border-indigo-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-indigo-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeAplikasiSoftwareModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Aplikasi Jasa Modal -->
  <div id="aplikasiJasaModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="aplikasiJasaModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-database"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Jasa Pemrograman Khusus</h3>
        </div>
        <button onclick="closeAplikasiJasaModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-database text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Jasa Pemrograman Khusus</h4>
          <p class="text-slate-500 text-sm">Jasa pemrograman khusus untuk instansi dan perusahaan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('aplikasi_jasa', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-indigo-300 hover:shadow-xl hover:shadow-indigo-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-indigo-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-blue-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-laptop-code text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 text-[10px] font-extrabold whitespace-nowrap border border-indigo-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-indigo-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeAplikasiJasaModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Reklame Desain Modal -->
  <div id="reklameDesainModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="reklameDesainModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-sign-hanging"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Desain Media Promosi</h3>
        </div>
        <button onclick="closeReklameDesainModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-sign-hanging text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Desain Media Promosi</h4>
          <p class="text-slate-500 text-sm">Desain dan produksi media promosi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('reklame_desain', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-pink-300 hover:shadow-xl hover:shadow-pink-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-pink-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-palette text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-pink-50 text-pink-600 text-[10px] font-extrabold whitespace-nowrap border border-pink-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-pink-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeReklameDesainModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Reklame Cetak Modal -->
  <div id="reklameCetakModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="reklameCetakModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-print"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Layanan Cetak</h3>
        </div>
        <button onclick="closeReklameCetakModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-print text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Layanan Cetak</h4>
          <p class="text-slate-500 text-sm">Layanan cetak untuk berbagai kebutuhan perusahaan dan instansi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('reklame_cetak', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-pink-300 hover:shadow-xl hover:shadow-pink-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-pink-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 text-pink-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-paint-roller text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-pink-50 text-pink-600 text-[10px] font-extrabold whitespace-nowrap border border-pink-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-pink-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeReklameCetakModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Kelistrikan Sistem Modal -->
  <div id="kelistrikanSistemModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="kelistrikanSistemModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-plug-circle-bolt"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Sistem Kelistrikan</h3>
        </div>
        <button onclick="closeKelistrikanSistemModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-100 to-amber-100 text-yellow-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-plug-circle-bolt text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Sistem Kelistrikan</h4>
          <p class="text-slate-500 text-sm">Perancangan, pemasangan, dan perawatan sistem kelistrikan.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('kelistrikan_sistem', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-yellow-300 hover:shadow-xl hover:shadow-yellow-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-yellow-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-100 to-amber-100 text-yellow-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-bolt text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-yellow-50 text-yellow-600 text-[10px] font-extrabold whitespace-nowrap border border-yellow-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-yellow-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeKelistrikanSistemModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- AC Pemasangan Modal -->
  <div id="acPemasanganModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="acPemasanganModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-shower"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Pemasangan AC</h3>
        </div>
        <button onclick="closeAcPemasanganModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-100 to-sky-100 text-cyan-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-shower text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pemasangan AC</h4>
          <p class="text-slate-500 text-sm">Pemasangan AC dan sistem pendingin lainnya.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('ac_pemasangan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-cyan-300 hover:shadow-xl hover:shadow-cyan-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-cyan-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-100 to-sky-100 text-cyan-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-snowflake text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-600 text-[10px] font-extrabold whitespace-nowrap border border-cyan-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-cyan-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeAcPemasanganModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- AC Maintenance Modal -->
  <div id="acMaintenanceModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="acMaintenanceModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-wind"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Maintenance AC</h3>
        </div>
        <button onclick="closeAcMaintenanceModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-cyan-100 to-sky-100 text-cyan-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-wind text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Maintenance AC</h4>
          <p class="text-slate-500 text-sm">Maintenance dan perbaikan berkala sistem pendingin.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('ac_maintenance', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-cyan-300 hover:shadow-xl hover:shadow-cyan-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-cyan-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-100 to-sky-100 text-cyan-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-fan text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-cyan-50 text-cyan-600 text-[10px] font-extrabold whitespace-nowrap border border-cyan-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-cyan-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeAcMaintenanceModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Komputer Pengadaan Modal -->
  <div id="komputerPengadaanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="komputerPengadaanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-laptop"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Pengadaan Komputer & Printer</h3>
        </div>
        <button onclick="closeKomputerPengadaanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-200 to-slate-300 text-slate-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-laptop text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Pengadaan Komputer & Printer</h4>
          <p class="text-slate-500 text-sm">Pengadaan unit komputer, printer, dan perangkat pendukung.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('komputer_pengadaan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-slate-300 hover:shadow-xl hover:shadow-slate-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-slate-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-200 to-slate-300 text-slate-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-desktop text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-slate-50 text-slate-600 text-[10px] font-extrabold whitespace-nowrap border border-slate-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-slate-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeKomputerPengadaanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Komputer Perawatan Modal -->
  <div id="komputerPerawatanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="komputerPerawatanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-print"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Perawatan Komputer & Printer</h3>
        </div>
        <button onclick="closeKomputerPerawatanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-200 to-slate-300 text-slate-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-print text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Perawatan Komputer & Printer</h4>
          <p class="text-slate-500 text-sm">Layanan perawatan dan perbaikan berkala.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('komputer_perawatan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-slate-300 hover:shadow-xl hover:shadow-slate-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-slate-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-200 to-slate-300 text-slate-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-screwdriver-wrench text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-slate-50 text-slate-600 text-[10px] font-extrabold whitespace-nowrap border border-slate-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-slate-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeKomputerPerawatanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Elektronik Penyediaan Modal -->
  <div id="elektronikPenyediaanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="elektronikPenyediaanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-tv"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Penyediaan Alat Elektronik</h3>
        </div>
        <button onclick="closeElektronikPenyediaanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-teal-100 to-emerald-100 text-teal-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-tv text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Penyediaan Alat Elektronik</h4>
          <p class="text-slate-500 text-sm">Penyediaan berbagai jenis perangkat elektronik sesuai kebutuhan proyek.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('elektronik_penyediaan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-teal-300 hover:shadow-xl hover:shadow-teal-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-teal-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-teal-100 to-emerald-100 text-teal-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-plug text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-teal-50 text-teal-600 text-[10px] font-extrabold whitespace-nowrap border border-teal-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-teal-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeElektronikPenyediaanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Kantor Penyediaan Modal -->
  <div id="kantorPenyediaanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="kantorPenyediaanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-chair"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Penyediaan Perlengkapan Kantor</h3>
        </div>
        <button onclick="closeKantorPenyediaanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-chair text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Penyediaan Perlengkapan Kantor</h4>
          <p class="text-slate-500 text-sm">Penyediaan perlengkapan kantor.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('kantor_penyediaan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-orange-300 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-orange-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-couch text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-orange-50 text-orange-600 text-[10px] font-extrabold whitespace-nowrap border border-orange-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-orange-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeKantorPenyediaanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Kantor Perawatan Modal -->
  <div id="kantorPerawatanModal" class="fixed inset-0 z-50 hidden bg-slate-900/80 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-all duration-300">
    <div id="kantorPerawatanModalBox" class="bg-white w-full max-w-4xl rounded-3xl shadow-2xl overflow-hidden border border-slate-100 transform scale-95 translate-y-8 opacity-0 transition-all duration-500 ease-out flex flex-col max-h-[90vh]">
      <div class="bg-gradient-to-r from-sky-950 via-brand-900 to-sky-900 px-6 py-5 flex items-center justify-between text-white shrink-0">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-lg"><i class="fa-solid fa-box-archive"></i></div>
          <h3 class="font-heading font-bold text-lg tracking-tight">Perawatan Alat Kantor</h3>
        </div>
        <button onclick="closeKantorPerawatanModal()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition">&times;</button>
      </div>
      <div class="bg-slate-50/50 p-6 md:p-8 overflow-y-auto space-y-8 text-slate-600 text-sm leading-relaxed">
        <div class="text-center max-w-2xl mx-auto">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 mb-4 shadow-sm border border-white">
            <i class="fa-solid fa-box-archive text-xl"></i>
          </div>
          <h4 class="font-heading font-extrabold text-slate-900 text-xl sm:text-2xl mb-2">Perawatan Alat Kantor</h4>
          <p class="text-slate-500 text-sm">Perawatan alat kantor secara rutin.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @forelse($modalItems->get('kantor_perawatan', collect()) as $item)
          <div class="group p-5 bg-white border border-slate-200/60 rounded-2xl hover:border-orange-300 hover:shadow-xl hover:shadow-orange-100/50 transition-all duration-300 relative overflow-hidden flex flex-col justify-between">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-orange-50 to-transparent rounded-bl-full pointer-events-none group-hover:scale-125 transition-transform duration-500"></div>
            <div class="relative z-10 space-y-4">
              <div class="flex items-center justify-between gap-2">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-orange-100 to-amber-100 text-orange-600 flex items-center justify-center shrink-0 shadow-sm border border-white">
                  <i class="fa-solid fa-broom text-sm"></i>
                </div>
                @if($item->year)
                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-orange-50 text-orange-600 text-[10px] font-extrabold whitespace-nowrap border border-orange-100"><i class="fa-regular fa-calendar mr-1.5"></i> {{ $item->year }}</span>
                @endif
              </div>
              <h5 class="font-bold text-slate-800 text-sm leading-snug">{{ $item->title }}</h5>
            </div>
            @if($item->client)
            <div class="relative z-10 mt-5 flex items-center gap-2 text-xs text-slate-500 font-semibold bg-slate-50 px-3 py-2 rounded-xl border border-slate-100">
              <i class="fa-regular fa-building text-orange-600 shrink-0"></i>
              <span class="line-clamp-2 leading-tight">{{ $item->client }}</span>
            </div>
            @endif
          </div>
          @empty
          <div class="col-span-2 text-center py-4 text-slate-400 text-sm">Belum ada data portofolio.</div>
          @endforelse
        </div>
      </div>
      <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex justify-end shrink-0">
        <button onclick="closeKantorPerawatanModal()" class="bg-gradient-to-r from-slate-900 to-slate-800 hover:from-sky-600 hover:to-cyan-600 text-white font-bold px-6 py-2.5 rounded-xl text-xs transition-all duration-300 shadow">Tutup</button>
      </div>
    </div>
  </div>

    <!-- IMAGE LIGHTBOX MODAL -->
  <div id="imageLightboxModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-4" style="background: rgba(2,8,23,0); backdrop-filter: blur(0px); transition: background 0.4s ease, backdrop-filter 0.4s ease;" onclick="closeLightbox()">
    <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center justify-center" onclick="event.stopPropagation()">
      <!-- Close Button -->
      <button onclick="closeLightbox()" class="absolute -top-14 right-4 md:right-0 w-11 h-11 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center text-2xl transition-all duration-300 shadow-lg hover:shadow-red-500/20 hover:scale-110 z-20" style="opacity:0; transition: opacity 0.3s 0.2s ease, background 0.3s ease, transform 0.3s ease;" id="lightboxCloseBtn">&times;</button>
      
      <!-- Image container -->
      <div id="lightboxModalBox" class="bg-slate-900 rounded-3xl overflow-hidden border border-white/10 shadow-2xl" style="transform: scale(0.7) translateY(30px); opacity: 0;">
        <img id="lightboxImage" src="" alt="Detail Proyek" class="max-w-full max-h-[70vh] object-contain block mx-auto" style="transition: opacity 0.3s ease;">
        <!-- Caption/Title info at the bottom of image -->
        <div class="p-5 bg-slate-950/80 backdrop-blur-md border-t border-white/5 text-center">
          <span id="lightboxCategory" class="bg-sky-500 text-white text-[9px] font-extrabold uppercase px-3 py-1 rounded-full tracking-wider mb-2 inline-block">Category</span>
          <h4 id="lightboxTitle" class="font-heading font-bold text-white text-base">Project Title</h4>
          <p id="lightboxDesc" class="text-slate-400 text-xs mt-1 max-w-xl mx-auto">Project Description</p>
        </div>
      </div>
    </div>
  </div>

  <!-- ======================================================
       FOOTER / KONTAK
  ====================================================== -->
  <footer id="kontak" class="relative pt-24 pb-10 overflow-hidden" style="background: linear-gradient(180deg, #020817 0%, #040d1e 100%);">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_center,rgba(14,165,233,0.06)_0%,transparent_60%)]"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-sky-500/30 to-transparent"></div>
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(rgba(14,165,233,0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(14,165,233,0.2) 1px, transparent 1px); background-size: 50px 50px;"></div>

    <!-- Top wave -->
    <div class="absolute top-0 left-0 w-full">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" class="w-full h-12 sm:h-16 fill-white">
        <path d="M0,30 C240,65 480,5 720,45 C960,75 1200,15 1440,40 L1440,0 L0,0 Z"/>
      </svg>
    </div>

    <div class="w-full max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

      <!-- CTA Banner -->
      <div class="relative overflow-hidden bg-gradient-to-r from-sky-900/50 to-cyan-900/30 border border-sky-700/30 rounded-3xl p-8 md:p-12 mb-20 flex flex-col md:flex-row items-center justify-between gap-8 backdrop-blur-sm">
        <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -top-8 -left-8 w-48 h-48 bg-sky-500/5 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
          <div class="inline-flex items-center gap-2 bg-sky-500/15 border border-sky-500/25 text-sky-300 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider mb-4">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Kami Siap Membantu
          </div>
          <h3 class="text-2xl sm:text-3xl font-heading font-black text-white mb-2">{{ $content['cta_title'] ?? 'Siap Bermitra Bersama Kami?' }}</h3>
          <p class="text-sm text-slate-400 max-w-lg">{{ $content['cta_subtitle'] ?? 'Konsultasikan kebutuhan IT, pengadaan, dan engineering Anda langsung dengan tim ahli kami. Gratis konsultasi!' }}</p>
        </div>
        <div class="flex gap-3 flex-wrap relative z-10 shrink-0">
          <a href="https://wa.me/6281332809923" target="_blank" class="inline-flex items-center gap-2.5 bg-emerald-500 hover:bg-emerald-400 text-white font-bold px-7 py-3.5 rounded-2xl text-sm transition-all duration-300 shadow-xl shadow-emerald-900/20 hover:shadow-emerald-500/20 hover:-translate-y-0.5">
            <i class="fa-brands fa-whatsapp text-base"></i> WhatsApp
          </a>
          <a href="mailto:info@nustech.co.id" class="inline-flex items-center gap-2.5 bg-white/8 hover:bg-white/15 text-white font-bold px-7 py-3.5 rounded-2xl text-sm border border-white/15 hover:border-white/30 transition-all duration-300 hover:-translate-y-0.5 backdrop-blur-sm">
            <i class="fa-solid fa-envelope text-sm"></i> Email Kami
          </a>
        </div>
      </div>

      <!-- Footer columns -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 border-b border-white/8 pb-14">

        <!-- Branding -->
        <div class="space-y-5 lg:col-span-1">
          <div class="flex items-center gap-3">
            <div class="relative">
              <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo CV. Nustech" class="h-11 w-11 rounded-full shadow-xl border-2 border-sky-500/30">
              <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-dark-950"></div>
            </div>
            <span class="font-heading font-extrabold text-xl tracking-tight text-white">CV. NUSTECH</span>
          </div>
          <p class="text-xs text-slate-400 leading-relaxed">{{ $content['footer_desc'] ?? 'Penyedia solusi IT infrastruktur, pengadaan barang, percetakan/reklame, kelistrikan, dan sistem pendingin ruangan bergaransi tepercaya di Nusa Tenggara Barat.' }}</p>
          <div class="flex gap-2.5 pt-1">
            <a href="https://www.instagram.com/nustech.co.id/" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-gradient-to-br hover:from-pink-500 hover:to-orange-500 border border-white/10 hover:border-transparent flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300 shadow">
              <i class="fa-brands fa-instagram text-sm"></i>
            </a>
            <a href="https://wa.me/6281332809923" target="_blank" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-emerald-600 border border-white/10 hover:border-emerald-500 flex items-center justify-center text-slate-400 hover:text-white transition-all duration-300 shadow">
              <i class="fa-brands fa-whatsapp text-sm"></i>
            </a>
          </div>
        </div>

        <!-- Navigasi -->
        <div>
          <h4 class="font-heading font-bold text-sm tracking-wider uppercase text-sky-400 mb-6 flex items-center gap-2">
            <span class="w-1 h-4 rounded-full bg-sky-500"></span> Navigasi
          </h4>
          <ul class="space-y-3 text-xs text-slate-400">
            <li><a href="#beranda" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Beranda</a></li>
            <li><a href="#tentang" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Tentang Kami</a></li>
            <li><a href="#visimisi" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Visi & Misi</a></li>
            <li><a href="#layanan" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Layanan Utama</a></li>
            <li><a href="#gallery" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Galeri Kerja</a></li>
            <li><a href="#news" class="hover:text-white hover:pl-2 transition-all duration-200 flex items-center gap-2 group"><i class="fa-solid fa-chevron-right text-[8px] text-sky-500/50 group-hover:text-sky-400 transition-colors"></i>Berita Instagram</a></li>
          </ul>
        </div>

        <!-- Kontak -->
        <div>
          <h4 class="font-heading font-bold text-sm tracking-wider uppercase text-sky-400 mb-6 flex items-center gap-2">
            <span class="w-1 h-4 rounded-full bg-sky-500"></span> Kontak Kami
          </h4>
          <ul class="space-y-4 text-xs text-slate-400">
            <li class="flex items-start gap-3">
              <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center shrink-0 mt-0.5"><i class="fa fa-map-marker-alt text-xs"></i></div>
              <span class="leading-relaxed">{{ $content['contact_address'] ?? 'Jl. Semangka No.2, Mataram – NTB' }}</span>
            </li>
            <li class="flex items-center gap-3">
              <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center shrink-0"><i class="fa fa-phone text-xs"></i></div>
              <span>{{ $content['contact_phone'] ?? '+62 813 3280 9923' }}</span>
            </li>
            <li class="flex items-center gap-3">
              <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center shrink-0"><i class="fa fa-envelope text-xs"></i></div>
              <span>{{ $content['contact_email'] ?? 'info@nustech.co.id' }}</span>
            </li>
            <li class="flex items-center gap-3">
              <div class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center shrink-0"><i class="fa-brands fa-instagram text-xs"></i></div>
              <a href="https://www.instagram.com/nustech.co.id/" target="_blank" class="hover:text-white hover:underline transition">nustech.co.id</a>
            </li>
          </ul>
        </div>

        <!-- Map -->
        <div>
          <h4 class="font-heading font-bold text-sm tracking-wider uppercase text-sky-400 mb-6 flex items-center gap-2">
            <span class="w-1 h-4 rounded-full bg-sky-500"></span> Lokasi Kami
          </h4>
          <div class="h-44 rounded-2xl overflow-hidden border border-white/10 shadow-lg relative">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.143719001391!2d116.1084288!3d-8.5835905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdbf5c5cfc2c43%3A0xe1db0920404470d0!2sJl.%20Semangka%2C%20Mataram%20Bar.%2C%20Kec.%20Selaparang%2C%20Kota%20Mataram%2C%20Nusa%20Tenggara%20Bar.!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0 absolute inset-0" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>

      </div>

      <!-- Bottom Bar -->
      <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-600 gap-4">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-circle text-[6px] text-sky-500/50"></i>
          <span>&copy; {{ date('Y') }} CV. NUSTECH. All Rights Reserved.</span>
        </div>
        <div class="flex items-center gap-5">
          <a href="#" class="hover:text-slate-300 hover:underline transition-colors duration-200">Syarat & Ketentuan</a>
          <span class="text-slate-700">|</span>
          <a href="#" class="hover:text-slate-300 hover:underline transition-colors duration-200">Kebijakan Privasi</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- WhatsApp Floating Button -->
  <a href="https://wa.me/6281332809923?text=Halo%20CV.%20Nustech%2C%20saya%20ingin%20berdiskusi%20mengenai%20layanan%20pengadaan%20IT%2Fjasa." target="_blank" class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-400 text-white rounded-full p-4 shadow-2xl shadow-emerald-500/30 flex items-center gap-2 hover:-translate-y-1.5 transition-all duration-300 group">
    <svg class="w-6 h-6 fill-current flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
      <path d="M16.001 3C9.374 3 4 8.374 4 15.001c0 2.646.99 5.072 2.615 6.957L4 29l7.28-2.56A11.956 11.956 0 0 0 16 27c6.627 0 12-5.373 12-11.999S22.627 3 16.001 3zm0 22c-1.484 0-2.891-.373-4.125-1.033l-.29-.162-4.336 1.524 1.478-4.214-.186-.3a8.953 8.953 0 0 1-1.542-5.019c0-4.962 4.037-9 9-9 4.961 0 9 4.038 9 9s-4.039 9-9 9zm5.533-6.529c-.306-.154-1.801-.889-2.08-.991-.278-.102-.48-.153-.683.154-.202.306-.784.991-.961 1.193-.177.202-.355.229-.66.076-.305-.152-1.29-.475-2.455-1.516-.906-.807-1.516-1.802-1.693-2.107-.177-.306-.018-.471.135-.623.138-.138.305-.354.457-.531.152-.178.203-.305.305-.509.101-.203.05-.381-.025-.533-.076-.152-.683-1.646-.935-2.25-.245-.59-.494-.51-.683-.52-.178-.01-.381-.012-.584-.012s-.533.076-.813.38c-.278.305-1.066 1.04-1.066 2.531 0 1.491 1.092 2.932 1.244 3.134.152.203 2.149 3.275 5.209 4.592.728.313 1.296.5 1.738.64.73.232 1.394.2 1.919.122.585-.087 1.801-.735 2.057-1.447.253-.71.253-1.319.177-1.447-.076-.127-.278-.202-.584-.355z" />
    </svg>
    <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-500 ease-out font-bold text-xs whitespace-nowrap">Hubungi Kami</span>
  </a>

  <!-- Swiper.js JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- ======================================================
       SCRIPTS
  ====================================================== -->
  <script>
    // 1. Navbar Scroll Effect
    const navbar       = document.getElementById('navbar');
    const navCapsule   = document.getElementById('navCapsule');
    const brandText    = document.getElementById('navBrandText');
    const logoArrow    = document.getElementById('logoArrow');
    const hamburgerIcon = document.getElementById('hamburgerIcon');

    window.addEventListener('scroll', () => {
      if (window.scrollY > 60) {
        navbar.classList.add('py-2');
        navCapsule.classList.remove('bg-white/10', 'border-white/20');
        navCapsule.classList.add('bg-white/92', 'backdrop-blur-2xl', 'border-slate-200/50', 'shadow-2xl');
        if (brandText)     brandText.style.color    = '#0f172a';
        if (logoArrow)     logoArrow.style.color     = '#0f172a';
        if (hamburgerIcon) hamburgerIcon.style.color = '#0f172a';
        document.querySelectorAll('.nav-link').forEach(link => {
          link.classList.remove('text-white', 'hover:text-sky-300', 'hover:bg-white/10');
          link.classList.add('text-slate-700', 'hover:text-sky-600', 'hover:bg-sky-50');
        });
        document.querySelectorAll('#layananToggle').forEach(btn => {
          btn.classList.remove('text-white', 'hover:text-sky-300', 'hover:bg-white/10');
          btn.classList.add('text-slate-700', 'hover:text-sky-600', 'hover:bg-sky-50');
        });
      } else {
        navbar.classList.remove('py-2');
        navCapsule.classList.remove('bg-white/92', 'backdrop-blur-2xl', 'border-slate-200/50', 'shadow-2xl');
        navCapsule.classList.add('bg-white/10', 'border-white/20');
        if (brandText)     brandText.style.color    = '#ffffff';
        if (logoArrow)     logoArrow.style.color     = 'rgba(255,255,255,0.7)';
        if (hamburgerIcon) hamburgerIcon.style.color = '#ffffff';
        document.querySelectorAll('.nav-link').forEach(link => {
          link.classList.remove('text-slate-700', 'hover:text-sky-600', 'hover:bg-sky-50');
          link.classList.add('text-white', 'hover:text-sky-300', 'hover:bg-white/10');
        });
        document.querySelectorAll('#layananToggle').forEach(btn => {
          btn.classList.remove('text-slate-700', 'hover:text-sky-600', 'hover:bg-sky-50');
          btn.classList.add('text-white', 'hover:text-sky-300', 'hover:bg-white/10');
        });
      }
    });

    // 2. Logo Dropdown
    const logoToggle        = document.getElementById('logoToggle');
    const loginDropdownMenu = document.getElementById('loginDropdownMenu');
    const logoArrowSvg      = document.getElementById('logoArrow');

    if (logoToggle && loginDropdownMenu) {
      logoToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = loginDropdownMenu.classList.contains('hidden');
        if (isHidden) {
          loginDropdownMenu.classList.remove('hidden');
          setTimeout(() => {
            loginDropdownMenu.classList.remove('opacity-0', 'translate-y-[-10px]');
            loginDropdownMenu.classList.add('opacity-100', 'translate-y-0');
            logoArrowSvg.classList.add('rotate-180');
          }, 10);
        } else {
          hideLogoDropdown();
        }
      });

      function hideLogoDropdown() {
        loginDropdownMenu.classList.remove('opacity-100', 'translate-y-0');
        loginDropdownMenu.classList.add('opacity-0', 'translate-y-[-10px]');
        logoArrowSvg.classList.remove('rotate-180');
        setTimeout(() => { loginDropdownMenu.classList.add('hidden'); }, 300);
      }

      document.addEventListener('click', (e) => {
        if (!logoToggle.contains(e.target) && !loginDropdownMenu.contains(e.target)) {
          hideLogoDropdown();
        }
      });
    }

    // 3. Layanan Mega Dropdown
    const layananDropdownEl = document.getElementById('layananDropdown');
    const layananMenuEl     = document.getElementById('layananMenu');
    const layananArrowEl    = document.getElementById('layananArrow');
    let hideTimeout;

    if (layananDropdownEl && layananMenuEl) {
      const showMenu = () => {
        clearTimeout(hideTimeout);
        layananMenuEl.classList.remove('hidden');
        setTimeout(() => {
          layananMenuEl.classList.remove('opacity-0', 'translate-y-[-10px]');
          layananMenuEl.classList.add('opacity-100', 'translate-y-0');
          layananArrowEl.classList.add('rotate-180');
        }, 10);
      };
      const hideMenu = () => {
        hideTimeout = setTimeout(() => {
          layananMenuEl.classList.remove('opacity-100', 'translate-y-0');
          layananMenuEl.classList.add('opacity-0', 'translate-y-[-10px]');
          layananArrowEl.classList.remove('rotate-180');
          setTimeout(() => {
            if (layananMenuEl.classList.contains('opacity-0')) {
              layananMenuEl.classList.add('hidden');
            }
          }, 300);
        }, 150);
      };
      layananDropdownEl.addEventListener('mouseenter', showMenu);
      layananDropdownEl.addEventListener('mouseleave', hideMenu);
      layananMenuEl.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
      layananMenuEl.addEventListener('mouseleave', hideMenu);
      layananMenuEl.querySelectorAll('button, a').forEach(el => {
        el.addEventListener('click', () => {
          layananMenuEl.classList.add('opacity-0', 'translate-y-[-10px]');
          layananArrowEl.classList.remove('rotate-180');
          setTimeout(() => layananMenuEl.classList.add('hidden'), 300);
        });
      });
    }

    // 4. Mobile Menu
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuToggle && mobileMenu) {
      menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        mobileMenu.classList.toggle('hidden');
      });
      mobileMenu.querySelectorAll('.mobile-nav-link, a[href^="#"]').forEach(link => {
        link.addEventListener('click', () => { mobileMenu.classList.add('hidden'); });
      });
    }

    // 5. Layanan Tabs
    function showLayanan(id, autoScroll = true) {
      document.querySelectorAll('.layanan-item').forEach(item => { item.classList.add('hidden'); });
      const target = document.getElementById(id);
      if (target) target.classList.remove('hidden');

      document.querySelectorAll('.layanan-tab-btn').forEach(btn => {
        btn.classList.remove('tab-btn-active');
        btn.classList.add('text-slate-600');
        btn.classList.remove('text-white');
        const i = btn.querySelector('i');
        if (i) { i.classList.add('text-sky-500'); i.classList.remove('text-white'); }
      });
      const activeBtn = document.getElementById('tab-' + id);
      if (activeBtn) {
        activeBtn.classList.add('tab-btn-active');
        activeBtn.classList.remove('text-slate-600');
        activeBtn.classList.add('text-white');
        const icon = activeBtn.querySelector('i');
        if (icon) { icon.classList.remove('text-sky-500'); icon.classList.add('text-white'); }
      }

      if (autoScroll) {
        const layananSection = document.getElementById('layanan');
        if (layananSection) layananSection.scrollIntoView({ behavior: 'smooth' });
      }
    }

    // 6. Swiper Portfolio Initialization & Layanan Tabs
    let portfolioSwiper;
    document.addEventListener("DOMContentLoaded", () => {
      showLayanan('networking', false);

      portfolioSwiper = new Swiper('.portfolioSwiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        speed: 1200, // Mengatur kecepatan agar halus (1.2s)
        coverflowEffect: {
          rotate: 0,
          stretch: 0,
          depth: 100,
          modifier: 2.5,
          slideShadows: false,
        },
        navigation: {
          nextEl: '#portfolio-next',
          prevEl: '#portfolio-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          dynamicBullets: true,
        },
        autoplay: {
          delay: 3500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        slideToClickedSlide: true, // Memastikan gambar yang diklik pindah ke tengah
        on: {
          init: function () {
            // Menambahkan custom easing agar transisi SANGAT HALUS
            this.wrapperEl.style.transitionTimingFunction = 'cubic-bezier(0.25, 1, 0.5, 1)';
          },
          click: function(swiper, event) {
            const slide = event.target.closest('.swiper-slide');
            if (!slide) return;
            
            // Cek apakah slide yang diklik sudah active (berada di tengah)
            if (slide.classList.contains('swiper-slide-active')) {
              openLightbox(slide);
            } else {
              swiper.slideTo(swiper.clickedIndex);
            }
          }
        }
      });

      // Swiper for Berita Umum
      new Swiper('.generalNewsSwiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        speed: 1000,
        coverflowEffect: {
          rotate: 5,
          stretch: 0,
          depth: 50,
          modifier: 2,
          slideShadows: false,
        },
        navigation: {
          nextEl: '#general-next',
          prevEl: '#general-prev',
        },
        pagination: {
          el: '.general-news-pagination',
          clickable: true,
          dynamicBullets: true,
        },
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        slideToClickedSlide: true,
        on: {
          init: function () {
            this.wrapperEl.style.transitionTimingFunction = 'cubic-bezier(0.25, 1, 0.5, 1)';
          },
          click: function(swiper, event) {
            const slide = event.target.closest('.swiper-slide');
            if (!slide) return;
            // Prevent opening lightbox if it has an instagram embed
            if (slide.querySelector('blockquote.instagram-media')) return;

            if (slide.classList.contains('swiper-slide-active') && slide.getAttribute('data-image')) {
              openLightbox(slide);
            } else {
              swiper.slideTo(swiper.clickedIndex);
            }
          }
        }
      });

      // Swiper for Instagram News
      new Swiper('.instagramNewsSwiper', {
        effect: 'coverflow',
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: 'auto',
        loop: true,
        speed: 1000,
        coverflowEffect: {
          rotate: 5,
          stretch: 0,
          depth: 50,
          modifier: 2,
          slideShadows: false,
        },
        navigation: {
          nextEl: '#ig-next',
          prevEl: '#ig-prev',
        },
        pagination: {
          el: '.instagram-news-pagination',
          clickable: true,
          dynamicBullets: true,
        },
        autoplay: {
          delay: 4500,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        slideToClickedSlide: true,
        on: {
          init: function () {
            this.wrapperEl.style.transitionTimingFunction = 'cubic-bezier(0.25, 1, 0.5, 1)';
          },
          click: function(swiper, event) {
            const slide = event.target.closest('.swiper-slide');
            if (!slide) return;
            if (slide.querySelector('blockquote.instagram-media')) return;

            if (slide.classList.contains('swiper-slide-active') && slide.getAttribute('data-image')) {
              openLightbox(slide);
            } else {
              swiper.slideTo(swiper.clickedIndex);
            }
          }
        }
      });
    });

    // 6b. Image Lightbox (smooth zoom animation)
    function openLightbox(element) {
      const imgUrl   = element.getAttribute('data-image');
      const category = element.getAttribute('data-category');
      const title    = element.getAttribute('data-title');
      const desc     = element.getAttribute('data-desc');

      const modal    = document.getElementById('imageLightboxModal');
      const box      = document.getElementById('lightboxModalBox');
      const closeBtn = document.getElementById('lightboxCloseBtn');

      document.getElementById('lightboxImage').src = imgUrl;
      document.getElementById('lightboxCategory').textContent = category;
      document.getElementById('lightboxTitle').textContent = title;
      document.getElementById('lightboxDesc').textContent = desc;

      // Show modal
      modal.classList.remove('hidden');
      void modal.offsetWidth; // force reflow

      // Animate backdrop
      modal.style.background = 'rgba(2,8,23,0.92)';
      modal.style.backdropFilter = 'blur(12px)';

      // Animate box with zoom
      box.classList.remove('lightbox-zoom-out');
      box.classList.add('lightbox-zoom-in');

      // Show close button
      closeBtn.style.opacity = '1';

      document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
      const modal    = document.getElementById('imageLightboxModal');
      const box      = document.getElementById('lightboxModalBox');
      const closeBtn = document.getElementById('lightboxCloseBtn');

      // Animate backdrop out
      modal.style.background = 'rgba(2,8,23,0)';
      modal.style.backdropFilter = 'blur(0px)';

      // Animate box out
      box.classList.remove('lightbox-zoom-in');
      box.classList.add('lightbox-zoom-out');

      // Hide close button
      closeBtn.style.opacity = '0';

      setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('lightboxImage').src = '';
      }, 400);
    }

    // Keyboard ESC to close lightbox
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const modal = document.getElementById('imageLightboxModal');
        if (modal && !modal.classList.contains('hidden')) {
          closeLightbox();
        }
      }
    });

    // 7. Stats Counter
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const el     = entry.target;
          const target = parseInt(el.getAttribute('data-count'));
          if (target && !el.dataset.counted) {
            el.dataset.counted = 'true';
            let current  = 0;
            const duration = 2000;
            const step   = Math.max(1, Math.floor(target / (duration / 30)));
            const timer  = setInterval(() => {
              current += step;
              if (current >= target) { current = target; clearInterval(timer); }
              el.textContent = current + '+';
            }, 30);
          }
        }
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('.stat-number').forEach(el => statsObserver.observe(el));

    // 8. Scroll Reveal
    const revealObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.10 });
    document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => revealObserver.observe(el));

    // 9. Modals Animation Logic
    function openModalGen(modalId, boxId) {
      const modal = document.getElementById(modalId);
      const box   = document.getElementById(boxId);
      modal.classList.remove('hidden');
      
      // Force browser reflow to enable transition from hidden state
      void modal.offsetWidth;

      modal.classList.remove('opacity-0'); 
      modal.classList.add('opacity-100'); 
      
      box.classList.remove('scale-95', 'translate-y-8', 'opacity-0'); 
      box.classList.add('scale-100', 'translate-y-0', 'opacity-100');
      
      document.body.style.overflow = 'hidden';
    }

    function closeModalGen(modalId, boxId) {
      const modal = document.getElementById(modalId);
      const box   = document.getElementById(boxId);
      
      modal.classList.remove('opacity-100'); 
      modal.classList.add('opacity-0');
      
      box.classList.remove('scale-100', 'translate-y-0', 'opacity-100');     
      box.classList.add('scale-95', 'translate-y-8', 'opacity-0');
      
      setTimeout(() => { 
        modal.classList.add('hidden'); 
        document.body.style.overflow = ''; 
      }, 400); // Wait for transition to finish
    }

    // Modal Triggers
    function openModal() { openModalGen('modalTentang', 'modalTentangBox'); }
    function closeModal() { closeModalGen('modalTentang', 'modalTentangBox'); }

    function openJaringanModal() { openModalGen('jaringanModal', 'jaringanModalBox'); }
    function closeJaringanModal() { closeModalGen('jaringanModal', 'jaringanModalBox'); }

    function openVsatModal() { openModalGen('vsatModal', 'vsatModalBox'); }
    function closeVsatModal() { closeModalGen('vsatModal', 'vsatModalBox'); }

    function openBasebandModal() { openModalGen('basebandModal', 'basebandModalBox'); }
    function closeBasebandModal() { closeModalGen('basebandModal', 'basebandModalBox'); }

    function openCctvModal() { openModalGen('cctvModal', 'cctvModalBox'); }
    function closeCctvModal() { closeModalGen('cctvModal', 'cctvModalBox'); }

    function openAplikasiSoftwareModal() { openModalGen('aplikasiSoftwareModal', 'aplikasiSoftwareModalBox'); }
    function closeAplikasiSoftwareModal() { closeModalGen('aplikasiSoftwareModal', 'aplikasiSoftwareModalBox'); }

    function openAplikasiJasaModal() { openModalGen('aplikasiJasaModal', 'aplikasiJasaModalBox'); }
    function closeAplikasiJasaModal() { closeModalGen('aplikasiJasaModal', 'aplikasiJasaModalBox'); }

    function openReklameDesainModal() { openModalGen('reklameDesainModal', 'reklameDesainModalBox'); }
    function closeReklameDesainModal() { closeModalGen('reklameDesainModal', 'reklameDesainModalBox'); }

    function openReklameCetakModal() { openModalGen('reklameCetakModal', 'reklameCetakModalBox'); }
    function closeReklameCetakModal() { closeModalGen('reklameCetakModal', 'reklameCetakModalBox'); }

    function openKelistrikanSistemModal() { openModalGen('kelistrikanSistemModal', 'kelistrikanSistemModalBox'); }
    function closeKelistrikanSistemModal() { closeModalGen('kelistrikanSistemModal', 'kelistrikanSistemModalBox'); }

    function openAcPemasanganModal() { openModalGen('acPemasanganModal', 'acPemasanganModalBox'); }
    function closeAcPemasanganModal() { closeModalGen('acPemasanganModal', 'acPemasanganModalBox'); }

    function openAcMaintenanceModal() { openModalGen('acMaintenanceModal', 'acMaintenanceModalBox'); }
    function closeAcMaintenanceModal() { closeModalGen('acMaintenanceModal', 'acMaintenanceModalBox'); }

    function openKomputerPengadaanModal() { openModalGen('komputerPengadaanModal', 'komputerPengadaanModalBox'); }
    function closeKomputerPengadaanModal() { closeModalGen('komputerPengadaanModal', 'komputerPengadaanModalBox'); }

    function openKomputerPerawatanModal() { openModalGen('komputerPerawatanModal', 'komputerPerawatanModalBox'); }
    function closeKomputerPerawatanModal() { closeModalGen('komputerPerawatanModal', 'komputerPerawatanModalBox'); }

    function openElektronikPenyediaanModal() { openModalGen('elektronikPenyediaanModal', 'elektronikPenyediaanModalBox'); }
    function closeElektronikPenyediaanModal() { closeModalGen('elektronikPenyediaanModal', 'elektronikPenyediaanModalBox'); }

    function openKantorPenyediaanModal() { openModalGen('kantorPenyediaanModal', 'kantorPenyediaanModalBox'); }
    function closeKantorPenyediaanModal() { closeModalGen('kantorPenyediaanModal', 'kantorPenyediaanModalBox'); }

    function openKantorPerawatanModal() { openModalGen('kantorPerawatanModal', 'kantorPerawatanModalBox'); }
    function closeKantorPerawatanModal() { closeModalGen('kantorPerawatanModal', 'kantorPerawatanModalBox'); }
  </script>
</body>

</html>
