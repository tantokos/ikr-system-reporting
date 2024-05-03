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

        $trendMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

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
        $site = ['Retail', 'Apartement', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;


        $branchPenagihan = DB::table('data_ftth_mt_sortirs as d')
            ->select('b.id', 'd.branch as nama_branch', 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.branch', '=', 'b.nama_branch')
            ->whereMonth('tgl_ikr', '=', $bulan)->whereYear('tgl_ikr', '=', $tahun)
            ->whereBetween('tgl_ikr', [$startDate, $endDate]);


        if ($request->filterSite != "All") {
            $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();


        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
            if ($branchPenagihan[$br]->site_penagihan == "Apartement") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    $branchPenagihan[$br]->nama_branch = "Apartement";
                }
                // $branchPenagihan[$br]->nama_branch = "Apartement";
                $branchPenagihan[$br]->total = $totWo;
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

        $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartement") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')
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
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')
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
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartement" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
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
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartement" && $branchPenagihan[$b]->nama_branch <> "Underground" && $branchPenagihan[$b]->nama_branch <> "Retail")) {
                $totWo = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('branch', '=', $branchPenagihan[$b]->nama_branch)
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
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
            $tblStatus = DataFtthMtSortir::where('tgl_ikr', '=', $tgl[$d]) //->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)
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

        $rootCouseDone = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        $RootDoneMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->distinct()->get();

        for ($x = 0; $x < $rootCouseDone->count(); $x++) {
            for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

                $jmlBln = $RootDoneMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseDone[$x]->penagihan)
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

                $rootCouseDone[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Done')
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

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->get();

        $RootPendingMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCousePending[$x]->penagihan)
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

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Pending')
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

    public function getRootCouseCancel(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->get();

        $RootCancelMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            ->distinct()->get();

        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseCancel[$x]->penagihan)
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

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Cancel')
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

    public function getRootCousePending1(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $RootPendingMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->get();

        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCousePending[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCousePending[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Pending')->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCousePending[$rootCousePending->count() - 1]->bulan[$RootPendingMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCousePending);
    }

    public function getRootCouseCancel11(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootCancelMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseCancel = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Cancel')->get();

        for ($x = 0; $x < $rootCouseCancel->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseCancel[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseCancel[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Cancel')->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn)->count();

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
        $detCouseCodeSortir = [];
        $detRootCouseSortir = [];

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


        $PenagihanSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        //->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month) // $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($ps = 0; $ps < count($PenagihanSortir); $ps++) {

            $detPenagihanSortir[$ps]['penagihan'] = $PenagihanSortir[$ps]->penagihan;

            for ($m = 0; $m < count($trendBulanan); $m++) {

                $jml = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $PenagihanSortir[$ps]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }

                $jml = $jml->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }


        // // dd($detPenagihanSortir);

        // $detCouseCodeSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code, count(*) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $CouseCodeSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $CouseCodeSortir = $CouseCodeSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $CouseCodeSortir = $CouseCodeSortir->where('branch', '=', $request->filterBranch);
        }

        $CouseCodeSortir = $CouseCodeSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($cs = 0; $cs < count($CouseCodeSortir); $cs++) {

            $detCouseCodeSortir[$cs]['penagihan'] = $CouseCodeSortir[$cs]->penagihan;
            $detCouseCodeSortir[$cs]['couse_code'] = $CouseCodeSortir[$cs]->couse_code;

            for ($mc = 0; $mc < count($trendBulanan); $mc++) {

                $jmlCouseCode = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mc]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $CouseCodeSortir[$cs]->penagihan)
                    ->where('data_ftth_mt_sortirs.couse_code', '=', $CouseCodeSortir[$cs]->couse_code);

                if ($request->filterSite != "All") {
                    $jmlCouseCode = $jmlCouseCode->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jmlCouseCode = $jmlCouseCode->where('branch', '=', $request->filterBranch);
                }

                $jmlCouseCode = $jmlCouseCode->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detCouseCodeSortir[$cs]['bulanan'][$mc] = [$jmlCouseCode];
            }
        }




        // $detRootCouseSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
        // ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
        // ->where('root_couse_penagihan.status', '=', 'Done')
        // ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $RootCouseSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional']);
        // ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
        // ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
        // ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $RootCouseSortir = $RootCouseSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $RootCouseSortir = $RootCouseSortir->where('branch', '=', $request->filterBranch);
        }

        $RootCouseSortir = $RootCouseSortir->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($rc = 0; $rc < count($RootCouseSortir); $rc++) {

            $detRootCouseSortir[$rc]['penagihan'] = $RootCouseSortir[$rc]->penagihan;
            $detRootCouseSortir[$rc]['couse_code'] = $RootCouseSortir[$rc]->couse_code;
            $detRootCouseSortir[$rc]['root_couse'] = $RootCouseSortir[$rc]->root_couse;

            for ($mr = 0; $mr < count($trendBulanan); $mr++) {

                $jmlRootCouse = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
                    ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
                    ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', \Carbon\Carbon::parse($trendBulanan[$mr]['bulan'])->month) // $bulan)
                    ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_mt_sortirs.penagihan', '=', $RootCouseSortir[$rc]->penagihan)
                    ->where('data_ftth_mt_sortirs.couse_code', '=', $RootCouseSortir[$rc]->couse_code)
                    ->where('data_ftth_mt_sortirs.root_couse', '=', $RootCouseSortir[$rc]->root_couse);

                if ($request->filterSite != "All") {
                    $jmlRootCouse = $jmlRootCouse->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jmlRootCouse = $jmlRootCouse->where('branch', '=', $request->filterBranch);
                }

                $jmlRootCouse = $jmlRootCouse->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detRootCouseSortir[$rc]['bulanan'][$mr] = [$jmlRootCouse];
            }
        }

        // dd($PenagihanSortir, $detPenagihanSortir, $detCouseCodeSortir, $detRootCouseSortir);
        // end query data Sortir

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
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

        $PenagihanSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
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


                $jml = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Done')
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

        $PenagihanSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Pending')
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


                $jml = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Pending')
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

        $PenagihanSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Cancel')
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


                $jml = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan'))
                    ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
                    ->where('root_couse_penagihan.status', '=', 'Cancel')
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

    public function getRootCouseAPK1(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $trendBulanan = [];

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        dd($trendBulanan);
        // $rootCousePenagihan = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        // query data Sortir

        $detPenagihanSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan, count(data_ftth_mt_sortirs.penagihan) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $detRootCouseSortir = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // end query data Sortir

        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
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

        // dd($trendBulanan);
        $RootCancelMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $statVisit = DB::table('data_ftth_mt_sortirs')->select('visit_novisit')->distinct()->get();

        for ($x = 0; $x < $statVisit->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                    ->where('visit_novisit', '=', $statVisit[$x]->visit_novisit)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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
            ->where('penagihan', '=', 'Cancel System Problem')->distinct()->get();

        for ($x = 0; $x < $visitSysProblem->count(); $x++) {
            for ($b = 0; $b < count($trendBulanan); $b++) {

                $bln = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->month;
                $thn = \Carbon\Carbon::parse($trendBulanan[$b]['bulan'])->year;

                $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                    ->where('visit_novisit', '=', $visitSysProblem[$x]->visit_novisit)
                    ->where('action_taken', '=', $visitSysProblem[$x]->action_taken)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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

            $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                // ->where('visit_novisit','=', $totVisit[$x]->visit_novisit)
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            $jmlMt = DataFtthMtSortir::whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

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

    public function getCancelSystemProblem2222(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootCancelMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $statVisit = DB::table('data_ftth_mt_sortirs')->select('visit_novisit')->distinct()->get();

        for ($x = 0; $x < $statVisit->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                    ->where('visit_novisit', '=', $statVisit[$x]->visit_novisit)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $statVisit[$x]->bulan[$jmlBln] = $jml;
            }
        }

        $visitSysProblem = DB::table('data_ftth_mt_sortirs')->select('visit_novisit', 'action_taken')
            ->where('penagihan', '=', 'Cancel System Problem')->distinct()->get();

        for ($x = 0; $x < $visitSysProblem->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                    ->where('visit_novisit', '=', $visitSysProblem[$x]->visit_novisit)
                    ->where('action_taken', '=', $visitSysProblem[$x]->action_taken)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $visitSysProblem[$x]->bulan[$jmlBln] = $jml;
            }
        }
        // dd($statVisit, $visitSysProblem);

        $totSysProblem = [];
        // for ($x = 0; $x < $totVisit->count(); $x++) {
        for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

            $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

            $jmlBln = $RootCancelMonthly[$b]->bulan;

            $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                // ->where('visit_novisit','=', $totVisit[$x]->visit_novisit)
                ->whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                ->count();

            $jmlMt = DataFtthMtSortir::whereMonth('tgl_ikr', '=', $bln)
                ->whereYear('tgl_ikr', '=', $thn)
                ->count();

            $totSysProblem[$b] = ['bulan' => $jmlBln, 'total' => $jml, 'totalMt' => $jmlMt];
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
                ->where('site_penagihan', '=', 'Apartement')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->year)
                ->count();
            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan', '=', 'Apartement')
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

        $tblStatusApart = DB::table('data_ftth_mt_sortirs')->select(DB::raw('tgl_ikr,count(if(status_wo = "Done" and site_penagihan="Apartement", 1, NULL)) as Done, 
        count(if(status_wo = "Pending" and site_penagihan="Apartement", 1, NULL)) as Pending, count(if(status_wo = "Cancel" and site_penagihan="Apartement", 1, NULL)) as Cancel'))
            // ->where('site_penagihan','=','Apartement')
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
                    ->where('site_penagihan', '=', 'Apartement')
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
                ->where('site_penagihan', '=', 'Apartement')
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
            ->where('site_penagihan', '=', 'Apartement')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        // // dd($detPenagihanSortir);

        $detCouseCodeSortirApart = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Apartement')
            ->whereNotIn('data_ftth_mt_sortirs.type_wo', ['Dismantle', 'Additional'])
            ->whereMonth('data_ftth_mt_sortirs.tgl_ikr', '=', $bulan)
            ->whereYear('data_ftth_mt_sortirs.tgl_ikr', '=', $tahun)
            ->groupBy('data_ftth_mt_sortirs.penagihan', 'couse_code', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        $detRootCouseSortirApart = DataFtthMtSortir::select(DB::raw('data_ftth_mt_sortirs.penagihan,couse_code,root_couse, count(*) as jml'))
            ->join('root_couse_penagihan', 'root_couse_penagihan.penagihan', '=', 'data_ftth_mt_sortirs.penagihan')
            ->where('root_couse_penagihan.status', '=', 'Done')
            ->where('site_penagihan', '=', 'Apartement')
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
                    ->where('site_penagihan', '=', 'Apartement')
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
                ->where('site_penagihan', '=', 'Apartement')
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
                    ->where('site_penagihan', '=', 'Apartement')
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
                ->where('site_penagihan', '=', 'Apartement')
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
            // ->where('site_penagihan','=','Apartement')
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
