<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceModalItem extends Model
{
    protected $fillable = ['modal_key', 'title', 'year', 'client', 'description', 'order'];

    /**
     * Get all items grouped by modal_key
     */
    public static function getAllGrouped(): array
    {
        return static::orderBy('order')->get()->groupBy('modal_key')->toArray();
    }

    /**
     * Get items by modal key
     */
    public static function getByModal(string $key)
    {
        return static::where('modal_key', $key)->orderBy('order')->get();
    }
}
