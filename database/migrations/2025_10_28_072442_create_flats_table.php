<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            // Основная информация
            $table->string('title');
            $table->text('description')->nullable();
            
            // Цена и площадь
            $table->decimal('price', 12, 2);
            $table->decimal('area', 8, 2);
            $table->decimal('living_area', 8, 2)->nullable();
            
            // Характеристики
            $table->integer('rooms');
            $table->integer('floor');
            $table->integer('total_floors');
            
            // Тип жилья
            $table->enum('housing_type', ['new_building', 'secondary'])->default('new_building');
            
            // Отделка
            $table->enum('finishing', ['rough', 'fine', 'euro', 'without'])->default('rough');
            
            // Вид из окна
            $table->enum('view_type', ['yard', 'street', 'combined'])->default('yard');
            
            // Дополнительные характеристики
            $table->boolean('balcony')->default(false);
            $table->enum('bathroom', ['separate', 'combined'])->default('separate');
            
            // Статус - ВАЖНО: добавили эти столбцы!
            $table->boolean('is_available')->default(true);
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            
            // Индексы для поиска
            $table->index('price');
            $table->index('rooms');
            $table->index('area');
            $table->index('housing_type');
            $table->index('status');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};