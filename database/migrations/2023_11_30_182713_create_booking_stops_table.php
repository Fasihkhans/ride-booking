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
        Schema::create('booking_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->string('stop');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('sequence_no');
            $table->string('type');
            $table->string('status');
            $table->timestamps();

            // Index on sequence_no for sorting
            $table->index('sequence_no');
            $table->index('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_stops');
    }
};
