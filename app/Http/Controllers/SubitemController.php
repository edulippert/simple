<?php

namespace App\Http\Controllers;

use App\Subitem;
use Illuminate\Http\Request;

class SubitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subitem::all();
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
            'item_id' => 'required',
            'description' => 'required'
        ]);

        $subitem = Subitem::create($attributes);

        return $subitem;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function show(Subitem $subitem)
    {
        return $subitem;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subitem $subitem)
    {
        $attributes = request()->validate([
            'item_id' => 'required',
            'description' => 'required'
        ]);

        $subitem->update($attributes);

        return $subitem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subitem  $subitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subitem $subitem)
    {
        $subitem->delete();
    }
}
