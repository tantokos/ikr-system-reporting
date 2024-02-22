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
            $table->after('fat_code', function($table){
                $table->string('kode_area_fat')->nullable();
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
