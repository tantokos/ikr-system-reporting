<?php

namespace App\Http\Controllers;

use App\Models\AsetIkr;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CallsignLead;
use App\Models\Employee;
use App\Models\kategoriAset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AsetIkrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $kategori = kategoriAset::select('kategori')->orderBy('kategori')->get();
        return view('dataAset.asetIndex', ['title' => "Data Aset", 'kategori' => $kategori]);
    }

    public function datamasterAset(Request $request)
    {
        if ($request->ajax()) {
            $datas = AsetIkr::orderBy('nama_barang')->get();
            return DataTables::of($datas)
                ->addIndexColumn() //memberikan penomoran
           
                ->addColumn('fotoAset', function ($row) {
                    $url = asset("storage/image-brg/$row->foto_barang");
                    return '<img src="' . $url . '" align="center" style="width: 40px;height:40px;" />';
                })
                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);
                    // <a href="aset/'.$row->id.'/edit" value="'.$row->id.'" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#md-edit-barang" > <i class="fas fa-edit"></i> Edit</a>
                    $btn ='<a href="/aset/'.$row->id.'/edit" class="btn btn-sm btn-primary edit-barang" > <i class="fas fa-edit"></i> Edit</a>
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        if ($request->kode_aset != '-') {
            $request->validate([
                'kode_aset' => 'unique:aset_ikrs,kode_aset',
            ]);
        }

        if ($request->kode_ga != '-') {
            $request->validate([
                'kode_ga' => 'unique:aset_ikrs,kode_ga',
            ]);
        }


        $request->validate([
            'kategori' => 'required',
            'nama_barang' => 'required',
            'merk_barang' => 'required',
            'kondisi' => 'required',
            'satuan' => 'required',
            'jml' => 'required',
        ]);


        $login = Auth::user()->name;


        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang')->getClientOriginalName();
            $request->file('foto_barang')->move(public_path('storage/image-brg'), $file);
        } else {
            $file = 'foto-blank.jpg';
        }

        AsetIkr::create([
            'nama_barang' => $request['nama_barang'],
            'merk_barang' => $request['merk_barang'],
            'spesifikasi' => $request['spesifikasi'],
            'kode_aset' => $request['kode_aset'],
            'kode_ga' => $request['kode_ga'],
            'kondisi' => $request['kondisi'],
            'satuan' => $request['satuan'],
            'jumlah' => $request['jml'],
            'kategori' => $request['kategori'],
            'tgl_pengadaan' => $request['tgl_input'],
            'foto_barang' => $file,
            'login' => $login,

        ]);

        return to_route('aset.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(AsetIkr $asetIkr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id, AsetIkr $asetIkr)
    {
        $editAset = AsetIkr::find($id);
        $kategori = kategoriAset::select('kategori')->orderBy('kategori')->get();

        // dd($editAset);
        
        // return response()->json($editbr); 
        return view('dataAset.asetEdit',['title' => "Edit Data Aset", 'kategori' => $kategori, 'editAset' => $editAset]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AsetIkr $asetIkr, $id)
    {
        // dd($asetIkr->foto_barang);
        if ($request->kode_asetEdit != '-') {
            $request->validate([
                'kode_asetEdit' => 'unique:aset_ikrs,kode_aset,'.$id,
            ]);
        }

        if ($request->kode_gaEdit != '-') {
            $request->validate([
                'kode_gaEdit' => 'unique:aset_ikrs,kode_ga,'.$id,
            ]);
        }


        $request->validate([
            'kategoriEdit' => 'required',
            'nama_barangEdit' => 'required',
            'merk_barangEdit' => 'required',
            'kondisiEdit' => 'required',
            'satuanEdit' => 'required',
            'jmlEdit' => 'required',
        ]);

        $login = Auth::user()->name;

        if ($request->hasFile('foto_barangEdit')) {
            $fileupdate = $request->file('foto_barangEdit')->getClientOriginalName();
            $request->file('foto_barangEdit')->move(public_path('storage/image-brg'), $fileupdate);

            if ($asetIkr->foto_barang) {
                unlink(public_path('storage/image-brg/'.$asetIkr->foto_barang));
            }
        
        } else {
            $fileupdate = $asetIkr->foto_barang;

        }

            // dd($asetIkr->foto_barang);
        
            $asetIkr->nama_barang = $request->nama_barangEdit;
            $asetIkr->merk_barang = $request->merk_barangEdit;
            $asetIkr->spesifikasi = $request->spesifikasiEdit;
            $asetIkr->kode_aset = $request->kode_asetEdit;
            $asetIkr->kode_ga = $request->kode_gaEdit;
            $asetIkr->kondisi = $request->kondisiEdit;
            $asetIkr->satuan = $request->satuanEdit;
            $asetIkr->jumlah = $request->jmlEdit;
            $asetIkr->kategori = $request->kategoriEdit;
            $asetIkr->tgl_pengadaan = $request->tgl_inputEdit;
            $asetIkr->foto_barang = $fileupdate;
            $asetIkr->login = $login;
            $asetIkr->save();

            return to_route('aset.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AsetIkr $asetIkr)
    {
        //
    }
}
