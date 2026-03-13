<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPerangkat extends Model
{
    protected $table = 'log_perangkat';

    protected $fillable = [
        'site_id',
        'perangkat',
        'sn_lama',
        'sn_baru',
        'tanggal_penggantian',
        'keterangan'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }
}
