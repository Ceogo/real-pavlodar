<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'message',
        'reality_id',
        'status', // Статус заявки: new, in_progress, completed, rejected
    ];

    protected $casts = [
        'status' => 'string', // Преобразование статуса в строку
    ];

    public function reality()
    {
        return $this->belongsTo(Realty::class);
    }
}
