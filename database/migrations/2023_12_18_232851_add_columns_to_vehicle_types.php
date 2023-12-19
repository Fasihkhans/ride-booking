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
            $table->decimal('night_base_fare');
            $table->decimal('night_per_minute_rate');
            $table->decimal('night_per_mile_rate');
            $table->dropColumn('per_mintue_rate');
            $table->decimal('per_minute_rate');
            $table->dropColumn('min_mintues');
            $table->time('min_mintues');
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
