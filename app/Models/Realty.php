<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realty extends Model
{
    protected $fillable = [
        'name', // Имя владельца
        'phone', // Телефон владельца
        'status', // Статус: активен, архив, заблокирован
        'deal', // Аренда или продажа
        'type',
        'price',
        'address',
        'rooms',
        'description',
        'year_built',
        'height',
        'balcony', // Балкон или лоджия
        'furniture', // Мебель
        'flooring', // Полы
        'parking', // Парковка
        'floor', // Этаж
        'floors', // Всего этажей
        'is_first_floor', // Первый этаж
        'is_last_floor', // Последний этаж
        'is_new_building', // Новостройка
        'total_floors', // Всего этажей в здании
        'coordinates' // Координаты (широта, долгота)
    ];
    protected $casts = [
        'coordinates' => 'array', // Преобразование координат в массив
        'is_first_floor' => 'boolean',
        'is_last_floor' => 'boolean',
        'is_new_building' => 'boolean',
    ];

    public function buyers()
    {
        return $this->hasMany(Buyer::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function hasImages()
    {
        return $this->images()->exists();
    }

    /**
     * Get the users who favorited this realty.
     */
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorites', 'realty_id', 'user_id')
                    ->withTimestamps();
    }
}
