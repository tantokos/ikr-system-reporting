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
        Schema::create('monit_mt_ftths', function (Blueprint $table) {
            $table->id();
            $table->string('batch_wo');
            $table->date('tgl_ikr')->nullable();
            $table->string('import_by')->nullable();
            $table->string('jenis_wo');
            $table->time('slot_time')->nullable();
            $table->string('callsign')->nullable();
            $table->string('teknisi1')->nullable();
            $table->string('teknisi2')->nullable();
            $table->string('teknisi3')->nullable();
            $table->string('teknisi4')->nullable();
            $table->string('status_wo')->nullable();
            $table->string('couse_code')->nullable();
            $table->string('root_couse')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('tgl_resechedule')->nullable();
            $table->string('material_ont_out')->nullable();
            $table->string('material_sn_ont_out')->nullable();
            $table->string('material_mac_ont_out')->nullable();

            $table->string('material_ont_in')->nullable();
            $table->string('material_sn_ont_in')->nullable();
            $table->string('material_mac_ont_in')->nullable();

            $table->string('material_stb_out')->nullable();
            $table->string('material_sn_stb_out')->nullable();
            $table->string('material_mac_stb_out')->nullable();

            $table->string('material_stb_in')->nullable();
            $table->string('material_sn_stb_in')->nullable();
            $table->string('material_mac_stb_in')->nullable();

            $table->string('material_router_out')->nullable();
            $table->string('material_sn_router_out')->nullable();
            $table->string('material_mac_router_out')->nullable();

            $table->string('material_router_in')->nullable();
            $table->string('material_sn_router_in')->nullable();
            $table->string('material_mac_router_in')->nullable();

            $table->string('material_precon_new')->nullable();
            $table->string('material_precon_bad')->nullable();
            $table->integer('material_dw')->nullable();
            
            $table->integer('material_fastconnector')->nullable();
            $table->integer('material_patchcord')->nullable();
            $table->integer('material_terminalbox')->nullable();
            $table->integer('material_remote')->nullable();
            $table->integer('material_adaptor')->nullable();

            $table->string('cuaca')->nullable();
            $table->string('remark_status_precon')->nullable();
            $table->string('remark_status_migrasi')->nullable();
            $table->string('start_ikr')->nullable();
            $table->string('end_ikr')->nullable();
            $table->datetime('checkin_apk')->nullable();
            $table->dateTime('checkout_apk')->nullable();
            $table->string('status_apk')->nullable();
            $table->longText('report_wa')->nullable();
            $table->string('konfirmasi_cst')->nullable();
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
            $table->string('kode_area_fat')->nullable();
            $table->string('area_fat')->nullable();
            $table->string('kode_cluster_fat')->nullable();
            $table->string('cluster_fat')->nullable();
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
        Schema::dropIfExists('monit_mt_ftths');
    }
};
