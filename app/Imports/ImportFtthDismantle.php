<?php

namespace App\Imports;

use App\Models\ImportFtthDismantleTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportFtthDismantle implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $login;

    function __construct($akses)
    {
        $this->login = $akses;
    }


    public function model(array $row)
    {
        return new ImportFtthDismantleTemp([
            'no_wo' => $row['no_wo' ],
            'wo_date' => $row['wo_date' ],
            'visit_date' => Date::excelToDateTimeObject($row['visit_date' ]),
            'dis_port_date' => $row['dis_port_date' ],
            'takeout_notakeout' => $row['takeout_notakeout' ],
            'port' => $row['port' ],
            'close_date' => $row['close_date' ],
            'cust_id' => $row['cust_id' ],
            'nama_cust' => $row['nama_cust' ],
            'cust_address' => $row['cust_address' ],
            'slot_time' => $row['slot_time' ],
            'teknisi1' => $row['teknisi1' ],
            'teknisi2' => $row['teknisi2' ],
            'teknisi3' => $row['teknisi3' ],
            'start' => $row['start' ],
            'finish' => $row['finish' ],
            'kode_fat' => $row['kode_fat' ],
            'kode_area' => $row['kode_area' ],
            'cluster' => $row['cluster' ],
            'kotamadya' => $row['kotamadya' ],
            'main_branch' => $row['main_branch' ],
            'ms_regular' => $row['ms_regular' ],
            'fat_status' => $row['fat_status' ],
            'ont_sn_in' => $row['ont_sn_in' ],
            'stb_sn_in' => $row['stb_sn_in' ],
            'router_sn_in' => $row['router_sn_in' ],
            'tarik_cable' => $row['tarik_cable' ],
            'status_wo' => $row['status_wo' ],
            'reason_status' => $row['reason_status' ],
            'remarks' => $row['remarks' ],
            'reschedule_date' => $row['reschedule_date' ],
            'alasan_no_rollback' => $row['alasan_no_rollback' ],
            'reschedule_time' => $row['reschedule_time' ],
            'callsign' => $row['callsign' ],
            'checkin_apk' => $row['checkin_apk' ],
            'checkout_apk' => $row['checkout_apk' ],
            'status_apk' => $row['status_apk' ],
            'keterangan' => $row['keterangan' ],
            'ikr_progress_date' => $row['ikr_progress_date' ],
            'ikr_report_date' => $row['ikr_report_date' ],
            'reconsile_date' => $row['reconsile_date' ],
            'weather' => $row['weather' ],
            'leader' => $row['leader' ],
            'pic_monitoring' => $row['pic_monitoring' ],
            'login' => $this->login
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
