<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('call_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->string('flat_title');
            $table->text('comment')->nullable();
            $table->enum('status', ['new', 'processed', 'in_progress'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_requests');
    }
};