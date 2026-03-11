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

    // Константы для типов (ДОЛЖНЫ БЫТЬ!)
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
      public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function applications() {
        return $this->HasMany(Application::class);
    }
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

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'success',
            'reserved' => 'warning',
            'sold' => 'secondary',
            default => 'secondary'
        };
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ') . ' ₽';
    }

    // Связь с фото
    public function photos()
    {
        return $this->hasMany(FlatPhoto::class)->orderBy('sort_order');
    }
    // Связь с историей цен
public function priceHistory()
{
    return $this->hasMany(PriceHistory::class)->orderBy('date', 'asc');
}

// Получить первую цену (самую старую)
public function getFirstPriceAttribute()
{
    return $this->priceHistory()->first()->price ?? $this->price;
}

// Получить последнюю цену (текущую)
public function getLastPriceAttribute()
{
    return $this->price;
}

// Изменение в рублях
public function getPriceChangeAmountAttribute()
{
    $firstPrice = $this->first_price;
    return $this->price - $firstPrice;
}

// Изменение в процентах
public function getPriceChangePercentAttribute()
{
    $firstPrice = $this->first_price;
    if ($firstPrice == 0) return 0;
    
    $change = (($this->price - $firstPrice) / $firstPrice) * 100;
    return round($change, 1);
}

// Автоматическая запись в историю при изменении цены
protected static function booted()
{
    static::created(function ($flat) {
        // При создании квартиры сразу записываем цену
        $flat->priceHistory()->create([
            'price' => $flat->price,
            'date' => now(),
        ]);
    });

    static::updated(function ($flat) {
        // Если цена изменилась - записываем в историю
        if ($flat->isDirty('price')) {
            $flat->priceHistory()->create([
                'price' => $flat->price,
                'date' => now(),
            ]);
        }
    });
}
}


