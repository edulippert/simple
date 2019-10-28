<?php

namespace App\Http\Controllers;

use App\MaintenanceProgram;
use Illuminate\Http\Request;

class MaintenanceProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function show(MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function edit(MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MaintenanceProgram  $maintenanceProgram
     * @return \Illuminate\Http\Response
     */
    public function destroy(MaintenanceProgram $maintenanceProgram)
    {
        //
    }

    public function getMaintenancePrograms(Request $request){
       return MaintenanceProgram::getMaintenancesPrograms($request->condominium_id);
       
    }

    public function getMaintenanceProgramsMonthGrouped(Request $request)
    {
        return MaintenanceProgram::buildMaintenanceResponse($request->condominium_id);
    }
}
