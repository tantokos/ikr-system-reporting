<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Charts\MonthlyWoChart;
use App\Models\Branch;
use App\Models\DataFtthMtSortir;
use App\Models\ImportFtthMtSortirTemp;
use App\Models\RootCouse;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MonthlyWoChart $chart)
    {
        $akses = Auth::user()->name;

        // $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();
        $branchPenagihan = DB::table('branches as b')->Join('data_ftth_mt_sortirs as d', 'b.nama_branch', '=', 'd.branch')
            ->select('b.id', 'd.branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_ftth_mt_sortirs')
            ->select('kotamadya_penagihan')
            // ->where('branch','=','Jakarta Timur')
            ->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        // dd($kotamadyaPenagihan);

        $tgl = ImportFtthMtSortirTemp::select('tgl_ikr')->distinct()->get();

        $trendMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan, month(tgl_ikr) as bln, year(tgl_ikr) as thn'))->distinct()->orderBy('bln','ASC')->orderBy('thn','ASC')->get();

        $tblStatus = ImportFtthMtSortirTemp::select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
        count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'))
            ->groupBy('tgl_ikr')->get();

        // $site = DataFtthMtSortir::select('site_penagihan')->distinct()->get();

        // dd($tblStatus);

        // dd($trendMonthly[0]->bulan);
        // dd(\Carbon\Carbon::parse($tgl[0]->tgl_ikr)->format('F'));

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->daysInMonth);

        // query data Sortir

        $detPenagihanSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            ->groupBy('penagihan', 'couse_code')->orderBy('penagihan')->get();

        $detRootCouseSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            ->groupBy('penagihan', 'couse_code', 'root_couse')->orderBy('penagihan')->get();

        // end query data Sortir

        return view(
            'report.reporting',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

        // 'totWoMtBranch' => $branchPenagihan, 
    }

    public function getFilterBranch(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_ftth_mt_sortirs')
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

    public function getFilterDashboard(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totAllBranch = DataFtthMtSortir::whereMonth('tgl_ikr', $bulan)
                        ->whereYear('tgl_ikr', $tahun)
                        ->select('status_wo')->count();

        $branchPenagihan = DB::table('data_ftth_mt_sortirs as d')
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

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();


        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
            if ($branchPenagihan[$br]->site_penagihan == "Apartemen") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    $branchPenagihan[$br]->nama_branch = "Apartemen";
                }
                // $branchPenagihan[$br]->nama_branch = "Apartemen";
                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$br]->site_penagihan == "Underground") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
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
                $branchPenagihan[$br]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$br]->site_penagihan == "Retail") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
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
        }

        return response()->json($branchPenagihan);
    }

    public function getTotalWoBranch(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totAllBranch = DataFtthMtSortir::whereMonth('tgl_ikr', $bulan)
                        ->whereYear('tgl_ikr', $tahun)
                        ->select('status_wo')->count();

        $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartemen") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartemen" && $branchPenagihan[$b]->nama_branch <> "Underground" && $branchPenagihan[$b]->nama_branch <> "Retail")) {
                $totWo = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
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

    

    public function getClusterBranch(Request $request)
    {
        
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totBranchBln = [];
        $totBranchBln2 = [];
        $trendBulanan = [];
        $branchSortir = [];
        $detCluster = [];
        $detCluster2 = [];
        $detRootCouseSortir = [];

        $newBranchCluster = [];
        $kolomBln='';

        $totBranchCluster = DB::table("v_ftth_mt_cluster")
                            ->select('id','nama_branch as nmTBranch','site_penagihan') //, DB::raw('sum(Jan_2024) as "jan_2024"'))
                            ->groupBy('id','nama_branch','site_penagihan');
                            // ->orderBy('id');

        $detClusterxx = DB::table("v_ftth_mt_cluster")
                        ->select('id','nama_branch', 'cluster','site_penagihan')// ->get();
                        ->groupBy('id','nama_branch','cluster','site_penagihan');
                        // ->orderBy('id');


        if ($request->filterSite != "All") {
            $totBranchCluster = $totBranchCluster->where('site_penagihan', '=', $request->filterSite);
            $detClusterxx = $detClusterxx->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $totBranchCluster = $totBranchCluster->where('branch', '=', $request->filterBranch);
            $detClusterxx = $detClusterxx->where('branch', '=', $request->filterBranch);
        }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$bt-1]['bulan'])->month;
            $blnThn = str_replace('-','_',$trendBulanan[$bt-1]['bulan']);

            

            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0) as ".$blnThn.""));
            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0)/(select sum(total_ftth_mt) from v_ftth_mt_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $detClusterxx = $detClusterxx->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0) as ".$blnThn.""));
            $detClusterxx = $detClusterxx->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0)/(select sum(total_ftth_mt) from v_ftth_mt_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $totBranchCluster=$totBranchCluster->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $detClusterxx = $detClusterxx->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();


        for ($db = 0; $db < count($totBranchCluster); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $totBranchCluster[$db]->nmTBranch;
            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$dbm]['bulan']);

                $persenBln = "persen_".$blnThn;

                $totBranchBln[$db]['totbulanan'][$dbm] = (int)$totBranchCluster[$db]->$blnThn;
                $totBranchBln[$db]['persen'][$dbm] = round($totBranchCluster[$db]->$persenBln,1);

            }

        }

        for ($bc = 0; $bc < count($detClusterxx); $bc++) {

            $detCluster[$bc]['nama_branch'] = $detClusterxx[$bc]->nama_branch;
            $detCluster[$bc]['cluster'] = $detClusterxx[$bc]->cluster;


            for ($tm = 0; $tm < count($trendBulanan); $tm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tm]['bulan']);

                $persenBln = "persen_".$blnThn;

                $detCluster[$bc]['bulanan'][$tm] = $detClusterxx[$bc]->$blnThn;
                $detCluster[$bc]['persen'][$tm] = round($detClusterxx[$bc]->$persenBln,1);

            }

        }



        return response()->json([
            'branchCluster' => $totBranchBln, 'detCluster' => $detCluster
        ]);
    } 

    public function getAnalisPrecon(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detPenagihanSoritrxx = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        $detCouseCodeSortirxx = [];
        $detRootCouseSortirxx = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        // dd($trendBulanan[0]['bulan']);
        // $rootCousePenagihan = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        // query data Sortir

        // $PenagihanSortir1 = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan, count(data_ftth_mt_sortirs.penagihan) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $PenagihanSortirxx = DB::table('v_analis_precon')
                            ->select('result')
                            ->groupBy('result')
                            ->orderBy('result');

        $CouseCodeSortirxx = DB::table('v_analis_precon')
                            ->select('result','penagihan')
                            ->groupBy('result','penagihan')
                            ->orderBy('result');

        $RootCouseSortirxx = DB::table('v_analis_precon')
                            ->select('result','penagihan','root_couse')
                            ->groupBy('result','penagihan','root_couse')
                            ->orderBy('result');
                            


        for ($tb = 0; $tb < count($trendBulanan); $tb++) {
            $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);

            $PenagihanSortirxx = $PenagihanSortirxx->addSelect(DB::raw("ifnull(count(case when month(mt_date)=".$Qbln." and year(mt_date)=".$tahun." then root_couse end),0) as ".$blnThn.""));
            $CouseCodeSortirxx = $CouseCodeSortirxx->addSelect(DB::raw("ifnull(count(case when month(mt_date)=".$Qbln." and year(mt_date)=".$tahun." then root_couse end),0) as ".$blnThn.""));
            $RootCouseSortirxx = $RootCouseSortirxx->addSelect(DB::raw("ifnull(count(case when month(mt_date)=".$Qbln." and year(mt_date)=".$tahun." then root_couse end),0) as ".$blnThn.""));

        }

        if ($request->filterSite != "All") {
            $PenagihanSortirxx = $PenagihanSortirxx->where('site_penagihan', '=', $request->filterSite);
            $CouseCodeSortirxx = $CouseCodeSortirxx->where('site_penagihan', '=', $request->filterSite);
            $RootCouseSortirxx = $RootCouseSortirxx->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortirxx = $PenagihanSortirxx->where('branch', '=', $request->filterBranch);
            $CouseCodeSortirxx = $CouseCodeSortirxx->where('branch', '=', $request->filterBranch);
            $RootCouseSortirxx = $RootCouseSortirxx->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortirxx= $PenagihanSortirxx->get();

        $CouseCodeSortirxx= $CouseCodeSortirxx->get();
        $RootCouseSortirxx= $RootCouseSortirxx->get();

        
        for($psx=0; $psx < $PenagihanSortirxx->count(); $psx++){
            $detPenagihanSoritrxx[$psx] = ['result' => $PenagihanSortirxx[$psx]->result];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);

                $detPenagihanSoritrxx[$psx]['bulanan'][$tb] = [(int)$PenagihanSortirxx[$psx]->$blnThn];
                
            }

        }

        for($psx=0; $psx < $CouseCodeSortirxx->count(); $psx++){
            $detCouseCodeSortirxx[$psx] = ['result' => $CouseCodeSortirxx[$psx]->result, 'penagihan' => $CouseCodeSortirxx[$psx]->penagihan];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);

                $detCouseCodeSortirxx[$psx]['bulanan'][$tb] = [(int)$CouseCodeSortirxx[$psx]->$blnThn];
            }

        }

        for($psx=0; $psx < $RootCouseSortirxx->count(); $psx++){
            $detRootCouseSortirxx[$psx] = ['result' => $RootCouseSortirxx[$psx]->result, 'penagihan' => $RootCouseSortirxx[$psx]->penagihan, 'root_couse' => $RootCouseSortirxx[$psx]->root_couse];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);

                $detRootCouseSortirxx[$psx]['bulanan'][$tb] = [$RootCouseSortirxx[$psx]->$blnThn];
            }

        }
        

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSoritrxx,
            'detCouseCodeSortir' => $detCouseCodeSortirxx, 'detRootCouseSortir' => $detRootCouseSortirxx
        ]);
    }

    public function getMonthly(Request $request)
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
    
    public function getTrendMonthly(Request $request)
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
            $totMtMontly = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontly = $totMtMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontly = $totMtMontly->where('branch', '=', $request->filterBranch);
            }

            $totMtMontly = $totMtMontly->count();

            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontlyDone = $totMtMontlyDone->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontlyDone = $totMtMontlyDone->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyDone = $totMtMontlyDone->count();

            $trendBulanan[$m]['trendMtTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendMtDone'] = $totMtMontlyDone;
        }

        return response()->json($trendBulanan);
    }


    public function getTabelStatus(Request $request)
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
            $tblStatus = DataFtthMtSortir::query()->where('tgl_ikr', '=', $tgl[$d]) //->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
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

    public function getRootCouseDone(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $rootCouseDone = DB::table('root_couse_penagihan')->select('penagihan')
                ->where('status', '=', 'Done')
                ->where('type_wo','=','MT FTTH')->get();

        $RootDoneMonthly = DataFtthMtSortir::query()->select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->distinct()->get();

        for ($x = 0; $x < $rootCouseDone->count(); $x++) {
            for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

                $jmlBln = $RootDoneMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::query()->where('penagihan', '=', $rootCouseDone[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $rootCouseDone[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::query()->where('status_wo', '=', 'Done')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]); //->count();

            if ($request->filterSite != "All") {
                $tot = $tot->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tot = $tot->where('branch', '=', $request->filterBranch);
            }

            $tot = $tot->count();

            $rootCouseDone[$rootCouseDone->count() - 1]->bulan[$RootDoneMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseDone);
    }


    public function getRootCousePending(Request $request)
    {

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

        $rootCousePending = DB::table('v_ftth_mt_pending')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCousePending = $rootCousePending->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $rootCousePending = $rootCousePending->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_mt_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }


        if ($request->filterSite != "All") {
            $rootCousePending = $rootCousePending->where('site_penagihan', '=', $request->filterSite);
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



    public function getRootCousePendingOld(Request $request)
    {

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }
        // dd(\Carbon\Carbon::parse($startDate)->day);

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')
                ->where('status', '=', 'Pending')
                ->where('type_wo','=','MT FTTH')->get();

        $RootPendingMonthly = DataFtthMtSortir::query()->select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::query()->where('penagihan', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween('tgl_ikr', [$startDate, $endDate]);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

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

            $tot = DataFtthMtSortir::query()->where('status_wo', '=', 'Pending')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

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

    public function getRootCouseCancel(Request $request)
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

        $rootCouseCancel = DB::table('v_ftth_mt_cancel')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_mt_cancel where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }


        if ($request->filterSite != "All") {
            $rootCouseCancel = $rootCouseCancel->where('site_penagihan', '=', $request->filterSite);
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

    public function getRootCouseCancelOld(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')
                ->where('status', '=', 'Cancel')
                ->where('type_wo','=','MT FTTH')->get();

        $RootCancelMonthly = DataFtthMtSortir::query()->select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->distinct()->get();

        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                if($rootCouseCancel[$x]->penagihan == 'Cancel System Problem-Back To Normal'){
                    $jml = DataFtthMtSortir::query()->whereIn('penagihan', ['Cancel System Problem', 'Back To Normal'])
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                }else{
                $jml = DataFtthMtSortir::query()->where('penagihan', '=', $rootCouseCancel[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                }
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

            $tot = DataFtthMtSortir::query()->where('status_wo', '=', 'Cancel')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]); //->count();

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

    

    

    public function getRootCouseAPK(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];
        $detPenagihanSortir = [];
        $detPenagihanSoritrxx = [];
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

        $detCouseCodeSortirxx = [];
        $detRootCouseSortirxx = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        // dd($trendBulanan[0]['bulan']);
        // $rootCousePenagihan = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        // query data Sortir

        // $PenagihanSortir1 = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan, count(data_ftth_mt_sortirs.penagihan) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $PenagihanSortirxx = DB::table('v_ftth_mt_rootcouse_done')
                            ->select('id','penagihan')
                            ->groupBy('id','penagihan');

        $CouseCodeSortirxx = DB::table('v_ftth_mt_rootcouse_done')
                            ->select('id','penagihan','couse_code')
                            ->groupBy('id','penagihan','couse_code');

        $RootCouseSortirxx = DB::table('v_ftth_mt_rootcouse_done')
                            ->select('id','penagihan','couse_code','root_couse')
                            ->groupBy('id','penagihan','couse_code','root_couse');


        for ($tb = 0; $tb < count($trendBulanan); $tb++) {
            $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);

            $PenagihanSortirxx = $PenagihanSortirxx->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $PenagihanSortirxx = $PenagihanSortirxx->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_mt_rootcouse_done where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $CouseCodeSortirxx = $CouseCodeSortirxx->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $CouseCodeSortirxx = $CouseCodeSortirxx->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_mt_rootcouse_done where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            
            $RootCouseSortirxx = $RootCouseSortirxx->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            $RootCouseSortirxx = $RootCouseSortirxx->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_mt_rootcouse_done where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }

        if ($request->filterSite != "All") {
            $PenagihanSortirxx = $PenagihanSortirxx->where('site_penagihan', '=', $request->filterSite);
            $CouseCodeSortirxx = $CouseCodeSortirxx->where('site_penagihan', '=', $request->filterSite);
            $RootCouseSortirxx = $RootCouseSortirxx->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortirxx = $PenagihanSortirxx->where('branch', '=', $request->filterBranch);
            $CouseCodeSortirxx = $CouseCodeSortirxx->where('branch', '=', $request->filterBranch);
            $RootCouseSortirxx = $RootCouseSortirxx->where('branch', '=', $request->filterBranch);
        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $PenagihanSortirxx= $PenagihanSortirxx->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $CouseCodeSortirxx= $CouseCodeSortirxx->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $RootCouseSortirxx= $RootCouseSortirxx->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        
        for($psx=0; $psx < $PenagihanSortirxx->count(); $psx++){
            $detPenagihanSoritrxx[$psx] = ['penagihan' => $PenagihanSortirxx[$psx]->penagihan];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $detPenagihanSoritrxx[$psx]['bulanan'][$tb] = [(int)$PenagihanSortirxx[$psx]->$blnThn];
                $detPenagihanSoritrxx[$psx]['persen'][$tb] = [round($PenagihanSortirxx[$psx]->$persenBln, 1)];
                
            }

        }

        for($psx=0; $psx < $CouseCodeSortirxx->count(); $psx++){
            $detCouseCodeSortirxx[$psx] = ['penagihan' => $CouseCodeSortirxx[$psx]->penagihan, 'couse_code' => $CouseCodeSortirxx[$psx]->couse_code];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $detCouseCodeSortirxx[$psx]['bulanan'][$tb] = [(int)$CouseCodeSortirxx[$psx]->$blnThn];
                $detCouseCodeSortirxx[$psx]['persen'][$tb] = [round($CouseCodeSortirxx[$psx]->$persenBln,1)];
            }

        }

        for($psx=0; $psx < $RootCouseSortirxx->count(); $psx++){
            $detRootCouseSortirxx[$psx] = ['penagihan' => $RootCouseSortirxx[$psx]->penagihan, 'couse_code' => $RootCouseSortirxx[$psx]->couse_code, 'root_couse' => $RootCouseSortirxx[$psx]->root_couse];

            for($tb=0; $tb < count($trendBulanan); $tb++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tb]['bulan'])->month;

                $blnThn = str_replace('-','_',$trendBulanan[$tb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $detRootCouseSortirxx[$psx]['bulanan'][$tb] = [(int)$RootCouseSortirxx[$psx]->$blnThn];
                $detRootCouseSortirxx[$psx]['persen'][$tb] = [round($RootCouseSortirxx[$psx]->$persenBln,1)];
            }

        }
        

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSoritrxx,
            'detCouseCodeSortir' => $detCouseCodeSortirxx, 'detRootCouseSortir' => $detRootCouseSortirxx
        ]);
    }

    public function getRootCouseAPKGraph(Request $request)
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

        $PenagihanSortir = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('root_couse_penagihan.type_wo','=','MT FTTH')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTH')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('tgl_ikr', '=', $tglGraph[$t])
                    // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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
    

    public function getRootCousePendingGraph(Request $request)
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

        $PenagihanSortir = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Pending')
            ->where('root_couse_penagihan.type_wo','=','MT FTTH')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Pending')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTH')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('tgl_ikr', '=', $tglGraphPending[$t])
                    // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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

    public function getRootCouseCancelGraph(Request $request)
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

        $PenagihanSortir = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Cancel')
            ->where('root_couse_penagihan.type_wo','=','MT FTTH')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();
        // dd($tglGraph);
        // for($t=0; $t < count($tglGraph); $t++ ){

        

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphCancel[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphCancel); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


                // $tglGraph[$t]['penagihan'][$p] = $PenagihanSortir[$p]->penagihan;


                $jml = DataFtthMtSortir::query()->select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Cancel')
                    ->where('root_couse_penagihan.type_wo','=','MT FTTH')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->where('tgl_ikr', '=', $tglGraphCancel[$t])
                    // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day,\Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $PenagihanSortir[$pn]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

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


    public function getCancelSystemProblem(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $RootCancelMonthly = DataFtthMtSortir::query()->select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        // $statVisit = DB::table('data_ftth_mt_sortirs')->select('visit_novisit')->whereNotNull('visit_novisit')->distinct()->get();

        $statVisit = DB::table('data_ftth_mt_sortirs')
                    ->select('visit_novisit')
                    ->whereNotNull('visit_novisit')
                    ->where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                    ->groupBy('visit_novisit');

        $visitSysProblem = DB::table('data_ftth_mt_sortirs')
                    ->select('visit_novisit','action_taken')
                    ->where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                    ->whereNotNull('visit_novisit')
                    ->groupBy('visit_novisit','action_taken');



        // for ($x = 0; $x < $statVisit->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$b]['bulan']);

                $statVisit = $statVisit->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0) as ".$blnThn.""));
                $statVisit = $statVisit->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));

                $visitSysProblem = $visitSysProblem->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0) as ".$blnThn.""));
                $visitSysProblem = $visitSysProblem->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));

                if ($request->filterSite != "All") {
                    $statVisit = $statVisit->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $statVisit = $statVisit->where('branch', '=', $request->filterBranch);
                }               

                

                
            }

            $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

            $statVisit= $statVisit->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
            $visitSysProblem= $visitSysProblem->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();

        // }


        for ($x = 0; $x < $statVisit->count(); $x++) {

            $visit_noVisit[$x] = ['visit_novisit' => $statVisit[$x]->visit_novisit];

            for ($xb = 0; $xb < count($trendBulanan); $xb++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$xb]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$xb]['bulan'])->year;

                $blnThn = str_replace('-','_',$trendBulanan[$xb]['bulan']);
                $persenBln = "persen_".$blnThn;

                $visit_noVisit[$x]['bulanan'][$xb] = [(int)$statVisit[$x]->$blnThn];
                $visit_noVisit[$x]['persen'][$xb] = [round($statVisit[$x]->$persenBln,1)];

            }
        }

        for ($x = 0; $x < $visitSysProblem->count(); $x++) {

            $SysProblem[$x] = ['visit_novisit' => $visitSysProblem[$x]->visit_novisit, 'action_taken' => $visitSysProblem[$x]->action_taken];

            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                $blnThn = str_replace('-','_',$trendBulanan[$b]['bulan']);
                $persenBln = "persen_".$blnThn;

                $SysProblem[$x]['bulanan'][$b] = [(int)$visitSysProblem[$x]->$blnThn];
                $SysProblem[$x]['persen'][$b] = [round($visitSysProblem[$x]->$persenBln,1)];

            }
        }

        $totSysProblem = [];
        // for ($x = 0; $x < $totVisit->count(); $x++) {
        for ($b = 0; $b < count($trendBulanan); $b++) {

            $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
            $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

            $jmlBln = $RootCancelMonthly[$b]->bulan;

            $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                // ->where('visit_novisit','=', $totVisit[$x]->visit_novisit)
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            $jmlMt = DataFtthMtSortir::whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

            if ($request->filterSite != "All") {
                $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                $jmlMt = $jmlMt->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $jml = $jml->where('branch', '=', $request->filterBranch);
                $jmlMt = $jmlMt->where('branch', '=', $request->filterBranch);
            }

            $jml = $jml->count();
            $jmlMt = $jmlMt->count();

            $totSysProblem[$b] = ['bulan' => $trendBulanan[$b]['bulan'], 'total' => $jml, 'totalMt' => $jmlMt];
        }
        // }


        return response()->json([
            'statVisit' => $visit_noVisit,'visitSysProblem' => $SysProblem, 'totSysProblem' => $totSysProblem
        ]);
    }

    public function getCancelSystemProblemOld(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $trendBulanan = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $RootCancelMonthly = DataFtthMtSortir::query()->select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $statVisit = DB::table('data_ftth_mt_sortirs')->select('visit_novisit')->whereNotNull('visit_novisit')->distinct()->get();

        for ($x = 0; $x < $statVisit->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                $jml = DataFtthMtSortir::query()->where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                    ->where('visit_novisit', '=', $statVisit[$x]->visit_novisit)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                // ->count();

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $statVisit[$x]->bulan[$trendBulanan[$b]['bulan']] = $jml;
            }
        }

        $visitSysProblem = DB::table('data_ftth_mt_sortirs')->select('visit_novisit', 'action_taken')
            ->where('penagihan', '=', 'Cancel System Problem/Back To Normal')->distinct()->get();

        for ($x = 0; $x < $visitSysProblem->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                $jml = DataFtthMtSortir::query()->where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                    ->where('visit_novisit', '=', $visitSysProblem[$x]->visit_novisit)
                    ->where('action_taken', '=', $visitSysProblem[$x]->action_taken)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
                // ->count();

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->count();

                $visitSysProblem[$x]->bulan[$trendBulanan[$b]['bulan']] = $jml;
            }
        }
        // dd($statVisit, $visitSysProblem);

        $totSysProblem = [];
        // for ($x = 0; $x < $totVisit->count(); $x++) {
        for ($b = 0; $b < count($trendBulanan); $b++) {

            $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
            $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

            $jmlBln = $RootCancelMonthly[$b]->bulan;

            $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem/Back To Normal')
                // ->where('visit_novisit','=', $totVisit[$x]->visit_novisit)
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            $jmlMt = DataFtthMtSortir::whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

            if ($request->filterSite != "All") {
                $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                $jmlMt = $jmlMt->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $jml = $jml->where('branch', '=', $request->filterBranch);
                $jmlMt = $jmlMt->where('branch', '=', $request->filterBranch);
            }

            $jml = $jml->count();
            $jmlMt = $jmlMt->count();

            $totSysProblem[$b] = ['bulan' => $trendBulanan[$b]['bulan'], 'total' => $jml, 'totalMt' => $jmlMt];
        }
        // }

        return response()->json([
            'statVisit' => $statVisit,
            'totSysProblem' => $totSysProblem, 'visitSysProblem' => $visitSysProblem
        ]);
    }

    

    public function getTrendMonthlyApart(Request $request)
    {
        $trendMonthlyApart = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->year);

        for ($m = 0; $m < $trendMonthlyApart->count(); $m++) {
            $totMtMontly = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan', '=', 'Apartemen')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->year)
                ->count();
            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan', '=', 'Apartemen')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->year)
                ->where('status_wo', '=', 'Done')
                ->count();

            $trendMonthlyApart[$m]->trendMtTotal = $totMtMontly;
            $trendMonthlyApart[$m]->trendMtDone = $totMtMontlyDone;
        }

        return response()->json($trendMonthlyApart);
    }

    public function getTabelStatusApart(Request $request)
    {
        // dd($request);
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $jmlHari = \Carbon\Carbon::parse($request->bulanTahunReport)->daysInMonth;

        // for ($x=0; $x < $jmlHari; $x++ ){

        $tblStatusApart = DB::table('data_ftth_mt_sortirs')->select(DB::raw('tgl_ikr,count(if(status_wo = "Done" and site_penagihan="Apartemen", 1, NULL)) as Done, 
        count(if(status_wo = "Pending" and site_penagihan="Apartemen", 1, NULL)) as Pending, count(if(status_wo = "Cancel" and site_penagihan="Apartemen", 1, NULL)) as Cancel'))
            // ->where('site_penagihan','=','Apartemen')
            // ->whereDay('tgl_ikr',$x)
            ->whereMonth('tgl_ikr', $bulan)
            ->whereYear('tgl_ikr', $tahun)
            ->orderBy('tgl_ikr')
            ->groupBy('tgl_ikr')->get();

        // }

        // dd($tblStatusApart);
        return response()->json($tblStatusApart);
    }

    public function getRootCouseDoneApart(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootDoneMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseDoneApart = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        for ($x = 0; $x < $rootCouseDoneApart->count(); $x++) {
            for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

                $jmlBln = $RootDoneMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseDoneApart[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseDoneApart[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Done')
                ->where('site_penagihan', '=', 'Apartemen')
                ->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCouseDoneApart[$rootCouseDoneApart->count() - 1]->bulan[$RootDoneMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseDoneApart);
    }


    public function getRootCouseAPKApart(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        // $rootCousePenagihan = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        // query data Sortir

        $detPenagihanSortirApart = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan, count(data_ftth_mt_sortirs.penagihan) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Apartemen')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortirApart = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Apartemen')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $detRootCouseSortirApart = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Apartemen')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // end query data Sortir

        return response()->json([
            'detPenagihanSortirApart' => $detPenagihanSortirApart,
            'detCouseCodeSortirApart' => $detCouseCodeSortirApart, 'detRootCouseSortirApart' => $detRootCouseSortirApart
        ]);
    }

    public function getRootCousePendingApart(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootPendingMonthlyApart = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCousePendingApart = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->get();

        for ($x = 0; $x < $rootCousePendingApart->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthlyApart->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthlyApart[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthlyApart[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthlyApart[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCousePendingApart[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCousePendingApart[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootPendingMonthlyApart->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootPendingMonthlyApart[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootPendingMonthlyApart[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Pending')
                ->where('site_penagihan', '=', 'Apartemen')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCousePendingApart[$rootCousePendingApart->count() - 1]->bulan[$RootPendingMonthlyApart[$b]->bulan] = $tot;
        }

        return response()->json($rootCousePendingApart);
    }

    public function getRootCouseCancelApart(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootCancelMonthlyApart = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseCancelApart = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->get();

        for ($x = 0; $x < $rootCouseCancelApart->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthlyApart->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthlyApart[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthlyApart[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthlyApart[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseCancelApart[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseCancelApart[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootCancelMonthlyApart->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootCancelMonthlyApart[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootCancelMonthlyApart[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Cancel')
                ->where('site_penagihan', '=', 'Apartemen')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCouseCancelApart[$rootCouseCancelApart->count() - 1]->bulan[$RootCancelMonthlyApart[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseCancelApart);
    }

    public function getTrendMonthlyUG(Request $request)
    {
        $trendMonthlyUG = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->year);

        for ($m = 0; $m < $trendMonthlyUG->count(); $m++) {
            $totMtMontly = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan', '=', 'Underground')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyUG[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyUG[$m]->bulan)->year)
                ->count();
            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan', '=', 'Underground')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyUG[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyUG[$m]->bulan)->year)
                ->where('status_wo', '=', 'Done')
                ->count();

            $trendMonthlyUG[$m]->trendMtTotal = $totMtMontly;
            $trendMonthlyUG[$m]->trendMtDone = $totMtMontlyDone;
        }

        return response()->json($trendMonthlyUG);
    }

    public function getTabelStatusUG(Request $request)
    {
        // dd($request);
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $jmlHari = \Carbon\Carbon::parse($request->bulanTahunReport)->daysInMonth;

        // for ($x=0; $x < $jmlHari; $x++ ){

        $tblStatusUG = DB::table('data_ftth_mt_sortirs')->select(DB::raw('tgl_ikr,count(if(status_wo = "Done" and site_penagihan="Underground", 1, NULL)) as Done, 
        count(if(status_wo = "Pending" and site_penagihan="Underground", 1, NULL)) as Pending, count(if(status_wo = "Cancel" and site_penagihan="Underground", 1, NULL)) as Cancel'))
            // ->where('site_penagihan','=','Apartemen')
            // ->whereDay('tgl_ikr',$x)
            ->whereMonth('tgl_ikr', $bulan)
            ->whereYear('tgl_ikr', $tahun)
            ->orderBy('tgl_ikr')
            ->groupBy('tgl_ikr')->get();

        // }

        // dd($tblStatusApart);
        return response()->json($tblStatusUG);
    }

    public function getRootCouseDoneUG(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootDoneMonthlyUG = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseDoneUG = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        for ($x = 0; $x < $rootCouseDoneUG->count(); $x++) {
            for ($b = 0; $b < $RootDoneMonthlyUG->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootDoneMonthlyUG[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootDoneMonthlyUG[$b]->bulan)->year;

                $jmlBln = $RootDoneMonthlyUG[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseDoneUG[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseDoneUG[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootDoneMonthlyUG->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootDoneMonthlyUG[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootDoneMonthlyUG[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Done')
                ->where('site_penagihan', '=', 'Underground')
                ->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCouseDoneUG[$rootCouseDoneUG->count() - 1]->bulan[$RootDoneMonthlyUG[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseDoneUG);
    }

    public function getRootCouseAPKUG(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        // $rootCousePenagihan = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        // query data Sortir

        $detPenagihanSortirUG = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan, count(data_ftth_mt_sortirs.penagihan) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Underground')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortirUG = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Underground')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $detRootCouseSortirUG = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Underground')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // end query data Sortir

        return response()->json([
            'detPenagihanSortirUG' => $detPenagihanSortirUG,
            'detCouseCodeSortirUG' => $detCouseCodeSortirUG, 'detRootCouseSortirUG' => $detRootCouseSortirUG
        ]);
    }

    public function getRootCousePendingUG(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootPendingMonthlyUG = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCousePendingUG = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->get();

        for ($x = 0; $x < $rootCousePendingUG->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthlyUG->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthlyUG[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthlyUG[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthlyUG[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCousePendingUG[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCousePendingUG[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootPendingMonthlyUG->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootPendingMonthlyUG[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootPendingMonthlyUG[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Pending')
                ->where('site_penagihan', '=', 'Underground')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCousePendingUG[$rootCousePendingUG->count() - 1]->bulan[$RootPendingMonthlyUG[$b]->bulan] = $tot;
        }

        return response()->json($rootCousePendingUG);
    }

    public function getRootCouseCancelUG(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootCancelMonthlyUG = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseCancelUG = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->get();

        for ($x = 0; $x < $rootCouseCancelUG->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthlyUG->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthlyUG[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthlyUG[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthlyUG[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseCancelUG[$x]->penagihan)
                    ->where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseCancelUG[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootCancelMonthlyUG->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootCancelMonthlyUG[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootCancelMonthlyUG[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Cancel')
                ->where('site_penagihan', '=', 'Underground')
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCouseCancelUG[$rootCouseCancelUG->count() - 1]->bulan[$RootCancelMonthlyUG[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseCancelUG);
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
