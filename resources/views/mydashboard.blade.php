<!DOCTYPE html>
<html lang="id">

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUSTECH Monitoring Dashboard</title>
    <meta name="description" content="Real-Time Network & Site Operation Center Dashboard">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/mydashboard.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        /* Modern Chat Enhancements */
        @keyframes chatMessageIn {
            from { opacity: 0; transform: translateY(15px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .chat-message-in {
            animation: chatMessageIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .chat-bubble {
            position: relative;
            padding: 12px 18px;
            border-radius: 20px;
            font-size: 13.5px;
            line-height: 1.5;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            overflow-wrap: anywhere;
            word-break: break-word;
        }

        .chat-bubble-me {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #ffffff;
            border-bottom-right-radius: 4px;
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
        }

        .chat-bubble-them {
            background: rgba(255, 255, 255, 0.9);
            color: #1a1a1a;
            border-bottom-left-radius: 4px;
            border: 1px solid rgba(255,255,255,1);
            box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        }

        .chat-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .chat-avatar:hover {
            transform: scale(1.1);
        }

        .chat-sender-name {
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 5px;
            letter-spacing: 0.5px;
        }

        .admin-badge {
            background: #2c3e50;
            color: #fff;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            text-transform: uppercase;
        }

        .chat-timestamp {
            font-size: 9px;
            margin-top: 6px;
            opacity: 0.6;
            text-align: right;
            font-weight: 500;
        }

        .chat-reply-preview-inner {
            background: rgba(0,0,0,0.06);
            padding: 8px 12px;
            border-radius: 10px;
            margin-bottom: 8px;
            border-left: 4px solid #007bff;
            font-size: 11.5px;
            color: inherit;
        }

        .chat-reply-btn {
            cursor: pointer;
            text-decoration: none;
            font-size: 11px;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .chat-reply-btn:hover {
            opacity: 0.7;
        }

        #chatbox::-webkit-scrollbar {
            width: 6px;
        }
        #chatbox::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .chat-input-wrapper {
            background: #ffffff;
            border-radius: 30px;
            padding: 5px 5px 5px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .chat-input-wrapper:focus-within {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-color: #007bff;
            transform: translateY(-2px);
        }
    </style>
</head>

<body data-force-light="true">
    <!-- Header -->
    <header class="header">
        <div class="header-bg-layer"></div>
        <div class="header-content-layer">
            <div class="header-blobs">
                <div class="blob blob-1"></div>
                <div class="blob blob-2"></div>
                <div class="blob blob-3"></div>
            </div>
            <div class="logo-section">
                <div class="logo-text">
                    <h1>
                        <i class="ph-fill ph-broadcast"></i>
                        <span class="bold-title">NUSTECH</span>
                        <span class="regular-title">Monitoring Dashboard</span>
                    </h1>
                    <p>Real-Time Network & Site Operation Center</p>
                </div>
            </div>
        </div>
        <div class="header-clock">
            <span id="clock">00:00:00</span>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-container">

        <!-- Left Column -->
        <div class="left-column">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="card stat-card blue-card clickable-card" data-type="today" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">Ticket<br>Today</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side"><span class="value" id="stat-today">{{ $todayCount }}</span></div>
                    </div>
                </div>

                <div class="card stat-card blue-card clickable-card" data-type="all_open" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">All Open<br>Ticket</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side"><span class="value" id="stat-all-open">{{ $totalOpen }}</span></div>
                    </div>
                </div>

                <div class="card stat-card white-card clickable-card" data-type="pm_bmn" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">PM<br>BMN<br>Done</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side">
                            <div class="value-group">
                                <span class="value" id="stat-pm-bmn-done">{{ $pmBmnDone }}</span>
                                <span class="sub-value" id="stat-pm-bmn-total">/ {{ $pmBmnTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card stat-card white-card clickable-card" data-type="pm_sl" style="cursor: pointer;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">PM<br>SL<br>Done</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side">
                            <div class="value-group">
                                <span class="value" id="stat-pm-sl-done">{{ $pmSlDone }}</span>
                                <span class="sub-value" id="stat-pm-sl-total">/ {{ $pmSlTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card stat-card white-card clickable-card" data-type="cm_all" style="cursor: pointer; grid-column: span 2;">
                    <div class="card-inner">
                        <div class="label-side"><span class="label-text">CM<br>Done</span></div>
                        <div class="vertical-divider"></div>
                        <div class="value-side">
                            <div class="value-group">
                                <span class="value" id="stat-cm-done">{{ $cmDone }}</span>
                                <span class="sub-value" id="stat-cm-total">/ {{ $cmTotal }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <div class="sidebar-menu">

                <!-- Menu Item 1: Piket Schedule (Expanded) -->
                <div class="card menu-item expanded">
                    <div class="menu-header">
                        <span class="menu-title">Piket Schedule</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>
                        <div class="menu-content">
                            <div class="shift-info-bar">
                                <div class="shift-status">
                                    <span>{{ $piketHariIni->isNotEmpty() ? 'Shift On' : 'No Shift' }}</span>
                                </div>
                                <div class="shift-time">
                                    {{ $shiftInfo }}
                                </div>
                            </div>
                            <div class="personnel-list">
                                @forelse($piketHariIni as $piket)
                                    <div class="personnel-badge">
                                        {{ $piket->user->name ?? $piket->nama_petugas }}
                                        <span class="badge bg-light text-dark ms-1" style="font-size: 10px;">{{ $piket->shift->kode }}</span>
                                    </div>
                                @empty
                                    <div class="text-muted small p-2">Semua personil sedang OFF hari ini.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                <!-- Menu Item 2: Open Ticket Problem (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Open Ticket Problem</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content ticket-content">
                        <div class="ticket-list">
                            @forelse($sidebarTickets as $problem => $items)
                                <div class="ticket-group">
                                    <div class="ticket-row">
                                        <span>{{ strtoupper($problem ?? 'N/A') }}</span>
                                        <a href="javascript:void(0)" class="toggle-site">Lihat Site ({{ $items->count() }})</a>
                                    </div>
                                    
                                    {{-- Container Detail Site --}}
                                    <div class="site-detail-container" style="display: none; padding: 8px 10px; background: rgba(0,0,0,0.03); border-radius: 6px; margin-top: 5px;">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            @foreach($items as $ticket)
                                                <li style="padding: 4px 0; color: #2c3e50; font-size: 0.8rem; display: flex; align-items: center; border-bottom: 1px solid rgba(0,0,0,0.03);">
                                                    <i class="ph ph-caret-right" style="margin-right: 5px; color: #4facfe;"></i>
                                                    {{ $ticket->nama_site }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @empty
                                <p style="padding: 10px; color: #999; text-align: center; font-size: 0.85rem;">No open problems</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <!-- Menu Item 3: Sparepart Needed (Collapsed) -->
                <div class="card menu-item collapsed">
                    <div class="menu-header">
                        <span class="menu-title">Sparepart Needed</span>
                        <i class="ph-fill ph-caret-right arrow-icon"></i>
                    </div>

                    <div class="menu-content">
                        <p style="">Belum ada sparepart</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">

            <!-- Ticket Table -->
            <div class="card table-card">
                <h2 class="card-title">Open Ticket List</h2>
                <div class="table-wrapper no-scrollbar">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th style="width: 35%">Site Name</th>
                                <th style="width: 23%">Site ID</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 15%">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tickets as $ticket)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $ticket->nama_site }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" 
                                    class="site-detail-link" 
                                    data-id="{{ $ticket->id }}" 
                                    style="color: #000000; text-decoration: none; font-weight: normal;">
                                        {{ $ticket->site_code }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark">OPEN</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $tglRekap = \Carbon\Carbon::parse($ticket->tanggal_rekap)->startOfDay();
                                        if (in_array(strtolower($ticket->status), ['close', 'closed']) && $ticket->tanggal_close) {
                                            $tglAkhir = \Carbon\Carbon::parse($ticket->tanggal_close)->startOfDay();
                                        } else {
                                            $tglAkhir = now()->startOfDay();
                                        }
                                        $durasiDashboard = $tglRekap->diffInDays($tglAkhir);
                                    @endphp
                                    {{ floor($durasiDashboard) }} Hari
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada tiket terbuka saat ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Chat Widget -->
            <div class="card chat-card" style="border: none; overflow: hidden;">
                <div class="chat-header" style="background: rgba(255,255,255,0.5); backdrop-filter: blur(10px); padding: 15px 20px; border-bottom: 1px solid rgba(0,0,0,0.05);">
                    <h2 class="card-title" style="display: flex; justify-content: space-between; align-items: center; margin: 0; font-size: 1.1rem;">
                        <span style="display: flex; align-items: center; gap: 8px;">
                            <i class="ph-fill ph-chat-circle-dots" style="color: #007bff;"></i>
                            Live Chat
                        </span>
                        <span id="last-sync-time" style="font-size: 10px; font-weight: 500; color: #888;">Last Sync: --:--</span>
                    </h2>
                </div>

                <div class="chat-area no-scrollbar" id="chatbox" style="height: 400px; overflow-y: auto; padding: 20px; display: flex; flex-direction: column; background: rgba(0,0,0,0.02); gap: 15px;"></div>

                <div class="chat-footer" style="padding: 15px; background: #ffffff;">
                    <div id="replyPreview" class="hidden" style="background: rgba(0,123,255,0.05); padding: 10px 15px; border-radius: 12px; margin-bottom: 12px; font-size: 12px; display: none; justify-content: space-between; align-items: center; border-left: 4px solid #007bff;">
                        <div>
                            <span style="font-weight: 700; color: #007bff;">Membalas:</span> 
                            <span id="replyText" style="color: #555; margin-left: 5px;"></span>
                        </div>
                        <button onclick="cancelReply()" style="color: #888; border: none; background: none; cursor: pointer; font-size: 14px;">&times;</button>
                    </div>

                    <div class="chat-input-wrapper">
                        <input type="text" id="chatInput" placeholder="Ketik pesan di sini..." style="flex: 1; border: none; outline: none; background: transparent; font-size: 13.5px; font-family: inherit;">
                        <button class="send-btn" onclick="sendMessage()" style="background: #007bff; color: white; border: none; width: 36px; height: 36px; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; flex-shrink: 0; position: static; transform: none; box-shadow: 0 4px 10px rgba(0,123,255,0.3); transition: all 0.2s;">
                            <i class="ph-fill ph-paper-plane-right" style="font-size: 1.1rem;"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div id="siteModal" class="custom-modal" style="display:none;">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center position-relative" style="background-color: #ffffff; border-bottom: 2px solid #eee;">
                    <h2 class="modal-title w-100 text-center" id="modalTitle" style="color: #000000; font-weight: 700;">Detail Tiket</h2>
                    <button type="button" class="btn-close position-absolute end-0 me-3 close-modal" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none; color: #000000; font-size: 1.5rem; font-weight: 700;">&times;</button>
                </div>
                <div class="modal-body">
            <div class="modal-detail-wrapper">
                <div class="detail-info-list">
                    <div class="detail-row"><span>Site ID</span> : <span id="m-site-id"></span></div>
                    <div class="detail-row"><span>Kategori</span> : <span id="m-kategori"></span></div>
                    <div class="detail-row"><span>Provinsi</span> : <span id="m-provinsi"></span></div>
                    <div class="detail-row"><span>Kabupaten</span> : <span id="m-kabupaten"></span></div>
                    <div class="detail-row"><span>Sumber Listrik</span> : <span id="m-listrik"></span></div>
                    <div class="detail-row"><span>Durasi</span> : <span id="m-durasi"></span></div>
                    <div class="detail-row"><span>Detail Problem</span> : <span id="m-problem"></span></div>
                    <div class="detail-row"><span>CE</span> : <span id="m-ce"></span></div>
                    <div class="detail-row"><span>Evidence</span> : <span id="m-evidence" class="text-primary fw-bold"></span></div>
                </div>

                <div class="map-container-small" style="position: relative;">
                    <div id="map"></div>
                    <div style="position: absolute; bottom: 5px; right: 5px; z-index: 1000; background: rgba(255,255,255,0.8); padding: 2px 8px; border-radius: 4px; font-size: 11px;">
                        <a id="googleMapsLink" href="#" target="_blank" style="color: #007bff; text-decoration: none; font-weight: bold;">
                            <i class="ph ph-google-logo"></i> View on Google Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="line"></div>
            <p>@2026 NUSTECH. All right reserved.</p>
            <div class="line"></div>
        </div>
    </footer>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    function getGuestName() {
        // Jika sudah login, tidak perlu nama guest
        if (@json(auth()->check())) return null;

        let name = localStorage.getItem('chat_guest_name');
        
        while (!name || name.trim() === "") {
            name = prompt("Silakan masukkan nama Anda untuk memulai chat:");
            if (name) {
                name = name.trim();
                localStorage.setItem('chat_guest_name', name);
            }
        }
        return name;
    }
// Pelacakan pesan terakhir untuk notifikasi
let lastMessageId = null;
let isFirstLoad = true;

// Minta izin notifikasi browser & Fitur Enter-to-Send
document.addEventListener('DOMContentLoaded', function() {
    if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
        Notification.requestPermission();
    }

    // Tambahkan event listener Enter pada input chat
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault(); // Hindari newline karea input bertipe text
                sendMessage();
            }
        });
    }
});

// Fungsi untuk menampilkan notifikasi browser
function showBrowserNotification(msg) {
    console.log("Mencoba menampilkan notifikasi. Status Izin:", Notification.permission); 
    if (Notification.permission === 'granted') {
        const isAdmin = (msg.user && (msg.user.is_admin == 1 || msg.user.is_admin === true)) || (msg.is_admin == 1);
        const name = msg.user ? msg.user.name : (msg.guest_name || 'Guest');
        // Format Baru: Nama (Admin)
        const senderName = isAdmin ? `${name} (Admin)` : name;
        
        try {
            const notification = new Notification(`Chat Baru dari ${senderName}`, {
                body: msg.message,
                icon: 'https://cdn-icons-png.flaticon.com/512/733/733585.png'
            });

            notification.onclick = function() {
                window.focus();
                notification.close();
            };
        } catch (e) {
            console.error("Gagal membuat objek Notifikasi:", e);
        }
    } else {
        console.warn("Izin notifikasi tidak diberikan (Status: " + Notification.permission + ")");
    }
}

let selectedReplyId = null;
function setReply(id, text, name, isAdmin = false) { 
    selectedReplyId = id;
    const preview = document.getElementById('replyPreview');
    const replyText = document.getElementById('replyText');
    
    // Gunakan nama yang sudah diformat dari parameter
    replyText.innerText = `${name}: ${text.substring(0, 35)}${text.length > 35 ? '...' : ''}`;
    
    preview.style.display = 'flex';
    document.getElementById('chatInput').focus();
}
// 2. Fungsi membatalkan balasan
function cancelReply() {
    selectedReplyId = null;
    document.getElementById('replyPreview').style.display = 'none';
}

function formatAdminName(name, isAdmin) {
    return isAdmin ? `${name} (Admin)` : name;
}

/// 3. Fungsi Ambil Pesan (Load)
function loadMessages() {
    const guestName = localStorage.getItem('chat_guest_name') || '';
    fetch(`{{ route('chat.fetch') }}?guest_name=${encodeURIComponent(guestName)}`)
        .then(res => res.json())
        .then(data => {
            const chatbox = document.getElementById('chatbox');
            
            // Cek pesan baru untuk notifikasi
            if (!isFirstLoad) {
                data.forEach(msg => {
                    const isMsgNew = lastMessageId && msg.id > lastMessageId;
                    if (isMsgNew && !msg.is_me) {
                        showBrowserNotification(msg);
                    }
                });
            }

            // Update lastMessageId ke pesan paling baru di data
            if (data.length > 0) {
                lastMessageId = Math.max(...data.map(m => m.id));
            }
            isFirstLoad = false;

            chatbox.innerHTML = "";
            let lastDate = null;

            data.forEach(msg => {
                // --- 1. LOGIKA PEMISAH TANGGAL ---
                const dateObj = new Date(msg.created_at);
                const msgDate = dateObj.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });
                
                const today = new Date().toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });

                const yesterday = new Date();
                yesterday.setDate(yesterday.getDate() - 1);
                const yesterdayStr = yesterday.toLocaleDateString('id-ID', {
                    day: 'numeric', month: 'long', year: 'numeric'
                });

                if (msgDate !== lastDate) {
                    let label = msgDate;
                    if (msgDate === today) label = "Hari Ini";
                    else if (msgDate === yesterdayStr) label = "Kemarin";

                    chatbox.innerHTML += `
                        <div style="display: flex; align-items: center; margin: 20px 0; opacity: 0.8;">
                            <div style="flex: 1; height: 1px; background: linear-gradient(to right, transparent, #ddd);"></div>
                            <div style="padding: 0 15px; font-size: 11px; font-weight: bold; color: #888; text-transform: uppercase; letter-spacing: 1px;">${label}</div>
                            <div style="flex: 1; height: 1px; background: linear-gradient(to left, transparent, #ddd);"></div>
                        </div>
                    `;
                    lastDate = msgDate;
                }

                // --- 2. LOGIKA BUBBLE CHAT ---
                const isMe = msg.is_me;
                const isAdmin = msg.is_sender_admin;
                const displayName = msg.user ? msg.user.name : (msg.guest_name || 'Guest');
                const userPhoto = msg.user && msg.user.photo 
                    ? `{{ asset('storage_public') }}/${msg.user.photo}` 
                    : `https://ui-avatars.com/api/?name=${encodeURIComponent(displayName)}&background=random`;

                const avatarHtml = `<img src="${userPhoto}" class="chat-avatar" style="margin-${isMe ? 'left' : 'right'}: 8px;" alt="Avatar">`;

                const replyTemplate = msg.parent ? `
                    <div class="chat-reply-preview-inner">
                        <strong>${(msg.parent.user ? msg.parent.user.name : (msg.parent.guest_name || 'Guest')) + (msg.parent.is_admin == 1 ? ' (Admin)' : '')}</strong>
                        <div style="opacity: 0.8;">${msg.parent.message.substring(0, 40)}...</div>
                    </div>
                ` : '';

                const msgHtml = `
                    <div class="chat-message-in" style="display: flex; justify-content: ${isMe ? 'flex-end' : 'flex-start'}; align-items: flex-end; margin-bottom: 15px;">
                        ${!isMe ? avatarHtml : ''}
                        <div style="max-width: 75%; position: relative;">
                            <div class="chat-bubble ${isMe ? 'chat-bubble-me' : 'chat-bubble-them'}">
                                <div class="chat-sender-name">
                                    <span>${isMe ? 'Anda' : displayName}</span>
                                    ${isAdmin ? '<span class="admin-badge">Admin</span>' : ''}
                                    <span style="flex: 1;"></span>
                                    <span onclick="setReply(${msg.id}, '${msg.message.replace(/'/g, "\\'")}', '${displayName}${isAdmin ? ' (Admin)' : ''}', ${isAdmin})" 
                                          class="chat-reply-btn" style="color: ${isMe ? '#cce5ff' : '#007bff'}">
                                        Reply
                                    </span>
                                </div>
                                
                                ${replyTemplate}
                                
                                <div style="font-size: 13.5px; line-height: 1.4;">${msg.message}</div>
                                
                                <div class="chat-timestamp">
                                    ${dateObj.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                </div>
                            </div>
                        </div>
                        ${isMe ? avatarHtml : ""}
                    </div>
                `;
                chatbox.innerHTML += msgHtml;
            });
            
            chatbox.scrollTop = chatbox.scrollHeight; 
        })
        .catch(err => console.error("Gagal memuat pesan:", err));
}
// 4. Fungsi Kirim Pesan
function sendMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value;
    if (message.trim() == "") return;

    // AMBIL NAMA GUEST DISINI
    const guestName = getGuestName(); 

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch("{{ route('chat.send') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": csrfToken
        },
        body: JSON.stringify({ 
            message: message,
            guest_name: guestName, // KIRIM NAMA KE SERVER
            parent_id: selectedReplyId 
        })
    })
    .then(async res => {
        const data = await res.json();
        if (!res.ok) {
            // Ini akan memberitahu kita ALASAN spesifik gagalnya
            console.error("Error Server:", data);
            throw new Error(data.message || "Gagal mengirim");
        }
        return data;
    })
    .then(() => {
        input.value = "";
        cancelReply();
        loadMessages(); 
    })
    .catch(err => {
        console.error(err);
        alert("Pesan Gagal: " + err.message);
    });
}

