<?php

namespace App\Http\Controllers;

use App\RootGuarantee;
use Illuminate\Http\Request;
use App\RootGuaranteeMaintenance;

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
    public function show($id)
    {
        
        return  RootGuaranteeMaintenance::showRootGuaranteeMaintenance($id);
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
    public function update(Request $request, RootGuaranteeMaintenance $rootguaranteemaintenance)
    {
        
        $root_guarantee_maintenance = $rootguaranteemaintenance->fill($request->all());
        $root_guarantee_maintenance->save();
        return $root_guarantee_maintenance;

        
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
        $root_guarantee = RootGuarantee::find($request->root_guarantee_id);
        $guarantee = $root_guarantee->guarantees;
        $root_guarantee_group = $root_guarantee->groups;
        $root_guarantee_item = $root_guarantee->item;
        

        $guarantee_maintenances = RootGuaranteeMaintenance::buildRootGuaranteeMaintenancesResponse($request->root_guarantee_id);

        return [
                'root_guarantee_id' => $root_guarantee->id,
                'guarantee_description' => $guarantee->description,
                'root_guarantee_group_description' => $root_guarantee_group->description,
                'root_guarantee_item_description' => $root_guarantee_item->description,
                'guarantee_maintenances' =>  $guarantee_maintenances
                ];
    }
}
