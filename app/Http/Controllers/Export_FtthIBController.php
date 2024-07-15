<?php

namespace App\Http\Controllers;

use App\Exports\ExportData;
use App\Exports\FtthIbSortirExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Export_FtthIBController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function export(Request $request)
    {
        // dd($request->all());

        switch ($request->data){
            case 'sortir':
                switch ($request->type_wo){
                    
                    case 'FTTH IB':

                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth IB Sortir '.$request->monthYear.'.xlsx');
                        break;
                
                    case 'FTTH MT':

                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth MT Sortir '.$request->monthYear.'.xlsx');
                        break;

                    case 'FTTH Dismantle':

                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth Dismantle Sortir '.$request->monthYear.'.xlsx');
                        break;

                    case 'FTTX IB':

                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Fttx IB Sortir '.$request->monthYear.'.xlsx');
                        break;
                    
                    case 'FTTX MT':

                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Fttx MT Sortir '.$request->monthYear.'.xlsx');
                        break;

                }

                break;

            case 'ori':
                switch ($request->type_wo){
                        
                    case 'FTTH IB':
    
                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth IB Ori '.$request->monthYear.'.xlsx');
                        break;
                    
                    case 'FTTH MT':
    
                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth MT Ori '.$request->monthYear.'.xlsx');
                        break;
    
                    case 'FTTH Dismantle':
    
                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Ftth Dismantle Ori '.$request->monthYear.'.xlsx');
                        break;
    
                    case 'FTTX IB':
    
                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Fttx IB Ori '.$request->monthYear.'.xlsx');
                        break;
                        
                    case 'FTTX MT':
    
                        return Excel::download(new ExportData($request->data,$request->type_wo,$request->month,$request->year) , 'Export Data Fttx MT Ori '.$request->monthYear.'.xlsx');
                        break;
    
                    }
    
                    break;
        }
    }


    public function index()
    {
        //
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
