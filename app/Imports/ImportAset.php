<?php

namespace App\Imports;

use App\Models\AsetImportTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ImportAset implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $login;
    
    function __construct($akses) {
        $this->login = $akses;
        
         
    }

    public function model(array $row)
    {
        // dd($row['tgl_pengadaan']);
        
        return new AsetImportTemp([

            'nama_barang' => $row['nama_barang'],
            'merk_barang' => $row['merk'],
            'spesifikasi' => $row['spesifikasi'],
            'kode_aset' => $row['kode_aset'],
            'kode_ga'=> $row['kode_ga'],
            'kondisi' => $row['kondisi'],
            'satuan' => $row['satuan'],
            'jumlah' => $row['jumlah'],
            'kategori' => $row['kategori'],
            'tgl_pengadaan' => Carbon::createFromTimestamp(($row['tgl_pengadaan'] - 25569) * 86400)->toDateString(),
            'foto_barang' => 'foto-blank.jpg',
            'nopol' => $row['nopol'],
            'pajak_1tahun' => $row['pajak_1tahun'],
            'pajak_5tahun' => $row['pajak_5tahun'],
            'login' => $this->login


        ]);
    }

    public function startRow(): int
    {
       return 2;
    }
}