// Jalankan load pesan setiap 3 detik
setInterval(loadMessages, 15000);
loadMessages();
</script>
{{-- Script untuk Detail Site Modal & Peta --}}
    <script>
        // 1. Inisialisasi Peta & Jam Global
        let map; 

        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-GB', { 
                hour: '2-digit', minute: '2-digit', second: '2-digit' 
            });
            const clockEl = document.getElementById('clock');
            if(clockEl) clockEl.innerText = timeString;
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 2. Logika Sidebar Menu (Expand/Collapse Card Utama)
        const menuItems = document.querySelectorAll(".menu-item");
        menuItems.forEach(item => {
            const header = item.querySelector(".menu-header");
            header.addEventListener("click", function(e) {
                // JANGAN jalankan collapse jika yang diklik adalah tombol "Lihat Site"
                if (e.target.classList.contains('toggle-site')) return;

                if (item.classList.contains("expanded")) {
                    item.classList.remove("expanded");
                    item.classList.add("collapsed");
                } else {
                    // Tutup menu lain yang terbuka
                    menuItems.forEach(i => {
                        i.classList.remove("expanded");
                        i.classList.add("collapsed");
                    });
                    // Buka yang sekarang
                    item.classList.remove("collapsed");
                    item.classList.add("expanded");
                }
            });
        });

        // 3. Logic for "Lihat Site" (Dropdown in sidebar)
        document.addEventListener('click', function(e) {
            const toggleBtn = e.target.closest('.toggle-site');
            if (toggleBtn) {
                e.preventDefault();
                e.stopPropagation();

                const group = toggleBtn.closest('.ticket-group');
                const container = group.querySelector('.site-detail-container');
                if (!container) return;
                
                const count = container.querySelectorAll('li').length;
                const isHidden = container.style.display === "none" || container.style.display === "";

                if (isHidden) {
                    container.style.display = "block";
                    toggleBtn.innerHTML = `Tutup Site (${count})`;
                    toggleBtn.style.color = "#ff4d4d";
                    toggleBtn.style.fontWeight = "bold";
                } else {
                    container.style.display = "none";
                    toggleBtn.innerHTML = `Lihat Site (${count})`;
                    toggleBtn.style.color = "";
                    toggleBtn.style.fontWeight = "normal";
                }
            }
        });

        // 4. Logika Modal Detail (Klik Site ID di Tabel)
        function openSiteDetail(id) {
            // Reset modal data so previous site data isn't shown
            document.getElementById('m-site-id').innerText = '...';
            document.getElementById('m-kategori').innerText = '...';
            document.getElementById('m-provinsi').innerText = '...';
            document.getElementById('m-kabupaten').innerText = '...';
            document.getElementById('m-listrik').innerText = '...';
            document.getElementById('m-durasi').innerText = '...';
            document.getElementById('m-problem').innerText = '...';
            document.getElementById('m-ce').innerText = '...';
            document.getElementById('m-evidence').innerText = '...';

            fetch(`/ticket/detail/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }
                    const modal = document.getElementById('siteModal');
                    modal.style.display = 'flex';

                    // Update Isi Modal
                    document.getElementById('modalTitle').innerText = `Detail Tiket - ${data.nama_site}`;
                    document.getElementById('m-site-id').innerText = data.site_id || '-';
                    document.getElementById('m-kategori').innerText = data.kategori || '-';
                    document.getElementById('m-provinsi').innerText = data.provinsi || '-';
                    document.getElementById('m-kabupaten').innerText = data.kabupaten || '-';
                    document.getElementById('m-listrik').innerText = data.sumber_listrik || '-';
                    document.getElementById('m-durasi').innerText = `${Math.floor(data.durasi || 0)} Hari`;
                    document.getElementById('m-problem').innerText = data.detail_problem || '-';
                    document.getElementById('m-ce').innerText = data.ce || '-';

                    // Update Evidence Row
                    const evidenceEl = document.getElementById('m-evidence');
                    // Check if evidence exists and looks like a file path (contains a period)
                    const hasEvidence = data.evidence && 
                                      data.evidence.trim() !== '' && 
                                      data.evidence !== 'null' && 
                                      data.evidence.includes('.');

                    if (hasEvidence) {
                        const baseUrl = "{{ asset('storage_public') }}";
                        evidenceEl.innerHTML = `<a href="javascript:void(0)" onclick="viewEvidence('${baseUrl}/${data.evidence}')" class="text-primary fw-bold" style="text-decoration: none;"><i class="ph ph-eye"></i> ADA (Klik untuk lihat)</a>`;
                    } else {
                        evidenceEl.innerText = 'TIDAK ADA';
                    }

                    // Render Map
                    setTimeout(() => {
                        if (map) { map.remove(); map = null; }
                        const lat = parseFloat(data.latitude);
                        const lng = parseFloat(data.longitude);

                        if (!isNaN(lat) && !isNaN(lng) && lat !== 0) {
                            map = L.map('map').setView([lat, lng], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                            L.marker([lat, lng]).addTo(map);
                            map.invalidateSize();

                            // Update Google Maps Link
                            const googleMapsLink = document.getElementById('googleMapsLink');
                            if (googleMapsLink) {
                                googleMapsLink.href = `https://www.google.com/maps?q=${lat},${lng}`;
                            }
                        }
                    }, 400);
                })
                .catch(err => console.error("Gagal memuat detail:", err));
        }

        // Listener untuk link di tabel (Event Delegation untuk element dinamis)
        document.body.addEventListener('click', function(e) {
            let target = e.target.closest('.site-detail-link');
            if (target) {
                e.preventDefault();
                openSiteDetail(target.getAttribute('data-id'));
            }
        });

        // 5. Logika Penutup Modal
        const closeModal = () => { document.getElementById('siteModal').style.display = 'none'; };
        const closeBtn = document.querySelector('.close-modal');
        if(closeBtn) closeBtn.onclick = closeModal;
        
        window.onclick = (event) => {
            const modal = document.getElementById('siteModal');
            if (event.target == modal) closeModal();
        };
    </script>
