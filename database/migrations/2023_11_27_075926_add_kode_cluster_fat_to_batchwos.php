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
        Schema::table('batchwos', function (Blueprint $table) {
            $table->after('area_fat', function($table){
                $table->string('kode_cluster_fat')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batchwos', function (Blueprint $table) {
            //
        });
    }
};
