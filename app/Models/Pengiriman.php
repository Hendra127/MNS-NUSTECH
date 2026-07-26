<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';

    protected $fillable = [
        'ekspedisi', 'no_resi', 'sn_perangkat', 'site_id', 'status', 'keterangan',
        'tanggal_pengiriman', 'nama_pengirim', 'nama_penerima',
        'kabkota_pengirim', 'kabkota_penerima', 'biaya_pengiriman', 'klasifikasi'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }
}
