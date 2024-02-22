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
        Schema::create('callsign_leads', function (Blueprint $table) {
            $table->id();
            $table->string('lead_callsign')->unique();
            $table->string('leader_id');
            // $table->string('callsign_tim');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('callsign_leads');
    }
};
