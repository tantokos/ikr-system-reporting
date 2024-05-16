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

        // $site = DataFtthDismantleSortir::select('site_penagihan')->distinct()->get();

        // dd($tblStatus);

        // dd($trendMonthly[0]->bulan);
        // dd(\Carbon\Carbon::parse($tgl[0]->visit_date)->format('F'));

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->daysInMonth);

        // query data Sortir

        // $detPenagihanSortir =ImportFtthDismantleSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan, count(penagihan) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->groupBy('penagihan')->orderBy('penagihan')->get();

        // // dd($detPenagihanSortir);

        // $detCouseCodeSortir =ImportFtthDismantleSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,reason_status, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status')->orderBy('penagihan')->get();

        // $detRootCouseSortir =ImportFtthDismantleSortirTemp::where('login', '=', $akses)->select(DB::raw('penagihan,couse_code,root_couse, count(*) as jml'))
            // ->whereNotIn('type_wo', ['Dismantle', 'Additional'])
            // ->distinct()
            // ->groupBy('penagihan', 'reason_status', 'root_couse')->orderBy('penagihan')->get();

        // end query data Sortir

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

        $branchPenagihan = Branch::select('id', 'nama_branch')
                    ->whereNotIn('nama_branch',['Apartemen', 'underground'])->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartemen") {
                $totWo = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();
                    
                $branchPenagihan[$b]->total = $totWo;
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
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
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
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir::where('main_branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('visit_date', $bulan)->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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

    public function getFilterDashboardDismantleFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $branchPenagihan = DB::table('data_ftth_dismantle_sortirs as d')
            ->select('b.id', 'd.main_branch as nama_branch') //, 'd.site_penagihan')
            ->leftJoin('branches as b', 'd.main_branch', '=', 'b.nama_branch')
            ->whereMonth('visit_date', '=', $bulan)->whereYear('visit_date', '=', $tahun)
            ->whereNotIn('b.nama_branch',['Apartemen','Underground'])
            ->whereBetween('visit_date', [$startDate, $endDate]);

        // if ($request->filterSite != "All") {
            // $branchPenagihan = $branchPenagihan->where('d.site_penagihan', '=', $request->filterSite);
        // }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('d.main_branch', '=', $request->filterBranch);
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('id')->get();

        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
            // if ($branchPenagihan[$br]->site_penagihan == "Apartemen") {
                $totWo = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->select('status_wo')->count();
                $totWoDone = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Apartemen')
                    whereMonth('visit_date', $bulan)
                    ->whereYear('visit_date', $tahun)
                    ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    ->where('status_wo', '=', 'Cancel')->count();

                // if ($request->filterSite == "All") {
                    // $branchPenagihan[$br]->nama_branch = "Apartemen";
                // }
                // $branchPenagihan[$br]->nama_branch = "Apartemen";
                $branchPenagihan[$br]->total = $totWo;
                $branchPenagihan[$br]->done = $totWoDone;
                $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$br]->pending = $totWoPending;
                $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$br]->cancel = $totWoCancel;
                $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            // } elseif ($branchPenagihan[$br]->site_penagihan == "Underground") {
                // $totWo = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Underground')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->select('status_wo')->count();
                // $totWoDone = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Underground')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Done')->count();
                // $totWoPending = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Underground')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Pending')->count();
                // $totWoCancel = DataFtthDismantleSortir:: //where('site_penagihan', '=', 'Underground')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Cancel')->count();

                // if ($request->filterSite == "All") {
                    // $branchPenagihan[$br]->nama_branch = "Underground";
                // }
                // $branchPenagihan[$br]->nama_branch = "Underground";
                // $branchPenagihan[$br]->total = $totWo;
                // $branchPenagihan[$br]->done = $totWoDone;
                // $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                // $branchPenagihan[$br]->pending = $totWoPending;
                // $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                // $branchPenagihan[$br]->cancel = $totWoCancel;
                // $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            // } //elseif ($branchPenagihan[$br]->site_penagihan == "Retail") {
                // $totWo = DataFtthDismantleSortir:://where('site_penagihan', '=', 'Retail')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->select('status_wo')->count();
                // $totWoDone = DataFtthDismantleSortir:://where('site_penagihan', '=', 'Retail')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Done')->count();
                // $totWoPending = DataFtthDismantleSortir:://where('site_penagihan', '=', 'Retail')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Pending')->count();
                // $totWoCancel = DataFtthDismantleSortir:://where('site_penagihan', '=', 'Retail')
                    // whereMonth('visit_date', $bulan)
                    // ->whereYear('visit_date', $tahun)
                    // ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    // ->select('status_wo')
                    // ->where('main_branch', '=', $branchPenagihan[$br]->nama_branch)
                    // ->where('status_wo', '=', 'Cancel')->count();

                // $branchPenagihan[$br]->total = $totWo;
                // $branchPenagihan[$br]->done = $totWoDone;
                // $branchPenagihan[$br]->persenDone = ($totWoDone * 100) / $totWo;
                // $branchPenagihan[$br]->pending = $totWoPending;
                // $branchPenagihan[$br]->persenPending = ($totWoPending * 100) / $totWo;
                // $branchPenagihan[$br]->cancel = $totWoCancel;
                // $branchPenagihan[$br]->persenCancel = ($totWoCancel * 100) / $totWo;
            // }
        }

        return response()->json($branchPenagihan);
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
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
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
                ->whereBetween(DB::raw('day(visit_date)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
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
