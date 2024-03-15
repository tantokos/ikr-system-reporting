<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AsetIkr;
use App\Models\kategoriAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use LengthException;
use Yajra\DataTables\DataTables;

class AsetDashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $portal_menu = "inventory Assets";
        $totAset = AsetIkr::all()->sum('jumlah');
        $totAsetDt = AsetIkr::all();
        $tersedia = AsetIkr::where('jumlah', '>=', '1')->where('kondisi', '=', 'Baik')->sum('jumlah');
        $distribusi = AsetIkr::where('jumlah', '=', '0')->sum('jumlah');
        $rusak = AsetIkr::where('kondisi', '=', 'Rusak')->sum('jumlah');
        $hilang = AsetIkr::where('kondisi', '=', 'Hilang')->sum('jumlah');
        $disposal = AsetIkr::where('kondisi', '=', 'disposal')->sum('jumlah');

        // Graph All Kategori
        $totAsetKategori = DB::table('kategori_asets')->leftJoin('aset_ikrs', 'aset_ikrs.kategori', '=', 'kategori_asets.kategori')
            ->select(DB::raw('kategori_asets.kategori, sum(aset_ikrs.jumlah) as jumlah '))
            ->groupBy('kategori_asets.kategori')->orderBy('kategori_asets.kategori')->get()->toJson();

        $toolsName = AsetIkr::select('kategori','nama_barang')->distinct()->orderBy('kategori')->orderBy('nama_barang')->get();
        $statusTools = [];

        for ($x=0 ; $x < count($toolsName); $x++){

            $toolTersedia = AsetIkr::where('nama_barang', '=', $toolsName[$x]->nama_barang)->where('jumlah', '>=', '1')->where('kondisi', '=', 'Baik')->sum('jumlah');
            $toolTerdistribusi = AsetIkr::where('nama_barang', '=', $toolsName[$x]->nama_barang)->where('jumlah', '=', '0')->where('kondisi', '=', 'Baik')->sum('jumlah');
            $toolRusak = AsetIkr::where('nama_barang', '=', $toolsName[$x]->nama_barang)->where('kondisi', '=', 'Rusak')->sum('jumlah');
            $toolHilang = AsetIkr::where('nama_barang', '=', $toolsName[$x]->nama_barang)->where('kondisi', '=', 'Hilang')->sum('jumlah');
            
            // dd($toolTersedia);

            // for ($i=0; $i < count($label); $i++){
                $statusTools[$x][$toolsName[$x]->nama_barang][] = ['kategori' => 'Tersedia', 'jumlah' => $toolTersedia, 'kategoriName' => $toolsName[$x]->kategori];
                $statusTools[$x][$toolsName[$x]->nama_barang][] = ['kategori' => 'Terdistribusi', 'jumlah' => $toolTerdistribusi, 'kategoriName' => $toolsName[$x]->kategori];
                $statusTools[$x][$toolsName[$x]->nama_barang][] = ['kategori' => 'Rusak', 'jumlah' => $toolRusak, 'kategoriName' => $toolsName[$x]->kategori];
                $statusTools[$x][$toolsName[$x]->nama_barang][] = ['kategori' => 'Hilang', 'jumlah' => $toolHilang, 'kategoriName' => $toolsName[$x]->kategori];
                
            // }
            
        }


        return view('dashboard.AsetDashView', [
            'totAset' => $totAset, 'tersedia' => $tersedia, 'distribusi' => $distribusi,
            'rusak' => $rusak, 'hilang' => $hilang, 'disposal' => $disposal, 'totAsetKategori' => $totAsetKategori,
            'totAsetTools' => json_encode($statusTools), 'portal_menu' => $portal_menu, 'totAsetDt' => $totAsetDt
        ]);
    }


    public function DataTotAsetDt(Request $request)
    {
        // dd($request);

        $dataTotDt = DB::table('aset_ikrs')->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 
        

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataTotDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function DataTersediaAsetDt(Request $request)
    {
        // dd($request);
        $dataTersediaDt = DB::table('aset_ikrs')->where('jumlah','>=', '1')
            ->where('kondisi','=','Baik')
            ->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataTersediaDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function DataDistribusiAsetDt(Request $request)
    {
        // dd($request);
        $dataDistribusiDt = DB::table('aset_ikrs')->where('jumlah','=', '0')
            ->where('kondisi','=','Baik')
            ->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataDistribusiDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function DataRusakAsetDt(Request $request)
    {
        // dd($request);
        $dataRusakDt = DB::table('aset_ikrs')
            ->where('kondisi','=','Rusak')
            ->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataRusakDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function DataHilangAsetDt(Request $request)
    {
        // dd($request);
        $dataHilangDt = DB::table('aset_ikrs')
            ->where('kondisi','=','Hilang')
            ->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataHilangDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }
    }

    public function DataDisposalAsetDt(Request $request)
    {
        // dd($request);
        $dataDisposalDt = DB::table('aset_ikrs')
            ->where('kondisi','=','Disposal')
            ->select(DB::raw('nama_barang, satuan,sum(jumlah) as jumlah,kategori'))
            ->groupBy('nama_barang','satuan','kategori')->orderBy('nama_barang')->get(); 

            // dd($dataTotDt);
        if ($request->ajax()) {
            $datas = $dataDisposalDt;
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
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
        //
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
