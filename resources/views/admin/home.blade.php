<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page Manager | Admin NUSTECH</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;850&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a80d750fb5.js" crossorigin="anonymous"></script>
    <!-- Tailwind CSS (Direct from CDN for the admin page to ensure instant beautiful styling) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0284c7',
                            600: '#0284c7',
                            700: '#0369a1',
                            900: '#0c4a6e',
                            950: '#082f49',
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans text-slate-800">

    <!-- Top Navigation -->
    <header class="bg-brand-950 text-white sticky top-0 z-40 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Left: Logo -->
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/img/logonustech.png') }}" alt="Nustech Logo" class="h-10 w-10 rounded-full border-2 border-white/20">
                    <div>
                        <h1 class="text-lg font-extrabold tracking-tight">NUSTECH</h1>
                        <p class="text-[10px] text-sky-300 font-medium">Landing Page Manager</p>
                    </div>
                </div>

                <!-- Right: Quick actions -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('home') }}" target="_blank" class="bg-white/10 hover:bg-white/20 text-white px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2">
                        <i class="fa-solid fa-earth-asia"></i> Lihat Web Utama
                    </a>
                    <a href="{{ route('mydashboard') }}" class="bg-sky-600 hover:bg-sky-700 text-white px-4 py-2 rounded-xl text-xs font-semibold transition flex items-center gap-2 shadow-lg shadow-sky-900/30">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Alerts -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3 animate-fade-in">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-emerald-900 text-sm">Berhasil!</h4>
                    <p class="text-emerald-700 text-xs mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg mt-0.5"></i>
                <div>
                    <h4 class="font-bold text-rose-900 text-sm">Gagal Menyimpan Data</h4>
                    <ul class="list-disc list-inside text-rose-700 text-xs mt-1 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Banner Header -->
        <div class="bg-gradient-to-r from-brand-900 via-brand-950 to-sky-900 rounded-3xl p-8 md:p-10 text-white shadow-xl mb-10 relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/5 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-64 h-64 bg-sky-500/10 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 bg-white/10 px-3 py-1.5 rounded-full text-xs font-semibold text-sky-200 mb-4 border border-white/10">
                    <i class="fa-solid fa-sliders"></i> Panel Administrasi Landing Page
                </div>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Kelola Konten Landing Page</h2>
                <p class="text-sky-100/80 text-sm mt-3 leading-relaxed">
                    Ubah portofolio, dokumentasi pengalaman kerja, serta kabar berita terbaru yang terintegrasi dengan tautan postingan Instagram Anda.
                </p>
            </div>
        </div>

        <!-- Tab Navigations -->
        <div class="flex border-b border-slate-200 mb-8 bg-white p-2 rounded-2xl shadow-sm gap-2">
            <button onclick="switchTab('tab-portfolio')" id="btn-tab-portfolio" class="tab-btn flex-1 py-3 px-4 rounded-xl text-sm font-bold text-brand-600 bg-brand-50 transition duration-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-images text-base"></i> Portofolio / Pengalaman Kerja
            </button>
            <button onclick="switchTab('tab-news')" id="btn-tab-news" class="tab-btn flex-1 py-3 px-4 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition duration-200 flex items-center justify-center gap-2">
                <i class="fa-brands fa-instagram text-base"></i> Kabar Instagram (News)
            </button>
        </div>

        <!-- TAB CONTENT: PORTFOLIO -->
        <div id="tab-portfolio" class="tab-pane block">
            <!-- Section Title & Add Button -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800">Portofolio Kerja</h3>
                    <p class="text-slate-400 text-xs mt-1">Daftar dokumentasi portofolio yang terdisplay di halaman utama.</p>
                </div>
                <button onclick="openModal('modal-add-portfolio')" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-brand-500/20">
                    <i class="fa-solid fa-plus text-sm"></i> Tambah Portofolio
                </button>
            </div>

            <!-- Portfolio Grid -->
            @if($portfolios->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <i class="fa-solid fa-image-portrait text-slate-400 text-2xl"></i>
                    </div>
                    <h4 class="text-slate-700 font-bold text-base">Belum Ada Portofolio</h4>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto mt-2">Daftar portofolio masih kosong. Tambahkan portofolio baru untuk mendominasi tampilan pengalaman kerja landing page.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($portfolios as $p)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-all duration-300">
                            <!-- Image container -->
                            <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                <img src="{{ asset('storage/' . $p->image_path) }}" alt="{{ $p->title }}" class="w-full h-full object-cover">
                                <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase tracking-wider">
                                    {{ $p->category ?? 'Umum' }}
                                </div>
                            </div>
                            
                            <!-- Body -->
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-base line-clamp-1">{{ $p->title }}</h4>
                                    <p class="text-slate-500 text-xs mt-2 line-clamp-2 leading-relaxed">{{ $p->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>

                                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-slate-50">
                                    <button onclick="openEditPortfolioModal({{ $p->id }}, '{{ addslashes($p->title) }}', '{{ addslashes($p->category) }}', '{{ addslashes($p->description) }}')" class="flex-1 bg-slate-50 hover:bg-brand-50 hover:text-brand-600 text-slate-600 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-100">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.home.portfolio.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus portofolio ini?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-slate-50 hover:bg-rose-50 hover:text-rose-600 text-slate-500 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-100">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- TAB CONTENT: NEWS -->
        <div id="tab-news" class="tab-pane hidden">
            <!-- Section Title & Add Button -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-extrabold text-slate-800">Kabar Berita Instagram</h3>
                    <p class="text-slate-400 text-xs mt-1">Kelola link dan postingan Instagram yang tampil pada News Page di halaman depan.</p>
                </div>
                <button onclick="openModal('modal-add-news')" class="bg-brand-600 hover:bg-brand-700 text-white px-5 py-2.5 rounded-xl text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-brand-500/20">
                    <i class="fa-solid fa-plus text-sm"></i> Tambah Kabar Instagram
                </button>
            </div>

            <!-- News Grid -->
            @if($news->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-100 shadow-sm">
                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                        <i class="fa-brands fa-instagram text-slate-400 text-2xl"></i>
                    </div>
                    <h4 class="text-slate-700 font-bold text-base">Belum Ada Kabar Berita</h4>
                    <p class="text-slate-400 text-xs max-w-sm mx-auto mt-2">Kabar berita instagram masih kosong. Tambahkan link postingan Instagram agar landing page terhubung dinamis!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $n)
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition-all duration-300">
                            <!-- Image Container -->
                            <div class="relative h-48 w-full bg-slate-100 overflow-hidden">
                                @if($n->image_path)
                                    <img src="{{ asset('storage/' . $n->image_path) }}" alt="{{ $n->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-brand-900 to-sky-600 flex items-center justify-center text-white">
                                        <i class="fa-brands fa-instagram text-5xl opacity-30"></i>
                                    </div>
                                @endif
                                <div class="absolute bottom-3 right-3 bg-brand-600/90 text-white text-[10px] font-bold px-2.5 py-1 rounded-md flex items-center gap-1">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    {{ $n->published_at ? $n->published_at->format('d M Y') : '-' }}
                                </div>
                            </div>
                            
                            <!-- Body -->
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <h4 class="font-bold text-slate-800 text-base line-clamp-1">{{ $n->title }}</h4>
                                    <p class="text-slate-500 text-xs mt-2 line-clamp-3 leading-relaxed">{{ $n->caption ?? 'Tidak ada caption.' }}</p>
                                    @if($n->instagram_url)
                                        <a href="{{ $n->instagram_url }}" target="_blank" class="inline-flex items-center gap-1.5 text-sky-600 hover:text-sky-700 text-xs font-bold mt-4 transition">
                                            <i class="fa-brands fa-instagram"></i> Buka Link Instagram <i class="fa-solid fa-up-right-from-square text-[9px]"></i>
                                        </a>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 mt-6 pt-4 border-t border-slate-50">
                                    <button onclick="openEditNewsModal({{ $n->id }}, '{{ addslashes($n->title) }}', '{{ addslashes($n->instagram_url) }}', '{{ addslashes($n->caption) }}', '{{ $n->published_at ? $n->published_at->format('Y-m-d') : '' }}')" class="flex-1 bg-slate-50 hover:bg-brand-50 hover:text-brand-600 text-slate-600 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-100">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <form action="{{ route('admin.home.news.destroy', $n->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan berita ini?');" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-slate-50 hover:bg-rose-50 hover:text-rose-600 text-slate-500 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 border border-slate-100">
                                            <i class="fa-solid fa-trash-can"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>

    <!-- MODAL: ADD PORTFOLIO -->
    <div id="modal-add-portfolio" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-100 animate-scale-up">
            <div class="bg-brand-950 text-white px-6 py-4 flex items-center justify-between">
                <h4 class="font-extrabold text-sm tracking-wide uppercase"><i class="fa-solid fa-images mr-1"></i> Tambah Portofolio Kerja</h4>
                <button onclick="closeModal('modal-add-portfolio')" class="text-white hover:text-slate-200 text-2xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.home.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Proyek / Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Pemasangan Fiber Optic Kantor Bupati" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Kategori Bidang</label>
                    <input type="text" name="category" placeholder="Contoh: Fiber Optic, Tower, VSAT, IT Support" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan mengenai proyek atau pekerjaan ini..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Foto Portofolio <span class="text-rose-500">*</span></label>
                    <input type="file" name="image" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal: 5MB</p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modal-add-portfolio')" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-brand-500/20">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT PORTFOLIO -->
    <div id="modal-edit-portfolio" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-100 animate-scale-up">
            <div class="bg-brand-950 text-white px-6 py-4 flex items-center justify-between">
                <h4 class="font-extrabold text-sm tracking-wide uppercase"><i class="fa-solid fa-pen-to-square mr-1"></i> Edit Portofolio Kerja</h4>
                <button onclick="closeModal('modal-edit-portfolio')" class="text-white hover:text-slate-200 text-2xl leading-none">&times;</button>
            </div>
            <form id="form-edit-portfolio" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Proyek / Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit-portfolio-title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Kategori Bidang</label>
                    <input type="text" name="category" id="edit-portfolio-category" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" id="edit-portfolio-description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Ganti Foto Portofolio <span class="text-slate-400 font-normal">(Kosongkan jika tidak ingin merubah)</span></label>
                    <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP. Maksimal: 5MB</p>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modal-edit-portfolio')" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-brand-500/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: ADD NEWS -->
    <div id="modal-add-news" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-100 animate-scale-up">
            <div class="bg-brand-950 text-white px-6 py-4 flex items-center justify-between">
                <h4 class="font-extrabold text-sm tracking-wide uppercase"><i class="fa-brands fa-instagram mr-1"></i> Tambah Kabar Instagram</h4>
                <button onclick="closeModal('modal-add-news')" class="text-white hover:text-slate-200 text-2xl leading-none">&times;</button>
            </div>
            <form action="{{ route('admin.home.news.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Kabar / Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" required placeholder="Contoh: Kegiatan CSR Nuotech Peduli Lingkungan" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tautan Postingan Instagram (URL) <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <input type="url" name="instagram_url" placeholder="Contoh: https://www.instagram.com/p/C..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Caption Postingan</label>
                    <textarea name="caption" rows="3" placeholder="Tulis deskripsi atau caption postingan..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Upload Cover Berita</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modal-add-news')" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-brand-500/20">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT NEWS -->
    <div id="modal-edit-news" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-xl w-full max-w-lg overflow-hidden border border-slate-100 animate-scale-up">
            <div class="bg-brand-950 text-white px-6 py-4 flex items-center justify-between">
                <h4 class="font-extrabold text-sm tracking-wide uppercase"><i class="fa-solid fa-pen-to-square mr-1"></i> Edit Kabar Instagram</h4>
                <button onclick="closeModal('modal-edit-news')" class="text-white hover:text-slate-200 text-2xl leading-none">&times;</button>
            </div>
            <form id="form-edit-news" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Judul Kabar / Berita <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit-news-title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tautan Postingan Instagram (URL)</label>
                    <input type="url" name="instagram_url" id="edit-news-url" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Caption Postingan</label>
                    <textarea name="caption" id="edit-news-caption" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Tanggal Publikasi</label>
                        <input type="date" name="published_at" id="edit-news-date" class="w-full px-4 py-2 rounded-xl border border-slate-200 text-sm focus:border-brand-500 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 uppercase mb-1.5">Ganti Cover Berita <span class="text-[9px] text-slate-400">(Opsional)</span></label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer mt-1">
                    </div>
                </div>
                <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeModal('modal-edit-news')" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-2.5 rounded-xl text-xs font-bold transition">Batal</button>
                    <button type="submit" class="flex-1 bg-brand-600 hover:bg-brand-700 text-white py-2.5 rounded-xl text-xs font-bold transition shadow-lg shadow-brand-500/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab & Modal Logic Scripts -->
    <script>
        function switchTab(tabId) {
            // Hide all tabs content
            document.querySelectorAll('.tab-pane').forEach(el => {
                el.classList.add('hidden');
                el.classList.remove('block');
            });
            // Show current tab content
            const activeTab = document.getElementById(tabId);
            activeTab.classList.remove('hidden');
            activeTab.classList.add('block');

            // Reset tab button styles
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.className = "tab-btn flex-1 py-3 px-4 rounded-xl text-sm font-semibold text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition duration-200 flex items-center justify-center gap-2";
            });

            // Set current button active
            const activeBtn = document.getElementById('btn-' + tabId);
            activeBtn.className = "tab-btn flex-1 py-3 px-4 rounded-xl text-sm font-bold text-brand-600 bg-brand-50 transition duration-200 flex items-center justify-center gap-2";

            // Save tab state
            localStorage.setItem('active_landing_tab', tabId);
        }

        // Keep active tab on reload
        window.addEventListener('DOMContentLoaded', () => {
            const activeTab = localStorage.getItem('active_landing_tab');
            if (activeTab && document.getElementById(activeTab)) {
                switchTab(activeTab);
            }
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openEditPortfolioModal(id, title, category, description) {
            document.getElementById('edit-portfolio-title').value = title;
            document.getElementById('edit-portfolio-category').value = category;
            document.getElementById('edit-portfolio-description').value = description;
            
            // Set dynamic action route
            const form = document.getElementById('form-edit-portfolio');
            form.action = `/admin/home/portfolio/${id}`;
            
            openModal('modal-edit-portfolio');
        }

        function openEditNewsModal(id, title, url, caption, date) {
            document.getElementById('edit-news-title').value = title;
            document.getElementById('edit-news-url').value = url;
            document.getElementById('edit-news-caption').value = caption;
            document.getElementById('edit-news-date').value = date;
            
            // Set dynamic action route
            const form = document.getElementById('form-edit-news');
            form.action = `/admin/home/news/${id}`;
            
            openModal('modal-edit-news');
        }
    </script>
</body>
</html>
