<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemoteLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'site_name',
        'site_code',
        'ip_router',
        'tunnel_name',
        'source_page',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
