<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batchwo extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_ikr',
        'import_by',
        'batch_wo',
        'jenis_wo',
        'callsign',
        'teknisi1',
        'teknisi2',
        'teknisi3',
        'teknisi4',
        'wo_no',
        'ticket_no',
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
        'time'
    ];


}
