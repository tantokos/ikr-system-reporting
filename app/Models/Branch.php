<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['nama_branch','kode_branch','alamat'];


    public function Employee() {

        return $this->belongsTo(Employee::class, 'id', 'branch_id');
    }
}
