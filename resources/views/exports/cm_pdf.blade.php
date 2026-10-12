<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Formulir Pengajuan CM - {{ $monthName }} {{ $year }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 landscape;
            margin: 20mm 25mm 20mm 25mm;
        }

        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #1a1a1a;
            background: #ffffff;
        }

        /* ============ KOP HEADER (CENTERED) ============ */
        .kop-container {
            width: 100%;
            text-align: center;
            margin-bottom: 18px;
        }

        .kop-logo {
            height: 55px;
            margin-bottom: 8px;
            display: inline-block;
        }

        .kop-title {
            font-size: 13pt;
            font-weight: bold;
            color: #1e3a8a;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .kop-subtitle {
            font-size: 10pt;
            font-weight: bold;
            color: #4b5563;
            letter-spacing: 0.3px;
        }

        /* ============ TABEL DATA ============ */
        table.main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8.5pt;
        }

        table.main-table thead tr th {
            background-color: #1d4ed8;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            padding: 8px 6px;
            border: 1px solid #bfdbfe;
            font-size: 8.5pt;
        }

        table.main-table tbody tr td {
            padding: 6px 8px;
            border: 1px solid #d1d5db;
            vertical-align: middle;
        }

        table.main-table tbody tr:nth-child(even) td {
            background-color: #f8fafc;
        }

        .col-no    { width: 5%;  text-align: center; }
        .col-kat   { width: 10%; text-align: center; }
        .col-tgl   { width: 18%; }
        .col-site  { width: 24%; }
        .col-rin   { width: 27%; }
        .col-total { width: 16%; text-align: right; font-weight: bold; }

        /* Total Row */
        .total-row td {
            background-color: #f3f4f6 !important;
            font-weight: bold;
            border: 1px solid #9ca3af;
            padding: 8px;
        }
        .total-label {
            text-align: right;
            padding-right: 12px;
            letter-spacing: 0.5px;
        }
        .total-value {
            text-align: right;
        }

        /* ============ TANDA TANGAN ============ */
        .signature-container {
            margin-top: 30px;
            page-break-inside: avoid;
        }

        table.sig-table {
            border-collapse: collapse;
            border: none;
        }

        table.sig-table td {
            border: none;
            vertical-align: top;
            padding: 0;
        }

        .sig-block {
            text-align: center;
        }

        .sig-label {
            font-size: 9pt;
            margin-bottom: 4px;
        }

        .sig-img-wrap {
            height: 55px;
            margin: 4px auto;
            display: block;
        }

        .sig-img {
            max-height: 55px;
            max-width: 140px;
        }

        .sig-name {
            font-weight: bold;
            font-size: 9pt;
            text-decoration: underline;
            margin-top: 4px;
        }

        .sig-jabatan {
            font-size: 8.5pt;
            font-weight: bold;
            margin-top: 1px;
            color: #111827;
        }
    </style>
</head>
<body>

    {{-- ============ KOP HEADER ============ --}}
    <div class="kop-container">
        @if($logoBase64)
            <div>
                <img src="{{ $logoBase64 }}" class="kop-logo" alt="Logo NUSTECH">
            </div>
        @endif
        <div class="kop-title">FORMULIR PENGAJUAN CORRECTIVE / PREVENTIVE MAINTENANCE</div>
        <div class="kop-subtitle">PERIODE: {{ strtoupper($monthName) }} {{ $year }} | {{ $katLabel }}</div>
    </div>

    {{-- ============ TABEL DATA ============ --}}
    <table class="main-table">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-kat">Kategori</th>
                <th class="col-tgl">Tempat & Tanggal</th>
                <th class="col-site">Nama Site</th>
                <th class="col-rin">Rincian Kebutuhan</th>
                <th class="col-total">Total Dana (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $cm)
                <tr>
                    <td class="col-no">{{ $i + 1 }}</td>
                    <td class="col-kat">{{ $cm->kategori ?? '-' }}</td>
                    <td class="col-tgl">{{ $cm->tempat_tanggal ?? '-' }}</td>
                    <td class="col-site">{{ $cm->nama_site ?? '-' }}</td>
                    <td class="col-rin">{{ $cm->rincian_kebutuhan ?? '-' }}</td>
                    <td class="col-total">Rp {{ number_format($cm->total ?? 0, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 18px; color: #6b7280;">
                        Tidak ada data untuk periode dan kategori yang dipilih.
                    </td>
                </tr>
            @endforelse

            {{-- Row Total --}}
            <tr class="total-row">
                <td colspan="5" class="total-label">TOTAL DANA</td>
                <td class="col-total total-value">
                    Rp {{ number_format($data->sum('total'), 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- ============ TANDA TANGAN — Hanya NOC Leader ============ --}}
    <div class="signature-container">
        <table class="sig-table" style="width: 100%;">
            <tr>
                {{-- Kiri: kosong --}}
                <td style="width: 33%;"></td>

                {{-- Tengah: Pemohon / NOC Leader --}}
                <td style="width: 34%; text-align: center;">
                    <div class="sig-block">
                        <div class="sig-label">Pemohon,</div>
                        <div class="sig-img-wrap">
                            @if($ttdPemohon)
                                <img src="{{ $ttdPemohon }}" class="sig-img" alt="TTD Pemohon">
                            @endif
                        </div>
                        <div class="sig-name">Rossie Maulana Septian, S.Kom</div>
                        <div class="sig-jabatan">NOC Leader</div>
                    </div>
                </td>

                {{-- Kanan: kosong --}}
                <td style="width: 33%;"></td>
            </tr>
        </table>
    </div>

</body>
</html>
