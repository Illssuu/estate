<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'image_path',
        'image_name',
        'sort_order',
        'is_main'
    ];

    protected $casts = [
        'is_main' => 'boolean'
    ];

    // Отношение к квартире (нужно!)
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    // Аксессор для URL (удобно в шаблонах)
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}