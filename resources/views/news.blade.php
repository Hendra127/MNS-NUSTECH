<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
  @include('partials.pwa-head')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CV. Nustech â€“ Solusi IT, Pengadaan & Engineering NTB</title>
  <meta name="description" content="CV. Nustech â€“ Penyedia solusi teknologi informasi, pengadaan barang, kelistrikan, dan engineering terpercaya di Nusa Tenggara Barat.">

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
      <div id="navCapsule" class="mx-auto max-w-5xl rounded-full bg-white/95 backdrop-blur-2xl border-slate-200/50 shadow-md shadow-lg px-6 py-2.5 transition-all duration-500 flex items-center justify-between">

        <!-- Logo & Brand Toggle -->
        <div class="relative" id="logoDropdownWrapper">
          <button id="logoToggle" class="flex items-center gap-2.5 focus:outline-none cursor-pointer group py-1">
            <div class="relative">
              <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo CV. Nustech" class="h-9 w-9 rounded-full shadow-lg transition-transform duration-700 group-hover:rotate-[360deg] border-2 border-white/30">
              <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-white animate-pulse"></div>
            </div>
            <span class="text-slate-900 font-heading font-extrabold text-lg tracking-tight transition-colors duration-300" id="navBrandText">NUSTECH</span>
            <svg class="w-3.5 h-3.5 text-slate-800 transition-transform duration-300 ml-0.5" id="logoArrow" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
        <!-- DROPDOWN LOGIN -->
        <div id="loginDropdownMenu" class="absolute left-0 mt-4 hidden opacity-0 translate-y-[-10px] transition-all duration-300 w-72 bg-white/95 backdrop-blur-xl rounded-2xl border border-slate-200/60 shadow-xl overflow-hidden" style="z-index: 100;">
          <!-- Header -->
          <div class="px-5 pt-5 pb-3">
            <div class="flex items-center gap-3 mb-1">
              <div class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center">
                <i class="fa-solid fa-right-to-bracket text-sm"></i>
              </div>
              <div>
                <h4 class="text-sm font-bold text-slate-800 tracking-tight">Portal Login</h4>
                <p class="text-[10px] text-slate-500 font-medium">Pilih akses portal</p>
              </div>
            </div>
          </div>

          <!-- Divider -->
          <div class="h-px bg-slate-100 mx-5"></div>

          <!-- Portal Items -->
          <div class="p-3 flex flex-col gap-1">
            <!-- MNS Nustech -->
            <a href="http://mns.nustech.co.id/login" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-slate-100 hover:bg-slate-50 transition-all duration-300 group">
              <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 group-hover:bg-sky-50 group-hover:text-sky-600 flex items-center justify-center text-lg transition-colors shrink-0">
                <i class="fa-solid fa-chart-line"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">
                  MNS Nustech
                </div>
                <div class="text-[10px] text-slate-500 mt-0.5">Monitoring & Network</div>
              </div>
              <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-sky-600 group-hover:translate-x-1 transition-all"></i>
            </a>

            <!-- Engineering -->
            <a href="http://enginering.nustech.co.id/login" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-slate-100 hover:bg-slate-50 transition-all duration-300 group">
              <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 group-hover:bg-sky-50 group-hover:text-sky-600 flex items-center justify-center text-lg transition-colors shrink-0">
                <i class="fa-solid fa-gears"></i>
              </div>
              <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">
                  Engineering
                </div>
                <div class="text-[10px] text-slate-500 mt-0.5">Inventory System</div>
              </div>
              <i class="fa-solid fa-arrow-right text-[10px] text-slate-400 group-hover:text-sky-600 group-hover:translate-x-1 transition-all"></i>
            </a>
          </div>
          
          <!-- Footer -->
          <div class="bg-slate-50 px-5 py-3 flex items-center justify-center gap-2 border-t border-slate-100">
            <i class="fa-solid fa-lock text-[9px] text-slate-400"></i>
            <span class="text-[10px] text-slate-500 font-medium">Koneksi aman & terenkripsi</span>
          </div>
        </div>
      </div>

      <!-- MENU DESKTOP -->
      <div class="hidden md:flex items-center space-x-1">
        <a href="#beranda" class="nav-link text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">Beranda</a>
        <a href="#tentang" class="nav-link text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">Tentang</a>
        <a href="#visimisi" class="nav-link text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">Visi Misi</a>

        <div id="layananDropdown" class="relative">
          <button id="layananToggle" class="text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200 flex items-center gap-1 cursor-pointer focus:outline-none">
            Layanan
            <svg class="w-3 h-3 transition-transform duration-300" id="layananArrow" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- MEGA MENU -->
          <div id="layananMenu" class="fixed left-1/2 -translate-x-1/2 w-[90vw] max-w-4xl bg-white/95 backdrop-blur-xl shadow-xl rounded-2xl border border-slate-200/60 hidden opacity-0 translate-y-[-10px] transition-all duration-300 overflow-hidden mt-4" style="z-index: 100;">
            <div class="p-6 md:p-8">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Col 1 -->
                <div>
                  <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    Layanan Utama
                  </h4>
                  <div class="flex flex-col gap-1">
                    <button onclick="showLayanan('networking')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-network-wired"></i></div>
                      <div><div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Networking</div><div class="text-[10px] text-slate-500">Jaringan & Mikrotik</div></div>
                    </button>
                    <button onclick="showLayanan('aplikasi')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-code"></i></div>
                      <div><div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Aplikasi</div><div class="text-[10px] text-slate-500">Web & Software</div></div>
                    </button>
                    <button onclick="showLayanan('reklame')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-palette"></i></div>
                      <div><div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Reklame</div><div class="text-[10px] text-slate-500">Promo & Percetakan</div></div>
                    </button>
                    <button onclick="showLayanan('kelistrikan')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-bolt"></i></div>
                      <div><div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Kelistrikan</div><div class="text-[10px] text-slate-500">Instalasi & Panel Listrik</div></div>
                    </button>
                  </div>
                </div>

                <!-- Col 2 -->
                <div>
                  <h4 class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-4 flex items-center gap-2">
                    Pendukung
                  </h4>
                  <div class="flex flex-col gap-1">
                    <button onclick="showLayanan('ac')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-snowflake"></i></div>
                      <div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Pendingin Ruangan (AC)</div>
                    </button>
                    <button onclick="showLayanan('komputer')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-print"></i></div>
                      <div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Komputer & Printer</div>
                    </button>
                    <button onclick="showLayanan('elektronik')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-tv"></i></div>
                      <div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Alat Elektronik</div>
                    </button>
                    <button onclick="showLayanan('kantor')" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 text-left transition duration-300 group border border-transparent hover:border-slate-100">
                      <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center text-sm group-hover:bg-sky-50 group-hover:text-sky-600 transition-colors"><i class="fa-solid fa-briefcase"></i></div>
                      <div class="text-xs font-semibold text-slate-800 group-hover:text-sky-600 transition-colors">Peralatan Kantor</div>
                    </button>
                  </div>
                </div>

                <!-- Col 3 -->
                <div class="bg-slate-50 border border-slate-100 p-6 rounded-2xl flex flex-col justify-between relative overflow-hidden">
                  <div>
                    <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600 mb-4 text-lg">
                      <i class="fa-solid fa-headset"></i>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800 mb-2">Butuh Konsultasi?</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed mb-6">Konsultasikan kebutuhan teknis proyek IT dan pengadaan barang Anda bersama tim ahli kami.</p>
                  </div>
                  <div class="flex flex-col gap-3 relative z-10">
                    <a href="https://wa.me/6281332809923" target="_blank" class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white py-2.5 px-4 rounded-xl text-xs font-semibold transition-colors shadow-sm">
                      <i class="fa-brands fa-whatsapp text-sm"></i> WhatsApp Kami
                    </a>
                    <a href="#kontak" class="text-center text-[11px] text-slate-500 hover:text-sky-600 font-medium transition-colors">Lihat Kontak Lainnya →</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <a href="#gallery" class="nav-link text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">Galeri</a>
        <a href="#news" class="nav-link text-slate-800 hover:text-sky-600 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg hover:bg-slate-100 transition-all duration-200">Berita</a>
        <a href="#kontak" class="ml-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold px-5 py-2.5 rounded-full transition-colors shadow-sm">Kontak</a>
      </div>

      <!-- Hamburger (Mobile) -->
      <div class="md:hidden flex items-center">
        <button id="menu-toggle" type="button" class="focus:outline-none p-2 -mr-2 cursor-pointer">
          <svg id="hamburgerIcon" class="w-6 h-6 text-slate-800 pointer-events-none transition-colors duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="md:hidden hidden mx-4 mt-3 bg-white/95 backdrop-blur-xl rounded-2xl shadow-xl border border-slate-200/60 overflow-hidden transition-all duration-300 p-4">
    <div class="flex flex-col gap-1">
      <a href="#beranda" class="p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-sky-600 font-medium transition-colors flex items-center gap-3"><i class="fa-solid fa-house text-slate-400 text-sm w-5 text-center"></i>Beranda</a>
      <a href="#tentang" class="p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-sky-600 font-medium transition-colors flex items-center gap-3"><i class="fa-solid fa-building text-slate-400 text-sm w-5 text-center"></i>Tentang Kami</a>
      <a href="#visimisi" class="p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-sky-600 font-medium transition-colors flex items-center gap-3"><i class="fa-solid fa-bullseye text-slate-400 text-sm w-5 text-center"></i>Visi & Misi</a>

      <!-- Mobile Layanan -->
      <div class="rounded-xl overflow-hidden bg-slate-50/50 border border-slate-100">
        <button onclick="document.getElementById('mobileLayananMenu').classList.toggle('hidden'); document.getElementById('mobileLayananArrow').classList.toggle('rotate-180')" class="w-full flex items-center justify-between p-3 text-left font-medium text-slate-700 hover:bg-slate-50 transition-colors focus:outline-none">
          <span class="flex items-center gap-3"><i class="fa-solid fa-concierge-bell text-slate-400 text-sm w-5 text-center"></i>Layanan</span>
          <svg id="mobileLayananArrow" class="w-4 h-4 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobileLayananMenu" class="hidden flex flex-col bg-white/50 border-t border-slate-100 p-1.5 gap-1">
          <button onclick="showLayanan('networking')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Networking</button>
          <button onclick="showLayanan('aplikasi')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Aplikasi</button>
          <button onclick="showLayanan('reklame')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Reklame</button>
          <button onclick="showLayanan('kelistrikan')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Kelistrikan</button>
          <button onclick="showLayanan('ac')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Pendingin Ruangan (AC)</button>
          <button onclick="showLayanan('komputer')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Komputer & Printer</button>
          <button onclick="showLayanan('elektronik')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Alat Elektronik</button>
          <button onclick="showLayanan('kantor')" class="w-full text-left p-2.5 rounded-lg text-sm text-slate-600 hover:text-sky-600 hover:bg-slate-50 transition-colors">Peralatan Kantor</button>
        </div>
      </div>

      <!-- Mobile Login -->
      <div class="rounded-xl overflow-hidden bg-slate-50/50 border border-slate-100 mt-1">
        <button onclick="document.getElementById('mobileLoginMenu').classList.toggle('hidden'); document.getElementById('mobileLoginArrow').classList.toggle('rotate-180')" class="w-full flex items-center justify-between p-3 text-left font-medium text-slate-700 hover:bg-slate-50 transition-colors focus:outline-none">
          <span class="flex items-center gap-3">
            <i class="fa-solid fa-right-to-bracket text-slate-400 text-sm w-5 text-center"></i>
            <span>Login Portal</span>
          </span>
          <svg id="mobileLoginArrow" class="w-4 h-4 text-slate-400 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
          </svg>
        </button>
        <div id="mobileLoginMenu" class="hidden flex flex-col bg-white/50 border-t border-slate-100 p-2 gap-2">
          <a href="http://mns.nustech.co.id/login" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-slate-100 hover:bg-slate-50 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center text-lg shrink-0">
              <i class="fa-solid fa-chart-line"></i>
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-slate-800">MNS Nustech</div>
              <div class="text-[10px] text-slate-500 mt-0.5">Monitoring & Network</div>
            </div>
          </a>
          <a href="http://enginering.nustech.co.id/login" target="_blank" class="flex items-center gap-3 p-3 rounded-xl border border-transparent hover:border-slate-100 hover:bg-slate-50 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center text-lg shrink-0">
              <i class="fa-solid fa-gears"></i>
            </div>
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold text-slate-800">Engineering</div>
              <div class="text-[10px] text-slate-500 mt-0.5">Inventory System</div>
            </div>
          </a>
        </div>
      </div>

      <a href="#gallery" class="p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-sky-600 font-medium transition-colors flex items-center gap-3 mt-1"><i class="fa-solid fa-images text-slate-400 text-sm w-5 text-center"></i>Galeri</a>
      <a href="#news" class="p-3 rounded-xl hover:bg-slate-50 text-slate-700 hover:text-sky-600 font-medium transition-colors flex items-center gap-3"><i class="fa-brands fa-instagram text-slate-400 text-sm w-5 text-center"></i>Berita</a>
      <a href="#kontak" class="mt-2 bg-sky-500 hover:bg-sky-600 text-white font-semibold text-sm py-3 px-5 rounded-xl text-center transition-colors shadow-sm">Kontak Kami</a>
    </div>
  </div>
      </div>
    </div>
  </nav>

  <div class="pt-32 pb-20 bg-slate-50 min-h-screen">
  <div class="max-w-[95%] 2xl:max-w-[90%] mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between mb-8 border-b-2 border-slate-200 pb-4">
        <h1 class="text-4xl font-heading font-black text-slate-900 border-b-4 border-red-600 -mb-[22px] pb-4">Portal <span class="bg-gradient-to-r from-sky-500 to-blue-600 bg-clip-text text-transparent">Berita</span></h1>
        <a href="{{ route('home') }}" class="text-sm font-bold text-slate-500 hover:text-sky-600 transition-colors"><i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Beranda</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 mt-8">
      
      <!-- KIRI: TERKINI (span 8) -->
      <div class="lg:col-span-8">
        <div class="flex items-center justify-between border-b-2 border-slate-200 pb-3 mb-6">
           <h2 class="text-2xl font-black text-slate-900 border-b-4 border-red-600 -mb-[19px] pb-3">Terkini</h2>
        </div>

        @if($heroNews)
          <!-- HERO NEWS -->
          <a href="{{ route('news.show', $heroNews->id) }}" class="block group mb-8 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-300">
            <div class="relative h-[300px] sm:h-[400px] lg:h-[480px] w-full overflow-hidden">
              @if(!empty($heroNews->image_path))
                <img src="{{ asset($heroNews->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
              @else
                <div class="w-full h-full bg-gradient-to-tr from-sky-100 to-blue-50 flex items-center justify-center text-sky-800 opacity-50">
                  <i class="fa-regular fa-newspaper text-6xl"></i>
                </div>
              @endif
              <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/40 to-transparent"></div>
              <div class="absolute bottom-0 left-0 p-6 sm:p-8 w-full">
                <div class="mb-3"><span class="bg-red-600 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1 rounded">Berita Utama</span></div>
                <h3 class="text-white text-2xl sm:text-3xl font-heading font-bold leading-tight group-hover:text-sky-300 transition-colors mb-2">{{ $heroNews->title }}</h3>
                <div class="text-slate-300 text-xs font-medium flex items-center gap-3">
                  <span><i class="fa-regular fa-calendar mr-1"></i> {{ $heroNews->published_at ? $heroNews->published_at->diffForHumans() : '' }}</span>
                  <span><i class="fa-regular fa-eye mr-1"></i> {{ $heroNews->views_count }} tayangan</span>
                </div>
              </div>
            </div>
          </a>
        @endif

        <!-- LATEST NEWS GRID -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
          @forelse($latestNews as $news)
            <a href="{{ route('news.show', $news->id) }}" class="flex gap-4 group bg-white p-3 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-sky-200 transition-all">
              <div class="w-1/3 aspect-[4/3] rounded-xl overflow-hidden shrink-0 bg-slate-100 relative">
                 @if(!empty($news->image_path))
                   <img src="{{ asset($news->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                 @else
                   <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fa-regular fa-image text-2xl"></i></div>
                 @endif
              </div>
              <div class="flex-1 flex flex-col justify-center py-1 pr-2">
                 <h4 class="font-heading text-slate-800 font-bold text-sm leading-snug line-clamp-3 group-hover:text-sky-600 transition-colors mb-2">{{ $news->title }}</h4>
                 <div class="flex items-center gap-3 mt-auto">
                   <span class="text-slate-400 text-[10px] font-medium"><i class="fa-regular fa-clock mr-1"></i>{{ $news->published_at ? $news->published_at->diffForHumans() : '' }}</span>
                 </div>
              </div>
            </a>
          @empty
            @if(!$heroNews)
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm">
              <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-4"></i>
              <h4 class="text-slate-500 font-bold text-lg">Belum ada berita.</h4>
            </div>
            @endif
          @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10 flex justify-center">
           {{ $latestNews->links() }}
        </div>
      </div>

      <!-- KANAN: TERPOPULER (span 4) -->
      <div class="lg:col-span-4">
        <div class="border-b-2 border-slate-200 pb-3 mb-6">
           <h2 class="text-2xl font-black text-slate-900 border-b-4 border-red-600 -mb-[19px] inline-block pb-3">Terpopuler</h2>
        </div>

        <div class="flex flex-col gap-5 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
          @forelse($popularNews as $index => $news)
            <a href="{{ route('news.show', $news->id) }}" class="flex gap-4 group items-start {{ !$loop->last ? 'border-b border-slate-100 pb-5' : '' }}">
              <div class="text-3xl font-black text-slate-200 group-hover:text-red-100 transition-colors italic shrink-0 w-8 text-center">
                {{ $index + 1 }}
              </div>
              <div class="w-24 aspect-[4/3] rounded-xl overflow-hidden shrink-0 bg-slate-100">
                 @if(!empty($news->image_path))
                   <img src="{{ asset($news->image_path) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                 @else
                   <div class="w-full h-full flex items-center justify-center text-slate-300"><i class="fa-regular fa-image"></i></div>
                 @endif
              </div>
              <div class="flex-1 pt-1">
                 <h4 class="font-heading text-slate-800 font-bold text-sm leading-snug line-clamp-3 group-hover:text-sky-600 transition-colors mb-2">{{ $news->title }}</h4>
                 <div class="flex items-center gap-3">
                   <span class="text-red-500 text-[10px] font-bold"><i class="fa-solid fa-fire mr-1"></i> {{ $news->views_count }} views</span>
                 </div>
              </div>
            </a>
          @empty
            <div class="text-sm text-slate-500 text-center py-8">Belum ada data berita terpopuler.</div>
          @endforelse
        </div>
        
        <!-- Banner/Ad Placeholder (Optional) -->
        <div class="mt-8 rounded-3xl overflow-hidden aspect-square bg-gradient-to-br from-sky-50 to-blue-50 border border-sky-100 flex flex-col items-center justify-center text-center p-8 relative group cursor-pointer shadow-sm">
          <div class="absolute inset-0 bg-sky-500 opacity-0 group-hover:opacity-5 transition-opacity duration-300"></div>
          <div class="w-16 h-16 rounded-full bg-white text-sky-500 flex items-center justify-center text-2xl mb-4 shadow-sm group-hover:scale-110 transition-transform duration-500"><i class="fa-solid fa-bullhorn"></i></div>
          <h4 class="font-heading font-bold text-lg text-slate-800 mb-2">Space Iklan / Promo</h4>
          <p class="text-xs text-slate-500">Pasang banner promosi atau pengumuman penting di sini.</p>
        </div>
      </div>
      
    </div>
  </div>
</div>
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
              <span class="leading-relaxed">{{ $content['contact_address'] ?? 'Jl. Semangka No.2, Mataram â€“ NTB' }}</span>
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




