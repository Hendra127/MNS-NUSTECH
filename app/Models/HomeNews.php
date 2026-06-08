<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeNews extends Model
{
    use HasFactory;

    protected $table = 'home_news';

    protected $fillable = [
        'type',
        'title',
        'instagram_url',
        'image_path',
        'caption',
        'published_at',
        'is_active',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
