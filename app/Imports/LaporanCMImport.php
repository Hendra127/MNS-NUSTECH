<?php

namespace App\Imports;

use App\Models\LaporanCM;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class LaporanCMImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Helper function to find a value by fuzzy match of the key
        $findValue = function($targets) use ($row) {
            foreach ($row as $key => $value) {
                $cleanKey = str_replace(['_', ' ', '-'], '', strtolower($key));
                foreach ($targets as $target) {
                    if ($cleanKey === str_replace(['_', ' ', '-'], '', strtolower($target))) {
                        return $value;
                    }
                }
            }
            return null;
        };

        // Fuzzy matches for all fields
        $siteId = $findValue(['site_id', 'siteid', 'idsite', 'site']);
        $namaSite = $findValue(['nama_site', 'sitename', 'sitename', 'lokasi', 'lokasisite', 'nama_site']);
        
        // If site_id is missing, try to find it by NAMA SITE
        if (!$siteId && $namaSite) {
            $foundSite = \App\Models\Site::where('sitename', 'like', '%' . $namaSite . '%')->first();
            if ($foundSite) {
                $siteId = $foundSite->site_id;
            }
        }

        // Even if we still don't have site_id, we continue (nullable in DB now)
        // But we check if the row is actually empty (to skip empty rows)
        if (!$siteId && !$namaSite && !$findValue(['nama_teknisi', 'teknisi'])) {
            return null;
        }

        $namaTeknisi = $findValue(['nama_teknisi', 'teknisi', 'nama']);
        $laporanCm = $findValue(['laporan_cm_pm', 'laporan_cm', 'laporan', 'laporan_pm', 'ba_pm']);
        $notes = $findValue(['notes', 'catatan', 'keterangan', 'kendala', 'masalah']);
        $biayaTeknisi = $findValue(['biaya_teknisi', 'biaya', 'cost']);

        // Date Handling
        $rawDate = $findValue(['tanggal_on_site', 'tanggal', 'date', 'tanggal_submit']);
        $tanggalOnSite = null;
        if ($rawDate) {
            try {
                if (is_numeric($rawDate)) {
                    $tanggalOnSite = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                } else {
                    // Ganti / dengan - agar Carbon/strtotime menganggapnya format d-m-Y (bukan m/d/Y)
                    $cleanDate = str_replace('/', '-', $rawDate);
                    $tanggalOnSite = Carbon::parse($cleanDate)->format('Y-m-d');
                }
            } catch (\Exception $e) {
                // Jika masih gagal, coba format spesifik
                try {
                    $tanggalOnSite = Carbon::createFromFormat('d-m-Y', str_replace('/', '-', $rawDate))->format('Y-m-d');
                } catch (\Exception $e2) {
                    $tanggalOnSite = null;
                }
            }
        }

        // Biaya Handling
        if ($biayaTeknisi !== null) {
            $biayaTeknisi = floatval(str_replace(['Rp', '.', ',', ' '], '', $biayaTeknisi));
        }

        return new LaporanCM([
            'site_id' => $siteId ? (string)$siteId : null,
            'nama_site' => $namaSite,
            'tanggal_on_site' => $tanggalOnSite,
            'nama_teknisi' => $namaTeknisi,
            'laporan_cm' => $laporanCm,
            'notes' => $notes,
            'biaya_teknisi' => $biayaTeknisi,
        ]);
    }
}
