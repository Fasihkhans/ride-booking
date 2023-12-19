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
        Schema::table('booking_stops', function (Blueprint $table) {
            $table->double('driver_latitude', 10,6)->nullable();
            $table->double('driver_longitude', 10,6)->nullable();
            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('booking_stops', function (Blueprint $table) {
            //
        });
    }
};
