<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ImportFtthDismantleSortirTemp;
use App\Models\DataFtthDismantleSortir;

class Report_DismantleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses = Auth::user()->name;

        // $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();
        $branchPenagihan = DB::table('branches as b')->Join('data_ftth_dismantle_sortirs as d', 'b.nama_branch', '=', 'd.main_branch')
            ->select('b.id', 'd.main_branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_ftth_dismantle_sortirs')
            ->select('kotamadya_penagihan')
            // ->where('branch','=','Jakarta Timur')
            ->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        // dd($kotamadyaPenagihan);

        $tgl = ImportFtthDismantleSortirTemp::select('visit_date')->distinct()->get();

        $trendMonthly = DataFtthDismantleSortir::select(DB::raw('date_format(visit_date, "%b-%Y") as bulan'))->distinct()->get();

        return view(
            'report.reportingFtthDismantle',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                // 'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                // 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

    }

    public function getMonthlyDismantle(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }       

        return response()->json($trendBulanan);
    }

    public function getFilterBranchDismantleFtth(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_ftth_Dismantle_sortirs')
            ->select('kotamadya_penagihan');
        // ->where('branch','=',$request->branchReport)
        // ->distinct()
        // ->orderBy('kotamadya_penagihan')
        // ->get();

        if ($request->branchReport != "All") {
            $kotamadyaPenagihan = $kotamadyaPenagihan->where('main_branch', '=', $request->branchReport);
        }

        $kotamadyaPenagihan = $kotamadyaPenagihan->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();


        return response()->json($kotamadyaPenagihan);
    }

    public function getTotalWoBranchDismantleFtth(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totAllBranch = DataFtthDismantleSortir::whereMonth('visit_date', $bulan)
                        ->whereYear('visit_date', $tahun)->count();
        
        $branchPenagihan = Branch::select('id', 'nama_branch')
                    ->whereNotIn('nama_branch',['Apartemen', 'underground'])->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartemen") {
                $totWo = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();
                    
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$b]->nama_branch == "Underground") {
                $totWo = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } //elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
                // $totWo = DataFtthDismantleSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->count();
                // $totWoDone = DataFtthDismantleSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                // $totWoPending = DataFtthDismantleSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                // $totWoCancel = DataFtthDismantleSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                // $branchPenagihan[$b]->total = $totWo;
                // $branchPenagihan[$b]->done = $totWoDone;
                // $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                // $branchPenagihan[$b]->pending = $totWoPending;
                // $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                // $branchPenagihan[$b]->cancel = $totWoCancel;
                // $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;

            // } //elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground" && $branchPenagihan[$b]->nama_branch <> "Retail")) {
                $totWo = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            // }
        }

        return response()->json($branchPenagihan);
    }

    public function getFilterDashboardDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totAllBranch = DataFtthDismantleSortir::whereMonth('visit_date', $bulan)
                        ->whereYear('visit_date', $tahun)->count();

        $branchPenagihan = DB::table('data_ftth_dismantle_sortirs as d')
            ->select('b.id', 'd.main_branch as nama_branch') //, 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.main_branch', '=', 'b.nama_branch')
            ->whereMonth('visit_date', '=', $bulan)->whereYear('visit_date', '=', $tahun)
            ->whereNotIn('b.nama_branch',['Apartemen','Underground']);
            // ->whereBetween('visit_date', [$startDate, $endDate]);

        // if ($request->filterSite != "All") {
            // $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.main_branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();

        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
                $totWo = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
        }

        return response()->json($branchPenagihan);
    }


    public function getClusterBranchDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totBranchBln = [];
        $trendBulanan = [];
        $branchSortir = [];
        $detCluster = [];
        $detRootCouseSortir = [];



        $branch = DB::table('v_ftth_dismantle_cluster')
                    ->select('id','nama_branch')
                    ->groupBy('id','nama_branch');
                    // ->orderBy('id');

        $branchCluster = DB::table('v_ftth_dismantle_cluster')
                    ->select('id','nama_branch','cluster')
                    ->groupBy('id','nama_branch','cluster');
                    // ->orderBy('id');


        if ($request->filterBranch != "All") {
            $branch = $branch->where('branch', '=', $request->filterBranch);
            $branchCluster = $branchCluster->where('branch', '=', $request->filterBranch);
        }


        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            $Qbln = \Carbon\Carbon::parse($trendBulanan[$bt-1]['bulan'])->month;
            $blnThn = str_replace('-','_',$trendBulanan[$bt-1]['bulan']);

            $branch = $branch->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_dismantle end),0) as ".$blnThn.""));
            $branch = $branch->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_dismantle end),0)/(select sum(total_ftth_dismantle) from v_ftth_dismantle_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $branchCluster = $branchCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_dismantle end),0) as ".$blnThn.""));
            $branchCluster = $branchCluster->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_dismantle end),0)/(select sum(total_ftth_dismantle) from v_ftth_dismantle_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $branch = $branch->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $branchCluster = $branchCluster->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        for ($db = 0; $db < count($branch); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;

            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$dbm]['bulan']);

                $persenBln = "persen_".$blnThn;

                $totBranchBln[$db]['totbulanan'][$dbm] = $branch[$db]->$blnThn;
                $totBranchBln[$db]['persen'][$dbm] = round($branch[$db]->$persenBln,1);

            }
        }

        for ($bc = 0; $bc < count($branchCluster); $bc++) {

            $detCluster[$bc]['nama_branch'] = $branchCluster[$bc]->nama_branch;
            $detCluster[$bc]['cluster'] = $branchCluster[$bc]->cluster;


            for ($tm = 0; $tm < count($trendBulanan); $tm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tm]['bulan']);

                $persenBln = "persen_".$blnThn;
               
                $detCluster[$bc]['bulanan'][$tm] = $branchCluster[$bc]->$blnThn;
                $detCluster[$bc]['persen'][$tm] = round($branchCluster[$bc]->$persenBln,1);

            }

        }



        // $branch = DB::table('data_ftth_dismantle_sortirs as d')
        //         ->leftJoin('branches as b','d.main_branch','=','b.nama_branch')
        //         ->select('b.id','d.main_branch as nama_branch');
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

        // $branchCluster = DB::table('data_ftth_dismantle_sortirs as d')
        //         ->leftJoin('branches as b','d.main_branch','=','b.nama_branch')
        //         ->select('b.id','d.main_branch as nama_branch','d.cluster');
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

                
        // if ($request->filterSite != "All") {
        //     $branchCluster = $branchCluster->where('d.site_penagihan', '=', $request->filterSite);
        //     $branch = $branch->where('d.site_penagihan', '=', $request->filterSite);
        // }
        // if ($request->filterBranch != "All") {
        //     $branchCluster = $branchCluster->where('d.main_branch', '=', $request->filterBranch);
        //     $branch = $branch->where('d.main_branch', '=', $request->filterBranch);
        // }

        // $branchCluster = $branchCluster->groupBy('d.main_branch', 'b.id','d.cluster')->orderBy('b.id')->orderBy('d.cluster' )->get();
        // $branch = $branch->groupBy('d.main_branch', 'b.id')->orderBy('b.id')->get();

        // for ($bc = 0; $bc < count($branchCluster); $bc++) {

        //     $detCluster[$bc]['nama_branch'] = $branchCluster[$bc]->nama_branch;
        //     $detCluster[$bc]['cluster'] = $branchCluster[$bc]->cluster;


        //     for ($tm = 0; $tm < count($trendBulanan); $tm++) {

        //         $jml = DB::table('data_ftth_dismantle_sortirs as d')
        //         ->leftJoin('branches as b','d.main_branch','=','b.nama_branch')
        //         ->select('b.id','d.main_branch as nama_branch','d.cluster')
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
        //         ->whereMonth('d.visit_date', '=', \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month) // $bulan)
        //         ->whereYear('d.visit_date', '=', $tahun)
        //         ->where('d.main_branch','=', $branchCluster[$bc]->nama_branch)
        //         ->where('d.cluster','=', $branchCluster[$bc]->cluster);


        //         $jml = $jml->groupBy('d.main_branch','d.cluster', 'b.id')->orderBy('b.id')->count();

        //         $detCluster[$bc]['bulanan'][$tm] = [$jml];

        //     }

        // }

        // for ($db = 0; $db < count($branch); $db++) {

        //     $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;
        //     for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {

        //         $jmldbm = DB::table('data_ftth_dismantle_sortirs as d')
        //         ->leftJoin('branches as b','d.main_branch','=','b.nama_branch')
        //         ->select('b.id','d.main_branch as nama_branch')
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
        //         ->whereMonth('d.visit_date', '=', \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month) // $bulan)
        //         ->whereYear('d.visit_date', '=', $tahun)
        //         ->where('d.main_branch','=', $branch[$db]->nama_branch)
        //         ->groupBy('d.main_branch','b.id')->orderBy('b.id')->count();

        //         // $varjml = $varjml + $jmldbm;
        //         $totBranchBln[$db]['totbulanan'][$dbm] = [$jmldbm];

        //     }

        // }

        return response()->json([
            'branchCluster' => $totBranchBln, 'detCluster' => $detCluster
        ]);
    }


    public function getTrendMonthlyDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        for ($m = 0; $m < count($trendBulanan); $m++) {
            $totIBFtthMontly = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('main_branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->count();

            $totIBFtthMontlyDone = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('main_branch', '=', $request->filterBranch);
            }

            $totIBFtthMontlyDone = $totIBFtthMontlyDone->count();

            $trendBulanan[$m]['trendIBFtthTotal'] = $totIBFtthMontly;
            $trendBulanan[$m]['trendIBFtthDone'] = $totIBFtthMontlyDone;
        }

        return response()->json($trendBulanan);
    }

    public function getTabelStatusDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tgl = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $dayMonth = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($dayMonth as $date) {
            $tgl[] = ['visit_date' => $date->format('Y-m-d')];
        }
        // dd($tgl);

        for ($d = 0; $d < count($tgl); $d++) {
            $tblStatus = DataFtthDismantleSortir::where('visit_date', '=', $tgl[$d]) //->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                ->select(DB::raw('visit_date, count(if(status_wo = "Done", 1, NULL)) as Done, 
            count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'));
            // ->whereDay('visit_date', $dayMonth);

            // dd($tblStatus);
            if ($request->filterSite != "All") {
                $tblStatus = $tblStatus->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tblStatus = $tblStatus->where('main_branch', '=', $request->filterBranch);
            }

            $tblStatus = $tblStatus->orderBy('visit_date')
                ->groupBy('visit_date')->first();

            // dd($tblStatus->Done);
            $tgl[$d]['Done'] = $tblStatus->Done ?? 0;
            $tgl[$d]['Pending'] = $tblStatus->Pending ?? 0;
            $tgl[$d]['Cancel'] = $tblStatus->Cancel ?? 0;
        }

        return response()->json($tgl);
    }

    public function getRootCouseAPKDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $PenagihanSortir = DB::table('v_ftth_dismantle')
                            ->select('reason_status')
                            ->where('status_wo','=', 'Done')
                            ->groupBy('reason_status');

        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('main_branch', '=', $request->filterBranch);
        }

        for ($m = 0; $m < count($trendBulanan); $m++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$m]['bulan']);

            $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));

            if ($request->filterBranch != "All") {
                $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_dismantle where main_branch='".$request->filterBranch."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            } else {
                $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_dismantle where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $PenagihanSortir= $PenagihanSortir->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        for($psx=0; $psx < $PenagihanSortir->count(); $psx++){
            $detPenagihanSortir[$psx] = ['penagihan' => $PenagihanSortir[$psx]->reason_status];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $detPenagihanSortir[$psx]['bulanan'][$tb] = [(int)$PenagihanSortir[$psx]->$blnThn];
                $detPenagihanSortir[$psx]['persen'][$tb] = [round($PenagihanSortir[$psx]->$persenBln, 1)];
                
            }

        }

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getRootCouseAPKDismantleFtthOld(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $PenagihanSortir = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
            ->where('root_couse_penagihan.status', '=', 'Done');
            // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_ftth_dismantle_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_ftth_dismantle_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_dismantle_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('main_branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

            $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->reason_status;
            for ($m = 0; $m < count($trendBulanan); $m++) {

                $jml = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_dismantle_sortirs.visit_date', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_dismantle_sortirs.visit_date', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_dismantle_sortirs.reason_status', '=', $PenagihanSortir[$ps]->reason_status);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('main_branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }


        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getReasonStatusDismantleFtthGraph(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tglGraph = [];
        $nameGraph = [];
        $dataGraph = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tglGraph[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        $PenagihanSortir = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
            ->where('root_couse_penagihan.status', '=', 'Done')
            // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_dismantle_sortirs.visit_date', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_dismantle_sortirs.visit_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_dismantle_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('main_branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->reason_status];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('visit_date', '=', $tglGraph[$t])
                    // ->whereMonth('data_ftth_dismantle_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_dismantle_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_dismantle_sortirs.reason_status', '=', $PenagihanSortir[$pn]->reason_status);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('main_branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
                // $tglGraph[$t]['jml'][$p] = $jml;
                // $dataGraph[$p]['penagihan'][$t] = ['jumlah' => $jml];
                $dataGraph[$pn]['data'][] = $jml;
            }
        }
        // }
        // dd($tglGraph, $nameGraph, $dataGraph[0]['data'][0]);
        // }
        return response()->json([
            'tglGraphAPK' => $tglGraph, 'dataGraphAPK' => $dataGraph,
            'nameGraphAPK' => $nameGraph
        ]);
    }


    public function getRootCousePendingGraphDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tglGraphPending = [];
        $nameGraphPending = [];
        $dataGraphPending = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tglGraphPending[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        $PenagihanSortir = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
            ->where('root_couse_penagihan.status', '=', 'Pending')
            ->where('root_couse_penagihan.type_wo','=','Dismantle FTTH')
            // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_dismantle_sortirs.visit_date', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_dismantle_sortirs.visit_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_dismantle_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('main_branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->reason_status];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthDismantleSortir::select(DB::raw('data_ftth_dismantle_sortirs.reason_status'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_dismantle_sortirs.reason_status')
                    ->where('root_couse_penagihan.status', '=', 'Pending')
                    ->where('root_couse_penagihan.type_wo','=','Dismantle Ftth')
                    // ->whereNotIn('data_ftth_dismantle_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('visit_date', '=', $tglGraphPending[$t])
                    // ->whereMonth('data_ftth_dismantle_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_dismantle_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_dismantle_sortirs.reason_status', '=', $PenagihanSortir[$pn]->reason_status);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('main_branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_dismantle_sortirs.reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
                // $tglGraph[$t]['jml'][$p] = $jml;
                // $dataGraph[$p]['penagihan'][$t] = ['jumlah' => $jml];
                $dataGraphPending[$pn]['data'][] = $jml;
            }
        }
        // }
        // dd($tglGraph, $nameGraph, $dataGraph[0]['data'][0]);
        // }
        return response()->json([
            'tglGraphAPKPending' => $tglGraphPending, 'dataGraphAPKPending' => $dataGraphPending,
            'nameGraphAPKPending' => $nameGraphPending
        ]);
    }


    public function getRootCousePendingDismantleFtth(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $detPending = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $PenagihanSortir = DB::table('v_ftth_dismantle')
                            ->select('reason_status')
                            ->where('status_wo','=', 'Pending')
                            ->groupBy('reason_status');

        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('main_branch', '=', $request->filterBranch);
        }

        for ($m = 0; $m < count($trendBulanan); $m++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$m]['bulan']);

            $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            

            if ($request->filterBranch != "All") {
                $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_dismantle where main_branch='".$request->filterBranch."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            } else {
                $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_dismantle where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }

               
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $PenagihanSortir= $PenagihanSortir->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        for($psx=0; $psx < $PenagihanSortir->count(); $psx++){
            $detPending[$psx] = ['penagihan' => $PenagihanSortir[$psx]->reason_status];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $detPending[$psx]['bulanan'][$tb] = [(int)$PenagihanSortir[$psx]->$blnThn];
                $detPending[$psx]['persen'][$tb] = [round($PenagihanSortir[$psx]->$persenBln, 1)];
                
            }

        }

        return response()->json($detPending);
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
    }

    public function getRootCousePendingDismantleFtthOld(Request $request)
    {

        $total = 0;
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }
        // dd(\Carbon\Carbon::parse($startDate)->day);

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->where('type_wo','=','Dismantle Ftth')->get();

        
        $RootPendingMonthly = DataFtthDismantleSortir::select(DB::raw('date_format(visit_date, "%b-%Y") as bulan'))
            ->whereYear('visit_date', '=', $tahun)
            ->whereMonth('visit_date', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthDismantleSortir::where('reason_status', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('visit_date', '=', $bln)
                    ->whereYear('visit_date', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('main_branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCousePending[$x]->bulan[$jmlBln] = $jml;
            }
        }
            

        for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

            $tot = DataFtthDismantleSortir::where('status_wo', '=', 'Pending')
                ->whereMonth('visit_date', '=', $bln)
                ->whereYear('visit_date', '=', $thn);
                // ->whereBetween('tgl_ikr', [$startDate, $endDate]); //->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn); //->count();
                // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

            if ($request->filterBranch != "All") {
                $tot = $tot->where('main_branch', '=', $request->filterBranch);
            }

            $tot = $tot->count();

            $rootCousePending[$rootCousePending->count() - 1]->bulan[$RootPendingMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCousePending);
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
