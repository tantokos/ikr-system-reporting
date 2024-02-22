<?php

namespace App\Http\Controllers;

use App\Models\PengembalianAset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengembalianAsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pengembalianAset.pengembalianIndex',['title' => 'Pengembalian Aset']);
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
    public function show(PengembalianAset $pengembalianAset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengembalianAset $pengembalianAset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengembalianAset $pengembalianAset)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengembalianAset $pengembalianAset)
    {
        //
    }
}
