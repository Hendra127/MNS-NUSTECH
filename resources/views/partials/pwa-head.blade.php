{{-- PWA Meta Tags & Service Worker Registration --}}
<link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#071152">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="MNS-NUSTECH">
<link rel="apple-touch-icon" href="{{ asset('assets/img/logonustech.png') }}">
<script src="{{ asset('js/ajax-search.js') }}?v={{ time() }}"></script>
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(() => {});
    }

    let deferredPrompt;
    
    window.addEventListener('beforeinstallprompt', (e) => {
        // Mencegah mini-infobar default muncul
        e.preventDefault();
        // Simpan event untuk dipicu nanti ketika tombol diklik
        deferredPrompt = e;
    });

    function showInstallButton() {
        // Cari container navbar dari sisi kanan (semua blade pakai struktur yang sama)
        const headerContainer = document.querySelector('.d-flex.align-items-center.gap-3');
        
        if (headerContainer && !document.getElementById('pwa-install-btn')) {
            const btn = document.createElement('button');
            btn.id = 'pwa-install-btn';
            
            // Menggunakan styling bootstrap premium sesuai tema
            btn.className = 'btn btn-sm text-white d-flex align-items-center justify-content-center gap-2';
            btn.style.background = 'linear-gradient(135deg, #0d6efd, #0b5ed7)';
            btn.style.border = 'none';
            btn.style.borderRadius = '50rem';
            btn.style.padding = '6px 14px';
            btn.style.fontWeight = '600';
            btn.style.boxShadow = '0 4px 10px rgba(13, 110, 253, 0.3)';
            btn.style.transition = 'all 0.3s';
            btn.style.cursor = 'pointer';
            
            btn.title = "Install MNS-NUSTECH App";
            btn.innerHTML = '<i class="bi bi-cloud-arrow-down-fill"></i> <span class="d-none d-md-inline" style="font-size: 13px;">Install App</span>';
            
            // Efek hover interaktif
            btn.onmouseover = () => btn.style.transform = 'translateY(-2px)';
            btn.onmouseout = () => btn.style.transform = 'translateY(0)';
            
            btn.onclick = async () => {
                if (deferredPrompt) {
                    // Tampilkan native install prompt
                    deferredPrompt.prompt();
                    // Minta pilihan dari user
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        btn.style.display = 'none';
                    }
                    deferredPrompt = null; // Reset setelah sekali klik
                } else {
                    // Jika PWA support tidak terdeteksi (HTTP) atau sudah terinstall
                    Swal.fire({
                        icon: 'info',
                        title: 'Cara Install Aplikasi',
                        html: `
                            <div style="text-align: left; font-size: 14px; line-height: 1.6;">
                                <p>Sistem mendeteksi bahwa instalasi otomatis belum tersedia atau aplikasi sudah terinstall.</p>
                                <b>🖥️ Di Komputer (Chrome/Edge):</b><br>
                                Klik icon <i class="bi bi-plus-circle"></i> atau layar monitor di bagian paling kanan <b>Address bar URL</b> di atas.<br><br>
                                <b>📱 Di HP Android/Safari:</b><br>
                                Buka menu browser (titik tiga ⋮ atau tombol Share), lalu pilih menu <b>"Add to Home Screen"</b> atau <b>"Install App"</b>.
                            </div>
                        `,
                        confirmButtonText: 'Mengerti',
                        confirmButtonColor: '#0d6efd',
                        customClass: { popup: 'rounded-4' }
                    });
                }
            };
            
            // Insert sebagai elemen pertama di container kanan (sebelah kiri tombol setting)
            headerContainer.insertBefore(btn, headerContainer.firstChild);
        }
    }

    // --- Dark Mode Logic ---
    function initDarkMode() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            document.body.classList.add('dark-mode');
        }

        const headerContainer = document.querySelector('.d-flex.align-items-center.gap-3');
        if (headerContainer && !document.getElementById('dark-mode-toggle')) {
            const btn = document.createElement('button');
            btn.id = 'dark-mode-toggle';
            // me-2 to add a little margin before the settings icon
            btn.className = 'btn btn-link text-white opacity-75 hover-opacity-100 p-0 me-md-2';
            btn.style.textDecoration = 'none';
            btn.title = 'Toggle Dark Mode';
            
            const icon = document.createElement('i');
            icon.className = savedTheme === 'dark' ? 'bi bi-moon-stars-fill' : 'bi bi-sun-fill';
            icon.style.fontSize = '1.3rem';
            icon.id = 'dark-mode-icon';
            
            icon.style.transition = 'transform 0.5s ease';
            icon.style.display = 'inline-block';
            btn.appendChild(icon);
            
            btn.onclick = () => {
                // Aktifkan transisi halus secara global
                document.documentElement.classList.add('theme-transition');

                // Simpan rotasi saat ini dan tambahkan 360 derajat agar terus berputar searah
                let currentRot = parseInt(icon.dataset.rotation || '0');
                let newRot = currentRot + 360;
                icon.dataset.rotation = newRot;

                // Terapkan animasi berputar penuh
                icon.style.transform = `rotate(${newRot}deg)`;
                
                // Ganti jenis ikon persis di pertengahan rotasi
                setTimeout(() => {
                    const currentTheme = document.documentElement.getAttribute('data-bs-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    document.documentElement.setAttribute('data-bs-theme', newTheme);
                    if (newTheme === 'dark') {
                        document.body.classList.add('dark-mode');
                        icon.className = 'bi bi-moon-stars-fill';
                    } else {
                        document.body.classList.remove('dark-mode');
                        icon.className = 'bi bi-sun-fill';
                    }
                    localStorage.setItem('theme', newTheme);
                    if(typeof updateChartsTheme === 'function') updateChartsTheme(newTheme);

                }, 150);

                // Matikan kelas efek global setelah transisi selesai
                setTimeout(() => {
                    document.documentElement.classList.remove('theme-transition');
                }, 800);
            };

            // Tambahkan di sebelah kiri ikon pengaturan
            const settingIcon = headerContainer.querySelector('a[href*="setting"]');
            if (settingIcon) {
                headerContainer.insertBefore(btn, settingIcon);
            } else {
                const profileWrapper = headerContainer.querySelector('.user-profile-wrapper');
                if(profileWrapper) {
                    headerContainer.insertBefore(btn, profileWrapper);
                } else {
                    headerContainer.prepend(btn);
                }
            }
        }
    }

    function updateChartsTheme(theme) {
        if (typeof Chart !== 'undefined') {
            const textColor = theme === 'dark' ? '#e0e0e0' : '#666';
            const gridColor = theme === 'dark' ? '#333' : '#e2e8f0';
            Chart.defaults.color = textColor;
            Chart.defaults.borderColor = gridColor;
            for (const id in Chart.instances) {
                const chart = Chart.instances[id];
                if(chart.options && chart.options.scales) {
                    for (const axis in chart.options.scales) {
                        if(chart.options.scales[axis].grid) {
                            chart.options.scales[axis].grid.color = gridColor;
                        }
                        if(chart.options.scales[axis].ticks) {
                            chart.options.scales[axis].ticks.color = textColor;
                        }
                    }
                }
                chart.update();
            }
        }
    }

    // Panggil fungsi segera setelah DOM siap, tanpa menunggu event beforeinstallprompt
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            showInstallButton();
            initDarkMode();
            updateChartsTheme(localStorage.getItem('theme') || 'light');
        });
    } else {
        showInstallButton();
        initDarkMode();
        updateChartsTheme(localStorage.getItem('theme') || 'light');
    }
