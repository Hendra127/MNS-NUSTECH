<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Database All Sites</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v={{ filemtime(public_path('css/password.css')) }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .status-badge {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: bold;
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
        .filter-btn i {
            color: #555;
            font-size: 1.1rem;
            cursor: pointer;
        }
        .tabs-section {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            .search-form {
                width: 100%;
            }
            .search-box {
                width: 100%;
            }
            .search-box input {
                width: 100%;
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
                            <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ Storage::url(auth()->user()->photo) }}" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
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
    <div class="tabs-section">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*', 'sites*') ? 'active' : '' }}" style="text-decoration: none;">All Sites</a>
        <a href="{{ route('datapas') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}" style="text-decoration: none;">Management Password</a>
        <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}" style="text-decoration: none;">Correctiv Maintenance</a>
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}" style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}" style="text-decoration: none;">PM Summary</a>
    </div>
    <!-- CARD -->
    <div class="card">
        <div class="card-header">
            <div class="actions">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Add" data-toggle="modal" data-target="#modalSite" onclick="addSite()"></button>
                    <form action="{{ route('sites.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" accept=".xlsx, .xls, .csv" onchange="this.form.submit()">
                        <button type="button" class="btn-action bi bi-upload" title="Upload" onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
               <a href="{{ route('sites.export', ['search' => request('search')]) }}" 
               <a href="{{ route('sites.export', ['search' => request('search')]) }}" 
                    class="btn-action bi bi-download" 
                    title="Download" 
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>
            <form method="GET" action="{{ route('datasite') }}" class="search-form">
                <div class="search-box d-flex align-items-center">
                    <button type="button" class="filter-btn" data-bs-toggle="modal" data-bs-target="#modalFilter" style="background: none; border: none; padding-left: 15px;">
                        <i class="bi bi-sliders2"></i> </button>
                    <input type="text" id="searchInput" name="q" placeholder="Search..." value="{{ request('q') }}" style="flex-grow: 1; border: none; outline: none;">
                    <button type="submit" class="search-btn">🔍</button>
                </div>
            </form>
        </div>
        <div class="table-responsive-custom" style="overflow-x: auto; max-width: 100%;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="sticky-col col-no">NO</th>
                        <th class="sticky-col col-site-id">SITE ID</th>
                        <th class="sticky-col col-sitename">SITENAME</th>
                        <th>TIPE</th>
                        <th>BATCH</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th>
                        <th>PROVINSI</th>
                        <th>KABUPATEN</th>
                        <th>KECAMATAN</th>
                        <th>KELURAHAN</th>
                        <th>ALAMAT LOKASI</th>
                        <th>NAMA PIC</th>
                        <th>NOMOR PIC</th>
                        <th>SUMBER LISTRIK</th>
                        <th>GATEWAY AREA</th>
                        <th>BEAM</th>
                        <th>HUB</th>
                        <th>KODEFIKASI</th>
                        <th>SN ANTENA</th>
                        <th>SN MODEM</th>
                        <th>SN ROUTER</th>
                        <th>SN AP1</th>
                        <th>SN AP2</th>
                        <th>SN TRANSCIEVER</th>
                        <th>SN STABILIZER</th>
                        <th>SN RAK</th>
                        <th>IP MODEM</th>
                        <th>IP ROUTER</th>
                        <th>IP AP1</th>
                        <th>IP AP2</th>
                        <th>EXPECTED SQF</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th>AKSI</th>
                        @endif
                    </tr>
                </thead>
            <tbody>
                @forelse($sites as $index => $site)
                    <tr>
                        <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                        <td class="sticky-col col-site-id">{{ $site->site_id }}</td>
                        <td class="sticky-col col-sitename">{{ $site->sitename }}</td>
                        <td>{{ $site->tipe }}</td>
                        <td>{{ $site->batch }}</td>
                        <td>{{ $site->latitude }}</td>
                        <td>{{ $site->longitude }}</td>
                        <td>{{ $site->provinsi }}</td>
                        <td>{{ $site->kab }}</td>
                        <td>{{ $site->kecamatan }}</td>
                        <td>{{ $site->kelurahan }}</td>
                        <td>{{ $site->alamat_lokasi }}</td>
                        <td>{{ $site->nama_pic }}</td>
                        <td>{{ $site->nomor_pic }}</td>
                        <td>{{ $site->sumber_listrik }}</td>
                        <td>{{ $site->gateway_area }}</td>
                        <td>{{ $site->beam }}</td>
                        <td>{{ $site->hub }}</td>
                        <td>{{ $site->kodefikasi }}</td>
                        <td>{{ $site->sn_antena }}</td>
                        <td>{{ $site->sn_modem }}</td>
                        <td>{{ $site->sn_router }}</td>
                        <td>{{ $site->sn_ap1 }}</td>
                        <td>{{ $site->sn_ap2 }}</td>
                        <td>{{ $site->sn_tranciever }}</td>
                        <td>{{ $site->sn_stabilizer }}</td>
                        <td>{{ $site->sn_rak }}</td>
                        <td>{{ $site->ip_modem }}</td>
                        <td>{{ $site->ip_router }}</td>
                        <td>{{ $site->ip_ap1 }}</td>
                        <td>{{ $site->ip_ap2 }}</td>
                        <td>{{ $site->expected_sqf }}</td>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                        <td>
                            <div class="btn-group" role="group">
                                {{-- JANGAN pakai <a> ke route edit, tapi pakai button onclick --}}
                                <button type="button" class="btn btn-sm bi bi-pencil" onclick="editSite({{ $site->toJson() }})"></button>
                                <form action="{{ route('sites.destroy', $site->site_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" 
                                            class="btn btn-sm bi bi-trash btn-delete" 
                                            data-name="{{ $site->sitename }}">
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                        <tr><td colspan="33" class="text-center">Data tidak ditemukan.</td></tr>
                    @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">
        {{ $sites->links('pagination::bootstrap-5') }}
    </div>
