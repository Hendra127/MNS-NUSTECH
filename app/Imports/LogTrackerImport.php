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
        return new Sparetracker([
            'sn'                          => $row['sn'] ?? null,
            'nama_perangkat'              => $row['nama_perangkat'] ?? null,
            'jenis'                       => $row['jenis'] ?? null,
            'type'                        => $row['type'] ?? null,
            'kondisi'                     => $row['kondisi'] ?? null,
            'pengadaan_by'                => $row['pengadaan_by'] ?? null,
            'lokasi_asal'                 => $row['lokasi_asal'] ?? null,
            'lokasi'                      => $row['lokasi'] ?? null,
            'bulan_masuk'                 => $row['bulan_masuk'] ?? null,
            'tanggal_masuk'               => isset($row['tanggal_masuk']) ? \Carbon\Carbon::parse($row['tanggal_masuk']) : null,
            'status_penggunaan_sparepart' => $row['status_penggunaan_sparepart'] ?? null,
            'lokasi_realtime'             => $row['lokasi_realtime'] ?? null,
            'kabupaten'                   => $row['kabupaten'] ?? null,
            'bulan_keluar'                => $row['bulan_keluar'] ?? null,
            'tanggal_keluar'              => isset($row['tanggal_keluar']) ? \Carbon\Carbon::parse($row['tanggal_keluar']) : null,
            'layanan_ai'                  => $row['layanan_ai'] ?? null,
            'keterangan'                  => $row['keterangan'] ?? null,
        ]);
    }
}
