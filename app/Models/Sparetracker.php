<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sparetracker extends Model
{
    protected $table = 'sparetracker';

    protected $fillable = [
        'sn', 'nama_perangkat', 'jenis', 'type', 'kondisi', 'pengadaan_by',
        'lokasi_asal', 'lokasi', 'bulan_masuk', 'tanggal_masuk',
        'status_penggunaan_sparepart', 'lokasi_realtime', 'kabupaten',
        'bulan_keluar', 'tanggal_keluar', 'layanan_ai', 'keterangan',
        'foto', 'sparepart_needed_id',
    ];

    /**
     * Relasi ke tabel sites berdasarkan kolom 'lokasi_realtime' (berisi sitename).
     * Ini sesuai dengan logic syncSiteSN() yang juga pakai lokasi_realtime.
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'lokasi_realtime', 'sitename');
    }

    /**
     * Relasi ke SparepartNeeded yang menghasilkan record ini (opsional, jika FK tersedia)
     */
    public function sparepartNeeded()
    {
        return $this->belongsTo(SparepartNeeded::class, 'sparepart_needed_id');
    }
}