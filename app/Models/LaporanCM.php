<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Site;

class LaporanCM extends Model
{
    protected $table = 'laporan_c_m_s';

    protected $fillable = [
        'site_id',
        'nama_site',
        'tanggal_on_site',
        'nama_teknisi',
        'laporan_cm',
        'notes',
        'biaya_teknisi',
        'foto_on_site',
        'bukti_transfer'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }
}
