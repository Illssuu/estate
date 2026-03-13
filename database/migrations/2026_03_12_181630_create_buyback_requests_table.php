<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('buyback_requests', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number');
            $table->date('contract_date');
            $table->string('name');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->json('contract_scan_images'); // путь к картинке
             $table->enum('status', ['new', 'processed', 'cancelled'])->default('new');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('buyback_requests');
    }
};