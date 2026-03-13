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
    <title>Setting | Project Operational</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-navy: #0f3b56;
            --accent-blue: #3498db;
            --accent-purple: #8e44ad;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --premium-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            --transition-smooth: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        body {
            background: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(52, 152, 219, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(142, 68, 173, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(15, 59, 86, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, rgba(52, 152, 219, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Outfit', 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }
        /* Ambient background shapes */
        .ambient-shape {
            position: fixed;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s infinite alternate ease-in-out;
        }
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(100px, 50px) rotate(15deg); }
        }
        .setting-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 30px 60px;
        }
        /* Stats Section */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
            perspective: 1000px;
        }
        .stat-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-radius: 24px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: var(--premium-shadow);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            gap: 20px;
            animation: revealUp 0.6s cubic-bezier(0.23, 1, 0.32, 1) backwards;
        }
        .stat-card:hover {
            transform: translateY(-10px) rotateX(5deg);
            /* Modal Premium Redesign */
        .modal-content-premium {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(40px) saturate(200%);
            -webkit-backdrop-filter: blur(40px) saturate(200%);
            border-radius: 35px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalFadeIn 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.9) translateY(30px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-header-premium {
            background: linear-gradient(135deg, var(--primary-navy), var(--accent-blue));
            border: none;
            padding: 25px 35px;
            color: white;
            position: relative;
        }
        .modal-header-premium::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
        }
        .form-control-premium {
            border-radius: 18px;
            padding: 14px 22px;
            border: 2px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.5);
            transition: var(--transition-smooth);
            font-weight: 500;
            color: var(--primary-navy);
        }
        .form-control-premium:focus {
            background: white;
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 6px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        .btn-add-premium {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            color: white;
            border: none;
            padding: 16px 35px;
            border-radius: 18px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 25px rgba(52, 152, 219, 0.3);
            transition: var(--transition-smooth);
        }
        .btn-add-premium:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 35px rgba(52, 152, 219, 0.4);
            color: white;
        }
        .modal-body-premium {
            position: relative;
            z-index: 1;
        }
        .modal-body-premium::before {
            content: "\F4CB"; /* bi-person-fill */
            font-family: "bootstrap-icons";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 15rem;
            opacity: 0.03;
            z-index: -1;
            pointer-events: none;
        }
            background: rgba(255, 255, 255, 0.9);
            border-color: var(--accent-blue);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-info h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .stat-info div {
            font-size: 1.75rem;
            font-weight: 850;
            color: var(--primary-navy);
            line-height: 1;
        }
        .user-table {
            border-collapse: separate;
            border-spacing: 0 15px;
            width: 100%;
            border: none;
        }
        .user-table thead th {
            border: none;
            color: #64748b;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            padding: 15px 25px;
            background: rgba(15, 59, 86, 0.03);
        }
        .user-table thead th:first-child { border-radius: 12px 0 0 12px; }
        .user-table thead th:last-child { border-radius: 0 12px 12px 0; }
        /* Table Design */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(25px) saturate(190%);
            -webkit-backdrop-filter: blur(25px) saturate(190%);
            border-radius: 32px;
            padding: 35px;
            box-shadow: var(--premium-shadow);
            border: 1px solid rgba(255, 255, 255, 0.6);
            animation: revealUp 0.8s cubic-bezier(0.23, 1, 0.32, 1) 0.2s backwards;
        }
        .user-row {
            transition: var(--transition-smooth);
            background: rgba(255, 255, 255, 0.4);
            border: none !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .user-row td {
            padding: 24px 25px;
            border: none !important;
            vertical-align: middle;
            background: transparent;
        }
        .user-row td:first-child { border-radius: 20px 0 0 20px; }
        .user-row td:last-child { border-radius: 0 20px 20px 0; }
        .user-row:hover {
            background: white !important;
            transform: scale(1.015) translateY(-2px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            z-index: 5;
            position: relative;
        }
        .user-avatar-premium {
            width: 64px;
            height: 64px;
            border-radius: 20px;
            padding: 3px;
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            box-shadow: 0 8px 16px rgba(52, 152, 219, 0.2);
            flex-shrink: 0;
        }
        .user-avatar-premium img, .user-avatar-premium .placeholder {
            width: 100%;
            height: 100%;
            border-radius: 13px;
            object-fit: cover;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .role-pill {
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 0.7rem;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid transparent;
        }
        .role-superadmin { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
        .role-admin { background: #e0f2fe; color: #075985; border-color: #7dd3fc; }
        .role-user { background: #f1f5f9; color: #475569; border-color: #cbd5e1; }
        .btn-action-premium {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .btn-edit { background: #f0f9ff; color: #0369a1; }
        .btn-edit:hover { background: #0369a1; color: white; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(3, 105, 161, 0.2); }
        .btn-delete { background: #fff1f2; color: #9f1239; }
        .btn-delete:hover { background: #9f1239; color: white; transform: translateY(-3px); box-shadow: 0 8px 15px rgba(159, 18, 57, 0.2); }
        /* Luxury Buttons */
        .btn-luxury {
            background: linear-gradient(135deg, var(--primary-navy), #1a5c85);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 16px;
            font-weight: 700;
            box-shadow: 0 10px 20px rgba(15, 59, 86, 0.2);
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn-luxury:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(15, 59, 86, 0.3);
            color: white;
        }
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
        .stagger-4 { animation-delay: 0.4s; }
        .text-navy { color: var(--primary-navy); }
        .bg-blue-soft { background: #e0f2fe; color: #0369a1; }
        .bg-purple-soft { background: #f5f3ff; color: #6d28d9; }
        .bg-green-soft { background: #f0fdf4; color: #15803d; }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
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
            @if(auth()->user()->role === 'superadmin')
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                    @if(auth()->user()->photo)
                        <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                    @else
                        <i class="bi bi-person-circle" style="font-size: 1.5rem; color: white;"></i>
                    @endif
                </div>
                <div id="profileDropdownMenu" class="hidden" style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                    <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                        {{ auth()->user()->name }}
                    </div>
                    <a href="{{ route('profile.edit') }}" style="padding: 10px 15px; text-decoration: none; color: #333; font-size: 14px; display: flex; align-items: center;">
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
    <div class="ambient-shape" style="width: 400px; height: 400px; background: var(--accent-blue); top: -100px; left: -100px;"></div>
    <div class="ambient-shape" style="width: 300px; height: 300px; background: var(--accent-purple); bottom: -50px; right: -50px; animation-delay: -5s;"></div>
    <div class="setting-container">
        <!-- STATS GRID -->
        <div class="stats-grid">
            <div class="stat-card stagger-1">
                <div class="stat-icon bg-blue-soft"><i class="bi bi-people"></i></div>
                <div class="stat-info">
                    <h4>Total Users</h4>
                    <div>{{ $stats['total'] }}</div>
                </div>
            </div>
            <div class="stat-card stagger-2">
                <div class="stat-icon bg-purple-soft"><i class="bi bi-shield-lock"></i></div>
                <div class="stat-info">
                    <h4>Admin / Super</h4>
                    <div>{{ $stats['admin'] + $stats['superadmin'] }}</div>
                </div>
            </div>
            <div class="stat-card stagger-3">
                <div class="stat-icon bg-green-soft"><i class="bi bi-person-check"></i></div>
                <div class="stat-info">
                    <h4>Standard Users</h4>
                    <div>{{ $stats['user'] }}</div>
                </div>
            </div>
            <div class="stat-card stagger-4">
                <div class="stat-icon" style="background: #fff7ed; color: #c2410c;"><i class="bi bi-broadcast"></i></div>
                <div class="stat-info">
                    <h4>Online Users</h4>
                    <div style="color: #c2410c;">{{ $stats['online'] }}</div>
                </div>
            </div>
        </div>
        <!-- USER MANAGEMENT TABLE -->
        <div class="glass-card">
            <div class="section-header d-flex justify-content-between align-items-center">
                <h3 class="section-title m-0">
                    <span class="d-none d-sm-inline-block"><i class="bi bi-ui-checks"></i> Manajemen User</span>
                    <span class="d-sm-none">Users</span>
                </h3>
                <button class="btn-luxury" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-plus-lg"></i> Tambah User Baru
                </button>
            </div>
            <div class="table-responsive">
                <table class="table user-table">
                    <thead>
                        <tr>
                            <th>Identitas User</th>
                            <th>Role / Akses</th>
                            <th>Kontak Email</th>
                            <th class="text-end">Kelola</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="user-row">
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar-premium">
                                        @if($user->photo)
                                            <img src="{{ Storage::url($user->photo) }}">
                                        @else
                                            <div class="placeholder"><i class="bi bi-person text-navy"></i></div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-navy mb-1" style="font-size: 1.15rem; letter-spacing: -0.02em;">{{ $user->name }}</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="badge bg-light text-dark border fw-normal px-2 py-1" style="font-size: 0.7rem; border-radius: 6px;">
                                                <span class="opacity-50">UID:</span> #{{ 1000 + $user->id }}
                                            </div>
                                            @if($user->is_online)
                                                <span class="badge bg-success-subtle text-success border border-success-subtle fw-bold px-2 py-1" style="font-size: 0.65rem; border-radius: 6px;">
                                                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> ONLINE
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fw-bold px-2 py-1" style="font-size: 0.65rem; border-radius: 6px;">
                                                    OFFLINE
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="role-pill role-{{ $user->role }}">
                                    <i class="bi bi-patch-check-fill me-1"></i> {{ $user->role }}
                                </span>
                            </td>
                            <td>
                                <div class="text-navy fw-semibold opacity-75">{{ $user->email }}</div>
                                @if($user->is_online)
                                    <div class="text-success small fw-bold"><i class="bi bi-activity me-1"></i> Sedang Aktif</div>
                                @elseif($user->last_seen_at)
                                    <div class="text-muted small"><i class="bi bi-eye me-1"></i> Terakhir terlihat {{ $user->last_seen_at->diffForHumans() }}</div>
                                @else
                                    <div class="text-muted small"><i class="bi bi-clock me-1"></i> Bergabung {{ $user->created_at->diffForHumans() }}</div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <button class="btn-action-premium btn-edit" onclick="editUser({{ $user }})">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('setting.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action-premium btn-delete">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- ADD USER MODAL -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title fw-extrabold"><i class="bi bi-person-plus-fill me-2"></i> Tambah User Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('setting.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-person me-1"></i> Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-control-premium" required placeholder="Ex: John Doe">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-envelope me-1"></i> Alamat Email</label>
                            <input type="email" name="email" class="form-control form-control-premium" required placeholder="john@example.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-key me-1"></i> Password</label>
                            <input type="password" name="password" class="form-control form-control-premium" required placeholder="Min. 8 characters">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-shield-check me-1"></i> Role Hak Akses</label>
                            <select name="role" class="form-select form-control-premium" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-5 pt-0">
                        <button type="button" class="btn btn-light rounded-4 px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-add-premium px-5">Buat User Baru</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- EDIT USER MODAL -->
    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title fw-extrabold"><i class="bi bi-pencil-square me-2"></i> Edit Informasi User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-5">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-person me-1"></i> Nama Lengkap</label>
                            <input type="text" name="name" id="edit_name" class="form-control form-control-premium" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-envelope me-1"></i> Alamat Email</label>
                            <input type="email" name="email" id="edit_email" class="form-control form-control-premium" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-key me-1"></i> Password <span class="opacity-50 fw-normal">(Opsional)</span></label>
                            <input type="password" name="password" class="form-control form-control-premium" placeholder="Biarkan kosong jika tetap">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-navy"><i class="bi bi-shield-check me-1"></i> Role Hak Akses</label>
                            <select name="role" id="edit_role" class="form-select form-control-premium" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="superadmin">Superadmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-5 pt-0">
                        <button type="button" class="btn btn-light rounded-4 px-4 fw-bold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-add-premium px-5">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editUser(user) {
            const form = document.getElementById('editUserForm');
            form.action = `/setting/update/${user.id}`;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role;
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
        @endif
    </script>
</body>
</html>

