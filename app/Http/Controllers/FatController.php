<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fat;
use App\Models\Branch;
use Yajra\DataTables\DataTables;

class FatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('fat.fatIndex',['title' => 'Data FAT & Cluster']);
    }


    public function fatdata(Request $request)
    {
        $fatData = Fat::join('branches','branches.id','=', 'fats.branch_id')
        ->select('fats.*','branches.nama_branch')->get();

        // dd($fatData);

        if ($request->ajax()) {
            // $fatData = Employee::all();            
            return DataTables::of($fatData)
                ->addIndexColumn() //memberikan penomoran
                //->addColumn('ID',function($row){ //menambahkan column baru pada yajra datatable
                    // $id = $row->id;
                    // return $id;
                //})
                // ->editColumn('gender', function($row){ //mengedit column pada yajra datatable 
                //     if($row->gender == 'L'){
                //         return 'Laki-laki';
                //     }else{
                //         return 'Perempuan';
                //     }
                // })
                ->editColumn('updated_at', function($row){
                    return $row->updated_at->format('Y-m-d H:m:s');
                })
                // ->addColumn('fotoKaryawan', function($row) {
                //     $url=asset("storage/image-kry/$row->foto_karyawan");
                //     return '<img src="'.$url.'" align="center" style="width: 100px;width:50px;" />';
                // })
                ->addColumn('action', function($row){  
                    //  $enc_id = \Crypt::encrypt($row->id);
                     
                     $btn = '<a href="/fatEdit/'.$row->id.'" class="btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
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
        $branchopt = Branch::all();
        return view('fat.fatCreate',['title' => 'Input Data Cluster FAT', 'branchopt' => $branchopt]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'branch' => 'required',
            'kode_branch' => 'required',
            'areaFat' => 'required','unique',
            'kode_cluster' => 'required',
            'cluster' => 'required',
            'ms_regular' => 'required',
        ]);

        Fat::create([
            'kode_area' => $request->kode_branch,
            'area' => $request->areaFat,
            'kode_cluster' => $request->kode_cluster,
            'cluster' => $request->cluster,
            'hp' => $request->homepas,
            'jml_fat' => $request->jml_fat,
            'active' => $request->sub_active,
            'suspend' => $request->suspend,
            'ms_regular' => $request->ms_regular,
            'branch_id' => $request->branch,

      ]);

      return redirect('fat');


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
        // dd($id);
        $fatEdit = Fat::find($id);
        $branchopt = Branch::all();
        

        // dd($fatEdit);

        return view('fat.fatEdit',['title' => 'Edit Data FAT & Cluster','fatedit' => $fatEdit,'branchopt' => $branchopt]);
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
