<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('realties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('status'); // Статус: активен, архив, заблокирован
            $table->string('deal'); // Аренда или продажа
            $table->string('type');
            $table->bigInteger('price');
            $table->string('address');
            $table->integer('rooms')->default(1);
            $table->longText('description')->nullable();
            $table->integer('year_built')->nullable();
            $table->integer('height')->nullable();
            $table->string('balcony')->nullable()->default('none'); // Балкон или лоджия
            $table->string('furniture')->nullable()->default('none'); // Мебель
            $table->string('parking')->nullable()->default('none'); // Парковка
            $table->integer('floor')->nullable(); // Этаж
            $table->integer('floors')->nullable(); // Всего этажей
            $table->boolean('is_first_floor')->default(false); // Первый этаж
            $table->boolean('is_last_floor')->default(false); // Последний этаж
            $table->boolean('is_new_building')->default(false); // Новостройка
            $table->integer('total_floors')->nullable(); // Всего этажей в здании
            $table->json('coordinates')->nullable(); // Координаты (широта, долгота)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realties');
    }
};
