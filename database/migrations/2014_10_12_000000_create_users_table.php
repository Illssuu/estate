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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // Основная информация

            $table->string('name');
            $table->string('login')->unique(); // Добавляем это поле
            $table->string('phone')->unique(); // Уникальный номер телефона
            $table->string('email'); // Уникальная почта
            
            // Роли: admin, developer, user
            $table->enum('role', ['admin', 'user'])->default('user');
            
            // Пароль и аутентификация
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
