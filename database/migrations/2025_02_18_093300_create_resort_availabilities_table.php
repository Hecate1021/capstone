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
        Schema::create('resort_availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resort_id')->constrained('users')->onDelete('cascade'); // Resort owner
            $table->string('day'); // Sunday, Monday, etc.
            $table->time('opening_time')->nullable();
            $table->time('closing_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resort_availabilities');
    }
};
