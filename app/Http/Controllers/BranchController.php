<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return view('branch.branchIndex',['title' => 'Data Branch']);
               
    }

    public function dataTable(Request $request)
    {
        if ($request->ajax()) {
            $datas = Branch::all();
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
                ->addColumn('action', function($row){  
                    //  $enc_id = \Crypt::encrypt($row->id);
                     
                     $btn = '<a href="/branchEdit/'.$row->id.'" class="btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
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
        return view('branch.branchCreate',['title' => 'Input Branch']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_branch' => 'required',
            'kode_branch' => 'required',
            'alamat' => 'required',
        ]);

        Branch::create([
            'nama_branch' => $request->nama_branch,
            'kode_branch' => $request->kode_branch,
            'alamat' => $request->alamat
        ]);

        return redirect('/branch');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($branch)
    {
        $bid = Branch::find($branch);
        return view('branch.branchEdit',[ 'title' => 'Edit Data Branch', 'branchid' => $bid ]);
        
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'nama_branch' => 'required',
            'alamat' => 'required',
        ]);

        $branch->nama_branch = $request->nama_branch;
        $branch->kode_branch = $request->kode_branch;
        $branch->alamat = $request->alamat;
        $branch->save();
        return view('branch.branchIndex',['title'=>'Data Branch']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        //
    }
}
