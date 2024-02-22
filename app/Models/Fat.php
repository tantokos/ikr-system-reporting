<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fat extends Model
{
    use HasFactory;

    protected $fillable = ['kode_area',
    'area',
    'kode_cluster',
    'cluster',
    'hp',
    'jml_fat',
    'active',
    'suspend',
    'ms_regular',
    'branch_id'];

 
}
