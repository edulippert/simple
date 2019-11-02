<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\RootMaintenanceRequest;
use App\Item;
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
    public function show(RootMaintenance $rootmaintenance)
    {
        return $rootmaintenance;
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

    public function getRootMaintenances(Request $request)
    {
        //dd($request->maintenance_id);
        $root_maintenances_groups = RootMaintenance::buildRootMaintenancesResponse($request->maintenance_id);
        
        return $root_maintenances_groups;
    }

    public function getGroupsRootMaintenance(Request $request)
    {
        $root_maintenances = RootMaintenance::where('maintenance_id',$request->maintenance_id)
                                            ->join('groups','groups.id','root_maintenances.group_id')
                                            ->select('root_maintenances.id',
                                                    'groups.id as group_id',
                                                    'groups.description as group_description'
                                                    )
                                            ->get();

        $groups = Group::getDistinctGroups($root_maintenances);

        return $groups; 
    }

    public function getItemsRootMaintenance(Request $request)
    {
        $root_maintenances = RootMaintenance::where('maintenance_id',$request->maintenance_id)
                                            ->where('root_maintenances.group_id',$request->group_id)
                                            ->join('items','items.id','root_maintenances.item_id')
                                            ->select('root_maintenances.id',
                                                    'items.id as items_id',
                                                    'items.description as items_description'
                                                    )
                                            ->get();
        
        $items = Item::getDistinctItems($root_maintenances);

        return $items;
    }

    public function getValuesRootMaintenance(Request $request)
    {
        $root_maintenance_values = RootMaintenance::where('maintenance_id',$request->maintenance_id)
                                            ->where('root_maintenances.group_id',$request->group_id)
                                            ->where('root_maintenances.item_id',$request->item_id)
                                            ->select(
                                                'root_maintenances.id as root_maintenance_id',
                                                'activity',
                                                'description',
                                                'amount',
                                                'period',
                                                'responsable',
                                                'font'  
                                            )
                                            ->get();
        return $root_maintenance_values;

    }
}
