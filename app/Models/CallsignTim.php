<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsignTim extends Model
{
    use HasFactory;

    protected $fillable = ['callsign_tim', 'nik_tim1','nik_tim2','nik_tim3','nik_tim4', 'lead_callsign'];

    public function CallsignLead() {

        return $this->belongsTo(CallsignLead::class,'lead_callsign','lead_callsign');
    }

    public function Employee() {

        return $this->hasOne(Employee::class,'nik_karyawan','nik_tim1');
    }


}
