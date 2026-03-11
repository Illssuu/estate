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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['call', 'viewing']); // звонок или просмотр
            $table->enum('status', ['new', 'processed', 'called'])->default('new');
            $table->dateTime('viewing_date')->nullable(); // для записи на просмотр
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
