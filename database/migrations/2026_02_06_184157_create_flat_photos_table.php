<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flat_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // Путь к изображению
            $table->string('image_name'); // Оригинальное имя файла
            $table->integer('sort_order')->default(0); // Порядок сортировки
            $table->boolean('is_main')->default(false); // Главное фото
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flat_photos');
    }
};