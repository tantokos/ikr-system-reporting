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
        Schema::create('batchwos', function (Blueprint $table) {
            $table->id();
            $table->string('batch_wo');
            $table->date('tgl_ikr')->nullable();
            $table->string('import_by')->nullable();
            $table->string('jenis_wo');
            $table->string('wo_no');
            $table->string('ticket_no');
            // $table->string('wo_type');
            $table->string('wo_date');
            $table->string('cust_id');
            $table->string('name');
            $table->string('cust_phone');
            $table->string('cust_mobile');
            $table->longText('address');
            $table->string('area');
            $table->string('wo_type');
            $table->string('fat_code');
            $table->string('fat_port');
            $table->longText('remarks');
            $table->string('vendor_installer');
            $table->string('ikr_date')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batchwos');
    }
};
