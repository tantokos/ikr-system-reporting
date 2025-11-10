<?php

namespace App\Imports;

use App\Models\ImportFtthIbTemp;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ImportFtthIB implements ToModel, WithHeadingRow, WithChunkReading
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
        return new ImportFtthIbTemp([
            'pic_monitoring' => $row['pic_monitoring'],
            'site' => $row['site'],
            'type_wo' => $row['type_wo'],
            'wo_type_apk' => $row['wo_type_apk'],
            'no_wo' => $row['no_wo'],
            'no_ticket' => $row['no_ticket'],
            'cust_id' => $row['cust_id'],
            'nama_cust' => $row['nama_cust'],
            'cust_address1' => $row['cust_address1'],
            'cust_address2' => $row['cust_address2'],
            'cust_phone_apk' => $row['cust_phone_apk'],
            'type_maintenance' => $row['type_maintenance'],
            'kode_fat' => $row['kode_fat'],
            'kode_wilayah' => $row['kode_wilayah'],
            'cluster' => $row['cluster'],
            'kotamadya' => $row['kotamadya'],
            'kotamadya_penagihan' => $row['kotamadya_penagihan'],
            'branch_id' => $row['branch_id'],
            'branch' => $row['branch'],
            'leadcall_id' => $row['leadcall_id'],
            'leadcall' => $row['leadcall'],
            'tgl_ikr' => Date::excelToDateTimeObject($row['tgl_ikr']),
            'slot_time_leader' => $row['slot_time_apk'],
            'slot_time_apk' => $row['slot_time_apk'],
            'sesi' => $row['sesi'],
            'callsign' => $row['callsign'],
            'callsign_id' => $row['callsign_id'],
            // 'leader_id' => $row['leader_id'],
            'leader' => $row['leader'],
            // 'tek1_nik' => $row['tek1_nik'],
            // 'tek2_nik' => $row['tek2_nik'],
            // 'tek3_nik' => $row['tek3_nik'],
            // 'tek4_nik' => $row['tek4_nik'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'teknisi4' => $row['teknisi4'],
            'status_wo' => $row['status_wo'],
            'reason_status' => $row['reason_status'],
            'action_status' => $row['action_status'],
            'visit_novisit' => $row['visit_novisit'],
            'remarks_teknisi' => $row['remarks_teknisi'],
            'remarks_wo' => $row['remarks_wo'],
            'penagihan' => $row['penagihan'],
            'tgl_jam_reschedule' => is_null($row['tgl_jam_reschedule']) ? null : Date::excelToDateTimeObject($row['tgl_jam_reschedule'])->format("H:i"),
            'tgl_reschedule' => is_null($row['tgl_reschedule']) ? null : Date::excelToDateTimeObject($row['tgl_reschedule'])->format('Y-m-d'),
            'alasan_cancel' => $row['alasan_cancel'],
            'alasan_pending' => $row['alasan_pending'],
            'detail_alasan' => $row['detail_alasan'],
            'respon_konf_cst' => $row['respon_konf_cst'],
            'jawaban_konf_cst' => $row['jawaban_konf_cst'],
            'permintaan_reschedule' => $row['permintaan_reschedule'],
            'weather' => $row['weather'],
            'start_ikr_wa' => $row['start_ikr_wa'],
            'end_ikr_wa' => $row['end_ikr_wa'],
            'nama_dispatch' => $row['nama_dispatch'],
            'telp_dispatch' => $row['telp_dispatch'],
            'jam_tek_foto_rmh' => is_string($row['jam_tek_foto_rmh']) ? null : Date::excelToDateTimeObject($row['jam_tek_foto_rmh'])->format("H:i"),
            'jam_dispatch_respon_foto' => is_string($row['jam_dispatch_respon_foto']) ? null : Date::excelToDateTimeObject($row['jam_dispatch_respon_foto'])->format("H:i"),
            'jam_teknisi_cek_fat' => is_string($row['jam_teknisi_cek_fat']) ? null : Date::excelToDateTimeObject($row['jam_teknisi_cek_fat'])->format("H:i"),
            'jam_dispatch_respon_fat' => is_string($row['jam_dispatch_respon_fat']) ? null : Date::excelToDateTimeObject($row['jam_dispatch_respon_fat'])->format("H:i"),
            'jam_teknisi_cek_port_fat' => is_string($row['jam_teknisi_cek_port_fat']) ? null : Date::excelToDateTimeObject($row['jam_teknisi_cek_port_fat'])->format("H:i"),
            'jam_dispatch_respon_port_fat' => is_string($row['jam_dispatch_respon_port_fat']) ? null : Date::excelToDateTimeObject($row['jam_dispatch_respon_port_fat'])->format("H:i"),
            'jam_teknisi_aktifasi_perangkat' => is_string($row['jam_teknisi_aktifasi_perangkat']) ? null : Date::excelToDateTimeObject($row['jam_teknisi_aktifasi_perangkat'])->format("H:i"),
            'jam_dispatch_respon_aktifasi_perangkat' => is_string($row['jam_dispatch_respon_aktifasi_perangkat']) ? null : Date::excelToDateTimeObject($row['jam_dispatch_respon_aktifasi_perangkat'])->format("H:i"),
            'validasi_start' => is_string($row['validasi_start']) ? null : Date::excelToDateTimeObject($row['validasi_start'])->format("H:i"),
            'validasi_end' => is_string($row['validasi_end']) ? null : Date::excelToDateTimeObject($row['validasi_end'])->format("H:i"),
            'start_regist' => is_string($row['start_regist']) ? null : Date::excelToDateTimeObject($row['start_regist'])->format("H:i"),
            'end_regist' => is_string($row['end_regist']) ? null : Date::excelToDateTimeObject($row['end_regist'])->format("H:i"),
            'otp_start' => $row['otp_start'],
            'otp_end' => $row['otp_end'],
            'checkin_apk' => $row['checkin_apk'],
            'checkout_apk' => $row['checkout_apk'],
            'waktu_instalasi' => $row['waktu_instalasi'],
            'selisih_menit' => $row['selisih_menit'],
            'status_checkin' => $row['status_checkin'],
            'status_apk' => $row['status_apk'],
            'mttr_all' => $row['mttr_all'],
            'mttr_pending' => $row['mttr_pending'],
            'mttr_progress' => $row['mttr_progress'],
            'mttr_technician' => $row['mttr_technician'],
            'sla_over' => $row['sla_over'],
            'keterangan' => $row['keterangan'],
            'qty_material_out' => $row['qty_material_out'],
            'qty_material_in' => $row['qty_material_in'],
            'ms_regular' => $row['ms_regular'],
            'wo_date_apk' => $row['wo_date_apk'],
            'wo_date_mail_reschedule' => $row['wo_date_mail_reschedule'],
            'wo_date_slot_time_apk' => $row['wo_date_slot_time_apk'],
            'slot_time_assign_apk' => $row['slot_time_assign_apk'],
            'slot_time_apk_delay' => $row['slot_time_apk_delay'],
            'status_slot_time_apk_delay' => $row['status_slot_time_apk_delay'],
            'ket_delay_slot_time' => $row['ket_delay_slot_time'],
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
            'kabel_utp' => $row['kabel_utp'],
            'fast_connector' => $row['fast_connector'],
            'patchcord' => $row['patchcord'],
            'pipa' => $row['pipa'],
            'socket_pipa' => $row['socket_pipa'],
            'terminal_box' => $row['terminal_box'],
            'cable_duct' => $row['cable_duct'],
            'remote_fiberhome' => $row['remote_fiberhome'],
            'remote_extrem' => $row['remote_extrem'],
            'rj45' => $row['rj45'],
            'flexible' => $row['flexible'],
            'port_fat' => $row['port_fat'],
            'marker' => $row['marker'],
            'site_penagihan' => $row['site_penagihan'],
            'is_checked' => $row['is_checked'],
            'is_confirmation' => $row['is_confirmation'],
            'cek_telebot' => $row['cek_telebot'],
            'hasil_cek_telebot' => $row['hasil_cek_telebot'],
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
