<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class importexcel extends Model
{
    use HasFactory;

    protected $fillable = [
        'tgl_ikr',
        'import_by',
        'batch_wo',
        'jenis_wo',
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
        'fat_port',
        'remarks',
        'vendor_installer',
        'ikr_date',
        'time'
    ];
}
