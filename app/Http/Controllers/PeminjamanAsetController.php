<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanAset;
use App\Http\Controllers\Controller;
use App\Models\AsetIkr;
use App\Models\Employee;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class PeminjamanAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawanOpt = Employee::leftjoin('branches', 'branches.id', '=', 'employees.branch_id')->where('employees.status_active', '=', 'Aktif')->select('employees.*', 'branches.nama_branch')->get();

        $asetOpt = AsetIkr::select('nama_barang')->where('jumlah', '>', 0)->distinct()->orderBy('nama_barang')->get();

        return view('PeminjamanAset.peminjamanIndex', ['title' => 'Distribusi Aset', 'karyawanOpt' => $karyawanOpt, 'asetOpt' => $asetOpt]);
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
    public function simpanPinjam(Request $request)
    {
        $pBarang = $request->all();
        dd($request);

        // return response()->json($pBarang);
    }

    public function generateInvoice()
    {
        $nopinjam = PeminjamanAset::orderBy('created_at', 'DESC');
        if ($nopinjam->count() > 0) {
            $nopinjam = $nopinjam->first();
            $explode = explode('-', $nopinjam->no_pinjam);
            $count = $explode[1] + 1;
            return 'PNJ-' . $count;
        }
        return 'PNJ-1';
    }

    public function getKodeAset(Request $request)
    {
        // get data aset, ketika pilih nama barang
        $dilist = [];

        if (is_null($request->idAset)) {
            // dd($request->idAset[0]['id_Aset']);
            $kAset = AsetIkr::select('id', 'kode_aset', 'kode_ga', 'merk_barang', 'spesifikasi', 'jumlah', 'satuan', 'kondisi')->where('jumlah', '>', '0')
                ->where('nama_barang', '=', $request->nama_barang)
                ->where('kondisi','=','Baik')
                ->distinct()->orderBy('kode_aset')->get();

        } elseif (count($request->idAset) > 0) {
            // dd($request->idAset[0]['id_Aset']);

            foreach (($request->idAset) as $list) {

                array_push($dilist, $list['id_Aset']);
                // array_push($dilist, $request->idAset[1]['id_Aset']);
                // dd(array_push($dilist,$request->idAset[$x]['id_Aset']));
            }

            // dd($dilist);

            $kAset = AsetIkr::select('id', 'kode_aset', 'kode_ga', 'merk_barang', 'spesifikasi', 'jumlah', 'satuan', 'kondisi')->where('jumlah', '>', '0')
                ->where('nama_barang', '=', $request->nama_barang)->where('kondisi','=','Baik')
                ->whereNotIn('id', $dilist)->distinct()->orderBy('kode_aset')->get();

            // dd($kAset);

        }

        return response()->json($kAset);
    }

    public function getKodeGa(Request $request)
    {
        // get data GA, ketika pilih kode aset

        $kGa = AsetIkr::select('id', 'kode_ga', 'merk_barang', 'spesifikasi', 'jumlah', 'satuan', 'kondisi')->where('jumlah', '>', '0')
            ->where('id', '=', $request->kode_aset)
            ->where('kondisi','=','Baik')
            ->distinct()->orderBy('kode_ga')->get();

        return response()->json($kGa);
    }

    public function getKodeList(Request $request)
    {
        // get data aset, ketika klik tambah list

        $kList = AsetIkr::select('id', 'nama_barang', 'kode_aset', 'kode_ga', 'merk_barang', 'spesifikasi', 'jumlah', 'satuan', 'kondisi', 'kategori')
            // ->where('jumlah','>', '0')
            ->where('id', '=', $request->idAset)->distinct()->orderBy('kode_ga')->get();

        return response()->json($kList);
    }

    /**
     * Display the specified resource.
     */
    public function show(PeminjamanAset $peminjamanAset)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PeminjamanAset $peminjamanAset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PeminjamanAset $peminjamanAset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PeminjamanAset $peminjamanAset)
    {
        //
    }
}
