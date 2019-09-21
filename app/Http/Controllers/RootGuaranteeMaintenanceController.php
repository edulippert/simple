<?php

namespace App\Http\Controllers;

use App\RootGuaranteeMaintenance;
use Illuminate\Http\Request;

class RootGuaranteeMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RootGuaranteeMaintenance::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $guarantee_maintenances = RootGuaranteeMaintenance::create($request->all());

        return $guarantee_maintenances;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RootGuaranteeMaintenance  $rootGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(RootGuaranteeMaintenance $rootGuaranteeMaintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RootGuaranteeMaintenance  $rootGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(RootGuaranteeMaintenance $rootGuaranteeMaintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RootGuaranteeMaintenance  $rootGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RootGuaranteeMaintenance $rootGuaranteeMaintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RootGuaranteeMaintenance  $rootGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(RootGuaranteeMaintennce $rootGuaranteeMaintenance)
    {
        //
    }

    public function getRootGuaranteeMaintenances(Request $request)
    {
        $guarantee_maintenances = RootGuaranteeMaintenance::buildRootGuaranteeMaintenancesResponse($request->root_guarantee_id);

        return $guarantee_maintenances;
    }
}
