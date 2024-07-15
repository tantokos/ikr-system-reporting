<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\DataFtthIbSortir;
use App\Models\ImportFtthIbSortirTemp;
use App\Models\Branch;
use Yajra\DataTables\DataTables;

class Report_IBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->dashBoard);
        $akses = Auth::user()->name;

        $branchPenagihan = DB::table('branches as b')->Join('data_ftth_ib_sortirs as d', 'b.nama_branch', '=', 'd.branch')
            ->select('b.id', 'd.branch as nama_branch')
            ->distinct()
            ->orderBy('b.id')
            ->get();

        $kotamadyaPenagihan = DB::table('data_ftth_ib_sortirs')
            ->select('kotamadya_penagihan')
            ->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        $tgl = ImportFtthIbSortirTemp::select('tgl_ikr')->distinct()->get();

        $trendMonthly = DataFtthIbSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();

        return view(
            'report.reportingFtthIB',
            [
                'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan, 
                'kota_penagihan' => $kotamadyaPenagihan, 'dashBoard' => $request->dashBoard
                // 'detPenagihanSortir' => $detPenagihanSortir, 'detCouseCodeSortir' => $detCouseCodeSortir,
                // 'detRootCouseSortir' => $detRootCouseSortir
            ]
        );
    }

    public function getFilterBranchIBFtth(Request $request)
    {

        $kotamadyaPenagihan = DB::table('data_ftth_ib_sortirs')
            ->select('kotamadya_penagihan');

        if ($request->branchReport != "All") {
            $kotamadyaPenagihan = $kotamadyaPenagihan->where('branch', '=', $request->branchReport);
        }

        $kotamadyaPenagihan = $kotamadyaPenagihan->distinct()
            ->orderBy('kotamadya_penagihan')
            ->get();

        return response()->json($kotamadyaPenagihan);
    }

    public function getMonthlyIBFtth(Request $request)
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

    public function getTotalWoBranchIBFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $totAllBranch = DataFtthIbSortir::whereMonth('tgl_ikr', $bulan)
        ->whereYear('tgl_ikr', $tahun)
        ->select('status_wo')->count();

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
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
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
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
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
                $branchPenagihan[$b]->persenTotal = ($totWo * 100) / $totAllBranch;
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

    

    public function getFilterDashboardIBFtth(Request $request)
    {
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;
        $site = ['Retail', 'Apartemen', 'Underground'];

        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $branchPenagihan = DB::table('v_ftth_ib_cluster')
            ->select('id','nama_branch', 
                    DB::raw('
                        sum(total_ftth_ib) as total,
                        ((sum(total_ftth_ib) * 100) / (select sum(total_ftth_ib) from v_ftth_ib_cluster where bulan='.$bulan.' and tahun='.$tahun.'))  as persenTotal, 
                        sum(ftth_ib_done) as done, 
                        ((sum(ftth_ib_done) * 100) / sum(total_ftth_ib)) as  persenDone,
                        sum(ftth_ib_pending) as pending,
                        ((sum(ftth_ib_pending) * 100) / sum(total_ftth_ib)) as  persenPending, 
                        sum(ftth_ib_cancel) as cancel,
                        ((sum(ftth_ib_cancel) * 100) / sum(total_ftth_ib)) as  persenCancel
                    '))
            ->where('bulan', '=', $bulan)->where('tahun', '=', $tahun);

        
        if ($request->filterSite != "All") {
            $branchPenagihan = $branchPenagihan->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $branchPenagihan = $branchPenagihan->where('penagihan','=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $branchPenagihan = $branchPenagihan->where('penagihan','!=', 'Additional Service STB');
        }

        $branchPenagihan = $branchPenagihan->groupBy('id','nama_branch')->get();
        

        return response()->json($branchPenagihan);
    }

    public function getFilterDashboardIBFtthOld(Request $request)
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
            $branchPenagihan = $branchPenagihan->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $branchPenagihan = $branchPenagihan->where('branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $branchPenagihan = $branchPenagihan->where('penagihan','=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $branchPenagihan = $branchPenagihan->where('penagihan','!=', 'Additional Service STB');
        }

        $branchPenagihan = $branchPenagihan->distinct()->orderBy('b.id')->get();
        dd($branchPenagihan);

        for ($br = 0; $br < $branchPenagihan->count(); $br++) {
            if ($branchPenagihan[$br]->site_penagihan == "Apartemen") {
                $totWo = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWo = $totWo->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWo = $totWo->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWo = $totWo->select('status_wo')->count();

                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoDone = $totWoDone->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoDone = $totWoDone->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoDone = $totWoDone->where('status_wo', '=', 'Done')->count();

                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoPending = $totWoPending->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoPending = $totWoPending->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoPending = $totWoPending->where('status_wo', '=', 'Pending')->count();

                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Apartemen')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoCancel = $totWoCancel->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoCancel = $totWoCancel->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoCancel = $totWoCancel->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    // $branchPenagihan[$br]->id = "11";
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWo = $totWo->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWo = $totWo->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWo = $totWo->select('status_wo')->count();

                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoDone = $totWoDone->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoDone = $totWoDone->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoDone = $totWoDone->where('status_wo', '=', 'Done')->count();

                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoPending = $totWoPending->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoPending = $totWoPending->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoPending = $totWoPending->where('status_wo', '=', 'Pending')->count();

                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Underground')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoCancel = $totWoCancel->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoCancel = $totWoCancel->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoCancel = $totWoCancel->where('status_wo', '=', 'Cancel')->count();

                if ($request->filterSite == "All") {
                    // $branchPenagihan[$br]->id = "12";
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWo = $totWo->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWo = $totWo->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWo = $totWo->select('status_wo')->count();

                $totWoDone = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoDone = $totWoDone->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoDone = $totWoDone->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoDone = $totWoDone->where('status_wo', '=', 'Done')->count();

                $totWoPending = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoPending = $totWoPending->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoPending = $totWoPending->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoPending = $totWoPending->where('status_wo', '=', 'Pending')->count();

                $totWoCancel = DataFtthIbSortir::where('site_penagihan', '=', 'Retail')
                    ->whereMonth('tgl_ikr', $bulan)
                    ->whereYear('tgl_ikr', $tahun)
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->select('status_wo')
                    ->where('branch', '=', $branchPenagihan[$br]->nama_branch);

                    if ($request->typePenagihanIB == "Additional Service STB"){
                        $totWoCancel = $totWoCancel->where('penagihan','=', $request->typePenagihanIB);
                    }
                    if ($request->typePenagihanIB == "New Installation"){
                        $totWoCancel = $totWoCancel->where('penagihan','!=', 'Additional Service STB');
                    }

                    $totWoCancel = $totWoCancel->where('status_wo', '=', 'Cancel')->count();

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
                        ->select('id','nama_branch','site_penagihan')
                        ->groupBy('id','nama_branch','site_penagihan');
                        // ->orderBy('id');

        $totCluster = DB::table('v_ftth_ib_cluster')
                        ->select('id','nama_branch','cluster','site_penagihan')
                        ->groupBy('id','nama_branch','cluster','site_penagihan');
                        // ->orderBy('id');

        if ($request->filterSite != "All") {
            $totBranchCluster = $totBranchCluster->where('site_penagihan', '=', $request->filterSite);
            $totCluster = $totCluster->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $totBranchCluster = $totBranchCluster->where('branch', '=', $request->filterBranch);
            $totCluster = $totCluster->where('branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $totBranchCluster = $totBranchCluster->where('penagihan', '=', $request->typePenagihanIB);
            $totCluster = $totCluster->where('penagihan', '=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $totBranchCluster = $totBranchCluster->where('penagihan', '!=', 'Additional Service STB');
            $totCluster = $totCluster->where('penagihan', '!=', 'Additional Service STB');
        }

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
            $Qbln = \Carbon\Carbon::parse($trendBulanan[$bt-1]['bulan'])->month;
            $blnThn = str_replace('-','_',$trendBulanan[$bt-1]['bulan']);

            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0) as ".$blnThn.""));
            $totBranchCluster = $totBranchCluster->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0)/(select sum(total_ftth_ib) from v_ftth_ib_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

            $totCluster = $totCluster->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0) as ".$blnThn.""));
            $totCluster = $totCluster->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total_ftth_ib end),0)/(select sum(total_ftth_ib) from v_ftth_ib_cluster where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));

        }

        $blnThnFilter = str_replace('-','_', $request->bulanTahunReport);

        $totBranchCluster = $totBranchCluster->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();
        $totCluster = $totCluster->orderBy('persen_'.$blnThnFilter.'', 'DESC')->get();


        for($db=0; $db < $totBranchCluster->count(); $db++){
            $totBranchBln[$db]['nmTbranch'] = $totBranchCluster[$db]->nama_branch;

            for($tbln=0; $tbln < count($trendBulanan); $tbln++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tbln]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tbln]['bulan']);

                $persenBln = "persen_".$blnThn;

                $totBranchBln[$db]['totbulanan'][$tbln] = $totBranchCluster[$db]->$blnThn;
                $totBranchBln[$db]['persen'][$tbln] = round($totBranchCluster[$db]->$persenBln,1); 
            }
        }

        for($db=0; $db < $totCluster->count(); $db++){
            $detCluster[$db]['nama_branch'] = $totCluster[$db]->nama_branch;
            $detCluster[$db]['cluster'] = $totCluster[$db]->cluster;

            for($tbln=0; $tbln < count($trendBulanan); $tbln++){
                $Qbln = \Carbon\Carbon::parse($trendBulanan[$tbln]['bulan'])->month;
                $blnThn = str_replace('-','_',$trendBulanan[$tbln]['bulan']);

                $persenBln = "persen_".$blnThn;

                $detCluster[$db]['bulanan'][$tbln] = $totCluster[$db]->$blnThn; 
                $detCluster[$db]['persen'][$tbln] = round($totCluster[$db]->$persenBln,1); 
            }
        }


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
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontly = $totIBFtthMontly->where('branch', '=', $request->filterBranch);
            }
            if ($request->typePenagihanIB == "Additional Service STB"){
                $totIBFtthMontly = $totIBFtthMontly->where('penagihan', '=', $request->typePenagihanIB);
            }
            if ($request->typePenagihanIB == "New Installation"){
                $totIBFtthMontly = $totIBFtthMontly->where('penagihan', '!=', 'Additional Service STB');
            }

            $totIBFtthMontly = $totIBFtthMontly->count();

            $totIBFtthMontlyDone = DB::table('data_ftth_ib_sortirs')
                ->whereMonth('tgl_ikr', \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->month)
                ->whereYear('tgl_ikr', (string) \Carbon\Carbon::parse($trendBulanan[$m]['bulan'])->year)
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                ->where('status_wo', '=', 'Done');
            // ->count();

            if ($request->filterSite != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('branch', '=', $request->filterBranch);
            }
            if ($request->typePenagihanIB == "Additional Service STB"){
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('penagihan', '=', $request->typePenagihanIB);
            }
            if ($request->typePenagihanIB == "New Installation"){
                $totIBFtthMontlyDone = $totIBFtthMontlyDone->where('penagihan', '!=', 'Additional Service STB');
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
            if ($request->typePenagihanIB == "Additional Service STB"){
                $tblStatus = $tblStatus->where('penagihan', '=', $request->typePenagihanIB);
            }
            if ($request->typePenagihanIB == "New Installation"){
                $tblStatus = $tblStatus->where('penagihan', '!=', 'Additional Service STB');
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
            ->whereMonth('data_ftth_ib_sortirs.tgl_ikr', '=', $bulan) // $bulan)
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
        }


        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraph[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        for ($t = 0; $t < count($tglGraph); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {

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
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $dataGraph[$pn]['data'][] = $jml;
            }
        }

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
        if ($request->typePenagihanIB == "Additional Service STB"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
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
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
                    ->where('data_ftth_ib_sortirs.penagihan', '=', $PenagihanSortir[$ps]->penagihan);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $detPenagihanSortir[$ps]['bulanan'][$m] = [$jml];
            }
        }


        return response()->json([
            'detPenagihanSortir' => $detPenagihanSortir,
            // 'detCouseCodeSortir' => $detCouseCodeSortir, 'detRootCouseSortir' => $detRootCouseSortir
        ]);
    }

    public function getDetailAPKIb(Request $request)
    {
        
        if($request->detSlide=="reason_status"){
            $detAPKBranch = DB::table('v_ftth_ib_cluster')
                        ->select('branch', DB::raw('sum(ftth_ib_done) as total'))
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
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="pending"){
            $detAPKBranch = DB::table('v_ftth_ib_pending')
                        ->select('branch', DB::raw('sum(total) as total'))->distinct()
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
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        if($request->detSlide=="cancel"){
            $detAPKBranch = DB::table('v_ftth_ib_cancel')
                        ->select('branch', DB::raw('sum(total) as total'))->distinct()
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
            

            $detAPKBranch=$detAPKBranch->groupBy('branch','bulan','tahun')->orderBy('total', 'DESC')->get();

        }

        return response()->json(['detailBranchAPK' => $detAPKBranch]);

    }

    public function dataDetailAPKIb(Request $request)
    {
        ini_set('max_execution_time', 900);
        ini_set('memory_limit', '2048M');

        $akses = Auth::user()->name;

        if($request->detSlide=="reason_status"){
            $detAPK = DB::table('data_ftth_ib_sortirs')
                    ->where('status_wo','=','Done')
                    ->whereMonth('tgl_ikr', '=',$request->detBulan)
                    ->whereYear('tgl_ikr', '=',$request->detThn);

            if($request->detSite != "All") {
                $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('penagihan','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if($request->detSlide=="pending"){
            $detAPK = DB::table('data_ftth_ib_sortirs')
                    ->where('status_wo','=','Pending')
                    ->whereMonth('tgl_ikr', '=',$request->detBulan)
                    ->whereYear('tgl_ikr', '=',$request->detThn);

            if($request->detSite != "All") {
                $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('penagihan','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if($request->detSlide=="cancel"){
            $detAPK = DB::table('data_ftth_ib_sortirs')
                    ->where('status_wo','=','Cancel')
                    ->whereMonth('tgl_ikr', '=',$request->detBulan)
                    ->whereYear('tgl_ikr', '=',$request->detThn);

            if($request->detSite != "All") {
                $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->where('penagihan','=',$request->detPenagihan);
            }
            
            $detAPK=$detAPK->get();

        }

        if($request->detSlide=="analisa_precon"){
            $detAPK = DB::table('v_detail_analis_precon')
                    ->whereMonth('tgl_ikr',$request->detBulan)
                    ->whereYear('tgl_ikr',$request->detThn);

            if($request->detSite != "All") {
                $detAPK=$detAPK->where('site_penagihan','=',$request->detSite);
            }
            if($request->detBranch != "All") {
                $detAPK=$detAPK->where('branch','=',$request->detBranch);
            }

            if($request->detKategori == "result"){
                $detAPK=$detAPK->whereRaw('`result` = "'.$request->detResult.'" COLLATE utf8mb4_unicode_ci');
            }
            
            if($request->detKategori == "penagihan"){
                $detAPK=$detAPK->whereRaw('`result` = "'.$request->detResult.'" COLLATE utf8mb4_unicode_ci')
                                ->where('penagihan','=',$request->detPenagihan);
            }
            if($request->detKategori == "root_couse"){
                $detAPK=$detAPK->whereRaw('`result` = "'.$request->detResult.'" COLLATE utf8mb4_unicode_ci')
                                ->where('penagihan','=',$request->detPenagihan)
                                ->where('root_couse','=', $request->detRoot_couse);
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
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);
        // ->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
        }

        $PenagihanSortir = $PenagihanSortir->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->get();

        for ($p = 0; $p < count($PenagihanSortir); $p++) {
            $nameGraphPending[$p] = ['penagihan' => $PenagihanSortir[$p]->penagihan];
        }

        
        for ($t = 0; $t < count($tglGraphPending); $t++) {
            for ($pn = 0; $pn < count($PenagihanSortir); $pn++) {


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
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
                }

                $jml = $jml->groupBy('data_ftth_ib_sortirs.penagihan', 'root_couse_penagihan.id')->orderBy('root_couse_penagihan.id')->count();

                $dataGraphPending[$pn]['data'][] = $jml;
            }
        }

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

        for ($bt = 1; $bt <= $bulan; $bt++) {
            $trendBulanan[] = ['bulan' => \Carbon\Carbon::create($tahun, $bt)->format('M-Y')];
        }

        $tblRootCousePending = [];

        $rootCousePending = DB::table('v_ftth_ib_pending')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        
        if ($request->filterSite != "All") {
            $rootCousePending = $rootCousePending->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $rootCousePending = $rootCousePending->where('branch', '=', $request->filterBranch);
        }

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCousePending = $rootCousePending->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            

            if ($request->filterSite != "All") {
                $rootCousePending = $rootCousePending->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_pending where site_penagihan='".$request->filterSite."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }
            if ($request->filterBranch != "All") {
                $rootCousePending = $rootCousePending->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_pending where branch='".$request->filterBranch."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            } else {
                $rootCousePending = $rootCousePending->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_pending where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }

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

    public function getRootCousePendingIBFtthOld(Request $request)
    {

        $total = 0;
        $startDate = $request->filterDateStart;
        $endDate = $request->filterDateEnd;

        $tglBulan = \Carbon\CarbonPeriod::between($startDate, $endDate);

        foreach ($tglBulan as $date) {
            $tgl[] = ['tgl_ikr' => $date->format('Y-m-d')];
        }

        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $rootCousePending = DB::table('root_couse_penagihan')->select('penagihan')->where('status', '=', 'Pending')->where('type_wo','=','IB Ftth')->get();

        
        $RootPendingMonthly = DataFtthIbSortir::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))
            ->whereYear('tgl_ikr', '=', $tahun)
            ->whereMonth('tgl_ikr', '<=', $bulan)
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day])
            ->distinct()->get();


        for ($x = 0; $x < $rootCousePending->count(); $x++) {
            for ($b = 0; $b < $RootPendingMonthly->count(); $b++) {

                $bln = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->month;
                $thn = \Carbon\Carbon::parse($RootPendingMonthly[$b]->bulan)->year;

                $jmlBln = $RootPendingMonthly[$b]->bulan;

                $jml = DataFtthIbSortir::where('penagihan', '=', $rootCousePending[$x]->penagihan)
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
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('penagihan', '!=', 'Additional Service STB');
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
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween('tgl_ikr', [$startDate, $endDate]); //->whereMonth('tgl_ikr', '=', $bln)->whereYear('tgl_ikr', '=', $thn); //->count();
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

            if ($request->filterSite != "All") {
                $tot = $tot->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tot = $tot->where('branch', '=', $request->filterBranch);
            }
            if ($request->typePenagihanIB == "Additional Service STB"){
                $tot = $tot->where('penagihan', '=', $request->typePenagihanIB);
            }
            if ($request->typePenagihanIB == "New Installation"){
                $tot = $tot->where('penagihan', '!=', 'Additional Service STB');
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
            ->whereYear('data_ftth_ib_sortirs.tgl_ikr', '=', $tahun);
            // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

        
        if ($request->filterSite != "All") {
            $PenagihanSortir = $PenagihanSortir->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $PenagihanSortir = $PenagihanSortir->where('branch', '=', $request->filterBranch);
        }
        if ($request->typePenagihanIB == "Additional Service STB"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
        }
        if ($request->typePenagihanIB == "New Installation"){
            $PenagihanSortir = $PenagihanSortir->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
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
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('data_ftth_ib_sortirs.penagihan', '!=', 'Additional Service STB');
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

        $rootCouseCancel = DB::table('v_ftth_ib_cancel')
                ->select('id','penagihan')
                ->groupBy('id','penagihan');

        if ($request->filterSite != "All") {
            $rootCouseCancel = $rootCouseCancel->where('site_penagihan', '=', $request->filterSite);
        }
        if ($request->filterBranch != "All") {
            $rootCouseCancel = $rootCouseCancel->where('branch', '=', $request->filterBranch);
        }

        for ($x = 0; $x < count($trendBulanan); $x++) {

            $Qbln = \Carbon\Carbon::parse($trendBulanan[$x]['bulan'])->month;

            $blnThn = str_replace('-','_',$trendBulanan[$x]['bulan']);

            $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0) as ".$blnThn.""));
            

            if ($request->filterSite != "All") {
                $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_cancel where site_penagihan='".$request->filterSite."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }
            if ($request->filterBranch != "All") {
                $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_cancel where branch='".$request->filterBranch."' and bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            } else {
                $rootCouseCancel = $rootCouseCancel->addSelect(DB::raw("(ifnull(sum(case when bulan=".$Qbln." and tahun=".$tahun." then total end),0)/(select sum(total) from v_ftth_ib_cancel where bulan=".$Qbln." and tahun=".$tahun."))*100 as persen_".$blnThn.""));
            }

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

    public function getRootCouseCancelIBFtthOld(Request $request)
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
                    ->whereYear('tgl_ikr', '=', $thn);
                    // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]);

                if ($request->filterSite != "All") {
                    $jml = $jml->where('site_penagihan', '=', $request->filterSite);
                }
                if ($request->filterBranch != "All") {
                    $jml = $jml->where('branch', '=', $request->filterBranch);
                }
                if ($request->typePenagihanIB == "Additional Service STB"){
                    $jml = $jml->where('penagihan', '=', $request->typePenagihanIB);
                }
                if ($request->typePenagihanIB == "New Installation"){
                    $jml = $jml->where('penagihan', '!=', 'Additional Service STB');
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
                ->whereYear('tgl_ikr', '=', $thn);
                // ->whereBetween(DB::raw('day(tgl_ikr)'), [\Carbon\Carbon::parse($startDate)->day, \Carbon\Carbon::parse($endDate)->day]); //->count();

            if ($request->filterSite != "All") {
                $tot = $tot->where('site_penagihan', '=', $request->filterSite);
            }
            if ($request->filterBranch != "All") {
                $tot = $tot->where('branch', '=', $request->filterBranch);
            }
            if ($request->typePenagihanIB == "Additional Service STB"){
                $tot = $tot->where('penagihan', '=', $request->typePenagihanIB);
            }
            if ($request->typePenagihanIB == "New Installation"){
                $tot = $tot->where('penagihan', '!=', 'Additional Service STB');
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
