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
        Schema::create('aset_ikrs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('merk_barang');
            $table->string('spesifikasi')->nullable();
            $table->string('kode_aset')->nullable();
            $table->string('kode_ga')->nullable();
            $table->string('kondisi');
            $table->string('satuan');
            $table->integer('jumlah');
            $table->string('kategori');
            $table->date('tgl_pengadaan');
            $table->string('foto_barang');
            $table->string('nopol')->nullable();
            $table->string('pajak_1tahun')->nullable();
            $table->string('pajak_5tahun')->nullable();
            $table->string('login')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset_ikrs');
    }
};
