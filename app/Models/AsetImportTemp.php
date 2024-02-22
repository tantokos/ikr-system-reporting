<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetImportTemp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'merk_barang',
        'spesifikasi',
        'kode_aset',
        'kode_ga',
        'kondisi',
        'satuan',
        'jumlah',
        'kategori',
        'tgl_pengadaan',
        'foto_barang',
        'nopol',
        'pajak_1tahun',
        'pajak_5tahun',
        'login'
    ];
}
