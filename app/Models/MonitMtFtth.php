<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitMtFtth extends Model
{
    use HasFactory;

    protected $fillable =[
        'batch_wo',
            'tgl_ikr',
            'import_by',
            'jenis_wo',
            'slot_time',
            'callsign',
            'teknisi1',
            'teknisi2',
            'teknisi3',
            'teknisi4',
            'status_wo',
            'couse_code',
            'root_couse',
            'action_taken',
            'tgl_resechedule',
            'material_ont_out',
            'material_sn_ont_out',
            'material_mac_ont_out',

            'material_ont_in',
            'material_sn_ont_in',
            'material_mac_ont_in',

            'material_stb_out',
            'material_sn_stb_out',
            'material_mac_stb_out',

            'material_stb_in',
            'material_sn_stb_in',
            'material_mac_stb_in',

            'material_router_out',
            'material_sn_router_out',
            'material_mac_router_out',

            'material_router_in',
            'material_sn_router_in',
            'material_mac_router_in',

            'material_precon_new',
            'material_precon_bad',
            'material_dw',
            
            'material_fastconnector',
            'material_patchcord',
            'material_terminalbox',
            'material_remote',
            'material_adaptor',

            'cuaca',
            'remark_status_precon',
            'remark_status_migrasi',
            'start_ikr',
            'end_ikr',
            'checkin_apk',
            'checkout_apk',
            'status_apk',
            'report_wa',
            'konfirmasi_cst',
            'wo_no',
            'ticket_no',
            // 'wo_type'
            'wo_date',
            'cust_id',
            'name',
            'cust_phone',
            'cust_mobile',
            'address',
            'area',
            'wo_type',
            'fat_code',
            'kode_area_fat',
            'area_fat',
            'kode_cluster_fat',
            'cluster_fat',
            'fat_port',
            'remarks',
            'vendor_installer',
            'ikr_date',
            'time',
    ];
}