</script>

<style>
    /* Smooth Global Theme Transition */
    html.theme-transition,
    html.theme-transition *,
    html.theme-transition *:before,
    html.theme-transition *:after {
        transition-property: background-color, color, border-color, box-shadow !important;
        transition-duration: 0.5s !important;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* Custom Dark Mode Overrides */
    [data-bs-theme="dark"] body {
        background-color: #121212 !important;
        background-image: none !important; /* Fix linear-gradient backgrounds */
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .note-item,
    [data-bs-theme="dark"] .done-column,
    [data-bs-theme="dark"] .card,
    [data-bs-theme="dark"] .modal-content,
    [data-bs-theme="dark"] .subtask-input,
    [data-bs-theme="dark"] #profileDropdownMenu,
    [data-bs-theme="dark"] .dropdown-menu {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .dropdown-item {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .checklist-item:hover,
    [data-bs-theme="dark"] .nav-link:hover,
    [data-bs-theme="dark"] .dropdown-item:hover {
        background-color: #2c2c2c !important;
        color: #fff !important;
    }
    [data-bs-theme="dark"] input,
    [data-bs-theme="dark"] select:not(.shift-select),
    [data-bs-theme="dark"] textarea {
        background-color: #2a2a2a !important;
        color: #fff !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .text-dark,
    [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, 
    [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4, 
    [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6,
    [data-bs-theme="dark"] .note-item h5 {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .header-brand-link,
    [data-bs-theme="dark"] .header-brand {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .modal-header,
    [data-bs-theme="dark"] .modal-footer {
        border-color: #333 !important;
    }
    /* Sweet Alert Dark Mode Overrides */
    [data-bs-theme="dark"] .swal2-popup {
        background: #1e1e1e !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .swal2-title,
    [data-bs-theme="dark"] .swal2-html-container {
        color: #e0e0e0 !important;
    }

    /* --- Table Fixes --- */
    [data-bs-theme="dark"] table,
    [data-bs-theme="dark"] .table,
    [data-bs-theme="dark"] .table-responsive-custom table,
    [data-bs-theme="dark"] .table-container table {
        color: #e0e0e0 !important;
        background-color: transparent !important;
    }
    [data-bs-theme="dark"] th,
    [data-bs-theme="dark"] table th,
    [data-bs-theme="dark"] .table th,
    [data-bs-theme="dark"] .table-responsive-custom table thead th,
    [data-bs-theme="dark"] .table-container thead th {
        background-color: #1a202c !important;
        color: #fff !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] table td,
    [data-bs-theme="dark"] .table td,
    [data-bs-theme="dark"] .table-responsive-custom table tbody td,
    [data-bs-theme="dark"] .table-container tbody td {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    
    /* --- Tailwind & Dashboard Overrides --- */
    [data-bs-theme="dark"] .bg-slate-50,
    [data-bs-theme="dark"] .bg-\[\#2d5d77\],
    [data-bs-theme="dark"] .table-header {
        background-color: #1a202c !important;
        color: #fff !important;
    }
    [data-bs-theme="dark"] .text-slate-600 {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .card.white-card,
    [data-bs-theme="dark"] .menu-item .menu-header,
    [data-bs-theme="dark"] .menu-item .menu-content {
        background: #1e1e1e !important;
        color: #e0e0e0 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .detail-row {
        border-bottom-color: #333 !important;
    }

    /* --- Dashboard Chat Widget --- */
    [data-bs-theme="dark"] .chat-header,
    [data-bs-theme="dark"] .chat-footer,
    [data-bs-theme="dark"] .chat-input-wrapper {
        background: #1e1e1e !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .chat-area {
        background: #121212 !important;
    }
    [data-bs-theme="dark"] .chat-bubble-them {
        background: #2c2c2c !important;
        color: #e0e0e0 !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] #replyPreview {
        background: #2c2c2c !important;
        border-left-color: #0d6efd !important;
    }

    /* --- Custom Modals --- */
    [data-bs-theme="dark"] .custom-modal .modal-header,
    [data-bs-theme="dark"] .custom-modal .modal-body,
    [data-bs-theme="dark"] .modal-detail-wrapper {
        background: #1e1e1e !important;
        color: #e0e0e0 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .custom-modal .modal-title,
    [data-bs-theme="dark"] .close-modal {
        color: #fff !important;
    }
    
    /* --- Detail Tiket Premium Fixes --- */
    [data-bs-theme="dark"] .premium-card {
        background: rgba(30, 30, 30, 0.9) !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .premium-card .card-title,
    [data-bs-theme="dark"] .ticket-site-name,
    [data-bs-theme="dark"] .metric-value {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .ticket-item,
    [data-bs-theme="dark"] .metric-box {
        background: #121212 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .ticket-item:hover,
    [data-bs-theme="dark"] .metric-box:hover {
        background: #252525 !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .ticket-status-dot {
        background: #1e1e1e !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .meta-pill {
        background: #1e1e1e !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .filter-input-card {
        background: #1a1a1a !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    
    /* --- Premium Dark Map (Leaflet Invert) --- */
    [data-bs-theme="dark"] .leaflet-layer,
    [data-bs-theme="dark"] .leaflet-control-zoom-in,
    [data-bs-theme="dark"] .leaflet-control-zoom-out,
    [data-bs-theme="dark"] .leaflet-control-attribution {
        filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
    }
    
    /* --- Glass Panel (Summary PM & Perangkat) --- */
    [data-bs-theme="dark"] .glass-panel {
        background: rgba(30, 30, 30, 0.9) !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .glass-panel h3,
    [data-bs-theme="dark"] .glass-panel h4,
    [data-bs-theme="dark"] .glass-panel .text-\[\#071152\],
    [data-bs-theme="dark"] .glass-panel .text-slate-700,
    [data-bs-theme="dark"] .glass-panel .text-slate-800 {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .glass-panel .bg-white {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .glass-panel .bg-green-50,
    [data-bs-theme="dark"] .glass-panel .bg-red-50,
    [data-bs-theme="dark"] .glass-panel .bg-slate-50,
    [data-bs-theme="dark"] .glass-panel .bg-indigo-50,
    [data-bs-theme="dark"] .glass-panel .bg-blue-50 {
        background-color: #121212 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .glass-panel .text-indigo-600 {
        color: #818cf8 !important; /* Lighter indigo for dark mode */
    }
    [data-bs-theme="dark"] .glass-panel .text-green-700 {
        color: #4ade80 !important;
    }
    [data-bs-theme="dark"] .glass-panel .text-red-700 {
        color: #f87171 !important;
    }
    [data-bs-theme="dark"] .glass-panel [class*="from-sky-50"],
    [data-bs-theme="dark"] .glass-panel [class*="from-emerald-50"] {
        background-image: none !important;
        background-color: #121212 !important;
        border-color: #333 !important;
    }
    
    /* --- Jadwal Piket & Tabs --- */
    [data-bs-theme="dark"] #capture-area,
    [data-bs-theme="dark"] .toolbar-card {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .main-title,
    [data-bs-theme="dark"] .text-navy {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .table-piket thead th {
        background-color: #121212 !important;
        color: #e0e0e0 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .name-cell {
        background-color: #1a1a1a !important;
        color: #e0e0e0 !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .table-piket td {
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .tab {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
        border: 1px solid #333 !important;
    }
    [data-bs-theme="dark"] .tab.active {
        background-color: #0d1b2a !important; 
        color: #fff !important;
        border-color: #0d1b2a !important;
    }

    /* --- Profile Page --- */
    [data-bs-theme="dark"] .settings-card {
        background: rgba(30, 30, 30, 0.9) !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .settings-card h3,
    [data-bs-theme="dark"] .form-group-modern label {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .back-link {
        color: #aaa !important;
    }
    [data-bs-theme="dark"] .back-link:hover {
        color: #fff !important;
    }
    
    /* --- Setting Page --- */
    [data-bs-theme="dark"] .stat-card,
    [data-bs-theme="dark"] .glass-card {
        background: rgba(30, 30, 30, 0.75) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    [data-bs-theme="dark"] .stat-info h4 {
        color: #aaa !important;
    }
    [data-bs-theme="dark"] .stat-info div {
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .stat-card .stat-info div[style*="color: #c2410c"] {
        color: #fb923c !important;
    }
    [data-bs-theme="dark"] .user-row {
        background: rgba(0, 0, 0, 0.2) !important;
    }
    [data-bs-theme="dark"] .user-row:hover {
        background: rgba(0, 0, 0, 0.4) !important;
    }
    [data-bs-theme="dark"] .user-row .badge.bg-light {
        background-color: #333 !important;
        color: #e0e0e0 !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .role-superadmin { background: rgba(153, 27, 27, 0.2) !important; color: #fca5a5 !important; border-color: rgba(252, 165, 165, 0.3) !important; }
    [data-bs-theme="dark"] .role-admin { background: rgba(7, 89, 133, 0.2) !important; color: #7dd3fc !important; border-color: rgba(125, 211, 252, 0.3) !important; }
    [data-bs-theme="dark"] .role-user { background: rgba(71, 85, 105, 0.2) !important; color: #cbd5e1 !important; border-color: rgba(203, 213, 225, 0.3) !important; }
    [data-bs-theme="dark"] .bg-blue-soft { background: rgba(3, 105, 161, 0.2) !important; color: #7dd3fc !important; }
    [data-bs-theme="dark"] .bg-purple-soft { background: rgba(109, 40, 217, 0.2) !important; color: #c4b5fd !important; }
    [data-bs-theme="dark"] .bg-green-soft { background: rgba(21, 128, 61, 0.2) !important; color: #86efac !important; }
    [data-bs-theme="dark"] .stat-icon[style*="background: #fff7ed"] { background: rgba(194, 65, 12, 0.2) !important; color: #fdba74 !important; }
    
    [data-bs-theme="dark"] .modal-content-premium {
        background: rgba(30, 30, 30, 0.95) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }
    [data-bs-theme="dark"] .form-control-premium {
        background: rgba(0, 0, 0, 0.2) !important;
        border-color: #444 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .form-control-premium:focus {
        background: rgba(0, 0, 0, 0.4) !important;
    }
    
    /* --- Nav Modal (Operational) --- */
    [data-bs-theme="dark"] .nav-modal-content {
        background: rgba(18, 18, 18, 0.95) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 30px 80px -20px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255,255,255,0.05) inset !important;
    }
    [data-bs-theme="dark"] .nav-column {
        background: rgba(30, 30, 30, 0.8) !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .nav-column:hover {
        background: rgba(40, 40, 40, 0.9) !important;
        border-color: #444 !important;
        box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.3) !important;
    }
    [data-bs-theme="dark"] .nav-modal-header p,
    [data-bs-theme="dark"] .nav-column ul li a {
        color: #aaa !important;
    }
    [data-bs-theme="dark"] .nav-column ul li a:hover {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #fff !important;
    }
    [data-bs-theme="dark"] .nav-close {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #aaa !important;
    }
    [data-bs-theme="dark"] .nav-close:hover {
        background-color: #fee2e2 !important;
        color: #ef4444 !important;
    }
    
    /* --- Sticky Cols in Dark Mode --- */
    [data-bs-theme="dark"] .sticky-col,
    [data-bs-theme="dark"] td.sticky-col {
        background-color: #1e1e1e !important;
    }
    [data-bs-theme="dark"] th.sticky-col,
    [data-bs-theme="dark"] thead th.sticky-col {
        background-color: #1a202c !important;
    }

    [data-bs-theme="dark"] table tr:nth-child(even) td,
    [data-bs-theme="dark"] .table-responsive-custom table tr:nth-child(even) td {
        background-color: #252525 !important;
    }
    [data-bs-theme="dark"] table tr:hover td,
    [data-bs-theme="dark"] .table-responsive-custom table tr:hover td {
        background-color: #2c2c2c !important;
    }
    
    /* --- Tabs & Badges Fixes --- */
    [data-bs-theme="dark"] .tab:not(.active) {
        background-color: #2c2c2c !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .summary-badge {
        background-color: #2c2c2c !important;
        border-color: #444 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .summary-badge b {
        color: #fff !important;
    }
    [data-bs-theme="dark"] .text-black,
    [data-bs-theme="dark"] .text-muted {
        color: #e0e0e0 !important;
    }

    /* --- Cards, Layout & Utils --- */
    [data-bs-theme="dark"] .bg-white {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .bg-light {
        background-color: #2c2c2c !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .card-header,
    [data-bs-theme="dark"] .tabs-section {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
    }

    /* --- Search Box --- */
    [data-bs-theme="dark"] .search-box,
    [data-bs-theme="dark"] .search-form,
    [data-bs-theme="dark"] .search-wrapper {
        background: #2c2c2c !important; /* using 'background' to override gradients */
        border-color: #444 !important;
        border-radius: 50px;
    }
    [data-bs-theme="dark"] .search-box input,
    [data-bs-theme="dark"] .search-box button,
    [data-bs-theme="dark"] .search-wrapper input,
    [data-bs-theme="dark"] .search-btn,
    [data-bs-theme="dark"] .filter-btn {
        background: transparent !important;
        color: #e0e0e0 !important;
        border: none !important;
    }
    [data-bs-theme="dark"] .search-box input::placeholder,
    [data-bs-theme="dark"] .search-wrapper input::placeholder {
        color: #888 !important;
    }
    [data-bs-theme="dark"] .filter-btn i,
    [data-bs-theme="dark"] .search-wrapper i {
        color: #e0e0e0 !important;
    }

    /* --- Additional Buttons over gradients --- */
    [data-bs-theme="dark"] .btn-action,
    [data-bs-theme="dark"] .btn-tool {
        background: #2c2c2c !important;
        color: #e0e0e0 !important;
        border-color: #444 !important;
    }


    /* --- Pagination --- */
    [data-bs-theme="dark"] .page-link {
        background-color: #2c2c2c !important;
        border-color: #444 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .page-item.active .page-link {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: #fff !important;
    }
    [data-bs-theme="dark"] .page-item.disabled .page-link {
        background-color: #1e1e1e !important;
        color: #666 !important;
    }

    /* ===================================================
       DARK MODE — GLOBAL COMPREHENSIVE FIXES
       Menutup semua gap di seluruh halaman
    =================================================== */

    /* --- Body & Page Background --- */
    [data-bs-theme="dark"] body {
        background-color: #121212 !important;
        background: #121212 !important;
        color: #e0e0e0 !important;
    }

    /* --- Plain Table (pergantianperangkat, sparetracker, logpergantian) --- */
    [data-bs-theme="dark"] table th,
    [data-bs-theme="dark"] .table-responsive-custom th,
    [data-bs-theme="dark"] table thead tr.thead-dark th {
        background-color: #1a202c !important;
        color: #e0e0e0 !important;
        border-color: #3a4a5c !important;
    }
    [data-bs-theme="dark"] table td {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
        border-color: #2e2e2e !important;
    }
    [data-bs-theme="dark"] table tr:nth-child(even) td,
    [data-bs-theme="dark"] table tr:nth-child(even) {
        background-color: #252525 !important;
    }
    [data-bs-theme="dark"] table tr:hover td {
        background-color: #2a3040 !important;
    }
    [data-bs-theme="dark"] .row-grand-total td {
        background-color: #1a202c !important;
        color: #adb5bd !important;
        border-color: #3a4a5c !important;
    }

    /* --- Sticky Columns (Freeze Panes Fix Overlap) --- */
    [data-bs-theme="dark"] .sticky-col,
    [data-bs-theme="dark"] td.sticky-col {
        background-color: #1e1e1e !important; /* Paksa latar solid di dark mode */
        border-color: #333 !important;
        z-index: 10 !important;
    }
    [data-bs-theme="dark"] tr:nth-child(even) .sticky-col,
    [data-bs-theme="dark"] tr:nth-child(even) td.sticky-col {
        background-color: #252525 !important;
    }
    [data-bs-theme="dark"] tr:hover .sticky-col,
    [data-bs-theme="dark"] tr:hover td.sticky-col {
        background-color: #2a3245 !important;
    }
    [data-bs-theme="dark"] th.sticky-col,
    [data-bs-theme="dark"] thead th.sticky-col {
        background-color: #1a202c !important;
        color: #e0e0e0 !important;
        border-bottom: 2px solid #3a4a5c !important;
        z-index: 30 !important;
    }
    [data-bs-theme="dark"] .col-sitename,
    [data-bs-theme="dark"] .col-nama_site,
    [data-bs-theme="dark"] .col-nama_lokasi,
    [data-bs-theme="dark"] .col-lokasi_site,
    [data-bs-theme="dark"] .col-tanggal_submit {
        border-right: none !important;
        box-shadow: none !important;
    }

    /* --- Card Header (filter bar background) --- */
    [data-bs-theme="dark"] .card-header {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
    }

    /* --- Tabs Section background & border --- */
    [data-bs-theme="dark"] .tabs-section {
        background-color: #121212 !important;
        border-bottom: 1px solid #2c2c2c;
    }
    [data-bs-theme="dark"] .tab {
        background-color: #1e1e1e !important;
        color: #ccc !important;
        border: 1px solid #333 !important;
        box-shadow: none !important;
    }
    [data-bs-theme="dark"] .tab.active,
    [data-bs-theme="dark"] a.tab.active {
        background-color: #1a3a5c !important;
        color: #fff !important;
        border-color: #1a3a5c !important;
    }

    /* --- Summary Badges --- */
    [data-bs-theme="dark"] .summary-badge {
        background-color: #2c2c2c !important;
        border-color: #444 !important;
        color: #ccc !important;
    }
    [data-bs-theme="dark"] .summary-badge b,
    [data-bs-theme="dark"] .summary-badge .text-success { color: #4ade80 !important; }
    [data-bs-theme="dark"] .summary-badge .text-danger  { color: #f87171 !important; }
    [data-bs-theme="dark"] .summary-badge .text-primary { color: #60a5fa !important; }

    /* --- Form Controls (select, input, date) in dark mode --- */
    [data-bs-theme="dark"] .form-select,
    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] input[type="date"],
    [data-bs-theme="dark"] input[type="text"],
    [data-bs-theme="dark"] input[type="number"],
    [data-bs-theme="dark"] input[type="email"],
    [data-bs-theme="dark"] textarea {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .form-select option {
        background-color: #2a2a2a !important;
        color: #e0e0e0 !important;
    }

    /* --- Search Box --- */
    [data-bs-theme="dark"] .search-box {
        background: #2c2c2c !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .search-box input {
        color: #e0e0e0 !important;
        background: transparent !important;
    }
    [data-bs-theme="dark"] .search-box input::placeholder { color: #888 !important; }
    [data-bs-theme="dark"] .search-btn { color: #ccc !important; background: transparent !important; border: none !important; }

    /* --- Buttons (Reset Filter, Action) --- */
    [data-bs-theme="dark"] .btn-light {
        background-color: #2c2c2c !important;
        border-color: #444 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .btn-light:hover {
        background-color: #3a3a3a !important;
        color: #fff !important;
    }
    [data-bs-theme="dark"] .btn-action {
        background: #2c2c2c !important;
        color: #aaa !important;
        border-color: #444 !important;
    }
    [data-bs-theme="dark"] .btn-action:hover {
        background: #3a3a3a !important;
        color: #fff !important;
    }

    /* --- Badge kondisi di tabel (BAIK, RUSAK, BARU, DONE, dll) --- */
    [data-bs-theme="dark"] .badge.bg-success { background-color: #166534 !important; color: #bbf7d0 !important; }
    [data-bs-theme="dark"] .badge.bg-danger  { background-color: #7f1d1d !important; color: #fecaca !important; }
    [data-bs-theme="dark"] .badge.bg-primary { background-color: #1e3a8a !important; color: #bfdbfe !important; }
    [data-bs-theme="dark"] .badge.bg-warning { background-color: #713f12 !important; color: #fde68a !important; }
    [data-bs-theme="dark"] .badge.bg-info    { background-color: #164e63 !important; color: #a5f3fc !important; }
    [data-bs-theme="dark"] .badge.bg-secondary { background-color: #374151 !important; color: #d1d5db !important; }

    /* --- Modal body & footer --- */
    [data-bs-theme="dark"] .modal-body {
        background-color: #1e1e1e !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .modal-footer {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .modal-content {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .modal-header:not([style*="background-color"]) {
        background-color: #111827 !important;
        border-color: #333 !important;
        color: #e0e0e0 !important;
    }
    [data-bs-theme="dark"] .form-label { color: #ccc !important; }

    /* --- Card (card body) --- */
    [data-bs-theme="dark"] .card {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
        box-shadow: 0 8px 30px rgba(0,0,0,0.4) !important;
    }

    /* =======================================================
       GLOBAL PREMIUM PAGINATION (MODERN ROUNDED)
       ======================================================= */
    .pagination-wrapper, .pagination-container {
        display: flex !important;
        flex-wrap: wrap !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 16px 24px !important;
        background: #ffffff !important;
        border-top: 1px solid #f1f5f9 !important;
        border-radius: 0 0 16px 16px !important;
        gap: 15px !important;
        margin-top: 0 !important;
    }

    .table-responsive + .pagination-wrapper,
    .table-responsive-custom + .pagination-wrapper {
        border-top: none !important;
        border-radius: 12px !important;
        margin-top: 15px !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02) !important;
    }

    .pagination-info, .pagination-wrapper p.small {
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #64748b !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    .pagination-info strong, .pagination-wrapper p.small span.fw-semibold {
        font-weight: 700 !important;
        color: #334155 !important;
    }

    .pagination-wrapper nav {
        margin: 0 !important;
        display: flex !important;
        align-items: center !important;
    }

    ul.pagination {
        display: flex !important;
        gap: 6px !important;
        margin: 0 !important;
        padding: 0 !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        border-radius: 0 !important;
    }

    ul.pagination li.page-item {
        margin: 0 !important;
        padding: 0 !important;
        border: none !important;
    }

    ul.pagination li.page-item .page-link,
    ul.pagination li.page-item span.page-link {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 36px !important;
        height: 36px !important;
        padding: 0 10px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #ffffff !important;
        color: #475569 !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        border-radius: 50% !important;
        transition: all 0.3s cubic-bezier(0.23, 1, 0.32, 1) !important;
        box-shadow: none !important;
        text-decoration: none !important;
        line-height: 1 !important;
    }

    ul.pagination li.page-item .page-link:hover:not(.disabled) {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #0f3b56 !important;
        transform: translateY(-2px) !important;
    }

    ul.pagination li.page-item.active .page-link,
    ul.pagination li.page-item.active span.page-link {
        background-color: #2c465d !important;
        border-color: #2c465d !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(44, 70, 93, 0.25) !important;
        font-weight: 700 !important;
        pointer-events: none !important;
        transform: none !important;
    }

    ul.pagination li.page-item.disabled .page-link,
    ul.pagination li.page-item.disabled span.page-link {
        background-color: #fbfbfc !important;
        border-color: #f1f5f9 !important;
        color: #cbd5e1 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
        box-shadow: none !important;
    }

    ul.pagination li.page-item:first-child .page-link,
    ul.pagination li.page-item:last-child .page-link {
        border-radius: 50px !important;
        padding: 0 16px !important;
        min-width: auto !important;
        font-weight: 500 !important;
        color: #64748b !important;
    }
    
    ul.pagination li.page-item:first-child .page-link:hover,
    ul.pagination li.page-item:last-child .page-link:hover {
        color: #0f3b56 !important;
    }

    .pagination-wrapper nav > div.flex.justify-between,
    .pagination-wrapper nav > div.hidden {
        display: none !important;
    }

    @media (max-width: 576px) {
        .pagination-wrapper {
            flex-direction: column !important;
            justify-content: center !important;
            text-align: center !important;
            gap: 12px !important;
        }
    }

    /* Dark Mode Pagination Fixes */
    [data-bs-theme="dark"] .pagination-wrapper { background: #1a1a1a !important; border-color: #333 !important; }
    [data-bs-theme="dark"] .pagination-info { color: #888 !important; }
    [data-bs-theme="dark"] .pagination-info strong { color: #ccc !important; }
    [data-bs-theme="dark"] ul.pagination li.page-item .page-link { background-color: #2c2c2c !important; border-color: #444 !important; color: #ccc !important; }
    [data-bs-theme="dark"] ul.pagination li.page-item .page-link:hover:not(.disabled) { background-color: #3d3d3d !important; border-color: #555 !important; color: #fff !important; }
    [data-bs-theme="dark"] ul.pagination li.page-item.active .page-link { background-color: #0d6efd !important; border-color: #0d6efd !important; box-shadow: 0 4px 10px rgba(13, 110, 253, 0.3) !important; color: #fff !important; }
    [data-bs-theme="dark"] ul.pagination li.page-item.disabled .page-link { background-color: #1e1e1e !important; border-color: #333 !important; color: #666 !important; }

    /* --- Profile Dropdown --- */
    [data-bs-theme="dark"] #profileDropdownMenu {
        background: #1e1e1e !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] #profileDropdownMenu a,
    [data-bs-theme="dark"] #profileDropdownMenu div {
        color: #ccc !important;
    }
    [data-bs-theme="dark"] #profileDropdownMenu a:hover {
        background-color: #2c2c2c !important;
        color: #fff !important;
    }

    /* --- Table-responsive-custom scroll bg --- */
    [data-bs-theme="dark"] .table-responsive-custom {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
    }
    [data-bs-theme="dark"] .table-responsive-custom::-webkit-scrollbar-track { background: #1a1a1a !important; }
    [data-bs-theme="dark"] .table-responsive-custom::-webkit-scrollbar-thumb { background: #444 !important; border-color: #1a1a1a !important; }
</style>
