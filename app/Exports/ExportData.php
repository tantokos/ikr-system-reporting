<?php

namespace App\Exports;

use App\Models\DataFtthDismantleOri;
use App\Models\DataFtthDismantleSortir;
use App\Models\DataFtthIbOri;
use App\Models\DataFtthIbSortir;
use App\Models\DataFtthMtOri;
use App\Models\DataFtthMtSortir;
use App\Models\DataFttxIbOri;
use App\Models\DataFttxIbSortir;
use App\Models\DataFttxMtOri;
use App\Models\DataFttxMtSortir;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

// class FtthIbSortirExport implements FromQuery
class ExportData implements FromCollection, WithHeadings, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    protected $data, $type_wo, $bulan, $tahun;

    public function __construct($data, $type_wo, $bulan , $tahun)
    {
        $this->data =$data;
        $this->type_wo = $type_wo;    
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function collection()
    {
        ini_set('max_execution_time', 1900);
        ini_set('memory_limit', '8192M');

        switch ($this->data){
            case 'sortir':

                switch ($this->type_wo){
                    case 'FTTH IB':
                        //get list material
                        $listMaterial = DB::table('list_material')
                                        ->select(DB::raw('lower(replace(kategori_material, " ","_")) as kategori'))
                                        ->select('kategori_material as kategori')
                                        ->distinct()->get();

                        //get sub query material IB berdasarkan list material
                        DB::enableQueryLog();
                        $materialIb = DB::table('ftth_ib_materials as ibm')
                                    ->select('ibm.wo_no',DB::raw('str_to_date(ibm.installation_date, "%d-%m-%Y") as installation_date'))->distinct()
                                    ->whereMonth(DB::raw('str_to_date(ibm.installation_date, "%d-%m-%Y")'), $this->bulan)
                                    ->whereYear(DB::raw('str_to_date(ibm.installation_date, "%d-%m-%Y")'), $this->tahun);

                        for($x=0; $x < count($listMaterial); $x++) {
                            $kategori = $listMaterial[$x]->kategori;
                            $asKate = Str::lower(Str::replace(' ','_', $listMaterial[$x]->kategori));

                            $materialIb = $materialIb->leftJoinSub(
                                DB::table('ftth_ib_materials')
                                    ->select([
                                        'wo_no',
                                        'installation_date',
                                        DB::raw('GROUP_CONCAT(description SEPARATOR ", ") as merk_'.$asKate.'_out'),
                                        DB::raw('GROUP_CONCAT(sn SEPARATOR ", ") as sn_'.$asKate.'_out'),
                                        DB::raw('GROUP_CONCAT(mac_address SEPARATOR ", ") as mac_'.$asKate.'_out'),
                                        DB::raw('GROUP_CONCAT(qty SEPARATOR ", ") as qty_'.$asKate.'_out'),
                                        DB::raw('GROUP_CONCAT(material_condition SEPARATOR ", ") as condition_'.$asKate.'_out')
                                    ])
                                    ->where('status_item', 'OUT')
                                    ->where('kategori_material', $kategori)
                                    ->whereMonth(DB::raw('str_to_date(installation_date, "%d-%m-%Y")'), $this->bulan)
                                    ->whereYear(DB::raw('str_to_date(installation_date, "%d-%m-%Y")'), $this->tahun)
                                    ->groupBy(['wo_no', 'installation_date']),
                                $asKate.'_out',
                                function($join) use($asKate) {
                                    $join->on('ibm.wo_no', '=', $asKate.'_out.wo_no')
                                        ->on('ibm.installation_date', '=', $asKate.'_out.installation_date');
                                }
                            );

                            $materialIb = $materialIb->addSelect($asKate.'_out.merk_'.$asKate.'_out',
                                                                $asKate.'_out.sn_'.$asKate.'_out',
                                                                $asKate.'_out.mac_'.$asKate.'_out',
                                                                $asKate.'_out.qty_'.$asKate.'_out',
                                                                $asKate.'_out.condition_'.$asKate.'_out');

                            $materialIb = $materialIb->leftJoinSub(
                                DB::table('ftth_ib_materials')
                                    ->select([
                                        'wo_no',
                                        'installation_date',
                                        DB::raw('GROUP_CONCAT(description SEPARATOR ", ") as merk_'.$asKate.'_in'),
                                        DB::raw('GROUP_CONCAT(sn SEPARATOR ", ") as sn_'.$asKate.'_in'),
                                        DB::raw('GROUP_CONCAT(mac_address SEPARATOR ", ") as mac_'.$asKate.'_in'),
                                        DB::raw('GROUP_CONCAT(qty SEPARATOR ", ") as qty_'.$asKate.'_in'),
                                        DB::raw('GROUP_CONCAT(material_condition SEPARATOR ", ") as condition_'.$asKate.'_in')
                                    ])
                                    ->where('status_item', 'IN')
                                    ->where('kategori_material', $kategori)
                                    ->whereMonth(DB::raw('str_to_date(installation_date, "%d-%m-%Y")'), $this->bulan)
                                    ->whereYear(DB::raw('str_to_date(installation_date, "%d-%m-%Y")'), $this->tahun)
                                    ->groupBy(['wo_no', 'installation_date']),
                                $asKate.'_in',
                                function($join) use($asKate) {
                                    $join->on('ibm.wo_no', '=', $asKate.'_in.wo_no')
                                        ->on('ibm.installation_date', '=', $asKate.'_in.installation_date');
                                }
                            );

                            $materialIb = $materialIb->addSelect($asKate.'_in.merk_'.$asKate.'_in',
                                                                $asKate.'_in.sn_'.$asKate.'_in',
                                                                $asKate.'_in.mac_'.$asKate.'_in',
                                                                $asKate.'_in.qty_'.$asKate.'_in',
                                                                $asKate.'_in.condition_'.$asKate.'_in');
                        }

                        $datas = DB::table('data_ftth_ib_oris as d')
                            ->whereMonth('d.tgl_ikr', $this->bulan)
                            ->whereYear('d.tgl_ikr', $this->tahun)
                            ->leftJoin('data_assign_tims as da', function ($join) {
                                $join->on('d.no_wo','=','da.no_wo_apk');
                                $join->on('d.tgl_ikr', '=', 'da.tgl_ikr');
                            })
                            ->leftJoinSub($materialIb, 'material', function($j) {
                                $j->on('d.no_wo','=', 'material.wo_no');
                                $j->on('d.tgl_ikr','=',DB::raw('material.installation_date'));
                            })
                            ->select(
                                'd.site','d.no_wo', 'd.wo_date_apk', DB::raw('"IB" as type_wo'), 'd.wo_type_apk',
                                DB::raw('d.wo_type_apk as remarks_wo_ib'), 'd.sesi', 'd.no_ticket', 'd.cust_id',
                                DB::raw('TRIM(d.nama_cust) AS nama_cust'), 'd.cust_address1', 'da.cust_mobile_apk',
                                'd.kode_fat', 'd.port_fat', 'd.kode_fat_relokasi', 'd.port_fat_relokasi',
                                DB::raw("date_format(d.tgl_ikr, '%Y-%m-%d') as tgl_ikr"), 'd.slot_time_apk', 'd.checkin_apk',
                                DB::raw('"-" as minute'),
                                'd.status_checkin',
                                'd.checkout_apk',
                                DB::raw('NULL as waktu_Installasi'),
                                DB::raw('NULL as mttr_all'),
                                DB::raw('NULL as mttr_pending'),
                                DB::raw('NULL as mttr_progress'),
                                DB::raw('NULL as mttr_technician'),
                                'd.sla_over', 'd.cluster', 'd.kotamadya', 'd.branch', 'd.kotamadya_penagihan', 'd.callsign',
                                'd.teknisi1', 'd.teknisi2', 'd.teknisi3', 'd.teknisi4', 'd.leader', 'd.pic_monitoring',
                                DB::raw("'Raden Feby Prihadi' as pic_pengecekan"),
                                'd.status_apk', 'd.status_wo', 'd.penagihan', 'd.reason_status',
                                DB::raw('d.detail_reason as root_cause'), DB::raw("'' as action_taken"),
                                'd.action_status', 'd.detail_alasan', 'd.visit_novisit',
                                DB::raw('concat("\'", d.remarks_teknisi) as remarks_teknisi'),'d.tgl_reschedule',
                                'd.respon_konf_cst', 'd.jawaban_konf_cst', 'd.permintaan_reschedule', 'd.nama_dispatch',
                                'd.telp_dispatch', 'd.cek_telebot', 'd.hasil_cek_telebot', 'd.weather', 'd.jam_tek_foto_rmh',
                                'd.jam_dispatch_respon_foto', 'd.jam_teknisi_cek_fat', 'd.jam_dispatch_respon_fat', 'd.validasi_start',
                                'd.validasi_end', 'd.start_regist', 'd.end_regist',
                                DB::raw("'' as kode_otp"),
                                DB::raw("'' as pic_konfirmasi_cst"),
                                DB::raw("'' as status_konfirmasi_customer"),
                                DB::raw("'' as tgl_jam_konfirmasi"),
                                DB::raw("'' as selisih_menit_konfirmasi"),
                                DB::raw("'' as status_konfirmasi_cst"),
                                DB::raw("'' as waktu_keterlambatan_konfirmasi"),
                                DB::raw("'' as bukti_konfirmasi"),
                                'd.qty_material_out as material_out', 'd.qty_material_in as material_in',
                                'material.merk_ont_out',
                                'material.sn_ont_out',
                                'material.mac_ont_out',
                                'material.merk_ont_in',
                                'material.sn_ont_in',
                                'material.mac_ont_in',
                                'material.condition_ont_in',
                                'material.merk_router_out',
                                'material.sn_router_out',
                                'material.mac_router_out',
                                'material.merk_router_in',
                                'material.sn_router_in',
                                'material.mac_router_in',
                                'material.condition_router_in',
                                'material.merk_stb_out',
                                'material.sn_stb_out',
                                'material.mac_stb_out',
                                'material.merk_stb_in',
                                'material.sn_stb_in',
                                'material.mac_stb_in',
                                'material.condition_stb_in',
                                'material.merk_remote_out',
                                'material.merk_remote_in',
                                'material.qty_dw_out',
                                'material.merk_precon_out',
                                DB::raw('NULL as precon_in'),
                                'material.qty_fast_connector_out',
                                'material.qty_patchcord_out',
                                'material.qty_terminal_box_out',
                                'material.qty_utp_out',
                                'material.qty_pvc_pipe_out',
                                'material.qty_socket_pipe_out',
                                'material.qty_cable_duct_out',
                                // DB::raw("'' as precon_in")
                            )
                            ->orderBy('d.tgl_ikr', 'DESC')
                            ->get();

                        // dd($datas);
                        // return DataFtthIbSortir::query()
                        //                         ->whereMonth('tgl_ikr', $this->bulan)
                        //                         ->whereYear('tgl_ikr', $this->tahun);

                        $collection = $datas->map(function ($item, $key) {
                            $item->minute = '=IF(OR(S'.($key + 2).'="",S'.($key + 2).'="0000-00-00 00:00:00"),"No Checkin",(CONCATENATE(TEXT(Q'.($key + 2).',"yyyy-mm-dd")&" "&TEXT(R'.($key + 2).',"hh:mm:ss"))-S'.($key + 2).')*1440)';
                            $item->status_checkin = '=IF(T'.($key + 2).'="No Checkin", "No Checkin",IF(T'.($key + 2).'<0,"Terlambat","On Time"))';
                            $item->waktu_Installasi = '=IF(AND(AP'.($key + 2).'="Done",AO'.($key + 2).'="cancelled"),0,IF(OR(AP'.($key + 2).'="done",AO'.($key + 2).'="CHECKOUT"),(V'.($key + 2).'-S'.($key + 2).'),0))';
                            $item->material_in = '=COUNTA(CC'.($key + 2).',CJ'.($key + 2).',CQ'.($key + 2).',CV'.($key + 2).')';
                            $item->material_out = '=COUNTA(BZ'.($key + 2).',CG'.($key + 2).',CN'.($key + 2).',CU'.($key + 2).',CW'.($key + 2).',CX'.($key + 2).',CZ'.($key + 2).',DA'.($key + 2).',DB'.($key + 2).',DC'.($key + 2).',DD'.($key + 2).',DE'.($key + 2).',DF'.($key + 2).',DG'.($key + 2).')';
                            $item->sla_over = '=IF(T'.($key + 2).'>=-60,"0%",IF(AND(T'.($key + 2).'<-60,T'.($key + 2).'>-120),"20%",IF(T'.($key + 2).'<-120,"30%")))';

                            // $item->sla_over = '=IF(U1>=-60;"0%";IF(AND(U1<-60;U1>-120);"20%";IF(U1<-120;"30%")))';
                            return $item;
                        });

                        return $collection;
                        break;

                    case 'FTTH MT':
                        return DataFtthMtSortir::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;

                    case 'FTTH Dismantle':
                        return DataFtthDismantleSortir::query()
                                                ->whereMonth('visit_date', $this->bulan)
                                                ->whereYear('visit_date', $this->tahun);
                        break;

                    case 'FTTX IB':
                        return DataFttxIbSortir::query()
                                                ->whereMonth('ib_date', $this->bulan)
                                                ->whereYear('ib_date', $this->tahun);
                        break;

                    case 'FTTX MT':
                        return DataFttxMtSortir::query()
                                                ->whereMonth('mt_date', $this->bulan)
                                                ->whereYear('mt_date', $this->tahun);
                        break;

                }
                break;

            case 'ori':

                switch ($this->type_wo){
                    case 'FTTH IB':
                        return DataFtthIbOri::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;
    
                    case 'FTTH MT':
                        return DataFtthMtOri::query()
                                                ->whereMonth('tgl_ikr', $this->bulan)
                                                ->whereYear('tgl_ikr', $this->tahun);
                        break;
    
                    case 'FTTH Dismantle':
                        return DataFtthDismantleOri::query()
                                                ->whereMonth('visit_date', $this->bulan)
                                                ->whereYear('visit_date', $this->tahun);
                        break;
    
                    case 'FTTX IB':
                        return DataFttxIbOri::query()
                                                ->whereMonth('ib_date', $this->bulan)
                                                ->whereYear('ib_date', $this->tahun);
                        break;
    
                    case 'FTTX MT':
                        return DataFttxMtOri::query()
                                                ->whereMonth('mt_date', $this->bulan)
                                                ->whereYear('mt_date', $this->tahun);
                        break;
    
                    }
                    break;
        }

    }

    public function headings(): array 
    {
        // return array_keys($this->query()->first()->toArray());

        return [
            'Site',
            'No Wo',
            'WO Date',
            'Type Wo',
            'Wo Type Apk',
            'Remarks WO',
            'Sesi',
            'No Ticket',
            'Cust Id',
            'Nama Cust',
            'Alamat Customer',
            'No Hp',
            'Kode FAT',
            'Port FAT',
            'Kode FAT Relokasi',
            'Port FAT Relokasi',
            'IKR Date',
            'Slot Time',
            'Check In (Aplikasi)',
            '+/-Minute',
            'Status Checkin',
            'Check Out (Aplikasi)',
            'Waktu Instalasi (Aplikasi)',
            'MTTR All',
            'MTTR Pending',
            'MTTR Progress',
            'MTTR Technician',
            'SLA Over',
            'Cluster',
            'Kotamadya',
            'Branch',
            'Kotamadya Penagihan',
            'Call sign',
            'Teknisi 1',
            'Teknisi 2',
            'Teknisi 3',
            'Teknisi 4',
            'Leader',
            'PIC Input',
            'PIC Pengecekan',
            'Status Aplikasi',
            'Status Progress',
            'Root Cause Penagihan',
            'Couse Code / Reason Status',
            'Root Cause',
            'Action Taken',
            'Action Status',
            'Detail Alasan',
            'Status Visit',
            'Report Teknisi',
            'Tanggal & Jam Reschedule Customer',
            'Respon Konfirmasi Cst (Respon/Tidak Respon)',
            'Jawaban Konfirmasi Cst (Setuju/Tidak Setuju/No Respon)',
            'Permintaan Reschedule (Leader/Teknisi/Customer/Dispatch)',
            'Nama Dispatch Konfirmasi',
            'No Telp Dispatch Konfirmasi',
            'Cek Telebot',
            'Hasil Cek Telebot',
            'Weather',
            'Jam Teknisi Foto Rumah',
            'Jam Respon Dispatch Foto Rumah',
            'Jam Teknisi Cek FAT',
            'Jam Respon Dispatch Cek FAT',
            'Validasi Start',
            'Validasi End',
            'Start Regist',
            'End Regist',
            'Kode OTP',
            'PIC Konfirmasi Cst',
            'Status Konfirmasi Cst',
            'Tgl IKR & Jam Konfirmasi Cst',
            '+/- Minute Konfirmasi',
            'Keterangan Konfirmasi Cst',
            'Waktu Keterlambatan Konfirmasi',
            'Bukti Konfirmasi',
            'Qty Material Out',
            'Qty Material In',
            'Merk ONT Out',
            'SN Ont Out',
            'Mac Ont Out',
            'Merk Ont In',
            'SN Ont In',
            'Mac Ont In',
            'Condition Ont In',
            'Merk Router Out',
            'SN Router Out',
            'Mac Router Out',
            'Merk Router In',
            'SN Router In',
            'Mac Router In',
            'Condition Router In',
            'Merk STB Out',
            'SN STB Out',
            'Mac STB Out',
            'Merk STB In',
            'SN STB In',
            'Mac STB In',
            'Condition STB In',
            'Remot Out',
            'Remot In',
            'Aerial drop cable DW',
            'Precon Out',
            'Precon In',
            'Fast Connector',
            'Patch Cord',
            'Terminal Box',
            'Kabel UTP',
            'Pipa',
            'Socket Pipa',
            'Cable Duct',
            'RJ45',
            'FLEXIBLE CONDUIT 20 MM',
        ];
    }

    public function columnFormats(): array
    {
        return [
            
        ];
    }
}
