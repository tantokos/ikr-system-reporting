<?php

namespace App\Http\Controllers;

use App\Models\CallsignTim;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\CallsignLead;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use function Laravel\Prompts\select;

class CallsignTimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        
        
        // dd($tim);

               
        $dataCallsignTim = CallsignTim::join('employees as e1', 'e1.id', '=', 'callsign_tims.nik_tim1')
            ->leftjoin('employees as e2', 'e2.id', '=', 'callsign_tims.nik_tim2')
            ->leftjoin('employees as e3', 'e3.id', '=', 'callsign_tims.nik_tim3')
            ->leftjoin('employees as e4', 'e4.id', '=', 'callsign_tims.nik_tim4')
            ->join('callsign_leads', 'callsign_leads.id', '=', 'callsign_tims.lead_callsign')
            ->join('employees as e5', 'e5.id', '=', 'callsign_leads.leader_id')
            ->join('branches', 'branches.id', '=', 'e5.branch_id')
            ->select('callsign_tims.*', 'e1.nama_karyawan as nama_karyawan1','e2.nama_karyawan as nama_karyawan2','e3.nama_karyawan as nama_karyawan3','e4.nama_karyawan as nama_karyawan4', 'callsign_leads.lead_callsign', 'callsign_leads.leader_id', 'e5.nama_karyawan as nama_leader', 'branches.nama_branch')->get();



        // dd($dataCallsignTim);

        if ($request->ajax()) {
            // $datas = CallsignTim::all();
            return DataTables::of($dataCallsignTim)
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
                // ->editColumn('leader_id', function ($row) {
                //     $leader = Employee::all()->where("id", "=", $row->leader_id)->first();
                //     return $leader->nama_karyawan;
                // })
                // ->editColumn('branch', function ($row) {
                //     $nbranch = Employee::with(['branch'])->where("id", "=", $row->leader_id)->first();
                //     return $nbranch->branch->nama_branch;
                // })
                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);

                    $btn = '<a href="/callsignTimEdit/' . $row->id . '" class="btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }


        return view('callsignTim.callsignTimIndex', ['title' => "Data Callsign Tim"]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $leadCallOpt = CallsignLead::all();
        $leadCallOpt = CallsignLead::join('employees', 'employees.id', '=', 'callsign_leads.leader_id')
            ->join('branches', 'branches.id', '=', 'employees.branch_id')
            ->select('callsign_leads.*', 'employees.nama_karyawan', 'branches.nama_branch', 'employees.branch_id', 'employees.posisi')->get();

        // dd($leadCallOpt);

        return view('callsignTim.callsignTimCreate', ['title' => 'Input Callsign Tim', 'leadCallOpt' => $leadCallOpt]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);
        $request->validate([

            'leadCallsign' => ['required'],
            'callsign' => ['required', 'unique:callsign_tims,callsign_tim'],
            // 'teknisi1' => ['unique:callsign_tims,nik_tim1','unique:callsign_tims,nik_tim2','unique:callsign_tims,nik_tim3','unique:callsign_tims,nik_tim4'],
            // 'teknisi2' => ['unique:callsign_tims,nik_tim1','unique:callsign_tims,nik_tim2','unique:callsign_tims,nik_tim3','unique:callsign_tims,nik_tim4'],
            // 'teknisi3' => ['unique:callsign_tims,nik_tim1','unique:callsign_tims,nik_tim2','unique:callsign_tims,nik_tim3','unique:callsign_tims,nik_tim4'],
            // 'teknisi4' => ['unique:callsign_tims,nik_tim1','unique:callsign_tims,nik_tim2','unique:callsign_tims,nik_tim3','unique:callsign_tims,nik_tim4'],


        ]);

        // for ($i = 0; $i < 4; $i++) {

            CallsignTim::create([
                'lead_callsign' => $request['leadCallsign'],
                'callsign_tim' => $request['callsign'],
                'nik_tim1' => $request['teknisi1'],
                'nik_tim2' => $request['teknisi2'],
                'nik_tim3' => $request['teknisi3'],
                'nik_tim4' => $request['teknisi4'],
            ]);

            // CallsignTim::create($tim);
        // }

        // dd($tim);
        
        return view('callsignTim.callsignTimIndex', ['title' => "Data Callsign Tim"]);


    }

    /**
     * Display the specified resource.
     */
    public function show($leaderid)
    {
        $tim1=collect(CallsignTim::pluck('nik_tim1 as nik_tim')->whereNotNull()->all());
        $tim2=collect(CallsignTim::pluck('nik_tim2 as nik_tim')->whereNotNull()->all());
        $tim3=collect(CallsignTim::pluck('nik_tim3 as nik_tim')->whereNotNull()->all());
        $tim4=collect(CallsignTim::pluck('nik_tim4 as nik_tim')->whereNotNull()->all());

        $tim=$tim1->merge($tim2)->merge($tim3)->merge($tim4);
        
        $branchid = Employee::find($leaderid);
        

        $data = Employee::whereNotIn('employees.id', $tim)->where("branch_id", "=", $branchid->branch_id)
            ->where('employees.posisi', 'not like', 'Leader%')
            ->where('employees.nama_karyawan', 'LIKE', '%' . request('q') . '%')->select('employees.id', 'employees.nama_karyawan')->paginate(10);
        // dd($nmbranch);



        // dd($data);

        return response()->json($data);
        // return response($nmbranch->branch->nama_branch);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($timID, CallsignTim $callsignTim)
    {
        // dd($timID);
        $leadCallsign = CallsignLead::all();
        $timEdit = CallsignTim::join('callsign_leads', 'callsign_leads.id', '=', 'callsign_tims.lead_callsign')
            ->leftjoin('employees', 'employees.id', '=', 'callsign_leads.leader_id')
            ->leftjoin('branches', 'branches.id', '=', 'employees.branch_id')
            ->leftjoin('employees as e1','e1.id','=','callsign_tims.nik_tim1')
            ->leftjoin('employees as e2','e2.id','=','callsign_tims.nik_tim2')
            ->leftjoin('employees as e3','e3.id','=','callsign_tims.nik_tim3')
            ->leftjoin('employees as e4','e4.id','=','callsign_tims.nik_tim4')
            ->where('callsign_tims.id', '=', $timID)
            ->select('callsign_tims.*', 'callsign_leads.leader_id', 'employees.nama_karyawan as nama_leader', 'employees.posisi as posisi_leader','employees.branch_id', 'branches.nama_branch', 'e1.nama_karyawan as nama_tim1','e2.nama_karyawan as nama_tim2','e3.nama_karyawan as nama_tim3','e4.nama_karyawan as nama_tim4')->first();

        
        // dd($timEdit);
        $callsign = CallsignTim::where('callsign_tims.id','=', $timID)->select('callsign_tims.callsign_tim')->first();

        $timEdit2=CallsignTim::leftjoin('employees as e1','e1.id','=','callsign_tims.nik_tim1')
        ->leftjoin('employees as e2','e2.id','=','callsign_tims.nik_tim2')
        ->leftjoin('employees as e3','e3.id','=','callsign_tims.nik_tim3')
        ->leftjoin('employees as e4','e4.id','=','callsign_tims.nik_tim4')        
        ->where('callsign_tims.callsign_tim', '=', $callsign->callsign_tim)
        ->select('callsign_tims.nik_tim1','e1.nama_karyawan as nama_karyawan1','callsign_tims.nik_tim2','e2.nama_karyawan as nama_karyawan2','callsign_tims.nik_tim3','e3.nama_karyawan as nama_karyawan3','callsign_tims.nik_tim4','e4.nama_karyawan as nama_karyawan4')->get();

        // $timEdit2 = CallsignTim::where('callsign_tims.callsign_tim','=', $callsign->callsign_tim)->select('callsign_tims.nik_tim')->get();
        // dd(response()->json($timEdit2));
        // dd($timEdit2);
        return view('callsignTim.callsignTimEdit', ['title' => 'Edit Callsign Tim', 'timEdit' => $timEdit, 'leadCallOpt' => $leadCallsign, 'timEdit2' => $timEdit2]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallsignTim $callsignTim)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallsignTim $callsignTim)
    {
        //
    }
}
