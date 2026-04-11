<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MikrotikCommandLog extends Model
{
    protected $table = 'mikrotik_command_logs';

    protected $fillable = [
        'site_id',
        'user_id',
        'command',
        'parameters',
        'response',
        'status',
        'category',
        'executed_at',
    ];

    protected $casts = [
        'parameters'  => 'array',
        'executed_at' => 'datetime',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
