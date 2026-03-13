<?php

namespace App\Exports;

use App\Models\LaporanCM;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanCMExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LaporanCM::select(
            'site_id',
            'nama_site',
            'tanggal_on_site',
            'nama_teknisi',
            'laporan_cm',
            'notes',
            'biaya_teknisi',
            'foto_on_site',
            'bukti_transfer'
        )->get();
    }

    public function headings(): array
    {
        return [
            'SITE ID',
            'NAMA SITE',
            'TANGGAL ON SITE',
            'NAMA TEKNISI',
            'LAPORAN CM/PM',
            'NOTES',
            'BIAYA TEKNISI',
            'FOTO ON SITE',
            'BUKTI TRANSFER'
        ];
    }
}
