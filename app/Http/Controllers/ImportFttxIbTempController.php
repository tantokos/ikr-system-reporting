<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ImportFttxIB;
use App\Imports\ImportFttxIBSortir;
use App\Models\DataFttxIbOri;
use App\Models\ImportFttxIbSortirTemp;
use App\Models\ImportFttxIbTemp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ImportFttxIbTempController extends Controller
{
    public function index () {
        $akses = Auth::user()->name;
        $jmlData = ImportFttxIbTemp::where('login', '=', $akses)->count('no_wo');

        $sitePenagihan = ImportFttxIbTemp::where('login', '=', $akses)->select('action_taken')->distinct()->get();
        $penagihan = ImportFttxIbTemp::where('login', '=', $akses)->select('action_taken')->distinct()->orderBy('action_taken')->get();
        $branch = ImportFttxIbTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $kotamadyaPenagihan = ImportFttxIbTemp::where('login', '=', $akses)->select('branch')->distinct()->orderBy('branch')->get();
        $statWo = ImportFttxIbTemp::where('login', '=', $akses)->select('status_wo')->distinct()->get();

        // query data ORI
        $done = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $pending = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');
        $cancel = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel')->count('status_wo');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])->count('status_wo');

        $tglIkr = ImportFttxIbTemp::where('login', '=', $akses)->select(DB::raw('ib_date'))->distinct()->get();

        $detPenagihan = ImportFttxIbTemp::where('login', '=', $akses)->select(DB::raw('action_taken, count(action_taken) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('action_taken')->orderBy('action_taken')->get();

        // end query data ORI

        // query data Sortir

        $doneSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Done')->get();

        $pendingSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Pending')->get();

        $cancelSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Cancel')->get();

        $donePendingSortir = $doneSortir->merge($pendingSortir);
        $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);


        $detPenagihanSortir = ImportFttxIbSortirTemp::where('login', '=', $akses)->select(DB::raw('action_taken, count(action_taken) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('action_taken')->orderBy('action_taken')->get();

        // end query data Sortir

        $TglMin = $tglIkr->min('ib_date');
        $TglMax = $tglIkr->max('ib_date');

        $CekBulanThnImport = DataFttxIbOri::whereBetween('ib_date',[$TglMin, $TglMax])->get();
        // dump($CekBulanThnImport->count());

        if($CekBulanThnImport->count() > 0) {
            $croscekData = "Data Tanggal $TglMin - $TglMax Sudah Pernah di Import";
        }
        else
        {
            $croscekData = "-";
        }


        return view('importWo.FttxIBTempIndex', [
            'title' => 'Import Data FTTX IB', 'akses' => $akses, 'jmlImport' => $jmlData,
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

    public function dataImportFttxIBTemp(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFttxIbTemp::where('login', '=', $akses)->get();
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

    public function importFttxIBTemp(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFttxIBOri')) {

            $request->validate([
                'fileFttxIBOri' => ['required', 'mimes:xlsx,xls,csv'],
                'fileFttxIBSortir' => ['required', 'mimes:xlsx,xls,csv']
            ]);
 
            $akses = Auth::user()->name;

            Excel::import(new ImportFttxIB($akses), request()->file('fileFttxIBOri'));
            Excel::import(new ImportFttxIBSortir($akses), request()->file('fileFttxIBSortir'));

            // $doneSortir = DB::table('import_fttx_ib_temps')->where('status_wo', '=', 'Done')->select(DB::raw('no_wo,max(ib_date) as tgl_ikr'))
                // ->orderBy('no_wo')
                // ->groupBy('no_wo')->get();

            // $pendingSortir = DB::table('import_fttx_ib_temps')->where('status_wo', '=', 'Pending')->select(DB::raw('no_wo,max(ib_date) as tgl_ikr'))
                // ->whereNotIn('no_wo', function ($p) {
                    // $p->select('no_wo')->from('import_fttx_ib_temps as import1')->where('status_wo', '=', 'Done');
                // })
                // ->whereNotIn('no_wo', function ($c) {
                    // $c->select('no_wo')->from('import_fttx_ib_temps as import2')->where('status_wo', '=', 'Cancel');
                // })
                // ->orderBy('no_wo')
                // ->groupBy('no_wo')->get();

            // $cancelSortir = DB::table('import_fttx_ib_temps')->where('status_wo', '=', 'Cancel')->select(DB::raw('no_wo,max(ib_date) as tgl_ikr'))
                // ->whereNotIn('no_wo', function ($p) {
                    // $p->select('no_wo')->from('import_fttx_ib_temps as import1')->where('status_wo', '=', 'Done');
                // })
                // ->orderBy('no_wo')
                // ->groupBy('no_wo')->get();

            // $donePendingSortir = $doneSortir->merge($pendingSortir);
            // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);

            // for ($x = 0; $x < $donePendingCancelSortir->count(); $x++) {

                // $ImportFttxIBOri = ImportFttxIbTemp::where('no_wo', '=', $donePendingCancelSortir[$x]->no_wo)
                    // ->where('ib_date', '=', $donePendingCancelSortir[$x]->tgl_ikr)->first();

                // dd($importFtthIBOri->no_wo);

                // ImportFttxIbSortirTemp::create([
                    // 'no_so' => $ImportFttxIBOri->no_so,
                    // 'no_wo' => $ImportFttxIBOri->no_wo,
                //     'wo_date' => $ImportFttxIBOri->wo_date,
                //     'ib_date' => $ImportFttxIBOri->ib_date,
                //     'wo_type' => $ImportFttxIBOri->wo_type,
                //     'cust_name' => $ImportFttxIBOri->cust_name,
                //     'cust_address' => $ImportFttxIBOri->cust_address,
                //     'area' => $ImportFttxIBOri->area,
                //     'site' => $ImportFttxIBOri->site,
                //     'packages_type' => $ImportFttxIBOri->packages_type,
                //     'service_type' => $ImportFttxIBOri->service_type,
                //     'slot_time' => $ImportFttxIBOri->slot_time,
                //     'teknisi1' => $ImportFttxIBOri->teknisi1,
                //     'teknisi2' => $ImportFttxIBOri->teknisi2,
                //     'teknisi3' => $ImportFttxIBOri->teknisi3,
                //     'leader' => $ImportFttxIBOri->leader,
                //     'branch' => $ImportFttxIBOri->branch,
                //     'callsign' => $ImportFttxIBOri->callsign,
                //     'nopol' => $ImportFttxIBOri->nopol,
                //     'start' => $ImportFttxIBOri->start,
                //     'finish' => $ImportFttxIBOri->finish,
                //     'report_wa' => $ImportFttxIBOri->report_wa,
                //     'fdt_code' => $ImportFttxIBOri->fdt_code,
                //     'fat_code' => $ImportFttxIBOri->fat_code,
                //     'fat_port' => $ImportFttxIBOri->fat_port,
                //     'signal_fat' => $ImportFttxIBOri->signal_fat,
                //     'signal_tb' => $ImportFttxIBOri->signal_tb,
                //     'signal_ont' => $ImportFttxIBOri->signal_ont,
                //     'ont_sn_out' => $ImportFttxIBOri->ont_sn_out,
                //     'ont_mac_out' => $ImportFttxIBOri->ont_mac_out,
                //     'ont_sn_in' => $ImportFttxIBOri->ont_sn_in,
                //     'ont_mac_in' => $ImportFttxIBOri->ont_mac_in,
                //     'stb1_sn' => $ImportFttxIBOri->stb1_sn,
                //     'stb1_mac' => $ImportFttxIBOri->stb1_mac,
                //     'stb2_sn' => $ImportFttxIBOri->stb2_sn,
                //     'stb2_mac' => $ImportFttxIBOri->stb2_mac,
                //     'stb3_sn' => $ImportFttxIBOri->stb3_sn,
                //     'stb3_mac' => $ImportFttxIBOri->stb3_mac,
                //     'stb4_sn' => $ImportFttxIBOri->stb4_sn,
                //     'stb4_mac' => $ImportFttxIBOri->stb4_mac,
                //     'stb5_sn' => $ImportFttxIBOri->stb5_sn,
                //     'stb5_mac' => $ImportFttxIBOri->stb5_mac,
                //     'stb6_sn' => $ImportFttxIBOri->stb6_sn,
                //     'stb6_mac' => $ImportFttxIBOri->stb6_mac,
                //     'stb7_sn' => $ImportFttxIBOri->stb7_sn,
                //     'stb7_mac' => $ImportFttxIBOri->stb7_mac,
                //     'stb8_sn' => $ImportFttxIBOri->stb8_sn,
                //     'stb8_mac' => $ImportFttxIBOri->stb8_mac,
                //     'stb9_sn' => $ImportFttxIBOri->stb9_sn,
                //     'stb9_mac' => $ImportFttxIBOri->stb9_mac,
                //     'router_sn' => $ImportFttxIBOri->router_sn,
                //     'router_mac' => $ImportFttxIBOri->router_mac,
                //     'drop_cable' => $ImportFttxIBOri->drop_cable,
                //     'precon' => $ImportFttxIBOri->precon,
                //     'fast_connector' => $ImportFttxIBOri->fast_connector,
                //     'termination_box' => $ImportFttxIBOri->termination_box,
                //     'patch_cord_3m' => $ImportFttxIBOri->patch_cord_3m,
                //     'patch_cord_10m' => $ImportFttxIBOri->patch_cord_10m,
                //     'screw_hanger' => $ImportFttxIBOri->screw_hanger,
                //     'indor_cable_duct' => $ImportFttxIBOri->indor_cable_duct,
                //     'pvc_pipe_20mm' => $ImportFttxIBOri->pvc_pipe_20mm,
                //     'socket_pvc_20mm' => $ImportFttxIBOri->socket_pvc_20mm,
                //     'clamp_pvc_20mm' => $ImportFttxIBOri->clamp_pvc_20mm,
                //     'flexible_pvc_20mm' => $ImportFttxIBOri->flexible_pvc_20mm,
                //     'clamp_cable' => $ImportFttxIBOri->clamp_cable,
                //     'cable_lan' => $ImportFttxIBOri->cable_lan,
                //     'connector_rj45' => $ImportFttxIBOri->connector_rj45,
                //     'cable_marker' => $ImportFttxIBOri->cable_marker,
                //     'insulation' => $ImportFttxIBOri->insulation,
                //     'cable_ties' => $ImportFttxIBOri->cable_ties,
                //     'adapter_optic' => $ImportFttxIBOri->adapter_optic,
                //     'fisher' => $ImportFttxIBOri->fisher,
                //     'paku_beton' => $ImportFttxIBOri->paku_beton,
                //     'splitter' => $ImportFttxIBOri->splitter,
                //     'status_wo' => $ImportFttxIBOri->status_wo,
                //     'root_couse' => $ImportFttxIBOri->root_couse,
                //     'action_taken' => $ImportFttxIBOri->action_taken,
                //     'remarks' => $ImportFttxIBOri->remarks,

                //     'login' => $akses
                // ]);
            // }

            return back();
        }
    }

    public function getFilterSummaryFttxIB(Request $request)
    {
        
        $akses = Auth::user()->name;

        // query status data ORI
        $done = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $pending = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $cancel = ImportFttxIbTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        // end query status date ORI

        // query status data Sortir
        $doneSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Done'); //->count('status_wo'); //->get();

        $pendingSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Pending'); //->count('status_wo'); //->get();
    
        $cancelSortir = DB::table('import_fttx_ib_sortir_temps')->where('status_wo', '=', 'Cancel'); //->count('status_wo'); //->get();
    
        // $donePendingSortir = $doneSortir->merge($pendingSortir);
        // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);
        // end query status data Sortir

        $tglIkr = ImportFttxIbTemp::where('login', '=', $akses)->select(DB::raw('ib_date'))->distinct()->get();

        $detPenagihan = ImportFttxIbTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_fttx_ib_temps.action_taken')
            ->where('root_couse_penagihan.type_wo','=','IB FTTX')
            ->select(DB::raw('import_fttx_ib_temps.action_taken, import_fttx_ib_temps.status_wo, count(import_fttx_ib_temps.action_taken) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        $detCouseCode = ImportFttxIbTemp::where('login', '=', $akses)->select(DB::raw('action_taken, status_wo, root_couse, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        // $detRootCouse = ImportFttxMtTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);


        $detPenagihanSortir = ImportFttxIbSortirTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_fttx_ib_sortir_temps.action_taken')
            ->where('root_couse_penagihan.type_wo','=','IB FTTX')
            ->select(DB::raw('import_fttx_ib_sortir_temps.action_taken,import_fttx_ib_sortir_temps.status_wo, count(import_fttx_ib_sortir_temps.action_taken) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCodeSortir = ImportFttxIbSortirTemp::where('login', '=', $akses)->select(DB::raw('action_taken, status_wo, root_couse, count(*) as jml'));
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
            $detPenagihan = $detPenagihan->where('import_fttx_ib_temps.action_taken','=',$request->filRootPenagihan);
            $detCouseCode = $detCouseCode->where('action_taken','=',$request->filRootPenagihan);
            // $detRootCouse = $detRootCouse->where('penagihan','=',$request->filRootPenagihan);

            $detPenagihanSortir = $detPenagihanSortir->where('import_fttx_ib_sortir_temps.action_taken','=',$request->filRootPenagihan);
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
            $detPenagihan = $detPenagihan->where('ib_date','=',$request->filTglIkr);
            $detCouseCode = $detCouseCode->where('ib_date','=',$request->filTglIkr);
            // $detRootCouse = $detRootCouse->where('tgl_ikr','=',$request->filTglIkr);

            $detPenagihanSortir = $detPenagihanSortir->where('ib_date','=',$request->filTglIkr);
            $detCouseCodeSortir = $detCouseCodeSortir->where('ib_date','=',$request->filTglIkr);
            // $detRootCouseSortir = $detRootCouseSortir->where('tgl_ikr','=',$request->filTglIkr);
        }

        $done = $done->count('status_wo');
        $pending = $pending->count('status_wo');
        $cancel = $cancel->count('status_wo');

        $doneSortir = $doneSortir->count('status_wo'); //->get();
        $pendingSortir = $pendingSortir->count('status_wo'); //->get();
        $cancelSortir = $cancelSortir->count('status_wo'); //->get();

        $detPenagihan = $detPenagihan->groupBy('import_fttx_ib_temps.action_taken', 'import_fttx_ib_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCode = $detCouseCode->distinct()->groupBy('action_taken', 'status_wo', 'root_couse')->orderBy('action_taken')->get();
        // $detRootCouse = $detRootCouse->distinct()->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
     
        $detPenagihanSortir = $detPenagihanSortir->groupBy('import_fttx_ib_sortir_temps.action_taken', 'import_fttx_ib_sortir_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCodeSortir = $detCouseCodeSortir->groupBy('action_taken', 'status_wo', 'root_couse')->orderBy('action_taken')->get();
        // $detRootCouseSortir = $detRootCouseSortir->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        return response()->json([
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel,
            'doneSortir' => $doneSortir, 'pendingSortir' => $pendingSortir, 'cancelSortir' => $cancelSortir,
            'detPenagihan' => $detPenagihan, 'detCouseCode' => $detCouseCode, //'detRootCouse' => $detRootCouse,
            'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, //'detRootCouseSortir' => $detRootCouseSortir
            ]);
    }

    public function saveImportFttxIB(Request $request)
    {
        $akses = Auth::user()->name;

        switch ($request->input('action')) {

            case 'simpan':

                // ===== copy data Ftth MT Ori Temporary ke table Data Ftth MT Ori ======//
                $dataimportFttxIBOri = ImportFttxIbTemp::where('login', '=', $akses)->get()
                    ->each(function ($item) {
                        $dataFttxIBOri = $item->replicate();
                        $dataFttxIBOri->setTable('data_fttx_ib_oris');
                        $dataFttxIBOri->save();
                    });

                if ($dataimportFttxIBOri) {

                    // ==== copy data Ftth Mt Sortir Temporary ke table Data Ftth Mt Sortir =======//
                    $dataimportFttxIBSortir = ImportFttxIbSortirTemp::where('login', '=', $akses)->get()
                        ->each(function ($item) {
                            $dataFttxIBSortir = $item->replicate();
                            $dataFttxIBSortir->setTable('data_fttx_ib_sortirs');
                            $dataFttxIBSortir->save();
                        });

                    ImportFttxIbTemp::where('login', '=', $akses)->delete();
                    ImportFttxIbSortirTemp::where('login', '=', $akses)->delete();
                }

                break;

            case 'batal':
                ImportFttxIbTemp::where('login', '=',$akses)->delete();
                ImportFttxIbSortirTemp::where('login', '=', $akses)->delete();

                break;
        }
        return back();    // }
    }
}
