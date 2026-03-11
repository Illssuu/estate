<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallRequest extends Model
{
    protected $table = 'call_requests';

    protected $fillable = [
        'name',
        'phone',
        'flat_id',
        'flat_title',
        'comment',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function flat(): BelongsTo
    {
        return $this->belongsTo(Flat::class);
    }
}