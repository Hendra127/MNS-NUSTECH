<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparepartNeeded extends Model
{
    protected $fillable = [
        'site_id',
        'sparepart_name',
        'quantity',
        'description',
        'status',
        'urgency',
        'photo',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'site_id');
    }
}
