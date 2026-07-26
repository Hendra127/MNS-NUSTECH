<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimalist Company Profile</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: '#1E293B',     // Deep Charcoal / Slate
                        accent: '#10B981',      // Emerald Green
                        bgLight: '#F9FAFB',     // Soft light gray
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #F9FAFB; color: #1E293B; }
        .fade-in-section {
            opacity: 0;
            transform: translateY(20vh);
            visibility: hidden;
            transition: opacity 0.6s ease-out, transform 1.2s ease-out;
            will-change: opacity, visibility;
        }
        .fade-in-section.is-visible {
            opacity: 1;
            transform: none;
            visibility: visible;
        }
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <nav class="fixed w-full bg-white/90 backdrop-blur-md z-50 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold tracking-tighter text-primary">Brand<span class="text-accent">.</span></div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-500">
                <a href="#about" class="hover:text-primary transition">About</a>
                <a href="#services" class="hover:text-primary transition">Services</a>
                <a href="#portfolio" class="hover:text-primary transition">Work</a>
            </div>
            <a href="#contact" class="hidden md:inline-flex bg-primary text-white px-5 py-2 text-sm font-medium hover:bg-gray-800 transition rounded">Contact Us</a>
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-primary focus:outline-none" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
        </div>
        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-6 py-4 space-y-4 shadow-lg text-sm font-medium text-gray-500">
            <a href="#about" class="block hover:text-primary">About</a>
            <a href="#services" class="block hover:text-primary">Services</a>
            <a href="#portfolio" class="block hover:text-primary">Work</a>
            <a href="#contact" class="block text-primary font-bold">Contact Us</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-32 pb-24 md:pt-48 md:pb-32 px-6 max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-12">
        <div class="w-full md:w-1/2 animate__animated animate__fadeInLeft">
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-primary leading-tight mb-6">
                Clarity in <br> <span class="text-gray-400">Design & Tech.</span>
            </h1>
            <p class="text-lg text-gray-500 mb-10 max-w-md leading-relaxed">
                We craft minimalist, high-performance digital experiences that elevate your brand and drive meaningful results.
            </p>
            <div class="flex gap-4">
                <a href="#portfolio" class="bg-primary text-white px-8 py-3 font-medium hover:bg-gray-800 transition rounded">Our Work</a>
                <a href="#about" class="bg-white border border-gray-200 text-primary px-8 py-3 font-medium hover:border-gray-400 hover:bg-gray-50 transition rounded">Learn More</a>
            </div>
        </div>
        <div class="w-full md:w-1/2 animate__animated animate__fadeInRight">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1200" alt="Modern Office" class="rounded-lg shadow-2xl object-cover h-[500px] w-full">
        </div>
    </section>

    <!-- About Us / Core Values -->
    <section id="about" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in-section">
                <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">Our Core Pillars</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">The foundational values that guide our process and ensure we deliver excellence in every project.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Pillar 1 -->
                <div class="text-center fade-in-section">
                    <div class="w-16 h-16 mx-auto bg-bgLight rounded-full flex items-center justify-center mb-6 text-primary">
                        <i class="fa-solid fa-lightbulb text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Innovation</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">We constantly explore new boundaries to deliver modern, forward-thinking solutions.</p>
                </div>
                <!-- Pillar 2 -->
                <div class="text-center fade-in-section">
                    <div class="w-16 h-16 mx-auto bg-bgLight rounded-full flex items-center justify-center mb-6 text-primary">
                        <i class="fa-solid fa-gem text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Quality</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Craftsmanship matters. Every line of code and pixel is refined to perfection.</p>
                </div>
                <!-- Pillar 3 -->
                <div class="text-center fade-in-section">
                    <div class="w-16 h-16 mx-auto bg-bgLight rounded-full flex items-center justify-center mb-6 text-primary">
                        <i class="fa-solid fa-handshake text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Integrity</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Honest communication, transparent processes, and dependable partnerships.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="py-24 bg-bgLight">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 fade-in-section">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">What We Do</h2>
                    <p class="text-gray-500">Comprehensive services designed to scale your business in the digital era.</p>
                </div>
                <a href="#contact" class="hidden md:inline-flex text-accent font-medium hover:text-green-700 transition">Discuss a project &rarr;</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-white p-10 rounded-lg border border-gray-100 hover-lift fade-in-section">
                    <i class="fa-solid fa-pen-nib text-3xl text-gray-400 mb-6 block"></i>
                    <h3 class="text-xl font-bold mb-3">UI/UX Design</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Intuitive, minimalist, and user-centered design interfaces that look beautiful and function flawlessly.</p>
                    <a href="#" class="text-sm font-semibold text-primary hover:text-accent transition">Learn More</a>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-10 rounded-lg border border-gray-100 hover-lift fade-in-section">
                    <i class="fa-solid fa-code text-3xl text-gray-400 mb-6 block"></i>
                    <h3 class="text-xl font-bold mb-3">Web Development</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Robust, scalable, and secure web architectures built with the latest modern frameworks.</p>
                    <a href="#" class="text-sm font-semibold text-primary hover:text-accent transition">Learn More</a>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-10 rounded-lg border border-gray-100 hover-lift fade-in-section">
                    <i class="fa-solid fa-mobile-screen text-3xl text-gray-400 mb-6 block"></i>
                    <h3 class="text-xl font-bold mb-3">Mobile Apps</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-6">Cross-platform mobile applications that provide native-like experiences on iOS and Android.</p>
                    <a href="#" class="text-sm font-semibold text-primary hover:text-accent transition">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Gallery -->
    <section id="portfolio" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-3xl md:text-4xl font-bold text-primary mb-12 text-center fade-in-section">Selected Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Item 1 -->
                <div class="group overflow-hidden rounded-lg bg-gray-100 fade-in-section cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800" alt="Project 1" class="w-full h-80 object-cover transition duration-500 group-hover:scale-105">
                    <div class="p-6 bg-white border border-t-0 border-gray-100">
                        <h4 class="font-bold text-lg mb-1">Fintech Dashboard</h4>
                        <p class="text-sm text-gray-500">UI/UX & Web Dev</p>
                    </div>
                </div>
                <!-- Item 2 -->
                <div class="group overflow-hidden rounded-lg bg-gray-100 fade-in-section cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1555421689-d68471e189f2?auto=format&fit=crop&q=80&w=800" alt="Project 2" class="w-full h-80 object-cover transition duration-500 group-hover:scale-105">
                    <div class="p-6 bg-white border border-t-0 border-gray-100">
                        <h4 class="font-bold text-lg mb-1">Tech Workspace App</h4>
                        <p class="text-sm text-gray-500">Mobile Development</p>
                    </div>
                </div>
                <!-- Item 3 -->
                <div class="group overflow-hidden rounded-lg bg-gray-100 fade-in-section cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1522542550221-31fd19575a2d?auto=format&fit=crop&q=80&w=800" alt="Project 3" class="w-full h-80 object-cover transition duration-500 group-hover:scale-105">
                    <div class="p-6 bg-white border border-t-0 border-gray-100">
                        <h4 class="font-bold text-lg mb-1">E-Commerce Redesign</h4>
                        <p class="text-sm text-gray-500">Digital Strategy</p>
                    </div>
                </div>
                <!-- Item 4 -->
                <div class="group overflow-hidden rounded-lg bg-gray-100 fade-in-section cursor-pointer">
                    <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800" alt="Project 4" class="w-full h-80 object-cover transition duration-500 group-hover:scale-105">
                    <div class="p-6 bg-white border border-t-0 border-gray-100">
                        <h4 class="font-bold text-lg mb-1">Corporate Branding</h4>
                        <p class="text-sm text-gray-500">Identity & Design</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-12 fade-in-section">
                <a href="#" class="inline-flex border-b-2 border-primary pb-1 text-primary font-medium hover:text-gray-500 hover:border-gray-500 transition">View Full Archive</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-primary text-white pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <div class="md:col-span-2">
                    <div class="text-2xl font-bold tracking-tighter mb-6">Brand<span class="text-accent">.</span></div>
                    <p class="text-gray-400 max-w-sm mb-6">Elevating brands through clean design and intelligent engineering.</p>
                    <a href="mailto:hello@brand.com" class="text-xl font-semibold border-b border-gray-600 hover:border-white transition">hello@brand.com</a>
                </div>
                <div>
                    <h5 class="font-bold mb-4 uppercase tracking-widest text-xs text-gray-400">Navigation</h5>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#services" class="hover:text-white transition">Services</a></li>
                        <li><a href="#portfolio" class="hover:text-white transition">Our Work</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="font-bold mb-4 uppercase tracking-widest text-xs text-gray-400">Social</h5>
                    <ul class="space-y-3 text-sm text-gray-300">
                        <li><a href="#" class="hover:text-white transition">LinkedIn</a></li>
                        <li><a href="#" class="hover:text-white transition">Twitter</a></li>
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-xs text-gray-500">
                <p>&copy; 2026 Brand Inc. All rights reserved.</p>
                <div class="space-x-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Animation Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };
            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.fade-in-section').forEach((section) => {
                observer.observe(section);
            });
        });
    </script>

</body>
</html>
