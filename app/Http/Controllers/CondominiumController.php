<?php

namespace App\Http\Controllers;

use App\Condominium;
use Illuminate\Http\Request;

class CondominiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Condominium::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = request()->validate([
            'company_id',
            'file_id',
            'name',
            'id_number',
            'address',
            'complement',
            'zipcode',
            'licence_due_date',
            'is_activ'
        ]);

        $condominium = Condominium::create($attributes);

        return $condominium;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function show(Condominium $condominium)
    {
        return $condominium;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Condominium $condominium)
    {
        $attributes = request()->validate([
            'company_id',
            'file_id',
            'name',
            'id_number',
            'address',
            'complement',
            'zipcode',
            'licence_due_date',
            'is_activ'
        ]);

        $condominium->update($attributes);

        return $condominium;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Condominium  $condominium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Condominium $condominium)
    {
        $condominium->delete();
    }
}
