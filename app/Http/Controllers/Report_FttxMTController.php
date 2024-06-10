<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataFttxMtOri;
use App\Models\ImportFtthIbSortirTemp;
use App\Models\Branch;
use App\Models\DataFttxMtSortir;

class Report_FttxMTController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses = Auth::user()->name;

        // $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();
        $branchPenagihan = DB::table('branches as b')->Join('data_fttx_mt_sortirs as d', 'b.nama_branch', '=', 'd.branch')
            ->select('b.id', 'd.branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_fttx_mt_sortirs')
            ->select('area')
            // ->where('branch','=','Jakarta Timur')
            ->distinct()
            ->orderBy('area')
            ->get();

        // dd($kotamadyaPenagihan);

        $tgl = DataFttxMtSortir::select('mt_date')->distinct()->get();

        $trendMonthly = DataFttxMtSortir::select(DB::raw('date_format(mt_date, "%b-%Y") as bulan, month(mt_date) as bln, year(mt_date) as thn'))->distinct()->orderBy('bln','ASC')->orderBy('thn','ASC')->get();

        // $site = DataFttxMtSortir::select('site_penagihan')->distinct()->get();

        // dd($tblStatus);

        // dd($trendMonthly[0]->bulan);
        // dd(\Carbon\Carbon::parse($tgl[0]->mt_date)->format('F'));

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->daysInMonth);

        // query data Sortir

        // $detPenagihanSortir =DataFttxMtSortir::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        // // dd($detPenagihanSortir);

        // $detCouseCodeSortir =DataFttxMtSortir::where('login', '=', $akses)->select(DB::raw('penagihan,reason_status, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status')->orderBy('penagihan')->get();

        // $detRootCouseSortir =DataFttxMtSortir::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status', 'root_couse')->orderBy('penagihan')->get();

        // end query data Sortir

        return view(
            'report.reportingFttxMT',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                // 'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                // 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

    }

    public function getFilterBranchMTFttx(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_fttx_mt_sortirs')
            ->select('area');
        // ->where('branch','=',$request->branchReport)
        // ->distinct()
        // ->orderBy('kotamadya_penagihan')
        // ->get();

        if ($request->branchReport != "All") {
            $kotamadyaPenagihan = $kotamadyaPenagihan->where('area', '=', $request->branchReport);
        }

        $kotamadyaPenagihan = $kotamadyaPenagihan->distinct()
            ->orderBy('area')
            ->get();


        return response()->json($kotamadyaPenagihan);
    }

    public function getTotalWoBranchMTFttx(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $branchPenagihan = DB::table('branches as b')
                    ->join('data_fttx_mt_sortirs as d', 'b.nama_branch','=','d.branch')
                    ->select('b.id', 'b.nama_branch')
                    ->whereNotIn('b.nama_branch',['Apartemen', 'underground'])
                    ->distinct()
                    ->orderBy('b.id')->get();
        
        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartemen") {
                $totWo = DataFttxMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFttxMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();
                    
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$b]->nama_branch == "Underground") {
                $totWo = DataFttxMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFttxMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } //elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
                // $totWo = DataFttxMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->count();
                // $totWoDone = DataFttxMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                // $totWoPending = DataFttxMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                // $totWoCancel = DataFttxMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                //     ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                //     ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                // $branchPenagihan[$b]->total = $totWo;
                // $branchPenagihan[$b]->done = $totWoDone;
                // $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                // $branchPenagihan[$b]->pending = $totWoPending;
                // $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                // $branchPenagihan[$b]->cancel = $totWoCancel;
                // $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;

            // } //elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground" && $branchPenagihan[$b]->nama_branch <> "Retail")) {
                $totWo = DataFttxMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFttxMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                
                $branchPenagihan[$b]->total = $totWo;
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

    public function getFilterDashboardMTFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $branchPenagihan = DB::table('data_fttx_mt_sortirs as d')
            ->select('b.id', 'd.branch as nama_branch') //, 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.branch', '=', 'b.nama_branch')
            ->whereMonth('mt_date', '=', $bulan)->whereYear('mt_date', '=', $tahun)
            ->whereNotIn('b.nama_branch',['Apartemen','Underground']);
            // ->whereBetween('mt_date', [$startDate, $endDate]);

        // if ($request->filterSite != "All") {
            // $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();

        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
                $totWo = DataFttxMtSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFttxMtSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxMtSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxMtSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('mt_date', $bulan)
                    ->whereYear('mt_date', $tahun)
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
        }

        return response()->json($branchPenagihan);
    }


    public function getClusterBranchMTFttx(Request $request)
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

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $branch = DB::table('data_fttx_mt_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch');
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

        $branchCluster = DB::table('data_fttx_mt_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch','d.cluster');
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

                
        if ($request->filterSite != "All") {
            $branchCluster = $branchCluster->where('d.site_penagihan', '=', $request->filterSite);
            $branch = $branch->where('d.site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $branchCluster = $branchCluster->where('d.branch', '=', $request->filterBranch);
            $branch = $branch->where('d.branch', '=', $request->filterBranch);
        }

        $branchCluster = $branchCluster->groupBy('d.branch', 'b.id','d.cluster')->orderBy('b.id')->orderBy('d.cluster' )->get();
        $branch = $branch->groupBy('d.branch', 'b.id')->orderBy('b.id')->get();

        for ($bc = 0; $bc < count($branchCluster); $bc++) {

            $detCluster[$bc]['nama_branch'] = $branchCluster[$bc]->nama_branch;
            $detCluster[$bc]['cluster'] = $branchCluster[$bc]->cluster;


            for ($tm = 0; $tm < count($trendBulanan); $tm++) {

                $jml = DB::table('data_fttx_mt_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch','d.cluster')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.mt_date', '=', \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month) // $bulan)
                ->whereYear('d.mt_date', '=', $tahun)
                ->where('d.branch','=', $branchCluster[$bc]->nama_branch)
                ->where('d.cluster','=', $branchCluster[$bc]->cluster);


                $jml = $jml->groupBy('d.branch','d.cluster', 'b.id')->orderBy('b.id')->count();

                $detCluster[$bc]['bulanan'][$tm] = [$jml];

            }

        }

        for ($db = 0; $db < count($branch); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;
            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {

                $jmldbm = DB::table('data_fttx_mt_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.mt_date', '=', \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month) // $bulan)
                ->whereYear('d.mt_date', '=', $tahun)
                ->where('d.branch','=', $branch[$db]->nama_branch)
                ->groupBy('d.branch','b.id')->orderBy('b.id')->count();

                // $varjml = $varjml + $jmldbm;
                $totBranchBln[$db]['totbulanan'][$dbm] = [$jmldbm];

            }

        }

        return response()->json([
            'branchCluster' => $totBranchBln, 'detCluster' => $detCluster
        ]);
    }


    public function getTrendMonthlyMTFttx(Request $request)
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
            $totIBFtthMontly = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->count();

            $totIBFtthMontlyDone = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontlyDone = $totIBFtthMontlyDone->count();

            $trendBulanan[$m]['trendIBFtthTotal'] = $totIBFtthMontly;
            $trendBulanan[$m]['trendIBFtthDone'] = $totIBFtthMontlyDone;
        }

        return response()->json($trendBulanan);
    }

    public function getTabelStatusMTFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tgl = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $dayMonth = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($dayMonth as $date) {
            $tgl[] = ['mt_date' => $date->format('Y-m-d')];
        }
        // dd($tgl);

        for ($d = 0; $d < count($tgl); $d++) {
            $tblStatus = DataFttxMtSortir::where('mt_date', '=', $tgl[$d]) //->whereMonth('mt_date', $bulan)->whereYear('mt_date', $tahun)
                ->select(DB::raw('mt_date, count(if(status_wo = "Done", 1, NULL)) as Done, 
            count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'));
            // ->whereDay('mt_date', $dayMonth);

            // dd($tblStatus);
            if ($request->filterSite != "All") {
                $tblStatus = $tblStatus->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tblStatus = $tblStatus->where('branch', '=', $request->filterBranch);
            }

            $tblStatus = $tblStatus->orderBy('mt_date')
                ->groupBy('mt_date')->first();

            // dd($tblStatus->Done);
            $tgl[$d]['Done'] = $tblStatus->Done ?? 0;
            $tgl[$d]['Pending'] = $tblStatus->Pending ?? 0;
            $tgl[$d]['Cancel'] = $tblStatus->Cancel ?? 0;
        }

        return response()->json($tgl);
    }

    public function getRootCouseAPKMTFttx(Request $request)
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

        $PenagihanSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','MT FTTX');
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

            $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->action_taken;
            for ($m = 0; $m < count($trendBulanan); $m++) {

                $jml = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTX')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_fttx_mt_sortirs.mt_date', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    ->whereYear('data_fttx_mt_sortirs.mt_date', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_mt_sortirs.action_taken', '=', $PenagihanSortir[$ps]->action_taken);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }


        // $CouseCodeSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.penagihan,reason_status'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.penagihan')
            // ->where('root_couse_penagihan.status', '=', 'Done');
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $CouseCodeSortir = $CouseCodeSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        // if ($request->filterBranch != "All") {
            // $CouseCodeSortir = $CouseCodeSortir->where('branch', '=', $request->filterBranch);
        // }

        // $CouseCodeSortir = $CouseCodeSortir->groupBy('data_fttx_mt_sortirs.penagihan', 'reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // for ($cs = 0; $cs < count($CouseCodeSortir); $cs++) {

            // $detCouseCodeSortir[$cs]['penagihan'] = $CouseCodeSortir[$cs]->penagihan;
            // $detCouseCodeSortir[$cs]['reason_status'] = $CouseCodeSortir[$cs]->reason_status;

            // for ($mc = 0; $mc < count($trendBulanan); $mc++) {

                // $jmlCouseCode = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.penagihan,reason_status'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.penagihan')
                    // ->where('root_couse_penagihan.status', '=', 'Done')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mc]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->where('data_fttx_mt_sortirs.penagihan', '=', $CouseCodeSortir[$cs]->penagihan)
                    // ->where('data_fttx_mt_sortirs.reason_status', '=', $CouseCodeSortir[$cs]->reason_status);

                // if ($request->filterSite != "All") {
                    // $jmlCouseCode = $jmlCouseCode->where('site_penagihan', '=', $request->filterSite);
                // }
                // if ($request->filterBranch != "All") {
                    // $jmlCouseCode = $jmlCouseCode->where('branch', '=', $request->filterBranch);
                // }

                // $jmlCouseCode = $jmlCouseCode->groupBy('data_fttx_mt_sortirs.penagihan', 'reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detCouseCodeSortir[$cs]['bulanan'][$mc] = [$jmlCouseCode];
            // }
        // }




        // $detRootCouseSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // $RootCouseSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.penagihan,couse_code,root_couse'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.penagihan')
            // ->where('root_couse_penagihan.status', '=', 'Done')
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $RootCouseSortir = $RootCouseSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        // if ($request->filterBranch != "All") {
            // $RootCouseSortir = $RootCouseSortir->where('branch', '=', $request->filterBranch);
        // }

        // $RootCouseSortir = $RootCouseSortir->groupBy('data_fttx_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // for ($rc = 0; $rc < count($RootCouseSortir); $rc++) {

            // $detRootCouseSortir[$rc]['penagihan'] = $RootCouseSortir[$rc]->penagihan;
            // $detRootCouseSortir[$rc]['couse_code'] = $RootCouseSortir[$rc]->couse_code;
            // $detRootCouseSortir[$rc]['root_couse'] = $RootCouseSortir[$rc]->root_couse;

            // for ($mr = 0; $mr < count($trendBulanan); $mr++) {

                // $jmlRootCouse = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.penagihan,couse_code,root_couse'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.penagihan')
                    // ->where('root_couse_penagihan.status', '=', 'Done')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mr]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->where('data_fttx_mt_sortirs.penagihan', '=', $RootCouseSortir[$rc]->penagihan)
                    // ->where('data_fttx_mt_sortirs.couse_code', '=', $RootCouseSortir[$rc]->couse_code)
                    // ->where('data_fttx_mt_sortirs.root_couse', '=', $RootCouseSortir[$rc]->root_couse);

                // if ($request->filterSite != "All") {
                    // $jmlRootCouse = $jmlRootCouse->where('site_penagihan', '=', $request->filterSite);
                // }
                // if ($request->filterBranch != "All") {
                    // $jmlRootCouse = $jmlRootCouse->where('branch', '=', $request->filterBranch);
                // }

                // $jmlRootCouse = $jmlRootCouse->groupBy('data_fttx_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detRootCouseSortir[$rc]['bulanan'][$mr] = [$jmlRootCouse];
            // }
        // }

        // dd($PenagihanSortir, $detPenagihanSortir, $detCouseCodeSortir, $detRootCouseSortir);
        // end query data Sortir

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getReasonStatusMTFttxGraph(Request $request)
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

        $PenagihanSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=', 'MT FTTX')
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_mt_sortirs.mt_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_mt_sortirs.mt_date', '=', $tahun)
            ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->action_taken];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTX')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('mt_date', '=', $tglGraph[$t])
                    // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_mt_sortirs.action_taken', '=', $PenagihanSortir[$pn]->action_taken);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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


    public function getRootCousePendingGraphMTFttx(Request $request)
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

        $PenagihanSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Pending')
            ->where('root_couse_penagihan.type_wo','=','MT FTTX')
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_mt_sortirs.mt_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_mt_sortirs.mt_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->action_taken];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
                    ->where('root_couse_penagihan.status', '=', 'Pending')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTX')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('mt_date', '=', $tglGraphPending[$t])
                    // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_mt_sortirs.action_taken', '=', $PenagihanSortir[$pn]->action_taken);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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

    public function getRootCousePendingMTFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $total = 0;
        $trendBulanan = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;
        

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        for ($tbln = 1; $tbln <= $bulan; $tbln++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $tbln)->format('M-Y')];
        }

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }
        // dd(\Carbon\Carbon::parse($startDate)->day);

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->where('type_wo','=','MT FTTX')->get();

        
        $RootPendingMonthly = DataFttxMtSortir::select(DB::raw('date_format(mt_date, "%b-%Y") as bulan'))
            ->whereYear('mt_date', '=', $tahun)
            ->whereMonth('mt_date', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                // $jmlBln = $RootPendingMonthly[$b]->bulan;
                if ($rootCousePending[$x]->penagihan == 'total_pending') {
                    $jml = DataFttxMtSortir::where('status_wo','=','Pending') //where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('mt_date', '=', $bln)
                    ->whereYear('mt_date', '=', $thn);
                }else {
                $jml = DataFttxMtSortir::where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('mt_date', '=', $bln)
                    ->whereYear('mt_date', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCousePending[$x]->bulan[$b] = $jml;
            }
        }
            

        // for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {
        //     $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
        //     $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

        //     $tot = DataFttxMtSortir::where('status_wo', '=', 'Pending')
        //         ->whereMonth('mt_date', '=', $bln)
        //         ->whereYear('mt_date', '=', $thn);
        //         // ->whereBetween('tgl_ikr', [$startDate, $endDate]); //->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn); //->count();
        //         // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

        //     if ($request->filterBranch != "All") {
        //         $tot = $tot->where('branch', '=', $request->filterBranch);
        //     }

        //     $tot = $tot->count();

        //     $rootCousePending[$rootCousePending->count() - 1]->bulan[$RootPendingMonthly[$b]->bulan] = $tot;
        // }

        return response()->json($rootCousePending);
    }

    public function getRootCouseCancelMTFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $total = 0;
        $trendBulanan = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;
        

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        for ($tbln = 1; $tbln <= $bulan; $tbln++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $tbln)->format('M-Y')];
        }

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }
        // dd(\Carbon\Carbon::parse($startDate)->day);

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->where('type_wo','=','MT FTTX')->get();

        
        $RootPendingMonthly = DataFttxMtSortir::select(DB::raw('date_format(mt_date, "%b-%Y") as bulan'))
            ->whereYear('mt_date', '=', $tahun)
            ->whereMonth('mt_date', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                // $jmlBln = $RootPendingMonthly[$b]->bulan;
                if ($rootCouseCancel[$x]->penagihan == 'total_cancel') {
                    $jml = DataFttxMtSortir::where('status_wo','=','Cancel') //where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('mt_date', '=', $bln)
                    ->whereYear('mt_date', '=', $thn);
                }else {
                $jml = DataFttxMtSortir::where('action_taken', '=', $rootCouseCancel[$x]->penagihan)
                    ->whereMonth('mt_date', '=', $bln)
                    ->whereYear('mt_date', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(mt_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCouseCancel[$x]->bulan[$b] = $jml;
            }
        }

        return response()->json($rootCouseCancel);
    }

    public function getRootCouseCancelGraphMTFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tglGraphCancel = [];
        $nameGraphCancel = [];
        $dataGraphCancel = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tglGraphCancel[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        $PenagihanSortir = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Cancel')
            ->where('root_couse_penagihan.type_wo','=','MT FTTX')
            // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_mt_sortirs.mt_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_mt_sortirs.mt_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphCancel[$p] = ['penagihan' => $PenagihanSortir[$p]->action_taken];
        }

        
        for ($t = 0; $t < count($tglGraphCancel); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxMtSortir::select(DB::raw('data_fttx_mt_sortirs.action_taken'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_mt_sortirs.action_taken')
                    ->where('root_couse_penagihan.status', '=', 'Cancel')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTX')
                    // ->whereNotIn('data_fttx_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('mt_date', '=', $tglGraphCancel[$t])
                    // ->whereMonth('data_fttx_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_mt_sortirs.action_taken', '=', $PenagihanSortir[$pn]->action_taken);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_mt_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
                // $tglGraph[$t]['jml'][$p] = $jml;
                // $dataGraph[$p]['penagihan'][$t] = ['jumlah' => $jml];
                $dataGraphCancel[$pn]['data'][] = $jml;
            }
        }
        // }
        // dd($tglGraph, $nameGraph, $dataGraph[0]['data'][0]);
        // }
        return response()->json([
            'tglGraphAPKCancel' => $tglGraphCancel, 'dataGraphAPKCancel' => $dataGraphCancel,
            'nameGraphAPKCancel' => $nameGraphCancel
        ]);
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
