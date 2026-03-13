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
        $site = Site::where('site_id', $row['site_id'])->first();
        
        if (!$site) {
            return null;
        }

        $tanggal = null;
        if (isset($row['tanggal'])) {
            try {
                if (is_numeric($row['tanggal'])) {
                    $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']));
                } else {
                    $tanggal = Carbon::parse($row['tanggal']);
                }
            } catch (\Exception $e) {
                $tanggal = null;
            }
        }

        return new LogPerangkat([
            'site_id'             => $site->id,
            'perangkat'           => $row['perangkat'] ?? null,
            'sn_lama'             => $row['sn_lama'] ?? null,
            'sn_baru'              => $row['sn_baru'] ?? null,
            'tanggal_penggantian' => $tanggal,
            'keterangan'          => $row['keterangan'] ?? null,
        ]);
    }
}
