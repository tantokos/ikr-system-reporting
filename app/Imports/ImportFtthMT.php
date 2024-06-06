<?php

namespace App\Imports;

use App\Models\ImportFtthMtTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ImportFtthMT implements ToModel, WithHeadingRow, WithChunkReading
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
        return new ImportFtthMtTemp([
            'pic_monitoring' => $row['pic_monitoring'],
            'type_wo' => $row['type_wo'], 
            'no_wo' => $row['no_wo'],
            'no_ticket' => $row['no_ticket'],
            'cust_id' => $row['cust_id'],
            'nama_cust' => $row['nama_cust'],
            'cust_address1' => $row['cust_address1'],
            'cust_address2' => $row['cust_address2'],
            'type_maintenance' => $row['type_maintenance'],
            'kode_fat' => $row['kode_fat'],
            'kode_wilayah' => $row['kode_wilayah'],
            'cluster' => $row['cluster'],
            'kotamadya' => $row['kotamadya'],
            'kotamadya_penagihan' => $row['kotamadya_penagihan'],
            'branch' => $row['branch'],
            'tgl_ikr' => Date::excelToDateTimeObject($row['tgl_ikr']),
            'slot_time_leader' => $row['slot_time_leader'],
            'slot_time_apk' => $row['slot_time_apk'],
            'sesi' => $row['sesi'],
            'remark_traffic' => $row['remark_traffic'],
            'callsign' => $row['callsign'],
            'leader' => $row['leader'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'status_wo' => $row['status_wo'],
            'couse_code' => $row['couse_code'],
            'root_couse' => $row['root_couse'],
            'penagihan' => $row['penagihan'],
            'alasan_tag_alarm' => $row['alasan_tag_alarm'],
            'tgl_jam_reschedule' => $row['tgl_jam_reschedule'],
            'tgl_jam_fat_on' => $row['tgl_jam_fat_on'],
            'action_taken' => $row['action_taken'],
            'panjang_kabel' => $row['panjang_kabel'],
            'weather' => $row['weather'],
            'remark_status' => $row['remark_status'],
            'action_status' => $row['action_status'],
            'visit_novisit' =>$row['visit_novisit'],
            'start_ikr_wa' => $row['start_ikr_wa'],
            'end_ikr_wa' => $row['end_ikr_wa'],
            'validasi_start' => $row['validasi_start'],
            'validasi_end' => $row['validasi_end'],
            'checkin_apk' => $row['checkin_apk'],
            'checkout_apk' => $row['checkout_apk'],
            'status_apk' => $row['status_apk'],
            'keterangan' => $row['keterangan'],
            'ms_regular' => $row['ms_regular'],
            'wo_date_apk' => $row['wo_date_apk'],
            'wo_date_mail_reschedule' => $row['wo_date_mail_reschedule'],
            'wo_date_slot_time_apk' => $row['wo_date_slot_time_apk'],
            'actual_sla_wo_minute_apk' => $row['actual_sla_wo_minute_apk'],
            'actual_sla_wo_jam_apk' => $row['actual_sla_wo_jam_apk'],
            'mttr_over_apk_minute' => $row['mttr_over_apk_minute'],
            'mttr_over_apk_jam' => $row['mttr_over_apk_jam'],
            'mttr_over_apk_persen' => $row['mttr_over_apk_persen'],
            'status_sla' => $row['status_sla'],
            'root_couse_before' => $row['root_couse_before'],
            'slot_time_assign_apk' => $row['slot_time_assign_apk'],
            'slot_time_apk_delay' => $row['slot_time_apk_delay'],
            'status_slot_time_apk_delay' => $row['status_slot_time_apk_delay'],
            'ket_delay_slot_time' => $row['ket_delay_slot_time'],
            'konfirmasi_customer' => $row['konfirmasi_customer'],
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
            'dw_out' => $row['dw_out'],
            'precon_out' => $row['precon_out'],
            'bad_precon' => $row['bad_precon'],
            'fast_connector' => $row['fast_connector'],
            'patchcord' => $row['patchcord'],
            'terminal_box' => $row['terminal_box'],
            'remote_fiberhome' => $row['remote_fiberhome'],
            'remote_extrem' => $row['remote_extrem'],
            'port_fat' => $row['port_fat'],
            'site_penagihan' => $row['site_penagihan'],
            'konfirmasi_penjadwalan' => $row['konfirmasi_penjadwalan'],
            'konfirmasi_cst' => $row['konfirmasi_cst'],
            'konfirmasi_dispatch' => $row['konfirmasi_dispatch'],
            'remark_status2' => $row['remark_status2'],
            'login' => $this->login
        ]);

        
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 2000;
    }
}
