<?php

namespace App\Http\Controllers;

use App\CustomerGuaranteeMaintenance;
use Illuminate\Http\Request;

class CustomerGuaranteeMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\CustomerGuaranteeMaintenance  $customerGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerGuaranteeMaintenance $customerGuaranteeMaintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerGuaranteeMaintenance  $customerGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerGuaranteeMaintenance $customerGuaranteeMaintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerGuaranteeMaintenance  $customerGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerGuaranteeMaintenance $customerGuaranteeMaintenance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerGuaranteeMaintenance  $customerGuaranteeMaintenance
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerGuaranteeMaintenance $customerguaranteemaintenance)
    {
        $customerguaranteemaintenance->delete();

        return response()->json([],204);
    }

}
