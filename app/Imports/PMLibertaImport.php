<?php

namespace App\Imports;

use App\Models\PMLiberta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date; // Tambahkan ini

class PMLibertaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Fungsi untuk menangani konversi tanggal Excel
        $tanggalTerformat = null;
        if (isset($row['date'])) {
            try {
                if (is_numeric($row['date'])) {
                    // Jika berupa angka serial Excel (seperti 45699)
                    $tanggalTerformat = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])->format('Y-m-d');
                } else {
                    // Ganti / dengan - agar Carbon/strtotime menganggapnya format d-m-Y (bukan m/d/Y)
                    $cleanDate = str_replace('/', '-', $row['date']);
                    $tanggalTerformat = \Carbon\Carbon::parse($cleanDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // Jika masih gagal, coba format spesifik d-m-Y
                try {
                    $tanggalTerformat = \Carbon\Carbon::createFromFormat('d-m-Y', str_replace('/', '-', $row['date']))->format('Y-m-d');
                } catch (\Exception $e2) {
                    $tanggalTerformat = null;
                }
            }
        }

        return new PMLiberta([
            'site_id'     => $row['site_id'],
            'nama_lokasi' => $row['nama_lokasi'],
            'provinsi'    => $row['provinsi'],
            'kabupaten'   => $row['kabupaten_kota'],
            'pic_ce'      => $row['pic_ce'],
            'month'       => $row['month'],
            'date'        => $tanggalTerformat, // Sekarang tersimpan sebagai '2025-07-16'
            'status'      => $row['status'],
            'week'        => $row['week'],
            'kategori'    => $row['kategori'],
        ]);
    }
}