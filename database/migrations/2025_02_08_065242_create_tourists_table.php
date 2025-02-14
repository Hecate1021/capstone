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
        Schema::create('tourists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location')->nullable(); // Optional if using lat/lng
            $table->decimal('latitude', 10, 8)->nullable(); // Store latitude
            $table->decimal('longitude', 11, 8)->nullable(); // Store longitude
            $table->string('image')->nullable(); // Optional field for an image path
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Foreign key with index
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourists');
    }
};
