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
        Schema::create('peminjaman_asets', function (Blueprint $table) {
            $table->id();
            // $table->string('no_pinjam');
            $table->string('tipe_pinjam');
            $table->date('tgl_pinjam');
            $table->string('id_karyawan');
            $table->string('nama_branch');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_asets');
    }
};
