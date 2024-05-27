<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportFttxMtSortirTemp extends Model
{
    use HasFactory;

    protected $fillable=[
        'no_so',
        'no_wo',
        'wo_date',
        'mt_date',
        'wo_type',
        'cust_name',
        'cust_address',
        'area',
        'site',
        'packages_type',
        'service_type',
        'slot_time',
        'teknisi1',
        'teknisi2',
        'teknisi3',
        'leader',
        'branch',
        'callsign',
        'nopol',
        'start',
        'finish',
        'report_wa',
        'fdt_code',
        'fat_code',
        'fat_port',
        'signal_fat',
        'signal_tb',
        'signal_ont',
        'ont_sn_out',
        'ont_mac_out',
        'ont_sn_in',
        'ont_mac_in',
        'stb2_sn',
        'stb2_mac',
        'stb3_sn',
        'stb3_mac',
        'router_sn',
        'router_mac',
        'drop_cable',
        'precon',
        'fast_connector',
        'termination_box',
        'patch_cord_3m',
        'patch_cord_10m',
        'screw_hanger',
        'indor_cable_duct',
        'pvc_pipe_20mm',
        'socket_pvc_20mm',
        'clamp_pvc_20mm',
        'flexible_pvc_20mm',
        'clamp_cable',
        'cable_lan',
        'connector_rj45',
        'cable_marker',
        'insulation',
        'cable_ties',
        'adapter_optic',
        'fisher',
        'paku_beton',
        'splitter',
        'status_wo',
        'root_couse',
        'action_taken',
        'remarks',
        'login'
    ];
}