</div>
<script>
    @if(session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger mt-2">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</script>
<!-- MODAL ADD DATA -->
<div class="modal fade" id="modalSite" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center" id="modalTitle">Form Data Site</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formSite" method="POST">
                @csrf
                <div id="methodField"></div>
                <div class="modal-body">
                    <ul class="nav nav-tabs mb-3" id="siteTab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab1">General</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab2">Lokasi & PIC</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab3">Hardware SN</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab4">Network</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab1">
                            <div class="row">
                                <div class="col-md-4"><label>SITE ID</label><input type="text" name="site_id" id="site_id" class="form-control mb-2" required></div>
                                <div class="col-md-4"><label>SITE NAME</label><input type="text" name="sitename" id="sitename" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>TIPE</label><input type="text" name="tipe" id="tipe" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>BATCH</label><input type="text" name="batch" id="batch" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>KODEFIKASI</label><input type="text" name="kodefikasi" id="kodefikasi" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SUMBER LISTRIK</label><input type="text" name="sumber_listrik" id="sumber_listrik" class="form-control mb-2"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab2">
                            <div class="row">
                                <div class="col-md-3"><label>LATITUDE</label><input type="text" name="latitude" id="latitude" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>LONGITUDE</label><input type="text" name="longitude" id="longitude" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>PROVINSI</label><input type="text" name="provinsi" id="provinsi" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>KABUPATEN</label><input type="text" name="kab" id="kab" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>KECAMATAN</label><input type="text" name="kecamatan" id="kecamatan" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>KELURAHAN</label><input type="text" name="kelurahan" id="kelurahan" class="form-control mb-2"></div>
                                <div class="col-md-6"><label>ALAMAT LOKASI</label><input type="text" name="alamat_lokasi" id="alamat_lokasi" class="form-control mb-2"></div>
                                <div class="col-md-6"><label>NAMA PIC</label><input type="text" name="nama_pic" id="nama_pic" class="form-control mb-2"></div>
                                <div class="col-md-6"><label>NOMOR PIC</label><input type="text" name="nomor_pic" id="nomor_pic" class="form-control mb-2"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab3">
                            <div class="row">
                                <div class="col-md-4"><label>SN ANTENA</label><input type="text" name="sn_antena" id="sn_antena" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN MODEM</label><input type="text" name="sn_modem" id="sn_modem" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN ROUTER</label><input type="text" name="sn_router" id="sn_router" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN AP1</label><input type="text" name="sn_ap1" id="sn_ap1" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN AP2</label><input type="text" name="sn_ap2" id="sn_ap2" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN TRANSCIEVER</label><input type="text" name="sn_tranciever" id="sn_tranciever" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN STABILIZER</label><input type="text" name="sn_stabilizer" id="sn_stabilizer" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>SN RAK</label><input type="text" name="sn_rak" id="sn_rak" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>HUB</label><input type="text" name="hub" id="hub" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>BEAM</label><input type="text" name="beam" id="beam" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>GATEWAY AREA</label><input type="text" name="gateway_area" id="gateway_area" class="form-control mb-2"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab4">
                            <div class="row">
                                <div class="col-md-3"><label>IP MODEM</label><input type="text" name="ip_modem" id="ip_modem" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>IP ROUTER</label><input type="text" name="ip_router" id="ip_router" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>IP AP1</label><input type="text" name="ip_ap1" id="ip_ap1" class="form-control mb-2"></div>
                                <div class="col-md-3"><label>IP AP2</label><input type="text" name="ip_ap2" id="ip_ap2" class="form-control mb-2"></div>
                                <div class="col-md-4"><label>EXPECTED SQF</label><input type="text" name="expected_sqf" id="expected_sqf" class="form-control mb-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFilter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-white d-flex justify-content-center position-relative" style="background-color: #071152;">
                <h5 class="modal-title w-100 text-center">Filter Data Site</h5>
                <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="{{ route('datasite') }}"> 
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold">Tipe</label>
                            <select name="tipe" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="BARANG MILIK NEGARA (BMN)" {{ request('tipe') == 'BARANG MILIK NEGARA (BMN)' ? 'selected' : '' }}>BMN</option>
                                <option value="SEWA LAYANAN" {{ request('tipe') == 'SEWA LAYANAN' ? 'selected' : '' }}>SL</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control" placeholder="Nama Provinsi..." value="{{ request('provinsi') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold">Kabupaten</label>
                            <input type="text" name="kab" class="form-control" placeholder="Nama Kabupaten..." value="{{ request('kab') }}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('datasite') }}" class="btn btn-light border">Reset</a>
                    <button type="submit" class="btn btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- Script untuk handling modal dan SweetAlert --}}
<script>
    $(document).ready(function() {
        // PERBAIKAN: SweetAlert Session (Tanpa HTML di dalam script)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Input',
                text: "{{ $errors->first() }}"
            });
        @endif
    });
    // Fungsi Tambah Data
    function addSite() {
        $('#modalTitle').text('Tambah Data Site Baru');
        $('#formSite').attr('action', "{{ route('sites.store') }}");
        $('#methodField').empty(); 
        $('#formSite')[0].reset();
        $('#modalSite').modal('show');
    }
    // Fungsi Edit Data
    function editSite(data) {
        $('#modalTitle').text('Edit Site: ' + data.site_id);
        $('#formSite').attr('action', "/sites/" + data.site_id);
        $('#methodField').html('@method("PUT")');
        Object.keys(data).forEach(key => {
            $(`#${key}`).val(data[key]);
        });
        $('#modalSite').modal('show');
    }
</script>
{{-- Script untuk auto-submit form pencarian dengan debounce --}}
<script>
    $(document).ready(function() {
    let timeout = null;
    $('#search-input').on('keyup', function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            // Submit form secara otomatis
            $('#search-form').submit();
        }, 100); // Jeda 800ms setelah berhenti mengetik
    });
    // Opsional: Posisikan kursor di akhir teks setelah reload
    const input = $('#search-input');
    const val = input.val();
    if (val) {
        input.focus().val('').val(val);
    }
});
</script>
{{-- Script untuk konfirmasi hapus dengan SweetAlert --}}
<script>
    $(document).ready(function() {
        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            // Ambil nama dari atribut data-name
            let siteName = $(this).data('name'); 
            Swal.fire({
                title: 'Apakah Anda yakin?',
                // Masukkan variabel siteName ke dalam teks
                html: `Data site <b>${siteName}</b> akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
</body>
</html>

