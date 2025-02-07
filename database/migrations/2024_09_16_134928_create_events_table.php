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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('resort_id'); // Resort ID
            $table->string('event_name');
            $table->text('description');
            $table->dateTime('event_start');
            $table->dateTime('event_end');
            $table->decimal('price', 8, 2);
            $table->decimal('discount', 5, 2)->nullable();
            $table->timestamps();

            // Foreign key constraint for resort_id, referencing the users table's id
            $table->foreign('resort_id')
                ->references('id')->on('users')
                ->onDelete('cascade'); // Optional: delete events if the associated user is deleted
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
