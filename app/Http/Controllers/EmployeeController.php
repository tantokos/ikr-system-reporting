<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Http\File;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Employee.employeeIndex', ['title' => 'Data Karyawan']);
    }


    public function employeeData(Request $request)
    {

        if ($request->ajax()) {
            $datas = Employee::all();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran

                ->editColumn('branch_id', function ($row) {
                    $nbranch = $row->branch->nama_branch;
                    return $nbranch;
                })
                ->addColumn('fotoKaryawan', function ($row) {
                    $url = asset("storage/image-kry/$row->foto_karyawan");
                    return '<img src="' . $url . '" align="center" style="width: 40px;height:40px;" />';
                })
                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);

                    $btn = '<a href="/employeeDetail/' . $row->id . '" class="btn btn-info btn-sm" > <i class="fas fa-edit"></i> Detail</a>
                     <a href="/employee/' . $row->id . '/edit" class="btn btn-primary btn-sm" > <i class="fas fa-edit"></i> Edit</a>';
                    //  <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'fotoKaryawan'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
        }
    }

    public function detail2($employee)
    {
        $employee = Employee::join('branches', 'branches.id', '=', 'employees.branch_id')
            ->where('employees.id', '=', $employee)
            ->select('employees.*', 'branches.nama_branch')->first();
        // dd($employee);
        return view('Employee.employeeDetail2', ['karyawan' => $employee]);
    }

    public function detail($employee)
    {
        $employee = Employee::join('branches', 'branches.id', '=', 'employees.branch_id')
            ->where('employees.id', '=', $employee)
            ->select('employees.*', 'branches.nama_branch')->first();

           $join=Carbon::parse(substr($employee->nik_karyawan,0,4)."-".substr($employee->nik_karyawan,4,2))->diff(Carbon::now());
        // dd($employee);
        return view('Employee.employeeDetail2', ['karyawan' => $employee, 'join' => $join]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $branchopt = Branch::all();
        return view('employee.employeeCreate', ['title' => 'Input Data Karyawan', 'branchopt' => $branchopt]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input('kelengkapan'));
        $request->validate([
            'nik_karyawan' => ['required', 'unique:Employees,nik_karyawan'],
            'nama_karyawan' => 'required',
            'branch' => 'required',
            'divisi' => 'required',
            'departement' => 'required',
            'posisi' => 'required',
        ]);

        //$branch = new Branch($request->all());
        //$branch->save();
        // dd($request->foto_karyawan);

        if ($request->hasFile('foto_karyawan')) {
            $file = $request->file('foto_karyawan')->getClientOriginalName();
            $request->file('foto_karyawan')->move(public_path('storage/image-kry'), $file);
        } else {
            $file = 'foto-blank.jpg';
        }


        Employee::create([
            'nik_karyawan' => $request->nik_karyawan,
            'nama_karyawan' => $request->nama_karyawan,
            'no_telp' => $request->no_telp,
            'branch_id' => $request->branch,
            'divisi' => $request->divisi,
            'departement' => $request->departement,
            'posisi' => $request->posisi,
            'email' => $request->email,
            'status_active' => $request->status_active,
            'foto_karyawan' => $file,
        ]);

        return redirect('employee');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($employee)
    {


        $employ = Employee::find($employee);
        // dd($employ);
        $bid = Branch::all();
        // dd($bid);
        return view('Employee.employeeEdit', ['title' => 'Edit Data Karyawan', 'karyawan' => $employ, 'branchopt' => $bid]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        // dd($employee);
        $request->validate([
            'nik_karyawan' => 'required',
            'nama_karyawan' => 'required',
            'branch' => 'required',
            'divisi' => 'required',
            'departement' => 'required',
            'posisi' => 'required',
            // 'email' => 'required',
            'status_active' => 'required',
        ]);

        // dd($request);

        if ($request->hasFile('foto_karyawan')) {
            $fileupdate =  $request->file('foto_karyawan')->getClientOriginalName();
            $request->file('foto_karyawan')->move(public_path('storage/image-kry'), $fileupdate);

            if ($employee->foto_karyawan) {
                unlink(public_path('storage/image-kry/' . $employee->foto_karyawan));
            }
        } else {
            $fileupdate = $employee->foto_karyawan;
        }

        $employee->nik_karyawan = $request->nik_karyawan;
        $employee->nama_karyawan = $request->nama_karyawan;
        $employee->no_telp = $request->no_telp;
        $employee->branch_id = $request->branch;
        $employee->divisi = $request->divisi;
        $employee->departement = $request->departement;
        $employee->posisi = $request->posisi;
        $employee->email = $request->email;
        $employee->status_active = $request->status_active;
        $employee->foto_karyawan = $fileupdate;
        $employee->save();
        return redirect('employee');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        //
    }
}
