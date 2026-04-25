<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management - To Do List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            color: #333;
        }

        .main-header {
            background-color: #1a202c;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Card Styling */
        .note-item {
            background: #fff;
            padding: 20px;
            border-radius: 18px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            min-height: 250px;
        }

        .note-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            border-color: #8b5cf6;
        }

        /* Progress Styling */
        .progress {
            background-color: #edf2f7;
            height: 8px;
            border-radius: 10px;
        }

        .progress-bar {
            transition: width 0.6s ease;
            border-radius: 10px;
        }

        /* Checklist */
        /* Update class ini di bagian <style> */
        .checklist-item {
            display: flex;
            align-items: flex-start;
            /* Ubah ke flex-start agar checkbox tetap di atas saat teks panjang */
            gap: 10px;
            margin-bottom: 8px;
            padding: 4px 8px;
            transition: 0.2s;
            width: 100%;
            /* Pastikan mengambil lebar penuh */
        }

        /* Tambahkan ini untuk memaksa teks membungkus (wrap) */
        .checklist-item span {
            word-break: break-word;
            /* Memecah kata yang terlalu panjang */
            white-space: normal;
            /* Memastikan teks pindah baris */
            flex: 1;
            /* Mengambil sisa ruang yang tersedia */
            line-height: 1.4;
        }

        /* Opsional: Jika judul project (h5) juga sering panjang, tambahkan ini */
        .note-item h5, .note-item h6 {
            word-break: break-word;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .checklist-item:hover {
            background: #f8fafc;
            border-radius: 8px;
        }

        .strikethrough {
            text-decoration: line-through;
            color: #a0aec0;
        }

        .subtask-input {
            border-radius: 10px !important;
            border: 1px dashed #cbd5e0 !important;
            background: #f8fafc !important;
            font-size: 13px !important;
        }

        /* Done Column Styling */
        .done-column {
            background: #e2e8f0;
            border-radius: 20px;
            padding: 20px;
            min-height: 80vh;
        }

        .done-card {
            opacity: 0.85;
            filter: grayscale(0.5);
            border-left: 5px solid #2ecc71 !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .pinned-card {
            border: 2px solid #f59e0b !important;
            background: #fffbeb !important;
        }
        .pin-active {
            color: #f59e0b !important;
        }

        /* ===== PREMIUM SECTION HEADER ===== */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 24px;
            flex-wrap: wrap;
        }

        .section-title-group {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .section-icon {
            width: 46px;
            height: 46px;
            background: #f5f3ff;
            color: #8b5cf6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.1);
        }

        .section-title {
            font-size: 24px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .count-badge {
            background: #8b5cf6;
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 10px;
            vertical-align: middle;
            box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);
            display: inline-flex;
            align-items: center;
        }

        .todo-input-container {
            flex: 1;
            max-width: 600px;
            min-width: 300px;
            position: relative;
            /* For floating button */
        }

        .todo-add-group {
            position: relative;
            background: #ffffff;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.3s;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .todo-add-group:focus-within {
            border-color: #8b5cf6;
            box-shadow: 0 0 0 4px rgba(139, 92, 246, 0.1);
        }

        .todo-add-input-alt {
            width: 100%;
            border: none;
            padding: 12px 60px 12px 15px;
            /* Extra right padding for button */
            font-size: 13.5px;
            resize: none;
            background: transparent;
            color: #1e293b;
            outline: none;
            min-height: 50px;
            display: block;
        }

        .todo-floating-btn {
            position: absolute;
            right: 10px;
            bottom: 10px;
            width: 36px;
            height: 36px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .todo-floating-btn:hover {
            background: #1d4ed8;
            transform: scale(1.05);
        }

        .todo-floating-btn:active {
            transform: scale(0.95);
        }
    </style>
</head>

<body>
    @include('components.nav-modal-structure')
    <header class="main-header">
        <div class="header-logo-container">
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()"
                style="text-decoration: none !important; color: white !important;">
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
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                <div id="profileDropdownMenu" class="hidden"
                    style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                    <div
                        style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <a href="{{ route('profile.edit') }}"
                        style="padding: 10px 15px; text-decoration: none; color: #333; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;"
                        onmouseover="this.style.backgroundColor='#f5f5f5'"
                        onmouseout="this.style.backgroundColor='transparent'">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit"
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ url('/todolist') }}" class="tab {{ request()->is('todolist*') ? 'active' : '' }}"
            style="text-decoration: none;">To Do List</a>
        @if(auth()->check() && auth()->user()->role === 'superadmin')
            <a href="{{ route('jadwalpiket') }}" class="tab {{ request()->is('jadwalpiket*') ? 'active' : '' }}"
                style="text-decoration: none;">Jadwal Piket</a>
            <a href="{{ route('remotelog') }}" class="tab {{ request()->is('remote-log*') ? 'active' : '' }}"
                style="text-decoration: none;">Log Remote</a>
        @endif
    </div>
    <div class="container-fluid mt-4 px-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-header">
                    <div class="section-title-group">
                        <div class="section-icon">
                            <i class="bi bi-kanban"></i>
                        </div>
                        <h3 class="section-title">
                            Ongoing Projects
                            <span class="count-badge">{{ $todos->count() }}</span>
                        </h3>
                    </div>
                    <div class="todo-input-container">
                        <div class="todo-add-group">
                            <textarea id="todoInput" class="todo-add-input-alt" rows="2"
                                placeholder="Nama Project Baru... (Tekan Enter untuk simpan)"
                                onkeydown="handleTextareaEnter(event)"></textarea>
                            <button class="todo-floating-btn" onclick="saveTodo()" title="Tambah Project">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="notes-grid"
                    style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                    @forelse($todos as $todo)
                        @php
                            $total = count($todo->checklists ?? []);
                            $completed = collect($todo->checklists ?? [])->where('completed', true)->count();
                            $percent = $total > 0 ? round(($completed / $total) * 100) : 0;
                        @endphp
                        <div class="note-item {{ $todo->is_pinned ? 'pinned-card' : '' }}" id="todo-card-{{ $todo->id }}" data-id="{{ $todo->id }}">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div style="flex: 1;">
                                    <h5 style="font-weight: 700; margin: 0; color: #1e293b; display: inline-block;" contenteditable="true"
                                        onkeydown="if(event.key==='Enter'){event.preventDefault();saveTitle({{ $todo->id }},this);}"
                                        onblur="saveTitle({{ $todo->id }},this)">
                                        {{ $todo->title }}
                                    </h5>
                                    @if(auth()->id() !== $todo->user_id)
                                        <div class="text-muted mt-1" style="font-size: 11px; font-weight: 500;">
                                            <i class="bi bi-reply-fill text-primary"></i> Dibagikan oleh {{ $todo->user->name ?? 'Admin' }}
                                        </div>
                                    @elseif($todo->sharedUsers && $todo->sharedUsers->count() > 0)
                                        <div class="text-muted mt-1 share-info-badge" style="font-size: 11px; font-weight: 500;">
                                            <i class="bi bi-people-fill text-success"></i> Dibagikan ke {{ $todo->sharedUsers->count() }} user
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex gap-2 ms-2">
                                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                                        @php
                                            $sharedIds = $todo->sharedUsers->pluck('id')->toJson();
                                        @endphp
                                        <i class="bi bi-share text-primary fs-5 cursor-pointer"
                                            onclick="shareTodo({{ $todo->id }}, {{ $sharedIds }})" title="Bagikan"></i>
                                    @endif
                                    <i class="bi {{ $todo->is_pinned ? 'bi-pin-fill pin-active' : 'bi-pin' }} fs-5 cursor-pointer pin-btn"
                                        onclick="togglePin({{ $todo->id }}, this)" title="Sematkan"></i>
                                    <i class="bi bi-check-circle-fill text-success fs-5 cursor-pointer"
                                        onclick="toggleStatus({{ $todo->id }})"></i>
                                    <i class="bi bi-trash text-danger cursor-pointer fs-5"
                                        onclick="deleteTodo({{ $todo->id }})"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1" style="font-size: 11px; font-weight: 600;">
                                    <span>Progress</span>
                                    <span class="pct-label">{{ $percent }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar pct-bar" style="width: {{ $percent }}%; background-color: #8b5cf6;">
                                    </div>
                                </div>
                            </div>
                            <div class="checklist-area mb-3"
                                style="max-height: 250px; overflow-y: auto; overflow-x: hidden; flex-grow: 1;">
                                @foreach($todo->checklists ?? [] as $item)
                                    <div class="checklist-item" style="justify-content: space-between;" id="sub-{{ $item['id'] }}">
                                        <div style="display: flex; align-items: flex-start; gap: 10px; flex: 1;">
                                            <input type="checkbox" {{ $item['completed'] ? 'checked' : '' }}
                                                onchange="toggleSub('{{ $todo->id }}', '{{ $item['id'] }}', this)"
                                                class="form-check-input cursor-pointer" style="min-width: 18px;">
                                            <span class="{{ $item['completed'] ? 'strikethrough' : '' }}" style="font-size: 13px; flex: 1;"
                                                contenteditable="true"
                                                onkeydown="if(event.key==='Enter'){event.preventDefault();saveSub('{{ $todo->id }}','{{ $item['id'] }}',this);}"
                                                onblur="saveSub('{{ $todo->id }}', '{{ $item['id'] }}', this)">
                                                {{ $item['text'] }}
                                            </span>
                                        </div>
                                        <i class="bi bi-trash text-danger cursor-pointer ms-2" style="font-size: 14px; margin-top: 2px;" title="Hapus sub-task"
                                            onclick="deleteSub('{{ $todo->id }}', '{{ $item['id'] }}')"></i>
                                    </div>
                                @endforeach
                            </div>
                            <input type="text" class="form-control form-control-sm subtask-input"
                                placeholder="+ Tambah sub-task..."
                                onkeydown="if(event.key === 'Enter'){ event.preventDefault(); addSubTask('{{ $todo->id }}', this); }">
                        </div>
                    @empty
                        <div id="no-todo-msg" class="col-12 text-center py-5">
                            <p class="text-muted">Tidak ada project berjalan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-4">
                <div class="done-column">
                    <h4 class="mb-4" style="font-weight: 700;"><i class="bi bi-check-all text-success"></i> Completed
                    </h4>
                    <div id="done-list">
                        @forelse($dones as $done)
                            <div class="note-item done-card {{ $done->is_pinned ? 'pinned-card' : '' }} mb-3" id="todo-card-{{ $done->id }}" data-id="{{ $done->id }}" style="min-height: auto; padding: 15px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div style="flex: 1; min-width: 0; padding-right: 15px;">
                                        <h6 class="m-0" style="font-weight: 700; text-decoration: line-through;">
                                            {{ $done->title }}
                                        </h6>
                                        @if(auth()->id() !== $done->user_id)
                                            <div class="text-muted mt-1" style="font-size: 10px;">
                                                <i class="bi bi-reply-fill text-primary"></i> Dibagikan oleh {{ $done->user->name ?? 'Admin' }}
                                            </div>
                                        @elseif($done->sharedUsers && $done->sharedUsers->count() > 0)
                                            <div class="text-muted mt-1" style="font-size: 10px;">
                                                <i class="bi bi-people-fill text-success"></i> Dibagikan ke {{ $done->sharedUsers->count() }} user
                                            </div>
                                        @endif
                                        <small class="text-muted" style="font-size: 10px;">Selesai pada:
                                            {{ $done->updated_at->format('d M H:i') }}</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-arrow-counterclockwise text-primary fs-5 cursor-pointer"
                                            onclick="toggleStatus({{ $done->id }})" title="Kembalikan ke Aktif"></i>
                                        <i class="bi bi-trash text-danger cursor-pointer"
                                            onclick="deleteTodo({{ $done->id }})"></i>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div id="no-done-msg" class="text-center py-5">
                                <p class="text-muted">Belum ada project selesai.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bagikan Project</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="shareForm">
                        <input type="hidden" id="shareTodoId">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pesan Tambahan (Opsional):</label>
                            <textarea class="form-control" id="shareMessage" rows="2" placeholder="Cth: Tolong selesaikan hari ini ya..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Pilih User:</label>
                            <div id="userCheckboxes">
                                @if(isset($users))
                                    @foreach($users as $user)
                                        <div class="form-check">
                                            <input class="form-check-input user-share-cb" type="checkbox" value="{{ $user->id }}" id="user_{{ $user->id }}">
                                            <label class="form-check-label" for="user_{{ $user->id }}">
                                                {{ $user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="submitShare()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    {{-- Script untuk dropdown profile dan CRUD To Do List --}}
    <script>
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

        // ===== TOAST =====
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        // ===== PROFILE DROPDOWN =====
        $('#profileDropdownTrigger').on('click', function(e) {
            e.stopPropagation();
            $('#profileDropdownMenu').fadeToggle(200);
        });
        $(document).on('click', () => $('#profileDropdownMenu').fadeOut(200));

        // ===== ENTER di textarea utama =====
        function handleTextareaEnter(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                saveTodo();
            }
        }

        // ===== TAMBAH PROJECT =====
        function saveTodo() {
            const title = $('#todoInput').val().trim();
            if (!title) {
                Swal.fire({ icon: 'error', title: 'Oops!', text: 'Nama project tidak boleh kosong!' });
                return;
            }
            $.ajax({
                url: "{{ route('todolist.store') }}",
                type: 'POST',
                data: { title: title },
                success: function(res) {
                    if (!res || !res.data) return;
                    const id = res.data.id;
                    const isSuperadmin = {{ auth()->check() && auth()->user()->role === 'superadmin' ? 'true' : 'false' }};
                    const shareBtn = isSuperadmin
                        ? `<i class="bi bi-share text-primary fs-5 cursor-pointer" onclick="shareTodo(${id}, [])" title="Bagikan"></i>`
                        : '';
                    const card = `
                        <div class="note-item" id="todo-card-${id}" data-id="${id}"
                             style="opacity:0; transform:scale(0.95); transition:all 0.3s;">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div style="flex:1;">
                                    <h5 style="font-weight:700;margin:0;color:#1e293b;display:inline-block;"
                                        contenteditable="true"
                                        onkeydown="if(event.key==='Enter'){event.preventDefault();saveTitle(${id},this);}"
                                        onblur="saveTitle(${id},this)">
                                        ${esc(title)}
                                    </h5>
                                </div>
                                <div class="d-flex gap-2 ms-2">
                                    ${shareBtn}
                                    <i class="bi bi-pin fs-5 cursor-pointer pin-btn" onclick="togglePin(${id}, this)" title="Sematkan"></i>
                                    <i class="bi bi-check-circle-fill text-success fs-5 cursor-pointer" onclick="toggleStatus(${id})"></i>
                                    <i class="bi bi-trash text-danger cursor-pointer fs-5" onclick="deleteTodo(${id})"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1" style="font-size:11px;font-weight:600;">
                                    <span>Progress</span><span class="pct-label">0%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar pct-bar" style="width:0%;background-color:#8b5cf6;"></div>
                                </div>
                            </div>
                            <div class="checklist-area mb-3"
                                 style="max-height:250px;overflow-y:auto;overflow-x:hidden;flex-grow:1;"></div>
                            <input type="text" class="form-control form-control-sm subtask-input"
                                   placeholder="+ Tambah sub-task..."
                                   onkeydown="if(event.key === 'Enter'){ event.preventDefault(); addSubTask(${id},this); }">
                        </div>`;
                    const $card = $(card);
                    
                    // Remove empty message if exists
                    $('#no-todo-msg').remove();
                    
                    $('.notes-grid').prepend($card);
                    setTimeout(() => $card.css({ opacity: 1, transform: 'scale(1)' }), 20);
                    $('#todoInput').val('');
                    // Update badge
                    const $badge = $('.count-badge');
                    $badge.text((parseInt($badge.text()) || 0) + 1);
                    Toast.fire({ icon: 'success', title: 'Project berhasil ditambahkan!' });
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: xhr.responseJSON?.message || 'Gagal menambah project' });
                }
            });
        }

        // ===== TOGGLE PIN =====
        function togglePin(id, iconEl) {
            $.post(`/todolist/pin/${id}`, function(res) {
                if (res.success) {
                    const $card = $(`#todo-card-${id}`);
                    const $icon = $(iconEl);
                    if (res.is_pinned) {
                        $card.addClass('pinned-card');
                        $icon.removeClass('bi-pin').addClass('bi-pin-fill pin-active');
                        Toast.fire({ icon: 'success', title: 'Tugas disematkan!' });
                    } else {
                        $card.removeClass('pinned-card');
                        $icon.removeClass('bi-pin-fill pin-active').addClass('bi-pin');
                        Toast.fire({ icon: 'success', title: 'Sematkan dilepas.' });
                    }
                    // Refresh halaman setelah jeda singkat agar urutan update (pinned di atas)
                    setTimeout(() => location.reload(), 1000);
                }
            }).fail(function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menyematkan tugas' });
            });
        }

        // ===== TOGGLE DONE / ONGOING =====
        function toggleStatus(id) {
            $.post('/todolist/toggle/' + id, function() {
                const $card = $('#todo-card-' + id);
                const title = $card.find('h5').text().trim() || $card.find('h6').text().trim();
                const isDone = $card.hasClass('done-card');

                if (!isDone) {
                    // → pindah ke Done
                    $card.fadeOut(250, function() {
                        $(this).remove();
                        
                        // Check empty state for Ongoing
                        if ($('.notes-grid .note-item').length === 0) {
                            $('.notes-grid').append(`<div id="no-todo-msg" class="col-12 text-center py-5"><p class="text-muted">Tidak ada project berjalan.</p></div>`);
                        }

                        const doneCard = `
                            <div class="note-item done-card mb-3" id="todo-card-${id}" data-id="${id}"
                                 style="min-height:auto;padding:15px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div style="flex:1;min-width:0;padding-right:15px;">
                                        <h6 class="m-0" style="font-weight:700;text-decoration:line-through;">${esc(title)}</h6>
                                        <small class="text-muted" style="font-size:10px;">Selesai: baru saja</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-arrow-counterclockwise text-primary fs-5 cursor-pointer"
                                           onclick="toggleStatus(${id})" title="Kembalikan"></i>
                                        <i class="bi bi-trash text-danger cursor-pointer"
                                           onclick="deleteTodo(${id})"></i>
                                    </div>
                                </div>
                            </div>`;
                        const $done = $(doneCard).hide();
                        
                        // Remove empty message for Done
                        $('#no-done-msg').remove();
                        
                        $('#done-list').prepend($done);
                        $done.fadeIn(250);
                        adjustBadge(-1);
                    });
                } else {
                    // → kembalikan ke Ongoing
                    $card.fadeOut(250, function() {
                        $(this).remove();
                        
                        // Check empty state for Done
                        if ($('#done-list .done-card').length === 0) {
                            $('#done-list').append(`<div id="no-done-msg" class="text-center py-5"><p class="text-muted">Belum ada project selesai.</p></div>`);
                        }

                        const onCard = `
                            <div class="note-item" id="todo-card-${id}" data-id="${id}"
                                 style="opacity:0;transition:all 0.3s;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div style="flex:1;">
                                        <h5 style="font-weight:700;margin:0;color:#1e293b;"
                                            contenteditable="true"
                                            onkeydown="if(event.key==='Enter'){event.preventDefault();saveTitle(${id},this);}"
                                            onblur="saveTitle(${id},this)">${esc(title)}</h5>
                                    </div>
                                    <div class="d-flex gap-2 ms-2">
                                        <i class="bi bi-check-circle-fill text-success fs-5 cursor-pointer" onclick="toggleStatus(${id})"></i>
                                        <i class="bi bi-trash text-danger cursor-pointer fs-5" onclick="deleteTodo(${id})"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1" style="font-size:11px;font-weight:600;">
                                        <span>Progress</span><span class="pct-label">0%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar pct-bar" style="width:0%;background-color:#8b5cf6;"></div>
                                    </div>
                                </div>
                                <div class="checklist-area mb-3"
                                     style="max-height:250px;overflow-y:auto;flex-grow:1;"></div>
                                <input type="text" class="form-control form-control-sm subtask-input"
                                       placeholder="+ Tambah sub-task..."
                                       onkeydown="if(event.key === 'Enter'){ event.preventDefault(); addSubTask(${id},this); }">
                            </div>`;
                        const $on = $(onCard);
                        
                        // Remove empty message for Ongoing
                        $('#no-todo-msg').remove();
                        
                        $('.notes-grid').prepend($on);
                        setTimeout(() => $on.css('opacity', 1), 20);
                        adjustBadge(1);
                    });
                }
                Toast.fire({ icon: 'success', title: 'Status diperbarui!' });
            }).fail(function(xhr) {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memperbarui status' });
            });
        }

        // ===== HAPUS PROJECT =====
        function deleteTodo(id) {
            Swal.fire({
                title: 'Hapus Project?', text: 'Data tidak bisa dikembalikan!',
                icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({ url: '/todolist/delete/' + id, type: 'DELETE', success: function() {
                    const $card = $('#todo-card-' + id);
                    const isDone = $card.hasClass('done-card');
                    $card.fadeOut(250, function() {
                        $(this).remove();
                        if (!isDone) {
                            adjustBadge(-1);
                            if ($('.notes-grid .note-item').length === 0) {
                                $('.notes-grid').append(`<div id="no-todo-msg" class="col-12 text-center py-5"><p class="text-muted">Tidak ada project berjalan.</p></div>`);
                            }
                        } else {
                            if ($('#done-list .done-card').length === 0) {
                                $('#done-list').append(`<div id="no-done-msg" class="text-center py-5"><p class="text-muted">Belum ada project selesai.</p></div>`);
                            }
                        }
                    });
                    Toast.fire({ icon: 'success', title: 'Project dihapus!' });
                }, error: function() {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus project' });
                }});
            });
        }

        // ===== EDIT JUDUL (Enter / blur) =====
        let _tTimer = {};
        function saveTitle(id, el) {
            const t = el.innerText.trim();
            if (!t) return;
            clearTimeout(_tTimer[id]);
            _tTimer[id] = setTimeout(() => {
                $.post('/todolist/update-title/' + id, { title: t }, function() {
                    Toast.fire({ icon: 'success', title: 'Judul disimpan!' });
                });
            }, 200);
        }

        // ===== TAMBAH SUB-TASK =====
        function addSubTask(todoId, inputEl) {
            const text = $(inputEl).val().trim();
            if (!text) return;
            $.post(`/todolist/subtask/add/${todoId}`, { text: text }, function(res) {
                if (!res || !res.success) return;
                const item = res.checklists[res.checklists.length - 1];
                const row = `
                    <div class="checklist-item" style="justify-content:space-between;" id="sub-${item.id}">
                        <div style="display:flex;align-items:flex-start;gap:10px;flex:1;">
                            <input type="checkbox" class="form-check-input cursor-pointer" style="min-width:18px;"
                                   onchange="toggleSub('${todoId}','${item.id}',this)">
                            <span style="font-size:13px;flex:1;" contenteditable="true"
                                  onkeydown="if(event.key==='Enter'){event.preventDefault();saveSub('${todoId}','${item.id}',this);}"
                                  onblur="saveSub('${todoId}','${item.id}',this)">${esc(text)}</span>
                        </div>
                        <i class="bi bi-trash text-danger cursor-pointer ms-2" style="font-size:14px;margin-top:2px;"
                           onclick="deleteSub('${todoId}','${item.id}')"></i>
                    </div>`;
                $(`#todo-card-${todoId} .checklist-area`).append(row);
                $(inputEl).val('');
                recalcPct(todoId, res.checklists);
                Toast.fire({ icon: 'success', title: 'Sub-task ditambahkan!' });
            }).fail(function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menambah sub-task' });
            });
        }

        // ===== TOGGLE CHECKBOX SUB-TASK =====
        function toggleSub(todoId, subId, cbEl) {
            $.post(`/todolist/subtask/toggle/${todoId}`, { subtask_id: subId }, function() {
                const $span = $(`#sub-${subId} span`);
                $span.toggleClass('strikethrough');
                // hitung ulang dari DOM
                const $area = $(`#todo-card-${todoId} .checklist-area`);
                const total = $area.find('.checklist-item').length;
                const done = $area.find('input[type=checkbox]:checked').length;
                const pct = total > 0 ? Math.round(done / total * 100) : 0;
                $(`#todo-card-${todoId} .pct-bar`).css('width', pct + '%');
                $(`#todo-card-${todoId} .pct-label`).text(pct + '%');
                Toast.fire({ icon: 'success', title: 'Status sub-task diperbarui!' });
            });
        }

        // ===== EDIT TEKS SUB-TASK =====
        let _sTimer = {};
        function saveSub(todoId, subId, el) {
            const t = el.innerText.trim();
            if (!t) return;
            const k = todoId + '_' + subId;
            clearTimeout(_sTimer[k]);
            _sTimer[k] = setTimeout(() => {
                $.post(`/todolist/subtask/update/${todoId}`, { subtask_id: subId, text: t }, function() {
                    Toast.fire({ icon: 'success', title: 'Sub-task diperbarui!' });
                });
            }, 200);
        }

        // ===== HAPUS SUB-TASK =====
        function deleteSub(todoId, subId) {
            Swal.fire({
                title: 'Hapus Sub-task?', icon: 'warning', showCancelButton: true,
                confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!'
            }).then(r => {
                if (!r.isConfirmed) return;
                $.ajax({ url: `/todolist/subtask/delete/${todoId}`, type: 'DELETE',
                    data: { subtask_id: subId },
                    success: function() {
                        $(`#sub-${subId}`).fadeOut(200, function() {
                            $(this).remove();
                            // hitung ulang dari DOM
                            const $area = $(`#todo-card-${todoId} .checklist-area`);
                            const total = $area.find('.checklist-item').length;
                            const done = $area.find('input[type=checkbox]:checked').length;
                            const pct = total > 0 ? Math.round(done / total * 100) : 0;
                            $(`#todo-card-${todoId} .pct-bar`).css('width', pct + '%');
                            $(`#todo-card-${todoId} .pct-label`).text(pct + '%');
                        });
                        Toast.fire({ icon: 'success', title: 'Sub-task dihapus!' });
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus sub-task' });
                    }
                });
            });
        }

        // ===== HELPER: recalc progress dari array checklists =====
        function recalcPct(todoId, checklists) {
            const total = checklists.length;
            const done  = checklists.filter(i => i.completed).length;
            const pct   = total > 0 ? Math.round(done / total * 100) : 0;
            $(`#todo-card-${todoId} .pct-bar`).css('width', pct + '%');
            $(`#todo-card-${todoId} .pct-label`).text(pct + '%');
        }

        // ===== HELPER: badge jumlah ongoing =====
        function adjustBadge(delta) {
            const $b = $('.count-badge');
            $b.text(Math.max(0, (parseInt($b.text()) || 0) + delta));
        }

        // ===== HELPER: escape HTML =====
        function esc(s) {
            return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        }

        // ===== SORTABLE =====
        document.addEventListener('DOMContentLoaded', function() {
            const grid = document.querySelector('.notes-grid');
            const done = document.querySelector('.done-column');
            if (grid) Sortable.create(grid, {
                group:'todos', animation:150, ghostClass:'sortable-ghost', handle:'.note-item',
                onEnd: evt => { if (evt.to === done && evt.from !== done) toggleStatus(evt.item.dataset.id); }
            });
            if (done) Sortable.create(done, {
                group:'todos', animation:150, ghostClass:'sortable-ghost', handle:'.note-item',
                onEnd: evt => { if (evt.to === grid && evt.from !== grid) toggleStatus(evt.item.dataset.id); }
            });
        });

        // ===== SHARE =====
        function shareTodo(id, sharedIds) {
            $('#shareTodoId').val(id);
            $('#shareMessage').val('');
            $('.user-share-cb').prop('checked', false);
            (sharedIds || []).forEach(uid => $('#user_' + uid).prop('checked', true));
            new bootstrap.Modal(document.getElementById('shareModal')).show();
        }

        function submitShare() {
            const id = $('#shareTodoId').val();
            const message = $('#shareMessage').val();
            const userIds = [];
            $('.user-share-cb:checked').each(function() { userIds.push($(this).val()); });

            $.post(`/todolist/share/${id}`, { user_ids: userIds, message: message }, function(res) {
                if (!res.success) { Swal.fire('Error', res.message || 'Terjadi kesalahan', 'error'); return; }
                bootstrap.Modal.getInstance(document.getElementById('shareModal')).hide();
                // update badge share di card
                const $card = $(`#todo-card-${id}`);
                $card.find('.share-info-badge').remove();
                if (userIds.length > 0) {
                    $card.find('h5').after(`<div class="text-muted mt-1 share-info-badge" style="font-size:11px;font-weight:500;">
                        <i class="bi bi-people-fill text-success"></i> Dibagikan ke ${userIds.length} user</div>`);
                    $card.find('.bi-share').attr('onclick', `shareTodo(${id},${JSON.stringify(userIds.map(Number))})`);
                } else {
                    $card.find('.bi-share').attr('onclick', `shareTodo(${id},[])`);
                }
                Toast.fire({ icon: 'success', title: 'Tugas berhasil dibagikan!' });
            });
        }



    </script>
</body>

</html>