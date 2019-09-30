<?php

namespace App\Http\Controllers;

use App\Http\Requests\RootMaintenanceRequest;
use App\RootMaintenance;
use Illuminate\Http\Request;

class RootMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RootMaintenance::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RootMaintenanceRequest $request)
    {
        
        $root_maintenance = RootMaintenance::create($request->all());
        return $root_maintenance;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RootMaintenance  $rootMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(RootMaintenance $rootMaintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RootMaintenance  $rootMaintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(RootMaintenance $rootMaintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RootMaintenance  $rootMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(RootMaintenanceRequest $request, RootMaintenance $rootmaintenance)
    {
        
        $rootmaintenance->fill($request->all());
        $rootmaintenance->save();
        return $rootmaintenance;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RootMaintenance  $rootMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(RootMaintenance $rootmaintenance)
    {
        $rootmaintenance->delete();

        return response()->json([],204);
    }
}
