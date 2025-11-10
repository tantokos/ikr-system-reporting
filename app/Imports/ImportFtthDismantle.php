<?php

namespace App\Imports;

use App\Models\ImportFtthDismantleTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportFtthDismantle implements ToModel, WithHeadingRow, WithChunkReading
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
            'no_wo' => $row['no_wo'],
            'site' => $row['site'],
            'type_wo' => $row['type_wo'],
            'wo_type_apk' => $row['wo_type_apk'],
            'type_maintenance' => $row['type_maintenance'],
            'no_ticket' => $row['no_ticket'],
            'sesi' => $row['sesi'],
            'wo_date' => $row['wo_date'],
            'visit_date' => Date::excelToDateTimeObject($row['visit_date' ]),
            'dis_port_date' => $row['dis_port_date'],
            'takeout_notakeout' => $row['takeout_notakeout'],
            'port' => $row['port'],
            'close_date' => $row['close_date'],
            'cust_id' => $row['cust_id'],
            'nama_cust' => $row['nama_cust'],
            'branch_id' => $row['branch_id'],
            'leadcall_id' => $row['leadcall_id'],
            'leadcall' => $row['leadcall'],
            'cust_address' => $row['cust_address'],
            'cust_address1' => $row['cust_address1'],
            'slot_time' => $row['slot_time'],
            'tek1_nik' => $row['tek1_nik'],
            'tek2_nik' => $row['tek2_nik'],
            'tek3_nik' => $row['tek3_nik'],
            'tek4_nik' => $row['tek4_nik'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'teknisi4' => $row['teknisi4'],
            'start' => $row['start'],
            'finish' => $row['finish'],
            'kode_fat' => $row['kode_fat'],
            'kode_area' => $row['kode_area'],
            'cluster' => $row['cluster'],
            'kotamadya' => $row['kotamadya'],
            'kotamadya_penagihan' => $row['kotamadya_penagihan'],
            'main_branch' => $row['main_branch'],
            'ms_regular' => $row['ms_regular'],
            'fat_status' => $row['fat_status'],
            'tarik_cable' => $row['tarik_cable'],
            'action_status' => $row['action_status'],
            'detail_alasan' => $row['detail_alasan'],
            'visit_novisit' => $row['visit_novisit'],
            'status_wo' => $row['status_wo'],
            'penagihan' => $row['penagihan'],
            'reason_status' => $row['reason_status'],
            'root_couse' => $row['root_couse'],
            'remarks' => $row['remarks'],
            'reschedule_date' => is_null($row['reschedule_date']) ? null : $row['reschedule_date'], //is_null($row['reschedule_date']) ? null : Date::excelToDateTimeObject($row['reschedule_date'])->format('Y-m-d'),
            'respon_cst' => $row['respon_cst'],
            'jawaban_cst' => $row['jawaban_cst'],
            'permintaan_rsch' => $row['permintaan_rsch'],
            'pic_dispatch' => $row['pic_dispatch'],
            'telp_dispatch' => $row['telp_dispatch'],
            'alasan_no_rollback' => $row['alasan_no_rollback'],
            'reschedule_time' => $row['reschedule_time'],
            'callsign_id' => $row['callsign_id'],
            'callsign' => $row['callsign'],
            'checkin_apk' => $row['checkin_apk'],
            'checkout_apk' => $row['checkout_apk'],
            'selisih_menit' => $row['selisih_menit'],
            'status_checkin' => $row['status_checkin'],
            'waktu_instalasi' => $row['waktu_instalasi'],
            'status_apk' => $row['status_apk'],
            'keterangan' => $row['keterangan'],
            'ikr_progress_date' => $row['ikr_progress_date'],
            'ikr_report_date' => $row['ikr_report_date'],
            'reconsile_date' => $row['reconsile_date'],
            'weather' => $row['weather'],
            'validasi_start' => $row['validasi_start'],
            'validasi_end' => $row['validasi_end'],
            'regist_start' => $row['regist_start'],
            'regist_end' => $row['regist_end'],
            'kode_otp' => $row['kode_otp'],
            'pic_konf_cst' => $row['pic_konf_cst'],
            'konfirmasi_customer' => $row['konfirmasi_customer'],
            'tgl_konf_cst' => $row['tgl_konf_cst'],
            'jam_konf_cst' => $row['jam_konf_cst'],
            'menit_konfirmasi' => $row['menit_konfirmasi'],
            'ket_konf_cst' => $row['ket_konf_cst'],
            'waktu_keterlambatan' => $row['waktu_keterlambatan'],
            'bukti_konf_cst' => $row['bukti_konf_cst'],
            'material_out' => $row['material_out'],
            'material_in' => $row['material_in'],
            'ont_merk_out' => $row['ont_merk_out'],
            'ont_sn_out' => $row['ont_sn_out'],
            'ont_mac_out' => $row['ont_mac_out'],
            'ont_merk_in' => $row['ont_merk_in'],
            'ont_sn_in' => $row['ont_sn_in'],
            'ont_mac_in' => $row['ont_mac_in'],
            'ont_condition_in' => $row['ont_condition_in'],
            'router_merk_out' => $row['router_merk_out'],
            'router_sn_out' => $row['router_sn_out'],
            'router_mac_out' => $row['router_mac_out'],
            'router_merk_in' => $row['router_merk_in'],
            'router_sn_in' => $row['router_sn_in'],
            'router_mac_in' => $row['router_mac_in'],
            'router_condition_in' => $row['router_condition_in'],
            'stb_merk_out' => $row['stb_merk_out'],
            'stb_sn_out' => $row['stb_sn_out'],
            'stb_mac_out' => $row['stb_mac_out'],
            'stb_merk_in' => $row['stb_merk_in'],
            'stb_sn_in' => $row['stb_sn_in'],
            'stb_mac_in' => $row['stb_mac_in'],
            'stb_condition_in' => $row['stb_condition_in'],
            'dw_out' => $row['dw_out'],
            'precon_out' => $row['precon_out'],
            'bad_precon' => $row['bad_precon'],
            'remote_out' => $row['remote_out'],
            'remote_in' => $row['remote_in'],
            'fast_connector' => $row['fast_connector'],
            'patchcord' => $row['patchcord'],
            'terminal_box' => $row['terminal_box'],
            'kabel_utp' => $row['kabel_utp'],
            'pipa' => $row['pipa'],
            'socket_pipa' => $row['socket_pipa'],
            'cable_duct' => $row['cable_duct'],
            'rj45' => $row['rj45'],
            'leader_id' => $row['leader_id'],
            'leader' => $row['leader'],
            // 'slot_time_leader' => $row['slot_time_leader'],
            // 'slot_time_apk' => $row['slot_time_apk'],
            // 'port_fat' => $row['port_fat'],
            
            'pic_monitoring' => $row['pic_monitoring'],
            'pic_pengecekan' => $row['pic_pengecekan'],
            'mttr_all' => $row['mttr_all'],
            'mttr_pending' => $row['mttr_pending'],
            'mttr_progress' => $row['mttr_progress'],
            'mttr_technician' => $row['mttr_technician'],
            'sla_over' => $row['sla_over'],
            'cek_telebot' => $row['cek_telebot'],
            'hasil_cek_telebot' => $row['hasil_cek_telebot'],
            // 'is_checked' => $row['is_checked'],
            // 'created_at' => $row['created_at'],
            // 'updated_at' => $row['updated_at'],
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
