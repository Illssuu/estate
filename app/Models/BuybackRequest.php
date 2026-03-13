<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuybackRequest extends Model
{
    protected $fillable = [
        'contract_number',
        'contract_date',
        'name',
        'user_id',
        'phone',
        'contract_scan_images',
        'status',
    ];
    
    protected $casts = [
        'contract_date' => 'date',
    ];
       public function user(): BelongsTo  
    {
        return $this->belongsTo(User::class);
    }
}