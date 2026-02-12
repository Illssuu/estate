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

    // Отношение к квартире
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }

    // Получить полный URL изображения
    public function getFullPathAttribute()
    {
        return asset('storage/' . $this->image_path);
    }

    // Получить главное фото квартиры
    public static function getMainPhoto($flatId)
    {
        return self::where('flat_id', $flatId)
                   ->where('is_main', true)
                   ->first();
    }

    // Получить все фото квартиры
    public static function getAllPhotos($flatId)
    {
        return self::where('flat_id', $flatId)
                   ->orderBy('sort_order')
                   ->orderBy('created_at')
                   ->get();
    }
}