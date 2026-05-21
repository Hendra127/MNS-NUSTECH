<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan CM - {{ $cm->nama_site }}</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            font-size: 11pt;
            line-height: 1.45;
        }

        .print-wrapper {
            width: 100%;
            border-collapse: collapse;
        }

        .page-content {
            padding: 2mm 20mm; /* Reduced from 15mm */
        }

        .header-container {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #3b82f6;
            padding: 10mm 20mm 10px 20mm; /* Reduced from 15mm */
            background: white;
        }

        .logo { width: 220px; height: auto; }

        .header-text-right { text-align: right; }

        .header-text-right h2 {
            margin: 0;
            font-size: 15pt;
            color: #3f3f46;
            font-weight: 700;
            text-transform: uppercase;
            font-family: Arial, Helvetica, sans-serif;
        }

        .header-text-right .subtitle {
            margin: 2px 0 0 0;
            font-size: 15pt;
            color: #3f3f46;
            font-weight: 700;
            text-transform: uppercase;
            font-family: Arial, Helvetica, sans-serif;
        }

        .info-section { margin-bottom: 12px; }

        .info-row {
            display: flex;
            margin-bottom: 3px;
        }

        .info-label   { width: 135px; flex-shrink: 0; }
        .info-separator { width: 18px; text-align: center; flex-shrink: 0; }
        .info-value   { flex: 1; }

        .pembuka {
            margin-bottom: 10px;
            text-align: justify;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .main-table td {
            border: 1px solid #000;
            padding: 1px 8px; /* Reduced padding for compact layout */
            vertical-align: middle; /* Changed to middle for better consistency */
            line-height: 1.15; /* Compact line-height */
        }

        .label-cell     { width: 170px; }
        .total-cell     { font-weight: bold; }
        .terbilang-cell { font-style: italic; }

        .footer-text { margin-bottom: 16px; }

        .signature-block {
            margin-top: 10px; /* Reduced from 25px */
        }

        .signature-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            row-gap: 15px; /* Further reduced from 30px */
            column-gap: 16px;
            margin-bottom: 5px; /* Further reduced from 10px */
        }

        .sign-box { text-align: center; }

        .sign-title { margin-bottom: 5px; }



        .sign-img {
            position: relative;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
        }

        .sign-img img {
            position: absolute;
            bottom: -65px;
            left: 50%;
            transform: translateX(-50%);
            height: 160px;
            max-width: 250px;
            object-fit: contain;
            filter: contrast(4) brightness(0.4);
            z-index: 10;
        }

        .sign-accounting img {
            bottom: -80px !important;
        }

        .sign-direktur img {
            bottom: -50px !important;
            height: 120px !important;
            filter: contrast(3.5) brightness(0.5) !important;
            opacity: 0.95;
        }

        .sign-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 5px;
            position: relative;
            z-index: 5;
        }

        .sign-jabatan { font-weight: bold; }

        .penasihat-row {
            display: flex;
            justify-content: center;
            margin-top: 15px; /* Reduced from 40px */
            page-break-inside: avoid;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body { background: none; margin: 0; }
            thead { display: table-header-group; }
            .no-print { display: none; }
        }
    </style>
</head>

