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

        $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();

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
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan, 'det',
                'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

        // 'totWoMtBranch' => $branchPenagihan, 
    }

    public function getTotalWoBranch(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $branchPenagihan = Branch::select('id', 'nama_branch')->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if ($branchPenagihan[$b]->nama_branch == "Apartement") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Apartement')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif ($branchPenagihan[$b]->nama_branch == "Underground") {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Underground')->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone * 100) / $totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending * 100) / $totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel * 100) / $totWo;
            } elseif (($branchPenagihan[$b]->nama_branch <> "Apartement" && $branchPenagihan[$b]->nama_branch <> "Underground")) {
                $totWo = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->count();
                $totWoDone = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Done')->count();
                $totWoPending = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Pending')->count();
                $totWoCancel = DataFtthMtSortir::where('site_penagihan', '=', 'Retail')->where('branch', '=', $branchPenagihan[$b]->nama_branch)
                    ->whereMonth('tgl_ikr', $bulan)->whereYear('tgl_ikr', $tahun)->select('status_wo')->where('status_wo', '=', 'Cancel')->count();

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
        $trendMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->year);

        for ($m = 0; $m < $trendMonthly->count(); $m++) {
            $totMtMontly = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->year)
                ->count();
            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->year)
                ->where('status_wo', '=', 'Done')
                ->count();

            $trendMonthly[$m]->trendMtTotal = $totMtMontly;
            $trendMonthly[$m]->trendMtDone = $totMtMontlyDone;
        }

        return response()->json($trendMonthly);
    }


    public function getTabelStatus(Request $request)
    {
        // dd($request);
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $tblStatus = DataFtthMtSortir::select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
        count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'))
            ->whereMonth('tgl_ikr', $bulan)
            ->whereYear('tgl_ikr', $tahun)
            ->orderBy('tgl_ikr')
            ->groupBy('tgl_ikr')->get();

        return response()->json($tblStatus);
    }

    public function getRootCouseDone(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $RootDoneMonthly = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->distinct()->get();

        $rootCouseDone = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Done')->get();

        for ($x = 0; $x < $rootCouseDone->count(); $x++) {
            for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

                $jmlBln = $RootDoneMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', $rootCouseDone[$x]->penagihan)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $rootCouseDone[$x]->bulan[$jmlBln] = $jml;
            }
        }

        for ($b = 0; $b < $RootDoneMonthly->count(); $b++) {
            $bln = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->month;
            $thn = \Carbon\Carbon::parse($RootDoneMonthly[$b]->bulan)->year;

            $tot = DataFtthMtSortir::where('status_wo', '=', 'Done')->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn)->count();

            $rootCouseDone[$rootCouseDone->count() - 1]->bulan[$RootDoneMonthly[$b]->bulan] = $tot;
        }

        return response()->json($rootCouseDone);
    }

    public function getRootCousePending(Request $request)
    {

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

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

    public function getRootCouseCancel(Request $request)
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
                    ->where('visit_novisit','=', $statVisit[$x]->visit_novisit)
                    ->whereMonth('tgl_ikr', '=', $bln)
                    ->whereYear('tgl_ikr', '=', $thn)
                    ->count();

                $statVisit[$x]->bulan[$jmlBln] = $jml;
            }
        }

        $visitSysProblem = DB::table('data_ftth_mt_sortirs')->select('visit_novisit','action_taken')
        ->where('penagihan','=','Cancel System Problem')->distinct()->get();

        for ($x = 0; $x < $visitSysProblem->count(); $x++) {
            for ($b = 0; $b < $RootCancelMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootCancelMonthly[$b]->bulan)->year;

                $jmlBln = $RootCancelMonthly[$b]->bulan;

                $jml = DataFtthMtSortir::where('penagihan', '=', 'Cancel System Problem')
                    ->where('visit_novisit','=', $visitSysProblem[$x]->visit_novisit)
                    ->where('action_taken','=',$visitSysProblem[$x]->action_taken)
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

        return response()->json(['statVisit' => $statVisit,
        'totSysProblem'=>$totSysProblem, 'visitSysProblem' => $visitSysProblem]);
    }

    public function getTrendMonthlyApart(Request $request)
    {
        $trendMonthlyApart = DataFtthMtSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->year);

        for ($m = 0; $m < $trendMonthlyApart->count(); $m++) {
            $totMtMontly = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan','=','Apartement')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->year)
                ->count();
            $totMtMontlyDone = DB::table('data_ftth_mt_sortirs')
                ->where('site_penagihan','=','Apartement')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendMonthlyApart[$m]->bulan)->year)
                ->where('status_wo', '=', 'Done')
                ->count();

            $trendMonthlyApart[$m]->trendMtTotal = $totMtMontly;
            $trendMonthlyApart[$m]->trendMtDone = $totMtMontlyDone;
        }

        return response()->json($trendMonthlyApart);
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
