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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('deal_type')->nullable(); // 'rent' or 'sale'
            $table->bigInteger('price_min')->nullable();
            $table->bigInteger('price_max')->nullable();
            $table->string('property_type')->nullable(); // Type of property
            $table->integer('rooms_min')->nullable();
            $table->integer('rooms_max')->nullable();
            $table->boolean('is_new_building')->nullable();
            $table->timestamps();

            // Ensure a user can only have one preferences record
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};
