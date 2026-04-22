<!DOCTYPE html>
<html>

<head>
    @include('partials.pwa-head')
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logonustech.png') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/password.css') }}?v=3.0">
    <link rel="stylesheet" href="{{ asset('css/nav-modal.css') }}?v=1.1">
    <script src="{{ asset('js/nav-modal.js') }}"></script>
    <script src="{{ asset('js/profile-dropdown.js') }}"></script>
    @include('components.nav-modal-structure')
    <title>Management Pass</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .tabs-section {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .search-form,
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
            <a href="javascript:void(0)" class="header-brand-link" onclick="openNavModal()"
                style="text-decoration: none !important; color: white !important;">
                <div class="header-brand" style="display: flex; align-items: center; gap: 8px; font-weight: bold;">
                    Project <span style="opacity: 0.5;">|</span> Operational
                </div>
            </a>
        </div>
        <div class="d-flex align-items-center gap-3">
            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                <a href="{{ route('setting.index') }}" class="text-white opacity-75 hover-opacity-100" title="Settings">
                    <i class="bi bi-gear-fill" style="font-size: 1.3rem;"></i>
                </a>
            @endif
            <div class="user-profile-wrapper" style="position: relative;">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <a href="{{ route('setting.index') }}" class="user-profile-icon" title="Setting User"
                        style="cursor: pointer; text-decoration: none; color: inherit;">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </a>
                @else
                    <div class="user-profile-icon" id="profileDropdownTrigger" style="cursor: pointer;">
                        @if(auth()->check() && auth()->user()->photo)
                            <img src="{{ asset('storage_public/' . auth()->user()->photo) }}" alt="Profile"
                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
                        @endif
                    </div>
                @endif
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
                            style="width: 100%; text-align: left; padding: 10px 15px; background: none; border: none; font-size: 14px; color: #dc3545; cursor: pointer;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="tabs-section">
        <a href="{{ route('datasite') }}" class="tab {{ request()->is('datasite*', 'sites*') ? 'active' : '' }}"
            style="text-decoration: none;">All Sites</a>
        <a href="{{ route('datapas') }}" class="tab {{ request()->is('datapass*') ? 'active' : '' }}"
            style="text-decoration: none;">Management Password</a>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
            <a href="{{ route('laporancm') }}" class="tab {{ request()->is('laporancm*') ? 'active' : '' }}"
                style="text-decoration: none;">Correctiv Maintenance</a>
        @endif
        <a href="{{ route('pmliberta') }}" class="tab {{ request()->is('PMLiberta*') ? 'active' : '' }}"
            style="text-decoration: none;">Preventive Maintenance</a>
        <a href="{{ route('summarypm') }}" class="tab {{ request()->is('summarypm*') ? 'active' : '' }}"
            style="text-decoration: none;">Summary PM</a>
    </div>
    <!-- CONTENT -->
    <div class="content-container">
        <div class="card-header d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3" style="margin-bottom: 20px;">
            <div class="actions flex-shrink-0">
                @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <button type="button" class="btn-action bi bi-plus" title="Add" data-toggle="modal"
                        data-target="#modalSite" onclick="addSite()"></button>
                    <form action="{{ route('datapas.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm" class="m-0">
                        @csrf
                        <input type="file" name="file" id="fileInput" style="display: none;" accept=".xlsx, .xls, .csv"
                            onchange="handleFileUpload()">
                        <button type="button" class="btn-action bi bi-upload" title="Upload"
                            onclick="document.getElementById('fileInput').click();">
                        </button>
                    </form>
                @endif
                <a href="{{ route('datapas.export', ['search' => request('search')]) }}"
                    class="btn-action bi bi-download" title="Download"
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                </a>
            </div>
            <div class="w-100 mt-2 mt-lg-0 d-flex justify-content-lg-end">
                <form method="GET" action="{{ route('datapas') }}" class="search-form row g-2 align-items-center m-0" id="search-form">
                    <div class="col-12 col-md-auto">
                        <div class="search-box d-flex align-items-center w-100">
                            <input type="text" name="search" id="search-input" placeholder="Search"
                                value="{{ request('search') }}" autocomplete="off" style="flex-grow: 1; border: none; outline: none; padding-left: 15px;">
                            <button type="submit" class="search-btn">🔍</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive-custom">
            <table>
                <thead>
                    <tr>
                        <th class="sticky-col col-no">No</th>
                        <th class="sticky-col col-site-id">Nama Lokasi</th>
                        <th>Kabupaten</th>
                        <th>ADOP</th>
                        <th>PASS AP1</th>
                        <th>PASS AP2</th>
                        @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <th class="sticky-col-right">Aksi</th>
                        @elseif(auth()->check() && auth()->user()->role === 'user')
                            <th class="sticky-col-right">Info</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($datapass as $row)
                        <tr>
                            <td class="text-center sticky-col col-no">{{ $loop->iteration }}</td>
                            <td class="sticky-col col-site-id">{{ $row->nama_lokasi }}</td>
                            <td>{{ $row->kabupaten }}</td>
                            <td class="text-center">{{ $row->adop }}</td>
                            <td>{{ $row->pass_ap1 }}</td>
                            <td>{{ $row->pass_ap2 }}</td>
                            @if(auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                <td class="text-center sticky-col-right">
                                    <button class="btn btn-sm bi bi-pencil" onclick="editData({{ json_encode($row) }})"
                                        title="Edit">
                                    </button>
                                    <button type="button" class="btn btn-sm bi bi-trash btn-delete" data-id="{{ $row->id }}"
                                        data-nama="{{ $row->nama_lokasi }}" title="Delete">
                                    </button>
                                    <form id="delete-form-{{ $row->id }}" action="{{ route('datapas.destroy', $row->id) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            @elseif(auth()->check() && auth()->user()->role === 'user')
                                <td class="text-center sticky-col-right">
                                    <button class="btn btn-sm bi bi-info-circle" onclick="viewInfo({{ json_encode($row) }})"
                                        title="Info">
                                    </button>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Showing {{ $datapass->firstItem() ?? 0 }} to {{ $datapass->lastItem() ?? 0 }} 
                of&nbsp;<strong>{{ $datapass->total() }}</strong>&nbsp;results
            </span>
            <nav>
                {{ $datapass->appends(request()->query())->links("pagination::bootstrap-5") }}
            </nav>
        </div>
    </div>
    {{-- Modal Add New Data --}}
    <div class="modal" id="addDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg"> {{-- Menggunakan ukuran besar agar proporsional --}}
            <div class="modal-content border-0 shadow-lg">
                {{-- Modal Header --}}
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title p-1 text-center w-100">
                        <i class="bi bi-plus-circle me-2"></i>Add New Management Password
                    </h5>
                    <button type="button" class="btn-close btn-close-white" onclick="closeM('addDataModal')"
                        aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <form method="POST" action="{{ route('datapas.store') }}">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            {{-- Baris 1: Dropdown Site (Full Width) --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">Pilih Site</label>
                                <select name="site_id" class="form-select shadow-sm" required>
                                    <option value="" disabled selected>-- Pilih Site --</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->site_id }} - {{ $site->sitename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Baris 2: Nama Lokasi & Kabupaten --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lokasi</label>
                                <input type="text" name="nama_lokasi" class="form-control"
                                    placeholder="Contoh: Jakarta Pusat" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kabupaten</label>
                                <input type="text" name="kabupaten" class="form-control"
                                    placeholder="Masukkan Kabupaten" required>
                            </div>
                            {{-- Baris 3: ADOP & PASS AP1 --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">ADOP</label>
                                <input type="text" name="adop" class="form-control" placeholder="Nama ADOP" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">PASS AP1</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                    <input type="text" name="pass_ap1" class="form-control" placeholder="Password AP1"
                                        required>
                                </div>
                            </div>
                            {{-- Baris 4: PASS AP2 (Setengah Lebar) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">PASS AP2</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                                    <input type="text" name="pass_ap2" class="form-control" placeholder="Password AP2"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Footer --}}
                    <div class="modal-footer bg-light text-end">
                        <button type="button" class="btn btn-secondary px-4"
                            onclick="closeM('addDataModal')">Batal</button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-lg me-2"></i>Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal Upload Excel --}}
    <div class="modal" id="uploadModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeM('uploadModal')">&times;</span>
            <h2>Upload Excel Data</h2>
            <form method="POST" action="{{ route('datapas.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label>Pilih File Excel (.xlsx)</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Import</button>
            </form>
        </div>
    </div>
    {{-- Modal Edit Data --}}
    <div class="modal" id="editDataModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                {{-- Modal Header --}}
                <div class="modal-header bg-primary text-white d-flex align-items-center position-relative">
                    {{-- text-center dan w-100 memastikan judul mengambil ruang penuh dan berada di tengah --}}
                    <h5 class="modal-title p-1 text-center w-100">
                        <i class="bi bi-pencil me-2"></i>Edit Management Password
                    </h5>
                    {{-- position-absolute dan end-0 memindahkan tombol close agar tidak memakan ruang layout --}}
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3"
                        onclick="closeM('editDataModal')" aria-label="Close"></button>
                </div>
                {{-- Modal Body --}}
                <form id="editForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="row g-3"> {{-- Menggunakan Grid Bootstrap --}}
                            {{-- Baris 1: Full Width --}}
                            <div class="col-12">
                                <label class="form-label fw-bold">Pilih Site</label>
                                <select name="site_id" id="edit_site_id" class="form-select select2" required>
                                    <option value="" disabled selected>-- Pilih Site --</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}">{{ $site->site_id }} - {{ $site->sitename }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Baris 2: Kolom Kiri & Kanan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Nama Lokasi</label>
                                <input type="text" name="nama_lokasi" id="edit_nama_lokasi" class="form-control"
                                    placeholder="Input lokasi..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Kabupaten</label>
                                <input type="text" name="kabupaten" id="edit_kabupaten" class="form-control"
                                    placeholder="Input kabupaten..." required>
                            </div>
                            {{-- Baris 3: Kolom Kiri & Kanan --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">ADOP</label>
                                <input type="text" name="adop" id="edit_adop" class="form-control"
                                    placeholder="Input ADOP..." required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">PASS AP1</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="text" name="pass_ap1" id="edit_pass_ap1" class="form-control" required>
                                </div>
                            </div>
                            {{-- Baris 4: Full Width (Atau setengah jika ingin ditambah field lain) --}}
                            <div class="col-md-6 offset-md-6"> {{-- Diletakkan di kanan bawah --}}
                                <label class="form-label fw-bold">PASS AP2</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="text" name="pass_ap2" id="edit_pass_ap2" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Modal Footer --}}
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary px-4"
                            onclick="closeM('editDataModal')">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // 1. Inisialisasi Elemen
        const addModal = document.getElementById('addDataModal');
        const uploadModal = document.getElementById('uploadModal');
        const editModal = document.getElementById('editDataModal');
        // 2. Fungsi Modal (Open/Close)
        // Fungsi ini dipanggil oleh onclick="addSite()" di tombol plus kamu
        function addSite() {
            addModal.style.display = 'block';
        }
        function closeM(id) {
            document.getElementById(id).style.display = 'none';
        }
        // 3. Logic View Info (read-only untuk role admin/user)
        function viewInfo(data) {
            Swal.fire({
                title: '<i class="bi bi-info-circle-fill text-primary"></i> Info Lokasi',
                html: `
                    <div style="text-align: left; font-size: 14px; line-height: 2;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr><td style="color:#888; width:120px;">Nama Lokasi</td><td><b>${data.nama_lokasi}</b></td></tr>
                            <tr><td style="color:#888;">Kabupaten</td><td>${data.kabupaten}</td></tr>
                            <tr><td style="color:#888;">ADOP</td><td>${data.adop}</td></tr>
                            <tr><td style="color:#888;">PASS AP1</td><td><code>${data.pass_ap1}</code></td></tr>
                            <tr><td style="color:#888;">PASS AP2</td><td><code>${data.pass_ap2}</code></td></tr>
                        </table>
                    </div>`,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#0d6efd',
                customClass: { popup: 'rounded-4' }
            });
        }

        // 3. Logic Edit Data
        function editData(data) {
            // Set Action URL ke Route Update
            document.getElementById('editForm').action = "/datapass/" + data.id;
            // Isi field modal dengan data dari row
            document.getElementById('edit_site_id').value = data.site_id;
            document.getElementById('edit_nama_lokasi').value = data.nama_lokasi;
            document.getElementById('edit_kabupaten').value = data.kabupaten;
            document.getElementById('edit_adop').value = data.adop;
            document.getElementById('edit_pass_ap1').value = data.pass_ap1;
            document.getElementById('edit_pass_ap2').value = data.pass_ap2;
            editModal.style.display = 'block';
        }
        // 4. Handle Upload Excel (Smooth Loading)
        function handleFileUpload() {
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                Swal.fire({
                    title: 'Sedang Mengimpor...',
                    text: 'Mohon tunggu sebentar, data sedang diproses.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById('importForm').submit();
            }
        }
        // 5. Logic Delete dengan Konfirmasi SweetAlert
        document.addEventListener('click', function (e) {
            // Cek jika yang diklik adalah tombol delete atau ikon di dalamnya
            const deleteBtn = e.target.closest('.btn-delete');
            if (deleteBtn) {
                const id = deleteBtn.getAttribute('data-id');
                const nama = deleteBtn.getAttribute('data-nama');
                Swal.fire({
                    title: 'Hapus Data?',
                    text: "Data lokasi " + nama + " akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            }
        });
        // 6. Global Close (Klik di luar modal untuk menutup)
        window.onclick = function (event) {
            if (event.target == addModal) addModal.style.display = 'none';
            if (event.target == uploadModal) uploadModal.style.display = 'none';
            if (event.target == editModal) editModal.style.display = 'none';
        }
        // 7. SweetAlert Notifikasi Session (Success/Error)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
            });
        @endif
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Kesalahan Input',
                text: "@foreach($errors->all() as $error){{ $error }} @endforeach",
            });
        @endif
    </script>
</body>

</html>
