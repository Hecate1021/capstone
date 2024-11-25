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
        Schema::create('event_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id');  // Foreign key to resort or user table
            $table->unsignedBigInteger('event_id')->nullable(); // Make event_id nullable
            $table->unsignedBigInteger('user_id')->nullable();  // Nullable user ID for logged-in users
            $table->string('name');
            $table->string('email');
            $table->string('contact');               // For storing contact number
            $table->decimal('payment', 10, 2);
            $table->string('reason')->nullable();
            $table->enum('status', ['Pending', 'Accept', 'Cancel', 'Check Out'])->default('Pending');       // For storing payment amount
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('resort_id')->references('id')->on('users')->onDelete('cascade'); // Assuming resorts are tied to users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');  // Nullable foreign key  // Nullable foreign key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_bookings');
    }
};
