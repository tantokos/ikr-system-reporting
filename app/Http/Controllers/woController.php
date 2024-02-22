<?php

namespace App\Http\Controllers;

use App\Models\Batchwo;
use App\Http\Controllers\Controller;
use App\Models\Fat;
use App\Models\importexcel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class woController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        
        $batch = Batchwo::paginate(20);

        return view('batchWO.batchWOIndex',['batchwo' => $batch]);

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
    public function show(Batchwo $batchwo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batchwo $batchwo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batchwo $batchwo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Batchwo $batchwo)
    {
        //
    }
}
