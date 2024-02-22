<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallsignLead extends Model
{
    use HasFactory;

    protected $fillable = ['lead_callsign','leader_id'];

    public function CallsignTim() {

        return $this->hasMany(CallsignTim::class);
    }

    public function Employee() {

        return $this->hasOne(Employee::class,'nik_karyawan','leader_id');
    }
}
