<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Batchwo;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BatchwoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teknisi = Employee::where('employees.posisi', 'not like', 'Leader%')
                    ->orderby('employees.nama_karyawan')->get();
        // dd($teknisi);
        return view('batchWO.batchWOIndex',['teknisiList' => $teknisi]);
    }


    public function batchwodata(Request $request)
    {
        // dd($request);
        $datas = Batchwo::leftjoin('fats','fats.kode_cluster','=','batchwos.kode_cluster_fat')
        ->leftjoin('branches','branches.id','=','fats.branch_id');
        // ->where('batchwos.batch_wo','=',$request->batch_wo)
        // ->select('batchwos.*', 'fats.area as areaFat','fats.cluster as clusterFat', 'branches.nama_branch');

        if($request->batch_wo != Null) {
            $datas = $datas->where('batchwos.batch_wo','=',$request->batch_wo);
        }
        if($request->jenis_wo != Null) {
            $datas = $datas->where('batchwos.jenis_wo','=',$request->jenis_wo);
        }
        if($request->tgl_ikr != Null) {
            $datas = $datas->whereDate('batchwos.tgl_ikr','=',$request->tgl_ikr);
        }
        if($request->branch != Null) {
            $datas = $datas->where('branches.nama_branch','=',$request->branch);
        }
        if($request->area_fat != Null) {
            $datas = $datas->where('fats.area','=',$request->area_fat);
        }
        if($request->callsign != Null) {
            $datas = $datas->where('batchwos.callsign','=',$request->callsign);
        }
        if($request->no_wo != Null) {
            $datas = $datas->where('batchwos.wo_no','=',$request->no_wo);
        }
        if($request->cust_id != Null) {
            $datas = $datas->where('batchwos.cust_id','=',$request->cust_id);
        }

        $datas = $datas->select('batchwos.*', 'fats.area as areaFat','fats.cluster as clusterFat', 'branches.nama_branch')->get();

        // dd($datas);
        if ($request->ajax()) {
            // $datas = Batchwo::all();   
            // dd($datas);         
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                
                ->addColumn('action', function($row){  
                    //  $enc_id = \Crypt::encrypt($row->id);
                     
                     $btn = '<a class="btn btn-sm btn-warning edit-callsign" > <i class="ti-pencil"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                     return $btn;
                })                
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        }

      
        
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
        // dd($request);

        
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