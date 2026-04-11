<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pengajuan Pengadaan Barang Inventaris</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm;
            margin: auto;
            background: white;
            box-sizing: border-box;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #5a7b9c;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 150px;
        }

        .judul-kanan {
            text-align: right;
        }

        .judul-kanan h2 {
            margin: 0;
            font-size: 15px;
            color: #5a7b9c;
            font-weight: bold;
        }

        .judul-kanan h1 {
            margin: 5px 0 0 0;
            font-size: 16px;
            color: #5a7b9c;
            font-weight: bold;
        }

        .info-pengajuan {
            margin-bottom: 15px;
            line-height: 1.6;
            font-size: 14px;
        }

        .info-row {
            display: flex;
            margin-bottom: 4px;
        }

        .info-label {
            width: 140px;
        }

        .info-separator {
            width: 15px;
            text-align: center;
        }

        .info-value {
            flex: 1;
        }

        .pembuka {
            margin-top: 15px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 15px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 4px 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
        }

        .bg-light {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 13px;
        }

        .sign-box {
            text-align: center;
            width: 45%;
        }

        .sign-divider {
            margin-top: 35px;
        }

        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }

        @page {
            size: A4;
            margin: 0;
            /* Ini menghapus header (tanggal/judul) dan footer (URL/halaman) dari browser */
        }

        @media print {
            body {
                background: none;
            }

            .page {
                margin: 0;
                padding: 15mm 20mm;
                border: none;
                box-shadow: none;
                width: 100%;
            }

            title {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="page">
        <!-- HEADER -->
        <div class="header">
            <div class="logo-area">
                <img src="{{ asset('assets/img/logonustech_new.jpg') }}" class="logo" style="max-width: 220px;"
                    alt="NUSTECH Logo">
            </div>
            <div class="judul-kanan">
                <h2>FORMULIR PENGAJUAN</h2>
                <h1>PENGADAAN BARANG INVENTARIS</h1>
            </div>
        </div>

        <!-- INFO -->
        <div class="info-pengajuan">
            <div class="info-row">
                <div class="info-label">Tempat, Tanggal</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $data['tempat_tanggal'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Divisi / Bagian</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $data['divisi'] ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">No.</div>
                <div class="info-separator">:</div>
                <div class="info-value">{{ $data['nomor'] ?? '' }}</div>
            </div>
        </div>

        <div class="pembuka">
            Dengan ini saya mengajukan perangkat sparepart untuk pergantian perangkat yang rusak dengan perincian
            sebagai berikut :
        </div>

        <!-- TABLE -->
        @php
            $grandTotal = 0;
            $itemsCount = isset($data['perangkat']) && is_array($data['perangkat']) ? count($data['perangkat']) : 1;
        @endphp
        <table>
            <tr class="bg-light">
                <th>No.</th>
                <th>Perangkat</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>TOTAL</th>
                <th>Layanan</th>
                <th>Peruntukan</th>
                <th>Keterangan</th>
            </tr>
            @if(isset($data['perangkat']) && is_array($data['perangkat']))
                @foreach($data['perangkat'] as $index => $perangkatData)
                    @php
                        $qty = $data['qty'][$index] ?? 1;
                        $harga = $data['harga'][$index] ?? 0;
                        $subTotal = $qty * $harga;
                        $grandTotal += $subTotal;
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}.</td>
                        <td class="text-start">{{ $perangkatData ?? '-' }}</td>
                        <td>{{ $qty }}</td>
                        <td>Rp {{ number_format($harga, 0, ',', '.') }}</td>
                        <td class="bg-light">Rp {{ number_format($subTotal, 0, ',', '.') }}</td>
                        <td>{{ $data['layanan'][$index] ?? '-' }}</td>
                        <td>{{ $data['peruntukan'][$index] ?? '-' }}</td>
                        <td>{{ $data['keterangan'][$index] ?? '-' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center">Belum ada perangkat.</td>
                </tr>
            @endif
            <tr>
                <td colspan="4" class="bg-light" style="text-align: center;">TOTAL</td>
                <td colspan="4" class="bg-light" style="text-align: left;">Rp
                    {{ number_format($grandTotal ?? 0, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="4" class="bg-light" style="text-align: center;">Terbilang</td>
                <td colspan="4" style="text-align: left;"><i style="color: #b71c1c;">{{ $data['terbilang'] ?? '' }}</i>
                </td>
            </tr>
        </table>

        <!-- SIGNATURES TIER 1 -->
        <div class="signature-section">
            <div class="sign-box">
                <div style="margin-bottom: 70px;">Pemohon,</div>
                <div class="sign-name">{{ $data['pemohon_nama'] ?? '-' }}</div>
                <div>{{ $data['pemohon_jabatan'] ?? '-' }}</div>
            </div>
            <div class="sign-box">
                <div style="margin-bottom: 70px;">Diverifikasi,</div>
                <div class="sign-name">{{ $data['diverifikasi1_nama'] ?? '-' }}</div>
                <div>{{ $data['diverifikasi1_jabatan'] ?? '-' }}</div>
            </div>
        </div>

        <!-- SIGNATURES TIER 2 -->
        <div class="signature-section sign-divider">
            <div class="sign-box">
                <div style="margin-bottom: 70px;">Diverifikasi,</div>
                <div class="sign-name">{{ $data['diverifikasi2_nama'] ?? '-' }}</div>
                <div>{{ $data['diverifikasi2_jabatan'] ?? '-' }}</div>
            </div>
            <div class="sign-box">
                <div style="margin-bottom: 70px;">Disetujui,</div>
                <div class="sign-name">{{ $data['disetujui_nama'] ?? '-' }}</div>
                <div>{{ $data['disetujui_jabatan'] ?? '-' }}</div>
            </div>
        </div>

        <!-- SIGNATURE TARGET 3 (Mengetahui) -->
        <div class="signature-section sign-divider" style="justify-content: center;">
            <div class="sign-box">
                <div style="margin-bottom: 70px;">Mengetahui,</div>
                <div class="sign-name">{{ $data['mengetahui_nama'] ?? '-' }}</div>
                <div>{{ $data['mengetahui_jabatan'] ?? '-' }}</div>
            </div>
        </div>

    </div>
</body>

</html>