<?php

namespace App\Http\Controllers;

use App\Http\Requests\RootGuaranteeRequest;
use App\RootGuarantee;
use Illuminate\Http\Request;

class RootGuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return RootGuarantee::all();
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
    public function store(RootGuaranteeRequest $request)
    {
        $rootGuarantee = RootGuarantee::create($request->all());

        return $rootGuarantee;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RootGuarantee  $rootGuarantee
     * @return \Illuminate\Http\Response
     */
    public function show(RootGuarantee $rootguarantee)
    {
        return $rootguarantee;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RootGuarantee  $rootGuarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(RootGuarantee $rootGuarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RootGuarantee  $rootGuarantee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RootGuarantee $rootGuarantee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RootGuarantee  $rootGuarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(RootGuarantee $rootGuarantee)
    {
        //
    }

    public function getRootGuarantees(Request $request)
    {

        $guarantee_maintenances_groups = RootGuarantee::buildRootGuaranteesResponse($request->guarantee_id);
        
        return $guarantee_maintenances_groups;
    }
}
