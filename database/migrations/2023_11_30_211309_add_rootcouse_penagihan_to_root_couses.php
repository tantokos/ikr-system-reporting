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
        Schema::table('root_couses', function (Blueprint $table) {
            $table->after('action_taken', function($table){
                $table->string('rootcouse_penagihan')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('root_couses', function (Blueprint $table) {
            //
        });
    }
};
