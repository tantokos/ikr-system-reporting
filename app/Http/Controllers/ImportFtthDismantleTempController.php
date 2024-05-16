<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportFtthDismantleTemp;
use App\Models\ImportFtthDismantleSortirTemp;
use App\Models\DataFtthDismantleOri;
use App\Imports\ImportFtthDismantle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ImportFtthDismantleTempController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses = Auth::user()->name;
        $tglIkr = ImportFtthDismantleTemp::where('login', '=', $akses)->select(DB::raw('visit_date'))->distinct()->get();

        $jmlData = ImportFtthDismantleTemp::where('login', '=', $akses)->count('no_wo');
        // $sitePenagihan = ImportFtthDismantleTemp::where('login', '=', $akses)->select('site_penagihan')->distinct()->get();
        // $penagihan = ImportFtthDismantleTemp::where('login', '=', $akses)->select('penagihan')->distinct()->orderBy('penagihan')->get();
        $branch = ImportFtthDismantleTemp::where('login', '=', $akses)->select('main_branch')->distinct()->orderBy('main_branch')->get();
        $kotamadyaPenagihan = ImportFtthDismantleTemp::where('login', '=', $akses)->select('kotamadya_penagihan')->distinct()->orderBy('kotamadya_penagihan')->get();
        $statWo = ImportFtthDismantleTemp::where('login', '=', $akses)->select('status_wo')->distinct()->get();

        $TglMin = $tglIkr->min('visit_date');
        $TglMax = $tglIkr->max('visit_date');

        $CekBulanThnImport = DataFtthDismantleOri::whereBetween('visit_date',[$TglMin, $TglMax])->get();
        // dump($CekBulanThnImport->count());

        if($CekBulanThnImport->count() > 0) {
            $croscekData = "Data Tanggal $TglMin - $TglMax Sudah Pernah di Import";
        }
        else
        {
            $croscekData = "-";
        }

        return view('importWo.FtthDismantleTempIndex',['akses' => $akses, 'croscekData' => $croscekData, 'jmlImport' => $jmlData,
                    'tglIkr' => $tglIkr, //'sitePenagihan' => $sitePenagihan, 
                    'branch' => $branch,'statusWo' => $statWo, //'penagihan' => $penagihan,
                    'kotamadyaPenagihan' => $kotamadyaPenagihan]);
    }

    public function dataImportFtthDismantleTemp(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFtthDismantleTemp::where('login', '=', $akses)->get();
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


    public function importFtthDismantleTemp(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFtthMT')) {

            $request->validate([
                'fileFtthMT' => ['required', 'mimes:xlsx,xls,csv']
            ]);

            $akses = Auth::user()->name;

            Excel::import(new ImportFtthDismantle($akses), request()->file('fileFtthMT'));

            $doneSortir = DB::table('import_ftth_dismantle_temps')->where('status_wo', '=', 'Done')->select(DB::raw('no_wo,max(visit_date) as visit_date'))
                // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $pendingSortir = DB::table('import_ftth_dismantle_temps')->where('status_wo', '=', 'Pending')->select(DB::raw('no_wo,max(visit_date) as visit_date'))
                // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->whereNotIn('no_wo', function ($p) {
                    $p->select('no_wo')->from('import_ftth_dismantle_temps as import1')->where('status_wo', '=', 'Done');
                })
                ->whereNotIn('no_wo', function ($c) {
                    $c->select('no_wo')->from('import_ftth_dismantle_temps as import2')->where('status_wo', '=', 'Cancel');
                })
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $cancelSortir = DB::table('import_ftth_dismantle_temps')->where('status_wo', '=', 'Cancel')->select(DB::raw('no_wo,max(visit_date) as visit_date'))
                // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
                ->whereNotIn('no_wo', function ($p) {
                    $p->select('no_wo')->from('import_ftth_dismantle_temps as import1')->where('status_wo', '=', 'Done');
                })
                ->orderBy('no_wo')
                ->groupBy('no_wo')->get();

            $donePendingSortir = $doneSortir->merge($pendingSortir);
            $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);

            for ($x = 0; $x < $donePendingCancelSortir->count(); $x++) {

                $importFtthDismantleOri = ImportFtthDismantleTemp::where('no_wo', '=', $donePendingCancelSortir[$x]->no_wo)
                    ->where('visit_date', '=', $donePendingCancelSortir[$x]->visit_date)->first();

                // dd($importFtthIBOri->no_wo);

                ImportFtthDismantleSortirTemp::create([

                    'no_wo' => $importFtthDismantleOri->no_wo,
                    'wo_date' => $importFtthDismantleOri->wo_date,
                    'visit_date' => $importFtthDismantleOri->visit_date,
                    'dis_port_date' => $importFtthDismantleOri->dis_port_date,
                    'takeout_notakeout' => $importFtthDismantleOri->takeout_notakeout,
                    'port' => $importFtthDismantleOri->port,
                    'close_date' => $importFtthDismantleOri->close_date,
                    'cust_id' => $importFtthDismantleOri->cust_id,
                    'nama_cust' => $importFtthDismantleOri->nama_cust,
                    'cust_address' => $importFtthDismantleOri->cust_address,
                    'slot_time' => $importFtthDismantleOri->slot_time,
                    'teknisi1' => $importFtthDismantleOri->teknisi1,
                    'teknisi2' => $importFtthDismantleOri->teknisi2,
                    'teknisi3' => $importFtthDismantleOri->teknisi3,
                    'start' => $importFtthDismantleOri->start,
                    'finish' => $importFtthDismantleOri->finish,
                    'kode_fat' => $importFtthDismantleOri->kode_fat,
                    'kode_area' => $importFtthDismantleOri->kode_area,
                    'cluster' => $importFtthDismantleOri->cluster,
                    'kotamadya' => $importFtthDismantleOri->kotamadya,
                    'main_branch' => $importFtthDismantleOri->main_branch,
                    'ms_regular' => $importFtthDismantleOri->ms_regular,
                    'fat_status' => $importFtthDismantleOri->fat_status,
                    'ont_sn_in' => $importFtthDismantleOri->ont_sn_in,
                    'stb_sn_in' => $importFtthDismantleOri->stb_sn_in,
                    'router_sn_in' => $importFtthDismantleOri->router_sn_in,
                    'tarik_cable' => $importFtthDismantleOri->tarik_cable,
                    'status_wo' => $importFtthDismantleOri->status_wo,
                    'reason_status' => $importFtthDismantleOri->reason_status,
                    'remarks' => $importFtthDismantleOri->remarks,
                    'reschedule_date' => $importFtthDismantleOri->reschedule_date,
                    'alasan_no_rollback' => $importFtthDismantleOri->alasan_no_rollback,
                    'reschedule_time' => $importFtthDismantleOri->reschedule_time,
                    'callsign' => $importFtthDismantleOri->callsign,
                    'checkin_apk' => $importFtthDismantleOri->checkin_apk,
                    'checkout_apk' => $importFtthDismantleOri->checkout_apk,
                    'status_apk' => $importFtthDismantleOri->status_apk,
                    'keterangan' => $importFtthDismantleOri->keterangan,
                    'ikr_progress_date' => $importFtthDismantleOri->ikr_progress_date,
                    'ikr_report_date' => $importFtthDismantleOri->ikr_report_date,
                    'reconsile_date' => $importFtthDismantleOri->reconsile_date,
                    'weather' => $importFtthDismantleOri->weather,
                    'leader' => $importFtthDismantleOri->leader,
                    'pic_monitoring' => $importFtthDismantleOri->pic_monitoring,
                    'login' => $akses

                ]);
            }

            return back();
        }
    }

    public function getFilterSummaryDismantle(Request $request)
    {
        
        $akses = Auth::user()->name;

        // query status data ORI
        $done = ImportFtthDismantleTemp::where('login', '=', $akses)->where('status_wo', '=', 'Done');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $pending = ImportFtthDismantleTemp::where('login', '=', $akses)->where('status_wo', '=', 'Pending');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        $cancel = ImportFtthDismantleTemp::where('login', '=', $akses)->where('status_wo', '=', 'Cancel');
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']); //->count('status_wo');
        // end query status date ORI

        // query status data Sortir
        $doneSortir = DB::table('import_ftth_dismantle_sortir_temps')->where('status_wo', '=', 'Done'); //->count('status_wo'); //->get();

        $pendingSortir = DB::table('import_ftth_dismantle_sortir_temps')->where('status_wo', '=', 'Pending'); //->count('status_wo'); //->get();
    
        $cancelSortir = DB::table('import_ftth_dismantle_sortir_temps')->where('status_wo', '=', 'Cancel'); //->count('status_wo'); //->get();
    
        // $donePendingSortir = $doneSortir->merge($pendingSortir);
        // $donePendingCancelSortir = $donePendingSortir->merge($cancelSortir);
        // end query status data Sortir

        $tglIkr = ImportFtthDismantleTemp::where('login', '=', $akses)->select(DB::raw('visit_date'))->distinct()->get();

        $detPenagihan = ImportFtthDismantleTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_ftth_dismantle_temps.reason_status')
            ->where('root_couse_penagihan.type_wo','=','Dismantle FTTH')
            ->select(DB::raw('import_ftth_dismantle_temps.reason_status, import_ftth_dismantle_temps.status_wo, count(import_ftth_dismantle_temps.reason_status) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);


        $detCouseCode = ImportFtthDismantleTemp::where('login', '=', $akses)->select(DB::raw('status_wo, reason_status, count(*) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);

        // $detRootCouse = ImportFtthDismantleTemp::where('login', '=', $akses)->select(DB::raw('penagihan, status_wo, couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);


        $detPenagihanSortir = ImportFtthDismantleSortirTemp::where('login', '=', $akses)
            ->leftjoin('root_couse_penagihan','root_couse_penagihan.penagihan', '=', 'import_ftth_dismantle_sortir_temps.reason_status')
            ->where('root_couse_penagihan.type_wo','=','Dismantle FTTH')
            ->select(DB::raw('import_ftth_dismantle_sortir_temps.reason_status,import_ftth_dismantle_sortir_temps.status_wo, count(import_ftth_dismantle_sortir_temps.reason_status) as jml'));
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional']);
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        $detCouseCodeSortir = ImportFtthDismantleSortirTemp::where('login', '=', $akses)->select(DB::raw('status_wo, reason_status, count(*) as jml'));
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

            $detPenagihanSortir = $detPenagihanSortir->where('site_penagihan','=',$request->filSitePenagihan);
            $detCouseCodeSortir = $detCouseCodeSortir->where('site_penagihan','=',$request->filSitePenagihan);

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
            $detPenagihan = $detPenagihan->where('import_ftth_dismantle_temps.penagihan','=',$request->filRootPenagihan);
            $detCouseCode = $detCouseCode->where('penagihan','=',$request->filRootPenagihan);
            // $detRootCouse = $detRootCouse->where('penagihan','=',$request->filRootPenagihan);

            $detPenagihanSortir = $detPenagihanSortir->where('import_ftth_dismantle_sortir_temps.penagihan','=',$request->filRootPenagihan);
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
            $detPenagihan = $detPenagihan->where('visit_date','=',$request->filTglIkr);
            $detCouseCode = $detCouseCode->where('visit_date','=',$request->filTglIkr);
            // $detRootCouse = $detRootCouse->where('visit_date','=',$request->filTglIkr);

            $detPenagihanSortir = $detPenagihanSortir->where('visit_date','=',$request->filTglIkr);
            $detCouseCodeSortir = $detCouseCodeSortir->where('visit_date','=',$request->filTglIkr);
            // $detRootCouseSortir = $detRootCouseSortir->where('visit_date','=',$request->filTglIkr);
        }

        $done = $done->count('status_wo');
        $pending = $pending->count('status_wo');
        $cancel = $cancel->count('status_wo');

        $doneSortir = $doneSortir->count('status_wo'); //->get();
        $pendingSortir = $pendingSortir->count('status_wo'); //->get();
        $cancelSortir = $cancelSortir->count('status_wo'); //->get();

        $detPenagihan = $detPenagihan->groupBy('import_ftth_dismantle_temps.reason_status', 'import_ftth_dismantle_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCode = $detCouseCode->distinct()->groupBy('reason_status', 'status_wo')->orderBy('reason_status')->get();
        // $detRootCouse = $detRootCouse->distinct()->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();
     
        $detPenagihanSortir = $detPenagihanSortir->groupBy('import_ftth_dismantle_sortir_temps.reason_status', 'import_ftth_dismantle_sortir_temps.status_wo','root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        $detCouseCodeSortir = $detCouseCodeSortir->groupBy('reason_status', 'status_wo')->orderBy('reason_status')->get();
        // $detRootCouseSortir = $detRootCouseSortir->groupBy('penagihan', 'status_wo', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        return response()->json([
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel,
            'doneSortir' => $doneSortir, 'pendingSortir' => $pendingSortir, 'cancelSortir' => $cancelSortir,
            'detPenagihan' => $detPenagihan, 'detCouseCode' => $detCouseCode, //'detRootCouse' => $detRootCouse,
            'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, //'detRootCouseSortir' => $detRootCouseSortir
            ]);
    }


    public function saveImportFtthDismantle(Request $request)
    {
        $akses = Auth::user()->name;

        switch ($request->input('action')) {

            case 'simpan':

                // ===== copy data Ftth MT Ori Temporary ke table Data Ftth MT Ori ======//
                $dataimportFtthIbOri = ImportFtthDismantleTemp::where('login', '=', $akses)->get()
                    ->each(function ($item) {
                        $dataFtthIbOri = $item->replicate();
                        $dataFtthIbOri->setTable('data_ftth_dismantle_oris');
                        $dataFtthIbOri->save();
                    });

                if ($dataimportFtthIbOri) {

                    // ==== copy data Ftth Mt Sortir Temporary ke table Data Ftth Mt Sortir =======//
                    $dataimportFtthIbSortir = ImportFtthDismantleSortirTemp::where('login', '=', $akses)->get()
                        ->each(function ($item) {
                            $dataFtthIbSortir = $item->replicate();
                            $dataFtthIbSortir->setTable('data_ftth_dismantle_sortirs');
                            $dataFtthIbSortir->save();
                        });

                    ImportFtthDismantleTemp::where('login', '=', $akses)->delete();
                    ImportFtthDismantleSortirTemp::where('login', '=', $akses)->delete();
                }

                break;

            case 'batal':
                ImportFtthDismantleTemp::where('login', '=', $akses)->delete();
                ImportFtthDismantleSortirTemp::where('login', '=', $akses)->delete();

                break;
        }

        return back();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
