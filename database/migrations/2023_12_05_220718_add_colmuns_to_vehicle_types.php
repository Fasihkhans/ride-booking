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
        Schema::table('vehicle_types', function (Blueprint $table) {
            $table->dropColumn('fare');
            $table->float('base_fare');
            $table->float('per_mintue_rate');
            $table->float('per_mile_rate');
            $table->float('min_mintues');
            $table->float('min_miles');
            $table->float('holiday_rate');
            $table->float('peak_hour_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_types', function (Blueprint $table) {
            //
        });
    }
};