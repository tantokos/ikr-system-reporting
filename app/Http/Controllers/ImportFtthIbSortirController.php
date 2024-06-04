<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportFtthIBSortir;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ImportFtthIbTemp;
use Illuminate\Support\Facades\DB;
use App\Models\ImportFtthIbSortirTemp;
use App\Models\DataFtthIbSortir;
use App\Models\DataFtthIbOri;
use Yajra\DataTables\DataTables;

class ImportFtthIbSortirController extends Controller
{
    public function index () {
        $akses = Auth::user()->name;
        $jmlData = ImportFtthIbTemp::where('login', '=', $akses)->count('no_wo');

        $sitePenagihan = ImportFtthIbTemp::where('login', '=', $akses)->select('site_penagihan')->distinct()->get();
        $penagihan = ImportFtthIbTemp::where('login', '=', $akses)->select('penagihan')->distinct()->orderBy('penagihan')->get();
        $branch = ImportFtthIbTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $kotamadyaPenagihan = ImportFtthIbTemp::where('login', '=', $akses)->select('kotamadya_penagihan')->distinct()->orderBy('kotamadya_penagihan')->get();
        $statWo = ImportFtthIbTemp::where('login', '=', $akses)->select('status_wo')->distinct()->get();

        // query data ORI
        $done = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $pending = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $cancel = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel')
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');

        $tglIkr = ImportFtthIbTemp::where('login', '=', $akses)->select(DB::raw('tgl_ikr'))->distinct()->get();

        $detPenagihan = ImportFtthIbTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        // end query data ORI

        // query data Sortir

        $doneSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Done')->get();

        $pendingSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Pending')->get();

        $cancelSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Cancel')->get();

        $donePendingSortir = $doneSortir->merge($pendingSortir);
        $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);


        $detPenagihanSortir = ImportFtthIbSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        // end query data Sortir

        $TglMin = $tglIkr->min('tgl_ikr');
        $TglMax = $tglIkr->max('tgl_ikr');

        $CekBulanThnImport = DataFtthIbOri::whereBetween('tgl_ikr',[$TglMin, $TglMax])->get();
        // dump($CekBulanThnImport->count());

        if($CekBulanThnImport->count() > 0) {
            $croscekData = "Data Tanggal $TglMin - $TglMax Sudah Pernah di Import";
        }
        else
        {
            $croscekData = "-";
        }


