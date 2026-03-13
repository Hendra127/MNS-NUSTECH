<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Project Operational</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-navy: #0f3b56;
            --accent-blue: #3498db;
            --soft-bg: #f2f5f8;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --premium-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .profile-wrapper {
            max-width: 900px;
            margin: 60px auto;
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 30px;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Left Side: Visual Profile Card */
        .visual-card {
            background: var(--primary-navy);
            color: white;
            border-radius: 24px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(15, 59, 86, 0.25);
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        .visual-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .visual-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        .avatar-container {
            position: relative;
            margin-bottom: 25px;
            z-index: 2;
        }
        .profile-photo-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .profile-photo-preview:hover {
            border-color: #fff;
            transform: scale(1.03);
        }
        .camera-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: #fff;
            color: var(--primary-navy);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 10;
        }
        .camera-badge:hover {
            background: var(--primary-navy);
            color: white;
            transform: scale(1.1);
        }
        /* Photo Viewer Overlay */
        .photo-viewer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 59, 86, 0.85);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .photo-viewer-overlay.active {
            display: flex;
            opacity: 1;
        }
        .viewer-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            transform: scale(0.85);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .photo-viewer-overlay.active .viewer-content {
            transform: scale(1);
        }
        .viewer-image {
            max-width: 100%;
            max-height: 85vh;
            border-radius: 15px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            border: 5px solid rgba(255,255,255,0.1);
        }
        .close-viewer {
            position: absolute;
            top: -50px;
            right: 0;
            color: white;
            font-size: 2.5rem;
            cursor: pointer;
            transition: color 0.2s;
        }
        .close-viewer:hover {
            color: #ff4d4d;
        }
        .user-info-text {
            z-index: 2;
        }
        .user-info-text h4 {
            margin: 0;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .user-info-text p {
            opacity: 0.8;
            font-size: 0.95rem;
            margin-top: 5px;
        }
        /* Right Side: Form Card */
        .settings-card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            padding: 40px;
            box-shadow: var(--premium-shadow);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .settings-card h3 {
            color: var(--primary-navy);
            font-weight: 800;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .settings-card h3 i {
            font-size: 1.8rem;
        }
        .form-group-modern {
            margin-bottom: 24px;
        }
        .form-group-modern label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #55606e;
            font-size: 0.9rem;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #8a9aaa;
            transition: all 0.3s;
        }
        .form-control-modern {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border-radius: 12px;
            border: 1px solid #e1e8ef;
            background: #fdfdfd;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        .form-control-modern:focus {
            border-color: var(--primary-navy);
            box-shadow: 0 0 0 4px rgba(15, 59, 86, 0.08);
            outline: none;
            background: #fff;
        }
        .form-control-modern:focus + i {
            color: var(--primary-navy);
        }
        .btn-premium {
            background: var(--primary-navy);
            color: white;
            border: none;
            padding: 14px 30px;
            border-radius: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 20px rgba(15, 59, 86, 0.2);
            width: 100%;
            margin-top: 10px;
        }
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(15, 59, 86, 0.3);
            background: #154b6c;
        }
        .btn-premium:active {
            transform: translateY(1px);
        }
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #8a9aaa;
            text-decoration: none;
            font-size: 0.9rem;
            margin-bottom: 30px;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: var(--primary-navy);
        }
        @media (max-width: 991px) {
            .profile-wrapper {
                grid-template-columns: 1fr;
                margin: 40px 20px;
            }
            .visual-card {
                padding: 30px;
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
                        <button type="submit" style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="profile-wrapper">
            <!-- LEFT: Profile Preview -->
            <div class="visual-card">
                <div class="avatar-container">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" 
                             alt="Profile Photo" 
                             class="profile-photo-preview" 
                             id="photoPreview" 
                             onclick="openPhotoViewer(this.src)">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random&size=200" alt="Default Avatar" class="profile-photo-preview" id="photoPreview" onclick="openPhotoViewer(this.src)">
                    @endif
                    <div class="camera-badge" onclick="document.getElementById('photoInput').click()">
                        <i class="bi bi-camera"></i>
                    </div>
                </div>
                <div class="user-info-text">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>{{ auth()->user()->email }}</p>
                    <div class="mt-4 pt-3 border-top border-light border-opacity-10">
                        <span class="badge rounded-pill bg-light text-dark px-3 py-2 opacity-75">
                            <i class="bi bi-shield-check me-1"></i> Account Verified
                        </span>
                    </div>
                </div>
            </div>
            <!-- RIGHT: Management Form -->
            <div class="settings-card">
                <a href="{{ route('datasite') }}" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h3><i class="bi bi-gear-wide-connected"></i> Pengaturan Profil</h3>
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-4 mb-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="file" name="photo" id="photoInput" style="display: none;" accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                    <div class="form-group-modern">
                        <label>Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" class="form-control-modern" value="{{ old('name', auth()->user()->name) }}" required placeholder="Masukkan nama lengkap">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group-modern">
                        <label>Alamat Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" class="form-control-modern" value="{{ old('email', auth()->user()->email) }}" required placeholder="Masukkan email aktif">
                            <i class="bi bi-envelope"></i>
                        </div>
                    </div>
                    <hr class="my-4 opacity-10">
                    <div class="form-group-modern">
                        <label>Password Baru <span class="fw-normal text-muted">(Opsional)</span></label>
                        <div class="input-wrapper">
                            <input type="password" name="password" class="form-control-modern" placeholder="••••••••">
                            <i class="bi bi-lock"></i>
                        </div>
                    </div>
                    <div class="form-group-modern mb-5">
                        <label>Konfirmasi Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" name="password_confirmation" class="form-control-modern" placeholder="••••••••">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-premium">
                        <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Photo Viewer Modal -->
    <div id="photoViewerModal" class="photo-viewer-overlay" onclick="closePhotoViewer()">
        <div class="viewer-content" onclick="event.stopPropagation()">
            <span class="close-viewer" onclick="closePhotoViewer()">&times;</span>
            <img src="" id="fullPhoto" class="viewer-image">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openPhotoViewer(src) {
            const modal = document.getElementById('photoViewerModal');
            const fullImg = document.getElementById('fullPhoto');
            fullImg.src = src;
            modal.style.display = 'flex';
            setTimeout(() => modal.classList.add('active'), 10);
            document.body.style.overflow = 'hidden'; // Stop scrolling
        }
        function closePhotoViewer() {
            const modal = document.getElementById('photoViewerModal');
            modal.classList.remove('active');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto'; // Re-enable scrolling
            }, 300);
        }
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 10 * 1024 * 1024; // 10MB in bytes
                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran foto maksimal adalah 10MB.',
                        background: '#fff',
                        color: '#0f3b56',
                        confirmButtonColor: '#0f3b56',
                        customClass: {
                            popup: 'rounded-5'
                        }
                    });
                    input.value = ""; // Clear input
                    return;
                }
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photoPreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        @if(session('success'))
            Swal.fire({ 
                icon: 'success', 
                title: 'Profil Diperbarui!', 
                text: "{{ session('success') }}", 
                background: '#fff',
                color: '#0f3b56',
                iconColor: '#0f3b56',
                confirmButtonColor: '#0f3b56',
                customClass: {
                    popup: 'rounded-5',
                    confirmButton: 'rounded-4 px-5'
                }
            });
        @endif
    </script>
</body>
</html>