<script>
let currentTableFilter = 'all_open'; // Default Filter

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.clickable-card');
    
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const type = this.getAttribute('data-type');
            currentTableFilter = type; // Simpan filter yang aktif
            const tableBody = document.querySelector('table tbody');
            const tableTitle = document.querySelector('.table-card .card-title');
            const tableHeaderLast = document.querySelector('table thead th:last-child'); // Target kolom Duration/Date

            // Feedback visual
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Sedang mengambil data...</td></tr>';

            fetch(`/tickets/filter?type=${type}`)
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (tableTitle) tableTitle.innerText = data.type_label;
                        
                        // FIX: Merubah Header secara dinamis
                        if (type === 'pm_bmn' || type === 'pm_sl' || type === 'cm_all') {
                            if (tableHeaderLast) tableHeaderLast.innerText = 'Date';
                        } else {
                            if (tableHeaderLast) tableHeaderLast.innerText = 'Duration';
                        }

                        tableBody.innerHTML = '';

                        if (data.tickets.length === 0) {
                            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
                            return;
                        }

                        data.tickets.forEach((t, index) => {
                            tableBody.innerHTML += `
                                <tr>
                                    <td class="text-center">${index + 1}</td>
                                    <td>${t.nama_site}</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" 
                                        class="site-detail-link" 
                                        data-id="${t.site_code}" 
                                        style="color: #000000; text-decoration: none; font-weight: normal;">
                                            ${t.site_code}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge ${t.status === 'DONE' ? 'bg-success' : 'bg-warning'}">
                                            ${t.status}
                                        </span>
                                    </td>
                                    <td class="text-center">${t.display_date}</td>
                                </tr>
                            `;
                        });
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal memuat data.</td></tr>';
                });
        });
    });
});
</script>

