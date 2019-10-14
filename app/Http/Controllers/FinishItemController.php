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

    public function getFinishItems(Request $request)
    {

        if ($request->group_id) {
          
            $finish_items = FinishItem::where('finish_groups.company_id',$request->company_id)
                                    ->where('finish_groups.id',$request->group_id)
                                    ->join('finish_groups','finish_groups.id','finish_items.group_id')
                                    ->select(
                                        'finish_items.id',
                                        'finish_items.name',
                                        'finish_items.description',
                                        'finish_groups.id as group_id',
                                        'finish_groups.name as group_name'
                                    
                                    )->get();

        }else{
            $finish_items = FinishItem::where('finish_groups.company_id',$request->company_id)
                                        ->join('finish_groups','finish_groups.id','finish_items.group_id')
                                        ->select(
                                            'finish_items.id',
                                            'finish_items.name',
                                            'finish_items.description',
                                            'finish_groups.id as group_id',
                                            'finish_groups.name as group_name'
                                        
                                        )->get();
        }
        return $finish_items;
    }
}
