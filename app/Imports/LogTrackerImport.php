<?php

namespace App\Imports;

use App\Models\Sparetracker;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LogTrackerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Helper function for robust date parsing to prevent Carbon::parse errors
        $parseDate = function($val) {
            if (empty($val)) return null;
            if (is_numeric($val)) {
                try {
                    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val);
                } catch (\Exception $e) {
                    return null;
                }
            }
            
            $val = trim($val);
            if (strtolower($val) === 'dd/mm/yyyy' || strtolower($val) === 'dd/mm/yy') return null;
            
            // Format d/m/Y e.g. 17/06/2026
            if (strpos($val, '/') !== false) {
                try {
                    return \Carbon\Carbon::createFromFormat('d/m/Y', $val);
                } catch (\Exception $ex) {
                    // Fallback if it's m/d/Y or invalid
                }
            }

            try {
                return \Carbon\Carbon::parse($val);
            } catch (\Exception $e) {
                return null;
            }
        };

        return new Sparetracker([
            'sn'                          => $row['serial_number_sn'] ?? $row['sn'] ?? null,
            'nama_perangkat'              => $row['nama_item'] ?? $row['nama_perangkat'] ?? null,
            'jenis'                       => $row['jenis_barang'] ?? $row['jenis'] ?? null,
            'type'                        => $row['type'] ?? null,
            'kondisi'                     => $row['kondisi'] ?? null,
            'pengadaan_by'                => $row['pengadaan_by'] ?? null,
            'lokasi_asal'                 => $row['lokasi_asal'] ?? null,
            'lokasi'                      => $row['lokasi'] ?? null,
            'bulan_masuk'                 => $row['bulan_masuk'] ?? null,
            'tanggal_masuk'               => $parseDate($row['tanggal_pengadaan_barang_diterima'] ?? $row['tanggal_masuk'] ?? null),
            'status_penggunaan_sparepart' => $row['status_perangkat'] ?? $row['status_penggunaan_sparepart'] ?? null,
            'lokasi_realtime'             => $row['lokasi_perangkat'] ?? $row['lokasi_realtime'] ?? null,
            'kabupaten'                   => $row['kabupaten'] ?? null,
            'bulan_keluar'                => $row['bulan_keluar'] ?? null,
            'tanggal_keluar'              => $parseDate($row['tanggal_keluar'] ?? null),
            'layanan_ai'                  => $row['layanan'] ?? $row['layanan_ai'] ?? null,
            'keterangan'                  => $row['catatan'] ?? $row['keterangan'] ?? null,
        ]);
    }
}
