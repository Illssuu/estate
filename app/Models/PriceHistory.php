<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{    protected $table = 'price_history';
    protected $fillable = [
        'flat_id',
        'price',
        'date'
    ];

    protected $casts = [
        'date' => 'date',
        'price' => 'decimal:2'
    ];

    // Обратная связь с квартирой
    public function flat()
    {
        return $this->belongsTo(Flat::class);
    }
}