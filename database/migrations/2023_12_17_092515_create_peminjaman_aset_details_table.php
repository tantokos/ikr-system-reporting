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
        Schema::create('peminjaman_aset_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_pinjam');
            $table->string('id_aset');
            $table->string('nama_aset');
            $table->string('kode_aset');
            $table->string('satuan');
            $table->integer('jml_pinjam');
            $table->string('kategori');
            $table->string('status_pinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_aset_details');
    }
};
