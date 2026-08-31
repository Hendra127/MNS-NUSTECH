<!-- MODAL HISTORY - Vanilla JS, no jQuery dependency -->
<div class="modal fade" id="modalHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header text-white d-flex justify-content-center position-relative"
                style="background-color: #071152; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title w-100 text-center fw-bold">
                    <i class="bi bi-clock-history"></i> History SN: <span id="historySnTitle"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" style="background-color: #f8f9fa; min-height: 200px;">
                <div id="historyLoading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 mb-0 text-muted">Memuat history...</p>
                </div>
                <div id="historyContent" style="display:none;">
                    <div class="timeline" id="historyTimeline"></div>
                </div>
                <div id="historyEmpty" style="display:none;" class="text-center py-4 text-muted">
                    <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                    <p class="mt-2 mb-0">Tidak ada data history untuk SN ini.</p>
                </div>
                <div id="historyError" style="display:none;" class="text-center py-4 text-danger">
                    <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem;"></i>
                    <p class="mt-2 mb-0">Gagal memuat data history.</p>
                </div>
            </div>
            <div class="modal-footer border-0 bg-transparent">
                <button type="button" class="btn btn-light rounded-pill px-4 border" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 3rem;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 14px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}
.timeline-item {
    position: relative;
    margin-bottom: 1.25rem;
}
.timeline-item:last-child { margin-bottom: 0; }
.timeline-icon {
    position: absolute;
    left: -3rem;
    top: 4px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #fff;
    border: 2px solid #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    z-index: 1;
}
.timeline-content {
    background: #fff;
    padding: 0.85rem 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    border: 1px solid #e9ecef;
}
.timeline-date {
    font-size: 0.78rem;
    color: #6c757d;
    margin-bottom: 0.3rem;
    display: block;
}
.timeline-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: #212529;
    margin-bottom: 0.25rem;
}
.timeline-desc {
    font-size: 0.88rem;
    color: #495057;
    margin-bottom: 0.4rem;
}
.timeline-meta {
    font-size: 0.78rem;
    color: #6c757d;
    background: #f8f9fa;
    padding: 0.3rem 0.6rem;
    border-radius: 0.25rem;
    display: inline-block;
    gap: 4px;
}
/* color variants for icon border */
.tl-icon-success { border-color: #198754; color: #198754; }
.tl-icon-warning { border-color: #fd7e14; color: #fd7e14; }
.tl-icon-info    { border-color: #0dcaf0; color: #0dcaf0; }
.tl-icon-danger  { border-color: #dc3545; color: #dc3545; }
.tl-icon-primary { border-color: #0d6efd; color: #0d6efd; }
</style>

<script>
function showHistory(sn) {
    if (!sn || sn.trim() === '' || sn === '-') {
        alert('SN tidak valid.');
        return;
    }

    // Reset state
    document.getElementById('historySnTitle').textContent = sn;
    document.getElementById('historyLoading').style.display = 'block';
    document.getElementById('historyContent').style.display = 'none';
    document.getElementById('historyEmpty').style.display = 'none';
    document.getElementById('historyError').style.display = 'none';
    document.getElementById('historyTimeline').innerHTML = '';

    // Show modal using Bootstrap 5 JS API
    var modalEl = document.getElementById('modalHistory');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    modal.show();

    // Fetch history data
    fetch('/sparetracker/history/' + encodeURIComponent(sn), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(function(response) {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    })
    .then(function(data) {
        document.getElementById('historyLoading').style.display = 'none';

        if (!data || data.length === 0) {
            document.getElementById('historyEmpty').style.display = 'block';
            return;
        }

        document.getElementById('historyContent').style.display = 'block';
        var html = '';

        data.forEach(function(item) {
            var date = new Date(item.created_at).toLocaleString('id-ID', {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });

            var user = (item.user && item.user.name) ? item.user.name : 'System';
            var aksi = (item.aksi || '').replace(/_/g, ' ').toUpperCase();
            var keterangan = item.keterangan || '-';
            var statusBaru = item.status_baru || '-';
            var kondisiBaru = item.kondisi_baru || '-';

            // Determine icon + color based on action
            var icon = 'bi-record-circle';
            var iconClass = 'tl-icon-primary';

            var aksiLow = (item.aksi || '').toLowerCase();
            if (aksiLow.includes('pengadaan') || aksiLow.includes('tambah')) {
                icon = 'bi-box-seam'; iconClass = 'tl-icon-success';
            } else if (aksiLow.includes('dikirim')) {
                icon = 'bi-truck'; iconClass = 'tl-icon-warning';
            } else if (aksiLow.includes('diterima') || aksiLow.includes('terpasang')) {
                icon = 'bi-check2-circle'; iconClass = 'tl-icon-info';
            } else if (aksiLow.includes('repair')) {
                icon = 'bi-tools'; iconClass = 'tl-icon-danger';
            }

            html += '<div class="timeline-item">'
                + '<div class="timeline-icon ' + iconClass + '"><i class="bi ' + icon + '"></i></div>'
                + '<div class="timeline-content">'
                + '<span class="timeline-date"><i class="bi bi-calendar3"></i> ' + date + '</span>'
                + '<div class="timeline-title">' + aksi + '</div>'
                + '<div class="timeline-desc">' + keterangan + '</div>'
                + '<span class="timeline-meta">'
                + '<i class="bi bi-person"></i> ' + user
                + ' &nbsp;|&nbsp; <i class="bi bi-arrow-right-circle"></i> Status: ' + statusBaru
                + ' &nbsp;|&nbsp; <i class="bi bi-info-square"></i> Kondisi: ' + kondisiBaru
                + '</span>'
                + '</div></div>';
        });

        document.getElementById('historyTimeline').innerHTML = html;
    })
    .catch(function() {
        document.getElementById('historyLoading').style.display = 'none';
        document.getElementById('historyError').style.display = 'block';
    });
}
</script>
