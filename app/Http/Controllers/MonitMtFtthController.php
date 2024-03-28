<?php

namespace App\Http\Controllers;

use App\Models\MonitMtFtth;
use App\Http\Controllers\Controller;
use App\Models\Batchwo;
use App\Models\RootCouse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MonitMtFtthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('MTFtth.MTIndex');
    }


    public function batchwodataMT(Request $request)
    {
        // dd($request);
        $datas = MonitMtFtth::leftjoin('fats','fats.kode_cluster','=','monit_mt_ftths.kode_cluster_fat')
        ->leftjoin('branches','branches.id','=','fats.branch_id')
        ->leftjoin('callsign_tims', 'callsign_tims.callsign_tim','=','monit_mt_ftths.callsign')
        ->leftjoin('callsign_leads','callsign_leads.id','=','callsign_tims.lead_callsign')
        ->leftjoin('employees','employees.id','=','callsign_leads.lead_callsign');

        if($request->batch_wo != Null) {
            $datas = $datas->where('monit_mt_ftths.batch_wo','=',$request->batch_wo);
        }
        if($request->jenis_wo != Null) {
            $datas = $datas->where('monit_mt_ftths.jenis_wo','=',$request->jenis_wo);
        }
        if($request->tgl_ikr != Null) {
            $datas = $datas->whereDate('monit_mt_ftths.tgl_ikr','=',$request->tgl_ikr);
        }
        if($request->branch != Null) {
            $datas = $datas->where('branches.nama_branch','=',$request->branch);
        }
        if($request->area_fat != Null) {
            $datas = $datas->where('fats.area','=',$request->area_fat);
        }
        if($request->callsign != Null) {
            $datas = $datas->where('monit_mt_ftths.callsign','=',$request->callsign);
        }
        if($request->no_wo != Null) {
            $datas = $datas->where('monit_mt_ftths.wo_no','=',$request->no_wo);
        }
        if($request->cust_id != Null) {
            $datas = $datas->where('monit_mt_ftths.cust_id','=',$request->cust_id);
        }

        $datas = $datas->select('monit_mt_ftths.*', 'fats.area as areaFat','fats.cluster as clusterFat', 'branches.nama_branch', 'employees.nama_karyawan as leader')->get();

        // dd($datas);
        if ($request->ajax()) {
            // $datas = Batchwo::all();   
            // dd($datas);         
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                
                ->addColumn('action', function($row){  
                    //  $enc_id = \Crypt::encrypt($row->id);
                     
                     $btn = '<a class="btn btn-sm btn-warning edit-callsign" id="'. $row->id .'"> <i class="ti-pencil"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                     return $btn;
                })                
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        }     
        
    }

    public function getCouseCode (Request $request)
    {
        // dd($request);
        $cousecode = RootCouse::where('status_wo','=',$request->status_wo)->select('couse_code')->groupby('couse_code')->get();

        return response()->json($cousecode);       

    }

    public function getRootCouse (Request $request)
    {
        // dd($request);
        $rootcouse = RootCouse::where('couse_code','=',$request->couse_code)->select('root_couse')->groupby('root_couse')->get();

        return response()->json($rootcouse);       

    }

    public function getActionTaken (Request $request)
    {
        // dd($request);
        $rootcouse = RootCouse::where('root_couse','=',$request->root_couse)->select('action_taken')->groupby('action_taken')->get();

        return response()->json($rootcouse);       

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
    public function show(MonitMtFtth $monitMtFtth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MonitMtFtth $monitMtFtth)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MonitMtFtth $monitMtFtth)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MonitMtFtth $monitMtFtth)
    {
        //
    }
}
