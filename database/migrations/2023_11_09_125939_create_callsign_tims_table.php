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
        Schema::create('callsign_tims', function (Blueprint $table) {
            $table->id();
            $table->string('callsign_tim');
            $table->string('nik_tim1')->unique();
            $table->string('nik_tim2')->unique();
            $table->string('nik_tim3')->unique();
            $table->string('nik_tim4')->unique();
            $table->string('lead_callsign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callsign_tims');
    }
};
