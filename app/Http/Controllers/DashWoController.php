<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Batchwo;
use App\Models\MonitMtFtth;
use Illuminate\Http\Request;

class DashWoController extends Controller
{
    public function index() 
    {
        // $totWo = Batchwo::where('tgl_ikr', '=', date(now()->format('Y-m-d')))->count();
        $totWo = MonitMtFtth::count();
        $totDone = MonitMtFtth::where('status_wo','=', 'Done')->count();
        $totPending = MonitMtFtth::where('status_wo','=', 'Pending')->count();
        $totCancel = MonitMtFtth::where('status_wo','=', 'Cancel')->count();
        $totProgress= MonitMtFtth::where('status_wo','=', 'Progress')->count();

        // dd($totWo);
        return view('dashboard.dashWo',['totalWo' => $totWo, 'totalDone' => $totDone, 'totalPending' => $totPending, 'totalCancel' => $totCancel, 'totalProgress' => $totProgress]);
    }
}
