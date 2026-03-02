<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataFttxMtOri;
use App\Models\ImportFtthIbSortirTemp;
use App\Models\Branch;
use App\Models\DataFttxIbSortir;
use Yajra\DataTables\DataTables;

class Report_FttxIBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses = Auth::user()->name;

        // $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();
        $branchPenagihan = DB::table('branches as b')->Join('data_fttx_ib_sortirs as d', 'b.nama_branch', '=', 'd.branch')
            ->select('b.id', 'd.branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_fttx_ib_sortirs')
            ->select('kotamadya_penagihan')
            // ->where('branch','=','Jakarta Timur')
            ->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        // dd($kotamadyaPenagihan);

        $tgl = DataFttxIbSortir::select('ib_date')->distinct()->get();

        $trendMonthly = DataFttxIbSortir::select(DB::raw('date_format(ib_date, "%b-%Y") as bulan, month(ib_date) as bln, year(ib_date) as thn'))->distinct()->orderBy('thn','DESC')->orderBy('bln','DESC')->get();

        return view(
            'report.reportingFttxIB',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                // 'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                // 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

    }

    public function getFilterBranchIBFttx(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_fttx_ib_sortirs')
            ->select('kotamadya_penagihan');
        // ->where('branch','=',$request->branchReport)
        // ->distinct()
        // ->orderBy('kotamadya_penagihan')
        // ->get();

        if ($request->branchReport != "All") {
            $kotamadyaPenagihan = $kotamadyaPenagihan->where('kotamadya_penagihan', '=', $request->branchReport);
        }

        $kotamadyaPenagihan = $kotamadyaPenagihan->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();


        return response()->json($kotamadyaPenagihan);
    }

    public function getTotalWoBranchIBFttx(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $TotAllBranch = DB::table('data_fttx_ib_sortirs')
                        ->whereMonth('ib_date','=', $bulan)
                        ->whereYear('ib_date','=', $tahun)
                        ->count();

        $branchPenagihan = DB::table('branches as b')
                    ->leftjoin('data_fttx_ib_sortirs as d', 'b.nama_branch','=','d.branch')
                    ->select('b.id', 'b.nama_branch')
                    ->whereMonth('d.ib_date','=', $bulan)
                    ->whereYear('d.ib_date','=', $tahun)
                    ->whereNotIn('b.nama_branch',['Apartemen', 'underground', 'Icon Plus'])
                    ->distinct()
                    ->orderBy('b.id')->get();
        
        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            
                $totWo = DataFttxIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('ib_date', $bulan)->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFttxIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('ib_date', $bulan)->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('ib_date', $bulan)->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('ib_date', $bulan)->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                // dump($totWo, $branchPenagihan[$b]->nama_branch, $bulan);
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $TotAllBranch;
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

    public function getFilterDashboardIBFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $TotAllBranch = DB::table('data_fttx_ib_sortirs')
                        ->whereMonth('ib_date','=', $bulan)
                        ->whereYear('ib_date','=', $tahun)
                        ->count();

        $branchPenagihan = DB::table('data_fttx_ib_sortirs as d')
            ->select('b.id', 'd.branch as nama_branch') //, 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.branch', '=', 'b.nama_branch')
            ->whereMonth('ib_date', '=', $bulan)->whereYear('ib_date', '=', $tahun)
            ->whereNotIn('b.nama_branch',['Apartemen','Underground', 'Icon Plus']);
            // ->whereBetween('ib_date', [$startDate, $endDate]);

        // if ($request->filterSite != "All") {
            // $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();

        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
                $totWo = DataFttxIbSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('ib_date', $bulan)
                    ->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFttxIbSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('ib_date', $bulan)
                    ->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFttxIbSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('ib_date', $bulan)
                    ->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFttxIbSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('ib_date', $bulan)
                    ->whereYear('ib_date', $tahun)
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->persenTotal = ($totWo * 100) / $TotAllBranch;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
        }

        return response()->json($branchPenagihan);
    }


    public function getClusterBranchIBFttx(Request $request)
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

        $branch = DB::table('data_fttx_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch');
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

        $branchCluster = DB::table('data_fttx_ib_sortirs as d')
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

                $jml = DB::table('data_fttx_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch','d.cluster')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.ib_date', '=', \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month) // $bulan)
                ->whereYear('d.ib_date', '=', $tahun)
                ->where('d.branch','=', $branchCluster[$bc]->nama_branch)
                ->where('d.cluster','=', $branchCluster[$bc]->cluster);


                $jml = $jml->groupBy('d.branch','d.cluster', 'b.id')->orderBy('b.id')->count();

                $detCluster[$bc]['bulanan'][$tm] = [$jml];

            }

        }

        for ($db = 0; $db < count($branch); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;
            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {

                $jmldbm = DB::table('data_fttx_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.ib_date', '=', \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month) // $bulan)
                ->whereYear('d.ib_date', '=', $tahun)
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


    public function getTrendMonthlyIBFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
            
        }

        for ($m = 0; $m < count($trendBulanan); $m++) {
            $totIBFtthMontly = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->count();

            $totIBFtthMontlyDone = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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

        // dd($trendBulanan);
        return response()->json($trendBulanan);
    }

    public function getTabelStatusIBFttx(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tgl = [];
        $type = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $dayMonth = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($dayMonth as $date) {
            $tgl[] = ['ib_date' => $date->format('Y-m-d')];
        }
        // dd($tgl);

        $dtType = DataFttxIbSortir::select('wo_type')
                    ->whereMonth('ib_date', $bulan)
                    ->whereYear('ib_date', $tahun)
                    ->distinct()
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                when wo_type="FTTB" then 2
                                when wo_type="UTP" then 3 end'))
                    ->pluck('wo_type');
        // dd($dtType[0]);

        for($t=0; $t < count($dtType); $t++) {
            $type[] = ['type' => $dtType[$t]];
            
            for ($d = 0; $d < count($tgl); $d++) {
                $tblStatus = DataFttxIbSortir::where('ib_date', '=', $tgl[$d])->where('wo_type', $dtType[$t]) //->whereMonth('ib_date', $bulan)->whereYear('ib_date', $tahun)
                    ->select(DB::raw('ib_date, 
                            count(if(status_wo = "Done" , 1, NULL)) as done, 
                            count(if(status_wo = "Pending" , 1, NULL)) as pending, 
                            count(if(status_wo = "Cancel" , 1, NULL)) as cancel'));
                // ->whereDay('ib_date', $dayMonth);

                // dd($tblStatus);
                if ($request->filterSite != "All") {
                    $tblStatus = $tblStatus->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $tblStatus = $tblStatus->where('branch', '=', $request->filterBranch);
                }

                $tblStatus = $tblStatus->orderBy('ib_date')
                    ->groupBy('ib_date')->first();

                // dd($tblStatus, $tgl[$d]['ib_date']);
                // if(count($tblStatus) == 0) {
                //     dd($d);
                // }
                // for ($x=0; $x < count($tblStatus); $x ++) {
                //     // dd($tblStatus[$x]);
                //     $tgl[$d]['wotype'] = $tblStatus[$x]->wo_type ?? "-";
                //     $tgl[$d]['Done'] = $tblStatus[$x]->Done ?? 0;
                //     $tgl[$d]['Pending'] = $tblStatus[$x]->Pending ?? 0;
                //     $tgl[$d]['Cancel'] = $tblStatus[$x]->Cancel ?? 0;
                // }
                $type[$t]['detail'][$d]['ib_date'] = $tgl[$d]['ib_date'];
                $type[$t]['detail'][$d]['Done'] = $tblStatus->done ?? 0;
                $type[$t]['detail'][$d]['Pending'] = $tblStatus->pending ?? 0;
                $type[$t]['detail'][$d]['Cancel'] = $tblStatus->cancel ?? 0;
                // $type[$t]['detail'][] = ['Done' => $tblStatus->done ?? 0];
                // $tgl[$d]['Done'] = $tblStatus->done ?? 0;
                // $tgl[$d]['Pending'] = $tblStatus->pending ?? 0;
                // $tgl[$d]['Cancel'] = $tblStatus->cancel ?? 0;
            }
        }

        // dd(count($type[0]['detail']), $tgl);           

        return response()->json(['data' => $tgl, 'type' => $type]);
    }

    public function getTabelStatusIBFttxType(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
            
        }

        // dd($trendBulanan);

        for ($m = 0; $m < count($trendBulanan); $m++) {
            $totIBFtthMontly = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttx, 
            count(if(wo_type = "FTTB", 1, NULL)) as totfttb, count(if(wo_type = "UTP", 1, NULL)) as totutp'));

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttx'] = $totIBFtthMontly->totfttx ?? 0;
            $trendBulanan[$m]['totfttb'] = $totIBFtthMontly->totfttb ?? 0;
            $trendBulanan[$m]['totutp'] = $totIBFtthMontly->totutp ?? 0;

            // dd($trendBulanan, $totIBFtthMontly);

            $totIBFtthMontlyDone = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttxdone, 
                    count(if(wo_type = "FTTB", 1, NULL)) as totfttbdone, count(if(wo_type = "UTP", 1, NULL)) as totutpdone'))
                ->where('status_wo', '=', 'Done');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontlyDone = $totIBFtthMontlyDone->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttxdone'] = $totIBFtthMontlyDone->totfttxdone ?? 0;
            $trendBulanan[$m]['totfttbdone'] = $totIBFtthMontlyDone->totfttbdone ?? 0;
            $trendBulanan[$m]['totutpdone'] = $totIBFtthMontlyDone->totutpdone ?? 0;
        }

        // dd($trendBulanan);
        return response()->json($trendBulanan);
    }

    public function getRootCouseAPKIBFttx_testNew(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulanan = [];
        $detPenagihanSortir = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            $bulanan[] = $bt; 
        }
      
        $PenagihanSortir = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Cancel')
            ->where('root_couse_penagihan.type_wo','=','IB FTTX');
            // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_fttx_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_fttx_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_ib_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($PenagihanSortir);
        $dtType = DB::table('data_fttx_ib_sortirs')
                    ->whereIn(DB::raw('month(ib_date)'), $bulanan )
                    ->whereYear('ib_date',$tahun)
                    ->select('wo_type')->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                when wo_type="FTTB" then 2
                                when wo_type="UTP" then 3 end'))->pluck('wo_type');
                    // ->get();
        // dd($PenagihanSortir);
        for ($dt=0; $dt < count($dtType); $dt++) {
            $detPenagihanSortir[$dt]['type'] = $dtType[$dt];

            for($p=0; $p < count($PenagihanSortir); $p++) {

                $detPenagihanSortir[$dt]['penagihan'][$p] = $PenagihanSortir[$p]->action_taken;
                for ($m = 0; $m < count($trendBulanan); $m++) {

                    $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.action_taken'))
                        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
                        // ->where('root_couse_penagihan.status', '=', 'Done')
                        // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
                        // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                        ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                        ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun)
                        ->where('data_fttx_ib_sortirs.wo_type', '=', $dtType[$dt])
                        ->where('data_fttx_ib_sortirs.status_wo', '=', 'Done');
                        // ->where('data_fttx_ib_sortirs.action_taken', '=', $PenagihanSortir[$ps]->action_taken);

                    if ($request->filterSite != "All") {
                        $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                    }
                    if ($request->filterBranch != "All") {
                        $jml = $jml->where('branch', '=', $request->filterBranch);
                    }

                    $jml = $jml->groupBy('data_fttx_ib_sortirs.wo_type','data_fttx_ib_sortirs.action_taken')
                            ->orderBy(DB::raw('case when data_fttx_ib_sortirs.wo_type="FTTX" then 1
                                    when data_fttx_ib_sortirs.wo_type="FTTB" then 2
                                    when data_fttx_ib_sortirs.wo_type="UTP" then 3 end'))
                            ->get();

                    for($at=0; $at < count($jml); $at++) {
                        // $detPenagihanSortir[$dt]['penagihan'] = $jml[$at]->action_taken;
                    }
                    
                }
            }
                
                // dd($jml);
        }

        // dd($detPenagihanSortir);

        // for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

        //     $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->action_taken;
        //     for ($m = 0; $m < count($trendBulanan); $m++) {

        //         $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.wo_type, data_fttx_ib_sortirs.action_taken'))
        //             ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
        //             ->where('root_couse_penagihan.status', '=', 'Cancel')
        //             ->where('root_couse_penagihan.type_wo','=','IB FTTX')
        //             // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
        //             ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
        //             ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun)
        //             ->where('data_fttx_ib_sortirs.action_taken', '=', $PenagihanSortir[$ps]->action_taken);

        //         if ($request->filterSite != "All") {
        //             $jml = $jml->where('site_penagihan', '=', $request->filterSite);
        //         }
        //         if ($request->filterBranch != "All") {
        //             $jml = $jml->where('branch', '=', $request->filterBranch);
        //         }

        //         $jml = $jml->groupBy('data_fttx_ib_sortirs.wo_type','data_fttx_ib_sortirs.action_taken', 'root_couse_penagihan.id')
        //                 ->orderBy(DB::raw('case when data_fttx_ib_sortirs.wo_type="FTTX" then 1
        //                         when data_fttx_ib_sortirs.wo_type="FTTB" then 2
        //                         when data_fttx_ib_sortirs.wo_type="UTP" then 3 end'))
        //                 ->orderBy('root_couse_penagihan.id')->get();

        //         dd($jml);
        //         // $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
                
        //         for($t=0; $t < count($jml); $t++) {
        //             $detPenagihanSortir[$t]['type'] = $jml[$t]->wo_type;
        //             $detPenagihanSortir[$t]['detail'] = $jml[$t]->action_taken;
        //             // $detPenagihanSortir[$t]['type'] = ['penagihan'=> $jml[$t]->action_taken];
        //             // $detPenagihanSortir[$m]['penagihan'][$t] = $jml[$t]->action_taken;
        //         }
        //     }
        // }
        //     dd($jml, $detPenagihanSortir);
        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getRootCouseAPKIBFttx_old(Request $request)
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

        $PenagihanSortir = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.action_taken'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','IB FTTX');
            // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_fttx_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_fttx_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_fttx_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_ib_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

            $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->action_taken;
            for ($m = 0; $m < count($trendBulanan); $m++) {

                $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.action_taken'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','IB FTTX')
                    // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_ib_sortirs.action_taken', '=', $PenagihanSortir[$ps]->action_taken);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_ib_sortirs.action_taken', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getReasonStatusIBFttxGraph(Request $request)
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

        $PenagihanSortir = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
            ->where('data_fttx_ib_sortirs.status_wo', '=', 'Done')
            // ->where('root_couse_penagihan.type_wo','=', 'IB FTTX')
            // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun)
            ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
                    ->where('data_fttx_ib_sortirs.status_wo', '=', 'Done')
                    // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
                    // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('ib_date', '=', $tglGraph[$t])
                    // ->whereMonth('data_fttx_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->count();

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


    public function getRootCousePendingGraphIBFttx(Request $request)
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

        $PenagihanSortir = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
            ->where('data_fttx_ib_sortirs.status_wo', '=', 'Pending')
            // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
            // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
                    ->where('data_fttx_ib_sortirs.status_wo', '=', 'Pending')
                    // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
                    // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('ib_date', '=', $tglGraphPending[$t])
                    // ->whereMonth('data_fttx_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->count();

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

    public function getRootCousePendingGraphIBFttxType(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            // $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
        }  

        // dd($trendBulanan);

        for ($m = 0; $m < count($trendBulanan); $m++) {
            $totIBFtthMontly = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttx, 
            count(if(wo_type = "FTTB", 1, NULL)) as totfttb, count(if(wo_type = "UTP", 1, NULL)) as totutp'));

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttx'] = $totIBFtthMontly->totfttx ?? 0;
            $trendBulanan[$m]['totfttb'] = $totIBFtthMontly->totfttb ?? 0;
            $trendBulanan[$m]['totutp'] = $totIBFtthMontly->totutp ?? 0;

            // dd($trendBulanan, $totIBFtthMontly);

            $totIBFtthMontlyPending = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttxpending, 
                    count(if(wo_type = "FTTB", 1, NULL)) as totfttbpending, count(if(wo_type = "UTP", 1, NULL)) as totutppending'))
                ->where('status_wo', '=', 'Pending');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyPending = $totIBFtthMontlyPending->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyPending = $totIBFtthMontlyPending->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontlyPending = $totIBFtthMontlyPending->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttxpending'] = $totIBFtthMontlyPending->totfttxpending ?? 0;
            $trendBulanan[$m]['totfttbpending'] = $totIBFtthMontlyPending->totfttbpending ?? 0;
            $trendBulanan[$m]['totutppending'] = $totIBFtthMontlyPending->totutppending ?? 0;
        }

        // dd($trendBulanan);
        return response()->json($trendBulanan);
    }

    public function getRootCouseCancelGraphIBFttxType(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $bulantahun = \Carbon\Carbon::parse($request->bulanTahunReport)->subMonths($bulan - 1);

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            // $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
        }

        // dd($trendBulanan);

        for ($m = 0; $m < count($trendBulanan); $m++) {
            $totIBFtthMontly = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttx, 
            count(if(wo_type = "FTTB", 1, NULL)) as totfttb, count(if(wo_type = "UTP", 1, NULL)) as totutp'));

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttx'] = $totIBFtthMontly->totfttx ?? 0;
            $trendBulanan[$m]['totfttb'] = $totIBFtthMontly->totfttb ?? 0;
            $trendBulanan[$m]['totutp'] = $totIBFtthMontly->totutp ?? 0;

            // dd($trendBulanan, $totIBFtthMontly);

            $totIBFtthMontlyCancel = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->select(DB::raw('month(ib_date) as bln, year(ib_date) as thn, count(if(wo_type = "FTTX", 1, NULL)) as totfttxcancel, 
                    count(if(wo_type = "FTTB", 1, NULL)) as totfttbcancel, count(if(wo_type = "UTP", 1, NULL)) as totutpcancel'))
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyCancel = $totIBFtthMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyCancel = $totIBFtthMontlyCancel->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontlyCancel = $totIBFtthMontlyCancel->groupBy('bln','thn')->first();

            $trendBulanan[$m]['totfttxcancel'] = $totIBFtthMontlyCancel->totfttxcancel ?? 0;
            $trendBulanan[$m]['totfttbcancel'] = $totIBFtthMontlyCancel->totfttbcancel ?? 0;
            $trendBulanan[$m]['totutpcancel'] = $totIBFtthMontlyCancel->totutpcancel ?? 0;
        }

        // dd($trendBulanan);
        return response()->json($trendBulanan);
    }

    public function getRootCouseAPKIBFttx(Request $request)
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

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        //     $inBulan[] = $bt; 
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            // $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
        }  

        $tblRootCouseDone = [];
        $filBranch = $request->filterBranch;

        if($bulan == 1) {

            $dtType = DB::table('v_fttx_ib_done')
                ->select('wo_type')
                ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                ->groupBy('wo_type')
                ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                when wo_type="FTTB" then 2
                                when wo_type="UTP" then 3 end'))
                ->get();


            $rootCouseDone = DB::table('v_fttx_ib_done')
                ->select('wo_type', 'penagihan')
                ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                ->groupBy('wo_type', 'penagihan')->get();

        } else {

            // $dtType = ["FTTX", "FTTB", "UTP"];
            $dtType = DB::table('v_fttx_ib_done')
                    ->select('wo_type')
                    // ->whereIn('bulan', $inBulan)
                    ->where('tahun', $tahun)
                    ->where('bulan', '<=', $bulan)
                    ->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                    when wo_type="FTTB" then 2
                                    when wo_type="UTP" then 3 end'))
                    ->get();
            

            // dd($dtType);
            $rootCouseDone = DB::table('v_fttx_ib_done')
                    // ->select('id','penagihan')
                    ->select('wo_type', 'penagihan')
                    ->where('tahun', $tahun)
                    ->where('bulan', '<=', $bulan)
                    // ->whereIn('bulan', $inBulan)
                    // ->groupBy('id','penagihan')->get();
                    ->groupBy('penagihan')->get();

        }
        

        
        for($d=0; $d < count($dtType); $d++){

            $tblRootCouseDone[$d]['type']= $dtType[$d]->wo_type;

            for($p=0; $p < count($rootCouseDone); $p++) {

                // $tblRootCouseDone[$d]['penagihan'][$p]= $rootCouseDone[$p]->penagihan;

                if($rootCouseDone[$p]->wo_type == $dtType[$d]->wo_type) {

                    for ($x = 0; $x < count($trendBulanan); $x++) {

                        $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;
                        $Qthn = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->year;
                        // dd($Qbln, $tahun);
                        $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

                        $jml = DB::table('v_fttx_ib_done')
                            ->select(DB::raw('wo_type,penagihan, ifnull(sum(total),0) as done'))
                            ->where('bulan', $Qbln)
                            ->where('tahun', $Qthn)
                            ->where('wo_type', $dtType[$d]->wo_type)
                            ->where('penagihan', $rootCouseDone[$p]->penagihan)
                            ->groupBy('wo_type','penagihan', 'bulan', 'tahun');

                        if ($request->filterBranch != "All") {
                            $jml = $jml->where('branch', '=', $request->filterBranch);
                        }

                        $jml=$jml->first();
                        $vJml = $jml->done ?? 0;
                        $tblRootCouseDone[$d]['detail'][$p]['penagihan'] = $rootCouseDone[$p]->penagihan;
                        $tblRootCouseDone[$d]['detail'][$p]['bulanan'][$blnThn] = (int)$vJml;
                        // dd($tblRootCouseDone);
                        // $tblRootCouseDone[$d]= ['penagihgan' => $rootCouseDone[$p]->penagihan, 'bulanan' => [$jml->done ?? 0]];
                        
                        // dd($dtType[$d]->wo_type, $rootCouseDone[$p]->penagihan, $jml);
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_fttx_ib_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

                    }
                }                
            }

                
        }
        
        // dd($tblRootCouseDone);

        

        // $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        // $rootCouseDone = $rootCouseDone->orderBy(DB::raw('case when wo_type="FTTX" then 1
        //                                                 when wo_type="FTTB" then 2
        //                                                 when wo_type="UTP" then 3 end'))
        //                                 ->orderBy('persen_'.$blnThnFilter.'', 'DESC')
        //                                 ->get();

        // dd($rootCouseDone);

        // for($psx=0; $psx < $rootCouseDone->count(); $psx++){
        //     $tblRootCouseDone[$psx] = ['type' => $rootCouseDone[$psx]->wo_type];

        //     for($tb=0; $tb < count($trendBulanan); $tb++){
        //         $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

        //         $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
        //         $persenBln = "persen_".$blnThn;

        //         $tblRootCouseDone[$psx]['penagihan'] = $rootCouseDone[$psx]->penagihan;
        //         $tblRootCouseDone[$psx]['bulanan'][$tb] = [(int)$rootCouseDone[$psx]->$blnThn];
        //         $tblRootCouseDone[$psx]['persen'][$tb] = [round($rootCouseDone[$psx]->$persenBln, 1)];
                
        //     }

        // }

        return response()->json($tblRootCouseDone);
    }

    public function getRootCousePendingIBFttx_oldFix(Request $request)
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

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $tblRootCousePending = [];

        $rootCousePending = DB::table('v_fttx_ib_pending')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCousePending = $rootCousePending->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $rootCousePending = $rootCousePending->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_fttx_ib_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }

        if ($request->filterBranch != "All") {
            $rootCousePending = $rootCousePending->where('branch', '=', $request->filterBranch);
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $rootCousePending = $rootCousePending->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        for($psx=0; $psx < $rootCousePending->count(); $psx++){
            $tblRootCousePending[$psx] = ['penagihan' => $rootCousePending[$psx]->penagihan];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $tblRootCousePending[$psx]['bulanan'][$tb] = [(int)$rootCousePending[$psx]->$blnThn];
                $tblRootCousePending[$psx]['persen'][$tb] = [round($rootCousePending[$psx]->$persenBln, 1)];
                
            }

        }

        return response()->json($tblRootCousePending);
    }

    public function getRootCousePendingIBFttx(Request $request)
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

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        //     $inBulan[] = $bt; 
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            // $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
        }  

        $tblRootCouseDone = [];
        $filBranch = $request->filterBranch;

        if($bulan == 1) {

            $dtType = DB::table('v_fttx_ib_pending')
                    ->select('wo_type')
                    ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                    when wo_type="FTTB" then 2
                                    when wo_type="UTP" then 3 end'))
                    ->get();

            $rootCousePending = DB::table('v_fttx_ib_pending')
                    ->select('wo_type', 'penagihan')
                    ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->groupBy('wo_type', 'penagihan')->get();

        } else {

            // $dtType = ["FTTX", "FTTB", "UTP"];
            $dtType = DB::table('v_fttx_ib_pending')
                    ->select('wo_type')
                    ->where('tahun', $tahun)
                    ->where('bulan', '<=', $bulan)
                    ->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                    when wo_type="FTTB" then 2
                                    when wo_type="UTP" then 3 end'))
                    ->get();

            $rootCousePending = DB::table('v_fttx_ib_pending')
                    ->select('wo_type', 'penagihan')
                    ->where('tahun', $tahun)
                    ->where('bulan', '<=', $bulan)
                    ->groupBy('wo_type', 'penagihan')->get();
        }
        

        
        for($d=0; $d < count($dtType); $d++){

            $tblRootCousePending[$d]['type']= $dtType[$d]->wo_type;

            for($p=0; $p < count($rootCousePending); $p++) {

                // $tblRootCouseDone[$d]['penagihan'][$p]= $rootCouseDone[$p]->penagihan;

                if($rootCousePending[$p]->wo_type == $dtType[$d]->wo_type) {

                    for ($x = 0; $x < count($trendBulanan); $x++) {

                        $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;
                        $Qthn = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->year;
                        // dd($Qbln, $tahun);
                        $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

                        $jml = DB::table('v_fttx_ib_pending')
                            ->select(DB::raw('wo_type,penagihan, ifnull(sum(total),0) as pending'))
                            ->where('bulan', $Qbln)
                            ->where('tahun', $Qthn)
                            ->where('wo_type', $dtType[$d]->wo_type)
                            ->where('penagihan', $rootCousePending[$p]->penagihan)
                            ->groupBy('wo_type','penagihan', 'bulan', 'tahun');

                        if ($request->filterBranch != "All") {
                            $jml = $jml->where('branch', '=', $request->filterBranch);
                        }

                        $jml=$jml->first();
                        // dd($dtType, $rootCousePending,$jml);
                        $vJml = $jml->pending ?? 0;
                        $tblRootCousePending[$d]['detail'][$p]['penagihan'] = $rootCousePending[$p]->penagihan;
                        $tblRootCousePending[$d]['detail'][$p]['bulanan'][$blnThn] = (int)$vJml;
                        // dd($tblRootCouseDone);
                        // $tblRootCouseDone[$d]= ['penagihgan' => $rootCouseDone[$p]->penagihan, 'bulanan' => [$jml->done ?? 0]];
                        
                        // dd($dtType[$d]->wo_type, $rootCouseDone[$p]->penagihan, $jml);
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_fttx_ib_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

                    }
                }
                
            }

                
        }
        
        return response()->json($tblRootCousePending);
    }

    public function getRootCousePendingIBFttxOld(Request $request)
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

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->where('type_wo','=','IB FTTX')->get();

        
        $RootPendingMonthly = DataFttxIbSortir::select(DB::raw('date_format(ib_date, "%b-%Y") as bulan'))
            ->whereYear('ib_date', '=', $tahun)
            ->whereMonth('ib_date', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                // $jmlBln = $RootPendingMonthly[$b]->bulan;
                // if ($rootCousePending[$x]->penagihan == 'total_pending') {
                    $jmlBulanan = DataFttxIbSortir::where('status_wo','=','Pending') //where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('ib_date', '=', $bln)
                    ->whereYear('ib_date', '=', $thn);
                // }else {
                $jml = DataFttxIbSortir::where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('ib_date', '=', $bln)
                    ->whereYear('ib_date', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                // }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                    $jmlBulanan = $jmlBulanan->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();
                $jmlBulanan = $jmlBulanan->count();

                $rootCousePending[$x]->bulan[$b] = $jml;
                $rootCousePending[$x]->totalBulanan[$b] = $jmlBulanan;
            }
        }

        return response()->json($rootCousePending);
    }

    public function getRootCouseCancelIBFttx(Request $request)
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

        // for ($bt = 1; $bt <= $bulan; $bt++) {
        //     $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        //     $inBulan[] = $bt; 
        // }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            // $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            if($bulan == 1) {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->startOfMonth()->subMonth()->format('M-Y')];
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
                
            } else {
                $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            } 
        }  


        $tblRootCouseCancel = [];
        $filBranch = $request->filterBranch;

        if($bulan == 1) {

            $dtType = DB::table('v_fttx_ib_cancel')
                    ->select('wo_type')
                    ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                    when wo_type="FTTB" then 2
                                    when wo_type="UTP" then 3 end'))
                    ->get();

            $rootCouseCancel = DB::table('v_fttx_ib_cancel')
                    ->select('wo_type', 'penagihan')
                    ->where(function ($query) use($tahun, $filBranch) {
                        $query->where('bulan', '12')
                            ->where('tahun', $tahun - 1)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->orWhere(function ($q) use($tahun, $bulan, $filBranch) {
                        $q->where('bulan', $bulan)
                            ->where('tahun', $tahun)
                            // ->where('status_wo','=', 'Done')
                            ->when($filBranch != "All", function($qu) use($filBranch) {
                                return $qu->where('branch', '=', $filBranch);
                            });
                    })
                    ->groupBy('wo_type', 'penagihan')
                    // ->orderBy('total','DESC')
                    ->get();

        } else {

            // $dtType = ["FTTX", "FTTB", "UTP"];
            $dtType = DB::table('v_fttx_ib_cancel')
                    ->select('wo_type')
                    ->where('bulan', '<=', $bulan)
                    ->where('tahun', $tahun)
                    ->groupBy('wo_type')
                    ->orderBy(DB::raw('case when wo_type="FTTX" then 1
                                    when wo_type="FTTB" then 2
                                    when wo_type="UTP" then 3 end'))
                    ->get();

            $rootCouseCancel = DB::table('v_fttx_ib_cancel')
                    // ->select('penagihan')
                    ->select('wo_type', 'penagihan')
                    ->where('bulan', '<=', $bulan)
                    ->where('tahun', $tahun)
                    ->groupBy('wo_type', 'penagihan')
                    // ->orderBy('total','DESC')
                    ->get();
        
        }      

        
        for($d=0; $d < count($dtType); $d++){

            $tblRootCouseCancel[$d]['type']= $dtType[$d]->wo_type;

            for($p=0; $p < count($rootCouseCancel); $p++) {

                // $tblRootCouseDone[$d]['penagihan'][$p]= $rootCouseDone[$p]->penagihan;

                if($rootCouseCancel[$p]->wo_type == $dtType[$d]->wo_type) {

                    for ($x = 0; $x < count($trendBulanan); $x++) {

                        $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;
                        $Qthn = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->year;
                        // dd($Qbln, $tahun);
                        $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

                        $jml = DB::table('v_fttx_ib_cancel')
                            ->select(DB::raw('wo_type,penagihan, ifnull(sum(total),0) as cancel'))
                            ->where('bulan', $Qbln)
                            ->where('tahun', $Qthn)
                            ->where('wo_type', $dtType[$d]->wo_type)
                            ->where('penagihan', $rootCouseCancel[$p]->penagihan)
                            ->groupBy('wo_type','penagihan', 'bulan', 'tahun');

                        if ($request->filterBranch != "All") {
                            $jml = $jml->where('branch', '=', $request->filterBranch);
                        }

                        $jml=$jml->first();
                        // dd($dtType, $rootCousePending,$jml);
                        $vJml = $jml->cancel ?? 0;
                        $tblRootCouseCancel[$d]['detail'][$p]['penagihan'] = $rootCouseCancel[$p]->penagihan;
                        $tblRootCouseCancel[$d]['detail'][$p]['bulanan'][$blnThn] = (int)$vJml;
                        // dd($tblRootCouseDone);
                        // $tblRootCouseDone[$d]= ['penagihgan' => $rootCouseDone[$p]->penagihan, 'bulanan' => [$jml->done ?? 0]];
                        
                        // dd($dtType[$d]->wo_type, $rootCouseDone[$p]->penagihan, $jml);
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
                        // $rootCouseDone = $rootCouseDone->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_fttx_ib_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

                    }
                }
                    
            }

                
        }
        
        return response()->json($tblRootCouseCancel);
    }

    public function getRootCouseCancelIBFttx_oldNew(Request $request)
    {
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $tblRootCouseCancel = [];

        $rootCouseCancel = DB::table('v_fttx_ib_cancel')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_fttx_ib_cancel where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }

        if ($request->filterBranch != "All") {
            $rootCouseCancel = $rootCouseCancel->where('branch', '=', $request->filterBranch);
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $rootCouseCancel = $rootCouseCancel->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        for($psx=0; $psx < $rootCouseCancel->count(); $psx++){
            $tblRootCouseCancel[$psx] = ['penagihan' => $rootCouseCancel[$psx]->penagihan];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $tblRootCouseCancel[$psx]['bulanan'][$tb] = [(int)$rootCouseCancel[$psx]->$blnThn];
                $tblRootCouseCancel[$psx]['persen'][$tb] = [round($rootCouseCancel[$psx]->$persenBln, 1)];
                
            }

        }

        return response()->json($tblRootCouseCancel);
    }

    
    public function getRootCouseCancelIBFttxOld(Request $request)
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

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->where('type_wo','=','IB FTTX')->get();

        
        $RootPendingMonthly = DataFttxIbSortir::select(DB::raw('date_format(ib_date, "%b-%Y") as bulan'))
            ->whereYear('ib_date', '=', $tahun)
            ->whereMonth('ib_date', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                // $jmlBln = $RootPendingMonthly[$b]->bulan;
                if ($rootCouseCancel[$x]->penagihan == 'total_cancel') {
                    $jml = DataFttxIbSortir::where('status_wo','=','Cancel') //where('action_taken', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('ib_date', '=', $bln)
                    ->whereYear('ib_date', '=', $thn);
                }else {
                $jml = DataFttxIbSortir::where('action_taken', '=', $rootCouseCancel[$x]->penagihan)
                    ->whereMonth('ib_date', '=', $bln)
                    ->whereYear('ib_date', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(ib_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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

    public function getRootCouseCancelGraphIBFttx(Request $request)
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

        $PenagihanSortir = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
            ->where('data_fttx_ib_sortirs.status_wo', '=', 'Cancel')
            // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
            // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_fttx_ib_sortirs.ib_date', '=', $bulan) // $bulan)
            ->whereYear('data_fttx_ib_sortirs.ib_date', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_fttx_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // if ($request->filterSite != "All") {
            // $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphCancel[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphCancel); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFttxIbSortir::select(DB::raw('data_fttx_ib_sortirs.penagihan'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_fttx_ib_sortirs.action_taken')
                    ->where('data_fttx_ib_sortirs.status_wo', '=', 'Cancel')
                    // ->where('root_couse_penagihan.type_wo','=','IB FTTX')
                    // ->whereNotIn('data_fttx_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('ib_date', '=', $tglGraphCancel[$t])
                    // ->whereMonth('data_fttx_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_fttx_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_fttx_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_fttx_ib_sortirs.penagihan')->orderBy('data_fttx_ib_sortirs.penagihan')->count();

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

    
    public function getDetailAPKIbFttx(Request $request)
    {
        
        if($request->detSlide=="action_status"){
            $detAPKBranch = DB::table('v_fttx_ib_done')
                        ->select('branch', DB::raw('sum(total) as total'))
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            // if($request->detSite != "All") {
            //     $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="pending"){
            $detAPKBranch = DB::table('v_fttx_ib_pending')
                        ->select('branch', DB::raw('sum(total) as total'))->distinct()
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            // if($request->detSite != "All") {
            //     $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="cancel"){
            $detAPKBranch = DB::table('v_fttx_ib_cancel')
                        ->select('branch', DB::raw('sum(total) as total'))->distinct()
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            // if($request->detSite != "All") {
            //     $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        return response()->json(['detailBranchAPK' => $detAPKBranch]);

    }

    public function dataDetailAPKIbFttx(Request $request)
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '2048M');

        $akses = Auth::user()->name;

        if($request->detSlide=="action_status"){
            $detAPK = DB::table('data_fttx_ib_sortirs')
                    ->where('status_wo','=','Done')
                    ->whereMonth('ib_date', '=',$request->detBulan)
                    ->whereYear('ib_date', '=',$request->detThn);

            // if($request->detSite != "All") {
            //     $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('action_taken','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if($request->detSlide=="pending"){
            $detAPK = DB::table('data_fttx_ib_sortirs')
                    ->where('status_wo','=','Pending')
                    ->whereMonth('ib_date', '=',$request->detBulan)
                    ->whereYear('ib_date', '=',$request->detThn);

            // if($request->detSite != "All") {
            //     $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('action_taken','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if($request->detSlide=="cancel"){
            $detAPK = DB::table('data_fttx_ib_sortirs')
                    ->where('status_wo','=','Cancel')
                    ->whereMonth('ib_date', '=',$request->detBulan)
                    ->whereYear('ib_date', '=',$request->detThn);

            // if($request->detSite != "All") {
            //     $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            // }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('action_taken','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if ($request->ajax()) {
            // $datas = DB::table('import_ftth_mt_temps')->where('login', '=', $akses)->get();
            return DataTables::of($detAPK)
                ->addIndexColumn() //memberikan penomoran
                // ->addColumn('action', function ($row) {
                //     $btn = '<a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                //              <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                //     return $btn;
                // })
                // ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function getDetailAPKIbFttxCluster(Request $request)
    {
        
        if($request->detSlide=="reason_status"){
            $detAPKBranch = DB::table('v_ftth_ib_cluster')
                        ->select('branch', 'cluster', DB::raw('sum(ftth_ib_done) as total'))
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            if($request->detSite != "All") {
                $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','cluster','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="pending"){
            $detAPKBranch = DB::table('v_ftth_ib_cluster')
                        ->select('branch', 'cluster', DB::raw('sum(ftth_ib_pending) as total'))->distinct()
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            if($request->detSite != "All") {
                $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','cluster', 'bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="cancel"){
            $detAPKBranch = DB::table('v_ftth_ib_cluster')
                        ->select('branch','cluster', DB::raw('sum(ftth_ib_cancel) as total'))->distinct()
                        ->where('bulan','=', $request->detBulan)
                        ->where('tahun','=', $request->detThn);

            if($request->detSite != "All") {
                $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "penagihan"){
                $detAPKBranch=$detAPKBranch->where('penagihan','=',$request->detPenagihan);
            }
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','cluster', 'bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        return response()->json(['detailBranchAPKCluster' => $detAPKBranch]);

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
