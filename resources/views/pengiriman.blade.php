<!DOCTYPE html>
<html lang="id">
<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/pergantianperangkat.css') }}?v=1.2">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengiriman Sparepart | Project Operational</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .tabs-section {
            flex-wrap: wrap;
            gap: 10px;
        }
        .summary-badge {
            font-size: 12px;
            padding: 5px 15px;
            border-radius: 50px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            margin-right: 10px;
        }
        .search-box {
            display: flex;
            align-items: center;
        }
        .search-box input {
            border: none;
            outline: none;
            padding: 20px;
            background: transparent;
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
            @if(auth()->check() && auth()->user()->hasAdminAccess())
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                <div id="profileDropdownMenu" class="hidden" style="position: absolute; right: 0; top: 100%; mt: 10px; width: 150px; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 1000; display: none; flex-direction: column; overflow: hidden;">
                    <div style="padding: 10px 15px; border-bottom: 1px solid #eee; font-size: 14px; font-weight: bold; color: #333;">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <a href="{{ route('profile.edit') }}" style="padding: 10px 15px; text-decoration: none; color: #333; font-size: 14px; display: flex; align-items: center; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#f5f5f5'" onmouseout="this.style.backgroundColor='transparent'">
                        <i class="bi bi-person me-2"></i> Profile
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section d-flex align-items-center">
        <a href="{{ route('pergantianperangkat') }}" class="tab {{ request()->is('pergantianperangkat*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Pergantian Perangkat</a>
        <a href="{{ url('/logpergantian') }}" class="tab {{ request()->is('logpergantian*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Log Perangkat</a>
        <a href="{{ url('/sparetracker') }}" class="tab {{ request()->is('sparetracker*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Spare Tracker</a>
        <a href="{{ url('/pengiriman') }}" class="tab {{ request()->is('pengiriman*') ? 'active' : '' }}" style="text-decoration: none; color: White;">Pengiriman</a>
        <a href="{{ url('/pm-summary') }}" class="tab {{ request()->is('pm-summary*') ? 'active' : '' }}" style="text-decoration: none; color: Black;">Summary</a>
    </div>

    <!-- CONTENT -->
    <div class="content-container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <h5 class="fw-bold mb-0"><i class="bi bi-truck"></i> Data Pengiriman Sparepart</h5>
            <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambahPengiriman">
                <i class="bi bi-plus-circle"></i> Tambah Pengiriman
            </button>
        </div>

        <!-- MODAL TAMBAH PENGIRIMAN -->
        <div class="modal fade" id="modalTambahPengiriman" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 border-0 shadow-lg">
                    <div class="modal-header text-white d-flex justify-content-center position-relative"
                        style="background-color: #0d6efd; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title w-100 text-center fw-bold">Tambah Data Pengiriman</h5>
                        <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                            data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-4">
                        <form action="{{ route('pengiriman.store') }}" method="POST">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Nama Ekspedisi
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="ekspedisi" required class="form-control" placeholder="Contoh: JNE, J&T, SiCepat">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">No Resi
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="no_resi" required class="form-control" placeholder="Masukkan nomor resi">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">SN Perangkat
                                        <span class="text-danger">*</span></label>
                                    <input type="text" name="sn_perangkat" required class="form-control" list="sn-list" placeholder="Ketik manual atau pilih SN yang ada...">
                                    <datalist id="sn-list">
                                        @foreach($sparetrackers as $st)
                                            <option value="{{ $st->sn }}">{{ $st->sn }} - {{ $st->nama_perangkat }}</option>
                                        @endforeach
                                    </datalist>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Site Tujuan
                                        <span class="text-danger">*</span></label>
                                    <select name="site_id" required class="form-select">
                                        <option value="">-- Pilih Site Tujuan --</option>
                                        @foreach($sites as $s)
                                            <option value="{{ $s->site_id }}">{{ $s->site_id }} - {{ $s->sitename }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Tanggal Pengiriman</label>
                                    <input type="date" name="tanggal_pengiriman" class="form-control" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Klasifikasi</label>
                                    <select name="klasifikasi" class="form-select">
                                        <option value="BMN">BMN (Barang Milik Negara)</option>
                                        <option value="SL">SL (Sewa Layanan)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Nama Pengirim</label>
                                    <input type="text" name="nama_pengirim" class="form-control" placeholder="Nama pengirim">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Nama Penerima</label>
                                    <input type="text" name="nama_penerima" class="form-control" placeholder="Nama penerima">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Kab/Kota Pengirim</label>
                                    <input type="text" name="kabkota_pengirim" class="form-control" placeholder="Kab/Kota pengirim">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Kab/Kota Penerima</label>
                                    <input type="text" name="kabkota_penerima" class="form-control" placeholder="Kab/Kota penerima">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Biaya Pengiriman</label>
                                    <input type="number" name="biaya_pengiriman" class="form-control" placeholder="Contoh: 50000">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label" style="font-size: 0.85rem; font-weight: 600;">Keterangan <i>(Opsional)</i></label>
                                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan..." class="form-control"></textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-light px-4 rounded-3 border" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4 rounded-3">Simpan & Update Sparetracker</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABLE DATA -->
        <div class="table-responsive-custom">
            <table class="table table-bordered table-hover">
                <thead style="background-color: #f5f6fa;">
                    <tr>
                        <th class="text-center" style="width: 50px;">NO</th>
                        <th>TANGGAL PENGIRIMAN</th>
                        <th>EKSPEDISI</th>
                        <th>NO RESI</th>
                        <th>SN PERANGKAT</th>
                        <th>KLASIFIKASI</th>
                        <th>SITE TUJUAN</th>
                        <th>PENGIRIM</th>
                        <th>PENERIMA</th>
                        <th>BIAYA PENGIRIMAN</th>
                        <th class="text-center">STATUS</th>
                        <th>KETERANGAN</th>
                        <th class="text-center" style="width: 100px;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengirimans as $i => $p)
                        <tr>
                            <td class="text-center">{{ $pengirimans->firstItem() + $i }}</td>
                            <td>{{ $p->tanggal_pengiriman ? \Carbon\Carbon::parse($p->tanggal_pengiriman)->format('d M Y') : '-' }}</td>
                            <td>{{ $p->ekspedisi }}</td>
                            <td><span class="badge bg-light text-dark border">{{ $p->no_resi }}</span></td>
                            <td><code>{{ $p->sn_perangkat }}</code></td>
                            <td>
                                @if($p->klasifikasi === 'BMN')
                                    <span class="badge bg-info text-dark">BMN</span>
                                @elseif($p->klasifikasi === 'SL')
                                    <span class="badge bg-secondary text-white">SL</span>
                                @else
                                    {{ $p->klasifikasi ?? '-' }}
                                @endif
                            </td>
                            <td>
                                @if($p->site)
                                    {{ $p->site->site_id }} - {{ $p->site->sitename }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $p->nama_pengirim ?? '-' }}</div>
                                <small class="text-muted">{{ $p->kabkota_pengirim ?? '-' }}</small>
                            </td>
                            <td>
                                <div>{{ $p->nama_penerima ?? '-' }}</div>
                                <small class="text-muted">{{ $p->kabkota_penerima ?? '-' }}</small>
                            </td>
                            <td>
                                {{ $p->biaya_pengiriman ? 'Rp ' . number_format($p->biaya_pengiriman, 0, ',', '.') : '-' }}
                            </td>
                            <td class="text-center">
                                @if($p->status === 'Dalam Pengiriman')
                                    <span class="badge bg-warning text-dark">{{ $p->status }}</span>
                                @elseif($p->status === 'Diterima')
                                    <span class="badge bg-success">{{ $p->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                            <td class="text-center">
                                @if($p->status === 'Dalam Pengiriman')
                                    <form action="{{ route('pengiriman.terima', $p->id) }}" method="POST" class="d-inline form-terima">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                            <i class="bi bi-check-circle"></i> Terima
                                        </button>
                                    </form>
                                @else
                                    <span class="text-success"><i class="bi bi-check2-all"></i> Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mt-2">Belum ada data pengiriman.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $pengirimans->links() }}
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-terima').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Diterima',
                    text: 'Apakah Anda yakin barang kiriman ini sudah diterima di site tujuan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Diterima!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false
        });
    </script>
    @endif
    @include('components.nav-modal-structure')
</body>
</html>
