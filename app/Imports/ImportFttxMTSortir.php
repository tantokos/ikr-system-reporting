<?php

namespace App\Imports;

use App\Models\ImportFttxMtSortirTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportFttxMTSortir implements ToModel,WithHeadingRow, WithChunkReading
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
        return new ImportFttxMtSortirTemp([
            'no_so' => $row['no_so'],
            'no_wo' => $row['no_wo'],
            'wo_date' => $row['wo_date'],
            'mt_date' => Date::excelToDateTimeObject($row['mt_date']),
            'wo_type' => $row['wo_type'],
            'cust_name' => $row['cust_name'],
            'cust_address' => $row['cust_address'],
            'area' => $row['area'],
            'site' => $row['site'],
            'packages_type' => $row['packages_type'],
            'service_type' => $row['service_type'],
            'slot_time' => $row['slot_time'],
            'checkin_time' => $row['checkin_time'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'leader' => $row['leader'],
            'branch' => $row['branch'],
            'callsign' => $row['callsign'],
            'nopol' => $row['nopol'],
            'start' => $row['start'],
            'finish' => $row['finish'],
            'report_wa' => $row['report_wa'],
            'fdt_code' => $row['fdt_code'],
            'fat_code' => $row['fat_code'],
            'fat_port' => $row['fat_port'],
            'signal_fat' => $row['signal_fat'],
            'signal_tb' => $row['signal_tb'],
            'signal_ont' => $row['signal_ont'],
            'ont_sn_out' => $row['ont_sn_out'],
            'ont_mac_out' => $row['ont_mac_out'],
            'ont_sn_in' => $row['ont_sn_in'],
            'ont_mac_in' => $row['ont_mac_in'],
            'stb2_sn' => $row['stb2_sn'],
            'stb2_mac' => $row['stb2_mac'],
            'stb3_sn' => $row['stb3_sn'],
            'stb3_mac' => $row['stb3_mac'],
            'router_sn' => $row['router_sn'],
            'router_mac' => $row['router_mac'],
            'drop_cable' => $row['drop_cable'],
            'precon' => $row['precon'],
            'fast_connector' => $row['fast_connector'],
            'termination_box' => $row['termination_box'],
            'patch_cord_3m' => $row['patch_cord_3m'],
            'patch_cord_10m' => $row['patch_cord_10m'],
            'screw_hanger' => $row['screw_hanger'],
            'indor_cable_duct' => $row['indor_cable_duct'],
            'pvc_pipe_20mm' => $row['pvc_pipe_20mm'],
            'socket_pvc_20mm' => $row['socket_pvc_20mm'],
            'clamp_pvc_20mm' => $row['clamp_pvc_20mm'],
            'flexible_pvc_20mm' => $row['flexible_pvc_20mm'],
            'clamp_cable' => $row['clamp_cable'],
            'cable_lan' => $row['cable_lan'],
            'connector_rj45' => $row['connector_rj45'],
            'cable_marker' => $row['cable_marker'],
            'insulation' => $row['insulation'],
            'cable_ties' => $row['cable_ties'],
            'adapter_optic' => $row['adapter_optic'],
            'fisher' => $row['fisher'],
            'paku_beton' => $row['paku_beton'],
            'splitter' => $row['splitter'],
            'status_wo' => $row['status_wo'],
            'couse_code' => $row['couse_code'],
            'root_couse' => $row['root_couse'],
            'action_taken' => $row['action_taken'],
            'penagihan' => $row['penagihan'],
            'remarks' => $row['remarks'],
            'login' => $this->login
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
