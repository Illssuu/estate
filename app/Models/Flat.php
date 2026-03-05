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

    // ===== СВЯЗИ =====
    public function photos()
    {
        return $this->hasMany(FlatPhoto::class)->orderBy('sort_order');
    }

    public function mainPhoto()
    {
        return $this->hasOne(FlatPhoto::class)->where('is_main', true);
    }

    // ===== ПРОВЕРКИ =====
    public function hasPhotos()
    {
        return $this->photos()->exists();
    }

    // ===== АКСЕССОРЫ ДЛЯ ФОТО =====
    public function getMainPhotoUrlAttribute()
    {
        return $this->mainPhoto?->url ?? asset('images/no-photo.jpg');
    }

    public function getFirstPhotoUrlAttribute()
    {
        $firstPhoto = $this->photos()->first();
        return $firstPhoto?->url ?? asset('images/no-photo.jpg');
    }

    public function getAllPhotosUrlsAttribute()
    {
        return $this->photos->map(fn($photo) => $photo->url)->toArray();
    }

    public function getPhotosCountAttribute()
    {
        return $this->photos()->count();
    }

    // ===== АКСЕССОРЫ ДЛЯ ТЕКСТОВ =====
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

    // ===== АКСЕССОРЫ ДЛЯ ЦЕНЫ =====
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }

    public function getPricePerMeterAttribute()
    {
        return $this->area > 0 ? round($this->price / $this->area) : 0;
    }
}