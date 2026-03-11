<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flat_id',
        'type',
        'status',
        'viewing_date',
        'comment'
    ];

    protected $casts = [
        'viewing_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function flats() {
        return $this->BelongsTo(Flat::class);
    }

    public function getStatusTextAttribute() {
        return match($this->status) {
            'new' => 'Новая заявка',
            'processed' => 'Обработана',
            'called' => 'Перезвонили',
            default => $this->status
        };
    }

    public function getTypeTextAttribute() {
        return match($this->type) {
            'call'=> 'Заявка на звонок',
            'viewing' => 'Запись на просмотр',
            default => $this->type
        };
    }
}