        return view('importWo.FtthIBSortirIndex', [
            'title' => 'Import Data FTTH IB', 'akses' => $akses, 'jmlImport' => $jmlData,
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel, 'sitePenagihan' => $sitePenagihan,
            'branch' => $branch, 'kotamadyaPenagihan' => $kotamadyaPenagihan, 'tglIkr' => $tglIkr, 'croscekData' => $croscekData,
            'statusWo' => $statWo, 'penagihan' => $penagihan,
            'detPenagihan' => $detPenagihan, //'detCouseCode' => $detCouseCode, 'detRootCouse' => $detRootCouse,
            'doneSortir' => $doneSortir->count(), 'pendingSortir' => $pendingSortir->count(), 'cancelSortir' => $cancelSortir->count(),
            'detPenagihanSortir' => $detPenagihanSortir, //'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function showData(Request $request){
        
    }

    public function dataImportFtthIBSortir(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFtthIbTemp::where('login', '=', $akses)->get();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function importFtthIBSortir(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFtthMT')) {

            $request->validate([
                'fileFtthMT' => ['required', 'mimes:xlsx,xls,csv']
            ]);

            $akses = Auth::user()->name;

            Excel::import(new ImportFtthIBSortir($akses), request()->file('fileFtthMT'));

            // $doneSortir = DB::table('import_ftth_ib_temps')->where('status_wo', '=', 'Done')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $pendingSortir = DB::table('import_ftth_ib_temps')->where('status_wo', '=', 'Pending')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->whereNotIn('no_wo', function ($p) {
            //         $p->select('no_wo')->from('import_ftth_ib_temps as import1')->where('status_wo', '=', 'Done');
            //     })
            //     ->whereNotIn('no_wo', function ($c) {
            //         $c->select('no_wo')->from('import_ftth_ib_temps as import2')->where('status_wo', '=', 'Cancel');
            //     })
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $cancelSortir = DB::table('import_ftth_ib_temps')->where('status_wo', '=', 'Cancel')->select(DB::raw('no_wo,max(tgl_ikr) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->whereNotIn('no_wo', function ($p) {
            //         $p->select('no_wo')->from('import_ftth_ib_temps as import1')->where('status_wo', '=', 'Done');
            //     })
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $donePendingSortir = $doneSortir->merge($pendingSortir);
            // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);

            // for ($x = 0; $x < $donePendingCancelSortir->count(); $x++) {

            //     $importFtthIBOri = ImportFtthIBTemp::where('no_wo', '=', $donePendingCancelSortir[$x]->no_wo)
            //         ->where('tgl_ikr', '=', $donePendingCancelSortir[$x]->tgl_ikr)->first();

            //     // dd($importFtthIBOri->no_wo);

            //     ImportFtthIBSortirTemp::create([

            //         'pic_monitoring' => $importFtthIBOri->pic_monitoring,
            //         'site' => $importFtthIBOri->site,
            //         'type_wo' => $importFtthIBOri->type_wo,
            //         'no_wo' => $importFtthIBOri->no_wo,
            //         'no_ticket' => $importFtthIBOri->no_ticket,
            //         'cust_id' => $importFtthIBOri->cust_id,
            //         'nama_cust' => $importFtthIBOri->nama_cust,
            //         'cust_address1' => $importFtthIBOri->cust_address1,
            //         'cust_address2' => $importFtthIBOri->cust_address2,
            //         'type_maintenance' => $importFtthIBOri->type_maintenance,
            //         'kode_fat' => $importFtthIBOri->kode_fat,
            //         'kode_wilayah' => $importFtthIBOri->kode_wilayah,
            //         'cluster' => $importFtthIBOri->cluster,
            //         'kotamadya' => $importFtthIBOri->kotamadya,
            //         'kotamadya_penagihan' => $importFtthIBOri->kotamadya_penagihan,
            //         'branch' => $importFtthIBOri->branch,
            //         'tgl_ikr' => $importFtthIBOri->tgl_ikr,
            //         'slot_time_leader' => $importFtthIBOri->slot_time_leader,
            //         'slot_time_apk' => $importFtthIBOri->slot_time_apk,
            //         'sesi' => $importFtthIBOri->sesi,
            //         'callsign' => $importFtthIBOri->callsign,
            //         'leader' => $importFtthIBOri->leader,
            //         'teknisi1' => $importFtthIBOri->teknisi1,
            //         'teknisi2' => $importFtthIBOri->teknisi2,
            //         'teknisi3' => $importFtthIBOri->teknisi3,
            //         'status_wo' => $importFtthIBOri->status_wo,
            //         'reason_status' => $importFtthIBOri->reason_status,
            //         'penagihan' => $importFtthIBOri->penagihan,
            //         'tgl_jam_reschedule' => $importFtthIBOri->tgl_jam_reschedule,
            //         'alasan_cancel' => $importFtthIBOri->alasan_cancel,
            //         'alasan_pending' => $importFtthIBOri->alasan_pending,
            //         'respon_konf_cst' => $importFtthIBOri->respon_konf_cst,
            //         'jawaban_konf_cst' => $importFtthIBOri->jawaban_konf_cst,
            //         'permintaan_reschedule' => $importFtthIBOri->permintaan_reschedule,
            //         'weather' => $importFtthIBOri->weather,
            //         'start_ikr_wa' => $importFtthIBOri->start_ikr_wa,
            //         'end_ikr_wa' => $importFtthIBOri->end_ikr_wa,
            //         'nama_dispatch' => $importFtthIBOri->nama_dispatch,
            //         'telp_dispatch' => $importFtthIBOri->telp_dispatch,
            //         'jam_tek_foto_rmh' => $importFtthIBOri->jam_tek_foto_rmh,
            //         'jam_dispatch_respon_foto' => $importFtthIBOri->jam_dispatch_respon_foto,
            //         'jam_teknisi_cek_fat' => $importFtthIBOri->jam_teknisi_cek_fat,
            //         'jam_dispatch_respon_fat' => $importFtthIBOri->jam_dispatch_respon_fat,
            //         'jam_teknisi_cek_port_fat' => $importFtthIBOri->jam_teknisi_cek_port_fat,
            //         'jam_dispatch_respon_port_fat' => $importFtthIBOri->jam_dispatch_respon_port_fat,
            //         'jam_teknisi_aktifasi_perangkat' => $importFtthIBOri->jam_teknisi_aktifasi_perangkat,
            //         'jam_dispatch_respon_aktifasi_perangkat' => $importFtthIBOri->jam_dispatch_respon_aktifasi_perangkat,
                    
            //         'validasi_start' => $importFtthIBOri->validasi_start,
            //         'validasi_end' => $importFtthIBOri->validasi_end,
            //         'otp_start' => $importFtthIBOri->otp_start,
            //         'otp_end' => $importFtthIBOri->otp_end,
            //         'checkin_apk' => $importFtthIBOri->checkin_apk,
            //         'checkout_apk' => $importFtthIBOri->checkout_apk,
            //         'status_apk' => $importFtthIBOri->status_apk,
            //         'keterangan' => $importFtthIBOri->keterangan,
            //         'ms_regular' => $importFtthIBOri->ms_regular,
            //         'wo_date_apk' => $importFtthIBOri->wo_date_apk,
            //         'wo_date_mail_reschedule' => $importFtthIBOri->wo_date_mail_reschedule,
            //         'wo_date_slot_time_apk' => $importFtthIBOri->wo_date_slot_time_apk,
                    
            //         'slot_time_assign_apk' => $importFtthIBOri->slot_time_assign_apk,
            //         'slot_time_apk_delay' => $importFtthIBOri->slot_time_apk_delay,
            //         'status_slot_time_apk_delay' => $importFtthIBOri->status_slot_time_apk_delay,
            //         'ket_delay_slot_time' => $importFtthIBOri->ket_delay_slot_time,

            //         'ont_merk_out' => $importFtthIBOri->ont_merk_out,
            //         'ont_sn_out' => $importFtthIBOri->ont_sn_out,
            //         'ont_mac_out' => $importFtthIBOri->ont_mac_out,
            //         'ont_merk_in' => $importFtthIBOri->ont_merk_in,
            //         'ont_sn_in' => $importFtthIBOri->ont_sn_in,
            //         'ont_mac_in' => $importFtthIBOri->ont_mac_in,
            //         'router_merk_out' => $importFtthIBOri->router_merk_out,
            //         'router_sn_out' => $importFtthIBOri->router_sn_out,
            //         'router_mac_out' => $importFtthIBOri->router_mac_out,
            //         'router_merk_in' => $importFtthIBOri->router_merk_in,
            //         'router_sn_in' => $importFtthIBOri->router_sn_in,
            //         'router_mac_in' => $importFtthIBOri->router_mac_in,
            //         'stb_merk_out' => $importFtthIBOri->stb_merk_out,
            //         'stb_sn_out' => $importFtthIBOri->stb_sn_out,
            //         'stb_mac_out' => $importFtthIBOri->stb_mac_out,
            //         'stb_merk_in' => $importFtthIBOri->stb_merk_in,
            //         'stb_sn_in' => $importFtthIBOri->stb_sn_in,
            //         'stb_mac_in' => $importFtthIBOri->stb_mac_in,
            //         'dw_out' => $importFtthIBOri->dw_out,
            //         'precon_out' => $importFtthIBOri->precon_out,

            //         'kabel_utp' => $importFtthIBOri->kabel_utp,
            //         'fast_connector' => $importFtthIBOri->fast_connector,
            //         'patchcord' => $importFtthIBOri->patchcord,
            //         'pipa' => $importFtthIBOri->pipa,
            //         'socket_pipa' => $importFtthIBOri->socket_pipa,
            //         'terminal_box' => $importFtthIBOri->terminal_box,
            //         'cable_duct' => $importFtthIBOri->cable_duct,
            //         // 'remote_fiberhome' => $importFtthIBOri->remote_fiberhome,
            //         // 'remote_extrem' => $importFtthIBOri->remote_extrem,
            //         'port_fat' => $importFtthIBOri->port_fat,
            //         'marker' => $importFtthIBOri->marker,
            //         'site_penagihan' => $importFtthIBOri->site_penagihan,
            //         // 'konfirmasi_penjadwalan' => $importFtthIBOri->konfirmasi_penjadwalan,
            //         // 'konfirmasi_cst' => $importFtthIBOri->konfirmasi_cst,
            //         // 'konfirmasi_dispatch' => $importFtthIBOri->konfirmasi_dispatch,
            //         // 'remark_status2' => $importFtthIBOri->remark_status2,
            //         'login' => $akses
            //     ]);
            // }

            return back();
        }
    }

    public function getFilterSummaryIB(Request $request)
    {
        
        $akses = Auth::user()->name;

        // query status data ORI
        $done = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $pending = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $cancel = ImportFtthIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        // end query status date ORI

        // query status data Sortir
        $doneSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Done'); //->count('status_wo'); //->get();

        $pendingSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Pending'); //->count('status_wo'); //->get();
    
        $cancelSortir = DB::table('import_ftth_ib_sortir_temps')->where('status_wo', '=', 'Cancel'); //->count('status_wo'); //->get();
    
        // $donePendingSortir = $doneSortir->merge($pendingSortir);
        // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);
        // end query status data Sortir

        $tglIkr = ImportFtthIbTemp::where('login', '=', $akses)->select(DB::raw('tgl_ikr'))->distinct()->get();

        $detPenagihan = ImportFtthIbTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_ftth_ib_temps.penagihan')
            ->where('root_couse_penagihan.type_wo','=','IB FTTH')
            ->select(DB::raw('import_ftth_ib_temps.penagihan, import_ftth_ib_temps.status_wo, count(import_ftth_ib_temps.penagihan) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        $detCouseCode = ImportFtthIbTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, reason_status, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        // $detRootCouse = ImportFtthIbTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);


        $detPenagihanSortir = ImportFtthIbSortirTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_ftth_ib_sortir_temps.penagihan')
            ->where('root_couse_penagihan.type_wo','=','IB FTTH')
            ->select(DB::raw('import_ftth_ib_sortir_temps.penagihan,import_ftth_ib_sortir_temps.status_wo, count(import_ftth_ib_sortir_temps.penagihan) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCodeSortir = ImportFtthIbSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, reason_status, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->distinct()
            // ->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        // $detRootCouseSortir = ImportFtthIbSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->distinct()
            // ->groupBy('penagihan', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        if ($request->filSitePenagihan != "ALL"){
            $detPenagihan = $detPenagihan->where('site_penagihan','=',$request->filSitePenagihan);
            $detCouseCode = $detCouseCode->where('site_penagihan','=',$request->filSitePenagihan);
            // $detRootCouse = $detRootCouse->where('site_penagihan','=',$request->filSitePenagihan);

            $detPenagihanSortir = $detPenagihanSortir->where('site_penagihan','=',$request->filSitePenagihan);
            $detCouseCodeSortir = $detCouseCodeSortir->where('site_penagihan','=',$request->filSitePenagihan);
            // $detRootCouseSortir = $detRootCouseSortir->where('site_penagihan','=',$request->filSitePenagihan);

        }
        if ($request->filBranch != "ALL"){
            $done = $done->where('branch', '=', $request->filBranch);            
            $pending = $pending->where('branch', '=', $request->filBranch);
            $cancel = $cancel->where('branch', '=', $request->filBranch);

            $doneSortir = $doneSortir->where('branch', '=', $request->filBranch);            
            $pendingSortir = $pendingSortir->where('branch', '=', $request->filBranch);
            $cancelSortir = $cancelSortir->where('branch', '=', $request->filBranch);

            $detPenagihan = $detPenagihan->where('branch','=',$request->filBranch);
            $detCouseCode = $detCouseCode->where('branch','=',$request->filBranch);
            // $detRootCouse = $detRootCouse->where('branch','=',$request->filBranch);

            $detPenagihanSortir = $detPenagihanSortir->where('branch','=',$request->filBranch);
            $detCouseCodeSortir = $detCouseCodeSortir->where('branch','=',$request->filBranch);
            // $detRootCouseSortir = $detRootCouseSortir->where('branch','=',$request->filBranch);

        }
        if ($request->filKotamadya != "ALL"){
            $detPenagihan = $detPenagihan->where('kotamadya','=',$request->filKotamadya);
            $detCouseCode = $detCouseCode->where('kotamadya','=',$request->filKotamadya);
            // $detRootCouse = $detRootCouse->where('kotamadya','=',$request->filKotamadya);

            $detPenagihanSortir = $detPenagihanSortir->where('kotamadya','=',$request->filKotamadya);
            $detCouseCodeSortir = $detCouseCodeSortir->where('kotamadya','=',$request->filKotamadya);
            // $detRootCouseSortir = $detRootCouseSortir->where('kotamadya','=',$request->filKotamadya);

        }
        if ($request->filRootPenagihan != "ALL"){
            $detPenagihan = $detPenagihan->where('import_ftth_ib_temps.penagihan','=',$request->filRootPenagihan);
            $detCouseCode = $detCouseCode->where('penagihan','=',$request->filRootPenagihan);
            // $detRootCouse = $detRootCouse->where('penagihan','=',$request->filRootPenagihan);

            $detPenagihanSortir = $detPenagihanSortir->where('import_ftth_ib_sortir_temps.penagihan','=',$request->filRootPenagihan);
            $detCouseCodeSortir = $detCouseCodeSortir->where('penagihan','=',$request->filRootPenagihan);
            // $detRootCouseSortir = $detRootCouseSortir->where('penagihan','=',$request->filRootPenagihan);

        }
        if ($request->filStatusWo != "ALL"){
            $detPenagihan = $detPenagihan->where('status_wo','=',$request->filStatusWo);
            $detCouseCode = $detCouseCode->where('status_wo','=',$request->filStatusWo);
            // $detRootCouse = $detRootCouse->where('status_wo','=',$request->filStatusWo);

            $detPenagihanSortir = $detPenagihanSortir->where('status_wo','=',$request->filStatusWo);
            $detCouseCodeSortir = $detCouseCodeSortir->where('status_wo','=',$request->filStatusWo);
            // $detRootCouseSortir = $detRootCouseSortir->where('status_wo','=',$request->filStatusWo);

        }
        if ($request->filTglIkr != "ALL"){
            $detPenagihan = $detPenagihan->where('tgl_ikr','=',$request->filTglIkr);
            $detCouseCode = $detCouseCode->where('tgl_ikr','=',$request->filTglIkr);
            // $detRootCouse = $detRootCouse->where('tgl_ikr','=',$request->filTglIkr);

            $detPenagihanSortir = $detPenagihanSortir->where('tgl_ikr','=',$request->filTglIkr);
            $detCouseCodeSortir = $detCouseCodeSortir->where('tgl_ikr','=',$request->filTglIkr);
            // $detRootCouseSortir = $detRootCouseSortir->where('tgl_ikr','=',$request->filTglIkr);
        }

        $done = $done->count('status_wo');
        $pending = $pending->count('status_wo');
        $cancel = $cancel->count('status_wo');

        $doneSortir = $doneSortir->count('status_wo'); //->get();
        $pendingSortir = $pendingSortir->count('status_wo'); //->get();
        $cancelSortir = $cancelSortir->count('status_wo'); //->get();

        $detPenagihan = $detPenagihan->groupBy('import_ftth_ib_temps.penagihan', 'import_ftth_ib_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCode = $detCouseCode->distinct()->groupBy('penagihan', 'status_wo', 'reason_status')->orderBy('penagihan')->get();
        // $detRootCouse = $detRootCouse->distinct()->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
     
        $detPenagihanSortir = $detPenagihanSortir->groupBy('import_ftth_ib_sortir_temps.penagihan', 'import_ftth_ib_sortir_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCodeSortir = $detCouseCodeSortir->groupBy('penagihan', 'status_wo', 'reason_status')->orderBy('penagihan')->get();
        // $detRootCouseSortir = $detRootCouseSortir->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        return response()->json([
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel,
            'doneSortir' => $doneSortir, 'pendingSortir' => $pendingSortir, 'cancelSortir' => $cancelSortir,
            'detPenagihan' => $detPenagihan, 'detCouseCode' => $detCouseCode, //'detRootCouse' => $detRootCouse,
            'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, //'detRootCouseSortir' => $detRootCouseSortir
            ]);
    }

    public function saveImportFtthIb(Request $request)
    {
        $akses = Auth::user()->name;

        switch ($request->input('action')) {

            case 'simpan':

                // ===== copy data Ftth MT Ori Temporary ke table Data Ftth MT Ori ======//
                $dataimportFtthIbOri = ImportFtthIbTemp::where('login', '=', $akses)->get()
                    ->each(function ($item) {
                        $dataFtthIbOri = $item->replicate();
                        $dataFtthIbOri->setTable('data_ftth_ib_oris');
                        $dataFtthIbOri->save();
                    });

                if ($dataimportFtthIbOri) {

                    // ==== copy data Ftth Mt Sortir Temporary ke table Data Ftth Mt Sortir =======//
                    $dataimportFtthIbSortir = ImportFtthIbSortirTemp::where('login', '=', $akses)->get()
                        ->each(function ($item) {
                            $dataFtthIbSortir = $item->replicate();
                            $dataFtthIbSortir->setTable('data_ftth_ib_sortirs');
                            $dataFtthIbSortir->save();
                        });

                    ImportFtthIbTemp::where('login', '=', $akses)->delete();
                    ImportFtthIbSortirTemp::where('login', '=', $akses)->delete();
                }

                break;

            case 'batal':
                ImportFtthIbTemp::where('login', '=', $akses)->delete();
                ImportFtthIbSortirTemp::where('login', '=', $akses)->delete();

                break;
        }

        return back();
    }
}
