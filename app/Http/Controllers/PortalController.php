<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccessMenu;
use App\Models\AccessPortal;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emp = Employee::where('email', '=' , Auth::user()->email)->first();
        
        // dd(Auth::user()->akses);
        $portal = AccessMenu::join('access_portals', 'access_portals.id','=','access_menus.portal_id')
            ->where('access_menus.user_id', '=', Auth::user()->id)
            ->select('access_portals.portal_menu', 'access_portals.portal_link')
            ->get();
        // dd($portal[0]->portal_link);
        return view('portal.portalIndex',['emp' => $emp, 'portal' => $portal]);
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
