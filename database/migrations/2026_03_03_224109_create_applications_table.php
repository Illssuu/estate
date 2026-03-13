<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade')->nullable();
            $table->string('flat_title');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->text('comment')->nullable();
            $table->enum('status', ['new', 'processed', 'cancelled'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};