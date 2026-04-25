<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'user_id', 
        'title', 
        'content', 
        'checklists', 
        'is_done', 
        'is_pinned',
        'color'
    ];

    // Casting checklists agar otomatis menjadi array saat dipanggil
    protected $casts = [
        'checklists' => 'array',
        'is_pinned' => 'boolean',
    ];

    // Relasi ke User (pembuat)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke User yang di-share
    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'todo_user', 'todo_id', 'user_id');
    }
}