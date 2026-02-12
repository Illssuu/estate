<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade'); // Измените apartment_id на flat_id
            $table->timestamps();
            
            // Уникальный индекс чтобы пользователь не мог добавить одну квартиру дважды
            $table->unique(['user_id', 'flat_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};