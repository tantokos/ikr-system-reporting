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
        Schema::create('fats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_area');
            $table->string('area');
            $table->string('kode_cluster');
            $table->string('cluster')->nullable();
            $table->string('hp')->nullable();
            $table->string('jml_fat')->nullable();
            $table->string('active')->nullable();
            $table->string('suspend')->nullable();
            $table->string('ms_regular');
            $table->string('branch_id'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fats');
    }
};
