<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Charts\MonthlyWoChart;
use App\Models\Branch;
use App\Models\DataFtthMtSortir;
use App\Models\ImportFtthMtSortirTemp;

class report_DashTrendWOController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
            'report.reportingDashTrendIkr',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan,
                'kota_penagihan' => $kotamadyaPenagihan,
                'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                'detRootCouseSortir' => $detRootCouseSortir
            ]
        );

    }

    public function getTrendMonthlyMT(Request $request)
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

            //**Get data total trend wo MT**//
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

            //**Get data total trend wo MT  Done**//
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

            //**Get data total trend wo MT Pending**//
            $totMtMontlyPending = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Pending');
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyPending = $totMtMontlyPending->count();

            //**Get data total trend wo MT Cancel**//
            $totMtMontlyCancel = DB::table('data_ftth_mt_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyCancel = $totMtMontlyCancel->count();

            $trendBulanan[$m]['trendMtTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendMtDone'] = $totMtMontlyDone;
            $trendBulanan[$m]['trendMtPending'] = $totMtMontlyPending;
            $trendBulanan[$m]['trendMtCancel'] = $totMtMontlyCancel;
        }

        return response()->json($trendBulanan);
    }

    public function getTrendMonthlyIB(Request $request)
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

            //**Get data total trend wo MT**//
            $totMtMontly = DB::table('data_ftth_ib_sortirs')
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

            //**Get data total trend wo MT  Done**//
            $totMtMontlyDone = DB::table('data_ftth_ib_sortirs')
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

            //**Get data total trend wo MT Pending**//
            $totMtMontlyPending = DB::table('data_ftth_ib_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Pending');
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyPending = $totMtMontlyPending->count();

            //**Get data total trend wo MT Cancel**//
            $totMtMontlyCancel = DB::table('data_ftth_ib_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            if ($request->filterSite != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyCancel = $totMtMontlyCancel->count();

            $trendBulanan[$m]['trendIbTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendIbDone'] = $totMtMontlyDone;
            $trendBulanan[$m]['trendIbPending'] = $totMtMontlyPending;
            $trendBulanan[$m]['trendIbCancel'] = $totMtMontlyCancel;
        }

        return response()->json($trendBulanan);
    }

    public function getTrendMonthlyDismantle(Request $request)
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

            //**Get data total trend wo MT**//
            $totMtMontly = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontly = $totMtMontly->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontly = $totMtMontly->where('main_branch', '=', $request->filterBranch);
            }

            $totMtMontly = $totMtMontly->count();

            //**Get data total trend wo MT  Done**//
            $totMtMontlyDone = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyDone = $totMtMontlyDone->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyDone = $totMtMontlyDone->where('main_branch', '=', $request->filterBranch);
            }

            $totMtMontlyDone = $totMtMontlyDone->count();

            //**Get data total trend wo MT Pending**//
            $totMtMontlyPending = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Pending');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyPending = $totMtMontlyPending->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('main_branch', '=', $request->filterBranch);
            }

            $totMtMontlyPending = $totMtMontlyPending->count();

            //**Get data total trend wo MT Cancel**//
            $totMtMontlyCancel = DB::table('data_ftth_dismantle_sortirs')
                ->whereMonth('visit_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('visit_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyCancel = $totMtMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('main_branch', '=', $request->filterBranch);
            }

            $totMtMontlyCancel = $totMtMontlyCancel->count();

            $trendBulanan[$m]['trendDisTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendDisDone'] = $totMtMontlyDone;
            $trendBulanan[$m]['trendDisPending'] = $totMtMontlyPending;
            $trendBulanan[$m]['trendDisCancel'] = $totMtMontlyCancel;
        }

        return response()->json($trendBulanan);
    }

    public function getTrendMonthlyFttxIB(Request $request)
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

            //**Get data total trend wo MT**//
            $totMtMontly = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontly = $totMtMontly->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontly = $totMtMontly->where('branch', '=', $request->filterBranch);
            }

            $totMtMontly = $totMtMontly->count();

            //**Get data total trend wo MT  Done**//
            $totMtMontlyDone = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyDone = $totMtMontlyDone->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyDone = $totMtMontlyDone->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyDone = $totMtMontlyDone->count();

            //**Get data total trend wo MT Pending**//
            $totMtMontlyPending = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Pending');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyPending = $totMtMontlyPending->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyPending = $totMtMontlyPending->count();

            //**Get data total trend wo MT Cancel**//
            $totMtMontlyCancel = DB::table('data_fttx_ib_sortirs')
                ->whereMonth('ib_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('ib_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyCancel = $totMtMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyCancel = $totMtMontlyCancel->count();

            $trendBulanan[$m]['trendFttxIBTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendFttxIBDone'] = $totMtMontlyDone;
            $trendBulanan[$m]['trendFttxIBPending'] = $totMtMontlyPending;
            $trendBulanan[$m]['trendFttxIBCancel'] = $totMtMontlyCancel;
        }

        return response()->json($trendBulanan);
    }

    public function getTrendMonthlyFttxMT(Request $request)
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

            //**Get data total trend wo MT**//
            $totMtMontly = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontly = $totMtMontly->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontly = $totMtMontly->where('branch', '=', $request->filterBranch);
            }

            $totMtMontly = $totMtMontly->count();

            //**Get data total trend wo MT  Done**//
            $totMtMontlyDone = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyDone = $totMtMontlyDone->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyDone = $totMtMontlyDone->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyDone = $totMtMontlyDone->count();

            //**Get data total trend wo MT Pending**//
            $totMtMontlyPending = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Pending');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyPending = $totMtMontlyPending->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyPending = $totMtMontlyPending->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyPending = $totMtMontlyPending->count();

            //**Get data total trend wo MT Cancel**//
            $totMtMontlyCancel = DB::table('data_fttx_mt_sortirs')
                ->whereMonth('mt_date', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('mt_date', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Cancel');
            // ->count();

            // if ($request->filterSite != "All") {
            //     $totMtMontlyCancel = $totMtMontlyCancel->where('site_penagihan', '=', $request->filterSite);
            // }
            if ($request->filterBranch != "All") {
                $totMtMontlyCancel = $totMtMontlyCancel->where('branch', '=', $request->filterBranch);
            }

            $totMtMontlyCancel = $totMtMontlyCancel->count();

            $trendBulanan[$m]['trendFttxMTTotal'] = $totMtMontly;
            $trendBulanan[$m]['trendFttxMTDone'] = $totMtMontlyDone;
            $trendBulanan[$m]['trendFttxMTPending'] = $totMtMontlyPending;
            $trendBulanan[$m]['trendFttxMTCancel'] = $totMtMontlyCancel;
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
