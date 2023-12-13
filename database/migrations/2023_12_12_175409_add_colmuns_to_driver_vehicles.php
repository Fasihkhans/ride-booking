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
        Schema::table('driver_vehicles', function (Blueprint $table) {
            $table->time('start_time')->change();
            $table->time('end_time')->change();
            $table->date('start_date');
            $table->date('end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driver_vehicles', function (Blueprint $table) {
            // $table->dropColumn('start_time');
            // $table->dropColumn('end_time');
        });
    }
};
