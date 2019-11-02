<?php

namespace App\Http\Controllers;

use App\CustomerGuarantee;
use App\Http\Requests\CustomerGuaranteeRequest;
use Illuminate\Http\Request;

class CustomerGuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CustomerGuarantee::all();
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
    public function store(CustomerGuaranteeRequest $request)
    {
        
        $customerGuarantee =  CustomerGuarantee::create($request->all());
        return $customerGuarantee;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CustomerGuarantee  $customerGuarantee
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerGuarantee $customerguarantee)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CustomerGuarantee  $customerGuarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerGuarantee $customerGuarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CustomerGuarantee  $customerGuarantee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerGuarantee $customerGuarantee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CustomerGuarantee  $customerGuarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerGuarantee $customerguarantee)
    {
        $customerguarantee->delete();

        return response()->json([],204);
    }

    public function getAllocateds(Request $request)
    {
        
        return CustomerGuarantee::buildGuaranteeMaintenancesAllocatedsResponse($request->condominium_id);

    }
}
