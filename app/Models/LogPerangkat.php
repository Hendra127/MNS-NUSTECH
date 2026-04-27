<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPerangkat extends Model
{
    protected $table = 'log_perangkat';

    protected $fillable = [
        'site_id',
        'perangkat',
        'qty',
        'sn_lama',
        'sn_baru',
        'tanggal_penggantian',
        'keterangan',
        'layanan',
        'status',
        'foto_perangkat_baru',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
}
