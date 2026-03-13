<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nustech - Solution For Your Tech Problem</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .text-primary-blue { color: #214b6b; }
        .bg-primary-blue { background-color: #214b6b; }
        .border-primary-blue { border-color: #214b6b; }
        .nav-link { position: relative; }
        .nav-link::after {
            content: ''; position: absolute; bottom: -4px; left: 0; width: 0;
            height: 2px; background: white; transition: width 0.3s;
        }
        .nav-link:hover::after { width: 100%; }
        
        /* Glassmorphism for hero box */
        .glass-box {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-800">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 text-white px-6 md:px-12 py-6 flex justify-between items-center transition-all duration-300">
        <div class="text-2xl font-serif tracking-widest uppercase font-bold">Nustech</div>
        
        <!-- Mobile Menu Button -->
        <button id="mobile-btn" class="md:hidden text-white focus:outline-none">
            <i class="fa-solid fa-bars text-xl"></i>
        </button>

        <!-- Desktop Menu -->
        <div class="hidden md:flex space-x-8 text-sm font-light items-center">
            <a href="#" class="nav-link">Beranda</a>
            <a href="#tentang-kami" class="nav-link">Tentang Kami</a>
            <a href="#visi-misi" class="nav-link">Visi Misi</a>
            <a href="#layanan" class="nav-link">Layanan</a>
            <a href="#kontak" class="nav-link">Kontak</a>
            @auth
                <a href="{{ route('mydashboard') }}" class="ml-4 border border-white px-5 py-2 rounded-full hover:bg-white hover:text-black transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="ml-4 border border-white px-5 py-2 rounded-full hover:bg-white hover:text-black transition">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="fixed inset-0 bg-black/95 z-40 hidden flex-col items-center justify-center space-y-6 text-white text-lg transition-all duration-300 opacity-0">
        <button id="close-mobile-btn" class="absolute top-6 right-6 text-2xl focus:outline-none">
            <i class="fa-solid fa-times"></i>
        </button>
        <a href="#" class="hover:text-gray-300">Beranda</a>
        <a href="#tentang-kami" class="hover:text-gray-300">Tentang Kami</a>
        <a href="#visi-misi" class="hover:text-gray-300">Visi Misi</a>
        <a href="#layanan" class="hover:text-gray-300">Layanan</a>
        <a href="#kontak" class="hover:text-gray-300">Kontak</a>
        @auth
            <a href="{{ route('mydashboard') }}" class="border border-white px-6 py-2 rounded-full">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="border border-white px-6 py-2 rounded-full">Login</a>
        @endauth
    </div>

    <!-- Hero Section -->
    <section class="relative h-[100vh] flex items-center bg-[#111] overflow-hidden">
        <!-- Background Image -->
        <!-- User needs to place the satellite image at public/assets/img/hero-satellite.jpg -->
        <img src="{{ asset('assets/img/hero-satellite.jpg') }}" alt="Satellite Background" class="absolute inset-0 w-full h-full object-cover opacity-60">
        <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent"></div>
        
        <div class="relative z-10 px-6 md:px-32 w-full text-white">
            <div class="glass-box p-8 md:p-12 rounded-2xl max-w-xl md:max-w-2xl transform transition-transform hover:scale-[1.02] duration-500">
                <h1 class="text-4xl md:text-5xl lg:text-5xl font-serif font-bold leading-tight mb-4 tracking-wide">Solution For Your<br>Tech Problem</h1>
                <p class="text-sm md:text-base mb-8 text-gray-200 font-light leading-relaxed">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc vulputate libero et velit interdum, ac aliquam massa mattis. Donec pulvinar velit eu aliquet.</p>
                <a href="#tentang-kami" class="inline-flex items-center border border-white/50 px-6 py-2.5 rounded-full hover:bg-white hover:text-black transition duration-300 text-sm tracking-wide">
                    Explore <i class="fa-solid fa-arrow-right ml-3 text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Container for Patterned Background Sections -->
    <!-- User can place pattern image at public/assets/img/pattern-bg.png -->
    <div class="relative bg-white overflow-hidden" style="background-image: url('{{ asset('assets/img/pattern-bg.png') }}'); background-repeat: repeat; background-size: 300px;">
        <!-- Light overlay to soften the pattern -->
        <div class="absolute inset-0 bg-white/90"></div>

        <div class="relative z-10 w-full">
            
            <!-- Tentang Kami Section -->
            <section id="tentang-kami" class="py-20 px-6 md:px-12 max-w-7xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-primary-blue mb-8 text-center md:text-left drop-shadow-sm tracking-wide">Tentang Kami</h2>
                
                <div class="bg-primary-blue text-white rounded-2xl p-8 md:p-12 shadow-2xl max-w-4xl hover:shadow-primary-blue/30 transition duration-500">
                    <h3 class="text-2xl font-bold mb-4 tracking-wide">Jagonya Teknologi Informasi</h3>
                    <p class="mb-10 font-light leading-relaxed text-gray-100 text-sm md:text-base">
                        NUSTECH adalah perusahaan yang berbasis di Lombok, Nusa Tenggara Barat dan bergerak di bidang pengadaan barang dan jasa, khususnya dalam sektor teknologi informasi, kelistrikan, dan rekayasa teknik (engineering).
                    </p>
                    <a href="#" class="inline-block border border-white/70 px-6 py-2 rounded-full hover:bg-white hover:text-primary-blue transition duration-300 text-sm font-medium">
                        Lihat Selengkapnya
                    </a>
                </div>
                <!-- Line Decor -->
                <div class="w-[80%] md:w-1/2 h-1.5 bg-primary-blue mt-10 mx-auto md:ml-12 opacity-90 rounded-full"></div>
            </section>

            <!-- Visi & Misi Section -->
            <section id="visi-misi" class="pt-10 pb-20 px-6 md:px-12 max-w-7xl mx-auto">
                <div class="grid md:grid-cols-2 gap-8 relative items-start">
                    
                    <!-- Worker Image Overlay (Desktop) -->
                    <!-- User needs to place the worker image at public/assets/img/worker.png -->
                    <div class="absolute bottom-[-100px] left-1/2 transform -translate-x-1/2 z-20 pointer-events-none hidden lg:block" style="width: 550px;">
                        <img src="{{ asset('assets/img/worker.png') }}" alt="Nustech Worker" class="w-full drop-shadow-2xl filter drop-shadow-[0_20px_20px_rgba(0,0,0,0.3)]">
                    </div>

                    <!-- Visi Column -->
                    <div class="space-y-6 flex flex-col justify-end h-full relative z-10">
                        <div class="bg-primary-blue text-white rounded-xl p-5 shadow-lg text-center font-bold text-2xl tracking-widest shadow-primary-blue/20 max-w-md">
                            Visi & Misi
                        </div>
                        <div class="bg-primary-blue text-white rounded-xl p-8 shadow-xl relative flex-grow hover:shadow-primary-blue/20 transition duration-300 max-w-md">
                            <h3 class="text-3xl font-bold mb-4">Visi</h3>
                            <p class="font-light text-sm leading-relaxed text-gray-100 pb-20 lg:pb-0">
                                Menjadi perusahaan jasa pelaksanaan dan pusat sharing teknologi informasi, elektronik, pneumatika, didaktik, mekanik, dan side skill teknik yang profesional, memiliki daya saing tinggi, serta terpercaya di tingkat lokal maupun nasional.
                            </p>
                        </div>
                        <!-- Small box decorator matching the image -->
                        <div class="bg-primary-blue rounded-xl h-24 shadow-md z-10 relative hidden md:block w-[90%] -mt-16 -ml-4"></div>
                    </div>

                    <!-- Misi Column -->
                    <div class="bg-primary-blue text-white rounded-xl p-8 shadow-xl lg:mt-32 relative z-10 hover:shadow-primary-blue/20 transition duration-300 ml-auto max-w-md lg:max-w-full">
                        <h3 class="text-3xl font-bold mb-6">Misi</h3>
                        <ul class="text-sm font-light leading-relaxed space-y-4 list-disc pl-5 text-gray-100 marker:text-blue-300">
                            <li>Memperhatikan strategi pertumbuhan bisnis global, kehandalan, dan efisiensi dengan pertimbangan dampak lingkungan, kesehatan, serta keselamatan (K3) proyek.</li>
                            <li>Menjalin kerjasama yang saling menguntungkan dengan mitra usaha dan mitra kerja melalui pengaturan pengadaan barang dan jasa secara sinergis dan efisien.</li>
                            <li>Memberikan pelayanan yang maksimal, cepat, dan profesional kepada seluruh rekanan mitra.</li>
                            <li>Membawa kultur turunan yang optimis bagi masyarakat serta bernilai daya positif terhadap pelestarian lingkungan.</li>
                            <li>Menjunjung tinggi prinsip transparansi dan integritas dalam setiap proses bisnis sebagai fondasi tertama untuk adaptasi tren pasar yang pelanggan butuhkan.</li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Services Section -->
            <section id="layanan" class="py-20 px-6 md:px-12 w-full max-w-7xl mx-auto">
                <div class="flex flex-col items-center">
                    <div class="bg-primary-blue text-white text-center py-4 px-12 rounded-t-xl text-3xl font-bold w-full shadow-lg align-middle justify-center tracking-wide">
                        Services
                    </div>
                    
                    <!-- Services Tabs / Pills -->
                    <div class="w-full bg-white border-x border-b border-gray-200 rounded-b-xl shadow-lg pb-8 pt-6">
                        <div class="overflow-x-auto custom-scrollbar px-6 mb-6">
                            <div class="flex space-x-3 min-w-max py-2 justify-center">
                                <button class="border-2 border-primary-blue bg-primary-blue text-white px-6 py-2.5 rounded-lg font-medium text-sm transition shadow-md">Networking</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">Aplikasi</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">Server</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">CCTV & Alarm</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">Smart Building</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">Command Center</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">Sistem Audio</button>
                                <button class="border border-gray-300 text-gray-600 bg-white hover:border-primary-blue hover:text-primary-blue px-6 py-2.5 rounded-lg font-medium text-sm transition">PABX System</button>
                            </div>
                        </div>

                        <!-- Active Service Detail -->
                        <div class="px-6 md:px-10 pb-2">
                            <div class="bg-primary-blue text-white p-6 md:p-8 rounded-xl shadow-inner w-full">
                                <h4 class="font-bold text-xl mb-3">Instalasi & Maintenance Jaringan (Networking)</h4>
                                <p class="text-sm font-light text-gray-200 leading-relaxed md:w-3/4">Layanan ini meliputi instalasi jaringan LAN, WAN, Fiber Optic, serta maintenance jaringan harian untuk memastikan koneksi yang stabil dan aman bagi perusahaan Anda. Kami menggunakan peralatan standar industri terkini untuk menjamin reliabilitas operasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Contact & Footer -->
    <footer id="kontak" class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 py-12 grid md:grid-cols-3 gap-8 border-b border-gray-800">
            <div>
                <h3 class="text-2xl font-serif font-bold tracking-widest uppercase mb-4 text-primary-blue">Nustech</h3>
                <p class="text-sm text-gray-400 font-light leading-relaxed mb-4">
                    Solusi terpadu untuk kebutuhan teknologi informasi, kelistrikan, dan rekayasa teknik untuk mendukung operasional bisnis Anda.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Hubungi Kami</h4>
                <ul class="text-sm text-gray-400 font-light space-y-2">
                    <li><i class="fa-solid fa-map-marker-alt w-5 text-center mr-2 text-primary-blue"></i> Lombok, Nusa Tenggara Barat</li>
                    <li><i class="fa-solid fa-envelope w-5 text-center mr-2 text-primary-blue"></i> info@nustech.id</li>
                    <li><i class="fa-solid fa-phone w-5 text-center mr-2 text-primary-blue"></i> +62 812 3456 7890</li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Sosial Media</h4>
                <div class="flex space-x-4">
                    <a href="#" class="bg-white/10 hover:bg-primary-blue w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="bg-white/10 hover:bg-primary-blue w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#" class="bg-white/10 hover:bg-primary-blue w-10 h-10 rounded-full flex items-center justify-center transition"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </div>
        </div>
        <div class="text-center py-6 text-sm font-light text-gray-500">
            <p>&copy; {{ date('Y') }} Nustech Indonesia. All rights reserved.</p>
        </div>
    </footer>

    <!-- Custom Scrollbar Style for Service Tabs -->
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1; 
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #214b6b; 
        }
    </style>

    <script>
        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobile-btn');
        const closeMobileBtn = document.getElementById('close-mobile-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        function toggleMenu() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                // slight delay for animation
                setTimeout(() => {
                    mobileMenu.classList.remove('opacity-0');
                    mobileMenu.classList.add('opacity-100');
                }, 10);
            } else {
                mobileMenu.classList.remove('opacity-100');
                mobileMenu.classList.add('opacity-0');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }
        }

        mobileBtn.addEventListener('click', toggleMenu);
        closeMobileBtn.addEventListener('click', toggleMenu);
        
        // Close menu on link click
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', toggleMenu);
        });

        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('bg-black/90', 'backdrop-blur-md', 'shadow-md', 'py-4');
                nav.classList.remove('py-6');
            } else {
                nav.classList.add('py-6');
                nav.classList.remove('bg-black/90', 'backdrop-blur-md', 'shadow-md', 'py-4');
            }
        });
    </script>
</body>
</html>

