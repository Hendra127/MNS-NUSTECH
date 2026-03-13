<?php

namespace App\Exports;

use App\Models\LogPerangkat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LogPerangkatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return LogPerangkat::with('site')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'SITE ID',
            'NAMA SITE',
            'PERANGKAT',
            'TANGGAL',
            'SN LAMA',
            'SN BARU',
            'KETERANGAN'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->site->site_id ?? '-',
            $row->site->sitename ?? '-',
            $row->perangkat,
            $row->tanggal_penggantian,
            $row->sn_lama,
            $row->sn_baru,
            $row->keterangan
        ];
    }
}
