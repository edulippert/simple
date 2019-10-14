<?php

namespace App\Http\Controllers;

use App\FinishItem;
use App\Http\Requests\FinishItemRequest;
use Illuminate\Http\Request;

class FinishItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FinishItem::all();
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
    public function store(FinishItemRequest $request)
    {
        $finish_item = FinishItem::create($request->all());
        return $finish_item;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FinishItem  $finishItem
     * @return \Illuminate\Http\Response
     */
    public function show(FinishItem $finishitem)
    {
        return $finishitem;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FinishItem  $finishItem
     * @return \Illuminate\Http\Response
     */
    public function edit(FinishItem $finishItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FinishItem  $finishItem
     * @return \Illuminate\Http\Response
     */
    public function update(FinishItemRequest $request, FinishItem $finishitem)
    {
        $finishitem->fill($request->all());
        $finishitem->save();
        return $finishitem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FinishItem  $finishItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinishItem $finishitem)
    {
        $finishitem->delete();
        return response()->json([],204);

    }
}
