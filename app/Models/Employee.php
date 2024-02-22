<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['nik_karyawan',
    'nama_karyawan',
    'no_telp',
    'tgl_gabung',
    'no_bpjs',
    'no_jamsostek',
    'branch_id',
    'divisi',
    'departement',            
    'posisi',      
    'email',      
    'status_active',
    'tgl_nonactive',
    'foto_karyawan',
    'kelengkapan'];


    public function Branch() {

        return $this->HasOne(Branch::class,'id','branch_id');
    }

    public function CallsignLead() {

        return $this->belongsTo(CallsignLead::class,'id','leader_id');
    }

}
