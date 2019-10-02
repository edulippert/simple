<?php

namespace App\Http\Controllers;

use App\Condominium;
use App\Http\Resources\CondominiumResource;
use Egulias\EmailValidator\Exception\CRLFAtTheEnd;
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
        $condominiums = Condominium::with('companies')->orderBy('name')->get();
        return CondominiumResource::collection($condominiums);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request->name);
        $attributes = request()->validate([
           // 'company_id' => 'required',
            'name' => 'required',
            'id_number' => 'required',
            'address' => 'required',
            'complement' => 'required',
            'zipcode' => 'required',
            'licence_due_date' => 'required',
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
           // 'company_id' => 'required',
            'name' => 'required',
            'id_number' => 'required',
            'address' => 'required',
            'complement' => 'required',
            'zipcode' => 'required',
            'licence_due_date' => 'required',
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
        return response()->json([],204);
    }

    public function getComdominiums(Request $request)
    {
        if ($request->company_id===-1) {
            $response = Condominium::where('company_id',null)->get();
        }else {
            $response = Condominium::where('company_id',$request->company_id)->get();
        }

        return $response;
    }
}
