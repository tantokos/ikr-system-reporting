<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportBatch implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        //
        foreach ($collection as $row)
        {

            $insert[] =[
                // 'batch_wo' => $this->batch_wo,
            // 'jenis_wo' => $this->jenis_wo,
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
            ]; 
        }
        return $insert;
    }


}
