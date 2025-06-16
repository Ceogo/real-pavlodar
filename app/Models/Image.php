<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'realty_id',
        'path'
    ];

    public function realty()
    {
        return $this->belongsTo(Realty::class);
    }
}
