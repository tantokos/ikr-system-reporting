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
            'cust_address2' => $row['cust_address1'],
            'type_maintenance' => $row['type_maintenance'],
            'kode_fat' => $row['kode_fat'],
            'kode_wilayah' => $row['kode_wilayah'],
            'cluster' => $row['cluster'],
            'kotamadya' => $row['kotamadya'],
            'kotamadya_penagihan' => $row['kotamadya_penagihan'],
            'branch' => $row['branch'],
            'tgl_ikr' => Date::excelToDateTimeObject($row['tgl_ikr']),
            'slot_time_leader' => $row['slot_time_apk'],
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
            'tgl_reschedule' => $row['tgl_jam_reschedule'], //is_null($row['tgl_reschedule']) ? null : Date::excelToDateTimeObject($row['tgl_reschedule'])->format('Y-m-d'),
            'tgl_jam_reschedule' => $row['tgl_jam_reschedule'],
            'alasan_cancel' => $row['alasan_cancel'],
            'alasan_pending' => $row['alasan_pending'],
            'detail_alasan' => $row['detail_alasan'],
            'permintaan_rsch' => $row['permintaan_rsch'],
            'respon_cst' => $row['respon_cst'],
            'jawaban_cst' => $row['jawaban_cst'],
            'dispatch' => $row['dispatch'],
            'telp_dispatch' => $row['telp_dispatch'],
            'tgl_jam_fat_on' => $row['tgl_jam_fat_on'],
            'action_taken' => $row['action_taken'],
            'panjang_kabel' => $row['panjang_kabel'],
            'weather' => $row['weather'],
            'remark_status' => $row['remark_status'],
            'action_status' => $row['action_status'],
            'visit_novisit' => $row['visit_novisit'],
            'start_ikr_wa' => $row['start_ikr_wa'],
            'end_ikr_wa' => $row['end_ikr_wa'],
            'jam_foto_rumah' => $row['jam_foto_rumah'],
            'jam_dispatch_foto_rumah' => $row['jam_dispatch_foto_rumah'],
            'jam_cek_fat' => $row['jam_cek_fat'],
            'jam_dispatch_cek_fat' => $row['jam_dispatch_cek_fat'],
            'validasi_start' => $row['validasi_start'],
            'validasi_end' => $row['validasi_end'],
            'foto_rumah' => $row['foto_rumah'],
            'foto_selfie' => $row['foto_selfie'],
            'regist_start' => $row['regist_start'],
            'regist_end' => $row['regist_end'],
            'cek_telebot' => $row['cek_telebot'],
            'hasil_cek_telebot' => $row['hasil_cek_telebot'],
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
            'pic_konf_cst' => $row['pic_konf_cst'],
            'konfirmasi_customer' => $row['konfirmasi_customer'],
            'tgl_konf_cst' => $row['tgl_konf_cst'],
            'jam_konf_cst' => $row['jam_konf_cst'],
            'bukti_konf_cst' => $row['bukti_konf_cst'],
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
            'fast_connector' => $row['fast_connector'],
            'patchcord' => $row['patchcord'],
            'terminal_box' => $row['terminal_box'],
            'kabel_utp' => $row['kabel_utp'],
            'pipa' => $row['pipa'],
            'socket_pipa' => $row['socket_pipa'],
            'cable_duct' => $row['cable_duct'],
            'rj45' => $row['rj45'],
            'flexible' => $row['flexible'],
            'remote_fiberhome' => $row['remote_fiberhome'],
            'remote_extrem' => $row['remote_extrem'],
            'port_fat' => $row['port_fat'],
            'site_penagihan' => $row['site_penagihan'],
            'konfirmasi_penjadwalan' => $row['konfirmasi_penjadwalan'],
            'konfirmasi_cst' => $row['konfirmasi_cst'],
            'konfirmasi_dispatch' => $row['konfirmasi_dispatch'],
            'remark_status2' => $row['remark_status2'],
            'wo_type_apk' => $row['wo_type_apk'],
            'branch_id' => $row['branch_id'],
            'leadcall' => $row['leadcall'],
            'tek1_nik' => $row['tek1_nik'],
            'tek2_nik' => $row['tek2_nik'],
            'tek3_nik' => $row['tek3_nik'],
            'tek4_nik' => $row['tek4_nik'],
            'leadcall_id' => $row['leadcall_id'],
            'leader_id' => $row['leader_id'],
            'callsign_id' => $row['callsign_id'],
            'teknisi4' => $row['teknisi4'],
            'kondisi_fat' => $row['kondisi_fat'],
            'alasan_tidak_ganti_precon' => $row['alasan_tidak_ganti_precon'],
            'is_checked' => $row['is_checked'],
            'mttr_all' => $row['mttr_all'],
            'mttr_pending' => $row['mttr_pending'],
            'mttr_progress' => $row['mttr_progress'],
            'mttr_teknisi' => $row['mttr_teknisi'],
            'sla_over' => $row['sla_over'],
            'minute' => $row['minute'],
            'status_checkin' => $row['status_checkin'],
            'waktu_installation' => is_string($row['waktu_installation']) ? null : Date::excelToDateTimeObject($row['waktu_installation'])->format("H:i"), //$row['waktu_installation'], //Date::excelToDateTimeObject($row['waktu_installation'])->format("H:i"),
            'kode_otp' => $row['kode_otp'],
            'material_out' => $row['material_out'],
            'material_in' => $row['material_in'],
            'kode_fat_relokasi' => $row['kode_fat_relokasi'],
            'port_fat_relokasi' => $row['port_fat_relokasi'],
            'last_import' => $row['last_import'],
            'time_last_import' => $row['time_last_import'],

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
