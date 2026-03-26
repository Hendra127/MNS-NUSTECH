<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Landing Page Nustech</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&family=Roboto+Slab:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden;
      height: 100vh;
      width: 100vw;
      background-color: #4c1d95; /* fallback color */
    }
    
    #bgVideo {
      position: fixed;
      top: 0;
      left: 0;
      min-width: 100%;
      min-height: 100%;
      object-fit: cover;
      z-index: -1;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes float {
      0% { transform: translateY(0px); }
      50% { transform: translateY(-15px); }
      100% { transform: translateY(0px); }
    }

    @keyframes glow {
      0% { text-shadow: 0 0 10px rgba(14, 165, 233, 0.5); }
      50% { text-shadow: 0 0 25px rgba(14, 165, 233, 0.8), 0 0 40px rgba(14, 165, 233, 0.4); }
      100% { text-shadow: 0 0 10px rgba(14, 165, 233, 0.5); }
    }

    .fade-in { animation: fadeIn 2s ease-out both; }
    .animate-float { animation: float 6s ease-in-out infinite; }

    .hero-glass-v2 {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
      border-radius: 24px;
      transition: all 0.4s ease;
    }

    .welcome-3d {
      font-family: 'Quicksand', sans-serif;
      font-weight: 700;
      background: linear-gradient(to bottom, #ffffff 0%, #7dd3fc 45%, #0ea5e9 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      filter: drop-shadow(0px 8px 10px rgba(0,0,0,0.3)) drop-shadow(0px 0px 35px rgba(56, 189, 248, 0.7));
      letter-spacing: 2px;
    }

    .btn-simple {
      background: linear-gradient(135deg, #0ea5e9, #0284c7);
      border-radius: 9999px;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 4px 15px rgba(2, 132, 199, 0.3);
    }

    .btn-simple:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(2, 132, 199, 0.5);
      border-color: rgba(255, 255, 255, 0.3);
    }

    /* Navbar Glassmorphism - Premium */
    .nav-glass {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
      border-radius: 9999px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .nav-glass:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(255, 255, 255, 0.3);
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.5);
    }

    /* Dropdown Desktop */
    .group > .dropdown-menu {
      opacity: 0;
      visibility: hidden;
      transform: translateY(15px) scale(0.95);
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
    }
    .group:hover > .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
    }

    .dropdown-item {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      font-size: 14px;
      color: #1a202c;
      transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
      font-weight: 500;
    }
    .dropdown-item i {
      width: 24px;
      margin-right: 12px;
      font-size: 1.1rem;
      color: #0ea5e9;
      opacity: 0.7;
      transition: all 0.25s ease;
    }
    .dropdown-item:hover {
      background: #f0f9ff;
      color: #0369a1;
      padding-left: 28px;
    }
    .dropdown-item:hover i {
      opacity: 1;
      transform: scale(1.2) rotate(5deg);
    }

    /* Nav Link Hover Underline */
    .nav-link { 
      position: relative; 
      transition: color 0.3s ease;
    }
    .nav-link::after {
      content: ''; position: absolute; bottom: 0; left: 50%; width: 0;
      height: 2px; background: #0ea5e9; transition: all 0.3s ease;
      transform: translateX(-50%);
    }
    .nav-link:hover::after { width: 70%; }
    .nav-link:hover { color: #0ea5e9; }

    .brand-glow {
      text-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
    }
  </style>
</head>

<body class="relative flex flex-col justify-center items-center text-gray-100">

  <video autoplay muted loop playsinline id="bgVideo">
    <source src="{{ asset('assets/video/coba.mp4') }}" type="video/mp4" />
  </video>

  <div class="absolute z-10 animate-slide-in-left w-full max-w-4xl px-8" style="top: 35%; left: 5%;">
    <div class="hero-glass-v2 p-10 md:p-14 animate-float relative overflow-hidden">
      <h1 class="text-6xl md:text-[7.5rem] welcome-3d leading-none mb-6">
        WELCOME
      </h1>
      <p class="text-xl md:text-2xl text-white font-normal mb-10">
        <span class="font-bold underline underline-offset-[10px] decoration-white/50">Nustech Indonesia.</span>
      </p>
      
      <div class="flex flex-wrap mt-2">
        <a href="{{ route('mydashboard') }}" class="btn-simple px-8 py-3.5 flex items-center space-x-3 group text-white no-underline">
          <span class="font-bold text-[15px]">Explore Dashboard</span>
          <i class="fa-solid fa-circle-arrow-right text-[1.1rem] group-hover:translate-x-1 transition-transform"></i>
        </a>
      </div>
    </div>
  </div>

  <nav id="mainNav" class="w-full fixed top-0 left-0 z-50 py-6 transition-all duration-300">
    <div class="max-w-[95%] xl:max-w-7xl mx-auto px-6 flex items-center justify-between nav-glass py-2">
      
      <!-- Brand Logo Section -->
      <a href="/" class="flex items-center space-x-3 group">
        <div class="flex items-center justify-center">
          <img src="{{ asset('assets/img/logonustech.png') }}" alt="Nustech Logo" class="h-11 w-auto drop-shadow-lg transform transition-transform group-hover:scale-105" />
        </div>
        <span class="text-xl font-bold tracking-tight brand-glow">
          NUS<span class="text-blue-400">TECH</span>
        </span>
      </a>

      <!-- Desktop Navigation -->
      <ul class="hidden lg:flex items-center space-x-1 font-medium text-white">
        
        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2 flex items-center">
            Data Site
          </a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-60 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden py-2 border border-blue-50">
            <a href="{{ route('datasite') }}" class="dropdown-item">
              <i class="fa-solid fa-server"></i> Data Site
            </a>
            <a href="{{ route('datapas') }}" class="dropdown-item">
              <i class="fa-solid fa-lock"></i> Manajemen Password
            </a>
            <a href="{{ route('laporancm') }}" class="dropdown-item">
              <i class="fa-solid fa-tools"></i> Corrective Maintenance
            </a>
            <a href="{{ route('pmliberta') }}" class="dropdown-item">
              <i class="fa-solid fa-shield-heart"></i> Preventive Maintenance
            </a>
            <a href="{{ route('summarypm') }}" class="dropdown-item">
              <i class="fa-solid fa-chart-line"></i> Summary PM
            </a>
          </div>
        </li>

        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2 flex items-center">
            Tiket
          </a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden py-2 border border-blue-50">
            <a href="{{ route('open.ticket') }}" class="dropdown-item">
              <i class="fa-solid fa-ticket"></i> Open Tiket
            </a>
            <a href="{{ route('close.ticket') }}" class="dropdown-item">
              <i class="fa-solid fa-circle-check"></i> Close Tiket
            </a>
            <a href="{{ route('summaryticket') }}" class="dropdown-item">
              <i class="fa-solid fa-file-lines"></i> Summary Tiket
            </a>
            <a href="{{ route('detailticket') }}" class="dropdown-item">
              <i class="fa-solid fa-circle-info"></i> Detail Tiket
            </a>
            <a href="{{ route('mydashboard') }}" class="dropdown-item">
              <i class="fa-solid fa-gauge-high"></i> Dashboard Stats
            </a>
          </div>
        </li>

        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2 flex items-center">
            Log Perangkat
          </a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden py-2 border border-blue-50">
            <a href="{{ route('pergantianperangkat') }}" class="dropdown-item">
              <i class="fa-solid fa-recycle"></i> Pergantian Perangkat
            </a>
            <a href="{{ route('logpergantian') }}" class="dropdown-item">
              <i class="fa-solid fa-clock-rotate-left"></i> Log Pergantian
            </a>
            <a href="{{ route('sparetracker') }}" class="dropdown-item">
              <i class="fa-solid fa-microchip"></i> Spare Tracker
            </a>
            <a href="{{ route('summaryperangkat') }}" class="dropdown-item">
              <i class="fa-solid fa-clipboard-list"></i> PM Summary
            </a>
          </div>
        </li>

        <li class="relative group">
          <a href="#" class="nav-link px-4 py-2 flex items-center">
            Jadwal Piket
          </a>
          <div class="dropdown-menu absolute top-full left-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden py-2 border border-blue-50">
            <a href="{{ route('jadwalpiket') }}" class="dropdown-item">
              <i class="fa-solid fa-calendar-days"></i> Lihat Jadwal
            </a>
          </div>
        </li>

        @auth
          @php $role = Auth::user()->role; @endphp
          @if (in_array($role, ['admin', 'superadmin']))
            <li class="relative group">
              <a href="#" class="nav-link px-4 py-2 flex items-center">
                SLA
              </a>
              <div class="dropdown-menu absolute top-full left-0 mt-3 w-52 bg-white rounded-2xl shadow-2xl z-50 overflow-hidden py-2 border border-blue-50">
                <a href="{{ url('rekap-bmn') }}" class="dropdown-item">
                  <i class="fa-solid fa-file-export"></i> Rekap BMN
                </a>
                <a href="{{ url('rekap-sl') }}" class="dropdown-item">
                  <i class="fa-solid fa-file-contract"></i> Rekap SL
                </a>
              </div>
            </li>
          @endif
        @endauth

        <li><a href="{{ route('todolist') }}" class="nav-link px-4 py-2">To Do List</a></li>
        
        @auth
          @if (Auth::user()->role === 'superadmin')
            <li><a href="{{ url('users') }}" class="nav-link px-4 py-2 text-cyan-200 hover:text-cyan-400">Users</a></li>
          @endif
          
          <div class="h-6 w-px bg-white/20 mx-2"></div>

          <li class="flex items-center space-x-3 pl-2">
            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 text-white/90 hover:text-white transition group">
              <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center border border-blue-400/30 group-hover:bg-blue-500/40 transition-all">
                <i class="fa-solid fa-user text-xs"></i>
              </div>
              <span class="text-sm font-semibold">Profile</span>
            </a>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="bg-red-500/20 hover:bg-red-500/80 border border-red-500/50 hover:border-red-500 text-red-200 hover:text-white px-5 py-1.5 rounded-full text-xs font-bold transition-all duration-300 backdrop-blur-sm flex items-center">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> LOGOUT
              </button>
            </form>
          </li>
        @endauth
      </ul>

      <!-- Mobile Menu Toggle -->
      <button id="mobile-menu-button" class="lg:hidden text-white p-2">
        <i class="fa-solid fa-bars-staggered text-2xl"></i>
      </button>

    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white text-gray-800 w-full absolute top-full left-0 shadow-2xl border-t border-gray-100">
      <ul class="flex flex-col p-4 space-y-1">
        <li><a href="{{ route('datasite') }}" class="block p-3 border-b border-gray-50">Data Site</a></li>
        <li><a href="{{ route('open.ticket') }}" class="block p-3 border-b border-gray-50">Open Tiket</a></li>
        <li><a href="{{ route('close.ticket') }}" class="block p-3 border-b border-gray-50">Close Tiket</a></li>
        <li><a href="{{ route('summaryticket') }}" class="block p-3 border-b border-gray-50">Summary Tiket</a></li>
        <li><a href="{{ route('detailticket') }}" class="block p-3 border-b border-gray-50">Detail Tiket</a></li>
        <li><a href="{{ route('todolist') }}" class="block p-3 border-b border-gray-50">To Do List</a></li>
        @auth
            <li><a href="{{ route('profile.edit') }}" class="block p-3 border-b border-gray-50">Profile</a></li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full text-left p-3 text-red-600">Logout</button>
                </form>
            </li>
        @endauth
      </ul>
    </div>
  </nav>

  <footer class="w-full absolute bottom-0 left-0 py-6 text-sm text-center fade-in text-white/60">
    &copy; <script>document.write(new Date().getFullYear())</script> Nustech Indonesia. All rights reserved.
  </footer>

  <script>
    // Navbar Scroll Effect
    const nav = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 40) {
        nav.classList.add('py-3');
      } else {
        nav.classList.remove('py-3');
      }
    });

    // Mobile Menu Toggle
    const mobileBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    // Auto Logout Script based on Inactivity
    (function() {
        let timeout;
        const maxIdleTime = 3600000; // 1 jam (3.600.000 ms)

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logoutUser, maxIdleTime);
        }

        function logoutUser() {
            const logoutBtn = document.querySelector('form[action="{{ route('logout') }}"]');
            if (logoutBtn) {
                logoutBtn.submit();
            }
        }

        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer; 
        window.ontouchstart = resetTimer;
        window.onclick = resetTimer;     
        window.onkeydown = resetTimer;   
        window.addEventListener('scroll', resetTimer, true);
    })();
  </script>
</body>
</html>