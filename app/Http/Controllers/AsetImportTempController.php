<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportAset;
use App\Models\AsetImportTemp;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AsetImportTempController extends Controller
{
    public function index(Request $request)
    {
        $akses = Auth::user()->name;
        $jmlData = AsetImportTemp::where('Aset_Import_Temps.login', '=', $akses)->count();

        return view('dataAsetTemp.asetTempIndex', ['title' => 'Import Aset', 'akses' => $akses, 'jmlImport' => $jmlData]);
    }

    public function importAset(Request $request)
    {
        // dd($request->all());
        if ($request->hasFile('fileAset')) {

            $request->validate([
                'fileAset' => ['required', 'mimes:xlsx,xls,csv'] 
            ]);

            $akses = Auth::user()->name;

            Excel::import(new importAset($akses), request()->file('fileAset'));

            return back();
        }
    }

    public function dataTempAset(Request $request)
    {
        if ($request->ajax()) {
            $datas = AsetImportTemp::all();
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
                // ->editColumn('leader_id', function ($row) {
                //     $leader = Employee::all()->where("id", "=", $row->leader_id)->first();
                //     return $leader->nama_karyawan;
                // })
                // ->editColumn('branch', function ($row) {
                //     $nbranch = Employee::with(['branch'])->where("id", "=", $row->leader_id)->first();
                //     return $nbranch->branch->nama_branch;
                // })
                ->addColumn('fotoAset', function ($row) {
                    $url = asset("storage/image-kry/$row->foto_barang");
                    return '<img src="' . $url . '" align="center" style="width: 40px;height:40px;" />';
                })
                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);
                    // <a href="aset/'.$row->id.'/edit" value="'.$row->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#md-edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                    $btn = '<a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'fotoAset'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }


        // return view('dataAset.asetIndex', ['title' => "Data Aset"]);
    }

    public function store(Request $request)
    {


        AsetImportTemp::where('login', '=', $request->akses)->select('id','nama_barang', 'merk_barang', 'spesifikasi', 'kode_aset', 'kode_ga', 'kondisi', 'satuan', 'jumlah', 'kategori', 'tgl_pengadaan', 'foto_barang', 'nopol', 'pajak_1tahun', 'pajak_5tahun', 'login')
            ->each(function ($aset) {
                // dd($aset);
                $newAset = $aset->replicate();
                $newAset->setTable('aset_ikrs');
                $newAset->save();

                $aset->delete();
            });


        return view('dataAset.asetIndex', ['title' => "Data Aset"]);


        // dd($dataimport->nama_barang);
        // \DB::statement('INSERT INTO Aset_ikrs (nama_barang, merk_barang,spesifikasi,kode_aset,kode_ga,kondisi,satuan,jumlah,kategori,tgl_pengadaan,foto_barang,nopol,pajak_1tahun,pajak_5tahun) select nama_barang, merk_barang,spesifikasi,kode_aset,kode_ga,kondisi,satuan,jumlah,kategori,tgl_pengadaan,foto_barang,nopol,pajak_1tahun,pajak_5tahun from aset_import_temps where aset_import_temps','=',$request->akses);

    }
}
