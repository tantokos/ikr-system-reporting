<?php

namespace App\Http\Controllers;

use App\Models\CallsignLead;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Branch;
use App\Models\CallsignTim;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class CallsignLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $datas = CallsignLead::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                // ->addColumn('ID',function($row){ //menambahkan column baru pada yajra datatable
                //     $id = $row->id;
                //     return $id;
                // })
                // ->editColumn('gender', function($row){ //mengedit column pada yajra datatable 
                //     if($row->gender == 'L'){
                //         return 'Laki-laki';
                //     }else{
                //         return 'Perempuan';
                //     }
                // })
                ->editColumn('leader_id', function ($row) {
                    $leader = Employee::all()->where("id", "=", $row->leader_id)->first();
                    return $leader->nama_karyawan;
                })
                ->editColumn('branch', function ($row) {
                    $nbranch = Employee::with(['branch'])->where("id", "=", $row->leader_id)->first();
                    return $nbranch->branch->nama_branch;
                })
                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);

                    $btn = '<a href="/callsignLeadEdit/' . $row->id . '" class="btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }


        return view('callsign.callsignLeadIndex', ['title' => "Data Lead Callsign"]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leaderlist = Employee::all();
        // dd($leaderlist);
        // return response()->json(['data' => $leaderlist]);
        return view('callsign.callsignLeadCreate', ['title' => 'Input Lead Callsign', 'leaderlist' => $leaderlist]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lead_callsign' => ['required', 'unique:callsign_leads,lead_callsign'],
            'leader_id' => 'required',
        ]);

        CallsignLead::create([
            'lead_callsign' => $request->lead_callsign,
            'leader_id' => $request->leader_id,

        ]);

        return view('callsign.callsignLeadIndex', ['title' => "Data Lead Callsign"]);
    }

    /**
     * Display the specified resource.
     */
    // public function show(CallsignLead $callsignLead)
    public function show($leaderid)
    {
        $nmbranch = Employee::with(['branch'])->where("id", "=", $leaderid)->first();
        // dd($nmbranch);
        return response()->json($nmbranch->branch->nama_branch);
        // return response($nmbranch->branch->nama_branch);

    }

    /**
     * Show the form for editing the specified resource.
     */
    //public function edit(CallsignLead $callsignLead)
    public function edit($lead_callsign)
    {

        $leaderlist = Employee::all();
        $lead_sign = CallsignLead::where('callsign_leads.id', $lead_callsign)->join('employees', 'employees.id', '=', 'callsign_leads.leader_id')
            ->join('branches', 'branches.id', '=', 'employees.branch_id')
            ->select('callsign_leads.*', 'employees.nama_karyawan', 'branches.nama_branch')->first();


        // $lead_callsign=CallsignLead::find($lead_callsign);

        // dd($lead_sign);
        return view('callsign.callsignLeadEdt', ['title' => 'Edit data Lead Callsign', 'lead_sign' => $lead_sign, 'leaderlist' => $leaderlist]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        // dd($request);
        $cek_callsignL = CallsignLead::find($id);

        // dd($cek_callsignL);

        if (($cek_callsignL->id == $id) && ($cek_callsignL->lead_callsign == $request->lead_callsign)) {
            // $cek_callsignL = "sama";

            $request->validate([
                'leader_id' => 'required',
                'branch' => 'required',
            ]);

            $cek_callsignL->leader_id = $request->leader_id;
            $cek_callsignL->save();
        } else {

            $request->validate([
                'lead_callsign' => ['required', 'unique:callsign_leads,lead_callsign'],
                'leader_id' => 'required',
                'branch' => 'required',
            ]);

            $cek_callsignL->lead_callsign = $request->lead_callsign;
            $cek_callsignL->leader_id = $request->leader_id;
            $cek_callsignL->save();
        }
        return view('callsign.callsignLeadIndex', ['title' => "Data Lead Callsign"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallsignLead $callsignLead)
    {
        //
    }
}
