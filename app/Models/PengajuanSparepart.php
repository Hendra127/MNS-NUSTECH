<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSparepart extends Model
{
    protected $guarded = [];

    protected $casts = [
        'items' => 'array'
    ];
}