<body onload="window.print()">
    @php
        $withTtd = $withTtd ?? true;
        // Prioritaskan logo2.jpg sesuai permintaan Anda
        $possiblePaths = [
            public_path('assets/img/logo2.jpg'),
            public_path('mns/assets/img/logo2.jpg'),
            $_SERVER['DOCUMENT_ROOT'] . '/assets/img/logo2.jpg',
            $_SERVER['DOCUMENT_ROOT'] . '/mns/assets/img/logo2.jpg',
            base_path('../public_html/assets/img/logo2.jpg'),
            base_path('../public_html/mns/assets/img/logo2.jpg'),
            
            // Fallback ke logonustech.png
            public_path('assets/img/logonustech.png'),
            public_path('mns/assets/img/logonustech.png'),
            $_SERVER['DOCUMENT_ROOT'] . '/assets/img/logonustech.png',
        ];

        $logoBase64 = '';
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $mime = ($ext == 'png') ? 'image/png' : 'image/jpeg';
                $logoBase64 = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($path));
                break;
            }
        }
    @endphp

    <table class="print-wrapper">
        <thead>
            <tr>
                <td>
                    <div class="header-container">
                        <div class="logo-area">
                            @if($logoBase64)
                                <img src="{{ $logoBase64 }}" class="logo" alt="NUSTECH Logo">
                            @else
                                <img src="/assets/img/logo2.jpg" class="logo" alt="NUSTECH Logo">
                            @endif
                        </div>
                        <div class="header-text-right">
                            <h2>FORMULIR PENGAJUAN</h2>
                            <div class="subtitle">CORRECTIVE / PREVENTIVE MAINTENANCE</div>
                        </div>
                    </div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="page-content">
                        <div class="info-section">
                            <div class="info-row">
                                <div class="info-label">Tempat, Tanggal</div>
                                <div class="info-separator">:</div>
                                <div class="info-value">{{ $cm->tempat_tanggal }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">Divisi / Bagian</div>
                                <div class="info-separator">:</div>
                                <div class="info-value">{{ $cm->divisi }}</div>
                            </div>
                            <div class="info-row">
                                <div class="info-label">No. Surat</div>
                                <div class="info-separator">:</div>
                                <div class="info-value">{{ $cm->no_surat ?? '-' }}</div>
                            </div>

                        </div>

                        <div class="pembuka">
                            Dengan ini saya mengajukan kunjungan teknisi untuk maintenance site open tiket atau sudah terpantau offline selama durasi lebih dari 3 hari dengan perincian sebagai berikut:
                        </div>

                        <table class="main-table">
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Nama Site</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell" style="line-height: 1.2; vertical-align: top;">@php
                                        $rawSites = str_replace(["\r", "\n"], ',', $cm->nama_site);
                                        $siteArray = array_values(array_filter(array_map('trim', explode(',', $rawSites))));
                                    @endphp @if(count($siteArray) > 1)
                                        @foreach($siteArray as $index => $s)
                                            {{ $index + 1 }}. {{ preg_replace('/^[0-9]+\.\s*/', '', $s) }}<br>
                                        @endforeach
                                    @else
                                        {{ $cm->nama_site }}
                                    @endif</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Tanggal Kunjungan</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell">{{ $cm->tanggal_kunjungan }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Nama Teknisi</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell">{{ $cm->nama_teknisi }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Bank</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell">{{ $cm->bank ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Nomer Rekening</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell">{{ $cm->nomor_rekening ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Rincian Kebutuhan</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell" style="vertical-align: top;">{!! nl2br(e($cm->rincian_kebutuhan)) !!}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Total</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell total-cell">Rp {{ number_format($cm->total, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Terbilang</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell terbilang-cell">{{ $cm->terbilang }}</td>
                            </tr>

                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Catatan</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell">{{ $cm->catatan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label-cell">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span>Keterangan</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="value-cell" style="vertical-align: top;">{!! nl2br(e($cm->keterangan ?? '-')) !!}</td>
                            </tr>
                        </table>

                        <div class="footer-text">
                            Demikian surat pengajuan ini dibuat, atas perhatiannya saya ucapkan terima kasih.
                        </div>

                        <div class="signature-block">
                            @if($cm->ttd_penasihat)
                                <div style="text-align: center; margin-bottom: 20px;">
                                    Mataram, {{ $cm->updated_at->format('d F Y') }}
                                </div>
                            @endif
                            <div class="signature-grid">
                                <div class="sign-box">

                                    <div class="sign-title">Pemohon,</div>
                                    <div class="sign-img">
                                        @if($cm->ttd_pemohon && $withTtd)
                                            @php
                                                $ttdUrl = str_replace('storage/', 'storage_public/', $cm->ttd_pemohon);
                                            @endphp
                                            <img src="{{ asset($ttdUrl) }}" alt="TTD Pemohon">
                                        @endif
                                    </div>
                                    <div class="sign-name">Rossie Maulana Septian, S.Kom</div>
                                    <div class="sign-jabatan">NOC Leader</div>
                                </div>
                                <div class="sign-box">

                                    <div class="sign-title">Diverifikasi,</div>
                                    <div class="sign-img">
                                        @if($cm->ttd_manager && $withTtd)
                                            @php
                                                $ttdUrl = str_replace('storage/', 'storage_public/', $cm->ttd_manager);
                                            @endphp
                                            <img src="{{ asset($ttdUrl) }}" alt="TTD Manager">
                                        @endif
                                    </div>
                                    <div class="sign-name">{{ $cm->diverifikasi1_nama }}</div>
                                    <div class="sign-jabatan">{{ $cm->diverifikasi1_jabatan ?: 'Manager' }}</div>
                                </div>
                                <div class="sign-box">

                                    <div class="sign-title">Diverifikasi,</div>
                                    <div class="sign-img sign-accounting">
                                        @if($cm->ttd_accounting && $withTtd)
                                            @php
                                                $ttdUrl = str_replace('storage/', 'storage_public/', $cm->ttd_accounting);
                                            @endphp
                                            <img src="{{ asset($ttdUrl) }}" alt="TTD Accounting">
                                        @endif
                                    </div>
                                    <div class="sign-name">{{ $cm->diverifikasi2_nama }}</div>
                                    <div class="sign-jabatan">{{ $cm->diverifikasi2_jabatan ?: 'Accounting' }}</div>
                                </div>
                                <div class="sign-box">

                                    <div class="sign-title">Disetujui,</div>
                                    <div class="sign-img sign-direktur">
                                        @if($cm->ttd_direktur && $withTtd)
                                            @php
                                                $ttdUrl = str_replace('storage/', 'storage_public/', $cm->ttd_direktur);
                                            @endphp
                                            <img src="{{ asset($ttdUrl) }}" alt="TTD Direktur">
                                        @endif
                                    </div>
                                    <div class="sign-name">{{ $cm->disetujui_nama }}</div>
                                    <div class="sign-jabatan">{{ $cm->disetujui_jabatan ?: 'Direktur' }}</div>
                                </div>
                            </div>

                            <div class="penasihat-row">
                                <div class="sign-box" style="width: 50%;">

                                    <div class="sign-title">Mengetahui,</div>
                                    <div class="sign-img">
                                        @if($cm->ttd_penasihat && $withTtd)
                                            @php
                                                $ttdUrl = str_replace('storage/', 'storage_public/', $cm->ttd_penasihat);
                                            @endphp
                                            <img src="{{ asset($ttdUrl) }}" alt="TTD Penasihat">
                                        @endif
                                    </div>
                                    <div class="sign-name">{{ $cm->mengetahui_nama }}</div>
                                    <div class="sign-jabatan">{{ $cm->mengetahui_jabatan ?: 'Penasihat' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
