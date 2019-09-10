<?php

namespace App\Http\Controllers;

use App\Guarantee;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Guarantee::all();
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
             'name' => 'required',
             'description' => 'required'
         ]);
            
         Guarantee::create($attributes);   

        return  response()->json(['message' => 'Garantia cadastrada com sucesso!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function show(Guarantee $guarantee)
    {
        return $guarantee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guarantee $guarantee)
    {
        $attributes = request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        
        $guarantee->update($attributes);

        return response()->json(['message' => 'Garantia alterada com sucesso!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guarantee $guarantee)
    {
        $guarantee->delete();
    }
}
