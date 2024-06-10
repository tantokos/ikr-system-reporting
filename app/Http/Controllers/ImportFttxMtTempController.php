<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\ImportFttxMT;
use App\Imports\ImportFttxMTSortir;
use App\Models\DataFttxMtOri;
use App\Models\ImportFttxMtSortirTemp;
use App\Models\ImportFttxMtTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ImportFttxMtTempController extends Controller
{
    public function index () {
        $akses = Auth::user()->name;
        $jmlData = ImportFttxMtTemp::where('login', '=', $akses)->count('no_wo');

        $sitePenagihan = ImportFttxMtTemp::where('login', '=', $akses)->select('action_taken')->distinct()->get();
        $penagihan = ImportFttxMtTemp::where('login', '=', $akses)->select('action_taken')->distinct()->orderBy('action_taken')->get();
        $branch = ImportFttxMtTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $kotamadyaPenagihan = ImportFttxMtTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $statWo = ImportFttxMtTemp::where('login', '=', $akses)->select('status_wo')->distinct()->get();

        // query data ORI
        $done = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $pending = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $cancel = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');

        $tglIkr = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('mt_date'))->distinct()->get();

        $detPenagihan = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('action_taken, count(action_taken) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('action_taken')->orderBy('action_taken')->get();

        // end query data ORI

        // query data Sortir

        $doneSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Done')->get();

        $pendingSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Pending')->get();

        $cancelSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Cancel')->get();

        $donePendingSortir = $doneSortir->merge($pendingSortir);
        $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);


        $detPenagihanSortir = ImportFttxMtSortirTemp::where('login', '=', $akses)->select(DB::raw('action_taken, count(action_taken) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('action_taken')->orderBy('action_taken')->get();

        // end query data Sortir

        $TglMin = $tglIkr->min('mt_date');
        $TglMax = $tglIkr->max('mt_date');

        $CekBulanThnImport = DataFttxMtOri::whereBetween('mt_date',[$TglMin, $TglMax])->get();
        // dump($CekBulanThnImport->count());

        if($CekBulanThnImport->count() > 0) {
            $croscekData = "Data Tanggal $TglMin - $TglMax Sudah Pernah di Import";
        }
        else
        {
            $croscekData = "-";
        }


        return view('importWo.FttxMTTempIndex', [
            'title' => 'Import Data FTTX MT', 'akses' => $akses, 'jmlImport' => $jmlData,
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

    public function dataImportFttxMtTemp(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFttxMtTemp::where('login', '=', $akses)->get();
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

    public function importFttxMtTemp(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFttxMTOri')) {

            $request->validate([
                'fileFttxMTOri' => ['required', 'mimes:xlsx,xls,csv'],
                'fileFttxMTSortir' => ['required', 'mimes:xlsx,xls,csv']
            ]);

            $akses = Auth::user()->name;

            Excel::import(new ImportFttxMT($akses), request()->file('fileFttxMTOri'));
            Excel::import(new ImportFttxMTSortir($akses), request()->file('fileFttxMTSortir'));

            // $doneSortir = DB::table('import_fttx_mt_temps')->where('status_wo', '=', 'Done')->select(DB::raw('no_wo,max(mt_date) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $pendingSortir = DB::table('import_fttx_mt_temps')->where('status_wo', '=', 'Pending')->select(DB::raw('no_wo,max(mt_date) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->whereNotIn('no_wo', function ($p) {
            //         $p->select('no_wo')->from('import_fttx_mt_temps as import1')->where('status_wo', '=', 'Done');
            //     })
            //     ->whereNotIn('no_wo', function ($c) {
            //         $c->select('no_wo')->from('import_fttx_mt_temps as import2')->where('status_wo', '=', 'Cancel');
            //     })
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $cancelSortir = DB::table('import_fttx_mt_temps')->where('status_wo', '=', 'Cancel')->select(DB::raw('no_wo,max(mt_date) as tgl_ikr'))
            //     // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            //     ->whereNotIn('no_wo', function ($p) {
            //         $p->select('no_wo')->from('import_fttx_mt_temps as import1')->where('status_wo', '=', 'Done');
            //     })
            //     ->orderBy('no_wo')
            //     ->groupBy('no_wo')->get();

            // $donePendingSortir = $doneSortir->merge($pendingSortir);
            // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);

            // for ($x = 0; $x < $donePendingCancelSortir->count(); $x++) {

            //     $ImportFttxMTOri = ImportFttxMtTemp::where('no_wo', '=', $donePendingCancelSortir[$x]->no_wo)
            //         ->where('mt_date', '=', $donePendingCancelSortir[$x]->tgl_ikr)->first();

            //     // dd($importFtthIBOri->no_wo);

            //     ImportFttxMtSortirTemp::create([
            //         'no_so' => $ImportFttxMTOri->no_so,
            //         'no_wo' => $ImportFttxMTOri->no_wo,
            //         'wo_date' => $ImportFttxMTOri->wo_date,
            //         'mt_date' => $ImportFttxMTOri->mt_date,
            //         'wo_type' => $ImportFttxMTOri->wo_type,
            //         'cust_name' => $ImportFttxMTOri->cust_name,
            //         'cust_address' => $ImportFttxMTOri->cust_address,
            //         'area' => $ImportFttxMTOri->area,
            //         'site' => $ImportFttxMTOri->site,
            //         'packages_type' => $ImportFttxMTOri->packages_type,
            //         'service_type' => $ImportFttxMTOri->service_type,
            //         'slot_time' => $ImportFttxMTOri->slot_time,
            //         'teknisi1' => $ImportFttxMTOri->teknisi1,
            //         'teknisi2' => $ImportFttxMTOri->teknisi2,
            //         'teknisi3' => $ImportFttxMTOri->teknisi3,
            //         'leader' => $ImportFttxMTOri->leader,
            //         'branch' => $ImportFttxMTOri->branch,
            //         'callsign' => $ImportFttxMTOri->callsign,
            //         'nopol' => $ImportFttxMTOri->nopol,
            //         'start' => $ImportFttxMTOri->start,
            //         'finish' => $ImportFttxMTOri->finish,
            //         'report_wa' => $ImportFttxMTOri->report_wa,
            //         'fdt_code' => $ImportFttxMTOri->fdt_code,
            //         'fat_code' => $ImportFttxMTOri->fat_code,
            //         'fat_port' => $ImportFttxMTOri->fat_port,
            //         'signal_fat' => $ImportFttxMTOri->signal_fat,
            //         'signal_tb' => $ImportFttxMTOri->signal_tb,
            //         'signal_ont' => $ImportFttxMTOri->signal_ont,
            //         'ont_sn_out' => $ImportFttxMTOri->ont_sn_out,
            //         'ont_mac_out' => $ImportFttxMTOri->ont_mac_out,
            //         'ont_sn_in' => $ImportFttxMTOri->ont_sn_in,
            //         'ont_mac_in' => $ImportFttxMTOri->ont_mac_in,
            //         'stb2_sn' => $ImportFttxMTOri->stb2_sn,
            //         'stb2_mac' => $ImportFttxMTOri->stb2_mac,
            //         'stb3_sn' => $ImportFttxMTOri->stb3_sn,
            //         'stb3_mac' => $ImportFttxMTOri->stb3_mac,
            //         'router_sn' => $ImportFttxMTOri->router_sn,
            //         'router_mac' => $ImportFttxMTOri->router_mac,
            //         'drop_cable' => $ImportFttxMTOri->drop_cable,
            //         'precon' => $ImportFttxMTOri->precon,
            //         'fast_connector' => $ImportFttxMTOri->fast_connector,
            //         'termination_box' => $ImportFttxMTOri->termination_box,
            //         'patch_cord_3m' => $ImportFttxMTOri->patch_cord_3m,
            //         'patch_cord_10m' => $ImportFttxMTOri->patch_cord_10m,
            //         'screw_hanger' => $ImportFttxMTOri->screw_hanger,
            //         'indor_cable_duct' => $ImportFttxMTOri->indor_cable_duct,
            //         'pvc_pipe_20mm' => $ImportFttxMTOri->pvc_pipe_20mm,
            //         'socket_pvc_20mm' => $ImportFttxMTOri->socket_pvc_20mm,
            //         'clamp_pvc_20mm' => $ImportFttxMTOri->clamp_pvc_20mm,
            //         'flexible_pvc_20mm' => $ImportFttxMTOri->flexible_pvc_20mm,
            //         'clamp_cable' => $ImportFttxMTOri->clamp_cable,
            //         'cable_lan' => $ImportFttxMTOri->cable_lan,
            //         'connector_rj45' => $ImportFttxMTOri->connector_rj45,
            //         'cable_marker' => $ImportFttxMTOri->cable_marker,
            //         'insulation' => $ImportFttxMTOri->insulation,
            //         'cable_ties' => $ImportFttxMTOri->cable_ties,
            //         'adapter_optic' => $ImportFttxMTOri->adapter_optic,
            //         'fisher' => $ImportFttxMTOri->fisher,
            //         'paku_beton' => $ImportFttxMTOri->paku_beton,
            //         'splitter' => $ImportFttxMTOri->splitter,
            //         'status_wo' => $ImportFttxMTOri->status_wo,
            //         'root_couse' => $ImportFttxMTOri->root_couse,
            //         'action_taken' => $ImportFttxMTOri->action_taken,
            //         'remarks' => $ImportFttxMTOri->remarks,

            //         'login' => $akses
            //     ]);
            // }

            return back();
        }
    }

    public function getFilterSummaryFttxMT(Request $request)
    {
        
        $akses = Auth::user()->name;

        // query status data ORI
        $done = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $pending = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $cancel = ImportFttxMtTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        // end query status date ORI

        // query status data Sortir
        $doneSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Done'); //->count('status_wo'); //->get();

        $pendingSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Pending'); //->count('status_wo'); //->get();
    
        $cancelSortir = DB::table('import_fttx_mt_sortir_temps')->where('status_wo', '=', 'Cancel'); //->count('status_wo'); //->get();
    
        // $donePendingSortir = $doneSortir->merge($pendingSortir);
        // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);
        // end query status data Sortir

        $tglIkr = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('mt_date'))->distinct()->get();

        $detPenagihan = ImportFttxMtTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_fttx_mt_temps.action_taken')
            ->where('root_couse_penagihan.type_wo','=','MT FTTX')
            ->select(DB::raw('import_fttx_mt_temps.action_taken, import_fttx_mt_temps.status_wo, count(import_fttx_mt_temps.action_taken) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        $detCouseCode = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('action_taken, status_wo, root_couse, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        // $detRootCouse = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);


        $detPenagihanSortir = ImportFttxMtSortirTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_fttx_mt_sortir_temps.action_taken')
            ->where('root_couse_penagihan.type_wo','=','MT FTTX')
            ->select(DB::raw('import_fttx_mt_sortir_temps.action_taken,import_fttx_mt_sortir_temps.status_wo, count(import_fttx_mt_sortir_temps.action_taken) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCodeSortir = ImportFttxMtSortirTemp::where('login', '=', $akses)->select(DB::raw('action_taken, status_wo, root_couse, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', action_takenAdditional']);
            // ->distinct();
            // ->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        // $detRootCouseSortir = ImportFttxMtSortirTemp::where('login', '=', $akses)->select(DB::raw('action_taken, action_taken couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', action_takenAdditional']);
            // action_taken->distinct()
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
            $detPenagihan = $detPenagihan->where('import_fttx_mt_temps.action_taken','=',$request->filRootPenagihan);
            $detCouseCode = $detCouseCode->where('action_taken','=',$request->filRootPenagihan);
            // $detRootCouse = $detRootCouse->where('penagihan','=',$request->filRootPenagihan);

            $detPenagihanSortir = $detPenagihanSortir->where('import_fttx_mt_sortir_temps.action_taken','=',$request->filRootPenagihan);
            $detCouseCodeSortir = $detCouseCodeSortir->where('action_taken','=',$request->filRootPenagihan);
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
            $detPenagihan = $detPenagihan->where('mt_date','=',$request->filTglIkr);
            $detCouseCode = $detCouseCode->where('mt_date','=',$request->filTglIkr);
            // $detRootCouse = $detRootCouse->where('tgl_ikr','=',$request->filTglIkr);

            $detPenagihanSortir = $detPenagihanSortir->where('mt_date','=',$request->filTglIkr);
            $detCouseCodeSortir = $detCouseCodeSortir->where('mt_date','=',$request->filTglIkr);
            // $detRootCouseSortir = $detRootCouseSortir->where('tgl_ikr','=',$request->filTglIkr);
        }

        $done = $done->count('status_wo');
        $pending = $pending->count('status_wo');
        $cancel = $cancel->count('status_wo');

        $doneSortir = $doneSortir->count('status_wo'); //->get();
        $pendingSortir = $pendingSortir->count('status_wo'); //->get();
        $cancelSortir = $cancelSortir->count('status_wo'); //->get();

        $detPenagihan = $detPenagihan->groupBy('import_fttx_mt_temps.action_taken', 'import_fttx_mt_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCode = $detCouseCode->distinct()->groupBy('action_taken', 'status_wo', 'root_couse')->orderBy('action_taken')->get();
        // $detRootCouse = $detRootCouse->distinct()->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
     
        $detPenagihanSortir = $detPenagihanSortir->groupBy('import_fttx_mt_sortir_temps.action_taken', 'import_fttx_mt_sortir_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCodeSortir = $detCouseCodeSortir->groupBy('action_taken', 'status_wo', 'root_couse')->orderBy('action_taken')->get();
        // $detRootCouseSortir = $detRootCouseSortir->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        return response()->json([
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel,
            'doneSortir' => $doneSortir, 'pendingSortir' => $pendingSortir, 'cancelSortir' => $cancelSortir,
            'detPenagihan' => $detPenagihan, 'detCouseCode' => $detCouseCode, //'detRootCouse' => $detRootCouse,
            'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, //'detRootCouseSortir' => $detRootCouseSortir
            ]);
    }

    public function saveImportFttxMT(Request $request)
    {
        $akses = Auth::user()->name;

        switch ($request->input('action')) {

            case 'simpan':

                // ===== copy data Ftth MT Ori Temporary ke table Data Ftth MT Ori ======//
                $dataimportFttxMTOri = ImportFttxMtTemp::where('login', '=', $akses)->get()
                    ->each(function ($item) {
                        $dataFttxMTOri = $item->replicate();
                        $dataFttxMTOri->setTable('data_fttx_mt_oris');
                        $dataFttxMTOri->save();
                    });

                if ($dataimportFttxMTOri) {

                    // ==== copy data Ftth Mt Sortir Temporary ke table Data Ftth Mt Sortir =======//
                    $dataimportFttxMTSortir = ImportFttxMtSortirTemp::where('login', '=', $akses)->get()
                        ->each(function ($item) {
                            $dataFttxMTSortir = $item->replicate();
                            $dataFttxMTSortir->setTable('data_fttx_mt_sortirs');
                            $dataFttxMTSortir->save();
                        });

                    ImportFttxMtTemp::where('login', '=', $akses)->delete();
                    ImportFttxMtSortirTemp::where('login', '=', $akses)->delete();
                }

                break;

            case 'batal':
                ImportFttxMtTemp::where('login', '=',$akses)->delete();
                ImportFttxMtSortirTemp::where('login', '=', $akses)->delete();

                break;
        }
        return back();    // }
    }

}
