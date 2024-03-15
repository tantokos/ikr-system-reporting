<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Charts\MonthlyWoChart;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MonthlyWoChart $chart)
    {
        // $chart = (new LarapexChart)->pieChart()
        // ->setTitle('Total Users Monthly')
        // ->setSubtitle('From January to March')
        // ->setXAxis(['Jan', 'Feb', 'Mar'])
        // ->setDataset([
        //     [
        //         'name'  =>  'Active Users',
        //         'data'  =>  [250, 700, 1200]
        //     ]
        // ]);

        return view('report.reporting',['chart' => $chart->build()]);
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
