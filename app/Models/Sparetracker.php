<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sparetracker extends Model
{
      protected $table = 'sparetracker';

    protected $fillable = [
        'sn', 'nama_perangkat', 'jenis', 'type', 'kondisi', 'pengadaan_by',
        'lokasi_asal', 'lokasi', 'bulan_masuk', 'tanggal_masuk',
        'status_penggunaan_sparepart', 'lokasi_realtime', 'kabupaten',
        'bulan_keluar', 'tanggal_keluar', 'layanan_ai', 'keterangan'
    ];


}