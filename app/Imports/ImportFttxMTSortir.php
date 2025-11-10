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
            'site' => $row['site'],
            'no_wo' => $row['no_wo'],
            'wo_date' => is_null($row['wo_date']) ? null : Date::excelToDateTimeObject($row['wo_date'])->format("Y-m-d"),
            'wo_type' => $row['wo_type'],
            'sub_wo_type' => $row['sub_wo_type'],
            'packages_type' => $row['packages_type'],
            'sesi' => $row['sesi'],
            'cust_name' => $row['cust_name'],
            'cust_address' => $row['cust_address'],
            'no_hp' => $row['no_hp'],
            'fat_code' => $row['fat_code'],
            'fat_port' => $row['fat_port'],
            'mt_date' => Date::excelToDateTimeObject($row['mt_date']),
            'slot_time' => $row['slot_time'],
            'checkin_time' => $row['checkin_time'],
            'minute' => $row['minute'],
            'status_checkin' => $row['status_checkin'],
            'finish' => $row['finish'],
            'waktu_installasi' => $row['waktu_installasi'],
            'cluster' => $row['cluster'],
            'area' => $row['area'],
            'branch' => $row['branch'],
            'kotamadya_penagihan' => $row['kotamadya_penagihan'],
            'callsign' => $row['callsign'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'teknisi4' => $row['teknisi4'],
            'leader' => $row['leader'],
            'pic_monitoring' => $row['pic_monitoring'],
            'pic_pengecekan' => $row['pic_pengecekan'],
            // 'Status Aplikasi' => $row['Status Aplikasi'],
            'status_wo' => $row['status_wo'],
            'penagihan' => $row['penagihan'],
            'couse_code' => $row['couse_code'],
            'root_couse' => $row['root_couse'],
            'action_taken' => $row['action_taken'],
            'action_status' => $row['action_status'],
            'detail_alasan' => $row['detail_alasan'],
            'status_visit' => $row['status_visit'],
            'remarks' => $row['remarks'],
            'tgl_jam_reschedule' => $row['tgl_jam_reschedule'],
            'respon_cst' => $row['respon_cst'],
            'jawaban_cst' => $row['jawaban_cst'],
            'permintaan_reschedule' => $row['permintaan_reschedule'],
            'pic_dispatch' => $row['pic_dispatch'],
            'ont_merk_out' => $row['ont_merk_out'],
            'ont_sn_out' => $row['ont_sn_out'],
            'ont_mac_out' => $row['ont_mac_out'],
            'ont_merk_in' => $row['ont_merk_in'],
            'ont_sn_in' => $row['ont_sn_in'],
            'ont_mac_in' => $row['ont_mac_in'],
            'router_merk_out' => $row['router_merk_out'],
            'router_sn_out' => $row['router_sn_out'],
            'router_mac_out' => $row['router_mac_out'],
            'router_merk_in' => $row['router_merk_in'],
            'router_sn_in' => $row['router_sn_in'],
            'router_mac_in' => $row['router_mac_in'],
            'stb_merk_out' => $row['stb_merk_out'],
            'stb_sn_out' => $row['stb_sn_out'],
            'stb_mac_out' => $row['stb_mac_out'],
            'stb_merk_in' => $row['stb_merk_in'],
            'stb_sn_in' => $row['stb_sn_in'],
            'stb_mac_in' => $row['stb_mac_in'],
            'remote_out' => $row['remote_out'],
            'remote_in' => $row['remote_in'],
            'drop_cable' => $row['drop_cable'],
            'precon' => $row['precon'],
            'precon_in' => $row['precon_in'],
            'fast_connector' => $row['fast_connector'],
            'patch_cord_3m' => $row['patch_cord_3m'],
            'termination_box' => $row['termination_box'],
            'cable_lan' => $row['cable_lan'],
            'pvc_pipe_20mm' => $row['pvc_pipe_20mm'],
            'socket_pvc_20mm' => $row['socket_pvc_20mm'],
            'indor_cable_duct' => $row['indor_cable_duct'],
            'connector_rj45' => $row['connector_rj45'],
            'flexible_pvc_20mm' => $row['flexible_pvc_20mm'],
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
