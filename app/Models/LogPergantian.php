<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogPergantian extends Model
{
    protected $table = 'log_pergantians';

    protected $fillable = [
        'sn_perangkat',
        'keterangan',
        'user_id',
        'aksi',         // contoh: 'repair_selesai', 'dikirim', 'stok_masuk'
        'status_lama',
        'status_baru',
        'kondisi_lama',
        'kondisi_baru',
    ];

    /**
     * Relasi ke User yang melakukan perubahan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

