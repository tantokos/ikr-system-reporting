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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nik_karyawan')->unique();
            $table->string('nama_karyawan');
            $table->string('no_telp')->nullable();
            $table->date('tgl_gabung')->nullable();
            $table->string('no_bpjs')->nullable();
            $table->string('no_jamsostek')->nullable();
            $table->string('branch_id');
            $table->string('divisi');
            $table->string('departement');            
            $table->string('posisi');      
            $table->string('email')->nullable();      
            $table->string('status_active');
            $table->date('tgl_nonactive')->nullable();
            $table->string('foto_karyawan')->nullable();
            $table->string('kelengkapan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
