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
        Schema::create('crime', function (Blueprint $table) {
            $table->id();
            $table->integer('serial_number')->after('id')->nullable();
            $table->integer('user_id');
            $table->string('type');
            $table->string('location');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('source');
            $table->time('time');        
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crime');
    }
};
