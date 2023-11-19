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
        Schema::create('verification_code_purposes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('expiration_seconds')->default(300);
            $table->text('description')->nullable();
            $table->tinyInteger('queue')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_code_purposes');
    }
};
