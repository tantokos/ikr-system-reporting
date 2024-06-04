<?php

namespace App\Imports;

use App\Models\DataFtthIbSortir;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use \PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportFtthIBSortir implements ToModel, WithHeadingRow
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
        return new DataFtthIbSortir([
            'pic_monitoring' => $row['pic_monitoring'],
            'site' => $row['site'],
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
            'callsign' => $row['callsign'],
            'leader' => $row['leader'],
            'teknisi1' => $row['teknisi1'],
            'teknisi2' => $row['teknisi2'],
            'teknisi3' => $row['teknisi3'],
            'status_wo' => $row['status_wo'],
            'reason_status' => $row['reason_status'],
            'penagihan' => $row['penagihan'],
            'tgl_jam_reschedule' => $row['tgl_jam_reschedule'],
            'alasan_cancel' => $row['alasan_cancel'],
            'alasan_pending' => $row['alasan_pending'],
            'respon_konf_cst' => $row['respon_konf_cst'],
            'jawaban_konf_cst' => $row['jawaban_konf_cst'],
            'permintaan_reschedule' =>$row['permintaan_reschedule'],
            'weather' => $row['weather'],
            'start_ikr_wa' => $row['start_ikr_wa'],
            'end_ikr_wa' => $row['end_ikr_wa'],
            'nama_dispatch' => $row['nama_dispatch'],
            'telp_dispatch' => $row['telp_dispatch'],
            'jam_tek_foto_rmh' => $row['jam_tek_foto_rmh'],
            'jam_dispatch_respon_foto' => $row['jam_dispatch_respon_foto'],
            'jam_teknisi_cek_fat' => $row['jam_teknisi_cek_fat'],
            'jam_dispatch_respon_fat' => $row['jam_dispatch_respon_fat'],
            'jam_teknisi_cek_port_fat' => $row['jam_teknisi_cek_port_fat'],
            'jam_dispatch_respon_port_fat' => $row['jam_dispatch_respon_port_fat'],
            'jam_teknisi_aktifasi_perangkat' => $row['jam_teknisi_aktifasi_perangkat'],
            'jam_dispatch_respon_aktifasi_perangkat' => $row['jam_dispatch_respon_aktifasi_perangkat'],
            'validasi_start' => $row['validasi_start'],
            'validasi_end' => $row['validasi_end'],
            'otp_start' => $row['otp_start'],
            'otp_end' => $row['otp_end'],

            'checkin_apk' => $row['checkin_apk'],
            'checkout_apk' => $row['checkout_apk'],
            'status_apk' => $row['status_apk'],
            'keterangan' => $row['keterangan'],
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

            'kabel_utp' => $row['kabel_utp'],
            'fast_connector' => $row['fast_connector'],
            'patchcord' => $row['patchcord'],
            'pipa' => $row['pipa'],
            'socket_pipa' => $row['socket_pipa'],
            'terminal_box' => $row['terminal_box'],
            'cable_duct' => $row['cable_duct'],
            // 'remote_fiberhome' => $row['remote_fiberhome'],
            // 'remote_extrem' => $row['remote_extrem'],
            'port_fat' => $row['port_fat'],
            'marker' => $row['marker'],
            'site_penagihan' => $row['site_penagihan'],
            'login' => $this->login
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
