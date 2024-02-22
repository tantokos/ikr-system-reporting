<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAset extends Model
{
    use HasFactory;

    protected $fillable =[
        'tgl_pinjam',
        'id_karyawan',
        'nama_branch',
        'id_aset',
        'nama_aset',
        'kode_aset',
        'satuan',
        'jml_pinjam',
        'kategori',
        'status_pinjam'
    ];
}
