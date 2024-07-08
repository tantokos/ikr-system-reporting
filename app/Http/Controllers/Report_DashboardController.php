<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report_DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $detailDash =[];

        $monthYearReport = DB::table('v_report_dashboard')
                    ->select('monthYear','bulan','tahun')
                    ->groupBy('monthYear','bulan','tahun')
                    ->orderBy('tahun')
                    ->orderBy('bulan', 'DESC')
                    ->get();

        $dataMonthlyReport = DB::table('v_report_dashboard')
                    ->select('monthYear','bulan','tahun','type','type_segment','rlink','total_wo','total_done','total_pending','total_cancel')
                    ->orderBy('tahun')
                    ->orderBy('bulan', 'DESC')
                    ->orderBy('position')
                    ->get();

        // dd($monthYearReport, $dataMonthlyReport);

        $MaxFtthIB = DB::table('data_ftth_ib_sortirs')
                    ->select(DB::raw('max(month(tgl_ikr)) as maxMonth, max(year(tgl_ikr)) as maxYear'))
                    ->first();

        $MaxFtthMT = DB::table('data_ftth_mt_sortirs')
                    ->select(DB::raw('max(month(tgl_ikr)) as maxMonth, max(year(tgl_ikr)) as maxYear'))
                    ->first();

        $MaxFtthDis = DB::table('data_ftth_dismantle_sortirs')
                    ->select(DB::raw('max(month(visit_date)) as maxMonth, max(year(visit_date)) as maxYear'))
                    ->first();

        $MaxFttxIB = DB::table('data_fttx_ib_sortirs')
                    ->select(DB::raw('max(month(ib_date)) as maxMonth, max(year(ib_date)) as maxYear'))
                    ->first();

        $MaxFttxMT = DB::table('data_fttx_mt_sortirs')
                    ->select(DB::raw('max(month(mt_date)) as maxMonth, max(year(mt_date)) as maxYear'))
                    ->first();


        $woFtthIB = DB::table('data_ftth_ib_sortirs')
            ->select(DB::raw('date_format(tgl_ikr,"%b-%Y") as MonthYearFtthIB, 
                            count(*) as TotFtthIB,
                            count(if(status_wo="Done",1,NULL)) as TotFtthIBDone,
                            count(if(status_wo="Pending",1,NULL)) as TotFtthIBPending,
                            count(if(status_wo="Cancel",1,NULL)) as TotFtthIBCancel'))
            ->whereMonth('tgl_ikr','=',$MaxFtthIB->maxMonth)
            ->whereYear('tgl_ikr','=',$MaxFtthIB->maxYear)
            ->groupBy('MonthYearFtthIB')
            ->first();

        $woFtthMT = DB::table('data_ftth_mt_sortirs')
            ->select(DB::raw('date_format(tgl_ikr,"%b-%Y") as MonthYearFtthMT, 
                            count(*) as TotFtthMT,
                            count(if(status_wo="Done",1,NULL)) as TotFtthMTDone,
                            count(if(status_wo="Pending",1,NULL)) as TotFtthMTPending,
                            count(if(status_wo="Cancel",1,NULL)) as TotFtthMTCancel'))
            ->whereMonth('tgl_ikr','=',$MaxFtthMT->maxMonth)
            ->whereYear('tgl_ikr','=',$MaxFtthMT->maxYear)
            ->groupBy('MonthYearFtthMT')
            ->first();

        $woFtthDis = DB::table('data_ftth_dismantle_sortirs')
            ->select(DB::raw('date_format(visit_date,"%b-%Y") as MonthYearFtthDis, 
                            count(*) as TotFtthDis,
                            count(if(status_wo="Done",1,NULL)) as TotFtthDisDone,
                            count(if(status_wo="Pending",1,NULL)) as TotFtthDisPending,
                            count(if(status_wo="Cancel",1,NULL)) as TotFtthDisCancel'))
            ->whereMonth('visit_date','=',$MaxFtthDis->maxMonth)
            ->whereYear('visit_date','=',$MaxFtthDis->maxYear)
            ->groupBy('MonthYearFtthDis')
            ->first();

        $woFttxIB = DB::table('data_fttx_ib_sortirs')
            ->select(DB::raw('date_format(ib_date,"%b-%Y") as MonthYearFttxIB, 
                            count(*) as TotFttxIB,
                            count(if(status_wo="Done",1,NULL)) as TotFttxIBDone,
                            count(if(status_wo="Pending",1,NULL)) as TotFttxIBPending,
                            count(if(status_wo="Cancel",1,NULL)) as TotFttxIBCancel'))
            ->whereMonth('ib_date','=',$MaxFttxIB->maxMonth)
            ->whereYear('ib_date','=',$MaxFttxIB->maxYear)
            ->groupBy('MonthYearFttxIB')
            ->first();

        $woFttxMT = DB::table('data_fttx_mt_sortirs')
            ->select(DB::raw('date_format(mt_date,"%b-%Y") as MonthYearFttxMT, 
                            count(*) as TotFttxMT,
                            count(if(status_wo="Done",1,NULL)) as TotFttxMTDone,
                            count(if(status_wo="Pending",1,NULL)) as TotFttxMTPending,
                            count(if(status_wo="Cancel",1,NULL)) as TotFttxMTCancel'))
            ->whereMonth('mt_date','=',$MaxFttxMT->maxMonth)
            ->whereYear('mt_date','=',$MaxFttxMT->maxYear)
            ->groupBy('MonthYearFttxMT')
            ->first();

                            
        return view('report.reportingDashboard',[
                'woFtthIB' => $woFtthIB, 'woFtthMT' => $woFtthMT,
                'woFtthDis' => $woFtthDis, 'woFttxIB' => $woFttxIB,
                'woFttxMT' => $woFttxMT, 'monthYear' => $monthYearReport, 'dataMonthly' => $dataMonthlyReport]);
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
