<?php

namespace App\Exports;

use App\Models\Sparetracker;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LogTrackerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sparetracker::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'SN',
            'Nama Perangkat',
            'Jenis',
            'Type',
            'Kondisi',
            'Pengadaan By',
            'Lokasi Asal',
            'Lokasi',
            'Bulan Masuk',
            'Tanggal Masuk',
            'Status Penggunaan Sparepart',
            'Lokasi Realtime',
            'Kabupaten',
            'Bulan Keluar',
            'Tanggal Keluar',
            'Layanan AI',
            'Keterangan',
            'Created At',
            'Updated At'
        ];
    }
}
