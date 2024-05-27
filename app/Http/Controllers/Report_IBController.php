<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataFtthIbSortir;
use App\Models\ImportFtthIbSortirTemp;
use App\Models\Branch;

class Report_IBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $akses = Auth::user()->name;

        // $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();
        $branchPenagihan = DB::table('branches as b')->Join('data_ftth_ib_sortirs as d', 'b.nama_branch', '=', 'd.branch')
            ->select('b.id', 'd.branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_ftth_ib_sortirs')
            ->select('kotamadya_penagihan')
            // ->where('branch','=','Jakarta Timur')
            ->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        // dd($kotamadyaPenagihan);

        $tgl = ImportFtthIbSortirTemp::select('tgl_ikr')->distinct()->get();

        $trendMonthly = DataFtthIbSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        // $site = DataFtthIbSortir::select('site_penagihan')->distinct()->get();

        // dd($tblStatus);

        // dd($trendMonthly[0]->bulan);
        // dd(\Carbon\Carbon::parse($tgl[0]->tgl_ikr)->format('F'));

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->daysInMonth);

        // query data Sortir

        // $detPenagihanSortir =ImportFtthIBSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        // // dd($detPenagihanSortir);

        // $detCouseCodeSortir =ImportFtthIBSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,reason_status, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status')->orderBy('penagihan')->get();

        // $detRootCouseSortir =ImportFtthIBSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status', 'root_couse')->orderBy('penagihan')->get();

        // end query data Sortir

        return view(
            'report.reportingFtthIB',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                // 'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                // 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );
    }

    public function getFilterBranchIBFtth(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_ftth_ib_sortirs')
            ->select('kotamadya_penagihan');
        // ->where('branch','=',$request->branchReport)
        // ->distinct()
        // ->orderBy('kotamadya_penagihan')
        // ->get();

        if ($request->branchReport != "All") {
            $kotamadyaPenagihan = $kotamadyaPenagihan->where('branch', '=', $request->branchReport);
        }

        $kotamadyaPenagihan = $kotamadyaPenagihan->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();


        return response()->json($kotamadyaPenagihan);
    }

    public function getTotalWoBranchIBFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartemen") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();
                    
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$b]->nama_branch == "Underground") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground" && $branchPenagihan[$b]->nama_branch <> "Retail")) {
                $totWo = DataFtthIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                
                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            }
        }

        return response()->json($branchPenagihan);
    }

    public function getFilterDashboardIBFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;


        $branchPenagihan = DB::table('data_ftth_ib_sortirs as d')
            ->select('b.id', 'd.branch as nama_branch', 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.branch', '=', 'b.nama_branch')
            ->whereMonth('tgl_ikr', '=', $bulan)->whereYear('tgl_ikr', '=', $tahun);
            // ->whereBetween('tgl_ikr', [$startDate, $endDate]);


        if ($request->filterSite != "All") {
            $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('b.id')->get();


        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
            if ($branchPenagihan[$br]->site_penagihan == "Apartemen") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    $branchPenagihan[$br]->id = "11";
                    $branchPenagihan[$br]->nama_branch = "Apartemen";
                }
                // $branchPenagihan[$br]->nama_branch = "Apartemen";
                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$br]->site_penagihan == "Underground") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    $branchPenagihan[$br]->nama_branch = "Underground";
                }
                // $branchPenagihan[$br]->nama_branch = "Underground";
                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$br]->site_penagihan == "Retail") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
        }

        return response()->json($branchPenagihan);
    }

    public function getClusterBranchIBFtth(Request $request)
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

        $kolomBln='';

        $totBranchCluster = DB::table('v_ftth_ib_cluster')
                        ->select('nama_branch','site_penagihan')
                        ->groupBy('nama_branch','site_penagihan');

        $totCluster = DB::table('v_ftth_ib_cluster')
                        ->select('nama_branch','cluster','site_penagihan')
                        ->groupBy('nama_branch','cluster','site_penagihan');

        if ($request->filterSite != "All") {
            $totBranchCluster = $totBranchCluster->where('site_penagihan', '=', $request->filterSite);
            $totCluster = $totCluster->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $totBranchCluster = $totBranchCluster->where('branch', '=', $request->filterBranch);
            $totCluster = $totCluster->where('branch', '=', $request->filterBranch);
        }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            $Qbln = \Carbon\Carbon::parse($trendBulanan[$bt-1]['bulan'])->month;
            $blnThn = str_replace('-','_',$trendBulanan[$bt-1]['bulan']);
            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0) as ".$blnThn.""));
            $totCluster = $totCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0) as ".$blnThn.""));
        }

        $totBranchCluster = $totBranchCluster->get();
        $totCluster = $totCluster->get();


        for($db=0; $db < $totBranchCluster->count(); $db++){
            $totBranchBln[$db]['nmTbranch'] = $totBranchCluster[$db]->nama_branch;

            for($tbln=0; $tbln < count($trendBulanan); $tbln++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tbln]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tbln]['bulan']);

                $totBranchBln[$db]['totbulanan'][$tbln] = $totBranchCluster[$db]->$blnThn; 
            }
        }

        for($db=0; $db < $totCluster->count(); $db++){
            $detCluster[$db]['nama_branch'] = $totCluster[$db]->nama_branch;
            $detCluster[$db]['cluster'] = $totCluster[$db]->cluster;

            for($tbln=0; $tbln < count($trendBulanan); $tbln++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tbln]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tbln]['bulan']);

                $detCluster[$db]['bulanan'][$tbln] = $totCluster[$db]->$blnThn; 
            }
        }


        // $branch = DB::table('data_ftth_ib_sortirs as d')
        //         ->leftJoin('branches as b','d.branch','=','b.nama_branch')
        //         ->select('b.id','d.branch as nama_branch');
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

        // $branchCluster = DB::table('data_ftth_ib_sortirs as d')
        //         ->leftJoin('branches as b','d.branch','=','b.nama_branch')
        //         ->select('b.id','d.branch as nama_branch','d.cluster');
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

                
        // if ($request->filterSite != "All") {
        //     $branchCluster = $branchCluster->where('d.site_penagihan', '=', $request->filterSite);
        //     $branch = $branch->where('d.site_penagihan', '=', $request->filterSite);
        // }
        // if ($request->filterBranch != "All") {
        //     $branchCluster = $branchCluster->where('d.branch', '=', $request->filterBranch);
        //     $branch = $branch->where('d.branch', '=', $request->filterBranch);
        // }

        // $branchCluster = $branchCluster->groupBy('d.branch', 'b.id','d.cluster')->orderBy('b.id')->orderBy('d.cluster' )->get();
        // $branch = $branch->groupBy('d.branch', 'b.id')->orderBy('b.id')->get();


        // for ($bc = 0; $bc < count($branchCluster); $bc++) {

        //     $detCluster[$bc]['nama_branch'] = $branchCluster[$bc]->nama_branch;
        //     $detCluster[$bc]['cluster'] = $branchCluster[$bc]->cluster;


        //     for ($tm = 0; $tm < count($trendBulanan); $tm++) {

        //         $jml = DB::table('data_ftth_ib_sortirs as d')
        //         ->leftJoin('branches as b','d.branch','=','b.nama_branch')
        //         ->select('b.id','d.branch as nama_branch','d.cluster')
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
        //         ->whereMonth('d.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month) // $bulan)
        //         ->whereYear('d.tgl_ikr', '=', $tahun)
        //         ->where('d.branch','=', $branchCluster[$bc]->nama_branch)
        //         ->where('d.cluster','=', $branchCluster[$bc]->cluster);


        //         $jml = $jml->groupBy('d.branch','d.cluster', 'b.id')->orderBy('b.id')->count();

        //         $detCluster[$bc]['bulanan'][$tm] = [$jml];

        //     }

        // }

        // for ($db = 0; $db < count($branch); $db++) {

        //     $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;
        //     for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {

        //         $jmldbm = DB::table('data_ftth_ib_sortirs as d')
        //         ->leftJoin('branches as b','d.branch','=','b.nama_branch')
        //         ->select('b.id','d.branch as nama_branch')
        //         // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
        //         ->whereMonth('d.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month) // $bulan)
        //         ->whereYear('d.tgl_ikr', '=', $tahun)
        //         ->where('d.branch','=', $branch[$db]->nama_branch)
        //         ->groupBy('d.branch','b.id')->orderBy('b.id')->count();

        //         // $varjml = $varjml + $jmldbm;
        //         $totBranchBln[$db]['totbulanan'][$dbm] = [$jmldbm];

        //     }

        // }

        return response()->json([
            'branchCluster' => $totBranchBln, 'detCluster' => $detCluster
        ]);
    } 

    public function getClusterBranchIBFtthOld(Request $request)
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

        $branch = DB::table('data_ftth_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch');
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional']);

        $branchCluster = DB::table('data_ftth_ib_sortirs as d')
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

                $jml = DB::table('data_ftth_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch','d.cluster')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month) // $bulan)
                ->whereYear('d.tgl_ikr', '=', $tahun)
                ->where('d.branch','=', $branchCluster[$bc]->nama_branch)
                ->where('d.cluster','=', $branchCluster[$bc]->cluster);


                $jml = $jml->groupBy('d.branch','d.cluster', 'b.id')->orderBy('b.id')->count();

                $detCluster[$bc]['bulanan'][$tm] = [$jml];

            }

        }

        for ($db = 0; $db < count($branch); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $branch[$db]->nama_branch;
            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {

                $jmldbm = DB::table('data_ftth_ib_sortirs as d')
                ->leftJoin('branches as b','d.branch','=','b.nama_branch')
                ->select('b.id','d.branch as nama_branch')
                // ->whereNotIn('d.type_wo', ['Dismantle', 'Additional'])
                ->whereMonth('d.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month) // $bulan)
                ->whereYear('d.tgl_ikr', '=', $tahun)
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


    public function getTrendMonthlyIBFtth(Request $request)
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
            $totIBFtthMontly = DB::table('data_ftth_ib_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }

            $totIBFtthMontly = $totIBFtthMontly->count();

            $totIBFtthMontlyDone = DB::table('data_ftth_ib_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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

    public function getTabelStatusIBFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $tgl = [];
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $dayMonth = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($dayMonth as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }
        // dd($tgl);

        for ($d = 0; $d < count($tgl); $d++) {
            $tblStatus = DataFtthIbSortir::where('tgl_ikr', '=', $tgl[$d]) //->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                ->select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
            count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'));
            // ->whereDay('tgl_ikr', $dayMonth);

            // dd($tblStatus);
            if ($request->filterSite != "All") {
                $tblStatus = $tblStatus->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tblStatus = $tblStatus->where('branch', '=', $request->filterBranch);
            }

            $tblStatus = $tblStatus->orderBy('tgl_ikr')
                ->groupBy('tgl_ikr')->first();

            // dd($tblStatus->Done);
            $tgl[$d]['Done'] = $tblStatus->Done ?? 0;
            $tgl[$d]['Pending'] = $tblStatus->Pending ?? 0;
            $tgl[$d]['Cancel'] = $tblStatus->Cancel ?? 0;
        }

        return response()->json($tgl);
    }

    public function getReasonStatusIBFtthGraph(Request $request)
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

        $PenagihanSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','IB FTTH')
            // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','IB FTTH')
                    // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('tgl_ikr', '=', $tglGraph[$t])
                    // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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

    public function getRootCouseAPKIBFtth(Request $request)
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

        $PenagihanSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','IB FTTH');
            // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

            $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->penagihan;

            for ($m = 0; $m < count($trendBulanan); $m++) {

                $jml = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','IB FTTH')
                    // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $PenagihanSortir[$ps]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }

        $CouseCodeSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan,reason_status'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','IB FTTH');
            // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $CouseCodeSortir = $CouseCodeSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $CouseCodeSortir = $CouseCodeSortir->where('branch', '=', $request->filterBranch);
        }

        $CouseCodeSortir = $CouseCodeSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($cs = 0; $cs < count($CouseCodeSortir); $cs++) {

            $detCouseCodeSortir[$cs]['penagihan'] = $CouseCodeSortir[$cs]->penagihan;
            $detCouseCodeSortir[$cs]['reason_status'] = $CouseCodeSortir[$cs]->reason_status;

            for ($mc = 0; $mc < count($trendBulanan); $mc++) {

                $jmlCouseCode = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan,reason_status'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','IB FTTH')
                    // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mc]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $CouseCodeSortir[$cs]->penagihan)
                    ->where('data_ftth_ib_sortirs.reason_status', '=', $CouseCodeSortir[$cs]->reason_status);

                if ($request->filterSite != "All") {
                    $jmlCouseCode = $jmlCouseCode->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jmlCouseCode = $jmlCouseCode->where('branch', '=', $request->filterBranch);
                }

                $jmlCouseCode = $jmlCouseCode->groupBy('data_ftth_ib_sortirs.penagihan', 'reason_status', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detCouseCodeSortir[$cs]['bulanan'][$mc] = [$jmlCouseCode];
            }
        }




        // $detRootCouseSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // $RootCouseSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan,couse_code,root_couse'))
            // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            // ->where('root_couse_penagihan.status', '=', 'Done')
            // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // if ($request->filterSite != "All") {
            // $RootCouseSortir = $RootCouseSortir->where('site_penagihan', '=', $request->filterSite);
        // }
        // if ($request->filterBranch != "All") {
            // $RootCouseSortir = $RootCouseSortir->where('branch', '=', $request->filterBranch);
        // }

        // $RootCouseSortir = $RootCouseSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // for ($rc = 0; $rc < count($RootCouseSortir); $rc++) {

            // $detRootCouseSortir[$rc]['penagihan'] = $RootCouseSortir[$rc]->penagihan;
            // $detRootCouseSortir[$rc]['couse_code'] = $RootCouseSortir[$rc]->couse_code;
            // $detRootCouseSortir[$rc]['root_couse'] = $RootCouseSortir[$rc]->root_couse;

            // for ($mr = 0; $mr < count($trendBulanan); $mr++) {

                // $jmlRootCouse = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan,couse_code,root_couse'))
                    // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    // ->where('root_couse_penagihan.status', '=', 'Done')
                    // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mr]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->where('data_ftth_ib_sortirs.penagihan', '=', $RootCouseSortir[$rc]->penagihan)
                    // ->where('data_ftth_ib_sortirs.couse_code', '=', $RootCouseSortir[$rc]->couse_code)
                    // ->where('data_ftth_ib_sortirs.root_couse', '=', $RootCouseSortir[$rc]->root_couse);

                // if ($request->filterSite != "All") {
                    // $jmlRootCouse = $jmlRootCouse->where('site_penagihan', '=', $request->filterSite);
                // }
                // if ($request->filterBranch != "All") {
                    // $jmlRootCouse = $jmlRootCouse->where('branch', '=', $request->filterBranch);
                // }

                // $jmlRootCouse = $jmlRootCouse->groupBy('data_ftth_ib_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                // $detRootCouseSortir[$rc]['bulanan'][$mr] = [$jmlRootCouse];
            // }
        // }

        // dd($PenagihanSortir, $detPenagihanSortir, $detCouseCodeSortir, $detRootCouseSortir);
        // end query data Sortir

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getRootCousePendingGraphIBFtth(Request $request)
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

        $PenagihanSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Pending')
            ->where('root_couse_penagihan.type_wo','=','IB Ftth')
            // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Pending')
                    ->where('root_couse_penagihan.type_wo','=','IB Ftth')
                    // ->whereNotIn('data_ftth_ib_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('tgl_ikr', '=', $tglGraphPending[$t])
                    // ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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

    public function getRootCousePendingIBFtth(Request $request)
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

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->where('type_wo','=','IB Ftth')->get();

        
        $RootPendingMonthly = DataFtthIbSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthIbSortir::where('penagihan', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCousePending[$x]->bulan[$jmlBln] = $jml;
            }
        }
            

        for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

            $tot = DataFtthIbSortir::where('status_wo', '=', 'Pending')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                // ->whereBetween('tgl_ikr', [$startDate, $endDate]); //->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn); //->count();
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

            if ($request->filterSite != "All") {
                $tot = $tot->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tot = $tot->where('branch', '=', $request->filterBranch);
            }

            $tot = $tot->count();

            $rootCousePending[$rootCousePending->count() - 1]->bulan[$RootPendingMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCousePending);
    }

    public function getRootCouseCancelGraphIBFtth(Request $request)
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

        $PenagihanSortir = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Cancel')
            ->where('root_couse_penagihan.type_wo','=','IB Ftth')
            ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphCancel[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }
        
        for ($t = 0; $t < count($tglGraphCancel); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {

                $jml = DataFtthIbSortir::select(DB::raw('data_ftth_ib_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_ib_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Cancel')
                    ->where('root_couse_penagihan.type_wo','=','IB Ftth')
                    ->where('tgl_ikr', '=', $tglGraphCancel[$t])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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

    public function getRootCouseCancelIBFtth(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')
                ->where('status', '=', 'Cancel')
                ->where('type_wo','=','IB Ftth')->get();

        $RootCancelMonthly = DataFtthIbSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->distinct()->get();

        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthIbSortir::where('penagihan', '=', $rootCouseCancel[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCouseCancel[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

            $tot = DataFtthIbSortir::where('status_wo', '=', 'Cancel')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]); //->count();

            if ($request->filterSite != "All") {
                $tot = $tot->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tot = $tot->where('branch', '=', $request->filterBranch);
            }

            $tot = $tot->count();

            $rootCouseCancel[$rootCouseCancel->count() - 1]->bulan[$RootCancelMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseCancel);
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
