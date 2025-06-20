<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    protected $table = 'user_preferences';

    protected $fillable = [
        'user_id',
        'deal_type',
        'price_min',
        'price_max',
        'property_type',
        'rooms_min',
        'rooms_max',
        'is_new_building',
    ];

    protected $casts = [
        'is_new_building' => 'boolean',
        'price_min' => 'integer',
        'price_max' => 'integer',
        'rooms_min' => 'integer',
        'rooms_max' => 'integer',
    ];

    /**
     * Get the user that owns the preferences.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
