<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFtthDismantleOri extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_wo',
        'wo_date',
        'visit_date',
        'dis_port_date',
        'takeout_notakeout',
        'port',
        'close_date',
        'cust_id',
        'nama_cust',
        'cust_address',
        'slot_time',
        'teknisi1',
        'teknisi2',
        'teknisi3',
        'start',
        'finish',
        'kode_fat',
        'kode_area',
        'cluster',
        'kotamadya',
        'kotamadya_penagihan',
        'main_branch',
        'ms_regular',
        'fat_status',
        'ont_sn_in',
        'stb_sn_in',
        'router_sn_in',
        'tarik_cable',
        'status_wo',
        'reason_status',
        'remarks',
        'reschedule_date',
        'alasan_no_rollback',
        'reschedule_time',
        'callsign',
        'checkin_apk',
        'checkout_apk',
        'status_apk',
        'keterangan',
        'ikr_progress_date',
        'ikr_report_date',
        'reconsile_date',
        'weather',
        'leader',
        'pic_monitoring',
        'login'
    ];
}
