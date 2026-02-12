<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'area',
        'living_area',
        'rooms',
        'floor',
        'total_floors',
        'housing_type',
        'finishing',
        'view_type',
        'balcony',
        'bathroom',
        'is_available',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'area' => 'decimal:2',
        'living_area' => 'decimal:2',
        'balcony' => 'boolean',
        'is_available' => 'boolean',
    ];

    // Константы для типов
    const HOUSING_TYPES = [
        'new_building' => 'Новостройка',
        'secondary' => 'Вторичное жилье'
    ];

    const FINISHING_TYPES = [
        'rough' => 'Предчистовая',
        'fine' => 'Чистовая',
        'euro' => 'Евроремонт',
        'without' => 'Без отделки'
    ];

    const VIEW_TYPES = [
        'yard' => 'Во двор',
        'street' => 'На улицу',
        'combined' => 'Совмещенный'
    ];

    const BATHROOM_TYPES = [
        'separate' => 'Раздельный',
        'combined' => 'Совмещенный'
    ];

    const STATUS_TYPES = [
        'available' => 'Свободна',
        'reserved' => 'Забронирована',
        'sold' => 'Продана'
    ];
 public function photos()
    {
        return $this->hasMany(FlatPhoto::class)->orderBy('sort_order');
    }

    /**
     * Главное фото
     */
    public function mainPhoto()
    {
        return $this->hasOne(FlatPhoto::class)->where('is_main', true);
    }

    /**
     * Есть ли фотографии у квартиры
     */
    public function hasPhotos()
    {
        return $this->photos()->exists();
    }

    /**
     * Количество фотографий
     */
    public function getPhotosCountAttribute()
    {
        return $this->photos()->count();
    }

    /**
     * URL главного фото
     */
    public function getMainPhotoUrlAttribute()
    {
        if ($this->mainPhoto) {
            return asset('storage/' . $this->mainPhoto->image_path);
        }
        
        // Запасное изображение
        return asset('images/no-photo.jpg'); // или placeholder
    }

    /**
     * URL первой фотографии
     */
    public function getFirstPhotoUrlAttribute()
    {
        $photo = $this->photos()->first();
        return $photo ? asset('storage/' . $photo->image_path) : asset('images/no-photo.jpg');
    }

    /**
     * Массив URL всех фотографий
     */
    public function getAllPhotosUrlsAttribute()
    {
        return $this->photos->map(function ($photo) {
            return asset('storage/' . $photo->image_path);
        })->toArray();
    }
    // Accessors для удобного отображения
    public function getHousingTypeTextAttribute()
    {
        return self::HOUSING_TYPES[$this->housing_type] ?? $this->housing_type;
    }

    public function getFinishingTextAttribute()
    {
        return self::FINISHING_TYPES[$this->finishing] ?? $this->finishing;
    }

    public function getViewTypeTextAttribute()
    {
        return self::VIEW_TYPES[$this->view_type] ?? $this->view_type;
    }

    public function getBathroomTextAttribute()
    {
        return self::BATHROOM_TYPES[$this->bathroom] ?? $this->bathroom;
    }

    public function getStatusTextAttribute()
    {
        return self::STATUS_TYPES[$this->status] ?? $this->status;
    }

    // Форматирование цены
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }
}