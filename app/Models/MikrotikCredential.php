<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class MikrotikCredential extends Model
{
    protected $table = 'mikrotik_credentials';

    protected $fillable = [
        'site_id',
        'api_host',
        'api_port',
        'api_user',
        'api_password',
        'use_ssl',
        'is_active',
        'last_connected',
        'last_error',
    ];

    protected $casts = [
        'use_ssl'        => 'boolean',
        'is_active'      => 'boolean',
        'last_connected' => 'datetime',
    ];

    protected $hidden = ['api_password'];

    // Enkripsi password saat disimpan
    public function setApiPasswordAttribute(string $value): void
    {
        $this->attributes['api_password'] = encrypt($value);
    }

    // Dekripsi password saat dibaca
    public function getApiPasswordAttribute(?string $value): string
    {
        if (!$value) return '';
        try {
            return decrypt($value);
        } catch (\Exception $e) {
            return $value; // Fallback jika belum di-encrypt
        }
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }
}
