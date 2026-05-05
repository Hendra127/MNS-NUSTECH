<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Company Profile - CV. Nustech</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ==================== BASE ==================== */
    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'Plus Jakarta Sans', 'Quicksand', sans-serif;
      color: #1a1a2e;
      overflow-x: hidden;
    }
    #navbar a { font-size: 13px; letter-spacing: 0.3px; }

    /* ==================== ANIMATIONS ==================== */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-40px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(40px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-20px); }
    }
    @keyframes pulse-glow {
      0%, 100% { box-shadow: 0 0 20px rgba(14,165,233,0.3); }
      50% { box-shadow: 0 0 40px rgba(14,165,233,0.6); }
    }
    @keyframes particle-rise {
      0% { transform: translateY(0) scale(1); opacity: 0.6; }
      100% { transform: translateY(-100vh) scale(0); opacity: 0; }
    }
    @keyframes slideRight {
      from { transform: translateY(50%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    @keyframes slideInLeft {
      from { transform: translateX(-50%); opacity: 0; }
      to { transform: translateX(0); opacity: 1; }
    }
    @keyframes countUp { from { opacity: 0; transform: scale(0.5); } to { opacity: 1; transform: scale(1); } }
    @keyframes shimmer { 0% { background-position: -200% 0; } 100% { background-position: 200% 0; } }
    @keyframes zoom { from { transform: scale(0.8); } to { transform: scale(1); } }
    @keyframes scrollGallery { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    .animate-fade-in-up { animation: fadeInUp 1s ease-out both; }
    .animate-fade { animation: fadeInUp 0.6s ease forwards; }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-float-slow { animation: float 8s ease-in-out infinite; }
    .animate-float-slower { animation: float 12s ease-in-out infinite; }
    .animate-slideRight { animation: slideRight 3s ease-out forwards; }
    .animate-slide-in { animation: slideInLeft 2.6s ease-out; }
    .delay-200 { animation-delay: .2s; }
    .delay-400 { animation-delay: .4s; }

    /* ==================== SCROLL REVEAL ==================== */
    .reveal { opacity: 0; transform: translateY(60px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .reveal-left { opacity: 0; transform: translateX(-60px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-left.visible { opacity: 1; transform: translateX(0); }
    .reveal-right { opacity: 0; transform: translateX(60px); transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .reveal-right.visible { opacity: 1; transform: translateX(0); }
    .fade-in-up { opacity: 0; transform: translateY(60px); transition: all 0.8s ease-out; }
    .fade-in-up.visible { opacity: 1; transform: translateY(0); }
    .fade-in-left { opacity: 0; transform: translateX(60px); transition: all 0.8s ease-out; }
    .fade-in-left.visible { transform: translateX(0); opacity: 1; }
    .fade-in-right { opacity: 0; transform: translateX(-60px); transition: all 0.8s ease-out; }
    .fade-in-right.visible { transform: translateX(0); opacity: 1; }

    /* ==================== HERO ==================== */
    .hero-overlay {
      background: linear-gradient(135deg, rgba(2,6,40,0.82) 0%, rgba(14,60,120,0.55) 50%, rgba(14,165,233,0.2) 100%);
    }
    .hero-particle {
      position: absolute;
      width: 6px; height: 6px;
      background: rgba(255,255,255,0.4);
      border-radius: 50%;
      animation: particle-rise linear infinite;
    }
    .hero-cta {
      background: linear-gradient(135deg, #0ea5e9, #0284c7);
      color: white;
      padding: 14px 36px;
      border-radius: 50px;
      font-weight: 700;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 10px;
      transition: all 0.3s;
      animation: pulse-glow 3s infinite;
      text-decoration: none;
    }
    .hero-cta:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 35px rgba(14,165,233,0.5);
    }
    .hero-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: rgba(255,255,255,0.12);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
      padding: 8px 18px;
      border-radius: 50px;
      font-size: 13px;
      color: rgba(255,255,255,0.9);
      margin-bottom: 20px;
    }

    /* ==================== NAVBAR ==================== */
    .nav-link { color: #ffffff; position: relative; transition: color 0.3s ease; font-weight: 600; }
    #navbar.scrolled .nav-link { color: #1a1a2e; }
    .nav-link::after {
      content: ""; position: absolute; bottom: -6px; left: 0; width: 0; height: 2.5px;
      background: linear-gradient(90deg, #0ea5e9, #06b6d4); border-radius: 2px; transition: width 0.3s ease;
    }
    .nav-link:hover::after { width: 100%; }
    #navCapsule.scrolled { background-color: rgba(255,255,255,0.97); backdrop-filter: blur(16px); box-shadow: 0 8px 32px rgba(0,0,0,0.1); }
    #navbar.scrolled #hamburgerIcon { color: #1a1a2e; }

    /* ==================== DROPDOWN (MEGA MENU) ==================== */
    .mega-menu-animate { 
      opacity: 0; 
      visibility: hidden;
      transform: translateY(-15px); 
      transition: all 0.45s cubic-bezier(0.16, 1, 0.3, 1); 
      pointer-events: none;
    }
    .mega-menu-show { 
      opacity: 1; 
      visibility: visible;
      transform: translateY(0); 
      pointer-events: auto;
    }
    #layananArrow.rotate { transform: rotate(180deg); }

    /* Mega Menu Cards */
    .mega-card {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 12px 14px;
      border-radius: 12px;
      background: #f8fafc;
      border: 1px solid transparent;
      transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
      cursor: pointer;
      text-align: left;
      width: 100%;
    }
    .mega-card:hover {
      background: white;
      border-color: #e0f2fe;
      box-shadow: 0 8px 30px rgba(14,165,233,0.1);
      transform: translateY(-3px);
    }
    .mega-card .mega-icon {
      flex-shrink: 0;
      width: 38px; height: 38px;
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      font-size: 15px;
      color: white;
      transition: transform 0.3s;
    }
    .mega-card:hover .mega-icon {
      transform: scale(1.1) rotate(-5deg);
    }
    .mega-card .mega-label {
      font-size: 13.5px;
      font-weight: 700;
      color: #1e293b;
      transition: color 0.3s;
      white-space: nowrap;
    }
    .mega-card:hover .mega-label {
      color: #0284c7;
    }
    .mega-card .mega-desc {
      font-size: 12px;
      color: #94a3b8;
      margin-top: 2px;
      line-height: 1.4;
    }

    /* Support link items */
    .mega-link {
      display: flex;
      align-items: center;
      gap: 12px;
      padding: 10px 14px;
      border-radius: 10px;
      transition: all 0.25s ease;
      cursor: pointer;
      text-align: left;
      width: 100%;
    }
    .mega-link:hover {
      background: #f0f9ff;
    }
    .mega-link .link-icon {
      width: 34px; height: 34px;
      border-radius: 10px;
      background: #f1f5f9;
      display: flex; align-items: center; justify-content: center;
      font-size: 13px;
      color: #64748b;
      transition: all 0.3s;
      flex-shrink: 0;
    }
    .mega-link:hover .link-icon {
      background: linear-gradient(135deg, #0ea5e9, #06b6d4);
      color: white;
    }
    .mega-link .link-text {
      font-size: 13.5px;
      font-weight: 600;
      color: #475569;
      transition: color 0.3s;
    }
    .mega-link:hover .link-text {
      color: #0284c7;
    }

    /* Staggered entrance */
    .mega-stagger { opacity: 0; transform: translateY(12px); }
    .mega-menu-show .mega-stagger {
      animation: megaFadeIn 0.4s ease forwards;
    }
    .mega-menu-show .mega-stagger:nth-child(1) { animation-delay: 0.05s; }
    .mega-menu-show .mega-stagger:nth-child(2) { animation-delay: 0.1s; }
    .mega-menu-show .mega-stagger:nth-child(3) { animation-delay: 0.15s; }
    .mega-menu-show .mega-stagger:nth-child(4) { animation-delay: 0.2s; }
    .mega-menu-show .mega-stagger:nth-child(5) { animation-delay: 0.25s; }
    .mega-menu-show .mega-stagger:nth-child(6) { animation-delay: 0.3s; }
    @keyframes megaFadeIn {
      to { opacity: 1; transform: translateY(0); }
    }

    /* Smooth Scroll Lock */
    body.menu-open {
      overflow: hidden;
    }

    /* ==================== STAT COUNTER ==================== */
    .stat-card {
      background: white;
      border-radius: 16px;
      padding: 24px 20px;
      text-align: center;
      box-shadow: 0 4px 24px rgba(0,0,0,0.06);
      border: 1px solid #f0f0f0;
      transition: all 0.3s;
    }
    .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(14,165,233,0.12); border-color: #bae6fd; }
    .stat-number {
      font-size: 36px; font-weight: 800;
      background: linear-gradient(135deg, #0ea5e9, #0284c7);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* ==================== SECTION DIVIDERS ==================== */
    .section-wave { position: absolute; bottom: 0; left: 0; width: 100%; overflow: hidden; line-height: 0; }
    .section-wave svg { display: block; width: calc(100% + 1.3px); height: 60px; }

    /* ==================== GALLERY ==================== */
    .animate-scroll { animation: scrollGallery 40s linear infinite; width: max-content; }
    #galleryContainer, #galleryContainerWrapper { scrollbar-width: none; -ms-overflow-style: none; }
    #galleryContainer::-webkit-scrollbar, #galleryContainerWrapper::-webkit-scrollbar { display: none; }

    /* ==================== LIGHTBOX ==================== */
    .lightbox { display: none; position: fixed; z-index: 50; padding-top: 60px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); }
    .lightbox img { margin: auto; display: block; max-width: 90%; max-height: 80vh; animation: zoom 0.3s ease; }
    .lightbox:target { display: block; }
    .close-lightbox { position: absolute; top: 30px; right: 50px; color: #fff; font-size: 40px; font-weight: bold; text-decoration: none; z-index: 100; }
    .close-lightbox:hover { color: #ccc; }

    /* ==================== FOOTER ==================== */
    .footer-animate { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
    .footer-animate.visible { opacity: 1; transform: translateY(0); }

    /* ==================== LAYANAN ==================== */
    .layanan-item ul li { opacity: 0; transform: translateX(-40px); animation: fadeInLeft 2.5s forwards; }
    .layanan-item ul li:nth-child(1) { animation-delay: 0.2s; }
    .layanan-item ul li:nth-child(2) { animation-delay: 0.4s; }
    .layanan-item ul li:nth-child(3) { animation-delay: 0.6s; }
    .layanan-item ul li:nth-child(4) { animation-delay: 0.8s; }

    /* ==================== MISC ==================== */
    .modal-animate { opacity: 0; transform: translateY(30px); animation: fadeInUp 0.5s ease forwards; }
    .group:hover .group-hover\:flex { display: flex !important; }
    .shimmer-line { background: linear-gradient(90deg, #e0e0e0 25%, #f5f5f5 50%, #e0e0e0 75%); background-size: 200% 100%; animation: shimmer 2s infinite; height: 3px; border-radius: 2px; }
    @media (max-width: 768px) { #layananContent { padding-left: 0.5rem; padding-right: 0.5rem; } }
  </style>
</head>
<body class="text-gray-900">
<!-- NAVBAR -->
<nav id="navbar" class="fixed top-0 left-0 right-0 w-full bg-transparent" style="z-index: 70;">
  <div class="flex justify-center px-4 sm:px-6 lg:px-8">
    <div id="navCapsule" class="mt-4 bg-white/10 backdrop-blur-md border border-white/20 shadow-lg rounded-full px-6 transition-all duration-500">
      <div class="flex items-center h-14 space-x-6 text-sm font-medium">

        <!-- Logo -->
        <a href="#beranda" class="flex items-center gap-2 mr-2">
          <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo" class="h-8 w-8 rounded-full shadow">
          <span class="text-white font-bold text-base tracking-tight hidden sm:inline" id="navBrandText">NUSTECH</span>
        </a>

        <!-- Hamburger (Mobile) -->
        <div class="md:hidden ml-auto flex items-center">
          <button id="menu-toggle" type="button" class="focus:outline-none p-2 -mr-2 cursor-pointer" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
            <svg class="w-7 h-7 text-white pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>

        <!-- MENU DESKTOP -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="#beranda" class="nav-link">Beranda</a>
          <a href="#tentang" class="nav-link">Tentang Kami</a>
          <a href="#visimisi" class="nav-link">Visi Misi</a>
          <div id="layananDropdown" class="relative">
            <button id="layananToggle" class="nav-link focus:outline-none flex items-center gap-1">
              Layanan
              <svg class="w-4 h-4 transition-transform duration-300" id="layananArrow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <!-- MEGA MENU CONTENT -->
            <div id="layananMenu" class="fixed left-0 w-full bg-white shadow-[0_25px_80px_rgba(0,0,0,0.12)] hidden mega-menu-animate overflow-hidden" style="z-index: 60; top: 74px;">
              
              <!-- Top gradient accent bar -->
              <div style="height:4px; background: linear-gradient(90deg, #0ea5e9, #06b6d4, #0284c7, #38bdf8);"></div>

              <div class="max-w-7xl mx-auto px-6 md:px-12 pt-6 pb-8">

                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 md:gap-6">
                  
                  <!-- Column 1: Layanan Utama (4 cols) -->
                  <div class="md:col-span-4">
                    <h4 class="text-[11px] font-bold text-sky-500 uppercase tracking-[0.25em] mb-4 flex items-center gap-2">
                      <span class="w-5 h-[2px] bg-sky-400 rounded-full"></span> Layanan Utama
                    </h4>
                    <div class="flex flex-col gap-1">
                      <button onclick="showLayanan('networking')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-network-wired"></i></div>
                        <div class="min-w-0">
                          <span class="link-text">Networking</span>
                          <p class="text-[11px] text-gray-400 font-medium">Sistem Jaringan & Mikrotik</p>
                        </div>
                      </button>
                      <button onclick="showLayanan('aplikasi')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-code"></i></div>
                        <div class="min-w-0">
                          <span class="link-text">Aplikasi</span>
                          <p class="text-[11px] text-gray-400 font-medium">Web & Software Development</p>
                        </div>
                      </button>
                      <button onclick="showLayanan('reklame')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-palette"></i></div>
                        <div class="min-w-0">
                          <span class="link-text">Reklame</span>
                          <p class="text-[11px] text-gray-400 font-medium">Media Promo & Branding</p>
                        </div>
                      </button>
                      <button onclick="showLayanan('kelistrikan')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-bolt"></i></div>
                        <div class="min-w-0">
                          <span class="link-text">Kelistrikan</span>
                          <p class="text-[11px] text-gray-400 font-medium">Instalasi & Power System</p>
                        </div>
                      </button>
                    </div>
                  </div>

                  <!-- Column 2: Pendukung (4 cols) -->
                  <div class="md:col-span-4">
                    <h4 class="text-[11px] font-bold text-sky-500 uppercase tracking-[0.25em] mb-5 flex items-center gap-2">
                      <span class="w-5 h-[2px] bg-sky-400 rounded-full"></span> Pendukung
                    </h4>
                    <div class="flex flex-col gap-1">
                      <button onclick="showLayanan('ac')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-snowflake"></i></div>
                        <span class="link-text">Sistem Pendingin</span>
                      </button>
                      <button onclick="showLayanan('komputer')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-print"></i></div>
                        <span class="link-text">Komputer & Printer</span>
                      </button>
                      <button onclick="showLayanan('elektronik')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-tv"></i></div>
                        <span class="link-text">Elektronik</span>
                      </button>
                      <button onclick="showLayanan('kantor')" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-briefcase"></i></div>
                        <span class="link-text">Alat Kantor</span>
                      </button>
                    </div>
                  </div>

                  <!-- Column 3: Dukungan (4 cols) -->
                  <div class="md:col-span-4">
                    <h4 class="text-[11px] font-bold text-sky-500 uppercase tracking-[0.25em] mb-5 flex items-center gap-2">
                      <span class="w-5 h-[2px] bg-sky-400 rounded-full"></span> Dukungan
                    </h4>
                    <div class="flex flex-col gap-1">
                      <a href="#kontak" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-headset"></i></div>
                        <span class="link-text">Konsultasi Gratis</span>
                      </a>
                      <a href="#" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-file-pdf"></i></div>
                        <span class="link-text">Unduh Company Profile</span>
                      </a>
                      <a href="#" class="mega-link mega-stagger">
                        <div class="link-icon"><i class="fa-solid fa-circle-question"></i></div>
                        <span class="link-text">FAQ</span>
                      </a>
                    </div>
                  </div>

                </div>

                <!-- Bottom CTA Banner -->
                <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                  <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></div>
                    <span class="text-sm font-medium text-gray-500">Butuh solusi khusus? Kami siap membantu Anda</span>
                  </div>
                  <div class="flex items-center gap-4">
                    <a href="#layanan" class="text-sm font-bold text-sky-500 hover:text-sky-600 transition-colors flex items-center gap-2 group">
                      Lihat Semua Layanan <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="https://wa.me/6281332809923" target="_blank" class="text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-cyan-500 px-5 py-2.5 rounded-full hover:shadow-lg hover:shadow-sky-200 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                      <i class="fa-brands fa-whatsapp"></i> Hubungi Kami
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <a href="#gallery" class="nav-link">Galeri</a>
        </div>
      </div>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div id="mobile-menu" class="md:hidden hidden mx-4 mt-3 bg-white rounded-2xl shadow-2xl text-gray-800 font-semibold px-5 pt-5 pb-6 border border-gray-100 overflow-hidden isolate transform origin-top transition-all" style="max-height: 80vh; overflow-y: auto;">
    <div class="space-y-1">
      <a href="#beranda" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="block py-3 px-4 rounded-xl hover:bg-sky-50 hover:text-sky-600 transition-colors">Beranda</a>
      <a href="#tentang" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="block py-3 px-4 rounded-xl hover:bg-sky-50 hover:text-sky-600 transition-colors">Tentang Kami</a>
      <a href="#visimisi" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="block py-3 px-4 rounded-xl hover:bg-sky-50 hover:text-sky-600 transition-colors">Visi & Misi</a>
      
      <!-- Layanan Mobile Dropdown -->
      <div class="rounded-xl overflow-hidden hover:bg-sky-50 transition-colors">
        <button onclick="document.getElementById('mobileLayananMenu').classList.toggle('hidden'); document.getElementById('mobileLayananArrow').classList.toggle('rotate-180')" class="w-full flex items-center justify-between py-3 px-4 text-left focus:outline-none hover:text-sky-600 transition-colors">
          Layanan
          <svg id="mobileLayananArrow" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="mobileLayananMenu" class="hidden flex-col bg-gray-50/50 border-t border-gray-100 py-2">
          <button onclick="showLayanan('networking'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Networking</button>
          <button onclick="showLayanan('aplikasi'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Aplikasi</button>
          <button onclick="showLayanan('reklame'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Reklame</button>
          <button onclick="showLayanan('kelistrikan'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Kelistrikan</button>
          <button onclick="showLayanan('ac'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Sistem Pendingin</button>
          <button onclick="showLayanan('komputer'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Komputer & Printer</button>
          <button onclick="showLayanan('elektronik'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Elektronik</button>
          <button onclick="showLayanan('kantor'); document.getElementById('mobile-menu').classList.add('hidden')" class="w-full text-left py-2 px-8 text-sm text-gray-600 hover:text-sky-600 transition-colors">Alat Kantor</button>
        </div>
      </div>
      
      <a href="#gallery" onclick="document.getElementById('mobile-menu').classList.add('hidden')" class="block py-3 px-4 rounded-xl hover:bg-sky-50 hover:text-sky-600 transition-colors">Galeri / Portofolio</a>
    </div>
  </div>
</nav>

  <!-- Hero Section -->
<section id="beranda" class="w-full min-h-screen flex items-center justify-center relative overflow-hidden" style="background: #0a0e27;">

  <!-- Video Background (File belum ada di folder public/assets/img/) -->
  <!--
  <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover z-0" style="opacity: 0.65;">
    <source src="{{ asset('assets/img/videobackgroundweb.mp4') }}" type="video/mp4">
  </video>
  -->

  <!-- Cinematic Overlay -->
  <div class="absolute inset-0 hero-overlay z-10"></div>

  <!-- Animated Particles -->
  <div class="absolute inset-0 z-10 overflow-hidden" id="heroParticles">
    <div class="hero-particle" style="left:10%;bottom:0;animation-duration:12s;animation-delay:0s;width:4px;height:4px;"></div>
    <div class="hero-particle" style="left:25%;bottom:0;animation-duration:9s;animation-delay:2s;width:6px;height:6px;"></div>
    <div class="hero-particle" style="left:40%;bottom:0;animation-duration:14s;animation-delay:1s;width:3px;height:3px;"></div>
    <div class="hero-particle" style="left:55%;bottom:0;animation-duration:11s;animation-delay:3s;width:5px;height:5px;"></div>
    <div class="hero-particle" style="left:70%;bottom:0;animation-duration:10s;animation-delay:0.5s;width:4px;height:4px;"></div>
    <div class="hero-particle" style="left:85%;bottom:0;animation-duration:13s;animation-delay:4s;width:7px;height:7px;"></div>
    <div class="hero-particle" style="left:15%;bottom:0;animation-duration:16s;animation-delay:5s;width:3px;height:3px;"></div>
    <div class="hero-particle" style="left:60%;bottom:0;animation-duration:8s;animation-delay:1.5s;width:5px;height:5px;"></div>
    <div class="hero-particle" style="left:35%;bottom:0;animation-duration:15s;animation-delay:6s;width:4px;height:4px;"></div>
    <div class="hero-particle" style="left:90%;bottom:0;animation-duration:11s;animation-delay:2.5s;width:6px;height:6px;"></div>
  </div>

  <!-- Hero Content -->
  <div class="relative z-20 text-center px-6 max-w-3xl mx-auto">
    <div class="hero-badge animate-fade-in-up">
      <span style="width:8px;height:8px;background:#34d399;border-radius:50%;display:inline-block;animation:pulse-glow 2s infinite;"></span>
      Solution For Your Tech Problem
    </div>
    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 leading-tight animate-fade-in-up" style="animation-delay: 0.2s; text-shadow: 0 4px 30px rgba(0,0,0,0.3);">
      CV. NUSTECH
    </h1>
    <p class="text-lg md:text-xl text-gray-200 mb-10 animate-fade-in-up font-light leading-relaxed" style="animation-delay: 0.4s;">
      Solusi Teknologi Informasi dan Komunikasi<br class="hidden md:inline">
      Terpercaya di Nusa Tenggara Barat
    </p>
    <div class="animate-fade-in-up" style="animation-delay: 0.6s;">
      <a href="#tentang" class="hero-cta">
        Jelajahi Kami <i class="fa-solid fa-arrow-down text-sm"></i>
      </a>
    </div>
  </div>

  <!-- Scroll Indicator -->
  <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-20 animate-float">
    <div style="width:28px;height:44px;border:2px solid rgba(255,255,255,0.4);border-radius:14px;display:flex;justify-content:center;padding-top:8px;">
      <div style="width:4px;height:10px;background:rgba(255,255,255,0.7);border-radius:2px;animation:fadeInUp 1.5s infinite;"></div>
    </div>
  </div>

  <!-- Bottom Wave -->
  <div class="section-wave z-20">
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" style="height:60px;">
      <path d="M0,0V60H1200V0C1000,55,800,20,600,45C400,70,200,20,0,0Z" fill="#ffffff"/>
    </svg>
  </div>
</section>

<!-- TENTANG KAMI SECTION -->
<section id="tentang" class="relative w-full py-20 lg:py-28 overflow-hidden bg-white">

  <!-- BACKGROUND GRADIENT -->
  <div class="absolute inset-0 bg-gradient-to-br from-orange-50/50 via-white to-sky-50/50"></div>

  <!-- SHAPE SVG ORGANIC -->
  <svg class="absolute -top-20 -left-20 w-[600px] opacity-20 animate-float-slower" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#FDBA74" d="M47.3,-61.6C60.6,-54.2,70.5,-40.6,73.3,-26C76,-11.3,71.6,4.4,63.7,17.9C55.9,31.3,44.6,42.5,31.4,50.4C18.2,58.3,3.1,62.9,-12.2,63.5C-27.6,64.1,-43.2,60.6,-55.3,51.4C-67.4,42.2,-75.9,27.3,-77.4,11.4C-78.8,-4.5,-73.3,-21.5,-63.3,-34.8C-53.3,-48.1,-38.8,-57.7,-23.2,-63.8C-7.7,-69.9,8.9,-72.5,24.5,-69.5C40.1,-66.6,54.7,-58.2,47.3,-61.6Z" transform="translate(100 100)" />
  </svg>
  <svg class="absolute -bottom-16 -right-16 w-[400px] opacity-15 animate-float-slow" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
    <path fill="#7dd3fc" d="M44.7,-52.9C57.1,-44.2,65.6,-29.3,68.4,-13.6C71.1,2.1,68.2,18.6,59.6,31.1C51,43.6,36.7,52.1,21.2,57.4C5.6,62.7,-11.3,64.8,-26.2,59.9C-41.2,55,-54.2,43.1,-61.5,28.2C-68.8,13.3,-70.5,-4.6,-65.3,-19.9C-60.2,-35.2,-48.3,-47.9,-34.8,-56.2C-21.3,-64.5,-6.3,-68.3,5.4,-74.5C17,-80.7,32.3,-61.7,44.7,-52.9Z" transform="translate(100 100)" />
  </svg>

  <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between max-w-7xl mx-auto px-6 lg:px-16 gap-12">
    <!-- KIRI -->
    <div class="w-full lg:w-1/2 reveal-left">
      <div class="inline-flex items-center gap-2 bg-orange-100 text-orange-700 px-4 py-1.5 rounded-full text-xs font-bold mb-6 tracking-wide">
        <i class="fa-solid fa-building"></i> TENTANG PERUSAHAAN
      </div>
      <h2 class="text-4xl lg:text-5xl font-extrabold mb-6 leading-tight">
        Ini Tentang <span class="text-orange-500">Kami,</span><br>
        <span class="bg-gradient-to-r from-orange-500 to-sky-500 bg-clip-text" style="-webkit-text-fill-color: Black;">Jagonya</span>
        Teknologi Informasi
      </h2>
      <p class="text-gray-500 mb-8 text-base leading-relaxed">
        CV. NUSTECH adalah perusahaan yang berbasis di Lombok, Nusa Tenggara Barat dan bergerak di bidang pengadaan barang dan jasa, khususnya dalam sektor teknologi informasi, kelistrikan, dan rekayasa teknik (engineering)...
      </p>
      <button onclick="openModal()" class="group bg-gradient-to-r from-sky-500 to-sky-600 text-black text-sm px-7 py-3 rounded-full font-bold shadow-lg hover:shadow-xl hover:from-sky-600 hover:to-sky-700 transition-all duration-300 cursor-pointer">
        Pelajari Selengkapnya <i class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
      </button>

      <!-- STAT COUNTERS -->
      <div class="grid grid-cols-3 gap-4 mt-12">
        <div class="stat-card reveal" style="transition-delay: 0.1s">
          <div class="stat-number" data-count="50">0+</div>
          <div class="text-gray-500 text-xs font-semibold mt-1">Proyek Selesai</div>
        </div>
        <div class="stat-card reveal" style="transition-delay: 0.2s">
          <div class="stat-number" data-count="30">0+</div>
          <div class="text-gray-500 text-xs font-semibold mt-1">Klien Puas</div>
        </div>
        <div class="stat-card reveal" style="transition-delay: 0.3s">
          <div class="stat-number" data-count="8">0+</div>
          <div class="text-gray-500 text-xs font-semibold mt-1">Layanan Utama</div>
        </div>
      </div>
    </div>

    <!-- KANAN -->
    <div class="relative w-full lg:w-1/2 reveal-right">
      <div class="relative">
        <div class="absolute -inset-4 bg-gradient-to-br from-sky-200/30 to-orange-200/30 rounded-3xl blur-2xl"></div>
        <img src="{{ asset('assets/img/tentangkami.png') }}" alt="tentang kami" class="relative w-full h-auto drop-shadow-2xl hover:scale-[1.02] transition-transform duration-500"/>
      </div>
    </div>
  </div>

</section>

<!-- ====== SHARED MODAL PREMIUM STYLES ====== -->
<style>
  .modal-premium-backdrop {
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
  }
  .modal-premium-box {
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.25), 0 0 0 1px rgba(255,255,255,0.1);
  }
  .modal-gradient-header {
    background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 100%);
    border-radius: 20px 20px 0 0;
  }
  .modal-close-btn {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    background: rgba(255,255,255,0.15);
    color: white;
    font-size: 20px;
    transition: all 0.3s;
    border: none; cursor: pointer;
  }
  .modal-close-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: rotate(90deg);
  }
  .modal-section-card {
    background: #f8fafc;
    border-left: 4px solid #0ea5e9;
    border-radius: 0 12px 12px 0;
    padding: 24px 28px;
    margin-bottom: 24px;
  }
  .modal-section-title {
    font-size: 22px;
    font-weight: 700;
    color: #0c4a6e;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .modal-section-title i {
    color: #0ea5e9;
  }
  .modal-list li {
    padding: 10px 0;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: flex-start;
    gap: 12px;
  }
  .modal-list li:last-child { border-bottom: none; }
  .modal-list .bullet {
    flex-shrink: 0;
    width: 24px; height: 24px;
    border-radius: 6px;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 11px; font-weight: bold;
    margin-top: 2px;
  }
  .modal-footer-bar {
    border-top: 1px solid #e2e8f0;
    background: linear-gradient(to right, #f0f9ff, #ffffff);
    padding: 16px 24px;
    text-align: center;
    border-radius: 0 0 20px 20px;
  }
  .modal-footer-btn {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: white;
    padding: 10px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s;
    border: none; cursor: pointer;
    box-shadow: 0 4px 14px rgba(14,165,233,0.3);
  }
  .modal-footer-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(14,165,233,0.4);
  }
  /* Premium scrollbar inside modals */
  .modal-scroll::-webkit-scrollbar { width: 6px; }
  .modal-scroll::-webkit-scrollbar-track { background: transparent; }
  .modal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
  .modal-scroll::-webkit-scrollbar-thumb:hover { background: #0ea5e9; }
  /* Fullscreen modal header */
  .modal-fs-header {
    background: linear-gradient(135deg, #0c4a6e 0%, #0ea5e9 100%);
    padding: 16px 24px;
    display: flex; align-items: center; justify-content: center;
    position: relative;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  }
  .modal-fs-header h3 {
    color: white;
    font-weight: 700;
    font-size: 18px;
    letter-spacing: 0.3px;
  }
  @keyframes modalSlideUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .modal-animate-in {
    animation: modalSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }
</style>

<!-- Modal FULLSCREEN dan Bisa Scroll -->
<div id="modalTentang" class="fixed inset-0 bg-black bg-opacity-60 z-50 overflow-y-auto hidden modal-premium-backdrop">
  <div class="min-h-screen flex items-start justify-center px-4 py-10">
    <div class="bg-white w-full max-w-5xl relative text-gray-800 modal-premium-box modal-animate-in overflow-hidden">

      <!-- Gradient Header -->
      <div class="modal-gradient-header px-8 py-6 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
            <i class="fa-solid fa-building text-white text-lg"></i>
          </div>
          <h3 class="text-2xl font-bold text-white tracking-wide">Tentang CV. NUSTECH</h3>
        </div>
        <button onclick="closeModal()" class="modal-close-btn">&times;</button>
      </div>

      <!-- Body -->
      <div class="p-8 md:p-10 max-h-[75vh] overflow-y-auto modal-scroll">

        <!-- Tentang -->
        <div class="modal-section-card mb-8">
          <div class="modal-section-title"><i class="fa-solid fa-circle-info"></i> Profil Perusahaan</div>
          <div class="text-justify text-[15px] leading-relaxed space-y-4 text-gray-600">
            <p>CV. NUSTECH adalah perusahaan yang berbasis di Lombok Nusa Tenggara Barat dan bergerak di bidang pengadaan barang dan jasa, khususnya dalam sektor teknologi informasi, kelistrikan, dan rekayasa teknik (engineering).</p>
            <p>Kami menawarkan kemitraan profesional kepada perusahaan lokal, nasional, maupun instansi pemerintahan, dengan mengedepankan keahlian serta pengalaman kami di bidang terkait.</p>
            <p>Penyusunan company profile ini bertujuan untuk memberikan gambaran umum mengenai layanan yang kami tawarkan, sekaligus menjadi dasar pertimbangan dalam menjalin kerja sama.</p>
            <p>Kami memiliki pengalaman dalam pembangunan dan pengelolaan jaringan internet, pengadaan dan perawatan alat-alat elektronik kantor, dan instalasi serta perawatan sistem kelistrikan di berbagai sektor, seperti perkantoran, institusi pendidikan, dan instansi pemerintahan.</p>
            <p>Kepercayaan yang telah diberikan oleh mitra kerja sebelumnya menjadi bukti komitmen kami dalam memberikan layanan terbaik dan solusi yang handal.</p>
            <p>Kami mengucapkan terima kasih atas kesempatan yang diberikan untuk memperkenalkan perusahaan kami.</p>
            <p>Kami sangat berharap dapat menjalin kerja sama yang saling menguntungkan di masa mendatang.</p>
            <p><strong>Hormat Kami,<br>CV. NUSTECH</strong></p>
          </div>
        </div>

        <!-- Strategi Perusahaan -->
        <div class="modal-section-card mb-8">
          <div class="modal-section-title"><i class="fa-solid fa-chess-rook"></i> Strategi Perusahaan</div>
          <div class="text-justify text-[15px] leading-relaxed text-gray-600">
            <p class="mb-4">CV. NUSTECH menerapkan strategi yang fokus pada pertumbuhan berkelanjutan, kepuasan pelanggan dan penguatan daya saing di pasar. Strategi utama kami meliputi:</p>
            <ul class="modal-list list-none space-y-0">
              <li><span class="bullet">1</span> <span><strong>Fokus pada Kualitas Layanan:</strong> Menyediakan layanan yang profesional, tepat waktu, dan sesuai kebutuhan klien.</span></li>
              <li><span class="bullet">2</span> <span><strong>Pemanfaatan Teknologi:</strong> Menggunakan sistem dan peralatan terbaru untuk mendukung efisiensi dan hasil kerja maksimal.</span></li>
              <li><span class="bullet">3</span> <span><strong>Kemitraan yang Kuat:</strong> Menjalin kerja sama dengan instansi pemerintah, swasta, dan mitra usaha secara berkelanjutan dan saling menguntungkan.</span></li>
              <li><span class="bullet">4</span> <span><strong>Pengembangan SDM:</strong> Meningkatkan kompetensi karyawan melalui pelatihan rutin dan pembinaan profesional.</span></li>
              <li><span class="bullet">5</span> <span><strong>Komitmen terhadap Kepuasan Pelanggan:</strong> Memberikan layanan purna jual dan dukungan teknis sebagai bentuk tanggung jawab perusahaan.</span></li>
            </ul>
          </div>
        </div>

        <!-- Kebijakan Perusahaan -->
        <div class="modal-section-card">
          <div class="modal-section-title"><i class="fa-solid fa-scale-balanced"></i> Kebijakan Perusahaan</div>
          <div class="text-justify text-[15px] leading-relaxed text-gray-600">
            <p class="mb-4">CV. NUSTECH berkomitmen untuk menjalankan usaha secara profesional, transparan, dan berorientasi pada kepuasan pelanggan. Adapun kebijakan utama kami meliputi:</p>
            <ul class="modal-list list-none space-y-0">
              <li><span class="bullet">1</span> <span><strong>Kualitas Layanan:</strong> Menjamin mutu layanan melalui proses kerja yang terstandar dan berorientasi hasil.</span></li>
              <li><span class="bullet">2</span> <span><strong>Integritas dan Profesionalisme:</strong> Menjunjung tinggi etika, kejujuran, dan tanggung jawab dalam setiap kegiatan usaha.</span></li>
              <li><span class="bullet">3</span> <span><strong>Keamanan dan Keselamatan Kerja:</strong> Menerapkan standar keselamatan kerja demi kenyamanan dan perlindungan seluruh karyawan.</span></li>
              <li><span class="bullet">4</span> <span><strong>Pengembangan SDM:</strong> Mendukung peningkatan kompetensi tim sebagai aset utama perusahaan.</span></li>
              <li><span class="bullet">5</span> <span><strong>Keberlanjutan dan Lingkungan:</strong> Berkontribusi positif terhadap lingkungan dan masyarakat melalui praktik bisnis yang bertanggung jawab.</span></li>
            </ul>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer-bar">
        <button onclick="closeModal()" class="modal-footer-btn">Tutup</button>
      </div>

    </div>
  </div>
</div>

<!-- VISI MISI SECTION -->
<section id="visimisi" class="w-full relative py-24 overflow-hidden" style="background: linear-gradient(135deg, #0c4a6e 0%, #075985 30%, #0284c7 70%, #0ea5e9 100%);">

  <!-- Floating SVG Shapes -->
  <svg class="absolute top-10 right-10 w-72 opacity-10 animate-float-slow" viewBox="0 0 200 200"><circle cx="100" cy="100" r="80" fill="white"/></svg>
  <svg class="absolute bottom-10 left-10 w-56 opacity-10 animate-float-slower" viewBox="0 0 200 200"><rect x="30" y="30" width="140" height="140" rx="30" fill="white"/></svg>

  <div class="max-w-7xl mx-auto px-6 lg:px-16 relative z-10">
    <!-- Section Title -->
    <div class="text-center mb-16 reveal">
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur text-white px-5 py-2 rounded-full text-xs font-bold mb-4 tracking-widest border border-white/20">
        <i class="fa-solid fa-bullseye"></i> VISI & MISI PERUSAHAAN
      </div>
      <h2 class="text-4xl lg:text-5xl font-extrabold text-white">Visi & Misi Kami</h2>
    </div>

    <!-- Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

      <!-- VISI Card -->
      <div class="reveal-left">
        <div class="h-full bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 lg:p-10 hover:bg-white/15 transition-all duration-500 hover:shadow-[0_0_40px_rgba(255,255,255,0.1)] group relative overflow-hidden">
          <!-- Decoration -->
          <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>
          
          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-white/20 to-white/5 flex items-center justify-center mb-8 shadow-inner">
            <i class="fa-solid fa-eye text-white text-3xl animate-pulse"></i>
          </div>
          <h3 class="text-3xl font-extrabold text-white mb-6 tracking-tight">VISI</h3>
          <p class="text-blue-50 leading-relaxed text-lg text-justify italic">
            "Menjadi perusahaan penyedia barang dan jasa di bidang teknologi informasi, elektronik, percetakan/reklame, meubel, dan alat-alat kantor yang profesional, memiliki daya saing tinggi, serta terpercaya di tingkat lokal maupun nasional."
          </p>
          
          <div class="mt-8 pt-8 border-t border-white/10">
            <div class="flex items-center gap-3 text-white/60 text-sm">
              <span class="w-2 h-2 rounded-full bg-sky-400"></span>
              Fokus pada Keunggulan & Kepercayaan
            </div>
          </div>
        </div>
      </div>

      <!-- MISI Card -->
      <div class="reveal-right">
        <div class="h-full bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 lg:p-10 hover:bg-white/15 transition-all duration-500 hover:shadow-[0_0_40px_rgba(255,255,255,0.1)] group relative overflow-hidden">
          <!-- Decoration -->
          <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/5 rounded-full blur-3xl group-hover:bg-white/10 transition-colors"></div>

          <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-white/20 to-white/5 flex items-center justify-center mb-8 shadow-inner">
            <i class="fa-solid fa-rocket text-white text-3xl"></i>
          </div>
          <h3 class="text-3xl font-extrabold text-white mb-6 tracking-tight">MISI</h3>
          <ul class="space-y-5">
            <li class="flex items-start gap-4 group/item">
              <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm font-bold mt-1 group-hover/item:bg-sky-500 transition-colors">1</div>
              <p class="text-blue-50 text-[15px] leading-relaxed text-justify">Mengoptimalkan strategi pertumbuhan bisnis secara berkelanjutan dan menguntungkan guna meningkatkan kesejahteraan karyawan serta seluruh pemangku kepentingan.</p>
            </li>
            <li class="flex items-start gap-4 group/item">
              <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm font-bold mt-1 group-hover/item:bg-sky-500 transition-colors">2</div>
              <p class="text-blue-50 text-[15px] leading-relaxed text-justify">Menjalin kerja sama yang saling menguntungkan dengan mitra usaha dan mitra kerja melalui pengelolaan pengadaan barang dan jasa secara sinergis dan efisien.</p>
            </li>
            <li class="flex items-start gap-4 group/item">
              <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm font-bold mt-1 group-hover/item:bg-sky-500 transition-colors">3</div>
              <p class="text-blue-50 text-[15px] leading-relaxed text-justify">Memberikan pelayanan yang maksimal, cepat, dan profesional kepada seluruh klien dan mitra.</p>
            </li>
            <li class="flex items-start gap-4 group/item">
              <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm font-bold mt-1 group-hover/item:bg-sky-500 transition-colors">4</div>
              <p class="text-blue-50 text-[15px] leading-relaxed text-justify">Memberikan nilai tambah yang optimal bagi masyarakat serta berkontribusi positif terhadap pelestarian lingkungan.</p>
            </li>
            <li class="flex items-start gap-4 group/item">
              <div class="flex-shrink-0 w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center text-white text-sm font-bold mt-1 group-hover/item:bg-sky-500 transition-colors">5</div>
              <p class="text-blue-50 text-[15px] leading-relaxed text-justify">Menjunjung tinggi prinsip transparansi dan integritas dalam setiap proses bisnis sebagai bentuk komitmen terhadap kepercayaan para pemangku kepentingan.</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Wave -->
  <div class="section-wave" style="z-index:5">
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" style="height:60px;">
      <path d="M0,0V60H1200V0C1050,50,900,10,750,40C600,70,450,15,300,45C150,75,50,20,0,0Z" fill="#ffffff"/>
    </svg>
  </div>
</section>

<section id="layanan" class="w-full bg-white text-gray-900 py-24 relative overflow-hidden">

  <!-- Subtle bg decoration -->
  <div class="absolute top-0 right-0 w-96 h-96 bg-sky-100/50 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
  <div class="absolute bottom-0 left-0 w-72 h-72 bg-orange-100/40 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

  <!-- Judul -->
  <div class="text-center mb-14 relative z-10 reveal">
    <div class="inline-flex items-center gap-2 bg-sky-50 text-sky-700 px-5 py-2 rounded-full text-xs font-bold mb-4 tracking-widest">
      <i class="fa-solid fa-concierge-bell"></i> LAYANAN KAMI
    </div>
    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800">Layanan Yang Kami <span class="bg-gradient-to-r from-sky-500 to-cyan-500 bg-clip-text" style="-webkit-text-fill-color:transparent;">Berikan</span></h2>
  </div>

  <!-- Container -->
  <div class="flex flex-col lg:flex-row gap-12 px-4 md:px-8 xl:px-20 items-start">

    <!-- Kiri -->
    <div class="w-full lg:w-1/2 space-y-10 text-black text-base">

        <!-- 1. Networking -->
        <div id="networking" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Instalasi & Pemeliharaan Jaringan (Networking)</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li class="cursor-pointer text-black-600 hover:underline" onclick="openJaringanModal()">Instalasi dan maintenance jaringan komputer</li>
            <li class="cursor-pointer text-black-600 hover:underline" onclick="openVsatModal()"> Pemasangan dan Perawatan Jaringan VSAT </li>
            <li class="cursor-pointer text-black-600 hover:underline" onclick="openBasebandModal()">Pemasangan Baseband (BB) Tower</li>
            <li>Instalasi dan pemeliharaan sistem CCTV</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Instalasi%20dan%20Pemeliharaan%20Jaringan%20(Networking)%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 2. Aplikasi -->
        <div id="aplikasi" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Pengembangan Aplikasi & Program Komputer</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Pembuatan software/aplikasi sesuai kebutuhan klien</li>
            <li>Jasa pemrograman khusus untuk instansi dan perusahaan</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Pengembangan%20Aplikasi%20dan%20Program%20Komputer%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 3. Reklame -->
        <div id="reklame" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Reklame dan Percetakan</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Desain dan produksi media promosi</li>
            <li>Layanan cetak untuk berbagai kebutuhan perusahaan dan instansi</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Reklame%20dan%20Percetakan%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 4. Kelistrikan -->
        <div id="kelistrikan" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Kelistrikan</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Perancangan, pemasangan, dan perawatan sistem kelistrikan untuk bangunan kantor dan instansi</li>
          </ul>
          <div class="mt-4">
             <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Kelistrikan%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 5. Sistem Pendingin -->
        <div id="ac" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Instalasi & Pemeliharaan Sistem Pendingin (AC)</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Pemasangan AC dan sistem pendingin lainnya</li>
            <li>Maintenance dan perbaikan berkala</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Instalasi%20dan%20Pemeliharaan%20Sistem%20Pendingin%20(AC)%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 6. Komputer dan Printer -->
        <div id="komputer" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Pengadaan & Maintenance Perangkat Komputer dan Printer</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Pengadaan unit komputer, printer, dan perangkat pendukung</li>
            <li>Layanan perawatan dan perbaikan berkala</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20Pengadaan%20dan%20Maintenance%20Perangkat%20Komputer%20dan%20Printer%20yang%20Anda%20tawarkan.%20Mohon%20info%20lebih%20lanjut."
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 7. Elektronik -->
        <div id="elektronik" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Pengadaan Peralatan Elektronik</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Penyediaan berbagai jenis perangkat elektronik sesuai kebutuhan proyek</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20pengadaan%20peralatan%20elektronik%20yang%20Anda%20tawarkan" 
                target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

        <!-- 8. Alat Kantor -->
        <div id="kantor" class="layanan-item hidden">
          <h3 class="text-2xl font-semibold mb-3">Pengadaan & Perawatan Alat-Alat Kantor</h3>
          <ul class="list-disc list-inside text-justify space-y-1">
            <li>Penyediaan perlengkapan kantor</li>
            <li>Perawatan alat kantor secara rutin</li>
          </ul>
          <div class="mt-4">
            <a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20pengadaan%20dan%20perawatan%20alat-alat%20kantor%20yang%20Anda%20tawarkan.%20Saya%20ingin%20mendapatkan%20informasi%20lebih%20lanjut%20mengenai%20produk%20dan%20layanan%20yang%20tersedia.
                " target="_blank"
              class="border border-gray-400 text-sm px-5 py-2 rounded-full hover:bg-gray-100 transition-all cursor-pointer">
              Hubungi Kami...
            </a>
          </div>
        </div>

      </div>
    </div>

    <!-- Kanan: Gambar -->
    <div class="w-full px-4 lg:px-8">
      <div class="w-full grid grid-cols-1 lg:grid-cols-2 gap-6 items-center">
        <!-- Gambar -->
        <div class="flex justify-end">
          <img src="{{ asset('assets/img/rosiemaulana.png') }}"
              alt="omrosi"
              class="w-full max-w-sm object-contain drop-shadow-xl">
        </div>
        
        <!-- Card -->
        <div class="bg-gradient-to-br from-sky-50 to-white p-7 rounded-2xl shadow-lg border border-sky-100 space-y-4 reveal">
          <details class="group text-left cursor-pointer bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-sky-200 transition-all">
            <summary class="flex justify-between items-center font-bold text-lg text-gray-800">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center"><i class="fa-solid fa-wand-magic-sparkles text-sky-600"></i></div>
                <span>Solusi Teknologi Sekali Sentuh</span>
              </div>
              <i class="fa-solid fa-chevron-down text-sky-400 text-sm transform group-open:rotate-180 transition-transform duration-300"></i>
            </summary>
            <div class="mt-4 text-gray-600 leading-relaxed pl-13">
              Kelola CCTV, jaringan internet, dan sistem AC dalam satu ekosistem terpadu.
              Instalasi cepat, konfigurasi otomatis, dan dukungan teknisi berpengalaman
              memastikan sistem Anda selalu siap bekerja — di kantor, hotel, hingga kawasan wisata seperti Gili.
            </div>
          </details>
          <details class="group text-left cursor-pointer bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-sky-200 transition-all">
            <summary class="flex justify-between items-center font-bold text-lg text-gray-800">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center"><i class="fa-solid fa-wifi text-sky-600"></i></div>
                <span>Koneksi Stabil, Instalasi Andal</span>
              </div>
              <i class="fa-solid fa-chevron-down text-sky-400 text-sm transform group-open:rotate-180 transition-transform duration-300"></i>
            </summary>
            <div class="mt-4 text-gray-600 leading-relaxed pl-13">
              Kami menyediakan solusi jaringan internet yang stabil, cepat, dan konsisten
              melalui instalasi Point-to-Point serta infrastruktur jaringan yang andal,
              ditangani langsung oleh teknisi berpengalaman dan profesional.
              Dirancang untuk mendukung operasional tanpa hambatan, baik di pusat kota
              maupun di wilayah dengan keterbatasan akses.
            </div>
          </details>
          <details class="group text-left cursor-pointer bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:border-sky-200 transition-all">
            <summary class="flex justify-between items-center font-bold text-lg text-gray-800">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-sky-100 flex items-center justify-center"><i class="fa-solid fa-shield-halved text-sky-600"></i></div>
                <span>Nyaman & Aman Sepanjang Hari</span>
              </div>
              <i class="fa-solid fa-chevron-down text-sky-400 text-sm transform group-open:rotate-180 transition-transform duration-300"></i>
            </summary>
            <div class="mt-4 text-gray-600 leading-relaxed pl-13">
              Nikmati kenyamanan tanpa henti dengan AC yang optimal dan sistem keamanan 24 jam.
              Tim teknisi kami siap memantau, merawat, dan memastikan semua berjalan lancar —
              sehingga Anda bisa fokus pada bisnis dan aktivitas utama.
            </div>
          </details>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section id="gallery" class="relative py-24 overflow-hidden" style="background: linear-gradient(180deg, #f8fafc 0%, #e0f2fe 100%);">
  <div class="max-w-[90rem] mx-auto px-6 lg:px-8">
    <!-- Title -->
    <div class="text-center mb-14 reveal">
      <div class="inline-flex items-center gap-2 bg-sky-100 text-sky-700 px-5 py-2 rounded-full text-xs font-bold mb-4 tracking-widest">
        <i class="fa-solid fa-images"></i> PORTOFOLIO
      </div>
      <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-800 text-center w-full">Pengalaman Kami <span class="bg-gradient-to-r from-sky-500 to-cyan-500 bg-clip-text" style="-webkit-text-fill-color:transparent;">Kerja</span></h2>
      <p class="text-gray-500 mt-3 max-w-xl mx-auto">Dokumentasi proyek dan kegiatan yang telah kami kerjakan</p>
    </div>

    <!-- Gallery Scroll -->
    <div id="galleryContainerWrapper" class="overflow-hidden relative rounded-2xl">
      <!-- Edge Gradients -->
      <div class="absolute left-0 top-0 bottom-0 w-20 bg-gradient-to-r from-gray-50 to-transparent z-10 pointer-events-none"></div>
      <div class="absolute right-0 top-0 bottom-0 w-20 bg-gradient-to-l from-gray-50 to-transparent z-10 pointer-events-none"></div>

      <div id="galleryContainer" class="flex gap-6 animate-scroll py-4">
        <!-- Images -->
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-fiber.jpg') }}" alt="Fiber Optic" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Fiber Optic Installation</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-tower.jpg') }}" alt="Tower" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Tower Project</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-vsat.jpg') }}" alt="VSAT" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">VSAT Satellite Connection</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/hero-satellite.jpg') }}" alt="Satellite" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Satellite Monitoring</span>
          </div>
        </a>

        <!-- Duplicates for loop -->
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-fiber.jpg') }}" alt="Fiber Optic" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Fiber Optic Installation</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-tower.jpg') }}" alt="Tower" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Tower Project</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/exp-vsat.jpg') }}" alt="VSAT" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">VSAT Satellite Connection</span>
          </div>
        </a>
        <a href="#" class="flex-shrink-0 w-72 snap-start rounded-2xl shadow-lg group block overflow-hidden relative">
          <img src="{{ asset('assets/img/hero-satellite.jpg') }}" alt="Satellite" class="w-full h-72 object-cover transition-all duration-500 group-hover:scale-110 group-hover:brightness-75">
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-5">
            <span class="text-white font-bold text-sm">Satellite Monitoring</span>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>


<!-- Lightbox Popups Removed -->

<!-- FOOTER -->
<footer class="relative text-white pt-16 pb-8 overflow-hidden" style="background: linear-gradient(135deg, #0a0e27 0%, #0c2d4a 50%, #0c4a6e 100%);">

  <!-- Top Wave -->
  <div class="absolute top-0 left-0 w-full overflow-hidden" style="line-height:0;">
    <svg viewBox="0 0 1200 60" preserveAspectRatio="none" style="height:60px;display:block;width:calc(100% + 1.3px);">
      <path d="M0,60V0C200,50,400,10,600,30C800,50,1000,10,1200,40V60Z" fill="rgba(255,255,255,0.03)"/>
    </svg>
  </div>

  <div class="max-w-7xl mx-auto px-6 relative z-10">
    <!-- Logo & Tagline -->
    <div class="text-center mb-12 footer-animate">
      <div class="inline-flex items-center gap-3 mb-4">
        <img src="{{ asset('assets/img/logonustech.png') }}" alt="Logo" class="h-12 w-12 rounded-full shadow-lg border-2 border-white/20">
        <span class="text-2xl font-extrabold tracking-tight">CV. NUSTECH</span>
      </div>
      <p class="text-blue-200/70 text-sm max-w-md mx-auto">
        Penyedia layanan IT, percetakan, reklame, kelistrikan, pendingin, dan pengadaan barang yang profesional dan terpercaya.
      </p>
      <div class="shimmer-line w-24 mx-auto mt-6" style="background:linear-gradient(90deg,rgba(255,255,255,0.05) 25%,rgba(14,165,233,0.3) 50%,rgba(255,255,255,0.05) 75%);background-size:200% 100%;"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
      <!-- Kontak -->
      <div id="footer-kontak" class="footer-animate">
        <h3 class="text-lg font-bold mb-5 flex items-center gap-2"><i class="fa-solid fa-address-book text-sky-400"></i> Kontak Kami</h3>
        <ul class="space-y-3 text-sm text-blue-100/80">
          <li class="flex items-center gap-3 hover:text-white transition"><div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fa fa-map-marker-alt text-sky-400 text-xs"></i></div>Jl. Semangka No.2, Mataram - NTB</li>
          <li class="flex items-center gap-3 hover:text-white transition"><div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fa fa-phone text-sky-400 text-xs"></i></div>+62 813 3280 9923</li>
          <li class="flex items-center gap-3 hover:text-white transition"><div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fa fa-envelope text-sky-400 text-xs"></i></div>info@nustech.co.id</li>
          <li class="flex items-center gap-3 hover:text-white transition"><div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fa fa-globe text-sky-400 text-xs"></i></div>nustech.co.id</li>
          <li class="flex items-center gap-3 hover:text-white transition"><div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fa fa-clock text-sky-400 text-xs"></i></div>Open 24 Hours</li>
          <li class="flex items-center gap-3 hover:text-white transition">
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center"><i class="fab fa-instagram text-pink-400 text-xs"></i></div>
            <a href="https://www.instagram.com/nustech.co.id/" target="_blank" class="hover:underline">nustech.co.id</a>
          </li>
        </ul>
      </div>

      <!-- Quick Links -->
      <div id="footer-nustech" class="footer-animate">
        <h3 class="text-lg font-bold mb-5 flex items-center gap-2"><i class="fa-solid fa-link text-sky-400"></i> Navigasi</h3>
        <ul class="space-y-3 text-sm text-blue-100/80">
          <li><a href="#beranda" class="hover:text-sky-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-sky-500"></i> Beranda</a></li>
          <li><a href="#tentang" class="hover:text-sky-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-sky-500"></i> Tentang Kami</a></li>
          <li><a href="#visimisi" class="hover:text-sky-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-sky-500"></i> Visi & Misi</a></li>
          <li><a href="#layanan" class="hover:text-sky-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-sky-500"></i> Layanan</a></li>
          <li><a href="#gallery" class="hover:text-sky-400 transition flex items-center gap-2"><i class="fa-solid fa-chevron-right text-xs text-sky-500"></i> Galeri</a></li>
        </ul>
      </div>

      <!-- Lokasi -->
      <div id="footer-lokasi" class="footer-animate">
        <h3 class="text-lg font-bold mb-5 flex items-center gap-2"><i class="fa-solid fa-location-dot text-sky-400"></i> Lokasi Kami</h3>
        <div class="w-full rounded-xl overflow-hidden shadow-lg border border-white/10">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3945.26015016994!2d116.0791956745222!3d-8.570965686954882!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dcdc10022fd3a0d%3A0xfda15d722c655f8b!2sCV.%20NUSTECH!5e0!3m2!1sen!2sus!4v1752163703447!5m2!1sen!2sus"
            width="100%" height="200" style="border:0;border-radius:12px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="mt-12 pt-6 border-t border-white/10 text-center">
      <p class="text-blue-200/50 text-xs">&copy; {{ date('Y') }} CV. NUSTECH. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- MODAL WRAPPER -->
<div
  id="basebandModal"
  class="fixed inset-0 z-50 hidden bg-black/60">

  <!-- MODAL BOX -->
<div
  id="basebandModalBox"
  class="bg-white w-full h-full flex flex-col
         transform transition-all duration-300
         opacity-0 scale-95">

  <!-- HEADER (TIDAK IKUT SCROLL) -->
  <div class="sticky top-0 z-20 modal-fs-header shrink-0">
    <div class="flex items-center gap-3">
      <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
        <i class="fa-solid fa-tower-broadcast text-white"></i>
      </div>
      <h3>Pemasangan Jaringan Internet BAKTI BTS</h3>
    </div>
    <button onclick="closeBasebandModal()" class="modal-close-btn absolute right-6">&times;</button>
  </div>

  <!-- BODY (SCROLL DI SINI) -->
  <div class="flex-1 overflow-y-auto px-6">

    <div class="min-h-full flex items-center justify-center">
      <div class="max-w-5xl mx-auto w-full py-12 md:py-20 space-y-16 text-gray-700">

        <!-- HERO SECTION -->
        <div class="text-center space-y-6 animate-fade-in-up">
          <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-sky-50 mx-auto border-4 border-white shadow-lg animate-float">
            <i class="fa-solid fa-signal text-5xl text-sky-500"></i>
          </div>
          <h4 class="text-3xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-cyan-500 tracking-tight">
            Konektivitas Unggul Melalui BTS
          </h4>
          <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed">
            Menjangkau wilayah terpencil dengan sinyal cepat dan stabil untuk masa depan digital Indonesia.
          </p>
        </div>

        <!-- MAIN CONTENT GRID -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
          <div class="space-y-6 text-justify leading-relaxed text-gray-600 animate-fade delay-200">
            <p class="text-lg">
              Melalui program <strong class="text-gray-800 font-semibold">Jaringan Internet BAKTI BTS</strong>, kami menghadirkan infrastruktur jaringan presisi tinggi sebagai solusi konektivitas andal di wilayah tertinggal, terdepan, dan terluar (3T).
            </p>
            <div class="bg-sky-50 border-l-4 border-sky-500 p-6 rounded-r-xl">
              <p class="text-gray-700 italic">
                "<strong>Baseband Tower (BB)</strong> berperan krusial sebagai jembatan digital yang mengintegrasikan radio, VSAT, dan transmisi data ke backbone nasional."
              </p>
            </div>
            <p>
              Seluruh instalasi dilaksanakan oleh tenaga teknis profesional tersertifikasi yang mengutamakan keselamatan kerja (K3), keandalan sistem operasi, serta kualitas layanan jangka panjang.
            </p>
          </div>
          
          <!-- FEATURES LIST -->
          <div class="space-y-6 animate-fade delay-300">
             <!-- Card 1 -->
             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-5 hover:shadow-lg transition-all hover:-translate-y-1">
               <div class="w-14 h-14 rounded-xl bg-sky-100 flex-shrink-0 flex items-center justify-center text-sky-600">
                 <i class="fa-solid fa-screwdriver-wrench text-2xl"></i>
               </div>
               <div>
                 <h5 class="text-xl font-bold text-gray-800 mb-2">Instalasi Perangkat Keras</h5>
                 <p class="text-gray-500 text-sm leading-relaxed">Pemasangan baseband, radio, dan antena sektoral terstruktur untuk jangkauan sinyal maksimal.</p>
               </div>
             </div>
             
             <!-- Card 2 -->
             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-5 hover:shadow-lg transition-all hover:-translate-y-1">
               <div class="w-14 h-14 rounded-xl bg-sky-100 flex-shrink-0 flex items-center justify-center text-sky-600">
                 <i class="fa-solid fa-bolt text-2xl"></i>
               </div>
               <div>
                 <h5 class="text-xl font-bold text-gray-800 mb-2">Optimalisasi Jaringan</h5>
                 <p class="text-gray-500 text-sm leading-relaxed">Integrasi VSAT & IP mutakhir agar transmisi data lebih cepat, stabil, dan minim gangguan.</p>
               </div>
             </div>

             <!-- Card 3 -->
             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex gap-5 hover:shadow-lg transition-all hover:-translate-y-1">
               <div class="w-14 h-14 rounded-xl bg-sky-100 flex-shrink-0 flex items-center justify-center text-sky-600">
                 <i class="fa-solid fa-stopwatch text-2xl"></i>
               </div>
               <div>
                 <h5 class="text-xl font-bold text-gray-800 mb-2">Solusi Cepat & Efisien</h5>
                 <p class="text-gray-500 text-sm leading-relaxed">Tim responsif untuk peningkatan kapasitas BTS sesuai adaptasi konektivitas terkini.</p>
               </div>
             </div>
          </div>
        </div>

      </div>
    </div>

  </div>

  <!-- FOOTER (TIDAK IKUT SCROLL) -->
  <div class="sticky bottom-0 modal-footer-bar shrink-0">
    <button onclick="closeBasebandModal()" class="modal-footer-btn">Tutup</button>
  </div>
</div>
</div>
<div
  id="vsatModal"
  class="fixed inset-0 z-50 hidden bg-black/60">

  <!-- MODAL BOX -->
  <div
    id="vsatModalBox"
    class="bg-white w-full h-full flex flex-col
           transform transition-all duration-300
           opacity-0 scale-95">

    <!-- HEADER (TIDAK IKUT SCROLL) -->
    <div class="sticky top-0 z-20 modal-fs-header shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
          <i class="fa-solid fa-satellite-dish text-white"></i>
        </div>
        <h3>Pemasangan & Perawatan Jaringan VSAT</h3>
      </div>
      <button onclick="closeVsatModal()" class="modal-close-btn absolute right-6">&times;</button>
    </div>

    <!-- BODY (SCROLL DI SINI) -->
    <div class="flex-1 overflow-y-auto px-6">

      <div class="min-h-full flex items-center justify-center">
        <div class="max-w-5xl mx-auto w-full py-12 md:py-20 space-y-16 text-gray-700">

          <!-- HERO SECTION -->
          <div class="text-center space-y-6 animate-fade-in-up">
            <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-sky-50 mx-auto border-4 border-white shadow-lg animate-float">
              <i class="fa-solid fa-globe text-5xl text-sky-500"></i>
            </div>
            <h4 class="text-3xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-cyan-500 tracking-tight">
              Koneksi Tanpa Batas Wilayah
            </h4>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed">
              Menghapus batasan geografis dengan teknologi komunikasi satelit (VSAT) terdepan untuk daerah 3T.
            </p>
          </div>

          <!-- TWO COLUMN LAYOUT -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 animate-fade delay-200 hover:shadow-lg transition-transform hover:-translate-y-1">
              <div class="w-12 h-12 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center mb-6">
                <i class="fa-solid fa-satellite-dish text-2xl"></i>
              </div>
              <h5 class="text-2xl font-bold text-gray-800 mb-4">Tulang Punggung Konektivitas</h5>
              <p class="text-gray-600 text-justify leading-relaxed mb-4">
                Bagaimana koneksi internet tetap ada di wilayah yang belum terjangkau fiber optic? <strong>VSAT (Very Small Aperture Terminal)</strong> adalah solusinya.
              </p>
              <p class="text-gray-600 text-justify leading-relaxed">
                Melalui program <strong>Internet BAKTI</strong>, kami menyediakan instalasi & perawatan jaringan satelit untuk sekolah, puskesmas, dan kantor pemerintahan di daerah terpencil.
              </p>
            </div>

            <div class="grid grid-cols-1 gap-4 animate-fade delay-300">
               <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition hover:-translate-y-1">
                 <div class="w-12 h-12 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-satellite"></i></div>
                 <div>
                    <h6 class="font-bold text-gray-800">Instalasi Presisi</h6>
                    <p class="text-sm text-gray-500 mt-1">Pemasangan antena dan pointing satelit akurat.</p>
                 </div>
               </div>
               <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition hover:-translate-y-1">
                 <div class="w-12 h-12 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-network-wired"></i></div>
                 <div>
                    <h6 class="font-bold text-gray-800">Integrasi Sistem</h6>
                    <p class="text-sm text-gray-500 mt-1">Distribusi internet lokal yang stabil dan efisien.</p>
                 </div>
               </div>
               <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-md transition hover:-translate-y-1">
                 <div class="w-12 h-12 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center text-xl shrink-0"><i class="fa-solid fa-toolbox"></i></div>
                 <div>
                    <h6 class="font-bold text-gray-800">Maintenance Rutin</h6>
                    <p class="text-sm text-gray-500 mt-1">Pemantauan berkala meminimalkan gangguan operasional.</p>
                 </div>
               </div>
            </div>

          </div>

          <!-- MILESTONE WRAPPER -->
          <div class="mt-16 animate-fade delay-400">
             <div class="text-center mb-12">
               <h4 class="text-3xl font-bold text-gray-800 inline-block border-b-4 border-sky-400 pb-2">Jejak Langkah Kami</h4>
             </div>
             
             <div class="milestone-wrapper" style="padding: 0;">
                <!-- ITEM -->
                <div class="milestone-item show mb-10">
                  <div class="milestone-year">2024</div>
                  <div class="milestone-line"><span class="milestone-dot"></span></div>
                  <div class="milestone-content bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <img src="{{ asset('assets/img/exp-vsat.jpg') }}" alt="VSAT 2024">
                    <div class="py-2 pr-4">
                      <h6 class="font-bold text-gray-800 mb-2">Sulawesi Tengah & Kalimantan Utara</h6>
                      <p class="text-sm text-gray-500">Instalasi VSAT BAKTI di ratusan lokasi untuk mendukung pemerataan akses informasi digital.</p>
                    </div>
                  </div>
                </div>

                <!-- ITEM -->
                <div class="milestone-item show mb-10">
                  <div class="milestone-year">2023</div>
                  <div class="milestone-line"><span class="milestone-dot"></span></div>
                  <div class="milestone-content bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <img src="{{ asset('assets/img/exp-vsat.jpg') }}" alt="VSAT 2023">
                    <div class="py-2 pr-4">
                      <h6 class="font-bold text-gray-800 mb-2">Ekspansi Wilayah Timur</h6>
                      <p class="text-sm text-gray-500">Pemberdayaan jaringan VSAT di Sulawesi Utara, Tenggara, dan Kota Sorong demi akses daerah 3T.</p>
                    </div>
                  </div>
                </div>

                <!-- ITEM -->
                <div class="milestone-item show">
                  <div class="milestone-year">2022</div>
                  <div class="milestone-line"><span class="milestone-dot"></span></div>
                  <div class="milestone-content bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <img src="{{ asset('assets/img/exp-vsat.jpg') }}" alt="VSAT 2022">
                    <div class="py-2 pr-4">
                      <h6 class="font-bold text-gray-800 mb-2">Fokus Stabilitas</h6>
                      <p class="text-sm text-gray-500">Maintenance komprehensif perangkat VSAT di kawasan Maluku, Papua, dan Nusa Tenggara Barat.</p>
                    </div>
                  </div>
                </div>
             </div>
          </div>

        </div>
      </div>
    </div>

    <!-- FOOTER (TIDAK IKUT SCROLL) -->
    <div class="sticky bottom-0 modal-footer-bar shrink-0">
      <button onclick="closeVsatModal()" class="modal-footer-btn">Tutup</button>
    </div>

  </div>
</div>
<!-- MODAL BACKDROP -->
<!-- MODAL JARINGAN KOMPUTER -->
<div
  id="jaringanModal"
  class="fixed inset-0 z-50 hidden bg-black/60">

  <!-- MODAL BOX -->
  <div
    id="jaringanModalBox"
    class="bg-white w-full h-full flex flex-col
           transform transition-all duration-300
           opacity-0 scale-95">

    <!-- HEADER (TIDAK IKUT SCROLL) -->
    <div class="sticky top-0 z-20 modal-fs-header shrink-0">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
          <i class="fa-solid fa-network-wired text-white"></i>
        </div>
        <h3>Instalasi & Maintenance Jaringan Komputer</h3>
      </div>
      <button onclick="closeJaringanModal()" class="modal-close-btn absolute right-6">&times;</button>
    </div>

    <!-- BODY (SCROLL DI SINI) -->
    <div class="flex-1 overflow-y-auto px-6">

      <div class="max-w-5xl mx-auto w-full py-12 md:py-20 text-gray-700">

        <!-- HEADER HERO -->
        <div class="flex flex-col md:flex-row items-center justify-between gap-10 mb-20 animate-fade-in-up">
          <div class="flex-1 space-y-6">
            <span class="inline-block py-1 px-3 rounded-full bg-sky-100 text-sky-600 font-semibold text-sm tracking-wide">IT NETWORK SERVICES</span>
            <h4 class="text-4xl md:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-sky-600 to-cyan-500 tracking-tight leading-tight">
              Fondasi Digital <br/>yang Andal
            </h4>
            <p class="text-gray-500 text-lg md:text-xl leading-relaxed max-w-lg">
              Jaringan stabil, aman, dan scalable tidak terjadi secara kebetulan—semuanya dimulai dari instalasi & arsitektur yang presisi.
            </p>
          </div>
          <div class="flex-shrink-0 relative">
            <div class="absolute inset-0 bg-sky-400 rounded-full blur-2xl opacity-20 animate-pulse"></div>
            <div class="w-40 h-40 md:w-64 md:h-64 bg-white rounded-full shadow-2xl border-8 border-sky-50 flex items-center justify-center relative z-10 animate-float">
              <i class="fa-solid fa-server text-6xl md:text-8xl text-sky-500"></i>
            </div>
          </div>
        </div>

        <!-- SERVICES GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
          <!-- Card 1 -->
          <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
            <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors text-sky-600 text-2xl">
              <i class="fa-solid fa-compass-drafting"></i>
            </div>
            <h5 class="text-2xl font-bold text-gray-800 mb-3">Perencanaan & Instalasi</h5>
            <p class="text-gray-500 leading-relaxed">
              Desain topologi LAN, WAN, dan WiFi profesional. Penarikan kabel rapi (UTP/Fiber Optic), penataan rack server standar data center, dan setup infrastruktur awal.
            </p>
          </div>
          
          <!-- Card 2 -->
          <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
            <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors text-sky-600 text-2xl">
              <i class="fa-solid fa-gears"></i>
            </div>
            <h5 class="text-2xl font-bold text-gray-800 mb-3">Konfigurasi Perangkat</h5>
            <p class="text-gray-500 leading-relaxed">
              Setup router kelas enterprise, switch manageable, access point, firewall, VLAN routing, dan load balancing untuk manajemen bandwidth cerdas.
            </p>
          </div>

          <!-- Card 3 -->
          <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
            <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors text-sky-600 text-2xl">
              <i class="fa-solid fa-chart-line"></i>
            </div>
            <h5 class="text-2xl font-bold text-gray-800 mb-3">Maintenance & Monitoring</h5>
            <p class="text-gray-500 leading-relaxed">
              Pengawasan traffic 24/7, pemeliharaan hardware rutin, dokumentasi aset IT, dan penanganan gangguan (troubleshooting) cepat tanggap.
            </p>
          </div>

          <!-- Card 4 -->
          <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-2 group">
            <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center mb-6 group-hover:bg-sky-500 group-hover:text-white transition-colors text-sky-600 text-2xl">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h5 class="text-2xl font-bold text-gray-800 mb-3">Keamanan & Skalabilitas</h5>
            <p class="text-gray-500 leading-relaxed">
              Audit keamanan jaringan, implementasi VPN, pembatasan akses, serta arsitektur yang mudah diekspansi mengikuti pertumbuhan bisnis perusahaan.
            </p>
          </div>
        </div>

        <!-- VALUE STRIP CTA -->
        <div class="bg-gradient-to-br from-sky-600 to-cyan-700 rounded-3xl overflow-hidden relative shadow-2xl animate-fade delay-400">
          <div class="absolute inset-0 opacity-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
          <div class="p-10 md:p-14 text-center text-white relative z-10">
            <h5 class="text-3xl font-bold mb-8">Mengapa NUSTECH Mitra Terbaik Anda?</h5>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-left max-w-4xl mx-auto">
              <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm">
                <i class="fa-solid fa-user-tie text-2xl text-amber-300 mt-1"></i>
                <span class="font-medium leading-tight">Teknisi Tersertifikasi</span>
              </div>
              <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm">
                <i class="fa-solid fa-rocket text-2xl text-amber-300 mt-1"></i>
                <span class="font-medium leading-tight">SLA Respons Super Cepat</span>
              </div>
              <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm">
                <i class="fa-solid fa-wand-magic-sparkles text-2xl text-amber-300 mt-1"></i>
                <span class="font-medium leading-tight">Implementasi Rapi & Estetis</span>
              </div>
              <div class="flex items-start gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm">
                <i class="fa-solid fa-handshake-angle text-2xl text-amber-300 mt-1"></i>
                <span class="font-medium leading-tight">Support Jangka Panjang</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- FOOTER (TIDAK IKUT SCROLL) -->
    <div class="sticky bottom-0 modal-footer-bar shrink-0">
      <button onclick="closeJaringanModal()" class="modal-footer-btn">Tutup</button>
    </div>

  </div>
</div>


<style>
  .milestone-wrapper {
    max-width: 1100px;
    margin: 0 auto;
    padding: 80px 20px;
  }

  .milestone-item {
    display: grid;
    grid-template-columns: 120px 40px 1fr;
    gap: 30px;
    align-items: flex-start;
    margin-bottom: 100px;

    opacity: 0;
    transform: translateY(60px);
    transition: all 0.9s ease;
  }

  .milestone-item.show {
    opacity: 1;
    transform: translateY(0);
  }

  /* YEAR */
  .milestone-year {
    font-size: 32px;
    font-weight: 700;
    color: #0ea5e9;
    text-align: right;
  }

  /* LINE */
  .milestone-line {
    position: relative;
    display: flex;
    justify-content: center;
  }

  .milestone-line::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: -100px;
    width: 3px;
    background: #0ea5e9;
  }

  .milestone-dot {
    width: 14px;
    height: 14px;
    background: #0ea5e9;
    border-radius: 50%;
    margin-top: 10px;
    z-index: 2;
  }

  /* CONTENT */
  .milestone-content {
    display: flex;
    gap: 30px;
    align-items: center;

    opacity: 0;
    transform: translateX(60px) scale(0.95);
    transition: all 0.9s ease 0.2s;
  }

  .milestone-item.show .milestone-content {
    opacity: 1;
    transform: translateX(0) scale(1);
  }

  .milestone-content img {
    width: 220px;
    height: 140px;
    object-fit: cover;
    border-radius: 12px;
  }

  .milestone-content p {
    color: #374151;
    line-height: 1.7;
    max-width: 480px;
  }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    .milestone-item {
      grid-template-columns: 1fr;
    }

    .milestone-year {
      text-align: left;
    }

    .milestone-line {
      display: none;
    }

    .milestone-content {
      flex-direction: column;
      align-items: flex-start;
    }
  }
</style>
<!-- Script Milestone -->
<script>
const milestones = document.querySelectorAll('.milestone-item');

const milestoneObserver = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    }
  });
}, {
  threshold: 0.25
});

milestones.forEach(item => milestoneObserver.observe(item));
</script>
<!-- Script Modal Jaringan -->
<script>
  function openJaringanModal() {
    const modal = document.getElementById('jaringanModal');
    const box = document.getElementById('jaringanModalBox');

    modal.classList.remove('hidden');
    if (document.getElementById('navbar')) document.getElementById('navbar').classList.add('hidden');

    setTimeout(() => {
      box.classList.remove('opacity-0', 'scale-95');
      box.classList.add('opacity-100', 'scale-100');
    }, 10);

    document.body.classList.add('overflow-hidden');
  }

  function closeJaringanModal() {
    const modal = document.getElementById('jaringanModal');
    const box = document.getElementById('jaringanModalBox');

    box.classList.add('opacity-0', 'scale-95');
    box.classList.remove('opacity-100', 'scale-100');

    setTimeout(() => {
      modal.classList.add('hidden');
      document.body.classList.remove('overflow-hidden');
      if (document.getElementById('navbar')) document.getElementById('navbar').classList.remove('hidden');
    }, 300);
  }
</script>
<!-- Script Modal VSAT -->
<script>
function openVsatModal() {
  const modal = document.getElementById('vsatModal');
  const box   = document.getElementById('vsatModalBox');

  modal.classList.remove('hidden');
  if (document.getElementById('navbar')) document.getElementById('navbar').classList.add('hidden');

  setTimeout(() => {
    box.classList.remove('opacity-0', 'scale-95');
    box.classList.add('opacity-100', 'scale-100');
  }, 50);

  document.body.classList.add('overflow-hidden');
}

function closeVsatModal() {
  const modal = document.getElementById('vsatModal');
  const box   = document.getElementById('vsatModalBox');

  box.classList.add('opacity-0', 'scale-95');

  setTimeout(() => {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    if (document.getElementById('navbar')) document.getElementById('navbar').classList.remove('hidden');
  }, 300);
}
</script>

<script>
function openBasebandModal() {
  const modal = document.getElementById('basebandModal');
  const box = document.getElementById('basebandModalBox');

  modal.classList.remove('hidden');
  if (document.getElementById('navbar')) document.getElementById('navbar').classList.add('hidden');

  setTimeout(() => {
    box.classList.remove('opacity-0', 'scale-95');
    box.classList.add('opacity-100', 'scale-100');
  }, 50);

  document.body.classList.add('overflow-hidden');
}

function closeBasebandModal() {
  const modal = document.getElementById('basebandModal');
  const box = document.getElementById('basebandModalBox');

  box.classList.add('opacity-0', 'scale-95');

  setTimeout(() => {
    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    if (document.getElementById('navbar')) document.getElementById('navbar').classList.remove('hidden');
  }, 300);
}
</script>
<script>
  document.querySelectorAll("details").forEach((targetDetail) => {
    targetDetail.addEventListener("toggle", () => {
      if (targetDetail.open) {
        document.querySelectorAll("details").forEach((detail) => {
          if (detail !== targetDetail && detail.open) {
            detail.removeAttribute("open");
          }
        });
      }
    });
  });
</script>
<script>
  const menuToggle = document.getElementById('menu-toggle');
  const mobileMenu = document.getElementById('mobile-menu');
  const dropdown = document.getElementById('dropdown-layanan');

  menuToggle.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  function toggleDropdown() {
    dropdown.classList.toggle('hidden');
  }
</script>
<!-- Script Modal -->
<script>
  function openModal() {
    document.getElementById('modalTentang').classList.remove('hidden');
    if (document.getElementById('navbar')) document.getElementById('navbar').classList.add('hidden');
  }

  function closeModal() {
    document.getElementById('modalTentang').classList.add('hidden');
    if (document.getElementById('navbar')) document.getElementById('navbar').classList.remove('hidden');
  }
</script>
<!-- Tambahan Animasi -->
<style>
  @keyframes fade-in-up {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in-up {
    animation: fade-in-up 1.2s ease-out both;
  }

  .fade-in-up {
    animation: fade-in-up 0.6s ease-out both;
  }
</style>
<script>
  function showLayanan(id) {
    const items = document.querySelectorAll('.layanan-item');

    items.forEach(item => {
      item.classList.add('hidden');
      item.classList.remove('animate-slide-in');
    });

    const selected = document.getElementById(id);
    if (selected) {
      selected.classList.remove('hidden');
      selected.classList.add('animate-slide-in');
    }

    // Optional: scroll ke bagian section layanan
    document.getElementById('layanan').scrollIntoView({ behavior: 'smooth' });
  }
</script>
  <!-- Tombol Scroll -->
  <script>
    function scrollGallery(direction) {
      const container = document.getElementById('galleryContainer');
      const scrollAmount = 300; // px
      container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }
  </script>
<script>
  function updateNavbarTextColor() {
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll("#menu a");
    const scrollPos = window.scrollY + 80; // tambahkan offset sedikit untuk toleransi

    sections.forEach(section => {
      const rect = section.getBoundingClientRect();
      const top = rect.top + window.scrollY;
      const bottom = top + section.offsetHeight;

      if (scrollPos >= top && scrollPos < bottom) {
        // Ambil class dari section
        const isDark = section.classList.contains("bg-black") || section.classList.contains("text-white");
        
        navLinks.forEach(link => {
          link.classList.remove("text-white", "text-black");
          if (isDark) {
            link.classList.add("text-white");
          } else {
            link.classList.add("text-black");
          }
        });
      }
    });
  }

  window.addEventListener("DOMContentLoaded", updateNavbarTextColor);
  window.addEventListener("scroll", updateNavbarTextColor);
  window.addEventListener("resize", updateNavbarTextColor);
</script>

  <script>
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
  <script>
  window.addEventListener("DOMContentLoaded", () => {
    const footerItems = document.querySelectorAll(".footer-animate");

    footerItems.forEach((item, index) => {
      setTimeout(() => {
        item.classList.add("visible");
      }, index * 400); // delay antar item: 400ms
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    }, { threshold: 0.2 });

    const paragraphs = document.querySelectorAll("#tentang p");
    paragraphs.forEach((p, i) => {
      if (i % 2 === 0) {
        p.classList.add("fade-in-left");
      } else {
        p.classList.add("fade-in-right");
      }
      observer.observe(p);
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    }, { threshold: 0.2 });

    // Tentang Kami
    const paragraphs = document.querySelectorAll("#tentang p");
    paragraphs.forEach((p, i) => {
      if (i % 2 === 0) {
        p.classList.add("fade-in-left");
      } else {
        p.classList.add("fade-in-right");
      }
      observer.observe(p);
    });

    // VISI box (fade-in-up optional kalau mau)
    const visiBox = document.querySelector("#visimisi .bg-sky-500");
    if (visiBox) {
      visiBox.classList.add("fade-in-up");// atau fade-in-up
      observer.observe(visiBox);
    }

    // Misi list (selang-seling)
    const misiItems = document.querySelectorAll("#visimisi ul li");
    misiItems.forEach((li, i) => {
      if (i % 2 === 0) {
        li.classList.add("fade-in-left");
      } else {
        li.classList.add("fade-in-right");
      }
      observer.observe(li);
    });
  });
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
      }else {
  entry.target.classList.remove("visible"); // supaya animasi bisa reset
}
    });
  }, { threshold: 0.15 });

  // Tangkap semua layanan (grid item dalam section #layanan)
  const layananItems = document.querySelectorAll("#layanan .grid > div");

  layananItems.forEach((item, index) => {
    const animationClass = index % 2 === 0 ? "fade-in-left" : "fade-in-right";
    item.classList.add(animationClass);
    observer.observe(item);
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }else {
  entry.target.classList.remove("visible"); // supaya animasi bisa reset
}
    });
  }, { threshold: 0.1 });

  const strategiItems = document.querySelectorAll("#strategi ul li");
  const kebijakanItems = document.querySelectorAll("#kebijakan ul li");

  [...strategiItems].forEach((item, i) => {
    const anim = i % 2 === 0 ? "fade-in-left" : "fade-in-right";
    item.classList.add(anim);
    observer.observe(item);
  });

  [...kebijakanItems].forEach((item, i) => {
    const anim = i % 2 === 0 ? "fade-in-left" : "fade-in-right";
    item.classList.add(anim);
    observer.observe(item);
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
      else {
  entry.target.classList.remove("visible"); // supaya animasi bisa reset
}
    });
  }, { threshold: 0.1 });

  const animateStagger = (selector) => {
    const items = document.querySelectorAll(selector);
    items.forEach((item, i) => {
      const animClass = i % 2 === 0 ? "fade-in-left" : "fade-in-right";
      item.classList.add(animClass);
      item.style.transitionDelay = `${i * 0.2}s`;
      observer.observe(item);
    });
  };

  // âœ¨ Fade-in atas-bawah untuk heading dan paragraf utama
  const headerText = document.querySelectorAll("#kebijakan h2, #kebijakan > p");
  headerText.forEach((el, i) => {
    el.classList.add("fade-in-down");
    el.style.transitionDelay = `${i * 0.2}s`;
    observer.observe(el);
  });

  // âœ¨ Fade-in selang seling untuk <li>
  animateStagger("#kebijakan ul li");
  animateStagger("#strategi ul li");
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      } else {
        entry.target.classList.remove('visible'); // reset animasi jika keluar viewport
      }
    });
  }, { threshold: 0.1 });

  const animateStagger = (selector) => {
    const items = document.querySelectorAll(selector);
    items.forEach((item, i) => {
      const animClass = i % 2 === 0 ? "fade-in-left" : "fade-in-right";
      item.classList.add(animClass);
      item.style.transitionDelay = `${i * 0.1}s`;
      observer.observe(item);
    });
  };

  // Section: TENTANG
  animateStagger("#tentang p");

  // Section: VISI & MISI
  const visiBox = document.querySelector("#visimisi .bg-sky-500");
  if (visiBox) {
    visiBox.classList.add("fade-in-up");
    observer.observe(visiBox);
  }
  animateStagger("#visimisi ul li");

  // Section: LAYANAN
  animateStagger("#layanan .grid > div");

  // Section: STRATEGI & KEBIJAKAN
  animateStagger("#strategi ul li");
  animateStagger("#kebijakan ul li");

  const kebijakanHeader = document.querySelectorAll("#kebijakan h2, #kebijakan > p");
  kebijakanHeader.forEach((el, i) => {
    el.classList.add("fade-in-down");
    el.style.transitionDelay = `${i * 0.2}s`;
    observer.observe(el);
  });

  // Footer animasi
  const footerItems = document.querySelectorAll(".footer-animate");
  footerItems.forEach((item, i) => {
    item.style.transitionDelay = `${i * 0.2}s`;
    observer.observe(item);
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
  /* ============= SCROLL REVEAL SYSTEM ============= */
  const revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });

  // Observe all reveal elements
  document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .fade-in-up, .fade-in-left, .fade-in-right, .footer-animate').forEach(el => {
    revealObserver.observe(el);
  });

  /* ============= STAT COUNTER ANIMATION ============= */
  const counterObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const target = parseInt(el.getAttribute('data-count'));
        if (!target || el.dataset.counted) return;
        el.dataset.counted = 'true';
        let count = 0;
        const duration = 2000;
        const step = Math.max(1, Math.floor(target / (duration / 30)));
        const timer = setInterval(() => {
          count += step;
          if (count >= target) { count = target; clearInterval(timer); }
          el.textContent = count + '+';
        }, 30);
      }
    });
  }, { threshold: 0.5 });

  document.querySelectorAll('.stat-number[data-count]').forEach(el => counterObserver.observe(el));

  /* ============= NAVBAR SCROLL ============= */
  const navbar = document.getElementById('navbar');
  const navCapsule = document.getElementById('navCapsule');
  const brandText = document.getElementById('navBrandText');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
      navCapsule.classList.add('scrolled');
      if (brandText) brandText.style.color = '#1a1a2e';
    } else {
      navbar.classList.remove('scrolled');
      navCapsule.classList.remove('scrolled');
      if (brandText) brandText.style.color = '#ffffff';
    }
  });

  /* ============= DROPDOWN (HOVER + ANIMATION) ============= */
  const wrapper = document.getElementById('layananDropdown');
  const menu = document.getElementById('layananMenu');
  const arrow = document.getElementById('layananArrow');
  let hideTimeout;

  if (wrapper && menu) {
    const showMenu = () => {
      clearTimeout(hideTimeout);
      menu.classList.remove('hidden');
      requestAnimationFrame(() => {
        menu.classList.add('mega-menu-show');
        if (arrow) arrow.classList.add('rotate');
      });
    };
    const hideMenu = () => {
      hideTimeout = setTimeout(() => {
        menu.classList.remove('mega-menu-show');
        if (arrow) arrow.classList.remove('rotate');
        setTimeout(() => { 
          if (!menu.classList.contains('mega-menu-show')) {
            menu.classList.add('hidden'); 
          }
        }, 450);
      }, 150);
    };
    wrapper.addEventListener('mouseenter', showMenu);
    wrapper.addEventListener('mouseleave', hideMenu);
    // Keep menu open when hovering on it (it's position:fixed, outside wrapper bounds)
    menu.addEventListener('mouseenter', () => clearTimeout(hideTimeout));
    menu.addEventListener('mouseleave', hideMenu);
    // Close on clicking any link/button inside the menu
    menu.querySelectorAll('a[href^="#"], button[onclick]').forEach(el => {
      el.addEventListener('click', () => {
        menu.classList.remove('mega-menu-show');
        if (arrow) arrow.classList.remove('rotate');
        setTimeout(() => menu.classList.add('hidden'), 450);
      });
    });
  }

  /* ============= MOBILE MENU ============= */
  const menuToggle = document.getElementById('menu-toggle');
  if (menuToggle) {
    menuToggle.addEventListener('click', () => {
      document.getElementById('mobile-menu').classList.toggle('hidden');
    });
  }
});
</script>

