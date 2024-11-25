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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id');
            $table->foreignId('user_id')->nullable()->constrained();
            $table->foreignId('room_id')->constrained();
            $table->string('name');
            $table->string('email');
            $table->string('contact_no');
            $table->integer('number_of_visitors');
            $table->decimal('payment', 8, 2);
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('request')->nullable();  // Make 'request' field nullable
            $table->enum('status', ['Pending', 'Accept', 'Cancel', 'Check Out'])->default('Pending');
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
