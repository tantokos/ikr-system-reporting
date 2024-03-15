<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportFtthMT;
use Yajra\DataTables\DataTables;
use App\Models\ImportFtthMtTemp;

class ImportFtthMtTempController extends Controller
{
    public function index()
    {

        $akses = Auth::user()->name;
        $jmlData = ImportFtthMtTemp::where('login', '=', $akses)->count('no_wo');
        $done = ImportFtthMtTemp::where('status_wo', '=', 'Done')->count('status_wo');
        $pending = ImportFtthMtTemp::where('status_wo', '=', 'Pending')->count('status_wo');
        $cancel = ImportFtthMtTemp::where('status_wo', '=', 'Cancel')->count('status_wo');
        $sitePenagihan = ImportFtthMtTemp::select('site_penagihan')->distinct()->get();
        $penagihan = ImportFtthMtTemp::select('penagihan')->distinct()->get();
        $branch = ImportFtthMtTemp::select('branch')->distinct()->get();
        $kotamadyaPenagihan = ImportFtthMtTemp::select('kotamadya_penagihan')->distinct()->get();

        // dd($sitePenagihan);

        return view('importWo.FtthMtTempIndex', [
            'title' => 'Import Data FTTH MT', 'akses' => $akses, 'jmlImport' => $jmlData,
            'done' => $done, 'pending' => $pending, 'cancel' => $cancel, 'sitePenagihan' => $sitePenagihan, 'penagihan' => $penagihan,
            'branch' => $branch, 'kotamadyaPenagihan' => $kotamadyaPenagihan
        ]);
    }


    public function importFtthMtTemp(Request $request)
    {

        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '2048M');

        if ($request->hasFile('fileFtthMT')) {

            $request->validate([
                'fileFtthMT' => ['required', 'mimes:xlsx,xls,csv']
            ]);

            $akses = Auth::user()->name;

            Excel::import(new ImportFtthMT($akses), request()->file('fileFtthMT'));

            return back();
        }
    }

    public function dataImportFtthTemp(Request $request)
    {
        $akses = Auth::user()->name;
        if ($request->ajax()) {
            $datas = ImportFtthMtTemp::where('login','=',$akses)->get();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }
}
