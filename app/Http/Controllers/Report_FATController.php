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
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;
use Yajra\DataTables\DataTables;

class Report_FATController extends Controller
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

        $tgl = ImportFtthMtSortirTemp::select('tgl_ikr')->distinct()->get();

        $trendMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan, month(tgl_ikr) as bln, year(tgl_ikr) as thn'))->distinct()->orderBy('bln','ASC')->orderBy('thn','ASC')->get();

        $tblStatus = ImportFtthMtSortirTemp::select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
        count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'))
            ->groupBy('tgl_ikr')->get();


        $detPenagihanSortir = ImportFtthMtSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            ->groupBy('penagihan')->orderBy('penagihan')->get();

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
            'report.reportingFat',
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
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

    public function getBranchFat(Request $request)
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

        $totBranchFat = DB::table('v_activity_fat')
                        ->select('id','branch')
                        ->groupBy('id','branch');

        $detBranchFat = DB::table('v_activity_fat')
                        ->select('id','branch','kode_fat')
                        ->groupBy('id','branch','kode_fat');


        if ($request->filterSite != "All") {
            $totBranchCluster = $totBranchCluster->where('site_penagihan', '=', $request->filterSite);
            $detClusterxx = $detClusterxx->where('site_penagihan', '=', $request->filterSite);
            $totBranchFat = $totBranchFat->where('site_penagihan', '=', $request->filterSite);
            $detBranchFat = $detBranchFat->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $totBranchCluster = $totBranchCluster->where('branch', '=', $request->filterBranch);
            $detClusterxx = $detClusterxx->where('branch', '=', $request->filterBranch);
            $totBranchFat = $totBranchFat->where('branch', '=', $request->filterBranch);
            $detBranchFat = $detBranchFat->where('branch', '=', $request->filterBranch);
        }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$bt-1]['bulan'])->month;
            $blnThn = str_replace('-','_',$trendBulanan[$bt-1]['bulan']);

            

            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0) as ".$blnThn.""));
            // $totBranchCluster = $totBranchCluster->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0)/(select sum(total_ftth_mt) from v_ftth_mt_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $detClusterxx = $detClusterxx->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0) as ".$blnThn.""));
            // $detClusterxx = $detClusterxx->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_mt end),0)/(select sum(total_ftth_mt) from v_ftth_mt_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $totBranchFat = $totBranchFat->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$Qbln." and year(tgl_ikr)=".$tahun." then branch end),0) as ".$blnThn.""));
            $detBranchFat = $detBranchFat->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$Qbln." and year(tgl_ikr)=".$tahun." then branch end),0) as ".$blnThn.""));

        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $totBranchCluster=$totBranchCluster->orderBy($blnThnFilter, 'DESC')->get(); //orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $detClusterxx = $detClusterxx->orderBy($blnThnFilter, 'DESC')->get();

        $totBranchFat = $totBranchFat->orderBy($blnThnFilter, 'DESC')->get();
        $detBranchFat = $detBranchFat->orderBy($blnThnFilter, 'DESC')->get();


        for ($db = 0; $db < count($totBranchFat); $db++) {

            $totBranchBln[$db]['nmTbranch'] = $totBranchFat[$db]->branch;
            for ($dbm = 0; $dbm < count($trendBulanan); $dbm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$dbm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$dbm]['bulan']);

                $persenBln = "persen_".$blnThn;

                $totBranchBln[$db]['totbulanan'][$dbm] = (int)$totBranchFat[$db]->$blnThn;
                // $totBranchBln[$db]['persen'][$dbm] = round($totBranchCluster[$db]->$persenBln,1);

            }

        }

        for ($bc = 0; $bc < count($detBranchFat); $bc++) {

            $detCluster[$bc]['nama_branch'] = $detBranchFat[$bc]->branch;
            $detCluster[$bc]['kode_fat'] = $detBranchFat[$bc]->kode_fat;


            for ($tm = 0; $tm < count($trendBulanan); $tm++) {
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tm]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tm]['bulan']);

                $persenBln = "persen_".$blnThn;

                $detCluster[$bc]['bulanan'][$tm] = $detBranchFat[$bc]->$blnThn;
                // $detCluster[$bc]['persen'][$tm] = round($detClusterxx[$bc]->$persenBln,1);

            }

        }

        return response()->json([
            'branchFat' => $totBranchBln, 'detCluster' => $detCluster
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
    

    public function getDetailFAT(Request $request)
    {
        if($request->detSlide=="tblFat"){

            $detAPKBranch = DB::table('v_activity_fat')
                        ->select('type_wo', DB::raw('count(type_wo) as total'));
                        // ->where('bulan','=', $request->detBulan)
                        // ->where('tahun','=', $request->detThn);

            if($request->detSite != "All") {
                $detAPKBranch=$detAPKBranch->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranch);
            }

            if($request->detBulan != "All") {
                $detAPKBranch=$detAPKBranch->whereMonth('tgl_ikr', $request->detBulan);
            }

            if($request->detThn != "All") {
                $detAPKBranch=$detAPKBranch->whereYear('tgl_ikr', $request->detThn);
            }

            if($request->detKategori == "branchFat"){
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranchFat);
            }
            if($request->detKategori == "kodeFat"){
                $detAPKBranch=$detAPKBranch->where('branch','=',$request->detBranchFat)
                                            ->where('kode_fat','=', $request->detKodeFat);
            }
            
            $detAPKBranch=$detAPKBranch->groupBy('type_wo')->orderBy('total', 'DESC')->get();

        }

        return response()->json(['detailBranchFAT' => $detAPKBranch]);

    }

    public function dataDetailFAT(Request $request)
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '2048M');

        $akses = Auth::user()->name;


        if($request->detSlide=="tblFat"){

            $detAPK = DB::table('v_activity_fat');
                        // ->select('type_wo', DB::raw('count(type_wo) as total'));
                        // ->where('bulan','=', $request->detBulan)
                        // ->where('tahun','=', $request->detThn);

            if($request->detSite != "All") {
                $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }

            if($request->detBulan != "All") {
                $detAPK=$detAPK->whereMonth('tgl_ikr', $request->detBulan);
            }

            if($request->detThn != "All") {
                $detAPK=$detAPK->whereYear('tgl_ikr', $request->detThn);
            }

            if($request->detKategori == "branchFat"){
                $detAPK=$detAPK->where('branch','=',$request->detBranchFat);
            }
            if($request->detKategori == "kodeFat"){
                $detAPK=$detAPK->where('branch','=',$request->detBranchFat)
                                            ->where('kode_fat','=', $request->detKodeFat);
            }
            
            $detAPK=$detAPK->orderBy('tgl_ikr')->get();

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
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        foreach ($tglBulan as $date) {
            $tglGraph[] = ['tgl_ikr' => $date->format('Y-m-d')];

            $PenagihanSortir = $PenagihanSortir->addSelect(DB::raw('sum(if(data_ftth_mt_sortirs.tgl_ikr="'.$date.'",1,0)) as "'.$date->format('Y_m_d').'"'));
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        // dd($PenagihanSortir);
        // for($t=0; $t < count($tglGraph); $t++ ){

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];

            for ($t=0; $t < count($tglGraph); $t++) {
                $tgl=str_replace('-','_',$tglGraph[$t]['tgl_ikr']);
                // dd($PenagihanSortir[$p]->$tgl);
                $dataGraph[$p]['data'][] = (int)$PenagihanSortir[$p]->$tgl;
            }
        }

        return response()->json([
            'tglGraphAPK' => $tglGraph, 'dataGraphAPK' => $dataGraph,
            'nameGraphAPK' => $nameGraph
        ]);
    }

    public function getRootCouseAPKGraphOld(Request $request)
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
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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

        if ($request->filterSite != "All") {
            $statVisit = $statVisit->where('site_penagihan', '=', $request->filterSite);
            $visitSysProblem = $visitSysProblem->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $statVisit = $statVisit->where('branch', '=', $request->filterBranch);
            $visitSysProblem = $visitSysProblem->where('branch', '=', $request->filterBranch);
        } 


        // for ($x = 0; $x < $statVisit->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$b]['bulan']);

                $statVisit = $statVisit->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0) as ".$blnThn.""));
                $visitSysProblem = $visitSysProblem->addSelect(DB::raw("ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0) as ".$blnThn.""));

                if ($request->filterSite != "All") {
                    $statVisit = $statVisit->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where site_penagihan='".$request->filterSite."' and month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
                    $visitSysProblem = $visitSysProblem->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where site_penagihan='".$request->filterSite."' and month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
                }
                if ($request->filterBranch != "All") {
                    $statVisit = $statVisit->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where branch='".$request->filterBranch."' and month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
                    $visitSysProblem = $visitSysProblem->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where branch='".$request->filterBranch."' and month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
                } else {
                    $statVisit = $statVisit->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
                    $visitSysProblem = $visitSysProblem->addSelect(DB::raw("(ifnull(count(case when month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." then visit_novisit end),0)/(select count(visit_novisit) from data_ftth_mt_sortirs where month(tgl_ikr)=".$bln." and year(tgl_ikr)=".$tahun." and visit_novisit is not null and penagihan='Cancel System Problem/Back To Normal'))*100 as persen_".$blnThn.""));
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
