<?php

namespace App\Http\Controllers;

use App\Models\importexcel;
use App\Http\Controllers\Controller;
use App\Imports\ImportBatch;
use App\Imports\ImportWO;
use App\Models\Batchwo;
use App\Models\MonitMtFtth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

use function Psy\Test\Command\ListCommand\Fixtures\bar;

class ImportexcelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request);
        $users = importexcel::all();

        if ($request->ajax()) {
            // dd($request);
            // $datas = CallsignTim::all();
            return DataTables::of($users)
                ->addIndexColumn() //memberikan penomoran

                // ->editColumn('gender', function($row){ //mengedit column pada yajra datatable 
                //     if($row->gender == 'L'){
                //         return 'Laki-laki';
                //     }else{
                //         return 'Perempuan';
                //     }    
                // })

                ->addColumn('action', function ($row) {
                    //  $enc_id = \Crypt::encrypt($row->id);

                    $btn = '<a href="/callsignTimEdit/' . $row->id . '" class="btn btn-sm btn-primary" > <i class="fas fa-edit"></i> Edit</a>
                             <a href="#" class="btn btn-sm btn-secondary disable"> <i class="fas fa-trash"></i> Hapus</a>';
                    return $btn;
                })
                // ->rawColumns(['action'])   //merender content column dalam bentuk html
                ->escapeColumns()  //mencegah XSS Attack
                ->toJson(); //merubah response dalam bentuk Json
            // ->make(true);
        }

        return view('importOrder.importOrderIndex', compact('users'), ['title' => 'Import Data Order WO']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function import(Request $request)
    {
        // dd($request);
        if ($request->hasFile('file')) {

            $request->validate([
                'file' => ['required', 'mimes:xlsx,xls,csv']

            ]);

            Excel::import(new ImportWO($request->batch_wo, $request->jenis_wo, $request->tgl_ikr, $request->import_by), request()->file('file'));
            // $dataimport = Excel::toCollection(new ImportBatch(), request()->file('file'));
            // Excel::import(new ImportWO($request->batch_wo, $request->jenis_wo, $request->tgl_ikr, $request->import_by), request()->file('file'));


            $batch = importexcel::all();

            // dd(substr($batch[1]->fat_code,4,3));

            for ($i = 0; $i < count($batch); $i++) {
                // echo $batch[$i]->wo_no;

                Batchwo::create([

                'batch_wo' => $batch[$i]->batch_wo,
                'tgl_ikr' => $batch[$i]->tgl_ikr,
                'import_by' => $batch[$i]->import_by,
                'jenis_wo' => $batch[$i]->jenis_wo,
                'wo_no' => $batch[$i]->wo_no,
                'ticket_no' => $batch[$i]->ticket_no,
                'wo_date' => $batch[$i]->wo_date,
                'cust_id' => $batch[$i]->cust_id,
                'name' => $batch[$i]->name,
                'cust_phone' => $batch[$i]->cust_phone,
                'cust_mobile' => $batch[$i]->cust_mobile,
                'address' => $batch[$i]->address,
                'area' => $batch[$i]->area,
                'wo_type' => $batch[$i]->wo_type,
                'fat_code' => ltrim(trim($batch[$i]->fat_code)),
                'kode_area_fat' => substr($batch[$i]->fat_code,0,3),

                'kode_cluster_fat' => substr($batch[$i]->fat_code,4,3),
                'fat_port' => $batch[$i]->fat_port,
                'remarks' => $batch[$i]->remarks,
                'vendor_installer' => $batch[$i]->vendor_installer,
                'ikr_date' => $batch[$i]->ikr_date,
                'time' => $batch[$i]->time                
                ]);

                MonitMtFtth::create([

                    'batch_wo' => $batch[$i]->batch_wo,
                    'tgl_ikr' => $batch[$i]->tgl_ikr,
                    'import_by' => $batch[$i]->import_by,
                    'jenis_wo' => $batch[$i]->jenis_wo,
                    'wo_no' => $batch[$i]->wo_no,
                    'ticket_no' => $batch[$i]->ticket_no,
                    'wo_date' => $batch[$i]->wo_date,
                    'cust_id' => $batch[$i]->cust_id,
                    'name' => $batch[$i]->name,
                    'cust_phone' => $batch[$i]->cust_phone,
                    'cust_mobile' => $batch[$i]->cust_mobile,
                    'address' => $batch[$i]->address,
                    'area' => $batch[$i]->area,
                    'wo_type' => $batch[$i]->wo_type,
                    'fat_code' => ltrim(trim($batch[$i]->fat_code)),
                    'kode_area_fat' => substr($batch[$i]->fat_code,0,3),
    
                    'kode_cluster_fat' => substr($batch[$i]->fat_code,4,3),
                    'fat_port' => $batch[$i]->fat_port,
                    'remarks' => $batch[$i]->remarks,
                    'vendor_installer' => $batch[$i]->vendor_installer,
                    'ikr_date' => $batch[$i]->ikr_date,
                    'time' => $batch[$i]->time                
                    ]);

                

                
            }

            
            // dd($batchwo);
        }

        return back();
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
    public function show(Request $request)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(importexcel $importexcel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, importexcel $importexcel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(importexcel $importexcel)
    {
        //
    }
}
