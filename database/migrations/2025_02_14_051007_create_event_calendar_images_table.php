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
        Schema::create('event_calendar_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_calendar_id'); // Foreign key to event_calendars table
            $table->string('image'); // Image filename or path
            $table->string('path'); // Full image path
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('event_calendar_id')->references('id')->on('event_calendars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_calendar_images');
    }
};
