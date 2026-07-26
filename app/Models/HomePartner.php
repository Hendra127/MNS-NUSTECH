<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'image_path',
    ];
}
