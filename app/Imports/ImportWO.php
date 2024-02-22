<?php

namespace App\Imports;

use App\Models\importexcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportWO implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $batch_wo;
    protected $jenis_wo;
    protected $tgl_ikr;

    function __construct($batch_wo, $jenis_wo, $tgl_ikr) {
        $this->batch_wo = $batch_wo;
        $this->jenis_wo = $jenis_wo;
        $this->tgl_ikr = $tgl_ikr;
         
    }

 
    public function model(array $row,)
    {
        // $request = request()->all();

        

        return new importexcel([
            
            'import_by' => 'userDemo',
            'batch_wo' => $this->batch_wo,
            'tgl_ikr' => $this->tgl_ikr,
            'jenis_wo' => $this->jenis_wo,
            'wo_no' => $row['wo_no'],
            'ticket_no' => $row['ticket_no'],
            'wo_date' => $row['wo_date'],
            'cust_id' => $row['cust_id'],
            'name' => $row['name'],
            'cust_phone' => $row['cust_phone'],
            'cust_mobile' => $row['cust_mobile'],
            'address' => $row['address'],
            'area' => $row['area'],
            'wo_type' => $row['wo_type'],
            'fat_code' => $row['fat_code'],
            'fat_port' => $row['fat_port'],
            'remarks' => $row['remarks'],
            'vendor_installer' => $row['vendor_installer'],
            'ikr_date' => $row['ikr_date'],
            'time' => $row['time'],
            

        ]);
    }

    public function startRow(): int
    {
       return 2;
    }
}
