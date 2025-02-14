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
        Schema::create('tourist_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tourist_id')->nullable();
            $table->string('image'); // Image filename
            $table->string('path');  // Full image path
            $table->timestamps();
            $table->foreign('tourist_id')->references('id')->on('tourists')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_images');
    }
};
