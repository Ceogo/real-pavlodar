<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavorite extends Model
{
    protected $table = 'user_favorites';

    protected $fillable = [
        'user_id',
        'realty_id',
    ];

    /**
     * Get the user that owns the favorite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the realty that is favorited.
     */
    public function realty()
    {
        return $this->belongsTo(Realty::class);
    }
}
