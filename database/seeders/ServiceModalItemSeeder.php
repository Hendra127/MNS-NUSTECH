<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceModalItem;

class ServiceModalItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // ============================================================
            // MODAL: JARINGAN (Instalasi & maintenance jaringan komputer)
            // ============================================================
            ['modal_key' => 'jaringan', 'title' => 'Perbaikan dan Perawatan Jaringan Wifi',           'year' => '2024 - 2025', 'client' => 'DIT RESKRIMSUS POLDA NTB & BNN Provinsi NTB',     'description' => null, 'order' => 1],
            ['modal_key' => 'jaringan', 'title' => 'Maintenance Jaringan & Server',                   'year' => '2016 - 2017', 'client' => 'Reserse Kriminal Khusus Polda NTB',                 'description' => null, 'order' => 2],
            ['modal_key' => 'jaringan', 'title' => 'Instalasi Jaringan Internet (Metode PTP)',         'year' => '2016',        'client' => 'Little Bali Restaurant Gili Meno & Ozzy Cottages', 'description' => null, 'order' => 3],
            ['modal_key' => 'jaringan', 'title' => 'Instalasi Jaringan Internet & PABX',              'year' => '2016',        'client' => 'Balai Karantina Pertanian Kelas 1 Mataram',         'description' => null, 'order' => 4],

            // ============================================================
            // MODAL: VSAT (Pemasangan dan perawatan jaringan VSAT)
            // ============================================================
            ['modal_key' => 'vsat', 'title' => 'Instalasi VSAT BAKTI 162 Lokasi Area SULAWESI TENGAH',                            'year' => '2024',        'client' => 'PT. PRIMAKOM',                               'description' => null, 'order' => 1],
            ['modal_key' => 'vsat', 'title' => 'Instalasi VSAT BAKTI Area KALIMANTAN UTARA (111 Lokasi)',                          'year' => '2024',        'client' => 'PT. ECOM PALINDO & PT. LIBERTA',             'description' => null, 'order' => 2],
            ['modal_key' => 'vsat', 'title' => 'Instalasi VSAT BAKTI 237 Lokasi (SULUT, SULTENG, SULTRA & SORONG)',                'year' => '2023',        'client' => 'PT. LIBERTA',                                'description' => null, 'order' => 3],
            ['modal_key' => 'vsat', 'title' => 'Instalasi & Maintenance VSAT Area NTB, LAMPUNG, GARUT, MALUKU & PAPUA',           'year' => '2020 - 2022', 'client' => 'Berbagai Mitra Nasional',                    'description' => null, 'order' => 4],

            // ============================================================
            // MODAL: BASEBAND (Pemasangan Baseband (BB) Tower)
            // ============================================================
            ['modal_key' => 'baseband', 'title' => 'Instalasi Jaringan Internet (Metode PTP) dengan mendirikan Tower STT 18 Meter', 'year' => '2016', 'client' => 'DIKBUDPORA Kabupaten Lombok Utara', 'description' => 'Konstruksi Baseband Tower kokoh, Pemasangan perangkat PTP (Point-to-Point), Integrasi jaringan internet antar gedung, Pengetesan VSWR internal kabel', 'order' => 1],

            // ============================================================
            // MODAL: CCTV (Instalasi dan pemeliharaan sistem CCTV)
            // ============================================================
            ['modal_key' => 'cctv', 'title' => 'Perbaikan dan Perawatan CCTV & Jaringan',   'year' => '2024 - 2025', 'client' => 'DIT RESKRIMSUS POLDA NTB & BNN Provinsi NTB',    'description' => null, 'order' => 1],
            ['modal_key' => 'cctv', 'title' => 'Instalasi CCTV 8 Channel & 16 Channel',      'year' => '2015 - 2017', 'client' => 'POLDA NTB, SMA 3 Mataram, D-Blonk Pusat Oleh-Oleh', 'description' => null, 'order' => 2],
            ['modal_key' => 'cctv', 'title' => 'Maintenance Peralatan Kantor & CCTV',        'year' => '2017',        'client' => 'Reserse Kriminal Khusus Polda NTB',               'description' => null, 'order' => 3],
        ];

        foreach ($items as $item) {
            ServiceModalItem::updateOrCreate(
                ['modal_key' => $item['modal_key'], 'title' => $item['title']],
                $item
            );
        }
    }
}