<!-- Auto Logout Script -->
<script>
    (function() {
        let timeout;
        const maxIdleTime = 3600000; // 1 jam (3.600.000 ms)

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logoutUser, maxIdleTime);
        }

        function logoutUser() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('logout') }}";
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = "{{ csrf_token() }}";
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
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

<!-- Script Auto-Refresh Menyeluruh (V5 - Stabil) -->
<script>
(function() {
    // CSS Efek Pulse
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse-update {
            0% { transform: scale(1); color: #28a745; font-weight: bold; }
            50% { transform: scale(1.1); color: #28a745; font-weight: bold; }
            100% { transform: scale(1); }
        }
        .update-pulse { animation: pulse-update 0.8s ease-out; }
    `;
    document.head.append(style);

    function applyPulse(elementId, newValue) {
        const el = document.getElementById(elementId);
        if (el && el.innerText != newValue) {
            el.innerText = newValue;
            el.classList.remove('update-pulse');
            void el.offsetWidth; 
            el.classList.add('update-pulse');
        } else if (el) {
            el.innerText = newValue;
        }
    }

    function safeUpdateInnerText(id, text) {
        const el = document.getElementById(id);
        if (el) el.innerText = text;
    }


    function updateStats() {
        console.log("Sinkronisasi Dashboard Dimulai...");
        const syncLabel = document.getElementById('last-sync-time');
        
        // Visual indicator: Sedang Sinkron
        if (syncLabel) syncLabel.style.color = '#4facfe';

        fetch(`{{ route('dashboard.stats') }}?type=${currentTableFilter}&_t=` + new Date().getTime())
            .then(res => res.json())
            .then(data => {
                if (!data.success) throw new Error(data.message || "Gagal mengambil data");

                const s = data.stats;
                
                // 1. Update Statistik Utama
                try {
                    applyPulse('stat-today', s.todayCount);
                    applyPulse('stat-all-open', s.totalOpen);
                    applyPulse('stat-pm-bmn-done', s.pmBmnDone);
                    applyPulse('stat-pm-sl-done', s.pmSlDone);
                    applyPulse('stat-cm-done', s.cmDone);
                    safeUpdateInnerText('stat-pm-bmn-total', `/ ${s.pmBmnTotal}`);
                    safeUpdateInnerText('stat-pm-sl-total', `/ ${s.pmSlTotal}`);
                    safeUpdateInnerText('stat-cm-total', `/ ${s.cmTotal}`);
                } catch (e) { console.warn("Error update stats:", e); }

                // 2. Update Jadwal Piket
                try {
                    const statusEl = document.querySelector('.shift-status span');
                    const timeEl = document.querySelector('.shift-time');
                    const listEl = document.querySelector('.personnel-list');
                    
                    if (statusEl) statusEl.innerText = data.piket.status;
                    if (timeEl) timeEl.innerText = data.piket.info;
                    if (listEl) {
                        listEl.innerHTML = data.piket.list.length > 0 
                            ? data.piket.list.map(p => `
                                <div class="personnel-badge">
                                    ${p.name}
                                    <span class="badge bg-light text-dark ms-1" style="font-size: 10px;">${p.shift_kode}</span>
                                </div>`).join('')
                            : '<div class="text-muted small p-2">Semua personil sedang OFF hari ini.</div>';
                    }
                } catch (e) { console.warn("Error update piket:", e); }

                // 3. Update Sidebar (Open Ticket Problem)
                try {
                    const sidebarContainer = document.querySelector('.ticket-list');
                    if (sidebarContainer) {
                        let html = '';
                        for (const [prob, items] of Object.entries(data.sidebar)) {
                            html += `
                                <div class="ticket-group">
                                    <div class="ticket-row">
                                        <span>${prob.toUpperCase()}</span>
                                        <a href="javascript:void(0)" class="toggle-site">Lihat Site (${items.length})</a>
                                    </div>
                                    <div class="site-detail-container" style="display: none; padding: 8px 10px; background: rgba(0,0,0,0.03); border-radius: 6px; margin-top: 5px;">
                                        <ul style="list-style: none; padding: 0; margin: 0;">
                                            ${items.map(t => `<li style="padding: 4px 0; font-size: 0.8rem; border-bottom: 1px solid rgba(0,0,0,0.03);"><i class="ph ph-caret-right" style="margin-right: 5px; color: #4facfe;"></i>${t.nama_site}</li>`).join('')}
                                        </ul>
                                    </div>
                                </div>`;
                        }
                        sidebarContainer.innerHTML = html || '<p class="text-center small text-muted">No open problems</p>';
                    }
                } catch (e) { console.warn("Error update sidebar:", e); }

                // 4. Update Tabel Utama
                try {
                    const tbody = document.querySelector('.table-card tbody');
                    const tableTitle = document.querySelector('.table-card .card-title');
                    const tableHeaderLast = document.querySelector('table thead th:last-child');

                    if (tableTitle) tableTitle.innerText = data.type_label;
                    
                    // Update Header Tabel Kolom Terakhir
                    if (data.type === 'pm_bmn' || data.type === 'pm_sl' || data.type === 'cm_all') {
                        if (tableHeaderLast) tableHeaderLast.innerText = 'Date';
                    } else {
                        if (tableHeaderLast) tableHeaderLast.innerText = 'Duration';
                    }

                    if (tbody) {
                        tbody.innerHTML = data.table.length > 0
                            ? data.table.map((t, idx) => `
                                <tr>
                                    <td class="text-center">${idx + 1}</td>
                                    <td>${t.nama_site}</td>
                                    <td class="text-center"><a href="javascript:void(0)" class="site-detail-link" data-id="${t.id}" style="color:#000; text-decoration:none;">${t.site_code}</a></td>
                                    <td class="text-center">
                                        <span class="badge ${t.status === 'DONE' ? 'bg-success' : 'bg-warning'}">
                                            ${t.status}
                                        </span>
                                    </td>
                                    <td class="text-center">${t.durasi}</td>
                                </tr>`).join('')
                            : `<tr><td colspan="5" class="text-center">Tidak ada data untuk ${data.type_label}.</td></tr>`;
                    }
                } catch (e) { console.warn("Error update table:", e); }

                // Success Visual
                if (syncLabel) {
                    const now = new Date();
                    syncLabel.innerText = "Last Sync: " + now.toLocaleTimeString();
                    syncLabel.style.color = '#28a745';
                }
            })
            .catch(err => {
                console.error("Gagal sinkronisasi:", err);
                if (syncLabel) {
                    syncLabel.innerText = "Sync Failed: " + new Date().toLocaleTimeString();
                    syncLabel.style.color = '#dc3545';
                }
            });
    }

    // Jalankan
    setInterval(updateStats, 30000); // 30 Detik
    window.addEventListener('load', updateStats);
})();
</script>

<!-- Modal Viewer Evidence -->
<div id="modalViewerEvidence" class="custom-modal" style="display: none;">
    <div class="modal-content bg-transparent border-0 shadow-none" style="background: transparent; box-shadow: none;">
        <span class="close-modal-evidence" style="position: absolute; top: -40px; right: 0; font-size: 40px; color: white; cursor: pointer;">&times;</span>
        <div id="evidenceContainer" style="display: flex; justify-content: center; align-items: center; min-height: 200px;">
            <!-- Content will be injected here -->
        </div>
    </div>
</div>

<script>
    function viewEvidence(url) {
        const modal = document.getElementById('modalViewerEvidence');
        const container = document.getElementById('evidenceContainer');
        if (!modal || !container) return;
        
        const ext = url.split('.').pop().toLowerCase();
        const videoExts = ['mp4', 'mov', 'avi', 'webm'];
        
        container.innerHTML = 'Loading...';
        
        if (videoExts.includes(ext)) {
            container.innerHTML = `<video src="${url}" controls autoplay class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto; max-width: 95vw;"></video>`;
        } else {
            container.innerHTML = `<img src="${url}" class="img-fluid rounded shadow-lg" style="max-height: 85vh; width: auto; max-width: 95vw; object-fit: contain;">`;
        }
        
        modal.style.display = 'flex';
    }

    // Close function for the manual modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('close-modal-evidence') || e.target.id === 'modalViewerEvidence') {
            const modal = document.getElementById('modalViewerEvidence');
            if (modal) {
                modal.style.display = 'none';
                document.getElementById('evidenceContainer').innerHTML = ''; // reset content
            }
        }
    });

    // Handle close button click specifically
    const closeEvBtn = document.querySelector('.close-modal-evidence');
    if(closeEvBtn) {
        closeEvBtn.onclick = function() {
            document.getElementById('modalViewerEvidence').style.display = 'none';
        };
    }
</script>
</body>
</html>
