<div id="navModal" class="nav-modal" onclick="if(event.target === this) closeNavModal()">
    <div class="nav-modal-content">
        <div class="nav-modal-close-wrapper">
            <span class="nav-close" onclick="closeNavModal()">&times;</span>
        </div>
        
        <div class="nav-modal-header">
            <h2>Daftar Halaman Operasional</h2>
            <p>Akses cepat menu manajemen proyek operasional</p>
        </div>

        <div class="nav-modal-body">
            <!-- GROUP 1: SITE MANAGEMENT -->
            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box blue"><i class="bi bi-hdd-network"></i></div>
                    <h3>Data Site</h3>
                </div>
                <ul>
                    <li><a href="{{ route('datasite') }}"><i class="bi bi-geo-alt me-2"></i> Data Site</a></li>
                    <li><a href="{{ route('datapas') }}"><i class="bi bi-shield-lock me-2"></i> Manajemen Password</a></li>
                    <li><a href="{{ route('laporancm') }}"><i class="bi bi-tools me-2"></i> Correctiv Maintenance</a></li>
                    <li><a href="{{ route('pmliberta') }}"><i class="bi bi-shield-check me-2"></i> Preventive Maintenance</a></li>
                    <li><a href="{{ route('summarypm') }}"><i class="bi bi-graph-up me-2"></i> Summary PM</a></li>
                </ul>
            </div>

            <!-- GROUP 2: TICKETING SYSTEM -->
            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box red"><i class="bi bi-ticket-detailed"></i></div>
                    <h3>Tiket</h3>
                </div>
                <ul>
                    <li><a href="{{ route('open.ticket') }}"><i class="bi bi-envelope-open me-2"></i> Open Tiket</a></li>
                    <li><a href="{{ route('close.ticket') }}"><i class="bi bi-envelope-check me-2"></i> Close Tiket</a></li>
                    <li><a href="{{ route('detailticket') }}"><i class="bi bi-file-earmark-text me-2"></i> Detail Tiket</a></li>
                    <li><a href="{{ route('summaryticket') }}"><i class="bi bi-pie-chart me-2"></i> Summary Tiket</a></li>
                </ul>
            </div>

            <!-- GROUP 3: LOG & TRACKER -->
            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box purple"><i class="bi bi-gear-wide-connected"></i></div>
                    <h3>Log Perangkat</h3>
                </div>
                <ul>
                    <li><a href="{{ route('pergantianperangkat') }}"><i class="bi bi-arrow-repeat me-2"></i> Pergantian Perangkat</a></li>
                    <li><a href="{{ route('logpergantian') }}"><i class="bi bi-journal-text me-2"></i> Log Pergantian</a></li>
                    <li><a href="{{ route('sparetracker') }}"><i class="bi bi-box-seam me-2"></i> Spare Tracker</a></li>
                    <li><a href="{{ route('summaryperangkat') }}"><i class="bi bi-bar-chart-steps me-2"></i> Summary Perangkat</a></li>
                </ul>
            </div>

            <!-- GROUP 4: PROJECT MANAGEMENT -->
            <div class="nav-column">
                <div class="column-header">
                    <div class="icon-box green"><i class="bi bi-kanban"></i></div>
                    <h3>Project Info</h3>
                </div>
                <ul>
                    <li><a href="{{ route('todolist') }}"><i class="bi bi-check2-square me-2"></i> My Todo List</a></li>
                    @if(auth()->check() && auth()->user()->role === 'superadmin')
                        <li><a href="{{ route('jadwalpiket') }}"><i class="bi bi-calendar-event me-2"></i> Jadwal Piket</a></li>
                    @endif
                @if(auth()->check() && auth()->user()->role === 'superadmin')
                    <li><a href="{{ route('remotelog') }}"><i class="bi bi-shield-lock me-2"></i> Log Remote</a></li>
                @endif
                </ul>
            </div>
            
        </div>
    </div>
</div>

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
            const metaCsrf = document.querySelector('meta[name="csrf-token"]');
            csrfToken.value = metaCsrf ? metaCsrf.getAttribute('content') : "{{ csrf_token() }}";
            
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