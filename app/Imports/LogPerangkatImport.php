<?php

namespace App\Imports;

use App\Models\LogPerangkat;
use App\Models\Site;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class LogPerangkatImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Debugging: Kita bisa melihat keys yang tersedia jika terjadi error
        // $keys = array_keys($row);

        // Mencari site berdasarkan site_id (string)
        $siteIdExcel = isset($row['site_id']) ? trim($row['site_id']) : null;
        
        // Fallback jika header berbeda sedikit (contoh: SITEID tanpa spasi)
        if (!$siteIdExcel) {
            $siteIdExcel = isset($row['siteid']) ? trim($row['siteid']) : null;
        }

        if (!$siteIdExcel) {
            return null; // Skip baris kosong
        }

        $site = Site::where('site_id', $siteIdExcel)->first();
        
        if (!$site) {
            // Kita skip saja jika site tidak ditemukan agar baris lain tetap ter-import
            return null;
        }

        // Parsing Tanggal
        $tanggalRaw = $row['tanggal_pergantian'] ?? 
                      $row['tanggal'] ?? 
                      $row['tgl_pergantian'] ?? 
                      $row['tgl'] ?? 
                      $row['tanggal_penggantian'] ?? 
                      null;

        $tanggal = null;
        if ($tanggalRaw) {
            try {
                if (is_numeric($tanggalRaw)) {
                    $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalRaw));
                } else {
                    $tanggalRaw = trim($tanggalRaw);
                    if (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/', $tanggalRaw)) {
                        // Handle d/m/Y or d-m-Y
                        $separator = str_contains($tanggalRaw, '/') ? '/' : '-';
                        $tanggal = Carbon::createFromFormat("d{$separator}m{$separator}Y", $tanggalRaw);
                    } else {
                        $tanggal = Carbon::parse($tanggalRaw);
                    }
                }
            } catch (\Exception $e) {
                $tanggal = null;
            }
        }

        // Jika tanggal masih null, gunakan hari ini sebagai fallback agar tidak error database
        if (!$tanggal) {
            $tanggal = now();
        }

        return new LogPerangkat([
            'site_id'             => $site->id,
            'perangkat'           => $row['jenis_perangkat'] ?? $row['perangkat'] ?? $row['nama_perangkat'] ?? 'LAINNYA',
            'qty'                 => $row['qty'] ?? 1,
            'sn_lama'             => $row['sn_perangkat_lama'] ?? $row['sn_lama'] ?? null,
            'sn_baru'             => $row['sn_perangkat_baru'] ?? $row['sn_baru'] ?? null,
            'tanggal_penggantian' => $tanggal,
            'layanan'             => $row['layanan'] ?? null,
            'status'              => $row['status'] ?? null,
            'keterangan'          => $row['catatan'] ?? $row['keterangan'] ?? null,
        ]);
    }
}
