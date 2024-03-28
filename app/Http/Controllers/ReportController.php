<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Charts\MonthlyWoChart;
use App\Models\Branch;
use App\Models\ImportFtthMtSortirTemp;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MonthlyWoChart $chart)
    {


        $branchPenagihan = Branch::select('id','nama_branch')->orderBy('id')->get();

        for ($b = 0; $b < $branchPenagihan->count(); $b++) {
            if($branchPenagihan[$b]->nama_branch == "Apartement"){
                $totWo = ImportFtthMtSortirTemp::where('site_penagihan','=','Apartement')->select('status_wo')->count();
                $totWoDone = ImportFtthMtSortirTemp::where('site_penagihan','=','Apartement')->select('status_wo')->where('status_wo','=','Done')->count();
                $totWoPending = ImportFtthMtSortirTemp::where('site_penagihan','=','Apartement')->select('status_wo')->where('status_wo','=','Pending')->count();
                $totWoCancel = ImportFtthMtSortirTemp::where('site_penagihan','=','Apartement')->select('status_wo')->where('status_wo','=','Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone*100)/$totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending*100)/$totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel*100)/$totWo;

            }
            elseif($branchPenagihan[$b]->nama_branch == "Underground"){
                $totWo = ImportFtthMtSortirTemp::where('site_penagihan','=','Underground')->select('status_wo')->count();
                $totWoDone = ImportFtthMtSortirTemp::where('site_penagihan','=','Underground')->select('status_wo')->where('status_wo','=','Done')->count();
                $totWoPending = ImportFtthMtSortirTemp::where('site_penagihan','=','Underground')->select('status_wo')->where('status_wo','=','Pending')->count();
                $totWoCancel = ImportFtthMtSortirTemp::where('site_penagihan','=','Underground')->select('status_wo')->where('status_wo','=','Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone*100)/$totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending*100)/$totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel*100)/$totWo;

            }
            elseif(($branchPenagihan[$b]->nama_branch <> "Apartement" && $branchPenagihan[$b]->nama_branch <> "Underground")){
                $totWo = ImportFtthMtSortirTemp::where('site_penagihan','=','Retail')->where('branch','=',$branchPenagihan[$b]->nama_branch)->select('status_wo')->count();
                $totWoDone = ImportFtthMtSortirTemp::where('site_penagihan','=','Retail')->where('branch','=',$branchPenagihan[$b]->nama_branch)->select('status_wo')->where('status_wo','=','Done')->count();
                $totWoPending = ImportFtthMtSortirTemp::where('site_penagihan','=','Retail')->where('branch','=',$branchPenagihan[$b]->nama_branch)->select('status_wo')->where('status_wo','=','Pending')->count();
                $totWoCancel = ImportFtthMtSortirTemp::where('site_penagihan','=','Retail')->where('branch','=',$branchPenagihan[$b]->nama_branch)->select('status_wo')->where('status_wo','=','Cancel')->count();

                $branchPenagihan[$b]->total = $totWo;
                $branchPenagihan[$b]->done = $totWoDone;
                $branchPenagihan[$b]->persenDone = ($totWoDone*100)/$totWo;
                $branchPenagihan[$b]->pending = $totWoPending;
                $branchPenagihan[$b]->persenPending = ($totWoPending*100)/$totWo;
                $branchPenagihan[$b]->cancel = $totWoCancel;
                $branchPenagihan[$b]->persenCancel = ($totWoCancel*100)/$totWo;

            }
        }

        $tgl = ImportFtthMtSortirTemp::select('tgl_ikr')->distinct()->get();

        $trendMonthly = ImportFtthMtSortirTemp::select(DB::raw('date_format(tgl_ikr, "%b-%Y") as bulan'))->distinct()->get();
        
        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->year);

        for ($m = 0; $m < $trendMonthly->count() ; $m++) {
            $totMtMontly = DB::table('import_ftth_mt_sortir_temps')
            ->whereMonth('tgl_ikr',\Carbon\Carbon::parse($trendMonthly[$m]->bulan)->month)
            ->whereYear('tgl_ikr',(string) \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->year)
            ->count();
            $totMtMontlyDone = DB::table('import_ftth_mt_sortir_temps')
            ->whereMonth('tgl_ikr',\Carbon\Carbon::parse($trendMonthly[$m]->bulan)->month)
            ->whereYear('tgl_ikr',(string) \Carbon\Carbon::parse($trendMonthly[$m]->bulan)->year)
            ->where('status_wo','=','Done')
            ->count();

            $trendMonthly[$m]->trendMtTotal = $totMtMontly;
            $trendMonthly[$m]->trendMtDone = $totMtMontlyDone;

        }

        $tblStatus = ImportFtthMtSortirTemp::select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
        count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'))
        ->groupBy('tgl_ikr')->get();

        // dd($tblStatus);

        // dd($trendMonthly[0]->bulan);
        // dd(\Carbon\Carbon::parse($tgl[0]->tgl_ikr)->format('F'));
        
        // dd(\Carbon\Carbon::parse($trendMonthly[0]->bulan)->daysInMonth);

        return view('report.reporting',
        ['totWoMtBranch' => $branchPenagihan, 'trendMonthly' => $trendMonthly, 'branches' => $branchPenagihan, 'tblStatus' => $tblStatus]);
    }

    public function getTabelStatus(Request $request)
    {
        // dd($request);
        $bulan = \Carbon\Carbon::parse($request->bulanTahunReport)->month;
        $tahun = \Carbon\Carbon::parse($request->bulanTahunReport)->year;

        $tblStatus = ImportFtthMtSortirTemp::select(DB::raw('tgl_ikr, count(if(status_wo = "Done", 1, NULL)) as Done, 
        count(if(status_wo = "Pending", 1, NULL)) as Pending, count(if(status_wo = "Cancel", 1, NULL)) as Cancel'))
        ->whereMonth('tgl_ikr',$bulan)
        ->whereYear('tgl_ikr', $tahun)
        ->orderBy('tgl_ikr')
        ->groupBy('tgl_ikr')->get();
        

        return response()->json($tblStatus);

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
