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
        Schema::create('booking_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings');
            $table->decimal('base_fare');
            $table->decimal('per_mile_rate');
            $table->decimal('per_minutes_rate');
            $table->foreignId('payment_method_id')->constrained('customer_payment_methods');
            $table->string('status');
            $table->timestamps();

            // Index on booking_id for better query performance
            $table->index('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_payments');
    }
};
