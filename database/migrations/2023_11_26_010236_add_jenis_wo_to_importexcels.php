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
        Schema::table('importexcels', function (Blueprint $table) {
            $table->after('batch_wo', function($table){
                $table->string('jenis_wo');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('importexcels', function (Blueprint $table) {
            //
        });
    }
};