<!-- Tombol WhatsApp -->
<a href="https://wa.me/6281332809923?text=Halo%2C%20saya%20tertarik%20dengan%20layanan%20undangan%20digital%20yang%20Anda%20tawarkan.%20Boleh%20saya%20minta%20informasi%20lebih%20lanjut%20terkait%20paket%2C%20fitur%2C%20dan%20cara%20pemesanan%3F%20Terima%20kasih. " target="_blank"
   class="fixed bottom-6 right-6 z-50 bg-green-500 hover:bg-green-600 text-white rounded-full p-4 shadow-lg flex items-center space-x-2 transition-all duration-300">
  <!-- Ikon WhatsApp -->
  <svg class="w-6 h-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
    <path d="M16.001 3C9.374 3 4 8.374 4 15.001c0 2.646.99 5.072 2.615 6.957L4 29l7.28-2.56A11.956 11.956 0 0 0 16 27c6.627 0 12-5.373 12-11.999S22.627 3 16.001 3zm0 22c-1.484 0-2.891-.373-4.125-1.033l-.29-.162-4.336 1.524 1.478-4.214-.186-.3a8.953 8.953 0 0 1-1.542-5.019c0-4.962 4.037-9 9-9 4.961 0 9 4.038 9 9s-4.039 9-9 9zm5.533-6.529c-.306-.154-1.801-.889-2.08-.991-.278-.102-.48-.153-.683.154-.202.306-.784.991-.961 1.193-.177.202-.355.229-.66.076-.305-.152-1.29-.475-2.455-1.516-.906-.807-1.516-1.802-1.693-2.107-.177-.306-.018-.471.135-.623.138-.138.305-.354.457-.531.152-.178.203-.305.305-.509.101-.203.05-.381-.025-.533-.076-.152-.683-1.646-.935-2.25-.245-.59-.494-.51-.683-.52-.178-.01-.381-.012-.584-.012s-.533.076-.813.38c-.278.305-1.066 1.04-1.066 2.531 0 1.491 1.092 2.932 1.244 3.134.152.203 2.149 3.275 5.209 4.592.728.313 1.296.5 1.738.64.73.232 1.394.2 1.919.122.585-.087 1.801-.735 2.057-1.447.253-.71.253-1.319.177-1.447-.076-.127-.278-.202-.584-.355z"/>
  </svg>
  <span class="hidden sm:inline font-semibold">Live Chat</span>
</a>
</body>
</html>
